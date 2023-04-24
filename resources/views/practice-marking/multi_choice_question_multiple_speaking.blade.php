<p><strong>{!!$practise['title']!!}</strong></p>
<?php
//pr($practise);
//pr(json_encode($practise['user_answer']));
$exp_question = explode(PHP_EOL, $practise['question']);

?>
<style>
.multi_choice_question_ms .custom-checkbox .custom-control-label:before {
    border-color: #007bff;
    background-color: #fff !important;
}

.multi_choice_question_ms .multiple-check .custom-control-input:checked~.custom-control-label:after, .multiple-check .custom-control-input:checked~.custom-control-label:before {
    border-color: #d55b7d !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    outline: none !important;
    background-color: #d55b7d !important;
    background-image: url(https://s3.amazonaws.com/imperialenglish.co.uk/ieukstudentpublic/images/icon-custom-check.svg) !important;
    background-position: center !important;
    background-repeat: no-repeat !important;
    background-size: 18px auto !important;
}
</style>
<!-- Compoent - Two click slider-->
<form class="multi_choice_question_ms form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_type" name="practise_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
<!-- /.Audio Player-->
  @if(!empty($exp_question))
    <div class="multiple-choice multiple-check">
      @foreach($exp_question as $key => $value)
   
        <div class="choice-box">
          <p> {{ substr(strstr($value, '.'), 1)}} </p>
          <?php
              $userAnswer=array();
              //pr($practise['user_answer'][0]['text_ans']);
               if(isset($practise['user_answer'][0]['text_ans'][$key]['ans']) && !empty($practise['user_answer'][0]['text_ans'][$key]['ans'])){
                 $userAnswer= explode(":",$practise['user_answer'][0]['text_ans'][$key]['ans']);
               }
              // pr()
          ?>
          <div class="d-flex ieukcc-boxo">
            @foreach($practise['options'][$key] as $k => $v )
              <?php $ans_val = $k."@@".$v; ?>
              <div class="custom-control custom-checkbox w-md-33">
                  <input type="checkbox" class="custom-control-input" id="cc_{{$key}}_{{$k}}_{{$v}}" name="user_answer[{{$key}}][]" value="{{$ans_val}}" <?php if(!empty($userAnswer) && (in_array($v, $userAnswer))){ echo "checked";}?>>
                  <label class="custom-control-label" for="cc_{{$key}}_{{$k}}_{{$v}}">{{$v}}</label>
              </div>
            @endforeach
          </div>
        </div>
        <input type="hidden" name="user_default_answer[]" value="{{$value}}" >

      @endforeach
      <!-- /. Choice Box -->
    </div>
  @endif
  <!-- Audio Player-->
  @include('practice.common.audio_record_div',['key'=>0])
  <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="multi_choice_question_multiple_speaking" value="0">


</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<script>

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
var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";

</script>

<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
