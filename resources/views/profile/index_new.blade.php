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
	/*.emeregency-contact label {
		width: 100%;
		color: #646464;
		font-size: 1rem;
		margin-bottom: 0px;
	}*/
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
	/* .update-modal {
		min-width: 400px;
	} */
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
						<!-- <span class="only-info-details dashboard-info float-right">
							<a href="javascript:void(0);" id="moreInfo"><i class="fas fa-info-circle"></i></a>
							<div class="info-details page-info-details">
								<div class="link1">
									<span><a href="javascript:void(0);" id="openmodal"><i class="fa fa-file-alt"></i> Click to read</a> <span>Instructions</span></span>
								</div>
							</div>
						</span> -->
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
				<!-- end instruction video -->
				<div class="main__content profile-page pt-0">
				<div class="alert alert-main-page alert-success" role="alert" style="display:none;"></div>
				<div class="alert alert-main-page alert-danger" role="alert" style="display:none"></div>
					<form runat="server" action="" class="student_profile" autocomplete="off" method="POST">
						<input type="hidden" name="file_data"  id="file_data" value="">
						<div class="row">
							<div class="col-12 col-xl-6 profile">
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
													<img src="<?php echo $profileImage;?>" alt="Profile Picture" id="profile_img" class="img-fluid img-rounded rounded-circle" style="width: 100%;height: 100%;">
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
												<span><?php echo $profile['student_id'];?></span>
											</div>
										</div>
									</div>
								</div>
								<h3 class="profile_data_title">Profile Details</h3>
								<div class="row profile_data_details">
									<div class="col-6 col-md-6">
										<label>First Name</label>
										<input type="text" class="form-control" id="name" name="firstname" value="<?php echo ucwords($profile['firstname']);?>" >
									</div>
									<div class="col-6 col-md-6">
										<label>Last Name</label>
										<input type="text" class="form-control" id="name" name="lastname" value="<?php echo ucwords($profile['lastname']);?>" >
									</div>
									<div class="col-6 col-md-6">
										<label>Gender</label>
										<select class="form-control form-control_underline form-control-lg" id="gender" name="gender">
											<option value="">Select Gender</option>
											<option value="Male" {{ strtolower($profile['gender']) == 'male'?'selected':'' }}>Male</option>
											<option value="Female" {{ strtolower($profile['gender']) == 'female'?'selected':'' }}>Female</option>
											<option value="Others" {{ strtolower($profile['gender']) == 'others'?'selected':'' }}>Others</option>
										</select>
										<!-- <input type="text" class="form-control" name='gender' value="<?php echo $profile['gender'];?>" > -->
									</div>

									<div class="col-6 col-md-6">
										<label>Date of Birth</label>
										<input type="text" class="form-control datepicker" id="datepicker" name="date_of_birth" value="<?php echo date('d-m-Y',strtotime($profile['date_of_birth']));?>" >
									</div>
									<div class="col-6 col-md-6">
										<label>Email ID</label>
										<input type="email" class="form-control" value="<?php echo $profile['email'];?>" disabled>
									</div>
									<div class="col-6 col-md-6">
										<label>Contact Number</label>
										<input type="text" class="form-control" name='phone' id='phone' value="<?php echo $profile['phone'];?>" >
									</div>
									<div class="col-12 col-sm-6 col-md-4">
										<label>Country</label>
										<select id="country-dropdown" class="form-control input_country" name="country">
											<option selected>Country</option>
                                                <?php foreach($countries as $country){?>
                                                    <?php //dd($countrys_name);?>
                                                    <option value="<?php echo $country['id'];?>" {{$country['id'] == $profile['country'] ? 'selected' :''}} ><?php echo $country['name'];?></option>
                                                <?php }?>
										</select>
									</div>
									<div class="col-12 col-sm-6 col-md-4">
									<label>State</label>
									@if($profile['state'] == "NULL")
										<select id="state-dropdown" class="form-control" name="state">
	                                        <option value=""></option>
										</select>
									@else
										<select id="state-dropdown" class="form-control" name="state">
	                                        <option value="<?php echo $profile['state'];?>" {{$profile['state'] == $profile['state'] ? 'selected' :''}} ><?php echo $profile['state_list']['name'];?></option>
										</select>
									@endif
									</div>
									<div class="col-12 col-sm-6 col-md-4">
									<label>City</label>
									@if($profile['city'] == "NULL")
									<select id="city-dropdown" class="form-control" name="city">
										<option value="" ></option>
									</select>

									@else
									<select id="city-dropdown" class="form-control" name="city">
										<option value="<?php echo $profile['city'];?>" {{$profile['city'] == $profile['city'] ? 'selected' :''}} ><?php echo $profile['city_list']['name'];?></option>
									</select>
									@endif
									</div>
									<div class="col-12 col-md-12">
										<label>Address</label>
										<input type="text" class="form-control" name="address"  id="address" value="<?php echo $profile['address'].' '.$profile['city'].' '.$profile['country'];?>" >
									</div>
									<div class="col-12 col-sm-6 col-md-6">
										<label for="" class="mr-3">Ethnicity: </label>
										<select class="form-control form-control_underline form-control-lg" name="ethnicity" id="ethnicity">
											<option value="">Select Ethnicity</option>
											@foreach($data['ethnicity'] as $item)
											<option value="{{$item}}" {{$item==$profile['ethnicity'] ? 'selected' :''}}>{{$item}}</option>
											@endforeach
										</select>
									</div>
									<div class="col-12 col-sm-6 col-md-6">
										<label for="" class="mr-3">Employment Status: </label>
										<select class="form-control form-control_underline form-control-lg" name="employment_status" id="employment_status">
											<option value="">Select Employment Status</option>
											@foreach($data['employment_status'] as $item)
											<option value="{{$item}}" {{$item == $profile['employment_status'] ? 'selected' :''}}>{{$item}}</option>
											@endforeach
										</select>
									</div>

									<div class="col-12 col-md-12">
										<label for="" class="mr-3">Ability Status: </label>
										<select class="form-control form-control_underline form-control-lg" name="ability_status"  id="ability_status" >
											<option value="">Select Ability Status</option>
											@foreach($data['ability_status'] as $item)
											<option value="{{$item}}" {{$item == $profile['ability_status'] || strtolower($item) == $profile['ability_status'] ? 'selected' :''}}>{{$item}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<h6 class="terms_privacy text-center mb-5">View <a href="#" id="terms_condition_open">Terms &amp; Conditions</a> and <a href="#" id="privacy-policy">Privacy Policy</a></h6>
									</div>
								</div>
							</div>
							
							<div class="col-12 col-xl-6 profile profile__right" id="EmContact">
								<h3 class="profile_data_title">Student Course & Level</h3>
								<ul class="list-inline list-register">
									<?php //dd($student_level)?>
									<?php if(isset($onlyCourse) && !empty($onlyCourse)){
									foreach($onlyCourse as $level){?>
									<li class="list-inline-item mb-2"> <a href="javascript:void(0);" class="btn btn-secondary text-left"> <b>Course Name:&nbsp;&nbsp;</b><?php echo $level['course']['coursetitle'];?><br/><b>Level :&nbsp;&nbsp;</b><?php echo $level['level']['leveltitle']?></a> </li>
									<?php }?>
									<?php }else{ ?>
									<li class="list-inline-item"> <p style="color:#d55b7d;"> No Level Found.</p></li>
									<?php }?>
								</ul>
								<h3 class="profile_data_title">Registered Class(es)</h3>
								<p>If this information is incorrect or you need to update your details please contact your Academy</p>
								<ul class="list-inline list-register">
									<?php //dd($class_list_new)?>
									<?php if(isset($class_list_new) && !empty($class_list_new)){
									foreach($class_list_new as $class){?>
									<li class="list-inline-item mb-2"> <a href="javascript:void(0);" class="btn btn-secondary"> <?php echo $class['class_name'];?></a> </li>
									<?php }?>
									<?php }else{ ?>
									<li class="list-inline-item"> <p style="color:#d55b7d;"> No Class Found.</p></li>
									<?php }?>
								</ul>
								<h3 class="profile_data_title">Registered Teachers</h3>
								<!-- <p>If this information is incorrect or you need to update your details please contact your Academy</p> -->
								<ul class="list-inline list-register">
									<?php //dd($teacherlist)?>
									<?php if(isset($teacherlist) && !empty($teacherlist)){
									foreach($teacherlist as $teacher){?>
									<li class="list-inline-item mb-2"> <a href="javascript:void(0);" class="btn btn-secondary text-left"><b>Teacher Name:&nbsp;&nbsp;</b> @if($teacher['teacher_name']=="")<?php echo "not found"?>  @else <?php echo $teacher['teacher_name'];?>@endif<br><b>Teacher Email:&nbsp;&nbsp;</b> <?php echo $teacher['teacher_email'];?></a> </li>
									<?php }?>
									<?php }else{ ?>
									<li class="list-inline-item"> <p style="color:#d55b7d;"> No Teacher Found.</p></li>
									<?php }?>
								</ul>

								<h3 class="profile_data_title">Medical Record </h3>
								<p><small>Notes :- If you have any medical conditions or take regular medications please tell us about it below. e.g. Dyslexia, allergies, diabetes, blood pressure, autism, asthma etc. Please also write in the event of an emergency what steps can a teacher or school take to help you e.g. a number for your local doctor, where you keep the medications etc.</small>
								</p>
								<div class="form-group">
									<textarea class="form-control" placeholder="write here" name="medical_record">{{isset($profile['medical_record'])?$profile['medical_record']:""}}</textarea>
								</div>

								<input type="hidden" name="emmergency_contact_name1" id="emmergency_contact_name1" value="{{isset($profile['emmergency_contact_name1'])?$profile['emmergency_contact_name1']:''}}">
                <input type="hidden" name="emmergency_contact_relationshipstatus1" id="emmergency_contact_relationshipstatus1" value="{{isset($profile['emmergency_contact_relationshipstatus1'])?$profile['emmergency_contact_relationshipstatus1']:''}}">
                <input type="hidden" name="emmergency_mobile1" id="emmergency_mobile1" value="{{isset($profile['emmergency_mobile1'])?$profile['emmergency_mobile1']:''}}">
                <input type="hidden" name="emmergency_contact_email1" id="emmergency_contact_email1"  value="{{isset($profile['emmergency_contact_email1'])?$profile['emmergency_contact_email1']:''}}">

                <input type="hidden" name="emmergency_contact_name2" id="emmergency_contact_name2" value="{{isset($profile['emmergency_contact_name2'])?$profile['emmergency_contact_name2']:''}}">
                <input type="hidden" name="emmergency_contact_relationshipstatus2" id="emmergency_contact_relationshipstatus2" value="{{isset($profile['emmergency_contact_relationshipstatus2'])?$profile['emmergency_contact_relationshipstatus2']:''}}">
                <input type="hidden" name="emmergency_mobile2" id="emmergency_mobile2" value="{{isset($profile['emmergency_mobile2'])?$profile['emmergency_mobile2']:''}}">
                <input type="hidden" name="emmergency_contact_email2" id="emmergency_contact_email2"  value="{{isset($profile['emmergency_contact_email2'])?$profile['emmergency_contact_email2']:''}}">

								<h3 class="profile_data_title">Emergency Contact</h3>

								<div class="appendHtml">
									@if(!empty($profile['emmergency_contact_name1']) && !empty($profile['emmergency_contact_email1']))
									<div class="emeregency-box mb-0">
										<a href="javascript:void(0);" class="edit" data="1"><img src="{{ asset('public/images/icon-edit-pen.svg') }}" alt="Pen" class="img-fluid"> </a>
										<div class="row emeregency-contact mb-0">
											<div class="col-5 emeregency-name1" style="word-break: break-word;"><label>Name:</label> <?php echo $profile['emmergency_contact_name1'];?> </div>
											<div class="col-7 emeregency-rela1" style="word-break: break-word;"><label>Relation:</label> <?php echo $profile['emmergency_contact_relationshipstatus1'];?> </div>
											<div class="col-5 emeregency-mobile1" style="word-break: break-word;"><label>Contact No:</label> <?php echo $profile['emmergency_mobile1'];?> </div>
											<div class="col-7 emeregency-email1" style="word-break: break-word;" ><label>Email:</label> <?php echo $profile['emmergency_contact_email1'];?> </div>
										</div>
									</div>
									@endif

									@if(!empty($profile['emmergency_contact_name2']) && !empty($profile['emmergency_contact_email2']))
									<div class="emeregency-box">
										<a href="javascript:void(0);" class="edit" data="2"><img src="{{ asset('public/images/icon-edit-pen.svg') }}" alt="Pen" class="img-fluid"> </a>
										<div class="row emeregency-contact">
											<div class="col-5 emeregency-name2" style="word-break: break-word;"><label>Name:</label> <?php echo $profile['emmergency_contact_name2'];?> </div>
											<div class="col-7 emeregency-rela2" style="word-break: break-word;"><label>Relation:</label> <?php echo $profile['emmergency_contact_relationshipstatus2'];?> </div>
											<div class="col-5 emeregency-mobile2" style="word-break: break-word;"><label>Contact No:</label> <?php echo $profile['emmergency_mobile2'];?> </div>
											<div class="col-7 emeregency-email2" style="word-break: break-word;"><label>Email:</label> <?php echo $profile['emmergency_contact_email2'];?> </div>
										</div>
									</div>
									@endif
								</div>

								@if(empty($profile['emmergency_contact_name1']) ||  empty($profile['emmergency_contact_name2']))
								<a class="btn btn-primary btn-add-emeregency btn-block" onclick="openmodel();"> 
									<span><img src="{{ asset('public/images/icon-plus-small-pink.svg') }}" alt="+" class="img-fluid"></span> Add Emergency Contact 
								</a> 
								@endif
								<div class="row w-100 text-center">
									<div class="col-12 col-sm-12 col-xl-12 mt-3 mb-5">
										<a href="javascript:void(0);" class="btn btn-primary update_profile_btn" id='update_profile_btn'>Update</a>
									</div>
								</div>
							</div>

							<!-- pop up model -->
							<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
								<div class="modal-dialog">
									<div class="modal-content">
											<input type="hidden" name="course_id" id="course_id" value="" />
											<div class="modal-header">
												<div class="modal-title"><i class="fa-solid fa-address-book"></i> Emergency Contact Details</div>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">×</span>
												</button>
											</div>
											<div class="modal-body">
												<div class="form-group">
													<label for="t1">Name</label>
													<input type="text" id ="t1" name="name" class="form-control">
												</div>
												<div class="form-group">
													<label for="t2">Relation</label>
													<input type="text" id ="t2" name="relation" class="form-control">
												</div>
												<div class="form-group">
													<label for="t3">Mobile Number</label>
													<input type="tel" id="t3" name="mono" class="form-control">
												</div>
												<div class="form-group">
													<label for="t4">Email Address</label>
													<input type="text" id ="t4" name="email" class="form-control">
												</div>

												<div class="form-group form-group__verification_error invalid-feedback" id="error_message" style="display:none;">
												<em class="d-flex">
													<span class="error-img">
														<img src="{{ asset('public/images/icon-invalid-code.svg') }}" alt="">
													</span>
													<span class="error-text"></span>
												</em>
											</div>

											<div class="form-group form-group__verification_success" id="success_message" style="display:none;">
												<em class="d-flex">
													<span class="success-img">
														<img src="{{ asset('public/images/icon-invalid-code.svg') }}" alt="">
													</span>
													<span class="success-text"></span>
												</em>
											</div>
											
											</div>
											<div class="modal-footer justify-content-center">
												<button  type="button" class="btn btn-primary" id="submitbtn">
												<i class="fa-regular fa-floppy-disk"></i> Save
												</button>
												<button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
											</div>
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
				<!-- <picture class="picture">
					<img src="{{ asset('public/images/icon-modal-updatepassword.svg') }}" alt="Update" class="img-fluid">
				</picture>
				<h2><strong>Update</strong> Password</h2> -->
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
							<!-- <span class="success-img">
								<img src="{{ asset('public/images/icon-invalid-code.svg') }}" alt="">
							</span> -->
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
			<!-- <div class="modal-footer">
				<div class="row">
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
						<button type="button" class="btn btn-save" data-dismiss="modal">Ok</button>
					</div>
				</div>
			</div> -->
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
			<!-- <div class="modal-footer">
				<div class="row">
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
						<button type="button" class="btn btn-save" data-dismiss="modal">Ok</button>
					</div>
				</div>
			</div> -->
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn  btn-cancel" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
    $(function() {
        // disable all the input boxes
        $("#state-dropdown").attr("disabled", true);
		$("#city-dropdown").attr("disabled", true);
        // add handler to re-enable input boxes on click
        $("#country-dropdown").click(function() {
            $("#state-dropdown").attr("disabled", false);
			$("#city-dropdown").attr("disabled", false);
        });
    });
</script>
<script>
     $(document).ready(function() {
		$("#state-dropdown").css("color", "#8e98b9");
		$("#city-dropdown").css("color", "#8e98b9");
        $('#country-dropdown').on('change', function() {
            var country_id = this.value;
         //  alert(country_id);
            $("#state-dropdown").html('');
            $.ajax({
                url: "{{url('/state')}}",
                type: "POST",
                data: {
                    country_id: country_id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) {
					$("#state-dropdown").html(result);
                    //console.log(result);
                    $('#state-dropdown').html('<option value="">Select State</option>');
                    $.each(result.states, function(key, value) {
                      //  console.log(result.states);
					  	// $('#state-dropdown :selected').text('');
						 // var selected = $('#country-dropdown :selected').text();
						  //$("#state-dropdown").val(selected);
                        $("#state-dropdown").append('<option value="' + value.id + '" >' + value.name + '</option>');
                    });
                    $('#city-dropdown').html('<option value="">Select State First</option>');
                }
            });
        });
        $('#state-dropdown').on('change', function() {
            var state_id = this.value;
           // alert(state_id);
            $("#city-dropdown").html('');
            $.ajax({
                url: "{{url('/getCities')}}",
                type: "POST",
                data: {
                    state_id: state_id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#city-dropdown').html('<option value="">Select City</option>');
                    $.each(result.cities, function(key, value) {
                    //    console.log(result.cities);
                        $("#city-dropdown").append('<option value="' + value.id + '" >' + value.name + '</option>');
                    });
                }
            });
        });
     });
</script>
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
	$('#terms_condition_open').click(function(){
		$('#terms_condition').modal('show');
	});
	$('#privacy-policy').click(function(){
		$('#privacy_policy').modal('show');
	});
	$('#updPass').click(function(){
		/*$('#old_password').value()
		$('#new_password').value()
		$('#new_password_c').value()*/
		var flagU = true;
		if($('#old_password').val() == ""){
			flagU = false;
			$('#error_message_password').fadeIn();
			$('.error-text-password').text("Please enter old password");
		}else if($('#new_password').val() == ""){
			$('#error_message_password').fadeIn();
			$('.error-text-password').text("Please enter new password");
			flagU = false;
		}else if($('#new_password_c').val() == ""){
			$('#error_message_password').fadeIn();
			$('.error-text-password').text("Please enter re password");
			flagU = false;
		}else if($('#new_password_c').val() != $('#new_password').val()){
			$('#error_message_password').fadeIn();
			$('.error-text-password').text("New password and Confirm password must be same.");
			flagU = false;
		}
		if(flagU){
			$('#updPass').attr('disabled',true);
			$('#error_message_password').fadeOut();
			$.ajax({
			  	url: "{{url('profile/reset_password')}}",
			  	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			  	type: 'POST',
			  	data: $("#my_form").serialize(),
			  	success: function (data) {
			  		console.log(data);
					$('#updPass').attr('disabled',false);
			  		if(data.success == false){
			  			$("#updatedata #error_message .error-text").text(data.message);
						$("#updatedata #error_message").show();
						$("#updatedata #success_message .success-text").text('');
						$("#updatedata #success_message").hide();
			  		}else{
			  			$("#updatedata #success_message .success-text").text(data.message);
						$("#updatedata #success_message").show();
						$("#updatedata #success_message .error-text").text('');
						$("#updatedata #error_message").hide();
						
						setTimeout(function(){
			  				$('#updatedata').modal("hide")
			  				$('#old_password').val("")
			  				$('#new_password').val("")
			  				$('#new_password_c').val("")
			  			},2000)
					}
					
			  	}
			});
		}
	});
});
var contactEditFlag = 0;
function openmodel(){
	$('#error_message').fadeOut();
	$('#t1').val("");
	$('#t2').val("");
	$('#t3').val("");
	$('#t4').val("");
	$('#exampleModal').modal("show");
	contactEditFlag = 0;
}
$(document).on("click",'.edit',function(){
	$('#error_message').fadeOut();
	contactEditFlag = $(this).attr("data");
	$('#t1').val("");
	$('#t2').val("");
	$('#t3').val("");
	$('#t4').val("");
	if($(this).attr("data") == 1) {
		$('#t1').val($('#emmergency_contact_name1').val())
		$('#t2').val($('#emmergency_contact_relationshipstatus1').val())
		$('#t3').val($('#emmergency_mobile1').val())
		$('#t4').val($('#emmergency_contact_email1').val())
	}else{
		$('#t1').val($('#emmergency_contact_name2').val())
		$('#t2').val($('#emmergency_contact_relationshipstatus2').val())
		$('#t3').val($('#emmergency_mobile2').val())
		$('#t4').val($('#emmergency_contact_email2').val())
	}
	$('#exampleModal').modal("show");
	$('.form-group').addClass("focus");
});
$(function(){
			
			
	$("#submitbtn").bind("click",function(){
		var number = $('#t3').val();
		var filter 		= /^\d*(?:\.\d{1,2})?$/;
		var testEmail 	= /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
		var flag = true;
		if($('#t1').val() == ""){
			flag = false;
			$('#error_message').fadeIn();
			$('.error-text').text("Please enter name");
		}else if($('#t2').val() == ""){
			flag = false;
			$('#error_message').fadeIn();
			$('.error-text').text("Please enter relation");
		}else if($('#t3').val() == ""){
			flag = false;
			$('#error_message').fadeIn();
			$('.error-text').text("Please enter mobile");
		}else if(number.length!=10){
			flag = false;
			$('#error_message').fadeIn();
			$('.error-text').text("Please enter valid number");
		}else if(!filter.test($('#t3').val())){
			flag = false;
			$('#error_message').fadeIn();
			$('.error-text').text("Not a valid number");
		}else if($('#t4').val() == ""){
			flag = false;
			$('#error_message').fadeIn();
			$('.error-text').text("Please enter email");
		}else if(!testEmail.test($('#t4').val())){
			flag = false;
			$('#error_message').fadeIn();
			$('.error-text').text("Not a valid email");
		}
		if(flag){
			$('#exampleModal').modal("hide");
			if(contactEditFlag ==0){
				var emgno = $('#emmergency_contact_name1').val() == ""?1:2;
					
				var text = '<div class="emeregency-box"> \
	                	 	<a href="javascript:void(0);" class="edit" data="'+emgno+'"><img src="{{ asset("public/images/icon-edit-pen.svg") }}" alt="Pen" class="img-fluid"> </a>\
			                <div class="row emeregency-contact">\
							  				<div class="col-6 emeregency-name'+emgno+'" style="word-break: break-word;" >Name: '+$('#t1').val()+'</div>\
			                  	<div class="col-6 emeregency-rela'+emgno+'" style="word-break: break-word;">Relation: '+$('#t2').val()+'</div>\
			                  	<div class="col-6 emeregency-mobile'+emgno+'" style="word-break: break-word;">Contact No: '+$('#t3').val()+'</div>\
			                  	<div class="col-6 emeregency-email'+emgno+'" style="word-break: break-word;">Email: '+$('#t4').val()+'</div>\
			                	</div>\
			            		</div>';
	    	$('#emmergency_contact_name'+emgno+'').val($('#t1').val())
				$('#emmergency_contact_relationshipstatus'+emgno+'').val($('#t2').val())
				$('#emmergency_mobile'+emgno+'').val($('#t3').val())
				$('#emmergency_contact_email'+emgno+'').val($('#t4').val())
				if(emgno == 2){
					$('.btn-add-emeregency').css("display","none")
				}
				$('.appendHtml').append(text);
			}else if(contactEditFlag ==1){
				$('#emmergency_contact_name1').val($('#t1').val())
				$('#emmergency_contact_relationshipstatus1').val($('#t2').val())
				$('#emmergency_mobile1').val($('#t3').val())
				$('#emmergency_contact_email1').val($('#t4').val())
				$('.emeregency-name1').text($('#t1').val())
				$('.emeregency-rela1').text($('#t2').val())
				$('.emeregency-mobile1').text($('#t3').val())
				$('.emeregency-email1').text($('#t4').val())
			}else if(contactEditFlag ==2){
				$('#emmergency_contact_name2').val($('#t1').val())
				$('#emmergency_contact_relationshipstatus2').val($('#t2').val())
				$('#emmergency_mobile2').val($('#t3').val())
				$('#emmergency_contact_email2').val($('#t4').val())
				$('.emeregency-name2').text($('#t1').val())
				$('.emeregency-rela2').text($('#t2').val())
				$('.emeregency-mobile2').text($('#t3').val())
				$('.emeregency-email2').text($('#t4').val())
			}
		}
		/*var div = $("<div class = 'col-12 col-xl-6 profile profile__right'/>");
		div.html(GetContact(""));
		$("#EmContact").append(div);*/
	});
});
/*$(document).on('click',".update_profile_btn" ,function() {
    $(".update_profile_btn").attr('disabled','disabled');
   
    $.ajax({
        url: "{{ url('profile/student-update') }}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $(".student_profile").serialize(),
        success: function (data) {  
        $(".student_profile").removeAttr('disabled');
            if(data.success){
                $('.alert-danger').hide();
                $('.alert-success').show().html(data.message).fadeOut(8000);
            }else{
                $('.alert-success').hide();
                $('.alert-danger').show().html(data.message).fadeOut(8000);
            }
        }
    });
});*/
$(document).on('click',".update_profile_btn" ,function() {
			
		var filter 		= /^\d*(?:\.\d{1,2})?$/;
		
		var saveFlag = true;
		if($('#name').val() == ""){
			saveFlag = false;
			$('.alert-danger').show().html("Please enter name.").fadeOut(8000);
		}else if($('#gender').val() == ""){
			saveFlag = false;
			$('.alert-danger').show().html("Please select gender.").fadeOut(8000);
		}else if($('#datepicker').val() == ""){
			saveFlag = false;
			$('.alert-danger').show().html("Please select dob.").fadeOut(8000);
		}else if($('#address').val() == ""){
			saveFlag = false;
			$('.alert-danger').show().html("Please enter address.").fadeOut(8000);
		}else if($('#phone').val() == ""){
			saveFlag = false;
			$('.alert-danger').show().html("Please enter phone.").fadeOut(8000);
		}else if(!filter.test($('#phone').val())) {
			saveFlag = false;
			// $('#error_message').fadeIn();
			// $('.alert-danger').text("Not a valid number");
			$('.alert-danger').show().html("Not a valid number.").fadeOut(8000);
		}else if($('#ethnicity').val() == ""){
			saveFlag = false;
			$('.alert-danger').show().html("Please enter ethnicity.").fadeOut(8000);
		}else if($('#employment_status').val() == ""){
			saveFlag = false;
			$('.alert-danger').show().html("Please select employment status.").fadeOut(8000);
		}else if($('#ability_status').val() == ""){
			saveFlag = false;
			$('.alert-danger').show().html("Please select ability status.").fadeOut(8000);
		}
		// alert(saveFlag)
		if(saveFlag){
		  	$(".update_profile_btn").css('pointer-events',"none");
		 	$(this).text("Updating..")
			$.ajax({
			  	url: "{{url('profile/student-update_new')}}",
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
	/*errorElement: "div",
	errorClass: "invalid-feedback",*/
	submitHandler: function(form) {
		alert("asd")
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
				alert("Asdasd")
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
  if (input.files && input.files[0]) {
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
</script>

@endsection