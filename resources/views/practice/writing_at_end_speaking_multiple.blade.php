 <link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
<p>
	<strong><?php 	echo $practise['title']; ?></strong>
</p>
<?php
//  echo "<pre>";
//    print_r($practise);  echo "</pre>";
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
 @if(isset($practise['typeofdependingpractice']) && $practise['typeofdependingpractice'] == 'set_full_view')
 <div class="showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}">
 </div>
 @endif
	<form class="form_{{$practise['id']}}">
	<input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
	<input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
	<input type="hidden" class="is_save" name="is_save" value="">
	<input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
	<input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
	@if($practise['type'] == 'writing_at_end_speaking_multiple_up_listening')
	 <div class="audio-player">
		<audio preload="auto" controls src="<?php echo isset($practise['audio_file'])?$practise['audio_file']:"";?>" type="audio/mpga" id="audio_{{$practise['id']}}">
		 <source src="<?php echo isset($practise['audio_file'])?$practise['audio_file']:""?>" type="audio/mp3" >
		</audio>
	 </div>
	@endif
	@if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && isset($practise['dependingpractise_answer']) && empty($practise['dependingpractise_answer']))
		@php
			$depend = explode("_",$practise['dependingpractiseid']);
			$style  = "display:none";
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
							<span class="textarea form-control form-control-textarea enter_disable" role="textbox" contenteditable placeholder="Write here..." style="color:black"><?php if ($answerExists) { echo  str_replace(" ", "&nbsp;", $practise['user_answer'][$key]['text_ans']);} ?></span>
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
                       
					@if($practise['type']=="writing_at_end_speaking_multiple")

						@include('practice.common.audio_record_div',['key'=> $key])
					@endif
				@endif
			@endforeach

		@else
				@if($practise['type']=="writing_at_end_speaking_multiple_up_listening")
				<div class="multiple-choice">
						<p class="mb-0"> </p>
							@include('practice.common.audio_record_div')
						<div class="form-group form-group-label">
							<span class="textarea form-control form-control-textarea" role="textbox"
									contenteditable placeholder="Write here...">
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
		<ul class="list-inline list-buttons">
				<li class="list-inline-item"><button type="button" class="save_btn btn btn-primary speakingMultipleBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"
								data-toggle="modal" data-is_save="0" data-target="#exitmodal">Save</button>
				</li>
				<li class="list-inline-item"><button type="button"
								class="submit_btn btn btn-primary submitBtn speakingMultipleBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1">Submit</button>
				</li>
		</ul>
	</div>
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
					// initialize plyr
					var i;
						var player = new Plyr("#audio_{{$practise['id']}}", {
							controls: [
									'play',
									'progress',
									'current-time',
							]
					});
			} else {
					// no audio support
					$('.column').addClass('hidden');
					var noSupport = $('#audio1').text();
					$('.container').append('<p class="no-support">' + noSupport + '</p>');
			}
		});
		</script>

	@endif
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
		$(document).on('click','.speakingMultipleBtn_{{$practise["id"]}}' ,function() {
			if($(this).attr('data-is_save') == '1'){
                $(this).closest('.active').find('.msg').fadeOut();
            }else{
                $(this).closest('.active').find('.msg').fadeIn();
            }
			var reviewPopup = '{!!$reviewPopup!!}';
			var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
					if(markingmethod =="student_self_marking"){
						if($(this).attr('data-is_save') == '1'){


							var AllAudio = new Array();
		                    var checkAudioAva = new Array();
							$('.form_{{$practise['id']}} .main-audio-record-div').each(function(){
								if($(this).find(".practice_audio").children().attr("src").indexOf("sample-audio.mp3") !== -1){
									checkAudioAva.push("false");
									AllAudio.push($(this).html())
								}else{
									checkAudioAva.push("true");
									AllAudio.push($(this).find(".practice_audio").children().attr("src"))
								}
							});


							var fullView= $(".form_{{$practise['id']}}").html();
							$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
							$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
							$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
							$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
							$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
							$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.delete-icon-right').remove();
							$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.textarea').attr("contenteditable",false);

							var tempInc = 0;
							$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.main-audio-record-div').each(function(){
								$(this).parent().prepend("<div class='append_"+tempInc+" myclass audio-player ' data="+tempInc+" style='    position: relative;display: flex;align-items: center;margin-bottom: 2rem;'></div>")
								tempInc++;
							})
							$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.main-audio-record-div').each(function(){
								$(this).remove()
							}) 
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
					
			var $this = $(this);
			var pid= '{{$practise["id"]}}';
		$this.attr('disabled','disabled');
		var is_save = $(this).attr('data-is_save');
		$('.form_'+pid).find('.is_save:hidden').val(is_save);
		setTextareaContent(pid);
		$.ajax({
			url: '<?php echo URL('save-writing-at-end-speaking'); ?>',
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			type: 'POST',
			data: $('.form_{{$practise["id"]}}').serialize(),
			success: function (data) {
				$this.removeAttr('disabled');
				if(data.success){
					$('.form_'+pid).find('.alert-danger').hide();
					$('.form_'+pid).find('.alert-success').show().html(data.message).fadeOut(8000);
				} else {
					$('.form_'+pid).find('.alert-success').hide();
					$('.form_'+pid).find('.alert-danger').show().html(data.message).fadeOut(8000);
				}
			}
		});
		});
		var token = $('meta[name=csrf-token]').attr('content');
		var upload_url = "{{url('upload-audio')}}";
		var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
		if(data33==undefined ){
			var data33=[];
		} 
		data33["{{$practise['id']}}"]= {"dependentpractice_ans": "{{$data[$practise['id']]['dependentpractice_ans']}}" };
		data33["{{$practise['id']}}"]["isRolePlayPractice"] = "{{$data[$practise['id']]['isRolePlayPractice']}}"
		data33["{{$practise['id']}}"]["is_dependent"] = "{{$data[$practise['id']]['is_dependent']}}"; 

		
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
			if(!flagForAudio){
				
				setTimeout(function(){

					// $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.append_'+inc).find('.plyr__controls__item').fadeOut();
				
					// $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}} .append_"+inc ).css("pointer-events","none");

				},2000)

			}

			}


	</script>

	
