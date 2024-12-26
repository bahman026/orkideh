<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'source_card_id' => [
                'required',
                'exists:cards,card_number',
                'regex:/^(6273-81|5022-29|5057-85|5028-06|6221-06|5029-08|6391-94)\d{2}-\d{4}-\d{4}$/',
            ],

            'destination_card_id' => [
                'required',
                'exists:cards,card_number',
                'different:source_card_id',
                'regex:/^(6273-81|5022-29|5057-85|5028-06|6221-06|5029-08|6391-94)\d{2}-\d{4}-\d{4}$/',
            ],
            'amount' => [
                'required',
                'numeric',
                'min:1000',
                'max:50000000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'source_card_id.required' => 'شماره کارت مبدا الزامی است.',
            'source_card_id.exists' => 'کارت مبدا معتبر نیست.',
            'destination_card_id.required' => 'شماره کارت مقصد الزامی است.',
            'destination_card_id.exists' => 'کارت مقصد معتبر نیست.',
            'destination_card_id.different' => 'کارت مبدا و مقصد نباید یکسان باشند.',
            'amount.required' => 'مبلغ انتقال الزامی است.',
            'amount.numeric' => 'مبلغ انتقال باید عددی باشد.',
            'amount.min' => 'حداقل مبلغ انتقال ۱۰۰۰ تومان است.',
            'amount.max' => 'حداکثر مبلغ انتقال ۵۰ میلیون تومان است.',
            'source_card_id.regex' => 'کارت مبدا معتبر نیست.',
            'destination_card_id.regex' => 'کارت مقصد معتبر نیست.',
        ];
    }
}
