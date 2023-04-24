<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
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
                                        $str.= '<div class="choice-box4 j"><input type="text" class="form-control text-left pl-0 form-control-inline" name="text_ans[]" autocomplete="off" value="'.$ans.'" style="display: inline-table; text-align: left;"></div>';
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

  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
  <ul class="list-inline list-buttons">
      <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"
              data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
      </li>
      <li class="list-inline-item"><button type="button"
              class="submit_btn btn btn-primary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1" >Submit</button>
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
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>

<script>
var practice_type="{{$practise['type']}}";
var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";

$(document).on('click','.submitBtn_{{$practise["id"]}}' ,function() {

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
console.log('.form_========>'+pid)
  var $this = $(this);
  $this.attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.form_'+pid).find('.is_save:hidden').val(is_save);


  $.ajax({
      url: '<?php echo URL('save-writing-at-end-speaking'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('.form_'+pid).serialize(),
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


</script>

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
<script>
  if(data31==undefined ){
    var data31=[];
  }
  var token = $('meta[name=csrf-token]').attr('content');
  var upload_url = "{{url('upload-audio')}}";
  var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
  data31["{{$practise['id']}}"]= {"dependentpractice_ans": "{{$data[$practise['id']]['dependentpractice_ans']}}" };
  data31["{{$practise['id']}}"]["isRolePlayPractice"] = "{{$data[$practise['id']]['isRolePlayPractice']}}"
  data31["{{$practise['id']}}"]["is_dependent"] = "{{$data[$practise['id']]['is_dependent']}}"; 
  if(data31["{{$practise['id']}}"]["is_dependent"]==1){
    
    if(data31["{{$practise['id']}}"]["dependentpractice_ans"]==0 ){
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
 
    data31["{{$practise['id']}}"]["typeofdependingpractice"] = "{{ $data[$practise['id']]['typeofdependingpractice'] }}";
    data31["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
    data31["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
    data31["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
    if(data31["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data31["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data31["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data31["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data31["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data31["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data31["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view"){
      
      $(function () { 
        // $('.cover-spin').fadeIn();
      });
      if(data31["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
        
        // IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
        if(data31["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
          setTimeout(function(){ 
          
            data31["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data31["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();        
          
            $(document).find(".showPreviousPractice_"+data31["{{$practise['id']}}"]["dependant_practise_id"]).html(data31["{{$practise['id']}}"]["prevHTML"]);
            $(document).find(".showPreviousPractice_"+data31["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
            $(document).find(".showPreviousPractice_"+data31["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
            $(document).find(".showPreviousPractice_"+data31["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert, .audio-player').remove();
            if( data31["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
              
                $(document).find(".showPreviousPractice_"+data31["{{$practise['id']}}"]["dependant_practise_id"]).find('.pickcolor__heading ').remove();
                $(document).find(".showPreviousPractice_"+data31["{{$practise['id']}}"]["dependant_practise_id"]).find('.delete-icon ').remove();

              
            }
             $('.cover-spin').fadeOut();
          }, 1000,data31 )
        }
      } else {
      
        // IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
        // DO NOT REMOVE BELOW   CODE
        var baseUrl = "{{url('/')}}";
        data31["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
        data31["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data31["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data31["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data31["{{$practise['id']}}"]["dependant_practise_id"];
        $.get(data31["{{$practise['id']}}"]["dependentURL"],  //
        function (dataHTML, textStatus, jqXHR) {  // success callback
          if(  data31["{{$practise['id']}}"]["dependant_practise_id"]!==undefined ){
            data31["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data31["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
            $(document).find(".showPreviousPractice_"+data31["{{$practise['id']}}"]["dependant_practise_id"]).html(data31["{{$practise['id']}}"]["prevHTML"]);
            $(document).find(".showPreviousPractice_"+data31["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
            $(document).find(".showPreviousPractice_"+data31["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, .alert, .audio-player').remove();
            
            if(data31["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" || data31["{{$practise['id']}}"]["typeofdependingpractice"] == "set_full_view_remove_zero_get_single_audio"){
              
              // if(data31["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
                $(document).find(".showPreviousPractice_"+data31["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
              // }
            }
          }
          $('.cover-spin').fadeOut();
        });
      }
    }  
  </script>
@endif
