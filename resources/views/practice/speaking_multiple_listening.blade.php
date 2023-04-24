<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
	$exploded_question  = array();
  	$user_ans = "";
  	$answerExists = false;
  	if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
		$answerExists = true;
		if(!empty($practise['is_roleplay']) && $practise['is_roleplay']==1 && $practise['type'] !='speaking_multiple'){
			$answers = $practise['user_answer'];
			$new_answer = array_values(array_filter($answers,
					function($item) {
					  return strpos($item, '##') === false;
					}));
			$practise['user_answer'] = $new_answer;
		}
	}

	$data[$practise['id']] = array();
	$data[$practise['id']]['isRolePlayPractice'] = (!empty($practise['is_roleplay']) &&  $practise['is_roleplay']==1)?1:0;
	$data[$practise['id']]['typeofdependingpractice'] = !empty($practise['typeofdependingpractice']) ? $practise['typeofdependingpractice'] : "";
	$data[$practise['id']]['setFullViewFromPreviousPractice'] = !empty($practise['depending_practise_details']['dependant_practise_id']) ? $practise['depending_practise_details']['dependant_practise_id']:"";
	$data[$practise['id']]['dependant_practise_topic_id'] = !empty($practise['depending_practise_details']['dependant_practise_topic_id']) ? $practise['depending_practise_details']['dependant_practise_topic_id']:"";
	$data[$practise['id']]['dependant_practise_task_id'] = !empty($practise['depending_practise_details']['dependant_practise_task_id']) ? $practise['depending_practise_details']['dependant_practise_task_id']:"";
	$data[$practise['id']]['dependant_practise_question_type'] = !empty($practise['depending_practise_details']['question_type']) ? $practise['depending_practise_details']['question_type']:"";
	$data[$practise['id']]['dependentpractice_ans'] = !empty($practise['dependingpractise_answer'])?1:0;
	$data[$practise['id']]['is_dependent'] = !empty($practise['is_dependent']) ? 1 : 0;
	
	if(isset($practise['typeofdependingpractice']) && $practise['typeofdependingpractice'] == "set_full_view_gen_que_double"){
		$data[$practise['id']]['setFullViewFromPreviousPractice'] = !empty($practise['depending_practise_details']['independant_practise']['practise_details']['practise_id']) ? $practise['depending_practise_details']['independant_practise']['practise_details']['practise_id']:"";
	}
	// echo "<pre>";
	// print_r($data);
	$style="";
	//dd($practise['depending_practise_details']);
	if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) ){
  		$depend =explode("_",$practise['dependingpractiseid']);
		  $style= "display:none"; 
?>
		<div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; display:none">
			<p style="margin: 15px;">In order to do this task you need to have completed
			<strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
		</div>
<?php
  	} else {
		if(!empty($practise['question'])){
			$exploded_question = explode(PHP_EOL,$practise['question']);
		}
	}
