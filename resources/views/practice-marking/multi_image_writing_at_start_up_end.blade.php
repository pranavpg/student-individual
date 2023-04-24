<p><strong>{{$practise['title']}}</strong></p>
<style>
  .course-book .form-group-label .label{
    min-width: 33px !important;
  }
</style>
<?php
  $answerExists = false;
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
    $answers = $practise['user_answer'][0];
  }
  if($practise['question_2']){
    $img_count = count($practise['question_2']);
    $q2=array();
    $i=0;
    foreach ($practise['question_2'] as $key => $value) {
      if($value=='@#'){
        $i++;
      }
      if($value!='@#'){
        $q2[$i][$key] = $value;
      }
    }
  }
?>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
	<input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  @if( !empty($practise['question']) )
    <?php $i = 0; $c_t = 0; ?>
    @foreach($practise['question'] as $key => $value)
      <div class="row multi__image mb-3 flex-wrap align-items-center multiple-choice">
          <div class="col-6 multi-description">
            @foreach($q2[$key] as $text_key => $text_ans)
                <?php $text_key = $i +1; $flag = true; ?>
                <?php 
                        if(str_contains($text_ans,'@@')) {
                                 $c_t++;
                            echo $outValue = preg_replace_callback('/@@/',
                                    function ($m) use (&$key1, &$c_t, &$data, &$value, &$text_ans, &$practise, &$flag, &$i) {
                                    $ans  = "";
                                    $startEnd = "";
                                    $ans = "";
                                    if($flag){
                                        $ans = !empty($practise['user_answer'][0][$i]['start'])?str_replace(" ","&nbsp", $practise['user_answer'][0][$i]['start']):"";
                                        $startEnd = "start";
                                        $str =$c_t.".&nbsp;&nbsp;&nbsp;  "."<div class='form-group d-flex align-items-start form-group-label'  style='width: 50%;display: inline-grid !important;'>";
                                    }else{
                                        $ans = !empty($practise['user_answer'][0][$i]['end'])?str_replace(" ","&nbsp", $practise['user_answer'][0][$i]['end']):"";
                                        $startEnd = "end";
                                        $str ="<div class='form-group d-flex align-items-start form-group-label' style='width: 50%;display: inline-grid !important;margin-left: 23px;'>";
                                    }                            
                                    $str .= '<span class="textarea form-control form-control-textarea main-answer enter_disable" role="textbox" disabled contenteditable placeholder="Write here...">'.$ans.'</span>';
                                    $str .= '  <div style="display:none"><textarea name="user_answer[0]['.$i.']['.$startEnd.']" class="main-answer-input">'.$ans.'</textarea></div>';
                                    if($flag){
                                       $str .="</div>";
                                        $flag = false;
                                    }else{

                                        $str .="</div><br>";
                                    }  
                                    return $str;
                                    }, $text_ans);
                        }else{
                              echo $outValue = $value;
                        }
                ?>
              <?php $i++; ?>
            @endforeach
          </div>
          <div class="col-6 image text-center">
            <img src="{{$value}}" alt="" class="img-fluid">
          </div>
      </div>
    @endforeach
  @endif
  </form>

