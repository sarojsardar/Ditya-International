@extends('backend.layout')
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">

@section('title')
    Candidate {{ $userDetails->userdetail->full_name }} Detail | {{ config('app.name') }}
@endsection


@section('content')

    <style>
        #myLightbox {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.75);
            z-index: 9999;
            overflow: auto;
            /* Enable scrolling if needed */
            padding-top: 20px;
            /* Add some padding to ensure space for close button */
            box-sizing: border-box;
            /* Ensure padding is included in height calculation */
        }

        #closeLightbox {
            position: fixed;
            top: 10px;
            right: 25px;
            font-size: 40px;
            cursor: pointer;
            color: #fff;
        }

        #lightboxImage {
            width: auto;
            /* Auto width to maintain aspect ratio */
            max-width: 90%;
            /* Limit width to prevent overflow */
            max-height: 80vh;
            /* Limit height based on viewport */
            margin: 0 auto;
            /* Center horizontally */
            display: block;
            /* Ensure margin auto works */
            position: relative;
            /* Removed transform for simplicity, rely on overflow and max-sizes */
        }

        #myImage {
            width: 100%;
            max-width: 100%;
            cursor: pointer;
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">User Profile /</span> Profile</h4>


        <p>
            <span class="text-danger" style="font-size: 25px">Note:</span>
            Before Proceeding to visa process, please read all information of the candidate to make successfull visa
            process.
        </p>

        <!-- Header -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                        <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                            <img src="{{ url('/storage/uploads/passport-photos/' . $userDetails?->uploadPhoto?->passport_photo) }}"
                                alt="user image" height="80" width="100"
                                class="d-block ms-0 ms-sm-4 rounded  img-fluid" />
                        </div>
                        <div class="flex-grow-1 mt-3 mt-sm-5">
                            <div
                                class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                <div class="user-profile-info">
                                    <h4>{{ $userDetails->userDetail->full_name }}</h4>
                                    <ul
                                        class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                        <li class="list-inline-item">
                                            <i class="mdi mdi-bookmark-check mdi-24px"></i>
                                            <span class="fw-medium mx-2">Medical Status :</span>
                                            <span>{{ $medicalCheckup?->status ?? 'Not Scheduled' }}</span>
                                        </li>


                                        <li class="list-inline-item">
                                            <i class="mdi mdi-bookmark-check mdi-24px"></i>
                                            <span class="fw-medium mx-2">Interview Status :</span>
                                            <span>{{ (bool) $interview?->is_selected ? 'Selected' : 'Not Selected Or Not Scheduled Or Not Taken' }}</span>
                                        </li>

                                        <li class="list-inline-item">
                                            <i class="mdi mdi-map-marker-outline me-1 mdi-20px"></i><span
                                                class="fw-medium">{{ $userDetails?->userDetail->permanent_address }}</span>
                                        </li>
                                        <li class="list-inline-item">
                                            <i class="mdi mdi-calendar-blank-outline me-1 mdi-20px"></i><span
                                                class="fw-medium"> {{ $userDetails->userDetail->dob }}</span>
                                        </li>

                                    </ul>
                                </div>

                                {{-- @if (!@$visaProcess) --}}
                                <div class="button-group" style="flex-shrink: 0;"> <!-- Ensure the buttons don't shrink -->
                                    <a href="#" id="document-status" title='Info' class="me-2">
                                        <!-- Add me-2 for spacing -->
                                        <button class='btn btn-sm btn-primary'><i class='fas fa-info'></i>Document
                                            Status</button>
                                    </a>

                                    <a href="#" id="notify-user" title='Info' class="me-2">
                                        <!-- Add me-2 for spacing -->
                                        <button class='btn btn-sm btn-info'><i class='fas fa-info'></i>Notify
                                            Candidate</button>
                                    </a>
                                </div>
                                {{-- @endif --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Header -->


        <!-- User Profile Content -->
        <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-5">
                <!-- About User -->
                <div class="card mb-4">
                    <div class="card-body">
                        <small class="card-text text-uppercase">Personal Details</small>
                        <ul class="list-unstyled my-3 py-1">
                            <li class="d-flex align-items-center mb-3">
                                <i class="mdi mdi-account-outline mdi-24px"></i><span class="fw-medium mx-2">Father's
                                    Name:</span> <span>{{ $userDetails->userDetail->father_name }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="mdi mdi-account-outline mdi-24px"></i><span class="fw-medium mx-2">Mother's
                                    Name:</span> <span>{{ $userDetails->userDetail->mother_name }}</span>
                            </li>

                            <li class="d-flex align-items-center mb-3">
                                <i class="mdi mdi-language-go me-1 mdi-20px"></i><span class="fw-medium mx-2">Age :</span>
                                <span class="fw-medium">{{ $userDetails->userDetail->age }}</span>
                            </li>
                            @if ($userDetails->userDetail->marital_status === 'Married')
                                <li class="d-flex align-items-center mb-3">
                                    <i class="mdi mdi-account-outline mdi-24px"></i>
                                    <span class="fw-medium mx-2">Spouse's Name:</span>
                                    <span>{{ $userDetails->userDetail->spouse_name }}</span>
                                </li>
                            @else
                                <li class="d-flex align-items-center mb-3">
                                    <i class="mdi mdi-account-outline mdi-24px"></i>
                                    <span class="fw-medium mx-2">Marital Status:</span> <span>Unmarried</span>
                                </li>
                            @endif

                            <li class="d-flex align-items-center mb-3">
                                <i class="mdi mdi-map-marker-outline me-1 mdi-20px"></i><span
                                    class="fw-medium mx-2">Parmanent Address:</span> <span
                                    class="fw-medium">{{ $userDetails->userDetail->permanent_address }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="mdi mdi-phone-outline mdi-24px"></i><span class="fw-medium mx-2">Contact:</span>
                                <span>{{ $userDetails->mobile_no }}</span>
                            </li>

                            <li class="d-flex align-items-center mb-3">
                                <i class="mdi mdi-account-multiple-outline mdi-24px"></i><span
                                    class="fw-medium mx-2">Relatives in Malaysia :</span>
                                <span>{{ $userDetails->userdetail->has_relatives_in_malaysia == 1 ? 'Yes' : 'No' }}</span>
                            </li>

                            <li class="d-flex align-items-center mb-3">
                                <i class="mdi mdi-motorbike mdi-24px"></i><span class="fw-medium mx-2">Accident :</span>
                                <span>{{ $userDetails->userdetail->has_been_in_accident == 1 ? 'Yes' : 'No' }}</span>
                            </li>

                            <br><br>

                        </ul>
                    </div>
                </div>
                <!--/ About User -->
                <!-- Profile Overview -->

                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title text-uppercase mb-3">Passport Details</h6>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-3">
                                <span class="fw-bold me-2">Passport Image:</span>
                                <div>
                                    <img src="{{ asset('storage/uploads/passport-images/' . $userDetails?->passportDetail?->passport_image) }}"
                                        class="img-fluid lightbox-trigger"
                                        style="width:auto; max-height:100px; cursor:pointer;">
                                </div>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <span class="fw-bold me-2">Passport Number:</span>
                                <span>{{ $userDetails?->passportDetail?->passport_number }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <span class="fw-bold me-2">Issue Date:</span>
                                <span>{{ $userDetails?->passportDetail?->passport_issue_date }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <span class="fw-bold me-2">Issue Place:</span>
                                <span>{{ $userDetails?->passportDetail?->issue_place }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <span class="fw-bold me-2">Expiry Date:</span>
                                <span>{{ $userDetails?->passportDetail?->expiry_date }}</span>
                            </li>
                        </ul>
                    </div>

                </div>
                <!--/ Profile Overview -->

                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title text-uppercase mb-3">Language Known</h6>
                        @if ($userDetails->languageDetail->isNotEmpty())
                            <ul class="list-unstyled">
                                @foreach ($userDetails->languageDetail as $detail)
                                    @if ($detail->language)
                                        {{-- Check if the category relationship exists --}}
                                        <li class="d-flex align-items-center mb-3">
                                            <span class="fw-bold me-2">Language {{ $loop->iteration }} :</span>
                                            <span>{{ ucfirst($detail->language->name) }}</span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </div>

                </div>
            </div>
            <div class="col-xl-8 col-lg-7 col-md-7">
                <!-- Activity Timeline -->
                <div class="card card-action mb-4">
                    <div class="card-header align-items-center">
                        <h5 class="card-action-title mb-0">
                            <i class="mdi mdi-format-list-bulleted mdi-24px me-2"></i>Work Experience
                        </h5>
                    </div>
                    <div class="card-body pt-3 pb-0">
                        <ul class="timeline mb-0">
                            @if (!$userDetails->workExperience->isEmpty())
                                @foreach ($userDetails->workExperience as $exp)
                                    <li class="timeline-item timeline-item-transparent">
                                        <span class="timeline-point timeline-point-success"></span>
                                        <div class="timeline-event">
                                            <div class="timeline-header mb-1">
                                                <h6 class="mb-0">{{ $exp->position }}</h6>
                                                <small class="text-muted">{{ $exp->no_of_years }} Years</small>
                                            </div>
                                            <p class="mb-2">Details : {{ $exp->description }}</p>
                                            <div class="d-flex flex-wrap">
                                                <div class="avatar me-3">
                                                    <img src="{{ url('/storage/uploads/passport-photos/' . $userDetails?->uploadPhoto?->passport_photo) }}"
                                                        alt="Avatar" class="rounded-circle" />
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">Company : {{ $exp->company_name }}</h6>
                                                    <span>Country : {{ $exp->country }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li class="timeline-item timeline-item-transparent">
                                    <tr>
                                        <td colspan="6" style="text-align: center">No Work Experience</td>
                                    </tr>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <!--/ Activity Timeline -->
                <div class="row">
                    <!-- Connections -->
                    <div class="col-lg-12 col-xl-6">
                        <div class="card card-action mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">User Photos</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <img src="{{ url('/storage/uploads/passport-photos/' . $userDetails?->uploadPhoto?->passport_photo) }}"
                                                    alt="Passport Size Photo"
                                                    class="img-fluid rounded-circle lightbox-trigger"
                                                    style="width:100px; height:100px; object-fit: cover; cursor:pointer;">
                                            </div>
                                            <h6 class="mb-0">Passport Size Photo</h6>
                                        </div>
                                    </li>
                                    <li class="mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <img src="{{ url('/storage/uploads/full-photos/' . $userDetails?->uploadPhoto?->full_photo) }}"
                                                    alt="Full Size Photo"
                                                    class="img-fluid rounded-circle lightbox-trigger"
                                                    style="width:100px; height:100px; object-fit: cover; cursor:pointer;">
                                            </div>
                                            <h6 class="mb-0">Full Size Photo</h6>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <!--/ Connections -->
                    <!-- Teams -->
                    <div class="col-lg-12 col-xl-6">
                        <div class="card card-action mb-4">
                            <div class="card-header align-items-center">
                                <h5 class="card-action-title">Resume</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0 ">
                                    <li class="d-flex align-items-center mb-3">
                                        <!-- Display PDF in an iframe -->
                                        <iframe id="pdfViewer" width="100%" height="220px"></iframe>

                                        <script>
                                            document.addEventListener('DOMContentLoaded', (event) => {
                                                // Set the iframe src attribute dynamically
                                                document.getElementById('pdfViewer').src =
                                                    "{{ asset('storage/uploads/resume-files/' . $userDetails?->resumeDetail?->resume_file) }}";
                                            });
                                        </script>

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--/ Teams -->
                </div>

                <!-- Projects table -->
                <div class="card mb-4">
                    <div class="card">
                        <h5 class="card-header">Educational Document</h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Educational Doc</th>
                                        <th>Level</th>
                                        <th>School/ College Name</th>
                                        <th>Pass Year</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>
                                            <iframe id="pdfViewer1" width="100%" height="220px"></iframe>

                                            <script>
                                                document.addEventListener('DOMContentLoaded', (event) => {
                                                    // Set the iframe src attribute dynamically
                                                    document.getElementById('pdfViewer1').src =
                                                        "{{ asset('storage/uploads/edu-doc/' . $userDetails?->educationalQualification?->edu_doc) }}";
                                                });
                                            </script>
                                        </td>
                                        <td style="vertical-align: top;">
                                            {{ ucfirst($userDetails?->educationalQualification?->level) }}</td>
                                        <td style="vertical-align: top;">
                                            {{ ucfirst($userDetails?->educationalQualification?->school_college_name) }}
                                        </td>
                                        <td style="vertical-align: top;">
                                            {{ ucfirst($userDetails?->educationalQualification?->pass_year) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <!--/ Projects table -->
            </div>
        </div>

        <div class="card mt-5">
            <h5 class="card-header">Medical Report</h5>
            <div class="container">
                @foreach ($medicalCheckup?->report ?? [] as $report)
                    <img src="{{ $report }}" alt="Not Foound" class="img-fluid">
                @endforeach
            </div>
        </div>

        @if ($visaProcess?->status == 'Successed')
            <div class="card mt-5">
                <h5 class="card-header">Visa</h5>
                <div class="container">
                    <embed src="{{ $visaProcess?->visa }}#toolbar=0" width="100%" height="500px" />
                </div>
            </div>
        @endif
        @if ($visaProcess?->status == 'Rejected')
            <div class="card mt-5">
                <h5 class="card-header">Visa</h5>
                <div class="container">
                    <p>
                        {{ $visaProcess?->reason }}
                    </p>
                </div>
            </div>
        @endif


        @if ($labourPermit?->status == 'Successed')
            <div class="card mt-5">
                <h5 class="card-header">Labour Permit</h5>
                <div class="container">
                    <embed src="{{ $labourPermit?->permit }}#toolbar=0" width="100%" height="500px" />
                </div>
            </div>
        @endif


        @if ($evisa?->status == 'Successed')
            <div class="card mt-5">
                <h5 class="card-header">E Visa</h5>
                <div class="container">
                    <embed src="{{ $evisa?->visa }}#toolbar=0" width="100%" height="500px" />
                </div>
            </div>
        @endif

        @if ($eticket?->status == 'Successed')
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="card-header">E Ticket Info</h5>
                                <div class="container">
                                    <p>Check In Date: {{\Carbon\Carbon::parse($eticket?->arrival)->format('Y-m-d g:i A')}}</p>
                                    <p>Departure Date: {{\Carbon\Carbon::parse($eticket?->departure_date)->format('Y-m-d g:i A')}}</p>
                                </div>
                            </div>
    
                            <div class="col-md-6">
                                <h5 class="card-header">E Ticket</h5>
                                <div class="container">
                                    <embed src="{{ $eticket?->eticket }}#toolbar=0" width="100%" height="500px" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!--/ User Profile Content -->
        <!-- Lightbox Container -->
        <div id="myLightbox"
            style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,0.75);text-align:center;z-index:9999;">
            <span id="closeLightbox"
                style="position:absolute;top:20px;right:30px;font-size:40px;cursor:pointer;color:#fff;">&times;</span>
            <img id="lightboxImage" style="max-width:80%;margin-top:60px;">
        </div>
    </div>

    <div class="modal fade" id="changeDocumentStatus" tabindex="-1" role="dialog"
        aria-labelledby="changeDocumentStatusLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('document-officer.document-status', $companyCandidate->id) }}" method="post"
                id="status-form">
                @csrf
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changeDocumentStatusLabel">Change Document Status</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Status:</label>
                            <select name="status" id="status" class="form-control">
                                <option value="Completed">Completed</option>
                                <option value="In Progress">In Progress</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Change Status</button>
                        <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="notify-userModal" tabindex="-1" role="dialog"
        aria-labelledby="notify-userModalStatusLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('document-officer.notify-user', $companyCandidate->id) }}" method="post"
                id="status-form">
                @csrf
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="notify-userModalStatusLabel">Notify User</h5>
                    </div>
                    <div class="modal-body">
                        <h5>Select The Required Document to Be Update</h5>
                        <ul class="list-gourp">
                            <li class="list-group-item">
                                <input type="checkbox" name="element_ids[]" class="element-checkbox"
                                    value="1"><span class="ms-2">Profile Picture</span>
                                <textarea name="reasons[1]" rows="3" class="form-control reason-area d-none">This is Blur Or Not Uploaded Or Not In Mentioned size</textarea>
                            </li>
                            <li class="list-group-item">
                                <input type="checkbox" name="element_ids[]" class="element-checkbox"
                                    value="2"><span class="ms-2">PP size Photo</span>
                                <textarea name="reasons[2]" rows="3" class="form-control reason-area d-none">This is Blur Or Not Uploaded Or Not In Mentioned size</textarea>
                            </li>

                            <li class="list-group-item">
                                <input type="checkbox" name="element_ids[]" class="element-checkbox"
                                    value="3"><span class="ms-2">Passport</span>
                                <textarea name="reasons[3]" rows="3" class="form-control reason-area d-none">This is Blur Or Not Uploaded Or Not In Mentioned size</textarea>
                            </li>

                            <li class="list-group-item">
                                <input type="checkbox" name="element_ids[]" class="element-checkbox"
                                    value="4"><span class="ms-2">Full size Photo</span>
                                <textarea name="reasons[4]" rows="3" class="form-control reason-area d-none">This is Blur Or Not Uploaded Or Not In Mentioned size</textarea>
                            </li>

                            <li class="list-group-item">
                                <input type="checkbox" name="element_ids[]" class="element-checkbox"
                                    value="5"><span class="ms-2">Educational Document</span>
                                <textarea name="reasons[5]" rows="3" class="form-control reason-area d-none">This is Blur Or Not Uploaded Or Not In Mentioned size</textarea>
                            </li>

                            <li class="list-group-item">
                                <input type="checkbox" name="element_ids[]" class="element-checkbox"
                                    value="6"><span class="ms-2">Resume</span>
                                <textarea name="reasons[6]" rows="3" class="form-control reason-area d-none">This is Blur Or Not Uploaded Or Not In Mentioned size</textarea>
                            </li>

                            <li class="list-group-item">
                                <input type="checkbox" name="element_ids[]" class="element-checkbox"
                                    value="7"><span class="ms-2">Additional Document</span>
                                <textarea name="reasons[7]" rows="3" class="form-control reason-area d-none">This is Blur Or Not Uploaded Or Not In Mentioned size</textarea>
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Notify User</button>
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $(document).on('click', '#document-status', function(e) {
            e.preventDefault();
            $('#changeDocumentStatus').modal('show');
        });

        $(document).on('click', '#notify-user', function() {
            $('#notify-userModal').modal('show');
        });


        $(document).on('change', '.element-checkbox', function(e) {
            e.preventDefault();
            // prop('checked')
            $(this).closest('li').find('.reason-area').toggleClass(['d-none', 'd-block']);
        })
    </script>
@endpush
