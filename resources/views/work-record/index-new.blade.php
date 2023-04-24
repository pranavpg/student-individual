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
</style>
@endsection
@section('content')
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
						@foreach($courses as $key => $course)
						<option value="{{$key}}">{{$course['coursetitle']}}</option>
						@endforeach
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
				<section class="main notes ieuk-wrm col-sm-12">

					<div class="summary-heading p-3">
						<!-- <a href="{{url('/')}}" class="back-button">back</a> -->
						<h1 class="text-center pageheading">
							<span style="display: inline-flex;">
								<!-- <img src="{{asset('public/images/icon-heading-notes.svg')}}" alt="" class="img-fluid"> -->
								<i class="fas fa-clipboard"></i>
							</span> Work Record
						</h1>
					</div>

					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<div class="row justify-content-center">
							<div class="col-12 col-sm-7 col-md-6 col-lg-8 col-xl-8 d-none d-sm-block d-xl-none notes-selection">
								<select class="col-md-6 custom-select2-dropdown-nosearch course-dropdown">
									@foreach($courses as $key => $course)
									<option value="{{$key}}">{{$course['coursetitle']}}</option>
									@endforeach
								</select>
							</div>
							<div class="col-12 col-sm-6 col-md-6 col-lg-8 col-xl-8 d-none d-xl-block">
								<?php	if(count($courses)>2) { ?>
									<select class="col-md-4 custom-select2-dropdown-nosearch" id="course-dropdown_2">
										@foreach($courses as $key => $course)
										<option value="{{$key}}">{{$course['coursetitle']}}</option>
										@endforeach
									</select>
								<?php } else { ?>
									<?php //dd($courses)?>
									@if(!empty($courses))
									<ul class="nav nav-pills nav-pills_switch" id="pills-tab">
										@foreach($courses as $key => $course)
										<li class="nav-item mr-2" courseId="{{$key}}">
											<a href="javascript:void(0);" data="{{$course['coursetitle']}}" id="pills-{{$course['_id']}}-tab" class="clickable-course-link nav-link {{$loop->index == 0 ? 'active' : ''}}">{{$course['coursetitle']}}</a>
										</li>
										@endforeach
									</ul>
									@endif
								<?php } ?>
							</div>
							<div class="col-6 col-sm-5 col-md-6 col-lg-4 col-xl-4">
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
							</div>
						</div>
					</div>

					<hr class="hr">

					<div class="main__content main__content_full work-record px-3">
						<div class="col-12">
							<div class="row mb-5">
								<div class="tab-content">
									<div class="tab-pane fade show active">
										<ul class="nav nav-tabs">
											<li class="nav-item markFilter" data-name="all">
												<a class="nav-link active" href="javascript:;">
													All Submitted Tasks
												</a>
											</li>
										<!-- <li class="nav-item markFilter" data-name="awaiting">
											<a class="nav-link" href="javascript:;">
												Awaiting Marking
											</a>
										</li> -->
										<li class="nav-item markFilter mb-1" data-name="marked">
											<a class="nav-link" href="javascript:;">
												Marked Tasks
											</a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane fade show active">
											<div class="table-responsive">
												<table id="tabaleid" class="table work-record__table ieuktable-sline">
													<thead class="thead-dark">
														<tr>
														  <th scope="col">Topic</th>
															<th scope="col">Task</th>
															<th scope="col">Latest Mark</th>
															<th scope="col">Highest Mark</th>
															<th scope="col">Teacher Review</th>
															<th scope="col">My Review</th>
															<th scope="col">Marking type</th>
															<th scope="col"></th>
														</tr>
													</thead>
													<tbody id="myTabinnerContent">
													</tbody>
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
					<!-- <div class="col-12">
						<div class="row ml-2">
							<ul id="pagination" class="pagination-sm"></ul>
						</div>
					</div> -->
				</div>
			</section>
		</div>
	</div>
</main>
@endsection
@section('popup')
<div class="modal fade" id="addFeedbackModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
						<!-- popoup review -->
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
					<!-- <button type="button" class="btn  btn-primary btnSaveFeedback">
						<span><img src="{{asset('public/images/icon-btn-save.svg')}}" alt="" class="img-fluid"></span>
						Save
					</button> -->
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
				<button type="button" class="btn btn-cancel"  data-dismiss="modal" id="close_video">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- end instruction video -->
