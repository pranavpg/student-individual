@extends('layouts.app')
@section('content')
@include('messages')
<div class="filter d-block d-md-none">
	<a href="javascript:void(0)" class="btn btn-sm btn-light open-filter filterbtn">
		<span class="mobonly"><img src="{{asset('public/images/filter-options-mobile.png')}}" alt="" class="img-fluid" width="24px"></span>
	</a>
</div>
<aside class="filter-sidebar"> 
	<div class="heading d-flex flex-wrap justify-content-between">
		<h5><i class="fa fa-filter"></i> Filter</h5>
		<a href="javascript:void(0);" class="close-filter">
			<img src="{{asset('public/images/icon-close-filter-white.svg')}}" alt="" class="img-fluid" width="15px" style="margin-top: -2px;">
		</a>
	</div>
	<?php //dd($onlyCourse)?>
	<div class="filter-body">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 partA">
				<span class="sidefilter-heading">Select Course</span>
				<select class="col-md-6 custom-select2-dropdown-nosearch" id="filter_dropdown1" style="min-width: 300px;">
					@foreach($onlyCourse as $key => $course)
					<option value="{{$key}}" data-course-leval-id="{{$course['level']['_id']}}" @if($course['course_id'] == session()->get('course_ids')) selected @endif>{{$course['course']['coursetitle']}} - {{$course['level']['leveltitle']}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-0 partB">
				<div class="filter-action-buttons">
					<a href="javascript:void(0)" class="btn btn-classic" id="addsummary" data-toggle="modal" onclick="openModelexampleModal()">
						<i class="fa fa-plus" aria-hidden="true"></i> Add Summary
					</a>
				</div>
				<!-- <div class="filter-action-buttons">
					<a href="javascript:void()" class="btn btn-classic">
						<span><i class="fa fa-download" aria-hidden="true"></i> Download</span>
					</a> 
				</div> -->
			</div>
			@if(empty($instration['getdocument'] OR $instration['getvideo']))
			@else
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 filter-bottom">
				<a href="javascript:void(0);" id="moreInfo"><i class="fas fa-info-circle"></i></a>
				<div class="info-details">
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
			</div>
			@endif
		</div>
	</div>
</aside>
<!-- instruction popup -->
<div class="modal fade" id="myModal" role="dialog">
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
<main class="dashboard">
	<div class="container-fluid">
		<div class="row">
			@include('common.sidebar')
			<section class="main ieuks-summerys col-sm-12">
				<div class="col-12 d-flex justify-content-md-start justify-content-between pt-3 pb-5">
					@if(isset($_REQUEST['type']) && $_REQUEST['type']=="task")
					<a href="{{Session::get('lastTask1')}}" class="btn btn-primary btn-icon position-absolute d-none d-md-block">
						<img src="{{ asset('public/images/icon-button-topic-white.png') }}" alt="resume icon" class="img-fluid" width="20px">
						{{Session::get('lastTaskName') ? Session::get('lastTaskName') : 'Back to Task' }}
					</a>
					<a href="{{Session::get('lastTask1')}}" class="backtotaskbtn d-block d-md-none">
						<img src="{{ asset('public/images/icon-button-topic-grey.png') }}" alt="resume icon" class="img-fluid default-img" width="20px">
						<img src="{{ asset('public/images/icon-button-topic-white.png') }}" alt="resume icon" class="img-fluid hover-img d-none" width="20px">
						{{Session::get('lastTaskName') ? Session::get('lastTaskName') : 'Back to Task' }}
					</a>
					@else
					<!-- <a href="{{url('vocabulary')}}" class="back-button position-absolute"><i class="fa-solid fa-caret-left"></i> back</a> -->
					@endif
					<h1 class="pageheading m-auto"><span><i class="fa fa-receipt" aria-hidden="true"></i></span> Summary</h1>
				</div>

				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<div class="row">
						<div class="col-12 col-sm-7 col-md-6 col-lg-8 col-xl-8 d-none d-sm-block d-xl-none notes-selection">
							<select class="col-md-6 custom-select2-dropdown-nosearch" id="mobile_dropdown">
								@foreach($onlyCourse as $key => $course)
								<option value="{{$key}}">{{$course['course']['coursetitle']}} - {{$course['level']['leveltitle']}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-12 col-sm-6 col-md-6 col-lg-8 col-xl-8 d-none d-xl-block">
							<?php
							if(count($onlyCourse)>2){
								?>
								<select class="col-md-6 custom-select2-dropdown-nosearch" id="condition_dropdown">
									@foreach($onlyCourse as $key => $course)
									<option value="{{$key}}" data-course-leval-id="{{$course['level']['_id']}}" @if($course['course_id'] == session()->get('course_ids')) selected @endif>{{$course['course']['coursetitle']}} - {{$course['level']['leveltitle']}}</option>
									@endforeach
								</select>
								<?php
							}else{
								?>
								<ul class="nav nav-pills nav-pills_switch aes_ges_parent pb-3" id="pills-tab" role="tablist">
									<?php 
									$i = 0;
									foreach($onlyCourse as $key=>$course){
										$class= "";
										if(session()->get('course_id')){
											if($course['course_id'] == session()->get('course_ids')){
												$class = "active show";
											}
										}else{
											if($i==0){
												$class= "active show";
											}
										}
										?>
										<li class="nav-item mb-2 mr-3">
											<a class="nav-link {{$class}}" value="praol" id="pills-<?php echo $key;?>-tab" data-toggle="pill" href="#pills-<?php echo $key;?>" role="tab" data-index={{$key}} aria-controls="pills-<?php echo $key;?>" aria-selected="true"><?php echo $course['course']['coursetitle'];?> - <?php echo $course['level']['leveltitle'];?></a>
										</li>
										<?php $i++;}?>
									</ul>
								<?php } ?>
							</div>
							<div class="col-6 d-sm-none">
								<h6 id="getFirstCourseName"></h6>
							</div>
							<div class="col-6 col-sm-5 col-md-6 col-lg-4 col-xl-4">
								<div class="row">
									<div class="col-sm-12 col-md-9 col-lg-9 col-xl-10 common-search">
										<div class="search-form">
											<div class="form-group mb-0">
												<input type="search search_box" class="form-control form-control-lg search_work_record newsearch" placeholder="Search" id="filter" aria-label="Search">
												<span class="icon-search">
													<img src="https://teacher.englishapp.uk/public/teacher/images/icon-search-pink.svg" alt="Search" class="img-fluid">
												</span>
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-md-3 col-lg-3 col-xl-2">
										<div class="filter">
											<a href="javascript:void(0)" class="btn btn-sm btn-light open-filter filterbtn">
												<img src="{{asset('public/images/filter-options-default.png')}}" alt="" class="img-fluid deskonly" width="20px">
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="main__content" id="image_class" style="display: none;">
						<div class="row text-center">
							<div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
								<img src="{{ asset('public/images/no_record_found.gif') }}" width="100%">
								<p style="font-weight: 600;font-size: 20px;margin-left: 25px;">No Records Found</p>
							</div>
						</div>
					</div>
					<hr class="hr">
					<!----------------------->
					<div class="main__content main__content_summary">
						<div class="tab-content" id="pills-tabContent">
							<?php 
							$i = 0;
							foreach($onlyCourse as $courseId=>$course){
								$class= "";
								if(session()->get('course_ids')){
									if($course['course_id'] == session()->get('course_ids')){
										$class = "active show";
									}
								}else{
									if($i==0){
										$class= "active show";
									}
								}	
								?>
								<div class="tab-pane fade {{$class}}" id="pills-<?php echo $courseId;?>" role="tabpanel" aria-labelledby="pills-<?php echo $courseId;?>-tab">
									<div class="row d-flex flex-wrap" id = "results">
										<?php 
										$k = 0;
										$topics = collect($summarydata);
										$new_array = array();
										foreach($summary as $sum)
										{
											$topicDetails = $topics->where('_id',$sum['topic_id'])->first();
                           	//dd($topicDetails);
											if(!isset($topicDetails['course_id']) OR !isset($course['course_id']))
											{
												continue;
											}
											else
											{
												if($topicDetails['course_id'] !== $course['course_id']){ continue;}
											} 
											$new_array[] = array(
												'sorting'  => $topicDetails['sorting'],
												'title'    => $topicDetails['topicname'],
												'topic_id' => $sum['topic_id'],
												'listening_summary' => $sum['listening_summary'],
												'reading_summary'   => $sum['reading_summary'],
												'writing_summary'   => $sum['writing_summary'],
												'speaking_summary'  => $sum['speaking_summary'],
												'grammar_summary'    => $sum['grammar_summary'],
												'vocabulary_summary' => $sum['vocabulary_summary']

											);

										}


										$sec_new = array();
										foreach($new_array as $key => $val)
										{
											$sec_new[$key] = $val['sorting'];
										}
										array_multisort($sec_new, SORT_ASC, $new_array);

										foreach($new_array as $sum){
											?>
											<div class="col-12 col-sm-6 col-lg-4 col-xl-3 summary_box" p-id="{{$sum['topic_id']}}"  style="cursor:pointer;" >
												<div class="summary-topic border-success pl-3 pr-0 pb-3" style="height: 170px;"data-toggle="modal" data-target="#exampleModal">
													<p>Topic <?php echo $sum['sorting'];?></p>
													<h4><?php echo $sum['title'];?></h4>
												</div>
												<input type="hidden" name="topic_id" value="<?php echo $sum['topic_id'];?>" />
												<input type="hidden" name="listening_summary" value="<?php echo $sum['listening_summary'];?>" />
												<input type="hidden" name="reading_summary" value="<?php echo $sum['reading_summary'];?>" />
												<input type="hidden" name="writing_summary" value="<?php echo $sum['writing_summary'];?>" />
												<input type="hidden" name="speaking_summary" value="<?php echo $sum['speaking_summary'];?>" />
												<input type="hidden" name="grammar_summary" value="<?php echo $sum['grammar_summary'];?>" />
												<input type="hidden" name="vocabulary_summary" value="<?php echo $sum['vocabulary_summary'];?>" />
											</div>
											<?php $k++; }?>
											<?php if($k == 0){?>
												<div class="row text-center w-100">
													<div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
														<img src="{{ asset('public/images/no_record_found.gif') }}" width="100%">
														<p style="font-weight: 600;font-size: 20px;margin-left: 25px;">No Records Found</p>
													</div>
												</div>
											<?php }?>
										</div>
									</div>
									<?php $i++;}?>
								</div>
							</div>
						</section>
					</div>
				</div>
			</main>
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<form id="my_form" action="" method="post">
							<input type="hidden" name="course_id" id="course_id" value="" />
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-receipt"></i> Summary</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="form-group maxw-300">
									<select id="topic_id" name="topic_id" class="form-control">
										<option value="">Please Select Topic</option>
										<option value="" data-courseid=""></option>
									</select>
								</div>
								<h5 class="mb-3">What you have learned from this topic?</h5>
								<div class="reading-form d-flex flex-wrap form-group">
									<h6>Reading</h6>
									<textarea name="reading_summary" id="reading_summary" class="form-control p-0" placeholder="write here..." onkeyup="textAreaAdjust(this)" style="overflow:auto"></textarea>
								</div>
								<!-- /. Reading Form -->
								<div class="reading-form d-flex flex-wrap">
									<h6>Writing</h6>
									<!-- <input type="text" name="writing_summary" id="writing_summary" class="form-control" placeholder="write here..."> -->
									<textarea name="writing_summary" id="writing_summary" class="form-control p-0" placeholder="write here..." onkeyup="textAreaAdjust(this)" style="overflow:auto"></textarea>
								</div>
								<!-- /. Reading Form -->
								<div class="reading-form d-flex flex-wrap form-group">
									<h6>Speaking</h6>
									<!-- <input type="text" name="speaking_summary" id="speaking_summary" class="form-control" placeholder="write here..."> -->
									<textarea name="speaking_summary" id="speaking_summary" class="form-control p-0" placeholder="write here..." onkeyup="textAreaAdjust(this)" style="overflow:auto"></textarea>
								</div>
								<!-- /. Reading Form -->
								<div class="reading-form d-flex flex-wrap form-group">
									<h6>Listening</h6>
									<!-- <input type="text" name="listening_summary" id="listening_summary" class="form-control" placeholder="write here..."> -->
									<textarea name="listening_summary" id="listening_summary" class="form-control p-0" placeholder="write here..." onkeyup="textAreaAdjust(this)" style="overflow:auto"></textarea>
								</div>
								<!-- /. Reading Form -->
								<div class="reading-form d-flex flex-wrap form-group">
									<h6>Vocabulary</h6>
									<!-- <input type="text" name="vocabulary_summary" id="vocabulary_summary" class="form-control" placeholder="write here..."> -->
									<textarea name="vocabulary_summary" id="vocabulary_summary" class="form-control p-0" placeholder="write here..." onkeyup="textAreaAdjust(this)" style="overflow:auto"></textarea>
								</div>
								<!-- /. Reading Form -->
								<div class="reading-form d-flex flex-wrap form-group">
									<h6>Grammar</h6>
									<!-- <input type="text" name="grammar_summary" id="grammar_summary" class="form-control" placeholder="write here..."> -->
									<textarea name="grammar_summary" id="grammar_summary" class="form-control p-0" placeholder="write here..." onkeyup="textAreaAdjust(this)"></textarea>
								</div>
								<!-- /. Reading Form -->
								<div class="form-group form-group__verification_error" id="error_message_summary" style="display:none;">
									<em class="d-flex">
										<span class="error-img">
											<img src="{{ asset('public/images/icon-invalid-code.svg') }}" alt="">
										</span>
										<span class="error-text_summary"></span>
									</em>
								</div>
							</div>
							<div class="modal-footer justify-content-center">
               <!-- <div class="w-100 form-group__verification_success text-center" id="success_message_summary" style="display:none;">
                  <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                     <em>
                     <span class="success-img">
                     <img src="{{ asset('public/images/icon-invalid-code.svg') }}" alt="">
                     </span>
                     <span class="success-text_summary"></span>
                     </em>
                  </div>
                </div> -->
                <button type="submit" class="btn btn-primary" id="sav_btn"><i class="fa-regular fa-floppy-disk"></i> Save</button>
                <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <script>
      	$(".backtotaskbtn").hover(function () {
      		$(".hover-img").toggleClass("d-none");
      		$(".default-img").toggleClass("d-none");
      	});
      	$("#pills-tab").click(function() {
      		$('#filter').val('');
      	});

      	function textAreaAdjust(element) {
      		element.style.height = "1px";
      		element.style.height = (25+element.scrollHeight)+"px";
      	}
      </script>
      <script type="text/javascript">
      	var data =  <?php echo json_encode($onlyCourse); ?>;

      	function setOptions(){
      		let index = $("#pills-tab li.nav-item .nav-link.active").data("index");
      		if(typeof index == 'undefined')
      		{
      			index = window.datas; 
      		}
      		let course_id = data[index].course._id;
      		let level_id = data[index].level._id;
      		$.ajax({
      			url: "{{url('/get_topic_task')}}",
      			type: "POST",
      			data: {
      				level_id:level_id,
      				_token: '{{csrf_token()}}'
      			},
      			dataType: 'json',
      			success: function(result) {
      				$('#topic_id').html('<option value="">Please Select topic</option>');
      				$.each(result.data, function(key, value) {
      					var check = "";
      					if(window.presentid == value._id){
      						check = "selected";
      					}
      					$("#topic_id").append('<option '+check+' value="' + value._id + '" data-courseid="'+course_id+'">Topic '+value.sorting+' : '+value.topicname+'</option>');

      				});
      			}
      		});
      		$('#topic_id').html("");
      	}

      	function openModelexampleModal(){
      		$(".error-text_summary").text('');
      		$("#error_message_summary").hide();
      		window.presentid ="";
      		setOptions();
   // $("#topic_id option:selected").remove();
   $('textarea').each(function(){
   	$(this).css("height",'51px')
   })
   $('#topic_id').removeAttr("disabled")
   $('#exampleModal').modal("show");
 }


 $('#addsummary').on('click', function (e) {
 	var activeCourse = $("#pills-tab li.nav-item .nav-link.active").attr("href");
 	if(typeof activeCourse == 'undefined'){
 		var activeCourse = 	"#pills-"+window.datas;
 	}
	// var newdata = window.datas;
	$('#topic_id').css("pointer-events","all")
	// var activeCourseName = $("#pills-tab li.nav-item .nav-link.active").text();
	var activeCourseId = activeCourse.replace("#pills-","");
	$("#sav_btn").html('<i class="fa-regular fa-floppy-disk"></i> Save');
	//alert(activeCourseId);
	$("#exampleModal #course_id").val(activeCourseId);
	// $('#topic_id').val('');
	// $('#topic_id option').hide();
	$('#topic_id option').first().show();
	// $('#topic_id option[data-courseid="'+activeCourseId+'"]').show();
	$('#listening_summary').val('');
	$('#reading_summary').val('');
	$('#writing_summary').val('');
	$('#speaking_summary').val('');
	$('#grammar_summary').val('');
	$('#vocabulary_summary').val('');
	$('#btn btn-primary').val('');
	$('#topic_id').prop("readonly",false);
})

 $(".summary_box").on('click',function(){
 	var pid = $(this).attr('p-id');
 	window.presentid = pid;
 	setOptions();
 	$('textarea').each(function(){
 		$(this).css("height",'51px')
 	});
 	$('#topic_id').css("pointer-events","none")
 	$('#topic_id').val($(this).find('input[name="topic_id"]').val());
 	$('#listening_summary').val($(this).find('input[name="listening_summary"]').val());
 	$('#reading_summary').val($(this).find('input[name="reading_summary"]').val());
 	$('#writing_summary').val($(this).find('input[name="writing_summary"]').val());
 	$('#speaking_summary').val($(this).find('input[name="speaking_summary"]').val());
 	$('#grammar_summary').val($(this).find('input[name="grammar_summary"]').val());
 	$('#vocabulary_summary').val($(this).find('input[name="vocabulary_summary"]').val());
 	$('#topic_id').prop("readonly",true);
 	$("#success_message_summary").hide();
 	$("#error_message_summary").hide();
 	$("#sav_btn").html('<i class="fa-regular fa-floppy-disk"></i> Update');
 })

 $("#my_form").validate({
 	rules: {
 		topic_id: {
 			required: !0,
 		}	
 	},
 	errorElement: "div",
 	errorClass: "invalid-feedback",
 	submitHandler: function(form) {
 		let index = $("#pills-tab li.nav-item .nav-link.active").data("index");
 		if(typeof index == 'undefined'){
 			index = window.datas; 
 		}
 		var textFields = false;
 		let courseId = data[index].course._id;
 		let LevelId = data[index].level._id;
 		$("<input />").attr("type", "hidden")
 		.attr("name", "course_ids")
 		.attr("value",courseId)
 		.appendTo("#my_form");

 		$("<input />").attr("type", "hidden")
 		.attr("name", "level_ids")
 		.attr("value",LevelId)
 		.appendTo("#my_form");

 		$('#my_form textarea').each(function(){
 			if($(this).val() !== ""){
 				textFields = true;
 			}
 		})
 		if(!textFields){
 			$("#error_message_summary .error-text_summary").text('Please fill at least one summary');
 			$("#error_message_summary").show();
 			$("#success_message_summary").hide();
 			return false;
 		}

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
 			url: '{{ URL("summary_post") }}',
 			data : $("#my_form").serialize(),
 			dataType: "json",
 			beforeSend: function() {
 				$('#topic_id').removeAttr("disabled")
 			},
	    // success: function(data) {
	    // },
	    success: function(res) {
				// alert(res.message);
				if(!res.success){
					$("#error_message_summary .error-text_summary").text(res.message);
					$("#error_message_summary").show();
					$("#success_message_summary").hide();
					$("#my_form").find("input[type='submit']").prop("disabled",false);
					$("#my_form").find("input[type='submit']").attr("value","Save");
					$("#my_form").find("button[type='submit']").prop("disabled",false);
					$("#my_form").find("button[type='submit']").text("Sign In");
				}else{
					$("#success_message_summary").show();
					$("#success_message_summary .success-text_summary").text(res.message);
					$("#error_message_summary").show();
					$("#error_message_summary").hide();
					setTimeout(function(){
				// $("#my_form")[0].reset()
				window.location.reload();
			},1000);
				// $('#exampleModal').show();
			}
	      // $('#topic_id').prop("disabled","true")
	    }
	  });
 		return false;								
 	}
 })