?>
<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
<div class="previous_practice_answer_exists_{{$practise['id']}}" style="{{$style}}">
	@if($data[$practise['id']]['typeofdependingpractice']=='set_full_view_hide_show')
		<div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
			<a href="javascript:;" class="btn btn-dark selected_option_hide_show">Show View</a>
		</div>
	@endif
	
	@if(!empty($practise['is_roleplay']) && $practise['is_roleplay']==1)
		@include('practice.speaking_multiple_listening_roleplay')
	@else
		<div class="showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}" id="previousSetfullview">
		 </div>
		 <br><br>
		<form class="form_{{$practise['id']}}">
		
			<input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
			<input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
			<input type="hidden" class="is_save" name="is_save" value="">
			<input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
			<input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
			
			<?php
			if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
				$depend =explode("_",$practise['dependingpractiseid']);
			?>
				<input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
				<input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
			<?php } ?>
			@if($practise['type'] == "speaking_multiple_listening")
				@include('practice.common.audio_player')
			@endif
			<?php
				$answerExists = false;
				if(!empty($practise['question'])){
					if($practise['type']=='speaking_multiple'){
						
						$exploded_question  =  explode(' @@', $practise['question']);
					} elseif($practise['type']=='speaking_multiple_listening') {
						$exploded_question  =  explode(PHP_EOL, $practise['question']);
					}
				}		
				if(!empty($practise['typeofdependingpractice']) && $practise['typeofdependingpractice']=='get_answers_generate_quetions') {
					?>
					<script>
						$(document).ready(function() {
							$('#previousSetfullview').css("display",'none');
						});
					</script>
					<?php
                    if(!empty($practise['depending_practise_details']))  
                    {
						if($practise['depending_practise_details']['question_type'] =='speaking_multiple' || $practise['depending_practise_details']['question_type'] =='writing_at_end' || $practise['depending_practise_details']['question_type'] == 'writing_at_end_up'){
							if( !empty( $practise['dependingpractise_answer'][0] ) && is_array($practise['dependingpractise_answer'][0])){
								$exploded_question  =  $practise['dependingpractise_answer'][0];
							} 
						}  
						else if( $practise['depending_practise_details']['question_type']=='single_tick' ){
							if( !empty( $practise['dependingpractise_answer'][0] ) && is_array($practise['dependingpractise_answer'][0])){
								  
								$exploded_question = array();
								foreach($practise['dependingpractise_answer'][0] as $key => $value){
									if(!empty($value['checked']) && $value['checked']==1){
										array_push($exploded_question,$value['name']);
									}
								} 
							}  
				    	}
				    }
				}
				
				if(!empty($practise['typeofdependingpractice']) && $practise['typeofdependingpractice']=='get_questions_and_answers') {
					if($practise['type']=='speaking_multiple'){
						// echo '<pre>'; print_r($practise); 
						if(isset($practise['depending_practise_details']['question_type']) && !empty($practise['depending_practise_details']['question_type']) && $practise['depending_practise_details']['question_type'] == "reading_total_blanks_edit" && isset($practise['dependingpractise_answer'])&& !empty($practise['dependingpractise_answer'])){
							$questions  =  explode(PHP_EOL, $practise['depending_practise_details']['question']);
							$userAnswer = explode(';',$practise['dependingpractise_answer'][0]);
							// echo '<pre>'; print_r($userAnswer); 
							$c = 0;
							foreach($questions as $key => $value)
                            {
									if(trim($userAnswer[$key]) != ''){

									
                                            if(str_contains($value,'@@')){
                                                $value= str_replace("<br>"," ",$value);
                                        //  $value = str_replace('<br>', '', $value);
                                         $exploded_question[] = preg_replace_callback('/@@/',
                                                    function ($m) use (&$key, &$c, &$userAnswer) {
                                                        $ans= !empty($userAnswer[$key])?trim($userAnswer[$key]):"";
                                                        $str = $ans;
                                                        $c++;
                                                        return $str;
                                                    }, $value);
											}
										}
    
							} 
						}elseif( !empty( $practise['depending_practise_details']['question'] ) ){
							$exploded_question  =  explode(PHP_EOL, $practise['depending_practise_details']['question']);
							 
						} 
					}  
				}
				if(isset($practise['typeofdependingpractice']) && !empty($practise['typeofdependingpractice']) && $practise['typeofdependingpractice']=='set_full_view_gen_que_double'){
					if($practise['type']=='speaking_multiple'){
						if( isset($practise['dependingpractise_answer']['0']) && !empty($practise['dependingpractise_answer']['0']) ){
							if(is_array($practise['dependingpractise_answer']['0'])){
								$exploded_question  = array_filter($practise['dependingpractise_answer']['0']);
							}else{

								$exploded_question[]  = $practise['dependingpractise_answer']['0'];
							}
							
							 
						} 
					}  
				}
				if(isset($practise['typeofdependingpractice']) && !empty($practise['typeofdependingpractice']) && $practise['typeofdependingpractice']=='get_questions_and_answers' && $practise['depending_practise_details']['question_type'] == 'multi_choice_question_multiple'){
					if($practise['type']=='speaking_multiple'){
						
						if(isset($practise['dependingpractise_answer']['0']) && !empty($practise['dependingpractise_answer']['0']) ){
							
							if(is_array($practise['dependingpractise_answer']['0'])){
								$dependQuestion= explode(PHP_EOL,$practise['depending_practise_details']['question']);
								$exploded_question=[];
								foreach($practise['dependingpractise_answer']['0'] as $key => $value ){
									
									if(!empty($value['ans'])){
										$exploded_question[]= $dependQuestion[$key].' : '.$value['ans'];
									}

								}
							
							}
							
						} 
					}
				}
				if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
					$answerExists = true;
				}
			 
			?>
			<?php 
			// echo '<pre>'; print_r($exploded_question); echo '</pre>';
			?>
				
			@if(!empty($exploded_question))
				@foreach($exploded_question as $key => $value)
					@if(!empty($value))
						<div class="multiple-choice1">
							<?php 
								$temp = str_replace("<div>", "", $value);
								$temp = str_replace("</div>", "", $temp);
								$temp = str_replace("!#", "", $temp);
							?>
							<p class="mb-0"><?php echo $temp; ?></p> 
							@if(!str_contains($value,'!#'))
								@include('practice.common.audio_record_div',['q'=> $key])
							@endif
						</div>
						<input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$key}}" name="text_ans[{{$key}}][audio_deleted]" value="0">
						<input type="hidden" name="text_ans[{{$key}}][path]" class="audio_path{{$key}}">
					@endif
				@endforeach
			@else

				@if(empty($practise['dependingpractiseid']))
					<div class="multiple-choice1">
						  @include('practice.common.audio_record_div')
					</div>
					<input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="text_ans[0][audio_deleted]" value="0">
					<input type="hidden" name="text_ans[0][path]" class="audio_path0">
				@else 
					@if(empty($data[$practise['id']]['setFullViewFromPreviousPractice']))
						@if(!empty($practise['dependingpractise_answer'][0]) && is_array($practise['dependingpractise_answer'][0]))
							
							@foreach($practise['dependingpractise_answer'][0] as $key => $value)
								@if(!empty($value)) 
									<input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$key}}_0" name="text_ans[{{$key}}][audio_deleted]" value="0">
									<div class="multiple-choice1">
										<p class="mb-0">{!! $value !!}</p>
										@include('practice.common.audio_record_div',['q'=> $value])
									</div>
									<input type="hidden" name="text_ans[{{$key}}][path]" class="audio_path{{$key}}">
								@endif
							@endforeach
						@elseif(!empty($practise['dependingpractise_answer'][0]) )
							<div class="multiple-choice2">
								@if(empty( $data[$practise['id']]['setFullViewFromPreviousPractice'] ))
									<p class="mb-0">{!!$practise['dependingpractise_answer'][0]!!}</p>
								@endif
								@include('practice.common.audio_record_div',['q'=> $practise['dependingpractise_answer'][0]])
							</div>
							<input type="hidden" name="text_ans[0][path]" class="audio_path0">
						@else
							@if(!empty($practise['dependingpractise_answer']))
						
								<div class="multiple-choice3">
									@if(empty($data[$practise['id']]['setFullViewFromPreviousPractice'] ))
										<p class="mb-0">{!!isset($practise['dependingpractise_answer'])?$practise['dependingpractise_answer']:""!!}</p>
									@endif
									@include('practice.common.audio_record_div',['q'=> $practise['dependingpractise_answer']])
								</div>
								<input type="hidden" name="text_ans[0][path]" class="audio_path0">
							@endif
						@endif
					@else
						<div class="multiple-choice4">
							@include('practice.common.audio_record_div')
						</div>
						<input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="text_ans[0][audio_deleted]" value="0">
						<input type="hidden" name="text_ans[0][path]" class="audio_path0">
					@endif
				@endif
			@endif
			<div class="alert alert-success" role="alert" style="display:none"></div>
			<div class="alert alert-danger" role="alert" style="display:none"></div>
			<ul class="list-inline list-buttons">
				<li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"
								data-toggle="modal" data-is_save="0" data-target="#exitmodal">Save</button>
				</li>
				<li class="list-inline-item"><button type="button"
								class="submit_btn btn btn-primary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1">Submit</button>
				</li>
			</ul>
		</form>
			@if(isset($practise["markingmethod"]) && $practise["markingmethod"] == "student_self_marking")

				@include('practice.common.student_self_marking')
            
			@endif
			@php
				$lastPractice=end($practises);
			@endphp
			@if($lastPractice['id'] == $practise['id'])
				@include('practice.common.review-popup')
				@php
					$reviewPopup=true;
				@endphp
			@else
				@php
					$reviewPopup=false;
				@endphp
			@endif
		@endif
