<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$userDetails->userDetail->full_name}}</title>
    <style>
        body {
            font-size: 14px;
        }

        .contact-details {
            text-align: right;
        }

        .contact-details ul {
            padding: 0;
            margin: 0;
        }

        .contact-details ul li {
            list-style: none;
        }

        .contact-details ul li span {
            display: inline-block;
            vertical-align: top;
        }

        .contact-details ul li i {
            height: 15px;
            width: 15px;
            line-height: 15px;
            text-align: center;
            border: 1px solid #000;
            margin-left: 10px;
        }

        .cantidate-head {
            border-bottom: 2px solid #6a6a6a;
            padding-bottom: 5px;
        }

        .logo {
            height: 40px;
            width: auto;
            margin-top: 10px;
        }

        #wrapper {
            overflow: inherit !important;
        }

        .footer {
            position: static !important;
        }

        .top-details h1 {
            margin: 0;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 700;
            background: #6a6a6a;
            display: inline-block;
            padding: 7px 10px;
            color: #fff;
            border-radius: 5px;
            letter-spacing: 1px;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            margin: auto;
            max-width: 180px;
        }

        .top-details {
            margin-top: 5px;
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }

        .profile-img {
            position: absolute;
            top: 5px;
            right: 0;
        }

        .top-details td {
            text-align: left;
        }

        .profile-img img {
            height: 50px;
            width: 50px;
            object-fit: cover;
        }

        .inner-header {
            font-size: 10px;
            margin: 0;
            margin-bottom: 5px;
            background: #6a6a6a;
            color: #fff;
            display: inline-block;
            padding: 5px 12px;
            border-radius: 50px;
        }

        .personal-details table td {
            padding: 3px 7px;
        }

        .passport-table {
            border: 1px solid gray;
        }

        .language-details table td {
            padding: 3px 7px;
        }

        .center-td td {
            text-align: center;
        }

        .language-details {
            margin-top: 15px;
        }

        .training-details {
            margin-top: 10px;
        }

        .training-details ul {
            margin: 0;
            padding: 0;
        }

        .training-details ul li {
            list-style: none;
            border-bottom: 2px dotted gray;
        }

        .training-details ul li+li {
            margin-top: 20px;
        }

        .footer-details {
            margin-top: 50px;
        }

        .footer-details span {
            display: inline-block;
            border-top: 2px dotted gray;
            padding-top: 5px;
        }

        table {
            border-collapse: collapse;
        }
    </style>
</head>

