<p>
	<strong>{{$practise['title']}}</strong>
	<?php
		$exploded_question  =  explode('@@', $practise['question']);
		//	pr($practise);

		$answerExists = false;
		$answers=array();
		if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
			$answerExists = true;
			$answers = $practise['user_answer'][0]['text_ans'];
		}

	?>
</p>
<style>
.true-false .box .true-false_buttons.true-false_buttons_radio .form-check-input:checked~.form-check-label.form-check-label_true {
    background-image: url(https://s3.amazonaws.com/imperialenglish.co.uk/ieukstudentpublic/images/icon-custom-check.svg)  !important;
    background-color: #33BC77 !important;
}

.true-false .box .true-false_buttons.true-false_buttons_radio .form-check-input:checked~.form-check-label.form-check-label_false {
    background-image: url(https://s3.amazonaws.com/imperialenglish.co.uk/ieukstudentpublic/images/icon-custom-close.svg)  !important;
    background-color: #E22735 !important;
}
</style>
<form class="save_true_false_speaking_form">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

  <div class="true-false">
		@if(!empty($exploded_question))
			@foreach($exploded_question as $key => $value)
				@if(!empty($value) && !str_contains($value,'<b>'))
		      <div class="box box-flex d-flex align-items-center">
	          <div class="box__left flex-grow-1">
	              <p>{!!$value!!}</p>
	          </div>
						<?php
							$question_name =	"text_ans[$key][question]";
							$true_false_name = "text_ans[$key][true_false]";
						?>
	          <div class="true-false_buttons true-false_buttons_radio d-flex">
								<input type="hidden" name="{{$question_name}}"  value="{{ $value }}@@" >
								<div class="form-check form-check-inline">
	                  <input class="form-check-input true_option" type="radio"
	                      name="{{$true_false_name}}" id="inlineRadioTrue{{$key}}" value="1" {{ ($answerExists && $answers[$key]['true_false']==1)?"checked":""}} >
	                  <label class="form-check-label form-check-label_true" for="inlineRadioTrue{{$key}}"></label>
	              </div>
	              <div class="form-check form-check-inline">
	                  <input class="form-check-input false_option" type="radio"
	                      name="{{$true_false_name}}" id="inlineRadioFalse{{$key}}" value="0" {{ ($answerExists && $answers[$key]['true_false']==0)?"checked":""}} >
	                  <label class="form-check-label form-check-label_false" for="inlineRadioFalse{{$key}}"></label>
	              </div>
	          </div>
	      	</div>
				@else
				<p>{!!$value!!}</p>
				@endif
			@endforeach
		@endif

		@include('practice.common.audio_record_div', ['key'=>0])
		<input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="true_false_speaking_up_simple" value="0">
  </div>


	<div class="alert alert-success" role="alert" style="display:none"></div>
	<div class="alert alert-danger" role="alert" style="display:none"></div>
	<ul class="list-inline list-buttons">
	    <li class="list-inline-item"><button class="save_btn btn btn-primary submitBtn"
	            data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
	    </li>
	    <li class="list-inline-item"><button
	            class="submit_btn btn btn-primary submitBtn" data-is_save="1" >Submit</button>
	    </li>
	</ul>
</form>
<script type="text/javascript">
$('.false_option').on('click', function(){
	$(this).parent().parent().parent().find('.textarea').show()
})
$('.true_option').on('click', function(){
	$(this).parent().parent().parent().find('.textarea').hide()
})
function setTextareaContent(){
	$("span.textarea.form-control").each(function(){
		var currentVal = $(this).html();
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
$(document).on('click','.submitBtn' ,function() {

  $('.submitBtn').attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.is_save:hidden').val(is_save);
  setTextareaContent();
  $.ajax({
      url: '<?php echo URL('save-true-false-speaking'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('.save_true_false_speaking_form').serialize(),
      success: function (data) {
        $('.submitBtn').removeAttr('disabled');
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
