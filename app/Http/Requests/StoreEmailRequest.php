<?php

namespace App\Http\Requests;

use App\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmailRequest extends FormRequest
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
            'from' => 'required|email',
            'to' => 'required|email',
            'subject' => 'required|max:200',
            'should_fail' => 'sometimes|boolean',
            'text_content' => 'required',
            'html_content' => 'sometimes',
            'attachments' => 'sometimes', //TODO add docx, xlsx, pptx etc
//            'attachments.*' => 'sometimes|file|mimes:pdf,jpeg,gif,png|max:5000' //TODO add docx, xlsx, pptx etc
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'should_fail' => ($this->should_fail == 'on' || $this->should_fail == true) ? true: false,
        ]);
    }

    protected function getValidatorInstance()
    {
        return parent::getValidatorInstance()->after(function ($validator) {
            $this->afterValidation($validator);
        });
    }

    protected function afterValidation($validator)
    {
        $this->html_content = Helper::removeUnwantedTags($validator->valid()['html_content']);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'subject.max' => 'Use some common sense! Your subject cannot be the size of an email :(.',
            'mimes' => 'Only PDF, JPEG, PNG are allowed.'
        ];
    }
}
