@extends('layouts.app')
@section('content')
<main class="main pl-0">
        <div class="container-fluid">
            <div class="row">
                @include('common.sidebar')
                <section class="main col-sm-12">
                <div class="main__content custom-content w-100">
                    <div class="portfolio-heading d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="index.html"><img src="/public/images/logo-blue.svg" alt="Imperial English UK"
                                    class="img-fluid"></a>
                        </div>
                        <h1 class="mb-0 d-flex align-items-center">
                            <span><img src="public/images/icon-portfolio-assessment.svg" alt="Portfolio Assessment"
                                    class="img-fluid mr-4"></span> Portfolio Assessment Verification - STUDENT ID
                        </h1>

                        <div class="logout">
                            <a href="portfolio-verifier.html">Back</a>
                        </div>
                    </div>
                    <!-- /. Portfolio Heading-->
                </div>

                <div class="main__content portfolio-blank mt-5 w-100">
                    <div class="row flex-wrap verification mr-auto ml-auto">
                        <div class="col-12 col-lg-6 assessment-result border-right">
                            <h2><strong>General English <br>
                                    Portfolio Assessment</strong></h2>
                            <div class="result-box">
                                <h3>Criteria 1 - Submission </h3>
                                <div class="bar d-flex flex-wrap">
                                    <div class="bar-left">
                                        <div class="progress">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span>Minimum requirement 80% </span>
                                    </div>

                                    <div class="progress-value">
                                        <h4>35%</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- /. Result Box-->
                            <div class="result-box">
                                <h3>Criteria 2 - Achievement</h3>
                                <div class="bar d-flex flex-wrap">
                                    <div class="bar-left">
                                        <div class="progress">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span>Minimum requirement 50% </span>
                                    </div>

                                    <div class="progress-value">
                                        <h4>35%</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- /. Result Box-->

                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="#!" class="btn btn-lg btn-danger">View
                                        Portfolio</a></li>
                                <li class="list-inline-item"><a href="#!" class="btn btn-lg btn-danger">View Work
                                        Record</a></li>
                            </ul>
                        </div>
                        <div class="col-12 col-lg-6 assessment-result">
                            <h2><strong>Academic English <br>
                                    Portfolio Assessment</strong></h2>
                            <div class="result-box">
                                <h3>Criteria 1 - Submission </h3>
                                <div class="bar d-flex flex-wrap">
                                    <div class="bar-left">
                                        <div class="progress">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span>Minimum requirement 80% </span>
                                    </div>

                                    <div class="progress-value">
                                        <h4>35%</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- /. Result Box-->
                            <div class="result-box">
                                <h3>Criteria 2 - Achievement</h3>
                                <div class="bar d-flex flex-wrap">
                                    <div class="bar-left">
                                        <div class="progress">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span>Minimum requirement 50% </span>
                                    </div>

                                    <div class="progress-value">
                                        <h4>35%</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- /. Result Box-->

                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="#!" class="btn btn-lg btn-danger">View
                                        Portfolio</a></li>
                                <li class="list-inline-item"><a href="#!" class="btn btn-lg btn-danger">View Work
                                        Record</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                </section>
            </div>
        </div>
    </main>
@endsection