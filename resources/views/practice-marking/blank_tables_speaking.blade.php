<p>
		<strong> {!! $practise['title'] !!} </strong>
	<?php
		// echo "<pre>";
	 	// print_r($practise);
	?>
</p>
@if(!empty($practise['question']))
		@if(!empty($practise['options']))
			<div class="suggestion-list d-flex flex-wrap w-100 mr-auto ml-auto mb-4 justify-content-center">
				@foreach( $practise['options'] as $key => $value )

						<div class="d-inline-flex flex-grow-1 suggestion_box justify-content-center">
								{{ $value[0]}}
						</div>
				@endforeach
			</div>
		@endif

		@if(  $practise['type'] == "two_blank_table_speaking_up" ||
					$practise['type'] == "three_blank_table_speaking_up" ||
					$practise['type'] == "four_blank_table_speaking_up" ||
					$practise['type'] == "five_blank_table_speaking_up")
				@include('practice.common.audio_record_div',['key'=>0])
		@endif

    <div class="table-container">
      <form class="save_blank_table_speaking_form">
        <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
        <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
        <input type="hidden" class="is_save" name="is_save" value="">
				<input type="hidden" class="practise_type" name="practise_type" value="{{$practise['type']}}">
				<input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
				<?php
				$table_header=array();
				$table_center_class = "";
				$start_j = 0;
					$exploded_question = explode(PHP_EOL, $practise['question']);
					if (!str_contains($exploded_question[0], '--'))
					{
						$table_header = explode('@@', $exploded_question[0]);
					}
					//pr($table_header);
					$answerExists = false;
					if (isset($practise['user_answer']) && !empty($practise['user_answer']))
					{
							$answerExists = true;
					}

					if (is_numeric($exploded_question[1]))
					{
							$firstColumns = array();
							if (!str_contains($exploded_question[0], '--'))
							{
								$start_j = 1;
							}
					}
					else
					{
						if (!str_contains($exploded_question[0], '--'))
						{
							//pr($practise);
							$start_j=1;
							$firstColumns = explode('@@', $exploded_question[1]);
							// pr($firstColumns);
							array_unshift($firstColumns, "");
							unset($firstColumns[0]);
//echo count($firstColumns);die;
							$exploded_question[1] = count($firstColumns)+1;

						} else {
							$firstColumns=array();
							$exploded_question[1] = count(explode('@@', $exploded_question[1]));
						}

					}

					$columnCount = 1;
					if ($practise['type'] == "one_blank_table_speaking" || $practise['type'] == "one_blank_table_speaking_up")
					{
							$columnCount = 1;
							$columnClass = 'w-100';
							$table_width_class='w-75';
							$practice_user_ans =	($answerExists)?$practise['user_answer'][0]:"";
					}
					elseif ($practise['type'] == "two_blank_table_speaking" || $practise['type'] == "two_table_option_speaking"|| $practise['type'] == "two_blank_table_speaking_up")
					{
							//	echo "asd";
						 	$table_center_class = "m-auto";
							$columnCount = 2;
							$columnClass = 'w-50';
							$table_width_class='w-75';
							if($answerExists){
								$practice_user_ans =	$practise['user_answer'][0]['text_ans'];
								$table_header = array_values($practice_user_ans[0][0]);
								$exploded_question[1] = count($table_header)+1;
								$columnCount =count($table_header);
							} else {

								if(empty($table_header)){
									$practice_user_ans =	explode(PHP_EOL, $practise['question']);
								}
								elseif( !empty($exploded_question[2]) ) {
										$practice_user_ans[0] =  $exploded_question[2];
								}
							//	pr($practice_user_ans);
							}
					}
					elseif ($practise['type'] == "three_blank_table_speaking"  || $practise['type'] == "three_table_option_speaking" || $practise['type'] == "three_blank_table_speaking_up")
					{
						//pr('sd');
						$table_center_class = "m-auto";
						$columnCount = 3;
						$columnClass = 'w-33';
						$table_width_class='w-75';
						$practice_user_ans = array();
						if($answerExists){
							$practice_user_ans =	$practise['user_answer'][0]['text_ans'];
						} else {

							if( empty($table_header) ){
								$practice_user_ans =	explode(PHP_EOL, $practise['question']);
							}	elseif( !empty($exploded_question[2]) ) {
										$practice_user_ans[0] =  $exploded_question[2];
								}
						}

					}
					elseif ($practise['type'] == "four_blank_table_speaking" || $practise['type'] == "four_blank_table_speaking_up" || $practise['type'] == "four_table_option_speaking" )
					{
							$columnCount = 4;
							$columnClass = 'w-25';
							$table_width_class='w-100';
							$practice_user_ans = array();
							if($answerExists){
								$practice_user_ans =	$practise['user_answer'][0]['text_ans'];
							} else {
								if( empty($table_header) ){
									$practice_user_ans =	explode(PHP_EOL, $practise['question']);
								}

							}

					}
					elseif ($practise['type'] == "five_blank_table_speaking" || $practise['type'] == "five_blank_table_speaking_up")
					{
							$columnCount = 5;
							$columnClass = 'w-20';
							$table_width_class='w-75';
							$practice_user_ans =	($answerExists)?$practise['user_answer'][0]['text_ans']:"";
						//	pr($practice_user_ans);

					}
					elseif ($practise['type'] == "six_blank_table_speaking" || $practise['type'] == "six_blank_table_speaking_up")
					{
							$columnCount = 6;
							$columnClass = 'col-2';
							$table_width_class='w-75';
							$practice_user_ans =	($answerExists)?$practise['user_answer'][0]:"";
					}
					elseif ($practise['type'] == "seven_blank_table_speaking" || $practise['type'] == "seven_blank_table_speaking_up")
					{
							$columnCount = 7;
							$columnClass = '';
							$table_width_class='w-75';
							$practice_user_ans =	($answerExists)?$practise['user_answer'][0]:"";
					}
					elseif ($practise['type'] == "eight_blank_table_speaking" || $practise['type'] == "eight_blank_table_speaking_up")
					{
							$columnCount = 8;
							$columnClass = '';
							$table_width_class='w-75';
							$practice_user_ans =	($answerExists)?$practise['user_answer'][0]:"";
					}
					elseif ($practise['type'] == "nine_blank_table_speaking" || $practise['type'] == "nine_blank_table_speaking_up")
					{
							$columnCount = 9;
							$columnClass = '';
							$table_width_class='w-75';
							$practice_user_ans =	($answerExists)?$practise['user_answer'][0]:"";
					}
					elseif ($practise['type'] == "ten_blank_table_speaking" || $practise['type'] == "ten_blank_table_speaking_up")
					{
							$columnCount = 10;
							$columnClass = '';
							$table_width_class='w-75';
							$practice_user_ans =	($answerExists)?$practise['user_answer'][0]:"";
					}
				?>
					<div class="table-container text-center  mb-4">
						<div class="table {{$table_width_class.' '.$table_center_class}}">
							<div class="table-heading thead-dark d-flex justify-content-between">
									@if(!empty($table_header))
										<?php foreach ($table_header as $key => $value) {  ?>
											<div class="d-flex justify-content-center align-items-center th <?php echo $columnClass; ?>"><?php echo $value; ?>
											<div style="display:none">
												<textarea name="text_ans[0][0][col_{{$key+1}}]"><?php echo $value; ?></textarea>
												<input type="hidden" name="text_ans[1][0][{{$key}}]" value="0" />
											</div>
											</div>

										<?php } ?>
									@endif
							</div>
							<?php for ( $j = $start_j ; $j < $exploded_question[1]; $j++ ) { ?>
								<div class="table-row thead-dark d-flex justify-content-between">
									<?php for ($k = 1;$k <= $columnCount;$k++) {
										if (!$answerExists && !empty($practice_user_ans[$k-1])) {
											$exp_practice_user_ans = explode(' @@',	$practice_user_ans[$k-1]);
											//pr($exp_practice_user_ans);
										}

										?>
										<div class="d-flex justify-content-center align-items-center  border-left td <?php echo $columnClass; ?> td-textarea">
											<?php if ($k == 1 && isset($firstColumns) && !empty($firstColumns)) { ?>
												<span class="textarea form-control form-control-textarea"><?php echo $firstColumns[$j]; ?></span>
												<div style="display:none">
													<?php
														if($j==0){

															$name="text_ans[0][$j][col_($k+1)]";
														}else{
															$name = "text_ans[0][$j][col_$k]";
														}
													?>
													<textarea name="{{$name}}"><?php echo $firstColumns[$j]; ?></textarea>
													<input type="hidden" name="text_ans[1][{{$j}}][{{$k-1}}]" value="false" />
												</div>

											<?php } else {
												$content_editable = "";
												if($answerExists==false && ( (!empty($practice_user_ans[$k-1]) && !empty($exp_practice_user_ans[$j])) || !empty($exp_practice_user_ans[$j-1])  )){
													$content_editable = "";
												} else {
													if(  (
																	!$answerExists ||
															  	(  !empty($practice_user_ans[1][$j][$k-1]) &&
																		(   $practice_user_ans[1][$j][$k-1]==='1' ||
																				$practice_user_ans[1][$j][$k-1]==='true' ||
																				$practice_user_ans[1][$j][$k-1]===true )
																		)
																  )
														)
													{
														$content_editable = "contenteditable";
													}
												}

												?>
												<span class="textarea form-control form-control-textarea" role="textbox" {{$content_editable}}  disabled placeholder="Write here...">
													<?php
														if ($answerExists) {
																echo !empty($practice_user_ans[0][$j])?$practice_user_ans[0][$j]['col_' . $k]:"";
																//echo $j"==".$k;
														} else{
															if(!empty($practice_user_ans[$k-1]) && !empty($exp_practice_user_ans[$j])){
																echo str_replace('--','',$exp_practice_user_ans[$j]);
															} else 	if(  !empty($exp_practice_user_ans[$j-1]) ){
																echo str_replace('--','',$exp_practice_user_ans[$j-1]);
															}
														}
													?>
												</span>
												<div style="display:none">
													<textarea name="text_ans[0][{{$j}}][col_{{$k}}]">
													<?php
															$true_false="true";
															if ($answerExists) {

																	echo !empty($practice_user_ans[0][$j])?$practice_user_ans[0][$j]['col_' . $k]:'';
																	$true_false = ($practice_user_ans[1][$j][$k-1]==='1' || $practice_user_ans[1][$j][$k-1]==='true' || $practice_user_ans[1][$j][$k-1]===true ) ?"true":"false";
															}  else{
																if(!empty($practice_user_ans[$k-1]) && !empty($exp_practice_user_ans[$j])){
																	echo str_replace('--','',$exp_practice_user_ans[$j]);
																} else 	if(  !empty($exp_practice_user_ans[$j-1]) ){
																	echo str_replace('--','',$exp_practice_user_ans[$j-1]);
																}
															}
													?>
													</textarea>
													<input type="hidden" name="text_ans[1][{{$j}}][{{$k-1}}]" value="{{$true_false}}" />
												</div>
											<?php } ?>
											@if($columnCount == $k )
											<div></div>
											@endif
										</div>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
					</div>
				@if($practise['type'] == "two_blank_table_speaking" ||
						$practise['type'] == "two_table_option_speaking" ||
						$practise['type'] == "three_table_option_speaking" ||
						$practise['type'] == "three_blank_table_speaking" )
						@include('practice.common.audio_record_div',['key'=>0])
				@endif

				<div class="alert alert-success" role="alert" style="display:none"></div>
				<div class="alert alert-danger" role="alert" style="display:none"></div>
			  
			</form>
		</div>


<script type="text/javascript">
function setTextareaContent(){
	$("span.textarea.form-control").each(function(){
		var currentVal = $(this).html();
		$(this).next().find("textarea").val(currentVal);
	})
}
var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
$(document).on('click','.delete-icon', function() {
	$(this).parent().find('.stop-button').hide();
	$(this).parent().find('.practice_audio').attr('src','');
	$(this).parent().find('.audioplayer-bar-played').css('width','0%');
	$(this).hide();
	$(this).parent().find('div.audio-element').css('pointer-events','none');
	$(this).parent().find('.record-icon').show();
	$(this).parent().find('.stop-button').hide();
	$.ajax({
      url: '<?php echo URL('delete-audio'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: {practice_id:practise_id},
      success: function (data) {

      }
  });
});
</script>
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
@endif
