<?php
$user_ans = "";
  $answerExists = false;
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
  }
?>

<?php
$style="";
// echo "<pre>";
// dd($practise);
// echo "</pre>";
if(isset($practise['dependingpractiseid'])){
            if($practise['typeofdependingpractice'] == "reading_total_blanks_generate_questions_numbers_before" ){
                $data = explode("@@", $practise['question']);
                $newArray = [];
                foreach($data as $key=>$new){
                    $newArray[$key][] = $new;
                }
                $practise['options'] = $newArray;
            }elseif($practise['typeofdependingpractice'] == "get_answers_put_into_quetions" ){

            }
        }
    if(isset($practise['id']))
    {
       if($practise['id'] == "166514370163401395d5470")
       {
         $data[$practise['id']] = array();
         $data[$practise['id']]['isRolePlayPractice'] = (!empty($practise['is_roleplay']) &&  $practise['is_roleplay']==1)?1:0;
         $data[$practise['id']]['typeofdependingpractice'] = !empty($practise['typeofdependingpractice']) ? $practise['typeofdependingpractice'] : "";
         $data[$practise['id']]['setFullViewFromPreviousPractice'] = !empty($practise['depending_practise_details']['dependant_practise_id']) ? $practise['depending_practise_details']['dependant_practise_id']:"";
         $data[$practise['id']]['dependant_practise_topic_id'] = !empty($practise['depending_practise_details']['dependant_practise_topic_id']) ? $practise['depending_practise_details']['dependant_practise_topic_id']:"";
         $data[$practise['id']]['dependant_practise_task_id'] = !empty($practise['depending_practise_details']['dependant_practise_task_id']) ? $practise['depending_practise_details']['dependant_practise_task_id']:"";
         $data[$practise['id']]['dependant_practise_question_type'] = !empty($practise['depending_practise_details']['question_type']) ? $practise['depending_practise_details']['question_type']:"";
         $data[$practise['id']]['dependentpractice_ans'] = !empty($practise['dependingpractise_answer'])?1:0;
         $data[$practise['id']]['is_dependent'] = !empty($practise['is_dependent']) ? 1 : 0;
       }
    }
if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) ){
  $depend =explode("_",$practise['dependingpractiseid']);
  $style= "display:none";

  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
    if(!empty($practise['user_answer'][0])){
      $user_ans = $practise['user_answer'][0];
    }
  }
?>
    <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; display:none">
         <p style="margin: 15px;">In order to do this task you need to have completed
            <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
   </div>
<?php
  } else {

    $exploded_question = explode(PHP_EOL,$practise['question']);
  }
?>

<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
<div class="previous_practice_answer_exists_{{$practise['id']}}" >
@if(isset($practise['id']))
 @if($practise['id'] == "166514370163401395d5470")
   <div class="showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}} mb-4"></div>
 @endif
@endif
@if($practise['type']=='writing_at_end_listening')
  @include('practice.common.audio_player')
@endif


