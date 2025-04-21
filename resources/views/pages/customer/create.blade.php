@extends('layouts.master-layout', ['title' => 'Admin - Thêm khách hàng'])
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Quản lý người dùng /</span> Thêm khách hàng</h4>
        <!-- Hoverable Table rows -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Thêm khách hàng</h5>
                        <a href="{{ route('customers.index') }}"><small
                                class="text-muted float-end d-flex align-item-center"><i class='bx bx-left-arrow-alt'></i>
                                Quay về</small></a>
                    </div>
                    <div class="card-body">
                        <form class="row" action="{{ route('customers.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            {{-- Họ và tên --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="company">Tên đầy đủ ( <span class="text-danger">*</span>
                                    )</label>
                                <input value="{{ old('company') }}" name="company" type="text" class="form-control"
                                    id="company" placeholder="Tên đầy đủ" />
                                @if ($errors->first('company'))
                                    <span class="text-danger"
                                        style="font-size: 0.8rem;">{{ $errors->first('company') }}</span>
                                @endif
                            </div>

                            {{-- Tên viết tắt --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="short_name">Tên viết tắt</label>
                                <input value="{{ old('short_name') }}" name="short_name" type="text" class="form-control"
                                    id="short_name" placeholder="Tên viết tắt" />
                                @if ($errors->first('short_name'))
                                    <span class="text-danger"
                                        style="font-size: 0.8rem;">{{ $errors->first('short_name') }}</span>
                                @endif
                            </div>

                            {{-- Lĩnh vực --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="industry">Lĩnh vực ( <span class="text-danger">*</span>
                                    )</label>
                                <input value="{{ old('industry') }}" name="industry" type="text" class="form-control"
                                    id="industry" placeholder="Lĩnh vực" />
                                @if ($errors->first('industry'))
                                    <span class="text-danger"
                                        style="font-size: 0.8rem;">{{ $errors->first('industry') }}</span>
                                @endif
                            </div>

                            {{-- Trạng thái --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="status">Trạng thái ( <span class="text-danger">*</span>
                                    )</label>
                                <select name="status" class="form-control" id="status">
                                    <option value="">-- Trạng thái --</option>
                                    <option {{ old('status') == 'information_exchange' ? 'selected' : '' }}
                                        value="information_exchange">Trao đổi thông tin</option>
                                    <option {{ old('status') == 'consulting_survey' ? 'selected' : '' }}
                                        value="consulting_survey">Khảo sát tư vấn</option>
                                    <option {{ old('status') == 'quotation' ? 'selected' : '' }} value="quotation">Báo giá
                                    </option>
                                    <option {{ old('status') == 'negotiation' ? 'selected' : '' }} value="negotiation">Đàm
                                        phán</option>
                                    <option {{ old('status') == 'contract_signed' ? 'selected' : '' }}
                                        value="contract_signed">Ký hợp đồng</option>
                                    <option {{ old('status') == 'payment_completed' ? 'selected' : '' }}
                                        value="payment_completed">Thanh toán nghiệm thu</option>
                                    <option {{ old('status') == 'no_contract_signed' ? 'selected' : '' }}
                                        value="no_contract_signed">Không ký hợp đồng</option>
                                </select>
                                @if ($errors->first('status'))
                                    <span class="text-danger"
                                        style="font-size: 0.8rem;">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="file">Tệp đính kèm</label>
                                <input value="{{ old('file') }}" name="file" type="file" class="form-control"
                                    id="file" placeholder="Lĩnh vực" />
                                @if ($errors->first('file'))
                                    <span class="text-danger"
                                        style="font-size: 0.8rem;">{{ $errors->first('file') }}</span>
                                @endif
                            </div>
                            {{-- Mô tả --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="note">Ghi chú</label>
                                <input value="{{ old('note') }}" type="text" name="note" rows="4"
                                    class="form-control" id="note" placeholder="Ghi chú">
                                @if ($errors->first('note'))
                                    <span class="text-danger"
                                        style="font-size: 0.8rem;">{{ $errors->first('note') }}</span>
                                @endif
                            </div>
                            <div class="col-12 mt-2">
                                <h5>Thông tin liên Hệ</h5>
                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="contact_name">Tên liên hệ ( <span
                                                class="text-danger">*</span> )</label>
                                        <input value="{{ old('contact.name') }}" name="contact[name]" type="text"
                                            class="form-control" id="contact_name" placeholder="Tên liên hệ" />
                                        @if ($errors->first('contact.name'))
                                            <span class="text-danger"
                                                style="font-size: 0.8rem;">{{ $errors->first('contact.name') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="email">Email ( <span
                                                class="text-danger">*</span> )</label>
                                        <input value="{{ old('contact.email') }}" name="contact[email]" type="text"
                                            class="form-control" id="email" placeholder="Email" />
                                        @if ($errors->first('contact.email'))
                                            <span class="text-danger"
                                                style="font-size: 0.8rem;">{{ $errors->first('contact.email') }}</span>
                                        @endif
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="phone">Số điện thoại ( <span
                                                class="text-danger">*</span> )</label>
                                        <input value="{{ old('contact.phone') }}" name="contact[phone]" type="text"
                                            class="form-control" id="phone" placeholder="Số điện thoại" />
                                        @if ($errors->first('contact.phone'))
                                            <span class="text-danger"
                                                style="font-size: 0.8rem;">{{ $errors->first('contact.phone') }}</span>
                                        @endif
                                    </div>

                                    {{-- Mật khẩu --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="position">Chức vụ</label>
                                        <input value="{{ old('contact.position') }}" name="contact[position]"
                                            type="position" class="form-control" id="position" placeholder="Chức vụ" />
                                        @if ($errors->first('contact.position'))
                                            <span class="text-danger"
                                                style="font-size: 0.8rem;">{{ $errors->first('contact.position') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="gender">Giới tính ( <span
                                                class="text-danger">*</span> )</label>
                                        <select name="contact[gender]" class="form-control" id="gender">
                                            <option value="">-- Giới tính --</option>
                                            <option {{ old('contact.gender') == 'male' ? 'selected' : '' }}
                                                value="male">Nam</option>
                                            <option {{ old('contact.gender') == 'female' ? 'selected' : '' }}
                                                value="female">Nữ</option>
                                        </select>
                                        @if ($errors->first('contact.gender'))
                                            <span class="text-danger"
                                                style="font-size: 0.8rem;">{{ $errors->first('contact.gender') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="address">Địa chỉ ( <span class="text-danger">*</span>
                                            )</label>
                                        <input type="text" value="{{ old('address') }}" name="address"
                                            rows="4" type="text" class="form-control" id="address"
                                            placeholder="Địa chỉ">
                                        @if ($errors->first('address'))
                                            <span class="text-danger"
                                                style="font-size: 0.8rem;">{{ $errors->first('address') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="province">Chọn tỉnh/thành ( <span class="text-danger">*</span>
                                            )</label>
                                        <select class="form-control" name="province" id="province">
                                            <option value="">-- Chọn tỉnh/thành --</option>
                                        </select>
                                        @if ($errors->first('province'))
                                            <span class="text-danger"
                                                style="font-size: 0.8rem;">{{ $errors->first('province') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="district">Quận / Huyện ( <span class="text-danger">*</span>
                                            )</label>

                                        <select class="form-control" name="district" id="district">
                                            <option value="">-- Chọn quận/huyện --</option>
                                        </select>
                                        @if ($errors->first('district'))
                                            <span class="text-danger"
                                                style="font-size: 0.8rem;">{{ $errors->first('district') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="ward">Phường/ Xã ( <span class="text-danger">*</span>
                                            )</label>

                                        <select class="form-control" name="ward" id="ward">
                                            <option value="">-- Chọn phường/xã --</option>
                                        </select>
                                        @if ($errors->first('ward'))
                                            <span class="text-danger"
                                                style="font-size: 0.8rem;">{{ $errors->first('ward') }}</span>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Lưu</button>
                                <a href="{{ route('customers.index') }}" class="btn btn-outline-danger">Hủy</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const oldProvince = "{{ old('province') }}";
        const oldDistrict = "{{ old('district') }}";
        const oldWard = "{{ old('ward') }}";
        const provinceSelect = document.getElementById('province');
        const districtSelect = document.getElementById('district');
        const wardSelect = document.getElementById('ward');

        // Load tỉnh
        fetch('https://provinces.open-api.vn/api/p/')
            .then(res => res.json())
            .then(data => {
                data.forEach(p => {
                    provinceSelect.innerHTML += `<option value="${p.code}">${p.name}</option>`;
                });

                if (oldProvince) {
                    provinceSelect.value = oldProvince;
                    loadDistricts(oldProvince);
                }
            });

        // Load quận/huyện theo tỉnh
        function loadDistricts(provinceId) {
            fetch(`https://provinces.open-api.vn/api/p/${provinceId}?depth=2`)
                .then(res => res.json())
                .then(data => {
                    districtSelect.innerHTML = '<option value="">-- Chọn quận/huyện --</option>';
                    data.districts.forEach(d => {
                        districtSelect.innerHTML += `<option value="${d.code}">${d.name}</option>`;
                    });

                    if (oldDistrict) {
                        districtSelect.value = oldDistrict;
                        loadWards(oldDistrict);
                    }
                });
        }

        // Load phường/xã theo huyện
        function loadWards(districtId) {
            fetch(`https://provinces.open-api.vn/api/d/${districtId}?depth=2`)
                .then(res => res.json())
                .then(data => {
                    wardSelect.innerHTML = '<option value="">-- Chọn phường/xã --</option>';
                    data.wards.forEach(w => {
                        wardSelect.innerHTML += `<option value="${w.code}">${w.name}</option>`;
                    });

                    if (oldWard) {
                        wardSelect.value = oldWard;
                    }
                });
        }

        // Khi chọn tỉnh
        provinceSelect.addEventListener('change', function() {
            districtSelect.innerHTML = '<option value="">-- Chọn quận/huyện --</option>';
            wardSelect.innerHTML = '<option value="">-- Chọn phường/xã --</option>';
            if (this.value) {
                loadDistricts(this.value);
            }
        });

        // Khi chọn huyện
        districtSelect.addEventListener('change', function() {
            wardSelect.innerHTML = '<option value="">-- Chọn phường/xã --</option>';
            if (this.value) {
                loadWards(this.value);
            }
        });
    </script>
@endsection
