
<style>
    body {
        margin: 0;
        padding: 0;
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
        margin-top: 5px;
    }

    .contact-details ul li span {
        display: inline-block;
        vertical-align: top;
    }

    .contact-details ul li i {
        height: 20px;
        width: 20px;
        line-height: 20px;
        text-align: center;
        border: 1px solid #000;
        margin-left: 10px;
        font-size: 14px;
    }

    .cantidate-head {
        border-bottom: 12px solid #6a6a6a;
        padding-bottom: 10px;
    }

    .logo {
        height: 110px;
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
        font-size: 30px;
        text-transform: uppercase;
        font-weight: 700;
        background: #6a6a6a;
        display: inline-block;
        padding: 7px 10px;
        color: #fff;
        border-radius: 5px;
        letter-spacing: 1px;
    }

    .top-details {
        margin-top: 50px;
        text-align: center;
        margin-bottom: 20px;
        position: relative;
    }

    .profile-img {
        position: absolute;
        top: -30px;
        right: 0;
    }

    .profile-img img {
        height: 150px;
        width: 150px;
        object-fit: cover;
    }

    .inner-header {
        font-size: 20px;
        margin: 0;
        margin-bottom: 10px;
        background: #6a6a6a;
        color: #fff;
        display: inline-block;
        padding: 7px 15px;
        border-radius: 50px;
    }

    .personal-details table td {
        padding: 5px 10px;
    }

    .passport-table {
        border: 1px solid gray;
    }

    .language-details table td {
        padding: 5px 10px;
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
        border-bottom: 3px dotted gray;
    }

    .training-details ul li+li {
        margin-top: 20px;
    }

    .footer-details {
        margin-top: 50px;
    }

    .footer-details span {
        display: inline-block;
        border-top: 3px dotted gray;
        padding-top: 5px;
    }
</style>

