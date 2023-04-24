<?php
  $answerExists = false;
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
    $answers = $practise['user_answer'];
  }
  $two_tabs = array();
  $i=0;
    $question_list = explode('#@', $practise['question']);
  if(isset($practise['is_roleplay']) && !empty($practise['is_roleplay'])){
    $two_tabs = explode('@@', str_replace('##True@@False','',$question_list[0]));
    array_shift($question_list);
  }else{
    if(count($question_list) == 2){
      $truefalse=explode('@@',$question_list[0]);
      $true_name=$truefalse[0];
      $false_name=$truefalse[1];

      $questions= explode(PHP_EOL,$question_list[1]);
    }else{
      $questions= explode(PHP_EOL,$question_list[0]);
      $true_name='Correct';
      $false_name='Incorrect';
    }
  }
?>
<p><strong>{!!$practise['title']!!}</strong></p>
<form class="true_false_correct_incorrect_form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_type" name="practise_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  @if(isset($practise['is_roleplay']) && !empty($practise['is_roleplay']))
    <input type="hidden" name="is_roleplay" value="true" >
    <input type="hidden" class="is_roleplay_submit" name="is_roleplay_submit" value="1">
  @endif
  <div class="component-two-click mb-4" >
      @if(!empty($two_tabs))
          <?php $k = 0; ?>
          <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
            @foreach($two_tabs as $key => $value)
              <?php 
              if($key==0){
                  $tbkey = $key;
              }else {
                  $tbkey = $key+1;
              }
              if(empty($answers[$tbkey]) && request()->segment(1)=="topic-iframe"){
                  $tab_val = $value."<br/>No answers submitted";
                  $btn_class= 'btn-light';
              }else{
                  $tab_val=$value;
                  $btn_class= 'btn-dark selected_option';
              }
              ?>
              <div class="prev_ans_{{$k}}" style="display:none;"></div>
                <a href="javascript:void(0)" class="btn {{$btn_class}}  selected_option_{{$key}}" data-key="{{$key}}">{!!$tab_val!!}</a>
                <?php $k+=2; ?>
            @endforeach
          </div>
      @endif
        <?php
          if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
            $depend =explode("_",$practise['dependingpractiseid']);
        ?>
            <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
            <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
        <?php } ?>
      <div class="content-box multiple-choice d-none mb-4  selected_option_description selected_option_description_0">
          <?php
            $style = "";
            if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) ){
              $depend = explode("_",$practise['dependingpractiseid']);
              if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
                $answerExists = true;
                if(!empty($practise['user_answer'][0])){
                  $user_ans = $practise['user_answer'][0];
                }
              }
          ?>
            <div id="dependant_pr_0" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; display:none">
                 <p style="margin: 15px;">In order to do this task you need to have completed
                    <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
           </div>
        <?php } ?>
      </div>
      <div class="content-box multiple-choice d-none mb-4 selected_option_description selected_option_description_1">
          <?php
            $style = "";
            if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) ){
                $depend = explode("_",$practise['dependingpractiseid']);
                if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
                  $answerExists = true;
                  if(!empty($practise['user_answer'][0])){
                    $user_ans = $practise['user_answer'][0];
                  }
                }
              ?>
                <div id="dependant_pr_2" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; display:none">
                      <p style="margin: 15px;">In order to do this task you need to have completed
                        <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                </div>
        <?php } ?>
      </div>
    <div class="two-click-content w-100 dsf">
        @if(!isset($practise['is_roleplay']) || empty($practise['is_roleplay']))
              <?php $key=0;$answer_count=0; ?>
                        @foreach($questions as $k=>$v)
                              <?php
                                $answer_count = $answer_count + $k;
                                $true_false_name = "user_answer[0][$k][true_false]";
                                $question_name = "user_answer[0][$k][question]";
                                $text_ans_name = "user_answer[0][$k][text_ans]";
                              ?>
                                <div class="true-false true-false_withoutBefore">
                                  <div class=" box box-flex align-items-center">
                                      <input type="hidden" name="{{$question_name}}" value="{{$v}}">
                                      <div class="box__left flex-grow-1">
                                          @if(!strpos($v,'@@'))
                                              <p>{!!$v!!}</p>
                                          @else
                                          <p>{!!str_replace("@@","",$v)!!}</p>
                                          <?php
                                            $style="display:none";
                                            if(!empty($answers) && isset($answers[0][$k]['true_false']) && $answers[0][$k]['true_false'] == 0 )
                                            {
                                              $style="display:block";
                                              $disabled="disabled";
                                            }
                                          ?>
                                          <div class="form-group">
                                              <?php
                                              $tmpAnsTrim='';
                                              if ($answerExists)
                                                {
                                                  $tmpAnsTrim= !empty($answers[0][$k]['text_ans'])?ltrim($answers[0][$k]['text_ans']):"";
                                                }
                                              ?>
                                            <span style="{{$style}}" class="textarea form-control form-control-textarea stringProper" contenteditable="" role="textbox">{!!$tmpAnsTrim!!}</span>
                                            <div style="display:none">
                                              <textarea name="{{$text_ans_name}}" {{empty($answers[0][$k]['text_ans'])?'disabled':''}}>
                                                <?php
                                                if ($answerExists)
                                                {
                                                  echo  !empty($answers[0][$k]['text_ans'])?$answers[0][$k]['text_ans']:"";
                                                }
                                                ?>
                                              </textarea>
                                            </div>
                                          </div>
                                          @endif
                                      </div>
                                       @if(strpos($v,'@@'))
                                              <div class="true-false_buttons mt-1">
                                                <div class="form-check form-check-inline">
                                                  <input class="form-check-input true_option" type="radio"
                                                      name="{{$true_false_name}}"
                                                      id="inlineRadioTrue_{{$key}}_{{$k}}_{{$practise['id']}}"
                                                      value="1" {{ ( isset($answers[0][$k]['true_false']) && $answerExists && $answers[0][$k]['true_false'] == 1 ) ? "checked":"" }} >
                                                  <label class="form-check-label form-check-label_true" for="inlineRadioTrue_{{$key}}_{{$k}}_{{$practise['id']}}">{!!$true_name!!}</label>

                                                </div>
                                                <div class="form-check form-check-inline">

                                                  <input class="form-check-input false_option" type="radio"
                                                      name="{{$true_false_name}}"
                                                      id="inlineRadioFalse_{{$key}}_{{$k}}_{{$practise['id']}}"
                                                      value="0" {{ ( isset($answers[0][$k]['true_false']) && $answerExists && $answers[0][$k]['true_false'] == 0) ?"checked":"" }} >
                                                  <label class="form-check-label form-check-label_true" for="inlineRadioFalse_{{$key}}_{{$k}}_{{$practise['id']}}">{!!$false_name!!}</label>

                                                </div>
                                              </div>

                                      @endif
                                  </div>
                                </div>
                                             
                        @endforeach
        
        @elseif(!empty($question_list))
            <?php $answer_count=0; $roleplay_count = 0; ?>
            @foreach($question_list as $key => $value)
                <?php $value =  str_replace('##True@@False','',$value); $exp_question = explode('@@',$value); ?>
                <?php
                    if($key>0) {
                        $roleplay_count+=2;
                    }
                    if( $key%2==0 ) {
                        echo '<input type="hidden" name="user_answers[{{$key+1}}]" value="#" >';
                    }
                ?>
                  <div class="content-box multiple-choice d-none student_bottom_{{$roleplay_count}} selected_option_description selected_option_description_{{$key}} true__false__block">
                    <div class="true-false true-false_withoutBefore">
                        @foreach($exp_question as $k => $v)

                            @if(!empty($v)) 
                                <?php
                                    $answer_count = $answer_count + $k;
                                    $true_false_name = "user_answer[$roleplay_count][0][$k][true_false]";
                                    $question_name = "user_answer[$roleplay_count][0][$k][question]";
                                    $text_ans_name = "user_answer[$roleplay_count][0][$k][text_ans]";
                                ?>
                              <div class="box box-flex d-flex align-items-center">
                                    <input type="hidden" name="{{$question_name}}" value="{{$v}}">
                                    <div class="box__left flex-grow-1">
                                        <p>{!! $v !!}</p>
                                        <?php
                                        $style="display:none";
                                        if(!empty($answers) && isset($answers[$roleplay_count][0][$k]['true_false']) && $answers[$roleplay_count][0][$k]['true_false'] == 0 )
                                        {
                                            $style="display:block";
                                            $disabled="disabled";
                                        }
                                        ?>
                                        <div class="form-group">
                                            <?php
                                                $ansTrim='';
                                                if ($answerExists)
                                                {
                                                    $ansTrim=!empty($answers[$roleplay_count][0][$k]['text_ans'])?ltrim($answers[$roleplay_count][0][$k]['text_ans']):"";
                                                }
                                            ?>
                                            <span style="{{$style}}" class="textarea form-control form-control-textarea stringProper" contenteditable="" role="textbox">{!!$ansTrim!!}</span>
                                            <div style="display:none">
                                                <textarea name="{{$text_ans_name}}" {{empty($answers[$roleplay_count][0][$k]['text_ans'])?'disabled':''}}>
                                                    <?php
                                                    if ($answerExists)
                                                    {
                                                        echo  !empty($answers[$roleplay_count][0][$k]['text_ans'])?$answers[$roleplay_count][0][$k]['text_ans']:"";
                                                    }
                                                    ?>
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="true-false_buttons mt-1">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input true_option" type="radio" name="{{$true_false_name}}" id="inlineRadioTrue_{{$key}}_{{$k}}_{{$practise['id']}}" value="1" {{ ( isset($answers[$roleplay_count][0][$k]['true_false']) && $answerExists && $answers[$roleplay_count][0][$k]['true_false'] == 1 ) ? "checked":"" }} >
                                        <label class="form-check-label form-check-label_true" for="inlineRadioTrue_{{$key}}_{{$k}}_{{$practise['id']}}">True</label>
                                   </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input false_option" type="radio" name="{{$true_false_name}}" id="inlineRadioFalse_{{$key}}_{{$k}}_{{$practise['id']}}" value="0" {{ ( isset($answers[$roleplay_count][0][$k]['true_false']) && $answerExists && $answers[$roleplay_count][0][$k]['true_false'] ==0)?"checked":"" }} >
                                        <label class="form-check-label form-check-label_true" for="inlineRadioFalse_{{$key}}_{{$k}}_{{$practise['id']}}">False</label>
                                    </div>
                                </div>
                                </div>
                            @endif
                        @endforeach
                    </div>  
                  </div>
              <?php $answer_count++ ?>
            @endforeach
        @endif
    </div>
    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
    </div>
