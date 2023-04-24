<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
  // pr($practise);
  $answerExists = false;
  if(!empty($practise['user_answer'])){
    $answerExists = true;
    //  pr($practise['user_answer']);
    $answer = $practise['user_answer'][0]['text_ans'];
  }
  $practise['question'] = nl2br($practise['question']);
  $exploded_question = explode(PHP_EOL,$practise['question']);
  $json_encoded_question = json_encode($exploded_question, true);
  $count = 0;
?>
@if(!empty($exploded_question))
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

  <div class="multiple-choice mb-4" style="color:black;">
    
    @foreach($exploded_question as $key => $value)
      

            <?php
            if(!empty($answer)){
                $exp_answer = array_filter(explode(';',$answer));
              //  pr($exp_answer);
            }
            if(str_contains($value,'@@')){

               echo $outValue = preg_replace_callback('/@@/',function ($m) use (&$key, &$count, &$exp_answer) {
                    $ans= !empty($exp_answer[$count])?trim($exp_answer[$count]):"";
                    $count++;
                    $str = '<span style="padding-bottom: 0px !important; line-height: 19px !important;" class="textarea d-inline-flex mw-20 form-control form-control-textarea conversation_answer_'.$count.'" role="textbox" contenteditable placeholder="Write here...">'.$ans.'</span><input type="hidden" name="text_ans[]" value="'.$ans.'">';
                    return $str;
                    }, $value);
            }else{
                echo "<div style='margin-top:15px;'>".$value."</div>";
            }
            
            if( $key%2==0 ){
                $class="mr-auto mb-4";
            } else {
                $class="convrersation-box__dark ml-auto mb-4";
            }

            ?>
      
    @endforeach
  </div>

@endif
<input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="audio_reading" value="0">
@include('practice.common.audio_record_div',['key'=>0])

</form>

<script>
function setInputContent(){
  $('.form_{{$practise["id"]}}').find("span.textarea.form-control").each(function(i){
    var currentVal = $(this).html();
    if($.trim(currentVal)!=""){
      $(this).next().val(currentVal);
    }
  });
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
var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
$(document).on('click','.delete-icon', function() {
  $(this).parent().find('.stop-button').hide();
  $(this).parent().find('.practice_audio').attr('src','');
  $(this).parent().find('.audioplayer-bar-played').css('width','0%');
  $(this).hide();
  $(this).parent().find('div.audio-element').css('pointer-events','none');
  $(this).parent().find('.record-icon').show();
  $(this).parent().find('.stop-button').hide();
  var practise_id = $('.practise_id:hidden').val();
  $.ajax({
      url: '<?php echo URL('delete-audio'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: {practice_id:practise_id},
      success: function (data) {

      }
  });
});
</script>
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
