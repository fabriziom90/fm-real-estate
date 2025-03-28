<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseProposalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'city'          => 'required|max:255',
            'type'          => 'required',
            'sale_type'     => 'required',
            'price_from'    => 'required|numeric',
            'price_to'      => 'required|numeric',
            'mq_from'       => 'required|numeric',
            'mq_to'         => 'required|numeric',
            'number_bathrooms'  => 'required|numeric',
            'number_rooms'  => 'required|numeric',
            'energetic_efficency' => 'required',
            'notes' => ''
            
        ];
    }

    public function messages()
    {
        return [
            'city.required' => 'La città è obbligatoria',
            'city.max'  => 'La città deve essere lunga al massimo :max caratteri',
            'type.required' => 'La tipologia di immobile è obbligatoria',
            'sale_type' => 'La tipologia di vendità è obbligatoria',
            'mq_from.required'   => 'I metri quadri da sono obbligatori',
            'mq_from.numeric'    => 'Il valore in metri quadri deve essere un valore numerico',
            'mq_to.required'   => 'I metri quadri a sono obbligatori',
            'mq_to.numeric'    => 'Il valore in metri quadri deve essere un valore numerico',
            'price_from.required' => 'Il prezzo da è obbligatorio',
            'price_from.numeric' => 'Il prezzo deve essere un valore numerico',
            'price_to.required' => 'Il prezzo a è obbligatorio',
            'price_to.numeric' => 'Il prezzo deve essere un valore numerico',
            'number_bathrooms.required'  => 'Il numero di bagni è obbligatorio',
            'number_bathrooms.numeric'  => 'Il valore inserito deve essere numerico',
            'number_rooms.required' => 'Il numero di stanze è obbligatorio',
            'number_rooms.numeric'  => 'Il valore inserito deve essere numerico',
            'energetic_efficency.required'   => 'L\'efficenza energetica è obbligatoria'
        ];
    }
}