<form class="form_{{$practise['id']}} commonFontSize">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  <?php
    if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
      $depend =explode("_",$practise['dependingpractiseid']);
  ?>
      <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
      <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
  <?php } ?>
  @if(!empty($practise['options']))
    <div class="suggestion-list d-flex flex-wrap w-50 mr-auto ml-auto mb-4 justify-content-center">
        @foreach($practise['options'] as $key => $value)
          <div class="d-inline-flex flex-grow-1 suggestion_box justify-content-center">
            {!! $value[0] !!}
          </div>
        @endforeach
    </div>
  @endif

  <!-- <div class="multiple-choice">  remove for counter edit by arshit date 09/12/20-->

  <div class="writing_at_end">


    <?php
       // dd($practise);
    if($practise['typeofdependingpractice'] == "get_answers_put_into_quetions_numbers"){
            echo '<input type="hidden" name="get_answers_put_into_quetions_numbers" value="get_answers_put_into_quetions_numbers">';
            $question = explode(PHP_EOL,$practise['depending_practise_details']['question']);

                if($practise['depending_practise_details']['question_type'] == "writing_at_end"){
                    if(!empty($practise['dependingpractise_answer'])){
                        $question = explode(PHP_EOL,$practise['question']);

                        if(isset($practise['dependingpractise_answer'][0]) && is_array($practise['dependingpractise_answer'][0])){
                            $ans = $practise['dependingpractise_answer'][0];
                        }else{
                            $ans = !empty($practise['dependingpractise_answer'])?explode(";",$practise['dependingpractise_answer'][0]):[];
                        }
                        $user_answer = isset($practise['user_answer'])?$practise['user_answer'][0]:[];

                        $k=0;
                        $s=0;
                        $temp=0;
                        $tmprory=0;
                        // dd($question);
                        foreach($question as $key => $value) {


                            if(str_contains($value,'@@')) {

                                $newTempAns = "";
                                if (strpos($value, '.') !== false) {
                                    $new = explode(".", $value);
                                    $newTempAns = $new[1];
                                }elseif(strpos($value, ')') !== false) {
                                    $new = explode(")", $value);
                                    $newTempAns = $new[1];
                                }
                                else{
                                    $newTempAns = $value;
                                }
                                // dd($newTempAns);
                                $s++;
                                echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$newTempAns, &$k, &$ans, &$s, &$key, &$user_answer, &$temp, &$tmprory) {
                                    $str = "";
                                    $ansd = "";
                                    if(isset($ans[$k])){
                                        $ansd = $ans[$k];
                                    }
                                    $answers = "";

                                    if(isset($user_answer[$temp])){
                                        $answers = $user_answer[$temp];
                                    }
                                    if($ansd != ""){
                                         $temp++;

                                        $str   .= '<div class="choice-box">
                                                '.$s.'. '.$ansd.'<div class="form-group"><span class="textarea form-control form-control-textarea main-answer enter_disable another-main-answer stringProper text-left" role="textbox" contenteditable placeholder="Write here...">'.$answers.'</span>
                                                    <div style="display:none">
                                                        <textarea name="user_answer[0]['.$tmprory.']" class="main-answer-input">'.$answers.'</textarea>
                                                    </div>
                                                </div>
                                            </div>';
                                            $tmprory++;
                                    }
                                    return $str;
                                }, $newTempAns);

                            }
                            $k++;
                        }
                    }else{
                         ?>
                                <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
                                    <p style="margin: 15px;">In order to do this task you need to have completed
                                    <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                               </div>
                               <br>
                               <script type="text/javascript">
                                   setTimeout(function(){
                                        $('.dependancybutton').fadeOut();
                                   },1000)
                               </script>
                            <?php
                    }
                }elseif($practise['depending_practise_details']['question_type'] == "writing_at_end_up"){

                    if(!empty($practise['dependingpractise_answer'])){


                        $question = explode(PHP_EOL,$practise['question']);

                        if(isset($practise['dependingpractise_answer'][0]) && is_array($practise['dependingpractise_answer'][0])){
                            $ans = $practise['dependingpractise_answer'][0];
                        }else{
                            $ans = !empty($practise['dependingpractise_answer'])?explode(";",$practise['dependingpractise_answer'][0]):[];
                        }
                        $user_answer = isset($practise['user_answer'])?$practise['user_answer'][0]:[];

                        $k=0;
                        $s=0;
                        $temp=0;
                        $tmprory=0;
                        // dd($question);
                        foreach($question as $key => $value) {


                            if(str_contains($value,'@@')) {

                                $newTempAns = "";
                                if (strpos($value, ')') !== false) {
                                    $new = explode(")", $value);
                                    $newTempAns = $new[1];
                                }else{
                                    $newTempAns = $value;
                                }

                                $s++;
                                echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$newTempAns, &$k, &$ans, &$s, &$key, &$user_answer, &$temp, &$tmprory) {
                                    $str = "";
                                    $ansd = "";
                                    if(isset($ans[$k])){
                                        $ansd = $ans[$k];
                                    }
                                    $answers = "";

                                    if(isset($user_answer[$temp])){
                                        $answers = $user_answer[$temp];
                                    }
                                    if($ansd != ""){
                                          $temp++;
                                          $str   .= '<div class="choice-box">
                                                '.$s.'. '.$ansd.'<div class="form-group"><span class="textarea form-control form-control-textarea main-answer enter_disable another-main-answer stringProper text-left" role="textbox" contenteditable placeholder="Write here...">'.$answers.'</span>
                                                    <div style="display:none">
                                                        <textarea name="user_answer[0]['.$tmprory.']" class="main-answer-input">'.$answers.'</textarea>
                                                    </div>
                                                </div>
                                            </div>';
                                            $tmprory++;
                                    }else{
                                        // $str   .= '<div style="display:none"><textarea name="user_answer[0]['.$tmprory.']" class="main-answer-input">'.$answers.'</textarea></div>';
                                    }
                                    return $str;
                                }, $newTempAns);

                            }
                            $k++;
                        }
                    }else{
                         ?>
                                <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
                                    <p style="margin: 15px;">In order to do this task you need to have completed
                                    <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                               </div>
                               <br>
                               <script type="text/javascript">
                                   setTimeout(function(){
                                        $('.dependancybutton').fadeOut();
                                   },1000)
                               </script>
                            <?php
                    }
                }elseif($practise['depending_practise_details']['question_type'] == "reading_no_blanks"){
            // dd($practise);
                    if(!empty($practise['dependingpractise_answer'])) {
                        $question = explode(PHP_EOL,$practise['depending_practise_details']['question']);
                        if(isset($practise['dependingpractise_answer'][0]) && is_array($practise['dependingpractise_answer'][0])){
                            $ans = $practise['dependingpractise_answer'][0];
                        }else{
                            $ans = !empty($practise['dependingpractise_answer'])?explode(";",$practise['dependingpractise_answer'][0]):[];
                        }
                        $user_answer = isset($practise['user_answer'])?$practise['user_answer'][0]:[];
                        // dd($user_answer);

                        $k=0;
                        $s=0;
                        $temp=0;

                        $y = 0;

                        $newAns = [];
                        foreach($ans as $newdata){
                            if($newdata == " " || $newdata == ""){
                                array_push($newAns,"test");
                            }else{
                                array_push($newAns,$newdata);
                            }
                        }

                         $quetemp = [];
                        $tmp = 0;
                        foreach($question as $key => $value) {

                                if(str_contains($value,'@@')) {

                                     $s++;
                                    $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$value, &$k, &$ans, &$s, &$key, &$user_answer, &$temp, &$y, &$tmp, &$newAns) {
                                        $str = "";
                                        $ansd = "&^";
                                        if($newAns[$tmp]!="test"){
                                            $ansd = $ans[$tmp];
                                        }
                                        $str   .=$ansd;

                                        $tmp++;
                                        return $str;
                                    }, $value);
                                    array_push($quetemp,$outValue);
                                }
                        }
                        $cehckItem = 0;
                        foreach($quetemp as $key => $value) {

                            if(!str_contains($value,'&^')) {
                                $answers = "";
                                if(isset($user_answer[$temp])){
                                    $answers = $user_answer[$temp];
                                }
                                ?>
                                {{$value}}
                                    <div class="choice-box">
                                        <div class="form-group"><span class="textarea form-control form-control-textarea main-answer enter_disable another-main-answer stringProper text-left" role="textbox" contenteditable placeholder="Write here...">{{$answers}}</span>
                                            <div style="display:none">
                                                <textarea name="user_answer[0][{{$temp}}]" class="main-answer-input"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                $temp++;
                                $k++;
                            } else {
                                $cehckItem++;
                                ?> <input type="hidden" name="user_answer[0][{{$temp}}]" class="main-answer-input"><?php
                            }
                        }
                        if(count($quetemp)  == $cehckItem){
                            ?>
                                <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
                                    <p style="margin: 15px;">In order to do this task you need to have completed
                                    <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                                </div>
                                <br>
                                <script type="text/javascript">
                                    setTimeout(function(){
                                        $('.dependancybutton').fadeOut();
                                    },1000)
                                </script>
                            <?php
                        }
                    } else {

                            ?>
                                <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
                                    <p style="margin: 15px;">In order to do this task you need to have completed
                                    <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                                </div>
                                <br>
                                <script type="text/javascript">
                                    setTimeout(function(){
                                        $('.dependancybutton').fadeOut();
                                    },1000)
                                </script>
                            <?php
                    }
                }elseif($practise['depending_practise_details']['question_type'] == "reading_blanks"){

                    if(!empty($practise['dependingpractise_answer'])){
                        if(isset($practise['dependingpractise_answer'][0]) && is_array($practise['dependingpractise_answer'][0])){
                            $ans = $practise['dependingpractise_answer'][0];
                        }else{
                            $ans = !empty($practise['dependingpractise_answer'])?explode(";",$practise['dependingpractise_answer'][0]):[];
                        }
                        $user_answer    = isset($practise['user_answer'])?$practise['user_answer'][0]:[];
                        $question       = explode(PHP_EOL,$practise['depending_practise_details']['question']);

                        $tempAns = [];
                        foreach ($question as $key => $value) {
                            if($value != "\r"){
                                array_push($tempAns, $value);
                            }
                        }
                        $question = $tempAns;

                        $k=0;
                        $w=0;
                        foreach($question as $key => $value) {
                            if($value=="") continue;
                            $checkbl = isset($ans[$k]['ans'])?$ans[$k]['ans']:"";
                            if($checkbl=="") continue;

                            if(str_contains($value,'@@')) {

                                echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$value, &$k, &$ans) {
                                        $str = "";
                                        $str   .= isset($ans[$k]['ans'])?$ans[$k]['ans']:"";

                                    $k++;
                                    return $str;
                                }, $value);
                            }
                            ?>
                                <div class="choice-box">
                                    <div class="form-group"><span class="textarea form-control form-control-textarea main-answer enter_disable another-main-answer stringProper text-left" role="textbox" contenteditable placeholder="Write here...">{{isset($user_answer[$w])?$user_answer[$w]:''}}</span>
                                        <div style="display:none">
                                            <textarea name="user_answer[0][{{$w}}]" class="main-answer-input">{{isset($user_answer[$w])?$user_answer[$w]:''}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            $w++;
                        }
                    } else{

                            ?>
                                <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
                                    <p style="margin: 15px;">In order to do this task you need to have completed
                                    <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                               </div>
                               <br>
                               <script type="text/javascript">
                                   setTimeout(function(){
                                        $('.dependancybutton').fadeOut();
                                   },1000)
                               </script>
                            <?php
                    }
                }elseif($practise['depending_practise_details']['question_type'] == "reading_total_blanks"){

                    if(!empty($practise['dependingpractise_answer'])){


                        if(isset($practise['dependingpractise_answer'][0]) && is_array($practise['dependingpractise_answer'][0])){
                            $ans = $practise['dependingpractise_answer'][0];
                        }else{
                            $ans = !empty($practise['dependingpractise_answer'])?explode(";",$practise['dependingpractise_answer'][0]):[];
                        }
                        $user_answer = isset($practise['user_answer'])?$practise['user_answer'][0]:[];
                        $k=0;

                        $newAns = [];
                        foreach($ans as $newdata){
                            if($newdata == " " || $newdata == ""){
                                array_push($newAns,"");
                            }else{
                                array_push($newAns,$newdata);
                            }
                        }

                        foreach($question as $key => $value) {
                            if($newAns[$k]!=""){

                                if(str_contains($value,'@@')) {

                                    echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$value, &$k, &$newAns) {
                                            $str = "";
                                            $str   .= isset($newAns[$k])?$newAns[$k]:"";

                                            echo "<br>";

                                        return $str;
                                    }, $value);
                                }
                                ?>
                                    <div class="choice-box">
                                        <div class="form-group"><span class="textarea form-control form-control-textarea main-answer enter_disable another-main-answer stringProper text-left" role="textbox" contenteditable placeholder="Write here...">{{isset($user_answer[$key])?$user_answer[$key]:''}}</span>
                                            <div style="display:none">
                                                <textarea name="user_answer[0][{{$key}}]" class="main-answer-input">{{isset($user_answer[$key])?$user_answer[$key]:''}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                <?php

                            }else{

                                ?><input type="hidden" name="user_answer[0][{{$key}}]" class="main-answer-input"><?php
                            } $k++;

                        }
                    } else{

                            ?>
                                <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
                                    <p style="margin: 15px;">In order to do this task you need to have completed
                                    <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                               </div>
                               <br>
                               <script type="text/javascript">
                                   setTimeout(function(){
                                        $('.dependancybutton').fadeOut();
                                   },1000)
                               </script>
                            <?php
                    }
                }elseif($practise['depending_practise_details']['question_type'] == "reading_total_blanks_edit"){

                    if(!empty($practise['dependingpractise_answer'])){
                        if(isset($practise['dependingpractise_answer'][0]) && is_array($practise['dependingpractise_answer'][0])){
                            $ans = $practise['dependingpractise_answer'][0];
                        }else{
                            $ans = !empty($practise['dependingpractise_answer'])?explode(";",$practise['dependingpractise_answer'][0]):[];
                        }
                        $user_answer    = isset($practise['user_answer'])?$practise['user_answer'][0]:[];
                        $question       = explode(PHP_EOL,$practise['depending_practise_details']['question']);


                        $temparray = [];
                        if(!empty($question)){
                              foreach ($question as $key => $value) {
                                if($value != "" && $value != "\r" ){
                                    array_push($temparray, $value);
                                }
                            }
                        }
                        $question = $temparray;



                        $tempAns = [];
                        foreach ($ans as $key => $value) {

                            if($value != " " && $value != "" ){
                                    array_push($tempAns, $value);
                            }
                        }
                        // dd($tempAns);


                        $k=0;
                        $w=0;
                        // foreach($question as $key => $value) {
                        foreach($tempAns as $key => $value) {
                            if($value=="") continue;
                            if(str_contains($question[$key],'@@')) {

                                echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$question, &$k, &$ans) {
                                        $str = "";
                                        $str   .= isset($ans[$k])?$ans[$k]:"";

                                        echo "<br>";
                                    $k++;
                                    return $str;
                                }, $question[$key]);
                            }
                            ?>
                                <div class="choice-box">
                                    <div class="form-group"><span class="textarea form-control form-control-textarea main-answer enter_disable another-main-answer stringProper text-left" role="textbox" contenteditable placeholder="Write here...">{{isset($user_answer[$w])?$user_answer[$w]:''}}</span>
                                        <div style="display:none">
                                            <textarea name="user_answer[0][{{$w}}]" class="main-answer-input">{{isset($user_answer[$w])?$user_answer[$w]:''}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            $w++;
                        }
                    }else{
                         ?>
                                <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
                                    <p style="margin: 15px;">In order to do this task you need to have completed
                                    <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                               </div>
                               <br>
                               <script type="text/javascript">
                                   setTimeout(function(){
                                        $('.dependancybutton').fadeOut();
                                   },1000)
                               </script>
                            <?php
                    }
                }else{

                    if(isset($practise['dependingpractise_answer'][0]) && is_array($practise['dependingpractise_answer'][0])){
                        $ans = $practise['dependingpractise_answer'][0];
                    }else{
                        $ans = !empty($practise['dependingpractise_answer'])?explode(";",$practise['dependingpractise_answer'][0]):[];
                    }
                    $user_answer = isset($practise['user_answer'])?$practise['user_answer'][0]:[];
                    $k=0;
                    foreach($question as $key => $value) {
                        if(str_contains($value,'@@')) {

                            echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$value, &$k, &$ans) {
                                    $str = "";
                                    $str   .= isset($ans[$k])?$ans[$k]:"";

                                    echo "<br>";
                                $k++;
                                return $str;
                            }, $value);
                        }
                        ?>
                            <div class="choice-box">
                                <div class="form-group"><span class="textarea form-control form-control-textarea main-answer enter_disable another-main-answer stringProper text-left" role="textbox" contenteditable placeholder="Write here...">{{isset($user_answer[$key])?$user_answer[$key]:''}}</span>
                                    <div style="display:none">
                                        <textarea name="user_answer[0][{{$key}}]" class="main-answer-input">{{isset($user_answer[$key])?$user_answer[$key]:''}}</textarea>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }
                }
    }elseif($practise['typeofdependingpractice'] == "set_full_view_remove_top_zero"){

        echo '<input type="hidden" name="set_full_view_remove_top_zero" value="set_full_view_remove_top_zero">';
        if(!empty($practise['dependingpractise_answer'])) {
            $question = explode(PHP_EOL,$practise['depending_practise_details']['question']);
            $question = array_filter($question);
            $question = array_merge($question);
            $ans = !empty($practise['dependingpractise_answer'])?explode(";",$practise['dependingpractise_answer'][0]):[];
            $k=0;
            foreach($question as $key => $value) {
                if(str_contains($value,'@@')) {
                    echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$value, &$k, &$ans) {
                            $str = "";
                            if(empty($ans)){
                                $str.= '<span class="resizing-input1">
                                          <span readonly disabled contenteditable="false" class="enter_disable spandata fillblanks stringProper text-left disable_writing"></span>
                                          <input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="">
                                        </span>';
                            }else{
                                $apval = "";
                                if(isset($ans[$k])){
                                    $apval = $ans[$k];
                                }
                                $str.= '<span class="resizing-input1">
                                          <span readonly disabled contenteditable="false" class="enter_disable spandata fillblanks stringProper text-left disable_writing">'.$apval.'</span>
                                          <input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="'.$apval.'">
                                        </span>';
                            }
                            echo "<br>";
                        return $str;
                    }, $value);
                    $k++;
                }else{
                    echo $value;
                    echo "<br>";
                }
            }
                    echo "<br>";
                    echo "<br>";
                    echo "<br>";

            $question = explode(PHP_EOL,$practise['question']);
            $question = array_filter($question);
            $question = array_merge($question);

            $ans = [];
            if(!empty($practise['user_answer'][0])) {
                $ans = $practise['user_answer'][0];
            }


            foreach($question as $key => $value) {

                if(str_contains($value,'@@')) {
                    $k=0;
                    echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$value, &$k, &$ans, &$key) {
                            $str = "<br>";

                            $answeres = isset($ans[$key])?$ans[$key]:"";
                            $str   .= '<div class="choice-box j">
                                            <div class="form-group">
                                                <span class="textarea form-control form-control-textarea main-answer enter_disable another-main-answer stringProper text-left" role="textbox" contenteditable placeholder="Write here...">'.$answeres.'</span>
                                                <div style="display:none">
                                                    <textarea name="user_answer[0]['.$key.']" class="main-answer-input">'.$answeres.'</textarea>
                                                </div>
                                            </div>
                                        </div>';

                            // echo "<br>";
                        $k++;
                        return $str;
                    }, $value);
                }
            }
        }else{
                 $depend =explode("_",$practise['dependingpractiseid']);
                    ?>
                        <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
                            <p style="margin: 15px;">In order to do this task you need to have completed
                            <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                       </div>
                       <br>
                       <script type="text/javascript">
                           setTimeout(function(){
                                $('.dependancybutton').fadeOut();
                           },1000)
                       </script>
                    <?php
        }
    }elseif($practise['typeofdependingpractice'] == "set_full_view_parentextra"){
        // dd($practise);
        echo '<input type="hidden" name="typeofdependingpractice" value="typeofdependingpractice">';
        $question = explode(PHP_EOL,$practise['question']);
        $question = array_filter($question);
        $question = array_merge($question);

        $ans = [];
        if(!empty($practise['user_answer'][0])) {
            $ans = $practise['user_answer'][0];
        }


        foreach($question as $key => $value) {

            if(str_contains($value,'@@')) {
                $k=0;
                echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$value, &$k, &$ans, &$key) {
                        $str = "<br>";

                        $answeres = isset($ans[$key])?$ans[$key]:"";
                        $str   .= '<div class="choice-box j">
                                        <div class="form-group">
                                            <span class="textarea form-control form-control-textarea main-answer enter_disable another-main-answer stringProper text-left" role="textbox" contenteditable placeholder="Write here...">'.$answeres.'</span>
                                            <div style="display:none">
                                                <textarea name="user_answer[0]['.$key.']" class="main-answer-input">'.$answeres.'</textarea>
                                            </div>
                                        </div>
                                    </div>';

                        echo "<br>";
                    $k++;
                    return $str;
                }, $value);
            }
        }
    }elseif($practise['typeofdependingpractice'] == "get_answers_put_into_quetions_numbers_parentextra_withdep"){

        if(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer'])){
            // dd($practise);
            $dependAns = isset($practise['user_answer']) && !empty($practise['user_answer'][0])?$practise['user_answer'][0]:[];
            $prctice = array_filter($practise['dependingpractise_answer'][0]);
            $inc = 0;
            // dd($prctice);

            foreach($prctice as $key=>$ans){
                    if($ans=="")continue; ?>
                    <div class="choice-box">
                        <p class="mb-0">{{$inc+1}}. {!! $ans !!} </p>
                        <div class="form-group">
                              <span class="textarea form-control form-control-textarea main-answer enter_disable" role="textbox" contenteditable placeholder="Write here...">
                                 <?php
                                if ($answerExists)
                                {
                                    echo  !empty($dependAns[$inc])?$dependAns[$inc]:"";
                                }
                              ?>
                              </span>
                              <div style="display:none">
                                    <textarea name="user_answer[0][]" class="main-answer-input">
                                         <?php
                                  if ($answerExists)
                                  {
                                    echo  !empty($dependAns[$inc])?$dependAns[$inc]:"";

                                  }
                              ?>
                                    </textarea>
                              </div>
                        </div>
                    </div>
                <?php
                $inc++;
            }

        }else{
             ?>
                <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
                    <p style="margin: 15px;">In order to do this task you need to have completed
                    <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
               </div>
               <br>
               <script type="text/javascript">
                   setTimeout(function(){
                        $('.dependancybutton').fadeOut();
                   },1000)
               </script>
            <?php
        }
    }elseif($practise['typeofdependingpractice'] == "get_answers_put_into_questions_odd") {

        if(!empty($practise['dependingpractise_answer'])){
            echo '<input type="hidden" name="get_answers_put_into_questions_odd" value="get_answers_put_into_questions_odd">';
            $ans = [];
            $user_answer = [];
            if(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer']) ) {
                $ans = explode(";",$practise['dependingpractise_answer'][0]);
            }
            if(isset($practise['user_answer']) && !empty($practise['user_answer']) ) {
                $user_answer = $practise['user_answer'][0];
            }

            $question =  $practise['depending_practise_details']['question'];
            // dd($user_answer);
            $question2 =  $practise['depending_practise_details']['question_2'];
            $newdata = explode("#@", $question[0]);
            $question[0] = $newdata[1];
            $k=0;
            $j=1;
            $incdata = 0;

            $newAns = [];
            foreach($ans as $newdata){
                if($newdata == " " || $newdata == ""){
                    array_push($newAns,"test");
                }else{
                    array_push($newAns,$newdata);
                }
            }
                if(!empty($user_answer)) {

                    foreach($user_answer as $key => $value) { ?>
                            <span class="textarea form-control form-control-textarea main-answer enter_disable" role="textbox" contenteditable placeholder="Write here...">{{$value}}</span>
                            <div style="display:none">
                                    <textarea name="user_answer[0][]" class="main-answer-input">{{$value}}</textarea>
                            </div>
                            <br>
                   <?php }

                } else {

                    $index = 0;
                    foreach($newAns as $key => $value) { ?>
                        <?php
                        if($value!="test"){?>
                            <span class="textarea form-control form-control-textarea main-answer enter_disable" role="textbox" contenteditable placeholder="Write here...">{{$question[$key].''.$question2[$value]}}</span>
                            <div style="display:none">
                                    <textarea name="user_answer[0][]" class="main-answer-input">{{$question[$key].''.$question2[$value]}}</textarea>
                            </div>

                            <span class="textarea form-control form-control-textarea main-answer enter_disable" role="textbox" contenteditable placeholder="Write here..."></span>
                            <div style="display:none">
                                    <textarea name="user_answer[0][]" class="main-answer-input"></textarea>
                            </div>

                       <?php }
                    }
                }
                echo "<br>";
                $incdata++;
                $k++; $j=$j+2;
        }else{

            ?>
                <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
                    <p style="margin: 15px;">In order to do this task you need to have completed
                    <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
               </div>
               <br>
               <script type="text/javascript">
                   setTimeout(function(){
                        $('.dependancybutton').fadeOut();
                   },1000)
               </script>
            <?php
        }
    }elseif($practise['typeofdependingpractice'] == "get_questions_and_answers"){

            ?><input type="hidden" name="reading_total_blanks_edit" value="reading_total_blanks_edit"><?php

            if(!empty($practise['dependingpractise_answer'][0])) {
            if($practise['depending_practise_details']['question_type'] == "writing_at_end_speaking_multiple_up") {

                    $question = explode(PHP_EOL,$practise['depending_practise_details']['question']);
                    $question = array_filter($question);
                    $question = array_merge($question);

                    $ans = [];
                    if(!empty($practise['dependingpractise_answer'][0])) {
                        $ans = $practise['dependingpractise_answer'];
                    }
                    $user_answer = isset($practise['user_answer'])?$practise['user_answer'][0]:[];
                    foreach($question as $key => $value) {

                        if(str_contains($value,'@@')) {
                            $k=0;
                            echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$value, &$k, &$ans, &$key) {
                                    $str = "<br>";
                                    $str   .= isset($ans[$key])?"Answer : ".$ans[$key]['text_ans']:"";

                                    echo "<br>";
                                $k++;
                                return $str;
                            }, $value);
                        }
                    }
                    echo "<br>";  echo "<br>";
                    $question = explode(PHP_EOL,$practise['question']);
                    $question = array_filter($question);
                    $question = array_merge($question);

                     $ans = [];
                    if(!empty($practise['user_answer'][0])) {
                        $ans = $practise['user_answer'][0];
                    }

                    foreach($question as $key => $value) {

                        if(str_contains($value,'@@')) {
                            $k=0;
                            echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$value, &$k, &$ans, &$key) {
                                    $str = "<br>";

                                    $answeres = isset($ans[$key])?$ans[$key]:"";
                                    $str   .= '<div class="choice-box j">
                                                    <div class="form-group">
                                                        <span class="textarea form-control form-control-textarea main-answer enter_disable another-main-answer stringProper text-left" role="textbox" contenteditable placeholder="Write here...">'.$answeres.'</span>
                                                        <div style="display:none">
                                                            <textarea name="user_answer[0]['.$key.']" class="main-answer-input">'.$answeres.'</textarea>
                                                        </div>
                                                    </div>
                                                </div>';

                                    echo "<br>";
                                $k++;
                                return $str;
                            }, $value);
                        }
                    }
            }elseif($practise['depending_practise_details']['question_type'] == "match_answer"){

                $ans = [];
                $user_answer = [];
                    if(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer']) ) {
                        $ans = explode(";",$practise['dependingpractise_answer'][0]);
                    }
                    if(isset($practise['user_answer']) && !empty($practise['user_answer']) ) {
                        $user_answer = $practise['user_answer'][0];
                    }
                   $question =  $practise['depending_practise_details']['question'];
                   $question2 =  $practise['depending_practise_details']['question_2'];
                   $newdata = explode("#@", $question[0]);
                   $question[0] = $newdata[1];
                   $k=0;
                   foreach($question as $key => $value) {
                       if(isset($question2[$ans[$k]])){
                        echo $value." : ".$question2[$ans[$k]];

                       }

                        $k++;
                        ?>
                            <div class="choice-box j">
                                <div class="form-group">
                                    <span class="textarea form-control form-control-textarea main-answer enter_disable another-main-answer stringProper text-left" role="textbox" contenteditable placeholder="Write here...">{{isset($user_answer[$key])?$user_answer[$key]:''}}</span>
                                    <div style="display:none">
                                        <textarea name="user_answer[0][{{$key}}]" class="main-answer-input">{{isset($user_answer[$key])?$user_answer[$key]:''}}</textarea>
                                    </div>
                                </div>
                            </div>

                    <?php }
            }elseif($practise['depending_practise_details']['question_type'] == "reading_total_blanks_edit"){

                    $question = explode(PHP_EOL,$practise['depending_practise_details']['question']);
                    $question = array_filter($question);
                    $question = array_merge($question);

                    $tempNewQWue = [];
                    foreach ($question as $key => $value) {
                        if($value!="\r"){
                            array_push($tempNewQWue,$value);
                        }
                    }
                    $question = $tempNewQWue;

                    $ans = [];
                    if(!empty($practise['dependingpractise_answer'][0])) {
                        $ans = explode(";",$practise['dependingpractise_answer'][0]);
                    }


                    $newAns = [];
                    foreach($ans as $newdata){
                        if($newdata == " " || $newdata == "" || $newdata == ""){
                            array_push($newAns,"");
                        }else{
                            array_push($newAns,$newdata);
                        }
                    }


                    $user_answer = isset($practise['user_answer'])?$practise['user_answer'][0]:[];

                            $k=0;
                            // dd($user_answer);
                    foreach($question as $key => $value) {

                        if(str_contains($value,'@@')) {
                            echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$value, &$k, &$newAns) {
                                    $str = "";
                                    $str   .= ($newAns[$k]!="")?$newAns[$k]:"___";

                                    echo "<br>";
                                $k++;
                                return $str;
                            }, $value);
                        }
                        ?>
                            <div class="choice-box j">
                                <div class="form-group">
                                    <span class="textarea form-control form-control-textarea main-answer enter_disable another-main-answer stringProper text-left" role="textbox" contenteditable placeholder="Write here...">{{isset($user_answer[$key])?$user_answer[$key]:''}}</span>
                                    <div style="display:none">
                                        <textarea name="user_answer[0][{{$key}}]" class="main-answer-input">{{isset($user_answer[$key])?$user_answer[$key]:''}}</textarea>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }
            }elseif($practise['depending_practise_details']['question_type'] == "question_type"){

                    $question = explode(PHP_EOL,$practise['depending_practise_details']['question']);
                    $question = array_filter($question);
                    $question = array_merge($question);

                    if(isset($practise['dependingpractise_answer'][0]) && is_array($practise['dependingpractise_answer'][0])){
                        $ans = $practise['dependingpractise_answer'];
                    }else{
                        $ans = !empty($practise['dependingpractise_answer'])?explode(";",$practise['dependingpractise_answer'][0]):[];
                    }
            }elseif($practise['depending_practise_details']['question_type'] == "multi_choice_question"){

                    $question = explode(PHP_EOL,$practise['depending_practise_details']['question']);
                    $question = array_filter($question);
                    $question = array_merge($question);

                    if(isset($practise['dependingpractise_answer'][0]) && is_array($practise['dependingpractise_answer'][0])){
                        $ans = $practise['dependingpractise_answer'][0];
                    }else{
                        $ans = !empty($practise['dependingpractise_answer'])?explode(";",$practise['dependingpractise_answer'][0]):[];
                    }

                    // $question = explode(PHP_EOL,$practise['question']);
                    // $question = array_filter($question);
                    // $question = array_merge($question);

                     $ans = [];
                    if(!empty($practise['user_answer'][0])) {
                        $ans = $practise['user_answer'][0];
                    }

                    foreach($question as $key => $value) {

                        if(str_contains($value,'@@')) {
                            $k=0;
                            echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$value, &$k, &$ans, &$key) {
                                    $str = "<br>";

                                    $answeres = isset($ans[$key])?$ans[$key]:"";
                                    $str   .= '<div class="choice-box j">
                                                    <div class="form-group">
                                                        <span class="textarea form-control form-control-textarea main-answer enter_disable another-main-answer stringProper text-left" role="textbox" contenteditable placeholder="Write here...">'.$answeres.'</span>
                                                        <div style="display:none">
                                                            <textarea name="user_answer[0]['.$key.']" class="main-answer-input">'.$answeres.'</textarea>
                                                        </div>
                                                    </div>
                                                </div>';

                                    echo "<br>";
                                $k++;
                                return $str;
                            }, $value);
                        }
                    }
                }
            }else{
                    $depend =explode("_",$practise['dependingpractiseid']);
                    ?>
                        <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
                            <p style="margin: 15px;">In order to do this task you need to have completed
                            <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                       </div>
                       <br>
                       <script type="text/javascript">
                           setTimeout(function(){
                                $('.dependancybutton').fadeOut();
                           },1000)
                       </script>
                    <?php
            }
    }elseif($practise['typeofdependingpractice'] == "set_full_view_remove_zero"){

            if($practise['depending_practise_details']['question_type'] == "listening_writing"){
                if(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer'])) {

                    $question   = isset($practise['depending_practise_details']['question'])?explode(":", $practise['depending_practise_details']['question']):[];
                    $prctice    = $practise['dependingpractise_answer'];
                    $dependAns  = isset($practise['user_answer']) && !empty($practise['user_answer'][0])?$practise['user_answer'][0]:[];

                    $inc = 0;
                    $j = 0;
                    // dd($question);
                    foreach($prctice as $key=>$ans){
                        if($ans=="")continue; ?>
                       <!--  <div class="choice-box" style="    border: solid 1px;padding: 6px;border-radius: 10px;box-shadow: 0px 0px 14px -4px;">
                              <p class="mb-0"> <input type="text" disabled  value="{{$ans}}" class="form-control"> </p>

                        </div> -->

                        <div class="form-slider p-0 mb-4">
                          <div class="component-control-box">
                                      <span class="textarea form-control" disabled role="textbox" contenteditable="false" placeholder="Write here..." name="writeingBox" value="writeingBox" onpaste="return false;">{{$ans}}</span>
                            <div style="display:none">
                              <textarea name="writeingBox">{{$ans}}</textarea>
                            </div>
                          </div>
                        </div>

                        <style type="text/css">
                          .form-control:disabled, .form-control[readonly] {
                              background-color: #ffffff !important;
                              opacity: 1;
                          }
                        </style>
                    <?php
                    $inc++;
                    }

                    $question       = explode(PHP_EOL,$practise['question']);
                    // dd($question);
                    foreach($question as $key => $value) {

                        if(str_contains($value,'@@')) {
                            echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$kley1, &$c_t, &$data, &$value, &$j, &$ans, &$user_answer, &$dependAns) {
                                    $str = "";
                                    $apval = "";
                                    if(isset($dependAns[$j])){
                                        $apval = $dependAns[$j];
                                    }
                                    $str.= '<span class="textarea form-control form-control-textarea maiDn-answer enter_disable another-main-answer stringProper text-left" role="textbox" contenteditable placeholder="Write here...">'.$apval.'</span><div style="display:none"><textarea name="user_answer[]" class="main-answer-input"></textarea></div>';

                                    echo "<br>";
                                return $str;
                            }, $value);

                        }else{
                            echo "<br>";
                            echo $value;
                        }

                         $j++;
                    }
                    echo "<br>";
                }else{

                    $depend =explode("_",$practise['dependingpractiseid']);
                    ?>
                        <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
                            <p style="margin: 15px;">In order to do this task you need to have completed
                            <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                       </div>
                       <br>
                       <script type="text/javascript">
                           setTimeout(function(){
                                $('.dependancybutton').fadeOut();
                           },1000)
                       </script>
                    <?php
                }

            }else{
                if(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer'])) {
                    $prctice = $practise['dependingpractise_answer'];
                    $dependAns = isset($practise['user_answer']) && !empty($practise['user_answer'][0])?$practise['user_answer'][0][0]:[];

                    $inc = 0;
                    foreach($prctice as $key=>$ans){
                        if($ans=="")continue; ?>
                        <div class="choice-box">
                              <p class="mb-0"> <span class="textarea form-control form-control-textarea main-answer enter_disable" role="textbox" contenteditable placeholder="Write here...">{!! $ans !!}</span> </p>

                            <div class="form-group">
                                  <span class="textarea form-control form-control-textarea main-answer enter_disable" role="textbox" contenteditable placeholder="Write here...">
                                     <?php
                                    if ($answerExists)
                                    {
                                        echo  !empty($dependAns[$inc])?$dependAns[$inc]:"";
                                    }
                                  ?>
                                  </span>
                                  <div style="display:none">
                                        <textarea name="user_answer[0][]" class="main-answer-input">
                                             <?php
                                      if ($answerExists)
                                      {
                                      // echo  !empty($practise['user_answer'][0][$p])?$practise['user_answer'][0][$p]:"";
                                        echo  !empty($dependAns[$inc])?$dependAns[$inc]:"";

                                      }
                                  ?>
                                        </textarea>
                                  </div>
                            </div>
                        </div>
                    <?php
                    $inc++;
                    }
                }else{
                    $depend =explode("_",$practise['dependingpractiseid']);
                    ?>
                        <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
                             <p style="margin: 15px;">In order to do this task you need to have completed
                                <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                       </div>
                       <br>
                    <?php
                }
            }
    }elseif($practise['typeofdependingpractice'] == "get_answers_put_into_answers"){
        if(!empty($practise['dependingpractise_answer'])){
            ?>  <input type="hidden" name="child_type" value="{{$practise['typeofdependingpractice']}}"> <?php
            $question       = explode(PHP_EOL,$practise['depending_practise_details']['question']);
            $ans = [];
            if(isset($practise['dependingpractise_answer'])){
                if(!empty($practise['dependingpractise_answer'][0])) {

                    if(isset($practise['user_answer']) && !empty($practise['user_answer'][0])){
                        $ans = $practise['user_answer'][0];
                    }else{
                        $ans = isset($practise['dependingpractise_answer'][0]['text_ans'])?$practise['dependingpractise_answer'][0]['text_ans']:$practise['dependingpractise_answer'][0];
                    }
                }
            }
            if(!empty($ans) && !is_array($ans)){
                if (strpos($ans, ';') !== false) {
                    $ans       = explode(";",$ans);
                    $ans = array_filter($ans);
                }else{
                    $ans = array_filter($ans);
                }
            }
            $newdata = [];
            foreach ($ans as $key => $value) {
                if($value!="")
                array_push($newdata,$value);
            }
            $ans = $newdata;
            $newans = [];
            if(isset($practise['user_answer'])){
                if(!empty($practise['user_answer'][0])) {

                    $temp = $practise['user_answer'][0];
                    $temp = array_filter($temp);
                    foreach ($temp as $key => $value) {
                        array_push($newans,$value);
                    }

                }
            }

            $j=0;
            echo "<br>";
            foreach($question as $key => $value) {
                if(str_contains($value,'@@')) {
                    echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$kley1, &$c_t, &$data, &$value, &$j, &$ans, &$user_answer) {
                            $str = "";
                            $apval = "";
                            if(isset($ans[$j])){
                                $apval = $ans[$j];
                            }
                            $str.= '<span class="textarea form-control form-control-textarea maiDn-answer enter_disable another-main-answer stringProper text-left" role="textbox" contenteditable placeholder="Write here...">'.$apval.'</span><div style="display:none"><textarea name="user_answer[]" class="main-answer-input"></textarea></div>';

                            echo "<br>";
                        return $str;
                    }, $value);
                    $j++;
                }else{
                    echo "<br>";
                    echo $value;
                }
            }
            echo "<br>"; echo "<br>";
        }else{

            ?>
                <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
                    <p style="margin: 15px;">In order to do this task you need to have completed
                    <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
               </div>
               <br>
               <script type="text/javascript">
                   setTimeout(function(){
                        $('.dependancybutton').fadeOut();
                   },1000)
               </script>
            <?php
        }
    }elseif($practise['typeofdependingpractice'] == "set_full_view") {

        $question       = explode(PHP_EOL,$practise['depending_practise_details']['question']);
        $ans = [];
        if(isset($practise['dependingpractise_answer'])){
            if(!empty($practise['dependingpractise_answer'][0])) {
                $ans = isset($practise['dependingpractise_answer'][0]['text_ans'])?$practise['dependingpractise_answer'][0]['text_ans']:$practise['dependingpractise_answer'][0];
            }
        }

        if(!empty($ans) && !is_array($ans)){
            if (strpos($ans, ';') !== false) {
                $ans       = explode(";",$ans);
                $ans = array_filter($ans);
            }else{
                $ans = array_filter($ans);
            }
        }
        $newdata = [];
        foreach ($ans as $key => $value) {
            if($value!="")
            array_push($newdata,$value);
        }
        $ans = $newdata;

        // dd($ans);
        $question_new   = explode(PHP_EOL,$practise['question']);
        if($practise['depending_practise_details']['question_type'] == "set_in_order_vertical"){

            ?>
                <div class="append_full_view1"></div>
                <script type="text/javascript">
                    setTimeout(function(){
                        // $('.save_set_in_order_vertical_listening_form_{{$depend[1]}}').html().appendTo('.append_full_view1').find('.inOrderAnswer').attr("name","");
                        // $('.save_set_in_order_vertical_listening_form_{{$depend[1]}}').find('.inOrderAnswer').attr("name","")
                        $('.append_full_view1').find('.previousButton').remove();


                         $('.append_full_view1').html($('.save_set_in_order_vertical_listening_form_{{$depend[1]}}').html());
                        // $('.save_set_in_order_vertical_listening_form_{{$depend[1]}}').find('.inOrderAnswer').attr("name","")
                        $('.append_full_view1').find('.previousButton').remove();
                        $('.append_full_view1').find('.inOrderAnswer').attr("name","");
                        $('.append_full_view1').find('.topic_id').remove();
                        $('.append_full_view1').find('.task_id').remove();
                        $('.append_full_view1').find('.is_save').remove();
                        $('.append_full_view1').find('.practise_id').remove();
                        $('.append_full_view1').find('.alert').remove();
                        // $('.append_full_view1').find('.practise_id').remove();


                    },3000);
                </script>
            <?php
        }elseif($practise['depending_practise_details']['question_type'] == "reading_total_blanks_edit"){

                if(!empty($practise['dependingpractise_answer'])){


                    $ans = !empty($practise['dependingpractise_answer'])?explode(";",$practise['dependingpractise_answer'][0]):[];
                    // dd($ans);
                    $k=0;
                    $question   = explode(PHP_EOL,$practise['depending_practise_details']['question']);
                    // dd($question);
                    foreach($question as $key => $value) {
                        if(str_contains($value,'@@')) {
                            echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$value, &$k, &$ans) {
                                    $str = "";

                                        $apval = "";
                                        if(isset($ans[$k])){
                                            $apval = $ans[$k];
                                        }
                                        $str.= '<span style="color: #f79400;font-weight: 800;">'.$apval.'</span>';
                                   $k++;
                                return $str;
                            }, $value);

                        }else{
                            // echo $value;
                            // echo "<br>";
                        }
                    }



                    $j=0;
                    echo "<br>";

                    $user_answer = isset($practise['user_answer'])?$practise['user_answer'][0]:[];
                    // dd($user_answer);
                    foreach($question_new as $key => $value) {
                        if(str_contains($value,'@@')) {
                            echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$kley1, &$c_t, &$data, &$value, &$j, &$newans, &$user_answer) {
                                    $str = "";
                                    $apval = "";
                                    if(isset($user_answer[$j])){
                                        $apval = $user_answer[$j];
                                    }
                                    $str.= '<span class="textarea form-control form-control-textarea maiDn-answer enter_disable another-main-answer" role="textbox" contenteditable placeholder="Write here...">'.$apval.'</span><div style="display:none"><textarea name="user_answer[]" class="main-answer-input"></textarea></div>';

                                    echo "<br>";
                                return $str;
                            }, $value);
                            $j++;
                        }else{
                            echo "<br>";
                            echo $value;
                        }
                    }
                    echo "<br>"; echo "<br>";
                }else{

                     ?>
                         <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; ">
                             <p style="margin: 15px;">In order to do this task you need to have completed
                                <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                       </div>
                       <script type="text/javascript">
                           setTimeout(function(){
                                $('.dependancybutton').fadeOut();
                           },1000)
                       </script>
                    <?php

                }
        }elseif($practise['depending_practise_details']['question_type'] == "writing_at_end_speaking"){

            if(!empty($practise['dependingpractise_answer'])) {

                $k=0;
                $ans = isset($practise['dependingpractise_answer'][0]['text_ans'])?$practise['dependingpractise_answer'][0]['text_ans']:$practise['dependingpractise_answer'][0];
                // dd($ans);
                // dd($question);
                ?>
                <div class="dependancyview">
                    <?php

                        foreach($question as $key => $value) {
                            // if($value=="") continue;
                            if(str_contains($value,'@@')) {
                                echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$value, &$k, &$ans) {
                                        $str = "";
                                        if(empty($ans)){
                                            $str.= '<span class=" form-control form-control-textarea main-answer enter_disable another-main-answer" ></span>';
                                        }else{
                                            $apval = "";
                                            if(isset($ans[$k])){
                                                $apval = $ans[$k];
                                            }
                                            $str.= '<span class=" form-control form-control-textarea main-answer enter_disable another-main-answer" >'.$apval.'</span>';
                                        }
                                        echo "<br>";
                                        $k++;
                                    return $str;
                                }, $value);
                            }else{
                                echo $value;
                                echo "<br>";
                            }

                        }
                    ?>
                    <div id="audioAppend" style=" pointer-events: none;"></div>
                </div>


                  <script type="text/javascript">
                    setTimeout(function(){
                      $('.justify-content-end').clone().appendTo("#audioAppend");
                    },2000)
                  </script>
                <?php
                $newans = [];
                if(isset($practise['user_answer'])){
                    if(!empty($practise['user_answer'][0])) {

                        $temp = $practise['user_answer'][0];
                        $temp = array_filter($temp);
                        foreach ($temp as $key => $value) {
                            array_push($newans,$value);
                        }

                    }
                }

                $j=0;
                echo "<br>";
                // dd($question_new);
                foreach($question_new as $key => $value) {
                    if(str_contains($value,'@@')) {
                        echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$kley1, &$c_t, &$data, &$value, &$j, &$practise, &$user_answer) {
                                $str = "";
                                $apval = "";
                                if(isset($practise['user_answer'][0][$j])){
                                    $apval = $practise['user_answer'][0][$j];
                                }
                                $str.= '<span class="textarea form-control form-control-textarea maiDn-answer enter_disable another-main-answer" role="textbox" contenteditable placeholder="Write here...">'.$apval.'</span><div style="display:none"><textarea name="user_answer[]" class="main-answer-input"></textarea></div>';

                                echo "<br>";
                            return $str;
                        }, $value);
                    }else{
                        echo "<br>";
                        echo '<input type="text" name="user_answer[]" class="main-answer-input">';
                        echo $value;
                    }
                        $j++;
                }
                echo "<br>"; echo "<br>";
            }else{
                    ?>
                         <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; ">
                             <p style="margin: 15px;">In order to do this task you need to have completed
                                <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                       </div>
                       <script type="text/javascript">
                           setTimeout(function(){
                                $('.dependancybutton').fadeOut();
                           },1000)
                       </script>
                    <?php
            }
        }elseif($practise['depending_practise_details']['question_type'] == "writing_at_end_up"){

                if(!empty($practise['dependingpractise_answer'])) {
                    $k=0;
                    foreach($question as $key => $value) {
                        if(str_contains($value,'@@')) {
                            echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$value, &$k, &$ans) {
                                    $str = "";
                                    if(empty($ans)){
                                        $str.= '<span class=" form-control form-control-textarea main-answer enter_disable another-main-answer" ></span>';
                                    }else{
                                        $apval = "";
                                        if(isset($ans[$k])){
                                            $apval = $ans[$k];
                                        }
                                        $str.= '<span class=" form-control form-control-textarea main-answer enter_disable another-main-answer" >'.$apval.'</span>';
                                    }
                                    echo "<br>";
                                return $str;
                            }, $value);
                            $k++;
                        }else{
                            echo $value;
                            echo "<br>";
                        }
                    }


                    $j=0;
                    echo "<br>";
                    $newans = [];
                    if(isset($practise['user_answer'])){
                        if(!empty($practise['user_answer'][0])) {

                            $temp = $practise['user_answer'][0];
                            $temp = array_filter($temp);
                            foreach ($temp as $key => $value) {
                                array_push($newans,$value);
                            }

                        }
                    }
                    // dd($newans);
                    foreach($question_new as $key => $value) {
                        if(str_contains($value,'@@')) {
                            echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$kley1, &$c_t, &$data, &$value, &$j, &$newans, &$user_answer) {
                                    $str = "";
                                    $apval = "";
                                    if(isset($newans[$j])){
                                        $apval = $newans[$j];
                                    }
                                    $str.= '<span class="textarea form-control form-control-textarea maiDn-answer enter_disable another-main-answer" role="textbox" contenteditable placeholder="Write here...">'.$apval.'</span><div style="display:none"><textarea name="user_answer[]" class="main-answer-input"></textarea></div>';

                                    echo "<br>";
                                return $str;
                            }, $value);
                            $j++;
                        }else{
                            echo "<br>";
                            echo $value;
                        }
                    }
                    echo "<br>";

                } else{
                    // dd("Asdasd");
                    ?>
                         <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; ">
                             <p style="margin: 15px;">In order to do this task you need to have completed
                                <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                       </div>
                       <script type="text/javascript">
                           setTimeout(function(){
                                $('.dependancybutton').fadeOut();
                           },1000)
                       </script>
                    <?php

                }
        }elseif($practise['depending_practise_details']['question_type'] == "writing_at_end"){
                         
                // dd($question);

                $ansData = 
                $k=0;
                foreach($question as $key => $value) {

                    if(str_contains($value,'@@')) {
                        echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$value, &$k, &$ans, &$key) {
                                $str = "";
                                if(empty($ans)){
                                    $str.= '<span class=" form-control form-control-textarea main-answer enter_disable another-main-answer" ></span>';
                                }else{
                                    $apval = "";
                                    if(isset($ans[$key])){
                                        $apval = $ans[$key];
                                    }
                                    $str.= '<span class=" form-control form-control-textarea main-answer enter_disable another-main-answer" >'.$apval.'</span>';
                                }
                                echo "<br>";
                            return $str;
                        }, $value);
                        $k++;
                    }else{
                        echo $value;
                        echo "<br>";
                    }
                }

                $j=0;
                echo "<br>";
                  //dd($question_new);
                $user_answer = [];
                $user_answer = isset($practise['user_answer'])?$practise['user_answer'][0]:[];
                foreach($question_new as $key => $value) {
                 if(str_contains($value,'<br>'))
                 {
                      echo $value."<br>";
                 }
                 else
                 {
                    if(str_contains($value,'@@')) {

                        echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$kley1, &$c_t, &$data, &$value, &$j, &$newans, &$user_answer, &$key) {
                                $str = "";
                                $apval = "";
                                // dd($user_answer[$j]);
                               
                                   if(isset($user_answer[$j])){
                                 
                                    $apval = isset($user_answer[$key])?$user_answer[$key]:'';
                                }
                                $str.= '<span class="textarea form-control form-control-textarea maiDn-answer enter_disable another-main-answer" role="textbox" contenteditable placeholder="Write here...">'.$apval.'</span><div style="display:none"><textarea name="user_answer[0][]" class="main-answer-input"></textarea></div>';
                                echo "<br>";
                            return $str;
                        }, $value);

                    } else {

                        echo "<br><input type='hidden' name='user_answer[]'> ";
                        echo $value;

                    }
                     $j++;
                 }
                }
              //  dd($user_answer);
                echo "<br>"; echo "<br>";
        }
        elseif($practise['depending_practise_details']['question_type'] == "image_reading_total_blanks")
        {
             //-----new dependent practice
        } 
        elseif($practise['depending_practise_details']['question_type'] == "true_false_listening_simple")
        {
             if(!empty($practise['dependingpractise_answer'])) {
                if(isset($practise['depending_practise_details']['question']))
                {
                   //dd($practise);
                    $questions      = str_replace(PHP_EOL, '',$practise['depending_practise_details']['question']);
                    $split_question = explode('@@',$questions);
                    
                    $style = "color: #fff;background-color: #d55b7d;";
                    foreach($split_question as $key => $value)
                    {
                        if($value != "")
                        {
                           $true_style  = "";
                           $false_style = "";
                           if(isset($practise['dependingpractise_answer'][0][$key]['true_false']))
                           {
                               $true_false_value = $practise['dependingpractise_answer'][0][$key]['true_false'];
                               if($true_false_value == "1")
                               {
                                  $true_style  = "color: #fff;background-color: #d55b7d;";
                               } 
                               else if($true_false_value == "0")
                               {
                                  $false_style  = "color: #fff;background-color: #d55b7d;";
                               }
                               else
                               {
                                    $true_style  = "";
                                    $false_style = "";
                               }
                           }
                    ?>
                          <div class="true-false">
                                <div class="box box-flex align-items-center">
                                    <div class="box__left flex-grow-1">
                                        <p>{{$value}}</p>
                                    </div>

                                    <div class="true-false_buttons">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" style="{{$true_style}}"for="inlineRadioTrue_0">True</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" style="{{$false_style}}" for="inlineRadiofalse_0">False</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                           // echo $value."</br>";
                        }
                    }
                }
             }
             else
             {
        ?>
                <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; ">
                     <p style="margin: 15px;">In order to do this task you need to have completed
                        <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. 
                        </strong> Please complete this first.
                     </p>
                </div>
                <script type="text/javascript">
                   setTimeout(function(){
                        $('.dependancybutton').fadeOut();
                   },1000)
                </script>
        <?php        
             }
             //-----new dependent practice
        } 
        else{
               $k=0;
                foreach($question as $key => $value) {
                    if(str_contains($value,'@@')) {
                        echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$value, &$k, &$ans) {
                                $str = "";
                                if(empty($ans)){
                                    $str.= '<span class=" form-control form-control-textarea main-answer enter_disable another-main-answer" ></span>';
                                }else{
                                    $apval = "";
                                    if(isset($ans[$k])){
                                        $apval = $ans[$k];
                                    }
                                    $str.= '<span class=" form-control form-control-textarea main-answer enter_disable another-main-answer" >'.$apval.'</span>';
                                }
                                echo "<br>";
                            return $str;
                        }, $value);
                        $k++;
                    }else{
                        echo $value;
                        echo "<br>";
                    }
                }
        }
