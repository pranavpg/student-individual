@extends('layouts.app')
@section('content')
<style type="text/css">
	.complaint-table .complaint__heading {
		display: block;
		max-width: 300px;
		font-size: 1rem;
		color: #3E5971;
	}
	.complaint-table .complaint__description {
		display: block;
		max-width: 300px;
		font-size: .875rem;
		color: #9fa9c5;
		word-break: break-all;
	}
	.scrollbar-table {
		max-height: 530px;
	}
	.complaint-table {
		margin-bottom: 0rem;
		border-bottom: 1px solid #e7e7e7;
	}
	.complaint-form .chatbox {
		padding-right: 1rem;
	}
</style>

<main class="dashboard">
	<div class="container-fluid">
		<div class="row">
			@include('common.sidebar')
			<section class="main col-sm-12">
				@include('profile.menu')
				<div class="main__content main__content_full complaint">
					<div class="row">
						<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-3 text-right">
							@if($complaintId == '')
							@else
							<a href="{{ url('/profile/complaints') }}" title="Back" class="float-right">
								<button class="btn btn-backtopage btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To complain form</button>
							</a>
							@endif
						</div>
					</div>
					<div class="row mt-3">
						<div class="col-sm-12 col-md-5 col-lg-6 col-xl-6">
							<select id="filterText" class="form-control mb-3 w-50">
								<option value='all'>All</option>
								<option value='RESOLVED'>RESOLVED</option>
								<option value='OPEN'>OPEN</option> 
							</select>
						</div>
						<div class="col-sm-12 col-md-7 col-lg-6 col-xl-6 pb-3">
							<div class="ieukmob-cbackbtn float-left">
								<a href="javascript:void(0);" id="view_procedure" class="btn btn-primary complaint-form__heading_button" target="_blank" data-toggle="modal" data-target="#view_procedure_popup">
									<span>
										<img src="{{ asset('public/images/icon-small-eye.png') }}" alt="" class="img-fluid" width="26px">
									</span>Complaints Policy
								</a>
							</div>
					
							@if(isset($instration['getdocument']))
							@if(empty($instration['getdocument'] OR $instration['getvideo']))

							@else
							<span class="only-info-details dashboard-info float-right">
								<a href="javascript:void(0);" id="moreInfo"><i class="fas fa-info-circle"></i></a>
								<div class="info-details page-info-details">
									@foreach($instration['getdocument'] as $ins_doc)
									<div class="link1 text-left">
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
							@endif
						</div>
					</div>
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
					<div class="row">
						<div class="col-md-12 col-xl-6 complaint-list pb-4">
							<?php if(empty($complaints)){?>
								<div class="row text-center">
									<div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
										<img src="{{ asset('public/images/no_record_found.gif') }}" width="100%">
										<p style="font-weight: 600;font-size: 20px;margin-left: 25px;">No Records Found</p>
									</div>
								</div>
							<?php }else{?>
								<div class="scrollbar scrollbar-table">
									<table class="table complaint-table ieuktable-sline" id="mytable">
										<thead class="thead-dark">
										<tr>
											<th scope="col" width="30%">Date & Time</th>
											<th scope="col" width="48%">Complaint Details</th>
											<th scope="col" width="22%">Status</th>
										</tr>
									</thead>
										<tbody>
											@if(!empty($complaints))
											<?php foreach($complaints as $complaint){
												$seconds = $complaint['updated_time'] / 1000;
												$class = '';
												$class2 ='';
												if(isset($complaintId) && !empty($complaintId)){
													if($complaintId == $complaint['_id']){
														$class = "complaint-open";
														$class2 ="complaint-open";
													}else{
														$class = "complaint-resolve";	
													}
												}elseif($complaint['status'] == 3){
													$class = "complaint-resolve";
												}
												?>
												<?php //dd($complaint['is_userseen'])?>
												@if($complaint['is_userseen']==false)
												<tr class="<?php echo $class2?>" onclick="window.location='<?php echo URL('/profile/complaints/'.$complaint['_id']);?>'" style="cursor:pointer;" id="content">
													@else
													<tr class="<?php echo $class;?>" onclick="window.location='<?php echo URL('/profile/complaints/'.$complaint['_id']);?>'" style="cursor:pointer;" id="content">
														@endif
														<td scope="row" width="30%" title="Date & Time">
															<div class="table__date"><?php echo date("D, d-m-Y",$seconds)?></div>
															<div class="table__time"> <?php echo date("h:i A",$seconds)?></div>
														</td>
														<td width="48%" title="Complaint Details">
															<span class="complaint__heading"><?php echo $complaint['title'];?></span>
															<span class="complaint__description"><?php echo $complaint['description'];?></span>
														</td>
														<td width="22%" <?php if($complaint['status'] !== 3){?>class="status-open"<?php }?> >
															<?php if($complaint['status'] == "1" || $complaint['status'] == 1){
																echo "OPEN";
															}elseif($complaint['status'] == "2" || $complaint['status'] == 2){
																echo "OPEN";
															}elseif($complaint['status'] == "3" || $complaint['status'] == 3){
																echo "RESOLVED";
															}?>
															<?php /*?><a href="" class="badge badge-danger">1</a><?php */?>
														</td>
													</tr>
												<?php }?>
												@endif
											</tbody>
											<div id="norec">

											</div>
										</table>
									</div>
								<?php }?>
							</div>
							<script>
								$("#filterText").on("change", function() {
									var value = $(this).val();
									console.log(value);
									var i = 0;
									$("#mytable tbody tr").each(function(index) {
										$("#norec").hide();
										i++; 
										$row = $(this);
										if(value == 'all')
										{
											$row.show();
										}else{
											var id    =  $row.find("td:last").text();
											var av    =  id.trim();
											var myval =  value.trim();
											console.log(av);
											if (av == myval) {
												console.log(av);
												$row.show();
											}
											else {
												$row.hide();
											}
										}
							        //}
							      });
									if(i < 1)
									{
										$("#norec").empty().append('No Records Found');
									}
								});
							</script>

							<div class="col-md-12 col-xl-6 complaint-form">
								<?php if(isset($complaintId) && !empty($complaintId)){?>
									<!-- /. Heading -->
									<div class="form-box complaint-form_chatbox">
										<div class="complaint-form__heading d-flex flex-wrap justify-content-center">
											<!-- this div need to display when complain is resolved. -->
											
											<div class="resolved-msg-{{$complaintId}}" style="display:none">
												<span>This complain is resolved.</span>
											</div>
											
											<!--------------------------------------------------------->
											<div class="typebox__button">
												<form id="my_form1" method="post">
													<?php 
													if(isset($complaintId) && !empty($complaintId)) {
														if(!empty($singleComplaint)) {
															if($singleComplaint[0]['status'] == 2 || $singleComplaint[0]['status'] == "2" || $singleComplaint[0]['status'] == 1 || $singleComplaint[0]['status'] == "1s") {
																?>
																<button type="button" id="openpopup" class="btn btn-primary">
																	<span>
																		<img src="{{ asset('public/images/ic_resolve_complaint.png') }}" alt="" style="height:20px">
																	</span>
																	Resolve This Complaint
																</button>
																<?php 
															} 
														}
													}?>
													<input type="hidden" name="complaint_id" id="complaint_id" value="<?php echo $complaintId;?>">
													<input type="hidden" name="status" id="status" value="3">
												</form>
												<script>
													$("#my_form1").validate({
														rules: {
															status: {
																required: !0,
															},
															complaint_id: {
																required: !0,
															}
														},
														errorElement: "div",
														errorClass: "invalid-feedback",
														submitHandler: function(form) {
															$("#my_form1").find("input[type='submit']").prop("disabled",true);
															$("#my_form1").find("button[type='submit']").prop("disabled",true);
															$.ajaxSetup({
																headers: {
																	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
																}
															});
															$.ajax({
																type: "POST",
																url: '{{ URL("profile/add_complaint_post") }}',
																data : $("#my_form1").serialize(),
																dataType: "json",
																success: function(res) {
																	if(res.success){
																		window.location.reload();
																	}else{
																		$("#my_form1").find("input[type='submit']").prop("disabled",false);
																		$("#my_form1").find("button[type='submit']").prop("disabled",false);
																		alert(res.message);
																	}

																}
															});
															return false;								
														}
													})
												</script>
											</div> 
										</div>
										<div class="chat_div scrollbar-inner" style="max-height: 400px;overflow: auto;">
											<?php if(isset($singleComplaint) && !empty($singleComplaint)) {
												if(isset($singleComplaint[0]['comments'])) {
													foreach($singleComplaint[0]['comments'] as $comment) {
											?>
											<div class="chatbox d-flex flex-wrap <?php if($comment['is_submitted_by'] == "person"){?>justify-content-end text-right<?php }else{?> chatbox__left<?php }?>">
												<div class="chat__message">
													<span class="message"><?php echo $comment['comment'];?></span>
												</div>
												<div class="chat__timedate">
													<?php 
													$seconds = $comment['updated_time'] / 1000;
													echo date("D, d F Y h:i A",$seconds);?>
												</div>
											</div>
											<?php } } ?>
											<?php } ?>
										</div>
										<?php 
										if(!empty($singleComplaint)){

											if($singleComplaint[0]['status'] == 1 || $singleComplaint[0]['status'] == "1"  ){?>
												@if(Request::segment(3)=="null")
												<div style="text-align: center;margin: 50px 0 40px 0;">
													NO MESSAGES YET ....
													<br>Start the conversation by typing in the field below
												</div>
												@endif
												
											<?php }
											?>
											<?php if($singleComplaint[0]['status'] == 3 || $singleComplaint[0]['status'] == "3"){?>

											<?php }else{?>
												<form id="my_form" action="" method="post">
													<div class="typebox d-flex flex-wrap">
														<input type="hidden" name="status" id="status" value="2">
														<div class="form-group">
															<input type="text" name="comments" id="comments" class="form-control">
															<input type="hidden" name="complaint_id" id="complaint_id" value="<?php echo $complaintId;?>">
														</div>
														<div class="typebox__button">
															<button type="submit" class="btn  btn-primary">
																<img src="{{ asset('public/images/icon-send.svg') }}" alt="" class="img-fluid">
															</button>
														</div>
													</div>
												</form>
												<script type="text/javascript">
													$("#my_form").validate({
														rules: {
															comments: {
																required: !0,
															},
															complaint_id: {
																required: !0,
															}
														},
														errorElement: "div",
														errorClass: "invalid-feedback",
														submitHandler: function(form) {
															$("#my_form").find("input[type='submit']").prop("disabled",true);
															$("#my_form").find("button[type='submit']").prop("disabled",true);
															$.ajaxSetup({
																headers: {
																	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
																}
															});
															$.ajax({
																type: "POST",
																url: '{{ URL("profile/add_complaint_post") }}',
																data : $("#my_form").serialize(),
																dataType: "json",
																success: function(res) {
																	if(res.success){
																		window.location.reload();
																	}else{
																		$("#my_form").find("input[type='submit']").prop("disabled",false);
																		$("#my_form").find("button[type='submit']").prop("disabled",false);
																		alert(res.message);
																	}

																}
															});
															return false;								
														}
													})
												</script>
											<?php } }?>
										</div>

									<?php }else{?>
										<!-- /. Heading -->
										<div class="form-box">
											<h2>Complaint form</h2>
											<h3 class="text-left">* Note :</h3>
											<p>
												Do not include any personal or sensitive information such as financial or credit
												card / debit card numbers, driver licence number, detailed health or medical
												history or similar sensitive information.
											</p>
											<p>
												Ensure that you have taken the necessary steps in line with the Academy
												procedures before submitting this complaint.
											</p>

											<p>
												To help you understand the complaints procedure please see the diagram. IEUK
												will endeavour to solve any issues to ensure you're able to effectively  continue
												your studies.
											</p>
											<form action="" id="my_form" autocomplete="off" method="post" onsubmit="return false;">
												<h3>Title</h3>

												<div class="form-group">
													<input type="text" class="form-control" id="title" name="title"  placeholder="Write Here">
												</div>

												<h3>Please tell us about your complaint(s):</h3>
												<div class="form-group">
													<input type="text" class="form-control" id="description" name="description" placeholder="Write Here">
												</div>

												<div class="form-group">
													<button type="submit" class="btn  btn-primary">Submit</button>
												</div>

												<div class="form-group form-group__verification_error" id="error_message" style="display:none;">
													<em class="d-flex">
														<span class="error-img">
															<img src="{{ asset('public/images/icon-invalid-code.svg') }}" alt="">
														</span>
														<span class="error-text"></span>
													</em>
												</div>
											</form>
										</div>
										<script type="text/javascript">
											$("#my_form").validate({
												rules: {
													title: {
														required: !0,
													},
													description: {
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
											url: '{{ URL("profile/add_complaint_post") }}',
											data : $("#my_form").serialize(),
											dataType: "json",
											success: function(res) {
												if(!res.success){
													$("#error_message .error-text").text(res.message);
													$("#error_message").show();
												}else{
													$("#error_message .error-text").text('');
													$("#error_message").hide();
													window.location.reload();
												}
												$("#my_form").find("input[type='submit']").prop("disabled",false);
												$("#my_form").find("input[type='submit']").attr("value","Submit");
												$("#my_form").find("button[type='submit']").prop("disabled",false);
												$("#my_form").find("button[type='submit']").text("Submit");
											}
										});
										return false;								
									}
								})
							</script>
						<?php }?>
					</div>
				</div>
			</div>

		</section>
	</div>