</div>
<?php 

?>

<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
 
<script>
	var sorting             = "{{ isset($topic_tasks_new)?$topic_tasks_new:$topic_tasks[0]['sorting'] }}";
    var courseType 			= "<?php echo $CourseDetails; ?>";
    var courseType 			= courseType.split("-");
    var level               = courseType[1];
    var courseType 			= courseType[0];
    var feedbackPopup       = true;

    if(level == "ELEMENTARY"){
	    if(courseType == "AES" && sorting == 14){
	        var facilityFeedback  = true;
	    	var courseFeedback    = false;       
	    }else{
	        var facilityFeedback    = false;
	        var courseFeedback      = true;
	    }
    }else if(level == "ADVANCED"){
        if(courseType == "AES" && sorting == 4){
            var facilityFeedback    = true;
            var courseFeedback      = false;
        }

    }else if(level == "INTERMEDIATE"){
        if(courseType == "AES" && sorting == 5){
            var facilityFeedback    = false;
            var courseFeedback      = true;
        }
    }
   
	if(data1==undefined ){
		var data1=[];
	}
 	var token = $('meta[name=csrf-token]').attr('content');
	var upload_url = "{{url('upload-audio')}}";
	var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
	data1["{{$practise['id']}}"]= {"dependentpractice_ans": "{{$data[$practise['id']]['dependentpractice_ans']}}" };
	data1["{{$practise['id']}}"]["isRolePlayPractice"] = "{{$data[$practise['id']]['isRolePlayPractice']}}"
	data1["{{$practise['id']}}"]["is_dependent"] = "{{$data[$practise['id']]['is_dependent']}}"; 
	if(data1["{{$practise['id']}}"]["is_dependent"]==1){
		
		if(data1["{{$practise['id']}}"]["dependentpractice_ans"]==0 ){
			$(".previous_practice_answer_exists_{{$practise['id']}}").hide();
			$("#dependant_pr_{{$practise['id']}}").show();
		} else {
			$(".previous_practice_answer_exists_{{$practise['id']}}").show();
			$("#dependant_pr_{{$practise['id']}}").hide();
		}
	}
 
