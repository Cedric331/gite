<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactMessageRequest;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    // Enregistre un nouveau message de contact et envoie un email de notification
    public function store(ContactMessageRequest $request): JsonResponse
    {
        $message = ContactMessage::create($request->validated());

        // Envoi de la notification (non bloquant en cas d'erreur SMTP)
        try {
            $adminEmail = Setting::get('contact_email', config('mail.from.address'));
            Mail::to($adminEmail)->send(new ContactMessageMail($message));
        } catch (\Throwable $e) {
            report($e); // Journalise sans interrompre la réponse
        }

        return response()->json([
            'message' => 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.',
        ], 201);
    }
}
