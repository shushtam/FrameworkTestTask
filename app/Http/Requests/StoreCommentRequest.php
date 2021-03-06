<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
        if (auth()->check()) {
            return [
                //
                'comment' => 'required|max:255'
            ];
        }
        return [
            //
            'auth' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'comment.required' => 'Please write a comment',
            'comment.max' => 'Comment is too long',
            'auth.required' => "You must login to leave a comment."
        ];
    }

    public function response(array $errors)
    {
        return response()->json(['errors' => $errors], 422);

    }
}
