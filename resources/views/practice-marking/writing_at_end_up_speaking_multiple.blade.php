<p>
	<strong><?php 	echo $practise['title']; ?></strong>
</p>
<form class="form_{{$practise['id']}}">
	<input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
	<input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
	<input type="hidden" class="is_save" name="is_save" value="">
	<input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
	<input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  	<?php
	  	$answerExists = false;
		$exploded_question  = array();
		if(!empty($practise['question'])){
			$exploded_question  =  explode('@@', $practise['question']);
		}
		if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
			$answerExists = true;
		}
		if( $practise['type']=="writing_at_end_up_speaking_multiple" ){
			$first_div_class = "multiple-choice";
			$div_span = "form-group mb-0";
		} elseif($practise['type']=="writing_at_end_up_speaking_multiple_up") {
			$first_div_class = "";
			$div_span = "form-group d-flex align-items-start form-group-label mb-5";
		}
  	?>
	<div class="{{$first_div_class}}">
		@if(!empty($exploded_question))
			@foreach($exploded_question as $key => $value)
				@if(!empty($value))
					@if($practise['type']=="writing_at_end_up_speaking_multiple" )
						<p class="mb-0">{{$value}}</p>
					@endif
					@if($practise['type']=="writing_at_end_up_speaking_multiple_up" )
						@include('practice.common.audio_record_div')
					@endif
						<div class="{{$div_span}}">
							@if($practise['type']=="writing_at_end_up_speaking_multiple_up" )
							  <span class="label">{{trim($value)}}</span>
							@endif
							<span class="textarea form-control form-control-textarea stringProper" role="textbox" disabled contenteditable placeholder="Write here..."><?php if ($answerExists){echo  $practise['user_answer'][$key]['text_ans'];}?></span>
								<div style="display:none">
									<textarea name="text_ans[{{$key}}][text_ans]" disabled="true">
										<?php
											if ($answerExists) {
												echo  $practise['user_answer'][$key]['text_ans'];
											}
										?>
									</textarea>
								</div>
								<input type="hidden" name="text_ans[{{$key}}][path]" class="audio_path{{$key}}" value="{{!empty($practise['user_answer'][$key]['path'])?$practise['user_answer'][$key]['path']:''}}">
								<input type="hidden" name="text_ans[{{$key}}][audio_exists]" value="{{ !empty($practise['user_answer'][$key]['path'])?1:0}}">
								<input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$key}}" name="text_ans[{{$key}}][audio_deleted]" value="0">
						</div>
						@if($practise['type']=="writing_at_end_up_speaking_multiple" )
							@include('practice.common.audio_record_div')
						@endif
				@endif
			@endforeach
		@endif
	</div>
	<div class="alert alert-success" role="alert" style="display:none"></div>
	<div class="alert alert-danger" role="alert" style="display:none"></div>
</form>
<script type="text/javascript">
$(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
function setTextareaContent(pid){
	$('.form_'+pid).find("span.textarea.form-control").each(function(){
		var currentVal = $(this).text();
		$(this).next().find("textarea").val(currentVal);
	});
}
var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
</script>
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
