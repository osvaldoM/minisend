<?php

namespace App\Http\Requests;

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
            'attachments' => 'sometimes|file|image|max:5000'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'should_fail' => $this->should_fail == 'on' ? true: false,
            'html_content' => $this->removeUnwantedTags($this->html_content),
        ]);
    }

    private function removeUnwantedTags($html)
    {
        $dom = new \DOMDocument();

        $dom->loadHTML($html);

        $tags_to_remove = array('script','style','iframe','link');

        foreach($tags_to_remove as $tag){
            $elements = $dom->getElementsByTagName($tag);
            foreach($elements as $item){
                $item->parentNode->removeChild($item);
            }
        }
        return $dom->saveHTML();

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
        ];
    }
}
