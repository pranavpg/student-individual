@extends('layouts.app')
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
				<div class="dropdown-div mt-3">
					<div class="class-dropdown mb-2">
						<span class="sidefilter-heading d-block">Select Course</span>
						<select class="custom-select2-dropdown-nosearch course_dropdown" id="course_dropdown" style="min-width: 300px;">
							<option value="">select course</option>
							@foreach($array_data as $data)
							<option value="{{$data['course_name']}}">{{$data['course_name']}}</option>
							@endforeach
						</select>
					</div>
				</div>
			

				<!-- <div class="dropdown-div mt-3">
					<div class="class-dropdown mb-2">
						<span class="sidefilter-heading d-block">Select Level</span>
						<select class="custom-select2-dropdown-nosearch" id="level_dropdown"style="min-width: 300px;">
							<option value="">select level</option>
							@foreach($array_data as $data)
							<option value="{{$data['leval-name']}}">{{$data['leval-name']}}</option>
							@endforeach
						</select>
					</div>
				</div> -->
				
			</div>
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 partC">
				<a href="javascript:void(0);" class="opneAddModel btn btn-classic d-none d-md-block text-left"><i class="fa fa-plus" aria-hidden="true"></i> Teacher Feedback</a>
				<a href="javascript:void(0);" class="opneAddModel-ieukmob btn btn-classic d-md-none"><i class="fa fa-plus" aria-hidden="true"></i> Teacher Feedback</a>
			</div>
			@if($instration)
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
							<span><a href="#" id="openmodal_forvideo" data-id="{{$ins_video['video_url']}}"><i class="fa fa-file-alt"></i> Click to watch</a> <span>{{$ins_video['video_name']}}</span></span>
						</div>
						@endforeach
					</div>
				</div>
				@endif
			@endif
		</div>
	</div>
