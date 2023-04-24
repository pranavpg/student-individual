<form class="save_listening_writing_form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_type" name="practise_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  <input type="hidden" name="is_roleplay" value="true" >
  <input type="hidden" class="is_roleplay_submit" name="is_roleplay_submit" value="1">

    <?php
    //echo '<pre>'; print_r($practise); 
      if(isset($practise['question']) && !empty($practise['question']) && str_contains($practise['question'],'##')){
        $roleplay = explode('##',$practise['question']);
        $roleplayTitle=explode('@@',$roleplay[0]);
        array_shift($roleplay); //     
      }
      
       //echo '<pre>'; print_r($roleplay); 

    if(isset($practise['is_dependent']) && !empty($practise['is_dependent'])){
       $depend =explode("_",$practise['dependingpractiseid']);
          }
    ?>
{{--<!-- <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
                    @foreach($roleplayTitle as $k=> $title)
                        <a href="javascript:;" id="s-button-{{$k}}" class="btn btn-dark selected_option selected_option_{{$k}} s-button">{!!$title!!}</a>
                    @endforeach                            
                </div> -->--}}
  <div class="component-two-click mb-4">
    <div class="showPreviousPractice_{{$practise['id']}} mb-4"></div>   
  </div>
  <div class="tab-content" id="abc-tabContent">
        <div class="tab-pane fade show active" id="abc-b" role="tabpanel" aria-labelledby="abc-b-tab">
            <div class="component-two-click mb-4">
            <?php $answer_count=0; ?>
              <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
                  @foreach($roleplayTitle as $k => $value)
                  <?php
                    if (str_contains($value, '##'))
                    {
                        $last_ans = explode('##', $value);
                        $value = $last_ans[0];
                    }
                    ?>
                  <a href="#!" class="btn btn-dark selected_option selected_option_{{$k}}" data-ans_count={{$answer_count}} data-key="{{$k}}" data-show_dependent_error="{{ ( !empty($practise['dependingpractiseid']) && empty($practise['dependingpractise_answer'][$answer_count]) )?1:0 }}" >{{$value}}</a>
                  <?php $answer_count+=2 ?>
                  @endforeach
              </div>
              
                @php 
                    $roleplayKey = 0;
                @endphp 
                
                <div class="two-click-content w-100">
                    @foreach($roleplay as $key=> $roleplayQuestion)                                     
                    <div class="content-box multiple-choice d-none selected_option_description selected_option_description_{{$key}}">
                        
                            <div class="w-100">
                            
                            @php 
                              $displayWriting="none"; 
                              $displayDependBox="block"; 
                            @endphp
                            @if(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer']))
                              
                                @if(isset($practise['dependingpractise_answer'][$roleplayKey]['path']) && !empty($practise['dependingpractise_answer'][$roleplayKey]['path']))
                        
                                    <div class="audio-player">
                                        <audio preload="none" controls  src="<?php echo $practise['dependingpractise_answer'][$roleplayKey]['path'];?>"  type="audio/mp4" id="audio_{{$roleplayKey}}_{{$practise['id']}}"></audio>
                                    </div>
                                    <script>
                                    jQuery(function ($) {
                                          'use strict'
                                          var supportsAudio = !!document.createElement('audio').canPlayType;
                                          if (supportsAudio) {
                                              // initialize plyr
                                              var i;

                                                  var player = new Plyr("#audio_{{$roleplayKey}}_{{$practise['id']}}", {
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
                                   @php $displayWriting="block"; 
                                        $displayDependBox="none"; 
                                  @endphp
                                @endif
                            @endif
                            <p>
                            <br>
                            <div style="display:{{$displayWriting}}">                                                              
                                <p>
                                    <div class="form-slider p-0 mb-4">
                                        <div class="component-control-box">
                                            <span class="textarea form-control form-control-textarea set_full_view_main stringProper" role="textbox" contenteditable="" placeholder="Write here..." >{!! isset($practise['user_answer'][$roleplayKey]) ? nl2br($practise['user_answer'][$roleplayKey]) : ''!!}</span>
                                            <div style="display:none">
                                              <textarea name="writeingBox[]">{!! isset($practise['user_answer'][$roleplayKey]) ? nl2br($practise['user_answer'][$roleplayKey]) : ''!!}</textarea>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </p>
                            </div>
                            <div id="defined_dependant_task_{{$practise['id']}}" style="display:{{$displayDependBox}}; border: 2px dashed gray; border-radius: 12px;">
                                <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                            </div>
                            </div>
                        </div>
                      @php $roleplayKey= $roleplayKey + 2 ; @endphp
                    @endforeach
                    <input type="hidden" name="role_play" value='1'>
                </div>
            </div>
        </div>
    </div>

  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
  <ul class="list-inline list-buttons">
      <li class="list-inline-item"><button type="button" class="btn btn-secondary saveBtn listeningWritingBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"
          data-toggle="modal" data-is_save="0" data-target="#exitmodal">Save</button></li>
      <li class="list-inline-item"><button type="button"
          class="btn btn-secondary submitBtn listeningWritingBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1">Submit</button></li>
  </ul>
</form>

@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==1 && $practise['typeofdependingpractice']!='get_answers_generate_quetions' )

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
	// if(data["{{$practise['id']}}"]["is_dependent"]==1){
		
	// 	if(data["{{$practise['id']}}"]["dependentpractice_ans"]==0 ){
	// 		$(".previous_practice_answer_exists_{{$practise['id']}}").hide();
	// 		$("#dependant_pr_{{$practise['id']}}").show();
	// 	} else {
	// 		$(".previous_practice_answer_exists_{{$practise['id']}}").show();
	// 		$("#dependant_pr_{{$practise['id']}}").hide();
	// 	}
	// }
      
    $(function() {
        data["{{$practise['id']}}"]["dependent_is_roleplay"] = "{{$data[$practise['id']]['dependent_is_roleplay']}}";
        
        $(".save_listening_writing_form_{{$practise['id']}}").find(".selected_option").click(function() {
            var content_key = $(this).attr('data-key');
            var show_dependent_error = parseInt($(this).attr('data-show_dependent_error'));
            
            $(".save_listening_writing_form_{{$practise['id']}}").find('.selected_option').not(this).toggleClass('d-none');
            $(".save_listening_writing_form_{{$practise['id']}}").find('.selected_option_description_' + content_key).toggleClass('d-none');
            $(".save_listening_writing_form_{{$practise['id']}}").find('.selected_option_' + content_key).show();
            $(".save_listening_writing_form_{{$practise['id']}}").find(this).toggleClass('btn-bg');
            var answer_count = 0;
            $(".showPreviousPractice_{{$practise['id']}}").html("")
            if(content_key>0) {
              answer_count = parseInt(content_key);
            }
            
            if ($(".save_listening_writing_form_{{$practise['id']}}").find('.selected_option_description:visible').length > 0) {
                if(data["{{$practise['id']}}"]["dependent_is_roleplay"] && show_dependent_error!=1){
                  
                  roleplayDependent(content_key, answer_count)
                }
              
                $(".dependant_pr_{{$practise['id']}}").show();
                $(".save_listening_writing_form_{{$practise['id']}}").find('.is_roleplay_submit').val(0);
                $(".save_listening_writing_form_{{$practise['id']}}").find('.submitBtn').attr('data-is_save', 0);
            } else {
                $(".dependant_pr_{{$practise['id']}}").hide();
                $(".showPreviousPractice_{{$practise['id']}}").html("").show()
                $(".save_listening_writing_form_{{$practise['id']}}").find('.is_roleplay_submit').val(1);
                $(".save_listening_writing_form_{{$practise['id']}}").find('.submitBtn').attr('data-is_save',1);
            }
        });
    });
 

    function roleplayDependent(content_key, answer_count){
    
      data["{{$practise['id']}}"]["typeofdependingpractice"] = "{{$data[$practise['id']]['typeofdependingpractice']}}";
      data["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{$data[$practise['id']]['dependant_practise_question_type']}}";
      if(data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_hide_show" || data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_parentextra" || data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_gen_que_double" || data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" || data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_get_ans" || data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view" || data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero_get_single_audio"){
        data["{{$practise['id']}}"]["dependant_practise_task_id"] =  "{{$data[$practise['id']]['dependant_practise_task_id']}}";
        data["{{$practise['id']}}"]["dependant_practise_id"] = "{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}";
        $(function () {
            // $('.cover-spin').fadeIn();
        })
        if(data["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{ request()->segment(3)}}"){
          
          // IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
          if(data["{{$practise['id']}}"]["dependant_practise_id"] !="" ){

            setTimeout(function(){ 
               
              $(".showPreviousPractice_{{$practise['id']}}").html("");
              if(data["{{$practise['id']}}"]["dependent_is_roleplay"] == 1 ){
            
                var prevHTML = $(document).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').find( '.selected_option_description_'+answer_count).html();	
                if(prevHTML==undefined){
                  var prevHTML = $(document).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').find( '#table_dependent_'+answer_count).html();	
                }			 
              } else {
                var prevHTML = $(document).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').find( '.selected_option_description_'+content_key ).html();				 
              }
 
             
              $(".showPreviousPractice_{{$practise['id']}}").html(prevHTML).show();
              $(".showPreviousPractice_{{$practise['id']}}").css('pointer-events','none');
              $(".showPreviousPractice_{{$practise['id']}}").find('ul.list-buttons').remove();
              $(".showPreviousPractice_{{$practise['id']}}").find('div.table-container').removeClass('d-none');
             
              if(data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
                if( data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up" ||  data["{{$practise['id']}}"]["dependant_practise_question_type"] == "single_speaking_up_writing") {
                  $(".showPreviousPractice_{{$practise['id']}}").find('fieldset').remove();
                }
              }
              if(data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero_parentextra_get_questions_and_answers"){
                if( data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up" ||  data["{{$practise['id']}}"]["dependant_practise_question_type"] == "single_speaking_up_writing") {
                  $(".showPreviousPractice_{{$practise['id']}}").find('fieldset').remove();
                  $(".showPreviousPractice_{{$practise['id']}}").find('.two-click').remove();
                }
              }  
              // $('.cover-spin').fadeOut();
            }, 4000)
          }
        } else {
          
          // IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
          // DO NOT REMOVE BELOW   CODE
          var baseUrl = "{{url('/')}}";
          
          data["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{$data[$practise['id']]['dependant_practise_topic_id']}}";
          var dependentURL = baseUrl+'/topic/'+data["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data["{{$practise['id']}}"]["dependant_practise_id"]+'&user_id={{ isset($studentId)?$studentId:'' }}';
          // console.log(data);
          $.get(dependentURL,function (dataHtml, textStatus, jqXHR) {
            // console.log(dataHtml);
            // alert('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]);  // success callback
            var prevHTML = $(dataHtml).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').find('.selected_option_description_'+content_key).html();				 
             //alert(prevHTML);
            $('.showPreviousPractice_{{$practise["id"]}}').html(prevHTML);
            $(".showPreviousPractice_{{$practise['id']}}").css('pointer-events','none');
            $(".showPreviousPractice_{{$practise['id']}}").find('ul.list-buttons').remove();
            if(data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero_get_single_audio"){
              
              if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up" ||  data["{{$practise['id']}}"]["dependant_practise_question_type"] == "single_speaking_up_writing") {
                $(".showPreviousPractice_{{$practise['id']}}").find('fieldset').remove();
              }
              if(data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero_get_single_audio"){
                if( data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up" ||  data["{{$practise['id']}}"]["dependant_practise_question_type"] == "single_speaking_up_writing") {
                  $(".showPreviousPractice_{{$practise['id']}}").find('fieldset').remove();
                }
              }
              
            }
            // $('.cover-spin').fadeOut();
          });
        }
      }  
    }
  </script>
@elseif(empty($practise['is_dependent']) && $practise['is_roleplay']==1 )
<script>
    $(".save_listening_writing_form_{{$practise['id']}}").find(".selected_option").click(function() {
      
      var content_key = $(this).attr('data-key');
      var show_dependent_error = parseInt($(this).attr('data-show_dependent_error'));
      
      $(".save_listening_writing_form_{{$practise['id']}}").find('.selected_option').not(this).toggleClass('d-none');
      $(".save_listening_writing_form_{{$practise['id']}}").find('.selected_option_description_' + content_key).toggleClass('d-none');
      $(".save_listening_writing_form_{{$practise['id']}}").find('.selected_option_' + content_key).show();
      $(".save_listening_writing_form_{{$practise['id']}}").find(this).toggleClass('btn-bg');
      var answer_count = 0;
      $(".showPreviousPractice_{{$practise['id']}}").html("")
      if(content_key>0) {
        answer_count = parseInt(content_key)  ;
      }
      
      if ($(".save_listening_writing_form_{{$practise['id']}}").find('.selected_option_description:visible').length > 0) {
        
        $(".dependant_pr_{{$practise['id']}}").show();
        $(".save_listening_writing_form_{{$practise['id']}}").find('.is_roleplay_submit').val(0);
        $(".save_listening_writing_form_{{$practise['id']}}").find('.submitBtn').attr('data-is_save', 0);
      } else {
        $(".dependant_pr_{{$practise['id']}}").hide();
        $(".showPreviousPractice_{{$practise['id']}}").html("")
        $(".save_listening_writing_form_{{$practise['id']}}").find('.is_roleplay_submit').val(1);
        $(".save_listening_writing_form_{{$practise['id']}}").find('.submitBtn').attr('data-is_save',1);
      }
    });
</script>
@else
<script>

function roleplayDependent(content_key,answer_count="0"){
  return true;
}
</script>
@endif
<script>
  var token = $('meta[name=csrf-token]').attr('content');
  var upload_url = "{{url('upload-audio')}}";
  var workerDirPath = "{{asset('public/js/audio-recorder/')}}";   
</script>
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
