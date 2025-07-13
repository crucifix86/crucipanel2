<?php



/*
 * @author Harris Marfel <hrace009@gmail.com>
 * @link https://youtube.com/c/hrace009
 * @copyright Copyright (c) 2022.
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoteRequest extends FormRequest
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
            'name' => 'required|string',
            'link' => [
                'required',
                'url',
                'regex:/^https?:\/\/(www\.)?arena-top100\.com\/.*$/'
            ],
            'type' => 'required',
            'reward_amount' => 'required|numeric|min:1',
            'hour_limit' => 'required|numeric|min:1'
        ];
    }
    
    public function messages()
    {
        return [
            'link.regex' => 'Only Arena Top 100 links are supported. The URL must be from arena-top100.com'
        ];
    }
}
