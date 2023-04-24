<p>
	<strong><?php 	echo $practise['title']; ?></strong>
</p>
<?php
   //pr($practise);
  $exp_question = explode(PHP_EOL, $practise['question']);
  //pr($exp_question);
	  $answerExists = false;

		if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
			$answerExists = true;
		}
?>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
	<input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

  <div class="multiple-choice">
  	 <?php $answer_count=0; ?>
      @if(!empty($exp_question))
        @foreach($exp_question as $key=> $value)
          <p class="mb-3">{{$value}}</p>
          @include('practice.common.audio_record_div',['q'=> $key])
          			 <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$key}}" name="speaking_multiple_single_writing_{{$key}}" value="0">
					<input type="hidden" name="text_ans[{{$key}}][path]" class="audio_path{{$key}}" value="{{!empty($practise['user_answer'][$key]['path'])?$practise['user_answer'][$key]['path']:''}}">
					<input type="hidden" name="text_ans[{{$key}}][audio_exists]" value="{{ !empty($practise['user_answer'][$key]['path'])?1:0}}">
					@if( $key > 0)
						<input type="hidden" name="text_ans[{{$key}}][text_ans]" value="" >
					@endif
					 <?php //$answer_count++; ?>
        @endforeach
      @endif


      <!--Component Form Slider-->
      <div class="form-slider p-0 mb-4">
        <div class="component-control-box">
          <span class="textarea form-control form-control-textarea" role="textbox"
							contenteditable placeholder="Write here...">
							<?php
								if ($answerExists)
								{
										echo  $practise['user_answer'][0]['text_ans'][0];
								}
							?>
					</span>
					<div style="display:none">
						<textarea name="text_ans[0][text_ans][0]">
						<?php
								if ($answerExists)
								{
									echo  $practise['user_answer'][0]['text_ans'][0];
								}
						?>
						</textarea>

					</div>
        </div>
      </div>
  </div>
</form>
<script type="text/javascript">
function setTextareaContent(){
	$('.form_{{$practise["id"]}}').find("span.textarea.form-control").each(function(){
		var currentVal = $(this).html();
		$(this).next().find("textarea").val(currentVal);
	});
}
function Audioplay(pid,inc,flagForAudio){
	var supportsAudio = !!document.createElement('audio').canPlayType;
	if (supportsAudio) {
		var i;
		var player = new Plyr(".modal .answer_audio-{{$practise['id']}}-"+inc, {
			controls: [
				'play',
				'progress',
				'current-time'
			]
		}); 
	}
}
var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
</script>
