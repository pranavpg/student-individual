@extends('layouts.app')
@section('content')
<?php 
$logo_type = "";
?>
<main class="dashboard">
	<div class="container-fluid dashboard-div">
		<div class="row">
			@include('common.sidebar')
			<section class="main col-sm-12">
				<div class="main__logo">
					@if($logo_img_new == 1)
						<a href="{{ url('/') }}" title="Imperial English UK" class="header-logo-left main-logo">
							<img src="{{ asset('/public/images/logo-blue.svg') }}" alt="Imperial English UK" class="img-fluid">
						</a>
					@elseif($logo_img_new == 2)
						<a href="{{ url('/') }}" title="Imperial English UK" class="header-logo-left a-logo"> 
							<img src="{{env('S3URL')}}{{$logo_img_new}}" alt="Imperial English UK" class="img-fluid">
						</a>
						<a href="{{ url('/') }}" title="Imperial English UK" class="header-logo-left main-logo">
							<img src="{{ asset('/public/images/logo-blue.svg') }}" alt="Imperial English UK" class="img-fluid" >
						</a>
					@elseif($logo_img_new == 3)
						<a href="{{ url('/') }}" title="Imperial English UK" class="header-logo-left">
							<img src="{{env('S3URL')}}{{$logo_img_new}}" alt="Imperial English UK" class="img-fluid">
						</a>
					@endif
					<a data-toggle="modal" data-target="#logout_popup" title="Logout" class="btn btn-danger float-right ieuklogoutbtn" style="padding: 0;border: none;min-width: 1%;">
						<img src="{{ asset('/public/images/icon-logout.svg') }}" alt="Logout" class="img-fluid deskonly d-none">
						<span class="mobonly"><img src="{{ asset('/public/images/mob-logbtn.png') }}" alt="Logout" class="img-fluid" width="24px" height="24px"></span>
					</a>
					<span class="dashboard-student-details float-right d-none d-md-block">
						<i class="fa fa-user-graduate"></i> {{ Session::get("first_name") }} {{ Session::get("last_name") }} ({{ Session::get("user_id_new") }})

					</span>
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
						<span class="dashboard-student-details mr-1 d-block d-md-none">
							<i class="fa fa-user-graduate"></i> Hello FirstnameOnly (IBL1OF)
						</span>
					</div>
				</div>
				<div class="modal fade" id="myModal" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title"><i class="fas fa-file-alt"></i> Instruction</h4>
								<button type="button" class="close" id="closemodal" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body text-center">
								<div id="datas"></div>
							</div>
							<div class="modal-footer justify-content-center">
								<button type="button" class="btn btn-cancel" id="closemodel" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
				<div class="main__content">
					<div class="topic-tab">
						<div class="course-dropdown d-sm-none w-100" style="display: none;">
							<label class="mb-0">Select Course</label>
							<select id="course_dropdown" class="form-control dropdown border">
								@foreach($onlyCourse as $i=>$course)
									<option value="{{$course['course']['_id']}}">{{$course['course']['coursetitle']}}</option>
								@endforeach
							</select>
						</div>
						<div class="course-block-list owl-carousel owl-theme">
							@foreach($onlyCourse as $i=>$course) 
								<?php  
									$disable = $disable = !$course['is_expire']?"false":"true";
								?>
								<div class="item tab__block_container nav-item pills-tab" data-course="{{ $course['course']['_id'] }}" date-course-new="{{$course['level']['_id']}}" expire_flag="{{ $disable }}" date="{{ $course['course_end_date'] }}" >
									<div class="tab__block d-flex flex-wrap justify-content-between selected-course crs_{{$course['course']['_id']}} {{ $loop->first?'active':'' }}" >
										<div class="tab__block_content col-12 p-0 text-left">
											<span class="course-logo">
												<img src="https://s3.amazonaws.com/imperialenglish.co.uk/{{isset($course['level']['level_image'])?$course['level']['level_image']:''}}">
											</span>
											<div>
												<h1 class="mt-2">{{$course['course']['coursetitle']}}</h1>
												<h3 class="text-left" style="color: #d55b7d;">{{$course['level']['leveltitle']}}</h3>
											</div>
											<div>
												<h6>{{isset($course['level']['title1'])?$course['level']['title1']:''}}</h6>
												<h6>{{isset($course['level']['title2'])?$course['level']['title2']:''}}</h6>
											</div>
										</div>
									</div>
								</div>
							@endforeach
						</div>
						<div class="tab-content mt-3 mt-sm-5 pt-3" id="pills-tabContent">
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</main>
<style type="text/css">
	body {
		height: 100%;
		overflow-x: hidden;
		margin: 0 auto;
	}
	.my-btn-border, .btn-bell {
		border-radius: 50%;
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
	}
	@keyframes bord-pop {
		0% {
			transform: translate(-50%, -50%);
		}
		50% {
			transform: translate(-50%, -50%) scale(1.9);
			opacity: 0.1;
		}
		100% {
			transform: translate(-50%, -50%) scale(1.9);
			opacity: 0;
		}
	}
	@keyframes col {
		0% {
			transform: scale(1) translate(0,0);
		}
		10% {
			transform: scale(1.1) translate(0,0);
		}
		75% {
			transform: scale(1) translate(0,0);
		}
		100% {
			transform: scale(1) translate(0,0);
		}
	}
	@keyframes bell-ring {
		0% {
			transform: translate(-50%, -50%);
		}
		5%, 15% {
			transform: translate(-50%, -50%) rotate(25deg);
		}
		10%, 20% {
			transform: translate(-50%, -50%) rotate(-25deg);
		}
		25%  {
			transform: translate(-50%, -50%) rotate(0deg);
		}
		100% {
			transform: translate(-50%, -50%) rotate(0deg);
		}
	}
	.notification li{
		padding: 4px;
		font-style: normal;
		color: #8e98b9;
	}
	.notification{
		list-style: none;
		padding-left:0;
	}
