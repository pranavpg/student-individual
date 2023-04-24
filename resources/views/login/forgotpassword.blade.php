@extends('layouts.app')
@section('content')
<style>
	.menu-option{
		display:none;
	}
</style>
<link href="{{ asset('public/css/_login.css') }}?n={{ env('CACTH') }}" rel="stylesheet">

<div class="login-main d-flex flex-wrap">
	<div class="w-55 login-sidebar">
		<div class="logo mb-5">
			<img src="{{ asset('public/images/logo-main.svg') }}" alt="IEUK Student" class="img-fluid" width="100%">
		</div>
		<div class="login-slider">
			<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
				<div class="carousel-item active">
						<img src="{{asset('public/images/ieuk-mobile-logo.png')}}" class="d-block" alt="Digital Learning">
						<div class="carousel-caption">
							<h2>British Standard, Quality and Qualification</h2>
						</div>
					</div>
					<div class="carousel-item">
						<img src="{{asset('public/images/icon-digital-learning.svg')}}" class="d-block w-100" alt="Digital Learning">
						<div class="carousel-caption">
							<h2>Digital Learning</h2>
							<p>Welcome to the world of Imperial English UK, a place where there is no limit to what you can achieve. </p>
						</div>
					</div>
					<div class="carousel-item">
						<img src="{{asset('public/images/icon-creative-learning.svg')}}" class="d-block w-100" alt="Creative Learning">
						<div class="carousel-caption">
							<h2>Creative Learning</h2>
							<p>Task based activities to stimulate your mind and encourage analysis of performance to develop as an independent learner. </p>
						</div>
					</div>
					<div class="carousel-item">
						<img src="{{asset('public/images/icon-graded-learning.svg')}}" class="d-block w-100" alt="Graded Learning">
						<div class="carousel-caption">
							<h2>Graded Learning</h2>
							<p>Exposure to authentic, natural models of English designed to meet your needs & requirements.</p>
						</div>
					</div>
				</div>
				<ol class="carousel-indicators">
					<li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
					<li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
					<li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
					<li data-target="#carouselExampleCaptions" data-slide-to="3"></li>
				</ol>
			</div>
		</div>
	</div>

	<div class="login-form w-45 d-flex flex-wrap justify-content-center align-items-center ieuk-forgtpp">
		<div class="back-button">
			<a href="<?php echo URL('/')?>">
				<img src="{{ asset('public/images/icon-back.svg')}}" alt="Back" class="img-fluid">
			</a>
		</div>
		<div class="login">
			<div class="login-heading">
				<div class="heading-icon">
					<img src="{{asset('public/images/icon-forget-password.svg')}}" alt="Student login" class="img-fluid">
				</div>
				<h1><strong>Forgot</strong> Password</h1>
				<p>Enter your registered e-mail</p>
			</div>
			<div class="login__form">
				<form action="" id="my_form" method="post" onsubmit="return false;">
					<div class="form-group form-group__verification_error" id="error_message">
						<em class="d-flex">
							<span class="error-img">
								<img src="{{ asset('public/images/icon-invalid-code.svg')}}" alt="">
							</span>
							<span class="error-text"></span>
						</em>
					</div>
					<div class="form-group form-group__verification_error" id="success_message">
						<em class="d-flex">
							<span class="success-img">
								<img src="{{ asset('public/images/icon-invalid-code.svg') }}" alt="">
							</span>
							<span class="success-text"></span>
						</em>
					</div>
			
					<div class="form-label-group form-label-group__last">
						<input type="email" class="form-control form-control__email" placeholder="" name="user_email" id="user_email"  autocomplete="off">
						<label for="user_email">Email ID</label>
						<div class="invalid-feedback">Invalid E-mail</div>
					</div>

					<div class="form-group form-group__button">
						<button type="submit" class="btn btn-danger btn-sm mb-2">Recover</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.19/jquery.touchSwipe.min.js"></script>

<script type="text/javascript">

	$(".carousel .carousel-inner").swipe({
  swipeLeft: function (event, direction, distance, duration, fingerCount) {
    this.parent().carousel("next");
  },
  swipeRight: function () {
    this.parent().carousel("prev");
  },
  threshold: 0,
  tap: function (event, target) {
    window.location = $(this).find(".carousel-item.active a").attr("href");
  },
  excludedElements: "label, button, input, select, textarea, .noSwipe"
});

</script>

<script type="text/javascript">

$("#my_form").validate({
	rules: {
		user_email: {
			required: !0,
			email: !0,
		}
	},
	errorElement: "div",
	errorClass: "invalid-feedback",
	submitHandler: function(form) {
		$("#my_form").find("input[type='submit']").prop("disabled",true);
		$("#my_form").find("input[type='submit']").attr("value","Submitting...");
		$("#my_form").find("button[type='submit']").prop("disabled",true);
		$("#my_form").find("button[type='submit']").text("Submitting...");
		$.ajaxSetup({
			  headers: {
				  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			  }
		});
		$.ajax({
			type: "POST",
			url: '{{ URL("forgotpassword_post") }}',
			data : $("#my_form").serialize(),
			dataType: "json",
			success: function(res) {
				if(!res.success){
					$("#error_message .error-text").text(res.message);
					$("#error_message").show();
					$("#success_message .success-text").text('');
					$("#success_message").hide();
				}else{
					$("#success_message .success-text").text(res.message);
					$("#success_message").show();
					$("#error_message .error-text").text('');
					$("#error_message").hide();
				}
				$("#my_form").find("input[type='submit']").prop("disabled",false);
				$("#my_form").find("input[type='submit']").attr("value","Recover");
				$("#my_form").find("button[type='submit']").prop("disabled",false);
				$("#my_form").find("button[type='submit']").text("Recover");
			}
		});
		return false;
	}
})
</script>
@endsection