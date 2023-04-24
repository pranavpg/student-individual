<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

  @if(env('HIDE_FLAG') == "external")
      <title>Adani Student</title>
      <link rel="icon" type="image/png" href="{{ env('LOGIN_BRAND_LOGO_FEVICON') }}" />
  @else
      <title>IEUK Student</title>
      <link rel="icon" type="image/png" href="{{ asset('public/images/favicon.png') }}" />
  @endif

	<link
	href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&family=Roboto:wght@300;400;700&display=swap"
	rel="stylesheet">
	<script src="{{ asset('public/js/popper.min.js') }}"></script>
	<link rel="stylesheet" href="{{ asset('public/css/all.min.css') }}" />
	<link rel="stylesheet" href="https://use.typekit.net/mky7wxw.css">
	<link href="{{ asset('public/css/style.css') }}?v={{env('CACTH')}}" rel="stylesheet">
	<link href="{{ asset('public/css/developer.css') }}?v={{env('CACTH')}}" rel="stylesheet">
	<link href="{{ asset('public/css/custom_new.css') }}?v={{env('CACTH')}}" rel="stylesheet">
	<script src="{{ asset('public/js/jquery-3.5.1.min.js') }}"></script>
	<script src="{{ asset('public/js/Chart.min.js') }}"></script>
	<script src="{{ asset('public/js/bootstrap.min.js') }}?v={{env('CACTH')}}"></script>
	<script src="{{ asset('public/js/jquery.validate.min.js') }}"></script>
	<script src="{{ asset('public/js/additional-methods.min.js') }}"></script>
	<script src="{{ asset('public/js/owl.carousel.js') }}"></script>
	<script src="{{ asset('public/js/select2.js') }}"></script>
	<link href="{{ asset('public/css/select2.min.css') }}" rel="stylesheet">
	<link href="{{ asset('public/css/d-scrollbar.css') }}" rel="stylesheet">
	<script src="{{ asset('public/js/d-scrollbar/jquery.scrollbar.js') }}"></script>

	<link rel="stylesheet" href="{{ asset('public/css/jquery-ui.css') }}">
	<script src="{{ asset('public/js/1.13.1-jquery-ui.js') }}"></script>

	<link rel="stylesheet" href="{{ asset('public/css/font-awesome-6.1.1.css') }}">
	<link rel="stylesheet" href="{{ asset('public/css/dataTables.bootstrap5.min.css') }}">
	<script type="text/javascript" src="{{ asset('public/js/jquery.dataTables.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/js/dataTables.bootstrap5.min.js') }}"></script>
	<script type="text/javascript">
		var feedbackPopup       = false;
		var facilityFeedback    = false;
		var courseFeedback      = false;
	</script>
	<link rel="stylesheet" href="{{ asset('public/css/animate.min.css') }}"/>
	<style type="text/css">

		#cover-spin {
			position:fixed;
			width:100%;
			left:0;right:0;top:0;bottom:0;
			background-color: rgba(255,255,255,0.7);
			z-index:9999;
			display:none;
		}
		@-webkit-keyframes spin {
			from {-webkit-transform:rotate(0deg);}
			to {-webkit-transform:rotate(360deg);}
		}
		@keyframes spin {
			from {transform:rotate(0deg);}
			to {transform:rotate(360deg);}
		}
		#cover-spin::after {
			content:'';
			display:block;
			position:absolute;
			left:48%;top:40%;
			width:40px;height:40px;
			border-style:solid;
			border-color:black;
			border-top-color:transparent;
			border-width: 4px;
			border-radius:50%;
			-webkit-animation: spin .8s linear infinite;
			animation: spin .8s linear infinite; 
		}
		.ui-datepicker {
			background: #30475e;
			border: 1px solid #555;
			color: #EEE;
		}
