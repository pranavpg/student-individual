
<p>
	<strong><?php 	echo $practise['title']; ?></strong>
</p>
<?php
$data[$practise['id']] = array();
	$data[$practise['id']]['isRolePlayPractice'] = (!empty($practise['is_roleplay']) &&  $practise['is_roleplay']==1)?1:0;
	$data[$practise['id']]['typeofdependingpractice'] = !empty($practise['typeofdependingpractice']) ? $practise['typeofdependingpractice'] : "";
	$data[$practise['id']]['setFullViewFromPreviousPractice'] = !empty($practise['depending_practise_details']['dependant_practise_id']) ? $practise['depending_practise_details']['dependant_practise_id']:"";
	$data[$practise['id']]['dependant_practise_topic_id'] = !empty($practise['depending_practise_details']['dependant_practise_topic_id']) ? $practise['depending_practise_details']['dependant_practise_topic_id']:"";
	$data[$practise['id']]['dependant_practise_task_id'] = !empty($practise['depending_practise_details']['dependant_practise_task_id']) ? $practise['depending_practise_details']['dependant_practise_task_id']:"";
	$data[$practise['id']]['dependant_practise_question_type'] = !empty($practise['depending_practise_details']['question_type']) ? $practise['depending_practise_details']['question_type']:"";
	$data[$practise['id']]['dependentpractice_ans'] = !empty($practise['dependingpractise_answer'])?1:0;
	$data[$practise['id']]['is_dependent'] = !empty($practise['is_dependent']) ? 1 : 0;
	$exploded_question  = array();
 ?>
 @if(isset($practise['is_roleplay']) && !empty($practise['is_roleplay']) && $practise['is_roleplay'] == "1" && $practise['type'] == "writing_at_end_speaking_multiple")
	@include('practice.writing_at_end_speaking_multiple_roleplay')
 @else
	<form class="form_{{$practise['id']}}">
	<input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
	<input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
	<input type="hidden" class="is_save" name="is_save" value="">
		<input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
	<input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

		@if($practise['type'] == 'writing_at_end_speaking_multiple_up_listening')
			<div class="audio-player">
					<audio preload="auto" controls src="<?php echo $practise['audio_file'];?>" type="audio/mpga" id="audio_{{$practise['id']}}">
							<source src="<?php echo $practise['audio_file']?>" type="audio/mp3" >
					</audio>
			</div>
		@endif
	@if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && isset($practise['dependingpractise_answer']) && empty($practise['dependingpractise_answer']))
		@php
			$depend =explode("_",$practise['dependingpractiseid']);
			$style = "display:none";

			

		@endphp 	
		<div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; ">
			<p style="margin: 15px;">In order to do this task you need to have completed
			<strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
		</div>
	@else
	
		@if(isset($practise['typeofdependingpractice']) && $practise['typeofdependingpractice'] == 'get_answers_put_into_quetions_before')
			@if(isset($practise['depending_practise_details']['question_type']) && isset($practise['dependingpractise_answer']) && $practise['depending_practise_details']['question_type'] == 'writing_at_end')
				@php $dependantAns= $practise['dependingpractise_answer'][0]; @endphp
			@endif
		@endif
		@if(isset($practise['typeofdependingpractice']) && $practise['typeofdependingpractice'] == 'set_full_view')
		<div class="showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}">
		</div>
		@endif
		@if(isset($practise['typeofdependingpractice']) && $practise['typeofdependingpractice'] == 'get_questions_and_answers')
			@php
			if(isset($practise['question']) && empty($practise['question'])){
				$count=0;
					$exp_answer =  explode(';',$practise['dependingpractise_answer'][0]);
					array_pop($exp_answer);
					$depend_question  =  explode(PHP_EOL, $practise['depending_practise_details']['question']);
					foreach($depend_question as $value ) {
						if(str_contains($value,'@@')){
							$exploded_question[] = preg_replace_callback('/@@/',
									function ($m) use (&$key, &$count, &$exp_answer) {
										$ans= $exp_answer[$count];
										$count++;
										$str = $ans;
										return $str;
									}
									, $value);
						}
					}
					
				}
				
			@endphp
		@endif
		@php
			$style = "display:block";
		@endphp
	@endif
	<div style="{{$style}}">
		<?php
			$answerExists = false;
				
				if(!empty($practise['question'])){
					
					if(str_contains($practise['question'],'@@')){
						$exploded_question  =  explode('@@', $practise['question']);
					}else{
						$exploded_question  =  explode(PHP_EOL, $practise['question']);
					}
					// echo "<pre>";
					// print_r($exploded_question);
				}elseif(!isset($practise['typeofdependingpractice']) && $practise['type'] == 'writing_at_end_speaking_multiple_up' && $practise['markingmethod'] =='read_only'){
					
					$exploded_question[0]='blank_Question';
				}
				if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
					$answerExists = true;
				}
		?>
		@if(!empty($exploded_question))
	@php // echo '<pre>'; print_r($exploded_question); @endphp
			@foreach($exploded_question as $key => $value)
				@if(!empty($value))
					@if(isset($dependantAns) && !empty($dependantAns))
						<p>{!!$dependantAns[$key]!!}</p>
					@endif
					@if($value != 'blank_Question')
					<p>{!!str_replace('<>','',$value)!!}</p>
					@endif
					
					@if($practise['type']=="writing_at_end_speaking_multiple_up" || $practise['type']=="writing_at_end_speaking_multiple_up_listening" )
						@include('practice.common.audio_record_div')
					@endif
						<div class="form-group d-flex align-items-start form-group-label">
							<span class="textarea form-control form-control-textarea enter_disable" role="textbox" disabled contenteditable placeholder="Write here..." style="color:black">
									<?php
										if ($answerExists)
										{
												echo  str_replace(" ", "&nbsp;", $practise['user_answer'][$key]['text_ans']);
										}
									?>
							</span>
							<div style="display:none">
								<textarea name="text_ans[{{$key}}][text_ans]">
								<?php
										if ($answerExists)
										{
											echo  str_replace(" ", "&nbsp;", $practise['user_answer'][$key]['text_ans']);
										}
								?>
								</textarea>
							</div>
								<input type="hidden" name="text_ans[{{$key}}][path]" class="audio_path{{$key}}">
								<input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$key}}" name="text_ans[{{$key}}][audio_deleted]" value="0">
						</div>

					@if($practise['type']=="writing_at_end_speaking_multiple" )
						@include('practice.common.audio_record_div',['key'=>$key])
					@endif
				@endif
			@endforeach

		@else
				@if($practise['type']=="writing_at_end_speaking_multiple_up_listening")
				<div class="multiple-choice">
						<p class="mb-0"> </p>
							@include('practice.common.audio_record_div')
						<div class="form-group form-group-label">
							<span class="textarea form-control form-control-textarea" role="textbox" disabled contenteditable placeholder="Write here...">
									<?php
										if ($answerExists)
										{
												echo  $practise['user_answer'][0]['text_ans'];
										}
									?>
							</span>
							<div style="display:none">
								<textarea name="text_ans[0][text_ans]">
								<?php
										if ($answerExists)
										{
											echo  $practise['user_answer'][0]['text_ans'];
										}
								?>
								</textarea>
						</div>
							<input type="hidden" name="text_ans[0][path]" class="audio_path0">
							<input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="text_ans[0][audio_deleted]" value="0">
				</div>
				@endif
		@endif
		<div class="alert alert-success" role="alert" style="display:none"></div>
		<div class="alert alert-danger" role="alert" style="display:none"></div>
	</div>
	</form>
