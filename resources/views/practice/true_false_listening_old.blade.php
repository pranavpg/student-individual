<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
<p style="margin-top:85px">

	<strong>{!! $practise['title'] !!}</strong>
</p>
<?php
//pr($practise);
?>
@if($practise['type'] =="true_false_listening")
	<div class="audio-player">
		<audio preload="auto" controls src="<?php echo $practise['audio_file'];?>" type="audio/mp3" id="audio_{{$practise['id']}}">
			<!-- <source > -->
		</audio>
	</div>
@endif

<?php
$question_description="";
if($practise['type'] =="true_false_listening"){
	$exploded_question  =  explode('@@', $practise['question']);
} else {
	if(str_contains($practise['question'],'I.')){
		$exp_question  =  explode('I.', $practise['question']);
		$question_description = $exp_question[0];
		$exploded_question = explode('@@', $exp_question[1]);
		$exploded_question[0]='1. '.$exploded_question[0];
	}else{
		$exploded_question  =  explode('@@', $practise['question']);
	}
}

$answerExists = false;
$userAnswer = array();
if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
	$answerExists = true;
	$userAnswer = $practise['user_answer'][0];
	foreach($userAnswer as $k=>$userAns){
		if($userAns['true_false'] == 0 && !isset($userAns['text_ans'])){
			$userAnswer[$k]['text_ans'] = '';
		}
	}
}
?>
<div class="table-container">
  <form class="true_false_listening_form">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
		@if(!empty($question_description))
		<div class="multiple-choice mb-4">
				<p>{!! nl2br($question_description) !!} </p>
		</div>
		@endif
		<div class="true-false">
			<?php
			foreach($exploded_question as $k=>$question){
				if(!empty($question)){
					$question = str_replace("@@",'',$question);
			?>
			<div class="box box-flex d-flex align-items-center">
				<div class="box__left flex-grow-1">
					<p><?php echo $question;?></p>

					<div class="form-group <?php if($answerExists && isset($userAnswer[$k]['text_ans'])){}else{?>d-none<?php }?>">
						<span class="textarea form-control form-control-textarea" role="textbox" contenteditable placeholder="Write here..."><?php if($answerExists && isset($userAnswer[$k]['text_ans'])){ echo $userAnswer[$k]['text_ans'];}?></span>
						<div style="display:none">
							<textarea name="false_why[<?php echo $k;?>]"><?php if($answerExists && isset($userAnswer[$k]['text_ans'])){ echo $userAnswer[$k]['text_ans'];}?></textarea>
							<input type="hidden" name="question[<?php echo $k;?>]" value="<?php echo $question.'@@';?>" />
						</div>
					</div>
				</div>
				<div class="true-false_buttons">
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="true_false_ticks[<?php echo $k;?>]" id="inlineRadioOptions_<?php echo $k;?>" value="true" <?php if($answerExists && $userAnswer[$k]['true_false'] == 1){?>  checked="checked"<?php }?>>
						<label class="form-check-label" for="inlineRadioOptions_<?php echo $k;?>">True</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="true_false_ticks[<?php echo $k;?>]"  id="inlineRadioOptions_<?php echo $k;?><?php echo $k;?>" value="false" <?php if($answerExists && $userAnswer[$k]['true_false'] == 0){?>  checked="checked"<?php }?>>
						<label class="form-check-label" for="inlineRadioOptions_<?php echo $k;?><?php echo $k;?>">False</label>
					</div>
				</div>
			</div>
			<!-- /. box -->
			<?php } }?>
		</div>

    <div class="alert alert-success" role="alert" style="display:none"></div>
		<div class="alert alert-danger" role="alert" style="display:none"></div>
    <input type="button" class="btnSubmits btn btn-primary" value="Save" data-is_save="0">
    <input type="button" class="btnSubmits btn btn-primary" value="Submit" data-is_save="1">
	</form>
</div>
<script type="text/javascript">
function setTextareaContent(){
	$("span.textarea.form-control").each(function(){
		var currentVal = $(this).html();
		$(this).next().find("textarea").val(currentVal);
	})
}
</script>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery(".form-check-input").change(function(){
		if(jQuery(this).prop("checked")){
			if(jQuery(this).val() == "false"){
				jQuery(this).parent().parent().parent().find(".box__left .form-group").removeClass("d-none");
			}else{
				jQuery(this).parent().parent().parent().find(".box__left .form-group").addClass("d-none");
			}
		}else{
			jQuery(this).parent().parent().parent().find(".box__left .form-group").addClass("d-none");
		}
	})
})
</script>

<script type="text/javascript">
$(document).on('click','.btnSubmits' ,function() {

	if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }

  $('.btnSubmits').attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.is_save:hidden').val(is_save);
  setTextareaContent();
  $.ajax({
      url: '<?php echo URL('true-false-listening'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('.true_false_listening_form').serialize(),
      success: function (data) {
        $('.btnSubmits').removeAttr('disabled');
		if(data.success){
			$('.alert-danger').hide();
			$('.alert-success').show().html(data.message).fadeOut(8000);
		}else{
			$('.alert-success').hide();
			$('.alert-danger').show().html(data.message).fadeOut(8000);
		}

      }
  });
});
</script>
<!-- <script src="{{ asset('public/js/audioplayer.js') }}"></script>
<script>
$(function () {
	$('audio').audioPlayer();
});
</script> -->
<script>jQuery(function ($) {
        'use strict'
        var supportsAudio = !!document.createElement('audio').canPlayType;
        if (supportsAudio) {
            // initialize plyr
            var i;

               var player = new Plyr("#audio_{{$practise['id']}}", {
                controls: [

                    'play',
                    'progress',
                    'current-time',

                ]
            });


        } else {
            // no audio support
            $('.column').addClass('hidden');
            var noSupport = $('#audio1').text();
            $('.container').append('<p class="no-support">' + noSupport + '</p>');
        }
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
