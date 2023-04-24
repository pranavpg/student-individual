<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
<script src="{{ asset('public/js/owl.carousel.js') }}"></script>


<p>
	<strong><?php echo $practise['title']; ?></strong>
</p>

<?php
// dd($practise);
if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1  && isset($practise['dependingpractise_answer'])&& empty($practise['dependingpractise_answer'])){
	$depend =explode("_",$practise['dependingpractiseid']);
	$style= "display:none"; 
  
?>
  <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; display:block">
	  <p style="margin: 15px;">In order to do this task you need to have completed
	  <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
  </div>
<?php
}else{
	$style= "display:block"; 
}
$speakingPractise = false;

if($practise['type'] == "reading_total_blanks_listening"){?>
   <!--add for level 0 -->
   @if($practise['id'] == "1666162532634f9f6451e17")
     @include('practice.common.audio_player')
   @else
	<div class="audio-player">
		<audio preload="auto" class="listen" controls src="<?php echo $practise['audio_file'];?>" type="audio/mp3" id="audio_{{$practise['id']}}">
			<!-- <source  > -->
		</audio>
	</div>
    @endif
<?php }?>

    <div class="table-container" style="{!!$style!!}">
      <form class="form_{{$practise['id']}}" id="image_reading_total_blanks_<?php echo $practise['id'];?>">
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
            $questions = explode(PHP_EOL, $practise['question']);
            //dd($questions);
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
		$classVal = "enter_disable spandata fillblanks stringProper text-left disable_writing";
		if($practise['type'] == "reading_total_blanks_edit"){
			$classVal = "enter_disable spandata fillblanks stringProper text-left";
		}
		if(isset($practise['question']) && !empty($practise['question']) && $practise['question'] != "@@") { ?>
				<ul class="list-unstyled">
					<?php
						$questions = explode(PHP_EOL, $practise['question']);
						$c = 0;
						$outValue="";
		                foreach($questions as $key => $value) {
							if(str_contains($value,'@@')){
		                        $outValue = preg_replace_callback('/@@/',
									function ($m) use (&$key, &$c, &$userAnswer, &$classVal) {
		                                $ans= !empty($userAnswer[$c])?trim($userAnswer[$c]):"";
										/* $str = '<span class="resizing-input"><input type="text" class="form-control form-control-inline px-2" name="blanks[]" style="text-align:left" value="'.$ans.'"><span style="display:none"></span></span>'; */
										
										
										$str = '<span class="resizing-input1">
													<span readonly disabled contenteditable="true" class="'.$classVal.'">'.$ans.'</span>
													<input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="'.$ans.'">
												</span>';
										$c++;
										return $str;
									}, $value);
		                    } else {
		                        $outValue = $value;
		                    }
							?>


							<li>
								<?php   echo $outValue; ?>
							</li>
							<?php 
						} ?>
				</ul>
		<?php 
		} else {
			// dd($practise);
			if(isset($practise['dependingpractiseid']) && !empty($practise['dependingpractiseid'])){
				if(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer']) && $practise['typeofdependingpractice'] == 'get_answers_generate_quetions'){
					$displayPractise="block";
					$displayDependancy="none";
					$dependFinalAnswer=array();
					if(isset($practise['dependingpractise_answer'][0]) && !empty($practise['dependingpractise_answer'][0])){
						?>
						<ul class="list-unstyled">
					<?php
						$dependAns= explode(';',$practise['dependingpractise_answer'][0]);
						/* echo $practise['dependingpractise_answer'][0];
						dd($dependAns); */
						$tempdata = [];
						foreach($dependAns as $data){
							if($data == " " || $data == "" ){
								array_push($tempdata,"");
							}else{
								array_push($tempdata,$data);
							}
						}
						$explo = explode("#@",$practise['depending_practise_details']['question'][0]);
						$practise['depending_practise_details']['question'][0] = $explo[1];
						foreach($tempdata as $key=>$ans){
							if(isset($practise['depending_practise_details']['question'][$key])){
								if($ans != ""){
									$value = $practise['depending_practise_details']['question'][$key]." ".$practise['depending_practise_details']['question_2'][$ans]."@@";
									if(str_contains($value,'@@')){
										$outValue = preg_replace_callback('/@@/',
											function ($m) use (&$key, &$c, &$userAnswer) {
												$ans= !empty($userAnswer[$key])?trim($userAnswer[$key]):"";												
												$str = '<span class="resizing-input1">
															<span readonly disabled contenteditable="true" class="enter_disable spandata fillblanks stringProper text-left disable_writing">'.$ans.'</span>
															<input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="'.$ans.'">
														</span>';
												$c++;
												return $str;
											}, $value);
									} else {
										$outValue = $value;
										
									}
									?>
									<li>
										<?php   echo $outValue; ?>
									</li>
									<?php
								}else{
									echo '<input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="">';
								}
							}
							/* if(isset($practise['depending_practise_details']['question'][$key])){
								if(!empty((int)$ans)){
									/* $dependFinalAnswer[]=$practise['depending_practise_details']['question1'][$key].' '.$practise['depending_practise_details']['question2'][$ans]; 
									//echo $practise['depending_practise_details']['question'][$key]."__---".$ans."<br />";
					
								}
							} */
						}
					?>
					</ul>
					<?php
					}
				}
			}
		}
		?>






		<?php if($practise['type'] == "reading_total_blanks_speaking"){ ?>
			@include('practice.common.audio_record_div',['key'=>0])
			<input type="hidden" name="speaking_one" value="true" />
		<?php }?>

		<div class="alert alert-success" role="alert" style="display:none"></div>
		<div class="alert alert-danger" role="alert" style="display:none"></div>
       
		<ul class="list-inline list-buttons">
			<li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn btnSubmit_{{$practise['id']}}" data-pid="{{$practise['id']}}"
					data-toggle="modal" data-is_save="0" data-target="#exitmodal"  >Save</button>
			</li>
			<li class="list-inline-item"><button type="button"
					class="submit_btn btn btn-primary submitBtn btnSubmit_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1" >Submit</button>
			</li>
		</ul>
      </form>
	 	@if(isset($practise["markingmethod"]) && $practise["markingmethod"] == "student_self_marking")

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
    </div>


