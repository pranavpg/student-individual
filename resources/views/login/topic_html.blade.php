 <style type="text/css">
 /********************* Lock Topic Css *********************/
 .topic-image-slider.locked-topic{
 	position: relative;
 }
 .lock-append-div{
 	position: absolute;
 	top: 0;
 	height: calc(100% - 1rem);
 	width: calc(100% - 1rem);
 	background: #404040c4;
 	padding: .5rem;
 	z-index: 10;
 	margin-top: .5rem;
 	border-radius: 3px;
 }
 .lock-append-div img{
 	max-width: 62px;
 }
</style>
<div class="tab-pane fade " id="pills-" role="tabpanel" aria-labelledby="pills-tab" style="opacity: 1;display: block;">
	@if($expire_flag == "false")
		<div class="tab-data col-sm-12">
			<div class="row">
				<div class="tab-data__heading col-sm-12 d-flex flex-wrap align-items-center">
					<div class="topic-dropdown col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3 pl-0">
						<select id="optionchange" class="form-control dropdown border optionchange" >
							<!-- <option>Select Course</option> -->
							@foreach($onlyCourse as $i=>$course)
								<?php  $disable = !$course['is_expired']?"false":"true";?>
								<option {{ $coursid == $course['course_id']?'selected':'' }} value="{{$course['course_id']}}" index-value="{{$i}}" level="{{$course['level_id']}}" class="{{ $disable }}">{{$course['coursetitle']}}</option>
							@endforeach
						</select>
					</div>
					<div class="topic-dropdown col-6 col-sm-6 col-md-5 col-lg-5 col-xl-3 pr-0 pr-0">
						<select id="topic_dropdown" class="form-control dropdown border">
							<option disabled selected hidden>Select Topic</option>
							@foreach($topics['student_courses'] as $s=>$topic)  
								<option value="<?php echo URL('/topic/'.$topic['_id']);?>">Topic {{isset($topic['sorting'])?$topic['sorting']:''}} : {{$topic['topicname']}}</option>
							@endforeach
						</select>
					</div>
					<div class="tab-data__heading_right col-12 col-sm-12 col-md-3 col-lg-3 col-xl-6 text-right pr-0 pt-md-0 pt-sm-3">
						<?php 
							$lastUrl1='';
							if(isset($sessionAll['lastTask1'])){
								$lastUrl1 = $sessionAll['lastTask1'];
							} ?>
							<a href="{{Session::get('lastTask1')}}" class="btn btn-primary  btn-icon">
							<img src="{{ asset('public/images/icon-button-topic.svg') }}" alt="" class="img-fluid">
							{{Session::get('lastTaskName') ? Session::get('lastTaskName') : 'Resume Task' }}
						</a>
					</div>
				</div>
				<div class="tab-data__slider col-sm-12">
					<div class="row">
						<div class="topic-carousel owl-carousel owl-theme">
							<?php foreach($topics['student_courses'] as $s=>$topic){ ?>
								<div class="item mb-3">
									<div class="card topic-image-slider {{($topics['payment_status'] !== 'paid' && (int)$topic['sorting'] > 2)?'locked-topic':''}}" data-topic="Topic {{isset($topic['sorting'])?$topic['sorting']:''}}">
										<a href="<?php echo URL('/topic/');?>/{{ $topic['_id'] }}" class="loader-needed">
											<img src="{{env('S3URL')}}{{isset($topic['image'])?$topic['image']:''}}" class="card-img-top" alt="...">
											<div class="card-body d-flex flex-wrap align-items-center">
												<div class="row m-0 w-100">
													<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
														<span class="topic_title">Topic {{isset($topic['sorting'])?$topic['sorting']:''}}</span>
													</div>
													<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 p-0" style="display: none;">
														<div class="progress topic_progress">
															<div class="progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width:10%;"></div>
														</div>
													</div>
												</div>
											</div>
										</a>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	@else
		<div class="topic-dropdown col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 pl-0 pr-0 mb-3">
			<select id="optionchange" class="form-control dropdown border optionchange" >
				<!-- <option>Select Course</option> -->
				<?php 
					$date = "";
				?>
				@foreach($onlyCourse as $i=>$course)
					<?php
						if($coursid == $course['course_id']){
							$date = $course['course_end_date'];
						}  
						$disable = !$course['is_expired']?"false":"true";
					?>
					<option {{ $coursid == $course['course_id']?'selected':'' }} value="{{$course['course_id']}}" level="{{$course['level_id']}}" class="{{ $disable }}">{{$course['coursetitle']}}</option>
				@endforeach
			</select>
		</div>
		<div class="course-notification row d-flex justify-content-center mt-5">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-md-3 d-xl-none d-lg-block">
				<div class="row">
					<div class="col-3 col-sm-3 col-md-3 col-lg-2 col-xl-1 pt-2 pl-4 d-flex justify-content-center">
						<div class="my-btn">
							<div class="my-btn-border"></div>
							<i class="fas fa-bell btn-bell"></i>
						</div>
					</div>
					<div class="col-9 col-sm-9 col-md-9 col-lg-10 col-xl-11">
						<h1 class="h1-heading">Course<br>Notification </h1>
					</div>
				</div>
			</div>
			<div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-1 d-none d-xl-block">
				<div class="my-btn">
					<div class="my-btn-border"></div>
					<i class="fas fa-bell btn-bell"></i>
				</div>
			</div>
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-11">
				<h1 class="h1-heading d-none d-xl-block">Course Notification</h1>
				<ul class="notification">
					<li>Thank you for choosing to study with us. This course ended {{ $date }}. </li>
					<li>{{ Session::get('franchise_name') }} has 15 days to complete the administrative procedures once all courses on your registered award have ended. E.g. If you are registered on General English Level 1, & Academic English Level 1 your registered award is 'Certificate in English Language'. This award can only be released once both courses are finished. </li>
					<li>You will receive an email once the administrative procedures are completed confirming your pass / fail status on this course and there will be links to download your course data including Certificate, Notes, Summary, Vocabulary, Progress Reports etc.  </li>
					<li>Once you receive this email you will have 10 days to download all the details. Then it will all be deleted. Once deleted this data cannot be retrieved. Note the course content and work record cannot be downloaded. </li>
					<li>If you are not registered on any other courses, you will also no longer be able to access or login on any of the Apps. </li>  
					<li>Our best wishes for the future! </li>
				</ul>
			</div>
		</div>
	@endif
</div>
<script>
	$(document).ready(function(){
		$(".locked-topic").append("<div class='lock-append-div d-flex flex-column align-items-center justify-content-center'><img class='mb-3' src='{{env('S3URL')}}manualsimage/lock-01.png'><a href='{{Url('/purchase_course')}}' class='btn btn-md btn-primary'>Pay To Unlock</a></div>");
	});
</script>