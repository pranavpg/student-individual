<p><strong>{!! $practise['title'] !!}</strong></p>

<?php
  $answerExists = false;
  if(!empty($practise['user_answer'])){
      $answerExists = true;
      $answer = $practise['user_answer'];
  }else if(!empty($practise['question_2'])){
      $preanswer = $practise['question_2'];
  }
?>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  <div class="conversation d-flex flex-column">
    @if(!empty($practise['question']))
       @foreach( $practise['question'] as $key => $value )
        <?php
          $count = 0;
          $k=$key;
            if(!empty($answer[$key])){
              $exp_answer =  array_filter(explode(';',$answer[$key]));
            }
            if(!empty($preanswer[$key])){
              $exp_answer = array_filter(explode('@@',$preanswer[$key]));
            }
            if(str_contains($value,'@@')){
              $outValue = preg_replace_callback('/@@/',
                  function ($m) use (&$key, &$count, &$exp_answer) {
                    $ans= !empty($exp_answer[$count])?trim(str_replace('_','',$exp_answer[$count])):"";
                    $count++;
                    $str = '<span class="textarea d-inline-flex mw-20 form-control form-control-textarea conversation_answer_'.$count.'" role="textbox" contenteditable disabled placeholder="Write here...">'.$ans.'</span><input type="hidden" name="text_ans['.$key.']['.$count.']" value="'.$ans.'">';
                    return $str;
                  }
                  , $value);
            } else {
              $outValue = $value.'<input type="hidden" name="text_ans['.$key.'][0]" value="">';
            }
          if( $key%2==0 ){
            $class="mr-auto mb-4";
          } else {
            $class="convrersation-box__dark ml-auto mb-4";
          }
        ?>
        <div class="convrersation-box {{$class}}">
            <p> {!! $outValue !!}</p>
        </div>
      @endforeach
    @endif
  </div>
  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
</form>
<script>
  function setInputContent(){
    $('.form_{{$practise["id"]}}').find("span.textarea.form-control").each(function(i){
      var currentVal = $(this).html();
      //console.log(i,'====>,',currentVal)
      if($.trim(currentVal)!=""){

        $(this).next().val('_'+currentVal+'_');
      } else {
        $(this).next().val(currentVal);
      }
    });
  }
</script>
