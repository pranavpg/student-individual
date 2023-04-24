<p>
	<strong>{{$practise['title']}}</strong>
</p>
<?php
    $answerExists = false;
    if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
      $answerExists = true;
      $answers = $practise['user_answer'][0];
    }
    $exploded_question  =  explode('- ', $practise['question']);
?>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  <div class="multiple-choice">
    <ul class="list-unstyled simple-list">
      @if(!empty($exploded_question))
        @foreach($exploded_question as $key => $value)
        <?php $val = str_replace('<br>','',$value); ?>
          @if(!empty(trim( $val )))
            <li class="list-item">- {!! str_replace('Notes : @@', '', $val) !!}</li>
          @endif
        @endforeach
      @endif
    </ul>
    <p>Notes:</p>
    <div class="form-group">
      <span class="textarea form-control form-control-textarea stringProper enter_disable" role="textbox" disabled contenteditable placeholder="Write here..."><?php if ($answerExists) { echo  $answers['text_ans'][0]; }?></span>
      <div style="display:none">
        <textarea name="text_ans[0]"><?php
            if ($answerExists)
            {
                echo  $answers['text_ans'][0];
            }
        ?>
        </textarea>
      </div>
    </div>
        @include('practice.common.audio_record_div',['key'=>0])
    <p>Write or paste your url below:</p>
    <div class="record-video d-flex align-items-end mb-5">
      <strong style="padding-bottom:0px !important">www.</strong>
      <span  class="textarea  ml-2 form-control form-control-textarea stringProper enter_disable allowpast"  role="textbox" disabled contenteditable placeholder="Write here..."><?php
            if ($answerExists) { echo  $answers['text_ans'][1]; }
          ?></span>
          <div style="display:none">
            <textarea name="text_ans[1]">
            <?php
                if ($answerExists) {
                    echo  $answers['text_ans'][1];
                }
            ?>
            </textarea>
          </div>
    </div>
</div>

	<div class="alert alert-success" role="alert" style="display:none"></div>
	<div class="alert alert-danger" role="alert" style="display:none"></div>
	<ul class="list-inline list-buttons">
	    <li class="list-inline-item"><button class="btn btn-secondary submitBtn_{{$practise['id']}}"
	            data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
	    </li>
	    <li class="list-inline-item"><button
	            class="btn btn-secondary submitBtn_{{$practise['id']}}" data-is_save="1" >Submit</button>
	    </li>
	</ul>
</form>
<script type="text/javascript">
function setTextareaContent(){
	$("span.textarea.form-control").each(function(){
		var currentVal = $(this).text();
    currentVal= currentVal.replace('&nbsp;',' ');
    currentVal= currentVal.replace('nbsp;',' ');
    currentVal= currentVal.replace('&amp;',' ');
    currentVal= currentVal.replace('amp;',' ');
    currentVal= currentVal.replace('</div>','');
    currentVal= currentVal.replace('<div>','<br>');
    currentVal= currentVal.replace('</div>','');
		$(this).next().find("textarea").val(currentVal);
	})
}
var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
$(document).ready(function(){
  if("{{$practise['id']}}" =="15518162425c7ed632532da"){
      $(".allowpast").removeAttr("contenteditable");
  }
});
</script>