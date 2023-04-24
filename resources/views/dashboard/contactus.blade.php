@extends('layouts.app')
@section('content')
<main class="dashboard">
	<div class="container-fluid">
		<div class="row">
			@include('common.sidebar')
			<section class="main academyContactUs col-sm-12">
				<div class="col-12 d-flex justify-content-center p-3">
					<h1 class="pageheading">
						<span style="display: inline-flex;"><i class="fas fa-headset"></i></span> Contact Us</h1>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<div class="row">
						<div class="col-md-3 col-lg-3 col-xl-3 d-sm-none d-md-block"></div>
						<div class="col-md-6 col-lg-6 col-xl-6 text-center">
							<div class="AcademyLogo">
								@if(isset($userdata['logo_type']) == 1)
									<img src="{{ asset('/public/images/logo-blue.svg') }}" alt="Academy Logo">
								@elseif(isset($userdata['logo_type']) == 2 || isset($userdata['logo_type']) == 3)
									<img src="{{env('S3URL')}}{{$userdata['logo_img']}} " alt="Academy Logo">
								@endif
							</div>
						</div>
						<div class="col-md-3 col-lg-3 col-xl-3 d-sm-none d-md-block"></div>
					</div>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-11 offset-xl-1">
					<div class="row academy_contact_details">
						<div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
							<h4>Address</h4>
							<span class="title-icon"><i class="fa fa-map-marker-alt"></i></span>
							<div class="academy_address">
								<span>{{ isset($userdata['address1'])?$userdata['address1']:'' }}</span>
								<span>{{ isset($userdata['address2'])?$userdata['address2']:'' }}</span>
								<span>{{ isset($userdata['city_list']['name'])?$userdata['city_list']['name']:'' }} - {{ isset($userdata['pincode'])?$userdata['pincode']:'' }}, {{ isset($userdata['state_list']['name'])?$userdata['state_list']['name']:'' }}, {{ isset($userdata['country_list']['name'])?$userdata['country_list']['name']:'' }}.</span>
							</div>
						</div>
						<div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
							<h4>Contact Us</h4>
							<span class="title-icon"><i class="fa fa-envelope-open"></i></span>
							<div class="contact_details">
								<h5 class="mb-0">Call</h5>
								<span><a href="tel:{{ isset($userdata['franchise_owner_phone'])?$userdata['franchise_owner_phone']:'' }}">{{ isset($userdata['franchise_owner_phone'])?$userdata['franchise_owner_phone']:'' }}</a></span>
								<h5 class="mt-3 mb-0">E-mail</h5>
								<span><a href="mailto:{{ isset($userdata['femail'])?$userdata['franchise_email']:'' }}">{{ isset($userdata['franchise_email'])?$userdata['franchise_email']:"" }}</a></span>
							</div>
						</div>
						<div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
							<h4>Social Network</h4>
							<span class="title-icon"><i class="fa fa-mobile-alt"></i></span>
							<div class="media_icons">
								@if(isset($userdata['facebook'])&& $userdata['facebook']!="")
									<a href="{{ isset($userdata['facebook'])?$userdata['facebook']:'' }}" target="_blank"><i class="fa-brands fa-facebook-f mr-3"></i></a>
								@else
								    <a href="{{ isset($ieuk_socialmedia['facebook'])?$ieuk_socialmedia['facebook']:'' }}" target="_blank"><i class="fa-brands fa-facebook-f mr-3"></i></a>
								@endif
								
								@if(isset($userdata['instagram'])&& $userdata['instagram']!="")
									<a href="{{ isset($userdata['instagram'])?$userdata['instagram']:'' }}" target="_blank"><i class="fa-brands fa-instagram mr-3"></i></a>
								@else
								    <a href="{{ isset($ieuk_socialmedia['instagram'])?$ieuk_socialmedia['instagram']:'' }}" target="_blank"><i class="fa-brands fa-instagram mr-3"></i></a>
								@endif

								@if(isset($userdata['twitter'])&& $userdata['twitter']!="")
									<a href="{{ isset($userdata['twitter'])?$userdata['twitter']:'' }}" target="_blank"><i class="fa-brands fa-twitter mr-3"></i></a>
								@else
								    <a href="{{ isset($ieuk_socialmedia['twitter'])?$ieuk_socialmedia['twitter']:'' }}" target="_blank"><i class="fa-brands fa-twitter mr-3"></i></a>
								@endif

								@if(isset($userdata['youtube'])&& $userdata['youtube']!="")
									<a href="{{ isset($userdata['youtube'])?$userdata['youtube']:'' }}" target="_blank"><i class="fa-brands fa-youtube mr-3"></i></a>
								@else
								    <a href="{{ isset($ieuk_socialmedia['youtube'])?$ieuk_socialmedia['youtube']:'' }}" target="_blank"><i class="fa-brands fa-youtube mr-3"></i></a>
								@endif
							</div>
							<div class="tandc">
								<span>Our <a  id="terms_condition_open">terms of use</a></span>
								<span>& <a  id="privacy-policy">privacy policy</a></span>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>  
</main> 
<div class="modal fade" id="privacy-policy1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">                 
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa-solid fa-newspaper"></i> Privacy Policy</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				@include('profile.privacy-policy')
			</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>  
<div class="modal fade" id="terms" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
	<div class="modal-dialog modal-xl">
		<div class="modal-content"> 
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa-solid fa-newspaper"></i> Terms of use</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				@include('profile.terms')
			</div>               
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#terms_condition_open').click(function(){
			$('#terms').modal('show');
		});
		$('#privacy-policy').click(function(){
			$('#privacy-policy1').modal('show');
		});
	})
</script>
@endsection