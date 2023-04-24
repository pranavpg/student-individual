<?php
	$exploded_question = explode(PHP_EOL, $practise['question']);
?>
<?php
$style="";
// if($practise['id']=='15506732135c6d653dbafb1'){

// echo "<pre>";
// print_r($practise);die;
//   }
if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) ){
  $depend =explode("_",$practise['dependingpractiseid']);
  $style= "display:none";
  //pr($practise);
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
    if(!empty($practise['user_answer'][0])){
      $user_ans = $practise['user_answer'][0];
    }
  }
?>
    <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; display:none">
         <p style="margin: 15px;">In order to do this task you need to have completed
            <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
   </div>
<?php
  } else {
    $exploded_question = explode(PHP_EOL,$practise['question']);
  }
?>
<style type="text/css">
	.course-book ul:not(.nav) li .form-control-inline {
		min-width: 60px;
		padding: 0rem;
	}
</style>
<div class="previous_practice_answer_exists_{{$practise['id']}}" style="{{$style}}">
	<div class="scrollbar">
		<form class="form_{{$practise['id']}}" id="form_<?php echo $practise['id'];?>">
		  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
		  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
		  <input type="hidden" class="is_save" name="is_save" value="">
		  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
			<input type="hidden" class="is_roleplay" name="is_roleplay" value="1">
			<input type="hidden" class="is_roleplay_submit" name="is_roleplay_submit" value="1">
		  <input type="hidden" class="task_type" name="task_type" value="reading_no_blanks_speaking">
			<input type="hidden" name="speaking_one" value="true">
 			<?php
		    if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
		      $depend =explode("_",$practise['dependingpractiseid']);
		  ?>
		      <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
		      <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
		  <?php } ?>
			<div class="tab-content" id="abc-tabContent">
				<div class="tab-pane fade show active" id="abc-b" role="tabpanel" aria-labelledby="abc-b-tab">
					<p><strong><?php echo $practise['title']; ?></strong></p>
					<!-- Compoent - Two click slider-->
					<?php
						$rolePlayQuestions = explode("##",$practise['question']);
						$rolePlayUsers = explode("@@",$rolePlayQuestions[0]);
						$userAnswer = array();

						if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
			        $userAnswer = $practise['user_answer'];
						}
					?>
					<div class="component-two-click mb-4">
						<div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
							<?php
							$userAnsCount = 0;
							foreach($rolePlayUsers as $c=>$rolePlayUser){ ?>
								<a href="#!" id="s-button-<?php echo $c;?>" class="btn btn-dark s-button"><?php echo trim($rolePlayUser);?></a>
							<?php }?>
						</div>
						<div class="two-click-content w-100">
							<?php
									$m=0;
									$readAnswer=array();
		              foreach($rolePlayUsers as $c=>$rolePlayUser)
		              {
										$exploded_question = explode(PHP_EOL, $rolePlayQuestions[$c+1]);
										if(!empty($userAnswer)) {
		                  //$readAnswer = explode(";", $userAnswer[$m][0]);
		                  if(array_key_exists($m, $userAnswer)){
		                      if(isset($userAnswer[$m]['text_ans'])){
		                          $readAnswer = explode(";", $userAnswer[$m]['text_ans']);
		                      }
		                  }
										}

							?>
							<div class="content-box multiple-choice s-button-box d-none" id="s-button-<?php echo $c.''.$c;?>">
								<p class="mb-0 student_question_title_{{$m}} role__play__title"></p>
								<div class="w-100">
									@if($practise['type']=="reading_no_blanks_speaking")
										@include('practice.common.audio_record_div', ['key'=>$m])
										<input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$m}}" name="reading_no_blanks_speaking{{$m}}" value="0">

									@endif
								</div>

								<ul class="list-unstyled">
									<?php
										$m+=2;
										$i = 0;$j=0;
										foreach($exploded_question as $key => $value)
										{
											$outValue="";
											if(str_contains($value,'@@')){


												$outValue = preg_replace_callback('/@@/', function ($m) use (&$key, &$i, &$readAnswer) {
																	$ans= !empty($readAnswer[$i])?trim($readAnswer[$i]):"";
																	$str='<span class="resizing-input"><input type="text" class="form-control text-left pl-0 form-control-inline" name="blanks[]" value="'.$ans.'"><span style="display:none"></span></span>';
																	$i++;
																	return $str;
															}, $value);
												$j+=2;
								  	?>
												<li>
													<?php   echo $outValue; ?>
												</li>
									<?php
		                    				}
											else
											{
												$outValue = $value;
		                    				}
									?>
									<?php 
										}
									?>
										<input type="hidden" name="blanks[]" value="##">
								</ul>
								<!--Component Form Slider End-->
							</div>
							<?php } ?>
						</div>
					</div>
					<!-- ./ Compoent - Two click slider Ends-->

					<!-- /. List Button Start-->
						<div class="alert alert-success" role="alert" style="display:none"></div>
						<div class="alert alert-danger" role="alert" style="display:none"></div>
		        <ul class="list-inline list-buttons">
		            <li class="list-inline-item">
		            <button class="save_btn btn btn-primary submitBtn reading_no_submitBtn_{{$practise['id']}}" data-is_save="0">Save</button>
		            </li>
		            <li class="list-inline-item">
		            <button class="submit_btn btn btn-primary submitBtn reading_no_submitBtn_{{$practise['id']}}" data-is_save="1" >Submit</button>
		            </li>
		        </ul>
		        {{-- <input type="button" class="btnSubmits btn btn-primary" value="Save" data-is_save="0">
		        <input type="button" class="btnSubmits btn btn-primary" value="Submit" data-is_save="1"> --}}
					<!-- /. List Button Ends-->
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
$(".selected_option").click(function() {
	 
		if ( $('#form_{{$practise["id"]}}').find('.two-click-content').find('.d-none').length ==2) {
				$('.is_roleplay_submit').val(0);
		} else {
				$('.is_roleplay_submit').val(1);
		}
});

