@extends('layouts.app')
@section('style')
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css" />
<style type="text/css">
	.col-md-7 .plyr__controls {
		position: relative;
		display: -webkit-box;
		display: -ms-flexbox;
		display: flex;
		-ms-flex-wrap: wrap;
		flex-wrap: wrap;
		max-width: 320px;
		max-height: 4rem;
		border: none;
		border-radius: 0.6rem;
		padding: 1.25rem 1.25rem .5rem;
		background-color: #F2F3F4;
	}
	.bg-info {
		background-color: #ffe968!important;
	}
	option{
		background: grey !important;
		color: black !important;
	}
	option:hover {
		background: blue !important;
	}
	#tabaleid_filter{
		position: absolute;
		top: .5rem;
		right: 0rem;
	}
</style>
@endsection
@section('content')
<div style="display: none;" id="hidediv">
	
</div>
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
	<div class="filter-body">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 partA">
				<div class="col-12 mt-2 mb-3">
					<span class="sidefilter-heading">Select Course</span>
					<select class="col-md-4 custom-select2-dropdown-nosearch course-dropdown" id="newdrop" style="min-width: 300px;">
						
					</select>
				</div>
			</div>

			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 partB">
				<div class="col-12 showSelectTopic mb-3">
					<span class="sidefilter-heading">Topic</span>
					<select class="form-control custom-select2-dropdown" id="selectTopic"></select>
				</div>

				<div class="col-12 showSelectTask mb-3">
					<span class="sidefilter-heading">Task</span>
					<select class="form-control custom-select2-dropdown" id="selectTask"></select>
				</div>

				<div class="col-12 mb-3">
					<span class="sidefilter-heading">Marking Type</span>
					<select class="form-control custom-select2-dropdown-nosearch" id="TopicChnage" onchange='filterText()'>
						<option value="all">All Marking Type</option>
						<option value="Automated">Automated</option>
						<option value="Participation">Participation</option>
						<option value="Teacher mark">Teacher mark</option>
						<option value="Class Mark">Class Mark</option>
						<option value="Self Mark">Self Mark</option>
						<option value="No marks">No marks</option>
					</select>
				</div>

				<div class="col-12 mb-3">
					<div class="dropdown teacherReview" id="teaReview">
						<span class="sidefilter-heading d-block sidefilter-heading">Teacher Review</span>

						<!-- 	<button class="btn btn-primary dropdown-toggle w-100 px-0" type="button" id="dropdownTeacherReview" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">All Teacher Review</button>
								<div class="dropdown-menu" aria-labelledby="dropdownTeacherReview">
									<span class="dropdown-item" data-value="" data-html="All Teacher Review">All Teacher Review</span>
									<span class="dropdown-item" data-value="1"> <img src="{{asset('public/images/icon-emoji-green.svg')}}" alt="1" /></span>
									<span class="dropdown-item" data-value="2"> <img src="{{asset('public/images/icon-emoji-yellow.svg')}}" alt="2" /></span>
									<span class="dropdown-item" data-value="4"> <img src="{{asset('public/images/icon-emoji-orange.svg')}}" alt="4" /></span>
									<span class="dropdown-item" data-value="3"> <img src="{{asset('public/images/icon-emoji-red.svg')}}" alt="3" /></span>
								</div> -->

						<div class="custom-control custom-radio">
							<input type="radio" class="custom-control-input" id="topic_1" name="topic-stacked" value="1">
							<label class="custom-control-label" for="topic_1">
								<span class=" " data-value="1">
									<img src="{{asset('public/images/icon-emoji-green.svg')}}" alt="1" />
								</span>
							</label>
						</div>
						<div class="custom-control custom-radio pl">
							<input type="radio" class="custom-control-input" id="topic_2" name="topic-stacked" value="2">
							<label class="custom-control-label" for="topic_2">
								<span class=" " data-value="2">
									<img src="{{asset('public/images/icon-emoji-yellow.svg')}}" alt="2" />
								</span>
							</label>
						</div>
						<div class="custom-control custom-radio pl">
							<input type="radio" class="custom-control-input" id="topic_3" name="topic-stacked" value="4">
							<label class="custom-control-label" for="topic_3">
								<span class=" " data-value="3">
									<img src="{{asset('public/images/icon-emoji-orange.svg')}}" alt="4" />
								</span>
							</label>
						</div>
						<div class="custom-control custom-radio pl">
							<input type="radio" class="custom-control-input" id="topic_4" name="topic-stacked" value="3">
							<label class="custom-control-label" for="topic_4">
								<span class=" " data-value="4">
									<img src="{{asset('public/images/icon-emoji-red.svg')}}" alt="3" />
								</span>
							</label>
						</div>
						<div class="custom-control custom-radio pl">
							<input type="radio" class="custom-control-input" id="topic_41" name="topic-stacked" value="all">
							<label class="custom-control-label" for="topic_41">
								<span class=" " data-value="41">All</span>
							</label>
						</div>
					</div>
				</div>

				<div class="col-12 mb-3">
					<div class="dropdown studentReview" id="stuReview">
						<span class="sidefilter-heading d-block sidefilter-heading">Student Review</span>

							<!-- <div class="dropdown" id="stuReview">
								<button class="btn btn-primary dropdown-toggle w-100 px-0" type="button" id="dropdownStudentReview" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">All Student Review</button>
								<div class="dropdown-menu" aria-labelledby="dropdownStudentReview">
									<span class="dropdown-item" data-value="" data-html="All Student Review">All Student Review</span>
									<span class="dropdown-item" data-value="1"> <img src="{{asset('public/images/icon-emoji-green.svg')}}" alt="1" /></span>
									<span class="dropdown-item" data-value="2"> <img src="{{asset('public/images/icon-emoji-yellow.svg')}}" alt="2" /></span>
									<span class="dropdown-item" data-value="4"> <img src="{{asset('public/images/icon-emoji-orange.svg')}}" alt="4" /></span>
									<span class="dropdown-item" data-value="3"> <img src="{{asset('public/images/icon-emoji-red.svg')}}" alt="3" /></span>
								</div>
							</div> -->

						<div class="custom-control custom-radio">
							<input type="radio" class="custom-control-input" id="topic_5" name="topic-stacked_1" value="1">
							<label class="custom-control-label" for="topic_5">
								<span class=" " data-value="1">
									<img src="{{asset('public/images/icon-emoji-green.svg')}}" alt="1" />
								</span>
							</label>
						</div>
						<div class="custom-control custom-radio pl">
							<input type="radio" class="custom-control-input" id="topic_6" name="topic-stacked_1" value="2">
							<label class="custom-control-label" for="topic_6">
								<span class=" " data-value="2">
									<img src="{{asset('public/images/icon-emoji-yellow.svg')}}" alt="2" />
								</span>
							</label>
						</div>
						<div class="custom-control custom-radio pl">
							<input type="radio" class="custom-control-input" id="topic_7" name="topic-stacked_1" value="4">
							<label class="custom-control-label" for="topic_7">
								<span class=" " data-value="3">
									<img src="{{asset('public/images/icon-emoji-orange.svg')}}" alt="4" />
								</span>
							</label>
						</div>
						<div class="custom-control custom-radio pl">
							<input type="radio" class="custom-control-input" id="topic_8" name="topic-stacked_1" value="3">
							<label class="custom-control-label" for="topic_8">
								<span class=" " data-value="4">
									<img src="{{asset('public/images/icon-emoji-red.svg')}}" alt="3" />
								</span>
							</label>
						</div>
						<div class="custom-control custom-radio pl">
							<input type="radio" class="custom-control-input" id="topic_9" name="topic-stacked_1" value="all">
							<label class="custom-control-label" for="topic_9">
								<span class=" " data-value="4">All</span>
							</label>
						</div>
					</div>
				</div>
			</div>
			@if(isset($instration['getdocument']))
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
			@endif

		</div>
	</div>
