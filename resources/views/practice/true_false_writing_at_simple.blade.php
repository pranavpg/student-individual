<div class="true-false">
	  	@if($practise['type']=='true_false_writing_at_end' || $practise['type']=='true_false_writing_at_end_simple' )
			@if(!empty($exploded_question))
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
				@foreach($exploded_question as $key => $value)
					<?php  $tempCheck = str_replace("\r\n","", $value); ?>
					@if(!empty($tempCheck) && !str_contains($tempCheck,'<b>'))

							<div class="box box-flex d-flex align-items-center">
					          	<div class="box__left flex-grow-1">
					              	<p>{!!$value!!}</p>
		              					<div class="form-group">
										<?php
												$style="display:none";
													if(!empty($answers) && $answers[$key]['true_false']==0){
													$style="display:block";
												}
												if( $practise['type']=='true_false_writing_at_end_simple' ){
													$style="display:block";
												}
										?>
										<span style="{{$style}}" class="textarea form-control form-control-textarea" role="textbox" contenteditable placeholder="Write here...">
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
							                      name="{{$true_false_name}}" id="inlineRadioTrue{{$key}}" value="1" {{ ($answerExists && $answers[$key]['true_false']==1)?"checked":""}} >
							                  <label class="form-check-label" for="inlineRadioTrue{{$key}}">True</label>
							            </div>
							            <div class="form-check form-check-inline">
							                  <input class="form-check-input false_option" type="radio"
							                      name="{{$true_false_name}}" id="inlineRadioFalse{{$key}}" value="0" {{ ($answerExists && $answers[$key]['true_false']==0)?"checked":""}} >
							                  <label class="form-check-label" for="inlineRadioFalse{{$key}}">False</label>
							            </div>
						          	</div>
					      	</div>
					      	
					@else
					<p>{!!$value!!}</p>
					@endif
				@endforeach
				</div>
				@endif
		@endif
			@if($practise['type'] == "true_false_speaking_writing_simple")
					@include('practice.common.audio_record_div', ['key'=>0])

					<div class="form-slider p-0 mb-4">
							<div class="component-control-box">
								<span class="textarea form-control form-control-textarea t_f_simple" role="textbox"
										contenteditable placeholder="Write here...">
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
  </div>