@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style type="text/css">
	.profile_img_loading {
		position: absolute;
		top: 6px;
	}
	.profile_img_loading input {
		width: 60px;
		height: 60px;
		cursor: pointer;
		opacity: 0;
	}
	.profile_heading_title {
		color: #3E5971 !important;
	}
	.update_pass_btn {
		color: #ffffff!important;
		font-size: 14px;
		padding: 3px 15px;
		margin: 0 0 0 30px;
	}
	.update_pass_btn img {
		width: 12px;
		vertical-align: sub;
	}
	.student_profile_header label {
		width: 100%;
		color: #9FA9C5;
		font-size: 1.125rem;
		margin-bottom: 0;
	}
	.student_profile_header span {
		color: #8e98b9;
		font-size: 20px;
	}
	.profile_data_title {
		padding: 2px 0;
		font-weight: 600!important;
	}
	.profile_data_details>div {
		margin-bottom: 10px;
	}
	.profile_data_details label {
		color: #9FA9C5;
		font-size: 1rem;
		margin-bottom: 0px;
	}
	.profile_data_details input[type=text], .profile_data_details input[type=email] {
		color: #8e98b9 !important;
		padding: 0;
		height: 32px;
		font-size: 19px;
	}
	.emeregency-contact > div {
		color: #8e98b9;
	}
	.terms_privacy {
		margin: 10px 0px 0 0;
		padding: 10px 0 0 0;
	}
	.terms_privacy a {
		color: #d55b7d;
	}
	.main .profile .list-register .btn {
		border: 1px solid #ececec;
		background-color: #fff1f5;
	}
	.main .profile-heading {
		margin-bottom: 2rem;
	}
	.modal-content {
		border-radius: 15px;
	}
	.update-modal .modal-body {
		padding: 1rem;
	}
	.update-modal .modal-body h2 {
		text-align: left;
		padding-top: .7rem;
    margin-bottom: 2rem;
	}
	.update-modal .modal-body h2 strong {
		color: #30475e;
	}
	.update_pass_field label {
		color: #30475e;
		margin-bottom: 0;
	}
	.update_pass_field .error {
		color: red;
    font-size: 15px;
	}
