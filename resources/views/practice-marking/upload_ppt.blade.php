<p>
	<strong>{{$practise['title']}}</strong>
	<?php
      $answerExists = false;
      $user_answer = "";
      if(isset($practise['user_answer']) && !empty($practise['user_answer']))
      {
            $answerExists = true;
            $user_answer = $practise['user_answer'];
            //dd($practise);
      }

	?>
</p>
<form class="save_upload_ppt_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

    <div class="record-video d-flex align-items-start mb-5">
        <b>www.</b>
        <span class="textarea form-control form-control-textarea url_textbox" role="textbox" contenteditable="" placeholder="Write here...">
            {{  $user_answer }}
        </span>
        <div style="display:none">
            <textarea name="text_ans">
               {{ $user_answer }}
            </textarea>
        </div>
    {{-- <input type="hidden" name="user_answer" value="{{ $user_answer }}"> --}}
    </div>
    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
    <!-- <ul class="list-inline list-buttons">
        <li class="list-inline-item"><button type="button" class="btn btn-secondary submitUploadPptBtn_{{$practise['id']}}"
                data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
        </li>
        <li class="list-inline-item"><button type="button"
                class="btn btn-secondary submitUploadPptBtn_{{$practise['id']}}" data-is_save="1" >Submit</button>
        </li>
    </ul> -->
  </form>


  <script>
     $(".url_textbox").keypress(
    function(event){
        if (event.which == '13') {
        event.preventDefault();
        }
    });
    function setTextareaContent(){
        $("span.textarea.form-control").each(function(){
            var currentVal = $(this).text();
            $(this).next().find("textarea").val(currentVal);
        })
    }
 
  $('.submitUploadPptBtn_{{$practise['id']}}').on('click', function(e) {
    e.preventDefault();
    $('.submitUploadPptBtn_{{$practise['id']}}').attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);
    setTextareaContent();
    $.ajax({
        url: '<?php echo URL('save-upload-ppt'); ?>',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $('.save_upload_ppt_form_{{$practise['id']}}').serialize(),
        success: function (data) {
            $('.submitUploadPptBtn_{{$practise['id']}}').removeAttr('disabled');
            if(data.success){
                $('.alert-danger').hide();
                $('.alert-success').show().html(data.message).fadeOut(4000);
            } else {
                $('.alert-success').hide();
                $('.alert-danger').show().html(data.message).fadeOut(4000);
            }
        }
    });
});
</script>