</aside>
	<main class="dashboard">
		<div class="container-fluid">
			<div class="row">
				@include('common.sidebar')
				<section class="main notes ieuk-wrm col-sm-12 work-record-section">
					<div class="summary-heading p-3">
						<h1 class="text-center pageheading">
							<span style="display: inline-flex;">
								<i class="fas fa-clipboard"></i>
							</span> Work Record
						</h1>
					</div>
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<div class="row justify-content-start">
							<div class="col-12 col-sm-7 col-md-6 col-lg-8 col-xl-8 d-none d-sm-block d-xl-none notes-selection">
								<select class="col-md-6 form-control course-dropdown clickable-course-link custom-select2-dropdown-nosearch course-dropdown">
									@foreach($coursesDataList['result'] as $key => $course)
									<option value="{{$course['course']['_id']}}">{{$course['course']['coursetitle']}}</option>
									@endforeach
								</select>
							</div>
							<div class="col-12 col-sm-6 col-md-6 col-lg-8 col-xl-8 d-none d-xl-block">
								<?php	if(count($coursesDataList['result'])>2) { ?>
									<select class="col-md-4 form-control clickable-course-link custom-select2-dropdown-nosearch" id="course-dropdown_2">
										@foreach($coursesDataList['result'] as $key => $course)
										<option value="{{$course['course']['_id']}}">{{$course['course']['coursetitle']}}</option>
										@endforeach
									</select>
								<?php } else { ?>
									@if(!empty($coursesDataList['result']))
									<ul class="nav nav-pills nav-pills_switch" id="pills-tab">
										@foreach($coursesDataList['result'] as $key => $course)
										<li class="nav-item mr-2" courseId="{{$key}}" data="{{$course['course']['_id']}}" data-level="{{$course['level_id']}}">
											<a href="javascript:void(0);" data="{{$course['course']['coursetitle']}}" id="pills-{{$course['course']['_id']}}-tab" class="clickable-course-link nav-link {{$loop->index == 0 ? 'active' : ''}}">{{$course['course']['coursetitle']}}</a>
										</li>
										@endforeach
									</ul>
									@endif
								<?php } ?>
							</div>
							<!-- <div class="col-6 col-sm-5 col-md-6 col-lg-4 col-xl-4">
								<div class="row">
									<div class="col-sm-12 col-md-9 col-lg-9 col-xl-10 common-search">
										<div class="search-form">
											<div class="form-group mb-0">
												<input type="search search_box" class="form-control form-control-lg search_work_record newsearch" placeholder="Search" id="searchbox" aria-label="Search">
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
							</div> -->
						</div>
					</div>
					

					<hr class="hr">

					<div class="main__content main__content_full work-record px-3">
						<div class="col-12">
							<div class="row mb-5">
								<div class="tab-content">
									<div class="tab-pane fade show active">
										<ul class="nav nav-tabs work-record-main-tab">
											<li class="nav-item markFilter" data-name="all">
												<a class="nav-link active" href="javascript:;">
													All Submitted Tasks
												</a>
											</li>
											<li class="nav-item markFilter mb-1" data-name="marked">
												<a class="nav-link" href="javascript:;">
													Marked Tasks
												</a>
											</li>
										</ul>
										<?php 
										//dd($records['result']['data']);
										?>
										<div class="tab-content">
											<div class="tab-pane fade show active">
												<div class="table-responsive">
													<table id="tabaleid" class="table work-record__table ieuktable-sline newdata" style="pointer-events:visible !important;">
														<thead class="thead-dark">
															<tr>
															  	<th scope="col">Topic</th>
																<th scope="col">Task</th>
																<th scope="col">Practise</th>
																<th scope="col">Teacher Review</th>
																<th scope="col">Marking type</th>
																<th scope="col" style="min-width: 50px;"></th>
															</tr>
														</thead>
														<tfoot>
												            <tr>
												                <th scope="col">Topic</th>
																<th scope="col">Task</th>
																<th scope="col">Practise</th>
																<th scope="col"></th>
																<th scope="col">Marking type</th>
																<th scope="col" style="min-width: 50px;"></th>
												            </tr>
												        </tfoot>
														<tbody id="myTabinnerContent"></tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<center>
							<div class="row text-center" id="image_class" style="display:none;">
									<div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
										<img src="{{ asset('public/images/no_record_found.gif') }}" width="100%">
										<p style="font-weight: 600;font-size: 20px;margin-left: 25px;">No Records Found</p>
									</div>
								</div>
						</center>
					</div>
			</section>
		</div>
	</div>
