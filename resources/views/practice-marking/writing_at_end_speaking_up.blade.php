<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
      // echo '<pre>'; print_r($practise);
    $answerExists = false; $answer =$exploded_question= array();
    if(isset($practise['user_answer']) && !empty($practise['user_answer'][0]['text_ans'])){
      $answerExists = true;
      $answers = $practise['user_answer'][0]['text_ans'][0];
    }
    // dd($practise);
    if(isset($practise['question']) && !empty($practise['question'])){      
      $exploded_question = explode(PHP_EOL,$practise['question']);
    }
    $data[$practise['id']] = array();
    $data[$practise['id']]['isRolePlayPractice'] = (!empty($practise['is_roleplay']) &&  $practise['is_roleplay'] == 1)?1:0;
    $data[$practise['id']]['typeofdependingpractice'] = !empty($practise['typeofdependingpractice']) ? $practise['typeofdependingpractice'] : "";
    $data[$practise['id']]['setFullViewFromPreviousPractice'] = !empty($practise['depending_practise_details']['dependant_practise_id']) ? $practise['depending_practise_details']['dependant_practise_id']:"";
    $data[$practise['id']]['dependant_practise_topic_id'] = !empty($practise['depending_practise_details']['dependant_practise_topic_id']) ? $practise['depending_practise_details']['dependant_practise_topic_id']:"";
    $data[$practise['id']]['dependant_practise_task_id'] = !empty($practise['depending_practise_details']['dependant_practise_task_id']) ? $practise['depending_practise_details']['dependant_practise_task_id']:"";
    $data[$practise['id']]['dependant_practise_question_type'] = !empty($practise['depending_practise_details']['question_type']) ? $practise['depending_practise_details']['question_type']:"";
    $data[$practise['id']]['dependentpractice_ans'] = !empty($practise['dependingpractise_answer'])?1:0;
    $data[$practise['id']]['is_dependent'] = !empty($practise['is_dependent']) ? 1 : 0;
  ?>
@if(isset($practise['is_roleplay']) && !empty($practise['is_roleplay']) && $practise['type'] == 'writing_at_end_speaking_up')
    @include('practice.writing_at_end_speaking_up_roleplay')
@else
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
	
		@php
			$style = "display:block";
      
		@endphp
      @if(isset($practise['dependingpractise_answer'][0]) && !empty($practise['dependingpractise_answer'][0]) && $practise['typeofdependingpractice'] == 'get_answers_put_into_answers')
        @php $dependAnswer[]=$practise['dependingpractise_answer'][0];        
         @endphp
      @endif
      @if(isset($practise['dependingpractise_answer'][0]) && !empty($practise['dependingpractise_answer'][0]) && $practise['typeofdependingpractice'] == 'get_questions_and_answers')
        
        @foreach($practise['dependingpractise_answer'][0] as $question)
            @if(!empty($question))
              @php $exploded_question[]=$question.'@@'; @endphp
            @else
              @php $exploded_question[]=''; @endphp
            @endif
        @endforeach
      @endif
	@endif
  @if(isset($practise['typeofdependingpractice']) && $practise['typeofdependingpractice'] != 'get_answers_put_into_answers')
<div style="{{$style}}" class="showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}">
</div>
@endif
@if(isset($practise['typeofdependingpractice']) && $practise['typeofdependingpractice'] == 'set_full_view_remove_zero_get_single_audio')
    @if(isset($practise['dependingpractise_answer'][0]['path']) && !empty($practise['dependingpractise_answer'][0]['path']))
    @php $practise['audio_file']=$practise['dependingpractise_answer'][0]['path']; @endphp
      @include('practice.common.audio_player')
    @php $practise['audio_file']=""; @endphp
		@endif