</aside>
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
<main class="dashboard">
	<div class="container-fluid">
		<div class="row">
			@include('common.sidebar')
			<!-- /. Sidebar-->
			<section class="main col-sm-12">
				@include('profile.menu')
				<div class="p-3">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<div class="row justify-content-center">
							<div class="col-12 col-sm-6 col-md-6 col-lg-8 col-xl-8">
							</div>
							<div class="col-8 col-sm-5 col-md-6 col-lg-4 col-xl-4">
								<div class="row">
									<div class="col-sm-12 col-md-9 col-lg-9 col-xl-10 common-search">
										<div class="search-form">
											<div class="form-group mb-0">
												<input type="search search_box" class="form-control form-control-lg search_work_record newsearch" placeholder="Search" id="" aria-label="Search">
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
				</div>
				<div class="main__content main__content_full ieuk-fdbk px-3">
					<?php 
					$feedbacks = array_reverse($feedbacks);
					$sessionAll = Session::all();
					// dump($feedbacks);
					// dd($sessionAll);

					?>
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-home" role="tabpanel"
						aria-labelledby="pills-home-tab">

						<table id="example" class="table ilp-table ieukfbk-tbl ieuktable-sline" >
							<thead class="thead-dark">
								<tr>
									<th scope="col" width="24%">Feedback Type</th>
									<th scope="col" width="20%">Course</th>
									<th scope="col" width="40%">Level</th>
									<th scope="col" width="16%">Action</th>
								</tr>
							</thead>
							<tbody>

								@foreach($feedbacks as $key=>$feedback)
								<fieldset id = "{{$feedback['_id']}}">
								</fieldset>
								<tr>
									<td scope="row">
										<span title="Feedback Type"></span>
										<?php 
										echo $feedback['new_student_feedback']['title'] ?? '';
										$feedback['type'] = $feedback['new_student_feedback']['type'] ?? '';
													// $feedback['type'] = 'teacher_evaluation_by_student';
													// if($feedback['type']=="teacher_evaluation_by_student" || $feedback['type']=="teacehr_evaluation_by_student"){
													// 	echo  "Teacher Feedback";
													// }elseif($feedback['type']=="end") {
													// 	echo  "End Course Feedback";
													// }elseif($feedback['type']=="init") {
													// 	echo  "Initial Course Feedback";
													// }elseif($feedback['type']=="mid") {
													// 	echo  "Mid Course Feedback";
													// }elseif($feedback['type']=="mid") {
													// 	echo  "Mid Course Feedback";
													// }elseif($feedback['type']=="facilities_feedback") {

													// 	$mesgg = "";
													// 	if($sessionAll['topics'][$feedback['topic_id']]['sorting'] == 4 ){
													// 		$mesgg = "Initial";
													// 	}elseif($sessionAll['topics'][$feedback['topic_id']]['sorting'] == 14){
													// 		$mesgg = "Mid";
													// 	}elseif($sessionAll['topics'][$feedback['topic_id']]['sorting'] == 29){
													// 		$mesgg = "End";
													// 	}

													// 	echo  $mesgg." Facilities Feedback";
													// }
													/*if(!empty($feedback['teacher_id'])){
														echo "Teacher feedback ";
													}*/
													?>
												</td>
												<td title="Course:" ><span title="Course"></span>
													<?php 
													// if(!empty($feedback['course_id'])){
													// 	// dd($sessionAll);

													// 	// echo $sessionAll['courses'][$feedback['course_id']]['title'];
													// 	echo collect($sessionAll['course_title'])->where('course_id',$feedback['course_id'])->first()['course']['coursetitle'] ?? '';
													// }else{
													// 	echo "-";
													// }
													echo $feedback['course']['coursetitle'] ?? '-';
													?>
												</td>
												<td title="Level:"><span title="Level"></span>
													<?php 
													// if($feedback['type']!="teacher_evaluation_by_student" || $feedback['type']=="teacehr_evaluation_by_student"){
													// 	if(!empty($feedback['level_id'])){
													// 		echo $sessionAll['levels'][$feedback['level_id']]['title'];
													// 	}else{
													// 		echo "-";
													// 	}
													// }else{

													// 	echo "-";
													// }

													echo $feedback['level']['leveltitle'] ?? '-';
													?>
												</td>
												<?php $ques_id = $feedback['_id']; ?>
												
												<td>
													<?php $ques_id= $feedback['_id'];
													$modalName = "";
													if($feedback['type']=="teacher_evaluation_by_student" || $feedback['type']=="teacehr_evaluation_by_student"){
														$modalName = "view-teacher-feedback";
														$modalName_mobile = "teacher-feedback-view";
													}else{
														$modalName = "view-teacher-feedback-student";
														$modalName_mobile = "view-teacher-feedback-student-view";
													}
													?>	
													<a href="" class = "allfeedbackQuestion" data-model = "{{isset($feedback['teacher_id']) && !empty($feedback['teacher_id']) ? 'teacher' : 'course'}}"   data-id="{{ $feedback['_id'] }}" data-toggle="modal" > 

														<img src="{{ asset('public/images/icon-small-eye.png') }}" alt="" class="img-fluid" width="26px">
													</a>
													<a href="" class="allfeedbackQuestion_mob" data-target="#{{$modalName_mobile}}" data-model = "{{isset($feedback['teacher_id']) && !empty($feedback['teacher_id']) ? 'teacher' : 'course'}}" data-key="{{$key}}" data-id="{{$feedback['_id']}}" data-teacher="{{ $feedback['teacher_id'] ?? '' }}" data-toggle="modal" > 

														<img src="{{ asset('public/images/icon-small-eye.png') }}" alt="" class="img-fluid" width="26px">
													</a>

												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
							<div class=" w-100 norecorddata">
			                    <div class="main__content" id="image_class" style="display: block;">
			                        <div class="row text-center">
			                            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
			                                <img src="{{ asset('public/images/no_record_found.gif') }}" width="100%">
			                                <p style="font-weight: 600;font-size: 20px;margin-left: 25px;">No Records Found</p>
			                            </div>
			                        </div>
			                    </div>
			                </div>

						</div>
					</section>
				</div>
			</div>
		</main>
		<!---Modal:Begin-->
		<div class="modal fade" id="view-feedback-modal" tabindex="-1" role="dialog" aria-labelledby="feedback-form-modalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl">
				<div class="modal-content" id="view-feedback-div">
				</div>
			</div>
		</div>
		<!--Modal:End-->
		<form id="add_feedback_form" name="add_feedback_form" class="add_feedback_form" method="post">
			<input type="hidden" name="type" value="course_evo">
			<input type="hidden" name="feedback_id" value="{{ $teacherSummaryFeedback['result']['_id'] ?? '' }}">
			<div class="modal fade" id="teacher-feedback-summary" tabindex="-1" role="dialog" aria-labelledby="teacher-feedback-summary-modalLabel" aria-hidden="true">
				<div class="modal-dialog modal-xl">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="teacher-feedback-summary-modalLabel">
								{{ $teacherSummaryFeedback['result']['title'] ?? ''}}
							</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
        		<div class="modal-body">
        			<div class="modal-selectors mb-4 w-100">
								<div class="row">
									<div class="col-3 form-group">
										<select class="form-control sw_1" name="teacher_id" id="teacher_id">
											<option value="">Select Teacher</option>
											@foreach($teachers as $item)
											<option value="{{$item['_id']}}">@if($item['teacher_name']) {{ $item['teacher_name'] }} @else {{ $item['first_name'] ?? '' }} {{ $item['last_name'] ?? ''}} @endif</option>
											@endforeach
										</select>
										<input type="hidden" name= "teacher_name" id="teachername" >
									</div>
								</div>
							</div>
							<div class="modal-table modal-table-border mb-4 d-flex flex-wrap">
							<div class="table-responsive">
								<table class="table mb-0">
									<thead>
										<tr>
											@foreach($teacherSummaryFeedback['result']['heading']['question'] as $heading)
											@if($loop->first)
											<th scope="col" class="align-middle bt-none">{{ $heading }} </th>
											@else
											<th scope="col" class="text-center border-left bt-none align-middle">{{ $heading }}</th>
											@endif
											@endforeach
											<th scope="col" class="text-center border-left bt-none align-middle">If you select rarely
											write why</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$temp = 0;
                            	//foreach ($course_init_mid as $key => $value) { ?>
                            		@foreach($teacherSummaryFeedback['result']['question']['question'] as $key => $question)
                            		<tr>
                            			<input type="hidden" name="user_answer[{{$key}}][question]" value="{{$question}}">
                            			<th scope="row">{{$question}}</th>
                            			@foreach($teacherSummaryFeedback['result']['heading']['question'] as $valueKey => $heading)
                            			@if($loop->first)
                            			@else
                            			<td class="text-center border-left align-middle">
                            				<div class="custom-control custom-radio">
                            					<input type="radio" class="custom-control-input" id="customControlValidationInitMid{{$temp}}" name="user_answer[{{$key}}][selection]" value="{{$valueKey}}">
                            					<label class="custom-control-label" for="customControlValidationInitMid{{$temp}}"></label>
                            				</div>
                            			</td>
                            			<?php $temp++;?>

                            			@endif
                            			@endforeach
                            			<td class="w-20 border-left align-middle">
                            				<div style="max-width: 187px;">
                            					<textarea name="user_answer[{{$key}}][extra_text]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext0" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
                            				</div>
                            			</td>
                            		</tr>
                            		@endforeach
                            		<?php //} ?>
                            	</tbody>
              	</table>
            	</div>
          	</div>
        			@foreach($teacherSummaryFeedback['result']['other_question']['question'] as $key => $other_question)
        			<h6>{{$other_question}}</h6>

        			<input type="hidden" name="other_question[{{$key}}][question]"  value="{{  $other_question }}">

        			<div class="form-group form-group_underline">
        				<input type="text"  name="other_question[{{$key}}][ans]" class="form-control form-control-sm form-control_underline" role="textbox"  placeholder="Your Answer...." value="">
        			</div>
        			@endforeach
        		</div>
        		<div class="modal-footer justify-content-center">
        			<div class="success_alert text-center alert alert-success" style="display:none;">
								<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
									<i class="fa-regular fa-circle-check"></i>
									<span>All answers successfully submitted.</span>
								</div>
							</div>
							<div class="error_alert text-center alert alert-danger" style="display:none;">
								<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
									<i class="fa fa-circle-exclamation"></i>
									<span></span>
								</div>
							</div>
        			<button type="button" class="btn btn-primary" id="feedback_add_btn">Save</button>
        			<button type="button" class="btn btn-cancel" data-dismiss="modal">Skip</button>
        		</div>
        	</div>
      	</div>
      </div>
    </form>

    <form id="add_feedback_form1" name="add_feedback_form1" class="add_feedback_form1" method="post">
              	<div class="modal fade" id="teacher-feedback" tabindex="-1" role="dialog" aria-labelledby="teacher-feedback-modalLabel" aria-hidden="true">
              		<div class="modal-dialog modal-xl">
              			<div class="modal-content">
              				<div class="modal-header bb-none flex-wrap">
              					<div class="modal-header-top d-flex flex-wrap justify-content-center align-items-center w-100 mb-4">
              						<h4 class="modal-title" id="teacher-feedback-modalLabel">
              							Teacher Feedback
              						</h4>
              						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              							<img src="{{ asset('public/images/icon-close-modal.svg') }}" alt="close" class="img-fluid">
              						</button>
              					</div>
              					<!-- /. Modal Header top-->
              					<div class="modal-selectors mb-4 w-100">
              						<div class="row">
              							<div class="col-3 form-group">
              								<select class="form-control form-control-lg" name="teacher_id" id = "teacher_id">
              									<option value="Select Teacher">Select Teacher</option>
              									@foreach($teachers as $item)
              									<option value="{{$item['_id']}}">{{$item['teacher_name']}}</option>
              									@endforeach
              								</select>
              								<input type="hidden" name= "teacher_name" id="teachername" >
              							</div>
              						</div>
              					</div>
              					<!-- /. Modal Selector-->
              					<!-- </div> -->
              					<div>
              					</div>
              					<div class="modal-table modal-table-border mb-4 d-flex flex-wrap">
              						<table class="table mb-0">
              							<thead>
              								<tr>

              									<th scope="col" class="text-center w-20 border-left bt-none align-middle">If you select rarely
              									write why</th>
              								</tr>
              							</thead>
              							<tbody>

              								@foreach($feedbackQuestionList as $key=>$data)
              								<tr>
              									<th scope="row" class="align-middle">{{$data}}
              										<input type="hidden" name="user_answer_view[{{$key}}][question]" value="{{$data}}">
              									</th>
              									<td class="text-center border-left align-middle">
              										<div class="custom-control custom-radio">
              											<input type="radio" class="custom-control-input" id="customControlValidation2{{$key}}"
              											name="user_answer_view[{{$key}}][selection]" value="1">
              											<label class="custom-control-label" for="customControlValidation2{{$key}}"></label>
              										</div>
              									</td>
              									<td class="text-center border-left align-middle">
              										<div class="custom-control custom-radio">
              											<input type="radio" class="custom-control-input" id="customControlValidation3{{$key}}"
              											name="user_answer_view[{{$key}}][selection]" value="2">
              											<label class="custom-control-label" for="customControlValidation3{{$key}}"></label>
              										</div>
              									</td>
              									<td class="text-center border-left align-middle">
              										<div class="custom-control custom-radio">
              											<input type="radio" class="custom-control-input" id="customControlValidation4{{$key}}"
              											name="user_answer_view[{{$key}}][selection]" value="3">
              											<label class="custom-control-label" for="customControlValidation4{{$key}}"></label>
              										</div>
              									</td>
              									<td class="text-center border-left align-middle">
              										<div class="custom-control custom-radio">
              											<input type="radio" class="custom-control-input" id="customControlValidation5{{$key}}"
              											name="user_answer_view[{{$key}}][selection]" value="4">
              											<label class="custom-control-label" for="customControlValidation5{{$key}}"></label>
              										</div>
              									</td>
              									<td class="text-center border-left align-middle">
              										<div class="custom-control custom-radio">
              											<input type="radio" class="custom-control-input" id="customControlValidation6{{$key}}"
              											name="user_answer_view[{{$key}}][selection]" value="5">
              											<label class="custom-control-label" for="customControlValidation6{{$key}}"></label>
              										</div>
              									</td>
              									<td class="w-20 border-left align-middle">
              										<div style="max-width: 187px;">
              											<span class="textarea form-control form-control-sm form-control_underline" id = "rarelytext{{$key}}" role="textbox"
              											contenteditable placeholder="Write Here...."></span>
              											<input type="hidden" name="user_answer_view[{{$key}}][extra_text]" value="">
              										</div>
              									</td>
              								</tr>
              								@endforeach
              							</tbody>
              						</table>
              					</div>
              					@foreach($otherQuestion as $key=>$data)
              					<div class="modal-body modal-table-border">

              						<h6>{{$data}}<input type="hidden" name="other_question[{{$key}}][question]" value="{{$data}}"></h6>

              						<div class="form-group form-group_underline">
              							<span class="textarea form-control form-control-sm form-control_underline" id = "comments" role="textbox" contenteditable
              							placeholder="Your Answer...."></span>
              							<input type="hidden" name="other_question[{{$key}}][ans]" value="">
              						</div>

              					</div>
              					@endforeach
              					<div class="modal-footer justify-content-center">
              						<button type="button" class="btn btn-primary" id="feedback_add_btn">Save</button>
              						<button type="button" class="btn btn-primary" data-dismiss="modal">Skip</button>
              					</div>
              				</div>
              			</div>
              		</div>
              	</div>
              </form>
              <form id="add_feedback_form-mob" name="add_feedback_form-mob" class="add_feedback_form-mob" method="post">
              	<input type="hidden" name="type" value="course_evo">
              	<input type="hidden" name="feedback_id" value="{{ $teacherSummaryFeedback['result']['_id'] ?? '' }}">
              	<div class="modal fade" id="teacher-feedback-mobieuk" tabindex="-1" role="dialog" aria-labelledby="teacher-feedback-mobieuk-modalLabel" aria-hidden="true">
              	<div class="modal-dialog modal-xl">
              		<div class="modal-content">
              			<div class="modal-header">
											<h4 class="modal-title" id="teacher-feedback-mobieuk-modalLabel">
												{{ $teacherSummaryFeedback['result']['title'] ?? ''}}
											</h4>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
              			</div>
              			<div class="modal-body">
											<div class="modal-selectors w-100">
												<div class="row">
													<div class="col-12 ieuktimeselc-cls w-100 text-center mb-2">
														<select class="ieukselect" name="teacher_id" id="mob_teacher_id">
															<option value="">Select Teacher</option>
															@foreach($teachers as $item)
															<option value="{{$item['_id']}}">{{$item['teacher_name']}}</option>
															@endforeach
														</select>
														<input type="hidden" name= "teacher_name" id="teachername" >
													</div>
												</div>
											</div>
              				<div class="ieukinmh">
              					<h5 class="ieuk-fptitle">Rating</h5> 
              					<span class="ieuk-msr-count align-self-end">1/{{ count($teacherSummaryFeedback['result']['question']['question'] ?? []) }}</span>
              				</div>
              				<div>
              					@foreach($teacherSummaryFeedback['result']['question']['question'] as $key => $question)
              					<input type="hidden" name="user_answer[{{$key}}][question]" value="{{$question}}">
              					<div class="parent_{{$key}}" @if(!$loop->first) style="display:none;" @endif >
              						<p>{{$question}}</p>
              						@foreach($teacherSummaryFeedback['result']['heading']['question'] as $valueKey => $heading)
              						@if($loop->first)
              						@else
              						<div class="ieuk-fpr">
              							<label>
              								<input type="radio"  id="customControlValidation{{$key}}" name="user_answer[{{$key}}][selection]" value="{{$valueKey}}" />
              								<span>{{ $heading }}</span>
              							</label>
              						</div>
              						@endif
              						@endforeach
              						<div class="ieukf-tarea">
              							If you select rarely write why:
              							<textarea name="user_answer[{{$key}}][extra_text]" placeholder="write here..."></textarea>
              						</div>
              					</div>
              					@endforeach
              					<div class="row">
              						<div class="col-12 d-flex justify-content-between mb-2">					
              							<button type="button" class="btn btn-primary pre_view">Back</button>
              							<button type="button" class="btn btn-primary next_view" data-number="{{count($teacherSummaryFeedback['result']['question']['question'] ?? []) }}" data-current="0" >Next</button>
              						</div>
              					</div>
              					<div class="">
              						<div class="ieukf-tarea">
              							@foreach($teacherSummaryFeedback['result']['other_question']['question'] as $key => $other_question)
              							<input type="hidden" name="other_question[{{$key}}][question]"  value="{{  $other_question }}">
              							<h6>{{$other_question}}
              								<input type="text" class="textarea form-control form-control-sm form-control_underline" id="comments" role="textbox" contenteditable="" placeholder="Your Answer...." onpaste="return false;" name="other_question[{{$key}}][ans]" value="" >
              							</h6>
              							@endforeach
              						</div>
              					</div>
              				</div>
										</div>
										
										<div class="modal-footer justify-content-center">
											<div class="success_alert text-center alert alert-success" style="display:none;">
												<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
													<i class="fa-regular fa-circle-check"></i>
													<span>All answers successfully submitted.</span>
												</div>
											</div>
											<div class="error_alert text-center alert alert-danger alert-danger-mobile" id="alert-danger-mobile" style="display:none;">
												<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
													<i class="fa fa-circle-exclamation"></i>
													<span></span>
												</div>
											</div>
											<div class="row">
												<div class="col-12 text-center">
													<button type="button" class="btn btn-primary feedback_add_btn_mobile" id="feedback_add_btn_mobile">Save</button>
												</div>
											</div>
										</div>
              		</div>
              	</div>
              </form>
              <div class="modal fade" id="view-teacher-feedback" tabindex="-1" role="dialog" aria-labelledby="teacher-feedback-modalLabel" aria-hidden="true">
              	<div class="modal-dialog modal-xl">
              		<div class="modal-content">
              			<div class="modal-header bb-none flex-wrap">
              				<div class="modal-header-top d-flex flex-wrap justify-content-center align-items-center w-100 mb-4">
              					<h4 class="modal-title" id="teacher-feedback-modalLabel">
              						Teacher Feedback
              					</h4>
              					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              						<img src="{{ asset('public/images/icon-close-modal.svg') }}" alt="close" class="img-fluid">
              					</button>
              				</div>
              				<div class="btn btn-primary c_1"> 
              					<span id = "teacher_info"></span>
              				</div>
              			</div>
              			<div class="modal-table modal-table-border mb-4 d-flex flex-wrap">
              				<table class="table mb-0">
              					<thead>
              						<tr class="main_heading"></tr>
              					</thead>
              					<tbody class="teacher_feedback">										
              					</tbody>
              				</table>
              			</div>	
              			<div class="modal-body modal-table-border other_question"></div>
              		</div>
              	</div>
              </div>
              <div class="modal fade" id="teacher-feedback-view" tabindex="-1" role="dialog"
              aria-labelledby="teacher-feedback-mobieuk-modalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl">
              	<div class="modal-content">
              		<div class="modal-header bb-none flex-wrap">
              			<div class="modal-header-top d-flex flex-wrap justify-content-center align-items-center w-100 mb-2">
              				<h4 class="modal-title" id="teacher-feedback-mobieuk-modalLabel">
              					Teacher Feedback Summary
              				</h4>

              				<div class="btn btn-primary c_1">
              					<span id = "teacher_info_mobile" class="teacher_info_mobile"></span>
              				</div>
              				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              					<img src="{{ asset('public/images/icon-close-modal.svg') }}" alt="close" class="img-fluid">
              				</button>
              			</div>
              		</div>
              		<dm iv class="modal-body modal-table-border">
              			<div class="ieukinmh"><h5 class="ieuk-fptitle">Rating</h5> <span class="ieuk-msr-count align-self-end number">1/28</span></div>
              			<div class="appendreadio"></div>
              			<div class="row">
              				<div class="col-12 d-flex justify-content-between mb-2">					
              					<button type="button" class="btn btn-primary pre_view">Back</button>
              					<button type="button" class="btn btn-primary next_view" data-number="28" data-current="0">Next</button>
              				</div>
              			</div>

              			<div class="mobile_ather_que"></div>


              			<!-- <div class="row"><div class="col-12 text-center"><button type="button" class="btn btn-primary feedback_add_btn_mobile">Save</button></div></div>					 -->
              		</div>
              		<div class="alert alert-success" role="alert" style="display: none;">All answers successfully submitted.</div>
              		<div class="alert alert-danger alert-danger-mobile" role="alert" style="display:none"></div>
              		<div class="modal-footer bt-none">

              		</div>
              	</div>
              </div>
            </div>
            <div class="modal fade" id="view-teacher-feedback-student" tabindex="-1" role="dialog" aria-labelledby="teacher-feedback-modalLabel" aria-hidden="true">
            	<div class="modal-dialog modal-xl">
            		<div class="modal-content">
            			<div class="modal-header bb-none flex-wrap">
            				<div class="modal-header-top d-flex flex-wrap justify-content-center align-items-center w-100 mb-4">
            					<h4 class="modal-title" id="teacher-feedback-modalLabel">
            					{{$teacherSummaryFeedback['result']['title'] ?? '' }}</p>
            				</h4>
            				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
            					<img src="{{ asset('public/images/icon-close-modal.svg') }}" alt="close" class="img-fluid">
            				</button>
            			</div>
            			<p style="margin-left: 185px;margin-left: 185px;" class="hidemsg">{{$teacherSummaryFeedback['result']['legend'] ?? '' }}</p>
            		</div>
            		<div class="modal-table modal-table-border mb-4 d-flex flex-wrap">
            			<table class="table mb-0">
            				<thead>
            					<tr class="main_heading"></tr>
            				</thead>
            				<tbody class="teacher_feedback">										
            				</tbody>
            			</table>
            		</div>	
            		<div class="modal-body modal-table-border other_question"></div>
            	</div>
            </div>
          </div>
          <div class="modal fade" id="view-teacher-feedback-student-view" tabindex="-1" role="dialog" aria-labelledby="teacher-feedback-modalLabel" aria-hidden="true">
          	<div class="modal-dialog modal-xl">
          		<div class="modal-content">
          			<div class="modal-header">
						<h4 class="modal-title" id="teacher-feedback-modalLabel-mobile">
							{{ $teacherSummaryFeedback['result']['title']  ?? ''}}
						</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
          			</div>
					<!-- <div class="modal-table modal-table-border mb-4 d-flex flex-wrap">
						<table class="table mb-0">
							<thead>
								<tr class="main_heading"></tr>
							</thead>
							<tbody class="teacher_feedback">										
							</tbody>
						</table>
					</div> -->	
			<div class="modal-body">
				<div class="row">
					<div class="col-12 text-center">
						<div class="btn btn-primary">
							<span id = "teacher_info_mobile" class="teacher_info_mobile"></span>
						</div>
						<p class="hidemsg">{{ $teacherSummaryFeedback['result']['legend']  ?? ''}}</p>
					</div>
				</div>
				<div class="ieukinmh"><h5 class="ieuk-fptitle">Rating</h5> <span class="ieuk-msr-count align-self-end number">1/28</span></div>
				<div class="appendreadio"></div>
				<div class="row">
					<div class="col-12 d-flex justify-content-between mb-2">					
						<button type="button" class="btn btn-primary pre_view">Back</button>
						<button type="button" class="btn btn-primary next_view" data-number="28" data-current="0">Next</button>
					</div>
				</div>
				<div class="mobile_ather_que"></div>
			</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn  btn-cancel" data-dismiss="modal">Close</button>
			</div>
			<!-- <div class="modal-body modal-table-border other_question"></div> -->
		</div>
	</div>
