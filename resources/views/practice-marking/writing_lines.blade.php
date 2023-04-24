<p>
	<strong>{!! $practise['title'] !!}</strong>
	<?php
        $answerExists = false;
        if(isset($practise['user_answer']) && !empty($practise['user_answer'])) {
            $answerExists = true;
            $user_answer = $practise['user_answer'][0];
        }
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
                <span class="textarea form-control form-control-textarea stringProper" role="textbox" disabled contenteditable="" placeholder="Write here...">{{ (isset($practise['user_answer']) && $answerExists == true) ?  nl2br($user_answer[$key]) : "" }}</span>
                <input type="hidden" name="user_answer[{{$key}}]" value="{{ (isset($practise['user_answer']) && $answerExists == true) ?  $user_answer[$key] : "" }}">
            </div>
        <?php $k++; ?>
       @endforeach
    </div>
    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
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
})
</script>
