@extends('layouts.master-layout', ['title' => 'Admin - Thêm hành động'])
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Phân quyền /</span> Hành động</h4>
        <!-- Hoverable Table rows -->
        <div class="row">
            <div class="col-xl">
              <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">Thêm hành động</h5>
                  <small class="text-muted float-end">Default label</small>
                </div>
                <div class="card-body">
                  <form class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label" for="name">Tên hành động</label>
                      <input type="text" class="form-control" id="name" placeholder="Create" />
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label" for="value">Bí danh</label>
                      <input type="text" class="form-control" id="value" placeholder="create" />
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
    </div>
@endsection
