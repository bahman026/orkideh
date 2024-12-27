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
            'source_card_id.required' => __('validation.source_card_required'),
            'source_card_id.exists' => __('validation.source_card_invalid'),
            'source_card_id.regex' => __('validation.source_card_format'),
            'destination_card_id.required' => __('validation.destination_card_required'),
            'destination_card_id.exists' => __('validation.destination_card_invalid'),
            'destination_card_id.different' => __('validation.destination_card_different'),
            'destination_card_id.regex' => __('validation.destination_card_format'),
            'amount.required' => __('validation.amount_required'),
            'amount.numeric' => __('validation.amount_numeric'),
            'amount.min' => __('validation.amount_min'),
            'amount.max' => __('validation.amount_max'),
        ];
    }
}