</script>

@if(!empty($practise['is_roleplay']) && $practise['is_roleplay']==1 && $practise['type']=="speaking_multiple_listening")
	<script>

		$(document).on('click',".submitBtn_{{$practise['id']}}" ,function() {
			if($(this).attr('data-is_save') == '1'){
		      $(this).closest('.active').find('.msg').fadeOut();
		    }else{
		      $(this).closest('.active').find('.msg').fadeIn();
		    }			
			$(".submitBtn_{{$practise['id']}}").attr('disabled','disabled');
			var is_save = $(this).attr('data-is_save');
			$('.is_save:hidden').val(is_save);

			$.ajax({
				url: "{{url('save-speaking-multiple-listening')}}",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				type: 'POST',
				data: $(".form_{{$practise['id']}}").serialize(),
				success: function (data) {
					$(".submitBtn_{{$practise['id']}}").removeAttr('disabled');

					if(data.success){
						$('.form_{{$practise["id"]}}').find('.alert-danger').hide();
						$('.form_{{$practise["id"]}}').find('.alert-success').show().html(data.message).fadeOut(8000);
					} else {
						$('.form_{{$practise["id"]}}').find('.alert-success').hide();
						$('.form_{{$practise["id"]}}').find('.alert-danger').show().html(data.message).fadeOut(8000);
					}
				}
			});
		});
	</script>