@endif

	@if($practise['type'] == 'writing_at_end_speaking_multiple_up_listening')
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
		<script>
		jQuery(function ($) { 
			'use strict'
			var supportsAudio = !!document.createElement('audio').canPlayType;
			if (supportsAudio) {
					var i;
						var player = new Plyr("#audio_{{$practise['id']}}", {
							controls: [
									'play',
									'progress',
									'current-time',
							]
					});
			} else {
					$('.column').addClass('hidden');
					var noSupport = $('#audio1').text();
					$('.container').append('<p class="no-support">' + noSupport + '</p>');
			}
		});
		</script>
	@endif
	<script type="text/javascript">
		function setTextareaContent(pid){
			$('.form_'+pid).find("span.textarea.form-control").each(function(){
				var currentVal = $(this).html();
				var regex = /<br\s*[\/]?>/gi;
				currentVal=currentVal.replace(regex, "\n");
				var regex = /<div\s*[\/]?>/gi;
				currentVal=currentVal.replace(regex, "\n");
				var regex = /<\/div\s*[\/]?>/gi;
				currentVal=currentVal.replace(regex, "");
				var regex = /&nbsp;/gi;
				currentVal=currentVal.replace(regex, "");
				$(this).next().find("textarea").val(currentVal);
			});
		}
		var token = $('meta[name=csrf-token]').attr('content');
		var upload_url = "{{url('upload-audio')}}";
		var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
		if(data==undefined ){
			var data=[];
		} 
		data["{{$practise['id']}}"]= {"dependentpractice_ans": "{{$data[$practise['id']]['dependentpractice_ans']}}" };
		data["{{$practise['id']}}"]["isRolePlayPractice"] = "{{$data[$practise['id']]['isRolePlayPractice']}}"
		data["{{$practise['id']}}"]["is_dependent"] = "{{$data[$practise['id']]['is_dependent']}}"; 
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
	</script>
