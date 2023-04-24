<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
// echo "<pre>";
// print_r($practise);
	$exploded_question  = array();
	$user_ans = "";
	$tableHeaderColumnClass="";
  	$answerExists = false;
  	if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
		$answerExists = true;
		if(!empty($practise['is_roleplay']) && $practise['is_roleplay']==1){
			$answers = $practise['user_answer'];
			$new_answer = array_values(array_filter($answers,
					function($item) {
					  return strpos($item, '##') === false;
					}));
			$practise['user_answer'] = $new_answer;
		}
	}
	$data[$practise['id']] = array();
	$data[$practise['id']]['isRolePlayPractice'] = (!empty($practise['is_roleplay']) &&  $practise['is_roleplay']==1)?1:0;
	$data[$practise['id']]['typeofdependingpractice'] = !empty($practise['typeofdependingpractice']) ? $practise['typeofdependingpractice'] : "";
	$data[$practise['id']]['setFullViewFromPreviousPractice'] = !empty($practise['depending_practise_details']['dependant_practise_id']) ? $practise['depending_practise_details']['dependant_practise_id']:"";
	$data[$practise['id']]['dependant_practise_topic_id'] = !empty($practise['depending_practise_details']['dependant_practise_topic_id']) ? $practise['depending_practise_details']['dependant_practise_topic_id']:"";
	$data[$practise['id']]['dependant_practise_task_id'] = !empty($practise['depending_practise_details']['dependant_practise_task_id']) ? $practise['depending_practise_details']['dependant_practise_task_id']:"";
	$data[$practise['id']]['dependant_practise_question_type'] = !empty($practise['depending_practise_details']['question_type']) ? $practise['depending_practise_details']['question_type']:"";
	$data[$practise['id']]['dependentpractice_ans'] = !empty($practise['dependingpractise_answer'])?1:0;
	$data[$practise['id']]['is_dependent'] = !empty($practise['is_dependent']) ? 1 : 0;
	// echo "<pre>";
	// print_r($practise);
	$style="";
	
	if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) ){
  		$depend =explode("_",$practise['dependingpractiseid']);
		  $style= "display:none"; 
		
?>
		<div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; display:none">
			<p style="margin: 15px;">In order to do this task you need to have completed
			<strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
		</div>
<?php
  	} else {
		$exploded_question = explode(PHP_EOL,$practise['question']);
	}
//	pr($exploded_question); 
?>

<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">

