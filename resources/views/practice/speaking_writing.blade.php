<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
  // pr($practise);
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
    $exploded_question = explode('@@',$practise['question']);
  } 
?>

<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">

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
          ?>
          @if(!empty($dependent_practise_answers))
            @foreach($dependent_practise_answers as $dk => $dv)
              @if(!empty($dv['text_ans']))
                <div class="form-slider p-0 mb-4">
                  <p class="mb-0">{!! $dependent_practise_questions[$dk] !!}</p> 
                  <p class="mb-0">Answer: {{ !empty($dv['text_ans'])? $dv['text_ans']:'' }} </p> 
                  @if($practise['type'] == "speaking_writing_up" || $practise['type'] == "writing_at_end_speaking_up")
                      @include('practice.common.audio_record_div', ['key'=>$dk])
                      <input type="hidden" name="answer[{{$dk}}][path]" class="audio_path{{$dk}}">
                      <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="speaking_writing" value="0">

                  @endif
                  <div class="component-control-box"> 
                    <span class="textarea form-control form-control-textarea spandata-temp fillblanks test_1" role="textbox"
                        contenteditable placeholder="Write here...">
                        <?php
                          if ($answerExists)
                          {
                              echo  ($practise['type'] == "speaking_writing_up" || $practise['type'] == "speaking_writing")?$practise['user_answer'][$dk]['text_ans']:$practise['user_answer'][0]['text_ans'][0];
                          }
                        ?>
                    </span>
                    <div style="display:none">
                      <textarea name="answer[{{$dk}}][text_ans]">
                      <?php
                          if ($answerExists)
                          {
                            echo  ($practise['type'] == "speaking_writing_up" || $practise['type'] == "speaking_writing" )?$practise['user_answer'][$dk]['text_ans']:$practise['user_answer'][0]['text_ans'][0];
                          }
                      ?>
                      </textarea>
                    </div>
                  </div>
                </div>
              @endif
            @endforeach
          @endif
        @else
      
        <?php
          
           $exploded_question = explode('@@',$practise['question']);
           
          if(!empty($exploded_question[0])){
            foreach($exploded_question as $key => $value){
        ?>
       
            @if(!empty(trim($value)))
              <div class="form-slider p-0 mb-4">
                <p class="mb-0">{!! $value !!} </p>
                @if($practise['type'] == "speaking_writing_up" || $practise['type'] == "writing_at_end_speaking_up")
                    @include('practice.common.audio_record_div', ['key'=>$key])
                  <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$key}}" name="speaking_writing_{{$key}}" value="0">

                @endif

                
                <div class="component-control-box"> 
                  <span class="textarea form-control form-control-textarea spandata-temp fillblanks enter_disable test_2" role="textbox"
                      contenteditable placeholder="Write here...">
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
                  <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="speaking_writing" value="0">

              @endif
              <div class="component-control-box"> 
                <span class="textarea form-control form-control-textarea spandata-temp fillblanks test_3" role="textbox"
                    contenteditable placeholder="Write here...">
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
          <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="speaking_writing" value="0">
        @endif
        <div class="alert alert-success" role="alert" style="display:none"></div>
        <div class="alert alert-danger" role="alert" style="display:none"></div>
        <ul class="list-inline list-buttons">
            <li class="list-inline-item"><button class="save_btn btn btn-primary submitBtn_{{$practise['id']}}"
                    data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
            </li>
            <li class="list-inline-item"><button
                    class="submit_btn btn btn-primary submitBtn_{{$practise['id']}}" data-is_save="1"  >Submit</button>
            </li>
        </ul>
      </form>
    @endif
</div>
@if($practise["markingmethod"] == "student_self_marking")
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
<script>
  if(data26==undefined ){
    var data26=[];
  }
  var token = $('meta[name=csrf-token]').attr('content');
  var upload_url = "{{url('upload-audio')}}";
  var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
  data26["{{$practise['id']}}"]= {"dependentpractice_ans": "{{$data[$practise['id']]['dependentpractice_ans']}}" };
  data26["{{$practise['id']}}"]["isRolePlayPractice"] = "{{$data[$practise['id']]['isRolePlayPractice']}}"
  data26["{{$practise['id']}}"]["is_dependent"] = "{{$data[$practise['id']]['is_dependent']}}"; 
  if(data26["{{$practise['id']}}"]["is_dependent"]==1){
    
    if(data26["{{$practise['id']}}"]["dependentpractice_ans"]==0 ){
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
            var AllAudio = new Array();
            var checkAudioAva = new Array();
            $('.form_{{$practise['id']}} .main-audio-record-div').each(function(){
                if($(this).find(".practice_audio").children().attr("src").indexOf("sample-audio.mp3") !== -1) {
                    checkAudioAva.push("false");
                    AllAudio.push($(this).find('.audio-element').html())
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
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
            var tempInc = 0;
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.main-audio-record-div').each(function(){
                $(this).parent().prepend("<div class='append_"+tempInc+" myclass audio-player ' data="+tempInc+"></div>")
                tempInc++;
            });
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.main-audio-record-div').each(function(){
              $(this).remove()
            }); 
            $.each(AllAudio,function(k,v){
                var audioTemp   = ' <audio preload="auto" controls class="practice_audio answer_audio-{{$practise['id']}}-'+k+'">\
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
    $('.submitBtn_{{$practise["id"]}}').attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);
    setTextareaContent();
      $('.spandata-temp').each(function(){
          $(this).next().find(".text_ans").val($(this).text())
          $(this).next().find(".text_ans").html($(this).text())
          $(this).next().find(".text_ans").text($(this).text())
    })
    $.ajax({
        url: '<?php echo URL('save-speaking-writing'); ?>',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $('.form_{{$practise["id"]}}').serialize(),
        success: function (data) {
          $('.submitBtn_{{$practise["id"]}}').removeAttr('disabled');
          if(data.success){
            $('.alert-danger').hide();
            $('.alert-success').show().html(data.message).fadeOut(8000);
          } else {
            $('.alert-success').hide();
            $('.alert-danger').show().html(data.message).fadeOut(8000);
          }
        }
    });
    return false;
});
var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";