</main>
@endsection
@section('popup')
<div class="modal fade" id="addFeedbackModal" tabindex="-1" role="dialog"
aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm">
	<div class="modal-content">
		<div class="modal-header">
			<div class="modal-topic mr-4">
				<span class="m__topic">Topic 1</span>
				<span class="m__task">Task 5</span>
			</div>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<form class="taskFeedbackForm">
			<input type="hidden" name="topicid" class="feedbacktopicid">
			<input type="hidden" name="taskid"  class="feedbacktaskid">

			<div class="modal-body">
				<div class="my-review d-flex flex-wrap">
					<h6 class="mr-2">Review :</h6>
					<div class="form-check my-review-orange form-check-inline">
						<input class="form-check-input removechecked" type="radio" name="task_emoji" id="inlineRadio1" value="4">
						<label class="form-check-label" for="inlineRadio2">
						</label>
					</div>

					<div class="form-check my-review-red form-check-inline">
						<input class="form-check-input removechecked" type="radio" name="task_emoji" id="inlineRadio2" value="3">
						<label class="form-check-label" for="inlineRadio1">
						</label>
					</div>
					<div class="form-check my-review-yellow form-check-inline">
						<input class="form-check-input removechecked" type="radio" name="task_emoji" id="inlineRadio3" value="2">
						<label class="form-check-label" for="inlineRadio3">
						</label>
					</div>
					<div class="form-check my-review-green form-check-inline">
						<input class="form-check-input removechecked" type="radio" name="task_emoji" id="inlineRadio4" value="1">
						<label class="form-check-label" for="inlineRadio4">
						</label>
					</div>
				</div>
				<h6>Comments :</h6>
				<div class="form-group">
					<textarea name="student_task_comment" id="student_task_comment" class="form-control" value="" disabled></textarea>
				</div>
			</div>
			<div class="modal-footer justify-content-center">
				<div class="alert alert-success" role="alert" style="display:none"></div>
				<div class="alert alert-danger" role="alert" style="display:none"></div>
				<button type="button" class="btn  btn-cancel" data-dismiss="modal">Close</button>
			</div>
		</form>
	</div>
