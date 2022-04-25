<?php

namespace Raosys\Fees\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class CreateFeeStructureRequest extends FormRequest
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
        $course_table = $this->getTableName();
        return [
            'course' => 'required|integer|exists:' . $course_table . ',id',
            'serial_code' => 'required|string|unique:fee_structures,serial_code',
        ];
    }

    private function getTableName()
    {
        $userModel = is_array(config('fees.courses_model')) ? config('fees.courses_model')[intval(App::version())] : config('fees.courses_model');
        return (new $userModel())->getTable();
    }
}
