
<p>
	<strong><?php echo $practise['title']; ?></strong>
</p>
<?php
    if(isset($practise['dependingpractiseid'])) {
        $depend = explode("_",$practise['dependingpractiseid']);
    }
    $exploded_question = explode(PHP_EOL, $practise['question']);
?>
<?php if(isset($practise['dependingpractiseid'])): ?>
<p>
    <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;" data-value="{{$practise['id']}}">
        <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
    </div>
</p>
<?php endif ?>
    <div class="table-container">
      <form class="save_two_blank_table_listening_form_{{$practise['id']}}">
        <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
        <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
        <input type="hidden" class="is_save" name="is_save" value="">
        <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
        <?php if(isset($depend)): ?>
            <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
            <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
        <?php endif;?>
        <?php

            $exploded_question = explode(PHP_EOL, $practise['question']);
            $table_header = explode('@@', $exploded_question[0]);

			$answerExists = false;
			if (isset($practise['user_answer']) && !empty($practise['user_answer'])) {
			    $answerExists = true;
			}
			if (is_numeric($exploded_question[1])) {
			    $firstColumns = array();
			} else {
			    $firstColumns = explode('@@', $exploded_question[1]);
			    $exploded_question[1] = count($firstColumns);
			}
			if ($practise['type'] == "two_blank_table_listening"){
			    $columnCount = 2;
			    $columnClass = 'w-50';
            } else {
                $columnCount = 1;
            }

		?>
		<div class="table-container mb-4 text-center">
			<div class="table w-75 m-auto">
				<div class="table-heading thead-dark d-flex justify-content-between">
					<?php foreach ($table_header as $key=> $table_head): ?>
                        <?php $table_head = str_replace('/t','',$table_head); ?>
						<div class="d-flex justify-content-center align-items-center th <?php echo $columnClass; ?>"><?php echo $table_head; ?></div>
						<div style="display:none">
							<textarea name="col[]"><?php echo $table_head; ?></textarea>
							<input type="hidden" name="true_false[]" value="false" />
						</div>
                    <?php endforeach;	?>
				</div>
				<?php for ($j = 0;$j < $exploded_question[1];$j++) { ?>
					<div class="table-row thead-dark d-flex justify-content-between">
					  <?php for ($k = 1;$k <= $columnCount;$k++) { ?>
							<div class="d-flex justify-content-center align-items-center  border-left td <?php echo $columnClass; ?> td-textarea">
								<?php if ($k == 1 && isset($firstColumns) && !empty($firstColumns)) { ?>
									<span class="textarea form-control form-control-textarea"><?php echo $firstColumns[$j]; ?></span>
									<div style="display:none">
										<textarea name="col[]"><?php echo $firstColumns[$j]; ?></textarea>
										<input type="hidden" name="true_false[]" value="false" />
									</div>
								<?php } else { ?>
									<span class="textarea form-control form-control-textarea" role="textbox" disabled contenteditable placeholder="Write here...">
                                        <?php if($answerExists){
					                        echo $practise['user_answer'][0][0][$j + 1]['col_' . $k];
					                    }
										?>
									</span>
									<div style="display:none">
										<textarea name="col[]">
										<?php if ($answerExists){
                                                echo $practise['user_answer'][0][0][$j + 1]['col_' . $k];
                                            }
										?>
										</textarea>
										<input type="hidden" name="true_false[]" value="true" />
									</div>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>
		
			<div class="alert alert-success" role="alert" style="display:none"></div>
				<div class="alert alert-danger" role="alert" style="display:none"></div>
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