</style>
<?php
// dd($profile);
?>
<main class="dashboard">
	<div class="container-fluid">
		<div class="row">
			@include('common.sidebar')
			<!-- /. Sidebar-->
			<section class="main col-sm-12">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
						@if(empty($instration['getdocument'] OR $instration['getvideo']))
			
						@else
						<span class="only-info-details dashboard-info float-right">
							<a href="javascript:void(0);" id="moreInfo"><i class="fas fa-info-circle"></i></a>
							<div class="info-details page-info-details">
								@foreach($instration['getdocument'] as $ins_doc)
								<div class="link1">
									<span><a href="#" id="openmodal" data-id="{{$ins_doc['document_url']}}"><i class="fa fa-file-alt"></i> Click to read</a> <span>{{$ins_doc['document_name']}}</span></span>
								</div>
								@endforeach
								@foreach($instration['getvideo'] as $ins_video)
								<div class="link1">
									<span><a href="#" id="openmodal_forvideo" data-id="{{$ins_video['video_url']}}" data-id2="{{$ins_video['video_id']}}"><i class="fa fa-file-alt"></i> Click to watch</a> <span>{{$ins_video['video_name']}}</span></span>
								</div>
								@endforeach
							</div>
						</span>
						@endif
					</div>
				</div>
				<!-- instruction popup -->
				<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title"><i class="fas fa-file-alt"></i> Instruction</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_video">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body text-center">
								<div id="datas"></div>
							</div>
							<div class="modal-footer justify-content-center">
								<button type="button" class="btn btn-cancel" data-dismiss="modal" id="close_video">Close</button>
							</div>
						</div>
					</div>
				</div>
				<!-- end instruction video -->
				<div class="main__content profile-page pt-0">
				<div class="alert alert-main-page alert-success" role="alert" style="display:none;"></div>
				<div class="alert alert-main-page alert-danger" role="alert" style="display:none"></div>
					<form runat="server" action="" class="student_profile" autocomplete="off" method="POST">
						<input type="hidden" name="file_data"  id="file_data" value="">
						<div class="row">
							<div class="col-12 col-xl-12 profile">
								<div class="row student_profile_header">
									<div class="col-12 col-md-12 col-xl-12">
										<div class="profile-heading d-flex flex-wrap align-items-center justify-content-between">
											<div class="heading-left">

												<?php 
												$profileImage = asset('public/images/nouser.png');
												if(isset($profile['student_image']) && !empty($profile['student_image'])) {
													$profileImage = $profile['student_image'];
												}?>
												<span class="picture">
													<img src="{{ env('S3URL') }}<?php echo $profileImage;?>" alt="Profile Picture" id="profile_img" class="img-fluid img-rounded rounded-circle" style="width: 100%;height: 100%;">
													<div class="profile_img_loading">
														<input type="file" id="profile-img" name="profile-img" value="">
													</div>
												</span>
												<h1 class="profile_heading_title">Hello <?php echo ucwords($profile['firstname'].' '.$profile['lastname']);?></h1>
												<p>Student <a href="javascript:void(0);" class="btn btn-primary update_pass_btn"><i class="fa-solid fa-user-lock"></i> Update Password</a>
												</p>
											</div>
										</div>
									</div>
									<?php //dd($profile)?>
									<div class="col-12 col-sm-6 col-xl-6">
										<label>Academy Name</label>
										<span><?php echo $profile['studentdetails_franchisdetail']['franchise_name'];?></span>
									</div>
									<div class="col-12 col-sm-6 col-xl-6">
										<div class="row">
											<div class="col-12 col-sm-6 col-xl-6">
												<label>Academy ID</label>
												<span><?php echo $profile['franchisecode'];?></span>
											</div>
											<div class="col-12 col-sm-6 col-xl-6">
												<label>Student ID</label>
												<span><?php echo $profile['studentid'];?></span>
											</div>
										</div>
									</div>
								</div>
								<h3 class="profile_data_title">Profile Details</h3>
								<div class="row profile_data_details">
									<div class="col-6 col-md-6">
										<label>First Name</label>
										<input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo ucwords($profile['firstname']);?>" >
									</div>
									<div class="col-6 col-md-6">
										<label>Last Name</label>
										<input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo ucwords($profile['lastname']);?>" >
									</div>
									<div class="col-6 col-md-6">
										<label>Gender</label>
										<select class="form-control form-control_underline form-control-lg" id="gender" name="gender">
											<option value="">Select Gender</option>
											<option value="Male" {{ strtolower(isset($profile['gender'])?$profile['gender']:'') == 'male'?'selected':'' }}>Male</option>
											<option value="Female" {{ strtolower(isset($profile['gender'])?$profile['gender']:'') == 'female'?'selected':'' }}>Female</option>
											<option value="Others" {{ strtolower(isset($profile['gender'])?$profile['gender']:'') == 'others'?'selected':'' }}>Others</option>
										</select>
									</div>
									<div class="col-6 col-md-6">
										<label>Date of Birth</label>
										<input type="text" class="form-control datepicker" id="datepicker" name="date_of_birth" value="<?php echo date('d-m-Y',strtotime(isset($profile['date_of_birth'])?$profile['date_of_birth']:''));?>" readonly>
									</div>
									<div class="col-6 col-md-6">
										<label>Email ID</label>
										<input type="email" class="form-control" value="<?php echo $profile['email'];?>" disabled>
									</div>
									<div class="col-6 col-md-6">
									<label>Contact Number</label>
									<input type="text" class="form-control" name='phone' id='phone' value="{{isset($profile['phone'])?$profile['phone']:''}}" >
									</div>
									<div class="col-12 col-sm-6 col-md-12">
										<label>Country</label>
										<select id="country-dropdown" class="form-control input_country" name="country">
											<option value=""selected>Country</option>
                                                <?php foreach($countries as $country){?>
                                                    <?php //dd($countrys_name);?>
                                                    <option value="<?php echo $country['id'];?>" <?php if(isset($profile['country']) && ($country['id'] == $profile['country'])){?> selected="selected" <?php }?> ><?php echo $country['name'];?></option>
                                                <?php }?>
										</select>
									</div>
								</div>
								<div class="row w-100 text-center">
									<div class="col-12 col-sm-12 col-xl-12 mt-3 mb-5">
										<a href="javascript:void(0);" class="btn btn-primary update_profile_btn" id='update_profile_btn'>Update</a>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</section>
		</div>
	</div>
</main>
<div class="modal fade" id="updatedata" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa-solid fa-user-lock"></i>Update Password</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="" id="my_form" autocomplete="off" method="post" onsubmit="return false;">
			<div class="modal-body">
					<div class="update_pass_field">
						<h6 for="old_password">Current Password</h6>
						<input type="password" name="old_password" id="old_password" class="form-control" placeholder="Type here..">
					</div>

					<div class="update_pass_field mt-3">
						<h6 for="new_password">New Password</h6>
						<input type="password" name="new_password" id="new_password" class="form-control"  placeholder="Type here..">
					</div>

					<div class="update_pass_field mt-3">
						<h6 for="new_password_c">Confirm New Password</h6>
						<input type="password" name="new_password_c" id="new_password_c" class="form-control"  placeholder="Type here..">
					</div>
					
					<div class="form-group__verification_error" id="error_message" style="display:none;">
						<div class="d-flex alert alert-danger text-center mb-0">
							<span class="error-img">
								<img src="{{ asset('public/images/icon-invalid-code.svg') }}" alt="">
							</span>
							<span class="error-text"></span>
						</div>
					</div>
					
					<div class="form-group__verification_error" id="success_message" style="display:none;">
						<div class="d-flex alert alert-success text-center mb-0">
							<span class="success-text"></span>
						</div>
					</div>
				</div>
				
				<div class="modal-footer justify-content-center">
					<button type="submit" class="btn  btn-primary" id="updPass"><i class="fa-regular fa-floppy-disk"></i> Update</button>
					<button type="button" class="btn  btn-cancel" data-dismiss="modal">Cancel</button>
				</div>
			</form>

		</div>
	</div>
