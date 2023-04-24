<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
<p>
	<strong><?php echo $practise['title']; ?></strong>
</p>

<?php

if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
	$originalPractiseAnswer = $practise['user_answer'];
}

if(isset($practise['is_roleplay']) && $practise['is_roleplay'] == 1){ ?>
	@include('practice.blank_tables_roleplay')
<?php }else{

?>








<?php
//echo '<p>'.$practise['type'].'</p>'; ?>

<?php if(isset($practise['options']) && !empty($practise['options'])){
$options = $practise['options'];
$allOptions = array();
foreach($options as $option){
	$allOptions[] = $option[0];
}
$allOptions = array_chunk($allOptions,4);
foreach($allOptions as $allOption){
?>
<div class="suggestion-list d-flex flex-wrap mb-4 justify-content-center">
<?php foreach($allOption as $option){?>
<div class="d-inline-flex flex-grow-1 suggestion_box justify-content-center w-25">
	<?php echo $option;?>
</div>
<?php }?>
</div>
<?php }?>
<?php }?>


<?php

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
								</div>
								<div class="modal-body">
									<p><?php echo $custom_option[1];?></p>
								</div>
								<div class="modal-footer justify-content-center">
									<button type="button" class="btn  btn-dark" data-dismiss="modal">Done</button>
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
		} else if(isset($practise['user_answer'][0])) {
			$newMakeAnswer = array();
			$newMakeAnswer[0][0] = $practise['user_answer'][0][0];
			$newMakeAnswer[0][1] = $practise['user_answer'][0][1];
			$practise['user_answer'] = $newMakeAnswer;


		}

		// pr($practise['user_answer']);die;

	}
}
?>















<?php

$speakingPractise = false;

if($practise['type'] == "one_blank_table_listening" || $practise['type'] == "two_blank_table_listening" || $practise['type'] == "three_blank_table_listening" || $practise['type'] == "four_blank_table_listening" || $practise['type'] == "five_blank_table_listening" || $practise['type'] == "six_blank_table_listening" || $practise['type'] == "seven_blank_table_listening" || $practise['type'] == "eight_blank_table_listening" || $practise['type'] == "nine_blank_table_listening" || $practise['type'] == "ten_blank_table_listening" || $practise['type'] == "one_blanks_table_listening" || $practise['type'] == "two_blanks_table_listening" || $practise['type'] == "three_blanks_table_listening" || $practise['type'] == "four_blanks_table_listening" || $practise['type'] == "five_blanks_table_listening" || $practise['type'] == "six_blanks_table_listening" || $practise['type'] == "seven_blanks_table_listening" || $practise['type'] == "eight_blanks_table_listening" || $practise['type'] == "nine_blanks_table_listening" || $practise['type'] == "ten_blanks_table_listening" || $practise['type'] == "one_table_option_listening" || $practise['type'] == "two_table_option_listening" || $practise['type'] == "three_table_option_listening" || $practise['type'] == "four_table_option_listening" || $practise['type'] == "five_table_option_listening" || $practise['type'] == "six_table_option_listening"){?>
<div class="audio-player">
	<audio preload="auto" controls src="<?php echo $practise['audio_file'];?>" type="audio/mpga" id="audio_{{$practise['id']}}">
		<!-- <source  > -->
	</audio>
</div>
<?php }?>




