<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle demande de contact</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; color: #333; }
        .header { background: #2d6a4f; color: white; padding: 24px; border-radius: 8px 8px 0 0; }
        .content { background: #f9f9f9; padding: 24px; }
        .field { margin-bottom: 16px; }
        .label { font-weight: bold; color: #555; font-size: 12px; text-transform: uppercase; }
        .value { font-size: 16px; margin-top: 4px; }
        .message-box { background: white; border-left: 4px solid #2d6a4f; padding: 16px; margin-top: 16px; }
        .footer { background: #eee; padding: 16px; text-align: center; font-size: 12px; color: #777; border-radius: 0 0 8px 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin:0; font-size: 22px;">Nouvelle demande de contact</h1>
        <p style="margin:8px 0 0 0; opacity:0.8;">Reçue le {{ $contactMessage->created_at->format('d/m/Y à H:i') }}</p>
    </div>

    <div class="content">
        <div class="field">
            <div class="label">Nom</div>
            <div class="value">{{ $contactMessage->name }}</div>
        </div>

        <div class="field">
            <div class="label">Email</div>
            <div class="value"><a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></div>
        </div>

        @if($contactMessage->phone)
        <div class="field">
            <div class="label">Téléphone</div>
            <div class="value">{{ $contactMessage->phone }}</div>
        </div>
        @endif

        @if($contactMessage->start_date)
        <div class="field">
            <div class="label">Dates souhaitées</div>
            <div class="value">
                Du {{ $contactMessage->start_date->format('d/m/Y') }}
                @if($contactMessage->end_date)
                    au {{ $contactMessage->end_date->format('d/m/Y') }}
                @endif
            </div>
        </div>
        @endif

        @if($contactMessage->guests)
        <div class="field">
            <div class="label">Nombre de personnes</div>
            <div class="value">{{ $contactMessage->guests }}</div>
        </div>
        @endif

        <div class="message-box">
            <div class="label">Message</div>
            <p style="margin:8px 0 0 0; white-space: pre-wrap;">{{ $contactMessage->message }}</p>
        </div>
    </div>

    <div class="footer">
        Ce message a été envoyé depuis le formulaire de contact du site Gîtes.
    </div>
</body>
</html>
