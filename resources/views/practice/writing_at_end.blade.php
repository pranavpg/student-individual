<p><strong>{!! $practise['title'] !!}</strong></p>
<?php 
if(isset($practise['is_roleplay']) && $practise['is_roleplay'] == 1){  ?>
    @include('practice.writing_at_end_role_play')
    <?php

}elseif(isset($practise['dependingpractiseid'])  ){?>
    @include('practice.writing_at_end_dependent')
    <?php
}else{
?>      
<?php
$user_ans = "";
$answerExists = false;
if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
}
?>
<?php
$style="";
 if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) )
 {
    $depend =explode("_",$practise['dependingpractiseid']);
    $style= "display:none";     
    if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
        $answerExists = true;
        if(!empty($practise['user_answer'][0])){
          $user_ans = $practise['user_answer'][0];
        }
 }
 ?>
    <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; display:none">
        <p style="margin: 15px;">In order to do this task you need to have completed
        <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
     </div>
 <?php
} 
else 
{
    $isTabscript = false;
    if (strpos($practise['question'], '#%') !== false) {
        $isTabscript        = true;
        $tapscripts         = explode("/t",$practise['question']);
        $tapscript          = explode("#%",$tapscripts[0]);
        $exploded_question  = explode(PHP_EOL,$tapscripts[1]);
    }else{
        $exploded_question  = explode(PHP_EOL,$practise['question']);
    }
}
?>
@if($isTabscript)
    <div id="myModal" class="modal fade" role="dialog" style="z-index:1051;">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{isset($tapscript[0])?$tapscript[0]:""}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php 
                if(isset($tapscript[1])){
                    echo nl2br($tapscript[1]);
                }         
                ?>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="submitBtnd btn btn-cancel" data-dismiss="modal">Close</button>
            </div>
        </div>
      </div>
    </div>
@endif
<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
<div class="previous_practice_answer_exists_{{$practise['id']}}" style="{{$style}}">
@if($practise['type']=='writing_at_end_listening')
  @include('practice.common.audio_player')
@endif
<form class="writing_at_end_form_{{$practise['id']}} commonFontSize">
<?php 
 $tapscripts = explode("/t",$practise['question']);
 $tapscript = explode("#%",$tapscripts[0]);
 if(count($tapscript)>1) {
     if(isset($tapscript[0]))
    { ?>
        <div  style="text-align: center;margin-bottom: 27px;">
            <button id="openmodel" class=" openmodel btn btn-primary">{{$tapscript[0]}}</button>
        </div>
     <?php
    }
 }