var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
$(document).on('click','#form_<?php echo $practise['id'];?> .reading_no_submitBtn_{{$practise['id']}}' ,function() {

	if($(this).attr('data-is_save') == '1'){
	    $(this).closest('.active').find('.msg').fadeOut();
	}else{
	    $(this).closest('.active').find('.msg').fadeIn();
	}

        
  $('#form_<?php echo $practise['id'];?> .reading_no_submitBtn_{{$practise['id']}}').attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.is_save:hidden').val(is_save);
  $.ajax({
      url: '<?php echo URL('save-reading-no-blanks-speaking-new'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('#form_<?php echo $practise['id'];?>').serialize(),
      success: function (data) {
        $('.reading_no_submitBtn_{{$practise['id']}}').removeAttr('disabled');
				if(data.success){
					 
					if( $('.form_{{$practise["id"]}}').find('.two-click-content').find('.d-none').length==2 && is_save=="1"){
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
                 //$('.nav-link.active').parent().next().find('a').trigger('click');
              }
            },1500);
            // =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
          }
					$('.alert-danger').hide();
					$('.alert-success').show().html(data.message).fadeOut(8000);
				}else{
					$('.alert-success').hide();
					$('.alert-danger').show().html(data.message).fadeOut(8000);
				}
      //  location.reload();
      }
  });
});
</script>
<script>
$(function () {
	// two click js
	$("#form_<?php echo $practise['id'];?> .s-button").on("click",function(){
		if($("#form_<?php echo $practise['id'];?> .s-button.d-none").length > 0){
			$("#form_<?php echo $practise['id'];?> .s-button.d-none");
			$("#form_<?php echo $practise['id'];?> .s-button-box").addClass("d-none");
			$("#form_<?php echo $practise['id'];?> .s-button").removeClass("d-none").removeClass("btn-bg");
			return false;
		}
		$("#form_<?php echo $practise['id'];?> .s-button-box,.s-button").addClass("d-none");
		$(this).removeClass("d-none").addClass("btn-bg");
		var curId = $(this).attr("id");
		curId = curId.replace("s-button-","");
		$("#form_<?php echo $practise['id'];?> #s-button-"+curId+curId).removeClass("d-none");
	})
	/*$("#p-button").click(function () {
		$("#police, #s-button").toggleClass("d-none");
		$(this).toggleClass('btn-bg');
	});

	$("#s-button").click(function () {
		$("#suspect, #p-button").toggleClass("d-none");
		$(this).toggleClass('btn-bg');
	});*/
});
</script>

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
            $('#dependant_pr_{{$practise["id"]}}').hide();
						var previous_practice_answer = data.user_Answer;
						console.log('student_question_title_',previous_practice_answer)
						if(previous_practice_answer) {

								$('.student_question_title_0').html(previous_practice_answer[0][0][1]);
								$('.student_question_title_2').html(previous_practice_answer[2][0][2]);

						}

          } else {
            $('.previous_practice_answer_exists_{{$practise["id"]}}').hide();
            $('#dependant_pr_{{$practise['id']}}').show();
          }
        }
    });
  }
});
</script>
@endif
