@extends('layouts.app')
@section('content')
<style type="text/css">
    .owl-dots {
        display: none;
    }
</style>
<main class="dashboard">
	<div class="container-fluid">
		<div class="row">
			@include('common.sidebar')
			<!-- /. Sidebar-->
			<section class="main col-sm-12">
				@include('profile.menu')
                <div class="main__content certificate_process">
                    <div class="row">

                        <div class="col-md-12 certificate_details">
                            <h3><span>{{!empty($certificate_details['student_name'])?$certificate_details['student_name']:""}}</span></h3>
                            <h4>{{!empty($certificate_details['level_title'])?$certificate_details['level_title']:""}}
                                <span>{{!empty($certificate_details['course_title'])?$certificate_details['course_title']:""}}</span>
                                </h4>
                            <h5>Certificate Details</h5>
                        </div>
                        <div class="col-md-10 offset-md-1">
                        <?php 
                         $statusClass = "done";
                         $activeClass="active";
                         $ieuk_status="";
                         $access_status="";
                         $pending_status="";
                         $academy_status="";
                            if(isset($certificate_details['pending_status']) && !empty($certificate_details['pending_status'])){
                                $pending_status = "done";
                                $academy_status="active";
                            }else{
                                $pending_status = "";
                                $academy_status="";
                            }
                            if(isset($certificate_details['academy_verification']) && !empty($certificate_details['academy_verification'])){
                                $academy_status = "done";
                                $ieuk_status="active";
                            }
                            if(isset($certificate_details['ieuk_verification']) && !empty($certificate_details['ieuk_verification'])){
                                $ieuk_status = "done";
                                $access_status="active";
                            }
                            if(isset($certificate_details['certificate_number']) && !empty($certificate_details['certificate_number'])){
                                $access_status = "done";
                                
                            }
                        ?>
                            <ol class="progress_status ieukc-process" data-steps="3">
                                <li class="{{$pending_status}}">
                                    <span class="step"></span>
                                </li>
                                <li class="{{$ieuk_status}}">
                                    <span class="step"></span>
                                </li>
                                <li class="{{$access_status}}">
                                    <span class="step"></span>
                                </li>
                            </ol>
                            <ol class="progress_status ieukc-getcerty" data-steps="3">
                                <li class="{{$pending_status}}">
                                    <span class="name">Course<br> Pending</span>
                                    @if(empty($certificate_details['pending_status']))
                                        <span class="psp"><img src="{{ asset('public/images/waiting-process.png') }}" alt=""></span>
                                    @else
                                        <span class="psp"><img src="{{ asset('public/images/ieuk-verification.png') }}" alt=""></span>
                                    @endif
                                </li>
                                <li class="{{$ieuk_status}}">
                                    <span class="name">IEUK<br> Verification</span>
                                    @if(empty($certificate_details['pending_status']))
                                        <span class="psp"><img src="{{ asset('public/images/waiting-process.png') }}" alt=""></span>
                                    @else
                                        <span class="psp"><img src="{{ asset('public/images/ieuk-verification.png') }}" alt=""></span>
                                    @endif
                                </li>
                                <li  class="{{$access_status}}">
                                    <span class="name">Access<br> Certificate</span>
                                    @if(empty($certificate_details['pending_status']) OR $certificate_details['skip_status'] == 1)
                                        <span class="psp"><img src="{{ asset('public/images/waiting-process.png') }}" alt=""></span>
                                    @else
                                        <span class="psp"><img src="{{ asset('public/images/ieuk-verification.png') }}" alt=""></span>
                                    @endif
                                </li>
                            </ol>
                        </div>
                    </div>
                    @if(!empty($certificate_details['certificate_number']))
                     @if( $certificate_details['skip_status'] == 1)
                        <div class="row mt-5">
                         <div class="col-md-12 offset-md-4">
                            <div class="row" align="center">
                                    <h2 style="color: red;">Academy Skipped Certificate Approval</h2>
                            </div>
                        </div>
                        </div>
                     @else
                        <div class="row mt-5">
                        	<div class="col-md-6 offset-md-3">
                        		<div class="row">
                        		<div class="col-4 text-left col-md-4">
    	                    		<a href="javascript:void(0)" class="ieukcd-btn btn btn-primary " data-toggle="modal"  data-target="#student_certificate">View</a>
    	                    	</div>
    	                    	<div class="col-4 text-center col-md-4">
    	                    		<a href="{{$certificate_details['certificate_url']}}" class="ieukcd-btn btn btn-primary " target="_blank"  download>Download</a>
    	                    	</div>
    	                    	<div class="col-4 text-right col-md-4">
    	                    		<a href="https://www.imperial-english.com/verification.php" class=ieukcd-btn "btn btn-primary " >Verify</a> <!--data-toggle="modal" data-target="#student_certificate_verification" -->
    	                    	</div>
    	                    </div>
                        	</div>
                        </div>
                        <script>
                        $(document).ready(function() {
                         PDFObject.embed("{{$certificate_details['certificate_url']}}", "#pdf-view-popup",{height: "60rem"});
                        });
                        </script>
                     @endif
                    @endif
                        <!-- <div class="row">
                            <div class="col-12 col-xl-5 assessment">
                                <h2>
                                    General English
                                    <span class="text-uppercase">PRE-INTERMEDIATE</span>
                                </h2>

                                <div class="assessment__block done">
                                    <h4>Complete Assessment</h4>
                                </div>

                                <div class="assessment__block done">
                                    <h4>Final Result</h4>
                                </div>

                                <div class="assessment__block active">
                                    <h4>Certificate</h4>
                                    <div class="assessment__block_result d-flex flex-wrap align-items-center">
                                        <div class="icon">
                                            <img src="images/icon-certificate.svg" alt="" class="img-fluid">
                                        </div>
                                        <h5>Congratulations! <br> your certificate is generated.</h5>
                                    </div>

                                    <ul class="list-unstyled">
                                        <li class="list-item d-flex flex-wrap align-items-center">
                                            <span>Student Name:</span>
                                            <strong>John Doe</strong>
                                        </li>
                                        <li class="list-item d-flex flex-wrap align-items-center">
                                            <span>IEUK Student ID:</span>
                                            <strong>ASSB123AD2</strong>
                                        </li>
                                        <li class="list-item d-flex flex-wrap align-items-center">
                                            <span>Course:</span>
                                            <strong>GES</strong>
                                        </li>
                                        <li class="list-item d-flex flex-wrap align-items-center">
                                            <span>Level:</span>
                                            <strong>Pre-Intermediate</strong>
                                        </li>
                                        <li class="list-item d-flex flex-wrap align-items-center">
                                            <span>Certificate Number:</span>
                                            <strong>ABSBAS211</strong>
                                        </li>
                                        <li>Online verification Link:</li>
                                        <li>
                                            <a href="javascript:void(0)" class="btn  btn-primary">Online
                                                Verification</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-12 col-xl-2 verticle-line"></div>
                            <div class="col-12 col-xl-5 assessment">
                                <h2>
                                    Academic English
                                    <span class="text-uppercase">PRE-INTERMEDIATE</span>
                                </h2>

                                <div class="assessment__block done">
                                    <h4>Complete Assessment</h4>
                                </div>

                                <div class="assessment__block done">
                                    <h4>Final Result</h4>

                                </div>

                                <div class="assessment__block done">
                                    <h4>Certificate</h4>
                                </div>
                            </div>

                        </div> -->
                    </div>
                </section>
		</div>
	</div>
