<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'fullname' => 'required|string|max:50',
            'name' => 'required|string|max:50',
            'industry' => 'required|string|max:255',
            'status' => 'required|in:information_exchange,consulting_survey,quotation,negotiation,contract_signed,payment_completed,no_contract_signed',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'user.email' => 'required|email|unique:users,email',
            'user.password' => 'required|string|max:255|min:8',
            'user.is_active' => 'required',
            'contact.name' => 'required|string|max:255',
            'contact.gender' => 'nullable|in:male,female',
            'contact.phone' => 'nullable|min:9|max:11',
            'contact.position' => 'nullable|string|max:255',
        ];

        if ($id) {
            $rules['user.email'] .= ",$id";
            $rules['user.password'] = "nullable|string|max:255";
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
        ];
    }

    public function attributes(): array
    {
        return [
            'fullname' => 'Họ và tên',
            'name' => 'Tên viết tắt',
            'industry' => 'Lĩnh vực',
            'status' => 'Trạng thái',
            'address' => 'Địa chỉ',
            'description' => 'Mô tả',
            'user.email' => 'Email',
            'user.password' => 'Mật khẩu',
            'user.is_active' => 'Trạng thái tài khoản',
            'contact.name' => 'Tên liên hệ',
            'contact.gender' => 'Giới tính',
            'contact.phone' => 'Số điện thoại',
            'contact.position' => 'Chức vụ',
        ];
    }

}