@endsection
@section('script')
<script type="text/javascript"  src="{{asset('public/js/k-common.js')}}"></script>
<!-- <script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<script type="text/javascript">
	var userCourses = @json($courses), filterRecords= {}, userCuRecords = [];
	var emoji_progress_width = ['100%','75%','50%','25%'], emoji =['icon-emoji-green.svg','icon-emoji-yellow.svg', 'icon-emoji-orange.svg', 'icon-emoji-red.svg'], filterData = {}, topicurl = "{{ url('/topic-iframe/') }}";;
	var htmlTemplate = '<tr class="content"><td><span title="Topic"></span>{0}</td><td><span title="Task"></span>{1}</td><td><span title="Latest Mark"></span>{2}</td><td><span title="Highest Mark"></span>{3}</td><td><span title="Teacher Review"></span>{4}</td><td><span title="My Review"></span>{5}</td><td><span title="Marking type"></span>{6}</td><td>{7}</td></tr><tr class="hidden-data"><td colspan="8"><div class="hidden-tr" style="display:none"><div class="topic-block">\
	<table class="table table-light table-borderless">\
	<thead class="thead-dark">\
	<tr>\
	<th scope="col">Practice</th>\
	<th scope="col">Latest Mark</th>\
	<th scope="col">Highest Mark</th>\
	<th scope="col">Marking Type</th>\
	<th scope="col">View</th>\
	</tr>\
	</thead>\
	<tbody class="tbody-inner-data">\
	</tbody>\
	</table>\
	</div>\
	</div>\
	</td>\
	</tr>', getRecords="{{route('student.work_records')}}", container = $('#myTabinnerContent');

	var htmlBladeTemplate = '<tr><td class="d-block d-md-none"><span title="Practice (Gained Marks)"></span>{0} ({1})</td><td scope="row" class="d-none d-md-table-cell"><span title="Practice"></span>{0}</td><td class="d-none d-md-table-cell"><span title="Gained Marks"></span>{1}</td><td class="d-none d-md-table-cell"><span title="Highest Marks"></span>{2}</td><td class=""><span title="Marking Type"></span>{3}</td><td>{4}</td></tr>';
	window.total = [];
	var count = 0;

	function myFunction(value, index, array) {
			// console.log(value);
			return  parseInt(value) 
		}

		var addPractises = (responseData,total) =>{
			for (var i = 0; i < responseData.length; i++) {
				var practiseId = responseData[i]['practise_id'], taskName = responseData[i]['task_name'], topicName = responseData[i]['topic_name'], taskId = responseData[i]['task_id'], topicId = responseData[i]['topic_id'], studentTaskComment=responseData[i]['student_task_comment'] ? responseData[i]['student_task_comment'] : '', taskEmoji = parseInt(responseData[i]['task_emoji']), showTaskEmoji = taskEmoji - 1, teacherEmoji = parseInt(responseData[i]['teacher_emoji']), showTeacherEmoji = teacherEmoji - 1, teacherReview = '-', studentReview = '';
				//console.log(practiseId);
				//console.log(total[taskId]['mark_gained']);
				let mark_gained = 0;
				total[taskId]['mark_gained'].forEach(function(item) {
					if(item == "") {return }
						mark_gained+=parseInt(item);
				});
				//console.log(mark_gained);

				let original_marks = 0;

				total[taskId]['original_marks'].forEach(function(item) {
					original_marks+=parseInt(item);
				});
                
                let highest_mark = 0;
                total[taskId]['highest_mark_gained'].forEach(function(item) {
					if(item == "") {return }
						highest_mark+=parseInt(item);
				});
				//debugger;
				if(teacherEmoji == 4){
					teacherReview = '<div class="d-sm-block d-md-flex align-items-center open-add-feedback-modal"  data-topicno="'+topicName+'" data-taskno="'+taskName+'" data-topicid="'+topicId+'" data-practiceid="'+practiseId+'" data-taskid="'+taskId+'" data-taskcomment="'+responseData[i].teacher_comment+'" data-taskemoji="'+responseData[i].teacher_emoji+'"><span class="review-icon"><img src="{{asset('public/images/icon-emoji-orange.svg')}}" alt="" class="img-fluid" /></span><span class="progress"><span class="progress-bar" <img src="{{asset('public/images/icon-emoji-orange.svg')}}" role="progressbar" style="width:'+emoji_progress_width[showTeacherEmoji]+'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></span> </span></div>';
				}
				else if(teacherEmoji == 3){
					teacherReview = '<div class="d-sm-block d-md-flex align-items-center open-add-feedback-modal"  data-topicno="'+topicName+'" data-taskno="'+taskName+'" data-topicid="'+topicId+'" data-practiceid="'+practiseId+'" data-taskid="'+taskId+'" data-taskcomment="'+responseData[i].teacher_comment+'" data-taskemoji="'+responseData[i].teacher_emoji+'"><span class="review-icon"><img src="{{asset('public/images/icon-emoji-red.svg')}}" alt="" class="img-fluid" /></span><span class="progress"><span class="progress-bar <img src="{{asset('public/images/icon-emoji-red.svg')}}"" role="progressbar" style="width:'+emoji_progress_width[showTeacherEmoji]+'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></span> </span></div>';
				}
				else if(teacherEmoji && teacherEmoji > 0){
					var imgSrc = 
					teacherReview = '<div class="d-sm-block d-md-flex align-items-center open-add-feedback-modal"  data-topicno="'+topicName+'" data-taskno="'+taskName+'" data-topicid="'+topicId+'" data-practiceid="'+practiseId+'" data-taskid="'+taskId+'" data-taskcomment="'+responseData[i].teacher_comment+'" data-taskemoji="'+responseData[i].teacher_emoji+'"><span class="review-icon"><img src="{{asset('public/images/')}}'+'/'+emoji[showTeacherEmoji]+'" alt="" class="img-fluid" /></span><span class="progress"><span class="progress-bar '+emoji[showTeacherEmoji]+'" role="progressbar" style="width:'+emoji_progress_width[showTeacherEmoji]+'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></span> </span></div>';
				}

				//Student Review
				if(taskEmoji == 3){
					studentReview = '<div class="d-sm-block d-md-flex align-items-center open-add-feedback-modal "  data-topicno="'+topicName+'" data-taskno="'+taskName+'" data-topicid="'+topicId+'" data-practiceid="'+practiseId+'" data-taskid="'+taskId+'" data-taskcomment="'+studentTaskComment+'" data-taskemoji="'+taskEmoji+'"><span class="review-icon"><img src="{{asset('public/images/icon-emoji-red.svg')}}" alt="" class="img-fluid"/></span><span class="progress"><span class="progress-bar '+emoji[showTaskEmoji]+'" role="progressbar" style="width:'+emoji_progress_width[showTaskEmoji]+'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></span></span></div>';
				}else if(taskEmoji == 4){
					studentReview = '<div class="d-sm-block d-md-flex align-items-center open-add-feedback-modal "  data-topicno="'+topicName+'" data-taskno="'+taskName+'" data-topicid="'+topicId+'" data-practiceid="'+practiseId+'" data-taskid="'+taskId+'" data-taskcomment="'+studentTaskComment+'" data-taskemoji="'+taskEmoji+'"><span class="review-icon"><img src="{{asset('public/images/icon-emoji-orange.svg')}}" alt="" class="img-fluid"/></span><span class="progress"><span class="progress-bar '+emoji[showTaskEmoji]+'" role="progressbar" style="width:'+emoji_progress_width[showTaskEmoji]+'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></span></span></div>';
				}else if(taskEmoji && taskEmoji > 0){
					var imgSrc =  
					studentReview = '<div class="d-sm-block d-md-flex align-items-center open-add-feedback-modal "  data-topicno="'+topicName+'" data-taskno="'+taskName+'" data-topicid="'+topicId+'" data-practiceid="'+practiseId+'" data-taskid="'+taskId+'" data-taskcomment="'+studentTaskComment+'" data-taskemoji="'+taskEmoji+'"><span class="review-icon"><img src="{{asset('public/images/')}}'+'/'+emoji[showTaskEmoji]+'" alt="" class="img-fluid"/></span><span class="progress"><span class="progress-bar '+emoji[showTaskEmoji]+'" role="progressbar" style="width:'+emoji_progress_width[showTaskEmoji]+'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></span></span></div>';
				}else{
					studentReview = '<a href="javascript:void(0)" class="open-add-feedback-modal" data-topicno="'+topicName+'" data-taskno="'+responseData[i]['task_name']+'" data-topicid="'+topicId+'" data-practiceid="'+practiseId+'" data-taskid="'+taskId+'" data-taskcomment="'+studentTaskComment+'" data-taskemoji="'+taskEmoji+'"> <img src="{{ asset('public/images/icon-small-eye.png')}}" alt="" width="26px" class="img-fluid" /></a>';    
				}

				if(responseData[i].is_marked_by == "automated")
				{
					responseData[i].is_marked_by = "Automated";
				}
				else if(responseData[i].is_marked_by == "read_only")
				{
					responseData[i].is_marked_by = "Participation";
				}
				else if(responseData[i].is_marked_by == "manual")
				{
					responseData[i].is_marked_by = "Teacher mark";
				}
				else if(responseData[i].is_marked_by == "student_self_marking")
				{
					responseData[i].is_marked_by = "Class Mark";
				}
				else if(responseData[i].is_marked_by == "self")
				{
					responseData[i].is_marked_by = "Self Mark";
				}
				else if(responseData[i].is_marked_by == "No marking")
				{
					responseData[i].is_marked_by = "No marks";
				}
				newHtml = htmlTemplate.replace('{0}', responseData[i].topic_name)
				.replace('{1}', responseData[i].task_name)
				.replace('{2}', (isNaN(mark_gained)?0:mark_gained)+'/'+original_marks)
				.replace('{3}',(isNaN(highest_mark)?0:highest_mark)+'/'+original_marks)
				//.replace('{2}', responseData[i].original_marks)
				.replace('{4}',teacherReview)
				.replace('{5}',studentReview)
				//.replace('{5}','<input type="hidden" value="'+responseData[i].is_marked_by+'">')
				.replace('{6}',responseData[i].is_marked_by)
				.replace('{7}','<a href="javascript:void(0)" class="hidden-tr-opner" style="width: 18px;height: 18px;display: inline-block;" data-topicid="'+topicId+'" data-practiceid="'+practiseId+'" data-taskid="'+taskId+'"> <img src="{{asset('public/images/icon-table-opener.svg')}}" alt="" class="img-fluid" /></a>');
				container.append(newHtml);

			}
		};

		// var showPagination = (totalCount) => {
		// 	$('#pagination').twbsPagination('destroy');

		// 	$('#pagination').twbsPagination({
		// 		totalPages: totalCount,
		// 		visiblePages: 5,
		// 		onPageClick: function (event, page) {
		// 			filterData.page = page;
		// 			container.html('');
		// 			AjaxCall(getRecords, JSON.stringify(filterData), "post", "json", "application/json",true).done(function (response) {
		// 				if (response.IsSuccess) {
		// 					if(response.Data){
		// 						addPractises(response.Data);
		// 					}
		// 				}else{
		// 					if(response.Message){
		// 						alert(response.Message);    
		// 					}
		// 				}
		// 			});
		// 		}
		// 	})
		// }

		var ajaxRecords = (filterData) => {
			container.html('');
			AjaxCall(getRecords, JSON.stringify(filterData), "post", "json", "application/json",true).done(function (response) {
				if (response.IsSuccess) {
					if(response.Data){
						//console.log(response.Data);
						window.total = response.total;
						userCuRecords = response.Data;
						addPractises(response.Data,window.total);
						/*$("#dataTables").DataTable();*/
					}
				}else{
					if(response.Message){
						// alert(response.Message);    
					}
				}
			});
		}

		var addSinglePractise = (responseData) => {
			var newBladeHtml='';
			for (var i = 0; i < responseData.length; i++) {
				var practiseId = responseData[i]['practise_id'], practiseNo = responseData[i]['p_sort'], taskName = responseData[i]['task_name'], topicName = responseData[i]['topic_name'], taskId = responseData[i]['task_id'], topicId = responseData[i]['topic_id'], studentTaskComment=responseData[i]['student_task_comment'] ? responseData[i]['student_task_comment'] : '', taskEmoji = parseInt(responseData[i]['task_emoji']), showTaskEmoji = taskEmoji - 1, teacherEmoji = parseInt(responseData[i]['teacher_emoji']), showTeacherEmoji = teacherEmoji - 1, teacherReview = '', studentReview = '', markGained = responseData[i]['marks_gained'], totalMarks = responseData[i]['original_marks'], teacherAudio='',highMark=responseData[i]['highest_score_attempt_id'] ? responseData[i]['highest_score_attempt_id'] : '', secondHigh=responseData[i]['second_score_attempt_id'] ? responseData[i]['second_score_attempt_id'] : '', highScore=responseData[i]['high_csore'] ? responseData[i]['high_csore'] : '', highTeacherComment=responseData[i]['high_teacher_comment'] ? responseData[i]['high_teacher_comment'] : '', highTeacherEmoji=parseInt(responseData[i]['high_teacher_emoji']), highTeacherAudio=responseData[i]['high_teacher_audio'] ? responseData[i]['high_teacher_audio'] : '', secondScore=responseData[i]['second_score'] ? responseData[i]['second_score'] : '', secondTeacherComment=responseData[i]['second_teacher_comment'] ? responseData[i]['second_teacher_comment'] : '', secondTeacherEmoji=parseInt(responseData[i]['second_teacher_emoji']), secondTeacherAudio=responseData[i]['second_teacher_audio'] ? responseData[i]['second_teacher_audio'] : '';
                    var highmark=responseData[i]['high_mark'] ? responseData[i]['high_mark'] : '';
                    console.log(responseData[i]);
						//Teacher Review
						if(responseData[i]['teacher_comment']){
							teacherReview = responseData[i]['teacher_comment'];
						}

						if(responseData[i]['teacher_audio']){
							teacherAudio = responseData[i]['teacher_audio'];
						}

						//Single Practise
						var viewReview = '<a href="javascript:void(0)" class="open_practice_preview_modal" data-practiceno="'+practiseNo+'" data-topicno="'+topicName+'" data-taskno="'+taskName+'" data-topicid="'+topicId+'"  data-practiceid="'+practiseId+'" data-taskid="'+taskId+'"  data-original-marks="'+totalMarks+'" data-marks-gained="'+markGained+'" data-teacher-comment="'+teacherReview+'" data-teacher-emoji="'+teacherEmoji+'"  data-teacher-audio="'+teacherAudio+'" data-high="'+highMark+'" data-second-high="'+secondHigh+'" data-high-score="'+highScore+'" data-high-teacher-comment="'+highTeacherComment+'" data-high-teacher-audio="'+highTeacherAudio+'" data-high-teacher-emoji="'+highTeacherEmoji+'" data-second-score="'+secondScore+'" data-second-teacher-comment="'+secondTeacherComment+'" data-second-teacher-audio="'+secondTeacherAudio+'" data-second-teacher-emoji="'+secondTeacherEmoji+'"><img src="{{asset('public/images/icon-small-eye.png')}}" alt="" width="22px" class="img-fluid"></a>';

						if(responseData[i].is_marked_by == "automated")
						{
							responseData[i].is_marked_by = "Automated";
						}
						else if(responseData[i].is_marked_by == "read_only")
						{
							responseData[i].is_marked_by = "Participation";
						}
						else if(responseData[i].is_marked_by == "manual")
						{
							responseData[i].is_marked_by = "Teacher mark";
						}
						else if(responseData[i].is_marked_by == "student_self_marking")
						{
							responseData[i].is_marked_by = "Class Mark";
						}
						else if(responseData[i].is_marked_by == "self")
						{
							responseData[i].is_marked_by = "Self Mark";
						}
						else if(responseData[i].is_marked_by == "No marking")
						{
							responseData[i].is_marked_by = "No marks";
						}
						newBladeHtml += htmlBladeTemplate.replaceAll('{0}', responseData[i].p_sort)
																//   .replaceAll('{1}', markGained)
																.replaceAll('{1}', (markGained ? markGained : 0)+'/'+totalMarks)
																.replaceAll('{2}',(highScore ? highScore : 0)+'/'+totalMarks)
																.replaceAll('{3}', responseData[i].is_marked_by)
																.replaceAll('{4}', viewReview)
															}
															return newBladeHtml;
														}

														function changeAudio(song) {
															audio = document.getElementById("practice_audio_popup_parent");
															audio.src = song;
															audio.load();
				// audio.play();
			}

			function Audioplay(pid,inc,flagForAudio) {
				var supportsAudio = !!document.createElement('audio').canPlayType;
				if (supportsAudio) {
					var i;
					var player = new Plyr(".practice_audio_popup_parent", {
						controls: [
						'play',
						'progress',
						'current-time'
						]
					}); 
				}
			}

			const showEmoji = (teacherEmoji) => {
				$('.wr_modal_review_icon').css("display","flex !important")

				for(var i=0;i<4;i++){
					$('.green1').css("display","inline-block");
					$('.red1').css("display","inline-block");
					$('.orange1').css("display","inline-block");
					$('.yellow1').css("display","inline-block");

					$('.green2').css("display","none");
					$('.red2').css("display","none");
					$('.orange2').css("display","none");
					$('.yellow2').css("display","none");
				}
				
				if(teacherEmoji == 1){
					$('.green2').css("display","inline-block");
					$('.green1').css("display","none");
				}else if(teacherEmoji == 2){
					$('.yellow2').css("display","inline-block");
					$('.yellow1').css("display","none");
				}else if(teacherEmoji == 3){
					
					$('.orange2').css("display","inline-block");
					$('.orange1').css("display","none");

				}else if(teacherEmoji == 4){

					$('.red2').css("display","inline-block");
					$('.red1').css("display","none");
				}

				if(teacherEmoji >= 0){
					$('#wr_modal_review_icon').css("display","flex");
				}else{
					$('#wr_modal_review_icon').css("display","none");
				}
			}

			const showAudio = (audio) => {
				if(audio!=""){
					$('#practice_audio_popup').attr("src",audio);
					changeAudio(audio);
					Audioplay();
					$('#parent_audio_hide').fadeIn();
				}else{
					$('#parent_audio_hide').fadeOut();
				}
			}

			const showComment = (teacherComment) => {
				if(teacherComment == ""){
					$('#comments').fadeOut();
				}else{
					$('#comments').fadeIn();
				}
				$('#practicePreviewModal').find('.wr_modal_footer_data').html(teacherComment);
			}

			const filterTaskTopicValue = (courseId) => {
				$("#teaReview").find('button').html('All Teacher Review');
				$("#stuReview").find('button').html('All Student Review');

				$(".showSelectTask, .showSelectTopic").hide();
				$("#selectTask").html('');
				$("#selectTopic").html('');
				$(".showSelectTask").hide();
				var filterCourse = Object.values(userCourses).find(course => course._id == courseId)
				//console.log(filterCourse);
				//alert(filterCourse);
				if(filterCourse){
					if(filterCourse.task_ids.length > 0){
						var taskFilter = '<option value="">All Task</option>';
						$.each(filterCourse.task_ids,function(index,value){
							taskFilter += "<option value="+value+">"+value+"</option>";
						})
						$("#selectTask").html(taskFilter);
						$(".showSelectTask").show();    
					}

					if(filterCourse.topic_ids.length > 0){
						var topicFilter = '<option value="">All Topic</option>';
						$.each(filterCourse.topic_ids,function(index,value){
							topicFilter += "<option value="+value+">"+value+"</option>";
						})
						$("#selectTopic").html(topicFilter);
						$(".showSelectTopic").show();    
					}
				}
			}

			const filterTcRecords = (filterRecords) => {
				var showTcRecods = userCuRecords;

				if(filterRecords.topic_sorting > 0){
					showTcRecods = showTcRecods.filter(record => record.topic_sorting == filterRecords.topic_sorting);
				}

				if(filterRecords.task_sorting > 0){
					showTcRecods = showTcRecods.filter(record => record.task_sorting == filterRecords.task_sorting);
				}

				if(filterRecords.teacher_emoji > 0){
					showTcRecods = showTcRecods.filter(record => record.teacher_emoji == filterRecords.teacher_emoji);
				}

				if(filterRecords.task_emoji > 0){
					showTcRecods = showTcRecods.filter(record => record.task_emoji == filterRecords.task_emoji);
				}

				if(showTcRecods.length > 0){
					$("p").fadeOut();
					addPractises(showTcRecods,window.total);     
				}
				else{
					$("p").fadeIn();
						//alert('sadf');
					}

				}

				$('document').ready(function() {

					$("#course-dropdown_2").change(function(){
						var courseId = $(this).val();
						var newid = "pills-"+courseId+"-tab";
						// alert(newid);
						$(".nav-link").removeClass('active');
						$("#"+newid).addClass('active');

						var get_rec = $("#newdrop option[value='"+courseId+"']").text();
						$("#newdrop option[value='"+courseId+"']").prop('selected', true);
						$("#select2-newdrop-container").text(get_rec);

						if(courseId){
							filterTaskTopicValue(courseId);
							filterData = { course_id: courseId };
							ajaxRecords(filterData);
						}
					})

					$("#newdrop").change(function(){
						var courseId = $(this).val();
						var newid = "pills-"+courseId+"-tab";

						var get_rec = $("#newdrop option[value='"+courseId+"']").text();
					    $("#newdrop option[value='"+courseId+"']").prop('selected', true);
					    $("#select2-course-dropdown_2-container").text(get_rec);

						$(".nav-link").removeClass('active');
						$("#"+newid).addClass('active');
						if(courseId){
							filterTaskTopicValue(courseId);
							filterData = { course_id: courseId };
							ajaxRecords(filterData);
						}
					})
					
					if($("#pills-tab").find('.nav-item').find('.nav-link.active').length > 0){
						var courseId = $("#pills-tab").find('.nav-item').find('.nav-link.active').parent().attr('courseId');
						if(courseId){
							filterTaskTopicValue(courseId);
							filterData = { course_id: courseId };
							ajaxRecords(filterData);
						}
					}

				//Old Click Events
				$("body").on('change','#selectTopic',function(){
						var taskValue = $(this).val();
						filterData.topic_sorting = taskValue;
						ajaxRecords(filterData);
				})

				$("body").on('change','#selectTask',function(){
						var taskValue = $(this).val();
						filterData.task_sorting = taskValue;
						ajaxRecords(filterData);
				})

				$("body").on('click','#teaReview span.dropdown-item',function(){
						var tReview = $(this).data('value');
						if(tReview > 0){
								$(this).parents('.dropdown').find('button').html($(this).html())
						}else{
								$(this).parents('.dropdown').find('button').html($(this).data('html'))
						}
						filterData.teacher_review = tReview;
						ajaxRecords(filterData);
				})

				$("body").on('click','#stuReview span.dropdown-item',function(){
						var sReview = $(this).data('value');
						if(sReview > 0){
								$(this).parents('.dropdown').find('button').html($(this).html())
						}else{
								$(this).parents('.dropdown').find('button').html($(this).data('html'))
						}
						filterData.student_review = sReview;
						ajaxRecords(filterData);
					})

				//New Click Events Start
				$("body").on('change','#selectTopic',function(){
					container.html('');
					var topicValue = parseInt($(this).val());
					filterRecords.topic_sorting = topicValue;
					filterTcRecords(filterRecords)
				})

				$("body").on('change','#selectTask',function(){
					container.html('');
					var taskValue = parseInt($(this).val());
					filterRecords.task_sorting = taskValue;
					filterTcRecords(filterRecords)
				})

				// $("body").on('click','#teaReview span.dropdown-item',function(){
				$("input[name='topic-stacked']").click(function() {
					container.html('');
					var tReview = parseInt($(this).val());
					if(tReview > 0){
						$(this).parents('.dropdown').find('button').html($(this).html())
					}else{
						$(this).parents('.dropdown').find('button').html($(this).data('html'))
					}
					filterRecords.teacher_emoji = tReview;
					filterTcRecords(filterRecords)
				})

				//$("body").on('click','#stuReview span.dropdown-item',function(){
				$("input[name='topic-stacked_1']").click(function() {
					container.html('');
					var sReview = parseInt($(this).val());
					if(sReview > 0){
						$(this).parents('.dropdown').find('button').html($(this).html())
					}else{
						$(this).parents('.dropdown').find('button').html($(this).data('html'))
					}
					filterRecords.task_emoji = sReview;
					filterTcRecords(filterRecords)
				})
				//New Click Events End

				$("body").on('click','.clickable-course-link',function(){
					var clickEle = $(this);
					$(".clickable-course-link").removeClass('active');
					clickEle.addClass('active');
					var courseId = clickEle.parent().attr('courseId');
					var get_rec = $("#newdrop option[value='"+courseId+"']").text();
					$("#newdrop option[value='"+courseId+"']" ).prop('selected', true);
					$("#select2-newdrop-container").text(get_rec);
					
					if(courseId){
						filterTaskTopicValue(courseId);
						filterData = { course_id: courseId };
						ajaxRecords(filterData);
					}
				})

				$("body").on('click','.markFilter',function(){
					var clickEle = $(this);
					$(".markFilter").find('a').removeClass('active');
					clickEle.find('a').addClass('active');
					var courseId = $(".clickable-course-link.active").parent().attr('courseId'), markName = $(this).data('name');
					if(courseId && markName){
						filterTaskTopicValue(courseId);
						filterData = { course_id: courseId, mark_filter:markName };
						ajaxRecords(filterData);
					}
				})

				$("body").on('click','.open-add-feedback-modal',function(){
					$('.removechecked').prop("checked",false);
					$('#addFeedbackModal').modal('toggle');
					var task_comment    = $(this).data("taskcomment");
						//alert(task_comment);
						var task_emoji      = $(this).data("taskemoji");
						var topic_id        = $(this).data("topicid");
						var practice_id     = $(this).data("practiceid");
						var task_id         = $(this).data("taskid");
						var topicno         = $(this).data("topicno");
						var taskno          = $(this).data("taskno");
						var practiceno      = $(this).data("practiceno");

						$('#addFeedbackModal').find('.m__topic').html('Topic '+ topicno);
						$('#addFeedbackModal').find('.feedbacktopicid').val(topic_id);
						$('#addFeedbackModal').find('.feedbacktaskid').val(task_id);
						$('#addFeedbackModal').find('.m__task').html('Task '+ taskno);
						$('#addFeedbackModal').find('.m__category').html(practiceno);
						$('#addFeedbackModal').find('#student_task_comment').val("");
						$('#addFeedbackModal').find('#student_task_comment').val(task_comment);
						
						var final = "";
						if(task_emoji ==4){
							final = 1
						}
						if(task_emoji ==3){
							final = 2
						}
						if(task_emoji ==2){
							final = 3
						}
						if(task_emoji ==1){
							final = 4
						}
						$('#inlineRadio'+final).prop("checked",true);
						var task_id = $(this).attr("data-taskid");
					})

				$("body").on('click','.btnSaveFeedback',function(){
					$(this).attr('disabled','disabled');

					$.ajax({
						url: '<?php echo URL('save-practice-feedback'); ?>',
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						type: 'POST',
						data: $('.taskFeedbackForm').serialize(),

						success: function (data) { 
							if(data.success){
								$('.alert-danger').hide();
								$('.alert-success').show().html(data.message).fadeOut(8000);
								location.reload();
							} else {
								$('.alert-success').hide();
								$('.alert-danger').show().html(data.message).fadeOut(8000);
							}
						}
					});
				});

				$("body").on('click','.hidden-tr-opner',function(){
					const clickEle = $(this), parentTr = clickEle.parents('tr'), nextElement = parentTr.next();
					$(".content").css("background-color","#ffffff");
					$(this).parents('tr').css("background-color","#fff5f7");
					$(".hidden-tr").css("background-color","#ffffff");
					$(this).parents('tr').next('tr').find(".hidden-tr").toggleClass('border-bottom');
					$(this).parents('tr').next('tr').find(".hidden-tr").css("background-color","#fff5f7");
					$(this).parents('tr').find('td').toggleClass('border-bottom-0');
					//$(".content td").css("border-bottom","1px solid #ddd");
					//$(this).parents('tr').find('td').css("border-bottom","none");

					if(clickEle.hasClass('open')){
						clickEle.toggleClass("open");
						nextElement.find("div.hidden-tr").slideToggle("slow");
						return;
					}

					const topicId = clickEle.data('topicid');
					const taskId = clickEle.data('taskid');

					if(topicId && taskId){
						AjaxCall("{{route('student.task_practise')}}", JSON.stringify({topic_id:topicId, task_id:taskId}), "post", "json", "application/json",true).done(function (response) {
							if (response.IsSuccess) {
								if(response.Data){
									var consoleData = addSinglePractise(response.Data);
									clickEle.toggleClass("open");
									nextElement.find("div.hidden-tr").find('tbody.tbody-inner-data').html(consoleData);
									nextElement.show().find('tr').show();
									nextElement.find("div.hidden-tr").slideToggle("slow");

								}else{
									alert('No Data');
								}
							}else{
								if(response.Message){
									alert(response.Message);    
								}
							}
						});     
					}
				});

				$("body").on('click','.open_practice_preview_modal',function(){
					 // alert('joo');
					 $(".open_practice_preview_modal").removeClass('click-preview-btn');
					 $(this).addClass('click-preview-btn');

					 $(".show-previous, #latestMark, #highestMark, #secondMark").hide();
					 $('#practicePreviewModal').modal('toggle');

					 var teacher_comment     = $(this).data("teacher-comment");
						//alert(teacher_comment);
						var teacher_emoji       = $(this).data("teacher-emoji");
						var original_marksd     = $(this).data("original-marks");
						var marks_gained        = $(this).data("marks-gained");
						var audio               = $(this).data("teacher-audio");

						var topic_id    = $(this).data("topicid");
						var practice_id = $(this).data("practiceid");
						var topicno     = $(this).data("topicno");
						var taskno      = $(this).data("taskno");
						var practiceno  = $(this).data("practiceno");
						var marks       = $(this).data("marks");
						var high        = $(this).data("high");
						var secondHigh  = $(this).data("second-high");

						if(high || secondHigh){
							$(".show-previous").show();
							$(".show-previous-history").removeClass('btn-success').addClass('btn-primary');
							$("#latestMark").addClass('btn-success').removeClass('btn-primary').show();

							if(high){
								$("#highestMark").show();
							}

							if(secondHigh){
								$("#secondMark").show();
							}
						}

						//Show Emoji
						showEmoji(teacher_emoji);

						//Audio
						showAudio(audio);

						//Show Comment
						showComment(teacher_comment);

						$('#practicePreviewModal').find('.m__topic').html('Topic '+ topicno);
						$('#practicePreviewModal').find('.m__task').html('Task '+ taskno);
						$('#practicePreviewModal').find('.m__category').html(practiceno)
						$('#practicePreviewModal').find('.m__marks').html(marks_gained+"/"+original_marksd);
						
						var task_id = $(this).attr("data-taskid");
						var url = topicurl+'/'+topic_id+"/"+task_id+"/"+practice_id; 
						$('.append_practice_preview').html('<iframe frameborder="0" style="overflow: hidden; height: 500px; width: 100%;" src="'+url+'" />')
						$(document).find(".plyr__controls__item").css('pointer-events','');
						$('#myframe').on('load', function() {
							var tabs = $('#myframe').contents().find('#abc-tab .nav-item a.nav-link');
							$(tabs).removeClass("active show");
							var tabcontent = $('#myframe').contents().find('#abc-tabContent .tab-pane');
							$(tabcontent).removeClass("active");
							$(tabs).each(function(i){
								var text = $(this).text().trim();
								if(text.toLowerCase() === practiceno.toLowerCase())
								{
									var activetabid = $(this).attr('href');
									activetabid = activetabid.replace('#','');
									$(tabcontent).each(function(){
										if($(this).attr('id') === activetabid){
											$(this).addClass("active show");
											return false;
										}
									})
									return false;
								}
							})
						});  
					});

				$("body").on('click','.show-previous-history',function(){
					const showData = $(this).data('show');

					if($('.click-preview-btn').length > 0){
						var clickEleBtn = $('.click-preview-btn');
						var showSEmoji = showSAudio = showSTeacherComment = marksGained = '', original_marksd= clickEleBtn.data("original-marks");

						if(showData == 1){
							marksGained = clickEleBtn.data('high-score');
							showSEmoji = clickEleBtn.data('high-teacher-emoji');
							showSAudio = clickEleBtn.data('high-teacher-audio');
							showSTeacherComment = clickEleBtn.data('high-teacher-comment');
						}else if(showData == 2){
							marksGained = clickEleBtn.data('second-score');
							showSEmoji = clickEleBtn.data('second-teacher-emoji');
							showSAudio = clickEleBtn.data('second-teacher-audio');
							showSTeacherComment = clickEleBtn.data('second-teacher-comment');
						}else{
							marksGained = clickEleBtn.data('marks-gained');
							showSEmoji = clickEleBtn.data('teacher-emoji');
							showSAudio = clickEleBtn.data('teacher-audio');
							showSTeacherComment = clickEleBtn.data('teacher-comment');
						}

						$('#practicePreviewModal').find('.m__marks').html(marksGained+"/"+original_marksd);
								//Show Emoji
								showEmoji(showSEmoji);
								//Audio
								showAudio(showSAudio);
								//Show Comment
								showComment(showSTeacherComment);    
							}

							$(this).siblings().removeClass('btn-success').addClass('btn-primary');
							$(this).removeClass('btn-primary').addClass('btn-success');
							var changeURL = '';

							var getURL = $('.append_practice_preview').find('iframe').attr('src');
							var lastSegment = getURL.substring(getURL.lastIndexOf('/') + 1);

							if(showData == 1 || showData == 2){
								if(lastSegment == 1 || lastSegment == 2){
									var changeURL = getURL.slice(0, getURL.lastIndexOf('/'))+ '/'+ showData;
								}else{
									changeURL = getURL + '/'+showData;
								}
							}else{
								if(lastSegment == 1 || lastSegment == 2){
									changeURL = getURL.slice(0, getURL.lastIndexOf('/'));
								}else{
									changeURL = getURL;
								}
							}

							if(changeURL != getURL){
								$('.append_practice_preview').html('');
								$('.append_practice_preview').html('<iframe frameborder="0" style="overflow: hidden; height: 500px; width: 100%;" src="'+changeURL+'" />')
							}
						});
			});
		</script>

		<script>
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
				$(function() {
					$('body').on('mouseup', function() {
						$('.info-details').hide();
					});
				});
			});
		</script>
		<script type="text/javascript">
			// $(document).ready(function() {
			// 	$("#selectTopic").select2();
			// 	$('#selectTopic').on("select2:open", function () {
			// 		$('.select2-results__options').addClass('d-scrollbar');
			// 		$('.select2-results__options').scrollbar();
			// 	});
			// });

			// $(document).ready(function() {
			// 	$("#selectTask").select2();
			// 	$('#selectTask').on("select2:open", function () {
			// 		$('.select2-results__options').addClass('d-scrollbar');
			// 		$('.select2-results__options').scrollbar();
			// 	});
			// });

		</script> 

		<script type="text/javascript">
			// $(document).ready(function() {
			// 	$("#TopicChnage").select2();
			// 	$('#TopicChnage').on("select2:open", function () {
			// 		$('.select2-results__options').addClass('d-scrollbar');
			// 		$('.select2-results__options').scrollbar();
			// 	});
			// });
		</script>

		<script>
			function filterText()
			{  
				var rex = new RegExp($('#TopicChnage').val());

				if(rex =="/all/"){
					clearFilter()
				}
				else{
					$('.content').hide();
					$('.content').filter(function()
					{
						return rex.test($(this).text());
					}).show();
				}
			}

			function clearFilter()
			{
				$('.filterText').val('');
				$('.content').show();
			}
		</script>
		<script>
			$(document).ready(function(){
			  $("#searchbox").on("keyup", function() {
			    var value = $(this).val().toLowerCase();
			    $("#tabaleid tbody tr").filter(function() {
			      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			    });
			    var trSel =  $("#tabaleid tbody tr:not('.no-records'):visible")
			    if(trSel.length == 0){
					$('#image_class').show()
				}
				else{
					console.log('else');
					$('#image_class').hide();
				}
			  });
			});
		</script>
		@endsection