@endif
<form class="writing_at_end_speakingform_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  <div style="{{$style}}">
      <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="writing_at_end_speaking_up" value="0">
      <input type="hidden" name="user_audio[0][path]" class="audio_path0">
      @include('practice.common.audio_record_div',['key'=>0])
      <ul class="list-unstyled">
          @foreach($exploded_question as $key=>$item)
            <li>
              @if(str_contains($item,'@@'))
                @php $item = str_replace('@@', '', $item); @endphp
                {!! $item !!}
                <span class="textarea form-control form-control-textarea enter_disable" role="textbox" disabled contenteditable placeholder="Write here..."> 
                    <?php
                      if($answerExists == true && array_key_exists($key, $practise['user_answer'][0]['text_ans'])) {
                          echo  $practise['user_answer'][0]['text_ans'][$key];
                      }elseif(isset($dependAnswer[0][$key]) && !empty($dependAnswer[0][$key])){
                        echo $dependAnswer[0][$key];
                      }
                    ?>
                </span>
              <div style="display:none">
                  <textarea name="text_ans[{{$key}}]" disabled="true">
                  <?php
                      if($answerExists == true && array_key_exists($key, $practise['user_answer'][0]['text_ans'])) {
                        echo str_replace(" ", "&nbsp;", $practise['user_answer'][0]['text_ans'][$key]);
                        
                      }elseif(isset($dependAnswer[0][$key]) && !empty($dependAnswer[0][$key])){
                        echo $dependAnswer[0][$key];
                      }
                  ?> </textarea>
              </div>
            </li>
          @else
          <input type="hidden" name="text_ans[{{$key}}]" value="">

          {!! $item !!}
          @endif
        @endforeach
      </ul>
      <div class="alert alert-success" role="alert" style="display:none"></div>
      <div class="alert alert-danger" role="alert" style="display:none"></div>
  </div>
</form>
@endif
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
<script>
    var practice_type="{{$practise['type']}}";
    var token = $('meta[name=csrf-token]').attr('content');
    var upload_url = "{{url('upload-audio')}}";
    var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
  	if(data==undefined ){
  		var data=[];
  	} 
   	var token = $('meta[name=csrf-token]').attr('content');
  	var upload_url = "{{url('upload-audio')}}";
  	var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
  	data["{{$practise['id']}}"]= {"dependentpractice_ans": "{{$data[$practise['id']]['dependentpractice_ans']}}" };
  	data["{{$practise['id']}}"]["isRolePlayPractice"] = "{{$data[$practise['id']]['isRolePlayPractice']}}"
  	data["{{$practise['id']}}"]["is_dependent"] = "{{$data[$practise['id']]['is_dependent']}}"; 
  	if(data["{{$practise['id']}}"]["is_dependent"]==1){
  		if(data["{{$practise['id']}}"]["dependentpractice_ans"]==0 ){
  			$(".previous_practice_answer_exists_{{$practise['id']}}").hide();
  			$("#dependant_pr_{{$practise['id']}}").show();
  		} else {
  			$(".previous_practice_answer_exists_{{$practise['id']}}").show();
  			$("#dependant_pr_{{$practise['id']}}").hide();
  		}
  	} else {
      $(".previous_practice_answer_exists_{{$practise['id']}}").show();
      $("#dependant_pr_{{$practise['id']}}").hide();
    }

</script>
@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==0 && $practise['typeofdependingpractice']!='get_answers_generate_quetions' )
<script>
	data["{{$practise['id']}}"]["typeofdependingpractice"] = "{{ $data[$practise['id']]['typeofdependingpractice'] }}";
	data["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
	if(data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_top_zero"|| data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_get_single_audio" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view"){
		data["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
		data["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
		if(data["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
			if(data["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
					 data["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();				 
					$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(data["{{$practise['id']}}"]["prevHTML"]);
					$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
					$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
					$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert, .audio-player').remove();
					if( data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
						if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
							$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('findset').remove();
						}
					}
			}
		} else {
      var pid = "{{$practise['id']}}";
			var baseUrl = "{{url('/')}}";
			data["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
			data["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data["{{$practise['id']}}"]["dependant_practise_id"]+'&user_id={{ isset($studentId)?$studentId:'' }}';
			$.get(data["{{$practise['id']}}"]["dependentURL"],  //
			function (dataHTML, textStatus, jqXHR) {  // success callback
				data["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
				$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(data["{{$practise['id']}}"]["prevHTML"]);
				$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
				$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, .alert, .audio-player').remove();
			  if(pid == "15567095145cc9808aaa772")
        {
      	  $(".deleteRecordingButton_0").hide();
        }
				if(data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
					 
					if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
						$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
					}
				}
        
			});
		}
	}  
</script>
@endif
<!--- Static Condition for beginner ges topic 21 task 3 AB-->
@if($practise['id'] == "16656589656347f05540862")
<style type="text/css">
  .record_16656589656347f05540862 .plyr__controls
  {
    display: none !important; 
  }
</style>
@endif
<!------------------------------------------------------------->
