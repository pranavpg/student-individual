<p>
	<strong><?php 	echo $practise['title']; ?></strong>
</p>
<?php
//pr($practise);
  $answerExists = false;

  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
  }

?>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
	<input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

  @if(!empty($practise['question_2']))
    <div class="suggestion-list d-flex flex-wrap w-75 mr-auto ml-auto mb-4 justify-content-center">
        @foreach($practise['question_2'] as $key => $value)
        <div class="d-inline-flex flex-grow-1 suggestion_box justify-content-center">
            {{ $value}}
        </div>
        @endforeach
    </div>
  @endif
  @if(!empty($practise['question']))
    <div class="image-box__writting w-75 mr-auto ml-auto row">
      @foreach($practise['question'] as $k => $v)
        <div class="col-4 writting mb-4 pl-0">
            <picture class="picture mb-3" >
                <img src="{{$v}}" alt="" class="img-fluid">
            </picture>
            <!-- Component - Form Control-->
            <div class="form-group">
              <span class="textarea form-control form-control-textarea main-answer" role="textbox" contenteditable placeholder="Write here...">
                <?php
                  if ($answerExists)
                  {
                      echo  !empty($practise['user_answer'][$k][0])?$practise['user_answer'][$k][0]:"";
                  }
                ?>
              </span>
              <div style="display:none">

                <textarea name="user_answer[{{$k}}][0]" class="main-answer-input">
                <?php
                    if ($answerExists)
                    {
                      echo  !empty($practise['user_answer'][$k][0])?$practise['user_answer'][$k][0]:"";
                    }
                ?>
                </textarea>
              </div>
            </div>
            <!-- /. Component - Form Control End-->
        </div>
      @endforeach
        <!-- /. Writting-->
    </div>
  @endif


  <!-- /. List Button Start-->
  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
  <ul class="list-inline list-buttons">
      <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"
              data-toggle="modal" data-is_save="0" data-target="#exitmodal"  >Save</button>
      </li>
      <li class="list-inline-item"><button type="button"
              class="submit_btn btn btn-primary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1" >Submit</button>
      </li>
  </ul>
</form>
<script>

$(document).on('click','.submitBtn_{{$practise["id"]}}' ,function() {
  var pid= $(this).attr('data-pid');
  if($(this).attr('data-is_save') == '1'){
      $(this).closest('.active').find('.msg').fadeOut();
  }else{
      $(this).closest('.active').find('.msg').fadeIn();
  }
	var $this = $(this);
  $this.attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.form_{{$practise["id"]}}').find('.is_save:hidden').val(is_save);
  $('.form_{{$practise["id"]}}').find("span.textarea.form-control").each(function(){
		var currentVal = $(this).html();
		$(this).next().find("textarea").val(currentVal);
	});

  $.ajax({
      url: '<?php echo URL('save-multi-image-option'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('.form_{{$practise["id"]}}').serialize(),
      success: function (data) {
        $this.removeAttr('disabled');
				if(data.success){
					$('.form_{{$practise["id"]}}').find('.alert-danger').hide();
					$('.form_{{$practise["id"]}}').find('.alert-success').show().html(data.message).fadeOut(8000);
				} else {
					$('.form_{{$practise["id"]}}').find('.alert-success').hide();
					$('.form_{{$practise["id"]}}').find('.alert-danger').show().html(data.message).fadeOut(8000);
				}
      }
  });
});
</script>
