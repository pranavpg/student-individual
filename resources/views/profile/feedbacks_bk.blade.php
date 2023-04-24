@extends('layouts.app')
@section('content')

<main class="dashboard">
	<div class="container-fluid">
		<div class="row">
			@include('common.sidebar')
			<!-- /. Sidebar-->
			<section class="main col-sm-12">
				@include('profile.menu')
                    <!-- /. Management Slider-->
					<div class="main__content main__content_full ieuk-fdbk">

							<div class="ilp-heading d-flex flex-wrap align-items-center">
								<div class="add-ilp-button pull-right">
									<a href="" class="opneAddModel">
										<span>
											<img src="{{ asset('public/images/icon-add-ilp.svg') }}" alt="" class="img-fluid">
										</span>
										Teacher Feedback
									</a>
									<!--===== add new HTML 04-09-21 =====-->
									<a href="" class="opneAddModel-ieukmob">
										<span>
											<img src="{{ asset('public/images/icon-add-ilp.svg') }}" alt="" class="img-fluid">
										</span>
										Teacher Feedback
									</a>
									<!--===== add new HTML 04-09-21 =====-->
								</div>
								<!-- /. add ilp-->
							</div>
							<?php 
							$feedbacks = array_reverse($feedbacks);
							// dd($feedbacks);

							$sessionAll = Session::all();

							?>
							<div class="tab-content" id="pills-tabContent">
								<div class="tab-pane fade show active" id="pills-home" role="tabpanel"
									aria-labelledby="pills-home-tab">
	
									<table class="table table-striped ilp-table ieukfbk-tbl ieuktable-sline">
										<thead>
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
												<th scope="row">
													<?php 
													$feedback['type'] = 'teacher_evaluation_by_student';
													if($feedback['type']=="teacher_evaluation_by_student" || $feedback['type']=="teacehr_evaluation_by_student"){
														echo  "Teacher Feedback";
													}elseif($feedback['type']=="end") {
														echo  "End Course Feedback";
													}elseif($feedback['type']=="init") {
														echo  "Initial Course Feedback";
													}elseif($feedback['type']=="mid") {
														echo  "Mid Course Feedback";
													}elseif($feedback['type']=="mid") {
														echo  "Mid Course Feedback";
													}elseif($feedback['type']=="facilities_feedback") {

														$mesgg = "";
														if($sessionAll['topics'][$feedback['topic_id']]['sorting'] == 4 ){
															$mesgg = "Initial";
														}elseif($sessionAll['topics'][$feedback['topic_id']]['sorting'] == 14){
															$mesgg = "Mid";
														}elseif($sessionAll['topics'][$feedback['topic_id']]['sorting'] == 29){
															$mesgg = "End";
														}

														echo  $mesgg." Facilities Feedback";
													}
													/*if(!empty($feedback['teacher_id'])){
														echo "Teacher feedback ";
													}*/
													?>
												</th>
												<td title="Course:" >
													<?php 
													if(!empty($feedback['course_id'])){
														// dd($sessionAll);

														// echo $sessionAll['courses'][$feedback['course_id']]['title'];
														echo collect($sessionAll['course_title'])->where('course_id',$feedback['course_id'])->first()['course']['coursetitle'] ?? '';
													}else{
														echo "-";
													}
													?>
												</td>
												<td title="Level:">
													<?php 
													if($feedback['type']!="teacher_evaluation_by_student" || $feedback['type']=="teacehr_evaluation_by_student"){
														if(!empty($feedback['level_id'])){
															echo $sessionAll['levels'][$feedback['level_id']]['title'];
														}else{
															echo "-";
														}
													}else{

														echo "-";
													}


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
													<a href="" class = "allfeedbackQuestion" data-target="#{{$modalName}}" data-model = "{{isset($feedback['teacher_id']) && !empty($feedback['teacher_id']) ? 'teacher' : 'course'}}"  data-id="{{$key}}"  data-toggle="modal" > 
													
														<img src="{{ asset('public/images/icon-eye-border.svg') }}" alt="" class="img-fluid">
													</a>
													<a href="" class="allfeedbackQuestion_mob" data-target="#{{$modalName_mobile}}" data-model = "{{isset($feedback['teacher_id']) && !empty($feedback['teacher_id']) ? 'teacher' : 'course'}}"  data-id="{{$key}}"  data-toggle="modal" > 
													
														<img src="{{ asset('public/images/icon-eye-border.svg') }}" alt="" class="img-fluid">
													</a>

												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
	
						</div>
                </section>
		</div>
	</div>
