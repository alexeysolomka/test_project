<?php

namespace App\Http\Requests;

use App\Metro;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMetroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Metro::$updateRules;
        $rules['location'] .= $this->metro_id;
        return $rules;
    }
}
