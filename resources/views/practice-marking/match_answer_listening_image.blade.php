
<p><strong>{!! $practise['title'] !!}</strong></p>

<?php
// dd($practise);
  if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid']) && !empty($practise['dependingpractiseid']) && isset($practise['dependingpractise_answer']) && empty($practise['dependingpractise_answer']) ){
      $depend =explode("_",$practise['dependingpractiseid']);
      if(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer'])){
        $displayPractise="block";
        $displayDependancy="none";

       }else{
        $displayPractise="none";
        $displayDependancy="block";
       }
    ?>
      <input type="hidden" class="get_answers_put_into_quetions_topic_id" name="get_answers_put_into_quetions_topic_id" value="{{$topicId}}">
      <input type="hidden" class="get_answers_put_into_quetions_task_id" name="depend_task_id" value="{{$depend[0]}}">
    <input type="hidden" class="get_answers_put_into_quetions_practise_id" name="depend_practise_id" value="{{$depend[1]}}">

    <div id="dependant_pr_{{$practise['id']}}" style="display:{{$displayDependancy}}; border: 2px dashed gray; border-radius: 12px;">
    <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
    </div>
    <?php 
  }?>
<style>
.bg-list-light-red {
    background-color: #ffcccb;
}
.draw-image {
  padding: 10px;
}
.draw-image img {
  border-radius: 18px;
}
</style>

<?php
// echo '<pre>'; print_r($practise);
//  dd($practise);
$q1=array();
$q2=array();
$answerExists = false;
if(!empty($practise['user_answer'])){
    $answerExists = true;
    if($practise['type']=='match_answer_speaking'){
      $user_ans = explode(';',$practise['user_answer'][0]['text_ans']);
      array_pop($user_ans);
    }
    else {
      if(isset($practise['user_answer']) && !empty($practise['user_answer']) && !is_array($practise['user_answer'])){
        $answerExists = true;
        $user_ans = explode(';',$practise['user_answer']);
        array_pop($user_ans);
      }
      
       //dd($user_ans); //2;5; ; ;4;3;
    }
   
}
?>

<?php
 if($practise['type']=="match_answer" || $practise['type']=='match_answer_speaking' || $practise['type']=="match_answer_listening_image" || $practise['type']=='match_answer_image' || $practise['type']=="match_answer_listening") 
  {
    $displayPractise="block";
    $displayDependancy="none";
    $condition = !empty($practise['question']) && !empty($practise['question_2']);

    $q1 = $practise['question'];
    // $q2 = $practise['question_2'];
    
     $q2 = isset($practise['question_2'])?$practise['question_2']:[];

    if(isset($q1[0]) && str_contains($q1[0],'#@')){
      $explode_question = explode( '#@', $q1[0]);
      $explode_question_header = explode( '@@', $explode_question[0]);
      $q1[0] = $explode_question[1];
    } else {

      $explode_question         = explode( '#@', $q2[0]);
      $explode_question_header  = explode( '@@', $explode_question[0]);
    // dd($explode_question);
      $q2[0] = isset($explode_question[1])?$explode_question[1]:"";
    }
  }

// dd($q2);
  ?>