</style>
<script type="text/javascript">
	$(".selected-course").click(function() {
		$(".selected-course").removeClass('active');
		$(this).addClass('active');
	});
	$(document).ready(function() {
		setTimeout(function(){
			getAjaxData($(".pills-tab").attr('date-course-new'),$(".pills-tab").attr('expire_flag'),$(".pills-tab").attr('data-course'))
		},1000);
		$('.pills-tab').click(function(){
			getAjaxData($(this).attr('date-course-new'),$(this).attr('expire_flag'),$(this).attr('data-course'))
		});
	});
	function getAjaxData(cid,exf,courseId){
		$.ajaxSetup({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
		});
		$.ajax({
			type: "POST",
			url: '{{ URL("get_topic_list") }}',
			data : {level_id:cid,expire_flag:exf,coursid:courseId},
			beforeSend: function () {
				$(".page-loader-wrapper").show();
			},
			complete: function () {
				$(".page-loader-wrapper").hide();
			},
			success: function(res) {
				$('#pills-tabContent').css('display','none');
				$('#pills-tabContent').html("")
				$('#pills-tabContent').html(res)
				$('#pills-tabContent').slideToggle("slow");
				var owl = $('.topic-carousel');

				if ( $(window).width() > 525 ) {
					owl.owlCarousel({
						loop:false,
						nav:true,
						margin:10,
						responsive:{
							0:{
								items:1,
							},
							526:{
								items:2,
								slideBy:2
							},
							600:{
								items:3,
								slideBy:3
							},  
							960:{
								items:5,
								slideBy:5
							},
							1200:{
								items:6,
								slideBy:6
							}
						}
					});
				} else {
					owl.addClass('off');
				}

				owl.on('mousewheel', '.owl-stage', function (e) {
					if (e.originalEvent.wheelDelta / 120 > 0) {
						owl.trigger('next.owl');
					} else {
						owl.trigger('prev.owl');
					}
					e.preventDefault();
				});
				$('#optionchange').change(function(){
					$(".selected-course").removeClass('active');
					$('.crs_'+$(this).val()).addClass("active")
					getAjaxData($('option:selected',this).attr('level'),$('option:selected',this).attr('class'),$(this).val())
				});
			}
		});
	}
	$(function() {
		if (/Mobi/.test(navigator.userAgent)) {
			setInterval(function() {
				navigator.vibrate();
			}, 3000);
		}
	});
	$(document).on('change',"#topic_dropdown",function(){
		var data = $(this).val();
		if(data) { 
			window.location = data; 
		}
		return false;
	});
	var owl = $('.course-block-list');
	owl.owlCarousel({
		loop: false,
		margin: 30,
		touchDrag: true,
		nav: true,
		dots:false,
		responsive:{
			0:{
				items:1
			},
			671:{
				items:2,
				slideBy:2
			},
			768:{
				items:1
			},
			890:{
				items:2,
				slideBy:2
			},
			1270:{
				items:3,
				slideBy:3
			},
			1640:{
				items:4,
				slideBy:4
			}
		}
	});

	$( ".course-block-list .owl-prev").html('<img src="{{ asset('/public/images/course-carousel-left-icon.png') }}">');
	$( ".course-block-list .owl-next").html('<img src="{{ asset('/public/images/course-carousel-right-icon.png') }}">');
	owl.on('mousewheel', '.owl-stage', function (e) {
		if (e.originalEvent.wheelDelta / 120 > 0) {
			owl.trigger('next.owl');
		} else {
			owl.trigger('prev.owl');
		}
		e.preventDefault();
	});
	
	$(document).on('click', '.liclick', function() {
		document.cookie = "courseId=" + $(this).attr("date-course-new") + "; expires=; path=/";
	});
	$(".loader-needed").click(function(){
		$(".page-loader-wrapper").css('display','block');
	});
	$("#course_dropdown").change(function(){
		$(".tab-pane.fade").removeClass("active show");
		$(".tab__block.active").removeClass("active");
		var course_id = $(this).val();
		var cid  = "pills-"+course_id;
		var sid  = "pills-"+course_id+"-tab";
		$("#"+cid).addClass('active show');
		$("#"+sid).addClass('active');
	});
	$(document).on('click',"#openmodal",function(){
		var url = $(this).attr("data-id");
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
	$(document).ready(function() {
	  $("body").addClass("dashboard-body");
	});
</script>
@endsection