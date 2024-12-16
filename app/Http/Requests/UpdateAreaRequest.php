<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAreaRequest extends FormRequest
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
            'area' => ['required', 'max:255'],
        ];
    }

    public function messages(){
        return [
            'area.required' => 'Devi inserire il nome dell\'area',
            'area.max'      => 'Il nome dell\'area deve essere di al massimo :max caratteri'
        ];
    }
}
