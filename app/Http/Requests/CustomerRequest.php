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
            'company' => 'required|string|max:50',
            'short_name' => 'nullable|string|max:50',
            'industry' => 'required|string|max:255',
            'status' => 'required|in:information_exchange,consulting_survey,quotation,negotiation,contract_signed,payment_completed,no_contract_signed',
            'address' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'ward' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'file' => 'nullable',
            'contact.name' => 'required|string|max:255',
            'contact.email' => 'required|email|unique:customer_contacts,email',
            'contact.gender' => 'required|in:male,female',
            'contact.phone' => 'required|min:9|max:11',
            'contact.position' => 'nullable|string|max:255',
        ];

        if ($id) {
            $rules['company'] = 'nullable|string|max:50';
            $rules['short_name'] = 'nullable|string|max:50';
            $rules['industry'] = 'nullable|string|max:255';
            $rules['status'] = 'nullable|in:information_exchange,consulting_survey,quotation,negotiation,contract_signed,payment_completed,no_contract_signed';
            $rules['address'] = 'nullable|string|max:255';
            $rules['province'] = 'nullable|string|max:255';
            $rules['district'] = 'nullable|string|max:255';
            $rules['ward'] = 'nullable|string|max:255';
            $rules['contact.name'] = 'nullable|string|max:255';
            $rules['contact.email'] = "nullable|email|unique:customer_contacts,email,$id,customer_id";
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
            'company' => 'Tên đầy đủ',
            'short_name' => 'Tên viết tắt',
            'industry' => 'Lĩnh vực',
            'status' => 'Trạng thái',
            'address' => 'Địa chỉ',
            'province' => 'Tỉnh/Thành',
            'district' => 'Quận/Huyện',
            'ward' => 'Phường/Xã',
            'description' => 'Mô tả',
            'user.email' => 'Email',
            'user.password' => 'Mật khẩu',
            'user.is_active' => 'Trạng thái tài khoản',
            'contact.name' => 'Tên liên hệ',
            'contact.email' => 'Email',
            'contact.gender' => 'Giới tính',
            'contact.phone' => 'Số điện thoại',
            'contact.position' => 'Chức vụ',
        ];
    }

}
