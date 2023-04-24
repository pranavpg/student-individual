<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
//	pr($practise);
    $answerExists = false;
    if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
      $answerExists = true;
    }
    $exploded_question = explode(PHP_EOL,$practise['question']);
  //  pr($exploded_question);
?>
<form class="save_writing_at_end_option_form{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

  @if(!empty($practise['options']))
      <div class="suggestion-list d-flex flex-wrap w-50 mr-auto ml-auto mb-4 justify-content-center">
          @foreach($practise['options'] as $key => $value)
          <div class="d-inline-flex flex-grow-1 suggestion_box justify-content-center">
              {{ $value[0]}}
          </div>
          @endforeach
      </div>
  @endif

  <div class="multiple-choice">
      <!-- /. box -->
      @if( !empty($exploded_question) )
        @foreach( $exploded_question as $key => $value )
          <div class="choice-box">
              <p class="mb-0">{!! substr(str_replace(' @@', '', $value),2) !!} </p>
              <div class="form-group">
                  <span class="textarea form-control form-control-textarea"
                      role="textbox" contenteditable
                      placeholder="Write here...">
                      <?php
                        if ($answerExists)
                        {
                            echo  $practise['user_answer'][0][$key];
                        }
                      ?>
                    </span>
                    <div style="display:none">
                      <textarea name="user_answer[0][{{$key}}]">
                      <?php
                          if ($answerExists)
                          {
                            echo  $practise['user_answer'][0][$key];
                          }
                      ?>
                      </textarea>
                    </div>
              </div>
          </div>
          <!-- /. box -->
        @endforeach
      @endif
  </div>

  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
  <ul class="list-inline list-buttons">
      <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn_{{$practise['id']}}"
              data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
      </li>
      <li class="list-inline-item"><button type="button"
              class="submit_btn btn btn-primary submitBtn_{{$practise['id']}}" data-is_save="1" >Submit</button>
      </li>
  </ul>
</form>
<script>
function setTextareaContent(pid){
	$('.save_writing_at_end_option_form'+pid).find("span.textarea.form-control").each(function(){
		var currentVal = $(this).html();
		$(this).next().find("textarea").val(currentVal);
	});
}
var pid= "<?php echo $practise['id'] ?>";
$('.save_writing_at_end_option_form'+pid).on('click','.submitBtn_'+pid ,function() {

  if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }
    
	var $this = $(this);
  $this.attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.save_writing_at_end_option_form'+pid).find('.is_save:hidden').val(is_save);
  setTextareaContent(pid);
  $.ajax({
      url: '<?php echo URL('save-writing-at-end-option'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('.save_writing_at_end_option_form'+pid).serialize(),
      success: function (data) {
        $this.removeAttr('disabled');
				if(data.success){
					$('.save_writing_at_end_option_form'+pid).find('.alert-danger').hide();
					$('.save_writing_at_end_option_form'+pid).find('.alert-success').show().html(data.message).fadeOut(8000);
				} else {
					$('.save_writing_at_end_option_form'+pid).find('.alert-success').hide();
					$('.save_writing_at_end_option_form'+pid).find('.alert-danger').show().html(data.message).fadeOut(8000);
				}
      }
  });
});
</script>
