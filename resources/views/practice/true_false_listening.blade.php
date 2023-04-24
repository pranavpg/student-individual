<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
<p style="margin-top:85px">
	<strong>{!! $practise['title'] !!}</strong>
</p>



<?php
$question_description="";

if($practise['type'] =="true_false_listening"){
    $exploded_question  =  explode('@@', $practise['question']);

}
elseif($practise['type'] === "true_false"){
    $exploded_question  = array();
    $final_questions = array();
    if(str_contains($practise['question'],'#@')){
        $question  =  explode('#@', $practise['question']);
        if(isset($question[0]) && str_contains($question[0],'@@')){
            $option= explode('@@', $question[0]);
            $option1 =$option[0];
            $option2 =$option[1];
            $exploded_question  =  explode(PHP_EOL, $question[1]);
        }else{
            $exploded_question=[];
        }
    }else{
        $exploded_question  =  explode(PHP_EOL, $practise['question']);
        $option1 ='True';
        $option2 ='False';
    }
    
    $int = 0;
    foreach ($exploded_question as $key => $value) {
        if(!empty($value) && $value !== "")
        {
            $value = str_replace("I. ", "1. ", $value);
            $final_questions[$int] = $value;
            $int++;
        }
    }
}
else {
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
$true_false = array();

if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
	$answerExists = true;
    $userAnswer = $practise['user_answer'][0];
    //dd($userAnswer);
    foreach($userAnswer as $k=>$userAns)
    {
		if($userAns['true_false'] == 0 && !isset($userAns['text_ans'])){
			$userAnswer[$k]['text_ans'] = '';
        }
    }
}
//dd($exploded_question);
//dd($true_false);
//dd($userAnswer);