<?php
 
	$tempPracticeData = $practise;
	if(empty($practise['dependingpractiseid']) &&  empty($practise['is_dependent']) ){

		if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
			$originalPractiseAnswer = $practise['user_answer'];
		}

		if(isset($practise['is_roleplay']) && $practise['is_roleplay'] == 1){ ?>
			@include('practice.blank_tables_roleplay') <?php 
		} else {
			if(isset($practise['options']) && !empty($practise['options'])){
				$options = $practise['options'];
				$allOptions = array();
				foreach($options as $option){
					$allOptions[] = $option[0];
				}
				$allOptions = array_chunk($allOptions,4);
				foreach($allOptions as $allOption){ ?>
					<div class="suggestion-list d-flex flex-wrap mb-4 justify-content-center">
						<?php foreach($allOption as $option){?>
							<div class="d-inline-flex flex-grow-1 suggestion_box justify-content-center w-25">
								<?php echo $option;?>
							</div>
						<?php }?>
					</div>
				<?php } 
			}

			if(str_contains($practise['question'],'#%')  ){
				$exploded_question = explode('#%', $practise['question']);
				$read_text_tab = $exploded_question[0];
				$exploded_question_by_slasht = explode('/t', $exploded_question[1]);
				$read_text_description = $exploded_question_by_slasht[0];
				$check_custom_table_header = explode(PHP_EOL,$exploded_question_by_slasht[1]);
				$check_custom_table_header = explode("@@",$check_custom_table_header[0]);
			} else {
				$exploded_question = explode(PHP_EOL, $practise['question']);
				$checkFirstTwoChars = substr($exploded_question[0],0, 2);
				if($checkFirstTwoChars !== "--"){

				
					$check_custom_table_header = explode('/t', $exploded_question[0]);
				
					if(count($check_custom_table_header) > 1){
						$check_custom_table_header = explode("@@",$check_custom_table_header[0]);
						if(count($check_custom_table_header) > 0){ ?>
							<div class="dark-buttons row mb-4">
								<?php
								unset($check_custom_table_header[0]);
								foreach($check_custom_table_header as $coun=>$custom_option){
									$custom_option = explode("#%",$custom_option);
								?>
									<div class="col-4 mb-4"><a href="javascript:void(0);" data-toggle="modal" data-target="#deoModal_<?php echo $practise['id'];?>_<?php echo $coun;?>" class="btn btn-dark" style="display:block; text-align:center;"><?php echo $custom_option[0];?></a></div>
									<div class="modal" id="deoModal_<?php echo $practise['id'];?>_<?php echo $coun;?>" tabindex="-1" role="dialog" aria-labelledby="deoModalTitle" aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered deoModal" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title text-center" id="deoModalTitle"><?php echo $custom_option[0];?></h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<p><?php echo $custom_option[1];?></p>
												</div>
												<div class="modal-footer justify-content-center">
													<button type="button" class="btn btn-primary" data-dismiss="modal">Done</button>
												</div>
											</div>
										</div>
									</div>
								<?php }?>
							</div>
						<?php } 
					}

					//pr($practise);
					if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
						$originalPractiseAnswer = $practise['user_answer'];
						if(!empty($practise['user_answer'][0]['text_ans'])){
							$newMakeAnswer[0]['text_ans'][0] = $practise['user_answer'][0]['text_ans'][0];
							$newMakeAnswer[0]['text_ans'][1] = $practise['user_answer'][0]['text_ans'][1];
							if(isset($practise['user_answer'][0]['path'])){
								$newMakeAnswer[0]['path'] =$practise['user_answer'][0]['path'];
							}
							$practise['user_answer'] = $newMakeAnswer;
						} else if(!empty($practise['user_answer'][0][0])) {
							$newMakeAnswer = array();
							$newMakeAnswer[0][0] = $practise['user_answer'][0][0];
							$newMakeAnswer[0][1] = $practise['user_answer'][0][1];
							$practise['user_answer'] = $newMakeAnswer; 
						} 
					}
				}
			}

			$speakingPractise = false;
 		?>
				
			<div class="table-container">
				<form class="save_two_blank_table_form" id="blank_table_form_<?php echo $practise['id'];?>">

				<div class="previous_practice_answer_exists_{{$practise['id']}}" style="{{$style}}">
					<div class="showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}">
					</div>
				</div>
				<input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
				<input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
				<input type="hidden" class="is_save" name="is_save" value="">
				<input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
				<?php

					if( str_contains($practise['question'],'#%') ){
						
						$exploded_question = explode('#%', $practise['question']);
						$read_text_tab = $exploded_question[0];
						$exploded_question = explode('/t', $exploded_question[1]);
						
						$read_text_description = $exploded_question[0];
						
						$check_custom_table_header = explode(PHP_EOL,$exploded_question[1]);
						$table_header = explode("@@", $check_custom_table_header[0] );
						$columnsStartWith = 1;
						$exploded_question = explode(PHP_EOL,$exploded_question[1]);
						// pr($read_text_tab);
					
					} else {
					 
						$exploded_question = explode( PHP_EOL, $practise['question'] );

						$checkFirstTwoChars = substr($exploded_question[0],0, 2);
						if($checkFirstTwoChars !== "--"){
							//
							$check_custom_table_header = explode('/t', $exploded_question[0]);
							//pr($check_custom_table_header);die;
							if(count($check_custom_table_header) > 1){
								$table_header = explode('@@', $check_custom_table_header[1]);
							}else{
								$table_header = explode('@@', $exploded_question[0]);
							}
						 

							$columnsStartWith = 1;
						}else{
							$table_header = array();
							$columnsStartWith = 0;
						}
					}
					$answerExists = false;
					
					if (isset($practise['user_answer']) && !empty($practise['user_answer'])) {
						$answerExists = true;
					}


					//	 dd($columnsStartWith);
					$flag = "";
					if (isset($exploded_question[$columnsStartWith]) && is_numeric($exploded_question[$columnsStartWith]))
					{
						// dd("sssss");
						$flag = "1";
						$firstColumns = array();
						$totalColumnCounts = $exploded_question[$columnsStartWith];
					}
					elseif(isset($exploded_question[$columnsStartWith]))
					{
						$flag = "2";
					//	pr($exploded_question);
						// dd($exploded_question[$columnsStartWith]);
						$firstColumns = explode('@@', $exploded_question[$columnsStartWith]);
					//	dd($firstColumns);
						$totalColumnCounts = count($firstColumns);
					}else{
						$firstColumns = array();
					}
					$columnsStartWith++;

					$secondColumns = array();
					if (isset($exploded_question[$columnsStartWith]) && is_numeric($exploded_question[$columnsStartWith]))
					{
						
						$secondColumns = array();
						$totalColumnCounts = $exploded_question[$columnsStartWith];
					}
					elseif(isset($exploded_question[$columnsStartWith]))
					{
						
						$secondColumns = explode('@@', $exploded_question[$columnsStartWith]);
					//	pr($exploded_question);
						$totalColumnCounts = count($secondColumns);
					}
					$columnsStartWith++;

					$thirdColumns = array();
					if (isset($exploded_question[$columnsStartWith]) && is_numeric($exploded_question[$columnsStartWith]))
					{
						$thirdColumns = array();
						$totalColumnCounts = $exploded_question[$columnsStartWith];
					}
					elseif(isset($exploded_question[$columnsStartWith]))
					{
						$thirdColumns = explode('@@', $exploded_question[$columnsStartWith]);
						$totalColumnCounts = count($thirdColumns);
					}
					$columnsStartWith++;

					$fourColumns = array();
					if (isset($exploded_question[$columnsStartWith]) && is_numeric($exploded_question[$columnsStartWith]))
					{
						$fourColumns = array();
						$totalColumnCounts = $exploded_question[$columnsStartWith];
					}
					elseif(isset($exploded_question[$columnsStartWith]))
					{
						$fourColumns = explode('@@', $exploded_question[$columnsStartWith]);
						$totalColumnCounts = count($fourColumns);
					}
					$columnsStartWith++;

					$fiveColumns = array();
					if (isset($exploded_question[$columnsStartWith]) && is_numeric($exploded_question[$columnsStartWith]))
					{
						$fiveColumns = array();
						$totalColumnCounts = $exploded_question[$columnsStartWith];
					}
					elseif(isset($exploded_question[$columnsStartWith]))
					{
						$fiveColumns = explode('@@', $exploded_question[$columnsStartWith]);
						$totalColumnCounts = count($fiveColumns);
					}
					$columnsStartWith++;

					$sixColumns = array();
					if (isset($exploded_question[$columnsStartWith]) && is_numeric($exploded_question[$columnsStartWith]))
					{
						$sixColumns = array();
						$totalColumnCounts = $exploded_question[$columnsStartWith];
					}
					elseif(isset($exploded_question[$columnsStartWith]))
					{
						$sixColumns = explode('@@', $exploded_question[$columnsStartWith]);
						$totalColumnCounts = count($sixColumns);
					}
					$columnsStartWith++;

					$sevenColumns = array();
					if (isset($exploded_question[$columnsStartWith]) && is_numeric($exploded_question[$columnsStartWith]))
					{
						$sevenColumns = array();
						$totalColumnCounts = $exploded_question[$columnsStartWith];
					}
					elseif(isset($exploded_question[$columnsStartWith]))
					{
						$sevenColumns = explode('@@', $exploded_question[$columnsStartWith]);
						$totalColumnCounts = count($sevenColumns);
					}
					$columnsStartWith++;

					$eightColumns = array();
					if (isset($exploded_question[$columnsStartWith]) && is_numeric($exploded_question[$columnsStartWith]))
					{
						$eightColumns = array();
						$totalColumnCounts = $exploded_question[$columnsStartWith];
					}
					elseif(isset($exploded_question[$columnsStartWith]))
					{
						$eightColumns = explode('@@', $exploded_question[$columnsStartWith]);
						$totalColumnCounts = count($eightColumns);
					}
					$columnsStartWith++;

					$nineColumns = array();
					if (isset($exploded_question[$columnsStartWith]) && is_numeric($exploded_question[$columnsStartWith]))
					{
						$nineColumns = array();
						$totalColumnCounts = $exploded_question[$columnsStartWith];
					}
					elseif(isset($exploded_question[$columnsStartWith]))
					{
						$nineColumns = explode('@@', $exploded_question[$columnsStartWith]);
						$totalColumnCounts = count($nineColumns);
					}
					$columnsStartWith++;

					$tenColumns = array();
					if (isset($exploded_question[$columnsStartWith]) && is_numeric($exploded_question[$columnsStartWith]))
					{
						$tenColumns = array();
						$totalColumnCounts = $exploded_question[$columnsStartWith];
					}
					elseif(isset($exploded_question[$columnsStartWith]))
					{
						$tenColumns = explode('@@', $exploded_question[$columnsStartWith]);
						$totalColumnCounts = count($tenColumns);
					}
   
					$columnCount = 1;
			        if ($practise['type'] == "two_blank_table" ) {
						$columnCount = 2; 
						$columnClass = 'w-50';
						$tableHeaderColumnClass = (count($table_header)==2)?'w-50':'w-100';
					} 
					$countElement = 0; 
				?>
				@if(!empty($read_text_description ))
				<div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
					<a href="javascript:;" data-toggle="modal" data-target="#read_text_modal_{{$practise['id']}}" class="btn btn-dark selected_option_hide_show ">{{ !empty($read_text_tab) ? $read_text_tab : "Read Text" }}</a>
				</div>

				<div class="modal subdeoModal" id="read_text_modal_{{$practise['id']}}" tabindex="-1" role="dialog" aria-labelledby="deoModalTitle" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered deoModal" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="deoModalTitle">{!! !empty($read_text_tab) ? $read_text_tab : "Read Text" !!}</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				                  <span aria-hidden="true">&times;</span>
				                </button>
							</div>
							<div class="modal-body" style="max-height: 83vh;overflow: auto;">
								<p>{!! nl2br($read_text_description)  !!}</p>
							</div>
							<div class="modal-footer justify-content-center">
								<button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
				@endif

				<div class="table-container mb-4 text-center">
					<div class="table m-auto">
						<?php if($columnCount >= 1 && !empty($table_header)){?>
						<div class="table-heading thead-dark d-flex justify-content-between">
							<?php foreach ($table_header as $table_head) { ?>
								<div class="d-flex justify-content-center align-items-center th <?php echo $tableHeaderColumnClass; ?>"><?php echo $table_head; ?>
									<div style="display:none;">
										<textarea name="col[]"><?php echo $table_head; ?></textarea>
										<input type="hidden" name="true_false[]" value="false" />
									</div>
								</div>
							<?php $countElement++; } ?>
							<?php  if(count($table_header)==1){ ?>
								<input type="hidden" name="col[]" value="">
								<input type="hidden" name="true_false[]" value="" />
							<?php $countElement++;} ?>
						</div>
						<?php }

						if(isset($firstColumns) && !empty($firstColumns)){
							$firstColumns[0] = str_replace("-","",$firstColumns[0]);
						}
					//pr($totalColumnCounts);
						if(isset($totalColumnCounts)){
							for ($j = 0;$j < $totalColumnCounts;$j++) {  ?>
							<div class="table-row thead-dark d-flex justify-content-between">
							<?php for ($k = 1;$k <= $columnCount;$k++) { ?>
									<div class="d-flex justify-content-center align-items-center  border-left td <?php echo $columnClass; ?> td-textarea">
										<?php if ( isset($firstColumns[$j]) && $k == 1 && isset($firstColumns) && !empty($firstColumns) && !empty(trim($firstColumns[$j]))  && $firstColumns[$j]!=""  ) { ?>
											<span class="textarea form-control form-control-textarea"><?php echo $firstColumns[$j]; ?></span>
											<div style="display:none">
												<textarea name="col[]"><?php echo $firstColumns[$j]; ?></textarea>
												<input type="hidden" name="true_false[]" value="false" />
											</div>
										<?php }elseif (isset($secondColumns[$j]) && $k == 2 && isset($secondColumns) && !empty($secondColumns) && !empty(trim($secondColumns[$j]))) {  ?>
											<span class="textarea form-control form-control-textarea"><?php echo $secondColumns[$j]; ?></span>
											<div style="display:none">
												<textarea name="col[]"><?php echo $secondColumns[$j]; ?></textarea>
												<input type="hidden" name="true_false[]" value="false" />
											</div>
										<?php }elseif ($k == 3 && isset($thirdColumns) && !empty($thirdColumns) && !empty(trim($thirdColumns[$j]))) { ?>
											<span class="textarea form-control form-control-textarea"><?php echo $thirdColumns[$j]; ?></span>
											<div style="display:none">
												<textarea name="col[]"><?php echo $thirdColumns[$j]; ?></textarea>
												<input type="hidden" name="true_false[]" value="false" />
											</div>
										<?php }elseif ($k == 4 && isset($fourColumns) && !empty($fourColumns) && !empty(trim($fourColumns[$j]))) { ?>
											<span class="textarea form-control form-control-textarea"><?php echo $fourColumns[$j]; ?></span>
											<div style="display:none">
												<textarea name="col[]"><?php echo $fourColumns[$j]; ?></textarea>
												<input type="hidden" name="true_false[]" value="false" />
											</div>
										<?php }elseif ($k == 5 && isset($fiveColumns) && !empty($fiveColumns) && !empty(trim($fiveColumns[$j]))) { ?>
											<span class="textarea form-control form-control-textarea"><?php echo $fiveColumns[$j]; ?></span>
											<div style="display:none">
												<textarea name="col[]"><?php echo $fiveColumns[$j]; ?></textarea>
												<input type="hidden" name="true_false[]" value="false" />
											</div>
										<?php }elseif ($k == 6 && isset($sixColumns) && !empty($sixColumns) && !empty(trim($sixColumns[$j]))) { ?>
											<span class="textarea form-control form-control-textarea"><?php echo $sixColumns[$j]; ?></span>
											<div style="display:none">
												<textarea name="col[]"><?php echo $sixColumns[$j]; ?></textarea>
												<input type="hidden" name="true_false[]" value="false" />
											</div>
										<?php }elseif ($k == 7 && isset($sevenColumns) && !empty($sevenColumns) && !empty(trim($sevenColumns[$j]))) { ?>
											<span class="textarea form-control form-control-textarea"><?php echo $sevenColumns[$j]; ?></span>
											<div style="display:none">
												<textarea name="col[]"><?php echo $sevenColumns[$j]; ?></textarea>
												<input type="hidden" name="true_false[]" value="false" />
											</div>
										<?php }elseif ($k == 8 && isset($eightColumns) && !empty($eightColumns) && !empty(trim($eightColumns[$j]))) { ?>
											<span class="textarea form-control form-control-textarea"><?php echo $eightColumns[$j]; ?></span>
											<div style="display:none">
												<textarea name="col[]"><?php echo $eightColumns[$j]; ?></textarea>
												<input type="hidden" name="true_false[]" value="false" />
											</div>
										<?php }elseif ($k == 9 && isset($nineColumns) && !empty($nineColumns) && !empty(trim($nineColumns[$j]))) { ?>
											<span class="textarea form-control form-control-textarea"><?php echo $nineColumns[$j]; ?></span>
											<div style="display:none">
												<textarea name="col[]"><?php echo $nineColumns[$j]; ?></textarea>
												<input type="hidden" name="true_false[]" value="false" />
											</div>
										<?php }elseif ($k == 10 && isset($tenColumns) && !empty($tenColumns) && !empty(trim($tenColumns[$j]))) { ?>
											<span class="textarea form-control form-control-textarea"><?php echo $tenColumns[$j]; ?></span>
											<div style="display:none">
												<textarea name="col[]"><?php echo $tenColumns[$j]; ?></textarea>
												<input type="hidden" name="true_false[]" value="false" />
											</div>
										<?php }else { ?>

											<span class="textarea form-control form-control-textarea" role="textbox" contenteditable placeholder="Write here...">
												<?php
													$newJ = "";
													if($practise['type'] == "one_blank_table"){
														if($flag=="1"){
															$newJ = $j+1;

														}else{
															$newJ = $j;
														}
													}else{
														$newJ = $j+1;

													}
													if ($answerExists) {
														if(isset($practise['user_answer'][0][0][$newJ]['col_' . $k])){
															echo $practise['user_answer'][0][0][$newJ]['col_' . $k];
														}
														else if(!empty($practise['user_answer'][0]['text_ans'][0][$newJ]['col_' . $k])){
																echo $practise['user_answer'][0]['text_ans'][0][$newJ]['col_' . $k];
														}
													}
												?>
											</span>
											<div style="display:none">
												<textarea name="col[]">
													<?php
														if ($answerExists) {
															if(isset($practise['user_answer'][0][0][$newJ]['col_' . $k])){
																				echo $practise['user_answer'][0][0][$newJ]['col_' . $k];
																			} else if(!empty($practise['user_answer'][0]['text_ans'][0][$newJ]['col_' . $k])){
																					echo $practise['user_answer'][0]['text_ans'][0][$newJ]['col_' . $k];
																			}
														}
													?>
												</textarea>
												<input type="hidden" name="true_false[]" value="true" />
											</div>
										<?php  } ?>
									</div>
								<?php $countElement++; } ?>
							</div>
							<?php }
						}else{ ?>
							<?php foreach($table_header as $j=>$quest){ ?>
							<div class="table-row thead-dark d-flex justify-content-between">
								<div class="d-flex justify-content-center align-items-center  border-left td <?php echo $columnClass; ?> td-textarea">
									<?php if (!empty(trim($quest))) { ?>
										<span class="textarea form-control form-control-textarea"><?php echo str_replace("--","",$quest); ?></span>
										<div style="display:none">
											<textarea name="col[]"><?php echo str_replace("--","",$quest); ?></textarea>
											<input type="hidden" name="true_false[]" value="false" />
										</div>
									<?php } else { ?>
										<span class="textarea form-control form-control-textarea" role="textbox" contenteditable placeholder="Write here...">
											<?php
									if ($answerExists) {
										echo $practise['user_answer'][0][0][$j]['col_1'];
									}
											?>
										</span>
										<div style="display:none">
											<textarea name="col[]">
											<?php
										if ($answerExists) {
											echo $practise['user_answer'][0][0][$j]['col_1'];
										}
											?>
											</textarea>
											<input type="hidden" name="true_false[]" value="true" />
										</div>
									<?php } ?>
								</div>
							</div>
							<?php } ?>
						<?php } ?>
					</div>
				</div>

 


			<?php if($practise['type'] == "one_blank_table_speaking" || $practise['type'] == "two_blank_table_speaking" || $practise['type'] == "three_blank_table_speaking" || $practise['type'] == "four_blank_table_speaking" || $practise['type'] == "five_blank_table_speaking" || $practise['type'] == "six_blank_table_speaking" || $practise['type'] == "seven_blank_table_speaking" || $practise['type'] == "eight_blank_table_speaking" || $practise['type'] == "nine_blank_table_speaking" || $practise['type'] == "ten_blank_table_speaking" || $practise['type'] == "one_table_option_speaking" || $practise['type'] == "two_table_option_speaking" || $practise['type'] == "three_table_option_speaking" || $practise['type'] == "four_table_option_speaking" || $practise['type'] == "five_table_option_speaking" || $practise['type'] == "six_table_option_speaking" || $practise['type'] == "seven_table_option_speaking" || $practise['type'] == "eight_table_option_speaking" || $practise['type'] == "nine_table_option_speaking" || $practise['type'] == "ten_table_option_speaking"){ ?>
				@include('practice.common.audio_record_div',['key'=>0])

				<?php $speakingPractise = true;?>
			<?php }?>

				<?php if($speakingPractise){?>
					<input type="hidden" name="speaking_one" value="true" />
				<?php }?>
	
					<div class="alert alert-success" role="alert" style="display:none"></div>
					<div class="alert alert-danger" role="alert" style="display:none"></div>
					<ul class="list-inline list-buttons">
						<li class="list-inline-item">
							<button type="button" class="save_btn btn btn-primary blankTableBtn_{{$practise['id']}}" data-is_save="0" >Save</button>
						</li>
						<li class="list-inline-item">
							<button type="button" class="submit_btn btn btn-primary blankTableBtn_{{$practise['id']}}" data-is_save="1"  >Submit</button>
						</li>
					</ul>
					<input type="hidden" name="table_type" value="<?php echo $columnCount; ?>" />
				</form>
			</div>
			@if($practise["markingmethod"] == "student_self_marking")
           
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

		<script type="text/javascript">
			$(".blank_textarea").keypress(
			function(event){
				if (event.which == '13') {
				event.preventDefault();
				}
			});
			$(".two_blank_table_up_writing_at_end_up_textarea").keypress(
			function(event){
				if (event.which == '13') {
				event.preventDefault();
				}
			});

			function setTextareaContent(){

				$("span.textarea.form-control").each(function(){
					var currentVal = $(this).html();
					// console.log('===========>', currentVal)
					$(this).next().find("textarea").val(currentVal);
				})
			}

			$(document).on('click','.blankTableBtn_{{$practise["id"]}}' ,function() {
				if($(this).attr('data-is_save') == '1'){
	                $(this).closest('.active').find('.msg').fadeOut();
	            }else{
	                $(this).closest('.active').find('.msg').fadeIn();
	            }

				var reviewPopup = '{!!$reviewPopup!!}';
				var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
						if(markingmethod =="student_self_marking"){
							
							if($(this).attr('data-is_save') == '1'){
								var fullView= $("#blank_table_form_{{$practise['id']}}").html();
								$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
								$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
								$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
								$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
								$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
								$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
								$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.textarea').attr("contenteditable","false");

							}
						}
						
						if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){
							
							$("#reviewModal_{{$practise['id']}}").modal('toggle');

						}
				$('.blankTableBtn_{{$practise["id"]}}').attr('disabled','disabled');
				var is_save = $(this).attr('data-is_save');
				$('.is_save:hidden').val(is_save);

				$("span.textarea.form-control").each(function(){
					var currentVal = $(this).text();
					$(this).next().find("textarea").val(currentVal);
				});

				$.ajax({
					url: '<?php echo URL('save-blank-table'); ?>',
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					type: 'POST',
					data: $('#blank_table_form_<?php echo $practise['id'];?>').serialize(),
					success: function (data) {
						$('.blankTableBtn_{{$practise["id"]}}').removeAttr('disabled');
						if(data.success) {
							if(is_save=="1"){
								// =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
								setTimeout(function(){
										$('.alert-success').hide();
									var isNextTaskDependent =  $('.nav-link.active').parent().next().find('a').attr('data-dependent');
									if( isNextTaskDependent == 1 ){
										var dependentPractiseId =  $('.nav-link.active').parent().next().find('a').attr('data-id');
										var baseUrl = "{{url('/')}}";
										var topic_id = "{{request()->segment(2)}}";
										var task_id = "{{request()->segment(3)}}";
											// //window.location.href=baseUrl+'/topic/'+topic_id+'/'+task_id+'?n='+dependentPractiseId
										////$('#abc-'+dependentPractiseId+'-tab').trigger('click');
									} else {
										// //$('.nav-link.active').parent().next().find('a').trigger('click');
									}
								},2000);
								// =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
							}
							$('.alert-danger').hide();
							$('.alert-success').show().html(data.message).fadeOut(8000);
						}else{
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
		<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
		<script>
			jQuery(function ($) {
				'use strict'
				var supportsAudio = !!document.createElement("audio").canPlayType;
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
					$('.column').addClass('hidden');
					var noSupport = $('#audio1').text();
					$('.container').append('<p class="no-support">' + noSupport + '</p>');
				}
			});
		</script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
		<?php } ?>

		<script>
			$(document).ready(function(){
				var n = 0;

				<?php if($practise['type'] == "six_blank_table_true_false"): ?>
					$('input:checkbox').change(function(e)
					{

						var ischecked= $(this).is(':checked');

						if(ischecked){
							$(this).closest('div').addClass('custom-checkbox_correct');
							$(this).prop('checked', true);
							$(this).attr('checked','checked');
							$(this).val(1);
							if($(this).parent('div').hasClass('custom-checkbox_incorrect')){
								$(this).closest('div').removeClass('custom-checkbox_incorrect');
							}
						}
						if(!ischecked)
						{
							if($(this).parent('div').hasClass('custom-checkbox_correct'))
							{
								$(this).closest('div').removeClass('custom-checkbox_correct').addClass('custom-checkbox_incorrect');
								$(this).prop('checked', true);
								$(this).attr('checked','checked');
								$(this).val(0);
							}
							else
							{
								$(this).closest('div').removeClass('custom-checkbox_incorrect').addClass('custom-checkbox_correct');
								$(this).prop('checked', true)
								$(this).attr('checked','checked');
								$(this).val(1);
							}
						}

					})

				<?php endif ?>
			})
		</script>
		<?php

	}else{
			
			
			if(isset($practise['options']) && !empty($practise['options'])){
				$options = $practise['options'];
				$allOptions = array();
				foreach($options as $option){
					$allOptions[] = $option[0];
				}
				$allOptions = array_chunk($allOptions,4);
				foreach($allOptions as $allOption){ ?>
					<div class="suggestion-list d-flex flex-wrap mb-4 justify-content-center">
						<?php foreach($allOption as $option){?>
							<div class="d-inline-flex flex-grow-1 suggestion_box justify-content-center w-25">
								<?php echo $option;?>
							</div>
						<?php }?>
					</div>
				<?php } 
			}


			$exploded_question = explode(PHP_EOL, $practise['question']);
			$checkFirstTwoChars = substr($exploded_question[0],0, 2);
			if($checkFirstTwoChars !== "--"){
				$check_custom_table_header = explode('/t', $exploded_question[0]);
				if(count($check_custom_table_header) > 1){
					$check_custom_table_header = explode("@@",$check_custom_table_header[0]);
					if(count($check_custom_table_header) > 0){ ?>
						<div class="dark-buttons row mb-4">
							<?php
							unset($check_custom_table_header[0]);
							foreach($check_custom_table_header as $coun=>$custom_option){
								$custom_option = explode("#%",$custom_option);
							?>
								<div class="col-4 mb-4"><a href="javascript:void(0);" data-toggle="modal" data-target="#deoModal_<?php echo $practise['id'];?>_<?php echo $coun;?>" class="btn btn-dark" style="display:block; text-align:center;"><?php echo $custom_option[0];?></a></div>
								<div class="modal" id="deoModal_<?php echo $practise['id'];?>_<?php echo $coun;?>" tabindex="-1" role="dialog" aria-labelledby="deoModalTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered deoModal" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title text-center" id="deoModalTitle"><?php echo $custom_option[0];?></h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<p><?php echo $custom_option[1];?></p>
											</div>
											<div class="modal-footer justify-content-center">
												<button type="button" class="btn btn-primary" data-dismiss="modal">Done</button>
											</div>
										</div>
									</div>
								</div>
							<?php }?>
						</div>
					<?php }


				}
				if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
					$originalPractiseAnswer = $practise['user_answer'];
					if(!empty($practise['user_answer'][0]['text_ans'])){
						$newMakeAnswer[0]['text_ans'][0] = $practise['user_answer'][0]['text_ans'][0];
						$newMakeAnswer[0]['text_ans'][1] = $practise['user_answer'][0]['text_ans'][1];
						if(isset($practise['user_answer'][0]['path'])){
							$newMakeAnswer[0]['path'] =$practise['user_answer'][0]['path'];
						}
						$practise['user_answer'] = $newMakeAnswer;
					} else if(!empty($practise['user_answer'][0][0])) {
						$newMakeAnswer = array();
						$newMakeAnswer[0][0] = $practise['user_answer'][0][0];
						$newMakeAnswer[0][1] = $practise['user_answer'][0][1];
						$practise['user_answer'] = $newMakeAnswer;


					}

					// pr($practise['user_answer']);die;

				}
			} 
			?>
	
			<?php 	$speakingPractise = false;
			if($practise['type'] == "one_blank_table_speaking_up" || $practise['type'] == "two_blank_table_speaking_up" || $practise['type'] == "three_blank_table_speaking_up" || $practise['type'] == "four_blank_table_speaking_up" || $practise['type'] == "five_blank_table_speaking_up" || $practise['type'] == "six_blank_table_speaking_up" || $practise['type'] == "seven_blank_table_speaking_up" || $practise['type'] == "eight_blank_table_speaking_up" || $practise['type'] == "nine_blank_table_speaking_up" || $practise['type'] == "ten_blank_table_speaking_up" || $practise['type'] == "one_table_option_speaking_up" || $practise['type'] == "two_table_option_speaking_up" || $practise['type'] == "three_table_option_speaking_up" || $practise['type'] == "four_table_option_speaking_up" || $practise['type'] == "five_table_option_speaking_up" || $practise['type'] == "six_table_option_speaking_up" || $practise['type'] == "seven_table_option_speaking_up" || $practise['type'] == "eight_table_option_speaking_up" || $practise['type'] == "nine_table_option_speaking_up" || $practise['type'] == "ten_table_option_speaking_up"){ ?>
						@include('practice.common.audio_record_div',['key'=>0])
						<?php 	$speakingPractise = true;?>
				<?php } ?>
				<div class="table-container">
				    <form class="save_two_blank_table_form" id="blank_table_form_<?php echo $practise['id'];?>">

						<div class="previous_practice_answer_exists_{{$practise['id']}}" style="{{$style}}">
							<div class="showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}">
							</div>
						</div>
					<?php if($speakingPractise){?>
						<input type="hidden" name="speaking_one" value="true" />
					<?php }?>
			        <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
			        <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
			        <input type="hidden" class="is_save" name="is_save" value="">
			        <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
		    		<?php
						if($practise['type'] == "two_blank_table_up_writing_at_end_up" || $practise['type'] == "writing_at_end_four_blanks_table" || $practise['type'] == "writing_at_end_up_four_blanks_table"){
							$wholeQuestion = explode("/t",$practise['question']);
							$exploded_question = explode(PHP_EOL, $wholeQuestion[1]);
						}else{
							$exploded_question = explode(PHP_EOL, $practise['question']);
						}
						$checkFirstTwoChars = substr($exploded_question[0],0, 2);
						if($checkFirstTwoChars !== "--"){
							//pr($practise);die;
							$check_custom_table_header = explode('/t', $exploded_question[0]);
							if(count($check_custom_table_header) > 1){
								$table_header = explode('@@', $check_custom_table_header[1]);
							}else{
								$table_header = explode('@@', $exploded_question[0]);
							}

							$columnsStartWith = 1;
						}else{
							$table_header = array();
							$columnsStartWith = 0;
						}
						$answerExists = false;
						if (isset($practise['user_answer']) && !empty($practise['user_answer']))
						{
						    $answerExists = true;
						}


							// dd($columnsStartWith);
						$flag = "";
						if (isset($exploded_question[$columnsStartWith]) && is_numeric($exploded_question[$columnsStartWith]))
						{
							// dd("sssss");
							$flag = "1";
						    $firstColumns = array();
							$totalColumnCounts = $exploded_question[$columnsStartWith];
						}
						elseif(isset($exploded_question[$columnsStartWith]))
						{
							$flag = "2";
							// dd($exploded_question[$columnsStartWith]);
							$firstColumns = explode('@@', $exploded_question[$columnsStartWith]);
							// dd($firstColumns);
							$totalColumnCounts = count($firstColumns);
						}else{
							$firstColumns = array();
						}
						$columnsStartWith++;

						$secondColumns = array();
						if (isset($exploded_question[$columnsStartWith]) && is_numeric($exploded_question[$columnsStartWith]))
						{
						    $secondColumns = array();
							$totalColumnCounts = $exploded_question[$columnsStartWith];
						}
						elseif(isset($exploded_question[$columnsStartWith]))
						{
							$secondColumns = explode('@@', $exploded_question[$columnsStartWith]);
							$totalColumnCounts = count($secondColumns);
						}
						$columnsStartWith++;

						$thirdColumns = array();
						if (isset($exploded_question[$columnsStartWith]) && is_numeric($exploded_question[$columnsStartWith]))
						{
						    $thirdColumns = array();
							$totalColumnCounts = $exploded_question[$columnsStartWith];
						}
						elseif(isset($exploded_question[$columnsStartWith]))
						{
							$thirdColumns = explode('@@', $exploded_question[$columnsStartWith]);
							$totalColumnCounts = count($thirdColumns);
						}
						$columnsStartWith++;

						$fourColumns = array();
						if (isset($exploded_question[$columnsStartWith]) && is_numeric($exploded_question[$columnsStartWith]))
						{
						    $fourColumns = array();
							$totalColumnCounts = $exploded_question[$columnsStartWith];
						}
						elseif(isset($exploded_question[$columnsStartWith]))
						{
							$fourColumns = explode('@@', $exploded_question[$columnsStartWith]);
							$totalColumnCounts = count($fourColumns);
						}
						$columnsStartWith++;

						$fiveColumns = array();
						if (isset($exploded_question[$columnsStartWith]) && is_numeric($exploded_question[$columnsStartWith]))
						{
						    $fiveColumns = array();
							$totalColumnCounts = $exploded_question[$columnsStartWith];
						}
						elseif(isset($exploded_question[$columnsStartWith]))
						{
							$fiveColumns = explode('@@', $exploded_question[$columnsStartWith]);
							$totalColumnCounts = count($fiveColumns);
						}
						$columnsStartWith++;

						$sixColumns = array();
						if (isset($exploded_question[$columnsStartWith]) && is_numeric($exploded_question[$columnsStartWith]))
						{
						    $sixColumns = array();
							$totalColumnCounts = $exploded_question[$columnsStartWith];
						}
						elseif(isset($exploded_question[$columnsStartWith]))
						{
							$sixColumns = explode('@@', $exploded_question[$columnsStartWith]);
							$totalColumnCounts = count($sixColumns);
						}
						$columnsStartWith++;

						$sevenColumns = array();
						if (isset($exploded_question[$columnsStartWith]) && is_numeric($exploded_question[$columnsStartWith]))
						{
						    $sevenColumns = array();
							$totalColumnCounts = $exploded_question[$columnsStartWith];
						}
						elseif(isset($exploded_question[$columnsStartWith]))
						{
							$sevenColumns = explode('@@', $exploded_question[$columnsStartWith]);
							$totalColumnCounts = count($sevenColumns);
						}
						$columnsStartWith++;

						$eightColumns = array();
						if (isset($exploded_question[$columnsStartWith]) && is_numeric($exploded_question[$columnsStartWith]))
						{
						    $eightColumns = array();
							$totalColumnCounts = $exploded_question[$columnsStartWith];
						}
						elseif(isset($exploded_question[$columnsStartWith]))
						{
							$eightColumns = explode('@@', $exploded_question[$columnsStartWith]);
							$totalColumnCounts = count($eightColumns);
						}
						$columnsStartWith++;

						$nineColumns = array();
						if (isset($exploded_question[$columnsStartWith]) && is_numeric($exploded_question[$columnsStartWith]))
						{
						    $nineColumns = array();
							$totalColumnCounts = $exploded_question[$columnsStartWith];
						}
						elseif(isset($exploded_question[$columnsStartWith]))
						{
							$nineColumns = explode('@@', $exploded_question[$columnsStartWith]);
							$totalColumnCounts = count($nineColumns);
						}
						$columnsStartWith++;

						$tenColumns = array();
						if (isset($exploded_question[$columnsStartWith]) && is_numeric($exploded_question[$columnsStartWith]))
						{
						    $tenColumns = array();
							$totalColumnCounts = $exploded_question[$columnsStartWith];
						}
						elseif(isset($exploded_question[$columnsStartWith]))
						{
							$tenColumns = explode('@@', $exploded_question[$columnsStartWith]);
							$totalColumnCounts = count($tenColumns);
						}




						$columnCount = 1;
					    if ($practise['type'] == "two_blank_table" || $practise['type'] == "two_blank_table_listening" || $practise['type'] == "two_blanks_table_listening" || $practise['type'] == "two_table_option" || $practise['type'] == "two_blank_table_speaking" || $practise['type'] == "two_table_option_speaking" || $practise['type'] == "two_blank_table_speaking_up" || $practise['type'] == "two_table_option_listening" || $practise['type'] == "two_table_option_speaking_up" || $practise['type'] == "two_blank_table_up_writing_at_end_up")
						{
						    $columnCount = 2;
							$columnClass = 'w-50';
							$tableHeaderColumnClass = (count($table_header)==2)?'w-50':'w-100';
						} 

						$countElement = 0;
					
						if($practise['type'] == "writing_at_end_four_blanks_table" || $practise['type'] == "writing_at_end_up_four_blanks_table"){
							$wholeQuestion = explode("/t",$practise['question']);
							$exploded_question = explode(PHP_EOL, $wholeQuestion[0]);
							foreach($exploded_question as $counttt=>$question){
								$displayQuestion = explode("@@",$question);
								if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
									if(isset($practise['user_answer'][1][$counttt])){
										$val = $practise['user_answer'][1][$counttt];
									}else{
										$val = '';
									}
								}else{
									$val = '';
								}


								if(count($displayQuestion) > 1){
								?>
								<div class="form-group d-flex align-items-start form-group-label mb-4">
									<span class="label"><?php echo $displayQuestion[0];?></span>
									<span class="textarea form-control form-control-textarea blank_textarea stringProper text-left" role="textbox" contenteditable="" placeholder="Write here...">{{isset($tempPracticeData['user_answer'][1][$counttt]) ? $tempPracticeData['user_answer'][1][$counttt] :''}}</span>
									<div style="display:none">
								<textarea name="blanks_up[]"><?php echo $val;?></textarea>
								</div>
								</div>
								<?php }else{
									echo "<p><strong>".$question."</strong></p>"; ?>
									<div style="display:none">
								<textarea name="blanks_up[]"><?php echo $val;?></textarea>
								</div>
								<?php }?>

							<?php }
						}
					?>

					<div class="table-container mb-4 text-center">
						<div class="table m-auto">
							<?php if($columnCount >= 1 && !empty($table_header)){?>
							<div class="table-heading thead-dark d-flex justify-content-between">
								<?php foreach ($table_header as $table_head) { ?>
								<div class="d-flex justify-content-center align-items-center th <?php echo $tableHeaderColumnClass; ?>"><?php echo $table_head; ?>
									<div style="display:none;">
										<textarea name="col[]"><?php echo $table_head; ?></textarea>
										<input type="hidden" name="true_false[]" value="false" />
									</div>
								</div>
								<?php $countElement++;} ?>
							</div>
							<?php }

							if(isset($firstColumns) && !empty($firstColumns)){
								$firstColumns[0] = str_replace("-","",$firstColumns[0]);
							}
							
							$fcData = array();
							if( !empty($practise['dependingpractise_answer']) && !empty($practise['typeofdependingpractice']) && $practise['typeofdependingpractice']=='reading_total_blanks_generate_questions_numbers_before'  ) {
						  
								
								if(!empty($practise['dependingpractise_answer'][0][0])){
									foreach( $practise['dependingpractise_answer'][0][0] as $key => $value){
										if( !empty($practise['dependingpractise_answer'][0][1][$key] )){
											$m=1;
											foreach($practise['dependingpractise_answer'][0][1][$key] as $k=>$v){
												if( !empty($practise['dependingpractise_answer'][0][1][$key][$k]) && $practise['dependingpractise_answer'][0][1][$key][$k]=='true' ){
													array_push($fcData,$value['col_'.$m]);
													//$fcData[$fc] = $value['col_'];
				
													$m++; 
												}
											}
										}
										$firstColumns =$fcData;
										$totalColumnCounts = count($firstColumns);
									}
								} 
								 
							} else {
								if( !empty($practise['dependingpractise_answer']) && !empty($practise['typeofdependingpractice']) && $practise['typeofdependingpractice']=='get_answers_put_into_quetions'  ) {
									foreach( $practise['dependingpractise_answer'][0][0] as $key => $value){
										if( !empty($practise['dependingpractise_answer'][0][1][$key][1]) && $practise['dependingpractise_answer'][0][1][$key][1]=='true' ){
											//$fcData[$fc] = $value['col_2'];
											array_push($fcData,$value['col_2']);
											
										}
										$firstColumns =$fcData;
										$totalColumnCounts = count($firstColumns);
									}
								}
							}
							//pr($firstColumns);
							if(isset($totalColumnCounts)){
								for ($j = 0;$j < $totalColumnCounts;$j++) {  ?>
								<div class="table-row thead-dark d-flex justify-content-between">
								  <?php for ($k = 1;$k <= $columnCount;$k++) { ?>
										<div class="d-flex justify-content-center align-items-center  border-left td <?php echo $columnClass; ?> td-textarea">
											<?php if ( isset($firstColumns[$j]) && $k == 1 && isset($firstColumns) && !empty($firstColumns) && !empty(trim($firstColumns[$j]))  && $firstColumns[$j]!=""  ) { ?>
												<span class="textarea form-control form-control-textarea"><?php echo $firstColumns[$j]; ?></span>
												<div style="display:none">
													<textarea name="col[]"><?php echo $firstColumns[$j]; ?></textarea>
													<input type="hidden" name="true_false[]" value="false" />
												</div>
											<?php }elseif (isset($secondColumns[$j]) && $k == 2 && isset($secondColumns) && !empty($secondColumns) && !empty(trim($secondColumns[$j]))) {  ?>
												<span class="textarea form-control form-control-textarea"><?php echo $secondColumns[$j]; ?></span>
												<div style="display:none">
													<textarea name="col[]"><?php echo $secondColumns[$j]; ?></textarea>
													<input type="hidden" name="true_false[]" value="false" />
												</div>
											<?php }elseif ($k == 3 && isset($thirdColumns) && !empty($thirdColumns) && !empty(trim($thirdColumns[$j]))) { ?>
												<span class="textarea form-control form-control-textarea"><?php echo $thirdColumns[$j]; ?></span>
												<div style="display:none">
													<textarea name="col[]"><?php echo $thirdColumns[$j]; ?></textarea>
													<input type="hidden" name="true_false[]" value="false" />
												</div>
											<?php }elseif ($k == 4 && isset($fourColumns) && !empty($fourColumns) && !empty(trim($fourColumns[$j]))) { ?>
												<span class="textarea form-control form-control-textarea"><?php echo $fourColumns[$j]; ?></span>
												<div style="display:none">
													<textarea name="col[]"><?php echo $fourColumns[$j]; ?></textarea>
													<input type="hidden" name="true_false[]" value="false" />
												</div>
											<?php }elseif ($k == 5 && isset($fiveColumns) && !empty($fiveColumns) && !empty(trim($fiveColumns[$j]))) { ?>
												<span class="textarea form-control form-control-textarea"><?php echo $fiveColumns[$j]; ?></span>
												<div style="display:none">
													<textarea name="col[]"><?php echo $fiveColumns[$j]; ?></textarea>
													<input type="hidden" name="true_false[]" value="false" />
												</div>
											<?php }elseif ($k == 6 && isset($sixColumns) && !empty($sixColumns) && !empty(trim($sixColumns[$j]))) { ?>
												<span class="textarea form-control form-control-textarea"><?php echo $sixColumns[$j]; ?></span>
												<div style="display:none">
													<textarea name="col[]"><?php echo $sixColumns[$j]; ?></textarea>
													<input type="hidden" name="true_false[]" value="false" />
												</div>
											<?php }elseif ($k == 7 && isset($sevenColumns) && !empty($sevenColumns) && !empty(trim($sevenColumns[$j]))) { ?>
												<span class="textarea form-control form-control-textarea"><?php echo $sevenColumns[$j]; ?></span>
												<div style="display:none">
													<textarea name="col[]"><?php echo $sevenColumns[$j]; ?></textarea>
													<input type="hidden" name="true_false[]" value="false" />
												</div>
											<?php }elseif ($k == 8 && isset($eightColumns) && !empty($eightColumns) && !empty(trim($eightColumns[$j]))) { ?>
												<span class="textarea form-control form-control-textarea"><?php echo $eightColumns[$j]; ?></span>
												<div style="display:none">
													<textarea name="col[]"><?php echo $eightColumns[$j]; ?></textarea>
													<input type="hidden" name="true_false[]" value="false" />
												</div>
											<?php }elseif ($k == 9 && isset($nineColumns) && !empty($nineColumns) && !empty(trim($nineColumns[$j]))) { ?>
												<span class="textarea form-control form-control-textarea"><?php echo $nineColumns[$j]; ?></span>
												<div style="display:none">
													<textarea name="col[]"><?php echo $nineColumns[$j]; ?></textarea>
													<input type="hidden" name="true_false[]" value="false" />
												</div>
											<?php }elseif ($k == 10 && isset($tenColumns) && !empty($tenColumns) && !empty(trim($tenColumns[$j]))) { ?>
												<span class="textarea form-control form-control-textarea"><?php echo $tenColumns[$j]; ?></span>
												<div style="display:none">
													<textarea name="col[]"><?php echo $tenColumns[$j]; ?></textarea>
													<input type="hidden" name="true_false[]" value="false" />
												</div>
											<?php }else { ?>

												<?php if($practise['type'] == "six_blank_table_true_false"){
													$checked = false;
			                                        $current_class = '';
			                                        $check_value = null;
													if ($answerExists) {
													
			                                            if(isset($practise['user_answer'][0][0][$j + 1]['col_' . $k]))
			                                            {
			                                                $checked = false;

			                                                if($practise['user_answer'][0][0][$j + 1]['col_' . $k] == "1")
			                                                {
			                                                    $current_class = 'custom-checkbox_correct';
			                                                    $check_value = 1;
			                                                    $checked = true;
			                                                }
			                                                elseif($practise['user_answer'][0][0][$j + 1]['col_' . $k] == "0"){
			                                                    $current_class = 'custom-checkbox_incorrect';
			                                                    $check_value = 0;
			                                                    $checked = true;
			                                                }
			                                                else
			                                                {
			                                                    $checked = false;
			                                                }
			                                            }
													}
													?>

													<div class="custom-control custom-checkbox custom-checkbox_single  {{$current_class}}">
														<input type="hidden" name="col[<?php echo $countElement;?>]" value="">
				                                        <input name="col[<?php echo $countElement;?>]" type="checkbox" class="custom-control-input" id="cc<?php echo $k.$j;?>" value="{{$check_value}}" <?php if($checked){?> checked="checked" <?php }?>>
														<label class="custom-control-label" for="cc<?php echo $k.$j;?>"></label>
													</div>
													<input type="hidden" name="true_false[]" value="true" />
												<?php } else{ ?>
														<span class="textarea form-control form-control-textarea" role="textbox" contenteditable placeholder="Write here...">

															<?php
																$newJ = "";
																if($practise['type'] == "one_blank_table"){
																	if($flag=="1"){
																		$newJ = $j+1;

																	}else{
																		$newJ = $j;
																	}
																}else{
																	$newJ = $j+1;

																}
															    if ($answerExists) {
																	if(isset($practise['user_answer'][0][0][$newJ]['col_' . $k])){
																		echo $practise['user_answer'][0][0][$newJ]['col_' . $k];
																	}
																	else if(!empty($practise['user_answer'][0]['text_ans'][0][$newJ]['col_' . $k])){
																			echo $practise['user_answer'][0]['text_ans'][0][$newJ]['col_' . $k];
																	}
											            		}
															?>

														</span>
														<div style="display:none">
															<textarea name="col[]">
																<?php
														            if ($answerExists) {
														                if(isset($practise['user_answer'][0][0][$newJ]['col_' . $k])){
																							echo $practise['user_answer'][0][0][$newJ]['col_' . $k];
																						} else if(!empty($practise['user_answer'][0]['text_ans'][0][$newJ]['col_' . $k])){
																								echo $practise['user_answer'][0]['text_ans'][0][$newJ]['col_' . $k];
																						}
														            }
																?>
															</textarea>
															<input type="hidden" name="true_false[]" value="true" />
														</div>


													<?php }
											} ?>
										</div>
									<?php $countElement++; } ?>
								</div>
								<?php }
							}else{ ?>
								<?php foreach($table_header as $j=>$quest){ ?>
								<div class="table-row thead-dark d-flex justify-content-between">
									<div class="d-flex justify-content-center align-items-center  border-left td <?php echo $columnClass; ?> td-textarea">
										<?php if (!empty(trim($quest))) { ?>
											<span class="textarea form-control form-control-textarea"><?php echo str_replace("--","",$quest); ?></span>
											<div style="display:none">
												<textarea name="col[]"><?php echo str_replace("--","",$quest); ?></textarea>
												<input type="hidden" name="true_false[]" value="false" />
											</div>
										<?php } else { ?>
											<span class="textarea form-control form-control-textarea" role="textbox" contenteditable placeholder="Write here...">
												<?php
													if ($answerExists) {
														echo $practise['user_answer'][0][0][$j]['col_1'];
													}
												?>
											</span>
											<div style="display:none">
												<textarea name="col[]">
												<?php
											if ($answerExists) {
												echo $practise['user_answer'][0][0][$j]['col_1'];
											}
												?>
												</textarea>
												<input type="hidden" name="true_false[]" value="true" />
											</div>
										<?php } ?>
									</div>
								</div>
								<?php } ?>
							<?php } ?>
						</div>
					</div>


				<?php
			if($practise['type'] == "two_blank_table_up_writing_at_end_up"){
				$wholeQuestion = explode("/t",$practise['question']);
				$exploded_question = explode(PHP_EOL, $wholeQuestion[0]);
				foreach($exploded_question as $counttt=>$question){
					$displayQuestion = explode("@@",$question);
					$val = '';

			        if (strpos($question, '@@') !== false) {
			            $val = isset($practise['user_answer']) && !empty($practise['user_answer']) ? $originalPractiseAnswer[1][$counttt] : "";
			        }

					if(count($displayQuestion) > 1){ ?>
						<div class="form-group d-flex align-items-start form-group-label mb-4">
							<span class="label"><?php echo $displayQuestion[0];?></span>
							<span class="textarea form-control form-control-textarea two_blank_table_up_writing_at_end_up_textarea" role="textbox" contenteditable="" placeholder="Write here..."><?php echo $val;?></span>
							<div style="display:none">
						<textarea name="blanks_up[]"><?php echo $val;?></textarea>
						</div>
						</div>
						<?php }else{
							echo "<p><strong>".$question."</strong></p>"; ?>
							<div style="display:none">
								<textarea name="blanks_up[]"><?php echo $val;?></textarea>
							</div>
					<?php }?>

				<?php }
			}
			?>




		

			<?php if($speakingPractise){?>
				<input type="hidden" name="speaking_one" value="true" />
			<?php }?>

				<div class="alert alert-success" role="alert" style="display:none"></div>
				<div class="alert alert-danger" role="alert" style="display:none"></div>
				<ul class="list-inline list-buttons">
					<li class="list-inline-item">
						<button type="button" class="save_btn btn btn-primary blankTableBtn_dependacy_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="0" >Save</button>
					</li>
					<li class="list-inline-item">
						<button type="button" class="submit_btn btn btn-primary submitBtn blankTableBtn_dependacy_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1">Submit</button>
					</li>
				</ul>
				<input type="hidden" name="table_type" value="<?php echo $columnCount; ?>" />
			</form>
	    </div>
		@if($practise["markingmethod"] == "student_self_marking")
           
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
	    <script type="text/javascript">
	    			$(document).on('click','.blankTableBtn_dependacy_{{$practise["id"]}}' ,function() {
						var reviewPopup = '{!!$reviewPopup!!}';
				var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
						if(markingmethod =="student_self_marking"){
							
							if($(this).attr('data-is_save') == '1'){
								var fullView= $("#blank_table_form_{{$practise['id']}}").html();
								$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
								$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
								$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
								$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
								$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
								$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
								$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.textarea').attr("contenteditable","false");
							}
						}
						
						if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){
							
							$("#reviewModal_{{$practise['id']}}").modal('toggle');

						}
					  	$('.blankTableBtn_dependacy_{{$practise["id"]}}').attr('disabled','disabled');
					  	var is_save = $(this).attr('data-is_save');
					  	$('.is_save:hidden').val(is_save);

						$("span.textarea.form-control").each(function(){
							var currentVal = $(this).text();
							$(this).next().find("textarea").val(currentVal);
						});

					  	$.ajax({
					      	url: '<?php echo URL('save-blank-table-dependancy'); ?>',
					      	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					      	type: 'POST',
					      	data: $('#blank_table_form_<?php echo $practise['id'];?>').serialize(),
					        success: function (data) {
					        	$('.blankTableBtn_dependacy_{{$practise["id"]}}').removeAttr('disabled');
								if(data.success) {
									if(is_save=="1"){
										// =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
										setTimeout(function(){
												$('.alert-success').hide();
											var isNextTaskDependent =  $('.nav-link.active').parent().next().find('a').attr('data-dependent');
											if( isNextTaskDependent == 1 ){
												var dependentPractiseId =  $('.nav-link.active').parent().next().find('a').attr('data-id');
												var baseUrl = "{{url('/')}}";
												var topic_id = "{{request()->segment(2)}}";
												var task_id = "{{request()->segment(3)}}";
													//window.location.href=baseUrl+'/topic/'+topic_id+'/'+task_id+'?n='+dependentPractiseId
												////$('#abc-'+dependentPractiseId+'-tab').trigger('click');
											} else {
												// //$('.nav-link.active').parent().next().find('a').trigger('click');
											}
										},2000);
										// =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
									}
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
	    <?php
	}
?>


<script>
	if(data1==undefined ){
		var data1=[];
	} 
	data1["{{$practise['id']}}"]= {"dependentpractice_ans": "{{$data[$practise['id']]['dependentpractice_ans']}}" };
	data1["{{$practise['id']}}"]["isRolePlayPractice"] = "{{$data[$practise['id']]['isRolePlayPractice']}}"
	data1["{{$practise['id']}}"]["is_dependent"] = "{{$data[$practise['id']]['is_dependent']}}"; 
	if(data1["{{$practise['id']}}"]["is_dependent"]==1){
		
		if(data1["{{$practise['id']}}"]["dependentpractice_ans"]==0 ){
			$(".previous_practice_answer_exists_{{$practise['id']}}").hide();
			$("#dependant_pr_{{$practise['id']}}").show();
		} else {
			$(".previous_practice_answer_exists_{{$practise['id']}}").show();
			$("#dependant_pr_{{$practise['id']}}").hide();
		}
	} else {

		$(".previous_practice_answer_exists_{{$practise['id']}}").show();
		$("#dependant_pr_{{$practise['id']}}").hide();
	}


</script>
@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==0 && $practise['typeofdependingpractice']!='get_answers_generate_quetions' )

<script>

	data1["{{$practise['id']}}"]["typeofdependingpractice"] = "{{ $data[$practise['id']]['typeofdependingpractice'] }}";
	data1["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
	if(data1["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data1["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data1["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data1["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data1["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data1["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data1["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view"){
	  
		data1["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
		data1["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
		// $(function () {
		// 	$('.cover-spin').fadeIn();
		// });
		var prectice_id = "{{$practise['id']}}";
		if(data1["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
			 
			// IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
			if(data1["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){

				setTimeout(function(){
				 
					 data1["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();				 
				 
					$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).html(data1["{{$practise['id']}}"]["prevHTML"]);
					$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
					$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
					$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert').remove();
					// 15569598685ccd527c4c933
					// 15569598685ccd527c4c933
					if(prectice_id == "15569598685ccd527c4c933"){
						$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).css('display','none');
					}
					if( data1["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" ){
						
						if(data1["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_no_blanks_listening_speaking_down"  || data1["{{$practise['id']}}"]["dependant_practise_question_type"]== "single_speaking_up_writing"|| data1["{{$practise['id']}}"]["dependant_practise_question_type"]== "listening_writing" ) {
							$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('.audio-player').remove();
							$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove(); 
						}
						if(data1["{{$practise['id']}}"]["question_type"] == "listening_writing") {
							$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('.audio-player').remove();
							$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove(); 
						}
					} 
					$('.cover-spin').fadeOut();
				 }, 8000 )
			}
		} else {
		 
			// IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
			// DO NOT REMOVE BELOW   CODE
			var baseUrl = "{{url('/')}}";
			data1["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
			data1["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data1["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data1["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data1["{{$practise['id']}}"]["dependant_practise_id"];
			$.get(data1["{{$practise['id']}}"]["dependentURL"],  //
			function (dataHTML, textStatus, jqXHR) {  // success callback
				data1["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
				$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).html(data1["{{$practise['id']}}"]["prevHTML"]);
				$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
				$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, .alert, input').remove();
				
				if(data1["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" ){
					 
					if(data1["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_no_blanks_listening_speaking_down" || data1["{{$practise['id']}}"]["dependant_practise_question_type"]== "single_speaking_up_writing") {
						$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
					}
				}
				$('.cover-spin').fadeOut();
			});
		}
	}  
</script>
@endif