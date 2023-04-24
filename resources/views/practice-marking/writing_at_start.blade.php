<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
  $user_ans="";
  $answerExists = false;
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
  }
  $exploded_question = explode(PHP_EOL,$practise['question']);
  $style="";
?>
<?php 
if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) && empty($practise['dependingpractise_answer'][0]) ){
      $depend =explode("_",$practise['dependingpractiseid']);
?>
    <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
      <p style="margin: 15px;">In order to do this task you need to have completed
      <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
    </div>
<?php
} 
else 
{
?>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  @if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1)
   <div class="multiple-choice mb-4">
     @if(isset($practise['dependingpractise_answer'][0]) && !empty($practise['dependingpractise_answer'][0]))
       @php $i = 0; @endphp
       @foreach($practise['dependingpractise_answer'][0] as $key => $value)
          @php $trim_val = trim($value); @endphp
          @if($trim_val != "")
            <div class="form-group d-flex align-items-start form-group-label mb-2">
              <span class="label">{{$i+1}}.</span>
              <span class="textarea form-control form-control-textarea main-answer stringProper text-left enter_disable" role="textbox" contenteditable placeholder="Write here..."><?php if ($answerExists){echo  !empty($practise['user_answer'][0][$i])?nl2br($practise['user_answer'][0][$i]):""; }?></span>
                <div style="display:none">
                <textarea name="user_answer[{{$key}}]" class="main-answer-input">
                  <?php
                      if($answerExists)
                      {
                        echo  !empty($practise['user_answer'][0][$i])?$practise['user_answer'][0][$i]:"";
                      }
                  ?>
                </textarea>
                </div>
            </div>
             <p style="margin-left: 63px;"><b>{{$key+1}}.</b>{!! nl2br(str_replace('@@', '', $value)) !!} </p>
            @php $i++; @endphp
          @endif   
       @endforeach
     @else
        <p><b>Please Submit any answer of practice A</b></p>
     @endif
   </div>
  @else
  <div class="multiple-choice mb-4">
    @if(!empty($exploded_question))
       @php
         $i = 0;
        @endphp
        @foreach( $exploded_question as $key => $value )
          @if(!empty($value))
              <div class="form-group d-flex align-items-start form-group-label mb-2">
                  <span class="label"> </span>
                @if(str_contains($value,'@@'))
                {{$key+1}}&nbsp;
                  <span class="textarea form-control form-control-textarea main-answer stringProper text-left enter_disable" role="textbox" contenteditable placeholder="Write here..."><?php if ($answerExists){echo  !empty($practise['user_answer'][0][$key])?nl2br($practise['user_answer'][0][$key]):""; }?></span>
                  <div style="display:none">
                    
                    <textarea name="user_answer[0][{{$key}}]" class="main-answer-input">
                    <?php
                        if ($answerExists)
                        {
                          echo  !empty($practise['user_answer'][0][$key])?$practise['user_answer'][0][$key]:"";
                        }
                    ?>
                    </textarea>
                  </div>
                  @php
                   $i++;
                  @endphp
                 @else
                    <input type="hidden" name="user_answer[0][{{$key}}]"value="vfdb">
                 @endif
              </div>
            <p style="margin-left: 63px;">{{!str_contains($value,'@@')?$key+1:''}} {!! nl2br(str_replace('@@', '', $value)) !!} </p>
          @endif
        @endforeach
    @endif
  </div>
  @endif
</form>
<?php
}
?>
