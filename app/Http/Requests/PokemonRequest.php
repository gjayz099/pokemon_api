<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class PokemonRequest extends FormRequest
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
            'Name' => 'min:3|max:50|unique:pokemon,Name|required',
            'Picture' => 'min:3|max:500|required',
            'types'=>[
                'Type_name' => 'required|min:3|max:500',
            ],
            'abilities'=>[
                'Ability_name' => 'required|min:3|max:500',
            ],
      
            'experiences'=>[
                'Base_experience' => 'required|max:500',
            ],
           
        ];
    }
}
