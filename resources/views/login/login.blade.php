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
			<div class="row">
				<div class="col-12 col-md-12 media_buttons">
					<a href="https://play.google.com/store/apps/details?id=com.ieuk_student&hl=en_IN&gl=US" target="_blank">
						<img style="width: 40%;max-width: 190px;margin-top: 10px;margin-right: 15px;" alt="Google Play" src="{{ asset('public/images/ieuk-student-app-playstore.png') }}">
					</a>
					<a href="https://www.youtube.com/watch?v=vQ1XZXSY0Ng" target="_blank">
						<img style="width: 40%;max-width: 190px;margin-top: 10px;" alt="instructions" src="{{ asset('public/images/ieuk-student-app.png') }}">
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="login-form w-45 d-flex flex-wrap justify-content-center align-items-center">
		<div class="login">
			<div class="login-heading">
				<div class="heading-icon">
					<img src="{{asset('public/images/icon-login-user.svg')}}" alt="Student login" class="img-fluid">
				</div>
				<h1><strong>Student</strong> Login</h1>
			</div>
			<div class="login__form">
				<form action="" id="my_form" autocomplete="off" method="post" onsubmit="return false;">
					<input autocomplete="false" name="hidden" type="text" style="display:none;">
					<div class="form-group form-group__verification_error" id="error_message">
						<em class="d-flex">
							<span class="error-img">
								<img src="{{ asset('public/images/icon-invalid-code.svg') }}" alt="">
							</span>
							<span class="error-text" style="max-width:300px;"></span>
						</em>
					</div>
					<div class="form-label-group">
						<input type="text" class="form-control form-control__email" placeholder="" name="user_email" id="user_email"  autocomplete="off">
						<label for="user_email">Email address</label>
						<div class="invalid-feedback">Invalid E-mail</div>
					</div>

					<div class="form-label-group form-label-group__last position-relative">
						<input type="password" class="form-control form-control__password" autocomplete="off" placeholder="" name="user_password" id="user_password">
						<label for="user_password">Password</label>
						<i id="eye-icon" class="fa fa-eye"></i>
						<div class="invalid-feedback">Invalid password</div>
					</div>

					<button type="submit" class="btn btn-danger btn-sm mb-2">Sign In</button>
					<p><a href="<?php echo URL('forgot-password')?>">Forgot your password?</a></p>
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
		user_password: {
			required: !0,
		},
		user_email: {
			required: !0,
			//email: !0,
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
			url: '{{ URL("login_post") }}',
			data : $("#my_form").serialize(),
			dataType: "json",
			success: function(res) {
				if(!res.success){
					$("#error_message .error-text").text(res.message);
					$("#error_message").show();
				}else{
                    if(res.profile_page != '' ){
                        window.location = '{{ URL("/profile-create") }}';
                    }else{
                        $("#error_message .error-text").text('');
					    $("#error_message").hide();
					    window.location = '{{ URL("/") }}';
                    }

				}
				$("#my_form").find("input[type='submit']").prop("disabled",false);
				$("#my_form").find("input[type='submit']").attr("value","Sign In");
				$("#my_form").find("button[type='submit']").prop("disabled",false);
				$("#my_form").find("button[type='submit']").text("Sign In");
			}
		});
		return false;
	}
})
</script>
<script>
$(document).ready(function(){

	$("#eye-icon").click(function(){
	  $("#user_password").toggleClass('form-control__password_hidden');
	  $("#user_password").toggleClass('form-control__password');
	  
	$('.form-control__password').prop("type", 'password');
	$('.form-control__password_hidden').prop("type", 'text');

 	});
});
</script>
@endsection
