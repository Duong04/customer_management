@extends('layouts.master-layout', ['title' => 'Admin - Cập nhật khách hàng'])
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Quản lý người dùng /</span> Cập nhật khách hàng</h4>
        <!-- Hoverable Table rows -->
        <div class="row">
            <div class="col-xl">
              <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">Cập nhật khách hàng</h5>
                  <a href="{{ route('customers.index') }}"><small class="text-muted float-end d-flex align-item-center"><i class='bx bx-left-arrow-alt'></i> Quay về</small></a>
                </div>
                <div class="card-body">
                  <form class="row" action="{{ route('customers.update', ['id' => $user->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                  
                    {{-- Họ và tên --}}
                    <div class="col-md-4 mb-3">
                      <label class="form-label" for="fullname">Họ và tên</label>
                      <input value="{{ $user->customer->fullname }}" name="fullname" type="text" class="form-control" id="fullname" placeholder="Họ và tên" />
                      @if ($errors->first('fullname'))
                        <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('fullname') }}</span>
                      @endif
                    </div>
                  
                    {{-- Email --}}
                    <div class="col-md-4 mb-3">
                      <label class="form-label" for="email">Email</label>
                      <input value="{{ $user->email }}" name="user[email]" type="text" class="form-control" id="email" placeholder="example@gmail.com" />
                      @if ($errors->first('user.email'))
                        <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('user.email') }}</span>
                      @endif
                    </div>
                  
                    {{-- Mật khẩu --}}
                    <div class="col-md-4 mb-3">
                      <label class="form-label" for="password">Mật khẩu</label>
                      <input value="{{ old('user.password') }}" name="user[password]" type="password" class="form-control" id="password" placeholder="Mật khẩu" />
                      @if ($errors->first('user.password'))
                        <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('user.password') }}</span>
                      @endif
                    </div>
                  
                    {{-- Tên viết tắt --}}
                    <div class="col-md-3 mb-3">
                      <label class="form-label" for="name">Tên viết tắt</label>
                      <input value="{{ $user->name }}" name="name" type="text" class="form-control" id="name" placeholder="Tên viết tắt" />
                      @if ($errors->first('name'))
                        <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('name') }}</span>
                      @endif
                    </div>
                  
                    {{-- Lĩnh vực --}}
                    <div class="col-md-3 mb-3">
                      <label class="form-label" for="industry">Lĩnh vực</label>
                      <input value="{{ $user->customer->industry }}" name="industry" type="text" class="form-control" id="industry" placeholder="Lĩnh vực" />
                      @if ($errors->first('industry'))
                        <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('industry') }}</span>
                      @endif
                    </div>
                  
                    {{-- Trạng thái --}}
                    <div class="col-md-3 mb-3">
                      <label class="form-label" for="status">Trạng thái</label>
                      <select name="status" class="form-control" id="status">
                        <option value="">-- Trạng thái --</option>
                        <option {{ $user->customer->status == 'information_exchange' ? 'selected' : '' }} value="information_exchange">Trao đổi thông tin</option>
                        <option {{ $user->customer->status == 'consulting_survey' ? 'selected' : '' }} value="consulting_survey">Khảo sát tư vấn</option>
                        <option {{ $user->customer->status == 'quotation' ? 'selected' : '' }} value="quotation">Báo giá</option>
                        <option {{ $user->customer->status == 'negotiation' ? 'selected' : '' }} value="negotiation">Đàm phán</option>
                        <option {{ $user->customer->status == 'contract_signed' ? 'selected' : '' }} value="contract_signed">Ký hợp đồng</option>
                        <option {{ $user->customer->status == 'payment_completed' ? 'selected' : '' }} value="payment_completed">Thanh toán nghiệm thu</option>
                        <option {{ $user->customer->status == 'no_contract_signed' ? 'selected' : '' }} value="no_contract_signed">Không ký hợp đồng</option>
                      </select>
                      @if ($errors->first('status'))
                        <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('status') }}</span>
                      @endif
                    </div>
                    <div class="col-md-3 mb-3">
                      <label class="form-label" for="is_active">Trạng thái tài khoản</label>
                      <select name="user[is_active]" class="form-control" id="is_active">
                        <option value="">-- Trạng thái tài khoản --</option>
                        <option {{ $user->is_active == 1 ? 'selected' : '' }} value="1">Hoạt động</option>
                        <option {{ $user->is_active == 0 ? 'selected' : '' }} value="0">Không hoạt động</option>
                      </select>
                      @if ($errors->first('user.is_active'))
                        <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('user.is_active') }}</span>
                      @endif
                    </div>
                  
                    {{-- Địa chỉ --}}
                    <div class="col-md-6 mb-3">
                      <label class="form-label" for="address">Địa chỉ</label>
                      <textarea name="address" rows="4" type="text" class="form-control" id="address" placeholder="Địa chỉ">{{ $user->customer->address }}</textarea>
                      @if ($errors->first('address'))
                        <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('address') }}</span>
                      @endif
                    </div>
                    {{-- Mô tả --}}
                    <div class="col-md-6 mb-3">
                      <label class="form-label" for="description">Mô tả</label>
                      <textarea name="description" rows="4" class="form-control" id="description" placeholder="Mô tả">{{ $user->customer->description }}</textarea>
                      @if ($errors->first('description'))
                        <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('description') }}</span>
                      @endif
                    </div>
                  
                    <div class="col-12">
                      <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                  </form>
                  
                </div>
              </div>
            </div>
          </div>
    </div>
@endsection
