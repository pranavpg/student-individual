<p>
	<strong>{{$practise['title']}}</strong>
	<?php
		$exploded_question  =  explode('@@', $practise['question']);
		$answerExists = false;
		$answers=array();
		if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
			$answerExists = true;
			if($practise['type'] == "true_false_speaking_writing_simple"){
				$answers = $practise['user_answer'][0]['text_ans'][0];
			} else {
				$answers = $practise['user_answer'][0];
			}
		}
	?>
</p>
<form class="save_true_false_speaking_form save_true_false_speaking_form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  <div class="true-false">
		@if(!empty($exploded_question))
			@foreach($exploded_question as $key => $value)
				@if(!empty($value) && !str_contains($value,'<b>'))
		      <div class="box box-flex align-items-center">
	          <div class="box__left flex-grow-1">
	              <p>{!!$value!!}</p>
								@if($practise['type']=='true_false_writing_at_end' || $practise['type']=='true_false_writing_at_end_simple' )
		              <div class="form-group">
										<?php
												$style="display:none";
	 											if(!empty($answers)&& isset($answers[$key]['true_false']) && $answers[$key]['true_false']==0){
													$style="display:block";
												}
												if( $practise['type']=='true_false_writing_at_end_simple' ){
													$style="display:block";
												}
										?>

										<span style="{{$style}}" class="textarea form-control form-control-textarea" role="textbox" disable contenteditable placeholder="Write here...">
		                    <?php
		                      if ($answerExists)
		                      {
		                          echo  $answers[$key]['text_ans'];
		                      }
		                    ?>
		                </span>
		                <div style="display:none">
		                  <textarea name="text_ans[{{$key}}][text_ans]">
		                  <?php
		                      if ($answerExists)
		                      {
															echo  $answers[$key]['text_ans'];
		                      }
		                  ?>
		                  </textarea>
		                </div>
		              </div>
								@endif
	          </div>
						<?php
								if($practise['type'] == "true_false_speaking_writing_simple") {
								$question_name =	"text_ans[0][$key][question]";
								$true_false_name = "text_ans[0][$key][true_false]";
							} else{
								$question_name =	"text_ans[$key][question]";
									$true_false_name = "text_ans[$key][true_false]";
							}
						?>
	          <div class="true-false_buttons">
								<input type="hidden" name="{{$question_name}}"  value="{{ $value }}@@" >
								<div class="form-check form-check-inline">
	                  <input class="form-check-input true_option" type="radio"
	                      name="{{$true_false_name}}" id="inlineRadioTrue{{$key}}" value="1" {{ ($answerExists&& isset($answers[$key]['true_false']) && $answers[$key]['true_false']==1)?"checked":""}} >
	                  <label class="form-check-label" for="inlineRadioTrue{{$key}}">True</label>
	              </div>
	              <div class="form-check form-check-inline">
	                  <input class="form-check-input false_option" type="radio"
	                      name="{{$true_false_name}}" id="inlineRadioFalse{{$key}}" value="0" {{ ($answerExists && isset($answers[$key]['true_false']) && $answers[$key]['true_false']==0)?"checked":""}} >
	                  <label class="form-check-label" for="inlineRadioFalse{{$key}}">False</label>
	              </div>
	          </div>
	      	</div>
				@else
				<p>{!!$value!!}</p>
				@endif
			@endforeach
		@endif
		@if($practise['type'] == "true_false_speaking_writing_simple")
				@include('practice.common.audio_record_div', ['key'=>0])
				<div class="form-slider p-0 mb-4">
						<div class="component-control-box">
							<span class="textarea form-control form-control-textarea t_f_simple" role="textbox" disable contenteditable placeholder="Write here...">
									<?php
										if ($answerExists)
										{
												echo  $practise['user_answer'][0]['text_ans'][1][0];
										}
									?>
							</span>
							<div style="display:none">
								<textarea name="text_ans[1][0]">
								<?php
										if ($answerExists)
										{
											echo $practise['user_answer'][0]['text_ans'][1][0];
										}
								?>
								</textarea>
							</div>
						</div>
				</div>
		@endif
  </div>
	<div class="alert alert-success" role="alert" style="display:none"></div>
	<div class="alert alert-danger" role="alert" style="display:none"></div>
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
			currentVal= currentVal.replace('</div>','');
			currentVal= currentVal.replace('<div>','<br>');
			currentVal= currentVal.replace('</div>','');
			$(this).next().find("textarea").val(currentVal);
		})
	}
	var token = $('meta[name=csrf-token]').attr('content');
	var upload_url = "{{url('upload-audio')}}";
	var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
</script>