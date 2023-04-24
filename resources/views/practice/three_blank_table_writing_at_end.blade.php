<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
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
                            //$exploded_question = array();
                            $exploded = explode('/t', $practise['question']);
                            $exploded_question = explode(PHP_EOL, $exploded[0]);
                            array_pop($exploded_question);
                            //dd($exploded_question);

                            $table_part = explode(PHP_EOL, $exploded[1]);
                            $table_row = (int)$table_part[1];
                            $table_header = explode('@@', $table_part[0]);
                            //dd($table_head);


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
                            //dd(count($exploded_question));
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
					<!-- Table -->
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

											<span class="textarea form-control form-control-textarea" role="textbox" contenteditable placeholder="Write here...">
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







		<?php /*?><ul class="list-inline list-buttons">
			<li class="list-inline-item"><a href="#!" class="btn btn-primary"
					data-toggle="modal" data-target="#exitmodal">Save</a>
			</li>
			<li class="list-inline-item"><a href="#!"
					class="btn btn-primary">Submit</a>
			</li>
		</ul><?php */ ?>

 

			<div class="alert alert-success" role="alert" style="display:none"></div>
			<div class="alert alert-danger" role="alert" style="display:none"></div>
			<ul class="list-inline list-buttons">
				<li class="list-inline-item">
					<button type="button" class="save_btn btn btn-primary blankTableBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"
								data-toggle="modal" data-is_save="0" data-target="#exitmodal">Save</button>
				</li>
				<li class="list-inline-item">
					<button type="button" class="submit_btn btn btn-primary submitBtn blankTableBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1">Submit</button>
				</li>
			</ul>
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
</script>
<script type="text/javascript">
$(document).on('click',".blankTableBtn_{{$practise['id']}}" ,function() {

	if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }

  $('.threeBlankTableBtn').attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.is_save:hidden').val(is_save);
  setTextareaContent();
  $.ajax({
      url: '<?php echo URL('save-three-blank-table-writing-up'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('.save_three_blank_table_form').serialize(),
      success: function (data) {
        	$('.threeBlankTableBtn').removeAttr('disabled');
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
</script>
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