?>
<!-- Transcript -->
    @php
      $isTabscript_writing_end = false;
      if (strpos($practise['question'], '#%') !== false) {
          $isTabscript_writing_end        = true;
          $tapscripts         = explode("/t",$practise['question']);
          $tapscript          = explode("#%",$tapscripts[0]);
          $question_new  = explode(PHP_EOL,$tapscripts[1]);
      }
    @endphp
<!---------------->
@if($isTabscript_writing_end)
    <div id="myModal" class="modal fade" role="dialog" style="z-index:1051;">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{isset($tapscript[0])?$tapscript[0]:""}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php 
                if(isset($tapscript[1])){
                    echo nl2br($tapscript[1]);
                }         
                ?>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="submitBtnd btn btn-cancel" data-dismiss="modal">Close</button>
            </div>
        </div>
      </div>
    </div>
@endif

<?php
        if($practise['depending_practise_details']['question_type'] != "writing_at_end" && $practise['depending_practise_details']['question_type'] != "writing_at_end_up" && $practise['depending_practise_details']['question_type'] != "writing_at_end_speaking" && $practise['depending_practise_details']['question_type'] != "reading_total_blanks_edit"){   
                  $newans = [];
                  if(isset($practise['user_answer'])){
                      if(!empty($practise['user_answer'][0])) {

                          $temp = $practise['user_answer'][0];
                          // $temp = array_filter($temp);
                          foreach ($temp as $key => $value) {
                              array_push($newans,$value);
                          }

                      }
                  }
                  //---------------------------------------
                   if($isTabscript_writing_end)
                   {
                     $tapscripts = explode("/t",$practise['question']);
                     $tapscript = explode("#%",$tapscripts[0]);
                     if(count($tapscript)>1) {
                         if(isset($tapscript[0]))
                        { ?>
                            <div  style="text-align: center;margin-bottom: 27px;">
                                <button id="openmodel" class=" openmodel btn btn-primary">{{$tapscript[0]}}</button>
                            </div>
                         <?php
                        }
                     }
                    }
                  //---------------------------------------
                        $j=0;
                         echo "<br>";
                      foreach($question_new as $key => $value) {
                          if(str_contains($value,'@@')) {
                              echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$kley1, &$c_t, &$data, &$value, &$j, &$newans, &$user_answer) {
                                      $str = "";
                                      $apval = "";
                                      if(isset($newans[$j])){
                                          $apval = $newans[$j];
                                      }
                                      $str.= '<span class="textarea form-control form-control-textarea maiDn-answer enter_disable another-main-answer" role="textbox" contenteditable placeholder="Write here...">'.$apval.'</span><div style="display:none"><textarea name="user_answer[]" class="main-answer-input"></textarea></div>';

                                      echo "<br>";
                                  return $str;
                              }, $value);
                              $j++;
                          }else{
                              echo "<br>";
                              echo $value;
                          }
                      }
                      echo "<br>"; echo "<br>";
        }
    }
    ?>
    <?php $p=0; ?>
    @if( !empty($exploded_question) )
        @foreach( $exploded_question as $key => $value )
          @if(!empty($value))
            @if (str_contains($value, '@@'))
              <div class="choice-box">
                  @if(  $practise['type']=="writing_at_end_option")
                    <p class="mb-0">{!! nl2br(substr(str_replace('@@', '', $value),2)) !!} </p>
                  @else
                    <p class="mb-0 main-question">{!! nl2br(str_replace('@@', '', $value)) !!} </p>
                  @endif
                  <div class="form-group">
                    <span class="textarea form-control form-control-textarea main-answer enter_disable" role="textbox" contenteditable placeholder="Write here...">
                      <?php
                        if ($answerExists)
                        {
                            echo  !empty($practise['user_answer'][0][$p])? str_replace(" ","&nbsp;",nl2br($practise['user_answer'][0][$p]) ):"";
                          // echo  !empty($practise['user_answer'][0][$p])?$practise['user_answer'][0][$p]:"";
                        }
                      ?>
                    </span>
                    <div style="display:none">

                      <textarea name="user_answer[0][{{$p}}]" class="main-answer-input">
                      <?php
                          if ($answerExists)
                          {
                                 // echo  !empty($practise['user_answer'][0][$p])?$practise['user_answer'][0][$p]:"";
                                echo  !empty($practise['user_answer'][0][$p])? str_replace(" ","&nbsp;",nl2br($practise['user_answer'][0][$p]) ):"";

                          }
                      ?>
                      </textarea>
                    </div>
                  </div>
              </div>
            @else
            <div class="first-question">
              <p class="mb-0  main-answer"><strong>{!! strip_tags(nl2br($value)) !!} </strong></p>
              <input type="hidden" name="user_answer[0][{{$key}}]">
            </div>
            @endif
            <?php $p++; ?>
          @endif

          <!-- /. box -->
        @endforeach
      @endif
  </div>

  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
  <ul class="list-inline list-buttons dependancybutton">
      <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"
              data-toggle="modal" data-is_save="0" data-target="#exitmodal"  >Save</button>
      </li>
      <li class="list-inline-item"><button type="button"
              class="submit_btn btn btn-primary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1" >Submit</button>
      </li>
  </ul>
