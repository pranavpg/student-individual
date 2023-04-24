@extends('layouts.app') @section('content')

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<style>
.form-check{
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
	pointer-events:none;
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
.mobile-header {
	display: none !important;
}

</style>
<input type="hidden" name="new_marks"  id="new_marks" value="{{ $one }}">
<input type="hidden" name="new_marks_gained" id="new_marks_gained" value="{{ $two }}">
<main class="course-book <?php clearstatcache(); if(isset($taskId) && !empty($taskId)){?>fullscreen<?php }?>" style="background-color:#ffffff;padding: 0;">
	<div class="container-fluid" style="">
		<div class="row flex-wrap">
			<div class="course-book-navigation d-flex flex-wrap" style="display:none !important">
				<div class="row w-100">
					<div class="say-hello col-12 col-md-3 col-lg-5 col-xl-6"> <a href="">Back</a>
						<h1><?php echo $topic_tasks[0]['title'];?></h1>
						<picture class="picture d-flex"> <img src="<?php echo $topic_tasks[0]['image'];?>" alt="<?php echo $topic_tasks[0]['title'];?>" class="img-fluid rounded-lg"> </picture>
					</div>
					<div class="book-navigation col-12 col-md-9 col-lg-7 col-xl-6">
						<div class="close-course">
							<a href="javascript:void(0);" class="close-course-icon"><img src="{{ asset('public/images/icon-close-course.svg') }}" alt="X" class="img-fluid"></a>
						</div> <a href="javascript:void(0);" class="navigation <?php if(isset($taskId) && !empty($taskId)){?> <?php }else{?>active<?php }?>">
                                AIM
                                <span>
                                    <img src="{{ asset('public/images/icon-right-circle.svg') }}" alt="" class="img-fluid">
                                </span>
                            </a>
						<?php
							$activeTaskKey = '';
							//pr($topic_tasks[0]['tasks']);
							foreach($topic_tasks[0]['tasks'] as $taskKey=>$task){?>
									<a  href="<?php echo URL('topic/'.$topic_tasks[0]['id'].'/'.$task['id']);?>" class="navigation  <?php if(isset($taskId) && !empty($taskId) && $taskId == $task['id']){ $activeTaskKey = $taskKey;?>active<?php }?>"> <small>T<?php echo $task['sorting'];?></small> <strong><?php echo $task['name'];?></strong> <span>
                                    <img src="{{ asset('public/images/icon-right-circle.svg') }}" alt="" class="img-fluid">
                                </span>
														</a>
							<?php }?>
					</div>
				</div>
			</div>	
			<div class="speaking-course col-12 pl-0 pr-0">

				<div class="practice-content course-content ieukpb-cucmob" style="height: 100% !important;margin: 0;background-color: #f9f9f9;">
					<?php
						$azRange = range('A', 'Z');
						if(isset($topic_tasks[0]['tasks'][$activeTaskKey]['practise'])){
						$practises = $topic_tasks[0]['tasks'][$activeTaskKey]['practise'];
						?>
						<div class="practice-tab course-tab">
							<div style="display:none !important;" class="">
								<ul class="nav nav-pills">
									<li class="nav-item"> <a class="nav-link active ieukpb-btnmain" href="javascript:void(0);">Practice Book</a> </li>
								</ul>
								<div class="abc-tab m-auto">
									<ul class="nav nav-pills text-uppercase align-items-center ieukpb-abcul" id="abc-tab" role="tablist">
										<?php foreach($practises as $i=>$practise){?>
											<li class="nav-item">
												<a class="nav-link <?php if($i == 0){ echo " active ";}?>" id="abc-<?php echo $practise['id'];?>-tab" data-toggle="pill" href="#abc-<?php echo $practise['id'];?>" role="tab" aria-controls="abc-<?php echo $practise['id'];?>" aria-selected="true">
													<?php echo $azRange[$i];?>
												</a>
											</li>
											<?php }?>
									</ul>
								</div>
								<!-- /. abc tab-->

							</div>
							<!-- /. practice heading-->
           
							<div class="course-tab-content p-3 h-100">
								<div class="tab-content" id="abc-tabContent">
									<?php foreach($practises as $i=>$practise){

									if(!empty(request()->get('reset'))){
										if($practise['id'] == request()->get('reset')){
											unset($practise['user_answer']);
										}
									}

									?>
									<?php
									  	$is_automated = false;
									  	if($practise['markingmethod'] == "automated") {
									    	$practise['markingmethod'] = "student_self_marking";
									    	$is_automated = true;
									  	}
                                     ?>
										<div class="tab-pane fade <?php if($practise['id'] == $practiceId){ echo " active show ";}?>" id="abc-<?php echo $practise['id'];?>" role="tabpanel" aria-labelledby="abc-<?php echo $practise['id'];?>-tab">

												@include('common.all-practice-list')
												
												@if($practise['correctanswer'])
														
														@if($practise['type'] == 'set_in_order_vertical' || $practise['type'] == 'set_in_order_vertical_listening' )
														   <span style="color:black; font-weight:bold">Answers:</span><br>
															<?php 
																$explodQuestion=explode(PHP_EOL,$practise['question']);

																if(empty($practise['question']) && !empty($practise['depending_practise_details']['question'])){

																	$userAnswer = $practise['dependingpractise_answer'];
																	if(isset($userAnswer[0]) && !empty($userAnswer[0]) && str_contains($userAnswer[0],';')){
																		$userAnswer = explode(";",$userAnswer[0]);
																	}else{
																		if(isset($userAnswer) && !empty($userAnswer) && str_contains($userAnswer,';')){
																			$userAnswer = explode(";",$userAnswer);
																		}else{
																			$userAnswer=[];
																		}                           
																	}
																	$questions= explode("\r\n", $practise['depending_practise_details']['question']);
																	//pr($userAnswer);
																	$c = 0;
																	foreach($questions as $key => $value)
																	{

																					if(str_contains($value,'@@')){
																						$value= str_replace("<br>"," ",$value);
																				//$outValue = str_replace('@@', $str, $value);
																				$outValue[] = preg_replace_callback('/@@/',
																													function ($m) use (&$key, &$c, &$userAnswer) {
																														$ans= !empty($userAnswer[$c])?trim($userAnswer[$c]):"";
																														$str = $ans;
																														$c++;
																														return $str;
																													}, $value);
																					}

																	}
																	//pr($outValue);
																	$explodQuestion=$outValue;
																}else{
																	$explodQuestion=explode(PHP_EOL,$practise['question']);
																}
																$explodAnswer=explode(';',$practise['correctanswer']);
																	foreach($explodAnswer as $val){
																		$i=0;
																		$i= intval($val)-1;
																		if(isset($explodQuestion[$i])){
																			echo ($explodQuestion[$i]).'<br/><br/>';
		
																		}
																	}
																
															
															
															?>
														
														@elseif($practise['type'] == 'true_false_radio')
														<span style="color:black; font-weight:bold">Answers:</span><br>
														<?php //echo '<pre>'; print_r($practise);  
														if(isset($practise['correctanswer']) && !empty($practise['correctanswer']) && isset($practise['question']) && !empty($practise['question'])){
															$question = explode(PHP_EOL,$practise['question']);
															$correctAnswer= explode(';',$practise['correctanswer']);
															array_pop($correctAnswer);
															foreach($correctAnswer as $key=> $answer){
																$answerExplode = explode('@@',$question[$key]);
																echo $answerExplode[$answer].'<br>';
															}
															
															
														}
														?>
														@elseif($practise['type'] == 'match_answer')
															<span style="color:black; font-weight:bold">Answers:</span><br><br>
															<?php //echo '<pre>'; print_r($practise);  
															if(isset($practise['correctanswer']) && !empty($practise['correctanswer']) && isset($practise['question']) && !empty($practise['question'])&& isset($practise['question_2']) && !empty($practise['question_2'])){
																if(isset($practise['dependingpractiseid']) && !empty($practise['dependingpractiseid'])){
																	if(isset($practise['typeofdependingpractice']) && $practise['typeofdependingpractice'] == 'get_questions_and_answers'){
																		if(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer'])){
																		  if(isset($practise['depending_practise_details']) && !empty($practise['depending_practise_details']) && isset($practise['depending_practise_details']['question'])){
																			  $exploded_question = explode(PHP_EOL,$practise['depending_practise_details']['question']);
																			  $k = 0;
																			  $ans = explode(";",$practise['dependingpractise_answer'][0]);
																			  foreach($exploded_question as  $question) {
																				  if(str_contains($question,'@@')) {
															  
																					 $outValue[] = preg_replace_callback('/@@/', function ($m) use ( &$ans, &$question, &$k) {
																					  $newans = isset($ans[$k])?$ans[$k]:'';
																					  
																					  $str ='<span style="color:#ff7600">'.$newans.'</span>';
																					  $k++;
																					  return $str;
																					}, $question);
															  
																				  }
																				
																			  }
																			  $q1=$outValue;
																			  $q2=$practise['question_2'];
																			  $explode_question = explode( '#@', $practise['question_2'][0]);
																			  $explode_question_header = explode( '@@', $explode_question[0]);
																			  $q2[0]=$explode_question[1];
																			 
																			  
																		  }
																		}
																		$correctAnswer= explode(';',$practise['correctanswer']);
																			array_pop($correctAnswer);
																			foreach($correctAnswer as $key=> $answer){
																				$answerExplode = explode(':',$answer);
																				//echo '<br><pre>'; print_r($answerExplode);
																				$pos1= ((int)$answerExplode[0])-1;
																				$pos2= ((int)$answerExplode[1])-1;
			
																				if(str_contains($q1[$pos1],'#@')){
																					$que = explode('#@',$q1[$pos1]);
																					$question_1=$que[1];
																				}else{
																					$question_1 = $q1[$pos1];
																				}
			
																				if(str_contains($q2[$pos2],'#@')){
																					$que1 = explode('#@',$q2[$pos2]);
																					$question_2=$que1[1];
																				}else{
																					$question_2 = $q2[$pos2];
																				}
			
																				echo $question_1.' : '.$question_2.'<br>';
																			}
																	  }
																
																
																}else{
																	$correctAnswer= explode(';',$practise['correctanswer']);
																	array_pop($correctAnswer);
																	foreach($correctAnswer as $key=> $answer){
																		$answerExplode = explode(':',$answer);
																		//echo '<br><pre>'; print_r($answerExplode);
																		$pos1= ((int)$answerExplode[0])-1;
																		$pos2= ((int)$answerExplode[1])-1;
	
																		if(str_contains($practise['question'][$pos1],'#@')){
																			$que = explode('#@',$practise['question'][$pos1]);
																			$question_1=$que[1];
																		}else{
																			$question_1 = $practise['question'][$pos1];
																		}
	
																		if(str_contains($practise['question_2'][$pos2],'#@')){
																			$que1 = explode('#@',$practise['question_2'][$pos2]);
																			$question_2=$que1[1];
																		}else{
																			$question_2 = $practise['question_2'][$pos2];
																		}
	
																		echo $question_1.' : '.$question_2.'<br>';
																	}
																}
																
															}
															?>
														@elseif($practise['type'] =='true_false_speaking_up_simple' || $practise['type'] == 'true_false_writing_at_end_select_option')
														<span style="color:black; font-weight:bold">Answers:</span><br>
														<?php
														$ans= array();	
															$explodAnswer=explode(';',$practise['correctanswer']);
															 array_pop($explodAnswer);
															//  dd($explodAnswer);
																foreach($explodAnswer as $k=>$answer){
																	// if($answer == "1"){
																	// 	echo "true,";
																	// }else{

																	// 	echo "false,";
																	// }
																	if($answer && $answer == 1  ){
																		$ans[$k]= "True ";
																	}elseif($answer  == 0){	
																		$ans[$k]="False";																

																	}
																}
																echo implode(", ",$ans);
														?>
														@else
														<span style="color:black; font-weight:bold">Answers:</span><br>
														<?php	
															// echo "<pre>";
															// print_r($practise);
															// echo "</pre>";
															$explodAnswer=explode(';',$practise['correctanswer']); 
															if($practise['type'] == "true_false_listening_simple" || $practise['type'] == "true_false_symbol_reading"){
																foreach($explodAnswer as $k=>$answer){
																	if($answer == "1"){
																		echo $k ==(count($explodAnswer))-1?" True":"True, ";
																	}else{
																		echo $k ==(count($explodAnswer))-1?" False":"False, ";
																	}
																}
															}elseif($practise['type'] == "true_false_writing_at_end" ){
																foreach($explodAnswer as $k=>$answer){
																	if($answer == "1"){
																		echo $k ==(count($explodAnswer))-1?" True":"True, ";
																	}else{
																		echo $k ==(count($explodAnswer))-1?" False":"False, ";
																	}
																}
															}else{
																foreach($explodAnswer as $k=>$answer){
																	
																	if(is_bool($answer) && $answer == 1  ){

																		echo "TRUE, ";
																	}elseif(is_bool($answer) && $answer == 0 ){		

																		if($k==(count($explodAnswer))-1){
																			echo "FALSE";
																		}else{
																			echo "FALSE, ";
																		}

																	}else{

																		if($k ==(count($explodAnswer))-1){																			
																			 echo $answer;
																			
																		}else{
																			if(isset($answer) && !empty($answer)){
																				echo str_replace('/','',$answer).", ";	
																			}
																		}
																		
																	}
																}
															}
															
														?>
														
													@endif
												@endif
										</div> 
										
										<!-- tab 1-->
										<?php
											}
                    					?>
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
			<div class="modal-header justify-content-center">
				<h5 class="modal-title" id="erasemodalLongTitle">Reset Answers</h5>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to reset your answers?</p>
			</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Yes</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script>
										jQuery(document).ready(function(){										
											
											$('form').keydown(function(){
												return false;
											});
											$('.workrecord-disable').on('click',function(){
												//  $('.workrecord-disable').off('click');
												// alert();
												$('.workrecord-disable').css('pointer-events','none');
												// pointer-events: none;
											});
										});										
										</script>
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
$('#abc-tabContent').find('.delete-icon').remove();
$('#abc-tabContent').find('[type="checkbox"]').attr('disabled','disabled');
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
	<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
	<script src="{{asset('public/js/audio-recorder/app-multiple.js')}}?v={{env('CACTH')}}"></script>
	<script src="{{ asset('public/js/audioplayer.js') }}"></script>
	<script>
	$(function () {
		$('audio.practice_audio').audioPlayer();

	});
	</script>
 	<style>
		ul.list-buttons, .delete-icon{
			display: none !important;
		}
		.btn.{
			display: block !important;
		}
		input, span, ul>li.answer-option {
			pointer-events: none !important;
		}
		button.plyr__controls__item{
			pointer-events: auto !important;
		}
		
  	</style>
<?php }?> @endsection
