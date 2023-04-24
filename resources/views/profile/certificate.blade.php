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
                   {{--  <div class="row"> --}}
                    <ul class="aes_ges_parent nav nav-pills nav-pills_switch" id="pills-tab" role="tablist">
                        <?php $i = 0; ?>
                       @if(count($certificate_details) >= 1)
                            @foreach($certificate_details as $key=>$student)
                                @foreach($student['data'] as $group)
                                    @foreach($group as $sorting)
                                        @foreach($sorting['level'] as $level)
                                            @foreach($level['courses'] as $key => $course)
                                                @if($course['academy_award_single'] == 'group')
                                                    @if($loop->first)
                                                        <li class="nav-item mr-2 mb-2">
                                                            <a class="nav-link @if($i == 0) active show @endif checkparent tab_change" data="{{$course['course_id']}}" id="pills-{{$course['course_id']}}-tab" data-toggle="pill" href="#pills-{{$course['course_id']}}" data-index="{{$course['course_id']}}" data-url="{{(isset($course['certificate']) ? (env('S3URL').$course['certificate']):'')}}" role="tab" aria-controls="pills-{{$course['course_id']}}" aria-selected="true">{{$course['course_name']}}</a>
                                                        </li>
                                                    @endif
                                                @else
                                                    <li class="nav-item mr-2 mb-2">
                                                        <a class="nav-link @if($i == 0)  active show @endif checkparent tab_change" data="{{$course['course_id']}}" id="pills-{{$course['course_id']}}-tab" data-toggle="pill" href="#pills-{{$course['course_id']}}" data-index="{{$course['course_id']}}" role="tab" aria-controls="pills-{{$course['course_id']}}" aria-selected="true" data-url="{{(isset($course['certificate']) ? (env('S3URL').$course['certificate']):'')}}">{{$course['course_name']}}</a>
                                                    </li>
                                                @endif
                                                <?php $i++ ?>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endif
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <?php $i = 0; ?>
                        {{-- @dd($certificate_details) --}}
                        @if(count($certificate_details) >= 1)
                            @foreach($certificate_details as $key=>$student)
                                @foreach($student['data'] as $group)
                                    @foreach($group as $sorting)
                                        @foreach($sorting['level'] as $level)
                                            @foreach($level['courses'] as $course)
                                                <div class="tab-pane fade  @if($i == 0) show active @endif" id="pills-{{$course['course_id']}}" role="tabpanel" aria-labelledby="pills-{{$course['course_id']}}-tab">
                                                    <div class="col-md-12 certificate_details">
                                                        <?php $levels =  collect(collect($level)['courses'])->pluck('level_name')->toArray() ;
                                                        $course_name =  collect(collect($level)['courses'])->pluck('course_name')->toArray() ;
                                                        $level_title = []; ?>
                                                        @foreach($levels as $level1)
                                                            @if(!in_array($level1,$level_title))
                                                                <?php $level_title[] = $level1 ?>
                                                            @endif
                                                        @endforeach
                                                        @if($course['academy_award_single'] == 'group')
                                                            @if($loop->first)
                                                                <h3><span>{{!empty($course['student_name'])?$course['student_name']:""}}</span></h3>
                                                                <h4>{{!empty($level_title) ? implode(',', $level_title) : ""}}  </h4>
                                                                <h5>{{!empty($course_name) ? implode(',', $course_name) : ""}}</h5>
                                                                <h5>Certificate Details</h5>

                                                                <div class="col-md-10 offset-md-1">
                                                                    <?php 
                                                                         $statusClass = "done";
                                                                         $activeClass="";
                                                                         $ieuk_status="";
                                                                         $access_status="";
                                                                         $pending_status="";
                                                                         $academy_status="";
                                                                    ?>
                                                                    @if($course['status'] == 'Course Pending')
                                                                        <?php 
                                                                            $pending_status = "done";
                                                                            $ieuk_status="";
                                                                        ?>
                                                                    @elseif($course['final_status'] == 'Approved')
                                                                        <?php 
                                                                            $pending_status = "done";
                                                                            $ieuk_status = "done";
                                                                            $academy_status = "done";
                                                                            $access_status="done";
                                                                        ?>
                                                                    @elseif($course['status'] == 'Pending IEUK Verification' || $course['status'] == 'Fail')
                                                                        <?php 
                                                                            $pending_status = "done";
                                                                            $ieuk_status = "done";
                                                                            $academy_status="";
                                                                        ?>
                                                                    @elseif($course['status'] == 'IEUK Approved' || $course['status'] == 'IEUK Disapproved')
                                                                        <?php 
                                                                            $pending_status = "done";
                                                                            $ieuk_status = "done";
                                                                            $academy_status = "done";
                                                                            $access_status="";
                                                                        ?>
                                                                    @elseif($course['final_status'] == 'Approved')
                                                                        <?php 
                                                                            $access_status="done";
                                                                        ?>
                                                                    @endif
                                                                    <ol class="progress_status ieukc-process" data-steps="3">
                                                                        <li class="{{$pending_status}}">
                                                                            <span class="step"></span>
                                                                        </li>
                                                                        <?php if($course['status'] == 'Fail'){?>
                                                                            <style>
                                                                            ol.progress_status[data-steps="3"] li {
                                                                                width: 33%;
                                                                            }
                                                                            </style>
                                                                            <?php }?>
                                                                        @if($course['status']=='IEUK Approved')
                                                                        <li class="{{$ieuk_status}}">
                                                                            <span class="step"></span>
                                                                        </li>
                                                                        @endif
                                                                         <li class="{{$academy_status}}">
                                                                            <span class="step"></span>
                                                                        </li>
                                                                        <li class="{{$access_status}}">
                                                                            <span class="step"></span>
                                                                        </li>
                                                                    </ol>
                                                                    <ol class="progress_status ieukc-getcerty" data-steps="3">
                                                                        <li class="{{$pending_status}}">
                                                                            <span class="name">Course<br> Pending</span>
                                                                            @if(empty($pending_status))
                                                                                <span class="psp"><img src="{{ asset('public/images/waiting-process.png') }}" alt=""></span>
                                                                            @else
                                                                                <span class="psp"><img src="{{ asset('public/images/ieuk-verification.png') }}" alt=""></span>
                                                                            @endif
                                                                        </li>
                                                                        @if($course['status']=='IEUK Approved')
                                                                        <li class="{{$ieuk_status}}">
                                                                            <span class="name">IEUK<br> Verification</span>
                                                                            @if(empty($ieuk_status))
                                                                                <span class="psp"><img src="{{ asset('public/images/waiting-process.png') }}" alt=""></span>
                                                                            @else
                                                                                <span class="psp"><img src="{{ asset('public/images/ieuk-verification.png') }}" alt=""></span>
                                                                            @endif
                                                                        </li> 
                                                                        @endif
                                                                        <li class="{{$academy_status}}">
                                                                            <span class="name">Academy<br> Verification</span>
                                                                            @if(empty($academy_status))
                                                                                <span class="psp"><img src="{{ asset('public/images/waiting-process.png') }}" alt=""></span>
                                                                            @else
                                                                                <span class="psp"><img src="{{ asset('public/images/ieuk-verification.png') }}" alt=""></span>
                                                                            @endif
                                                                        </li>
                                                                        <li  class="{{$access_status}}">
                                                                            <span class="name">Access<br> Certificate</span>
                                                                            @if(empty($access_status))
                                                                                <span class="psp"><img src="{{ asset('public/images/waiting-process.png') }}" alt=""></span>
                                                                            @else
                                                                                <span class="psp"><img src="{{ asset('public/images/ieuk-verification.png') }}" alt=""></span>
                                                                            @endif
                                                                        </li>
                                                                    </ol>
                                                                </div>
                                                                @if($course['final_status'] == 'Approved' && !empty($course['certificate'])) 
                                                                    <div class="mt-5">
                                                                        <div class="col-md-6 offset-md-3">
                                                                            <div class="row">
                                                                                <div class="col-4 text-left col-md-4">
                                                                                    <a href="javascript:void(0)" class="ieukcd-btn btn btn-primary " data-toggle="modal"  data-target="#student_certificate" style="max-width: 100%; width: 150px;">View</a>
                                                                                </div>
                                                                                <?php
                                                                                        $storage_link = env('S3URL').(isset($course['certificate']) ? $course['certificate']:'');
                                                                                    ?>
                                                                                <script>
                                                                               
                                                                                </script>
                                                                                <div class="col-4 text-center col-md-4">
                                                                                    
                                                                                    <a href="{{ $storage_link }}" class="ieukcd-btn btn btn-primary " target="_blank" style="max-width: 100%; width: 150px;" download>Download</a>
                                                                                </div>
                                                                                <div class="col-4 text-right col-md-4">
                                                                                    <a href="https://imperial-english.com/verification?no={{ $course['certificate_no'] ?? "" }}" target="_blank" class="ieukcd-btn btn btn-primary " style="max-width: 100%; width: 150px;">Verify</a> 
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @else
                                                            <h3><span>{{!empty($course['student_name'])?$course['student_name']:""}}</span></h3>
                                                            <h4>{{!empty($course['level_name']) ? $course['level_name'] : ""}}  </h4>
                                                            <h5>{{!empty($course['course_name']) ?  $course['course_name'] : ""}}</h5>
                                                            <h5>Certificate Details</h5>
                                                            <div class="col-md-10 offset-md-1">
                                                                <?php 
                                                                     $statusClass = "done";
                                                                     $activeClass="";
                                                                     $ieuk_status="";
                                                                     $access_status="";
                                                                     $pending_status="";
                                                                     $academy_status="";
                                                                ?>
                                                                @if($course['status'] == 'Course Pending')
                                                                    <?php 
                                                                        $pending_status = "done";
                                                                        $ieuk_status="";
                                                                    ?>
                                                                @elseif($course['final_status'] == 'Approved')
                                                                    <?php 
                                                                        $pending_status = "done";
                                                                        $ieuk_status = "done";
                                                                        $academy_status = "done";
                                                                        $access_status="done";
                                                                    ?>
                                                                @elseif($course['status'] == 'Pending IEUK Verification' || $course['status'] == 'Fail')
                                                                    <?php 
                                                                        $pending_status = "done";
                                                                        $ieuk_status = "done";
                                                                        $academy_status="";
                                                                    ?>
                                                                @elseif($course['status'] == 'IEUK Approved' || $course['status'] == 'IEUK Disapproved')
                                                                    <?php 
                                                                        $pending_status = "done";
                                                                        $ieuk_status = "done";
                                                                        $academy_status = "done";
                                                                        $access_status="";
                                                                    ?>
                                                                @elseif($course['final_status'] == 'Approved')
                                                                    <?php 
                                                                        $access_status="done";
                                                                    ?>
                                                                @endif
                                                                <ol class="progress_status ieukc-process" data-steps="3">
                                                                    <li class="{{$pending_status}}">
                                                                        <span class="step"></span>
                                                                    </li>
                                                                    <li class="{{$ieuk_status}}">
                                                                        <span class="step"></span>
                                                                    </li>
                                                                     <li class="{{$academy_status}}">
                                                                        <span class="step"></span>
                                                                    </li>
                                                                    <li class="{{$access_status}}">
                                                                        <span class="step"></span>
                                                                    </li>
                                                                </ol>
                                                                <ol class="progress_status ieukc-getcerty" data-steps="3">
                                                                    <li class="{{$pending_status}}">
                                                                        <span class="name">Course<br> Pending</span>
                                                                        @if(empty($pending_status))
                                                                            <span class="psp"><img src="{{ asset('public/images/waiting-process.png') }}" alt=""></span>
                                                                        @else
                                                                            <span class="psp"><img src="{{ asset('public/images/ieuk-verification.png') }}" alt=""></span>
                                                                        @endif
                                                                    </li>
                                                                    <li class="{{$ieuk_status}}">
                                                                        <span class="name">IEUK<br> Verification</span>
                                                                        @if(empty($ieuk_status))
                                                                            <span class="psp"><img src="{{ asset('public/images/waiting-process.png') }}" alt=""></span>
                                                                        @else
                                                                            <span class="psp"><img src="{{ asset('public/images/ieuk-verification.png') }}" alt=""></span>
                                                                        @endif
                                                                    </li> 
                                                                    <li class="{{$academy_status}}">
                                                                        <span class="name">Academy<br> Verification</span>
                                                                        @if(empty($academy_status))
                                                                            <span class="psp"><img src="{{ asset('public/images/waiting-process.png') }}" alt=""></span>
                                                                        @else
                                                                            <span class="psp"><img src="{{ asset('public/images/ieuk-verification.png') }}" alt=""></span>
                                                                        @endif
                                                                    </li>
                                                                    <li  class="{{$access_status}}">
                                                                        <span class="name">Access<br> Certificate</span>
                                                                        @if(empty($access_status))
                                                                            <span class="psp"><img src="{{ asset('public/images/waiting-process.png') }}" alt=""></span>
                                                                        @else
                                                                            <span class="psp"><img src="{{ asset('public/images/ieuk-verification.png') }}" alt=""></span>
                                                                        @endif
                                                                    </li>
                                                                </ol>
                                                            </div>
                                                            @if($course['final_status'] == 'Approved' && !empty($course['certificate'])) 
                                                                <div class="mt-5">
                                                                    <div class="col-md-6 offset-md-3">
                                                                        <div class="row">
                                                                            <div class="col-4 text-left col-md-4">
                                                                                <a href="javascript:void(0)" class="ieukcd-btn btn btn-primary " data-toggle="modal"  data-target="#student_certificate">View</a>
                                                                            </div>
                                                                            <?php
                                                                                        $storage_link = env('S3URL').(isset($course['certificate']) ? $course['certificate']:'');
                                                                                    ?>
                                                                                <script>
                                                                               
                                                                                </script>
                                                                            <div class="col-4 text-center col-md-4">
                                                                                <a href="{{ $storage_link }}" class="ieukcd-btn btn btn-primary " target="_blank"  download>Download</a>
                                                                            </div>
                                                                            <div class="col-4 text-right col-md-4">
                                                                                <a href="https://imperial-english.com/verification?no={{ $course['certificate_no'] ?? "" }}" target="_blank" class="ieukcd-btn btn btn-primary " style="max-width: 100%; width: 150px;">Verify</a> 
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>  
                                                <?php $i++ ?>
                                            @endforeach
                                        @endforeach
                                    @endforeach  
                                @endforeach
                            @endforeach
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>
<div class="modal fade" id="student_certificate" tabindex="-1" role="dialog" aria-labelledby="cpd-policy-modalLabel" aria-hidden="true">
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
                <div class="pdf-view-popup"></div>
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
@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        // getCertificate();
        getUrl();
        function getUrl(){
            var url = $('.tab_change.active.show').data('url');
             if(url != ''){
                console.log('url',url);
                 PDFObject.embed(url, ".pdf-view-popup",{height: "60rem"});
            }
        }
        $('.tab_change').on('click',function(){
            var url = $(this).data('url');
            if(url != ''){
                console.log('url',url);
                 PDFObject.embed(url, ".pdf-view-popup",{height: "60rem"});
            }
        });

    });

</script>
@endsection