</div>
</div>
<div class="modal fade" id="practicePreviewModal" tabindex="-1" role="dialog" aria-labelledby="practicePreviewModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Task Review</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body">
				<div class="row wr_review_modal mb-3">	
					<div class="col-12 col-sm-7">
						<div class="modal-topic"> <span class="m__topic"></span> <span class="m__task">Task 5</span> <span class="m__category">A</span> </div>
					</div>
					<div class="col-12 col-sm-5">
						<div class="wr_modal_marks_gain">
							<p class="float-left float-sm-right">Marks: <span class="m__marks">0/0</span></p>
						</div>
					</div>
				</div>
				<div class="append_practice_preview"></div>
				<div class="w-100">
					<div class="col-md-12 mt-3 text-left" id="parent_audio_hide"> 
						<span class="wr_modal_footer_title">Teacher's Audio Comment : </span> 
						<span>
							<audio id="practice_audio_popup_parent" preload="auto" class="practice_audio_popup_parent audioplayer" src=""  ></audio>
						</span> 
					</div>

					<div class="col-md-12 wr_modal_review_icon mt-3" id="wr_modal_review_icon" style="display: flex;">
						<span class="wr_modal_footer_title">Teacher Review :</span> 
						<div class="parent_1">
							<img src="{{ asset('public/images/icon-emoji-gray-green.svg') }}" alt="Too Easy" class="img-fluid active green1"> 
							<img src="{{ asset('public/images/icon-emoji-green.svg') }}" alt="Too Easy" class="img-fluid active green2" style="display: none;"> 
						</div> 
						<div class="parent_2">
							<img src="{{ asset('public/images/icon-emoji-gray-yellow.svg') }}" alt="Too Easy" class="img-fluid active yellow1"> 
							<img src="{{ asset('public/images/icon-emoji-yellow.svg') }}" alt="Too Easy" class="img-fluid active yellow2" style="display: none;"> 
						</div> 
						<div class="parent_3">
							<img src="{{ asset('public/images/icon-emoji-gray-orange.svg') }}" alt="Too Easy" class="img-fluid active orange1"> 
							<img src="{{ asset('public/images/icon-emoji-orange.svg') }}" alt="Too Easy" class="img-fluid active orange2" style="display: none;"> 
						</div> 
						<div class="parent_4">
							<img src="{{ asset('public/images/icon-emoji-gray-red.svg') }}" alt="Too Easy" class="img-fluid active red1"> 
							<img src="{{ asset('public/images/icon-emoji-red.svg') }}" alt="Too Easy" class="img-fluid active red2" style="display: none;"> 
						</div>
					</div>
				
					<div class="w-100 mt-3 text-left" id="comments">
						<div class="col-md-12"> <span class="wr_modal_footer_title">Teacher's Comments : </span> </div>
						<div class="col-md-12"> <span class="wr_modal_footer_data">Remarks or comments added by teacher.</span> </div>
					</div>
				</div>
			</div>
			
			<div class="w-100 show-previous" style="display:none">
				<div class="modal-footer text-center">
					<button style="display:none" id="highestMark" class="btn btn-primary show-previous-history" data-show="1">Highest Score</button>
					<button style="display:none" id="secondMark" class="btn btn-primary show-previous-history" data-show="2">Second Score</button>
					<button style="display:none" id="latestMark" class="btn btn-success show-previous-history" data-show="0">Latest Score</button>
				</div>
			</div>

		</div>
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
				<button type="button" class="btn btn-cancel"  data-dismiss="modal" id="close_video">Close</button>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
	var topicurl = "{{ url('/topic-iframe/') }}";
	var taskS = "all";
	
	function getAlldata(flag) {
		if ( $.fn.DataTable.isDataTable('.newdata') ) {
		  $('.newdata').DataTable().destroy();
		}
		if(flag == "init"){
			var couseId = $('.nav-pills_switch').find('li:eq(0)').attr("data") != ""?$('.nav-pills_switch').find('li:eq(0)').attr("data"):$('#course-dropdown_2:eq(0)').val();
			var levelId = $('.nav-pills_switch').find('li:eq(0)').attr("data") != ""?$('.nav-pills_switch').find('li:eq(0)').attr("data-level"):$('#course-dropdown_2:eq(0)').val();
		    // data-level="{{$course['_id']}}"

		}else{
			var couseId = $('.nav-pills_switch').find(".active").parent("li").attr("data")!=""?$('.nav-pills_switch').find(".active").parent("li").attr("data"):$('#course-dropdown_2').val();
			var levelId = $('.nav-pills_switch').find(".active").parent("li").attr("data")!=""?$('.nav-pills_switch').find(".active").parent("li").attr("data-level"):$('#course-dropdown_2').val();
		}
		
		$.ajax({
			url: '<?php echo URL('/getExcercise'); ?>',
			type: 'get',
			data: {"couseId":couseId,"taskS":taskS,"levelId":levelId},
			beforeSend: function() {
				$('#cover-spin').fadeIn();
			},
			complete: function() {
				$('#cover-spin').fadeOut();
			},
			success: (json) => {
				$('#myTabinnerContent').html("");
				$('#myTabinnerContent').append(json);
				$('.hidden-data').remove();
				$(this).closest('tr').after(json);
				$(this).parents('tr').css("background-color","#FFFFF8");
				$(this).parents('tr').find('td').addClass('border-bottom-0');
				$(this).parents('tr').next('tr').find(".hidden-tr").css("background-color","#FFFFF8");
				setTimeout(function() {
					$('html, body').animate({
						scrollTop: $('.topic-block-marking').offset().top - 100 
					}, 800);
				},2000);
				var dataSearchtable = $('.newdata').DataTable({
				    paging: false,
				    dom: 'Bfrtip',
				    buttons: [
				        'excelHtml5'
				    ],
				    "bInfo": true,
				    columnDefs: [
				        { orderable: true, className: 'reorder', targets: 0 },
				        { orderable: true, className: 'reorder', targets: 1 },
				        { orderable: false, className: 'reorder', targets: 2 },
				        { orderable: false, className: 'reorder', targets: 3 },
				        { orderable: true, className: 'reorder', targets: 4 },
				        { orderable: false, className: 'reorder', targets: 5 },
				    ],
				    initComplete: function () {
			            this.api()
			                .columns([0,1,2,4])
			                .every(function () {
			                    var column = this;
			                    var select = $('<select><option value=""></option></select>')
			                        .appendTo($(column.footer()).empty())
			                        .on('change', function () {
			                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
			 
			                            column.search(val ? '^' + val + '$' : '', true, false).draw();
			                        });
			                    column
			                        .data()
			                        .unique()
			                        .sort()
			                        .each(function (d, j) {
			                            select.append('<option value="' + d + '">' + d + '</option>');
			                        });
			                });
			        }
				});
				/*$('.newdata tfoot th').each(function () {
					var title = $(this).text();
					$(this).html('<input type="text" placeholder="Search ' + title + '" />');
				});*/
				setTimeout(function() {
					$('#tabaleid').css("pointer-events","visible !important;");
				}, 1000);
			}
		});


	}
	function file_get_contents(filename) {
	    fetch(filename).then((resp) => resp.text()).then(function(data) {
	        document.getElementById("hidediv").innerHTML = data;
	    });
	}
	function getData(practice_id,course_id,level_id,task_id,topic_id,flag,data) {
		var url = topicurl+'/'+topic_id+"/"+task_id+"/"+practice_id+"/"+flag;
		var taskdata = file_get_contents(url);
		$('#1').html("");
		$('#1').html('<iframe frameborder="0" style="overflow: hidden; height: 500px; width: 100%;" src="'+url+'" />');
		setTimeout(() => {
		  /*$('#marksdisplay').html("Mark <span>"+data+"</span>");
		  $('#cover-spin').fadeOut();*/
		},1000)
		setTimeout(() => {
			window.orignalmarks 		= 	$('#hidediv').find('#new_marks').val();
			window.orignalmarksGained 	=  	$('#hidediv').find('#new_marks_gained').val();
			$('#marksdisplay').html("Mark <span>"+window.orignalmarksGained+"/"+window.orignalmarks+"</span>");
		  	$('#cover-spin').fadeOut();
		}, 2000);
	}
	$(document).ready(function() {
		window.newflag = true;
		getAlldata("init");
	});
	$(document).on('change','#course-dropdown_2',function() {
		window.newflag = false;
		getAlldata("second");
	});
	$(document).on('click','.nav-pills_switch li',function() {
		$(".nav-pills_switch li a").removeClass("active");
		$(this).find("a").addClass("active");
		window.newflag = false;
		getAlldata("second");
	});
	$(document).on('click','.score',function() {
		window.data = $(this).closest("tr").prev().find("td:eq(3)").html();
		getData(window.practiseId,window.courseId,window.levelId,window.taskId,window.topic_id,$(this).attr('data'),window.data);
	});
	$("body").on('click','.markFilter',function(){
		var clickEle = $(this);
		$(".markFilter").find('a').removeClass('active');
		clickEle.find('a').addClass('active');
		taskS = clickEle.attr("data-name");
		window.newflag = false;
		getAlldata();
	});
	$(document).on('click','.click',function() {
		window.data = $(this).closest("tr").find("td:eq(3)").html();
		$(".odd").css("background-color","#ffffff");
		$(".even").css("background-color","#ffffff");
		$(".odd").find('td').removeClass('border-bottom-0');
		$(".even").find('td').removeClass('border-bottom-0');
		$(this).parents('tr').css("background-color","#FFFFF");
		window.taskId 			= $(this).attr('taskid');
		window.practiseId 		= $(this).attr('practice_id');
		window.levelId 			= $(this).attr('level_id');
		window.courseId 		= $(this).attr('course_id');
		window.StudetnId 		= $(this).attr('studentid');
		window.topic_id 		= $(this).attr('topic_id');
		var flag= true;
		if($(this).closest("tr").next().attr('class') == "hidden-data"){
			$(this).removeClass("active");
			$(this).closest("tr").next().slideUp('slow');
			setTimeout(() => {
				$(this).closest("tr").next().remove();
			}, 1000);
			flag= false;
		}else{
			flag= true;
			$(".hidden-tr-opner").removeClass("active");
		}

		if(flag){
			$.ajax({
				url: '<?php echo URL('/getview'); ?>',
				type: 'get',
				data: {'flag_for_tab':window.type,'studenId':$(this).attr('studentid'),'taskId':$(this).attr('taskid'),'course':$(this).attr('course_id'),'level':$(this).attr('level_id'),'practice_id':$(this).attr('practice_id')},
				beforeSend: function() {
					$('#cover-spin').fadeIn();
				},
				complete: function() {
					$('#cover-spin').fadeOut();
				},
				success: (json) => {
					$('.hidden-data').remove();
					$(this).closest('tr').after(json);
					var ABCSArray = new Array("A","B","C","D","E","F","G","H","I","J","K");
					$('.topic-tabs-topic-names').text("Topic "+$(this).attr("topic-data"));
					$('.topic-tabs-task-names').text("Task "+$(this).attr("task-data"));
					$('.topic-tabs-section-names').text(""+ABCSArray[$(this).attr("practise-data")-1]);
					$(this).addClass("active");
					$(this).parents('tr').css("background-color","#FFFFF8");
					$(this).parents('tr').find('td').addClass('border-bottom-0');
					$(this).parents('tr').next('tr').find(".hidden-tr").css("background-color","#FFFFF8");
					setTimeout(function() {
						$('html, body').animate({
							scrollTop: $('.topic-block-marking').offset().top - 100 
						}, 800);
					}, 100);
					getData($(this).attr("practice_id"),$(this).attr("course_id"),$(this).attr("level_id"),$(this).attr("taskid"),$(this).attr("topic_id"),$(this).closest('tr').next().find(".score:eq(0)").attr("data"),window.data);
				}
			});
		}
	});
</script>
<style type="text/css">
	 tfoot {
        display: table-header-group;
    }}
</style>
@endsection