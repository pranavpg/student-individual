<?php
// pr($practise);
// echo '<pre>'; print_r($practise); 

  $user_ans="";
  $answerExists = false;

	if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
		$answerExists = true;
		$answers = $practise['user_answer'][0]['text_ans'];
	}
	$exploded_question  =  explode(PHP_EOL, $practise['question']);
	
  $style="";
?>
<?php
  if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) ){
	$depend =explode("_",$practise['dependingpractiseid']);
	// echo "sdfs";
    // $style= "display:none";
	  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
      $answerExists = true;
      if(!empty($practise['user_answer'][0])){
        $user_ans = $practise['user_answer'][0]['text_ans'];
      }
    }
	?>

      <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; display:none">
           <p style="margin: 15px;">In order to do this task you need to have completed
              <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
     </div>
<?php } ?>

	<div class="previous_practice_answer_exists_{{$practise['id']}}" style="{{$style}}">
		<p><strong>{{$practise['title']}}</strong></p>
		
    <form class="form_{{$practise['id']}}">
      <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
      <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
      <input type="hidden" class="is_save" name="is_save" value="">
			<input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
			<input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
		 	<?php
				if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
					$depend =explode("_",$practise['dependingpractiseid']);
			?>
					<input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
					<input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
					
			<?php } ?>
		
      @if($practise['type'] == "true_false_speaking_up_simple")
					@include('practice.common.audio_record_div',['key'=>0])
			@endif
              <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="true_false_speaking_up_simple" value="0">
			
			<div class="true-false">
					@if(!empty($exploded_question))
					
						@foreach($exploded_question as $key => $value)
							@if(!empty($value))
								<div class="box box-flex align-items-center" >
										<div class="box__left flex-grow-1 temp_{{$key}}" >
											@if($answerExists && isset($answers[$key]['question']) && !empty($answers[$key]['question']))
												<p>{!!str_replace('@@','',$answers[$key]['question'])!!} </p>
												<input type="hidden" class="que_ans" name="text_ans[{{$key}}][question]"   >
											@else
												<p class="question_answer_p" data="{{$key}}">{!! str_replace('@@',"<b><font color = '#03A9F4' class='q_answer text-pink'></font></b>",$value) !!}</p>
												<input type="hidden" class="que_ans" name="text_ans[{{$key}}][question]"   >
											@endif
										</div>
										<div class="true-false_buttons">
										<?php ?>
												<div class="form-check form-check-inline">

														<input class="form-check-input" type="radio" name="text_ans[{{$key}}][true_false]" id="inlineRadioTrue{{$key}}" value="1" {{ ($answerExists && $answers[$key]['true_false']==1)?"checked":""}} >
														<label class="form-check-label" for="inlineRadioTrue{{$key}}">True</label>
												</div>
												<div class="form-check form-check-inline">
														<input class="form-check-input" type="radio" name="text_ans[{{$key}}][true_false]" id="inlineRadioFalse{{$key}}" value="0" {{ ($answerExists && $answers[$key]['true_false']==0)?"checked":""}}>
														<label class="form-check-label" for="inlineRadioFalse{{$key}}">False</label>
												</div>

										</div>
								</div>
							@endif
						@endforeach
					@endif
				
					<!-- /. box -->

			</div>


			<div class="alert alert-success" role="alert" style="display:none"></div>
			<div class="alert alert-danger" role="alert" style="display:none"></div>
			<ul class="list-inline list-buttons">
			    <li class="list-inline-item"><button class="btn btn-primary submitBtn_{{$practise['id']}}"
			            data-toggle="modal" data-is_save="0" data-target="#exitmodal"  {{empty($practise['user_answer'])?"disableds":""}}>Save</button>
			    </li>
			    <li class="list-inline-item"><button
			            class="btn btn-primary submitBtn_{{$practise['id']}}" data-is_save="1"  {{empty($practise['user_answer'])?"disableds":""}}>Submit</button>
			    </li>
			</ul>
    </form>
	</div>

