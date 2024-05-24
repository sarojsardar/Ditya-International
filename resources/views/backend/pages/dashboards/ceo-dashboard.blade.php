@extends('backend.layout')

@section('title')
Dashboard | {{ config('app.name') }}
@endsection

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-6 mb-6">

        <div class="col-xxl-4">
            <div class="card card-border-shadow-success h-100">
                <div class="card-body">
                    <h5 class="card-title mb-1">Enrolled <span class="fw-bold">Candidates!</span> 🎉</h5>
                    <p class="card-subtitle mb-3">per Month</p>
                    <h4 class="text-success mb-0">30 persons</h4>
                    <p class="mb-3">78% of target 🚀</p>
                    <a href="javascript:;" class="btn btn-sm btn-success">View Details</a>
                </div>
                <img src="../../assets/img/illustrations/trophy.png" class="position-absolute bottom-0 end-0 me-4"
                    height="140" alt="view Details" />
            </div>
        </div>

        <div class="col-xxl-2 col-md-3 col-sm-6">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-primary rounded-3">
                                <i class="ri-shopping-cart-2-line ri-24px"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-info mt-5">
                        <h5 class="mb-1">15</h5>
                        <p>Total Staffs</p>
                        <div class="badge bg-label-secondary rounded-pill">Last 4 Month</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-2 col-md-3 col-sm-6">
            <div class="card card-border-shadow-success h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-success rounded-3">
                                <i class="ri-handbag-line ri-24px"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-info mt-5">
                        <h5 class="mb-1">50</h5>
                        <p>Total Demands</p>
                        <div class="badge bg-label-secondary rounded-pill">Last Six Month</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-2 col-md-3 col-sm-6">
            <div class="card card-border-shadow-info h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-info rounded-3">
                                <i class="ri-handbag-line ri-24px"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-info mt-5">
                        <h5 class="mb-1">20</h5>
                        <p>Total Company</p>
                        <div class="badge bg-label-secondary rounded-pill">Last Six Month</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-2 col-md-3 col-sm-6">
            <div class="card card-border-shadow-danger h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-danger rounded-3">
                                <i class="ri-handbag-line ri-24px"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-info mt-5">
                        <h5 class="mb-1">5</h5>
                        <p>Total Rejected</p>
                        <div class="badge bg-label-secondary rounded-pill">Last Six Month</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row g-6">

        <div class="col-xxl-4 col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Meekly Candidate Overview</h5>
                    <div class="dropdown">
                        <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1" type="button"
                            id="meetingSchedule" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-more-2-line ri-20px"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="meetingSchedule">
                            <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        <li class="d-flex align-items-center mb-6">
                            <div class="avatar flex-shrink-0 me-4">
                                <img src="../../assets/img/avatars/4.png" alt="avatar" class="rounded-3" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Call with Woods</h6>
                                    <small class="d-flex align-items-center">
                                        <i class="ri-calendar-line ri-16px"></i>
                                        <span class="ms-2">21 Jul | 08:20-10:30</span>
                                    </small>
                                </div>
                                <div class="badge bg-label-primary rounded-pill">Accepted</div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-6">
                            <div class="avatar flex-shrink-0 me-4">
                                <img src="../../assets/img/avatars/5.png" alt="avatar" class="rounded-3" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Conference call</h6>
                                    <small class="d-flex align-items-center">
                                        <i class="ri-calendar-line ri-16px"></i>
                                        <span class="ms-2">21 Jul | 08:20-10:30</span>
                                    </small>
                                </div>
                                <div class="badge bg-label-warning rounded-pill">On progress</div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-6">
                            <div class="avatar flex-shrink-0 me-4">
                                <img src="../../assets/img/avatars/3.png" alt="avatar" class="rounded-3" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Meeting with Mark</h6>
                                    <small class="d-flex align-items-center">
                                        <i class="ri-calendar-line ri-16px"></i>
                                        <span class="ms-2">21 Jul | 08:20-10:30</span>
                                    </small>
                                </div>
                                <div class="badge bg-label-secondary rounded-pill">Pending</div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-6">
                            <div class="avatar flex-shrink-0 me-4">
                                <img src="../../assets/img/avatars/14.png" alt="avatar" class="rounded-3" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Meeting in Oakland</h6>
                                    <small class="d-flex align-items-center">
                                        <i class="ri-calendar-line ri-16px"></i>
                                        <span class="ms-2">21 Jul | 08:20-10:30</span>
                                    </small>
                                </div>
                                <div class="badge bg-label-danger rounded-pill">Rejected</div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-6">
                            <div class="avatar flex-shrink-0 me-4">
                                <img src="../../assets/img/avatars/8.png" alt="avatar" class="rounded-3" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Call with hilda</h6>
                                    <small class="d-flex align-items-center">
                                        <i class="ri-calendar-line ri-16px"></i>
                                        <span class="ms-2">21 Jul | 08:20-10:30</span>
                                    </small>
                                </div>
                                <div class="badge bg-label-success rounded-pill">Completed</div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-4">
                                <img src="../../assets/img/avatars/1.png" alt="avatar" class="rounded-3" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Meeting with Carl</h6>
                                    <small class="d-flex align-items-center">
                                        <i class="ri-calendar-line ri-16px"></i>
                                        <span class="ms-2">21 Jul | 08:20-10:30</span>
                                    </small>
                                </div>
                                <div class="badge bg-label-primary rounded-pill">Accepted</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 order-2 order-lg-0">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Some Random Title </h5>
                    <div class="dropdown">
                        <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1" type="button"
                            id="mostSales" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-more-2-line ri-20px"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="mostSales">
                            <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pb-1 pt-0">
                    <div class="mb-6 mt-1">
                        <div class="d-flex align-items-center">
                            <h1 class="mb-0 me-2">24,895</h1>
                            <div class="badge bg-label-success rounded-pill">+42%</div>
                        </div>
                        <p class="mt-0">Sales Last 90 Days</p>
                    </div>
                    <div class="table-responsive text-nowrap border-top">
                        <table class="table">
                            <tbody class="table-border-bottom-0">
                                <tr>
                                    <td class="ps-0 pe-12 py-4"><span class="text-heading">Australia</span></td>
                                    <td class="text-end py-4"><span class="text-heading fw-medium">18,879</span></td>
                                    <td class="pe-0 py-4">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <span class="text-heading fw-medium me-2">15%</span>
                                            <i class="ri-arrow-down-s-line ri-24px text-danger"></i>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-0 pe-12 py-4"><span class="text-heading">Canada</span></td>
                                    <td class="text-end py-4"><span class="text-heading fw-medium">10,357</span></td>
                                    <td class="pe-0 py-4">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <span class="text-heading fw-medium me-2">85%</span>
                                            <i class="ri-arrow-up-s-line ri-24px text-success"></i>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-0 pe-12 py-4"><span class="text-heading">India</span></td>
                                    <td class="text-end py-4"><span class="text-heading fw-medium">4,860</span></td>
                                    <td class="pe-0 py-4">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <span class="text-heading fw-medium me-2">48%</span>
                                            <i class="ri-arrow-up-s-line ri-24px text-success"></i>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-0 pe-12 py-4"><span class="text-heading">United State</span></td>
                                    <td class="text-end py-4"><span class="text-heading fw-medium">899</span></td>
                                    <td class="pe-0 py-4">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <span class="text-heading fw-medium me-2">16%</span>
                                            <i class="ri-arrow-down-s-line ri-24px text-danger"></i>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-0 pe-12 py-4"><span class="text-heading">Brazil</span></td>
                                    <td class="text-end py-4"><span class="text-heading fw-medium">18</span></td>
                                    <td class="pe-0 py-4">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <span class="text-heading fw-medium me-2">12%</span>
                                            <i class="ri-arrow-up-s-line ri-24px text-success"></i>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

            <div class="col-12 col-xxl-4 col-md-6">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="bg-label-primary text-center mb-6 pt-2 rounded-3">
                      <img
                        class="img-fluid w-px-150"
                        src="../../assets/img/illustrations/faq-illustration.png"
                        alt="Boy card image" />
                    </div>
                    <h5 class="mb-1">Upcoming Deadline</h5>
                    <p class="mb-6">
                      Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                    </p>
                    <div class="row mb-6 g-4">
                      <div class="col-6">
                        <div class="d-flex">
                          <div class="avatar flex-shrink-0 me-4">
                            <span class="avatar-initial rounded-3 bg-label-primary"
                              ><i class="ri-calendar-line ri-24px"></i
                            ></span>
                          </div>
                          <div>
                            <h6 class="mb-0 text-nowrap fw-normal">17 Nov 23</h6>
                            <small>Date</small>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="d-flex">
                          <div class="avatar flex-shrink-0 me-4">
                            <span class="avatar-initial rounded-3 bg-label-primary"
                              ><i class="ri-time-line ri-24px"></i
                            ></span>
                          </div>
                          <div>
                            <h6 class="mb-0 text-nowrap fw-normal">32 minutes</h6>
                            <small>Duration</small>
                          </div>
                        </div>
                      </div>
                    </div>
                    <a href="javascript:void(0);" class="btn btn-primary w-100">View All</a>
                  </div>
                </div>
              </div>

    </div>
</div>

@endsection

@push('scripts')
<script>


</script>
@endpush