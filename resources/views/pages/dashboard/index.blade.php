@extends('layouts.master-layout', ['title' => 'Admin - Dashboard'])
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-8 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Xin chào {{ auth()->user()->name }}! 🎉</h5>
                                <p class="mb-4">
                                    Chào mừng bạn quay lại tiếp tục quản lý hệ thống! Chúc bạn làm việc hiệu quả và thành công.
                                </p>

                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140"
                                    alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 order-1">
                <h5>Thống kê hợp đồng</h5>
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success"
                                            class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Có hiệu lực</span>
                                <h3 class="card-title mb-2">{{ $status_valid['count'] }}</h3>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> {{ number_format($status_valid['total_value'], 0, ',', '.') }} đ</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="../assets/img/icons/unicons/wallet-info.png" alt="Credit Card"
                                            class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <span>Chưa có hiệu lực</span>
                                <h3 class="card-title text-nowrap mb-2">{{ $status_not_yet_valid['count'] }}</h3>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> {{  number_format($status_not_yet_valid['total_value'], 0, ',', '.') .'đ' }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Total Revenue -->
            <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="col-md-8">
                            <h5 class="card-header m-0 me-2 pb-3">Số lượng khách hàng</h5>
                            <div id="totalRevenueChart" class="px-2"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-body">
                                <div class="text-center d-flex justify-content-center" style="gap: 10px;">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" 
                                                id="growthReportYearId" data-bs-toggle="dropdown" aria-haspopup="true" 
                                                aria-expanded="false">
                                            <span id="selectedYear">{{ now()->year }}</span> <!-- Hiển thị năm mặc định -->
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportYearId" id="yearDropdown">
                                            <a class="dropdown-item" href="javascript:void(0);" data-year="2027">2027</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-year="2026">2026</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-year="2025">2025</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-year="2024">2024</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-year="2023">2023</a>
                                        </div>
                                    </div>
                                
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" 
                                                id="growthReportMonthId" data-bs-toggle="dropdown" aria-haspopup="true" 
                                                aria-expanded="false">
                                            <span id="selectedMonth">{{ now()->month }}</span> <!-- Hiển thị tháng mặc định -->
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportMonthId" id="monthDropdown">
                                            <a class="dropdown-item" href="javascript:void(0);" data-month="1">1</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-month="2">2</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-month="3">3</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-month="4">4</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-month="5">5</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-month="6">6</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-month="7">7</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-month="8">8</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-month="9">9</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-month="10">10</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-month="11">11</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-month="12">12</a>
                                        </div>
                                    </div>
                                </div>
                                

                                  
                            </div>
                            <div id="growthChart"></div>
                            <div class="text-center fw-semibold pt-3 mb-2" id="growthPercentage">62% Company Growth</div>

                            <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                                <div class="d-flex">
                                    <div class="me-2">
                                        <span class="badge bg-label-primary p-2"><i
                                                class="bx bx-dollar text-primary"></i></span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <small>2024</small>
                                        <h6 class="mb-0">$32.5k</h6>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="me-2">
                                        <span class="badge bg-label-info p-2"><i
                                                class="bx bx-wallet text-info"></i></span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <small>2025</small>
                                        <h6 class="mb-0">$41.2k</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Total Revenue -->
            <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                <div class="row">
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="../assets/img/icons/unicons/paypal.png" alt="Credit Card"
                                            class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <span class="d-block mb-1">Hết hạn</span>
                                <h3 class="card-title text-nowrap mb-2">{{ $status_expired['count'] }}</h3>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                    {{ number_format($status_expired['total_value'], 0, ',', '.') }}đ</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="../assets/img/icons/unicons/cc-primary.png" alt="Credit Card"
                                            class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Tổng</span>
                                <h3 class="card-title mb-2">{{ $status_total['count'] }}</h3>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>{{ number_format($status_total['total_value'], 0, ',', '.') }}đ</small>
                            </div>
                        </div>
                    </div>
                    <!-- </div>
    <div class="row"> -->
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                    <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                        <div class="card-title">
                                            <h5 class="text-nowrap mb-2">Tổng lợi nhuận</h5>
                                            <span class="badge bg-label-warning rounded-pill">Year {{ now()->year }}</span>
                                        </div>
                                        <div class="mt-sm-auto">
                                            <small class="text-success text-nowrap fw-semibold"><i
                                                    class="bx bx-chevron-up"></i> 68.2%</small>
                                            <h3 class="mb-0">{{ number_format($status_total['total_value'], 0, ',', '.') }}đ</h3>
                                        </div>
                                    </div>
                                    <div id="profileReportChart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
