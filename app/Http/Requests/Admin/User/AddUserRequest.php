<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\BaseRequest;
use App\Traits\Rule\RuleTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddUserRequest extends BaseRequest
{
    use RuleTrait;
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
     * @return array
     */
    public function rules()
    {
        $check_phone = $this->checkPhone('users',true , -1 , $this->request->get('phone_code') , $this->request->get('phone'));
        return [
            'name' => ['required', 'max:250'],
            'email' => ['required', 'email', 'max:250', Rule::unique('users', 'email')->whereNull('deleted_at')],
            'phone_code' => ['required', Rule::exists('countries', 'phone_code')],

            'phone' => ['required', 'digits_between:6,13',$check_phone],
            'password' => ['required', 'max:250']
        ];
    }
}
