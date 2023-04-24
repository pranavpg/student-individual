<p><strong>{!! $practise['title'] !!} Test Amit</strong></p>
<?php
    $answerExists = false; $answer = array();
    if(isset($practise['user_answer']) && !empty($practise['user_answer'][0]['text_ans'])){
      $answerExists = true;
      $answers = $practise['user_answer'][0]['text_ans'];
    }
    $exploded_question = explode(PHP_EOL,$practise['question']);

  ?>
<form class="writing_at_end_speakingform_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="user_audio[0][audio_deleted]" value="0">
    <input type="hidden" name="user_audio[0][path]" class="audio_path0">
    @include('practice.common.audio_record_div',['key'=>0])
        <ul class="list-unstyled">
            @foreach($exploded_question as $key=>$item)
               <li>
                   @php $item = str_replace('@@', '', $item); @endphp
                   {{ $item }}
                <span class="textarea form-control form-control-textarea" role="textbox" disabled contenteditable placeholder="Write here...">
                    <?php
                      if($answerExists == true && array_key_exists($key, $practise['user_answer'][0]['text_ans']))
                      {
                          echo $practise['user_answer'][0]['text_ans'][$key];
                      }
                    ?>
                </span>
                <div style="display:none">
                    <textarea name="text_ans[{{$key}}]">
                      <?php
                          if($answerExists == true && array_key_exists($key, $practise['user_answer'][0]['text_ans'])) {
                            echo $practise['user_answer'][0]['text_ans'][$key];
                          }
                      ?>
                    </textarea>
                </div>
               </li>
            @endforeach
        </ul>
  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
</form>
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
<script>
  var practice_type="{{$practise['type']}}";
  var token = $('meta[name=csrf-token]').attr('content');
  var upload_url = "{{url('upload-audio')}}";
  var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
</script>
