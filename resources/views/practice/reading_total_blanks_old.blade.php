<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
<script src="{{ asset('public/js/owl.carousel.js') }}"></script>


<p>
	<strong><?php echo $practise['title']; ?></strong>
</p>

<?php
//pr($practise);
$speakingPractise = false;

if($practise['type'] == "reading_total_blanks_listening"){?>
<div class="audio-player">
	<audio preload="auto" controls src="<?php echo $practise['audio_file'];?>" type="audio/mp3" id="audio_{{$practise['id']}}">
		<!-- <source  > -->
	</audio>
</div>
<?php }?>

    <div class="table-container">
      <form class="image_reading_total_blanks" id="image_reading_total_blanks_<?php echo $practise['id'];?>">
        <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
        <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
        <input type="hidden" class="is_save" name="is_save" value="">
        <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

		<?php if(isset($practise['options']) && !empty($practise['options'])){?>
		<div class="match-answer">
			<div class="form-slider w-100 mr-auto ml-auto mb-5">
				<div class="owl-carousel owl-theme">
					<div class="item">
						<div class="table-slider-box ietsb-mobv text-center d-flex flex-wrap">
							<?php foreach($practise['options'] as $options){?>
							<div class="w-33 ietsob-mobv table-option border">
								<a href="javascript:void(0);"><?php echo $options[0];?></a>
							</div>
							<?php }?>
						</div>
					</div>
				</div>
			</div>
			<!-- /. Table Slider-->
		</div>
		<?php }?>


		<?php
			$userAnswer = array();
			if(isset($practise['user_answer']) && !empty($practise['user_answer'])){

				if($practise['type'] == "reading_total_blanks_speaking"){
					$userAnswer = $practise['user_answer'][0]['text_ans'];
					$userAnswer = explode(";",$userAnswer);
				}else{
					$userAnswer = $practise['user_answer'];
					$userAnswer = explode(";",$userAnswer[0]);
				}
			}
		//	pr($practise);

		?>

		<?php if(isset($practise['question']) && !empty($practise['question'])){?>
		<ul class="list-unstyled">
			<?php
					$questions = explode(PHP_EOL, $practise['question']);
					$c = 0;
					$outValue="";
				foreach($questions as $key => $value){

					if(str_contains($value,'@@')){
						$outValue = preg_replace_callback('/@@/',
								function ($m) use (&$key, &$c, &$userAnswer) {
									$ans= !empty($userAnswer[$c])?trim($userAnswer[$c]):"";
									$c++;
									$str = '<span class="resizing-input"><input type="text" class="form-control form-control-inline" name="blanks[]" style="text-align:left" value="'.$ans.'"><span style="display:none"></span></span>';
									return $str;
								}
								, $value);
					}

			?>


			<li>
				<?php
echo $outValue;
					// if(strpos($question, "@@") === false){
					// 	$value = '';
					// }else{
					// 	if(isset($userAnswer[$c]) && !empty($userAnswer[$c])){
					// 		$value = $userAnswer[$c];
					// 	}else{
					// 		$value = '';
					// 	}
					// 	$c++;
					// }
					//
					// $question = str_replace("@@",'<span class="resizing-input"><input type="text" class="form-control form-control-inline" name="blanks[]" style="text-align:left" value="'.$value.'"><span style="display:none"></span></span>',$question);
					// echo $question;
				?>
			</li>
			<?php }?>
		</ul>
		<?php }?>


		<?php if($practise['type'] == "reading_total_blanks_speaking"){ ?>
			@include('practice.common.audio_record_div',['key'=>0])
			<input type="hidden" name="speaking_one" value="true" />
		<?php }?>

		<div class="alert alert-success" role="alert" style="display:none"></div>
		<div class="alert alert-danger" role="alert" style="display:none"></div>
        <input type="button" class="btnSubmits btn btn-primary" value="Save" data-is_save="0">
        <input type="button" class="btnSubmits btn btn-primary" value="Submit" data-is_save="1">


      </form>
    </div>


<script type="text/javascript">
$(document).on('click','#image_reading_total_blanks_<?php echo $practise['id'];?> .btnSubmits' ,function() {
	
	if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }
    
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
			$('.alert-success').show().html(data.message).fadeOut(8000);
		}else{
			$('.alert-success').hide();
			$('.alert-danger').show().html(data.message).fadeOut(8000);
		}

      }
  });
});
</script>


@if($practise['type']!='reading_total_blanks_edit') {
<script>
$('#image_reading_total_blanks_<?php echo $practise['id'];?> .resizing-input input').keypress(function(e) {
	return false
});
</script>
@endif
<script>
$('.resizing-input:first').addClass('focus');
$('.resizing-input:first').find('input').addClass('active');
$('.owl-carousel').owlCarousel({
	loop: true,
	margin: 10,
	nav: true,
	items: 1
})
	$(function () {
	});
	$('#image_reading_total_blanks_<?php echo $practise['id'];?> .resizing-input input').on('focus',function(){
		$('#image_reading_total_blanks_<?php echo $practise['id'];?> .resizing-input input').removeClass("active");
		$(this).addClass("active");
	})
	$("#image_reading_total_blanks_<?php echo $practise['id'];?> .match-answer .table-slider-box .table-option a").on('click',function(){
		if($('#image_reading_total_blanks_<?php echo $practise['id'];?> .resizing-input input.active').length > 0){
			var curText = $(this).text();
			$('#image_reading_total_blanks_<?php echo $practise['id'];?> .resizing-input input.active').val(curText);
			//$('#image_reading_total_blanks_<?php echo $practise['id'];?> .resizing-input input.active').removeClass("active");
		}
	})

</script>
<script>
  jQuery(function ($) {
    'use strict'
    var supportsAudio = !!document.createElement('audio').canPlayType;
    if (supportsAudio) {
        // initialize plyr
        var i;

           var player = new Plyr('audio', {
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
