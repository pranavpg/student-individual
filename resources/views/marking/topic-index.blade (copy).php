@extends('layouts.app') @section('content')

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<main class="course-book fullscreen ">
	<div class="container-fluid">
		<div class="row flex-wrap">

			<div class="speaking-course d-flex flex-wrap col-6">
				<div class="course-content course-content-1 bg-white" style="width:100%; height: calc(100% - 4rem); overflow:hidden; <?php if(isset($taskId) && !empty($taskId)){?> display:none; <?php }?>">
					<iframe id="iframe_aim1" src="{{ URL('topic_aim/'.$topic_tasks['id'])}}" scrolling="auto" frameborder="0" width="100%" style="min-height:100%"></iframe>
				</div>
				<div class="course-content bg-white course-content-2" style=" <?php if(isset($taskId) && !empty($taskId)){?>  <?php }else{?> display:none; <?php }?>">
					<div class="course-tab">
						<div class="course-tab-fixed-heading d-flex flex-wrap align-items-center">
							<ul class="nav nav-pills" id="pills-tab" role="tablist">
								<li class="nav-item"> <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Course Book</a> </li>
								<?php /*?>
									<li class="nav-item"> <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Teacher Book</a> </li>
									<?php */?>
							</ul>
						</div>
						<div class="course-tab-content ">
							<div class="tab-content" id="pills-tabContent" style="max-height:300px;">
								<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" style="height:100%;">
									<div style="width:100%; max-height:300px;">
										<?php
											echo $topic_tasks['description'];
										?>
									</div>
								</div>
								<!-- tab 1-->
								<?php /*?>
									<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...</div>
									<?php */?>
							</div>
							<!-- /. tab content-->
						</div>
					</div>
				</div>
				<div class="practice-content bg-white course-content">
					<?php
						$azRange = range('A', 'Z');
						if(isset($topic_tasks['practise'][0]['id'])){
						$practises = $topic_tasks['practise'][0]['id'];
						?>
						<div class="practice-tab course-tab">
							<div class="practice-content-heading course-tab-fixed-heading d-flex flex-wrap justify-content-between align-items-center">
								<ul class="nav nav-pills">
									<li class="nav-item"> <a class="nav-link active" href="javascript:void(0);">Practice Book</a> </li>
								</ul>
								<div class="abc-tab m-auto">
									<ul class="nav nav-pills text-uppercase align-items-center" id="abc-tab" role="tablist">

											<li class="nav-item">
												<a class="nav-link   active " id="abc-<?php echo $topic_tasks['practise'][0]['id'];?>-tab" data-toggle="pill" href="#abc-<?php echo $topic_tasks['practise'][0]['id'];?>" role="tab" aria-controls="abc-<?php echo $topic_tasks['practise'][0]['id'];?>" aria-selected="true">

												</a>
											</li>

									</ul>
								</div>
								<!-- /. abc tab-->
								<div class="heading-right">
									<ul class="list-inline">
										<li class="list-inline-item">
											<a href="javascript:void(0);"> <img src="{{ asset('public/images/icon-tab-edit.svg') }}" alt="edit" class="img-fluid"> </a>
										</li>
									</ul>
								</div>
							</div>
							<!-- /. practice heading-->
              <?php
            		//	pr($practises);die;
								$practise=$topic_tasks['practise'][0];
							//	pr($practise);
              ?>
							<div class="course-tab-content scrollbar">
								<div class="tab-content" id="abc-tabContent">

										<div class="tab-pane fade active show " id="abc-<?php echo $topic_tasks['practise'][0]['id'];?>" role="tabpanel" aria-labelledby="abc-<?php echo $topic_tasks['practise'][0]['id'];?>-tab" data-type="<?php echo $topic_tasks['practise'][0]['type'];?>">

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


												<div class="teacher-feedback">
													<form class="teacher-feedback-form">
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
													 <button type="button" class="teacherFeedbackSubmitBtn">Submit</button>
													</form>
												</div>

										</div>

											<!-- /. tab content-->
								</div>
							</div>
						</div>
						<?php }?>
				</div>
			</div>
		</div>
</main>

<div class="modal fade" id="erasemodal" tabindex="-1" role="dialog" aria-labelledby="erasemodalLongTitle">
	<div class="modal-dialog erase-modal modal-dialog-centered" role="document">
		<div class="modal-content">
		<div class="d-flex justify-content-end w-100"><button type="button" class="btn btn-secondary  btn-sm mb-2" data-dismiss="modal">&times;</button></div>
			<div class="modal-header justify-content-center">
				<h5 class="modal-title" id="erasemodalLongTitle">Reset Answers</h5>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to reset your answers</p>
			</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Yes</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function(){

		jQuery(".heading-right .list-inline-item a").attr("data-toggle","modal");
		jQuery(".heading-right .list-inline-item a").attr("data-target","#erasemodal");

		jQuery('#erasemodal').on('shown.bs.modal', function() {
			var currentActiveID = jQuery(".practice-tab.course-tab .abc-tab .nav-link.active").attr("href");
			currentActiveID = currentActiveID.replace("#abc-","");
			jQuery("#erasemodal .modal-footer button").first().attr("onclick","window.location='?reset="+currentActiveID+"'");
		})
	})
</script>


<script type="application/javascript">

function resizeIFrameToFitContent(iFrame) {
	iFrame.width = iFrame.contentWindow.document.body.scrollWidth;
	iFrame.height = iFrame.contentWindow.document.body.scrollHeight;
}
window.addEventListener('DOMContentLoaded', function(e) {
	var iFrame = document.getElementById('iframe_aim');
	if(iFrame !== null){
		resizeIFrameToFitContent(iFrame);
	}
	var iFrame2 = document.getElementById('iframe_aim2');
	if(iFrame2 !== null){
		resizeIFrameToFitContent(iFrame2);
	}
	var iframes = document.querySelectorAll("iframe_aim");
	for(var i = 0; i < iframes.length; i++) {
		resizeIFrameToFitContent(iframes[i]);
	}
	var iframes = document.querySelectorAll("iframe_aim2");
	for(var i = 0; i < iframes.length; i++) {
		resizeIFrameToFitContent(iframes[i]);
	}
});

$('.teacherFeedbackSubmitBtn').on('click', function(){
	$.ajax({
			url: '<?php echo URL('practice-submit-marking'); ?>',
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			type: 'POST',
			data: $('.teacher-feedback-form').serialize(),
			success: function (data) {

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

<?php if(isset($taskId) && !empty($taskId)){?>
	<script type="text/javascript">
	$("#fullscreen, .close-course-icon").click(function() {
		$(".course-content-2").toggle();
		$(".course-content-1").toggle();
	});
	$(".navigation.active").click(function() {
		$(".close-course-icon").trigger("click");
		return false;
	});
	</script>
	<script src="{{asset('public/student/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
	<script src="{{asset('public/student/js/audio-recorder/app-multiple.js')}}"></script>
	<script src="{{ asset('public/student/js/audioplayer.js') }}"></script>
	<script>
	$(function () {
		$('audio.practice_audio').audioPlayer();

	});
	</script>
	<?php }?> @endsection
