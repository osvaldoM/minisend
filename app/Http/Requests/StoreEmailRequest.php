<?php

namespace App\Http\Requests;

use App\Helpers\Helper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreEmailRequest extends FormRequest
{
    private $image_ext = [
        'jpg', 'jpeg', 'png', 'gif', 'ai', 'svg', 'eps', 'ps'
    ];

    private $audio_ext = [
        'mp3', 'ogg', 'mpga'
    ];

    private $video_ext = [
        'mp4', 'mpeg'
    ];

    private $document_ext = [
        'doc', 'docx', 'dotx', 'pdf', 'odt', 'xls', 'xlsm', 'xlsx', 'ppt', 'pptx', 'vsd'
    ];

    /**
     * Merge all listed extensions into one massive array
     *
     * @return array Extensions of all file types
     */
    private function extension_whitelist()
    {
        $extensions =  array_merge($this->image_ext, $this->audio_ext, $this->video_ext, $this->document_ext);

        return implode(',', $extensions);
    }

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
        $extensions = $this->extension_whitelist();

        return [
            'from' => 'required|email',
            'to' => 'required|email',
            'subject' => 'required|max:200',
            'should_fail' => 'sometimes|boolean',
            'text_content' => 'required',
            'html_content' => 'sometimes',
            'attachments[].*' => "sometimes|file|mimes:$extensions|max:5000",
            'attachments.*' => "sometimes|file|mimes:$extensions|max:5000",

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

//    protected function failedValidation(Validator $validator) {
//        $message = $validator->errors()->all();
//        throw new HttpResponseException(response()->json(['status' => 0,'messages' => $message]));
//    }

    /**
     * Clean up fields after validation
     *
     * @param Validator $validator
     */
    protected function afterValidation(Validator $validator)
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
            'subject.max' => 'Use some common sense! Your subject cannot be the size of an email :(',
//            'attachments.*.mimes' => 'Only Images, documents, audios and videos are allowed.',
            'attachments.*.max' => 'Max upload size(5MB) exceeded.'
        ];
    }
}
