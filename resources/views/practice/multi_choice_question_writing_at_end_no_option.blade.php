<p><strong>{!!$practise['title']!!}</strong></p>
<?php
  $exp_question = explode(PHP_EOL, $practise['question']);
 // pr($practise);
 $answerExists = false;
 if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
   $answerExists = true;

 }
?>
<!-- Compoent - Two click slider-->
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_type" name="practise_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  <input type="hidden" class="total_que" name="total_que" value="{{count($exp_question)}}">
  <div class="multiple-choice multiple-choice_withoutBefore multiple-check">
    <?php

    ?>
    @if(!empty($exp_question))
      @foreach($exp_question as $key => $value)
        @if(!str_contains($value,'@@'))
          <div class="choice-box">
              <p>{{str_replace('@@','',$value)}}</p>
              <div class="d-flex"> 
                  @foreach($practise['options'][$key] as $k=>$v)
                    @if(isset($practise['user_answer']))
                    <div class="custom-control custom-radio w-25">
                        <input type="radio" class="custom-control-input" id="cc{{$key}}{{$k}}" name="user_answer[{{$key}}]" value="{{$k.'@@'.$v}}" {{$practise['user_answer'][0][$key]['ans_pos'] == $k ?  'checked' :  " " }}>
                        <label class="custom-control-label" for="cc{{$key}}{{$k}}">{{$v}}</label>
                    </div>
                    @else
                      <div class="custom-control custom-radio w-25">
                        <input type="radio" class="custom-control-input" id="cc{{$key}}{{$k}}" name="user_answer[{{$key}}]" value="{{$k.'@@'.$v}}" >
                        <label class="custom-control-label" for="cc{{$key}}{{$k}}">{{$v}}</label>
                     </div>

                    @endif
                  @endforeach 
              </div>
              <input type="hidden" name="text_ans" value="">
          </div>
        @else
          <div class="choice-box">
              <p class="mb-0">{{str_replace('@@','',$value)}}</p>
              <div class="form-group"> 
                <span class="textarea form-control form-control-textarea stringProper text-left" role="textbox"contenteditable placeholder="Write here...">@if($answerExists){{trim($practise['user_answer'][0][$key]['text_ans'])}}@endif</span>
                <div style="display:none">
                  <textarea  name="user_answer[{{$key}}]" >
                  <?php
                      if ($answerExists)
                      {
                        echo trim($practise['user_answer'][0][$key]['text_ans']);
                      }
                  ?>
                  </textarea>
                  <input type="hidden" name="ans" value="">
                </div>
              </div>
          </div>
        @endif
      @endforeach
    @endif
      <!-- /. Choice Box -->


      <!-- /. Choice Box -->


  </div>


  <div class="alert alert-success" role="alert" style="display:none"></div>
	<div class="alert alert-danger" role="alert" style="display:none"></div>
	<ul class="list-inline list-buttons">
			<li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"
							data-toggle="modal" data-is_save="0" data-target="#exitmodal">Save</button>
			</li>
			<li class="list-inline-item"><button type="button"
							class="submit_btn btn btn-primary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1">Submit</button>
			</li>
	</ul>
</form>
<script>
  $(document).ready(function(){
       $("#cover-spin").hide();
  });
</script>
<script>

$(document).on('click','.submitBtn_{{$practise["id"]}}' ,function() {

    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }

              
  $('.submitBtn').attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.is_save:hidden').val(is_save);
  $('.form_{{$practise["id"]}}').find("span.textarea.form-control").each(function(){
		var currentVal = $(this).html();
 
    if(currentVal==""){
      $(this).next().find("textarea").val("no");
    }else{
      $(this).next().find("textarea").val(currentVal);

    }
	});
  $.ajax({
      url: '<?php echo URL('save-multi-choice-question-multiple-writing-at-end-no-option'); ?>',
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
});
</script>