</main>

<div class="modal fade" id="student_certificate" tabindex="-1" role="dialog" aria-labelledby="cpd-policy-modalLabel"
                        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header flex-wrap">
                    <div class="modal-header-top d-flex flex-wrap justify-content-center align-items-center w-100 mb-4">
                        <h4 class="modal-title" id="cpd-policy-modalLabel">
                                
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="{{ asset('public/images/icon-close-modal.svg') }}" alt="close" class="img-fluid">
                        </button>
                    </div>
                    <!-- /. Modal Header top-->
                </div>
                <div class="modal-body text-center border-0">
                    <div id="pdf-view-popup"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="student_certificate_verification" tabindex="-1" role="dialog" aria-labelledby="cpd-policy-modalLabel"
                        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header flex-wrap">
                    <div class="modal-header-top d-flex flex-wrap justify-content-center align-items-center w-100 mb-4">
                        <h4 class="modal-title" id="cpd-policy-modalLabel">
                                
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="{{ asset('public/images/icon-close-modal.svg') }}" alt="close" class="img-fluid">
                        </button>
                    </div>
                    <!-- /. Modal Header top-->
                </div>
                <div class="modal-body text-center border-0"><br>
                    <iframe src="https://www.imperial-english.com/verification.php" title="description" style="width:100%; height:500px"> </iframe>
                </div>
            </div>
        </div>
    </div>
    
     
@endsection