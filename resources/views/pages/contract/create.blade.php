@extends('layouts.master-layout', ['title' => 'Admin - Tạo hợp đồng'])

@section('css')
    <style>
        .upload-box {
            border: 2px dashed #0b2dee;
            padding: 35px 10px;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            position: relative;
        }

        .upload-box:hover {
            background-color: #d6e5fc;
        }

        .upload-box i,
        .upload-box span {
            pointer-events: none;
        }

        .text-purple {
            color: #0b2dee;
        }

        .btn-plus,
        .btn-remove {
            cursor: pointer;
        }

        .btn-plus:hover,
        .btn-remove:hover {
            opacity: 0.8;
        }
    </style>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Quản lý hợp đồng /</span> Tạo hợp đồng</h4>
        <!-- Hoverable Table rows -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Tạo hợp đồng</h5>
                        <a href="{{ route('staffs.index') }}"><small class="text-muted float-end d-flex align-item-center"><i
                                    class='bx bx-left-arrow-alt'></i> Quay về</small></a>
                    </div>
                    <div class="card-body">
                        <form class="row" action="{{ route('staffs.store') }}" method="POST">
                            @csrf

                            {{-- Tên hợp đồng --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="name">Tên hợp đồng</label>
                                <input value="{{ old('name') }}" name="name" type="text" class="form-control"
                                    id="name" placeholder="Nhập tên hợp đồng" />
                                @error('name')
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Người ký --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="signer">Người ký</label>
                                <input value="{{ old('signer') }}" name="signer" type="text" class="form-control"
                                    id="signer" placeholder="Tên người ký" />
                                @error('signer')
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Khách hàng --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="customer_id">Khách hàng</label>
                                <select name="customer_id" class="form-control" id="customer_id">
                                    <option value="">-- Chọn khách hàng --</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}</option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Ngày ký --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="sign_date">Ngày ký</label>
                                <input value="{{ old('sign_date') }}" name="sign_date" type="date" class="form-control"
                                    id="sign_date" />
                                @error('sign_date')
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Ngày bắt đầu --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="start_date">Ngày bắt đầu</label>
                                <input value="{{ old('start_date') }}" name="start_date" type="date"
                                    class="form-control" id="start_date" />
                                @error('start_date')
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Ngày kết thúc --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="end_date">Ngày kết thúc</label>
                                <input value="{{ old('end_date') }}" name="end_date" type="date" class="form-control"
                                    id="end_date" />
                                @error('end_date')
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Trạng thái --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="status">Trạng thái</label>
                                <select name="status" class="form-control" id="status">
                                    <option value="">-- Trạng thái --</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Đang hiệu lực
                                    </option>
                                    <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Hết hạn
                                    </option>
                                    <option value="terminated" {{ old('status') == 'terminated' ? 'selected' : '' }}>Đã
                                        chấm dứt</option>
                                </select>
                                @error('status')
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Giá trị hợp đồng --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="contract_value">Giá trị hợp đồng</label>
                                <input value="{{ old('contract_value') }}" name="contract_value" type="number"
                                    step="0.01" class="form-control" id="contract_value" placeholder="Nhập giá trị" />
                                @error('contract_value')
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                              <label class="form-label" for="contract_value">Giá trị hợp đồng</label>
                              <input value="{{ old('contract_value') }}" name="contract_value" type="number"
                                  step="0.01" class="form-control" id="contract_value" placeholder="Nhập giá trị" />
                              @error('contract_value')
                                  <span class="text-danger" style="font-size: 0.8rem;">{{ $message }}</span>
                              @enderror
                          </div>

                            {{-- File đính kèm --}}
                            @php
                                $attachments = old('attachments', [['description' => '', 'file' => null]]);
                            @endphp
                            <div class="form-group col-12">
                              <label>Tệp đính kèm</label>
                              <div id="attachment-wrapper" class="row">
                                  @foreach ($attachments as $index => $attachment)
                                      <div class="d-flex flex-column mb-2 attachment-item py-2 col-4"
                                          data-index="{{ $index }}">
                                          <div class="col-md-12 d-flex align-items-center mb-2">
                                              <div class="text-danger me-2 cursor-pointer btn-remove">
                                                <i class='bx bx-trash'></i>
                                              </div>
                                              <div class="text-primary cursor-pointer btn-plus add-attachment">
                                                <i class='bx bx-plus'></i>
                                              </div>
                                          </div>

                                          <div class="col-md-12 my-2">
                                              <input type="text"
                                                  name="attachments[{{ $index }}][description]"
                                                  class="form-control" value="{{ $attachment['description'] }}"
                                                  placeholder="Mô tả tệp" />
                                              @error("attachments.$index.description")
                                                  <span class="text-danger fs-7">{{ $message }}</span>
                                              @enderror
                                          </div>

                                          <div class="col-md-12">
                                              <label class="upload-box w-100 text-center">
                                                  <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-purple"></i><br>
                                                  <span class="text-purple">Upload File</span>
                                                  <small class="file-name text-muted text-truncate d-block mt-1"></small>
                                                  <input type="file" name="attachments[{{ $index }}][file]"
                                                      class="form-control upload-input" hidden />
                                              </label>
                                              @error("attachments.$index.file")
                                                  <span class="text-danger fs-7">{{ $message }}</span>
                                              @enderror
                                          </div>
                                      </div>
                                  @endforeach
                              </div>
                          </div>

                            {{-- Ghi chú --}}
                            <div class="col-md-8 mb-3">
                                <label class="form-label" for="note">Ghi chú</label>
                                <textarea name="note" rows="4" class="form-control" id="note" placeholder="Nhập ghi chú">{{ old('note') }}</textarea>
                                @error('note')
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Tạo ngay</button>
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
        document.addEventListener("DOMContentLoaded", function() {
            let wrapper = document.getElementById("attachment-wrapper");

            // Cập nhật index hiện tại dựa theo phần tử cuối
            let index = wrapper.querySelectorAll(".attachment-item").length;

            // Thêm file mới
            wrapper.addEventListener("click", function(e) {
                if (e.target.closest(".add-attachment")) {
                    let newItem = document.createElement("div");
                    newItem.classList.add("d-flex", "flex-column", "mb-2", "attachment-item",
                    "py-2", "col-4");
                    newItem.setAttribute("data-index", index);

                    newItem.innerHTML = `
                        <div class="col-md-12 d-flex align-items-center mb-2">
                            <div class="text-danger me-2 cursor-pointer btn-remove">
                                 <i class='bx bx-trash'></i>
                            </div>
                            <div class="text-primary cursor-pointer btn-plus add-attachment">
                                <i class="bx bx-plus"></i>
                            </div>
                        </div>
                        <div class="col-md-12 my-2">
                            <input type="text" name="attachments[${index}][description]" class="form-control" placeholder="Mô tả tệp" />
                        </div>
                        <div class="col-md-12">
                            <label class="upload-box w-100 text-center">
                                <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-purple"></i><br>
                                <span class="text-purple">Upload File</span>
                                <small class="file-name text-muted text-truncate d-block mt-1"></small>
                                <input type="file" name="attachments[${index}][file]" class="form-control upload-input" hidden />
                            </label>
                        </div>
                    `;

                    wrapper.appendChild(newItem);
                    index++;
                }
            });

            // Xoá file
            wrapper.addEventListener("click", function(e) {
                if (e.target.closest(".btn-remove")) {
                    let item = e.target.closest(".attachment-item");
                    if (item) item.remove();
                }
            });

            // Hiển thị tên file khi chọn
            wrapper.addEventListener("change", function(e) {
                if (e.target.matches(".upload-input")) {
                    let fileInput = e.target;
                    let fileName = fileInput.files[0]?.name || '';
                    fileInput.closest("label").querySelector(".file-name").textContent = fileName;
                }
            });
        });
    </script>
@endsection
