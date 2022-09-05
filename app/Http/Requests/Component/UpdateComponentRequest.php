<?php

namespace App\Http\Requests\Component;

use Illuminate\Foundation\Http\FormRequest;

class UpdateComponentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => "required|max:255",
            "type" => "required|max:50",
            "new_image" => "nullable|image|mimes:jpeg,jpg,png,svg|max:2048",
            "price" => "required|numeric|min:0|max:100000",
        ];
    }
}
