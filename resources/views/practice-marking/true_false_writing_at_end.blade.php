<p>
	<strong>{!!$practise['title']!!}</strong>
	<?php
		if($practise['type']=='true_false_writing_at_end' && isset($practise['is_roleplay']) ){
			$rolplayexercise  =  explode('##', $practise['question']);
			$tabs  =  explode('@@', $rolplayexercise[0]);
		}elseif($practise['type']=='true_false_writing_at_end_simple' || $practise['type']=='true_false_writing_at_end'){
			$true="True";
			$false="False";
			if(isset($practise['question']) && str_contains($practise['question'],'#@')){
				$option= explode('#@',$practise['question']);
				
				$trueFalse= explode('@@',$option[0]);
				$practise['question']=$option[1];
				$true=$trueFalse[0];
				$false=$trueFalse[1];
			}
				$exploded_question  =  explode('@@', $practise['question']);
		}else{
			$exploded_question = explode('@@',$practise['question']);
		}
		$answerExists = false;
		$answers=array();
		if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
			$answerExists = true;
			if($practise['type'] == "true_false_speaking_writing_simple" ){

				$answers = $practise['user_answer'][0]['text_ans'][0];
			} else {
				$answers = $practise['user_answer'];
			}
		}
		
	?>
</p>
<form class="save_true_false_speaking_form_{{$practise['id']}}"  id="reading-no-blanks_form-<?php echo $practise['id'];?>">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
	@if($practise['type']=='true_false_writing_at_end' )
		@include('practice.true_false_writing_at_end_with_simple')
	@elseif($practise['type']=='true_false_writing_at_end_simple')
		@include('practice.true_false_writing_at_simple')
	@endif
</form>
@if($practise['type']!="true_false_writing_at_end_simple")
	<script type="text/javascript">
		$('.false_option').on('click', function(){
			$(this).parent().parent().parent().find('.textarea').show()
		})
		$('.true_option').on('click', function(){
			$(this).parent().parent().parent().find('.textarea').hide()
		});
		$('.t_f_simple').keypress(
		function(event){
			if (event.which == '13') {
			event.preventDefault();
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
		currentVal= currentVal.replace('<br>','\n');
		currentVal= currentVal.replace('<div>','\n');
		currentVal= currentVal.replace('</div>','');
		$(this).next().find("textarea").val(currentVal);
	})
	}
	var token = $('meta[name=csrf-token]').attr('content');
	var upload_url = "{{url('upload-audio')}}";
	var workerDirPath = "{{asset('public/js/audio-recorder/')}}";

</script>
