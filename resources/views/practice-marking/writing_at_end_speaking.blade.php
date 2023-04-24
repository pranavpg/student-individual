
<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
  // dd($practise);
    $answerExists = false;
    $user_answer_temp = [];
    if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
      $answerExists = true;
      $user_answer_temp = $practise['user_answer'][0]['text_ans'];
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
  // print_r($practise);die;
  $style="";
  
  if(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer']) ){
      $depend =explode("_",$practise['dependingpractiseid']);
      $style = "display:none"; 
        
  ?>
      <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
        <p style="margin: 15px;">In order to do this task you need to have completed
        <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
      </div>
  <?php
    }else{
     
      $style = "display:block";
    }
    //if($practise['type']=='writing_at_end_option'){
      $exploded_question = explode(PHP_EOL,$practise['question']);
      $exploded_question = array_filter($exploded_question);
      $exploded_question = array_merge($exploded_question);
    // } else {
    //   $exploded_question = explode('@@',$practise['question']);
    // }
?>
<div class="showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}"></div>
<form class="form_{{$practise['id']}}" >

  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

   <div class="multiple-choice">
      <!-- /. box -->
        
        <?php 
            if(isset($practise['is_roleplay'])){
                ?>
              @include('practice.writing_at_end_speaking_role_play')
                <?php
            }
           
            else{ //dd($practise);?>
              <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="writing_at_end_speaking" value="0">
                @if( !empty($exploded_question) )
              
                      <?php 
                      $s = 0;
                        foreach($exploded_question as $key => $value) {
                           
                            if(str_contains($value,'@@')) {
                              echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$value, &$s, &$ans, &$user_answer_temp) {

                                        $str = "";
                                        $ans = "";
                                        if(!empty($user_answer_temp) && isset($user_answer_temp[$s])){
                                            $ans = $user_answer_temp[$s];
                                        }
                                        $str.= '<div class="choice-box4 j"><input type="text" class="form-control text-left pl-0 form-control-inline" name="text_ans[]" value="'.$ans.'" style="display: inline-table; text-align: left;"></div>';
                                        echo "<br>";
                                        $s++; 
                                    return $str;
                              }, $value);
                            
                            }else{
                                 $s++; 
                                echo "<br>";
                                echo $value;
                                ?>
                                <input type="hidden" name="text_ans[]" value="">
                                <?php
                            }
                        }

                      ?>
                      
                  @endif
                  @if(  $practise['type']=="writing_at_end_speaking")
                    @include('practice.common.audio_record_div',['key'=>0])
                    

                  @endif

                <?php
            }
        ?>
      <br/>
  </div>
</form>

<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>

<script>
var practice_type="{{$practise['type']}}";
var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";

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
    data["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
    data["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
    if(data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view"){
      
      $(function () { 
        // $('.cover-spin').fadeIn();
      });
      if(data["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
        if(data["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
          setTimeout(function(){ 
            data["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();        
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(data["{{$practise['id']}}"]["prevHTML"]);
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert, .audio-player').remove();
            if( data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
                $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.pickcolor__heading ').remove();
                $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.delete-icon ').remove();
            }
             $('.cover-spin').fadeOut();
          }, 1000,data )
        }
      } else {
      
        // IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
        // DO NOT REMOVE BELOW   CODE
        var baseUrl = "{{url('/')}}";
        data["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
        data["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data["{{$practise['id']}}"]["dependant_practise_id"]+'&user_id={{ isset($studentId)?$studentId:'' }}';
        $.get(data["{{$practise['id']}}"]["dependentURL"],  //
        function (dataHTML, textStatus, jqXHR) {  // success callback
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
