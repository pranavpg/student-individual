<p><strong>{!! $practise['title'] !!}</strong></p>
 <?php
 // dd($practise);

    $exploded_question  = array();
  	$user_ans = "";
  	$answerExists = false;
  	if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
		$answerExists = true;
		if(!empty($practise['is_roleplay']) && $practise['is_roleplay']== 1 && $practise['type'] != 'speaking_writing'){
      // pr($practise);
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
	// echo "<pre>";

  // $dependent_practise_answers = $practise['dependingpractise_answer'];
  // dd($dependent_practise_answers);
	// print_r($practise);die;
	$style="";
	
	if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) ){
  		$depend =explode("_",$practise['dependingpractiseid']);
      $style = "display:none"; 
      if( !empty($practise['depending_practise_details']['question'])  ) {
          $exploded_question = explode('@@',$practise['depending_practise_details']['question']);
      }
		  
?>
		<div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; display:none">
			<p style="margin: 15px;">In order to do this task you need to have completed
			<strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
		</div>
<?php
  } else {
    if (isset($practise['question'])) {
      $exploded_question = explode('@@',$practise['question']);
    }
    
  } 
?>



<div class="previous_practice_answer_exists_{{$practise['id']}}" style="{{$style}}">

    @if($data[$practise['id']]['typeofdependingpractice']=='set_full_view_hide_show')
      <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
        <a href="javascript:;" class="btn btn-dark selected_option_hide_show ">Show View</a>
      </div>
    @endif


    @if($practise['type'] == 'speaking_writing' && isset($practise['is_roleplay']) && !empty($practise['is_roleplay']) && $practise['is_roleplay'] == 1)
      @include('practice.speaking_writing_roleplay')
    @elseif(!empty($practise['is_roleplay']) && $practise['is_roleplay']==1)
      @include('practice.speaking_multiple_listening_roleplay')
    @else
        
      <div class="showPreviousPractice {{!empty($practise['depending_practise_details']['question_type'])?$practise['depending_practise_details']['question_type']:''}} showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}">
      </div>
      <form class="form_{{$practise['id']}}">
        <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
        <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
        <input type="hidden" class="is_save" name="is_save" value="">
        <input type="hidden" class="practise_type" name="practice_type" value="{{$practise['type']}}">
        <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
        <?php
          if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
            $depend =explode("_",$practise['dependingpractiseid']);
          ?>
            <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
            <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
        <?php } ?>
        <?php

				$answerExists = false;
			
				if(!empty($practise['question'])){
					if($practise['type']=='speaking_multiple'){
						$exploded_question  =  explode('@@', $practise['question']);
					} elseif($practise['type']== 'speaking_multiple_listening') {
						$exploded_question  =  explode(PHP_EOL, $practise['question']);
					}
				}
				
				if(!empty($practise['typeofdependingpractice']) && $practise['typeofdependingpractice']=='get_answers_generate_quetions') {
					if($practise['type']=='speaking_multiple'){
						if( !empty( $practise['dependingpractise_answer'][0] ) && is_array($practise['dependingpractise_answer'][0])){
							$exploded_question  =  $practise['dependingpractise_answer'][0];
						} 
					}  
				}
			
				if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
					$answerExists = true;
				}
				
			?>
				@if(!empty($practise['typeofdependingpractice']) && $practise['typeofdependingpractice']=="get_questions_and_answers")
          <?php 
            if(!empty($practise['depending_practise_details']['question'])){
              $dependent_practise_questions = explode('@@', $practise['depending_practise_details']['question']);
              $dependent_practise_answers = $practise['dependingpractise_answer'];
            }

            $tempInc = 0;
          ?>
          @if(!empty($dependent_practise_answers))
            @foreach($dependent_practise_answers as $dk => $dv)
              @if(!empty($dv['text_ans']))

                <div class="form-slider p-0 mb-4">
                  <p class="mb-0">{!! $dependent_practise_questions[$dk] !!}</p> 
                  <p class="mb-0">Answer: {{ !empty($dv['text_ans'])? $dv['text_ans']:'' }} </p> 
                  @if($practise['type'] == "speaking_writing_up" || $practise['type'] == "writing_at_end_speaking_up")
                      @include('practice.common.audio_record_div', ['key'=>$tempInc])
                      <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$tempInc}}" name="speaking_writing_up_{{$tempInc}}" value="0">

                      <input type="hidden" name="answer[{{$tempInc}}][path]" class="audio_path{{$tempInc}}">
                  @endif
                  <div class="component-control-box"> 
                    <span class="textarea form-control form-control-textarea spandata-temp fillblanks enter_disable" role="textbox" disabled contenteditable placeholder="Write here...">
                        <?php
                          if ($answerExists)
                          {
                              echo  ($practise['type'] == "speaking_writing_up" || $practise['type'] == "speaking_writing")?$practise['user_answer'][$tempInc]['text_ans']:$practise['user_answer'][0]['text_ans'][0];
                          }
                        ?>
                    </span>
                    <div style="display:none">
                      <textarea name="answer[{{$tempInc}}][text_ans]">
                      <?php
                          if ($answerExists)
                          {
                            echo  ($practise['type'] == "speaking_writing_up" || $practise['type'] == "speaking_writing" )?$practise['user_answer'][$tempInc]['text_ans']:$practise['user_answer'][0]['text_ans'][0];
                          }
                      ?>
                      </textarea>
                    </div>
                  </div>
                </div>
                  <?php $tempInc++; ?>
              @endif
            @endforeach
          @endif
        @else
      
        <?php
          if (isset($practise['question'])) {
           $exploded_question = explode('@@',$practise['question']);
           }
          if(!empty($exploded_question[0])){
            foreach($exploded_question as $key => $value){
        ?>
       
            @if(!empty(trim($value)))
              <div class="form-slider p-0 mb-4">
                <p class="mb-0">{!! $value !!} </p>
                @if($practise['type'] == "speaking_writing_up" || $practise['type'] == "writing_at_end_speaking_up")
                    @include('practice.common.audio_record_div', ['key'=>$key])
                    <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$key}}" name="speaking_writing_up_{{$key}}" value="0">
                @endif

                
                <div class="component-control-box"> 
                  <span class="textarea form-control form-control-textarea spandata-temp fillblanks enter_disable" role="textbox" disabled contenteditable placeholder="Write here...">
                      <?php
                        if ($answerExists)
                        {
                            echo  ($practise['type'] == "speaking_writing_up" || $practise['type'] == "speaking_writing")?$practise['user_answer'][$key]['text_ans']:$practise['user_answer'][$key]['text_ans'][0];
                        }
                      ?>
                  </span>
                  <div style="display:none">
                    <textarea name="answer[{{$key}}][text_ans]">
                      <?php
                        if ($answerExists) {
                          echo  ($practise['type'] == "speaking_writing_up" || $practise['type'] == "speaking_writing" )?$practise['user_answer'][$key]['text_ans']:$practise['user_answer'][$key]['text_ans'][0];
                        }
                      ?>
                    </textarea>
                    <input type="hidden" name="answer[{{$key}}][path]" class="audio_path{{$key}}">
                  </div>
                </div>
              </div>
            @endif
        <?php
            }
          } else {
        ?>
          
            <div class="form-slider p-0 mb-4">
              @if($practise['type'] == "speaking_writing_up" || $practise['type'] == "writing_at_end_speaking_up")
                  @include('practice.common.audio_record_div', ['key'=>0])
                    <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="speaking_writing_up_0" value="0">
              @endif
              <div class="component-control-box"> 
                <span class="textarea form-control form-control-textarea spandata-temp fillblanks enter_disable" role="textbox" disabled contenteditable placeholder="Write here...">
                    <?php
                      if ($answerExists)
                      {
                          echo  ($practise['type'] == "speaking_writing_up" || $practise['type'] == "speaking_writing")?$practise['user_answer'][0]['text_ans']:$practise['user_answer'][0]['text_ans'][0];
                      }
                    ?>
                </span>
                <div style="display:none">
                  <textarea name="text_ans" class="text_ans">
                  <?php
                      if ($answerExists)
                      {
                        echo  ($practise['type'] == "speaking_writing_up" || $practise['type'] == "speaking_writing" )?$practise['user_answer'][0]['text_ans']:$practise['user_answer'][0]['text_ans'][0];
                      }
                  ?>
                  </textarea>
                </div>
              </div>
            </div>
          <?php } ?>
          
        @endif
        @if($practise['type'] == "speaking_writing")
          @include('practice.common.audio_record_div',['key'=>0])
          <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$key}}" name="speaking_writing_up_{{$key}}" value="0">
        @endif
        <div class="alert alert-success" role="alert" style="display:none"></div>
        <div class="alert alert-danger" role="alert" style="display:none"></div>
      </form>
    @endif
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>

