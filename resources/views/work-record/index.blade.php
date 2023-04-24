@extends('layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&family=Roboto:wght@100;300;400;500;700&display=swap"
rel="stylesheet">
<!--<link href="{{asset('public/css/style.css')}}" rel="stylesheet">-->
<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>

<main class="dashboard">
	<div class="container-fluid">
		<div class="row">
			@include('common.sidebar')
			<section class="main notes ieuk-wrm col-sm-12">
				<div class="summary-heading d-flex flex-wrap justify-content-between align-items-center">
					<a href="{{url('')}}" class="back-button">back</a>

					<h1>
						<span>
							<img src="{{asset('public/images/icon-heading-notes.svg')}}" alt="" class="img-fluid">
						</span>
						Work Record
					</h1>

					<!-- /. H1 -->
					<div class="ilp-search align-self-end">
						<input class="form-control mr-sm-2 search_work_record" type="search" placeholder="Search"
						aria-label="Search">
						<button class="btn" type="button" id="removeSearch">
							<img src="{{asset('public/images/icon-search-pink.svg')}}" alt="" class="img-fluid">
						</button>
						<form class="form-inline">
						</form>
					</div>
					<!-- /. ilp search-->
				</div>

				<!-- /. Management Slider-->
				<div class="ilp-heading d-flex flex-wrap align-items-center">
					<ul class="nav nav-pills nav-pills_switch" id="pills-tab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active checkparent" id="pills-home-tab" data-toggle="pill" href="#pills-home"
							role="tab" aria-controls="pills-home" aria-selected="true">GES</a>
						</li>
						<li class="nav-item">
							<a class="nav-link checkparent" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
							role="tab" aria-controls="pills-profile" aria-selected="false">AES</a>
						</li>
					</ul>
					<!-- /. Tab heading-->
					<div class="d-flex flex-wrap pull-right">
						<div class="filter">
							<a href="javascript:void(0)" class="btn btn-primary btn-sm close-filter">
								<img src="{{asset('public/images/icon-filter.svg')}}" alt="" class="img-fluid">
							</a>
						</div>
					</div>
				</div>

				<!-- /. ILP Heading-->

				<hr class="hr">
				<div class="main__content main__content_full work-record">
					<div class="col-12">
						<div class="row">

							<div class="tab-content" id="pills-tabContent">
								<div class="tab-pane fade show active" id="pills-home" role="tabpanel"
								aria-labelledby="pills-home-tab">

								<!-- tab in tab start-->
								<ul class="nav nav-tabs" id="myTabinner" role="tablist">
									<li class="nav-item">
										<a class="nav-link active clicking" id="home-tab" data-toggle="tab" href="#all_submitted_tasks_ges"
										role="tab" aria-controls="home" aria-selected="true">
										All Submitted Tasks
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link clicking" id="profile-tab" data-toggle="tab" href="#awaiting_marked_tasks_ges"
									role="tab" aria-controls="profile" aria-selected="false">
									Awaiting Marking
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link clicking" id="contact-tab" data-toggle="tab" href="#marked_tasks_ges"
								role="tab" aria-controls="contact" aria-selected="false">
								Marked Tasks
							</a>
						</li>
					</ul>
					<div class="tab-content" id="myTabinnerContent">
						<?php
						$record_types_temp_data = ['all_submitted_tasks_ges','awaiting_marked_tasks_ges','marked_tasks_ges'];
						$record_types = ['all_submitted_tasks','awaiting_marked_tasks','marked_tasks'];
						?>
						@if(!empty($recordList))
						@foreach($record_types as $rkey => $rvalue)
						<div class="tab-pane fade {{($rkey==0)?'show active':''}}" id="{{$record_types_temp_data[$rkey]}}" role="tabpanel"
						aria-labelledby="home-tab">
						<table class="table work-record__table">
							<thead>
								<tr>
									<th scope="col">Topic</th>
									<th scope="col">Task</th>
									<th scope="col">Marks</th>
									<th scope="col">Teacher Review</th>
									<th scope="col">My Review</th>
									<th scope="col"></th>
								</tr>
							</thead>
							<tbody class="{{$rvalue}}">
								<?php
								$azRange = range('A', 'Z');
								$emoji =['icon-emoji-green.svg','icon-emoji-yellow.svg', 'icon-emoji-orange.svg', 'icon-emoji-red.svg'];
								$emoji_progress_class =['bg-success', 'bg-info', 'bg-warning', 'bg-danger'];
								$emoji_progress_width = ['100%','75%','50%','25%'];
								$i=0;
																						 // pr($recordList['GES']['all_submitted_tasks']);
								?>
								
								@if(!empty($recordList['GES']))
								<?php 
								$student_list_array =  isset($recordList['GES'][$rvalue])?$recordList['GES'][$rvalue]:[];
								usort($student_list_array, function($a, $b) {
									return (int) $b['updated_at'] - (int) $a['updated_at'];
								});     
								
								?>
								@foreach( $student_list_array as $key => $value)
								<?php 
																								// pr($sessionAll)
								$value['task_no'] = is_array($value['task_no'])?"1":$value['task_no'];
								?>
								<tr class="{{ 'topic'.$value['topic_no']. ' task'.$value['task_no'].' myreview'.$value['task_emoji'].' teacherreview'.$value['teacher_emoji']  }}">
									<th scope="row">Topic {{$value['topic_no']}}</th>
									<td>
										<?php
										if(isset($sessionAll['tasks'][$value['task_id']]) && $sessionAll['tasks'][$value['task_id']]['title'] == 'Grammar Key'){
											echo "GK";                                                                
										}elseif(isset($sessionAll['tasks'][$value['task_id']]) && $sessionAll['tasks'][$value['task_id']]['title'] == 'Grammar Practice'){
											echo "GP";
										}else{
											echo "Task ".$value['task_no'];
										}
										?>
									</td>
									<td>
										<?php
										if($value['marks_gained']!='-'){
											echo $value['marks_gained'].'/'.$value['original_marks'];
										}else {
											echo '-';
										}
										?>
									</td>
									<td>
										<?php
																										//    pr($value['teacher_emoji']);

										
										

										?>
										@if( !empty($value['teacher_emoji']) && $value['teacher_emoji'] > 0)
										<div class="d-flex align-items-center flex-wrap">
											<span class="review-icon">

												<img src="{{asset('public/images/').'/'.$emoji[$value['teacher_emoji']-1]}}" alt=""
												class="img-fluid">
											</span>

											<span class="progress">
												<span class="progress-bar {{$emoji_progress_class[$value['teacher_emoji']-1]}}"
												role="progressbar" style="width: {{$emoji_progress_width[$value['teacher_emoji']-1]}}"
												aria-valuenow="25" aria-valuemin="0"
												aria-valuemax="100"></span>
											</span>
										</div>
										@else
										__
										@endif
									</td>

									<td>
										@if( !empty($value['task_emoji']) && $value['task_emoji'] > 0)
										<div class="d-flex align-items-center flex-wrap open-add-feedback-modal"  data-topicno="{{$value['topic_no']}}" data-taskno="{{$value['task_no']}}" data-topicid="{{$value['topic_id']}}" data-practiceid="{{$value['practice_id']}}" data-taskid="{{$value['task_id']}}" data-taskcomment="{{$value['student_task_comment']}}" data-taskemoji="{{$value['task_emoji']}}">
											<span class="review-icon">

												<img src="{{asset('public/images/').'/'.$emoji[$value['task_emoji']-1]}}" alt=""
												class="img-fluid">
											</span>

											<span class="progress">
												<span class="progress-bar {{$emoji_progress_class[$value['task_emoji']-1]}}"
												role="progressbar" style="width: {{$emoji_progress_width[$value['task_emoji']-1]}}"
												aria-valuenow="25" aria-valuemin="0"
												aria-valuemax="100"></span>
											</span>
										</div>
										@else
										<a href="javascript:void(0)" class="open-add-feedback-modal" data-topicno="{{$value['topic_no']}}" data-taskno="{{$value['task_no']}}" data-topicid="{{$value['topic_id']}}" data-practiceid="{{$value['practice_id']}}" data-taskid="{{$value['task_id']}}" data-taskcomment="{{$value['student_task_comment']}}" data-taskemoji="{{$value['task_emoji']}}">
											<img src="{{ asset('public/images/icon-table-edit.svg')}}" alt="" class="img-fluid ">
										</a>
										@endif
									</td>

									<td>
										<a href="javascript:void(0)"
										class="hidden-tr-opner">
										<img src="{{asset('public/images/icon-table-opener.svg')}}" alt=""
										class="img-fluid">
									</a>
								</td>
							</tr>

							@if(!empty($value['practice']))
							<tr class="hidden-data" >
								<td colspan="6">
									<div class="hidden-tr" style="display:none">
										<div class="topic-block">
											<table
											class="table table-light table-borderless">
											<thead>
												<tr>
													<th scope="col">Practice</th>
													<th scope="col">Allocated Marks</th>
													<th scope="col">Total Marks</th>
													<th scope="col"></th>
												</tr>
											</thead>
											<tbody>

												@foreach($value['practice'] as $pk => $pv)
												<?php

																																	 /*     echo "<pre>";
																																				print_r($value['teacher_comment']);
																																				// print_r($pv);
																																				echo "</pre>";  */
																																				if($pv['practice_no']==0){
																																					$practice_sorting = $pv['practice_no'];
																																				} else {
																																					$practice_sorting = $pv['practice_no']-1;
																																				}
																																				?>
																																				<tr>
																																					<th scope="row">{{   $azRange[$practice_sorting]}}</th>
																																					<td>{{$pv['marks_gained']}}</td>
																																					<td>{{$pv['original_marks']}}</td>
																																					<td>
																																						<a href="javascript:void(0)" class="open_practice_preview_modal" data-practiceno="{{$azRange[$practice_sorting]}}" data-topicno="{{$value['topic_no']}}" data-taskno="{{$value['task_no']}}" data-topicid="{{$value['topic_id']}}" data-practiceid="{{$pv['practice_id']}}" data-taskid="{{$value['task_id']}}" data-original-marks="{{$pv['original_marks']}}" data-marks-gained="{{$pv['marks_gained']}}"  
																																						data-teacher-comment="{{isset($value['teacher_comment'])?$value['teacher_comment']:''}}"  
																																						data-teacher-audio="{{isset($value['teacher_audio'])?$value['teacher_audio']:''}}"  
																																						data-teacher-emoji="{{isset($value['teacher_emoji'])?$value['teacher_emoji']:''}}">
																																						<img src="{{asset('public/images/icon-small-eye.svg')}}" alt=""   class="img-fluid">


																																					</a>
																																				</td>
																																			</tr>
																																			@endforeach
																																		</tbody>
																																	</table>
																																</div>
																															</div>
																														</td>
																													</tr>
																													@endif
																													<tr></tr>
																													<?php $i++; ?>
																													@endforeach
																													@else
																													<tr>
																														<td colspan="6"><center>No record found</center></td>
																													</tr>
																													@endif
																												</tbody>
																											</table>

																										</div>
																										@endforeach
																										@endif

																									</div>
																									<!-- tab in tab end-->
																								</div>
																								<!-- tab 1-->
																								<div class="tab-pane fade" id="pills-profile" role="tabpanel"
																								aria-labelledby="pills-profile-tab">

																								<!-- tab in tab start-->
																								<ul class="nav nav-tabs" id="myTabinner" role="tablist">
																									<li class="nav-item">
																										<a class="nav-link active clicking" id="home-tab" data-toggle="tab" href="#all_submitted_tasks"
																										role="tab" aria-controls="home" aria-selected="true">
																										All Submitted Tasks
																									</a>
																								</li>
																								<li class="nav-item">
																									<a class="nav-link clicking" id="profile-tab" data-toggle="tab" href="#awaiting_marked_tasks"
																									role="tab" aria-controls="profile" aria-selected="false">
																									Awaiting Marking
																								</a>
																							</li>
																							<li class="nav-item">
																								<a class="nav-link clicking" id="contact-tab" data-toggle="tab" href="#marked_tasks"
																								role="tab" aria-controls="contact" aria-selected="false">
																								Marked Tasks
																							</a>
																						</li>
																					</ul>

																					<div class="tab-content" id="myTabinnerContent">
																						<?php
																						$record_types = ['all_submitted_tasks','awaiting_marked_tasks','marked_tasks'];
																						?>
																						@if(!empty($recordList) && array_key_exists('AES', $recordList))
																						@foreach($record_types as $rkey => $rvalue)
																						<div class="tab-pane fade {{($rkey==0)?'show active':''}}" id="{{$rvalue}}" role="tabpanel"
																						aria-labelledby="home-tab">
																						<table class="table work-record__table">
																							<thead>
																								<tr>
																									<th scope="col">Topic</th>
																									<th scope="col">Task</th>
																									<th scope="col">Marks</th>
																									<th scope="col">Teacher Review</th>
																									<th scope="col">My Review</th>
																									<th scope="col"></th>
																								</tr>
																							</thead>
																							<tbody class="{{$rvalue}}">
																								<?php
																								$azRange = range('A', 'Z');
																								$emoji =['icon-emoji-green.svg','icon-emoji-yellow.svg', 'icon-emoji-orange.svg', 'icon-emoji-red.svg'];
																								$emoji_progress_class =['bg-success', 'bg-info', 'bg-warning', 'bg-danger'];
																								$emoji_progress_width = ['100%','75%','50%','25%'];
																								$i=0;
																							//  pr($recordList['GES']['all_submitted_tasks']);
																								?>
																								<?php 
																												 // $student_list_array =  $recordList['AES'][$rvalue];

																								$student_list_array =  isset($recordList['AES'][$rvalue])?$recordList['AES'][$rvalue]:[];
																								usort($student_list_array, function($a, $b) {
																									return (int) $b['updated_at'] - (int) $a['updated_at'];
																								}); 
																								?>
																								@foreach($student_list_array as $key => $value)

																								<tr class="{{ 'topic'.$value['topic_no']. ' task'.$value['task_no'].' myreview'.$value['task_emoji'].' teacherreview'.$value['teacher_emoji']  }}">
																									<th scope="row">Topic {{$value['topic_no']}}</th>
																									<td> <?php
																									if($sessionAll['tasks'][$value['task_id']]['title'] == 'Grammar Key'){
																										echo "GK";                                                                
																									}elseif($sessionAll['tasks'][$value['task_id']]['title'] == 'Grammar Practice'){
																										echo "GP";
																									}else{
																										echo "Task ".$value['task_no'];
																									}
																								?></td>
																								<td>
																									<?php
																									if($value['marks_gained']!='-'){
																										echo $value['marks_gained'].'/'.$value['original_marks'];
																									}else {
																										echo '-';
																									}
																									?>
																								</td>
																								<td>
																									<?php
																										//    pr($value['teacher_emoji']);
																									?>
																									@if( !empty($value['teacher_emoji']) && $value['teacher_emoji'] > 0)
																									<div class="d-flex align-items-center flex-wrap">
																										<span class="review-icon">

																											<img src="{{asset('public/images/').'/'.$emoji[$value['teacher_emoji']-1]}}" alt=""
																											class="img-fluid">
																										</span>

																										<span class="progress">
																											<span class="progress-bar {{$emoji_progress_class[$value['teacher_emoji']-1]}}"
																											role="progressbar" style="width: {{$emoji_progress_width[$value['teacher_emoji']-1]}}"
																											aria-valuenow="25" aria-valuemin="0"
																											aria-valuemax="100"></span>
																										</span>
																									</div>
																									@else
																									__
																									@endif
																								</td>

																								<td>
																									@if( !empty($value['task_emoji']) && $value['task_emoji'] > 0)
																									<div class="d-flex align-items-center flex-wrap open-add-feedback-modal" data-topicno="{{$value['topic_no']}}" data-taskno="{{$value['task_no']}}" data-topicid="{{$value['topic_id']}}" data-practiceid="{{$value['practice_id']}}" data-taskid="{{$value['task_id']}}"  data-taskcomment="{{$value['student_task_comment']}}" data-taskemoji="{{$value['task_emoji']}}">
																										<span class="review-icon">

																											<img src="{{asset('public/images/').'/'.$emoji[$value['task_emoji']-1]}}" alt=""
																											class="img-fluid">
																										</span>

																										<span class="progress">
																											<span class="progress-bar {{$emoji_progress_class[$value['task_emoji']-1]}}"
																											role="progressbar" style="width: {{$emoji_progress_width[$value['task_emoji']-1]}}"
																											aria-valuenow="25" aria-valuemin="0"
																											aria-valuemax="100"></span>
																										</span>
																									</div>
																									@else
																									<a href="javascript:void(0)" class="open-add-feedback-modal" data-topicno="{{$value['topic_no']}}" data-taskno="{{$value['task_no']}}" data-topicid="{{$value['topic_id']}}" data-practiceid="{{$value['practice_id']}}" data-taskid="{{$value['task_id']}}"  data-taskcomment="{{$value['student_task_comment']}}" data-taskemoji="{{$value['task_emoji']}}">
																										<img src="{{ asset('public/images/icon-table-edit.svg')}}" alt="" class="img-fluid ">
																									</a>
																									@endif
																								</td>

																								<td>
																									<a href="javascript:void(0)"
																									class="hidden-tr-opner">
																									<img src="{{asset('public/images/icon-table-opener.svg')}}" alt=""
																									class="img-fluid">
																								</a>
																							</td>
																						</tr>

																						@if(!empty($value['practice']))
																						<tr class="hidden-data" >
																							<td colspan="6">
																								<div class="hidden-tr" style="display:none">
																									<div class="topic-block">
																										<table
																										class="table table-light table-borderless">
																										<thead>
																											<tr>
																												<th scope="col">Practice</th>
																												<th scope="col">Allocated Marks</th>
																												<th scope="col">Total Marks</th>
																												<th scope="col"></th>
																											</tr>
																										</thead>
																										<tbody>
																											
																											@foreach($value['practice'] as $pk => $pv)
																											<?php
																																				//pr($value['practice']);
																											if($pv['practice_no']==0){
																												$practice_sorting = $pv['practice_no'];
																											} else {
																												$practice_sorting = $pv['practice_no']-1;
																											}
																											?>
																											<tr>
																												<th scope="row">{{   $azRange[$practice_sorting]}}</th>
																												<td>{{$pv['marks_gained']}}</td>
																												<td>{{$pv['original_marks']}}</td>
																												<td>  
																													
																													<a href="javascript:void(0)" class="open_practice_preview_modal" data-practiceno="{{$azRange[$practice_sorting]}}" data-topicno="{{$value['topic_no']}}" data-taskno="{{$value['task_no']}}" data-topicid="{{$value['topic_id']}}"  data-practiceid="{{$pv['practice_id']}}" data-taskid="{{$value['task_id']}}"  data-original-marks="{{$pv['original_marks']}}" data-marks-gained="{{$pv['marks_gained']}}"
																													data-teacher-comment="{{isset($value['teacher_comment'])?$value['teacher_comment']:''}}"  
																													data-teacher-audio="{{isset($value['teacher_audio'])?$value['teacher_audio']:''}}"  
																													data-teacher-emoji="{{isset($value['teacher_emoji'])?$value['teacher_emoji']:''}}">
																													<img src="{{asset('public/images/icon-small-eye.svg')}}" alt=""   class="img-fluid">
																												</a>
																											</td>
																										</tr>
																										@endforeach
																									</tbody>
																								</table>
																							</div>
																						</div>
																					</td>
																				</tr>
																				@endif
																				<tr></tr>
																				<?php $i++; ?>
																				@endforeach
																			</tbody>
																		</table>

																	</div>
																	@endforeach
																	@endif

																</div>
															</div>
														</div>

														<!-- /. tab content-->
													</div>
												</div>
											</div>
										</section>
									</div>
								</div>
							</main>

							<div class="modal fade add-summary-modal" id="practicePreviewModal" tabindex="-1" role="dialog" aria-labelledby="practicePreviewModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-xl">
									<div class="modal-content" style="height:800px !important;">
										<div class="modal-header align-items-center">
											<div class="row w-100 wr_review_modal">
												<div class="col-md-4">
													<h4 class="popup_title_wr">Task Review</h4>
												</div>
												<div class="col-md-4 text-center">
													<div class="modal-topic"> <span class="m__topic"></span> <span class="m__task">Task 5</span> <span class="m__category">A</span> </div>
												</div>
												<div class="col-md-4">
													<div class="wr_modal_marks_gain">
														<p>Marks: <span class="m__marks">0/0</span></p>
													</div>
												</div>
											</div>
											<button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
										</div>
										<div class="modal-body append_practice_preview" style="min-height:350px !important;"></div>
										<div class="modal-footer">
											<div class="row w-100">

												<div class="col-md-7" id="parent_audio_hide"> 
													<span class="wr_modal_footer_title">Teacher's Audio Comment : </span> 
													<span>
														<audio id="practice_audio_popup_parent" preload="auto" class="practice_audio_popup_parent audioplayer" src=""  ></audio>
													</span> 
												</div>

												<div class="col-md-5 wr_modal_review_icon" id="wr_modal_review_icon" style="display: flex;"> <span class="wr_modal_footer_title">Teacher Review : </span> 
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

											</div>
											<div class="row w-100" id="comments">
												<div class="col-md-12"> <span class="wr_modal_footer_title">Teacher's Comments : </span> </div>
												<div class="col-md-12"> <span class="wr_modal_footer_data">Remarks or comments added by teacher.</span> </div>
												
											</div>
										</div>

									</div>
								</div>
							</div>
							<aside class="filter-sidebar">
								<div class="heading d-flex flex-wrap justify-content-between">
									<a href="javascript:void(0)" class="close-filter">
										<img src="{{ asset('public/images/icon-close-filter.svg')}}" alt="" class="img-fluid">
									</a>
									<h5>Filter</h5>
								</div>
								<!-- /. Filter Heading-->
								<div class="filter-body" style="overflow-y: scroll;height: 700px;">
									<div class="filter-badges">

									</div>

									<div class="filter-accordion">
										<div class="accordion" id="accordionExample">

											@if(!empty($all_topics))
											<div class="card">
												<div class="card-header" id="headingOne">
													<h2 class="mb-0">
														<button class="btn btn-link" type="button" data-toggle="collapse"
														data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
														Topic
													</button>
												</h2>
											</div>

											<div id="collapseOne" class="collapse" aria-labelledby="headingOne"
											data-parent="#accordionExample">

											<div class="card-body">
												<div class="custom-control custom-radio  mb-3" >
													<input type="radio" class="custom-control-input filterWorkRecordTopic" data-filter="0" id="topic0"
													name="radio-stacked1" required>
													<label class="custom-control-label" for="topic0">All</label>
												</div>
												@foreach($all_topics as $topic_key => $topic_val)
												<div class="custom-control custom-radio  mb-3" >
													<input type="radio" class="custom-control-input filterWorkRecordTopic" data-filter="{{$topic_val}}" id="topic_{{$topic_key}}"
													name="radio-stacked1" required>
													<label class="custom-control-label" for="topic_{{$topic_key}}">Topic {{$topic_val}}</label>
												</div>
												@endforeach

											</div>
										</div>
									</div>
									@endif
									@if(!empty($all_tasks))
									<div class="card">
										<div class="card-header" id="headingTwo">
											<h2 class="mb-0">
												<button class="btn btn-link collapsed" type="button" data-toggle="collapse"
												data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
												Task
											</button>
										</h2>
									</div>
									<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
									data-parent="#accordionExample">
									<div class="card-body">
										<div class="custom-control custom-radio  mb-3" >
											<input type="radio" class="custom-control-input filterWorkRecordTask" data-filter="0" id="task0"
											name="radio-stacked2" required>
											<label class="custom-control-label" for="task0">All</label>
										</div>
										@foreach($all_tasks as $task_key => $task_val)
										<div class="custom-control custom-radio mb-3" >
											<input type="radio" class="custom-control-input filterWorkRecordTask" data-filter="{{$task_val}}"id="task_{{$task_key}}"
											name="radio-stacked2" required>
											<label class="custom-control-label" for="task_{{$task_key}}">Task {{$task_val}}</label>
										</div>
										@endforeach
									</div>
								</div>
							</div>
							@endif
							@if(!empty($skills))
									<!-- <div class="card">
											<div class="card-header" id="headingThree">
													<h2 class="mb-0">
															<button class="btn btn-link collapsed" type="button" data-toggle="collapse"
																	data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
																	Skill
															</button>
													</h2>
											</div>
											<div id="collapseThree" class="collapse" aria-labelledby="headingThree"
													data-parent="#accordionExample">
													<div class="card-body">
														<div class="custom-control custom-radio  mb-3" >
																<input type="radio" class="custom-control-input filterWorkRecordTask" data-filter="0" id="skill0"
																		name="radio-stacked" required>
																<label class="custom-control-label" for="skill0">All</label>
														</div>
														@foreach($skills as $skill_key => $skill_val)
															<div class="custom-control custom-radio mb-3" >
																	<input type="radio" class="custom-control-input filterWorkRecordTask" data-filter="{{$skill_val['title']}}"id="task_{{$skill_key}}"
																			name="radio-stacked" required>
																	<label class="custom-control-label" for="task_{{$skill_key}}">{{$skill_val['title']}}</label>
															</div>
														@endforeach
													</div>
											</div>
										</div> -->
										@endif
										<!-- Start - Teacher  Review -->
										<div class="card">
											<div class="card-header" id="headingFour">
												<h2 class="mb-0">
													<button class="btn btn-link collapsed" type="button" data-toggle="collapse"
													data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
													Teacher Review
												</button>
											</h2>
										</div>
										<div id="collapseFour" class="collapse" aria-labelledby="headingFOur"
										data-parent="#accordionExample">
										<div class="card-body">
											<div class="row">
												<div class="col-6">
													<div class="custom-control custom-radio">
														<input type="radio" class="custom-control-input filterWorkRecordTeacherReview" data-filter="0" id="teacher_review"
														name="radio-stacked3" required>
														<label class="custom-control-label" for="teacher_review">
														All</label>
													</div>

													<div class="custom-control custom-radio">
														<input type="radio" class="custom-control-input filterWorkRecordTeacherReview" data-filter="4" data-emoji="icon-emoji-red.svg" id="tacher_review1"
														name="radio-stacked3" required>
														<label class="custom-control-label" for="tacher_review1">
															<img src="{{ asset('public/images/icon-emoji-red.svg')}}" alt="">
														</label>
													</div>
													<div class="custom-control custom-radio">
														<input type="radio" class="custom-control-input filterWorkRecordTeacherReview" data-filter="3" data-emoji="icon-emoji-orange.svg" id="tacher_review3"
														name="radio-stacked3" required>
														<label class="custom-control-label" for="tacher_review3">
															<img src="{{ asset('public/images/icon-emoji-orange.svg')}}" alt="">
														</label>
													</div>
													<div class="custom-control custom-radio">
														<input type="radio" class="custom-control-input filterWorkRecordTeacherReview" data-filter="2" data-emoji="icon-emoji-yellow.svg" id="tacher_review4"
														name="radio-stacked3" required>
														<label class="custom-control-label" for="tacher_review4">
															<img src="{{ asset('public/images/icon-emoji-yellow.svg')}}" alt="">
														</label>
													</div>
													<div class="custom-control custom-radio">
														<input type="radio" class="custom-control-input filterWorkRecordTeacherReview" data-filter="1" data-emoji="icon-emoji-green.svg" id="tacher_review2"
														name="radio-stacked3" required>
														<label class="custom-control-label" for="tacher_review2">
															<img src="{{ asset('public/images/icon-emoji-green.svg')}}" alt="">
														</label>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- Start - My Review -->
								<div class="card">
									<div class="card-header" id="headingFive">
										<h2 class="mb-0">
											<button class="btn btn-link collapsed" type="button" data-toggle="collapse"
											data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
											My Review
										</button>
									</h2>
								</div>
								<div id="collapseFive" class="collapse" aria-labelledby="headingFive"
								data-parent="#accordionExample">
								<div class="card-body">
									<div class="row">
										<div class="col-6">
											<div class="custom-control custom-radio">
												<input type="radio" class="custom-control-input filterWorkRecordMyReview" data-filter="0" id="myreview"
												name="radio-stacked4" required>
												<label class="custom-control-label" for="myreview">
												All</label>
											</div>

											<div class="custom-control custom-radio">
												<input type="radio" class="custom-control-input filterWorkRecordMyReview" data-filter="4" data-emoji="icon-emoji-red.svg" id="myreview1"
												name="radio-stacked4" required>
												<label class="custom-control-label" for="myreview1">
													<img src="{{ asset('public/images/icon-emoji-red.svg')}}" alt="">
												</label>
											</div>
											<div class="custom-control custom-radio">
												<input type="radio" class="custom-control-input filterWorkRecordMyReview" data-filter="3" data-emoji="icon-emoji-orange.svg" id="myreview3"
												name="radio-stacked4" required>
												<label class="custom-control-label" for="myreview3">
													<img src="{{ asset('public/images/icon-emoji-orange.svg')}}" alt="">
												</label>
											</div>
											<div class="custom-control custom-radio">
												<input type="radio" class="custom-control-input filterWorkRecordMyReview" data-filter="2" data-emoji="icon-emoji-yellow.svg" id="myreview4"
												name="radio-stacked4" required>
												<label class="custom-control-label" for="myreview4">
													<img src="{{ asset('public/images/icon-emoji-yellow.svg')}}" alt="">
												</label>
											</div>
											<div class="custom-control custom-radio">
												<input type="radio" class="custom-control-input filterWorkRecordMyReview" data-filter="1" data-emoji="icon-emoji-green.svg" id="myreview2"
												name="radio-stacked4" required>
												<label class="custom-control-label" for="myreview2">
													<img src="{{ asset('public/images/icon-emoji-green.svg')}}" alt="">
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</aside>
		<div class="modal fade add-summary-modal" id="addFeedbackModal" tabindex="-1" role="dialog"
		aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header align-items-center">
					<div class="modal-topic">
						<span class="m__topic">Topic 1</span>
						<span class="m__task">Task 5</span>
					</div>
					<button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form class="taskFeedbackForm">
					<input type="hidden" name="topicid" class="feedbacktopicid">
					<input type="hidden" name="taskid"  class="feedbacktaskid">

					<div class="modal-body">
						<div class="my-review d-flex flex-wrap align-items-center">
							<h3>My Review :</h3>

							<div class="form-check my-review-green form-check-inline">
								<input class="form-check-input removechecked" type="radio" name="task_emoji" id="inlineRadio4"
								value="1">
								<label class="form-check-label" for="inlineRadio4">

								</label>
							</div>
							<div class="form-check my-review-yellow form-check-inline">
								<input class="form-check-input removechecked" type="radio" name="task_emoji" id="inlineRadio3"
								value="2">
								<label class="form-check-label" for="inlineRadio3">

								</label>
							</div>
							<div class="form-check my-review-orange form-check-inline">
								<input class="form-check-input removechecked" type="radio" name="task_emoji" id="inlineRadio2"
								value="3">
								<label class="form-check-label" for="inlineRadio2">

								</label>
							</div>
							<div class="form-check my-review-red form-check-inline">
								<input class="form-check-input removechecked" type="radio" name="task_emoji" id="inlineRadio1"
								value="4">
								<label class="form-check-label" for="inlineRadio1">

								</label>
							</div>
						</div>

						<h3>My Comments :</h3>
						<div class="form-group">
							<textarea name="task_comment" id="task_comment" class="form-control" value=""></textarea>
						</div>
					</div>
					<div class="modal-footer justify-content-center">
						<div class="alert alert-success" role="alert" style="display:none"></div>
						<div class="alert alert-danger" role="alert" style="display:none"></div>
						<button type="button" class="btn  btn-primary btnSaveFeedback">
							<span><img src="{{asset('public/images/icon-btn-save.svg')}}" alt="" class="img-fluid"></span>
							Save
						</button>
						<button type="button" class="btn  btn-primary" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>


	<script>
		var topicurl = "{{ url('/topic-iframe/') }}";
		
		$(document).on("click",".hidden-tr-opner", function () { 
			$(this).toggleClass("open");
			$(this).parent().parent().next().show().find('tr').show()
			$(this).parent().parent().next().show().find(".hidden-tr").slideToggle("slow");
		});

		$(document).on("click",".close-filter", function () {
			$(".filter-sidebar").toggleClass("openclose");
		});

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
			$('.open_practice_preview_modal').on('click', function(){
				$('#practicePreviewModal').modal('toggle');
				var teacher_comment     = $(this).attr("data-teacher-comment");
				var teacher_emoji       = $(this).attr("data-teacher-emoji");
				var original_marksd     = $(this).attr("data-original-marks");
				var marks_gained        = $(this).attr("data-marks-gained");
				var audio               = $(this).attr("data-teacher-audio");

				var topic_id    = $(this).attr("data-topicid");
				var practice_id = $(this).attr("data-practiceid");
				var topicno     = $(this).attr("data-topicno");
				var taskno      = $(this).attr("data-taskno");
				var practiceno  = $(this).attr("data-practiceno");
				var marks       = $(this).attr("data-marks");
				
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
				
				if(teacher_emoji == 1){
					$('.green2').css("display","inline-block");
					$('.green1').css("display","none");
				}else if(teacher_emoji == 2){
					$('.yellow2').css("display","inline-block");
					$('.yellow1').css("display","none");
				}else if(teacher_emoji == 3){
					
					$('.orange2').css("display","inline-block");
					$('.orange1').css("display","none");

				}else if(teacher_emoji == 4){


					$('.red2').css("display","inline-block");
					$('.red1').css("display","none");
				}
				// alert(teacher_emoji);
				if(teacher_emoji !="0"){
					$('#wr_modal_review_icon').css("display","flex");
				}else{
					$('#wr_modal_review_icon').css("display","none");
				}

				if(audio!=""){
					$('#practice_audio_popup').attr("src",audio);
					changeAudio(audio);
					Audioplay();
					$('#parent_audio_hide').fadeIn();
				}else{
					$('#parent_audio_hide').fadeOut();
				}

				$('#practicePreviewModal').find('.m__topic').html('Topic '+ topicno);
				$('#practicePreviewModal').find('.m__task').html('Task '+ taskno);
				$('#practicePreviewModal').find('.m__category').html(practiceno)
				$('#practicePreviewModal').find('.m__marks').html(marks_gained+"/"+original_marksd);
				// alert(teacher_comment);
				if(teacher_comment == ""){
					$('#comments').fadeOut();
				}else{
					$('#comments').fadeIn();
				}
				$('#practicePreviewModal').find('.wr_modal_footer_data').html(teacher_comment);
				
				var task_id = $(this).attr("data-taskid");
				var url = topicurl+'/'+topic_id+"/"+task_id+"/"+practice_id; 
				$('.append_practice_preview').html('<iframe frameborder="0" style="overflow: hidden; height: 100%; width: 100%;" src="'+url+'" />')
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

			$('.open-add-feedback-modal').on('click', function() {

				$('.removechecked').prop("checked",false);

				$('#addFeedbackModal').modal('toggle');
				var task_comment    = $(this).attr("data-taskcomment");
				var task_emoji      = $(this).attr("data-taskemoji");

				var topic_id        = $(this).attr("data-topicid");
				var practice_id     = $(this).attr("data-practiceid");
				var task_id         = $(this).attr("data-taskid");
				var topicno         = $(this).attr("data-topicno");
				var taskno          = $(this).attr("data-taskno");
				var practiceno      = $(this).attr("data-practiceno");
				$('#addFeedbackModal').find('.m__topic').html('Topic '+ topicno);
				$('#addFeedbackModal').find('.feedbacktopicid').val(topic_id);
				$('#addFeedbackModal').find('.feedbacktaskid').val(task_id);
				$('#addFeedbackModal').find('.m__task').html('Task '+ taskno);
				$('#addFeedbackModal').find('.m__category').html(practiceno);
				$('#addFeedbackModal').find('#task_comment').val("");
				$('#addFeedbackModal').find('#task_comment').val(task_comment);
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
				$('#inlineRadio'+final).prop("checked",true)
				

				var task_id = $(this).attr("data-taskid");
			});

			$('.btnSaveFeedback').on('click', function(){
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
			var removeFlag = false;
			var topicArray               = [];
			var TaskArrayNew             = [];
			var myReviewArrayNew         = [];
			var teacherReviewArrayNew    = [];
			var searachArrayNew          = [];

			$('.filterWorkRecordTopic').on('click', function(e) {
				topicArray = [];
				removeFlag = false;
				$('.filterWorkRecordTopic').removeClass('active-topic');
				$(this).addClass('active-topic');
				var topic = $(this).attr('data-filter');
				var task = $('.active-task').attr('data-filter');
				var myreview = $('.active-myreview').attr('data-filter');
				var teacherreview = $('.active-teacherreview').attr('data-filter');
				var skills = "";
				
				topicArray.push('.topic'+topic);
				if(topic ==0){
					topicArray = [];
				}
				filterRecord(topic, task, myreview, teacherreview, skills)
			});

			$('.filterWorkRecordTask').on('click', function(e) {
				TaskArrayNew = [];
				removeFlag = false;
				$('.filterWorkRecordTask').removeClass('active-task');
				$(this).addClass('active-task');
				var task = $(this).attr('data-filter');
				var topic = $('.active-topic').attr('data-filter');
				var myreview = $('.active-myreview').attr('data-filter');
				var teacherreview = $('.active-teacherreview').attr('data-filter');
		var skills ="";//  $('.active-teacherreview').attr('data-filter');


		TaskArrayNew.push('.task'+task);
		if(task ==0){
			TaskArrayNew = [];
		}
		filterRecord(topic, task, myreview, teacherreview, skills)
	});

			$('.filterWorkRecordSkills').on('click', function(e) {
				
				$('.filterWorkRecordSkills').removeClass('active-skills');
				$(this).addClass('active-task');
		var skills = "";// $(this).attr('data-filter');
		var task = $('.active-topic').attr('data-filter');
		var topic = $('.active-topic').attr('data-filter');
		var myreview = $('.active-myreview').attr('data-filter');
		var teacherreview = $('.active-teacherreview').attr('data-filter');
		filterRecord(topic, task, myreview, teacherreview, skills)
	});

			$('.filterWorkRecordMyReview').on('click', function(e) {
				myReviewArrayNew = [];
				removeFlag = false;
				$('.filterWorkRecordMyReview').removeClass('active-myreview');
				$(this).addClass('active-myreview');
				var topic = $('.active-topic').attr('data-filter');
				var task = $('.active-task').attr('data-filter');
				var myreview = $(this).attr('data-filter');
				var teacherreview = $('.active-teacherreview').attr('data-filter');
		var skills = "";// $('.active-teacherreview').attr('data-filter');
		myReviewArrayNew.push('.myreview'+myreview);
		if(myreview ==0){
			myReviewArrayNew = [];
		}


		filterRecord(topic, task, myreview, teacherreview, skills)
	});
			
			$('.filterWorkRecordTeacherReview').on('click', function(e) {
				teacherReviewArrayNew = [];
				removeFlag = false;
				$('.filterWorkRecordTeacherReview').removeClass('active-teacherreview');
				$(this).addClass('active-teacherreview');
				var topic = $('.active-topic').attr('data-filter');
				var task = $('.active-task').attr('data-filter');
				var myreview = $('.active-myreview').attr('data-filter');
				var teacherreview = $(this).attr('data-filter');
		var skills ="";//  $('.active-teacherreview').attr('data-filter');

		teacherReviewArrayNew.push('.teacherreview'+teacherreview);
		if(teacherreview ==0){
			teacherReviewArrayNew = [];
		}


		filterRecord(topic, task, myreview, teacherreview, skills)
	});

			$('.search_work_record').click(function(){
		// alert($(this).val())
		// alert("asdasd");
		
		// if($(this).val()==""){

		//     searachArrayNew = [];
		//     topic = "";
		//     task = "";
		//     myreview = "";
		//     teacherreview = "";
		//     skills = "";
		//     filterRecord(topic, task, myreview, teacherreview, skills);
		// }
	});
			$('.search_work_record').on('keyup', function(){
				searachArrayNew = [];
				var  parent = $('.checkparent.active').attr("id");
				if(parent=="pills-home-tab"){
					parentId = "pills-home";
				}else{
					parentId = "pills-profile";
				}
				var search_keyword =$.trim($(this).val()) ;
				if(search_keyword == ""){
					searachArrayNew = [];
				}
				if(search_keyword !=""){
					var serachData = search_keyword.replace(' ','');
					var serachData = serachData.toLowerCase();
					searachArrayNew.push('.'+serachData);
					if(serachData == ""){
						searachArrayNew = [];
					}
				}
				topic = "";
				task = "";
				myreview = "";
				teacherreview = "";
				skills = "";
				filterRecord(topic, task, myreview, teacherreview, skills);
			});
			$(document).on('click','.clear_search', function(){
				
				var parent_class = $('.tab-pane.active').find('tbody').attr('class');
				$('.'+parent_class+' tr').show();
			});
			var trclass=[]
			var category_data = "";
			
			$(document).on('click','.remove_filter', function() {
				removeFlag = true;
				category_data = $(this).attr('data-category');
				var section = $(this).attr('data-section');
		// alert(category_data)
		if(category_data == "filterWorkRecordTopic" ){
			topicArray = [];
			$('.filterWorkRecordTopic').each(function(){
				$(this).removeClass('active-topic')
			});
		}else if(category_data == "filterWorkRecordTask" ){
			TaskArrayNew  = [];
			$('.filterWorkRecordTask').each(function(){
				$(this).removeClass('active-task')
			});
		}else if(category_data == "filterWorkRecordTeacherReview" ){
			$('.filterWorkRecordTeacherReview').each(function(){
				$(this).removeClass('active-teacherreview')
			});
			teacherReviewArrayNew  = [];
		}else if(category_data == "filterWorkRecordMyReview" ){
			myReviewArrayNew  = [];
			$('.filterWorkRecordMyReview').each(function(){
				$(this).removeClass('active-myreview')
			});
		}
		//  $('.'+category_data+':first').click();
		// alert(category_data)
		$('.'+category_data).prop('checked', false);
		$(this).parent().parent().remove();
		$(this).closest(".badge-secondary").remove()
		var val = $(this).attr('data-val');
		var index = trclass.indexOf('.'+section+val);
		if(index!=-1){
			trclass.splice(index, 1);
		}
		if(trclass.length>0){
			var parent_class = $('.tab-pane.active').find('tbody').attr('class');
			$('.'+parent_class+' tr').hide();
			tr_class_string = trclass.join().replace(',','');
				//console.log('tr_class_string',tr_class_string)
				$('.'+parent_class).find(tr_class_string).show();
			} else {
				$('.'+parent_class+' tr').show();
			}

			// $(this).addClass('active-teacherreview');
			var topic         = $('.active-topic').attr('data-filter');
			var task          = $('.active-task').attr('data-filter');
			var myreview      = $('.active-myreview').attr('data-filter');
			var teacherreview = $('.active-teacherreview').attr('data-filter');
			var skills        = "";//  $('.active-teacherreview').attr('data-filter');
			$(this).remove();
			// return false;
			filterRecord(topic, task, myreview, teacherreview, skills)


		})


			$('.checkparent').click(function(){
				var  parent = $('.checkparent.active').attr("id");
				if(parent=="pills-home-tab"){
					parentId = "pills-home";
				}else{
					parentId = "pills-profile";
				}


				var search_keyword =$.trim($(this).val()) ;
				var parent_class = $('.tab-pane.active').find('tbody').attr('class');
				var parent_class = $('#'+parentId+' #myTabinnerContent .tab-pane.active').find('tbody').attr('class');

				$('#'+parentId+' .'+parent_class+' tr').show();
				var trclass=[]
			});
			$('.clicking').click(function(){

				var  parent = $('.checkparent.active').attr("id");
				if(parent=="pills-home-tab"){
					parentId = "pills-home";
				}else{
					parentId = "pills-profile";
				}


				var search_keyword =$.trim($(this).val()) ;
				var parent_class = $('.tab-pane.active').find('tbody').attr('class');
				var parent_class = $('#'+parentId+' #myTabinnerContent .tab-pane.active').find('tbody').attr('class');


				$('#'+parentId+' .'+parent_class+' tr').show();
				var trclass=[]
				
				$('.filterWorkRecordTeacherReview').removeClass('active-teacherreview');
				$(this).addClass('active-teacherreview');
				var topic = $('.active-topic').attr('data-filter');
				var task = $('.active-task').attr('data-filter');
				var myreview = $('.active-myreview').attr('data-filter');
				var teacherreview = $(this).attr('data-filter');
			var skills ="";//  $('.active-teacherreview').attr('data-filter');
			// alert(topic);
			// alert(task);
			// alert(myreview);
			// alert(teacherreview);
			// alert(skills);
			filterRecord(topic, task, myreview, teacherreview, skills)

		});

/*  function filterdata(parentId,parent_class){

				$('#'+parentId+' .'+parent_class+' tr').hide();
				var tr_class_string_temp = "";
				if (typeof topicArray !== 'undefined' && topicArray.length > 0) {
						tr_class_string_temp += topicArray[0];
				}
				if (typeof TaskArrayNew !== 'undefined' && TaskArrayNew.length > 0) {
						tr_class_string_temp += TaskArrayNew[0];
				}
				if (typeof myReviewArrayNew !== 'undefined' && myReviewArrayNew.length > 0) {
						tr_class_string_temp += myReviewArrayNew[0];
				}
				if (typeof teacherReviewArrayNew !== 'undefined' && teacherReviewArrayNew.length > 0) {
						tr_class_string_temp += teacherReviewArrayNew[0];
				}
				if (typeof searachArrayNew !== 'undefined' && searachArrayNew.length > 0) {
						tr_class_string_temp += searachArrayNew[0];
				}

				if(tr_class_string_temp==""){
						$('#'+parentId+' .'+parent_class+' tr').fadeIn();
				}else{
				 
				}
				 // alert(('#'+parentId+' .'+parent_class+' '+tr_class_string_temp));
				$('#'+parentId+' .'+parent_class+' '+tr_class_string_temp).fadeIn();
			}*/

			function filterRecord(topic, task, myreview, teacherreview, skills){
		 /* alert(topic)
			alert(task)
			alert(teacherreview)*/
			// alert(myreview)
			if(!removeFlag){


				if(topic>0) {
					$('.topic-filter').remove();
					$('.filter-badges').append(`<span class="badge badge-secondary mr-2 topic-filter">
						Topic `+topic+`
						<span><img src="{{ asset('public/images/icon-badge-close.svg')}}" alt="" class="img-fluid remove_filter" data-val="`+topic+`" data-section="topic" data-category="filterWorkRecordTopic"></span>
						</span>`);
				}else{
					$('.topic-filter').remove();
				}

				if(task > 0 ){

					$('.task-filter').remove();
					$('.filter-badges').append(`<span class="badge badge-secondary mr-2 task-filter">
						Task `+task+`
						<span><img src="{{ asset('public/images/icon-badge-close.svg')}}" alt="" class="img-fluid remove_filter" data-val="`+task+`" data-section="task"  data-category="filterWorkRecordTask"></span>
						</span>`);

				}else{
					$('.task-filter').remove();
				}
				 /* alert(teacherreview)
				 alert(myreview)*/
				 if(teacherreview>0){

				 	$('.teacherreview-filter').remove();
				 	var teacherreview_emoji =  $('.active-teacherreview').attr('data-emoji');
				 	var emojinumber =  $('.active-teacherreview').attr('data-filter');
				 	var teacherreview_emoji_path = "{{ asset('public/images/')}}";
				 	$('.filter-badges').append(`<span class="badge badge-secondary mr-2 teacherreview-filter">
				 		Teacher Review: <img src="`+teacherreview_emoji_path+`/`+teacherreview_emoji+`" alt=""/>
				 		<span><img src="{{ asset('public/images/icon-badge-close.svg')}}" alt="" class="img-fluid remove_filter" data-val="`+emojinumber+`" data-section="teacherreview" data-category="filterWorkRecordTeacherReview"></span>
				 		</span>`);
				 }else{
				 	$('.teacherreview-filter').remove();
				 }
				 if(myreview>0){

				 	$('.myreview-filter').remove();
				 	var myreview_emoji =  $('.active-myreview').attr('data-emoji');
				 	var emojinumber =  $('.active-myreview').attr('data-filter');
				 	var myreview_emoji_path = "{{ asset('public/images/')}}";
				 	$('.filter-badges').append(`<span class="badge badge-secondary mr-2 myreview-filter">
				 		My Review: <img src="`+myreview_emoji_path+`/`+myreview_emoji+`" alt=""/>
				 		<span><img src="{{ asset('public/images/icon-badge-close.svg')}}" alt="" class="img-fluid remove_filter" data-val="`+emojinumber+`" data-section="myreview" data-category="filterWorkRecordMyReview"></span>
				 		</span>`);
				 }else{
				 	$('.myreview-filter').remove();
				 }
				}
				



				var     parent_class = $('#pills-home .tab-pane').find('tbody').attr('class');
				var     parent = $('.checkparent.active').attr("id");
				if(parent=="pills-home-tab"){
					parentId = "pills-home";
				}else{
					parentId = "pills-profile";
				}
				var parent_class = $('#'+parentId+' #myTabinnerContent .tab-pane.active').find('tbody').attr('class');
				$('#'+parentId+' .'+parent_class+' tr').hide();


				$('#'+parentId+' .'+parent_class+' tr').hide();
				var tr_class_string_temp = "";
				if (typeof topicArray !== 'undefined' && topicArray.length > 0) {
					tr_class_string_temp += topicArray[0];
				}
				if (typeof TaskArrayNew !== 'undefined' && TaskArrayNew.length > 0) {
					tr_class_string_temp += TaskArrayNew[0];
				}
				if (typeof myReviewArrayNew !== 'undefined' && myReviewArrayNew.length > 0) {
					tr_class_string_temp += myReviewArrayNew[0];
				}
				if (typeof teacherReviewArrayNew !== 'undefined' && teacherReviewArrayNew.length > 0) {
					tr_class_string_temp += teacherReviewArrayNew[0];
				}
				if (typeof searachArrayNew !== 'undefined' && searachArrayNew.length > 0) {
					tr_class_string_temp += searachArrayNew[0];
				}

				if(tr_class_string_temp==""){
					$('#'+parentId+' .'+parent_class+' tr').fadeIn();
				}else{
					
				}
				 // alert(('#'+parentId+' .'+parent_class+' '+tr_class_string_temp));
				 $('#'+parentId+' .'+parent_class+' '+tr_class_string_temp).fadeIn();

				// filterdata(parentId,parent_class);
			}
		</script>
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
		</style>
		@endsection