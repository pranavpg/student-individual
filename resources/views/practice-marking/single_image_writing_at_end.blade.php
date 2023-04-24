<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
    $answerExists = false;
    if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
      $answerExists = true;
    }
  ?>
  @if(isset($practise['is_roleplay']) && !empty($practise['is_roleplay']) && $practise['type'] == 'single_image_writing_at_end')
    @include('practice.single_image_writing_at_end_roleplay')
  @else
  <form class="form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
      <div class="draw-image draw-image__small mb-5 text-center">
        <img style="padding:15px" width="600px" src="{{$practise['question'][0]}}" />
      </div>
      @if(!empty($practise['question_2']))
        @foreach($practise['question_2'] as $key => $value)
        <div class="box__left box__left_radio">
              @if(str_contains($value, '@@') == false)
                <p> <?php echo $value ;?> </p>
                <input type="hidden" name="user_answer[{{$key}}]" value="">
              @else
                <p style="margin-bottom: 0.45rem !important;"> <?php echo str_replace("@@","",$value) ;?> </p>
              @endif          
        </div>
          @if(str_contains($value, '@@') != false)       
                  <div class="form-group">
                    <span class="textarea form-control form-control-textarea stringProper enter_disable" role="textbox" contenteditable placeholder="Write here..."><?php if ($answerExists) { echo  rtrim($practise['user_answer'][0][$key]); } ?></span>
                    <div style="display:none">
                        <textarea name="user_answer[{{$key}}]">
                        <?php
                            if ($answerExists)
                            {
                              echo  $practise['user_answer'][0][$key];
                            }
                        ?></textarea>
                    </div>
                  </div>
          @endif       
        @endforeach
      @endif
  </form>
@endif
