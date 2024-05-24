@extends('frontend.layout')

@section('title')
    Recruitment | {{ config('app.name') }}
@endsection
@section('content')
    <!-- Banner  -->
    <section class="page-banner"
        style="background-image:url('{{ @$webContent->about_us_banner ? url('/storage/public/uploads/web-images/' . @$webContent->about_us_banner) : asset('web/img/slider1.jpg') }}');">
        <div class="container">
            <div class="page-banner-wrap">
                <h1>Recruitment</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Recruitment</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Banner End  -->

    <!-- Recruitment Page  -->
    <section class="recruitment-page mt mb">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12">
                    <div class="recruit-content">
                        <h2>How We Recruit?</h2>
                        <span>
                            When you reach out to us to fulfill your recruitment need, we take the following steps to
                            ensure that you get the right person for the job. On time without any hassle.
                        </span>
                        <ol>
                            <li>We use our own up-to-date databank as well as publish advertisements in the national
                                newspapers and social media handles to collect applications of qualified candidates.</li>
                            <li>Applications&nbsp; are scrutinized by our committee&nbsp; as per the client’s requirements.
                            </li>
                            <li>Short listed candidates’ CVs are sent to the employer for their consideration.</li>
                            <li>Interview and final selection of the candidates is carried out by the employer. We provide
                                all the assistance and handle logistics.<strong><br>
                                    Medical Examination:</strong></li>
                            <li>Selected candidates will have a medical examination in an authorized hospital or clinic.
                                Only candidates found medically fit for foreign employment are sent for&nbsp; further visa
                                process.</li>
                        </ol>
                        <p>
                            <strong>*Ticketing and Immigration Clearance:</strong> The employer is required to provide PTA
                            for the selected
                            candidates or in case traveling expenses are borne by the candidates themselves, TGRE will
                            obtain necessary Immigration Clearance from the Department of Labour and complete all
                            formalities required for departure.
                        </p>
                        <p>

                            <strong>*Orientation before departure:</strong> We provide basic orientation to all the
                            candidates before
                            traveling abroad. During the orientation, they are informed about their duties and
                            responsibilities, working environment while abroad and other salient features about the laws of
                            the country of employment.
                        </p>

                        <strong>Guarantees:</strong>
                        <p>
                            <strong>*TGRE</strong> takes full responsibility to deploy manpower (workers) in time except
                            under
                            unavailability
                            of air tickets or other unforeseen circumstances that are not under our control.
                        </p>
                        <p>
                            <strong>*TGRE</strong> is liable to take back the technically unfit and unable workers if found
                            so
                            by the
                            employer.
                        </p>
                        <ul>
                            <li>We use our own up-to-date databank as well as publish advertisements in the national
                                newspapers and social media handles to collect applications of qualified candidates.</li>
                            <li>Applications&nbsp; are scrutinized by our committee&nbsp; as per the client’s requirements.
                            </li>
                            <li>Short listed candidates’ CVs are sent to the employer for their consideration.</li>
                            <li>Interview and final selection of the candidates is carried out by the employer. We provide
                                all the assistance and handle logistics.<strong><br>
                                    Medical Examination:</strong></li>
                            <li>Selected candidates will have a medical examination in an authorized hospital or clinic.
                                Only candidates found medically fit for foreign employment are sent for&nbsp; further visa
                                process.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12">
                    <div class="recruit-list">
                        <div class="recruitment-list-point">
                            <div class="recruitment-list-content">
                                <h3>Week 1</h3>
                                <ul>
                                    <li>Client Inquiry</li>
                                    <li>CV Collection</li>
                                    <li>Draft legal documents</li>
                                </ul>
                            </div>
                            <div class="recruitment-icon">
                                <i class="las la-file-signature"></i>
                            </div>
                        </div>
                        <div class="recruitment-list-point">
                            <div class="recruitment-list-content">
                                <h3>Week 2</h3>
                                <ul>
                                    <li>Client Inquiry</li>
                                    <li>CV Collection</li>
                                    <li>Draft legal documents</li>
                                </ul>
                            </div>
                            <div class="recruitment-icon">
                                <i class="las la-user-tie"></i>
                            </div>
                        </div>
                        <div class="recruitment-list-point">
                            <div class="recruitment-list-content">
                                <h3>Week 3</h3>
                                <ul>
                                    <li>Client Inquiry</li>
                                    <li>CV Collection</li>
                                    <li>Draft legal documents</li>
                                </ul>
                            </div>
                            <div class="recruitment-icon">
                                <i class="las la-briefcase-medical"></i>
                            </div>
                        </div>
                        <div class="recruitment-list-point">
                            <div class="recruitment-list-content">
                                <h3>Week 4</h3>
                                <ul>
                                    <li>Client Inquiry</li>
                                    <li>CV Collection</li>
                                    <li>Draft legal documents</li>
                                </ul>
                            </div>
                            <div class="recruitment-icon">
                                <i class="lab la-telegram-plane"></i>
                            </div>
                        </div>
                        <div class="recruitment-list-point">
                            <div class="recruitment-list-content">
                                <h3>Disclaimer</h3>
                                <ul>
                                    <li>Client Inquiry</li>
                                    <li>CV Collection</li>
                                    <li>Draft legal documents</li>
                                </ul>
                            </div>
                            <div class="recruitment-icon">
                                <i class="las la-file-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Recruitment Page End  -->

    {{-- <section class="extra-documents pt pb">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-12">
                    <div class="extra-document-images">
                        <div class="extra-document">
                            <div class="extra-document-item">
                                <img src="{{ asset('web/img/d1.jpg') }}" alt="images">
                            </div>
                            <div class="extra-document-item">
                                <img src="{{ asset('web/img/d1.jpg') }}" alt="images">
                            </div>
                            <div class="extra-document-item">
                                <img src="{{ asset('web/img/d1.jpg') }}" alt="images">
                            </div>
                            <div class="extra-document-item">
                                <img src="{{ asset('web/img/d1.jpg') }}" alt="images">
                            </div>
                            <div class="extra-document-item">
                                <img src="{{ asset('web/img/d1.jpg') }}" alt="images">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12">
                    <div class="recruit-content">
                        <h2>Five Legal Documents</h2>
                        <span>
                            In order to get pre-approval from the department of labor we require the following documents.
                        </span>
                        <ol>
                            <li>We use our own up-to-date databank as well as publish advertisements in the national
                                newspapers and social media handles to collect applications of qualified candidates.</li>
                            <li>Applications&nbsp; are scrutinized by our committee&nbsp; as per the client’s requirements.
                            </li>
                            <li>Short listed candidates’ CVs are sent to the employer for their consideration.</li>
                            <li>Interview and final selection of the candidates is carried out by the employer. We provide
                                all the assistance and handle logistics.<strong><br>
                                    Medical Examination:</strong></li>
                            <li>Selected candidates will have a medical examination in an authorized hospital or clinic.
                                Only candidates found medically fit for foreign employment are sent for&nbsp; further visa
                                process.</li>
                        </ol>
                        <p>
                            <strong>*Ticketing and Immigration Clearance:</strong> The employer is required to provide PTA
                            for the selected
                            candidates or in case traveling expenses are borne by the candidates themselves, TGRE will
                            obtain necessary Immigration Clearance from the Department of Labour and complete all
                            formalities required for departure.
                        </p>
                        <p>

                            <strong>*Orientation before departure:</strong> We provide basic orientation to all the
                            candidates before
                            traveling abroad. During the orientation, they are informed about their duties and
                            responsibilities, working environment while abroad and other salient features about the laws of
                            the country of employment.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
@endsection
