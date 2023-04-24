<?php $markingmethod = isset($practise['markingmethod'])?$practise['markingmethod']:""; ?>
<tr class="hidden-data">
	<td colspan="9" class="hidden-tr p-0">
		<div class="topic-block-marking">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 pra-block">
					<ul class="nav nav-tabs work-record-marking practicebook-work-tab pr-xl-5" role="tablist">
						<li class="nav-item" role="presentation">
							<button class="nav-link active" data-toggle="tab" data-target="#aa" role="tab">
								<img src="{{asset('public/images/practicebook-tab.png')}}" style="width: 25px;">
								<span class="tab-title">Practice Book</span>
							</button>
						</li>
						<li class="nav-item d-lg-block d-xl-none" role="presentation">
							<button class="nav-link" data-toggle="tab" data-target="#aaa" role="tab">
								<img src="{{asset('public/images/marking-tab.png')}}" style="width: 25px;">
								<span class="tab-title">Marking</span>
							</button>
						</li>
					</ul>
					<div class="expand-option-course d-none d-xl-block">
						<ul class="list-inline">
							<li class="">
								<a href="javascript:void(0);" class="expand-collapse-practice"> <img src="{{ url('public/images/icon-fullscreen.svg') }}" alt="edit" class="img-fluid rotate-expand-icon"> </a>
							</li>
						</ul>
					</div>
					<div class="tab-content work-record-tabs pr-work-record-tab pt-0">
						<div class="tab-pane fade show active" id="aa" role="tabpanel">
							<div class="row">
								<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 practice-type">
									@php  $lable2 = $markingmethods;$lable2 = ""; @endphp 	
									@if($markingmethods == "read_only")
										@php  $lable3 = "readonly"; $lable2 = "Participation Mark"; @endphp 	
									@elseif($markingmethods == "automated")
										@php  $lable3 = "readonly"; $lable2 = "Auto Mark"; @endphp 	
									@elseif($markingmethods == "no_marking")
										@php  $lable3 = "readonly"; $lable2 = "No Mark"; @endphp 	
									@elseif($markingmethods == "student_self_marking")
										@php  $lable3 = ""; $lable2 = "Class Mark"; @endphp 
									@elseif($markingmethods == "manual")
										@php  $lable3 = ""; $lable2 = "Teacher Mark"; @endphp 	
									@elseif($markingmethods == "self")
										@php  $lable3 = ""; $lable2 = "Self Mark"; @endphp 	
									@endif
									<h5><span>Practice type : {{ ucfirst($lable2) }}</span></h5>
								</div>
							</div>
							<div class="practice-book-data">
								<ul class="nav nav-tabs" role="tablist">
									<input type="hidden" name="is_highest" id="is_highest"  value="{{ $tabs['is_highest'] }}">
									<input type="hidden" name="is_second_highest" id="is_second_highest"  value="{{ $tabs['is_second_highest'] }}">
									<input type="hidden" name="is_latest" id="is_latest"  value="{{ $tabs['is_latest'] }}">

									@if($flag_for_tab == 1)
										<li class="nav-item tooltip-custom score " data="3">
											<a class="nav-link active findactive" data="3" data-toggle="tab" href="#3" role="tab">
												<img src="{{asset('public/images/highest-score.png')}}" style="width: 21px;">
												<span class="d-none d-sm-inline-block">Latest Marking</span>
												<span class="tooltiptext-neutral">Latest Marking</span>
											</a>
										</li>
									@else
										@if($tabs['is_highest'])
											<li class="nav-item tooltip-custom score" data="1">
												<a class="nav-link active findactive" data="1" data-toggle="tab" href="#1" role="tab">
													<img src="{{asset('public/images/highest-score.png')}}" style="width: 21px;">
													<span class="d-none d-sm-inline-block">Highest Score</span>
													<span class="tooltiptext-neutral">Highest Score</span>
												</a>
											</li>
										@endif
										@if($tabs['is_second_highest'])
											<li class="nav-item tooltip-custom score" data="2">
												<a class="nav-link findactive" data="2" data-toggle="tab" href="#2" role="tab">
													<img src="{{asset('public/images/second-highest-score.png')}}" style="width: 21px;">
													<span class="d-none d-sm-inline-block">Second Highest Score</span>
													<span class="tooltiptext-neutral">Second Highest Score</span>
												</a>
											</li>
										@endif
										@if($tabs['is_latest'])

											<li class="nav-item tooltip-custom score " data="3">
												<a class="nav-link {{ $tabs['is_highest']?'':'active' }} findactive" data="3" data-toggle="tab" href="#3" role="tab">
													<img src="{{asset('public/images/letest-marking.png')}}" style="width: 21px;">
													<span class="d-none d-sm-inline-block">Latest Marking</span>
													<span class="tooltiptext-neutral">Latest Marking</span>
												</a>
											</li>
										@endif
									@endif
								</ul>
								<div class="course-tab-content practice-tab-content">
									<div class="tab-content border border-top-0 rounded-bottom p-3">
										<div class="tab-pane fade active show tabss" id="1" role="tabpanel">
											
										</div>
										<div class="tab-pane fade tabss" id="2" role="tabpanel">
										
										</div>
										<div class="tab-pane fade tabss" id="3" role="tabpanel">
										
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="aaa" role="tabpanel">
							<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 p-0">
								<ul class="nav nav-tabs work-record-marking teacher-course-tab" role="tablist">
									<li class="nav-item tooltip-custom">
										<button class="nav-link active" data-toggle="tab" data-target="#bb1" role="tab">
											<img src="{{asset('public/images/marking-tab.png')}}" style="width: 25px;">
											<span class="tab-title d-none d-sm-inline-block">Marking</span>
											<span class="tooltiptext-neutral">Marking</span>
										</button>
									</li>
									<li class="nav-item tooltip-custom">
										<button class="nav-link" data-toggle="tab" data-target="#cc1" role="tab">
											<img src="{{asset('public/images/teacherbook-tab.png')}}" style="width: 25px;">
											<span class="tab-title d-none d-sm-inline-block">Teacher Book</span>
											<span class="tooltiptext-neutral">Teacher Book</span>
										</button>
									</li>
									<li class="nav-item tooltip-custom">
										<button class="nav-link" data-toggle="tab" data-target="#dd1" role="tab">
											<img src="{{asset('public/images/coursebook-tab.png')}}" style="width: 25px;">
											<span class="tab-title d-none d-sm-inline-block">Course Book</span>
											<span class="tooltiptext-neutral">Course Book</span>
										</button>
									</li>
								</ul>

								{{-- <div class="tab-content work-record-tabs teacher-course-content">
									<div class="tab-pane fade show active" id="bb1" role="tablist">
										<div class="row marking-data">
											<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
												<div class="row overall-marking-feedback">
													<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
														<h3><i class="fa-solid fa-microphone-lines"></i> Overall Feedback</h3>
													
													</div>
													<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3 review-emojis">
														<h3><i class="fa-solid fa-rss"></i> Overall Task Performance</h3>
														<ul class="list-inline list-rating d-flex flex-wrap justify-content-start">
															<li class="list-inline-item emoji" data="1">
																<a href="javascript:void(0);" class="select_teacher_emoji" data-teacheremoji="1" id="tooltip-veryhappy">
																	<img src="{{asset('public/images/icon-very-happy.svg')}}" alt="" class="active">
																	<img src="{{asset('public/images/icon-very-happy-gray.svg')}}" alt="" class="inactive">
																</a>
															</li>
															<li class="list-inline-item emoji" data="2">
																<a href="javascript:void(0);" class="select_teacher_emoji" data-teacheremoji="2" id="tooltip-happy">
																	<img src="{{asset('public/images/icon-happy.svg')}}" alt="" class="active">
																	<img src="{{asset('public/images/icon-happy-gray.svg')}}" alt="" class="inactive">
																</a>
															</li>
															<li class="list-inline-item emoji"  data="3">
																<a href="javascript:void(0);" class="select_teacher_emoji" data-teacheremoji="4" id="tooltip-neutral">
																	<img src="{{asset('public/images/icon-neutral.svg')}}" alt="" class="active">
																	<img src="{{asset('public/images/icon-neutral-gray.svg')}}" alt="" class="inactive">
																</a>
															</li>
															<li class="list-inline-item emoji"  data="4">
																<a href="javascript:void(0);" class="select_teacher_emoji" data-teacheremoji="3" id="tooltip-sad">
																	<img src="{{asset('public/images/icon-bad.svg')}}" alt="" class="active">
																	<img src="{{asset('public/images/icon-bad-gray.svg')}}" alt="" class="inactive">
																</a>
															</li>
														</ul>
													</div>
													<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
														<h3><i class="fa-regular fa-file-lines"></i> Overall Comment</h3>
														<div class="d-flex flex-wrap align-items-center">
															<div class="form-group">
																<textarea class="form-control comment"  name="" rows="8" cols="100" placeholder="Write here" style="resize: none;"></textarea>
															</div>
														</div>
													</div>
													<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 marks-submit">
														<div class="row">
															<div class="col-7 col-sm-6 col-md-6 col-lg-6 col-xl-6">
																<div class="form-group d-flex pt-1 font-weight-bold">Score :
																	<input type="text" class="form-control input-marks-gained allow_marking text-center font-weight-bold mark" style="width: 42px;padding: 0px 8px;height: auto;" max="1979-12-31" maxlength="2" onkeypress="return /[0-9]/i.test(event.key)" {{ $lable2 }}>
																	<span style="display: block ruby;" class="orignal_mark"> / </span>
																</div>
															</div>
															<div class="col-5 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-right ">
																<a href="javascript:void(0);" class="btn btn-primarysubmit submit-modal-btn">Submit</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="cc1" role="tablist">
										<div class="teacher-book-data"> {!! isset($teacherBook)?$teacherBook:""  !!} </div>
									</div>
									<div class="tab-pane fade" id="dd1" role="tablist">
										<div class="course-book-data">{!!  str_replace("http://ec2-52-15-233-207.us-east-2.compute.amazonaws.com/storage","https://s3.amazonaws.com/imperialenglish.co.uk",$courseBook);!!}</div>
									</div>
								</div> --}}

								<div class="tab-content work-record-tabs teacher-course-content" id="remove2">
									<div class="tab-pane fade show active" id="bb1" role="tablist">
										<div class="row marking-data">
											<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
												<div class="row overall-marking-feedback">
													<!-- <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
														<h3><i class="fa-solid fa-microphone-lines"></i> Overall Feedback</h3>
													</div> -->
													<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3 review-emojis">
														<h3><i class="fa-solid fa-rss"></i> Overall Task Performance</h3>
														<ul class="list-inline list-rating d-flex flex-wrap justify-content-start">
															<li class="list-inline-item emoji" data="1">
																<a href="javascript:void(0);" class="select_teacher_emoji" data-teacheremoji="1" id="tooltip-veryhappy">
																	<img src="{{asset('public/images/icon-very-happy.svg')}}" alt="" class="active">
																	<img src="{{asset('public/images/icon-very-happy-gray.svg')}}" alt="" class="inactive">
																</a>
															</li>

															<li class="list-inline-item emoji" data="2">
																<a href="javascript:void(0);" class="select_teacher_emoji" data-teacheremoji="2" id="tooltip-happy">
																	<img src="{{asset('public/images/icon-happy.svg')}}" alt="" class="active">
																	<img src="{{asset('public/images/icon-happy-gray.svg')}}" alt="" class="inactive">
																</a>
															</li>

															<li class="list-inline-item emoji"  data="3">
																<a href="javascript:void(0);" class="select_teacher_emoji" data-teacheremoji="4" id="tooltip-neutral">
																	<img src="{{asset('public/images/icon-neutral.svg')}}" alt="" class="active">
																	<img src="{{asset('public/images/icon-neutral-gray.svg')}}" alt="" class="inactive">
																</a>
															</li>

															<li class="list-inline-item emoji"  data="4">
																<a href="javascript:void(0);" class="select_teacher_emoji" data-teacheremoji="3" id="tooltip-sad">
																	<img src="{{asset('public/images/icon-bad.svg')}}" alt="" class="active">
																	<img src="{{asset('public/images/icon-bad-gray.svg')}}" alt="" class="inactive">
																</a>
															</li>
														</ul>
													</div>
													<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
														<h3><i class="fa-regular fa-file-lines"></i> Overall Comment</h3>
														<div class="d-flex flex-wrap align-items-center">
															<div class="form-group">
																<textarea class="form-control comment"  name="" rows="8" cols="100" placeholder="Write here" style="resize: none;"></textarea>
															</div>
														</div>
													</div>
													<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 marks-submit">
														<div class="row">
															<div class="col-7 col-sm-6 col-md-6 col-lg-6 col-xl-6">
																<div class="form-group d-flex pt-1 font-weight-bold">Score :
																	<input type="text" class="form-control input-marks-gained allow_marking text-center font-weight-bold mark" style="width: 42px;padding: 0px 8px;height: auto;" max="1979-12-31" maxlength="2" onkeypress="return /[0-9]/i.test(event.key)" {{ $lable3 }}>
																	<span style="display: block ruby;" class="orignal_mark"> / </span>
																</div>
															</div>
															<div class="col-5 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-right submit">
																<a href="javascript:void(0);" class="btn btn-primary">Submit</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="cc1" role="tablist">
										<div class="teacher-book-data"> {!! isset($teacherBook)?$teacherBook:""  !!} </div>
									</div>
									<div class="tab-pane fade" id="dd1" role="tablist">
										<div class="course-book-data">{!!  str_replace("http://ec2-52-15-233-207.us-east-2.compute.amazonaws.com/storage","https://s3.amazonaws.com/imperialenglish.co.uk",$courseBook);!!}</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mb-1 d-none d-xl-block cou-block">
					<div class="expand-option-course">
						<ul class="list-inline">
							<li class="">
								<a href="javascript:void(0);" class="expand-collapse-course"> <img src="{{ url('public/images/icon-fullscreen.svg') }}" alt="edit" class="img-fluid rotate-expand-icon"> </a>
							</li>
						</ul>
					</div>
					<ul class="nav nav-tabs work-record-marking teacher-course-tab pr-xl-5" role="tablist">
						<li class="nav-item">
							<button class="nav-link active" data-toggle="tab" data-target="#bbbb1" role="tab">
								<img src="{{asset('public/images/marking-tab.png')}}" style="width: 25px;">
								<span class="tab-title">Marking</span>
							</button>
						</li>
						<li class="nav-item">
							<button class="nav-link" data-toggle="tab" data-target="#cccc1" role="tab">
								<img src="{{asset('public/images/teacherbook-tab.png')}}" style="width: 25px;">
								<span class="tab-title">Teacher Book</span>
							</button>
						</li>
						<li class="nav-item">
							<button class="nav-link" data-toggle="tab" data-target="#dddd1" role="tab">
								<img src="{{asset('public/images/coursebook-tab.png')}}" style="width: 25px;">
								<span class="tab-title">Course Book</span>
							</button>
						</li>
					</ul>
					<div class="tab-content work-record-tabs teacher-course-content" id="remove1">
						<div class="tab-pane fade show active" id="bbbb1" role="tablist">
							<div class="row marking-data">
								<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
									<div class="row overall-marking-feedback">
									<!-- 	<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
											<h3><i class="fa-solid fa-microphone-lines"></i> Overall Feedback</h3>
											
										</div> -->
										<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3 review-emojis">
											<h3><i class="fa-solid fa-rss"></i> Overall Task Performance</h3>
											<ul class="list-inline list-rating d-flex flex-wrap justify-content-start">
												<li class="list-inline-item emoji" data="1">
													<a href="javascript:void(0);" class="select_teacher_emoji" data-teacheremoji="1" id="tooltip-veryhappy">
														<img src="{{asset('public/images/icon-very-happy.svg')}}" alt="" class="active">
														<img src="{{asset('public/images/icon-very-happy-gray.svg')}}" alt="" class="inactive">
													</a>
												</li>

												<li class="list-inline-item emoji" data="2">
													<a href="javascript:void(0);" class="select_teacher_emoji" data-teacheremoji="2" id="tooltip-happy">
														<img src="{{asset('public/images/icon-happy.svg')}}" alt="" class="active">
														<img src="{{asset('public/images/icon-happy-gray.svg')}}" alt="" class="inactive">
													</a>
												</li>

												<li class="list-inline-item emoji"  data="3">
													<a href="javascript:void(0);" class="select_teacher_emoji" data-teacheremoji="4" id="tooltip-neutral">
														<img src="{{asset('public/images/icon-neutral.svg')}}" alt="" class="active">
														<img src="{{asset('public/images/icon-neutral-gray.svg')}}" alt="" class="inactive">
													</a>
												</li>

												<li class="list-inline-item emoji"  data="4">
													<a href="javascript:void(0);" class="select_teacher_emoji" data-teacheremoji="3" id="tooltip-sad">
														<img src="{{asset('public/images/icon-bad.svg')}}" alt="" class="active">
														<img src="{{asset('public/images/icon-bad-gray.svg')}}" alt="" class="inactive">
													</a>
												</li>
											</ul>
										</div>
										<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
											<h3><i class="fa-regular fa-file-lines"></i> Overall Comment</h3>
											<div class="d-flex flex-wrap align-items-center">
												<div class="form-group">
													<textarea class="form-control comment"  name="" rows="8" cols="100" placeholder="Write here" style="resize: none;"></textarea>
												</div>
											</div>
										</div>
										<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 marks-submit">
											<div class="row">
												<div class="col-7 col-sm-6 col-md-6 col-lg-6 col-xl-6">
													<div class="form-group d-flex pt-1 font-weight-bold">Score :
														<input type="text" class="form-control input-marks-gained allow_marking text-center font-weight-bold mark" style="width: 42px;padding: 0px 8px;height: auto;" max="1979-12-31" maxlength="2" onkeypress="return /[0-9]/i.test(event.key)" {{ $lable3 }}>
														<span style="display: block ruby;" class="orignal_mark"> / </span>
													</div>
												</div>
												<div class="col-5 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-right">
													<a href="javascript:void(0);" class="btn btn-primary submit submit-modal-btn">Submit</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="cccc1" role="tablist">
							<div class="teacher-book-data"> {!! isset($teacherBook)?$teacherBook:""  !!} </div>
						</div>
						<div class="tab-pane fade" id="dddd1" role="tablist">					<div class="course-book-data">{!! $desc = str_replace("http://ec2-52-15-233-207.us-east-2.compute.amazonaws.com/storage","https://s3.amazonaws.com/imperialenglish.co.uk",$courseBook);!!}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</td>
