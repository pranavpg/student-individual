@extends('layouts.teacher-app')
@section('content')
<!-- <link rel="stylesheet" type="text/css" href="{{url('public/audio/css/all.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/audio/css/plyr.css')}}"> -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<!-- <link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css"> -->
<!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous"> -->
<style type="text/css">
/*neutral*/
/*sad emoji*/
#tooltip-sad {
  position: relative;
  display: inline-block;
}
#tooltip-sad .tooltiptext-sad{
  visibility: hidden;
  width: 120px;
  left: -50px;
  top: 40px;
  background-color: #3e5971;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
/* Position the tooltip */
  position: absolute;
  transition: 10ms ease;
}
#tooltip-sad:hover .tooltiptext-sad{
  visibility: visible;
}
/*netural*/
#tooltip-neutral {
  position: relative;
  display: inline-block;
}
#tooltip-neutral .tooltiptext-neutral {
  visibility: hidden;
  width: 120px;
  left: -50px;
  top: 40px;
  background-color: #3e5971;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
/* Position the tooltip */
  position: absolute;
  transition: 10ms ease;
}
#tooltip-neutral:hover .tooltiptext-neutral {
  visibility: visible;
}
/*happy*/
#tooltip-happy {
  position: relative;
  display: inline-block;
}
#tooltip-happy .tooltiptext-happy {
  visibility: hidden;
  width: 120px;
  left: -50px;
  top: 40px;
  background-color: #3e5971;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
/* Position the tooltip */
  position: absolute;
  transition: 10ms ease;
}
#tooltip-happy:hover .tooltiptext-happy {
  visibility: visible;
}
/*very happy*/
#tooltip-veryhappy {
  position: relative;
  display: inline-block;
}
#tooltip-veryhappy .tooltiptext-veryhappy {
  visibility: hidden;
  width: 120px;
  left: -50px;
  top: 40px;
  background-color: #3e5971;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
/* Position the tooltip */
  position: absolute;
  transition: 10ms ease;
}
#tooltip-veryhappy:hover .tooltiptext-veryhappy {
  visibility: visible;
}
</style>
<?php
//dd('test');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    $markingmethod = isset($practise['markingmethod'])?$practise['markingmethod']:"";
?>

