

<p>
	<strong>{{$practise['title']}}</strong>
</p>
<?php
// dd($practise);
$answerExists = false;
if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
	$answerExists = true;
}
?>


		@if($practise['type'] == "true_false_simple_left_align_listening")
				@include('practice.common.audio_player')
		@endif

    <form class="save_true_false_speaking_form">
      <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
      <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
      <input type="hidden" class="is_save" name="is_save" value="">
			<input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
			<input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
			<?php
				$exploded_question  =  explode('@@', $practise['question']);
					//pr($exploded_question);

				$answerExists = false;
			 	if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
					 $answerExists = true;

						if($practise['type'] == "true_false_simple_left_align_listening")
							$answers = $practise['user_answer'][0];
						else
					 		$answers = $practise['user_answer'][0]['text_ans'];
			 	}
			?>
			@if($practise['type'] == "true_false_speaking_up")
					@include('practice.common.audio_record_div',['key'=>0])
			@endif
		
		<!--======== html change 10-1-21 ========-->
			<div class="true-false">
					@if(!empty($exploded_question))
						@foreach($exploded_question as $key => $value)
							@if(!empty($value))
								<div class="box ieuktf-outerbox">
										@if($practise['type']!="true_false_simple_left_align_listening")
											<div class="ieuktf-dis"><p>{{$value }}</p></div>
										@endif
										<div class="true-false_buttons ieuktf-btnbox">
												<input type="hidden" name="text_ans[{{$key}}][question]"  value="{{ $value }}@@" >
												<input type="hidden" name="text_ans[{{$key}}][true_false]" value="-1">
												<div class="form-check form-check-inline">
														
														<input class="form-check-input" type="radio" name="text_ans[{{$key}}][true_false]" id="inlineRadioTrue{{$key}}" value="1" {{ ($answerExists && $answers[$key]['true_false']==1)?"checked":""}} >
														<label class="form-check-label" for="inlineRadioTrue{{$key}}">True</label>
												</div>
												<div class="form-check form-check-inline">
														<input class="form-check-input" type="radio" name="text_ans[{{$key}}][true_false]" id="inlineRadioFalse{{$key}}" value="0" {{ ($answerExists && $answers[$key]['true_false']==0)?"checked":""}}>
														<label class="form-check-label" for="inlineRadioFalse{{$key}}">False</label>
												</div>

										</div>
								</div>
							@endif
						@endforeach
					@endif
		<!--======== html change 10-1-21 ========-->
					<!-- /. box -->

			</div>
			<input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="audio[0][audio_deleted]" value="0">
			@if($practise['type'] == "true_false_speaking_simple")
					@include('practice.common.audio_record_div',['key'=>0])
			@endif

			<div class="alert alert-success" role="alert" style="display:none"></div>
			<div class="alert alert-danger" role="alert" style="display:none"></div>
			<!-- <ul class="list-inline list-buttons">
			    <li class="list-inline-item"><button class="btn btn-secondary submitBtn"
			            data-toggle="modal" data-is_save="0" data-target="#exitmodal">Save</button>
			    </li>
			    <li class="list-inline-item"><button
			            class="btn btn-secondary submitBtn" data-is_save="1">Submit</button>
			    </li>
			</ul> -->

    </form>
@if($practise['type'] == "speaking_writing")
    @include('practice.common.audio_record_div')
@endif

@if($practise['type'] == "true_false_simple_left_align_listening")
<script>jQuery(function ($) {
	'use strict'
	var supportsAudio = !!document.createElement('audio').canPlayType;
	if (supportsAudio) {
			// initialize plyr
			var i;

				 var player = new Plyr('audio', {
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
@endif

<script type="text/javascript">
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
						$('.alert-success').show().html(data.message).fadeOut(4000);
					} else {
						$('.alert-success').hide();
						$('.alert-danger').show().html(data.message).fadeOut(4000);
					}
	      }
	  });
	});
	var token = $('meta[name=csrf-token]').attr('content');
	var upload_url = "{{url('upload-audio')}}";
	var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
	$('.delete-icon').on('click', function() {
			$(this).parent().find('.stop-button').hide();
	    $(this).parent().find('.practice_audio').attr('src','');
	    $(this).parent().find('.audioplayer-bar-played').css('width','0%');
	    $(this).hide();
	    $(this).parent().find('div.audio-element').css('pointer-events','none');
	    $(this).parent().find('.record-icon').show();
	    $(this).parent().find('.stop-button').hide();
	    var practise_id = $('.practise_id:hidden').val();
    	$.ajax({
	      url: '<?php echo URL('delete-audio'); ?>',
	      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	      type: 'POST',
	      data: {practice_id:practise_id},
	      success: function (data) {

	      }
	  });
	//	$('.audio-element').html('').append('<div class="audio-player d-flex flex-wrap justify-content-end"><audio preload="auto" controls class="practice_audio"> <source src="{{asset("public/horse.mp3")}}" type="audio/mp3"> </audio></div>');
	});
</script>
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
