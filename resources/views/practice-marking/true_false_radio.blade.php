<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
    $answerExists = false;
    $answers=array();
    if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
      $answerExists = true;
      $answers = $practise['user_answer'][0];
    }
    $exploded_question = explode(PHP_EOL,$practise['question']);
  ?>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  @if($practise['type']=="true_false_radio_listening")
    @include('practice.common.audio_player')
  @endif
  <div class="true-flase-radio multiple-choice">
      @if(!empty($exploded_question))
        @foreach($exploded_question as $key => $value)
          <div class="box">
            <?php
            $explode_option = explode('@@', $value);
            
            ?>
            @if(!empty($explode_option))
              @foreach($explode_option as $k => $v)
                <div class="box-flex d-flex align-items-center">
                  @if($k==0)
                    <input type="hidden" name="text_ans[{{$key}}][question]" value="{{$value}}">
                  @endif
                  <div class="box__left box__left_radio">
                      <p style="white-space: pre;">{{$v}}</p>
                  </div>
                  <div class="true-false_buttons true-false_buttons_radio">
                      <div class="form-check form-check-inline">

                          <input class="form-check-input true_option" type="radio"
      	                      name="text_ans[{{$key}}][selection]"
                              id="inlineRadioTrue_{{$key}}_{{$k}}"
                              value="{{$k}}" {{ ($answerExists && $answers[$key]['selection'] ==$k)?"checked":""}} >
      	                  <label class="form-check-label form-check-label_true" for="inlineRadioTrue_{{$key}}_{{$k}}"></label>
                      </div>
                  </div>
              </div>
              @endforeach
            @endif
          </div>
        @endforeach
      @endif
  </div>
</form>