<body>

    <div class="cantidate-head">
        <table width="100%">
            <tbody>
                <tr>
                    <td>
                        Govt. Lic. No.: 1171/073/074<br>
                        <img src="{{ @$setting->site_logo ? url('/storage/public/uploads/site-logo/'.@$setting->site_logo) : asset('assets/images/logo.png') }}" alt="logo" class="logo">
                    </td>
                    <td class="contact-details">
                        <ul>
                            <li>
                                <span>{{ @$setting->location }}</span>
                                <i class="las la-map-marker"></i>
                            </li>
                            <li>
                                <span>{{ @$setting->contact }}</span>
                                <i class="las la-phone"></i>
                            </li>
                            <li>
                                <span>{{ @$setting->official_email }}</span>
                                <i class="las la-envelope"></i>
                            </li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="top-details">
        <h1>Job Application Form</h1>
        <table>
            <tbody>
            <tr>
                <td>Date:</td>
                <td>{{ \Carbon\Carbon::parse($userDetails->userdetail->created_at)->toDateString() }}</td>
            </tr>
            <tr>
                <td>Applied Country:</td>
                <td> </td>
            </tr>
            </tbody>
        </table>

        <div class="profile-img">
            <img src="{{url('/storage/uploads/passport-photos/'.$userDetails->uploadPhoto->passport_photo)}}" alt="images">
        </div>
    </div>
    <div class="personal-details">
        <table width="100%">
            <tbody>
                <tr>
                    <td style="padding:0;vertical-align:top;padding-right:15px;width:65%;">
                        <h3 class="inner-header">Personal Details</h3>
                        <table border="1" width="100%">
                            <tbody>
                                <tr>
                                    <td>Name</td>
                                    <td>{{$userDetails->userDetail->full_name}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Father's Name</td>
                                    <td>{{ $userDetails->userDetail->father_name }}</td>
                                </tr>
                                <tr>
                                    <td>Mother's Name</td>
                                    <td>{{ $userDetails->userDetail->mother_name }}</td>
                                </tr>
                                <tr>
                                    <td>Spouse Name</td>
                                    <td>{{ $userDetails->userDetail->spouse_name }}</td>
                                </tr>
                                <tr>
                                    <td>Permanent Address</td>
                                    <td>{{ $userDetails->userDetail->permanent_address }}</td>
                                </tr>
                                <tr>
                                    <td>Temporary Address</td>
                                    <td>{{ $userDetails->userDetail->temporary_address}}</td>
                                </tr>
                                <tr>
                                    <td>Contact No.</td>
                                    <td>{{ $userDetails->mobile_no }}</td>
                                </tr>

                                <tr>
                                    <td>Weight</td>
                                    <td>{{ $userDetails->userDetail->weight }}</td>
                                </tr>
                                <tr>
                                    <td>Marital Status</td>
                                    <td>
                                        @if($userDetails->userDetail->marital_status === 'Married')
                                            <!-- Display spouse name only if marital status is married -->
                                            Spouse: {{ $userDetails->userDetail->spouse_name }}
                                        @else
                                            <!-- Display this if the user is not married -->
                                            Unmarried
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>Height</td>
                                    <td>{{ $userDetails->userDetail->height }}</td>
                                </tr>

                                <tr>
                                    <td>Weight</td>
                                    <td>{{ $userDetails->userDetail->weight }}</td>
                                </tr>

                                <tr>
                                    <td>Relatives in Malaysia </td>
                                    <td>{{ $userDetails->userdetail->has_relatives_in_malaysia == 1 ? ' ✔' : '𐤕' }}</td>
                                </tr>

                                <tr>
                                    <td>Accident</td>
                                    <td>{{ $userDetails->userdetail->has_been_in_accident == 1 ? ' ✔' : '𐤕' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="padding:0;vertical-align:top;width:35%;">
                        <h3 class="inner-header">Passport Details</h3>
                        <table width="100%" class="passport-table">
                            <tbody>
                                <tr>
                                    <td>Passport No.</td>
                                    <td>{{ $userDetails->passportDetail->passport_number }}</td>
                                </tr>
                                <tr>
                                    <td>Date of Issue</td>
                                    <td>{{ $userDetails->passportDetail->passport_issue_date}}</td>
                                </tr>
                                <tr>
                                    <td>Date of Expiry</td>
                                    <td>{{ $userDetails->passportDetail->expiry_date }}</td>
                                </tr>
                                <tr>
                                    <td>Place of Issue</td>
                                    <td>{{ $userDetails->passportDetail->issue_place }}</td>
                                </tr>
                                <tr>
                                    <td>Age</td>
                                    <td>{{ $userDetails->userDetail->age }}</td>
                                </tr>
                                <tr>
                                    <td>Date of Birth</td>
                                    <td>
                                    {{$userDetails->userDetail->dob}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <h3 style="margin-top:10px;" class="inner-header">Educational Qualification</h3>
                        <table width="100%" border="1">
                            <tbody>
                                <tr>
                                    <td>Level</td>
                                    <td>Level</td>
                                    <td>Tick: (✔)</td>
                                </tr>
                                @foreach ($educationTypes as $type)
                                    <tr>
                                        <!-- Display the education type name -->
                                        <td>{{ $type->name }}</td>
                                        <td>
                                            @php
                                                $hasQualification = false;
                                            @endphp

                                                <!-- Iterate through the user's educational qualifications. This works even if the user has only one qualification. -->
                                            @if ($userDetails->educationalQualification->edu_level == $type->edu_level)
                                                @php
                                                    $hasQualification = true;
                                                @endphp
                                                ✔
                                                @break {{-- Stop checking once a match is found --}}
                                            @endif

                                            <!-- If no matching qualification was found, display a dash -->
                                            @if (!$hasQualification)
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="language-details">
        <table width="100%">
            <tbody>
                <tr>
                    <td style="padding:0;vertical-align:top;padding-right:15px;width:65%;">
                        <h3 class="inner-header">Language Known: Tick (✔)</h3>
                        <table border="1" width="100%">
                            <tbody>
                            @foreach ($languages as $language)
                                <tr>
                                    <td>{{ $language->name }}</td>
                                    <td>
                                        @php
                                            $hasLanguage = false;
                                        @endphp
                                        @foreach ($userDetails->languageDetail as $detail)
                                            @if ($detail->language_name == $language->id)
                                                @php
                                                    $hasLanguage = true;
                                                @endphp
                                                ✔
                                                @break {{-- Ensures we stop the loop once a match is found --}}
                                            @endif
                                        @endforeach
                                        @if (!$hasLanguage)
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <h3 style="margin-top:10px;" class="inner-header">Work Experience</h3>
                        <table width="100%" border="1">
                            <tbody>
                                <tr>
                                    <td>S.No.</td>
                                    <td>Name of Company</td>
                                    <td>Post</td>
                                    <td>Country</td>
                                    <td>Duration</td>
                                    <td>Remarks</td>
                                </tr>

                                @if (!$userDetails->workExperience->isEmpty())
                                    @foreach($userDetails->workExperience as $exp)
                                        <tr class="prev-work-detail">
                                            <td>1</td> <!-- More conventional way to handle index increment -->
                                            <td>{{ $exp->company_name }}</td>
                                            <td>{{ $exp->position }}</td>
                                            <td>{{ $exp->country }}</td>
                                            <td>{{ $exp->no_of_years }}</td>
                                            <td> {{$exp->description}}</td> <!-- Assuming this is intentionally left empty for future use -->
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" style="text-align: center">No Work Experience</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </td>
                    <td style="padding:0;vertical-align:top;width:35%;">
                        <h3 class="inner-header">Interview Comment</h3>
                        <table width="100%" class="passport-table">
                            <tbody>
                                <tr>
                                    <td
                                        style="height: 328px;
                                            vertical-align: top;
                                            position: relative;">
                                        @if ($userDetails->comment)
                                            <p>
                                                {{ $userDetails->comment->comment }}
                                            </p>
                                        @else
                                            <p></p>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="training-details">
        <h3 class="inner-header">Training & Technical Knowledge, if Any</h3>
        <ul>
            <li>1. </li>
            <li>2. </li>
            <li>3. </li>
        </ul>
    </div>
    <div class="footer-details">
        <table width="100%">
            <tbody>
                <tr>
                    <td>
                        <span>(Applicant Sign)</span>
                    </td>
                    <td style="text-align: right;">
                        <span>(Authorised Sign)</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        window.print();
        window.onafterprint = back;

        function back() {
            window.close();
        }
    </script>
</body>

</html>