?>
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
     
        <div class="writing_at_end">
          <?php $p=0; 
            $exploded_question = array_filter($exploded_question);
            $exploded_question = array_merge($exploded_question);
            $tempArray = array();
            foreach($exploded_question as $new => $data){
                if($data!="\r"){
                    array_push($tempArray,$data);
                }
            }
            // print_r($exploded_question);
            $exploded_question = $tempArray;
            if(!empty($exploded_question)){
                foreach( $exploded_question as $key => $value ){
                    if($value!==""){
                        if(str_contains($value, '@@')) { ?>
                                <div class="choice-box">
                                    <?php
                                    if( $practise['type']=="writing_at_end_option"){ ?>
                                        <p class="mb-0">{!! nl2br(substr(str_replace('@@', '', $value),2)) !!} </p>
                                    <?php
                                    }else{
                                        ?>
                                         <p class="mb-0 main-question">{!! nl2br(str_replace('@@', '', $value)) !!} </p>
                                        <?php
                                    }?>
                                    <div class="form-group">
                                        <span class="textarea form-control form-control-textarea main-answer enter_disable" role="textbox" contenteditable placeholder="Write here...">
                                            <?php
                                                if($answerExists) {
                                                    echo  !empty($practise['user_answer'][0][$key])? str_replace(" ","&nbsp;",nl2br($practise['user_answer'][0][$key]) ):"";
                                                }
                                            ?>
                                        </span>
                                        <div style="display:none">
                                            <textarea name="user_answer[0][{{$p}}]" class="main-answer-input">
                                                <?php
                                                if($answerExists){
                                                    echo  !empty($practise['user_answer'][0][$key])? str_replace(" ","&nbsp;",nl2br($practise['user_answer'][0][$key]) ):"";
                                                }
                                                ?>
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                        <?php
                        }else{

                            ?>
                            <div class="first-question">
                              <p class="mb-0  main-answer">{!! nl2br($value) !!}</p>
                              <input type="hidden" name="user_answer[0][{{$key}}]">
                            </div>
                            <br>
                            <?php
                        }
                        $p++; 
                    }
                }
            } ?>
        </div>

      <div class="alert alert-success" role="alert" style="display:none"></div>
      <div class="alert alert-danger" role="alert" style="display:none"></div>
      <ul class="list-inline list-buttons">
          <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary  submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"
                  data-toggle="modal" data-is_save="0" data-target="#exitmodal"  >Save</button>
          </li>
          <li class="list-inline-item"><button type="button"
                  class="submit_btn btn btn-primary  submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1" >Submit</button>
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
    </div>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
    <script>
        var sorting             = "{{ isset($topic_tasks_new)?$topic_tasks_new:$topic_tasks[0]['sorting'] }}";
        var courseType          = "<?php echo $CourseDetails; ?>";
        var courseType          = courseType.split("-");
        var level               = courseType[1];
        var courseType          = courseType[0];
        var feedbackPopup       = true;
        if(level == "ELEMENTARY"){
            if(courseType == "GES" && sorting == 14){
                var facilityFeedback    = true;
                var courseFeedback      = false;         
            }else if(courseType == "AES" && sorting == 29){
                var facilityFeedback    = true;
                var courseFeedback      = false;
            }else{
                var facilityFeedback    = false;
                var courseFeedback      = true;
            }
        }else if(level == "INTERMEDIATE"){

            if(courseType == "GES" && sorting == 29){
                var facilityFeedback    = true;
                var courseFeedback      = false;
            }else if(courseType == "AES" && sorting == 29){
                var facilityFeedback    = true;
                var courseFeedback      = false;
            }else{
                var facilityFeedback    = true;
                var courseFeedback      = false;
            }

        }else if(level == "ADVANCED"){

            if(courseType == "GES" && sorting == 4){
                var facilityFeedback    = true;
                var courseFeedback      = false;
            }else if(courseType == "GES" && sorting == 14){
                var facilityFeedback    = true;
                var courseFeedback      = false;
            }else if(courseType == "GES" && sorting == 29){
                var facilityFeedback    = true;
                var courseFeedback      = false;
            }else if(courseType == "GES" && sorting == 30){
                var facilityFeedback    = false;
                var courseFeedback      = true;
            }else{
                var facilityFeedback    = true;
                var courseFeedback      = false;
            }
        }
        $('.enter_disable').keypress(function(event){
            if (event.which == '13') {
              event.preventDefault();
            }
        });
        $(document).on('click','.openmodel',function(){
            $('#myModal').modal("show");
            return false;
        })
     
        jQuery(function ($) {
             'use strict'
            var supportsAudio = !!document.createElement('audio').canPlayType;
            if (supportsAudio) {
                var i;
                var player = new Plyr("#audio_{{$practise['id']}}", {
                controls: [
                    'play',
                    'progress',
                    'current-time'
                ]});
            } else {
                $('.column').addClass('hidden');
                var noSupport = $('#audio1').text();
                $('.container').append('<p class="no-support">' + noSupport + '</p>');
            }
        });
        $(document).on('click','.submitBtn_{{$practise["id"]}}' ,function() {
            if($(this).attr('data-is_save') == '1'){
                $(this).closest('.active').find('.msg').fadeOut();
            }else{
                $(this).closest('.active').find('.msg').fadeIn();
            }
            var reviewPopup = '{!!$reviewPopup!!}';
            var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){                    var fullView= $(".writing_at_end_form_{{$practise['id']}}").html();                    
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.enter_disable').attr("contenteditable",false);
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.textarea').attr("contenteditable",false);
                }
            }
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){
                $("#reviewModal_{{$practise['id']}}").modal('toggle');
            }

            var $this = $(this);
            $this.attr('disabled','disabled');
            var is_save = $(this).attr('data-is_save');
            $('.writing_at_end_form_{{$practise["id"]}}').find('.is_save:hidden').val(is_save);
            $('.writing_at_end_form_{{$practise["id"]}}').find("span.textarea.form-control").each(function(){
              var currentVal = $(this).html();
              $(this).next().find("textarea").val(currentVal);
            });

            $.ajax({
                url: '<?php echo URL('save-writing-at-end-option'); ?>',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                data: $('.writing_at_end_form_{{$practise["id"]}}').serialize(),
                success: function (data) {
                    console.log(data);
                    $this.removeAttr('disabled');
                    if(data.success){
                        if(is_save=="1"){
                            setTimeout(function(){
                                $('.alert-success').hide();
                                var isNextTaskDependent =  $('.nav-link.active').parent().next().find('a').attr('data-dependent');
                                if( isNextTaskDependent == 1 ){
                                  var dependentPractiseId =  $('.nav-link.active').parent().next().find('a').attr('data-id');
                                  var baseUrl = "{{url('/')}}";
                                  var topic_id = "{{request()->segment(2)}}";
                                  var task_id = "{{request()->segment(3)}}";
                                }
                            },2000);
                        }
                        $('.writing_at_end_form_{{$practise["id"]}}').find('.alert-danger').hide();
                        $('.writing_at_end_form_{{$practise["id"]}}').find('.alert-success').show().html(data.message).fadeOut(8000);
                    } else {
                        $('.writing_at_end_form_{{$practise["id"]}}').find('.alert-success').hide();
                        $('.writing_at_end_form_{{$practise["id"]}}').find('.alert-danger').show().html(data.message).fadeOut(8000);
                    }
                }
            });
        });
    </script>
    @if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 )
    <script>
    $( document ).ready(function() {
      var practise_id = $(".writing_at_end_form_{{$practise['id']}}").find('.depend_practise_id').val();
      if(practise_id){
        // getDependingPractise();
      } else{
        $('.previous_practice_answer_exists_{{$practise["id"]}}').show();
      }
    });
    </script>
    @endif
<?php } ?>
<!--- Static Condition for beginner ges topic 09 task 8 AB --->
<style type="text/css">
 #abc-1629890480612627b01e67d
 {
     display: none;
 }
 #abc-1629890534612627e6028cd
 {
     display: none;
 }
</style>
<!------------------------------------------------------------->
