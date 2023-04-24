<p><strong>{!! $practise['title'] !!}</strong></p>


<?php 
// echo "<pre>";
// dd($practise);
// echo "</pre>";
if(isset($practise['is_roleplay']) && $practise['is_roleplay'] == 1){  ?>
    @include('practice.writing_at_end_role_play')
    <?php

}elseif(isset($practise['dependingpractiseid'])  ){?>
    @include('practice.writing_at_end_dependent')
    <?php
}else{
  // dd($practise);
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

    if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) ){
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
    } else {
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
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{isset($tapscript[0])?$tapscript[0]:""}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
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


    <div class="previous_practice_answer_exists_{{$practise['id']}}" style="{{$style}}">

    @if($practise['type']=='writing_at_end_listening')
      @include('practice.common.audio_player')
    @endif
    <form class="writing_at_end_form_{{$practise['id']}} commonFontSize">

        <?php 

         $tapscripts = explode("/t",$practise['question']);
            $tapscript = explode("#%",$tapscripts[0]);

            if(count($tapscript)>1) {

                if(isset($tapscript[0])){ ?>
                        <div  style="text-align: center;margin-bottom: 27px;pointer-events: auto;">
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
            if( !empty($exploded_question) ){
                foreach( $exploded_question as $key => $value ){

                    if($value!==""){
                        if (str_contains($value, '@@')) { ?>
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
                                                if ($answerExists) {
                                                    echo  !empty($practise['user_answer'][0][$key])? str_replace(" ","&nbsp;",nl2br($practise['user_answer'][0][$key]) ):"";
                                                }
                                            ?>
                                        </span>
                                        <div style="display:none">
                                            <textarea name="user_answer[0][{{$p}}]" class="main-answer-input">
                                                <?php
                                                if ($answerExists){
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
 
    </form>
   
    </div>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
    <script>

        var sorting             = "{{isset($topic_tasks_new)?$topic_tasks_new:''}}";
        var courseType          =  "<?php echo isset($CourseDetails)?$CourseDetails[$sessionAll['topics'][$topicId]['course_id']]['title']:""; ?>";
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
   
        
        $( document ).ready(function() {
             $('.openmodel').click(function(){
                $('#myModal').modal("show");
                return false;
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
<!--- Static Condition for beginner ges topic 09 task 8 AB-->
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
<!------------------------------------------------------------>