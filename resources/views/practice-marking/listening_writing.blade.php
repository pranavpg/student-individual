<p><strong>{!! $practise['title'] !!}</strong></p>
<?php

  $user_ans = "";
  $answerExists = false;
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
		$answerExists = true;
  }
  
	$dep = array();
  // pr($practise);
  $dep_pr_id = $practise['id'];
	$setFullViewFromPreviousPractice_lw = !empty($practise['depending_practise_details']['dependant_practise_id']) ? $practise['depending_practise_details']['dependant_practise_id']:"";
	$dependant_practise_topic_id_lw = !empty($practise['depending_practise_details']['dependant_practise_topic_id']) ? $practise['depending_practise_details']['dependant_practise_topic_id']:"";
	$dependant_practise_task_id_lw = !empty($practise['depending_practise_details']['dependant_practise_task_id']) ? $practise['depending_practise_details']['dependant_practise_task_id']:"";


  $answerExists = false;
  $exploded_question  = array();
  $data[$practise['id']] = array();
  $data[$practise['id']]['isRolePlayPractice'] = (!empty($practise['is_roleplay']) &&  $practise['is_roleplay']==1)?1:0;
  $data[$practise['id']]['typeofdependingpractice'] = !empty($practise['typeofdependingpractice']) ? $practise['typeofdependingpractice'] : "";
  $data[$practise['id']]['setFullViewFromPreviousPractice'] = !empty($practise['depending_practise_details']['dependant_practise_id']) ? $practise['depending_practise_details']['dependant_practise_id']:"";
  $data[$practise['id']]['dependant_practise_topic_id'] = !empty($practise['depending_practise_details']['dependant_practise_topic_id']) ? $practise['depending_practise_details']['dependant_practise_topic_id']:"";
  $data[$practise['id']]['dependant_practise_task_id'] = !empty($practise['depending_practise_details']['dependant_practise_task_id']) ? $practise['depending_practise_details']['dependant_practise_task_id']:"";
  $data[$practise['id']]['dependant_practise_question_type'] = !empty($practise['depending_practise_details']['question_type']) ? $practise['depending_practise_details']['question_type']:"";
  $data[$practise['id']]['dependent_is_roleplay'] = !empty($practise['depending_practise_details']['is_roleplay']) ? $practise['depending_practise_details']['is_roleplay']:"";
  $data[$practise['id']]['dependentpractice_ans'] = !empty($practise['dependingpractise_answer'])?1:0;
  $data[$practise['id']]['is_dependent'] = !empty($practise['is_dependent']) ? 1 : 0;

  
	
	$dependentpractice_ans = !empty($practise['dependingpractise_answer'])?1:0;
	$is_dependent =  !empty($practise['is_dependent'])?1:0;
?>




@if( !empty($practise['is_roleplay']) )
        @include('practice.listening_writing_roleplay')
@else 

<?php
 //echo '<pre>'; print_r($practise);
	$style="";
	
	if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) ){
  		$depend =explode("_",$practise['dependingpractiseid']);
  		
  
      if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
        $answerExists = true;
        if(!empty($practise['user_answer'][0])){
          $user_ans = $practise['user_answer'][0];
        }
      }
      
    ?>
    @if(empty($practise['dependingpractise_answer']))
      @php
        $style= "display:none";
      @endphp
      <div id="" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
        <p style="margin: 15px;">In order to do this task you need to have completed
        <strong>Practice  {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
      </div>
    @elseif(!empty($practise['dependingpractise_answer']))
      @if(isset($practise['typeofdependingpractice']) && $practise['typeofdependingpractice'] == 'get_single_audio')
        @php  
          $practise['audio_file'] = isset($practise['dependingpractise_answer'][1])?$practise['dependingpractise_answer'][1]:$practise['dependingpractise_answer'][0];          
        @endphp
        
      @endif
      
    @endif
    <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
			<p style="margin: 15px;">In order to do this task you need to have completed
			<strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
    </div>
    
<?php
  	} else {
      if(isset($practise['question'])){

		    $exploded_question = explode(PHP_EOL,$practise['question']);
      }else{
        $exploded_question =[];
      }
	}
	
	$dependentpractice_ans = !empty($practise['dependingpractise_answer'])?1:0;
  $is_dependent =  !empty($practise['is_dependent'])?1:0;
  if(!empty($practise['dependingpractiseid'])){
    $dependend_practise = explode('_', $practise['dependingpractiseid'] ) ;
    $previous_practice_id = $dependend_practise[1];
  }

