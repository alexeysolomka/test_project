<?php

namespace App\Http\Requests;

use App\Station;
use Illuminate\Foundation\Http\FormRequest;

class CreateStationRequest extends FormRequest
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
        return Station::createValidationRules();
    }
}