@endif

@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==0 && $practise['typeofdependingpractice']!='get_answers_generate_quetions' )
<script>
	data1["{{$practise['id']}}"]["typeofdependingpractice"] = "{{ $data[$practise['id']]['typeofdependingpractice'] }}";
	data1["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
	if(data1["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data1["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data1["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data1["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data1["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data1["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data1["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view"){	 
	  if(data1["{{$practise['id']}}"]["typeofdependingpractice"] == "set_full_view_gen_que_double"){
			data1["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{isset($practise['depending_practise_details']['independant_practise']['practise_details']['task_id'])?$practise['depending_practise_details']['independant_practise']['practise_details']['task_id']:''}}";
			data1["{{$practise['id']}}"]["dependant_practise_id"] = "{{ isset($practise['depending_practise_details']['independant_practise']['practise_details']['practise_id']) ? $practise['depending_practise_details']['independant_practise']['practise_details']['practise_id'] :''}}";
			
		
	  }else{
	   data1["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{$data[$practise['id']]['dependant_practise_task_id'] }}";
	   data1["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
	  }
		
		$(function () {
			$('.cover-spin').fadeIn();
		});
		$(function () {
			$('.cover-spin').fadeOut();
		});
		
		if(data1["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
			// IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
			if(data1["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
				setTimeout(function(){ 
					 data1["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();				 
					$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).html(data1["{{$practise['id']}}"]["prevHTML"]);
					$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
					$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
					$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert').remove();
					$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('.match-answer').hide();//add for level 0
					$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('.spandata').attr("contenteditable","false")
					if( data1["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view"){
						if(data1["{{$practise['id']}}"]["dependant_practise_question_type"] == "speaking_writing_up" && data1["{{$practise['id']}}"]["typeofdependingpractice"] == "set_full_view" ){	
							$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
						}
						if(data1["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_total_blanks_edit") {
							$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('.form-slider').remove();
						}
					}
					if( data1["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
						// alert(data1["{{$practise['id']}}"]["dependant_practise_question_type"])						
						if(data1["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up" || data1["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_up_speaking_up") 
						{
							$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
						}
					}
				    //---------add static condition for the level 0............
					if(data1["{{$practise['id']}}"]["dependant_practise_id"] == "16666234696356a7ed13f21")
					{
					     $(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset .deleteRecordingButton').remove();
					     $(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset .audio__controls').remove();
					     $(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset .animated__mic__icon').remove();
					     $(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset .countdown').remove();
					}
					$('.cover-spin').fadeOut();
				}, 8000,data1 )
			}
		} else {
			// IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
			// DO NOT REMOVE BELOW   CODE
		var baseUrl = "{{url('/')}}"; 
		var pid = "{{$practise['id']}}";
		data1["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
	      	data1["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data1["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data1["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data1["{{$practise['id']}}"]["dependant_practise_id"];
			setTimeout(function(){ 

				$.get(data1["{{$practise['id']}}"]["dependentURL"],  //
				function (dataHTML, textStatus, jqXHR) {  // success callback
					data1["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();

					$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).html(data1["{{$practise['id']}}"]["prevHTML"]);
					// remove audio player
					if(pid == "15554957925cb6fb704d7df"){
						if(data1["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" ){
							$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('.audio-player').remove();
						}	
					}
					
					$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
					if(pid !== '15567380715cc9f01738ad4')
					{
					  $(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, .alert, input:hidden').remove();
					}
					else
				    {
				    	$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
				    }
				    
					$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('.spandata').attr("contenteditable",false);
					if(data1["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
						 
						if(data1["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
							$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
						}
					}
					$('.cover-spin').fadeOut();

				});
			 }, 5000,data1 )
		}
	}  
</script>
@endif

@if(empty($practise['is_roleplay']) || $practise['is_roleplay']==0)
<script>
	$(document).on('click',".submitBtn_{{$practise['id']}}" ,function() {
			if($(this).attr('data-is_save') == '1'){
		      $(this).closest('.active').find('.msg').fadeOut();
		    }else{
		      $(this).closest('.active').find('.msg').fadeIn();
		    }			
		var reviewPopup = '{!!$reviewPopup!!}';
    	var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
                    var fullView= $(".form_{{$practise['id']}}").html();

                    var AllAudio = new Array();
                    var checkAudioAva = new Array();
					$('.multiple-choice1').each(function(){
						// alert($(this).find('fieldset').html());
						
						if(typeof($(this).find(".practice_audio").children().attr("src")) !="undefined"){

							if($(this).find(".practice_audio").children().attr("src").indexOf("sample-audio.mp3") !== -1){
								checkAudioAva.push("false");
								AllAudio.push($(this).find('fieldset').html()+"<input type='hidden' value = 'sample-audio.mp3' ")
							}else{
								checkAudioAva.push("true");
								AllAudio.push($(this).find(".practice_audio").children().attr("src"))
							}
						}
					});

					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.delete-icon').remove();
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");

					var tempInc = 0;
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.main-audio-record-div').each(function(){
						$(this).parent().prepend("<div class='append_"+tempInc+" myclass audio-player ' data="+tempInc+"></div>")
						tempInc++;
					})
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.main-audio-record-div').each(function(){
						$(this).remove()
					}) 
					// new code 
					setTimeout(function(){

					$('.form_{{$practise['id']}} .delete-icon').each(function(){
						if($(this).is(":visible") === true){

							$(this).closest('.main-audio-record-div').find('.audioplayer-playpause').css("display","flex");
						}
					});
					},1000)
					// end
					// var tempInc = 0;
					$.each(AllAudio,function(k,v){
						var audioTemp 	= ' <audio preload="auto" controls class="practice_audio answer_audio-{{$practise['id']}}-'+k+'">\
								              <source src="'+v+'" type="audio/mp3">\
								          </audio>';
						var disableIcon = "";
						if(checkAudioAva[k] ==="true"){
							$('.append_'+k).append(audioTemp)
							disableIcon =false;
							Audioplay("{{$practise['id']}}",k,disableIcon);
							$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}} .append_"+k+" .plyr").css("width","310px");
						}else{
							disableIcon =true;
							$('.append_'+k).append(v)
							$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}} .append_"+k ).css("pointer-events","none");
						}
					});
				}
            }
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){
                $("#reviewModal_{{$practise['id']}}").modal('toggle');
            }

			function Audioplay(pid,inc,flagForAudio){
				var supportsAudio = !!document.createElement('audio').canPlayType;
				if (supportsAudio) {
					var i;
					var player = new Plyr(".modal .answer_audio-{{$practise['id']}}-"+inc, {
						controls: [
							'play',
							'progress',
							'current-time'
						]
					}); 
				}
			}
            
			$(".submitBtn_{{$practise['id']}}").attr('disabled','disabled');
			if($(this).attr('data-is_save') == '1'){
		      
		      $(this).closest('.active').find('.msg').fadeOut();
		    }else{
		      $(this).closest('.active').find('.msg').fadeIn();
		      
		    }
			var is_save = $(this).attr('data-is_save');
			$('.is_save:hidden').val(is_save);
			$.ajax({
					url: "{{url('save-speaking-multiple-listening')}}",
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					type: 'POST',
					data: $(".form_{{$practise['id']}}").serialize(),
					success: function (data) {
						$(".submitBtn_{{$practise['id']}}").removeAttr('disabled');
							if(data.success){
								if(is_save=="1"){
									// =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
									setTimeout(function(){
											$('.alert-success').hide();
										var isNextTaskDependent =  $('.nav-link.active').parent().next().find('a').attr('data-dependent');
										if( isNextTaskDependent == 1 ){
											var dependentPractiseId =  $('.nav-link.active').parent().next().find('a').attr('data-id');
											var baseUrl = "{{url('/')}}";
											var topic_id = "{{request()->segment(2)}}";
											var task_id = "{{request()->segment(3)}}";
												// //window.location.href=baseUrl+'/topic/'+topic_id+'/'+task_id+'?n='+dependentPractiseId
											////$('#abc-'+dependentPractiseId+'-tab').trigger('click');
										} else {
											// //$('.nav-link.active').parent().next().find('a').trigger('click');
										}
									},2000);
									// =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
								}
								// var fullView= $(".form_{{$practise['id']}}").clone(true);
								// $(".form_{{$practise['id']}}").after(fullView);

								$('.form_{{$practise["id"]}}').find('.alert-danger').hide();
								$('.form_{{$practise["id"]}}').find('.alert-success').show().html(data.message).fadeOut(8000);
							} else {
								$('.form_{{$practise["id"]}}').find('.alert-success').hide();
								$('.form_{{$practise["id"]}}').find('.alert-danger').show().html(data.message).fadeOut(8000);
							}
					}
			});
	});
</script>
@endif
@if($data[$practise['id']]['typeofdependingpractice']=='set_full_view_hide_show')
<script>
$("#previousSetfullview").hide();
	$(".selected_option_hide_show").click(function () {
		// alert();
		var text = $(this).text();
		$(this).text(
				text == "Hide View" ? "Show View" : "Hide View"
				
			);
			
		$("#previousSetfullview").toggle();
	});

</script>
@endif
<style type="text/css">
	.myclass{
		position: relative;
	    display: flex;
	    align-items: center;
	    margin-bottom: 2rem;
	}
</style>
<!--- Static Condition for beginner ges topic 09 task 8 AB-->
@if(isset($_GET['n']))
 @if($_GET['n'] == "1629890534612627e6028cd")
    <style type="text/css">
     #abc-1629890534612627e6028cd
     {
         display: block  !important;
     }
     #abc-1629890480612627b01e67d
     {
         display: none;
     }
    </style>
 @endif
@endif
<!--- Static Condition for beginner ges topic 21 task 8 AB-->
@if($practise['id'] == "16656578776347ec15c9b8b")
<style type="text/css">
	.record_16656578776347ec15c9b8b .plyr__controls
	{
		display: none !important; 
	}
</style>
@endif
<!--- Static Condition for beginner ges topic 09 task 8 AB-->
@if(isset($_GET['n']))
 @if($_GET['n'] == "16666234996356a80b34528")
    <style type="text/css">
     #abc-16666234266356a7c2ed325
     {
         display: none;
     }
     #abc-16666234696356a7ed13f21
     {
     	display: none;
     }
    </style>
 @endif
@endif
@if(isset($_GET['n']))
 @if($_GET['n'] == "16666235386356a8327e126")
    <style type="text/css">
     #abc-16666234266356a7c2ed325
     {
         display: none;
     }
     #abc-16666234696356a7ed13f21
     {
     	display: none;
     }
     #abc-16666234996356a80b34528
     {
     	display: none;
     }
    </style>
 @endif
@endif
<!------------------------------------------------------------->