</form>
@if(isset($practise["markingmethod"]) && $practise["markingmethod"] == "student_self_marking")

    @include('practice.common.student_self_marking')

@endif
@php
    $lastPractice=end($practises);
@endphp
@if($lastPractice['id'] == $practise['id'])
    @include('practice.common.review-popup')
    @php
        $reviewPopup=true;
    @endphp
@else
    @php
        $reviewPopup=false;
    @endphp
@endif
</div>
<script type="text/javascript">
  $(document).on('click','.openmodel',function(){
      $('#myModal').modal("show");
      return false;
  });
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>

<script>
    // var cols = document.querySelectorAll('#columnsa .list-item');
    // [].forEach.call(cols, addDnDHandlers);
</script>
<script>
$('.enter_disable').keypress(function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});

var feedbackPopup       = true;
var facilityFeedback    = false;
var courseFeedback      = true;


// =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
// var next_practice_id = "{{request()->n}}";
// if(next_practice_id && next_practice_id!=""){
//   $('#abc-'+next_practice_id+'-tab').trigger('click');
//   $('.course-tab-content.scrollbar').find('.tab-pane').removeClass('active').removeClass('show');
//   $('#abc-'+next_practice_id).addClass('active show')
// }
// =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
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
                'current-time'
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
$(document).on('click','.submitBtn_{{$practise["id"]}}' ,function() {


        if($(this).attr('data-is_save') == '1'){
            $(this).closest('.active').find('.msg').fadeOut();
        }else{
            $(this).closest('.active').find('.msg').fadeIn();
        }
        var reviewPopup = '{!!$reviewPopup!!}';
          var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){
                    var fullView= $(".form_{{$practise['id']}}").html();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.textarea').attr("contenteditable",false);
                }
            }
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){

                $("#reviewModal_{{$practise['id']}}").modal('toggle');

            }
