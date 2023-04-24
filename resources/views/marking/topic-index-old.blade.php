@extends('layouts.teacher-app') @section('content')

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

<main class="course-book fullscreen d-flex flex-wrap">
		<aside class="w-35 course-book__left">
				<div class="course-book-heading mb-4 d-flex flex-wrap align-items-center">
						<div class="close-course mr-4">
								<a href="{{ url()->previous() }}" class="close-course-icon"><img src="{{asset('public/images/icon-close-course.svg')}}" alt="X"
												class="img-fluid"></a>
						</div>
						<div class="heading__button">
								Student Name : {{$topic_tasks['student_name']}}
						</div>
				</div>
				<!-- /. Course book heading-->
				<div class="course-content bg-white" >
						<div class="course-tab-fixed-heading w-100 d-flex flex-wrap align-items-center">
								<ul class="nav nav-pills" id="pills-tab" role="tablist">
										<li class="nav-item">
												<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
														role="tab" aria-controls="pills-home" aria-selected="true">Course Book</a>
										</li>
										<li class="nav-item">
												<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
														role="tab" aria-controls="pills-profile" aria-selected="false">Teacher Book</a>
										</li>
								</ul>
								<div class="expand-option-course" >
								<ul class="list-inline">
									<li class="list-inline-item">
										<a href="javascript:void(0);" class="expand-collapse-course"> <img src="{{ asset('public/images/ic_expand.png') }}" alt="edit" class="img-fluid rotate-expand-icon"> </a>
									</li>
								</ul>
							</div>
						</div>

						<div class="course-tab-content">
								<div class="tab-content scrollbar" id="pills-tabContent">
										<div class="tab-pane fade show active" id="pills-home" role="tabpanel"
												aria-labelledby="pills-home-tab">
												<?php
													echo $topic_tasks['description'];
													$practise=$topic_tasks['practise'][0];
												?>
										</div>
								</div>
						</div>
				</div>
				<!-- /. Cousre Content-->

		</aside>
		<!-- /. Course book Left-->

		<div class="w-65 course-book__right">
				<div class="course-book-heading mb-4 d-flex flex-wrap justify-content-between align-items-center">
						<div class="heading__button">
								Topic {{$topicNumber}} - Task {{$taskNumber}}
						</div>
						<div class="heading__button">
							<?php
								$marks_gained = !empty($topic_tasks['practise'][0]['marks_gained'])?$topic_tasks['practise'][0]['marks_gained']:0;
								$out_of_marks = !empty($topic_tasks['practise'][0]['mark'])?$topic_tasks['practise'][0]['mark']:0;
							?>
								Total Task Marks : {{$marks_gained}}/{{$out_of_marks}}
						</div>
				</div>
				<!-- /. Course book heading-->
				<div class="course-content bg-white" id="top-book">
						<div class="course-tab-fixed-heading w-100 d-flex flex-wrap align-items-center justify-content-between" style="display:none">
								<div class="title">Practice Book</div>
								<!-- /. Title -->
								<?php
									$azRange = range('A', 'Z');
									$activeTaskKey=0;
									if(isset($topic_tasks['practise'])){
										$practises = $topic_tasks['practise'];
								?>
											<ul class="nav nav-pills pr-5" id="pills-teacher-tab" role="tablist">

												<?php foreach($practises as $i=>$practise){?>
													<li class="nav-item">
														<a class="nav-link <?php if($i == 0){ echo " active ";}?>" id="abc-<?php echo $practise['id'];?>-tab" data-toggle="pill" href="#abc-<?php echo $practise['id'];?>" role="tab" aria-controls="abc-<?php echo $practise['id'];?>" aria-selected="true">
															<?php echo $azRange[$i];?>
														</a>
													</li>
													<?php }?>
											</ul>
								<?php } ?>
								<!-- /. Teacher tab-->
								<div class="heading__extra_button">
										<a href="javascript:;" class="btn btn-secondary">
												<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" class="icon-pencil-svg">
														<defs />
														<path fill-rule="evenodd"
																d="M14.911 5.178l-.456.46-2.992-2.992.461-.46a1.289 1.289 0 011.822 0l1.17 1.169c.5.506.497 1.32-.005 1.823zM2.942 11.54l2.615 2.615-3.926 1.306 1.311-3.921zm3.414 2.198l-2.992-2.993 7.488-7.489 2.993 2.992-7.489 7.49zm7.996-12.159a2.152 2.152 0 00-3.04 0l-.76.766-8.1 8.095-.017.017c-.004.004-.004.009-.008.009-.009.013-.022.025-.03.038 0 .005-.005.005-.005.009l-.02.034c-.006.005-.006.009-.01.014l-.013.034c0 .004-.004.004-.004.009L.548 16.007a.423.423 0 00.103.439.435.435 0 00.443.103l5.4-1.802c.004 0 .004 0 .008-.004a.122.122 0 00.04-.017l.008-.004c.012-.009.03-.018.043-.026.012-.008.025-.021.038-.03.005-.005.01-.005.01-.009.003-.003.011-.008.016-.017l8.86-8.86c.838-.84.838-2.2 0-3.04l-1.165-1.161z" />
												</svg>
										</a>
								</div>
						</div>
						<?php
							// pr($topic_tasks['practise'][0]['type']);
						?>

						<div class="course-tab-content">
								<div class="tab-content scrollbar" id="pills-teacher--tabContent">
										<div class="tab-pane fade show active" id="pills-a" role="tabpanel" aria-labelledby="pills-a-tab">
												@if( $topic_tasks['practise'][0]['type'] == "one_blank_table" || $topic_tasks['practise'][0]['type'] == "two_blank_table" || $topic_tasks['practise'][0]['type'] == "three_blank_table" || $topic_tasks['practise'][0]['type'] == "four_blank_table" || $topic_tasks['practise'][0]['type'] == "five_blank_table" || $topic_tasks['practise'][0]['type'] == "six_blank_table" || $topic_tasks['practise'][0]['type'] == "two_blank_table_listening" || $topic_tasks['practise'][0]['type'] == "three_blank_table_listening" || $topic_tasks['practise'][0]['type'] == "four_blank_table_listening" || $topic_tasks['practise'][0]['type'] == "five_blank_table_listening" || $topic_tasks['practise'][0]['type'] == "six_blank_table_listening"  || $topic_tasks['practise'][0]['type'] == "two_blanks_table_listening" || $topic_tasks['practise'][0]['type'] == "three_blanks_table_listening" || $topic_tasks['practise'][0]['type'] == "four_blanks_table_listening" || $topic_tasks['practise'][0]['type'] == "five_blanks_table_listening" || $topic_tasks['practise'][0]['type'] == "six_blanks_table_listening" || $topic_tasks['practise'][0]['type'] == "one_table_option" || $topic_tasks['practise'][0]['type'] == "two_table_option" || $topic_tasks['practise'][0]['type'] == "three_table_option" || $topic_tasks['practise'][0]['type'] == "four_table_option" || $topic_tasks['practise'][0]['type'] == "five_table_option" || $topic_tasks['practise'][0]['type'] == "six_table_option" || $topic_tasks['practise'][0]['type'] == "one_blank_table_speaking" || $topic_tasks['practise'][0]['type'] == "one_table_option_speaking" || $topic_tasks['practise'][0]['type'] == "one_blank_table_speaking_up" || $topic_tasks['practise'][0]['type'] == "two_blank_table_speaking" || $topic_tasks['practise'][0]['type'] == "two_table_option_speaking" || $topic_tasks['practise'][0]['type'] == "two_blank_table_speaking_up" ||  $topic_tasks['practise'][0]['type'] == "three_blank_table_speaking" || $topic_tasks['practise'][0]['type'] == "three_table_option_speaking" || $topic_tasks['practise'][0]['type'] == "three_blank_table_speaking_up" || $topic_tasks['practise'][0]['type'] == "four_blank_table_speaking" || $topic_tasks['practise'][0]['type'] == "four_table_option_speaking" || $topic_tasks['practise'][0]['type'] == "four_blank_table_speaking_up" || $topic_tasks['practise'][0]['type'] == "five_blank_table_speaking" || $topic_tasks['practise'][0]['type'] == "five_table_option_speaking" || $topic_tasks['practise'][0]['type'] == "five_blank_table_speaking_up" || $topic_tasks['practise'][0]['type'] == "six_blank_table_speaking" || $topic_tasks['practise'][0]['type'] == "six_table_option_speaking" || $topic_tasks['practise'][0]['type'] == "six_blank_table_speaking_up" || $topic_tasks['practise'][0]['type'] == "seven_blank_table_speaking" || $topic_tasks['practise'][0]['type'] == "seven_table_option_speaking" || $topic_tasks['practise'][0]['type'] == "seven_blank_table_speaking_up" || $topic_tasks['practise'][0]['type'] == "eight_blank_table_speaking" || $topic_tasks['practise'][0]['type'] == "eight_table_option_speaking" || $topic_tasks['practise'][0]['type'] == "eight_blank_table_speaking_up" || $topic_tasks['practise'][0]['type'] == "nine_blank_table_speaking" || $topic_tasks['practise'][0]['type'] == "nine_table_option_speaking" || $topic_tasks['practise'][0]['type'] == "nine_blank_table_speaking_up" || $topic_tasks['practise'][0]['type'] == "ten_blank_table_speaking" || $topic_tasks['practise'][0]['type'] == "ten_table_option_speaking" || $topic_tasks['practise'][0]['type'] == "ten_blank_table_speaking_up" || $topic_tasks['practise'][0]['type'] == "one_table_option_listening" || $topic_tasks['practise'][0]['type'] == "two_table_option_listening" || $topic_tasks['practise'][0]['type'] == "three_table_option_listening" || $topic_tasks['practise'][0]['type'] == "four_table_option_listening" || $topic_tasks['practise'][0]['type'] == "five_table_option_listening" || $topic_tasks['practise'][0]['type'] == "six_table_option_listening" || $topic_tasks['practise'][0]['type'] == "six_blank_table_true_false" || $topic_tasks['practise'][0]['type'] == "two_table_option_speaking_up"  || $topic_tasks['practise'][0]['type'] == "two_blank_table_up_writing_at_end_up")
												@include('practice.blank_tables')
											@elseif($topic_tasks['practise'][0]['type'] == "writing_at_end_up"   ||  $topic_tasks['practise'][0]['type']=='Writing')
												@include('practice.writing_at_end_up')
											@elseif($topic_tasks['practise'][0]['type'] == "writing_at_end_up_listening")
												@include('practice.writing_at_end_up_listening')
											@elseif($topic_tasks['practise'][0]['type'] == "reading_no_blanks_listening")
												@include('practice.reading_no_blanks_listening')
											@elseif( $topic_tasks['practise'][0]['type'] == "true_false_listening" || $topic_tasks['practise'][0]['type'] == "true_false" )
												@include('practice.true_false_listening')
											@elseif($topic_tasks['practise'][0]['type'] == "listening_writing")
												@include('practice.listening_writing')
											@elseif($topic_tasks['practise'][0]['type'] == "two_blank_table_speaking" || $topic_tasks['practise'][0]['type'] == "two_table_option_speaking" || $topic_tasks['practise'][0]['type'] == "three_blank_table_speaking" || $topic_tasks['practise'][0]['type'] == "three_table_option_speaking" || $topic_tasks['practise'][0]['type'] == "two_blank_table_speaking_up" || $topic_tasks['practise'][0]['type'] == "five_blank_table_speaking_up" || $topic_tasks['practise'][0]['type'] =="four_blank_table_speaking_up")
												@include('practice.blank_tables_speaking')
											@elseif($topic_tasks['practise'][0]['type'] == "speaking_writing" || $topic_tasks['practise'][0]['type'] == "speaking_writing_up" || $topic_tasks['practise'][0]['type'] == "writing_at_end_speaking_up"  )
												@include('practice.speaking_writing')
											@elseif($topic_tasks['practise'][0]['type'] == "true_false_speaking_simple" || $topic_tasks['practise'][0]['type'] == "true_false_simple_left_align_listening" ||  $topic_tasks['practise'][0]['type'] == "true_false_speaking_up")
												@include('practice.true_false_speaking')
											@elseif($topic_tasks['practise'][0]['type'] == "true_false_writing_at_end" ||   $topic_tasks['practise'][0]['type'] == "true_false_speaking_writing_simple" ||   $topic_tasks['practise'][0]['type'] == "true_false_writing_at_end_simple" )
												@include('practice.true_false_writing_at_end')
											@elseif( $topic_tasks['practise'][0]['type'] == "underline_text"   )
												@include('practice.underline_text')
											@elseif( $topic_tasks['practise'][0]['type'] == "underline_text_writing_at_end"  )
												@include('practice.underline_text_writing_at_end')
											@elseif( $topic_tasks['practise'][0]['type'] == "underline_text_writing" )
												@include('practice.underline_text_writing')

											@elseif( $topic_tasks['practise'][0]['type'] == "writing_at_end_speaking_multiple" || $topic_tasks['practise'][0]['type'] == "writing_at_end_speaking_multiple_up"  || $topic_tasks['practise'][0]['type'] == "writing_at_end_speaking_multiple_up_listening" )
												@include('practice.writing_at_end_speaking_multiple')

											@elseif( $topic_tasks['practise'][0]['type'] == "multiple_tick")
												@include('practice.multiple_tick')
											@elseif($topic_tasks['practise'][0]['type'] == "set_in_order_vertical_listening")
												@include('practice.set_in_order_vertical_listening')
											@elseif($topic_tasks['practise'][0]['type'] == "true_false_listening_symbol")
												@include('practice.true_false_listening_symbol')
												@elseif($topic_tasks['practise'][0]['type'] == "multi_choice_question"  || $topic_tasks['practise'][0]['type'] == "multi_choice_question_listening")
												@include('practice.multi_choice_question')
											@elseif($topic_tasks['practise'][0]['type'] == "writing_at_end_option" || $topic_tasks['practise'][0]['type'] == "writing_at_end" || $topic_tasks['practise'][0]['type'] == "writing_at_end_listening"  )
												@include('practice.writing_at_end_option')
											@elseif( $topic_tasks['practise'][0]['type'] == "writing_at_end_speaking")
												@include('practice.writing_at_end_speaking')
											@elseif($topic_tasks['practise'][0]['type'] == "reading_no_blanks_no_space")
												@include('practice.reading_no_blanks_no_space')
											@elseif($topic_tasks['practise'][0]['type'] == "listening_speaking")
												@include('practice.listening_speaking')
											@elseif( $topic_tasks['practise'][0]['type'] == "speaking_multiple_up")
												@include('practice.speaking_multiple_up')
											@elseif($topic_tasks['practise'][0]['type'] == "true_false_symbol_reading" )
												@include('practice.true_false_symbol_reading')
											@elseif($topic_tasks['practise'][0]['type'] == "two_blank_table_up_writing_at_end")
												@include('practice.two_blank_table_up_writing_at_end')
											@elseif($topic_tasks['practise'][0]['type'] == "three_blank_table_writing_at_end")
												@include('practice.three_blank_table_writing_at_end')
											@elseif($topic_tasks['practise'][0]['type'] == "writing_at_end_up_speaking_up" )
												@include('practice.writing_at_end_up_speaking_up')
											@elseif($topic_tasks['practise'][0]['type'] == "single_image_writing_at_end" )
												@include('practice.single_image_writing_at_end')
											@elseif($topic_tasks['practise'][0]['type'] == "true_false_radio" || $topic_tasks['practise'][0]['type'] =="true_false_radio_listening" )
												@include('practice.true_false_radio')
											@elseif( $topic_tasks['practise'][0]['type'] == "speaking_multiple_listening" || $topic_tasks['practise'][0]['type'] == "speaking_multiple" )
												@include('practice.speaking_multiple_listening')
											@elseif( $topic_tasks['practise'][0]['type'] == "match_answer_single_image" ||  $topic_tasks['practise'][0]['type'] == "match_answer" || $topic_tasks['practise'][0]['type'] == "match_answer_listening_image" || $topic_tasks['practise'][0]['type'] == "match_answer_listening"  || $topic_tasks['practise'][0]['type'] == "match_answer_image" || $topic_tasks['practise'][0]['type'] == "match_answer_speaking"  )
												@include('practice.match_answer_single_image')
											@elseif($topic_tasks['practise'][0]['type'] == "true_false_listening_simple")
												@include('practice.true_false_listening_simple')
											@elseif($topic_tasks['practise'][0]['type'] == "writing_at_end_up_single_underline_text"  )
												@include('practice.writing_at_end_up_single_underline_text')
											@elseif($topic_tasks['practise'][0]['type'] == "underline_text_multiple"  )
												@include('practice.underline_text_multiple')
											@elseif( $topic_tasks['practise'][0]['type'] == "single_speaking_writing" || $topic_tasks['practise'][0]['type'] == "single_speaking_up_writing")
												@include('practice.single_speaking_writing')
											@elseif($topic_tasks['practise'][0]['type'] == "multi_choice_question_multiple" )
												@include('practice.multi_choice_question_multiple')
											@elseif($topic_tasks['practise'][0]['type'] == "single_image_writing_at_end_speaking_up")
												@include('practice.single_image_writing_at_end_speaking_up')
											@elseif($topic_tasks['practise'][0]['type'] == "can_do_statements")
												@include('practice.can_do_statements')
											@elseif($topic_tasks['practise'][0]['type'] == "multi_choice_question_up_writing_at_end" || $topic_tasks['practise'][0]['type'] == "multi_choice_question_writing_at_end_up_listening")
												@include('practice.multi_choice_question_up_writing_at_end')
											@elseif($topic_tasks['practise'][0]['type'] == "image_box_writing" || $topic_tasks['practise'][0]['type'] == "image_two_box_writing")
												@include('practice.image_box_writing')
											@elseif($topic_tasks['practise'][0]['type'] == "create_quiz")
												@include('practice.create_quiz')
											@elseif($topic_tasks['practise'][0]['type'] == "conversation_simple_multi_blank")
												@include('practice.conversation_simple_multi_blank')
											@elseif($topic_tasks['practise'][0]['type'] == "listening_tick" || $topic_tasks['practise'][0]['type'] == "multiple_tick_listening")
												@include('practice.multiple_tick_listening')
											@elseif($topic_tasks['practise'][0]['type'] == "image_reading_no_blanks_no_space")
												@include('practice.image_reading_no_blanks_no_space')
											@elseif($topic_tasks['practise'][0]['type'] == "draw_image_writing")
												@include('practice.draw_image_writing')
											@elseif($topic_tasks['practise'][0]['type'] == "drag_drop")
												@include('practice.drag_drop')
											@elseif($topic_tasks['practise'][0]['type'] == "hide_show_answer_speaking_up")
												@include('practice.hide_show_answer_speaking_up')
											@elseif($topic_tasks['practise'][0]['type'] == "draw_image_speaking")
												@include('practice.draw_image_speaking')
											@elseif($topic_tasks['practise'][0]['type'] == "underline_text_listening" )
												@include('practice.underline_text_listening')
											@elseif( $topic_tasks['practise'][0]['type'] == "true_false_symbol_speaking")
												@include('practice.true_false_symbol_speaking')
											@elseif( $topic_tasks['practise'][0]['type'] == "writing_at_start" )
												@include('practice.writing_at_start')
											@elseif( $topic_tasks['practise'][0]['type'] == "true_false_speaking_up_simple" )
												@include('practice.true_false_speaking_up_simple')
											@elseif( $topic_tasks['practise'][0]['type'] == "writing_at_end_speaking_multiple_record_video" )
												@include('practice.writing_at_end_speaking_multiple_record_video')
											@elseif( $topic_tasks['practise'][0]['type'] == "writing_at_end_up_speaking_multiple" || $topic_tasks['practise'][0]['type'] == "writing_at_end_up_speaking_multiple_up")
												@include('practice.writing_at_end_up_speaking_multiple')
											@elseif( $topic_tasks['practise'][0]['type'] == "multi_image_option")
												@include('practice.multi_image_option')

											@elseif( $topic_tasks['practise'][0]['type'] == "multi_image_selection")
												@include('practice.multi_image_selection')
											@elseif( $topic_tasks['practise'][0]['type'] == "multi_image_writing_at_start_up_end")
												@include('practice.multi_image_writing_at_start_up_end')
											@elseif( $topic_tasks['practise'][0]['type'] == "single_speaking_up_conversation_simple_view")
												@include('practice.single_speaking_up_conversation_simple_view')
											@elseif( $topic_tasks['practise'][0]['type'] == "speaking_multiple_single_writing")
												@include('practice.speaking_multiple_single_writing')
											@elseif( $topic_tasks['practise'][0]['type'] == "speaking_multiple_single_image")
												@include('practice.speaking_multiple_single_image')
											@elseif( $topic_tasks['practise'][0]['type'] == "single_image_writing_at_end_speaking")
												@include('practice.single_image_writing_at_end_speaking')
											@elseif( $topic_tasks['practise'][0]['type'] == "set_in_sequence")
												@include('practice.set_in_sequence')
											@elseif( $topic_tasks['practise'][0]['type'] == "multi_choice_question_multiple_speaking")
												@include('practice.multi_choice_question_multiple_speaking')
											@elseif( $topic_tasks['practise'][0]['type'] == "multi_choice_question_writing_at_end_no_option")
												@include('practice.multi_choice_question_writing_at_end_no_option')
											@elseif( $topic_tasks['practise'][0]['type'] == "draw_image_listening" || $topic_tasks['practise'][0]['type'] == "draw_image")
												@include('practice.draw_image_listening')
											@elseif( $topic_tasks['practise'][0]['type'] == "draw_image_writing_at_end" )
												@include('practice.draw_image_writing_at_end')
											@elseif( $topic_tasks['practise'][0]['type'] == "multi_choice_question_self_marking")
												@include('practice.multi_choice_question_self_marking')
											@elseif( $topic_tasks['practise'][0]['type'] == "underline_text_multi_color"   )
												@include('practice.underline_text_multi_color')
											@elseif( $topic_tasks['practise'][0]['type'] == "single_tick"   )
												@include('practice.single_tick')
											@elseif( $topic_tasks['practise'][0]['type'] == "true_false_a_g"   )
												@include('practice.true_false_a_g')
											@elseif( $topic_tasks['practise'][0]['type'] == "true_false_correct_incorrect"   )
												@include('practice.true_false_correct_incorrect')


											<!-- AES Practice  plesee Don't edit  -->

											@elseif($topic_tasks['practise'][0]['type'] == "conversation_simple_multi_blank_no_submit")
												@include('practice.conversation_simple_multi_blank_no_submit')
											@elseif($topic_tasks['practise'][0]['type'] == "draw_image_writing_email")
												@include('practice.draw_image_writing_email')
											@elseif($topic_tasks['practise'][0]['type'] == "record_video")
												@include('practice.record_video')
											@elseif($topic_tasks['practise'][0]['type'] == "single_tick_reading")
												@include('practice.single_tick_reading')
											@elseif($topic_tasks['practise'][0]['type'] == "single_tick_speaking")
												@include('practice.single_tick_speaking')
											@elseif($topic_tasks['practise'][0]['type'] == "true_false_simple")
												@include('practice.true_false_simple')
											@elseif($topic_tasks['practise'][0]['type'] == "true_false_symbol")
												@include('practice.true_false_symbol')
											@elseif($topic_tasks['practise'][0]['type'] == "true_false_writing_at_end_select_option")
												@include('practice.true_false_writing_at_end_select_option')
											@elseif($topic_tasks['practise'][0]['type'] == "true_false_writing_at_end_all_symbol")
												@include('practice.true_false_writing_at_end_all_symbol')
											@elseif($topic_tasks['practise'][0]['type'] == "hide_show_answer")
												@include('practice.hide_show_answer')
											@elseif($topic_tasks['practise'][0]['type'] == "speaking_up_option")
												@include('practice.speaking_up_option')
											<!-- Amit -->
											@elseif($topic_tasks['practise'][0]['type'] == "true_false_listening_simple")
												@include('practice.true_false_listening_simple')
											@elseif($topic_tasks['practise'][0]['type'] == "multi_choice_question_speaking_up")
												@include('practice.multi_choice_question_speaking_up') --}}
											@elseif($topic_tasks['practise'][0]['type'] == "four_blank_table_speaking_writing")
																									@include('practice.four_blank_table_speaking_writing')
																							@elseif($topic_tasks['practise'][0]['type'] == "three_blank_table_speaking_up")
																									@include('practice.three_blank_table_speaking_up')
																							@elseif($topic_tasks['practise'][0]['type'] == "LISTENING")
																									@include('practice.listening')
																							@elseif($topic_tasks['practise'][0]['type'] == "reading_total_blanks_speaking_up")
																									@include('practice.reading_total_blanks_speaking_up')
																							@elseif($topic_tasks['practise'][0]['type'] == "single_tick_writing")
																									@include('practice.single_tick_writing')
																							@elseif($topic_tasks['practise'][0]['type'] == "match_answer_writing")
																									@include('practice.match_answer_writing')
																							@elseif($topic_tasks['practise'][0]['type'] == "reading_no_blanks_listening_speaking_down")
																									@include('practice.reading_no_blanks_listening_speaking_down')
																							@elseif($topic_tasks['practise'][0]['type'] == "reading_blank_listening")
																									@include('practice.reading_blank_listening')
																							@elseif($topic_tasks['practise'][0]['type'] == "multiple_tick_writing")
																									@include('practice.multiple_tick_writing')
																							@elseif($topic_tasks['practise'][0]['type'] == "underline_text_speaking_down")
																									@include('practice.underline_text_speaking_down')
																							<!-- @elseif($topic_tasks['practise'][0]['type'] == "underline_text_writing_at_end_multi_color")
																									@include('practice.underline_text_writing_at_end_multi_color') -->
																							@elseif($topic_tasks['practise'][0]['type'] == "upload_ppt")
																									@include('practice.upload_ppt')
																							@elseif($topic_tasks['practise'][0]['type'] == "writing_lines")
																									@include('practice.writing_lines')
																							@elseif($topic_tasks['practise'][0]['type'] == "writing_edit")
												@include('practice.writing_edit')
												@elseif($topic_tasks['practise'][0]['type'] == "writing_word_count")
																									@include('practice.writing_word_count')
												<!-- --------------- End AES ---------------- -->

											@else
												<?php echo '<p>'.$topic_tasks['practise'][0]['type'].'</p>';?>
											@endif
											<br/>
											<div class="teacher-feedback" style="display:none" >
												<form class="teacher-feedback-form-old">
													<input type="hidden" name="student_id" value="{{$studentId}}" >
													<input type="hidden" name="practice_id" value="{{$practice_id}}" >

													<input type="hidden" name="answers[0][answer_id]" value="{{$topic_tasks['practise'][0]['answer_id']}}" >

													<p>	Marks Gained <input type="text" name="answers[0][marks_gained]" value="" >/5</p>
													@include('practice.common.audio_record_div')
													<p>	Task Performance <input type="text" name="teacher_emoji" value="" >/5</p>

													<div class="form-group">
														<p>Overall Feedback</p>
														 <textarea name="teacher_comment" class="form-control" value=""></textarea>
												 </div>
												 <div class="alert alert-success" role="alert" style="display:none"></div>
												 <div class="alert alert-danger" role="alert" style="display:none"></div>
												 <button type="button" class="teacherFeedbackSubmitBtn">Submit</button>

												 <!-- test------------------------------------->


												</form>
											</div>
											<form class="teacher-feedback-form">
												<input type="hidden" name="student_id" value="{{$studentId}}" >
												<input type="hidden" name="practice_id" value="{{$practice_id}}" >
												<input type="hidden" name="answers[0][answer_id]" value="{{$topic_tasks['practise'][0]['answer_id']}}" >
												<input type="hidden" name="teacher_emoji" class="teacher_emoji" value="0" >
												<div class="performance-marking mb-4 d-flex flex-wrap" style="display:none !important;">
														<div class="col-6 performance-rating">
																<div class="performance-box d-flex flex-wrap align-items-center justify-content-center">
																		<p>Perormance:</p>
																		<ul class="list-inline list-rating ml-3">
																				<li class="list-inline-item">
																						<a href="javascript:;">
																								<img src="{{asset('public/images/icon-bad.svg')}}" alt="" class="active">
																								<img src="{{asset('public/images/icon-bad-gray.svg')}}" alt="" class="inactive">
																						</a>
																				</li>
																				<li class="list-inline-item">
																						<a href="javascript:;">
																								<img src="{{asset('public/images/icon-neutral.svg')}}" alt="" class="active">
																								<img src="{{asset('public/images/icon-neutral-gray.svg')}}" alt="" class="inactive">
																						</a>
																				</li>
																				<li class="list-inline-item">
																						<a href="javascript:;">
																								<img src="{{asset('public/images/icon-happy.svg')}}" alt="" class="active">
																								<img src="{{asset('public/images/icon-happy-gray.svg')}}" alt="" class="inactive">
																						</a>
																				</li>
																				<li class="list-inline-item">
																						<a href="javascript:;">
																								<img src="{{asset('public/images/icon-very-happy.svg')}}" alt="" class="active">
																								<img src="{{asset('public/images/icon-very-happy-gray.svg')}}" alt="" class="inactive">
																						</a>
																				</li>
																		</ul>
																</div>
														</div>
														<div class="col-6 performance-rating">
																<div
																		class="performance-box d-flex flex-wrap align-items-center justify-content-center">
																		<p>Total Task Marks:</p>
																		<div class="editable-box ml-3 form-group d-flex align-items-center">
																				<input type="text" class="form-control" name="answers[0][marks_gained]" > <span class="task-marks ml-2">/
																						1</span>
																		</div>
																</div>
														</div>
												</div>

												<footer class="tab-footer d-flex flex-wrap justify-content-center mb-4" style="">
													<div class="col-6 overall-feedback">
															<!-- <div class="d-flex flex-wrap w-100 align-items-center">
																	<p>Put Your audio call plugin code here. I will apply css once you implement it.
																	</p>
															</div> -->
													</div>
													<div class="col-6 overall-feedback">
															<div
																	class="editable-box ml-auto mr-auto w-100 d-flex align-items-center flex-wrap justify-content-center">
																	<div class="form-group mb-0 d-flex align-items-center">
																			<input type="text" class="form-control" name="answers[0][marks_gained]"><span class="task-marks ml-2">/
																					5</span>
																	</div>

																	<a href="javascript:;" class="btn toggle-feedback btn-primary ml-4">Save</a>
															</div>
													</div>
												</footer>

										</div>

								</div>
						</div>
				</div>
				<!-- /. Cousre Content-->
				<div class="course-content course-tab-content_ranking bg-white" id="bottom-book">
						<div class="expand-option-course">
								<ul class="list-inline">
									<li class="list-inline-item">
										<a href="javascript:void(0);" class="expand-collapse-course"> <img src="https://student.englishapp.uk/public/images/ic_expand.png" alt="edit" class="img-fluid rotate-expand-icon"> </a>
									</li>
								</ul>
							</div>
						<div class="d-flex flex-wrap">
								<div class="col-6 overall-feedback">
										<h3>Overall Feedback</h3>
										<div class="d-flex flex-wrap w-100 align-items-center">
												@include('practice.common.audio_record_div')
										</div>
								</div>
								<!-- /. Overall Feedback-->
								<div class="col-6 overall-feedback text-center">
										<h3>Overall Task Performance</h3>
										<ul class="list-inline list-rating d-flex flex-wrap justify-content-center">
												<li class="list-inline-item">
														<a href="javascript:;" class="select_teacher_emoji" data-teacherEmoji="4">
																<img src="{{asset('public/images/icon-bad.svg')}}" alt="" class="active">
																<img src="{{asset('public/images/icon-bad-gray.svg')}}" alt="" class="inactive">
														</a>
												</li>
												<li class="list-inline-item">
														<a href="javascript:;" class="select_teacher_emoji" data-teacherEmoji="3">
																<img src="{{asset('public/images/icon-neutral.svg')}}" alt="" class="active">
																<img src="{{asset('public/images/icon-neutral-gray.svg')}}" alt="" class="inactive">
														</a>
												</li>
												<li class="list-inline-item">
														<a href="javascript:;" class="select_teacher_emoji" data-teacherEmoji="2">
																<img src="{{asset('public/images/icon-happy.svg')}}" alt="" class="active">
																<img src="{{asset('public/images/icon-happy-gray.svg')}}" alt="" class="inactive">
														</a>
												</li>
												<li class="list-inline-item">
														<a href="javascript:;" class="select_teacher_emoji" data-teacherEmoji="1">
																<img src="{{asset('public/images/icon-very-happy.svg')}}" alt="" class="active">
																<img src="{{asset('public/images/icon-very-happy-gray.svg')}}" alt="" class="inactive">
														</a>
												</li>
										</ul>
								</div>
								<!-- /. Overall Feedback-->

								<div class="col-12 overall-feedback">
										<h3>Overall Comment</h3>
										<div class="d-flex flex-wrap align-items-center">
												<div class="form-group flex-grow-1 mr-4 mb-0">
														<input type="text" class="form-control" name="teacher_comment">
												</div>
												<div class="alert alert-success" role="alert" style="display:none"></div>
												<div class="alert alert-danger" role="alert" style="display:none"></div>
												<a href="javascript:;" class="btn btn-primary teacherFeedbackSubmitBtn">Submit</a>
										</div>
								</div>
							</form>
						</div>
				</div>

		</div>
