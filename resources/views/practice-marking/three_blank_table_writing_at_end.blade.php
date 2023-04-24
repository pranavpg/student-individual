
<p>
	<strong><?php echo $practise['title']; ?></strong>
</p>
    <div class="table-container">
      <form class="save_three_blank_table_form">
        <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
        <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
        <input type="hidden" class="is_save" name="is_save" value="">
        <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
        <input type="hidden" name="task_type" value="three_blank_table_writing_at_end">
        <?php
            $exploded = explode('/t', $practise['question']);
            $exploded_question = explode(PHP_EOL, $exploded[0]);
            array_pop($exploded_question);
            //dd($exploded_question);

            $table_part = explode(PHP_EOL, $exploded[1]);
            $table_row = (int)$table_part[1];
            $table_header = explode('@@', $table_part[0]);
			$answerExists = false;
			if (isset($practise['user_answer']) && !empty($practise['user_answer']))
			{
                $answerExists = true;
			}
			$columnCount = 1;
			if ($practise['type'] == "three_blank_table_writing_at_end")
			{
			    $columnCount = 3;
			    $columnClass = 'w-33';
			}
			?>
				<div class="multiple-choice">
					@for($w=0; $w< count($exploded_question); $w++)
						<p class="mb-0">{{str_replace('@@','',$exploded_question[$w])}}<?php 	//echo count($exploded_question)-2; ?> </p>
						<div class="form-group form-group-label">
							<span class="textarea form-control form-control-textarea" role="textbox"
								contenteditable placeholder="Write here...">
								<?php
									if ($answerExists) {
										if(isset($practise['user_answer'][1][$w])){
											echo $practise['user_answer'][1][$w];
										}
										
									}
								?>
							</span>
							<div style="display:none">
							<textarea name="textarea[]">
								<?php
									if ($answerExists) {
										if(isset($practise['user_answer'][1][$w])){
											echo $practise['user_answer'][1][$w];
										}
									
									}
								?>
							</textarea>
						</div>
						</div>
					@endfor
					<div class="table-container mb-4 text-center">
						<div class="table">
							<div class="table-heading thead-dark d-flex justify-content-between">
								@foreach($table_header as $header)
                                    <div class="d-flex justify-content-center align-items-center th w-33">
                                        {{$header}}
                                    </div>
								<div style="display:none">
									<textarea name="col[]"><?php echo $header; ?></textarea>
									<input type="hidden" name="true_false[]" value="false" />
								</div>
								@endforeach
							</div>
							<?php for ($j = 0;$j < $table_row;$j++) { ?>
								<div class="table-row thead-dark d-flex justify-content-between">
								<?php for ($k = 1;$k <= $columnCount;$k++) { ?>
									<div class="d-flex justify-content-center align-items-center  border-left td <?php echo $columnClass; ?> td-textarea">

											<span class="textarea form-control form-control-textarea" role="textbox" disabled contenteditable placeholder="Write here...">
												<?php
											if ($answerExists) {
												echo $practise['user_answer'][0][0][$j + 1]['col_' . $k];
											}
												?>
											</span>
											<div style="display:none">
												<textarea name="col[]">
												<?php
											if ($answerExists) {
												echo $practise['user_answer'][0][0][$j + 1]['col_' . $k];
											}
												?>
												</textarea>
												<input type="hidden" name="true_false[]" value="true" />
											</div>
									</div>
								<?php } ?>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
		
			<input type="hidden" name="table_type" value="3" />
		</form>
    </div>
<script type="text/javascript">
function setTextareaContent(){
	$(".save_three_blank_table_form span.textarea.form-control").each(function(){
		var currentVal = $(this).html();
		$(this).next().find("textarea").val(currentVal);
	})
}
jQuery(function ($) {
        'use strict'
        var supportsAudio = !!document.createElement("audio").canPlayType;
        if (supportsAudio) {
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