<script type="text/javascript">
	$('.spandata').not('.write-span').keydown(function(){
		$(this).text($(this).text());
		return false;
	});
$(document).on('click','.btnSubmit_{{$practise["id"]}}' ,function() {

	if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }
    
	var reviewPopup = '{!!$reviewPopup!!}';
    var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){
                    var fullView= $(".form_{{$practise['id']}}").html();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.spandata').attr("contenteditable","false");
					// $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.text-center').css("width","305px");
					// $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.text-center').css("margin-left","0");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.match-answer').remove();
                }
            }
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){

                $("#reviewModal_{{$practise['id']}}").modal('toggle');

            }
  $('#image_reading_total_blanks_<?php echo $practise['id'];?> .btnSubmits').attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.is_save:hidden').val(is_save);
  $.ajax({
      url: '<?php echo URL('reading-no-blanks'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('.form_<?php echo $practise['id'];?> ').serialize(),
      success: function (data) {
        $('.btnSubmit_{{$practise["id"]}}').removeAttr('disabled');
		if(data.success){
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
</script>


@if($practise['type']!='reading_total_blanks_edit') 
<script>
$('#image_reading_total_blanks_<?php echo $practise['id'];?> .resizing-input input').keypress(function(e) {
	return false
});
</script>
@endif
<script>
	$('.stringProper:first').addClass('focus');
	$('.stringProper:first').find('input').addClass('active');		
	$('.owl-carousel').owlCarousel({
		loop: false,
		margin: 10,
		nav: true,
		items: 1
	})
	$('#image_reading_total_blanks_<?php echo $practise['id'];?> .stringProper').on('focus',function(){
		$('#image_reading_total_blanks_<?php echo $practise['id'];?> .stringProper').removeClass("active");
		$(this).addClass("active");
	})
	/* $("#image_reading_total_blanks_<?php //echo $practise['id'];?> .match-answer .table-slider-box .table-option a").on('click',function(){
		if($('#image_reading_total_blanks_<?php //echo $practise['id'];?> .resizing-input input.active').length > 0){
			var curText = $(this).text();
			$('#image_reading_total_blanks_<?php //echo $practise['id'];?> .resizing-input input.active').val(curText);
			$('#image_reading_total_blanks_<?php //echo $practise['id'];?> .resizing-input input.active').css("width", (curText.length +3) + "ch");
			//$('#image_reading_total_blanks_<?php //echo $practise['id'];?> .resizing-input input.active').removeClass("active");
		}
	}) */
	$("#image_reading_total_blanks_<?php echo $practise['id'];?> .match-answer .table-slider-box .table-option a").on('click',function(){
		if($('#image_reading_total_blanks_<?php echo $practise['id'];?> .stringProper ').length > 0){
			var curText = $(this).text();
			// $('#image_reading_total_blanks_<?php echo $practise['id'];?> .stringProper ').css("width",curText.length*10);
			$('#image_reading_total_blanks_<?php echo $practise['id'];?> .resizing-input1').find('.active').html(curText);
			var stringdata = curText.split("");
			var size = "";
			if(stringdata.length ==1){
				$('#image_reading_total_blanks_<?php echo $practise['id'];?> .resizing-input1').find('.active').css('min-width','0ch');
			}
			if(stringdata.length ==2){
				// var size = "1ch";
				$('#image_reading_total_blanks_<?php echo $practise['id'];?> .resizing-input1').find('.active').css('min-width','1ch');
			}

			    // min-width: 3ch;
			$('#image_reading_total_blanks_<?php echo $practise['id'];?> .resizing-input1').find('.active').next("input").val(curText);
			// $('#image_reading_total_blanks_<?php echo $practise['id'];?> .resizing-input1').find('.appendspan').val(curText);
			// $('#image_reading_total_blanks_<?php echo $practise['id'];?> .resizing-input1').find('.active').removeAttr('contenteditable').blur();
			// $('span#id').removeAttr('contenteditable').blur();
			//$('#image_reading_total_blanks_<?php echo $practise['id'];?> .stringProper input.active').removeClass("active");
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

           var player = new Plyr('audio.listen', {
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
	setTimeout(() => {
		var spanLen = $('span.resizing-input');
		if(spanLen.length > 0){
			for (let index = 0; index < spanLen.length; index++) {
				var spanText = $('span.resizing-input:eq('+index+') input').val();
				$('span.resizing-input:eq('+index+') input').css("min-width", (spanText.length + 3) +"ch");
				$('span.resizing-input:eq('+index+') input').css("width", (spanText.length + 3) +"ch");
			}
		}
	}, 1);

	$( "span.resizing-input input" ).keyup(function(event) {
		if(event){
			event.preventDefault();
		}
		var spText = $(this).val();
		$( this ).css("width", (spText.length + 3) +"ch");
		setTimeout(() => {
		//	$( this ).css("width", (spText.length + 3) +"ch");
		}, 1);
	});
  });
  $(document).on('keyup','.spandata',function(){
	$(this).next().val($(this).html())
})
</script>

<style type="text/css">

  	*[contenteditable]:empty:before
	{
	    content: "\feff"; /* ZERO WIDTH NO-BREAK SPACE */
	}

	.appendspan {
	 	color:red;
	}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