?>
@if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer']))
    <div class="showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}"></div>
  
@endif

  <div class="previous_practice_answer_exists_{{$practise['id']}}" style="{{$style}}">
    <div class="showPreviousPractice">
    </div>
    <form class="save_listening_writing_form_{{$practise['id']}}" style="{{$style}}">
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
      @if(isset($practise['audio_file']) && !empty($practise['audio_file']))
        @if($practise['type'] == "speaking_multiple_listening" || $practise['type']=='listening_writing')
          @include('practice.common.audio_player')
        @endif
      @endif
      <div class="form-slider p-0 mb-4">
        <div class="component-control-box">
          <?php
            if(isset($practise['user_answer']) && isset($practise['user_answer'])){
              $userAnswer=$practise['user_answer'];
            }else{
              $userAnswer='';
            }
            ?>
          <span class="textarea form-control form-control-textarea stringProper" role="textbox"
            contenteditable placeholder="Write here..." name="writeingBox" value="writeingBox">{{$userAnswer}}</span>
          <div style="display:none">
            <textarea name="writeingBox">{{$userAnswer}}</textarea>
          </div>
        </div>
      </div>

    </form>
  </div>
@endif
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<script>
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
	}

</script>
@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==0 && $practise['typeofdependingpractice']!='get_answers_generate_quetions' )
<script>
    
	data["{{$practise['id']}}"]["typeofdependingpractice"] = "{{ $data[$practise['id']]['typeofdependingpractice'] }}";
	data["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
	if(data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_top_zero"){
	  
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
					if( data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
            
							$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.audio-player').remove();

						if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
							$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
                        }
                        if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "set_in_order_vertical_listening") {
							$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.audio-player').remove();
						}
					}
                     $('.cover-spin').fadeOut();
				}, 1000,data )
			}
		} else {
			var baseUrl = "{{url('/')}}";
			data["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
			data["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data["{{$practise['id']}}"]["dependant_practise_id"]+'&user_id={{ isset($studentId)?$studentId:'' }}';
			$.get(data["{{$practise['id']}}"]["dependentURL"],  //
			function (dataHTML, textStatus, jqXHR) {  // success callback
				data["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
				$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(data["{{$practise['id']}}"]["prevHTML"]);
				$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
				$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, .alert').remove();
				
				if(data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
					 
					if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
						$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
					}
				}
             
			});
		}
	} else {
	 
		setTimeout(function(){
			// $('#cover-spin').fadeIn();
            getSpeakingMultipleDependency();
            // $('.cover-spin').fadeOut();
		},5000);
		
		
	}
</script>
@endif
<script>
var dependentpractice_ans = "{{	$setFullViewFromPreviousPractice_lw }}";
	var is_dependent = "{{$is_dependent}}"; 
	if(is_dependent==1){
		
		if(dependentpractice_ans=="0" ){
			$(".previous_practice_answer_exists_{{$practise['id']}}").hide();
			$("#dependant_pr_{{$practise['id']}}").show();
		} else {
			$(".previous_practice_answer_exists_{{$practise['id']}}").show();
			$("#dependant_pr_{{$practise['id']}}").hide();
		}
	}
  var dependant_practise_id_lw = "{{$setFullViewFromPreviousPractice_lw}}";
  	var baseUrl = "{{url('/')}}";
		var dependant_practise_topic_id = "{{$dependant_practise_topic_id_lw}}";
		var dependant_practise_task_id = "{{$dependant_practise_task_id_lw}}";
		var dependentURL = baseUrl+'/topic/'+dependant_practise_topic_id+'/'+dependant_practise_task_id+'?n='+dependant_practise_id_lw
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
    });
  }
   var player = "";
    function Audioplay(pid){
      var supportsAudio = !!document.createElement('audio').canPlayType;
      if (supportsAudio) {
        $('.modal').find('.plyr__controls:first').remove()
              var i;
              player = new Plyr(".modal .audio_"+pid, {
                  controls: [
                      'play',
                      'progress',
                      'current-time'
                  ]
              }); 


          } else {
              // no audio support
              $('.column').addClass('hidden');
              var noSupport = $('#audio1').text();
              $('.container').append('<p class="no-support">' + noSupport + '</p>');
          } 
    }
</script>
<script src="{{ asset('public/js/audioplayer.js') }}"></script>