<!--Component Draw Image End-->
<?php
if($condition) {


  ?>
  <form class="form_{{$practise['id']}}" style="display:{{$displayPractise}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practise_type" name="practice_type" value="{{$practise['type']}}">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    @if($practise['type']=="match_answer_listening" || $practise['type']=="match_answer_listening_image" )
      <div class="audio-player">
        <audio preload="auto" controls src="<?php echo $practise['audio_file'];?>" type="audio/mp3" id="audio_{{$practise['id']}}">
          <!-- <source > -->
        </audio>
      </div>
    @endif
    <div class="match-answer mb-4">
      <div class="row">
        @if(!empty($explode_question_header[0]))
          <div class="col-md-6 match-answer__block">
              <h3>{{$explode_question_header[0]}}</h3>
          </div>
        @endif
        @if(!empty($explode_question_header[1]))
          <div class="col-md-6 match-answer__block">
              <h3>{{$explode_question_header[1]}}</h3>
          </div>
        @endif
      </div>
      <div class="match-answer__block">
          <ul class="list-unstyled row">
            <?php
              $background_color_class =  array('match-option-color-one','match-option-color-two','match-option-color-three','match-option-color-four','match-option-color-five','match-option-color-six','match-option-color-seven','match-option-color-eight','match-option-color-nine','match-option-color-ten','match-option-color-eleven','match-option-color-twelve','match-option-color-thirteen','match-option-color-fourteen','match-option-color-fifteen','match-option-color-sixteen','match-option-color-seventeen','match-option-color-eighteen','match-option-color-ninteen','match-option-color-twenty');
            ?>
             @foreach($q1 as $key => $value)
              @if(!empty(trim($value)))
                <li class="list-item col-12 col-md-6 bg-list-light-gray  question_option  question_option_{{$key}}" data-key="{{$key}}" data-bgcolor="{{$background_color_class[$key]}}">
                  @if($practise['type']=="match_answer_listening_image" || $practise['type']=="match_answer_image" )
                   <?php 
                    $type = Array(1 => 'jpg', 2 => 'jpeg', 3 => 'png', 4 => 'gif'); 
                    $ext = explode(".",$value);
                    $ext = end($ext);
                                      ?>
                   @if(isset($ext[1]))
                     @if(!in_array($ext,$type))
                       {!! $value !!}
                     @else
                       <img src="{{$value}}" width="100px">
                     @endif
                   @else
                      {!! $value !!}
                   @endif
                  @else
                      {!!  $value !!}
                  @endif
                  <input type="hidden" name="text_ans[]" value=" " class="hidden">
                </li>
                <li class="list-item col-12 col-md-6 bg-list-light-gray answer_option answer_option_{{$key}}" data-key="{{$key}}">
                  <strong>{!! !empty($q2[$key])?$q2[$key]:"" !!}</strong>
                </li>
              @endif
            @endforeach
          </ul>
          @if(  $practise['type'] == "match_answer_speaking" )
              @include('practice.common.audio_record_div',['key'=>0])
          @endif
      </div>
    </div>
    <!-- /. Component Match Answer End -->

    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
    <!-- <ul class="list-inline list-buttons">
        <li class="list-inline-item"><button class="btn btn-secondary submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
        </li>
        <li class="list-inline-item"><button
                class="btn btn-secondary submitBtn_{{$practise['id']}}" data-is_save="1" data-pid="{{$practise['id']}}" >Submit</button>
        </li>
    </ul> -->
  </form>
  <?php
}
?>
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
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

  var token = $('meta[name=csrf-token]').attr('content');
  var upload_url = "{{url('upload-audio')}}";
  var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
</script>
<script>

  $(document).ready(function() {

    <?php if($answerExists){ ?>
      
        var user_answers = <?php echo json_encode($user_ans) ?>;
        var submit_answer = [];
        var colors = <?php echo json_encode($background_color_class) ?>;
        //console.log("colors: ", colors);

        $('.question_option').each(function(i){
            var c_class = parseInt(user_answers[i]); //4

            if(isNaN(c_class) == false){
                $('.form_{{$practise["id"]}} .question_option:eq('+i+')').addClass(colors[i]);
                $('.form_{{$practise["id"]}} .question_option:eq('+i+')').addClass(' confirmed active-bg');
                $('.form_{{$practise["id"]}} .question_option:eq('+i+')').find('input:hidden').val(c_class);
            }
            else{
                $('.form_{{$practise["id"]}} .question_option:eq('+i+')').find('input:hidden').val(" ");
            }
        });

        $('.form_{{$practise["id"]}} .answer_option').each(function(i){
            var c_class = parseInt(user_answers[i]); //4

            if(isNaN(c_class) == false){
                $('.form_{{$practise["id"]}} .answer_option:eq('+c_class+')').addClass(colors[i]);
                //$('.answer_option:eq('+c_class+')').find('input:hidden').val(i);
                submit_answer.push({ "id": i , "value" : c_class});
            }
            else{
                submit_answer.push({ "id": i , "value" : " "});
            }


        });
        // console.log("submit_ans : ", submit_answer)

    <?php } ?>
});
</script>

<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
