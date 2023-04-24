<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
<!-- <script src="{{ asset('public/js/owl.carousel.js') }}"></script> -->
@php
$dependentid = "";
@endphp
<p>
	<strong><?php echo $practise['title']; ?></strong>
</p>
<?php
// dd($practise);
$speakingPractise = false;
if($practise['type'] == "reading_total_blanks_listening"){?>
<div class="audio-player">
	<audio preload="auto" class="listen" controls src="<?php echo $practise['audio_file'];?>" type="audio/mp3" id="audio_{{$practise['id']}}">
		<!-- <source  > -->
	</audio>
</div>
<?php }?>
	<?php 
		if(isset($practise['dependingpractiseid'])){
			$split_id  = explode("_",$practise['dependingpractiseid']);
			$dependentid  = $split_id[1];
			if($practise['typeofdependingpractice'] == "reading_total_blanks_generate_questions_numbers_before" ){
				$data = explode("@@", $practise['question']);
				$newArray = [];
				foreach($data as $key=>$new){
					$newArray[$key][] = $new;
				}
				$practise['options'] = $newArray;
			}elseif($practise['typeofdependingpractice'] == "get_answers_put_into_quetions" ){

			}
		}
		else
		{
			 $dependentid = "";
		}
    if(isset($practise['id']))
    {
       if($practise['id'] == "1665070023633ef3c75b5b1" OR $practise['id'] == "16655740276346a48b9acc2")
       {
		 $data[$practise['id']] = array();
		 $data[$practise['id']]['isRolePlayPractice'] = (!empty($practise['is_roleplay']) &&  $practise['is_roleplay']==1)?1:0;
		 $data[$practise['id']]['typeofdependingpractice'] = !empty($practise['typeofdependingpractice']) ? $practise['typeofdependingpractice'] : "";
		 $data[$practise['id']]['setFullViewFromPreviousPractice'] = !empty($practise['depending_practise_details']['dependant_practise_id']) ? $practise['depending_practise_details']['dependant_practise_id']:"";
		 $data[$practise['id']]['dependant_practise_topic_id'] = !empty($practise['depending_practise_details']['dependant_practise_topic_id']) ? $practise['depending_practise_details']['dependant_practise_topic_id']:"";
		 $data[$practise['id']]['dependant_practise_task_id'] = !empty($practise['depending_practise_details']['dependant_practise_task_id']) ? $practise['depending_practise_details']['dependant_practise_task_id']:"";
		 $data[$practise['id']]['dependant_practise_question_type'] = !empty($practise['depending_practise_details']['question_type']) ? $practise['depending_practise_details']['question_type']:"";
		 $data[$practise['id']]['dependentpractice_ans'] = !empty($practise['dependingpractise_answer'])?1:0;
		 $data[$practise['id']]['is_dependent'] = !empty($practise['is_dependent']) ? 1 : 0;
	   }
    }
	if(isset($practise['dependingpractiseid']) ) {
			$depend =explode("_",$practise['dependingpractiseid']); ?>
		    <input type="hidden" class="get_answers_put_into_quetions_topic_id" name="get_answers_put_into_quetions_topic_id" value="{{$topicId}}">
		    <input type="hidden" class="get_answers_put_into_quetions_task_id" name="depend_task_id" value="{{$depend[0]}}">
			<input type="hidden" class="get_answers_put_into_quetions_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
			<div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
			<p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong>Please complete this first.</p>
			</div>
	<?php } ?>
	@if(isset($practise['id']))
     @if($practise['id'] == "1665070023633ef3c75b5b1" OR $practise['id'] == "16655740276346a48b9acc2")
       <div class="showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}} mb-4 old-pr"></div>
     @endif
    @endif
    <div class="table-container">
      <form class="form_{{$practise['id']}}" id="image_reading_total_blanks_<?php echo $practise['id'];?>">
        <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
        <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
        <input type="hidden" class="is_save" name="is_save" value="">
        <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

		<?php if(isset($practise['options']) && !empty($practise['options'])){?>
			<div class="match-answer">
				<div class="form-slider w-100 mr-auto ml-auto mb-5">
					<div class="owl-carousel owl-theme owl-test-new">
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

		?>

		<?php if(isset($practise['question']) && !empty($practise['question'])){?>
		<ul class="list-unstyled">
			<?php
					$questions = explode(PHP_EOL, $practise['question']);
					$flag = false;
				  	$newArray = [];
				  	$hideFlag = "no";
				  	if(isset($practise['dependingpractiseid'])){
				  		if($practise['typeofdependingpractice'] == "reading_total_blanks_generate_questions_numbers_before" ){
				  			if(empty($practise['dependingpractise_answer'])){
								$hideFlag = "yes";
				  			}
                       
						  	if(!empty($practise['dependingpractise_answer'])){
						  		$flag = true;
				            	foreach ($practise['dependingpractise_answer'][0][0] as $key => $value) {
				            		if($key == 0) continue;
					            	foreach ($value as $keya => $valuea) {
					            		if($valuea!=""){
											array_push($newArray, "@@".$valuea);
					            		}
					            	}
				            	}
				            	$questions = $newArray;
				            	
				            }
				            // dd($questions);
			            }elseif($practise['typeofdependingpractice'] == "get_answers_put_into_quetions" ){
				  			if(empty($practise['dependingpractise_answer'])){
								$hideFlag = "yes";
				  			}
			            	$questions = explode(PHP_EOL, $practise['depending_practise_details']['question']);
			            	foreach($questions as $key=>$newque){
			            		if (strpos($newque, '@@') !== false) {
			            			// dd($practise['dependingpractise_answer']);
			            			if(!empty($practise['dependingpractise_answer'])){
										$data = str_replace("@@",$practise['dependingpractise_answer'][0][$key],$newque);
			            				array_push($newArray,$data." @@");
									}

			            		}else{
			            			if(!empty($practise['dependingpractise_answer'])){
				            			array_push($newArray, $newque." @@");
				            		}
			            		}
			            		
			            	}
			            	$questions = $newArray;
			            }
			            else
			            {
			            	if(isset($practise['dependingpractise_answer']))
			            	{
			            	   if(empty($practise['dependingpractise_answer']))
			            	   {
                                     $hideFlag = "yes";
			            	   }
			            	}
			            	else
			            	{
			            		 $hideFlag = "yes";
			            	}
			            }
				  	}

					$c = 0;
					$s = 0;
					$outValue="";
                foreach($questions as $key => $value)
                {
                    if(strlen($value)<2)
                    {
                    	 echo"<br/>";
                    }
					if(str_contains($value,'@@')){
					    $outValue = preg_replace_callback('/@@/',
						function ($m) use (&$key, &$c, &$userAnswer, &$flag, &$s) {
							$s++;
                            $ans= !empty($userAnswer[$c])?trim($userAnswer[$c]):"";

                            $new = $flag?$s.".":"";

                            // $str = $new.'<span class="stringProper"><input type="text" class="form-control form-control-inline px-2" name="blanks[]" style="text-align:left;padding-left:0 !important;padding-right:0 !important;" value="'.$ans.'"><span style="display:none"></span></span>';
                            
                            $str = $new.'<span class="resizing-input1">
					 				<span readonly disabled contenteditable="true" class="enter_disable spandata fillblanks stringProper text-left disable_writing">'.$ans.'</span>
					 				<input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="'.$ans.'">
									
								</span>';

							$c++;
							return $str;
						}, $value);

                    }
                    else
                    {
                        $outValue = $value;
                    }


					?>


					<li>
						<?php   echo $outValue; ?>
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
	 var depend = "<?php echo $hideFlag; ?>"; 
	 if(depend!="no"){
	 	$('.form_<?php echo $practise['id'];?> ').fadeOut();
	 	$('#dependant_pr_{{$practise['id']}}').fadeIn();
	 	if($('.showPreviousPractice_'+"{{$dependentid}}").length){
	       $('.showPreviousPractice_'+"{{$dependentid}}").hide();
		}
	 }

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
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.enter_disable').attr("contenteditable","false");
					// $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.match-answer').remove();
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.match-answer').remove();
					// setTimeout(function(){
					// 	$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.item').css("margin-right","507px");
					// },1000);
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
$('#image_reading_total_blanks_<?php echo $practise['id'];?> .stringProper input').keypress(function(e) {
	return false
});
</script>
@endif
<script>
	$('.stringProper:first').addClass('focus');
	$('.stringProper:first').find('input').addClass('active');
	$('.owl-test-new').owlCarousel({
		loop: false,
		margin: 10,
		nav: false,
		items: 1
	});

	$(function () {
		$('.disable_writing').on('keydown', function (event) {
			return false;
		});
	});

	$('#image_reading_total_blanks_<?php echo $practise['id'];?> .stringProper ').on('focus',function(){
		$('#image_reading_total_blanks_<?php echo $practise['id'];?> .stringProper ').removeClass("active");
		$(this).addClass("active");
	})
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
  });


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
@if(isset($practise['id']))
@if($practise['id'] == "1665070023633ef3c75b5b1" OR $practise['id'] == "16655740276346a48b9acc2")
<script>
	if(data13==undefined ){
		var data13=[];
	} 
	data13["{{$practise['id']}}"]= {"dependentpractice_ans": "{{$data[$practise['id']]['dependentpractice_ans']}}" };
	data13["{{$practise['id']}}"]["isRolePlayPractice"] = "{{$data[$practise['id']]['isRolePlayPractice']}}"
	data13["{{$practise['id']}}"]["is_dependent"] = "{{$data[$practise['id']]['is_dependent']}}"; 
	if(data13["{{$practise['id']}}"]["is_dependent"]==1){
		
		if(data13["{{$practise['id']}}"]["dependentpractice_ans"]==0 ){
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

	data13["{{$practise['id']}}"]["typeofdependingpractice"] = "{{$data[$practise['id']]['typeofdependingpractice'] }}";
	data13["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
	if(data13["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data13["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data13["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data13["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data13["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data13["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data13["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view"){
	  
		data13["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
		data13["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
		$(function () {
			$('.cover-spin').fadeIn();
		});
		if(data13["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
			 
			// IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
			if(data13["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
				
				 
				 setTimeout(function(){ 
				 
					 data13["{{$practise['id']}}"]["prevHTML"] = $(document).find('#abc-'+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();				 
				 
					$(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).html(data13["{{$practise['id']}}"]["prevHTML"]);
					$(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
					$(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
					$(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert').remove();

					if( data13["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" ){
						if(data13["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_no_blanks_listening_speaking_down"  || data13["{{$practise['id']}}"]["dependant_practise_question_type"]== "single_speaking_up_writing" ) {
							$(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('.audio-player').remove();
							$(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
						}
					} 
					$('.cover-spin').fadeOut();
				 }, 8000 )
			}
		} else {
		
			// IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
			// DO NOT REMOVE BELOW   CODE
			var baseUrl = "{{url('/')}}";
			data13["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
			data13["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data13["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data13["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data13["{{$practise['id']}}"]["dependant_practise_id"];
			$.get(data13["{{$practise['id']}}"]["dependentURL"],  //
			function (dataHTML, textStatus, jqXHR) {  // success callback
				setTimeout(function(){
					data13["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
					$(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).html(data13["{{$practise['id']}}"]["prevHTML"]);
					$(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
					$(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, .alert, input:hidden').remove();
					
					if(data13["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" ){
						
						if(data13["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_no_blanks_listening_speaking_down" || data13["{{$practise['id']}}"]["dependant_practise_question_type"]== "single_speaking_up_writing") {
							$(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
						}
					}
					$('.cover-spin').fadeOut();
				},8000)
				
			});
		}
	}  
</script>
@endif
@endif
@endif
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