</div>


<?php

$feedback = [];
$teacherFeedback =[];
$type =[];
	// dd($feedbacks);
foreach($feedbacks as $key=>$data){
	$feedback[$key]			=json_decode($data['feedback']);
		// $teacherFeedback[$key] 	= $data['teacher_id'];
	$type[$key] 			= $data['type'] ?? '';
}
	// dd($type);
	/*foreach($feedbacks as $key=>$data){
		$teacherFeedback[$key] = $data['teacher_id'];
	}*/
	?>

	<script>
		
		$(document).ready(function() {

			window.inc = 0;
			window.lengthque = 0;
			$('.next').click(function(){
				if(window.inc==27){
					return false;
				}
				$('.parent_'+window.inc).fadeOut()
				window.inc++;
				$('.parent_'+window.inc).fadeIn()
				var newData = window.inc+1;
				$('.align-self-end').html(newData+"/28")
			});
			$('.pre').click(function(){
				if(window.inc<1){
					return false;
				}
				$('.parent_'+window.inc).fadeOut() 
				$('.align-self-end').html(window.inc+"/28")
				window.inc--;
				$('.parent_'+window.inc).fadeIn()
			});

			$('.next_view').click(function(){
				console.log( $(this).closest('.modal-body').find('.align-self-end:first'));
				let lastIndex = $(this).attr('data-number');
				let current = $(this).attr('data-current');
				console.log(current);
				console.log(lastIndex);
				if(typeof lastIndex !== "undefined"){
					console.log('in');
					window.lengthque = lastIndex;
				}
			// if(window.inc==window.lengthque-1){
			// 	return false;
			// }			
			if(current==lastIndex-1){
				return false;
			}

			$(this).closest('.modal-body').find('.parent_'+current).fadeOut()
			current++;
			$(this).closest('.modal-body').find('.parent_'+current).fadeIn()
			let newData = current+1;
			$(this).closest('.modal-body').find('.align-self-end:first').html(newData+"/"+lastIndex);
			$(this).attr('data-current',current);
		});

			$('.pre_view').click(function(){
				let lastIndex = $(this).closest('div').find('.next_view:first').attr('data-number');
				let current = $(this).closest('div').find('.next_view:first').attr('data-current');
			// if(window.inc<1){
			// 	return false;
			// }	
			if(current<1){
				return false;
			}
			console.log(current);
			$(this).closest('.modal-body').find('.parent_'+current).fadeOut()
			$(this).closest('.modal-body').find('.align-self-end').html(current+"/"+lastIndex)
			current--;
			$(this).closest('.modal-body').find('.parent_'+current).fadeIn();
			$(this).closest('div').find('.next_view:first').attr('data-current',current);
		});


			$('.opneAddModel').click(function(e){
				$('#teacher-feedback-summary').modal("show");
				$('.add_feedback_form')[0].reset();
				e.preventDefault();
			});
		// ===== 04-09-21 jQuery =====
		$('.opneAddModel-ieukmob').click(function(e){
			$('#teacher-feedback-mobieuk').modal("show");
			e.preventDefault();
		});
		// ===== 04-09-21 jQuery =====
	});


	// var mainFeedbackArray 	= '<?php //echo json_encode($teacherFeedback) ?>';

	var type 				= '<?php echo addslashes(json_encode($type))  ?>';
	var mainFeed 			= '<?php echo addslashes(json_encode($feedback)) ?>';

	$(".allfeedbackQuestion").click(function(){
		$('#view-feedback-div').html('');
		let feedbackId = $(this).data('id');
		$.ajax({
			url:"{{ route('feedback.view') }}",
			method:'POST',
			data:{_token:"{{csrf_token() }}",feedback_id:feedbackId},
			success:function(response){
				$('#view-feedback-div').html(response.html);
				$('#view-feedback-modal').modal('show');
			}
		});
			// console.log(parsedArray)

		})
	$(".allfeedbackQuestion_mob").click(function(){
		var data = JSON.parse(mainFeed);
		var key = $(this).attr("data-key");
			// var key = $(this).attr("data-id");
			var model = $(this).attr("data-model")
			var otherQuestion = data[key]['other_question'];
			$('.appendreadio').html("")
			type_of_popup = JSON.parse(type);
			var feedbackQuestion 	= data[key]['user_answer'];
			var type_of_popup_data	= type_of_popup[key];
			var teacherName 		= data[key]['teacher_name'];
			let teachers = <?php echo json_encode($teachers); ?>;
			let teacher_id = $(this).attr('data-teacher');
			let selectedTeacher = teachers.find( teacher => teacher._id == teacher_id);
			if(selectedTeacher){
				$(".teacher_info_mobile").html(selectedTeacher.first_name +' '+ selectedTeacher.last_name);
				if(selectedTeacher.teacher_name != ''){
					$(".teacher_info_mobile").html(selectedTeacher.teacher_name);
				}
			}
			let courseFeedbackHeading   = '<?php echo addslashes(json_encode($teacherSummaryFeedback['result']['heading']['question'] ?? [])) ?>';
			let headingData = JSON.parse(courseFeedbackHeading);
			var i=0;
			window.inc =0;

			var lableArray = new Array();
			if(model == 'course'){
				$('#view-feedback-div').html('');
				let feedbackId = $(this).data('id');
				$.ajax({
					url:"{{ route('feedback.view') }}",
					method:'POST',
					data:{_token:"{{csrf_token() }}",feedback_id:feedbackId},
					success:function(response){
						$('#view-feedback-div').html(response.html);
						$('#view-feedback-modal').modal('show');
					}
				});
				return false;

			}
			$('#view-teacher-feedback-student-view').find('.next_view:first').attr('data-current',0);
			if(model == "teacher"){
				//alert('hjdhjg');
					/*$lableArray
					$('.main_heading').append('<th scope="col" class="align-middle bt-none">Rating</th><th scope="col" class="text-center border-left bt-none align-middle">Rarely</th><th scope="col" class="text-center border-left bt-none align-middle">Once in a while</th><th scope="col" class="text-center border-left bt-none align-middle">Sometimes</th><th scope="col" class="text-center border-left bt-none align-middle">Most of the times</th><th scope="col" class="text-center border-left bt-none align-middle">Almost always</th><th scope="col" class="text-center w-20 border-left bt-none align-middle">If you select rarely write why</th>')*/

					// lableArray=['Rarely','Once in a while','Sometimes','Most of the times','Almost always'];
					lableArray=headingData;
				}
				if(type_of_popup_data == "teacher_evaluation_by_student" || type_of_popup_data == "teacehr_evaluation_by_student"){
					if(model == "course"){
						/*		$('.main_heading').append('<th scope="col" class="align-middle bt-none">Question</th><th scope="col" class="text-center border-left bt-none align-middle">Excellent</th><th scope="col" class="text-center border-left bt-none align-middle">Good</th><th scope="col" class="text-center border-left bt-none align-middle">Average</th><th scope="col" class="text-center border-left bt-none align-middle">Poor</th>')*/
						lableArray=['Question','Excellent','Good','Average','Poor'];
					}
				}	
				if(type_of_popup_data == "init" || type_of_popup_data == "mid" || type_of_popup_data == "end" ){
				// $('.main_heading').append('<th scope="col" class="align-middle bt-none">Please tick a box (&#10003;)  to answer each question:</th><th scope="col" class="align-middle">1</th><th scope="col" class="text-center border-left bt-none align-middle">2</th><th scope="col" class="text-center border-left bt-none align-middle">3</th><th scope="col" class="text-center border-left bt-none align-middle">4</th><th scope="col" class="text-center border-left bt-none align-middle">N/A</th>')
				lableArray=['1','2','3','4','N/A'];
			}

			if(type_of_popup_data == "facilities_feedback"){
				$('.main_heading').append('<th scope="col" class="align-middle bt-none">Question</th><th scope="col" class="text-center border-left bt-none align-middle">Excellent</th><th scope="col" class="text-center border-left bt-none align-middle">Good</th><th scope="col" class="text-center border-left bt-none align-middle">Average</th><th scope="col" class="text-center border-left bt-none align-middle">Poor</th>')
				lableArray=['Question','Excellent','Good','Average','Poor'];
			}

			$('.number').html('1/'+feedbackQuestion.length)
			$('#view-teacher-feedback-student-view').find('.next_view:first').attr('data-number',feedbackQuestion.length);
			
			window.lengthque = feedbackQuestion.length;
			feedbackQuestion.forEach(function(feedbackQuestion,key) {
				if(i==0){
					var textdata = '<div class="parent_'+i+'" >';
				}else{
					var textdata = '<div class="parent_'+i+'" style="display:none;">';
				}
				textdata += '<p>'+feedbackQuestion.question+'</p>';
				headingData.forEach(function(heading,index){
					if(index != 0){
						textdata +='<div class="ieuk-fpr">\
						<label>\
						'+(feedbackQuestion.selection == index ? '<input type="radio"  id="customControlValidation20" name="user_answer_mobile['+index+'][selection]" value="'+index+'" checked/>':'<input type="radio"  id="customControlValidation20" name="user_answer_mobile['+index+'][selection]" value="'+index+'" />')+'\
						<span>'+heading+'</span>\
						</label>';
						textdata+='</div>';

					}
				});
				textdata+='<div class="ieukf-tarea">If you select rarely write why:<textarea name="user_answer['+key+'][extra_text]" placeholder="write here...">'+feedbackQuestion.extra_text+'</textarea></div>';
				$('.appendreadio').append(textdata)
				i++;
			});			

			var k = 0;
			$('.mobile_ather_que').html("")
			otherQuestion.forEach(function(otherQuestion) {
				$('.mobile_ather_que').append(`<div class="ieukf-tarea">
					<h6>`+otherQuestion.question+`
					<input type="text" class="textarea form-control form-control-sm form-control_underline" id="comments" role="textbox" contenteditable="" placeholder="Your Answer...." onpaste="return false;" name="other_question_mobile[0][ans]" value="`+otherQuestion.ans+`" >
					</h6>
					</div>`);
				k++;
			});

			$('.main_heading').html("")
			if(model == "teacher"){
				$('.main_heading').append('<th scope="col" class="align-middle bt-none">Rating</th><th scope="col" class="text-center border-left bt-none align-middle">Rarely</th><th scope="col" class="text-center border-left bt-none align-middle">Once in a while</th><th scope="col" class="text-center border-left bt-none align-middle">Sometimes</th><th scope="col" class="text-center border-left bt-none align-middle">Most of the times</th><th scope="col" class="text-center border-left bt-none align-middle">Almost always</th><th scope="col" class="text-center w-20 border-left bt-none align-middle">If you select rarely write why</th>')
			}	

			if(type_of_popup_data == "teacher_evaluation_by_student" || type_of_popup_data == "teacehr_evaluation_by_student"){
				if(model == "course"){
					$('.main_heading').append('<th scope="col" class="align-middle bt-none">Question</th><th scope="col" class="text-center border-left bt-none align-middle">Excellent</th><th scope="col" class="text-center border-left bt-none align-middle">Good</th><th scope="col" class="text-center border-left bt-none align-middle">Average</th><th scope="col" class="text-center border-left bt-none align-middle">Poor</th>')
				}
			}	
			if(type_of_popup_data == "init" || type_of_popup_data == "mid" || type_of_popup_data == "end" ){

				$('.main_heading').append('<th scope="col" class="align-middle bt-none">Please tick a box (&#10003;)  to answer each question:</th><th scope="col" class="align-middle">1</th><th scope="col" class="text-center border-left bt-none align-middle">2</th><th scope="col" class="text-center border-left bt-none align-middle">3</th><th scope="col" class="text-center border-left bt-none align-middle">4</th><th scope="col" class="text-center border-left bt-none align-middle">N/A</th>')

			}

			if(type_of_popup_data == "facilities_feedback"){
				$('.main_heading').append('<th scope="col" class="align-middle bt-none">Question</th><th scope="col" class="text-center border-left bt-none align-middle">Excellent</th><th scope="col" class="text-center border-left bt-none align-middle">Good</th><th scope="col" class="text-center border-left bt-none align-middle">Average</th><th scope="col" class="text-center border-left bt-none align-middle">Poor</th>')
				$('.hidemsg').css("display","none")
			}else {
				$('.hidemsg').css("display","block")

			}

			if(type_of_popup_data != "teacher_evaluation_by_student" || type_of_popup_data != "teacehr_evaluation_by_student"){
				if(type_of_popup_data == "facilities_feedback"){
					$('#view-teacher-feedback-student-view #teacher-feedback-modalLabel-mobile').text("FACILITES FEEDBACK FORM");
				}else if(type_of_popup_data =="init"){
					$('#view-teacher-feedback-student-view #teacher-feedback-modalLabel-mobile').text("ELT INITIAL-COURSE FEEDBACK FORM");
				}else if(type_of_popup_data =="mid"){
					$('#view-teacher-feedback-student-view #teacher-feedback-modalLabel-mobile').text("ELT MID-COURSE FEEDBACK FORM");
				}else if(type_of_popup_data =="end"){
					$('#view-teacher-feedback-student-view #teacher-feedback-modalLabel-mobile').text("ELT END-OF-TERM FEEDBACK FORM");
				}
			}

			// console.log(JSON.parse(mainFeed));
			var parsedArray = JSON.stringify(mainFeed.feedback); 
			// console.log(parsedArray)

		})
