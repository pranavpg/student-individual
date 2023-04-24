<?php $markingmethod = isset($practise['markingmethod'])?$practise['markingmethod']:""; ?>
<tr class="hidden-data">
	<td colspan="9" class="hidden-tr p-0">
		<div class="topic-block-marking new-workrecord-block">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pra-block">
					<div class="tab-content work-record-tabs pr-work-record-tab pt-0">
						<div class="tab-pane fade show active" id="aa" role="tabpanel">
							<div class="row">
								<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 practice-type">
									@php  $lable = $markingmethods;$lable2 = ""; @endphp 	
									@if($markingmethods == "read_only")
										@php  $lable = "Read Only"; $lable2 = "readonly"; @endphp 	
									@elseif($markingmethods == "automated")
										@php  $lable = "Automated"; $lable2 = "readonly"; @endphp 	
									@elseif($markingmethods == "no_marking")
										@php  $lable = "No Marking"; $lable2 = "readonly"; @endphp 	
									@elseif($markingmethods == "student_self_marking")
										@php  $lable = "Student self marking"; $lable2 = ""; @endphp 	
									@endif
								</div>
							</div>
							<div class="practice-book-data pt-3">
								<ul class="nav nav-tabs" role="tablist">
									<input type="hidden" name="is_highest" id="is_highest"  value="{{ $tabs['is_highest'] }}">
									<input type="hidden" name="is_second_highest" id="is_second_highest"  value="{{ $tabs['is_second_highest'] }}">
									<input type="hidden" name="is_latest" id="is_latest"  value="{{ $tabs['is_latest'] }}">
									@if($flag_for_tab == 1)
										<li class="nav-item tooltip-custom score " data="3">
											<a class="nav-link active" data-toggle="tab" href="#3" role="tab">
												<img src="{{asset('public/images/highest-score.png')}}" style="width: 21px;">
												<span class="d-none d-sm-inline-block">Latest Marking</span>
											</a>
										</li>
									@else
										@if($tabs['is_highest'])
											<li class="nav-item tooltip-custom score" data="1">
												<a class="nav-link active" data-toggle="tab" href="#1" role="tab">
													<img src="{{asset('public/images/highest-score.png')}}" style="width: 21px;">
													<span class="d-none d-sm-inline-block">Highest Score</span>
												</a>
											</li>
										@endif
										@if($tabs['is_second_highest'])
											<li class="nav-item tooltip-custom score" data="2">
												<a class="nav-link" data-toggle="tab" href="#2" role="tab">
													<img src="{{asset('public/images/second-highest-score.png')}}" style="width: 21px;">
													<span class="d-none d-sm-inline-block">Second Highest Score</span>
												</a>
											</li>
										@endif
										@if($tabs['is_latest'])
											<li class="nav-item tooltip-custom score " data="3">
												<a class="nav-link {{ $tabs['is_highest']?'':'active' }}" data-toggle="tab" href="#3" role="tab">
													<img src="{{asset('public/images/letest-marking.png')}}" style="width: 21px;">
													<span class="d-none d-sm-inline-block">Latest Marking</span>
												</a>
											</li>
										@endif
									@endif
								</ul>
								<div class="course-tab-content practice-tab-content">
									<div class="tab-content border border-top-0 rounded-bottom p-3">
										<div class="row align-items-center ">
											<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
												<div class="d-flex align-items-center py-4 ">
													<div class="topic-tabs ml-0">
														<div class="topic-tabs-names"> 
															<span class="topic-tabs-topic-names">Topic : 8</span> 
															<span class="topic-tabs-task-names">Task : 7</span>
															<span class="topic-tabs-section-names">A</span>
														 </div>
													</div>
													<div class="topic-tabs ml-5">
														<div class="gained-marks-tab">
															<p class="mb-0" id="marksdisplay">Mark <span class="">1/1</span></p>
														</div>
													</div>
												</div>
											</div>
											@if(isset($tabs['comments']) && $tabs['comments']!="" )
											<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-8">
													<p class="text-left" style="color: #d55b7d;">Comment : </p>
												<div style="height: 82px;overflow: auto;border: solid 1px #e8e4e4;padding: 5px 5px;border-radius: 5px;margin-bottom: 10px;width: 98%;white-space: pre-line;">
													<p >{{ $tabs['comments'] }}</p>
												</div>
											</div>
											@endif
										</div>
										<div id="1" class="tab-pane fade active show tabss" role="tabpanel"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="aaa" role="tabpanel">
							<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 p-0">
								<ul class="nav nav-tabs work-record-marking teacher-course-tab" role="tablist">
									<li class="nav-item tooltip-custom">
										<button class="nav-link active" data-toggle="tab" data-target="#bb" role="tab">
											<img src="{{asset('public/images/marking-tab.png')}}" style="width: 25px;">
											<span class="tab-title d-none d-sm-inline-block">Marking</span>
											<span class="tooltiptext-neutral">Marking</span>
										</button>
									</li>
									<li class="nav-item tooltip-custom">
										<button class="nav-link" data-toggle="tab" data-target="#cc" role="tab">
											<img src="{{asset('public/images/teacherbook-tab.png')}}" style="width: 25px;">
											<span class="tab-title d-none d-sm-inline-block">Teacher Book</span>
											<span class="tooltiptext-neutral">Teacher Book</span>
										</button>
									</li>
									<li class="nav-item tooltip-custom">
										<button class="nav-link" data-toggle="tab" data-target="#dd" role="tab">
											<img src="{{asset('public/images/coursebook-tab.png')}}" style="width: 25px;">
											<span class="tab-title d-none d-sm-inline-block">Course Book</span>
											<span class="tooltiptext-neutral">Course Book</span>
										</button>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</td>
</tr>
<script type="text/javascript">
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
		$('.comment').attr('disabled',false);
	});
	$(document).on('keypress',':input[type="number"]', function (e) {
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