</main>


<script type="application/javascript">
$('ul.list-inline.list-buttons').remove();
$('.teacherFeedbackSubmitBtn').on('click', function(){
	$.ajax({
		url: '<?php echo URL('practice-submit-marking'); ?>',
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		type: 'POST',
		data: $('.teacher-feedback-form').serialize(),
		success: function (data) {
			if(data.success) {
				$('.teacher-feedback-form').trigger("reset");
	          	$('.alert-danger').hide();
	          	$('.alert-success').show().html(data.message).fadeOut(4000);
				setTimeout(function () {
					location.reload();
				},2000)
	        } else {
	          $('.alert-success').hide();
	          $('.alert-danger').show().html(data.message).fadeOut(4000);
	        }
		}
	});
})
</script>
<script>

	var token = $('meta[name=csrf-token]').attr('content');
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
    var practise_id = $('.practise_id:hidden').val();
    $.ajax({
        url: '<?php echo URL('delete-audio'); ?>',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: {practice_id:practise_id},
        success: function (data) {

        }
    });
  });
</script>


<script src="{{asset('public/student/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
<script src="{{asset('public/student/js/audio-recorder/app-multiple.js')}}"></script>
<script src="{{ asset('public/student/js/audioplayer.js') }}"></script>
<script>
	$(function () {
		$('audio.practice_audio').audioPlayer();
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
	})
</script>
@endsection
