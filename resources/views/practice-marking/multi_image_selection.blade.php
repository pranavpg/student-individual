<p>
	<strong><?php 	echo $practise['title']; ?></strong>
</p>
<?php
  //pr($practise);
  $answerExists = false;
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
    $answers = $practise['user_answer'][0];
  }

?>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
	<input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

  <div class="multiple-choice  mb-4">
      <div class="true-false_buttons-aes d-flex flex-wrap w-75 ml-auto mr-auto">
        @foreach($practise['question'] as $k => $v)
          <div class="form-check w-50 mb-4">
              <input class="form-check-input" type="radio" name="text_radio[0][checked]" id="inlineRadioTrue_{{$k}}" value="{{$k}}" {{ ($answerExists && $answers[$k]['checked'] ==1)?"checked":""}} >
              <label class="form-check-label form-check-label_center" for="inlineRadioTrue_{{$k}}">
                  <img src="{{$v}}" alt="" class="img-fluid img-checkbox">
              </label>
              <input type="hidden" name="text_ans[0][{{$k}}][image]" value="{{$v}}">
          </div>

        @endforeach
      </div>
  </div>
    </ul>
  </form>
