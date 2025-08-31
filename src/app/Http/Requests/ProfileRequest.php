<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'profile_image' => ['nullable','image','mimes:jpeg,png'],
            'name' => ['required','string','max:20'],
            'postcode' => ['required','regex:/^\d{3}-\d{4}$/'],
            'address' => ['required','string'],
        ];
    }

    public function messages()
    {
        return[
            'profile_image' => '「.png」または「.jpeg」形式でアップロードしてください',
            'name.required' => 'お名前を入力してください',
            'name.max' => 'お名前を20文字以内で入力してください',
            'postcode.required' => '郵便番号を入力してください',
            'postcode.regex' => '郵便番号はハイフンを含めて123-4567形式で入力してください',
            'address.required' => '住所を入力してください',
        ];
    }


}
