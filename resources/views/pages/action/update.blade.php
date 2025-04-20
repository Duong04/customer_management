@extends('layouts.master-layout', ['title' => 'Admin - Cập nhật hành động'])
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Phân quyền /</span> Cập nhật hành động</h4>
        <!-- Hoverable Table rows -->
        <div class="row">
            <div class="col-xl">
              <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">Cập nhật hành động</h5>
                  <a href="{{ route('actions.index') }}"><small class="text-muted float-end d-flex align-item-center"><i class='bx bx-left-arrow-alt'></i> Quay về</small></a>
                </div>
                <div class="card-body">
                  <form class="row" action="{{ route('actions.update', ['id' => $action->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-md-6 mb-3">
                      <label class="form-label" for="name">Tên hành động (<span class="text-danger">*</span>)</label>
                      <input value="{{ $action->name }}" name="name" type="text" class="form-control" id="name" placeholder="Create" />
                      @if ($errors->first('name'))
                        <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('name') }}</span>
                      @endif
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label" for="value">Bí danh (<span class="text-danger">*</span>)</label>
                      <input value="{{ $action->value }}" name="value" type="text" class="form-control" id="value" placeholder="create" />
                      @if ($errors->first('value'))
                        <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('value') }}</span>
                      @endif
                    </div>
                    <div class="col-12 mb-3">
                      <span>Cho phép thuộc quyền nào</span>
                      <div class="row gutters-xs mt-2">
                        @foreach ($permissions as $item)
                        <div class="col-auto ms-3 d-flex align-items-center">
                            <label class="colorinput me-2">
                                <input {{ $action->permissionActions->contains('permission_id', $item->id) ? 'checked' : '' }} id="checkbox-{{$item->id}}" name="permissions[]" type="checkbox" value="{{ $item->id }}" class="colorinput-input form-check-input check-action" />
                                <span class="colorinput-color bg-info"></span>
                            </label>
                            <label for="checkbox-{{$item->id}}">{{ $item->name }}</label>
                        </div>
                        @endforeach
                    </div>
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