<?php if($practise['type'] == "one_blank_table_speaking_up" || $practise['type'] == "two_blank_table_speaking_up" || $practise['type'] == "three_blank_table_speaking_up" || $practise['type'] == "four_blank_table_speaking_up" || $practise['type'] == "five_blank_table_speaking_up" || $practise['type'] == "six_blank_table_speaking_up" || $practise['type'] == "seven_blank_table_speaking_up" || $practise['type'] == "eight_blank_table_speaking_up" || $practise['type'] == "nine_blank_table_speaking_up" || $practise['type'] == "ten_blank_table_speaking_up" || $practise['type'] == "one_table_option_speaking_up" || $practise['type'] == "two_table_option_speaking_up" || $practise['type'] == "three_table_option_speaking_up" || $practise['type'] == "four_table_option_speaking_up" || $practise['type'] == "five_table_option_speaking_up" || $practise['type'] == "six_table_option_speaking_up" || $practise['type'] == "seven_table_option_speaking_up" || $practise['type'] == "eight_table_option_speaking_up" || $practise['type'] == "nine_table_option_speaking_up" || $practise['type'] == "ten_table_option_speaking_up"){ ?>
	@include('practice.common.audio_record_div',['key'=>0])
	<?php 	$speakingPractise = true;?>
<?php }?>







    <div class="table-container">
      <form class="save_two_blank_table_form" id="blank_table_form_<?php echo $practise['id'];?>">
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



							if (isset($exploded_question[$columnsStartWith]) && is_numeric($exploded_question[$columnsStartWith]))
							{
							    $firstColumns = array();
								$totalColumnCounts = $exploded_question[$columnsStartWith];
							}
							elseif(isset($exploded_question[$columnsStartWith]))
							{
								$firstColumns = explode('@@', $exploded_question[$columnsStartWith]);
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
							if ($practise['type'] == "one_blank_table" || $practise['type'] == "one_blank_table_listening" || $practise['type'] == "one_blanks_table_listening" || $practise['type'] == "one_table_option" || $practise['type'] == "one_blank_table_speaking" || $practise['type'] == "one_table_option_speaking" || $practise['type'] == "one_blank_table_speaking_up" || $practise['type'] == "one_table_option_listening")
							{
							    $columnCount = 1;
							    $columnClass = 'w-100';
							}
							elseif ($practise['type'] == "two_blank_table" || $practise['type'] == "two_blank_table_listening" || $practise['type'] == "two_blanks_table_listening" || $practise['type'] == "two_table_option" || $practise['type'] == "two_blank_table_speaking" || $practise['type'] == "two_table_option_speaking" || $practise['type'] == "two_blank_table_speaking_up" || $practise['type'] == "two_table_option_listening" || $practise['type'] == "two_table_option_speaking_up" || $practise['type'] == "two_blank_table_up_writing_at_end_up")
							{
							    $columnCount = 2;
							    $columnClass = 'w-50';
							}
							elseif ($practise['type'] == "three_blank_table" || $practise['type'] == "three_blank_table_listening" || $practise['type'] == "three_blanks_table_listening" || $practise['type'] == "three_table_option" || $practise['type'] == "three_blank_table_speaking" || $practise['type'] == "three_table_option_speaking" || $practise['type'] == "three_blank_table_speaking_up" || $practise['type'] == "three_table_option_listening")
							{
							    $columnCount = 3;
							    $columnClass = 'w-33';
							}
							elseif ($practise['type'] == "four_blank_table" || $practise['type'] == "four_blank_table_listening" || $practise['type'] == "four_blanks_table_listening" || $practise['type'] == "four_table_option" || $practise['type'] == "four_blank_table_speaking" || $practise['type'] == "four_table_option_speaking" || $practise['type'] == "four_blank_table_speaking_up" || $practise['type'] == "four_table_option_listening" || $practise['type'] == "writing_at_end_four_blanks_table" || $practise['type'] == "writing_at_end_up_four_blanks_table")
							{
							    $columnCount = 4;
							    $columnClass = 'w-25';
							}
							elseif ($practise['type'] == "five_blank_table" || $practise['type'] == "five_blank_table_listening" || $practise['type'] == "five_blanks_table_listening" || $practise['type'] == "five_table_option" || $practise['type'] == "five_blank_table_speaking" || $practise['type'] == "five_table_option_speaking" || $practise['type'] == "five_blank_table_speaking_up" || $practise['type'] == "five_table_option_listening")
							{
							    $columnCount = 5;
							    $columnClass = 'w-20';
							}
							elseif ($practise['type'] == "six_blank_table" || $practise['type'] == "six_blank_table_listening" || $practise['type'] == "six_blanks_table_listening" || $practise['type'] == "six_table_option" || $practise['type'] == "six_blank_table_speaking" || $practise['type'] == "six_table_option_speaking" || $practise['type'] == "six_blank_table_speaking_up" || $practise['type'] == "six_table_option_listening" || $practise['type'] == "six_blank_table_true_false")
							{
							    $columnCount = 6;
							    $columnClass = 'col-2';
							}
							elseif ($practise['type'] == "seven_blank_table" || $practise['type'] == "seven_blank_table_listening" || $practise['type'] == "seven_blanks_table_listening" || $practise['type'] == "seven_table_option" || $practise['type'] == "seven_blank_table_speaking" || $practise['type'] == "seven_table_option_speaking" || $practise['type'] == "seven_blank_table_speaking_up" || $practise['type'] == "seven_table_option_listening")
							{
							    $columnCount = 7;
							    $columnClass = '';
							}
							elseif ($practise['type'] == "eight_blank_table" || $practise['type'] == "eight_blank_table_listening" || $practise['type'] == "eight_blanks_table_listening" || $practise['type'] == "eight_table_option" || $practise['type'] == "eight_blank_table_speaking" || $practise['type'] == "eight_table_option_speaking" || $practise['type'] == "eight_blank_table_speaking_up" || $practise['type'] == "eight_table_option_listening")
							{
							    $columnCount = 8;
							    $columnClass = '';
							}
							elseif ($practise['type'] == "nine_blank_table" || $practise['type'] == "nine_blank_table_listening" || $practise['type'] == "nine_blanks_table_listening" || $practise['type'] == "nine_table_option" || $practise['type'] == "nine_blank_table_speaking" || $practise['type'] == "nine_table_option_speaking" || $practise['type'] == "nine_blank_table_speaking_up" || $practise['type'] == "nine_table_option_listening")
							{
							    $columnCount = 9;
							    $columnClass = '';
							}
							elseif ($practise['type'] == "ten_blank_table" || $practise['type'] == "ten_blank_table_listening" || $practise['type'] == "ten_blanks_table_listening" || $practise['type'] == "ten_table_option" || $practise['type'] == "ten_blank_table_speaking" || $practise['type'] == "ten_table_option_speaking" || $practise['type'] == "ten_blank_table_speaking_up" || $practise['type'] == "ten_table_option_listening")
							{
							    $columnCount = 10;
							    $columnClass = '';
							}

							$countElement = 0;
							?>


		<?php
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
					<span class="textarea form-control form-control-textarea" role="textbox" contenteditable="" placeholder="Write here..."><?php echo $val;?></span>
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
				<?php if($columnCount > 1 && !empty($table_header)){?>
				<div class="table-heading thead-dark d-flex justify-content-between">
					<?php foreach ($table_header as $table_head) { ?>
					<div class="d-flex justify-content-center align-items-center th <?php echo $columnClass; ?>"><?php echo $table_head; ?></div>
					<div style="display:none">
						<textarea name="col[]"><?php echo $table_head; ?></textarea>
						<input type="hidden" name="true_false[]" value="false" />
					</div>
					<?php $countElement++;} ?>
				</div>
				<?php }?>
				<?php

				if(isset($firstColumns) && !empty($firstColumns)){
					$firstColumns[0] = str_replace("-","",$firstColumns[0]);
				}

				if(isset($totalColumnCounts)){
				for ($j = 0;$j < $totalColumnCounts;$j++) { ?>
					<div class="table-row thead-dark d-flex justify-content-between">
					  <?php for ($k = 1;$k <= $columnCount;$k++) { ?>
							<div class="d-flex justify-content-center align-items-center  border-left td <?php echo $columnClass; ?> td-textarea">
								<?php if ($k == 1 && isset($firstColumns) && !empty($firstColumns) && !empty(trim($firstColumns[$j]))) { ?>
									<span class="textarea form-control form-control-textarea"><?php echo $firstColumns[$j]; ?></span>
									<div style="display:none">
										<textarea name="col[]"><?php echo $firstColumns[$j]; ?></textarea>
										<input type="hidden" name="true_false[]" value="false" />
									</div>
								<?php }elseif ($k == 2 && isset($secondColumns) && !empty($secondColumns) && !empty(trim($secondColumns[$j]))) { ?>
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

									<?php if($practise['type'] == "six_blank_table_true_false"){?>

									<?php
										$checked = false;
										if ($answerExists) {
											if(isset($practise['user_answer'][0][0][$j + 1]['col_' . $k]) && $practise['user_answer'][0][0][$j + 1]['col_' . $k] == 1){
												$checked = true;
											}
										}
										?>

									<div class="custom-control custom-checkbox custom-checkbox_single custom-checkbox_single_dark custom-checkbox_correct">
										<input type="hidden" name="col[<?php echo $countElement;?>]" value="">
										<input name="col[<?php echo $countElement;?>]" type="checkbox" class="custom-control-input" id="cc<?php echo $k.$j;?>" value="1" <?php if($checked){?> checked="checked" <?php }?>>
										<label class="custom-control-label" for="cc<?php echo $k.$j;?>"></label>
									</div>
									<input type="hidden" name="true_false[]" value="true" />
								<?php }else{?>





									<span class="textarea form-control form-control-textarea" role="textbox" contenteditable placeholder="Write here...">
										<?php
					            if ($answerExists) {
									if(isset($practise['user_answer'][0][0][$j + 1]['col_' . $k])){
										echo $practise['user_answer'][0][0][$j + 1]['col_' . $k];
									}
					            }
										?>
									</span>
									<div style="display:none">
										<textarea name="col[]">
										<?php
						            if ($answerExists) {
						                if(isset($practise['user_answer'][0][0][$j + 1]['col_' . $k])){
											echo $practise['user_answer'][0][0][$j + 1]['col_' . $k];
										}
						            }
										?>
										</textarea>
										<input type="hidden" name="true_false[]" value="true" />
									</div>


								<?php }?>

								<?php } ?>
							</div>
						<?php $countElement++; } ?>
					</div>
				<?php }
				}else{ ?>
					<?php

					foreach($table_header as $j=>$quest){



					?>
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
					<?php }?>
				<?php }?>


			</div>
		</div>


		<?php
		if($practise['type'] == "two_blank_table_up_writing_at_end_up"){
			$wholeQuestion = explode("/t",$practise['question']);
			$exploded_question = explode(PHP_EOL, $wholeQuestion[0]);
			foreach($exploded_question as $counttt=>$question){
				$displayQuestion = explode("@@",$question);

				if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
					$val = $practise['user_answer'][1][$counttt];
				}else{
					$val = '';
				}


				if(count($displayQuestion) > 1){
				?>
				<div class="form-group d-flex align-items-start form-group-label mb-4">
					<span class="label"><?php echo $displayQuestion[0];?></span>
					<span class="textarea form-control form-control-textarea" role="textbox" contenteditable="" placeholder="Write here..."><?php echo $val;?></span>
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




		<?php if($practise['type'] == "one_blank_table_speaking" || $practise['type'] == "two_blank_table_speaking" || $practise['type'] == "three_blank_table_speaking" || $practise['type'] == "four_blank_table_speaking" || $practise['type'] == "five_blank_table_speaking" || $practise['type'] == "six_blank_table_speaking" || $practise['type'] == "seven_blank_table_speaking" || $practise['type'] == "eight_blank_table_speaking" || $practise['type'] == "nine_blank_table_speaking" || $practise['type'] == "ten_blank_table_speaking" || $practise['type'] == "one_table_option_speaking" || $practise['type'] == "two_table_option_speaking" || $practise['type'] == "three_table_option_speaking" || $practise['type'] == "four_table_option_speaking" || $practise['type'] == "five_table_option_speaking" || $practise['type'] == "six_table_option_speaking" || $practise['type'] == "seven_table_option_speaking" || $practise['type'] == "eight_table_option_speaking" || $practise['type'] == "nine_table_option_speaking" || $practise['type'] == "ten_table_option_speaking"){ ?>
	@include('practice.common.audio_record_div',['key'=>0])
	<?php $speakingPractise = true;?>
<?php }?>

		<!-- <div class="audio-player d-flex flex-wrap justify-content-end">
	    <div class="audioplayer">
	        <audio preload="auto" controls="" style="display:none">
	            <source src="horse.mp3" type="audio/mp3">
	        </audio>
	         - <div class="audioplayer-playpause" title=""><a href="#"></a></div>
	        <div class="audioplayer-time audioplayer-time-current">00:00</div>
	        <div class="audioplayer-bar">
	            <div class="audioplayer-bar-loaded"></div>
	            <div class="audioplayer-bar-played"></div>
	        </div>
	        <div class="audioplayer-time audioplayer-time-duration">…</div>
	        <div class="audioplayer-volume">
	            <div class="audioplayer-volume-button" title=""><a href="#"></a></div>
	            <div class="audioplayer-volume-adjust">
	                <div>
	                    <div style="width: 100%;"></div>
	                </div>
	            </div>
	        </div> -
	    </div>
		</div> -->
		<?php /*?><ul class="list-inline list-buttons">
			<li class="list-inline-item"><a href="#!" class="btn btn-primary"
					data-toggle="modal" data-target="#exitmodal">Save</a>
			</li>
			<li class="list-inline-item"><a href="#!"
					class="btn btn-primary">Submit</a>
			</li>
		</ul><?php */ ?>

		<?php if($speakingPractise){?>
			<input type="hidden" name="speaking_one" value="true" />
		<?php }?>

				<div class="alert alert-success" role="alert" style="display:none"></div>
				<div class="alert alert-danger" role="alert" style="display:none"></div>
				<ul class="list-inline list-buttons">
					<li class="list-inline-item"><input type="button" class="twoBlankTableBtn btn btn-primary save_btn" value="Save" data-is_save="0"></li>
					<li class="list-inline-item"><input type="button" class="twoBlankTableBtn btn btn-primary submit_btn" value="Submit" data-is_save="1"></li>
				</ul>
				<input type="hidden" name="table_type" value="<?php echo $columnCount; ?>" />
			</form>
    </div>

<script type="text/javascript">
function setTextareaContent(){
	$("span.textarea.form-control").each(function(){
		var currentVal = $(this).html();
		$(this).next().find("textarea").val(currentVal);
	})
}
</script>
<script type="text/javascript">
$(document).on('click','.twoBlankTableBtn' ,function() {
	if($(this).attr('data-is_save') == '1'){
	    $(this).closest('.active').find('.msg').fadeOut();
	  }else{
	    $(this).closest('.active').find('.msg').fadeIn();
	  }
		  
	if($(this).attr('data-is_save') == '1'){
	    $(this).closest('.active').find('.msg').fadeOut();
	  }else{
	    $(this).closest('.active').find('.msg').fadeIn();
	  }
	  
  $('.twoBlankTableBtn').attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.is_save:hidden').val(is_save);
  setTextareaContent();
  $.ajax({
      url: '<?php echo URL('save-blank-table'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('#blank_table_form_<?php echo $practise['id'];?>').serialize(),
      success: function (data) {
        	$('.twoBlankTableBtn').removeAttr('disabled');
					if(data.success){
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
      data: {practice_id:"{{$practise['id']}}"},
      success: function (data) {

      }
  });
});
</script>
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
<!-- <script src="{{ asset('public/js/audioplayer.js') }}"></script>
<script>
$(function () {
	$('audio').audioPlayer();
});
</script> -->

<script>jQuery(function ($) {
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
            // no audio support
            $('.column').addClass('hidden');
            var noSupport = $('#audio1').text();
            $('.container').append('<p class="no-support">' + noSupport + '</p>');
        }
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>

<?php }?>
