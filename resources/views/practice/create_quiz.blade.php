<p><strong>{!! $practise['title'] !!}</strong></p>
<!-- Component - Create Quiz-->
<?php
//pr(json_encode($practise));
  $answerExists = false;
  if(!empty($practise['user_answer'])){
      $answerExists = true;
      $answers = $practise['user_answer'][0];
  }
  $exp_question = explode(PHP_EOL, $practise['question']);
  $total_questions = $exp_question[0];
  $total_options = $exp_question[1];

?>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

  @for($i=0;$i<$total_questions; $i++)
    <div class="create-quiz">
      <div class="d-flex flex-wrap quiz__question_box mb-4">
        <div class="quiz-question">
            Question {{$i+1}}:
        </div>
        <div class="quiz-question__form-control">
            <span class="textarea form-control form-control-textarea"
                role="textbox" contenteditable
                placeholder="Write here...">
                {{ ($answerExists) ? $answers[$i]['question'] : "" }}
            </span>
            <div style="display:none">
              <textarea name="text_ans[{{$i}}][question]">
              <?php
                  if ($answerExists)
                  {
                    echo  !empty($answerExists) ? $answers[$i]['question'] : "";
                  }
              ?>
              </textarea>
              <input type="hidden" name="text_ans[{{$i}}][total_option]" value="{{$total_options}}" >
            </div>
        </div>
      </div>
      <div class="row">
        <?php
          	$azRange = range('a', 'z');
            $AZRange = range('A', 'Z');

         ?>

        @for($j=0;$j<$total_options; $j++)
          <div class="col-4 d-flex flex-wrap quiz__option_box">
            <div class="quiz-question">
                Option {{$AZRange[$j]}}:
            </div>
            <div class="quiz-question__form-control">
                <span class="textarea form-control form-control-textarea"
                    role="textbox" contenteditable
                    placeholder="Write here...">
                    {{ ($answerExists) ? $answers[$i]['option_'.$azRange[$j]] : "" }}
                </span>
                <div style="display:none">
                  <?php $option_name ="option_"; ?>
                  <textarea name="text_ans[{{$i}}][{{$option_name.$azRange[$j]}}]">
                  <?php
                      if ($answerExists)
                      {
                        echo $answers[$i]['option_'.$azRange[$j]] ;
                      }
                  ?>
                  </textarea>
                </div>
            </div>
          </div>
        @endfor
        <!-- /. Question-Option-box -->

      </div>

      <div class="quiz__answer quiz_answer_{{$i}} show">
        <div class="d-flex flex-wrap align-items-center quiz__option_box">
            <div class="quiz-question">
                Answer:
                <textarea  style="display:none" name="text_ans[{{$i}}][answer]" class="list_item_answer">{{($answerExists ) ? $answers[$i]['answer'] : ''}}</textarea>
            </div>
            <div class="quiz-question__form-control quiz-question__answer">
                <ul class="list-inline">
                  @for($k=0; $k<$total_options; $k++)
                    <li class="list-inline-item answer-option {{($answerExists && $answers[$i]['answer']==$k) ? 'active' : ''}}"  data-option="{{$k}}" ><a href="#!">{{$AZRange[$k]}}</a></li>
                  @endfor
                </ul>
            </div>

        </div>
        <!-- /. Question-Option-box -->
      </div>

      <div class="show-hide-button" style="display:none">
          <a href="#!" class="show-answer show-answer{{$i}}" data-key="{{$i}}">
              <span>
                <img src="{{ asset('public/images/icon-show-answer.svg')}}" alt="Show Answer" class="img-fluid show mr-2">
                <img src="{{ asset('public/images/icon-hide-answer.svg')}}" alt="Hide Answer" class="img-fluid hide d-none mr-2">
              </span>
              <span class="show">Show Answer</span>
              <span class="hide d-none">Hide Answer</span>
          </a>
      </div>
    </div>
  @endfor
  <!-- /. List Button Start-->
  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
  <ul class="list-inline list-buttons">
      <li class="list-inline-item"><button class=" save_btn btn btn-primary submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
      </li>
      <li class="list-inline-item"><button
              class="btn btn-primary submit_btn submitBtn_{{$practise['id']}}" data-is_save="1" data-pid="{{$practise['id']}}" >Submit</button>
      </li>
  </ul>
</form>

<script>
    $(function () {
      $('.answer-option').on('click', function() {
        $(this).parent().find('.answer-option').removeClass('active');
        $(this).addClass('active');
        var option = $(this).attr('data-option');
        $(this).parent().parent().parent().find('.list_item_answer').html(option)
      });
      $(".show-answer").click(function () {
        var key = $(this).attr("data-key");
          $(".quiz_answer_"+key).toggleClass('show');
          $(".show-answer"+key+" .show, .show-answer"+key+" .hide").toggleClass("d-none");
      });
    });

  function setTextareaContent(){
    $('.form_{{$practise["id"]}}').find("span.textarea.form-control").each(function(){
      var currentVal = $(this).html();
      $(this).next().find("textarea").val(currentVal);
    });
  }
  $('.form_{{$practise["id"]}}').on('click','.submitBtn_{{$practise["id"]}}' ,function() {
    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
      }else{
        $(this).closest('.active').find('.msg').fadeIn();
      }
    $('.submitBtn_{{$practise["id"]}}').attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);
    setTextareaContent();
    $.ajax({
        url: '<?php echo URL('save-create-quiz'); ?>',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $('.form_{{$practise["id"]}}').serialize(),
        success: function (data) {
          $('.submitBtn_{{$practise["id"]}}').removeAttr('disabled');
          if(data.success){
            $('.alert-danger').hide();
            $('.alert-success').show().html(data.message).fadeOut(8000);
          } else {
            $('.alert-success').hide();
            $('.alert-danger').show().html(data.message).fadeOut(8000);
          }
        }
    });
    return false;
  });
</script>