</tr>
<script type="text/javascript">
	if (window.matchMedia('screen and (max-width: 1200px)').matches) {
		$('#remove1').remove();
	}else{
		$('#remove2').remove();
	}
	$('.review-emojis').find(".list-rating .list-inline-item > a ").click(function () {
		$('.review-emojis').find(".list-rating .list-inline-item ").removeClass("active");
		$(this).parent().addClass('active');
	}); 
	$(document).ready(function(){
		$('.stringProper').css('pointer-events','none');
		$('.enter_disable').attr("contenteditable","false");
		$('.spandata').attr("contenteditable","false");
		$('.fillblanks').attr("contenteditable","false");
		$('.fillblanks').attr("contenteditable","false");
		$('.textarea').attr("contenteditable","false");
		$('.resizing-input1').attr("contenteditable","false");
		$('.comment').attr('disabled',false)
	});
	$(document).on('keypress', ':input[type="number"]', function (e) {
		if ( e.which == 45 || e.which == 189 ) {
		    e.preventDefault();
		}
	    if (isNaN(e.key)) {
	        return false;
	    }
		$('.resizing-input1').attr("contenteditable","false");
		$('textarea').attr("disabled",true);
		$('textarea').attr("readonly",true);
		$('.form-control').attr("readonly",true);
	});
	$(document).on('keypress', ':input[type="number"]', function (e) {
		if ( e.which == 45 || e.which == 189 ) {
		    e.preventDefault();
		}
	    if (isNaN(e.key)) {
	        return false;
	    }
	});
	function minmax(value, min, max) {
	    if(parseInt(value) < min || isNaN(parseInt(value))) 
	        return min; 
	    else if(parseInt(value) > max) 
	        return max; 
	    else return value;
	}
	$(".expand-collapse-practice").click(function(){
		$(".expand-collapse-practice .rotate-expand-icon").toggleClass("half");
		$(".practicebook-work-tab").parent(".pra-block").toggleClass("col-xl-6");
		$(".practicebook-work-tab").parent(".pra-block").toggleClass("col-xl-12");
		$(".cou-block").toggleClass("d-xl-block");
		$(".cou-block").toggleClass("d-xl-none");
	});
	$(".expand-collapse-course").click(function(){
		$(".expand-collapse-course .rotate-expand-icon").toggleClass("half");
		$(".teacher-course-tab").parent(".cou-block").toggleClass("col-xl-6");
		$(".teacher-course-tab").parent(".cou-block").toggleClass("col-xl-12");
		$(".pra-block").toggleClass("d-none");
	});
</script>
<style type="text/css">
	.form-control-textarea {
	    pointer-events: none;
	}
	.stringProper {
	    pointer-events: none;
	}
	.resizing-input1 {
	    pointer-events: none;
	}
</style>