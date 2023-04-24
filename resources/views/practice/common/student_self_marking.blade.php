<style>
	.modal .answerkeyframe body{
		overflow-x:auto !important;
	}
	.self_marking_modal_popup textarea{
		pointer-events: none;
	}

	.modal-title-blocks {
		background-color: #ececec;
		padding: 2px 10px;
		border-radius: 4px;
		color: #d55b7d;
		margin-right: 15px;
		font-size: 17px;
	}

	.answer-match {
		border: 1px solid #6e8699;
		margin: 0px;
		border-radius: 5px;
	}

	.answer-match h4 {
		text-align: center;
		background-color: #f4f4f4;
		border-radius: 5px;
		color: #30475e;
		font-size: 18px;
		font-weight: 500;
		padding: 4px 0;
		margin-bottom: 0px;
	}
</style>
<div class="modal fade self_marking_modal_popup" id="selfMarking_{{$practise['id']}}" tabindex="-1" role="dialog" aria-labelledby="reviewmodallabel"
data-keyboard="false"  aria-hidden="true" data-backdrop="static">
<div class="modal-dialog modal-xl review-modal">
	<div class="modal-content">
		<div class="modal-header justify-content-start">
		  <?php
			if($is_automated == false)
         { 
        ?>
			<h5 class="modal-title" id="reviewmodallabel">Give your marks</h5>
			<h5 class="modal-title" id="reviewmodallabel_1" style="position: absolute;left: 50%;transform: translate(-50%,0);">Marking Type : Class mark</h5>
		  <?php 
         }
         else
         {
		  ?>
			<h5 class="modal-title" id="reviewmodallabel">Check Your Answers</h5>
			<h5 class="modal-title" id="reviewmodallabel_2" style="position: absolute;left: 50%;transform: translate(-50%,0);" >Marking Type :  Automated</h5>
		  <?php } ?>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<?php
			if(session::get('lastTaskName') !=""){
				$topicDisplayText = explode("/",session::get('lastTaskName'));
				?>
				<ul class="modal-header-breadcrumb mb-0 list-inline">
					<li class="list-inline-item">{{isset($topicDisplayText[0])?$topicDisplayText[0]:""}}</li>
					<li class="list-inline-item">{{isset($topicDisplayText[1])?$topicDisplayText[1]:""}}</li>
					<li class="list-inline-item part"></li>
				</ul>
				<?php
			}?>

			<!-- <p>Read the text in your Course Book and answer the question. </p> -->
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-12 col-lg-5 assessment-answer mb-3">
					<div class="assessment-answer-heading text-center">
						<h4>Answer Key</h4>
					</div>
					<?php 
                      if($practise['answer_key'] != "")
                      {
					?>
							<div class="assessment-answer-heading-body">
								<div id="iframe_div" style="height:100%">
									<iframe class="answerkeyframe" srcdoc="{{str_replace('overflow-x:hidden;','overflow-x:auto;',$practise['answer_key'])}}" style="height: inherit;" width="100%" scrolling="yes" frameborder="0"></iframe>
								</div>
							</div>
					 <?php
                       }
                       else
                       {

                    ?>
                       <div class="assessment-answer-heading-body overflow-auto">
                        <div id="iframe_div">
                    	@if($practise['correctanswer'])
														
														@if($practise['type'] == 'set_in_order_vertical' || $practise['type'] == 'set_in_order_vertical_listening' )
														   <span style="color:black; font-weight:bold">Answers:</span><br>
															<?php 
																$explodQuestion=explode(PHP_EOL,$practise['question']);

																if(empty($practise['question']) && !empty($practise['depending_practise_details']['question'])){

																	$userAnswer = $practise['dependingpractise_answer'];
																	if(isset($userAnswer[0]) && !empty($userAnswer[0]) && str_contains($userAnswer[0],';')){
																		$userAnswer = explode(";",$userAnswer[0]);
																	}else{
																		if(isset($userAnswer) && !empty($userAnswer) && str_contains($userAnswer,';')){
																			$userAnswer = explode(";",$userAnswer);
																		}else{
																			$userAnswer=[];
																		}                           
																	}
																	$questions= explode("\r\n", $practise['depending_practise_details']['question']);
																	//pr($userAnswer);
																	$c = 0;
																	foreach($questions as $key => $value)
																	{

																					if(str_contains($value,'@@')){
																						$value= str_replace("<br>"," ",$value);
																				//$outValue = str_replace('@@', $str, $value);
																				$outValue[] = preg_replace_callback('/@@/',
																													function ($m) use (&$key, &$c, &$userAnswer) {
																														$ans= !empty($userAnswer[$c])?trim($userAnswer[$c]):"";
																														$str = $ans;
																														$c++;
																														return $str;
																													}, $value);
																					}

																	}
																	//pr($outValue);
																	$explodQuestion=$outValue;
																}else{
																	$explodQuestion=explode(PHP_EOL,$practise['question']);
																}
																$explodAnswer=explode(';',$practise['correctanswer']);
																	foreach($explodAnswer as $val){
																		$i=0;
																		$i= intval($val)-1;
																		if(isset($explodQuestion[$i])){
																			echo ($explodQuestion[$i]).'<br/><br/>';
		
																		}
																	}
																
															
															
															?>
														
														@elseif($practise['type'] == 'true_false_radio')
														<span style="color:black; font-weight:bold">Answers:</span><br>
														<?php //echo '<pre>'; print_r($practise);  
														if(isset($practise['correctanswer']) && !empty($practise['correctanswer']) && isset($practise['question']) && !empty($practise['question'])){
															$question = explode(PHP_EOL,$practise['question']);
															$correctAnswer= explode(';',$practise['correctanswer']);
															array_pop($correctAnswer);
															foreach($correctAnswer as $key=> $answer){
																$answerExplode = explode('@@',$question[$key]);
																echo $answerExplode[$answer].'<br>';
															}
															
															
														}
														?>
														@elseif($practise['type'] == 'match_answer')
															<span style="color:black; font-weight:bold">Answers:</span><br><br>
															<?php //echo '<pre>'; print_r($practise);  
															if(isset($practise['correctanswer']) && !empty($practise['correctanswer']) && isset($practise['question']) && !empty($practise['question'])&& isset($practise['question_2']) && !empty($practise['question_2'])){
																if(isset($practise['dependingpractiseid']) && !empty($practise['dependingpractiseid'])){
																	if(isset($practise['typeofdependingpractice']) && $practise['typeofdependingpractice'] == 'get_questions_and_answers'){
																		if(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer'])){
																		  if(isset($practise['depending_practise_details']) && !empty($practise['depending_practise_details']) && isset($practise['depending_practise_details']['question'])){
																			  $exploded_question = explode(PHP_EOL,$practise['depending_practise_details']['question']);
																			  $k = 0;
																			  $ans = explode(";",$practise['dependingpractise_answer'][0]);
																			  foreach($exploded_question as  $question) {
																				  if(str_contains($question,'@@')) {
															  
																					 $outValue[] = preg_replace_callback('/@@/', function ($m) use ( &$ans, &$question, &$k) {
																					  $newans = isset($ans[$k])?$ans[$k]:'';
																					  
																					  $str ='<span style="color:#ff7600">'.$newans.'</span>';
																					  $k++;
																					  return $str;
																					}, $question);
															  
																				  }
																				
																			  }
																			  $q1=$outValue;
																			  $q2=$practise['question_2'];
																			  $explode_question = explode( '#@', $practise['question_2'][0]);
																			  $explode_question_header = explode( '@@', $explode_question[0]);
																			  $q2[0]=$explode_question[1];
																			 
																			  
																		  }
																		}
																		$correctAnswer= explode(';',$practise['correctanswer']);
																			array_pop($correctAnswer);
																			foreach($correctAnswer as $key=> $answer){
																				$answerExplode = explode(':',$answer);
																				//echo '<br><pre>'; print_r($answerExplode);
																				$pos1= ((int)$answerExplode[0])-1;
																				$pos2= ((int)$answerExplode[1])-1;
																			   if(!empty($q1))
																			   {
																					if(str_contains($q1[$pos1],'#@')){
																						$que = explode('#@',$q1[$pos1]);
																						$question_1=$que[1];
																					}else{
																						$question_1 = $q1[$pos1];
																					}
			                                                   }
			                                                   if(!empty($q2))
																			   {
																				   if(str_contains($q2[$pos2],'#@')){
																				   	$que1 = explode('#@',$q2[$pos2]);
																				   	$question_2=$que1[1];
																				   }else{
																				   	$question_2 = $q2[$pos2];
																				   }
																				   echo $question_1.' : '.$question_2.'<br>';
																				}
																			}
																	  }
																}else{
																	$correctAnswer= explode(';',$practise['correctanswer']);
																	array_pop($correctAnswer);
																	foreach($correctAnswer as $key=> $answer){
																		$answerExplode = explode(':',$answer);
																		//echo '<br><pre>'; print_r($answerExplode);
																		$pos1= ((int)$answerExplode[0])-1;
																		$pos2= ((int)$answerExplode[1])-1;
	
																		if(str_contains($practise['question'][$pos1],'#@')){
																			$que = explode('#@',$practise['question'][$pos1]);
																			$question_1=$que[1];
																		}else{
																			$question_1 = $practise['question'][$pos1];
																		}
	
																		if(str_contains($practise['question_2'][$pos2],'#@')){
																			$que1 = explode('#@',$practise['question_2'][$pos2]);
																			$question_2=$que1[1];
																		}else{
																			$question_2 = $practise['question_2'][$pos2];
																		}
	
																		echo $question_1.' : '.$question_2.'<br>';
																	}
																}
																
															}
															?>
														@elseif($practise['type'] =='true_false_speaking_up_simple' || $practise['type'] == 'true_false_writing_at_end_select_option')
														<span style="color:black; font-weight:bold">Answers:</span><br>
														<?php
														$ans= array();	
															$explodAnswer=explode(';',$practise['correctanswer']);
															 array_pop($explodAnswer);
															//  dd($explodAnswer);
																foreach($explodAnswer as $k=>$answer){
																	// if($answer == "1"){
																	// 	echo "true,";
																	// }else{

																	// 	echo "false,";
																	// }
																	if($answer && $answer == 1  ){
																		$ans[$k]= "True ";
																	}elseif($answer  == 0){	
																		$ans[$k]="False";																

																	}
																}
																echo implode(", ",$ans);
														?>
														@else
														<span style="color:black; font-weight:bold">Answers:</span><br>
														<?php	
															// echo "<pre>";
															// print_r($practise);
															// echo "</pre>";
															$explodAnswer=explode(';',$practise['correctanswer']); 
															if($practise['type'] == "true_false_listening_simple" || $practise['type'] == "true_false_symbol_reading"){
																foreach($explodAnswer as $k=>$answer){
																	if($answer == "1"){
																		echo $k ==(count($explodAnswer))-1?" True":"True, ";
																	}else{
																		echo $k ==(count($explodAnswer))-1?" False":"False, ";
																	}
																}
															}elseif($practise['type'] == "true_false_writing_at_end" ){
																foreach($explodAnswer as $k=>$answer){
																	if($answer == "1"){
																		echo $k ==(count($explodAnswer))-1?" True":"True, ";
																	}else{
																		echo $k ==(count($explodAnswer))-1?" False":"False, ";
																	}
																}
															}else{
																foreach($explodAnswer as $k=>$answer){
																	
																	if(is_bool($answer) && $answer == 1  ){

																		echo "TRUE, ";
																	}elseif(is_bool($answer) && $answer == 0 ){		

																		if($k==(count($explodAnswer))-1){
																			echo "FALSE";
																		}else{
																			echo "FALSE, ";
																		}

																	}else{

																		if($k ==(count($explodAnswer))-1){																			
																			 echo $answer;
																			
																		}else{
																			if(isset($answer) && !empty($answer)){
																				echo str_replace('/','',$answer).", ";	
																			}
																		}
																		
																	}
																}
															}
															
														?>
														
													@endif
												@endif
										</div> 
										</div>
										<!-- tab 1-->
										<?php
											}
                    					?>
                 
				</div>
				<div class="col-12 col-lg-7 assessment-answer">
					<div class="assessment-answer-heading text-center">
						<h4>Student Answer</h4>
					</div>
					<div class="assessment-answer-heading-body overflow-auto" id="practise_div"></div>
				</div>
			</div>
		</div>

		<div class="success_popup" role="alert" style="display:none;text-align: center;color: green;"></div>
		<div class="error_popup" role="alert" style="display:none;text-align: center;color: red;"></div>
        <?php
         if($is_automated == false)
         { 
        ?>
		<div class="modal-footer justify-content-center">

			<div class="marks-box d-flex align-items-center justify-content-center mr-4">
				<span style="color:#d55b7d;">Marks:</span>
				<form method="POST" class="student_self_mark_form_{{$practise['id']}}">
					<input type="hidden" name="practise_id" value="{{$practise['id']}}">
					<input type="hidden" name="student_id" value="{{Session::get('user_id_new')}}">
					<div class="form-group d-flex flex-wrap align-items-center ml-4 mb-0" style="margin-left: 0.0rem!important;">
						<?php if(isset($practise['marks_gained'])){
							if($practise['marks_gained'] !== 0)
							{

								?>
								<input type="text" class="disable_copy_paste form-control self_marks_input_{{$practise['id']}}" name="marks" id="self_marks_input" value="<?php echo $practise['marks_gained'];?>"placeholder="<?php echo $practise['marks_gained'];?>" autocomplete="false" maxlength="2">
								<span class="marks">/{!!$practise['mark']!!}</span>
								<?php
							}
							else
							{

								?>
								<input type="text" class="disable_copy_paste form-control self_marks_input_{{$practise['id']}}" name="marks" id="self_marks_input" placeholder="00" autocomplete="false" maxlength="2" >
								<span class="marks">/{!!$practise['mark']!!}</span>
								<?php    
							}
						}
						else
						{ 
							?>
							<input type="text" class="disable_copy_paste form-control self_marks_input_{{$practise['id']}}" name="marks" id="self_marks_input" placeholder="00" autocomplete="false"maxlength="2">
							<span class="marks">/{!!$practise['mark']!!}</span>
							<?php    
						}

						?>

					</div>
				</form>
			</div>
			<a href="#!" class="btn btn-primary  student_self_mark_cancel_btn" id="student_self_mark_btn_{{$practise['id']}}">Submit</a>
			 <a href="#!" class="btn btn-cancel student_self_mark_cancel_btn can"  id="{{$practise['id']}}"data-dismiss="modal">Cancel</a>
		  </div>
		<?php 
         }
         if($is_automated == true)
         { 
		?>
		 <div class="modal-footer justify-content-center">
		  <a href="#!" class="btn btn-cancel student_self_mark_cancel_btn can" id="{{$practise['id']}}" data-dismiss="modal">Cancel</a>
		 </div>
		<?php
        }
		 ?>
	</div>
