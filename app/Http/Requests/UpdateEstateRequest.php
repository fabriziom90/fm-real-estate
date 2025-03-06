<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEstateRequest extends FormRequest
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
            'name'          => 'required|max:255',
            'description'   => 'required',
            'address'       => 'required|max:255',
            'city'          => 'required|max:255',
            'type'          => 'required',
            'sale_type'     => 'required',
            'mq'            => 'required|numeric',
            'price'         => 'required|numeric',
            'number_bathrooms'  => 'required|numeric',
            'number_rooms'  => 'required|numeric',
            'energetic_efficency'   => 'max:10',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Il nome dell\'immobile è obbligatorio',
            'name.max'  => 'Il nome deve essere di al massimo :max caratteri',
            'address.required'  => 'L\'indirizzo è obbligatorio',
            'address.max'   => 'L\'indirizzo deve essere di al massimo :max caratteri',
            'city.required' => 'La città è obbligatoria',
            'city.max'  => 'La città deve essere lunga al massimo :max caratteri',
            'type.required' => 'La tipologia di immobile è obbligatoria',
            'sale_type' => 'La tipologia di vendità è obbligatoria',
            'mq.required'   => 'I metri quadri sono obbligatori',
            'mq.numeric'    => 'Il valore in metri quadri deve essere un valore numerico',
            'price.required' => 'Il prezzo è obbligatorio',
            'price.numeric' => 'Il prezzo deve essere un valore numerico',
            'number_bathrooms.required'  => 'Il numero di bagni è obbligatorio',
            'number_bathrooms.numeric'  => 'Il valore inserito deve essere numerico',
            'number_rooms.required' => 'Il numero di stanze è obbligatorio',
            'number_rooms.numeric'  => 'Il valore inserito deve essere numerico',
            'energetic_effigency.max'   => 'Il valore dell\'efficenza energetica deve essere al massimo di :max caratteri'
        ];
    }
}
