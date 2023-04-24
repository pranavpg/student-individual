<?php
if(!isset($practise['dependingpractiseid'])) {


		$ans = [];
		if(isset($practise['user_answer'])){
				$ans = explode(";",$practise['user_answer'][0]);
		}else{
			if(isset($practise['options'])){
				foreach($practise['options'] as $data) {
					array_push($ans,$data[0]);	
				}
			}
		}
		$ans = array_filter($ans); ?>

	    <form class="reading-no-blanks_form commonFontSize" id="reading-no-blanks_form-<?php echo $practise['id'];?>">
	    	<div class="table-container">

		      	<?php
			    if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid']) && $practise['type']=="reading_no_blanks"){

			        $depend =explode("_",$practise['dependingpractiseid']); ?>

			        <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
			        <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
			    
			    <?php } ?>

		        <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
		        <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
		        <input type="hidden" class="is_save" name="is_save" value="">
		        <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
		  		<input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
				<input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

					<ul class="list-unstyled">
						<?php
						$k = 0;

						foreach($exploded_question as $key=>$question){

							$pp=0;
							if(str_contains($question,'@@')) {
								if(substr_count($question,"@@")>2) {

									echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$ans, &$data, &$question, &$k, &$pp) {
										$newans = isset($ans[$k])?trim($ans[$k]):'';
										$pp++;

										 $value = strlen($newans);
								  		if($value == ""){
											$style = "3ch";
										}else{
										  	if($value == "1" || $value == "2" || $value == "3"){
												$style = "1ch";
										  	}else{
												$style = "3ch";
										  	}
										}
	
										$str ='<span class="resizing-input1" >
									 				<span contenteditable="true" class="enter_disable spandata fillblanks stringProper" style="min-width:'.$style.' !important;">'.$newans.'</span>
									 				<input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="'.$newans.'">
													
												</span>';
			                           	$k++;
										return $str;
									}, $question);
										echo "<br>";
								}else{

								 	echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$ans, &$data, &$question, &$k) {
								 		$newans = isset($ans[$k])?trim($ans[$k]):'';

								 		$value = strlen($newans);
								  		if($value == ""){
											$style = "3ch";
										}else{
										  	if($value == "1" || $value == "2" || $value == "3"){
												$style = "1ch";
										  	}else{
												$style = "3ch";
										  	}
										}

										$str ='<span class="resizing-input1">
									 				<span contenteditable="true" class="enter_disable spandata fillblanks stringProper"  style="min-width:'.$style.' !important;">'.$newans.'</span>
									 				<input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="'.$newans.'">
													
												</span>';
			                           	$k++;
										return $str;
									}, $question);
										echo "<br>";
								}
							} else {

								?>
									<!-- <li><?php //echo $question;?></li> -->
									<?php echo $question;?>

								<?php	
								echo "<br>";
							}
							// echo "<br>"
						?>
								
						<?php }?>
					</ul>

	        </div>
	    </form> <?php 
} else {
		$ans = [];
		if(isset($practise['user_answer'])) {
			$ans = explode(";",$practise['user_answer'][0]);
		}else{
			if(isset($practise['options'])) {
				foreach($practise['options'] as $data) {
					array_push($ans,$data[0]);	
				}
			}
		}
		$ans = array_filter($ans);
		
		?>

	    <div class="table-container">
	      	<form class="reading-no-blanks_form commonFontSize" id="reading-no-blanks_form-<?php echo $practise['id'];?>">

		      	<?php
			    if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid']) && $practise['type']=="reading_no_blanks"){

			        $depend =explode("_",$practise['dependingpractiseid']); ?>

			        <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
			        <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
			    
			    <?php } ?>

		        <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
		        <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
		        <input type="hidden" class="is_save" name="is_save" value="">
		        <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
		  		<input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
				<input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
						

				<?php if($practise['typeofdependingpractice'] == "get_questions_and_answers" && $practise['typeofdependingpractice'] == "set_full_view" ) {
					$oldans = explode(PHP_EOL, $practise['depending_practise_details']['question']);
					?>

					<ul class="list-unstyled" >
						<?php

						$dependingpractise_answer = !empty($practise['dependingpractise_answer'])?$practise['dependingpractise_answer'][0]:"";
						$answer = explode(";",$dependingpractise_answer);
						$k = 0;
						foreach($oldans as $key=>$question){
							$pp=0;
							if(str_contains($question,'@@')) {
								
									echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$answer, &$data, &$question, &$k, &$pp) {
										$newanst = isset($answer[$k])?$answer[$k]:'';
										$pp++;
										$str =$newanst;
			                           	$k++;
										return $str;
									}, $question);
							
							} else {
								?>
									<li><?php echo $question;?></li>
								<?php	
							} ?>
								
						  <?php 
						}
						?>
					</ul>
				<?php 
				} 
				if($practise['typeofdependingpractice'] == "set_full_view" && $practise['depending_practise_details']['question_type'] == "reading_no_blanks"){
					?>
						<div class="append_two_blank_table"></div><br><br>
						<script type="text/javascript">

							setTimeout(function(){
								$('#reading-no-blanks_form-{{$depend[1]}}').find('.list-unstyled').clone().appendTo('.append_two_blank_table');
								$('.append_two_blank_table').find('.enter_disable').attr("contenteditable","false")
								$('.append_two_blank_table').find('.list-buttons').fadeOut();
								$('.append_two_blank_table').find('.alert-success').remove();
								$('.append_two_blank_table').find('.appendspan').each(function(){
									$(this).attr("name","")
								});
							},2000);
						</script>
					<?php
				}?>
				<?php
				if($practise['typeofdependingpractice'] == "set_full_view" && $practise['depending_practise_details']['question_type'] == "two_blank_table"){
					?>
						<div class="append_two_blank_table"></div>
						<script type="text/javascript">
							setTimeout(function(){
								$('#blank_table_form_{{$depend[1]}}').clone().appendTo('.append_two_blank_table');
								$('.append_two_blank_table').find('.list-buttons').fadeOut();
								$('.append_two_blank_table').find('.alert-success').remove();
								$('.append_two_blank_table').find('.topic_id').remove();
								$('.append_two_blank_table').find('.task_id').remove();
								$('.append_two_blank_table').find('.is_save').remove();
								$('.append_two_blank_table').find('.practise_id').remove();
								$('.append_two_blank_table').find('.textarea').attr("contenteditable",false);
							},2000);
						</script>
					<?php
				}?>

				<?php
				if($practise['typeofdependingpractice'] == "set_full_view" && $practise['depending_practise_details']['question_type'] == "four_blank_table"){
					?>
						<div class="append_two_blank_table"></div>
						<script type="text/javascript">
							setTimeout(function(){
								$('#blank_table_form_{{$depend[1]}}').clone().appendTo('.append_two_blank_table');
								$('.append_two_blank_table').find('.list-buttons').fadeOut();
								$('.append_two_blank_table').find('.list-buttons').fadeOut();
								$('.append_two_blank_table').find('.textarea').removeAttr('contenteditable');
								$('.append_two_blank_table').find('.topic_id').remove();
								$('.append_two_blank_table').find('.task_id').remove();
								$('.append_two_blank_table').find('.is_save').remove();
								$('.append_two_blank_table').find('.practise_id').remove();
								$('.append_two_blank_table').find('.alert-success').remove();
							},2000);
						</script>
					<?php
				}?>

				<?php
				if($practise['typeofdependingpractice'] == "set_full_view_remove_top_zero" && $practise['depending_practise_details']['question_type'] == "four_table_option"){

					  $data[$practise['id']] = array();
					  $data[$practise['id']]['isRolePlayPractice'] = (!empty($practise['is_roleplay']) &&  $practise['is_roleplay']==1)?1:0;
					  $data[$practise['id']]['typeofdependingpractice'] = !empty($practise['typeofdependingpractice']) ? $practise['typeofdependingpractice'] : "";
					  $data[$practise['id']]['setFullViewFromPreviousPractice'] = !empty($practise['depending_practise_details']['dependant_practise_id']) ? $practise['depending_practise_details']['dependant_practise_id']:"";
					  $data[$practise['id']]['dependant_practise_topic_id'] = !empty($practise['depending_practise_details']['dependant_practise_topic_id']) ? $practise['depending_practise_details']['dependant_practise_topic_id']:"";
					  $data[$practise['id']]['dependant_practise_task_id'] = !empty($practise['depending_practise_details']['dependant_practise_task_id']) ? $practise['depending_practise_details']['dependant_practise_task_id']:"";
					  $data[$practise['id']]['dependant_practise_question_type'] = !empty($practise['depending_practise_details']['question_type']) ? $practise['depending_practise_details']['question_type']:"";
					  $data[$practise['id']]['dependent_is_roleplay'] = !empty($practise['depending_practise_details']['is_roleplay']) ? $practise['depending_practise_details']['is_roleplay']:"";
					  $data[$practise['id']]['dependentpractice_ans'] = !empty($practise['dependingpractise_answer'])?1:0;
					  $data[$practise['id']]['is_dependent'] = !empty($practise['is_dependent']) ? 1 : 0;

					  if(!empty($practise['dependingpractise_answer'])){


					  ?>

					   	<div class="showPreviousPractice_reding_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}"></div>
					   <?php } ?>

					  	<script>
							if(data==undefined ){
								var data=[];
							}
						 	var token = $('meta[name=csrf-token]').attr('content');
							var upload_url = "{{url('upload-audio')}}";
							var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
							data["{{$practise['id']}}"]= {"dependentpractice_ans": "{{$data[$practise['id']]['dependentpractice_ans']}}" };
							data["{{$practise['id']}}"]["isRolePlayPractice"] = "{{$data[$practise['id']]['isRolePlayPractice']}}"
							data["{{$practise['id']}}"]["is_dependent"] = "{{$data[$practise['id']]['is_dependent']}}"; 
							if(data["{{$practise['id']}}"]["is_dependent"]==1){
								
								if(data["{{$practise['id']}}"]["dependentpractice_ans"]==0 ){
									$(".previous_practice_answer_exists_{{$practise['id']}}").hide();
									$("#dependant_pr_{{$practise['id']}}").show();
								} else {
									$(".previous_practice_answer_exists_{{$practise['id']}}").show();
									$("#dependant_pr_{{$practise['id']}}").hide();
								}
							}
						</script>
						@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==0 && $practise['typeofdependingpractice']!='get_answers_generate_quetions' )
							<script>
								data["{{$practise['id']}}"]["typeofdependingpractice"] = "{{ $data[$practise['id']]['typeofdependingpractice'] }}";
								data["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
								if(data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_top_zero"){
									data["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
									data["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
									if(data["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
										if(data["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
							                setTimeout(function(){ 
							                    data["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();				 
											    $(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(data["{{$practise['id']}}"]["prevHTML"]);
												$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
												$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.removebutton').remove();
												$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert').remove();
												if( data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
														$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.audio-player').remove();

													if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
														$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
							                        }
							                        if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "set_in_order_vertical_listening") {
														$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.audio-player').remove();
													}
												}
											}, 5000,data )
										}
									} else {
										var baseUrl = "{{url('/')}}";
										data["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
										data["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data["{{$practise['id']}}"]["dependant_practise_id"]+'&user_id={{ isset($studentId)?$studentId:'' }}';
										$.get(data["{{$practise['id']}}"]["dependentURL"], function (dataHTML, textStatus, jqXHR) {
											
											data["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
											$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(data["{{$practise['id']}}"]["prevHTML"]);
											$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
											$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find(".blankTableBtn_"+data["{{$practise['id']}}"]["dependant_practise_id"]).remove();
											$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find(".topic_id").remove();
											$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find(".task_id").remove();
											$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find(".is_save").remove();
											$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find(".practise_id").remove();
											$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find(".alert-success").remove();
											$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find(".alert-danger").remove();
											if(data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
												if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
													$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
												}
											}
										});
									}
								} else {
									setTimeout(function(){
							            getSpeakingMultipleDependency();
									},5000);
								}
							</script>
							@endif
					  <?php
				}
				if($practise['typeofdependingpractice'] == "get_questions_and_answers" && $practise['depending_practise_details']['question_type'] == "reading_no_blanks_listening"){
					  $data[$practise['id']] = array();
					  $data[$practise['id']]['isRolePlayPractice'] = (!empty($practise['is_roleplay']) &&  $practise['is_roleplay']==1)?1:0;
					  $data[$practise['id']]['typeofdependingpractice'] = !empty($practise['typeofdependingpractice']) ? $practise['typeofdependingpractice'] : "";
					  $data[$practise['id']]['setFullViewFromPreviousPractice'] = !empty($practise['depending_practise_details']['dependant_practise_id']) ? $practise['depending_practise_details']['dependant_practise_id']:"";
					  $data[$practise['id']]['dependant_practise_topic_id'] = !empty($practise['depending_practise_details']['dependant_practise_topic_id']) ? $practise['depending_practise_details']['dependant_practise_topic_id']:"";
					  $data[$practise['id']]['dependant_practise_task_id'] = !empty($practise['depending_practise_details']['dependant_practise_task_id']) ? $practise['depending_practise_details']['dependant_practise_task_id']:"";
					  $data[$practise['id']]['dependant_practise_question_type'] = !empty($practise['depending_practise_details']['question_type']) ? $practise['depending_practise_details']['question_type']:"";
					  $data[$practise['id']]['dependent_is_roleplay'] = !empty($practise['depending_practise_details']['is_roleplay']) ? $practise['depending_practise_details']['is_roleplay']:"";
					  $data[$practise['id']]['dependentpractice_ans'] = !empty($practise['dependingpractise_answer'])?1:0;
					  $data[$practise['id']]['is_dependent'] = !empty($practise['is_dependent']) ? 1 : 0;
					  ?>
					   <div class="showPreviousPractice_reding_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}"></div><br>
					  <script>
							if(data==undefined ){
								var data=[];
							}
						 	var token = $('meta[name=csrf-token]').attr('content');
							var upload_url = "{{url('upload-audio')}}";
							var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
							data["{{$practise['id']}}"]= {"dependentpractice_ans": "{{$data[$practise['id']]['dependentpractice_ans']}}" };
							data["{{$practise['id']}}"]["isRolePlayPractice"] = "{{$data[$practise['id']]['isRolePlayPractice']}}"
							data["{{$practise['id']}}"]["is_dependent"] = "{{$data[$practise['id']]['is_dependent']}}"; 
							if(data["{{$practise['id']}}"]["is_dependent"]==1){
								if(data["{{$practise['id']}}"]["dependentpractice_ans"]==0 ){
									$(".previous_practice_answer_exists_{{$practise['id']}}").hide();
									$("#dependant_pr_{{$practise['id']}}").show();
								} else {
									$(".previous_practice_answer_exists_{{$practise['id']}}").show();
									$("#dependant_pr_{{$practise['id']}}").hide();
								}
							}
						</script>
						@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==0 && $practise['typeofdependingpractice']!='get_answers_generate_quetions' )
						@php
						@endphp
							<script>
								data["{{$practise['id']}}"]["typeofdependingpractice"] = "{{ $data[$practise['id']]['typeofdependingpractice'] }}";
								data["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
								if(data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_top_zero" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="get_questions_and_answers"){
									data["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
									data["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
									if(data["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
										if(data["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
							                setTimeout(function(){ 
											    data["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();				 
											    $(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(data["{{$practise['id']}}"]["prevHTML"]);
												$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
												$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.removebutton').remove();
												$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.list-buttons').remove();
												$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert').remove();
												if( data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
														$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.audio-player').remove();
													if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
														$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
							                        }
							                        if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "set_in_order_vertical_listening") {
														$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.audio-player').remove();
													}
												}
												$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.topic_id').remove();
												$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.task_id').remove();
												$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.practise_id').remove();
												$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('input').each(function(){
													$(this).attr("name","old_reding")
												})
											}, 3000,data )
										}
									} else {
										var baseUrl = "{{url('/')}}";
										data["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
										data["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data["{{$practise['id']}}"]["dependant_practise_id"]+'&user_id={{ isset($studentId)?$studentId:'' }}';
										$.get(data["{{$practise['id']}}"]["dependentURL"],  //
										function (dataHTML, textStatus, jqXHR) {  // success callback
											data["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
											$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(data["{{$practise['id']}}"]["prevHTML"]);
											$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
											$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find(".blankTableBtn_"+data["{{$practise['id']}}"]["dependant_practise_id"]).remove();
											
											if(data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
												 
												if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
													$(document).find(".showPreviousPractice_reding_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
												}
											}
										});
									}
								} else {
									setTimeout(function(){
							            getSpeakingMultipleDependency();
									},3000);
								}
							</script>
							@endif
					  <?php
				}?>
				<ul class="list-unstyled ">
					<?php
					$k = 0;
					$exploded_question = array_filter($exploded_question);
					$exploded_question = array_merge($exploded_question);
					foreach($exploded_question as $key=>$question) {
						$pp=0;
						if(str_contains($question,'@@')) {

							if(substr_count($question,"@@")>2){
								echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$ans, &$data, &$question, &$k, &$pp) {
									$newans = isset($ans[$k])?trim($ans[$k]):'';


									$value = strlen($newans);
							  		if($value == ""){
										$style = "3ch";
									}else{
									  	if($value == "1" || $value == "2" || $value == "3"){
											$style = "1ch";
									  	}else{
											$style = "3ch";
									  	}
									}

									$pp++;
									$str ='<span class="resizing-input1">
												<span contenteditable="true" class="enter_disable spandata fillblanks stringProper" style="min-width:'.$style.' !important;">'.$newans.'</span>
								 				<input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="'.$newans.'">
											</span>';
		                           	$k++;
									return $str;
								}, $question);

							}else{

							 	echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$ans, &$data, &$question, &$k) {
							 		$newans = isset($ans[$k])?trim($ans[$k]):'';

							 		$value = strlen($newans);
							  		if($value == ""){
										$style = "3ch";
									}else{
									  	if($value == "1" || $value == "2" || $value == "3"){
											$style = "1ch";
									  	}else{
											$style = "3ch";
									  	}
									}
									$str ='<span class="resizing-input1">
										<span contenteditable="true" class="enter_disable spandata fillblanks stringProper" style="min-width:'.$style.' !important;">'.$newans.'</span>
								 				<input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="'.$newans.'">

									</span>';

		                           	$k++;
									return $str;
								}, $question);
							}
						} else {
								if(isset($practise['dependingpractise_answer']) && empty($practise['dependingpractise_answer']) && $practise['typeofdependingpractice'] != "set_full_view"){
										$depend =explode("_",$practise['dependingpractiseid']);
									?>
									<input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
									<input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
									<div id="dependant_pr_new_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
										<p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
									</div>
								<?php } 
								?>
								<li class="newdata_temp"><?php echo $question;?></li>
							<?php	
						}
						echo "<br>";
					} ?>
				</ul>
	      	</form>
	    </div>
	    	<?php
	    	if(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer'])) {

		    		if($practise['typeofdependingpractice'] == "get_answers_generate_questions_underline") {
							$ans = [];
							if(isset($practise['user_answer'])){
								$ans = explode(";",$practise['user_answer'][0]);
							}
							$tempAnswers = [];
			    			foreach ($practise['dependingpractise_answer'][0] as $key => $value) {
			    				foreach (json_decode($value) as $key => $inner) {
		    						$newKey = str_replace("n_","",$key);
		    						$tempAnswers[(int) $newKey] = $inner;
			    				}
			    			}
			    			ksort($tempAnswers);
			    			$dependancyIns = [];
			    			foreach ($tempAnswers as $key => $value) {
			    				array_push($dependancyIns,$value->word);
			    			}
							$ans = [];
							$flagIsDependancy = false;
							if(isset($practise['user_answer'])) {
								$flagIsDependancy = true;
								$ans = explode(";",$practise['user_answer'][0]);
							}
							$ans = array_filter($ans);
							$ans = array_merge($ans);
							if(count($ans) != count($dependancyIns)){
								$flagIsDependancy = false;
							}
			    			?>
			    			<script type="text/javascript">
				    			var Newanswers	='<?php echo !empty($practise['dependingpractise_answer'])?$practise['dependingpractise_answer'][0][0]:"[]" ?>';
				    			var flag 		='<?php echo $flagIsDependancy ?>';
				    			var Newanswers = JSON.parse(Newanswers);
				    			if(flag){
				    				var ans='<?php echo addslashes(json_encode($ans)); ?>';
					    			var  ans= JSON.parse(ans);
				    			}else{
			    					var ans='<?php echo !empty($dependancyIns)?json_encode($dependancyIns):"[]" ?>';
					    			var ans = JSON.parse(ans);
				    			}
				    			var array = new Array();
			    				$.each( Newanswers, function( key, value ) {
			    					array.push(value.i);
								});
			    				setTimeout(function(){
			    					highlight();
			    				},500)
			    				function highlight() {
								    var current_key = 0;
							        var wordNumber;
							        var k=0;
							        var end=0;
							        $('.newdata_temp').each(function(key){
										var paragraph="";
										var str = $(this).text();
										var $this =$(this);
										str.replace(/[ ]{2,}/gi," ");
										$this.attr('data-total_characters', str.length);
										$this.attr('data-total_words', str.split(' ').length);
										var words = $this.text().split(' ');//split( /\s+/ );
										var temp =0;
										for(var i=0; i<words.length;i++){
											var word = $.trim(words[i].replace(/^\s+/,""));
											if(word !=""){
												if( key==0){
													wordNumber = k;
												}else{
													wordNumber = k+key;
												}
												if(i==0 && key==0){
												    end=word.length;
												}else{
													if(key>=1){
														if(i==0){
															end+=word.length;
															end+= 3
														} else{
															end+=word.length;
															end++;
														}
													}else{
														end+=word.length;
														end++;
													}
												}
												if(array.indexOf(wordNumber) =="-1"){
													var start = end-word.length
													var iName= "text_ans[0][0]["+wordNumber+"][i]";
													var fColorName =  "text_ans[0][0]["+wordNumber+"][fColor]"
													var foregroundColorSpanName = "text_ans[0][0]["+wordNumber+"][foregroundColorSpan]";
													var wordName="text_ans[0][0]["+wordNumber+"][word]";
													var startName = "text_ans[0][0]["+wordNumber+"][start]";
													var endName = "text_ans[0][0]["+wordNumber+"][end]";
													paragraph+="<span class='highlight-text' id="+wordNumber+" data-key="+key+" data-wordlength="+word.length+"><input type='hidden' class='i' disabled name="+iName+" value="+wordNumber+"><input type='hidden' class='fColor' disabled name="+fColorName+" value='-1145286'><input type='hidden' class='foregroundColorSpan' disabled name="+foregroundColorSpanName+" value='-1145286'> <input type='hidden' class='word' disabled name="+wordName+" value="+words[i]+" ><input type='hidden' disabled name="+startName+" class='start' value="+start+" ><input disabled type='hidden' name="+endName+" value="+parseInt(end)+" class='end'>"+word+"</span>"
													if(i==115){
														paragraph+="<br><br>";
													}
													$this.html(paragraph);
												}else{
													if(typeof(ans[temp]) =="undefined"){
														var nans ="";		
													}else{
														if(ans[temp]==""){
															var nans =word;	
														}else{
															var nans =ans[temp];	
														}
													}
													var size = "3ch !important";
													if(nans.length == 1 || nans.length == 2 ){
														size = "1ch !important";
													}
													paragraph+="<span class='resizing-input1'><span contenteditable='true' class='enter_disable spandata fillblanks stringProper' style='min-width:"+size+"'>"+nans+"</span><input type='hidden' class='form-control form-control-inline appendspan' name='blanks[]' value="+nans+"></span>";
													temp++;
													if(i==115){
														paragraph+="<br><br>";
													}
													$this.html(paragraph);
												}
											}
											k++;
										}
							    	});
								}
			    			</script>

			    	<?php }elseif($practise['typeofdependingpractice'] == "get_answers_generate_questions_underline_five") {
									$ans = [];
										if(isset($practise['user_answer'])){
											$ans = explode(";",$practise['user_answer'][0]);
										}

									$tempAnswers = [];
					    			foreach ($practise['dependingpractise_answer'][0] as $key => $value) {
					    				foreach (json_decode($value) as $key => $inner) {
				    						$newKey = str_replace("n_","",$key);
				    						$tempAnswers[(int) $newKey] = $inner;
					    				}
					    			}

					    			ksort($tempAnswers);
					    			$dependancyIns = [];
					    			foreach ($tempAnswers as $key => $value) {
					    					array_push($dependancyIns,$value->word);
					    			}
									$ans = [];
									$flagIsDependancy = false;
									if(isset($practise['user_answer'])){
										$flagIsDependancy = true;
										$ans = explode(";",$practise['user_answer'][0]);
									}
									$ans = array_filter($ans);
									$ans = array_merge($ans);
									if(count($ans) != count($dependancyIns)){

										$flagIsDependancy = false;
									}
					    			?>
					    			<script type="text/javascript">
						    			var Newanswers	='<?php echo !empty($practise['dependingpractise_answer'])?$practise['dependingpractise_answer'][0][0]:"[]" ?>';
						    			var flag 		='<?php echo $flagIsDependancy ?>';
						    			var Newanswers = JSON.parse(Newanswers);
						    			if(flag){
						    				var ans='<?php echo addslashes(json_encode($ans)) ; ?>';
							    			var  ans= JSON.parse(ans);
						    			}else{
					    					var ans='<?php echo !empty($dependancyIns)?addslashes(json_encode($dependancyIns)) :"[]" ?>';
							    			var ans = JSON.parse(ans);
						    			}
						    			var array = new Array();
					    				$.each( Newanswers, function( key, value ) {
					    					array.push(value.i);
										});
					    				setTimeout(function(){
					    					highlight();
					    				},500)
					    				function highlight() {
										    var current_key = 0;
										        var wordNumber;
										        var k=0;
										        var end=0;
										        $('.newdata_temp').each(function(key){
													var paragraph="";
													var str = $(this).text();
													var $this =$(this);
													str.replace(/[ ]{2,}/gi," ");
													$this.attr('data-total_characters', str.length);
													$this.attr('data-total_words', str.split(' ').length);
													var words = $this.first().text().split(' ');//split( /\s+/ );
													var temp =0;
													for(var i=0; i<words.length;i++){
													var word = $.trim(words[i].replace(/^\s+/,""));
													if(word !=""){
														if( key==0){
														    wordNumber = k;
														}else{
														    wordNumber = k+key;
														}

														if(i==0 && key==0){
														      end=word.length;
														}else{
															    if(key>=1){
															      		if(i==0){
															        		end+=word.length;
															        		end+= 3
															      		} else{
															        		end+=word.length;
															        		end++;
															      		}
															    } else {
															      end+=word.length;
															      end++;
															    }
														  }

														  if(array.indexOf(wordNumber) =="-1"){

															  var start = end-word.length
															  var iName= "text_ans[0][0]["+wordNumber+"][i]";
															  var fColorName =  "text_ans[0][0]["+wordNumber+"][fColor]"
															  var foregroundColorSpanName = "text_ans[0][0]["+wordNumber+"][foregroundColorSpan]";
															  var wordName="text_ans[0][0]["+wordNumber+"][word]";
															  var startName = "text_ans[0][0]["+wordNumber+"][start]";
															  var endName = "text_ans[0][0]["+wordNumber+"][end]";
															  paragraph+="<span class='highlight-text' id="+wordNumber+" data-key="+key+" data-wordlength="+word.length+"><input type='hidden' class='i' disabled name="+iName+" value="+wordNumber+"><input type='hidden' class='fColor' disabled name="+fColorName+" value='-1145286'><input type='hidden' class='foregroundColorSpan' disabled name="+foregroundColorSpanName+" value='-1145286'> <input type='hidden' class='word' disabled name="+wordName+" value="+words[i]+" ><input type='hidden' disabled name="+startName+" class='start' value="+start+" ><input disabled type='hidden' name="+endName+" value="+parseInt(end)+" class='end'>"+word+"</span>"
															  $this.html(paragraph);

														  }else{
														  		// console.log(ans[temp]);
														  		if(typeof(ans[temp]) =="undefined"){
														  			// console.log("undefined")
														  			var nans ="";		
														  		}else{
															  		if(ans[temp]==""){
															  			var nans =word;	

															  		}else{
															  			var nans =ans[temp];	

															  		}
														  		}
																var size = "3ch !important";
																if(nans.length == 1 || nans.length == 2 ){
																	size = "1ch !important";
																}
																paragraph+="<span class='resizing-input1'><span contenteditable='true' class='enter_disable spandata fillblanks stringProper' style='min-width:"+size+"'>"+nans+"</span><input type='hidden' class='form-control form-control-inline appendspan' name='blanks[]' value="+nans+"></span>";
																temp++;
																$this.html(paragraph);
														  }
													}
													k++;
												}
										    });
										  }

			    			</script><?php
			    		}
	    	}else{
	    		?>
	    			<script type="text/javascript">
	    				$('.newdata_temp').fadeOut();
	    			</script>
	    		<?php
			} ?>
<?php } ?>

