<p>
	<strong>{!! $practise['title'] !!}</strong>
	<?php
      $answerExists = false;
      if(isset($practise['user_answer']) && !empty($practise['user_answer']))
      {
            $answerExists = true;
            $user_answer = $practise['user_answer'][0];
      }
      //dd($user_answer);
      $exploded_question = $practise['question'];
	?>
</p>
<form class="writing_lines_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

    <div class="multiple-choice">
        <?php $k=1; ?>
       @foreach ($exploded_question as $key=>$item)
        @php $item = str_replace("@@", "", $item); @endphp
            <div class="form-group d-flex align-items-start form-group-label focus">
                <span class="label">{{$k}}</span>
                <span class="textarea form-control form-control-textarea stringProper text-left" role="textbox" contenteditable="" placeholder="Write here...">{{ (isset($practise['user_answer']) && $answerExists == true) ?  nl2br($user_answer[$key]) : "" }}</span>
                <input type="hidden" name="user_answer[{{$key}}]" value="{{ (isset($practise['user_answer']) && $answerExists == true) ?  $user_answer[$key] : "" }}">
            </div>
        <?php $k++; ?>
       @endforeach
    </div>
    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
    <ul class="list-inline list-buttons">
        <li class="list-inline-item">
            <button type="button" class="save_btn btn btn-primary submitWritingLinesBtn_{{$practise['id']}}" data-is_save="0">Save</button>
        </li>
        <li class="list-inline-item">
            <button type="button" class="submit_btn btn btn-primary submitWritingLinesBtn_{{$practise['id']}}" data-is_save="1" >Submit</button>
        </li>
    </ul>
  </form>


  <script>
$(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
$(document).ready(function(){
    function setTextareaContents(){
        $("span.textarea.form-control").each(function(){
            var currentVal = $(this).html();
            $(this).next("input:hidden").val(currentVal);
        })
    }

    $('.submitWritingLinesBtn_{{$practise['id']}}').on('click', function(e) {
    e.preventDefault();
    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);
    setTextareaContents();

    $('.submitWritingLinesBtn_{{$practise['id']}}').attr('disabled','disabled');
        $.ajax({
            url: '<?php echo URL('save-writing-lines'); ?>',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: $('.writing_lines_form_{{$practise['id']}}').serialize(),
            success: function (data) {
                $('.submitWritingLinesBtn_{{$practise['id']}}').removeAttr('disabled');
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

})
</script>