@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==0 && $practise['typeofdependingpractice']=='set_full_view' )
<script>

	data33["{{$practise['id']}}"]["typeofdependingpractice"] = "{{ $data[$practise['id']]['typeofdependingpractice'] }}";
	data33["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
	if(data33["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data33["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data33["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data33["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data33["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data33["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data33["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view"){
	  
		data33["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
		data33["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
		$(function () {
			$('.cover-spin').fadeIn();
		});
		if(data33["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
			 
			// IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
			if(data33["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
				
				 
				 setTimeout(function(){ 
				 
					 data33["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data33["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();				 
				 
					$(document).find(".showPreviousPractice_"+data33["{{$practise['id']}}"]["dependant_practise_id"]).html(data33["{{$practise['id']}}"]["prevHTML"]);
					$(document).find(".showPreviousPractice_"+data33["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
					$(document).find(".showPreviousPractice_"+data33["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
					$(document).find(".showPreviousPractice_"+data33["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert').remove();

					if( data33["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" ){
						if(data33["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_no_blanks_listening_speaking_down"  || data33["{{$practise['id']}}"]["dependant_practise_question_type"]== "single_speaking_up_writing" ) {
							$(document).find(".showPreviousPractice_"+data33["{{$practise['id']}}"]["dependant_practise_id"]).find('.audio-player').remove();
							$(document).find(".showPreviousPractice_"+data33["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
						}
					} 
					$('.cover-spin').fadeOut();
				 }, 8000 )
			}
		} else {
		
			// IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
			// DO NOT REMOVE BELOW   CODE
			var baseUrl = "{{url('/')}}";
			data33["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
			data33["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data33["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data33["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data33["{{$practise['id']}}"]["dependant_practise_id"];
			$.get(data33["{{$practise['id']}}"]["dependentURL"],  //
			function (dataHTML, textStatus, jqXHR) {  // success callback
				setTimeout(function(){
					data33["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data33["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
					$(document).find(".showPreviousPractice_"+data33["{{$practise['id']}}"]["dependant_practise_id"]).html(data33["{{$practise['id']}}"]["prevHTML"]);
					$(document).find(".showPreviousPractice_"+data33["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
					$(document).find(".showPreviousPractice_"+data33["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, .alert, input:hidden').remove();
					
					if(data33["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" ){
						
						if(data33["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_no_blanks_listening_speaking_down" || data33["{{$practise['id']}}"]["dependant_practise_question_type"]== "single_speaking_up_writing") {
							$(document).find(".showPreviousPractice_"+data33["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
						}
					}
					$('.cover-spin').fadeOut();
				},8000)
				
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