</div>
</div>


<div class="modal fade" id="selfmarking" tabindex="-1" role="dialog" aria-labelledby="reviewmodallabel" data-keyboard="false" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-xl review-modal">
		<div class="modal-content">
			<div class="modal-header pb-1">
				<h5 class="modal-title" id="reviewmodallabel">Give your marks</h5>
				<div class="row">
					<span class="modal-title-blocks mb-2">Topic 1</span>
					<span class="modal-title-blocks mb-2">Task 1</span>
					<span class="modal-title-blocks mb-2">A</span>
				</div>
			</div>
			<div class="modal-body">
				<p class="mb-1">Finish the conversation with one word in each gap.</p>
				<div class="row answer-match">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 p-0">
						<h4>Answer Key</h4>
						<div class="answer-key">
							<p></p>
						</div>
						<h4>Your Answer</h4>
						<div class="answer-submitted">
							<p></p>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer justify-content-center">
				<div class="marks-box d-flex align-items-center justify-content-center mr-4">
					<span style="color:#d55b7d;">Marks:</span>
					<form method="POST" class="">
						<div class="form-group d-flex flex-wrap align-items-center ml-4 mb-0" style="margin-left: 0.0rem!important;">
							<input type="text" class="form-control" name="marks" id="" value="" placeholder="00" autocomplete="false">
							<span class="marks">/10</span>
						</div>
					</form>
				</div>
				<a href="javascript:void(0);" class="btn btn-cancel student_self_mark_cancel_btn"  data-dismiss="modal">Close</a>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	<?php //echo '<pre>'; print_r($practise); ?>
	<?php
	$lastPractice=end($practises);
	if($lastPractice['id'] == $practise['id']){       
		$reviewPopup=true; 
	}else{
		$reviewPopup=false; 
	}
	?>
	$( document ).ready(function() {

        //called when key is pressed in textbox
        $("#self_marks_input").keypress(function (e) {

        	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                return false;
              }
            });

        $(".self_marks_input_{{$practise['id']}}").on('keyup', function(e){
        	var n = parseInt($(this).val());
        	var max = parseInt("{{$practise['mark']}}"); 
        	if (n > max 
        		&& e.keyCode !== 46
        		&& e.keyCode !== 8
        		) {

        		e.preventDefault();   
        	$(this).val('');
        }
        if ($(this).val() < 0 
        	&& e.keyCode !== 46
        	&& e.keyCode !== 8
        	) {
        	e.preventDefault();     
        $(this).val('');
      }
    });

        $("#student_self_mark_btn_{{$practise['id']}}").click(function(){

        	var reviewPopup = '{!!$reviewPopup!!}';
        	var p_id = "{{$practise['id']}}";
         if(p_id != "1662979120631f0c30e80cf")
         {
	        	if($('.self_marks_input_{{$practise["id"]}}').val() === ""){
	        		$('.error_popup').show().html("Please enter marks.").fadeOut(8000);
	        		return false;
	        	}
         }
                // alert("The paragraph was clicked.");
                $.ajax({
                	url: '<?php echo URL('save-student-self-marking'); ?>',
                	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                	type: 'POST',
                	data: $('.student_self_mark_form_{{$practise["id"]}}').serialize(),
                	success: function (data) {
                		console.log(data);

                		if(data.success){
                			$('.error_popup').hide();
                			$('.success_popup').show().html(data.message).fadeOut(8000);

                			$('.alert-danger').hide();
                			$('.alert-success').show().html(data.message).fadeOut(8000);

                			if(reviewPopup == 1){
                				$("#selfMarking_{{$practise['id']}}").modal('hide');
                				$("#reviewModal_{{$practise['id']}}").modal('hide');
                			}

                			setTimeout(function(){
                				$("#selfMarking_{{$practise['id']}}").modal('hide');
                			},1500)

                            // $(document).on('click', '.student_self_mark_cancel_btn', function(){
                                // alert($('.self_marking_modal_popup').find('.audio-player').find('.plyr__control--pressed').attr("type"));
                                // if($('.self_marking_modal_popup').find('.audio-player').find('.plyr__control--pressed').attr("type") == "button"){
                                //     $('.self_marking_modal_popup').find('.audio-player').find('.plyr__controls__item').trigger('click');
                                $('.self_marking_modal_popup').find('.audio-player').find('.plyr__controls__item').attr('disabled',true);
                                // }
                            // });

                          } else {

                          	$('.alert-success').hide();
                          	$('.alert-danger').show().html(data.message).fadeOut(8000);

                          	$('.success_popup').hide();
                          	$('.error_popup').show().html(data.message).fadeOut(8000);
                          }
                        }
                      });
              });

        setTimeout(function(){
        	$('.part').each(function(){
        		$(this).html($('.abc-tab .active').text())
        	})
        },1000)
      });
    </script>
    <script type="text/javascript">
    	$(document).ready(function(){
    		$('.d-scrollbar').scrollbar();
    	});


    	$('.disable_copy_paste').bind("cut copy paste",function(e) {
    		e.preventDefault();
    	});

    	$('.disable_copy_paste').keyup(function(e)
    	{
    		if (/\D/g.test(this.value))
    		{
        // Filter non-digits from input value.
        this.value = this.value.replace(/\D/g, '');
      }
    });
  </script>
  