</div>

<div class="modal fade" id="terms_condition" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa-solid fa-newspaper"></i> Terms & Conditions</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">@include('terms')</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn  btn-cancel" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="privacy_policy" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa-solid fa-newspaper"></i> Privacy policy</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">@include('privacy-policy')</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn  btn-cancel" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">   
$(document).ready(function() {
	$('.update_pass_btn').click(function(){
		$("#updatedata #success_message").hide();
		$("#updatedata #error_message").hide();
		$('#old_password').val("")
		$('#new_password').val("")
		$('#new_password_c').val("")
		$('#updatedata').modal('show');
	})
});
$(document).on('click',".update_profile_btn" ,function() {
		var filter 		= /^\d*(?:\.\d{1,2})?$/;
		var saveFlag = true;
		if($('#firstname').val() == ""){
			saveFlag = false;
			$('.alert-danger').show().html("Please enter firstname.").fadeOut(8000);
		}else if($('#lastname').val() == ""){
			saveFlag = false;
			$('.alert-danger').show().html("Please enter lastname.").fadeOut(8000);
		}else if($('#gender').val() == ""){
			saveFlag = false;
			$('.alert-danger').show().html("Please select gender.").fadeOut(8000);
		}else if($('#datepicker').val() == ""){
			saveFlag = false;
			$('.alert-danger').show().html("Please select dob.").fadeOut(8000);
		}
		else if($('#country-dropdown').val() == ""){
			saveFlag = false;
			$('.alert-danger').show().html("Please select Country.").fadeOut(8000);
		}
		// alert(saveFlag)
		if(saveFlag){
		  	$(".update_profile_btn").css('pointer-events',"none");
		 	$(this).text("Updating..")
			$.ajax({
			  	url: "{{url('profile/student-update')}}",
			  	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			  	type: 'POST',
			  	data: $(".student_profile").serialize(),
			  	success: function (data) {
					$(".update_profile_btn").text("Update")
					$(".update_profile_btn").removeAttr('disabled');
					$('.alert-success').show().html(data.message).fadeOut(8000);
					$(".update_profile_btn").css('pointer-events',"all");
			  	}
			});
		}
	});
</script>
<script type="text/javascript">
$.validator.addMethod("notEqual", function(value, element, param) {
 return this.optional(element) || value != $(param).val();
}, "New Password can not be same as current password");
$("#my_form").validate({
	rules: {
		old_password: {
			required: !0,
		},
		new_password: {
			required: !0,
			minlength : 5,
			notEqual: "#old_password"
		},
		new_password_c: {
			required: !0,
			minlength : 5,
			equalTo : "#new_password"
		}
	},
	submitHandler: function(form) {
		$("#my_form").find("input[type='submit']").prop("disabled",true);
		$("#my_form").find("input[type='submit']").attr("value","Updating...");
		$("#my_form").find("button[type='submit']").prop("disabled",true);
		$("#my_form").find("button[type='submit']").text("Updating...");
		$.ajaxSetup({
			  headers: {
				  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			  }
		});
		$.ajax({
			type: "POST",
			url: '{{ URL("profile/reset_password") }}',
			data : $("#my_form").serialize(),
			// dataType: "json",
			success: function(res) {
				if(!res.success){
					$("#error_message .error-text").text(res.message);
					$("#error_message").show();
					$("#success_message .success-text").text('');
					$("#success_message").hide();
					
				}else{
					$("#error_message .error-text").text('');
					$("#error_message").hide();
					$("#success_message .success-text").text(res.message);
					$("#success_message").show();
					$("#my_form")[0].reset();
				}
				
				$("#my_form").find("input[type='submit']").prop("disabled",false);
				$("#my_form").find("input[type='submit']").attr("value","Update");
				$("#my_form").find("button[type='submit']").prop("disabled",false);
				$("#my_form").find("button[type='submit']").text("Update");
			}
		});
		// return false;								
	}
})
function readIMG(input) {
  if(input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
    	$('#file_data').val(e.target.result)
      $('#profile_img').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#profile-img").change(function() {
  readIMG(this);
});
$("#date").datepicker();
</script>
  <script>
  $( function() {
    $(".datepicker").datepicker({  dateFormat: 'dd-mm-yy', maxDate: new Date(), changeYear: true, changeMonth: true,maxDate: "-0Y", minDate: "-100Y",yearRange: "-100:-0"  });
  });
  </script>
@endsection