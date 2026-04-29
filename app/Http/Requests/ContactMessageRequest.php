<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:20',
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date|after:start_date',
            'guests' => 'nullable|integer|min:1|max:20',
            'message' => 'required|string|min:10|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'name.max' => 'Le nom ne peut pas dépasser 100 caractères.',
            'email.required' => "L'adresse email est obligatoire.",
            'email.email' => "L'adresse email n'est pas valide.",
            'phone.max' => 'Le numéro de téléphone ne peut pas dépasser 20 caractères.',
            'start_date.after_or_equal' => "La date d'arrivée doit être aujourd'hui ou dans le futur.",
            'end_date.after' => "La date de départ doit être après la date d'arrivée.",
            'guests.min' => 'Le nombre de personnes doit être au moins 1.',
            'guests.max' => 'Le nombre de personnes ne peut pas dépasser 20.',
            'message.required' => 'Le message est obligatoire.',
            'message.min' => 'Le message doit contenir au moins 10 caractères.',
            'message.max' => 'Le message ne peut pas dépasser 2000 caractères.',
        ];
    }
}
