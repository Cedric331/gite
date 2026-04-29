"""
Scraper de gîtes - Pyrénées-Atlantiques (64)
Utilise Playwright pour rendre le JavaScript des pages

Installation :
    pip install playwright pandas openpyxl --break-system-packages
    playwright install chromium
"""

import asyncio
import re
import pandas as pd
from playwright.async_api import async_playwright

OUTPUT_FILE = "gites_64.xlsx"

ZONES = [
    "https://www.gites64.com/pau-paysbearn.html",
    "https://www.gites64.com/laruns-ossau.html",
    "https://www.gites64.com/vallee-aspe.html",
    "https://www.gites64.com/coeurpaysbasque.html",
]

def extract_email(text):
    emails = re.findall(r"[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}", text)
    blacklist = ["example.com", "sentry", "jquery", ".png", ".jpg", ".svg", "schema.org"]
    return [e for e in emails if not any(b in e for b in blacklist)]

def extract_phone(text):
    phones = re.findall(r"(?:(?:\+33|0033|0)\s?[1-9](?:[\s.\-]?\d{2}){4})", text)
    return phones

async def scrape_gites64():
    results = []

    async with async_playwright() as p:
        browser = await p.chromium.launch(headless=True)
        context = await browser.new_context(
            user_agent="Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0"
        )
        page = await context.new_page()

        for zone_url in ZONES:
            print(f"\n📡 Zone : {zone_url}")
            try:
                await page.goto(zone_url, wait_until="networkidle", timeout=30000)
                await asyncio.sleep(2)

                links = await page.eval_on_selector_all(
                    "a[href]",
                    "els => els.map(e => e.href).filter(h => h.includes('/gite') || h.includes('/chambre') || h.includes('-ref-') || h.includes('location-'))"
                )
                links = list(set([l for l in links if "gites64.com" in l]))
                print(f"   → {len(links)} fiches trouvées")

                for i, link in enumerate(links[:30]):
                    try:
                        print(f"   [{i+1}/{min(len(links),30)}] {link[:70]}...")
                        detail_page = await context.new_page()
                        await detail_page.goto(link, wait_until="networkidle", timeout=20000)
                        await asyncio.sleep(1)

                        content = await detail_page.content()
                        text = await detail_page.inner_text("body")

                        name = await detail_page.title()
                        try:
                            h1 = await detail_page.inner_text("h1")
                            if h1:
                                name = h1.strip()
                        except Exception:
                            pass

                        emails = extract_email(text) or extract_email(content)
                        email = emails[0] if emails else ""

                        phones = extract_phone(text)
                        phone = phones[0] if phones else ""

                        location = ""
                        for selector in [".commune", ".ville", ".localisation", ".city", ".location"]:
                            try:
                                loc = await detail_page.inner_text(selector)
                                if loc:
                                    location = loc.strip()
                                    break
                            except Exception:
                                pass

                        results.append({
                            "nom": name[:80],
                            "localisation": location,
                            "email": email,
                            "telephone": phone,
                            "url": link,
                            "zone": zone_url.split("/")[-1].replace(".html", ""),
                        })

                        if email:
                            print(f"      ✅ {email}")
                        elif phone:
                            print(f"      📞 {phone}")
                        else:
                            print(f"      ⚠️  Pas de contact trouvé")

                        await detail_page.close()
                        await asyncio.sleep(1.5)

                    except Exception as e:
                        print(f"      ❌ {str(e)[:60]}")
                        try:
                            await detail_page.close()
                        except Exception:
                            pass
                        continue

            except Exception as e:
                print(f"   ❌ Erreur zone : {e}")
                continue

        await browser.close()

    return results

def export_to_excel(gites):
    if not gites:
        print("❌ Aucun gîte trouvé.")
        return

    df = pd.DataFrame(gites)
    df = df.drop_duplicates(subset=["url"])
    df["_has_email"] = df["email"].apply(lambda x: 0 if x else 1)
    df = df.sort_values("_has_email").drop(columns="_has_email")

    with pd.ExcelWriter(OUTPUT_FILE, engine="openpyxl") as writer:
        df.to_excel(writer, index=False, sheet_name="Gîtes 64")
        ws = writer.sheets["Gîtes 64"]
        for col in ws.columns:
            max_len = max(len(str(cell.value or "")) for cell in col)
            ws.column_dimensions[col[0].column_letter].width = min(max_len + 4, 60)

    total = len(df)
    avec_email = df["email"].astype(bool).sum()
    avec_tel = df["telephone"].astype(bool).sum()

    print(f"\n✅ Fichier exporté : {OUTPUT_FILE}")
    print(f"   → {total} gîtes | {avec_email} emails | {avec_tel} téléphones")
    print(f"\n📋 Aperçu :")
    print(df[["nom", "email", "telephone"]].head(15).to_string(index=False))

if __name__ == "__main__":
    print("🚀 Démarrage (peut prendre 5-10 min)...\n")
    gites = asyncio.run(scrape_gites64())
    print(f"\n📋 Total : {len(gites)} gîtes collectés")
    export_to_excel(gites)