</div>
</main>
<!--Popup model-->
<div class="modal fade" id="view_procedure_popup" tabindex="-1" role="dialog" aria-labelledby="cpd-policy-modalLabel"
aria-hidden="true">
<div class="modal-dialog modal-xl">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title" id="cpd-policy-modalLabel">
				<i class="fa-solid fa-newspaper"></i> Complaints Policy
			</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
		<!-- /. Modal Header top-->
		<div class="modal-body text-center border-0">
			<div class="embd-file">
				<img src="{{ asset('public/images/complaint_dia_img.png') }}" width="100%">
			</div>
			<!-- <div id="pdf-procedure-popup_0"></div> -->
			<div style=" text-align: center; margin: 15px; padding:7px; border: 1px solid #1d1d75; border-radius: 15px; color: #ef9341;">
				if you are still unhappy with the investigation findings and wish to complain further, the manager will review the investigation and decide on the course of action. Finally,  
				if you're still dissatisfied , you are entitled to complain directly to relevant bodies.
			</div>
		</div>
		<div class="modal-footer justify-content-center">
			<button type="button" class="btn  btn-cancel" data-dismiss="modal">Close</button>
		</div>
	</div>
</div>
</div>
<!-- close popup -->
<div class="modal fade" id="closepopup" tabindex="-1" role="dialog" aria-labelledby="erasemodalLongTitle" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog erase-modal modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header justify-content-center">
				<h5 class="modal-title" id="erasemodalLongTitle">Resolve Complaint</h5>
			</div>
			<div class="modal-body p-5">
				<p>Are you sure you want to resolve this complaint ?</p>
			</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-primary reset-answer" data-dismiss="modal" id="yes">Yes</button>
				<button type="button" class="btn  btn-cancel" data-dismiss="modal" id="no">No</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {

		$('.owl-carousel').trigger('to.owl.carousel',8);
		$('#openpopup').click(function(){
			$('#closepopup').modal("show")
		});
		$('#yes').click(function(){
			$('#my_form1').submit();
		});


		$('#no').click(function(){
			$('#closepopup').modal("hide")
		});


		var url="{{ asset('public/images/complaint_dia_img.png') }}";

		PDFObject.embed(url, "#pdf-procedure-popup_0",{height: "60rem"});


		$(".ilp-heading .nav-pills .nav-item a").on('click',function() {
			setTimeout(function(){
				var timetable = $(".ilp-heading .nav-pills .nav-item a.nav-link.active").parent().attr("data-timetable");
				if(timetable == ""){
					timetable = 'javascript:void(0);';
				}
				$("#view_procedure").attr("href",timetable);
			},100);
		});
	});
</script>
<script>
	$( document ).ready(function() {
	   var data = <?php echo json_encode($complaints);?>;
	    $.each(data, function(key, value) {
		    if(value.is_userseen == true){
		    	$('.resolved-msg-'+value._id).show();
		    }
		});
	});
</script>
<!-- <script type="text/javascript">
		$(document).ready(function() {
			$("#filterText").select2();
			$('#filterText').on("select2:open", function () {
				$('.select2-results__options').addClass('d-scrollbar');
				$('.select2-results__options').scrollbar();
			});
		});
        
	</script>  -->

	@endsection