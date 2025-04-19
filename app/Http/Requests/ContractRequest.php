<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'note' => ['nullable', 'string'],
            'customer_representative' => ['required', 'string'],
            'signer' => ['required', 'string', 'max:255'],
            'customer_id' => ['required', 'exists:customers,id'],
            'sign_date' => ['required', 'date'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:valid,expired,not_yet_valid'],
            'contract_value' => ['required', 'numeric', 'min:0'],
            'payments' => ['nullable', 'array', 'min:1'],
            'payments.*.payment_method' => ['required', 'in:cash,bank_transfer,credit_card'],
            'payments.*.amount' => ['required', 'numeric', 'min:0'],
            'payments.*.status' => ['required', 'in:pending,completed'],

            'payments.*.bank_name' => ['nullable', 'required_if:payments.*.payment_method,bank_transfer', 'string', 'max:100'],
            'payments.*.account_number' => ['nullable', 'required_if:payments.*.payment_method,bank_transfer', 'string', 'max:50'],
            'payments.*.account_holder' => ['nullable', 'required_if:payments.*.payment_method,bank_transfer', 'string', 'max:100'],
            'attachments' => ['nullable', 'array'],
            'attachments.*.file' => ['nullable', 'max:10240'],
        ];

        if ($id) {
            $rules['attachments.*.id'] = 'nullable';
            $rules['payments.*.id'] = 'nullable';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute là bắt buộc.',
            'string' => ':attribute phải là chuỗi ký tự.',
            'max' => ':attribute không được vượt quá :max ký tự.',
            'min' => ':attribute phải có ít nhất :min.',
            'date' => ':attribute phải là ngày hợp lệ.',
            'after_or_equal' => ':attribute phải lớn hơn hoặc bằng :date.',
            'in' => ':attribute không hợp lệ.',
            'numeric' => ':attribute phải là số.',
            'array' => ':attribute phải là danh sách.',
            'exists' => ':attribute không tồn tại hoặc không hợp lệ.',
            'required_if' => ':attribute là bắt buộc.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'tên hợp đồng',
            'description' => 'Mô tả',
            'signer' => 'người ký',
            'customer_id' => 'khách hàng',
            'sign_date' => 'ngày ký',
            'start_date' => 'ngày bắt đầu',
            'end_date' => 'ngày kết thúc',
            'status' => 'trạng thái',
            'contract_value' => 'giá trị hợp đồng',
            'payments' => 'danh sách thanh toán',

            'payments.*.payment_method' => 'phương thức thanh toán',
            'payments.*.amount' => 'số tiền thanh toán',
            'payments.*.status' => 'trạng thái thanh toán',
            'payments.*.note' => 'ghi chú',
            'payments.*.bank_name' => 'tên ngân hàng',
            'payments.*.account_number' => 'số tài khoản',
            'payments.*.account_holder' => 'tên chủ tài khoản',

            'attachments' => 'Tệp đính kèm',
            'attachments.*.note' => 'Mô tả tệp đính kèm',
            'attachments.*.file' => 'Tệp đính kèm',
        ];
    }
}