/*		.stringProper{
			white-space: pre-line;
		}*/
		.stringProperNew{
			white-space: break-spaces;
		}
		.closeGoBack{
			right:0;
			top:0;
			margin-right: 20px;
			margin-top:15px;
			position: absolute;
		}
		.commonFontSize{
			font-size: 1.125rem;
			font-weight: 500;
			color: #30475e;
		}


		.page-loader-wrapper {
			z-index: 99999999;
			position: fixed;
			top: 0;
			left: 0;
			bottom: 0;
			right: 0;
			width: 100%;
			height: 100%;
			background: rgba(111,89,89,.4);
			overflow: hidden;
			text-align: center;
		}
		.page-loader-wrapper .loader {
			position: relative;
			top: calc(50% - 30px);
		}
		.loading-img-spin {
			position: absolute;
			top: 50%;
			left: 50%;
			width: 150px;
			height: 150px;
			margin: -130px 0 20px -75px;
        /*-webkit-animation: spin 1.5s linear infinite;
        -moz-animation: spin 1.5s linear infinite;
        animation: spin 1.5s linear infinite;*/
      }

    </style>

    <script type="text/javascript">
    	var flag = false;
    </script>

    <link href="{{ asset('public/css/responsive1.css') }}?v={{env('CACTH')}}" rel="stylesheet"> 
    <link href="{{ asset('public/css/responsive2.css') }}?v={{env('CACTH')}}" rel="stylesheet">
    @yield('style')

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/9.8.4/firebase-app.js";
        import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.8.4/firebase-analytics.js";
        const firebaseConfig = {
        apiKey: "AIzaSyBhEKIVyU6dIw4u6jCSlyi-tLof5tWQ22I",
        authDomain: "ieuk-student.firebaseapp.com",
        databaseURL: "https://ieuk-student.firebaseio.com",
        projectId: "ieuk-student",
        storageBucket: "ieuk-student.appspot.com",
        messagingSenderId: "106344401447",
        appId: "1:106344401447:web:c63591e89ebb47f4c61c02",
        measurementId: "G-ZV0HEH31T3"
        };
        const app = initializeApp(firebaseConfig);
        const analytics = getAnalytics(app);
    </script>

    <script type="text/javascript">
      (function(w,d,v3){
      w.chaportConfig = {
        appId : '62b6c7e3ae84592f3096d376',
        launcher: {
					show: false
				},
				appearance: {
					position: ['left', 20, 20],
					textStatuses: true
				}
      };
      if(w.chaport)return;v3=w.chaport={};v3._q=[];v3._l={};v3.q=function(){v3._q.push(arguments)};v3.on=function(e,fn){if(!v3._l[e])v3._l[e]=[];v3._l[e].push(fn)};var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://app.chaport.com/javascripts/insert.js';var ss=d.getElementsByTagName('script')[0];ss.parentNode.insertBefore(s,ss)})(window, document);

      window.chaport.on('ready', function () {
  			$(".expand-chat-support").click(function() {
    			// window.chaport.openIn({ selector: '#divyesh' });
    			window.chaport.open();
    			// window.chaport.toggle();
  			});
  			$(".chat-support").click(function() {
    			window.chaport.open();
  			});
			});



    </script>
 
  </head>
  <!-- <body class="{{ isset($topic_tasks[0]['sorting'])?'topicsall topic_'.$topic_tasks[0]['sorting']:'' }} {{ isset($pageName)? $pageName:'' }}"> -->
  	<div class="hide-menu"></div>
  	<body class="topicsall">
  	<a style="display:none" id="scrll-top" class="scrolltop" href="javascript:void(0);" onclick="scrolltoTop()"><img src="{{ asset('public/images/scrolltoTop-arrow.png') }}" alt="" class="img-fluid" width="20px"></a>
  	<div class="page-loader-wrapper" style="display:none">
  		<div class="loader">
  			<img class="loading-img-spin" src="{{asset('public/images/logo-main.svg')}}" alt="admin">
  			<p class="primary font-weight-bolder">Please wait...</p>
  		</div>
  	</div>
  	<header class="mobile-header">
  		<div class="mb-menu menu-option"><a href="javascript:void(0)"><img class="mbmenubutton" src="{{ asset('public/images/mobilemenu-icon.png') }}" alt="menuicon" width="24px" height="24px"></a></div>
  		<div class="mb-menu menu-back"><a href="" onclick="window.history.go(-1); return false;"><img class="mbmenubutton" src="{{ asset('public/images/icon-back-white.svg') }}" alt="Back"></a></div>

  		<div class="mh-logo"><img src='{{asset("public/images/mob-logo-w.png")}}' srcset='{{asset("public/images/mob-logo-w-2x.png 2x")}}'  alt="Imperial English UK"></div>

  		<!-- <div class="mh-logo"><img src='{{asset("public/images/ieuk-mobile-logo.png")}}' srcset='{{asset("public/images/mob-logo-w-2x.png 2x")}}'  alt="Imperial English UK"></div> -->
  	</header>   

  	<?php 
// dd($feedback);
  	?>
  	@yield('content')

  	<?php

  	$facility = [
  		'Classroom Learning Facilities e.g. light, heating, furniture, size, cleanliness , rooming, toilets',
  		'Course Reading Facilities e.g. course books, graded readers, magazines, dictionaries',
  		'IT Facilities e.g. wifi, printing, tablet, speakers, headphones, CD Player, laptops, computers, projectors',
  		'Stationery e.g. paper, pens, coloring, scissors, staplers etc.',
  		'Refreshments & drinking water e.g water coolers, hot water facilities',
  		'Overall'
  	];
  	$course_init_mid = [
  		'I like this course',
  		'This course is worthwhile for me',
  		'This course is a waste of my time',
  		'The teacher uses a variety of learning methods',
  		'I know who to ask for help and guidance',
  		'This course is what I was hoping for',
  		'The lessons have clear objectives',
  		'The lessons are interesting',
  		'I like working with the other people in my class',
  		'The resources we use are interesting and useful',
  		'I learn something new in every lesson',
  		'My teacher(s) knows a lot about English',
  		'My teacher(s) is friendly and helpful',
  		'I would like to do some more courses at this school',
  		'There is a problem with this course (state below)',
  		'The room is suitable for my class'
  	];
  	$course_end = [
  		'I enjoyed this course',
  		'This course was worthwhile for me',
  		'This course was a waste of my time',
  		'The teacher used a variety of learning methods',
  		'The room was suitable for my class',
  		'This course met my expectations',
  		'The lessons had clear objectives',
  		'The lessons were interesting',
  		'I enjoyed working with the other people in my class',
  		'The resources used were interesting and useful',
  		'I learned something new in every lesson',
  		'My teacher(s) was friendly and helpful',
  		'I have improved my English language skills',
  		'Exams and assessment were well managed',
  		'I would like to do more courses at this college',
  		'I have been told about future courses'
  	];

  	?>
  	<div class="modal fade" id="goBack" tabindex="-1" role="dialog" >
  		<div class="modal-dialog erase-modal modal-dialog-centered" role="document">
  			<div class="modal-content" >
  				<button type="button" class="close closeGoBack" >&times;</button>
  				<div class="modal-header justify-content-center">
  					<h5 class="modal-title" id="audiomodalLongTitle">Do you want to go back?</h5>
  				</div>
  				<div class="modal-body">
  				</div>
  				<div class="modal-footer justify-content-center audio__controls">
  					<button type="button" class="btn goBackYes">Yes</button>
  					<button type="button" class="btn cancleModal">No</button>
  				</div>
  			</div>
  		</div>
  	</div>

  	<?php 

  	$levelId = "";
  	if(isset($courseName) && isset($userDetails)) {
  		if($courseName == "ges"){
  			$levelId= isset($userDetails)?$userDetails['student_ges_level']:"";
  		}
  		if($courseName == "aes"){
  			$levelId= isset($userDetails)?$userDetails['student_aes_level']:"";
  		}
  	}
  	$slectedTask = isset($_GET['n'])?$_GET['n']:'';
  	if(isset($topic_tasks)){
  		foreach($topic_tasks as $key=>$data){
  			if(!empty($data['tasks'])) {
  				foreach($data['tasks'] as $key1=>$tasks){
  					if($taskId == $tasks['id']){
  						if($slectedTask == ""){
  							$slectedTask = !empty($tasks['practise'][0]['id']) ? $tasks['practise'][0]['id'] : 0;
  						}
  					}
  				}
  			}
  		}
  		$feedbackPopup = false;
        // if(isset($feedback) && !empty($feedback['result'])){
        //     if($feedback['result']['practice_id'] == $slectedTask){
        //         $feedbackPopup = true;
        //     }
        // }
  		if(isset($lastPractice)) {
  			$feedbackPopup = true;
  		}
  	}

  	?>

  	<!-- Remove the 1 from id name facility-feedback and course-feedback start work -->
  	<div class="modal fade" id="facility-feedback1" tabindex="-1" role="dialog" aria-labelledby="feedback-form-modalLabel" aria-hidden="true">
  		<div class="modal-dialog modal-xl">
  			<form id="add_feedback_facility_form" name="add_feedback_facility_form" class="add_feedback_facility_form" method="post">

  				<input type="hidden" name="course_course_id" value="{{isset($courseIdCurrunt)?$courseIdCurrunt:''}}">
  				<input type="hidden" name="course_topic_id" value="{{ Request::segment(2) }}">
  				<input type="hidden" name="course_level_id" value="{{ $levelId }}">
  				<input type="hidden" name="select_base" value="{{ isset($topic_tasks[0]['sorting'])?$topic_tasks[0]['sorting']:'' }}">


  				<div class="modal-content">
  					<div class="modal-header bb-none flex-wrap">
  						<div class="modal-header-top d-flex flex-wrap justify-content-center align-items-center w-100 mb-4">
  							<h4 class="modal-title" id="feedback-form-modalLabel">
  								Facilities Feedback Form
  							</h4>
  							<button type="button" class="close" data-dismiss="modal" aria-label="Close">

  								<img src="{{ asset('public/images/icon-close-modal.svg')}}" alt="Close Icone" class="img-fluid inactive">
  							</button>
  						</div>
  					</div>
  					<div class="modal-table modal-table-border mb-4 d-flex flex-wrap">
  						<table class="table mb-0">
  							<thead>
  								<tr>
  									<th scope="col" class="bt-none">Please Select an option to answer each question</th>
  									<th scope="col" class="text-center bt-none border-left">Excellent</th>
  									<th scope="col" class="text-center bt-none border-left">Good</th>
  									<th scope="col" class="text-center bt-none border-left">Average</th>
  									<th scope="col" class="text-center bt-none border-left">Poor</th>
  								</tr>
  							</thead>
  							<tbody>
  								<?php $temp = 0;
  								foreach ($facility as $key => $value) { ?>
  									<tr>
  										<input type="hidden" name="user_answer[{{$key}}][question]" value="{{$value}}">
  										<th scope="row">{{$value}}</th>
  										<td class="text-center border-left">
  											<div class="custom-control custom-radio">
  												<input type="radio" class="custom-control-input" id="customControlValidationFacility{{$temp}}" name="user_answer[{{$key}}][selection]" value="1">
  												<label class="custom-control-label" for="customControlValidationFacility{{$temp}}"></label>
  											</div>
  										</td>
  										<?php $temp++;?>
  										<td class="text-center border-left">
  											<div class="custom-control custom-radio">
  												<input type="radio" class="custom-control-input" id="customControlValidationFacility{{$temp}}" name="user_answer[{{$key}}][selection]" value="2">
  												<label class="custom-control-label" for="customControlValidationFacility{{$temp}}"></label>
  											</div>
  										</td>
  										<?php $temp++;?>
  										<td class="text-center border-left">
  											<div class="custom-control custom-radio">
  												<input type="radio" class="custom-control-input" id="customControlValidationFacility{{$temp}}" name="user_answer[{{$key}}][selection]" value="3">
  												<label class="custom-control-label" for="customControlValidationFacility{{$temp}}"></label>
  											</div>
  										</td>
  										<?php $temp++;?>
  										<td class="text-center border-left">
  											<div class="custom-control custom-radio">
  												<input type="radio" class="custom-control-input" id="customControlValidationFacility{{$temp}}" name="user_answer[{{$key}}][selection]" value="4">
  												<label class="custom-control-label" for="customControlValidationFacility{{$temp}}"></label>
  											</div>
  										</td>
  										<?php $temp++;?>
  									</tr>
  								<?php } ?>
  							</tbody>
  						</table>
  					</div>
  					<div class="modal-body border-danger pl-0 pr-0">
  						<h6>Additional Comments</h6>

  						<input type="hidden" name="other_question[0][question]" value="Additional Comments">


  						<div class="form-group form-group_underline mb-2">

  							<!-- <span class="form-control form-control-sm form-control_underline" role="textbox" contenteditable placeholder="Your Answer...."></span> -->
  							<!-- <input type="hidden" value="value1" name="other_question[0][ans]" value=""> -->

  							<input class="form-control form-control-sm form-control_underline keydwn" type="text" name="other_question[0][ans]">
  						</div>

  					</div>
  					<div class="modal-footer bt-none justify-content-center">
  						<div class="alert alert-success" role="alert" style="display:none"></div>
  						<div class="alert alert-danger" role="alert" style="display:none"></div>
  						<button type="button" class="btn btn-primary" data-dismiss="modal">Skip</button>
  						<button type="button" class="btn btn-primary" id="add-facility">Add</button>
  					</div>
  				</div>
  			</form>
  		</div>
  	</div>
  	<div class="modal fade" id="course-feedback-end1" tabindex="-1" role="dialog" aria-labelledby="feedback-form-modalLabel" aria-hidden="true">
  		<div class="modal-dialog modal-xl">
  			<form id="add_feedback_course_end_form" name="add_feedback_form" class="add_feedback_form" method="post">
  				<input type="hidden" name="course_course_id" value="{{isset($courseIdCurrunt)?$courseIdCurrunt:''}}">
  				<input type="hidden" name="course_topic_id" value="{{ Request::segment(2) }}">
  				<input type="hidden" name="course_level_id" value="{{ $levelId }}">
  				<input type="hidden" name="select_base" value="{{ isset($topic_tasks[0]['sorting'])?$topic_tasks[0]['sorting']:'' }}">
  				<div class="modal-content">
  					<div class="modal-header flex-wrap bb-none">
  						<div class="modal-header-top d-flex flex-wrap justify-content-center align-items-center w-100 mb-4">
  							<h4 class="modal-title" id="feedback-form-modalLabel">ET INITIAL-COURSE FEEDBACK FORM</h4>
  							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  								<img src="{{ asset('public/images/icon-close-modal.svg')}}" alt="Close Icone" class="img-fluid inactive">
  							</button>
  						</div>
  						<p style="margin-left: 185px;margin-left: 185px;">1 = Strongly Disagree; 2 = Disagree; 3 = Agree; 4 = Strongly Agree; NA = Don’t know/not relevant</p>
  					</div>

  					<div class="modal-table modal-table-border mb-4 d-flex flex-wrap">
  						<table class="table mb-0">
  							<thead>
  								<tr>
  									<th scope="col" class="bt-none">Please tick a box (&#10003;)  to answer each question:</th>
  									<th scope="col" class="text-center bt-none border-left">1</th>
  									<th scope="col" class="text-center bt-none border-left">2</th>
  									<th scope="col" class="text-center bt-none border-left">3</th>
  									<th scope="col" class="text-center bt-none border-left">4</th>
  									<th scope="col" class="text-center bt-none border-left">N/A</th>
  								</tr>
  							</thead>
  							<tbody>
  								<?php
  								$temp = 0;
  								foreach ($course_end as $key => $value) { ?>
  									<tr>
  										<input type="hidden" name="user_answer[{{$key}}][question]" value="{{$value}}">
  										<th scope="row">{{$value}}</th>
  										<td class="text-center border-left">
  											<div class="custom-control custom-radio">
  												<input type="radio" class="custom-control-input" id="customControlValidation{{$temp}}" name="user_answer[{{$key}}][selection]" value="1">
  												<label class="custom-control-label" for="customControlValidation{{$temp}}"></label>
  											</div>
  										</td>
  										<?php $temp++;?>
  										<td class="text-center border-left">
  											<div class="custom-control custom-radio">
  												<input type="radio" class="custom-control-input" id="customControlValidation{{$temp}}" name="user_answer[{{$key}}][selection]" value="2">
  												<label class="custom-control-label" for="customControlValidation{{$temp}}"></label>
  											</div>
  										</td>
  										<?php $temp++;?>
  										<td class="text-center border-left">
  											<div class="custom-control custom-radio">
  												<input type="radio" class="custom-control-input" id="customControlValidation{{$temp}}" name="user_answer[{{$key}}][selection]" value="3">
  												<label class="custom-control-label" for="customControlValidation{{$temp}}"></label>
  											</div>
  										</td>
  										<?php $temp++;?>
  										<td class="text-center border-left">
  											<div class="custom-control custom-radio">
  												<input type="radio" class="custom-control-input" id="customControlValidation{{$temp}}" name="user_answer[{{$key}}][selection]" value="4">
  												<label class="custom-control-label" for="customControlValidation{{$temp}}"></label>
  											</div>
  										</td>
  										<?php $temp++;?>
  										<td class="text-center border-left">
  											<div class="custom-control custom-radio">
  												<input type="radio" class="custom-control-input" id="customControlValidation{{$temp}}" name="user_answer[{{$key}}][selection]" value="5">
  												<label class="custom-control-label" for="customControlValidation{{$temp}}"></label>
  											</div>
  										</td>
  										<?php $temp++;?>
  									</tr>
  								<?php } ?>
  							</tbody>
  						</table>
  					</div>
  					<div class="modal-body modal-table-border">

  						<input type="hidden" name="other_question[0][question]" value="What are you enjoying the most about the course?">
  						<input type="hidden" name="other_question[1][question]" value="What are you not enjoying about the course?">

  						<h6>What are you enjoying the most about the course?</h6>
  						<div class="form-group form-group_underline">
  							<!-- <span class="form-control form-control-sm form-control_underline" role="textbox" contenteditable placeholder="Your Answer...."></span> -->
  							<input type="text" name="other_question[0][ans]" class="form-control form-control-sm form-control_underline" role="textbox"  placeholder="Your Answer...." value="">
  						</div>
  						<h6>What are you not enjoying about the course?</h6>

  						<div class="form-group form-group_underline mb-2">

  							<input type="text"  name="other_question[1][ans]" class="form-control form-control-sm form-control_underline" role="textbox"  placeholder="Your Answer...." value="">
  						</div>
  					</div>
  					<div class="modal-footer bt-none justify-content-center">
  						<div class="alert alert-success" role="alert" style="display:none"></div>
  						<div class="alert alert-danger" role="alert" style="display:none"></div>
  						<button type="button" class="btn btn-primary" data-dismiss="modal">Skip</button>
  						<button type="button" class="btn btn-primary" id="add-add-course">Add</button>
  					</div>
  				</div>
  			</form>
  		</div>
  	</div>

  	@if(!empty($feedback['result']) && $feedbackExits == false)
  	<?php 
  	$feedback_all = $feedback['result']['feedback_all'];
  	?>
  	<div class="modal fade" id="course-feedback-init-mid" tabindex="-1" role="dialog" aria-labelledby="feedback-form-modalLabel" aria-hidden="true">
  		<div class="modal-dialog modal-xl">
  			<form id="add_feedback_course_mid_init_form" name="add_feedback_form" class="add_feedback_form" method="post">
  				<input type="hidden" name="course_course_id" value="{{isset($courseIdCurrunt)?$courseIdCurrunt:''}}">
  				<!-- <input type="hidden" name="practice_id" value="{{isset($practiceId)?$practiceId:''}}"> -->
  				<input type="hidden" name="course_topic_id" value="{{ Request::segment(2) }}">
  				<input type="hidden" name="feedback_id" value="{{ $feedback['result']['feedback_id'] }}">
  				<input type="hidden" name="course_level_id" value="<?php isset($level_id)?$level_id:'' ?>">
  				<!-- <input type="hidden" name="select_base" value="{{ isset($topic_tasks[0]['sorting'])?$topic_tasks[0]['sorting']:'' }}"> -->
  				<!-- <input type="hidden" name="select_base" value="{{ isset($topic_tasks[0]['sorting'])?$topic_tasks[0]['sorting']:'' }}"> -->
  				<div class="modal-content">
  					<div class="modal-header">
							<h4 class="modal-title" id="feedback-form-modalLabel">{{ $feedback_all['title'] }}</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
  					</div>
						<div class="modal-body">
							<p>{{ $feedback_all['legend'] }}</p>
							<div class="modal-table modal-table-border mb-4 d-flex flex-wrap">
  							<table class="table border-0 practice-review-modal">
  								<thead>
  									<tr>
  										@foreach($feedback_all['heading']['question'] as $heading)
  										@if($loop->first)
  										<th scope="col" class="bt-none">{{ $heading }} </th>
  										@else
  										<th scope="col" class="text-center bt-none border-left">{{ $heading }}</th>
  										@endif
  										@endforeach
  									</tr>
  								</thead>
  								<tbody>
  									<?php
  									$temp = 0;
                            	//foreach ($course_init_mid as $key => $value) { ?>
                            		@foreach($feedback_all['question']['question'] as $key => $question)
                            		<tr>
                            			<input type="hidden" name="user_answer[{{$key}}][question]" value="{{$question}}">
                            			<td scope="row">{{$question}}</td>
                            			@foreach($feedback_all['heading']['question'] as $valueKey => $heading)
                            			@if($loop->first)
                            			@else
                            			<td class="text-center border-left">
                            				<div class="custom-control custom-radio">
                            					<input type="radio" class="custom-control-input" id="customControlValidationInitMid{{$temp}}" name="user_answer[{{$key}}][selection]" value="{{$valueKey}}">
                            					<label class="custom-control-label" for="customControlValidationInitMid{{$temp}}"></label>
                            				</div>
                            			</td>
                            			<?php $temp++;?>
                            			@endif
                            			@endforeach
                            		</tr>
                            		@endforeach
                            		<?php //} ?>
                	</tbody>
              	</table>
            	</div>
							@foreach($feedback_all['other_question']['question'] as $key => $other_question)
							<h6>{{$other_question}}</h6>

							<input type="hidden" name="other_question[{{$key}}][question]"  value="{{  $other_question }}">

							<div class="form-group form-group_underline">
								<input type="text"  name="other_question[{{$key}}][ans]" class="form-control form-control-sm form-control_underline" role="textbox"  placeholder="Your Answer...." value="">
							</div>
							@endforeach
						</div>
						<div class="modal-footer justify-content-center">
							<div class="success_alert text-center alert alert-success" style="display:none;">
								<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
									<i class="fa-regular fa-circle-check"></i>
								</div>
							</div>
							<div class="error_alert text-center alert alert-danger" style="display:none;">
								<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
									<i class="fa fa-circle-exclamation"></i>
								</div>
							</div>
							<button type="button" class="btn btn-primary" id="add-init-course">Add</button>
							<button type="button" class="btn btn-cancel" data-dismiss="modal">Skip</button>
						</div>
          </div>
        </form>
      </div>
    </div>
                @endif
                @yield('popup')


                <div class="cover-spin" id="cover-spin"></div>
                <script src="{{ asset('public/js/general.js') }}"></script>
                <script src="{{ asset('public/js/custom.js') }}"></script>
                <script src="{{ asset('public/js/pdf-popup.js') }}"></script>
                <script>
                	$(document).ready(function(){
                		$('.keydwn').keydown(function (e) {
                			if (e.keyCode == 13) {
                				e.preventDefault();
                				return false;
                			}
                		});
                		$('span.textarea').attr("onpaste","return false;")

                		$('.enter_disable').keypress(function(event){
                			if (event.which == '13') {
                				event.preventDefault();
                			}
                		});

                		$('.goBackYes').click(function(){
            // $(".course-book").toggleClass("fullscreen");
            // $(".course-content").toggleClass("scrollbar");
            // $(".speaking-course").toggleClass("d-flex")
            // $('#goBack').modal('toggle')
          })

                		$('.close-course').click(function(){
            // $('#goBack').modal('toggle')
          })
                	});
                </script>
                <script type="text/javascript">
                	$(document).ready(function(){
                		$('.d-scrollbar').scrollbar();
                	});
                </script>
                <script type="text/javascript">

                	$(document).ready(function() {
                		jQuery("#add-facility").click(function(){
                			$("#add-facility").attr('disabled',true);
                			$("#add_feedback_facility_form .form-control_underline").each(function(){
                				$(this).next().val($(this).text())
                			});

                			$.ajax({
                				url: "{{ URL('profile/add-facility-feedbacks')}}",
                				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                				type: 'POST',
                				data: $("#add_feedback_facility_form").serialize(), 
                				success: function (data) {
                // $("#feedback_add_btn").removeAttr('disabled');
                
                if(data.success){
                	setTimeout(function(){
                		window.location.reload();
                            // $("#add-facility").removeAttr('disabled');
                          },2000);
                	$('#add_feedback_facility_form .alert-danger').hide();
                	$('#add_feedback_facility_form .alert-success').show().html(data.message).fadeOut(6000);
                }else{
                	$('#add_feedback_facility_form .alert-success').hide();
                	$('#add_feedback_facility_form .alert-danger').show().html(data.message).fadeOut(6000);
                }
              }
            });
                		});
                		jQuery("#add-add-course").click(function(){
                			$("#add-add-course").attr('disabled',true);
                			$("#add_feedback_course_end_form .form-control_underline").each(function(){
                				$(this).next().val($(this).text())
                			});

                			$.ajax({
                				url: "{{ URL('profile/add-course-end-feedbacks')}}",
                				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                				type: 'POST',
                				data: $("#add_feedback_course_end_form").serialize(), 
                				success: function (data) {


                					if(data.success){
                						setTimeout(function(){
                							window.location.reload()
                          // $("#add-add-course").removeAttr('disabled');
                        },2000);
                						$('#add_feedback_course_end_form .alert-danger').hide();
                						$('#add_feedback_course_end_form .alert-success').show().html(data.message).fadeOut(6000);
                					}else{
                						$('#add_feedback_course_end_form .alert-success').hide();
                						$('#add_feedback_course_end_form .alert-danger').show().html(data.message).fadeOut(6000);
                					}
                				}
                			});
                		});

                		jQuery("#add-init-course").click(function(){
                			$("#add-init-course").attr('disabled',true);
                			$("#add_feedback_course_mid_init_form .form-control_underline").each(function(){
                				$(this).next().val($(this).text())
                			});

                			$.ajax({
                				url: "{{ URL('profile/add-course-init-mid-feedbacks')}}",
                				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                				type: 'POST',
                				data: $("#add_feedback_course_mid_init_form").serialize(), 
                				success: function (data) {


                					if(data.success){
                						setTimeout(function(){
                							window.location.reload()
                          // $("#add-init-course").removeAttr('disabled');
                        },2000);
                						$('#add_feedback_course_mid_init_form .alert-danger').hide();
                						$('#add_feedback_course_mid_init_form .alert-success').show().html(data.message).fadeOut(6000);
                					}else{
                						$('#add_feedback_course_mid_init_form .alert-success').hide();
                						$('#add_feedback_course_mid_init_form .alert-danger').show().html(data.message).fadeOut(6000);
                					}
                				}
                			});
                		});

                	});

$('body').on('dragstart drop', function(e){
	e.preventDefault();
	return false;
}); 

//== responsive for header mobile menu ==// 
$(document).ready(function(){
    //== on change size window reload
//  $(window).resize(function(){location.reload();});
if (window.matchMedia('(max-width: 767px)').matches) {

	$("header.mobile-header a").on("click", function (event) {
		$("aside#sidebar.sidebar-menu").toggle();
		$(this).toggleClass('on');
		$('aside#sidebar.sidebar-menu').toggleClass('on');
		event.stopPropagation();
	});
	$("main.dashboard,header.mobile-header").on("click", function (event) {
		$("aside#sidebar.sidebar-menu").hide();
		$('header.mobile-header a').prop('checked', true); 
		$('header.mobile-header a').removeClass('on');
		$('aside#sidebar.sidebar-menu').removeClass('on');

	});         

//      // backbutton body margin
//      var bkbtnoh  = $(".course-book a.mobbackbtn-b").outerHeight();      
//      $('body').css({
//          "margin-bottom": bkbtnoh
//      });

}
//== responsive for header mobile menu ==//
//== page Reload ==//
//  if (window.DeviceOrientationEvent) {
//      window.addEventListener('orientationchange', function() { 
//          alert('hello');
//          location.reload(); }, false);
//  }

window.addEventListener("orientationchange", function() {
//    alert(window.orientation);
location.reload();

}, false);  
});
//if (window.matchMedia('(max-width:926px').matches) {
//  $(window).resize(function(){location.reload();});
//  
//}else{
//  
//}


</script>
<script>
	function scrolltoTop() {
		setTimeout(function(){
			$('html, body').animate({
				scrollTop: $('body').offset().top }, 1000);
		}, 100);
	}

	var mybutton = document.getElementById("scrll-top");


	window.onscroll = function() {scrollFunction()};

	function scrollFunction() {
		if (document.body.scrollTop > 1000 || document.documentElement.scrollTop > 1000) {
			mybutton.style.display = "block";
		} else {
			mybutton.style.display = "none";
		}
	}

</script>
<script type="text/javascript">

	$(document).ready(function() {
		$('.datatable').DataTable();
	});
	$(document).ready(function() {
		$(".custom-select2-dropdown").select2();
		$('.custom-select2-dropdown').on("select2:open", function () {
			$('.select2-results__options').addClass('d-scrollbar');
			$('.select2-results__options').scrollbar();
		});
	});
	$(document).ready(function() {
		$(".custom-select2-dropdown-nosearch").select2({minimumResultsForSearch: -1});
		$('.custom-select2-dropdown-nosearch').on("select2:open", function () {
			$('.select2-results__options').addClass('d-scrollbar');
			$('.select2-results__options').scrollbar();
		});
	});
	$(document).ready(function() {
		$(".custom-select2-dropdown-nosearch2").select2({minimumResultsForSearch: -1});
		$('.custom-select2-dropdown-nosearch2').on("select2:open", function () {
			$('.select2-results__options').addClass('d-scrollbar');
			$('.select2-results__options').scrollbar();
		});
	});
</script>
<script type="text/javascript">
	function textAreaAdjust(element) {
	element.style.height = "1px";
	element.style.height = (25+element.scrollHeight)+"px";
	}
</script>
<script type="text/javascript">
	$(".open-filter").click(function(){
		$("aside.filter-sidebar").addClass("openclose");
	});

	$(".close-filter").click(function(){
		$("aside.filter-sidebar.openclose").removeClass("openclose");
	});

	$(document).ready(function(){
		$("#moreInfo").click(function(){
			$(".info-details").slideDown("slow");
		});
		$(".moreInfo").click(function(){
			$(".dashboard-info-details").slideDown("slow");
		});
		$(function() {
			$('body').on('mouseup', function() {
				$('.info-details').hide();
			});
		});
	});
</script>

<script type="text/javascript">
	$(document).on('keyup','.fillblanks',function() {
		var value = $(this).html().trim().length;
		if(value == "") {
			$(this).css("min-width","3ch");
			$(this).css("display","inline-block");
		} else {
			if(value == "1" || value == "2" || value == "3") {
				$(this).css("min-width","1ch");
				$(this).css("display","inherit");
			} else {
				if(flag) {
					flag = false;
					$(this).css("min-width","3ch");
					$(this).css("display","inherit");
				}
			}
		}
	});
</script>

<script type="">

	$(".nav-opener").click(function(){
		$("body").toggleClass("open-black-bg");
	})

</script>

<script>
  	$(document).on('click',"#openmodal",function(){
  		var url = $(this).attr("data-id");
		// PDFObject.embed('https://s3.amazonaws.com/imperialenglish.co.uk/'+url, "#datas",{height: "60rem"});
		const app_url = '{{ env('S3URL') }}';
		PDFObject.embed(app_url+url, "#datas",{height: "60rem"});
		$('#myModal').modal("show")
	});
	$(document).on('click',"#openmodal_forvideo",function(){
  		var url = $(this).attr("data-id");
  		var url2 = $(this).attr("data-id2");
  		var url_update = 'https://www.youtube.com/embed/'+url2+'';
  		$("#datas").show().html('<iframe width="653" height="345" src="'+url_update+'"></iframe>');
		$('#myModal').modal("show")
	});
	$(document).on('click',"#close_video",function(){
  	$("#datas").show().html('');
  });
</script>
@yield('script')

</body>
</html>