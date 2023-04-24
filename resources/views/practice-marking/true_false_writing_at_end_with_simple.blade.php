<div class="true-false">

		@if(!empty($rolplayexercise))
			<input type="hidden" name="is_roleplay" value="1">
			<div class="component-two-click mb-4">
			<div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
				<?php
				if(!empty($tabs)){
				$userAnsCount = 0;
				foreach($tabs as $c=>$rolePlayUser){?>
				<a href="#!" id="s-button-<?php echo $c;?>" class="btn btn-dark s-button-{{$practise['id']}} selected_option selected_option_{{$c}} {{$practise['id']}}"  data-key="{{$c}}"><?php echo trim($rolePlayUser);?></a>
				<?php }}?>
			</div>
			<div class="two-click-content w-100">
				<?php $index=1; $tempFlag = 0; $increment = 0;?>

					@foreach($tabs as $c=>$rolePlayUser)
						<?php 
							$k=1; $tempCheck = str_replace("\r\n","", $rolplayexercise[$c]); 
							$question = [];
							// dd($rolplayexercise);
							$question = explode(PHP_EOL, $rolplayexercise[$index]);
							$question = array_filter($question);
						?>
						<div class="content-box multiple-choice s-button-box d-none selected_option_description selected_option_description_{{$c}}" id="s-button-<?php echo $c.''.$c;?>">
								@foreach($question as $s=>$lines)
							
									<div class="box box-flex align-items-center">
										<div class="box__left flex-grow-1">
											<p>{!!str_replace('@@',"",$lines)!!}</p>
											<div class="form-group">
												<?php
												$style="display:none";
												if(!empty($answers) && isset($answers[$tempFlag][0][$s]) && isset($answers[$tempFlag][0][$s]) && $answers[$tempFlag][0][$s]['true_false']==0){
													$style="display:block";
												}
												if( $practise['type']=='true_false_writing_at_end_simple' ){
													$style="display:block";
												}
												?>
												<span style="{{$style}}" class="textarea form-control form-control-textarea stringProper" role="textbox"  disabled contenteditable placeholder="Write here..."><?php if ($answerExists)
													{
														if(!empty($answers) && isset($answers[$tempFlag][0][$s]) && isset($answers[$tempFlag][0][$s])){
															echo  isset($answers[$tempFlag][0][$s]['text_ans'])?str_replace(" ","&nbsp;",$answers[$tempFlag][0][$s]['text_ans']):"";
															
														}
													}
													?></span>
												<div style="display:none">
													<textarea name="text_ans[{{$c}}][{{$s}}][text_ans]"><?php if ($answerExists)
													{
														if(!empty($answers) && isset($answers[$tempFlag][0][$s]) && isset($answers[$tempFlag][0][$s])){
															echo  isset($answers[$tempFlag][0][$s]['text_ans'])?str_replace(" ","&nbsp;",$answers[$tempFlag][0][$s]['text_ans']):"";
														}
													}
													?></textarea>
												</div>
											</div>
										</div>
										<?php
											$question_name =	"text_ans[$c][$s][question]";
											$true_false_name = "text_ans[$c][$s][true_false]";
										?>
								
										<?php
											$first = "";
											$second = "";
											if($answerExists){
												if(!empty($answers) && isset($answers[$tempFlag][0][$s]) && isset($answers[$tempFlag][0][$s]['true_false']) && $answers[$tempFlag][0][$s]['true_false']==1){
													$first = "checked";
													$second = "";
												}
												elseif(!empty($answers) && isset($answers[$tempFlag][0][$s]) && isset($answers[$tempFlag][0][$s]['true_false']) && $answers[$tempFlag][0][$s]['true_false']==0){
													$first = "";
													$second = "checked";
												}
											}
										?>
										<div class="true-false_buttons mt-1">
											<input type="hidden" name="{{$question_name}}"  value='{!!str_replace("@@","",$lines)!!}' >
											<div class="form-check form-check-inline">
											<input class="form-check-input true_option" type="radio" name="{{$true_false_name}}" id="inlineRadioTrue{{$increment}}" {{ $first }}  value="1"  >
												<label class="form-check-label" for="inlineRadioTrue{{$increment}}">True</label>
											</div>
											<div class="form-check form-check-inline">
													<input class="form-check-input false_option" type="radio" name="{{$true_false_name}}" id="inlineRadioFalse{{$increment}}" value="0" {{ $second }} >
												<label class="form-check-label" for="inlineRadioFalse{{$increment}}">False</label>
											</div>
										</div>


									</div>
									
								<?php $increment++;?>
								@endforeach
							</div>
				
					<?php $k++;?>
					<?php $index++;  ?>
					<?php $tempFlag = $tempFlag+2; ?>
				@endforeach
			</div>
			</div>
		
	
			@if($practise['type'] == "true_false_speaking_writing_simple")
				@include('practice.common.audio_record_div', ['key'=>0])
				<div class="form-slider p-0 mb-4">
					<div class="component-control-box">
						<span class="textarea form-control form-control-textarea t_f_simple stringProper" role="textbox" disabled contenteditable placeholder="Write here...">
							<?php
							if ($answerExists){
								echo  $practise['user_answer'][0]['text_ans'][1][0];
							
							}
							?>
						</span>
						<div style="display:none">
							<textarea name="text_ans[1][0]">
							<?php if ($answerExists) {
								echo $practise['user_answer'][0]['text_ans'][1][0];
							}
							?>
							</textarea>
						</div>
					</div>
				</div>
			@endif
	@else
	<div class="true-false">
		<?php //dd($answers); ?>
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
												
	 											if(!empty($answers) && $answers[0][$key]['true_false']== 0){
													$style="display:block";
												}
												if( $practise['type']=='true_false_writing_at_end_simple' ){
													$style="display:block";
												}
										?>

										<span style="{{$style}}" class="textarea form-control form-control-textarea" role="textbox" disabled contenteditable placeholder="Write here...">
		                    <?php
		                      if ($answerExists)
		                      {
		                          echo  $answers[0][$key]['text_ans'];
		                      }
		                    ?>
		                </span>
		                <div style="display:none">
		                  <textarea name="text_ans[{{$key}}][text_ans]">
		                  <?php
		                      if ($answerExists)
		                      {
															echo  $answers[0][$key]['text_ans'];
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
	          <div class="true-false_buttons mt-1">
								<input type="hidden" name="{{$question_name}}"  value="{{ $value }}@@" >
								<div class="form-check form-check-inline">
	                  <input class="form-check-input true_option" type="radio"
	                      name="{{$true_false_name}}" id="inlineRadioTrue{{$key}}" value="1" {{ ($answerExists && $answers[0][$key]['true_false']==1)?"checked":""}} >
	                  <label class="form-check-label" for="inlineRadioTrue{{$key}}">{!!$true!!}</label>
	              </div>
	              <div class="form-check form-check-inline">
	                  <input class="form-check-input false_option" type="radio"
	                      name="{{$true_false_name}}" id="inlineRadioFalse{{$key}}" value="0" {{ ($answerExists && $answers[0][$key]['true_false']==0)?"checked":""}} >
	                  <label class="form-check-label" for="inlineRadioFalse{{$key}}">{!!$false!!}</label>
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
							<span class="textarea form-control form-control-textarea t_f_simple stringProper" role="textbox" disabled contenteditable placeholder="Write here...">
								<?php
									if ($answerExists) {
										echo  $practise['user_answer'][0]['text_ans'][1][0];
									}
								?>
							</span>
							<div style="display:none">
								<textarea name="text_ans[1][0]">
									<?php
										if ($answerExists) {
											echo $practise['user_answer'][0]['text_ans'][1][0];
										}
									?>
								</textarea>
							</div>
						</div>
				</div>
		@endif
  </div>
	@endif
</div>
<script type="text/javascript">
	$(".s-button-<?php echo $practise['id'];?>").on("click",function(){
			if($("#reading-no-blanks_form-<?php echo $practise['id'];?> .s-button-<?php echo $practise['id'];?>.d-none").length > 0){
				$("#reading-no-blanks_form-<?php echo $practise['id'];?> .s-button-<?php echo $practise['id'];?>.d-none");
				$("#reading-no-blanks_form-<?php echo $practise['id'];?> .s-button-box").addClass("d-none");
				$("#reading-no-blanks_form-<?php echo $practise['id'];?> .s-button-<?php echo $practise['id'];?>").removeClass("d-none").removeClass("btn-bg");
				return false;
			}
			$("#reading-no-blanks_form-<?php echo $practise['id'];?> .s-button-box,.s-button-<?php echo $practise['id'];?>").addClass("d-none");
			$(this).removeClass("d-none").addClass("btn-bg");
			var curId = $(this).attr("id");
			curId = curId.replace("s-button-","");
			$("#reading-no-blanks_form-<?php echo $practise['id'];?> #s-button-"+curId+curId).removeClass("d-none");
		})
	
</script>