?>
<div class="table-container">
  <form class="true_false_listening_form_{{$practise['id']}}">

    @if($practise['type'] =="true_false_listening")
        <div class="audio-player">
            <audio preload="auto" controls src="<?php echo $practise['audio_file'];?>" type="audio/mp3" id="audio_{{$practise['id']}}">
                <!-- <source > -->
            </audio>
        </div>
    @endif


    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

    @if($practise['type'] !== 'true_false')

		@if(!empty($question_description))
            <div class="multiple-choice mb-4">
                <p>{!! nl2br( $question_description) !!} </p>
            </div>
		@endif
		<div class="true-false">
			<?php
            foreach($exploded_question as $k=>$question)
            {

                if(!empty($question) && $question !== "")
                {
					$question = str_replace("@@",'',$question);
			?>
			<div class="box box-flex align-items-center ieuktf-outerbox">

				<div class="box__left flex-grow-1">
					<p><?php echo $question;?></p>
					<div class="form-group <?php echo ($answerExists == true && isset($userAnswer[$k]['text_ans']) && !empty($userAnswer[$k]['text_ans'])) ? '' : 'd-none' ?>">
						<span class="textarea form-control form-control-textarea" role="textbox" contenteditable placeholder="Write here..."><?php if($answerExists && isset($userAnswer[$k]['text_ans'])){ echo $userAnswer[$k]['text_ans'];}?></span>
						<div style="display:none">
							<textarea name="false_why[<?php echo $k;?>]"><?php if($answerExists && isset($userAnswer[$k]['text_ans']) && !empty($userAnswer[$k]['text_ans']) ){ echo $userAnswer[$k]['text_ans'];}?></textarea>
							<input type="hidden" name="question[<?php echo $k;?>]" value="<?php echo $question.'@@';?>" />
						</div>
					</div>
                </div>

                 <div class="true-false_buttons ieuktf-btnbox mt-2">
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
    @endif

    @if($practise['type'] === 'true_false')
        <div class="true-false">
            @foreach($final_questions as $k=>$question)

                <?php if(strpos($question, " @@") !== false)
                    {
                        $replace_class = 'subscription-price';
                    }
                    else
                    {
                        $replace_class = '';
                    }
                ?>
                <?php if($question !== "" && !empty($question)): ?>
                        <div class="box align-items-center ieuktf-outerbox">
                            <div class="box__left flex-grow-1">
                                <?php echo "<p class='".$replace_class."'>".$question.'</p>'; ?>
                                    <div class="form-group d-none">
                                        <span class="textarea form-control form-control-textarea" role="textbox" contenteditable placeholder="Write here..."></span>
                                        <div style="display:none">
                                            <textarea name="false_why[<?php echo $k;?>]">-1</textarea>
                                        <input type="hidden" name="question[<?php echo $k;?>]" value="{!! $question !!}" />
                                        </div>
                                    </div>
                            </div>
                            <?php if(strpos($question, " @@") !== false): ?>
                                <div class="true-false_buttons ieuktf-btnbox w-auto mt-1">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="true_false_ticks[<?php echo $k;?>]" id="inlineRadioOptions_<?php echo $k;?>" value="true" <?php if(isset($userAnswer[$k]['true_false']) && $answerExists && $userAnswer[$k]['true_false'] == 1){?>  checked="checked"<?php }?>>
                                        <label class="form-check-label" for="inlineRadioOptions_<?php echo $k;?>">{!!$option1!!}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="true_false_ticks[<?php echo $k;?>]"  id="inlineRadioOptions_<?php echo $k;?><?php echo $k;?>" value="false" <?php if(isset($userAnswer[$k]['true_false']) && $answerExists && $userAnswer[$k]['true_false'] == 0){?>  checked="checked"<?php }?>>
                                        <label class="form-check-label" for="inlineRadioOptions_<?php echo $k;?><?php echo $k;?>">{!!$option2!!}</label>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
                <?php endif;?>
            @endforeach
        </div>
    @endif
    <div class="alert alert-success" role="alert" style="display:none"></div>
	<div class="alert alert-danger" role="alert" style="display:none"></div>
    <input type="button" class="btnSubmits btn btn-primary" value="Save" data-is_save="0">
    <input type="button" class="btnSubmits btn btn-primary" value="Submit" data-is_save="1">
  </form>
 	@if(isset($practise["markingmethod"]) && $practise["markingmethod"] == "student_self_marking")

		@include('practice.common.student_self_marking')

	@endif
	@php
		$lastPractice=end($practises);
	@endphp
	@if($lastPractice['id'] == $practise['id'])
		@include('practice.common.review-popup')
		@php
			$reviewPopup=true;
		@endphp
	@else
		@php
			$reviewPopup=false;
		@endphp
	@endif
</div>
<script type="text/javascript">
function setTextareaContent(){
	$("span.textarea.form-control").each(function(){
		var currentVal = $(this).html();
		$(this).next().find("textarea").val(currentVal);
	})
}
</script>
<?php if($practise['type'] === 'true_false'): ?>
    <script type="text/javascript">
        jQuery(document).ready(function(){

            $('.subscription-price').each(function(i){
                var text = $(this).html();
                $(this).html(text.replace(" @@", ""));
            })


            jQuery(".form-check-input").change(function(){
                if(jQuery(this).prop("checked")){
                    if(jQuery(this).val() == "false"){
                        //jQuery(this).parent().parent().parent().find(".box__left .form-group").removeClass("d-none");
                    }else{
                        //jQuery(this).parent().parent().parent().find(".box__left .form-group").addClass("d-none");
                    }
                }else{
                    //jQuery(this).parent().parent().parent().find(".box__left .form-group").addClass("d-none");
                }
            })
        })
    </script>
<?php else: ?>

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

<?php endif; ?>


<script type="text/javascript">
$(document).on('click','.btnSubmits' ,function() {

      if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }

            
    var reviewPopup = '{!!$reviewPopup!!}';
    var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
    if(markingmethod =="student_self_marking"){
        if($(this).attr('data-is_save') == '1'){
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
            var fullView= $(".true_false_listening_form_{{$practise['id']}}").clone();
			$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
			$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
			$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
			$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.btnSubmits').remove();
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.textarea').attr("contenteditable","false");
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.form-check-inline').css("pointer-events","none");
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.subscription-price').css("width","auto")
        }
    }
    if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){

        $("#reviewModal_{{$practise['id']}}").modal('toggle');

    }
  $('.btnSubmits').attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.is_save:hidden').val(is_save);
  setTextareaContent();
  $.ajax({
      url: '<?php echo URL('true-false-listening'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('.true_false_listening_form_{{$practise["id"]}}').serialize(),
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
