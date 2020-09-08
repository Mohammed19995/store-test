<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExecuteOptionRequest extends BaseRequest
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
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (is_null($this->request->get('option_id')) ||$this->request->get('option_id') == -1) {
                $validator->errors()->add('option_id', trans('admin.pleas_select_option'));
            }
            if (is_array($this->request->get('ids')) && count($this->request->get('ids')) <= 0) {
                $validator->errors()->add('option_id', trans('admin.pleas_select_record'));
            }

        });
    }
}
