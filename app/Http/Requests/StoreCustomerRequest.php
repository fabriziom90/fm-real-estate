<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'name' => ['required', 'max:50'],
            'surname' => ['required', 'max:50'],
            'email' => ['required', 'max:120'],
            'phone' => ['required', 'max:20'],
            'address' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Devi inserire il nome',
            'name.max' => 'Il nome deve essere lungo al massimo :max caratteri',
            'surname.required' => 'Devi inserire il cognome',
            'surname.max'   => 'Il cognome deve essere lungo al massimo :max caratteri',
            'email.required' => 'L\'indirizzo email è obbligatorio',
            'email.max' => 'L\'indirizzo email deve essere lungo al massimo :max caratteri',
            'phone.required' => 'Devi inserire il numero di telefono',
            'phone.max' => 'Il numero di telefono deve essere lungo al massimo :max caratteri',
            'address.required' => 'Devi inserire l\'indirizzo',
            'address.max' => 'L\'indirizzo deve essere lungo al massimo :max caratteri'
        ];
    }
}
