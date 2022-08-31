<?php

namespace App\Http\Requests\Assembly;

use Illuminate\Foundation\Http\FormRequest;

class CreateAssemblyRequest extends FormRequest
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
            "name" => "required",
            "image" => "required|image|mimes:jpeg,jpg,png,svg|max:2048",
            "price" => "required|numeric|min:0|max:100000",
            "manufacturer_id" => "required|exists:manufacturers,id",
            "components" => "required|array|min:1",
            "components.*.id" => "required|exists:components,id",
            "components.*.location" => "required|distinct"
        ];
    }
}