<script type="text/javascript">
// $( document ).ready(function() {
//     setQuestionContent();
// });
	function setTextareaContent(){
		$("span.textarea.form-control").each(function(){
			var currentVal = $(this).html();
			currentVal= currentVal.replace('&nbsp;',' ');
			currentVal= currentVal.replace('nbsp;',' ');
			currentVal= currentVal.replace('&amp;',' ');
			currentVal= currentVal.replace('amp;',' ');
			currentVal= currentVal.replace('</div>','');
			currentVal= currentVal.replace('<div>','<br>');
			currentVal= currentVal.replace('</div>','');
			$(this).next().find("textarea").val(currentVal);
		})
	}
	function setQuestionContent(){
		$(".question_answer_p").each(function(){
			var currentVal = $(this).html();
			var parent_id = $(this).attr("data");
			// alert(('.temp_'+parent_id));
			$('.temp_'+parent_id).find('input').val(currentVal+'@@') // for GES-ELEMENTARY dependancy  - true_false_speaking_up_simple ===ID==> 15572210855cd14eddb3955
			//console.log(currentVal);
			// $(this).next().find("hidden").val(currentVal);
		})
	}
	$(document).on('click','.submitBtn_{{$practise["id"]}}' ,function() {
		  if($(this).attr('data-is_save') == '1'){
                $(this).closest('.active').find('.msg').fadeOut();
            }else{
                $(this).closest('.active').find('.msg').fadeIn();
            }
	  $('.submitBtn_{{$practise["id"]}}').attr('disabled','disabled');
	  var is_save = $(this).attr('data-is_save');
	  $('.is_save:hidden').val(is_save);
	  setQuestionContent();
	  setTextareaContent();
	  $.ajax({
	      url: '<?php echo URL('save-true-false-speaking'); ?>',
	      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	      type: 'POST',
	      data: $('.form_{{$practise["id"]}}').serialize(),
	      success: function (data) {
	        $('.submitBtn_{{$practise["id"]}}').removeAttr('disabled');
					if(data.success){
						$('.alert-danger').hide();
						$('.alert-success').show().html(data.message).fadeOut(8000);
					} else {
						$('.alert-success').hide();
						$('.alert-danger').show().html(data.message).fadeOut(8000);
					}
	      }
	  });
	  return false;
	});
	var token = $('meta[name=csrf-token]').attr('content');
	var upload_url = "{{url('upload-audio')}}";
	var workerDirPath = "{{asset('public/js/audio-recorder/')}}";  
</script>
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 )

<script>
  $( document ).ready(function() {

    var practise_id = $(".form_{{$practise['id']}}").find('.depend_practise_id').val();
    if(practise_id){
      getDependingPractise();
    } else{
      $('.previous_practice_answer_exists_{{$practise["id"]}}').show();
    }

    function getDependingPractise(){
		
      var topic_id= $(".form_{{$practise['id']}}").find('.topic_id').val();
      var task_id=$(".form_{{$practise['id']}}").find('.depend_task_id').val();
      var practise_id=$(".form_{{$practise['id']}}").find('.depend_practise_id').val();
      var dependent_ans = '<?php echo !empty($user_ans)?json_encode($user_ans):"" ?>';
      //console.log('d====>',dependent_ans)
      $.ajax({
          url: "{{url('get-student-practisce-answer')}}",
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          type: 'POST',
          data:{
              topic_id,
              task_id,
              practise_id
          },
          dataType:'JSON',
          success: function (data) {
            if(data.question!=null && data.question!=undefined){
              $('.form_{{$practise["id"]}}').find('.first-question').remove()
              $('.previous_practice_answer_exists_{{$practise["id"]}}').show();
              $('#dependant_pr_{{$practise['id']}}').hide();
              var question = data.question;
              var answer = data.user_Answer[0];
              var question_array = question.split(':');
              var str ="";
              if(answer){
								var splitted_ans = answer.split(';')
								console.log(splitted_ans);
								splitted_ans.forEach((item, i) => {
									$(".form_{{$practise['id']}}").find(".q_answer:eq("+i+")").html(item)
								});


              }

            } else {
              $('.previous_practice_answer_exists_{{$practise["id"]}}').hide();
              $('#dependant_pr_{{$practise['id']}}').show();
            }
          }
      });
    }
	$('.previous_practice_answer_exists_{{$practise["id"]}}').show();
  });
</script>
@endif