function setTextareaContents(){
	$("span.textarea.form-control").each(function(){
		var currentVal = $(this).html() 
		$(this).next("input").val(currentVal);
	})
}
$(document).ready(function() {
	$('#teacher_id').on('change', function() {
		var teacherName= $("#teacher_id option:selected").text();
			//alert(teacherName);
			$("#teachername").val(teacherName);
		});


	jQuery("#feedback_add_btn").click(function(){
		setTextareaContents();
		var flagForSubmit = true;
		if($('#teacher_id').val() == ""){
			$('.alert-danger').show().html("Please select teacher").fadeOut(8000);
			flagForSubmit = false;
		}

		if(flagForSubmit){
			$("#feedback_add_btn").attr('disabled',true);
			$.ajax({
				url: "{{ URL('profile/add-view-feedbacks')}}",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				type: 'POST',
				data: $("#add_feedback_form").serialize(), 
				success: function (data) {

					
					if(data.success){
						setTimeout(function(){
							window.location.reload()
						},2000);
						$('.alert-danger').hide();
						$('.alert-success').show().html(data.message).fadeOut(8000);
					}else{
						$('.alert-success').hide();
						$('.alert-danger').show().html(data.message).fadeOut(8000);
						$("#feedback_add_btn").removeAttr('disabled');
					}
				}
			});
		}
	});
	jQuery("#feedback_add_btn_mobile").click(function(){
		setTextareaContents();
		var flagForSubmit = true;
		if($('#mob_teacher_id').val() == ""){
			$('#alert-danger-mobile').show().html("Please select teacher").fadeOut(8000);
			flagForSubmit = false;
		}

		if(flagForSubmit){
			$("#feedback_add_btn_mobile").attr('disabled',true);
			$.ajax({
				url: "{{ URL('profile/add-view-feedbacks')}}",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				type: 'POST',
				data: $("#add_feedback_form-mob").serialize(), 
				success: function (data) {

					
					if(data.success){
						setTimeout(function(){
							window.location.reload()
						},2000);
						$('.alert-danger').hide();
						$('.alert-success').show().html(data.message).fadeOut(6000);
					}else{
						$('.alert-success').hide();
						$('.alert-danger').show().html(data.message).fadeOut(6000);
						$("#feedback_add_btn_mobile").removeAttr('disabled');
					}
				}
			});
		}
	});
});
var data = {};
function teacher_feedback_question(id){
		//  $("input[type='radio']").prop("checked",false)
		// $("fieldset#"+id+" > input").each(function(){
		// 	data[$(this).attr('name')] = $(this).val();
		// });
		// console.log(data.feedback);
		jQuery.map($.parseJSON(data.feedback),function(key,info){
			if(info == "user_answer"){
				var s=0;
				key.forEach(function(entry) {
					if(entry.selection != -1)
					{
						$("#ttse_"+s+" #selection"+entry.selection).prop("checked", true);
					}
					s = s + 1;
				});
				var k = 0;
				key.forEach(function(text){
						//console.log(text.extra_text);
						$("#rarelytext_"+k).text(text.extra_text);
						k= k + 1;
					})
			}
			if(info == "other_question"){
				var ss = 0;
				key.forEach(function(entry) {
						//console.log(entry);
						$("#other_question_"+ss).html("");
						$("#other_question_"+ss).append(entry.ans);
						ss = ss + 1;
					});
			}
			if(info == "teacher_name"){
					//console.log(key);
					
				}
			});
	}

</script>
<script>
	var table = "";
   $(document).ready(function() {
     table = $('#example').DataTable({
         "aaSorting": [],
         "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                console.log(aiDisplay.length);
                if (aiDisplay.length > 0) {
                     $("#image_class").hide();
                     $(".datatable-footer").show();
                }
                else {
                     $("#image_class").show();
                     $(".datatable-footer").hide();
                }
            }
     });
    });

    $('.newsearch').on( 'keyup', function () {
        table.search( this.value ).draw();
    });
	$('#course_dropdown').on( 'change', function () {
         table.search( this.value ).draw();
    });
    $('#level_dropdown').on( 'change', function () {
         table.search( this.value ).draw();
    });
</script>
@endsection