</form>
<script>
$('.false_option').on('click', function(){
  $(this).parent().parent().parent().find('.textarea').show()
  $(this).parent().parent().parent().find('textarea').removeAttr('disabled');
})
$('.true_option').on('click', function(){
  $(this).parent().parent().parent().find('.textarea').hide();
  $(this).parent().parent().parent().find('textarea').attr('disabled');
});
$(function () {
    $("#abc-{{$practise['id']}} .selected_option").click(function () {
      var content_key = $(this).attr('data-key');
      $('#abc-{{$practise["id"]}} .selected_option').not(this).toggleClass('d-none');
      $('#abc-{{$practise["id"]}} .selected_option_description_'+content_key).toggleClass('d-none');
      $('#abc-{{$practise["id"]}} .selected_option_'+content_key).show();
      $(this).toggleClass('btn-bg');
      if( $('#abc-{{$practise['id']}} .selected_option_description:visible').length>0 ){
        var ans_key = (content_key == 0) ? 0 : 2;
        $('#abc-{{$practise['id']}} .prev_ans_'+ans_key).show();
        $('#abc-{{$practise['id']}} .is_roleplay_submit').val(0);
      }else{
        $('#abc-{{$practise["id"]}} .prev_ans_0').hide();
        $('#abc-{{$practise["id"]}} .prev_ans_2').hide();
        $('#abc-{{$practise["id"]}} .is_roleplay_submit').val(1);
      }
    });
});
function selfmarkingPopup(){
   $("#selfMarking_{{$practise['id']}} .selected_option").click(function () {
      var content_key = $(this).attr('data-key');
      $('#selfMarking_{{$practise["id"]}} .selected_option').not(this).toggleClass('d-none');
      $('#selfMarking_{{$practise["id"]}} .selected_option_description_'+content_key).toggleClass('d-none');
      $('#selfMarking_{{$practise["id"]}} .selected_option_'+content_key).show();
      $(this).toggleClass('btn-bg');
      if( $('#selfMarking_{{$practise['id']}} .selected_option_description:visible').length>0 ){
        var ans_key = (content_key == 0) ? 0 : 2;
        $('#selfMarking_{{$practise["id"]}} .prev_ans_'+ans_key).show();
        $('#selfMarking_{{$practise["id"]}} .is_roleplay_submit').val(0);
      }else{
        $('#selfMarking_{{$practise["id"]}} .prev_ans_0').hide();
        $('#selfMarking_{{$practise["id"]}} .prev_ans_2').hide();
        $('#selfMarking_{{$practise["id"]}} .is_roleplay_submit').val(1);
      }
    });
}
function setTextareaContent(){
	$(".true_false_correct_incorrect_form_{{$practise['id']}} span.textarea.form-control").each(function(){
		var currentVal = $(this).html();
    var regex = /<br\s*[\/]?>/gi;
    currentVal=currentVal.replace(regex, "\n");
    var regex = /<div\s*[\/]?>/gi;
    currentVal=currentVal.replace(regex, "\n");
    var regex = /<\/div\s*[\/]?>/gi;
    currentVal=currentVal.replace(regex, "");
    var regex = /&nbsp;/gi;
    currentVal=currentVal.replace(regex, "");
    currentVal= currentVal.replace('</div>','');
    console.log(currentVal);
		$(this).next().find("textarea").val(currentVal);
	})
}
</script>
@if(!empty($practise['dependingpractiseid']) && $practise['is_dependent']==1 )
  <script>
  $(window).on('load', function() {
    var practise_id = $("#abc-{{$practise['id']}}").find('.depend_practise_id').val();
    if(practise_id){
        getDependingPractisess();
    } else{
      $('.previous_practice_answer_exists_{{$practise["id"]}}').show();
    }
    function getDependingPractisess(){
      var topic_id= $("#abc-{{$practise['id']}}").find('.topic_id').val();
      var task_id=$("#abc-{{$practise['id']}}").find('.depend_task_id').val();
      var practise_id=$("#abc-{{$practise['id']}}").find('.depend_practise_id').val();
      var dependent_ans = '<?php echo !empty($user_ans)?json_encode($user_ans):"" ?>';
      var student_id = "{{request()->segment(4)}}";
      $.ajax({
          url: "{{url('get-student-practisce-answer')}}",
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          type: 'POST',
          data:{
              topic_id,
              task_id,
              practise_id,
              student_id
          },
          dataType:'JSON',
          success: function (data) {
            if(jQuery.isEmptyObject(data) == false && data.user_Answer){
              $(".true__false__block").show();
              var split_question = data.question.split('##')
              split_question.shift();
              var answer = data.user_Answer;
              split_question.forEach( (item, i) => {
                var str = "";
                var count = 0;
                if(i>0){
                  i+=1
                }
                if( answer[i].text_ans!==undefined && answer[i].text_ans[0] !== ";"){
                  var blanks = answer[i].text_ans.split(';');
                  item = item.replace(/@@/g, function( match, contents, offset, input_string )
                  {
                    var ans= blanks[count];
                    count++;
                    str = '<span class="textarea d-inline-flex mw-20 form-control form-control-textarea stringProper conversation_answer_'+count+'" role="textbox" >'+ans+'</span>';
                    return str;
                  });
                  $('#dependant_pr_'+i).hide();
                  $('.student_bottom_'+i).show();
                  console.log(item);
                  $('.prev_ans_'+i).html('<p>'+item+'</p>');
                } else {
                  if(answer[i]=="") {
                    $('#dependant_pr_'+i).show();
                    $('.student_bottom_'+i).hide();
                    $('.prev_ans_'+i).hide()
                  }
                }
              });
            } else {
                $("#dependant_pr_0").css("display", "block");
                $("#dependant_pr_2").css("display", "block");
                $(".true__false__block").hide();
            }
          }
      });
    }
  });
</script>
@endif