</script>
@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==0 && $practise['typeofdependingpractice']!='get_answers_generate_quetions' )
  <script>
 
    data26["{{$practise['id']}}"]["typeofdependingpractice"] = "{{ $data[$practise['id']]['typeofdependingpractice'] }}";
    data26["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
    data26["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
    data26["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
    if(data26["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data26["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data26["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data26["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data26["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data26["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data26["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view"){
      
      $(function () { 
        // $('.cover-spin').fadeIn();
      });
      if(data26["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
        
        // IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
        if(data26["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
          //setTimeout(function(){ 
            data26["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data26["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();        
          
            $(document).find(".showPreviousPractice_"+data26["{{$practise['id']}}"]["dependant_practise_id"]).html(data26["{{$practise['id']}}"]["prevHTML"]);
            $(document).find(".showPreviousPractice_"+data26["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
            $(document).find(".showPreviousPractice_"+data26["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
            // display none download button
            $(document).find(".showPreviousPractice_"+data26["{{$practise['id']}}"]["dependant_practise_id"]).find('#sendTeacher').css('display','none');
            // end
            setTimeout(function(){

            // $(document).find(".previous_practice_answer_exists_{{$practise['id']}}").find('.alert, .audio-player, input:hidden').remove();
            // alert((".showPreviousPractice_{{$practise['id']}}"))
            $(document).find(".showPreviousPractice_"+data26["{{$practise['id']}}"]["dependant_practise_id"]).find('.audio-player').remove();
            },5000)
            // alert($('.practise_id').val())
            $(document).find(".showPreviousPractice_{{$practise['depending_practise_details']['dependant_practise_id']}}").find('.audio-player').remove();
            
            if( data26["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
              //  alert(data26["{{$practise['id']}}"]["dependant_practise_id"]);
              if(data26["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
                $(document).find(".showPreviousPractice_"+data26["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
                
              }

            }
            // $('.cover-spin').fadeOut();
          //}, 1000,data )
        }
      } else {
      
        // IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
        // DO NOT REMOVE BELOW   CODE
        var baseUrl = "{{url('/')}}";
        data26["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
        data26["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data26["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data26["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data26["{{$practise['id']}}"]["dependant_practise_id"];
        $.get(data26["{{$practise['id']}}"]["dependentURL"],  //
        function (dataHTML, textStatus, jqXHR) {  // success callback
          if(  data26["{{$practise['id']}}"]["dependant_practise_id"]!==undefined ){
            data26["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data26["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
            $(document).find(".showPreviousPractice_"+data26["{{$practise['id']}}"]["dependant_practise_id"]).html(data26["{{$practise['id']}}"]["prevHTML"]);
            $(document).find(".showPreviousPractice_"+data26["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
            $(document).find(".showPreviousPractice_"+data26["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, .alert, .audio-player').remove();
            
            if(data26["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" || data26["{{$practise['id']}}"]["typeofdependingpractice"] == "set_full_view_remove_zero_get_single_audio"){
              
              // if(data26["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
                $(document).find(".showPreviousPractice_"+data26["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
              // }
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
  .showPreviousPractice.reading_no_blanks [contenteditable] {
    outline: 0px solid transparent;
  }

  .showPreviousPractice.reading_no_blanks *[contenteditable]:empty:before
  {
      content: "\feff"; /* ZERO WIDTH NO-BREAK SPACE */
  }

  .showPreviousPractice.reading_no_blanks .resizing-input1 {
    display: inline-flex; /* takes only the content's width */
    /*align-items: stretch; by default / takes care of the equal height among all flex-items (children) */
  }

  .showPreviousPractice.reading_no_blanks .appendspan {
    color:red;
  }

  .showPreviousPractice.reading_no_blanks .resizing-input1 > * {
      margin: 0 5px !important; /* just for demonstration */
  }
</style>