</main>
<form id="add_feedback_form" name="add_feedback_form" class="add_feedback_form" method="post">
	<div class="modal fade" id="teacher-feedback-summary" tabindex="-1" role="dialog"
        aria-labelledby="teacher-feedback-summary-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bb-none flex-wrap">
                    <div class="modal-header-top d-flex flex-wrap justify-content-center align-items-center w-100 mb-4">
                        <h4 class="modal-title" id="teacher-feedback-summary-modalLabel">
                            Teacher Feedback Summary
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <img src="{{ asset('public/images/icon-close-modal.svg') }}" alt="close" class="img-fluid">
                        </button>
                    </div>

                    <div class="modal-selectors mb-4 w-100">
						<div class="row">
							<div class="col-3 form-group">
								<select class="form-control form-control-lg sw_1" name="teacher_id" id = "teacher_id">
									<option value="">Select Teacher</option>
									@foreach($teachers as $item)
										<option value="{{$item['_id']}}">{{$item['teacher_name']}}</option>
									@endforeach
								</select>
								<input type="hidden" name= "teacher_name" id="teachername" >
							</div>
						</div>
					</div>

                </div>
                <div class="modal-table modal-table-border mb-4 d-flex flex-wrap">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col" class="align-middle bt-none">Rating</th>
                                <th scope="col" class="text-center border-left bt-none align-middle">Rarely</th>
                                <th scope="col" class="text-center border-left bt-none align-middle">Once in a while </th>
                                <th scope="col" class="text-center border-left bt-none align-middle">Sometimes</th>
                                <th scope="col" class="text-center border-left bt-none align-middle">Most of the times</th>
                                <th scope="col" class="text-center border-left bt-none align-middle">Almost always</th>
                                <th scope="col" class="text-center border-left bt-none align-middle">If you select rarely
                                    write why</th>
                            </tr>
                        </thead>
                      		<tbody>

								<tr>
									<th scope="row" class="align-middle">Teacher is prepared for class
										<input type="hidden" name="user_answer[0][question]" value="Teacher is prepared for class">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation20" name="user_answer[0][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation20"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation30" name="user_answer[0][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation30"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation40" name="user_answer[0][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation40"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation50" name="user_answer[0][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation50"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation60" name="user_answer[0][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation60"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[0][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext0" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
								<tr>
									<th scope="row" class="align-middle">Teacher knows his/her subject
										<input type="hidden" name="user_answer[1][question]" value="Teacher knows his/her subject">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation21" name="user_answer[1][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation21"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation31" name="user_answer[1][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation31"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation41" name="user_answer[1][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation41"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation51" name="user_answer[1][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation51"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation61" name="user_answer[1][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation61"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[1][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext1" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher is organised and neat
										<input type="hidden" name="user_answer[2][question]" value="Teacher is organised and neat">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation22" name="user_answer[2][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation22"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation32" name="user_answer[2][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation32"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation42" name="user_answer[2][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation42"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation52" name="user_answer[2][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation52"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation62" name="user_answer[2][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation62"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[2][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext2" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher plans class time and assignments that help students to understand the class aims easily.
										<input type="hidden" name="user_answer[3][question]" value="Teacher plans class time and assignments that help students to understand the class aims easily.">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation23" name="user_answer[3][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation23"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation33" name="user_answer[3][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation33"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation43" name="user_answer[3][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation43"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation53" name="user_answer[3][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation53"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation63" name="user_answer[3][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation63"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[3][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext3" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher is flexible in accommodating for individual student needs
										<input type="hidden" name="user_answer[4][question]" value="Teacher is flexible in accommodating for individual student needs">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation24" name="user_answer[4][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation24"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation34" name="user_answer[4][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation34"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation44" name="user_answer[4][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation44"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation54" name="user_answer[4][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation54"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation64" name="user_answer[4][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation64"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[4][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext4" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher is clear in giving instructions when doing tasks
										<input type="hidden" name="user_answer[5][question]" value="Teacher is clear in giving instructions when doing tasks">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation25" name="user_answer[5][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation25"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation35" name="user_answer[5][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation35"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation45" name="user_answer[5][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation45"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation55" name="user_answer[5][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation55"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation65" name="user_answer[5][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation65"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[5][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext5" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher allows you to be active in the classroom learning environment
										<input type="hidden" name="user_answer[6][question]" value="Teacher allows you to be active in the classroom learning environment">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation26" name="user_answer[6][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation26"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation36" name="user_answer[6][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation36"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation46" name="user_answer[6][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation46"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation56" name="user_answer[6][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation56"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation66" name="user_answer[6][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation66"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[6][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext6" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher manages the time well
										<input type="hidden" name="user_answer[7][question]" value="Teacher manages the time well">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation27" name="user_answer[7][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation27"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation37" name="user_answer[7][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation37"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation47" name="user_answer[7][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation47"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation57" name="user_answer[7][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation57"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation67" name="user_answer[7][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation67"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[7][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext7" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher returns homework in a timely manner
										<input type="hidden" name="user_answer[8][question]" value="Teacher returns homework in a timely manner">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation28" name="user_answer[8][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation28"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation38" name="user_answer[8][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation38"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation48" name="user_answer[8][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation48"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation58" name="user_answer[8][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation58"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation68" name="user_answer[8][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation68"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[8][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext8" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher has clear classroom procedures so students don’t waste time
										<input type="hidden" name="user_answer[9][question]" value="Teacher has clear classroom procedures so students don’t waste time">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation29" name="user_answer[9][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation29"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation39" name="user_answer[9][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation39"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation49" name="user_answer[9][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation49"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation59" name="user_answer[9][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation59"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation69" name="user_answer[9][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation69"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[9][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext9" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher grades fairly
										<input type="hidden" name="user_answer[10][question]" value="Teacher grades fairly">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation210" name="user_answer[10][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation210"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation310" name="user_answer[10][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation310"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation410" name="user_answer[10][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation410"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation510" name="user_answer[10][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation510"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation610" name="user_answer[10][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation610"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[10][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext10" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">I have learned a lot from this teacher about this subject
										<input type="hidden" name="user_answer[11][question]" value="I have learned a lot from this teacher about this subject">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation211" name="user_answer[11][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation211"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation311" name="user_answer[11][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation311"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation411" name="user_answer[11][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation411"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation511" name="user_answer[11][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation511"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation611" name="user_answer[11][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation611"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[11][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext11" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher gives me good feedback on homework and projects so that I can improve
										<input type="hidden" name="user_answer[12][question]" value="Teacher gives me good feedback on homework and projects so that I can improve">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation212" name="user_answer[12][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation212"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation312" name="user_answer[12][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation312"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation412" name="user_answer[12][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation412"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation512" name="user_answer[12][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation512"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation612" name="user_answer[12][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation612"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[12][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext12" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher is creative in delivering the lesson
										<input type="hidden" name="user_answer[13][question]" value="Teacher is creative in delivering the lesson">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation213" name="user_answer[13][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation213"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation313" name="user_answer[13][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation313"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation413" name="user_answer[13][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation413"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation513" name="user_answer[13][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation513"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation613" name="user_answer[13][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation613"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[13][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext13" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
								<tr>
									<th scope="row" class="align-middle">Teacher encourages students to speak up and be active in the class
										<input type="hidden" name="user_answer[14][question]" value="Teacher encourages students to speak up and be active in the class">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation214" name="user_answer[14][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation214"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation314" name="user_answer[14][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation314"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation414" name="user_answer[14][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation414"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation514" name="user_answer[14][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation514"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation614" name="user_answer[14][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation614"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[14][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext14" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher follows through on what he/she says. You can count on the teacher’s word
										<input type="hidden" name="user_answer[15][question]" value="Teacher follows through on what he/she says. You can count on the teacher’s word">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation215" name="user_answer[15][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation215"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation315" name="user_answer[15][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation315"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation415" name="user_answer[15][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation415"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation515" name="user_answer[15][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation515"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation615" name="user_answer[15][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation615"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[15][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext15" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher listens and understands students’ point of view; he/she may not agree, but students feel understood
										<input type="hidden" name="user_answer[16][question]" value="Teacher listens and understands students’ point of view; he/she may not agree, but students feel understood">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation216" name="user_answer[16][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation216"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation316" name="user_answer[16][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation316"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation416" name="user_answer[16][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation416"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation516" name="user_answer[16][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation516"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation616" name="user_answer[16][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation616"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[16][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext16" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher respects the opinions and decisions of students
										<input type="hidden" name="user_answer[17][question]" value="Teacher respects the opinions and decisions of students">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation217" name="user_answer[17][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation217"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation317" name="user_answer[17][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation317"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation417" name="user_answer[17][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation417"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation517" name="user_answer[17][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation517"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation617" name="user_answer[17][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation617"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[17][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext17" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher is willing to accept responsibility for his/her own mistakes
										<input type="hidden" name="user_answer[18][question]" value="Teacher is willing to accept responsibility for his/her own mistakes">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation218" name="user_answer[18][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation218"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation318" name="user_answer[18][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation318"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation418" name="user_answer[18][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation418"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation518" name="user_answer[18][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation518"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation618" name="user_answer[18][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation618"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[18][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext18" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher is willing to learn from students
										<input type="hidden" name="user_answer[19][question]" value="Teacher is willing to learn from students">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation219" name="user_answer[19][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation219"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation319" name="user_answer[19][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation319"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation419" name="user_answer[19][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation419"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation519" name="user_answer[19][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation519"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation619" name="user_answer[19][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation619"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[19][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext19" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher is sensitive to the needs of students
										<input type="hidden" name="user_answer[20][question]" value="Teacher is sensitive to the needs of students">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation220" name="user_answer[20][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation220"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation320" name="user_answer[20][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation320"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation420" name="user_answer[20][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation420"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation520" name="user_answer[20][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation520"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation620" name="user_answer[20][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation620"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[20][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext20" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher’s words and actions match
										<input type="hidden" name="user_answer[21][question]" value="Teacher’s words and actions match">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation221" name="user_answer[21][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation221"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation321" name="user_answer[21][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation321"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation421" name="user_answer[21][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation421"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation521" name="user_answer[21][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation521"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation621" name="user_answer[21][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation621"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[21][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext21" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher is fun to be with
										<input type="hidden" name="user_answer[22][question]" value="Teacher is fun to be with">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation222" name="user_answer[22][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation222"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation322" name="user_answer[22][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation322"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation422" name="user_answer[22][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation422"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation522" name="user_answer[22][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation522"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation622" name="user_answer[22][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation622"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[22][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext22" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher likes and respects students
										<input type="hidden" name="user_answer[23][question]" value="Teacher likes and respects students">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation223" name="user_answer[23][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation223"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation323" name="user_answer[23][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation323"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation423" name="user_answer[23][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation423"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation523" name="user_answer[23][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation523"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation623" name="user_answer[23][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation623"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[23][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext23" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher helps you when you ask for help
										<input type="hidden" name="user_answer[24][question]" value="Teacher helps you when you ask for help">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation224" name="user_answer[24][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation224"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation324" name="user_answer[24][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation324"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation424" name="user_answer[24][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation424"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation524" name="user_answer[24][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation524"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation624" name="user_answer[24][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation624"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[24][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext24" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher is consistent and fair in discipline
										<input type="hidden" name="user_answer[25][question]" value="Teacher is consistent and fair in discipline">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation225" name="user_answer[25][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation225"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation325" name="user_answer[25][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation325"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation425" name="user_answer[25][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation425"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation525" name="user_answer[25][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation525"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation625" name="user_answer[25][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation625"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[25][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext25" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">I trust this teacher
										<input type="hidden" name="user_answer[26][question]" value="I trust this teacher">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation226" name="user_answer[26][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation226"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation326" name="user_answer[26][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation326"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation426" name="user_answer[26][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation426"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation526" name="user_answer[26][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation526"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation626" name="user_answer[26][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation626"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[26][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext26" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher tries to model what teacher expects of students
										<input type="hidden" name="user_answer[27][question]" value="Teacher tries to model what teacher expects of students">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation227" name="user_answer[27][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation227"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation327" name="user_answer[27][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation327"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation427" name="user_answer[27][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation427"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation527" name="user_answer[27][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation527"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation627" name="user_answer[27][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation627"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[27][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext27" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
																<tr>
									<th scope="row" class="align-middle">Teacher is fair and firm in discipline without being too strict
										<input type="hidden" name="user_answer[28][question]" value="Teacher is fair and firm in discipline without being too strict">
									</th>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation228" name="user_answer[28][selection]" value="1">
											<label class="custom-control-label" for="customControlValidation228"></label>
										</div>
									</td>
									<td class="text-center border-left  align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation328" name="user_answer[28][selection]" value="2">
											<label class="custom-control-label" for="customControlValidation328"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation428" name="user_answer[28][selection]" value="3">
											<label class="custom-control-label" for="customControlValidation428"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation528" name="user_answer[28][selection]" value="4">
											<label class="custom-control-label" for="customControlValidation528"></label>
										</div>
									</td>
									<td class="text-center border-left align-middle">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="customControlValidation628" name="user_answer[28][selection]" value="5">
											<label class="custom-control-label" for="customControlValidation628"></label>
										</div>
									</td>
									<td class="w-20 border-left align-middle">
										<div style="max-width: 187px;">
											<textarea name="user_answer[28][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext28" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;"></textarea>
										</div>
									</td>
								</tr>
							</tbody>
                    </table>
                </div>
        		<div class="modal-body modal-table-border">
				
					<h6>What are the things that your teacher does well?
						<input type="hidden" name="other_question[0][question]" value="What are the things that your teacher does well?"></h6>

					<div class="form-group form-group_underline">
						<input type="text" class="textarea form-control form-control-sm form-control_underline" id="comments" role="textbox" contenteditable="" placeholder="Your Answer...." onpaste="return false;" name="other_question[0][ans]" >
					</div>
		
					<h6>Can you think of any suggestions that will help this teacher improve?<input type="hidden" name="other_question[1][question]" value="Can you think of any suggestions that will help this teacher improve?"></h6>
					<div class="form-group form-group_underline mb-2">
						<input type="text" class="textarea form-control form-control-sm form-control_underline" id="comments" role="textbox" contenteditable="" placeholder="Your Answer...." onpaste="return false;" name="other_question[1][ans]" >
					</div>
				</div>
				<div class="alert alert-success" role="alert" style="display: none;">All answers successfully submitted.</div>
				<div class="alert alert-danger" role="alert" style="display:none"></div>
    			<div class="modal-footer bt-none justify-content-center">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Skip</button>
					<button type="button" class="btn btn-primary" id="feedback_add_btn">Save</button>
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
									<th scope="col" class="align-middle bt-none">Rating</th>
									<th scope="col" class="text-center border-left bt-none align-middle">Rarely</th>
									<th scope="col" class="text-center border-left bt-none align-middle">Once in a while</th>
									<th scope="col" class="text-center border-left bt-none align-middle">Sometimes</th>
									<th scope="col" class="text-center border-left bt-none align-middle">Most of the times</th>
									<th scope="col" class="text-center border-left bt-none align-middle">Almost always</th>
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
									<td class="text-center border-left  align-middle">
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
<form id="add_feedback_form_mob" name="add_feedback_form_mob" class="add_feedback_form_mob" method="post">
<!--===== add new HTML 04-09-21 =====-->
<form id="add_feedback_form-mob" name="add_feedback_form-mob" class="add_feedback_form-mob" method="post">
	<div class="modal fade" id="teacher-feedback-mobieuk" tabindex="-1" role="dialog"
        aria-labelledby="teacher-feedback-mobieuk-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bb-none flex-wrap">
                    <div class="modal-header-top d-flex flex-wrap justify-content-center align-items-center w-100 mb-2">
                        <h4 class="modal-title" id="teacher-feedback-mobieuk-modalLabel">
                            Teacher Feedback Summary
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <img src="{{ asset('public/images/icon-close-modal.svg') }}" alt="close" class="img-fluid">
                        </button>
                    </div>
					<div class="modal-selectors  w-100">
						<div class="row">
							<div class="col-12 ieuktimeselc-cls w-100 text-center mb-2">
								<select class="ieukselect" name="teacher_id" id = "teacher_id">
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
                </div>
        		<div class="modal-body modal-table-border">
					<div class="ieukinmh"><h5 class="ieuk-fptitle">Rating</h5> <span class="ieuk-msr-count align-self-end">1/28</span></div>
					<p>Teacher plans class time and assignments that help students to understand the class aims easily.</p>
					
					<div class="ieuk-fpr">					
						<label>
							<input type="radio" name="radioGroup" checked />
							<span>Rarely</span>
						</label>
						<label>
							<input type="radio" name="radioGroup" />
							<span>Once in a while</span>
						</label>
						<label>
							<input type="radio" name="radioGroup" />
							<span>Sometimes</span>
						</label>
						<label>
							<input type="radio" name="radioGroup" />
							<span>Most of the times</span>
						</label>
						<label>
							<input type="radio" name="radioGroup" />
							<span>Almost always</span>
						</label>
						
					</div>
					<div class="row">
						<div class="col-12 d-flex justify-content-between mb-2">					
							<button type="button" class="btn btn-primary">Back</button>
							<button type="button" class="btn btn-primary">Next</button>
						</div>
					</div>
					<div class="ieukf-tarea">
						If you select rarely write why:
						<textarea placeholder="write here..."></textarea>
					</div>
					<div class="ieukf-tarea">
						What are the things that your teacher does well?
						<textarea placeholder="write here..."></textarea>
					</div>
					<div class="ieukf-tarea">
						What are the things that your teacher does well?
						<textarea placeholder="write here..."></textarea>
					</div>
					<div class="row"><div class="col-12 text-center"><button type="button" class="btn btn-primary">Save</button></div></div>					
				</div>
				<div class="alert alert-success" role="alert" style="display: none;">All answers successfully submitted.</div>
				<div class="alert alert-danger" role="alert" style="display:none"></div>
    			<div class="modal-footer bt-none">

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
							<button type="button" class="btn btn-primary next_view" >Next</button>
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
						Teacher Feedback
					</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<img src="{{ asset('public/images/icon-close-modal.svg') }}" alt="close" class="img-fluid">
					</button>
				</div>
				<p style="margin-left: 185px;margin-left: 185px;" class="hidemsg">1 = Strongly Disagree; 2 = Disagree; 3 = Agree; 4 = Strongly Agree; NA = Don’t know/not relevant</p>
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
			<div class="modal-header bb-none flex-wrap">
				<div class="modal-header-top d-flex flex-wrap justify-content-center align-items-center w-100 mb-4">
					<h4 class="modal-title" id="teacher-feedback-modalLabel-mobile">
						Teacher Feedback
					</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<img src="{{ asset('public/images/icon-close-modal.svg') }}" alt="close" class="img-fluid">
					</button>
				</div>
				<div class="btn btn-primary">
					<span id = "teacher_info_mobile" class="teacher_info_mobile"></span>
				</div>
				<p class="hidemsg">1 = Strongly Disagree; 2 = Disagree; 3 = Agree; 4 = Strongly Agree; NA = Don’t know/not relevant</p>
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
			<div class="modal-body modal-table-border">
				<div class="ieukinmh"><h5 class="ieuk-fptitle">Rating</h5> <span class="ieuk-msr-count align-self-end number">1/28</span></div>
				<div class="appendreadio"></div>
				<div class="row">
					<div class="col-12 d-flex justify-content-between mb-2">					
						<button type="button" class="btn btn-primary pre_view">Back</button>
						<button type="button" class="btn btn-primary next_view" >Next</button>
					</div>
				</div>
				<div class="mobile_ather_que"></div>
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
		
			if(window.inc==window.lengthque-1){
				return false;
			}
			$('.parent_'+window.inc).fadeOut()
			window.inc++;
			$('.parent_'+window.inc).fadeIn()
			var newData = window.inc+1;
			$('.align-self-end').html(newData+"/"+window.lengthque)
		});

		$('.pre_view').click(function(){
			if(window.inc<1){
				return false;
			}
			$('.parent_'+window.inc).fadeOut()
			$('.align-self-end').html(window.inc+"/"+window.lengthque)
			window.inc--;
			$('.parent_'+window.inc).fadeIn()
		});


		$('.opneAddModel').click(function(e){
			$('#teacher-feedback-summary').modal("show");
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
			var data = JSON.parse(mainFeed);
			var key = $(this).attr("data-id");
			var model = $(this).attr("data-model")
			var otherQuestion = data[key]['other_question'];
			$('.teacher_feedback').html("")
			type_of_popup = JSON.parse(type);
			var feedbackQuestion 	= data[key]['user_answer'];
			var type_of_popup_data	= type_of_popup[key];
			var teacherName 		= data[key]['teacher_name'];
			// alert(type_of_popup_data)
			$("#teacher_info").html(teacherName);
			var i=0;
			feedbackQuestion.forEach(function(feedbackQuestion) {
				
					var textdata = `<tr><th scope="row" class="align-middle ">`+feedbackQuestion.question+`</th>
					<td class="text-center border-left align-middle">
						<div class="custom-control custom-radio">
						`+(feedbackQuestion.selection == 1 ? '<input type="radio" class="custom-control-input selection1" id="selection1" name="radio_btn_'+ i +'" value="" checked>':'<input type="radio" class="custom-control-input selection1" id="selection1" name="radio_btn" value="">')+`								
							<label class="custom-control-label" for="selection1"></label>
						</div>
					</td>
					<td class="text-center border-left  align-middle">
						<div class="custom-control custom-radio">
						`+(feedbackQuestion.selection == 2 ? '<input type="radio" class="custom-control-input selection2" id="selection2" name="radio_btn_'+ i +'" value="" checked>':'<input type="radio" class="custom-control-input selection2" id="selection2" name="radio_btn" value="">')+`
							<label class="custom-control-label" for="selection2"></label>
						</div>
					</td>
					<td class="text-center border-left align-middle">
						<div class="custom-control custom-radio">
						`+(feedbackQuestion.selection == 3 ? '<input type="radio" class="custom-control-input selection3" id="selection3" name="radio_btn_'+ i +'" value="" checked>':'<input type="radio" class="custom-control-input selection3" id="selection3" name="radio_btn" value="">')+`
							<label class="custom-control-label" for="selection3"></label>
						</div>
					</td>
					<td class="text-center border-left align-middle">
						<div class="custom-control custom-radio">
						`+(feedbackQuestion.selection == 4 ? '<input type="radio" class="custom-control-input selection4" id="selection4" name="radio_btn_'+ i +'" value="" checked>':'<input type="radio" class="custom-control-input selection4" id="selection4" name="radio_btn" value="">')+`
							<label class="custom-control-label" for="selection4"></label>
						</div>
					</td>`;
					if(type_of_popup_data == "teacher_evaluation_by_student" || type_of_popup_data == "teacehr_evaluation_by_student"){
						textdata +=`<td class="text-center border-left align-middle">
							<div class="custom-control custom-radio">
							`+(feedbackQuestion.selection == 5 ? '<input type="radio" class="custom-control-input selection5" id="selection5" name="radio_btn_'+ i +'" value="" checked>':'<input type="radio" class="custom-control-input selection5" id="selection5" name="radio_btn" value="">')+`
								<label class="custom-control-label" for="selection5"></label>
							</div>
						</td>`;
					}

					if(type_of_popup_data == "init" || type_of_popup_data == "mid" || type_of_popup_data == "end" ){
					
							textdata +=`<td class="text-center border-left align-middle">
								<div class="custom-control custom-radio">
								`+(feedbackQuestion.selection == 5 ? '<input type="radio" class="custom-control-input selection5" id="selection5" name="radio_btn_'+ i +'" value="" checked>':'<input type="radio" class="custom-control-input selection5" id="selection5" name="radio_btn" value="">')+`
									<label class="custom-control-label" for="selection5"></label>
								</div>
							</td>`;
						
					}	


					if(type_of_popup_data == "teacher_evaluation_by_student" || type_of_popup_data == "teacehr_evaluation_by_student"){
						textdata +=`<td class="w-20 border-left align-middle"><div style="max-width: 187px;">
						<textarea class="textarea form-control form-control-sm form-control_underline" id = "rarelytext_`+i+`" readonly>`+feedbackQuestion.extra_text+`</textarea><input type="hidden" name="" value=""></div></td></tr>`;
					}
					$('.teacher_feedback').append(textdata)
					i++;
			});

			
			var k = 0;
			$('.other_question').html("")
			otherQuestion.forEach(function(otherQuestion) {
					$('.other_question').append(`<h6>`+otherQuestion.question+`<input type="hidden" name="other_question`+k+`"  value=""></h6>
							<div class="form-group form-group_underline">
							<input type="text" class="textarea form-control form-control-sm form-control_underline" id = "other_question_`+k+`" role="textbox" contenteditable
									placeholder="Your Answer...." value="`+otherQuestion.ans+`" readonly>
									<input type="hidden" name="other_question_`+k+`" value="" >
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
						$('#view-teacher-feedback-student #teacher-feedback-modalLabel').text("FACILITES FEEDBACK FORM");
					}else if(type_of_popup_data =="init"){
						$('#view-teacher-feedback-student #teacher-feedback-modalLabel').text("ELT INITIAL-COURSE FEEDBACK FORM");
					}else if(type_of_popup_data =="mid"){
						$('#view-teacher-feedback-student #teacher-feedback-modalLabel').text("ELT MID-COURSE FEEDBACK FORM");
					}else if(type_of_popup_data =="end"){
						$('#view-teacher-feedback-student #teacher-feedback-modalLabel').text("ELT END-OF-TERM FEEDBACK FORM");
					}
				}
					
			// console.log(JSON.parse(mainFeed));
			var parsedArray = JSON.stringify(mainFeed.feedback); 
			// console.log(parsedArray)
				
	})
	$(".allfeedbackQuestion_mob").click(function(){
			var data = JSON.parse(mainFeed);
			var key = $(this).attr("data-id");
			var model = $(this).attr("data-model")
			var otherQuestion = data[key]['other_question'];
			$('.appendreadio').html("")
			type_of_popup = JSON.parse(type);
			var feedbackQuestion 	= data[key]['user_answer'];
			var type_of_popup_data	= type_of_popup[key];
			var teacherName 		= data[key]['teacher_name'];
			$(".teacher_info_mobile").html(teacherName);
			var i=0;
			window.inc =0;

			var lableArray = new Array();
			if(model == "teacher"){
					/*$lableArray
					$('.main_heading').append('<th scope="col" class="align-middle bt-none">Rating</th><th scope="col" class="text-center border-left bt-none align-middle">Rarely</th><th scope="col" class="text-center border-left bt-none align-middle">Once in a while</th><th scope="col" class="text-center border-left bt-none align-middle">Sometimes</th><th scope="col" class="text-center border-left bt-none align-middle">Most of the times</th><th scope="col" class="text-center border-left bt-none align-middle">Almost always</th><th scope="col" class="text-center w-20 border-left bt-none align-middle">If you select rarely write why</th>')*/

					lableArray=['Rarely','Once in a while','Sometimes','Most of the times','Almost always'];
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
			
			window.lengthque = feedbackQuestion.length;
			feedbackQuestion.forEach(function(feedbackQuestion) {
					if(i==0){
						var textdata = '<div class="parent_'+i+'" >';
					}else{
						var textdata = '<div class="parent_'+i+'" style="display:none;">';
					}
					textdata += '<p>'+feedbackQuestion.question+'</p>\
						<div class="ieuk-fpr">\
							<label>\
							'+(feedbackQuestion.selection == 1 ? '<input type="radio"  id="customControlValidation20" name="user_answer_mobile[0][selection]" value="1" checked/>':'<input type="radio"  id="customControlValidation20" name="user_answer_mobile[0][selection]" value="1" />')+'\
								<span>'+lableArray[0]+'</span>\
							</label>\
							<label>\
							'+(feedbackQuestion.selection == 2 ? '<input type="radio"  id="customControlValidation20" name="user_answer_mobile[0][selection]" value="1" checked />':'<input type="radio"  id="customControlValidation20" name="user_answer_mobile[0][selection]" value="1" />')+'\
								<span>'+lableArray[1]+'</span>\
							</label>\
							<label>\
							'+(feedbackQuestion.selection == 3 ? '<input type="radio"  id="customControlValidation20" name="user_answer_mobile[0][selection]" value="1" checked />':'<input type="radio"  id="customControlValidation20" name="user_answer_mobile[0][selection]" value="1" />')+'\
								<span>'+lableArray[2]+'</span>\
							</label>\
							<label>\
							'+(feedbackQuestion.selection == 4 ? '<input type="radio"  id="customControlValidation20" name="user_answer_mobile[0][selection]" value="1" checked/>':'<input type="radio"  id="customControlValidation20" name="user_answer_mobile[0][selection]" value="1" />')+'\
								<span>'+lableArray[3]+'</span>\
							</label>';
						if(type_of_popup_data == "teacher_evaluation_by_student" || type_of_popup_data == "teacehr_evaluation_by_student"){
							textdata +='<label>\
							'+(feedbackQuestion.selection == 5 ? '<input type="radio"  id="customControlValidation20" name="user_answer_mobile[0][selection]" value="1" checked />':'<input type="radio"  id="customControlValidation20" name="user_answer_mobile[0][selection]" value="1" />')+'\
							<span>'+lableArray[4]+'</span>\
							</label>';
						}

						if(type_of_popup_data == "init" || type_of_popup_data == "mid" || type_of_popup_data == "end" ){
							textdata +='<label>\
							'+(feedbackQuestion.selection == 5 ? '<input type="radio"  id="customControlValidation20" name="user_answer_mobile[0][selection]" value="1" />':'<input type="radio"  id="customControlValidation20" name="user_answer_mobile[0][selection]" value="1" />')+'\
								<span>'+lableArray[4]+'</span>\
							</label>';
						}	
						textdata+='</div>';
						if(type_of_popup_data == "teacher_evaluation_by_student" || type_of_popup_data == "teacehr_evaluation_by_student"){
							
							textdata +='<textarea name="user_answer_mobile['+i+'][extra_text_new]" class="textarea form-control form-control-sm form-control_underline" id="rarelytext1" role="textbox" contenteditable="" placeholder="Write Here...." onpaste="return false;">'+feedbackQuestion.extra_text+'</textarea>';
						}
						textdata+='</div>';
						$('.appendreadio').append(textdata)
				i++;
			});			

			var k = 0;
			$('.mobile_ather_que').html("")
			console.log(otherQuestion);
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
@endsection