<script>
  console.log("Loading");
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
<script type="text/javascript">
  function setTextareaContent(){
    $("span.textarea.form-control").each(function(){
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
    })
  }
  var token = $('meta[name=csrf-token]').attr('content');
  var upload_url = "{{url('upload-audio')}}";
  var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
</script>
@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==0 && $practise['typeofdependingpractice']!='get_answers_generate_quetions' )
  <script>
    data["{{$practise['id']}}"]["typeofdependingpractice"] = "{{ $data[$practise['id']]['typeofdependingpractice'] }}";
    data["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
    data["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
    data["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
    if(data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view"){
      if(data["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
        if(data["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
            data["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();				 
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(data["{{$practise['id']}}"]["prevHTML"]);
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
            setTimeout(function(){
              $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.audio-player').remove();
            },5000)
            $(document).find(".showPreviousPractice_{{$practise['depending_practise_details']['dependant_practise_id']}}").find('.audio-player').remove();
            if( data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
              if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
                $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
              }
            }
        }
      } else {
        var baseUrl = "{{url('/')}}";
        data["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
        data["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data["{{$practise['id']}}"]["dependant_practise_id"]+'&user_id={{ isset($studentId)?$studentId:'' }}';
        $.get(data["{{$practise['id']}}"]["dependentURL"],  //
        function (dataHTML, textStatus, jqXHR) {
          if(  data["{{$practise['id']}}"]["dependant_practise_id"]!==undefined ){
            data["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(data["{{$practise['id']}}"]["prevHTML"]);
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, .alert, .audio-player').remove();
            if(data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" || data["{{$practise['id']}}"]["typeofdependingpractice"] == "set_full_view_remove_zero_get_single_audio"){
                $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
            }
          }
          $('.cover-spin').fadeOut();
        });
      }
    }  
  </script>
@endif
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
<style type="text/css">
  .showPreviousPractice.reading_no_blanks	*[contenteditable]:empty:before {
	    content: "\feff"; /* ZERO WIDTH NO-BREAK SPACE */
	}
	.showPreviousPractice.reading_no_blanks .appendspan {
	 	color:red;
	}
</style>