</script>

<script>
	var count = 0;
	$("#filter").keyup(function(){
		var filter = $(this).val();
		$('#results div').each(function() {
			if ($(this).text().search(new RegExp(filter, "i")) < 0) {
				$(this).hide();
			} else {
				$(this).show();
			}
		});
		var temp= 0;
		var temp1= 0;
		$('#results div').each(function() {
			if(!$(this).is(':visible')){
				temp++;
			}               
			temp1++;
		});

		if(temp1 == temp){
			$("#image_class").show();
		}else{

			$("#image_class").hide();
		}
	});
	setTimeout(function(){
		$('.flash-message').fadeOut()
	},5000)
</script>

<script>
	$( document ).ready(function() {
		var text1 = $("#filter_dropdown1 option:selected").text();
		$("#getFirstCourseName").text(text1);

		let indexvalue = $("#pills-tab li.nav-item .nav-link.active").data("index");
		if(typeof indexvalue == 'undefined'){
			$("#pills-0-tab").addClass('active show')
		}
	});
	window.datas = '0';
	$(document).on('click',"#pills-tab",function(){
		let indexvalue = $("#pills-tab li.nav-item .nav-link.active").data("index");
		var new_indexvalue =  "pills-"+indexvalue+"-tab";
		var get_rec  = $( "#pills-tab li.nav-item .nav-link.active").text(); //new_indexvalue.text();
		$( "#filter_dropdown1 option[value='"+get_rec+"']" ).prop('selected', true);
		$("#select2-filter_dropdown1-container").text(get_rec);
	});


	$(document).on('change',"#mobile_dropdown",function(){
		var value = $(this).val();
		var newvalue = "pills-"+value+"-tab";

		$(".nav-link").removeClass('active');
		$("#"+newvalue).addClass('active');

		var main_data = "pills-"+value;
		$(".tab-pane.fade").removeClass('active show');
		$("#"+main_data).addClass('active show');

		var get_rec  = $( "#filter_dropdown1 option[value='"+value+"']" ).text();
		$( "#filter_dropdown1 option[value='"+get_rec+"']" ).prop('selected', true);
		$("#select2-filter_dropdown1-container").text(get_rec);
	});
	$(document).on('change',"#condition_dropdown",function(){
		var value = $(this).val();
		var newvalue = "pills-"+value+"-tab";
		var addsummvalue = value;
		window.datas = addsummvalue;
		$(".nav-link").removeClass('active');
		$("#"+newvalue).addClass('active');
		var main_data = "pills-"+value;
		$(".tab-pane.fade").removeClass('active show');
		$("#"+main_data).addClass('active show');
		var get_rec  = $( "#filter_dropdown1 option[value='"+value+"']" ).text();
		$( "#filter_dropdown1 option[value='"+get_rec+"']" ).prop('selected', true);
		$("#select2-filter_dropdown1-container").text(get_rec);
	});
	$(document).on('change',"#filter_dropdown1",function(){
		var value = $(this).val();
		var newvalue = "pills-"+value+"-tab";
		var addsummvalue = value;
		window.datas = addsummvalue;
		$(".nav-link").removeClass('active');
		$("#"+newvalue).addClass('active');
		var main_data = "pills-"+value;
		$(".tab-pane.fade").removeClass('active show');
		$("#"+main_data).addClass('active show');
		var get_rec  = $( "#condition_dropdown option[value='"+value+"']" ).text();
		$( "#condition_dropdown option[value='"+get_rec+"']" ).prop('selected', true);
		$("#select2-condition_dropdown-container").text(get_rec);
		var text = $("#select2-filter_dropdown1-container").text();
		$("#getFirstCourseName").text(text);

	});
	
</script>
@endsection