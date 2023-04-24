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
      

      <!-- /. Component Audio Player END-->

      <ul class="list-unstyled">
        @foreach($exploded_question as $key=>$item)

          <li>
          @if(str_contains($item,'@@'))
              @php $item = str_replace('@@', '', $item); @endphp
              {!! $item !!}
            <span class="textarea form-control form-control-textarea enter_disable" role="textbox"
                contenteditable placeholder="Write here...">
                <?php
                  if($answerExists == true && array_key_exists($key, $practise['user_answer'][0]['text_ans']))
                  {
                      echo  $practise['user_answer'][0]['text_ans'][$key];
                      // echo $practise['user_answer'][0]['text_ans'][$key];
                  }elseif(isset($dependAnswer[0][$key]) && !empty($dependAnswer[0][$key])){
                    echo $dependAnswer[0][$key];
                  }
                ?>
            </span>
            <div style="display:none">
                <textarea name="text_ans[{{$key}}]">
                <?php
                    if($answerExists == true && array_key_exists($key, $practise['user_answer'][0]['text_ans']))
                    {
                      // echo $practise['user_answer'][0]['text_ans'][$key];
                      echo str_replace(" ", "&nbsp;", $practise['user_answer'][0]['text_ans'][$key]);
                      
                    }elseif(isset($dependAnswer[0][$key]) && !empty($dependAnswer[0][$key])){
                      echo $dependAnswer[0][$key];
                    }
                ?>
                </textarea>
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
      <ul class="list-inline list-buttons">
          <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn writing_at_end_up_speaking_up_{{$practise['id']}}" data-pid="{{$practise['id']}}"
                  data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
          </li>
          <li class="list-inline-item"><button type="button"
                  class="submit_btn btn btn-primary submitBtn writing_at_end_up_speaking_up_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1" >Submit</button>
          </li>
      </ul>
  </div>
</form>
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
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>

<script>
    var practice_type="{{$practise['type']}}";
    var token = $('meta[name=csrf-token]').attr('content');
    var upload_url = "{{url('upload-audio')}}";
    var workerDirPath = "{{asset('public/js/audio-recorder/')}}";

    $(document).on('click','.writing_at_end_up_speaking_up_{{$practise["id"]}}' ,function() {

      if($(this).attr('data-is_save') == '1'){
          $(this).closest('.active').find('.msg').fadeOut();
      }else{
          $(this).closest('.active').find('.msg').fadeIn();
      }
      
      var reviewPopup = '{!!$reviewPopup!!}';
			var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
					if(markingmethod =="student_self_marking"){
						if($(this).attr('data-is_save') == '1'){
							var fullView= $(".form_{{$practise['id']}}").html();
							$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
							$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
							$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
							$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
							$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
						}
					}
					if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){

						$("#reviewModal_{{$practise['id']}}").modal('toggle');

					}
      var pid= $(this).attr('data-pid');

        var $this = $(this);
      $this.attr('disabled','disabled');
      var is_save = $(this).attr('data-is_save');
      $('.writing_at_end_speakingform_{{$practise["id"]}}').find('.is_save:hidden').val(is_save);
      $('.writing_at_end_speakingform_{{$practise["id"]}}').find("span.textarea.form-control").each(function(){
            var currentVal = $(this).html();
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

      $.ajax({
          url: '<?php echo URL('save-writing-at-end-speakings'); ?>',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          type: 'POST',
          data: $('.writing_at_end_speakingform_{{$practise['id']}}').serialize(),
          success: function (data) {
            $this.removeAttr('disabled');
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
                        //window.location.href=baseUrl+'/topic/'+topic_id+'/'+task_id+'?n='+dependentPractiseId
                      ////$('#abc-'+dependentPractiseId+'-tab').trigger('click');
                    } else {
                      //$('.nav-link.active').parent().next().find('a').trigger('click');
                    }
                  },2000);
                  // =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
                }
                $('.writing_at_end_speakingform_{{$practise['id']}}').find('.alert-danger').hide();
                $('.writing_at_end_speakingform_{{$practise['id']}}').find('.alert-success').show().html(data.message).fadeOut(8000);
            } else {
                $('.writing_at_end_speakingform_{{$practise['id']}}').find('.alert-success').hide();
                $('.writing_at_end_speakingform_{{$practise['id']}}').find('.alert-danger').show().html(data.message).fadeOut(8000);
            }
          }
      });
    });

	if(data35==undefined ){
		var data35=[];
	}
 	var token = $('meta[name=csrf-token]').attr('content');
	var upload_url = "{{url('upload-audio')}}";
	var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
	data35["{{$practise['id']}}"]= {"dependentpractice_ans": "{{$data[$practise['id']]['dependentpractice_ans']}}" };
	data35["{{$practise['id']}}"]["isRolePlayPractice"] = "{{$data[$practise['id']]['isRolePlayPractice']}}"
	data35["{{$practise['id']}}"]["is_dependent"] = "{{$data[$practise['id']]['is_dependent']}}"; 
	if(data35["{{$practise['id']}}"]["is_dependent"]==1){
		
		if(data35["{{$practise['id']}}"]["dependentpractice_ans"]==0 ){
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
	data35["{{$practise['id']}}"]["typeofdependingpractice"] = "{{ $data[$practise['id']]['typeofdependingpractice'] }}";
	data35["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
	if(data35["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_top_zero"|| data35["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_get_single_audio" || data35["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data35["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data35["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data35["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data35["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data35["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data35["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view"){
	  
		data35["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
		data35["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
  
		if(data35["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
			 
			// IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
			if(data35["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
				//setTimeout(function(){ 
 				 
					 data35["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data35["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();				 
				 
					$(document).find(".showPreviousPractice_"+data35["{{$practise['id']}}"]["dependant_practise_id"]).html(data35["{{$practise['id']}}"]["prevHTML"]);
					$(document).find(".showPreviousPractice_"+data35["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
					$(document).find(".showPreviousPractice_"+data35["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
					$(document).find(".showPreviousPractice_"+data35["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert, .audio-player').remove();
					if( data35["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
						if(data35["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
							$(document).find(".showPreviousPractice_"+data35["{{$practise['id']}}"]["dependant_practise_id"]).find('findset').remove();
						}
					}
          // $('.cover-spin').fadeOut();
				//}, 1000,data )
			}
		} else {
		 
      //  alert('edwfhi');
			// IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
			// DO NOT REMOVE BELOW   CODE
			var baseUrl = "{{url('/')}}";
      //---delete-recording-15567093555cc97feb1e213-0
      var del_button_pid = data35["{{$practise['id']}}"]["dependant_practise_id"];//"{{$practise['id']}}";
			data35["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
			data35["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data35["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data35["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data35["{{$practise['id']}}"]["dependant_practise_id"];
			$.get(data35["{{$practise['id']}}"]["dependentURL"],  //
			function (dataHTML, textStatus, jqXHR) {  // success callback
				data35["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data35["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
				$(document).find(".showPreviousPractice_"+data35["{{$practise['id']}}"]["dependant_practise_id"]).html(data35["{{$practise['id']}}"]["prevHTML"]);
				$(document).find(".showPreviousPractice_"+data35["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
				$(document).find(".showPreviousPractice_"+data35["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, .alert, .audio-player').remove();
             $(".delete-recording-"+del_button_pid+"-0").hide();
        //--------------------------------------------------
				if(data35["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
					 
					if(data35["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
						$(document).find(".showPreviousPractice_"+data35["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
					}
				}
        
			});
		}
	}  
</script>
@else
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