@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==0 && $practise['typeofdependingpractice']=='set_full_view' )
<script>
	data["{{$practise['id']}}"]["typeofdependingpractice"] = "{{ $data[$practise['id']]['typeofdependingpractice'] }}";
	data["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
	if(data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view"){
	  
		data["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
		data["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
		$(function () {
			$('.cover-spin').fadeIn();
		});
		if(data["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
			if(data["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
				 setTimeout(function(){ 
					 data["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();				 
					$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(data["{{$practise['id']}}"]["prevHTML"]);
					$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
					$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
					$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert').remove();

					if( data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" ){
						if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_no_blanks_listening_speaking_down"  || data["{{$practise['id']}}"]["dependant_practise_question_type"]== "single_speaking_up_writing" ) {
							$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.audio-player').remove();
							$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
						}
					} 
					$('.cover-spin').fadeOut();
				 }, 4000 )
			}
		} else {
			var baseUrl = "{{url('/')}}";
			data["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
			data["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data["{{$practise['id']}}"]["dependant_practise_id"]+'&user_id={{ isset($studentId)?$studentId:'' }}';;
			$.get(data["{{$practise['id']}}"]["dependentURL"],
			function (dataHTML, textStatus, jqXHR) {
				setTimeout(function(){
					data["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
					$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(data["{{$practise['id']}}"]["prevHTML"]);
					$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
					$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, .alert, input:hidden').remove();
					if(data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" ){
						if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_no_blanks_listening_speaking_down" || data["{{$practise['id']}}"]["dependant_practise_question_type"]== "single_speaking_up_writing") {
							$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
						}
					}
					$('.cover-spin').fadeOut();
				},4000)
			});
		}
	}  
</script>
@endif
<!--- Static Condition for beginner ges topic 25 task 6-->
@if(isset($_GET['n']))

 @if($_GET['n'] == "16666234696356a7ed13f21")
    <style type="text/css">
     #abc-16666234266356a7c2ed325
     {
         display: none;
     }
     #abc-16666234996356a80b34528
     {
     	display: none;
     }
     #abc-16666235386356a8327e126
     {
        display: none;
     }
    </style>
 @endif
@endif