// $("#reviewModal_{{$practise['id']}}").modal('toggle');
// return false;

var $this = $(this);
$this.attr('disabled','disabled');
var is_save = $(this).attr('data-is_save');
$('.form_{{$practise["id"]}}').find('.is_save:hidden').val(is_save);
$('.form_{{$practise["id"]}}').find("span.textarea.form-control").each(function(){
  var currentVal = $(this).html();
  $(this).next().find("textarea").val(currentVal);
});

$.ajax({
    url: '<?php echo URL('save-writing-at-end-option'); ?>',
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    type: 'POST',
    data: $('.form_{{$practise["id"]}}').serialize(),
    success: function (data) {

      $this.removeAttr('disabled');
      if(data.success){
        if(is_save=="1"){
          // =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
          setTimeout(function(){
              $('.alert-success').hide();
            var isNextTaskDependent =  $('.nav-link.active').parent().next().find('a').attr('data-dependent');
            if( isNextTaskDependent == 1 ){
              var dependentPractiseId =  $('.nav-link.active').parent().next().find('a').attr('data-id');
              var baseUrl = "{{url('/')}}";
              var topic_id = "{{request()->segment(2)}}";
              var task_id = "{{request()->segment(3)}}";
                // //window.location.href=baseUrl+'/topic/'+topic_id+'/'+task_id+'?n='+dependentPractiseId
              ////$('#abc-'+dependentPractiseId+'-tab').trigger('click');
            } else {
               // //$('.nav-link.active').parent().next().find('a').trigger('click');
            }
          },2000);
          // =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
        }

        $('.form_{{$practise["id"]}}').find('.alert-danger').hide();
        $('.form_{{$practise["id"]}}').find('.alert-success').show().html(data.message).fadeOut(8000);
        // $("#reviewModal_{{$practise['id']}}").modal('toggle');
      } else {
        $('.form_{{$practise["id"]}}').find('.alert-success').hide();
        $('.form_{{$practise["id"]}}').find('.alert-danger').show().html(data.message).fadeOut(8000);
      }
    }
});
});
</script>
@if(isset($practise['id']))
@if($practise['id'] == "166514370163401395d5470")
<script>
    if(data13==undefined ){
        var data13=[];
    } 
    data13["{{$practise['id']}}"]= {"dependentpractice_ans": "{{$data[$practise['id']]['dependentpractice_ans']}}" };
    data13["{{$practise['id']}}"]["isRolePlayPractice"] = "{{$data[$practise['id']]['isRolePlayPractice']}}"
    data13["{{$practise['id']}}"]["is_dependent"] = "{{$data[$practise['id']]['is_dependent']}}"; 
    if(data13["{{$practise['id']}}"]["is_dependent"]==1){
        
        if(data13["{{$practise['id']}}"]["dependentpractice_ans"]==0 ){
            $(".previous_practice_answer_exists_{{$practise['id']}}").hide();
            $("#dependant_pr_{{$practise['id']}}").show();
        } else {
            $(".previous_practice_answer_exists_{{$practise['id']}}").show();
            $("#dependant_pr_{{$practise['id']}}").hide();
        }
    } else {
        $(".previous_practice_answer_exists_{{$practise['id']}}").show();
        $("#dependant_pr_{{$practise['id']}}").hide();
    }

    