<div class="card">
    <div class="card-header card-header-color">
        Candidate {{ $candidate->first_name . ' ' . $candidate->middle_name . ' ' . $candidate->last_name }}
        Detail
    </div>
    <div class="card-body scroll-card">
        <a href="{{ route('candidate.printCandidateApplication', $candidate->id) }}" target="_blank"><button class="btn btn-sm btn-primary" style="margin-bottom: 15px !important;">Print/ Save Application</button></a>
        <div class="cantidate-head">
            <table width="100%">
                <tbody>
                    <tr>
                        <td>
                            Govt. Lic. No.: 1171/073/074<br>
                            <img src="{{ asset('assets/images/logo.png') }}" alt="logo" class="logo">
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
                        <td>{{ \Carbon\Carbon::parse($candidate->created_at)->toDateString() }}</td>
                    </tr>
                    <tr>
                        <td>Applied Country:</td>
                        <td> {{ $candidate->companies[0]->originCountry->code . ' | ' . $candidate->companies[0]->originCountry->name. ' || '.$candidate->companies[0]->name. ' || '.$candidate->demand->demand_code }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="profile-img">
                @if (@$candidate->profile)
                    <img src="{{ url('/storage/public/uploads/candidate-profiles/' . @$candidate->profile) }}"
                        alt="images">
                @else
                    <img src="{{ asset('no-profile.jpg') }}" alt="images">
                @endif
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
                                        <td>{{ $candidate->first_name . ' ' . $candidate->middle_name . ' ' . $candidate->last_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Father's Name</td>
                                        <td>{{ $candidate->father_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Mother's Name</td>
                                        <td>{{ $candidate->mother_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Spouse Name</td>
                                        <td>{{ $candidate->spouse_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Permanent Address</td>
                                        <td>{{ $candidate->permanent_address }}</td>
                                    </tr>
                                    <tr>
                                        <td>Temporary Address</td>
                                        <td>{{ $candidate->temp_address }}</td>
                                    </tr>
                                    <tr>
                                        <td>Contact No.</td>
                                        <td>{{ $candidate->contact }}</td>
                                    </tr>
                                    <tr>
                                        <td>E-mail</td>
                                        <td>{{ $candidate->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nationality</td>
                                        <td>{{ $candidate->nationality }}</td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td>{{ $candidate->weight }}</td>
                                    </tr>
                                    <tr>
                                        <td>Marital Status</td>
                                        <td>{{ $candidate->marital_status }}</td>
                                    </tr>
                                    <tr>
                                        <td>Height</td>
                                        <td>{{ $candidate->height }}</td>
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
                                        <td>{{ @$candidate->passportDetails->passport_no }}</td>
                                    </tr>
                                    <tr>
                                        <td>Date of Issue</td>
                                        <td>{{ @$candidate->passportDetails->passport_issue_date }}</td>
                                    </tr>
                                    <tr>
                                        <td>Date of Expiry</td>
                                        <td>{{ @$candidate->passportDetails->passport_expiry_date }}</td>
                                    </tr>
                                    <tr>
                                        <td>Place of Issue</td>
                                        <td>{{ @$candidate->passportDetails->passport_issue_country }}</td>
                                    </tr>
                                    <tr>
                                        <td>Place of Birth</td>
                                        <td>{{ @$candidate->passportDetails->place_of_birth }}</td>
                                    </tr>
                                    <tr>
                                        <td>Date of Birth</td>
                                        <td>
                                            @if(@$candidate->date_of_birth_en)
                                                {{ \Carbon\Carbon::parse(@$candidate->date_of_birth_en)->format('d M, Y') }}
                                            @else
                                            --
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <h3 style="margin-top:10px;" class="inner-header">Educational Qualification</h3>
                            <table width="100%" border="1">
                                <tbody>
                                    <tr>
                                        <td>Level</td>
                                        <td>Division</td>
                                        <td>Tick: (✔)</td>
                                    </tr>
                                    @foreach ($educationalQualifications as $key => $val)
                                        <tr>
                                            <td>{{ $val }}</td>
                                            <td>-</td>
                                            <td>
                                                @foreach (@$candidate->educations as $edu)
                                                    @if ($edu->education == $val)
                                                        ✔
                                                    @endif
                                                @endforeach
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
                                    <tr>
                                        <td rowspan="2">Language</td>
                                        @foreach ($languageSkills as $key => $lan)
                                            <td colspan="{{ count($languageSkillLevels) }}"
                                                style="text-align: center;">{{ ucfirst($lan) }}</td>
                                        @endforeach
                                        {{-- <td colspan="3" style="text-align: center;">Speak</td>
                                        <td colspan="3" style="text-align: center;">Read</td>
                                        <td colspan="3" style="text-align: center;">Write</td> --}}
                                    </tr>
                                    <tr>
                                        @for ($i = 0; $i < count($languageSkills); $i++)
                                            @foreach ($languageSkillLevels as $key => $level)
                                                <td>{{ ucfirst($level) }}</td>
                                            @endforeach
                                        @endfor
                                    </tr>
                                    @foreach ($languages as $key => $val)
                                        <tr class="center-td">
                                            <td style="text-align: left;">{{ ucfirst($val) }}</td>
                                            @foreach ($languageSkills as $key => $skill)
                                                @foreach ($languageSkillLevels as $key => $level)
                                                    @php
                                                        $sValue = \App\Models\CandidateLanugageSkill::candidateSkill(@$candidate->id, $val, $skill, $level);
                                                    @endphp
                                                    <td>
                                                        @if (@$sValue == true)
                                                            ✔
                                                        @else
                                                        @endif
                                                    </td>
                                                @endforeach
                                            @endforeach
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
                                    @if (!@$candidate->workExperiences->isEmpty())
                                        @foreach (@$candidate->workExperiences as $k => $exp)
                                            <tr class="prev-work-detail">
                                                <td>{{ ++$k }}</td>
                                                <td>{{ $exp->company_name }}</td>
                                                <td>{{ $exp->post }}</td>
                                                <td>{{ $exp->country }}</td>
                                                <td>{{ $exp->duration }}</td>
                                                <td></td>
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

                                            <p>
                                                {{ @$candidate->interview->interview_comment }}
                                            </p>

                                            {{-- <br>
                                            <b style="display: block;margin-top:15px;position: absolute;bottom: 10px;">Application
                                                Approve By: Sandeep
                                                Shrestha</b> --}}
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
    </div>
</div>