<link rel="stylesheet" href="{{ asset('public/literally/css/literallycanvas.css') }}">
    <style>
      .literally {
        width: 100%;
        height: 100%;
        position: relative;
        background-color: transparent !important
      }
      .literally .lc-picker{
        background-color: transparent !important
      }
      .literally .horz-toolbar{
        background-color:   !important
      }
      .draw_img_full_screen {
        width: 100%;
    }
    .draw_img_full_screen img {
        width: 100%;
    }
    .draw-image > a::before {
        background: none;
    }
    .draw-image > a::after {
        background: none;
    }
    </style>
    <?php
    //pr($topic_tasks);
    ?>
    <div class="filter d-block d-md-none">
			<a href="javascript:void(0)" class="btn-sm filterbtn expand-chat-support" style="padding: 0.35rem 0 0.35rem 0.35rem;">
				<span class="mobonly"><img src="{{asset('public/images/contactus-04.svg')}}" alt="Chat Support" class="img-fluid" width="30px"></span>
			</a>
		</div>
	<main class="course-book fullscreen d-flex flex-wrap">
		<aside class=" cc w-35 course-book__left">
			<div class="course-book-heading mb-4 d-flex flex-wrap align-items-center">
				<div class="close-course mr-4 close-course-mobile">
					<a href="{{ Session::get('preClass') != '' ? URL('marking-new/'.Session::get('preClass')) : URL('marking-new') }}" class="close-course-icon">
						<img src="{{asset('public/images/icon-close-course.svg')}}" alt="X"  class="img-fluid">
					</a>
				</div>
				<div class="heading__button">
					{{$topic_tasks['student_name']}} : {{strtoupper($courseName)}}: {{strtoupper($levelTitle)}}
				</div>
			</div>
			<!-- /. Course book heading-->
			<div class="course-content bg-white p-2 mh_11">
				<div class="course-tab-fixed-heading w-100 d-flex flex-wrap df_1">
					<div class="expand-option-course">
						<ul class="list-inline">
							<li class="list-inline-item">
								<a href="javascript:void(0);" class="expand-collapse-course" title="Maximize"> <img src="https://student.englishapp.uk/public/images/ic_expand.png" alt="edit" class="img-fluid rotate-expand-icon"></a>
							</li>
						</ul>
					</div>
					<ul class="nav nav-pills course-buttons" id="pills-tab" role="tablist">
						<li class="nav-item">
							<a class="nav-link mb-1 active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Course Book</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Teacher Book</a>
						</li>
					</ul>
					<!-- <div class="expand-option-course">
						<ul class="list-inline">
							<li class="list-inline-item">
								<a href="javascript:void(0);" class="expand-collapse-course"> <img src="https://student.englishapp.uk/public/images/ic_expand.png" alt="edit" class="img-fluid rotate-expand-icon"> </a>
							</li>
							</ul>
					</div> -->
				</div>
				<div class="course-tab-content">
					<div class="tab-content scrollbar" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
							<h2>{!! $topic_tasks['name'] !!}</h2>
							{!! str_replace('assets/demo/demo12/base/style.bundle.css','',$topic_tasks['description']) !!}
						</div>
						<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
							{!! str_replace('assets/demo/demo12/base/style.bundle.css', '', isset($topic_tasks['teacherbook'][0]['description'])?$topic_tasks['teacherbook'][0]['description']:'') !!}
						</div>
					</div>
				</div>
			</div>
			<!-- /. Cousre Content-->
		</aside>
		<!-- /. Course book Left-->
		<div class="pc w-65 course-book__right">
			<div class="course-book-heading mb-4 d-flex flex-wrap align-items-center">
				<div class="heading__button mt-2 mt-md-0 mr-3">
					Topic {{$topicNumber}} - Task {{$taskName}}
				</div>

				<div class="heading__button mt-2 mt-md-0">
					<?php
					$marks_gained = !empty($topic_tasks['practise'][0]['marks_gained'])?$topic_tasks['practise'][0]['marks_gained']:0;
					$out_of_marks_array = array();
					foreach ($topic_tasks['practise'] as $key => $value) {
						if(isset($topic_tasks['practise'][$key]['mark']) && !empty($topic_tasks['practise'][$key]['mark'])){
							array_push($out_of_marks_array,$topic_tasks['practise'][$key]['mark']);
						} else {
							$topic_tasks['practise'][$key]['mark']=0;
							array_push($out_of_marks_array,$topic_tasks['practise'][$key]['mark']);
						}
					}
					?>
					Total Task Marks : <span class="marks_gained_by_student">{{$marks_gained}}</span>/{{array_sum($out_of_marks_array)}}
				</div>
				<div class="course-tab-chat-support flex-wrap align-items-center d-none d-md-block">
					<div class="w-100">
						<a href="javascript:void(0);" class="expand-chat-support">
							<img src="{{ asset('/public/images/task-chat-support.png') }}" alt="Chat Support" style="width:40px;">
						</a>
					</div>
				</div>
			</div>
			<!-- /. Course book heading-->
			<div class="course-content bg-white mb-4 course-content_shrink p-2 pcs" id="top-book">
				<div class="course-tab-fixed-heading w-100 d-flex flex-wrap align-items-center justify-content-between">
					<div class="title mb-1">Practice Book</div>
					
					<?php
						$azRange = range('A', 'Z');
						$activeTaskKey=0;
						if(isset($topic_tasks['practise'])) {
							$practises = $topic_tasks['practise'];
					?>
					<ul class="nav nav-pills nav-mwidth" id="pills-teacher-tab" role="tablist">
						<?php foreach($practises as $i=>$practise){?>
							<li class="nav-item mb-1">
								<a data-key="{{$i}}" class="nav-link  {{ $markingmethod == 'markingmethod' ? 'practice__link allow__draw' : 'practice__link' }} {{ (!empty($practise['markingmethod']) && $practise['markingmethod'] == 'manual') ? '' : '' }}"   data-markingmethod="{{$markingmethod}}" id="abc-<?php echo $practise['id'];?>-tab" data-toggle="pill" href="#abc-<?php echo $practise['id'];?>" role="tab" aria-controls="abc-<?php echo $practise['id'];?>" data-pid="{{$practise['id']}}" aria-selected="true">
									<?php echo $azRange[$i]. ' : ' . $practise['mark'];?>
								</a>
							</li>
						<?php } $practise_id_1 = $practise['id']; // pr($topic_tasks['id']); ?>
					</ul>
					<div class="expand-option-course">
						<ul class="list-inline">
							<li class="list-inline-item">
								<a href="javascript:void(0);" class="expand-collapse-practice" title="Maximize"> <img src="https://student.englishapp.uk/public/images/ic_expand.png" alt="edit" class="img-fluid rotate-expand-icon"> </a>
							</li>
						</ul>
					</div>
					<?php } ?>
					<!-- /. Teacher tab-->
					<!-- <div class="heading__extra_button">
						<a href="javascript:;" style="display:none"  data-toggle="modal" data-target="#drawMarkingModal" class="btn btn-secondary open_draw_marking_modal">
							<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" class="icon-pencil-svg">
								<defs />
								<path fill-rule="evenodd" d="M14.911 5.178l-.456.46-2.992-2.992.461-.46a1.289 1.289 0 011.822 0l1.17 1.169c.5.506.497 1.32-.005 1.823zM2.942 11.54l2.615 2.615-3.926 1.306 1.311-3.921zm3.414 2.198l-2.992-2.993 7.488-7.489 2.993 2.992-7.489 7.49zm7.996-12.159a2.152 2.152 0 00-3.04 0l-.76.766-8.1 8.095-.017.017c-.004.004-.004.009-.008.009-.009.013-.022.025-.03.038 0 .005-.005.005-.005.009l-.02.034c-.006.005-.006.009-.01.014l-.013.034c0 .004-.004.004-.004.009L.548 16.007a.423.423 0 00.103.439.435.435 0 00.443.103l5.4-1.802c.004 0 .004 0 .008-.004a.122.122 0 00.04-.017l.008-.004c.012-.009.03-.018.043-.026.012-.008.025-.021.038-.03.005-.005.01-.005.01-.009.003-.003.011-.008.016-.017l8.86-8.86c.838-.84.838-2.2 0-3.04l-1.165-1.161z" />
							</svg>
						</a>
					</div> -->
				</div>
				<div class="course-tab-content"> 
					<div class="tab-content scrollbar pl-2" id="pills-teacher--tabContent">
						<?php
						// dd($practises);
							foreach($practises as $i=>$practise) {
								$top_book_class="";
								$content_shrink_class = "";
								if($i == 0) {
									$top_book_class = "active show";
									$bottom_book_class = "";
								}
								if( empty( $practise['marks_gained'] ) ) {
									$save_btn_class = "justify-content-center";
								} else {
									$save_btn_class = "justify-content-end";
									$content_shrink_class = "course-content_shrink";
								}
						?>

						<div class="tab-pane fade {{ $top_book_class }}" id="abc-<?php echo $practise['id'];?>" role="tabpanel" aria-labelledby="abc-<?php echo $practise['id'];?>-tab">
							<fieldset class="practice-fieldset">
								<div class="mb-4 pr-3 allow_draw" id="{{$markingmethod=='manual'?'allow_draw_'.$i:''}}">
									<?php  //echo '<p>'.$practise['type']."  ===ID==>  ". $practise['id'].'</p>'; ?>
									@include('common.practice-types')
								</div>
								@if( $markingmethod=='manual' )
								<img style="display:none;" class="getDrawMarkingImage">
								@endif
							</fieldset>
							<!-- /. Component Match Answer End -->
							<!-- teacher Marking-->
							<form class="teacher-feedback-form">
								<footer class="tab-footer d-flex flex-wrap justify-content-center mb-4">
									<div class="row w-100">
										<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-2">
											<div class="row">
												<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 overall-feedback">
													@if(!empty($practise['highest_score_attempt_id']))
													<a href="javascript:;" class="btn {{(!empty($showPrevious) && $showPrevious == 1) ? 'btn-danger practice-marking-btn' : 'btn-secondary practice-marking-btn'}}" data-bind="click:$root.getPreviousMarking.bind($data,1)" data-id="{{$practise['answer_id']}}">Highest Score</a>
													@endif
												</div>
												<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 overall-feedback">
													@if(!empty($practise['second_score_attempt_id']))
													<a href="javascript:;" class="btn {{(!empty($showPrevious) && $showPrevious == 2) ? 'btn-danger practice-marking-btn' : 'btn-secondary practice-marking-btn'}}" data-bind="click:$root.getPreviousMarking.bind($data,2)" data-id="{{$practise['answer_id']}}">Second Score</a>
													@endif
												</div>
												<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 overall-feedback">
													@if(!empty($practise['highest_score_attempt_id']) || !empty($practise['second_score_attempt_id']))
													<a href="javascript:;" class="btn {{ empty($showPrevious) ? 'btn-danger practice-marking-btn' : 'btn-secondary practice-marking-btn'}}" data-bind="click:$root.getCurrentMarking">Latest Marking</a>
													@endif
												</div>
											</div>
										</div>
										<input type="hidden" name="answers[{{$i}}][answer_id]" value="{{$practise['answer_id']}}">
										@php
										$selfMarkingArray = array('automated','read_only','no_marking');
										@endphp
										<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 overall-feedback">
											<div class="editable-box ml-auto mr-auto w-100 d-flex align-items-center flex-wrap {{$save_btn_class}}">
												@if(in_array($practise['markingmethod'], $selfMarkingArray))

												<input type="hidden"  value="{{ !empty($practise['marks_gained'])?$practise['marks_gained']:'0' }}" name="answers[{{$i}}][marks_gained]">
												<input type="hidden" name="answers[{{$i}}][comment_image]" value="" class="marking_comment_image">
												<input type="hidden" name="answers[{{$i}}][is_file]" value="false" class="is_marking_file">

												<span>Score: &nbsp;&nbsp;</span>
												<div class="form-group mb-0 d-flex align-items-center" style="max-width: 100px;">
													<input type="text" {{ ( in_array($markingmethod, $selfMarkingArray))?'disabled=disabled':'' }}  class="form-control input-marks-gained {{ ( !in_array($markingmethod, $selfMarkingArray))?'allow_marking':'' }} " data-maxMarks="{{ !empty($practise['mark'])?$practise['mark']:'0' }}" value="{{ !empty($practise['marks_gained'])?$practise['marks_gained']:'0' }}" style="width: 42px;{{ ( in_array($markingmethod, $selfMarkingArray))?'width: 42px;background-color: #e4dada;text-align: center;padding-right: 13px;':'' }}" name="answers[{{$i}}][marks_gained]">
													<span class="task-marks ml-2">  / {{ !empty($practise['mark'])?$practise['mark']:"0" }}</span>
													<!--{{ <?php //(!empty($practise['marks_gained'])? $practise['marks_gained'] :'0').' / '.($practise['mark']) ?>}}-->
												</div>
												@else
												<span>Add Score: &nbsp;&nbsp;</span>
												<div class="form-group mb-0 d-flex align-items-center" style="{{ ( in_array($markingmethod, $selfMarkingArray))?'max-width: 100px;background-color: #e4dada;text-align: center;padding-right: 13px;':'max-width: 100px;' }}">

													<?php if(in_array($markingmethod, $selfMarkingArray)) { ?>
														<input type="hidden" value="{{ !empty($practise['marks_gained'])?$practise['marks_gained']:'0' }}"  name="answers[{{$i}}][marks_gained]">
													<?php } ?>

													<input type="text" {{ ( in_array($markingmethod, $selfMarkingArray))?'disabled=disabled':'' }}  class="form-control input-marks-gained {{ ( !in_array($markingmethod, $selfMarkingArray))?'allow_marking':'' }} " data-maxMarks="{{ !empty($practise['mark'])?$practise['mark']:'0' }}" value="{{ !empty($practise['marks_gained'])?$practise['marks_gained']:'0' }}" style="width: 42px;{{ ( in_array($markingmethod, $selfMarkingArray))?'width: 42px;background-color: #e4dada;text-align: center;padding-right: 13px;':'' }}" name="answers[{{$i}}][marks_gained]">
													<span class="task-marks ml-2">  / {{ !empty($practise['mark'])?$practise['mark']:"0" }}</span>
													<input type="hidden" name="answers[{{$i}}][comment_image]" value="" class="marking_comment_image">
													<input type="hidden" name="answers[{{$i}}][is_file]" value="false" class="is_marking_file">
												</div>
												@endif
											</div>
										</div>
									</div>
								</footer>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<!-- /. Cousre Content-->
			<!-- Course Tab Content for overall Ranking-->

			<div class="course-content course-content-feedback course-tab-content_ranking fc active" id="bottom-book" style="background-color: #f7f3f3;">
				<div class="alert alert-success mt-3 dt_2" role="alert" style="display:none;"></div>
				<div class="alert alert-danger mt-3" role="alert" style="display:none;"></div>
				<div class="expand-option-feedback">
					<ul class="list-inline">
						<li class="list-inline-item">
							<a href="javascript:void(0);" class="expand-collapse-feedback" title="Maximize"> <img src="{{ asset('public/images/ic_expand.png') }}" alt="edit" class="img-fluid rotate-expand-icon"></a>
						</li>
					</ul>
				</div>

				<div class="d-flex flex-wrap">
					<div class="col-12 overall-feedback col-sm-12 col-md-12 col-lg-12 col-xl-7">
						<h3>Overall Feedback</h3>
						<input type="hidden" name="student_id" id="student_id_new" value="{{$studentId}}" >
						<input type="hidden" name="practise_id" value="{{$practise_id_1}}" >
						<input type="hidden" name="task_id" id="task_id" value="{{$topic_tasks['id']}}" >
						<input type="hidden" class="marking_audio_path" name="marking_audio_path" value="{{$topic_tasks['id']}}" >
						<input type="hidden" name="teacher_emoji" class="teacher_emoji" value="{{isset($topic_tasks['feedbacks'][0]['teacher_emoji'])?$topic_tasks['feedbacks'][0]['teacher_emoji']:''}}" >

						<div class="d-flex flex-wrap w-100 align-items-center feedback_audio">
							@include('practice.common.marking_audio_record',['key'=>0, 'student_id' => $studentId, 'practise_id'=>$topic_tasks['id']])
						</div>
					</div>

					<div class="col-12 overall-feedback col-sm-12 col-md-12 col-lg-12 col-xl-5 text-left">
						<h3>Overall Task Performance</h3>
						<?php
							if(isset($topic_tasks['feedbacks'][0]['id']) && !empty($topic_tasks['feedbacks'][0]['id'])){ ?>
								<input type="hidden" name="feedbackid" value="{{$topic_tasks['feedbacks'][0]['id']}}">
						<?php } ?>
						<ul class="list-inline list-rating d-flex flex-wrap justify-content-start">
							<li class="list-inline-item {{(!empty($topic_tasks['feedbacks']) && $topic_tasks['feedbacks'][0]['teacher_emoji']==4)?'active':'' }}">
								<a href="javascript:;" class="select_teacher_emoji" data-teacherEmoji="4" id="tooltip-neutral">
									<img src="{{asset('public/images/icon-neutral.svg')}}" alt="" class="active">
									<img src="{{asset('public/images/icon-neutral-gray.svg')}}" alt="" class="inactive">
									<span class="tooltiptext-neutral">Neutral</span>
								</a>
							</li>

							<li class="list-inline-item {{(!empty($topic_tasks['feedbacks']) && $topic_tasks['feedbacks'][0]['teacher_emoji']==3)?'active':'' }} ">
								<a href="javascript:;" class="select_teacher_emoji" data-teacherEmoji="3" id="tooltip-sad">
									<img src="{{asset('public/images/icon-bad.svg')}}" alt="" class="active">
									<img src="{{asset('public/images/icon-bad-gray.svg')}}" alt="" class="inactive">
									<span class="tooltiptext-sad">Sad</span>
								</a>
							</li>

							<li class="list-inline-item {{(!empty($topic_tasks['feedbacks']) && $topic_tasks['feedbacks'][0]['teacher_emoji']==2)?'active':'' }}">
								<a href="javascript:;" class="select_teacher_emoji" data-teacherEmoji="2" id="tooltip-happy">
									<img src="{{asset('public/images/icon-happy.svg')}}" alt="" class="active">
									<img src="{{asset('public/images/icon-happy-gray.svg')}}" alt="" class="inactive">
									<span class="tooltiptext-happy">Happy</span>
								</a>
							</li>

							<li class="list-inline-item {{(!empty($topic_tasks['feedbacks']) && $topic_tasks['feedbacks'][0]['teacher_emoji']==1)?'active':'' }}">
								<a href="javascript:;" class="select_teacher_emoji" data-teacherEmoji="1" id="tooltip-veryhappy">
									<img src="{{asset('public/images/icon-very-happy.svg')}}" alt="" class="active">
									<img src="{{asset('public/images/icon-very-happy-gray.svg')}}" alt="" class="inactive">
									<span class="tooltiptext-veryhappy">Very Happy</span>
								</a>
							</li>
						</ul>
					</div>
					<!-- /. Overall Feedback-->
					<div class="col-12 overall-feedback">
						<h3>Overall Comment</h3>
						<div class="d-flex flex-wrap align-items-center">
							<div class="form-group flex-grow-1 mr-4 mb-1">
								<input type="text" class="form-control" name="teacher_comment" value="{{!empty($topic_tasks['feedbacks'][0]['teacher_comment'])?$topic_tasks['feedbacks'][0]['teacher_comment']:"" }}" placeholder="Write here" style="border-bottom: solid 1px #111111;padding: 0;">
							</div>
							@if(empty($showPrevious))
							<a href="javascript:void(0);" class="btn btn-primary teacherFeedbackSubmitBtn">Submit</a>
							@endif
						</div>
					</div>
				</div>
			</div>
			</form>
			<!-- /.Course Tab Content for overall Ranking-->
		</div>
	</main>

	<div class="modal" id="drawMarkingModal" tabindex="-1" aria-labelledby="drawMarkingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                  <div class="loader__icon justify-content-center"  style="display:none">
                     <img src="{{asset('public/images/animated-loader.gif')}}"  />
                     <h5  class="modal-title text-center" >Loading...</h5>
                  </div>
                  <div class="fs-container">
                     <div class="backgrounds" id="canvas__{{$practise_id_1}}"></div>
                  </div>
                </div>
                <div class="modal-footer">
                     <button type="button" class="btn btn-danger btn-no-border" data-dismiss="modal">Close</button>
                     <button type="button" class="btn btn-primary canvasSave_{{$practise_id_1}}" data-key="" data-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>
   @include('practice.common.audio_record_popup')

   @section('popup')
<div class="modal fade add-summary-modal" id="previousMarking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="d-flex justify-content-end w-100"><button type="button" class="btn btn-secondary  btn-sm mb-2" data-dismiss="modal">&times;</button></div>
            <div class="modal-header align-items-center">
                <h5 class="modal-title" id="exampleModalLabel">
                    Previous Marking
                </h5>
            </div>
            <div class="modal-body" style="color:#000;">
                <table class="table mt-2">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Mark Gain</th>
                            <th scope="col">Marked By</th>
                            <th scope="col">Created At</th>
                        </tr>
                    </thead>
                    <tbody data-bind="visible:$root.Records().length > 0, foreach:$root.Records">
                        <tr>
                            <td data-bind="text:$index() + 1"></td>
                            <td data-bind="text:$data.marks_gained"></td>
                            <td data-bind="text:$data.is_marked_by"></td>
                            <td data-bind="text:$data.created_at"></td>
                        </tr>
                    </tbody>
                    <tbody data-bind="visible:$root.Records().length == 0">
                        <tr>
                            <td colspan="4" align="middle">No Record Found</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bind="click:$root.closePreviousMarking">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal new-audio-record-modal fade" id="audio-record-modal" tabindex="-1" role="dialog" aria-labelledby="audiomodalLongTitle">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" >
      <div class="modal-header justify-content-center">
        <h4 class="modal-title" id="audiomodalLongTitle">Record your answer now</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <h4 class="modal__question"></h4>
        <div class="mic__icon justify-content-center">
          <img src="https://teacher.imperial-english.com/public/images/mic-icon-1.png"  />
        </div>

        <div class="animated__mic__icon justify-content-center"  style="display:none">
          <img src="https://teacher.imperial-english.com/public/images/animated-mic-icon.gif"  />
          <div class="audio__progress">
            <div class="audio__progress__bar audio__progress__success" data-width="0" style="width:0%">
            </div>
            <div class="audio__progress__bar audio__progress__remaining" data-width="100" style="width:100%">
            </div>
          </div>
        </div>
        <div class="loader__icon justify-content-center"  style="display:none">
          <img src="https://teacher.imperial-english.com/public/images/animated-loader.gif"  />
          <h5  class="modal-title" >Processing your audio</h5>
        </div>
      </div>
      <div class="modal-footer justify-content-center audio__controls">
        <button type="button" class="btn new__record__button recordButton">Record</button>
        <button type="button" class="btn new__pause__button pauseButton" style="display:none">Pause</button>
        <button type="button" class="btn new__resume__button pauseButton" style="display:none">Resume</button>
        <button type="button" class="btn new__stop__button stopButton" style="display:none">Stop</button>
      </div>
    </div>
  </div>
</div>
@endsection

   <script src="//cdnjs.cloudflare.com/ajax/libs/react/0.14.7/react-with-addons.js"></script>
   <script src="//cdnjs.cloudflare.com/ajax/libs/react/0.14.7/react-dom.js"></script>
   <script src="{{ asset('public/literally/js/literallycanvas.js') }}"></script>

<script type="application/javascript">
   var currURL = "{{Request::url()}}";
   var nextURL = "{{ Session::get('preClass') != '' ? URL('marking-new/'.Session::get('preClass')) : URL('marking-new') }}";
   $('ul.list-inline.list-buttons').remove();
   $('.open_draw_marking_modal').on('click', function(){
      $('#drawMarkingModal').modal('toggle');
      var key = $(this).attr('data-key');
      $('.canvasSave_{{$practise_id_1}}').attr('data-key', key);
   });
   var ttm = 0;
   $('.input-marks-gained').each(function(){
      ttm +=parseInt($(this).val())
   });
   $('.marks_gained_by_student').html(ttm);
   $('.save__marks__teacher').on('click', function(){
      var marks_gained_by_student =  parseInt($('.marks_gained_by_student').html());
      var input_marks_gained = parseInt($(this).parent().find('.input-marks-gained').val());
      $('.marks_gained_by_student').html(marks_gained_by_student+input_marks_gained);
   })
   $(".input-marks-gained").keypress(function (e) {
          if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
              //display error message
                  return false;
          }
      });
   $('.input-marks-gained').keyup(function (e) {
      // var maxMarks = parseInt($(this).attr('data-maxMarks'));
      // var regex = new RegExp("^[0-9-]+$");
      // var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
      // var value = parseInt($(this).val());
      // if ((regex.test(str) || (e.which>=96 && e.which<=106)) && value<=maxMarks)  {
      //    return true;
      // }
      // alert(v);
      // $(this).val(v);
      // var v = value.substr(0, value.length - 1);
      var n = parseInt($(this).val());
            var max = parseInt($(this).attr('data-maxMarks'));
            if (n > max
                && e.keyCode !== 46
                && e.keyCode !== 8
                ) {
                e.preventDefault();
                $(this).val('');
            }
            if ($(this).val() < 0
                && e.keyCode !== 46
                && e.keyCode !== 8
                ) {
                e.preventDefault();
                $(this).val('');
            }
                var ttm = 0;
               $('.input-marks-gained').each(function(){
                if($(this).val()!=""){
                  ttm +=parseInt($(this).val())
                }
               });
               $('.marks_gained_by_student').html(ttm);
   });
   $('.teacherFeedbackSubmitBtn').on('click', function(){
      var showError = false;
      $('input.allow_marking').each(function(index){
              var inputVal = $(this).val();
              if(parseInt(inputVal) >= 0){
              }else{
               alert("Please enter the marks. If no marks are given enter zero");
               showError = true;
               return false;
              }
          }
      );
      if(showError === false){
         $.ajax({
            url: '<?php echo URL('practice-submit-marking'); ?>',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: $('.teacher-feedback-form').serialize(),
            success: function (data) {
               if(data.success){
                  var nextURL = "{{ Session::get('preClass') != '' ? URL('marking-new/'.Session::get('preClass')) : URL('marking-new') }}";
                  $('.teacher-feedback-form').trigger("reset");
                  $('.alert-danger').hide();
                  if(getCookie('filter_data_url').length > 0){
                     var filterDataURLs = JSON.parse(getCookie('filter_data_url'));
                     //Remove current URL
                     var getIndex = filterDataURLs.indexOf(currURL);
                     if (getIndex > -1) {
                       filterDataURLs.splice(getIndex, 1);
                       if(filterDataURLs.length > 0){
                        nextURL = filterDataURLs[0];
                        setCookie('filter_data_url',JSON.stringify(filterDataURLs));
                       }
                     }
                  }
               $('.alert-success').show().html(data.message).fadeOut(4000);
                  setTimeout(function () {
                     window.location.href = nextURL;
                  },2000)
               } else {
                  $('.alert-success').hide();
                  $('.alert-danger').show().html(data.message).fadeOut(4000);
               }
            }
         });
      }
   });
   var token = $('meta[name=csrf-token]').attr('content');
   var rename_audio = '{{ URL("rename-audio") }}'
  var upload_url = "{{url('upload-audio')}}";
  var workerDirPath = "{{asset('public/student/js/audio-recorder/')}}";
   $(document).on('click','.delete-icon', function() {
      $(this).parent().find('.stop-button').hide();
      $(this).parent().find('.practice_audio').attr('src','');
      $(this).parent().find('.audioplayer-bar-played').css('width','0%');
      $(this).hide();
      $(this).parent().find('div.audio-element').css('pointer-events','none');
      $(this).parent().find('.record-icon').show();
      $(this).parent().find('.stop-button').hide();
      $(this).parent().find('.plyr__controls__item.plyr__control').hide();
      var practise_id = $('#task_id:hidden').val();
      $.ajax({
         url: '<?php echo URL('delete-audio'); ?>',
         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
         type: 'POST',
         data: {practice_id:practise_id},
         success: function (data) {
         }
      });
   });
   $(document).on('click','.delete-icon1', function() {
      $(this).parent().find('.stop-button').hide();
      $(this).parent().find('.practice_audio').attr('src','');
      $(this).parent().find('.audioplayer-bar-played').css('width','0%');
      $(this).hide();
      $(this).parent().find('div.audio-element').css('pointer-events','none');
      $(this).parent().find('.record-icon').show();
      $(this).parent().find('.stop-button').hide();
      $(this).parent().find('.plyr__controls__item.plyr__control').hide();
      $('.record_marking').find('#marking_audio1').find('source').attr('src', '');
      var audio = document.getElementById('marking_audio1');
        audio.load(); //call this to just preload the audio without playing
      var practise_id = $('#task_id:hidden').val();
      var student_id= $('#student_id_new').val();
      $.ajax({
         url: '<?php echo URL('delete-audio'); ?>',
         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
         type: 'POST',
         data: {practice_id:practise_id,student_id:student_id},
         success: function (data) {
         }
      });
   });
</script>


<script src="{{asset('public/student/js/audio-recorder/recorder.js')}}"></script>
<script src="{{asset('public/student/js/audio-recorder/app-multiple.js')}}"></script>

<script src="{{ asset('public/js/html2canvas.min.js') }}"></script>
<script src="{{ asset('public/student/js/audioplayer.js') }}"></script>
<script type="text/javascript" src="{{asset('public/vendors/knockout/knockout.js')}}"></script>
<script type="text/javascript" src="{{asset('public/vendors/knockout/knockout.validation.js')}}"></script>
<script type="text/javascript" src="{{asset('public/vendors/knockout/knockout.mapping.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/pagejs/common.js')}}"></script>
<script>
   var previousMarkingURL = "{{route('show_previous_history')}}", showPrevious="{{$showPrevious}}";
</script>
<script type="text/javascript" src="{{asset('public/js/pagejs/topic.js?'.time())}}"></script>
<script>
  var canvas={};
   setTimeout(function() {
      $('.practice__link').first().click();
   },10);
   var idsArray = new Array();
   $(document).on('click','.practice__link',function(){
      if(idsArray.indexOf($(this).attr('aria-controls')) == "-1"){
        $('#'+$(this).attr('aria-controls')+' .practice_audio').audioPlayer();
      }
      idsArray.push($(this).attr('aria-controls'));
   });


   $(document).on('ready', function(){
      $('.practice-fieldset').children().off('click');
      $(".practice-fieldset").on('click', function(e) {
        e.stopPropagation();
        e.preventDefault();
      });

    // $('.practice_audio').audioPlayer();
    $('.dependancy_audio_parent .alert').remove();
    $('form .alert').remove();
    $('.delete-icon').fadeOut();
      // $('audio').audioPlayer();
      $('.feedback_audio .audio_record_fieldset').addClass('w-75 ');
      $('.feedback_audio .audio_record_fieldset .audioplayer').addClass('mt-0 mb-0');
      $('#drawMarkingModal').on('show.bs.modal', function(){
         var key = $('.canvasSave_{{$practise_id_1}}').attr('data-key');
         if(key!=""){
            $(".is_marking_file").eq(key).val(false);
            var saved_image_path = $('.getDrawMarkingImage').eq(key).prop('src');
            $(".canvasSave_{{$practise['id']}}").removeAttr("disabled");
            var x_axis=10;
            var y_axis=10;
            var scale_img = 0.6;
            if( saved_image_path=="" ){
               $('.loader__icon').show();
               $('#canvas__{{$practise["id"]}}').hide();
               html2canvas( $("#allow_draw_"+key)[0] ).then(function(htmlCanvas) {
                  var img = htmlCanvas.toDataURL();
                  $('.getDrawMarkingImage').eq(key).prop('src',img);
                  var saved_image_path = $('.getDrawMarkingImage').eq(key).prop('src');
                  var newImage = new Image();
                  newImage.src = saved_image_path;
                  var bg_img = newImage;
                  setTimeout(() => {
                     canvas[key] =  LC.init(document.getElementsByClassName('backgrounds')[0],
                     {
                        imageURLPrefix: "{{ asset('public/literally/img') }}",
                        toolbarPosition: 'top',
                        defaultStrokeWidth: 2,
                        strokeWidths: [1, 2, 3, 5, 30],
                        keyboardShortcuts: false
                     });
                     canvas[key].saveShape(LC.createShape('Image', {x: x_axis, y: y_axis, image: bg_img,  scale: scale_img}));
                     $('.loader__icon').hide();
                     $('#canvas__{{$practise["id"]}}').show();
                     window.dispatchEvent(new Event('resize'));
                  }, 300);
               });
            } else {
               $('.loader__icon').show();
               $('#canvas__{{$practise["id"]}}').hide();
               var scale_img = 0.6;
               // console.log('====>',saved_image_path)
               var newImage = new Image();
               newImage.src = saved_image_path;
               var bg_img = newImage;
               setTimeout(() => {
                  canvas[key] =  LC.init(document.getElementsByClassName('backgrounds')[0],
                  {
                     imageURLPrefix: "{{ asset('public/literally/img') }}",
                     toolbarPosition: 'top',
                     defaultStrokeWidth: 2,
                     strokeWidths: [1, 2, 3, 5, 30],
                     keyboardShortcuts: false
                  });
                  canvas[key].saveShape(LC.createShape('Image', {x: x_axis, y: y_axis, image: bg_img,  scale: scale_img}));
                  $('.loader__icon').hide();
                  $('#canvas__{{$practise["id"]}}').show();
                  window.dispatchEvent(new Event('resize'));
               }, 300);
            }
         }
      });
   });
  $('#bottom-book').find(".list-rating .list-inline-item > a ").click(function () {
      $('#bottom-book').find(".list-rating .list-inline-item ").removeClass("active");
      $(this).parent().addClass('active');
  });
  $(".toggle-feedback").on('click',function () {
      $("#top-book").toggleClass("course-content_shrink");
      $("#bottom-book").toggleClass("active");
  });
  $('.select_teacher_emoji').on('click', function() {
    var selected_emoji = $(this).attr('data-teacherEmoji');
    $('.teacher_emoji').val(selected_emoji)
  });
   $(document).on('click','.practice__link', function() {
     // alert($(this).attr('data-markingmethod'))
      if($(this).attr('data-markingmethod')=="manual"){
         var key = $(this).attr('data-key')
         $('.open_draw_marking_modal').show();
         $('.open_draw_marking_modal').attr('data-key', key);
      } else {
         $('.open_draw_marking_modal').hide();
      }
   });
   /*  Canvas jquery local save image */
   $(document).on('click',".canvasSave_{{$practise_id_1}}" ,function() {
      var key = $(this).attr('data-key');
      $(".canvasSave_{{$practise_id_1}}").attr('disabled','disabled');
      var image=  canvas[key].canvasForExport().toDataURL().split(',')[1];
      var dataURL = "data:image/png;base64,"+image;
      $('.marking_comment_image:hidden').val(dataURL);
      $('.allow_draw').eq(key).hide();
      $(".getDrawMarkingImage").eq(key).attr('src', dataURL).show();
      $(".is_marking_file").eq(key).val(true)
      $(".getDrawMarkingImage").eq(key).css({  "width":"500", "object-fit":"content"});
   });
</script>

<script>
  jQuery(document).ready(function(){
   //  $('form').keydown(function(){
   //    return false;
   //  });
    $('.workrecord-disable').on('click',function(){
      //  $('.workrecord-disable').off('click');
      // alert();
      $('.workrecord-disable').css('pointer-events','none');
      // pointer-events: none;
    });
  });
  $(document).ready(function(){
      $(".rotate").click(function(){
        $(this).toggleClass("quarter");
      });
      $(".etra_options_buttons").click(function(){
        $(".etra_options").fadeToggle();
      });
      $(".rotate-expand-icon").click(function(){
        $(this).toggleClass("half");
      });
      $(".expand-collapse-course").click(function(){
        $(".expand-collapse-course").attr('title', 'Maximize');
        $(".cc").toggleClass("expanded-block");
        $(".cc").toggleClass("w-100");
        $(".cc").toggleClass("pr-0");
        $(".pc").toggle();
        $(".fc").toggle();
        $(".expand-collapse-course").toggleClass("Mimimize");
        $(".Mimimize").attr('title', 'Mimimize');
      });
      $(".expand-collapse-practice").click(function(){
        $(".expand-collapse-practice").attr('title', 'Maximize');
        $(".pc").toggleClass("expanded-block");
        $(".pc").toggleClass("w-100");
        $(".cc").toggle();
        $(".fc").toggle();
        $(".expand-collapse-practice").toggleClass("Mimimize");
        $(".Mimimize").attr('title', 'Mimimize');
      });
      $(".expand-collapse-feedback").click(function(){
        $(".expand-collapse-feedback").attr('title', 'Maximize');
        $(".fc").toggleClass("expanded-block");
        $(".fc").toggleClass("w-100");
        $(".pc").toggleClass("w-100");
        $(".cc").toggle();
        $(".pcs").toggle();
        $(".expand-collapse-feedback").toggleClass("Mimimize");
        $(".Mimimize").attr('title', 'Mimimize');
      });
    });
</script>

 <script>
    $(document).on('click', '.close__modal', function(){
      var isRecording = $('.close__modal').attr('recording');
      if(isRecording=='1'){
        $('.stopButton').trigger('click')
      } else {
        $('.new-audio-record-modal').modal('toggle')
      }
    });
    $(document).on('click', '.recordModalButton', function(){
      $('.animated__mic__icon').hide();
      $('.loader__icon').hide();
      $('.mic__icon').show();
      $('.new__record__button').show();
      $('.close__modal').attr('recording',0);
      $('.pauseButton').hide();
      $('.stopButton').hide();
      
      $('.new-audio-record-modal').modal({
          backdrop: 'static',
          keyboard: false
      });
      var data_key = $(this).attr('data-key');
      var data_que = $(this).attr('data-q');
      var prid = $(this).attr('data-pid')
      //  $('.new-audio-record-modal').modal('toggle');
      $('.new__record__button').attr('data-pid',prid );
      $('.new__record__button').addClass('active_recording');
      $('.new__record__button').attr('data-key', data_key );
      $('.new__record__button').attr('id', "record_audio"+data_key  )
      $('.audio__controls').find('button').removeClass('active');
      $('.new__stop__button').attr('data-pid', $(this).attr('data-pid') );
      $('.new__stop__button').attr('data-key', data_key );
      $('.new__stop__button').attr('id', "stop_recording"+data_key  );
      $('.new__pause__button').attr('data-pid', $(this).attr('data-pid') );
      $('.new__pause__button').attr('data-key', data_key );
      $('.new__pause__button').attr('id', "pause_recording"+data_key  );
      $('.new__resume__button').attr('data-pid', $(this).attr('data-pid') );
      $('.new__resume__button').attr('data-key', data_key );
      $('.new__resume__button').attr('id', "pause_recording"+data_key  );
      $('.audio__progress__success').css('width', '0%');
      $('.audio__progress__success').attr('data-width', 0);
      $('.audio__progress__remaining').css('width', '100%');
      $('.audio__progress__remaining').attr('data-width', 100);
      if( $.trim(data_que) != ""){
        $('.modal__question').show();
        $('.modal__question').html(data_que);
      } else{
        $('.modal__question').hide();
      }
    });
    $(document).on('click', '.new__record__button', function(){
      $('.close__modal').attr('recording',1);
      $('.mic__icon').hide();
      $('.animated__mic__icon').show();
      $('.new__record__button').hide();
      $('.new__stop__button, .new__pause__button').show();
    });
    $(document).on('click', '.new__stop__button', function(){
      $('.audio__controls').find('button').removeClass('active');
      $(this).addClass('active')
      $('.animated__mic__icon').hide();
      $('.mic__icon').hide();
      $('.loader__icon').show();
      $('.new__stop__button, .new__record__button, .new__pause__button, .new__resume__button').hide();
      var data_key = $('.new__record__button').attr('data-key' );
      var pid = $('.new__record__button').attr('data-pid' );
      $('.marking_answer_audio'+data_key).parent().find('.audioplayer-playpause').css('display', 'flex')
      $('.mic-icon-'+data_key).hide();
      $('.delete-recording').show();
      $('.plyr__control').show();
      var audio = document.getElementById('marking_audio1');
      audio.load(); 
    });
    $(document).on('click', '.new__pause__button', function(){
      $('.animated__mic__icon').hide();
      $('.mic__icon').show();
      $('.new__pause__button').hide();
      $('.new__resume__button').show();
    });
    $(document).on('click', '.new__resume__button', function(){
      $('.mic__icon').hide();
      $('.animated__mic__icon').show();
      $('.new__resume__button').hide();
      $('.new__pause__button').show();
    });
  </script>

<style>
/* .plyr__controls button{
   display:none !important;
} */
    .form-check{
      pointer-events:none;
    }
    .form-control-textarea{
      pointer-events:none;
    }
    .underline_text_list_item{
      pointer-events:none;
    }
    .vertical-set-order{
      pointer-events:none;
    }
    .form-slider{
      pointer-events:none;
    }
    .multiple-choice fieldset{
      pointer-events:auto;
    }
    fieldset{
      pointer-events:auto;
    }
    .table-can{
      pointer-events:none;
    }
    .table{
      pointer-events:none;
    }
    .multiple-choice{
      /*pointer-events:none;*/
    }
    .multiple-check{
      pointer-events:none;
    }
    .list-unstyled{
      pointer-events:none;
    }
    .draw-image{
      pointer-events:none;
    }
    .set_sequence{
      pointer-events:none;
    }
    .choice-box{
      pointer-events:none;
    }
    .writing_at_end_up_form-control{
      pointer-events:none;
    }
    .table-container{
      /*pointer-events:none;*/
    }
    .chat-left{
      pointer-events:none;
    }
    .input-marks-gained:disabled {
      background: #dddddd;
      color:red;
    }
</style>
@endsection
<!-- /. Course Book-->