</script>

@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==0 && $practise['typeofdependingpractice']!='get_answers_generate_quetions' )
<script>

    data13["{{$practise['id']}}"]["typeofdependingpractice"] = "{{$data[$practise['id']]['typeofdependingpractice'] }}";
    data13["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
    if(data13["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data13["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data13["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data13["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data13["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data13["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data13["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view"){
      
        data13["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
        data13["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
        $(function () {
            $('.cover-spin').fadeIn();
        });
        if(data13["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
             

            // IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
            if(data13["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
                
                 
                 setTimeout(function(){ 
                 
                     data13["{{$practise['id']}}"]["prevHTML"] = $(document).find('#abc-'+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();               
                    $(".previous_practice_answer_exists_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).find(".match-answer").hide();
                    $(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).html(data13["{{$practise['id']}}"]["prevHTML"]);
                    $(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
                    $(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
                    $(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert').remove();

                    if( data13["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" ){
                        if(data13["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_no_blanks_listening_speaking_down"  || data13["{{$practise['id']}}"]["dependant_practise_question_type"]== "single_speaking_up_writing" ) {
                            $(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('.audio-player').remove();
                            $(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
                        }

                    } 

                    $('.cover-spin').fadeOut();
                    $(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).find(".match-answer").hide();
                 }, 8000 )
                 
                // alert('dfd');
            }
        } else {
        
            // IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
            // DO NOT REMOVE BELOW   CODE
            var baseUrl = "{{url('/')}}";
            data13["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
            data13["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data13["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data13["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data13["{{$practise['id']}}"]["dependant_practise_id"];
            $.get(data13["{{$practise['id']}}"]["dependentURL"],  //
            function (dataHTML, textStatus, jqXHR) {  // success callback
                setTimeout(function(){
                    data13["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
                    $(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).html(data13["{{$practise['id']}}"]["prevHTML"]);
                    $(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
                    $(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, .alert, input:hidden').remove();
                    
                    if(data13["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" ){
                        
                        if(data13["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_no_blanks_listening_speaking_down" || data13["{{$practise['id']}}"]["dependant_practise_question_type"]== "single_speaking_up_writing") {
                            $(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
                        }
                    }
                    $('.cover-spin').fadeOut();
                },8000)
                
            });
        }
    }  
    // $(".owl-stage-outer").hide();
</script>
@endif
@endif
@endif