<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required',
            'password' => 'nullable',
            're_password' => 'nullable|same:password',
            'position_id' =>  'required|exists:positions,id',
            'department_id' =>  'required|exists:departments,id',
            'birthday' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên',
            're_password.same' => 'Mật khẩu không khớp',
            'position_id.required' => 'Vui lòng chọn chức vụ',
            'position_id.exists' => 'Chức vụ không tồn tại',
            'department_id.required' => 'Vui lòng chọn phòng ban',
            'department_id.exists' => 'Phòng ban không tồn tại',
            'birthday.date' => 'Ngày sinh không đúng định dạng',
            'birthday.required' => 'Vui lòng nhập ngày sinh',
        ];
    }
}
