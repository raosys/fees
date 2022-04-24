<?php

namespace Raosys\Fees\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEntryItemRequest extends FormRequest
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
            'fee_structure_id' => 'required|exists:fee_structures,id|integer|min:1|',
            'votehead' => 'required|string|max:255|min:2|unique:entry_items,votehead',
            'amount' => 'required|numeric|min:0.01|max:9999999999.99',
        ];
    }
}
