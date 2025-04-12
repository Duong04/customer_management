<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->id;
        $rules = [
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|max:255|min:8',
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'required',
            'staff.address' => 'nullable|string|max:255',
            'staff.phone' => 'nullable|string|max:11|min:9',
            'staff.dob' => 'nullable|date',
            'staff.join_date' => 'nullable|date',
            'staff.gender' => 'nullable|in:male,female',
            'staff.note' => 'nullable|string',
        ];

        if ($id) {
            $rules['email'] .= ",$id";
            $rules['password'] = "nullable|string|max:255";
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống!',
            'string' => ':attribute phải là chuỗi!',
            'max' => ':attribute không được vượt quá :max ký tự!',
            'min' => ':attribute không được nhỏ hơn :min ký tự!',
            'email' => ':attribute phải là một địa chỉ email hợp lệ!',
            'unique' => ':attribute đã tồn tại!',
            'in' => ':attribute không hợp lệ!',
            'exists' => ':attribute không tồn tại'
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Họ và tên',
            'email' => 'Email',
            'password' => 'Mật khẩu',
            'role_id' => 'Vai trò',
            'is_active' => 'Trạng thái tài khoản',
            'staff.phone' => 'Số điện thoại',
            'staff.dob' => 'Ngày sinh',
            'staff.join_date' => 'Ngày vào',
            'staff.gender' => 'Giới tính',
            'staff.address' => 'Địa chỉ',
            'staff.note' => 'Ghi chú',
        ];
    }

}
