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
    <!-- Component - Form Control-->
    <div class="form-group">
      <span class="textarea form-control form-control-textarea stringProper text-left enter_disable" role="textbox" contenteditable placeholder="Write here..."><?php if ($answerExists) { echo  $answers['text_ans'][0]; }?></span>
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
    <!-- /. Component - Form Control End-->
        @include('practice.common.audio_record_div',['key'=>0])

    <p>Write or paste your url below:</p>

    <!-- /. Componetnt - Record Video -->
    <div class="record-video d-flex align-items-end mb-5">
      <strong style="padding-bottom:0px !important">www.</strong>
      <span  class="textarea  ml-2 form-control form-control-textarea stringProper text-left enter_disable allowpast" role="textbox" contenteditable placeholder="Write here..."><?php
            if ($answerExists)
            {
                echo  $answers['text_ans'][1];
            }
          ?></span>
      <div style="display:none">
        <textarea name="text_ans[1]">
        <?php
            if ($answerExists)
            {
                echo  $answers['text_ans'][1];
            }
        ?>
        </textarea>
      </div>
    </div>
    <!-- /. Componetnt - Record Video End-->
</div>

	<div class="alert alert-success" role="alert" style="display:none"></div>
	<div class="alert alert-danger" role="alert" style="display:none"></div>
	<ul class="list-inline list-buttons">
	    <li class="list-inline-item"><button class="save_btn btn btn-primary submitBtn_{{$practise['id']}}"
	            data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
	    </li>
	    <li class="list-inline-item"><button
	            class="submit_btn btn btn-primary submitBtn_{{$practise['id']}}" data-is_save="1" >Submit</button>
	    </li>
	</ul>
</form>
<script type="text/javascript">
// $(document).keypress(
//   function(event){
//     if (event.which == '13') {
//       event.preventDefault();
//     }
// });
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
    // currentVal= currentVal.replace('www.',' ');
		$(this).next().find("textarea").val(currentVal);
	})
}
$(document).on('click','.submitBtn_{{$practise["id"]}}' ,function(e) {

    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }

                  
e.preventDefault();
  $('.submitBtn_{{$practise["id"]}}').attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.is_save:hidden').val(is_save);
  setTextareaContent();
  $.ajax({
      url: '<?php echo URL('save-writing-speaking-multi-video-record'); ?>',
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

var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";

</script>
<script>
$(document).ready(function(){
if("{{$practise['id']}}" =="15518162425c7ed632532da"){
  $('.allowpast').on("cut copy paste",function(e) {
    $(".allowpast").removeAttr("onpaste");
 });
}
});
</script>