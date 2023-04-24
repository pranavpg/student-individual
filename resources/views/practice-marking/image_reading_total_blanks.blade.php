<?php // echo "<pre>"; print_r($practise); exit;?>
<p>
	<strong><?php
	echo $practise['title'];
	?></strong>
</p>
    <div class="table-container">
      <form class="image_reading_total_blanks" id="image_reading_total_blanks_<?php echo $practise['id'];?>">
        <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
        <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
        <input type="hidden" class="is_save" name="is_save" value="">
        <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

		<?php if(isset($practise['question_3']) && !empty($practise['question_3'])){?>
		<div class="match-answer">
			<div class="form-slider w-75 mr-auto ml-auto mb-5">
				<div class="owl-carousel owl-theme tempOwl">
					<div class="item">
						<div class="table-slider-box ietsb-mobv text-center d-flex flex-wrap">
							<?php foreach($practise['question_3'] as $question_3){?>
							<div class="w-33 ietsob-mobv table-option border">
								<a href="javascript:void(0);"><?php echo $question_3;?></a>
							</div>
							<?php }?>
						</div>
					</div>
				</div>
			</div>
			<!-- /. Table Slider-->
		</div>
		<?php }?>

		<?php if(isset($practise['question']) && !empty($practise['question'])){?>
		<picture class="picture picture-with-border d-flex w-75 mr-auto ml-auto mb-4">
			<img src="<?php echo $practise['question'][0];?>" alt="" class="img-fluid w-100">
		</picture>
		<?php }?>


		<?php
		$userAnswer = array();
		if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
			$userAnswer = $practise['user_answer'];
			$userAnswer = explode(";",$userAnswer[0]);
		}
		?>

		<?php if(isset($practise['question_2']) && !empty($practise['question_2'])){?>
		<ul class="list-unstyled">
			<?php foreach($practise['question_2'] as $c=>$question_2){?>
			<li>
				<?php

				if(isset($userAnswer[$c]) && !empty($userAnswer[$c])){
					$value = $userAnswer[$c];
				}else{
					$value = '';
				}

				$question = str_replace("@@",'<span class="resizing-input"><input type="text" class="form-control form-control-inline" name="blanks[]" style="text-align:left;padding-left: 0;padding-right: 0;" value="'.$value.'"><span style="display:none"></span></span>',$question_2);
				echo $question;
				?>
			</li>
			<?php }?>
		</ul>
		<?php }?>

		<div class="alert alert-success" role="alert" style="display:none"></div>
		<div class="alert alert-danger" role="alert" style="display:none"></div>
        <!-- <input type="button" class="btnSubmits btn btn-primary" value="Save" data-is_save="0">
        <input type="button" class="btnSubmits btn btn-primary" value="Submit" data-is_save="1"> -->

      </form>
    </div>


<script type="text/javascript">
$(document).on('click','.btnSubmits' ,function() {
  $('#image_reading_total_blanks_<?php echo $practise['id'];?> .btnSubmits').attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.is_save:hidden').val(is_save);
  $.ajax({
      url: '<?php echo URL('reading-no-blanks'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('#image_reading_total_blanks_<?php echo $practise['id'];?> ').serialize(),
      success: function (data) {
        $('#image_reading_total_blanks_<?php echo $practise['id'];?> .btnSubmits').removeAttr('disabled');
		if(data.success){
			$('.alert-danger').hide();
			$('.alert-success').show().html(data.message).fadeOut(4000);
		}else{
			$('.alert-success').hide();
			$('.alert-danger').show().html(data.message).fadeOut(4000);
		}

      }
  });
});
</script>

<!-- <script src="{{asset('public/js/js/owl.carousel.js')}}"></script> -->
<script>
	$(function () {
		$('.tempOwl').owlCarousel({
			// loop: true,
			margin: 10,
			nav: true,
			items: 1
		})
	});
	$('#image_reading_total_blanks_<?php echo $practise['id'];?> .resizing-input input').on('focus',function(){
		$('#image_reading_total_blanks_<?php echo $practise['id'];?> .resizing-input input').removeClass("active");
		$(this).addClass("active");
	})
	$("#image_reading_total_blanks_<?php echo $practise['id'];?> .match-answer .table-slider-box .table-option a").on('click',function(){
		if($('#image_reading_total_blanks_<?php echo $practise['id'];?> .resizing-input input.active').length > 0){
			var curText = $(this).text();
			// alert(curText.length*10)
			$('#image_reading_total_blanks_<?php echo $practise['id'];?> .resizing-input input.active').css("width",curText.length*10);
			$('#image_reading_total_blanks_<?php echo $practise['id'];?> .resizing-input input.active').val(curText);
			$('#image_reading_total_blanks_<?php echo $practise['id'];?> .resizing-input input.active').removeClass("active");
		}
	})
	$('#image_reading_total_blanks_<?php echo $practise['id'];?> .resizing-input input').keypress(function(e) {
		return false
	});
</script>
