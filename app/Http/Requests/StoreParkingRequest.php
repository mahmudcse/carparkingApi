<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreParkingRequest extends FormRequest
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
            'zone_id' => ['required'],
            'vehicle_id' =>['required', Rule::exists('vehicles', 'id')->where(function($query){
                return $query->where('user_id', auth()->id());
            }),
            ]
        ];
    }
}
