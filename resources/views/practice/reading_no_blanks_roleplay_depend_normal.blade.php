<?php
// dd($practise['typeofdependingpractice']);
	if($practise['typeofdependingpractice'] =="get_answers_generate_quetions") {

		$ans = [];
		
		if(!isset($practise['user_answer'])) {

			if(isset($practise['dependingpractise_answer'])) {

				foreach($practise['dependingpractise_answer'] as $key=>$data) {
					$temparray = [];
					if($data !="##"){
						$temparray = !empty($data)?explode(";",rtrim($data[0], ';')):"";
					}

					if(!empty($data)){
						foreach($temparray as $answrs){
							array_push($ans,$answrs);	
						}
					}
				}
			}else{
				foreach($practise['options'] as $data) {
					array_push($ans,'');	
				}
			}
			$newAns = [];
			foreach ($ans as $key => $value) {
				if($value!="##") 
				array_push($newAns, $value);
			}
		}else{
			if(isset($practise['user_answer'])){
				foreach($practise['user_answer'] as $key=>$data) {
					$temparray = [];
					if($data !="##"){
						$temparray = !empty($data)?explode(";",rtrim($data[0], ';')):"";
					}
					if(!empty($data)) {
						foreach($temparray as $answrs){
							array_push($ans,$answrs);	
						}
					}
				}
			}else{
				foreach($practise['options'] as $data) {
					array_push($ans,'');	
				}
			}
			$newAns = [];
			foreach ($ans as $key => $value) {
				if($value!="##") 
				array_push($newAns, $value);
			}
		}


		if(!empty($newAns)){  ?>
			<form class="reading-no-blanks_form" id="reading-no-blanks_form-<?php echo $practise['id'];?>">
			    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
			    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
			    <input type="hidden" class="is_save" name="is_save" value="">
			    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
				<input type="hidden" class="is_roleplay"  name="is_roleplay" value="true" >
				<input type="hidden" class="is_roleplay_submit" name="is_roleplay_submit" value="1">

				<?php
					if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){ 
							$depend =explode("_",$practise['dependingpractiseid']);
						?>

						<input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
						<input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">

						<div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
							<p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
						</div>
				<?php } 

					$rolePlayQuestions = explode("##",$practise['depending_practise_details']['question']);
					$rolePlayUsers = explode("@@",$rolePlayQuestions[0]);
					$userAnswer = array();
					// dd($rolePlayQuestions);
					if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
						foreach($practise['user_answer'] as $userAns){
							if(is_array($userAns)){
								$userAns = $userAns[0];
								$userAns = explode(";",$userAns);
								foreach($userAns as $userAn){
					                if(!empty($userAn)){
					                  	$userAnswer[] = $userAn;
					                }
								}
							}
							else{
					            if(!empty(trim($userAns))){
					                $userAnswer[] = $userAns;
					            }

							}
						}
					}  ?>

					<div class="component-two-click mb-4">
						<div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
							<?php
							if(!empty($rolePlayUsers)){
							$userAnsCount = 0;
							
							foreach($rolePlayUsers as $c=>$rolePlayUser){?>
								<a href="#!" id="s-button-<?php echo $c;?>" class="btn btn-dark s-button-{{$practise['id']}} selected_option selected_option_{{$c}} {{$practise['id']}}"  data-key="{{$c}}"><?php echo trim($rolePlayUser);?></a>
							<?php }}?>
						</div>
						<div class="two-click-content w-100">
							<?php
									// dd($practise);
								$k = 0;

								$doubleInc = 0 ;
								
								if(!empty($rolePlayUsers)){
									foreach($rolePlayUsers as $s=>$rolePlayUser){
										$exploded_question = explode(PHP_EOL, $rolePlayQuestions[$s+1]); 

										?>
										<div class="content-box multiple-choice s-button-box d-none selected_option_description selected_option_description_{{$s}}" id="s-button-<?php echo $s.''.$s;?>">
											<ul class="list-unstyled">
												<?php
													$newFlag  = 0 ;
													foreach($exploded_question as $question) {
														
														if(empty(trim($question))){ continue; }

															$ansData = "";
															if(!isset($practise['user_answer'])) {

																if($practise['dependingpractise_answer'][$doubleInc] != "") {
																	$ansData = explode(";",$practise['dependingpractise_answer'][$doubleInc][0]);
																}
															}else{
																// dd($practise['user_answer'][0][$doubleInc]);
																if($practise['user_answer'][$doubleInc] != "") {
																	$ansData = explode(";",$practise['user_answer'][$doubleInc][0]);
																}else{
																	$ansData = isset($practise['dependingpractise_answer'][$doubleInc]) && $practise['dependingpractise_answer'][$doubleInc]!=""?explode(";",$practise['dependingpractise_answer'][$doubleInc][0]):[];
																}
																// $practise['user_answer']


															}
														?>
														<li>
															<?php

															// dd($question);
															if(str_contains($question,'@@')) {
															 	if(substr_count($question,"@@")>2){
																	echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$newAns, &$data, &$question, &$k, &$ansData, &$newFlag){

																		$ans = isset($ansData[$newFlag])?trim($ansData[$newFlag]):'';

																		$value = strlen($ans);
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
																 				<span contenteditable="true" class="enter_disable spandata fillblanks stringProper text-left" style="min-width:'.$style.' !important;">'.$ans.'</span>
																 				<input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="'.$ans.'">
																				
																			</span>';
											                           	$k++;
											                           	$newFlag++;
																		return $str;
																	}, $question);

																}else{

																 	echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$newAns, &$data, &$question, &$k, &$newFlag) {
																 		$ans = isset($ansData[$newFlag])?$ansData[$newFlag]:'';


																 		$value = strlen($ans);
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
																 				<span contenteditable="true" class="enter_disable spandata fillblanks stringProper text-left"  style="min-width:'.$style.' !important;">'.$ans.'</span>
																 				<input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="'.$ans.'">
																				
																			</span>';
											                           	$k++;
											                           	$newFlag++;
																		return $str;
																	}, $question);
																}

															}
															?>
														</li>
											<?php   } ?>
				                				<input type="hidden" name="blanks[]" value="##">
											</ul>
										</div>
										<?php 
										$doubleInc = $doubleInc+2;

									} 
										
								 }?>
						</div>
					</div>
						
					<div class="alert alert-success" role="alert" style="display:none"></div>
					<div class="alert alert-danger" role="alert" style="display:none"></div>

					<ul class="list-inline list-buttons">
					    <li class="list-inline-item">
								<button class="save_btn btn btn-primary btnSubmits_reding submitBtn_{{$practise['id']}}" data-is_save="0">Save</button>
					    </li>
					    <li class="list-inline-item">
								<button class="submit_btn btn btn-primary btnSubmits_reding submitBtn_{{$practise['id']}}" data-is_save="1"  >Submit</button>
					    </li>
					</ul>
				</form>
		<?php 	} else { ?>
				<form class="reading-no-blanks_form" id="reading-no-blanks_form-<?php echo $practise['id'];?>">
			    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
			    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
			    <input type="hidden" class="is_save" name="is_save" value="">
			    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
					<input type="hidden" class="is_roleplay"  name="is_roleplay" value="true" >
					<input type="hidden" class="is_roleplay_submit" name="is_roleplay_submit" value="1">
						<?php $depend =explode("_",$practise['dependingpractiseid']); ?>
						<input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
						<input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
						<div id="dependant_pr_{{$practise['id']}}" style="border: 2px dashed gray; border-radius: 12px;">
							<p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
						</div>
				</form>
			<?php
		}

	}elseif($practise['typeofdependingpractice'] =="set_full_view") {


		$ans = [];
		if(!isset($practise['user_answer'])){
			if(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer'])  ) {
					if( strpos( $practise['dependingpractise_answer'][0], ";" ) !== false) {
						foreach($practise['dependingpractise_answer'] as $key=>$data) {
							$temparray = [];
							if($data !="##"){
								if(isset($data[0])){
									$temparray = explode(";",rtrim($data[0], ';'));
								}
							}
							foreach($temparray as $answrs){
								array_push($ans,$answrs);	
							}
						}
					}else{
						$temparray = [];
						foreach($practise['dependingpractise_answer'] as $key=>$data) {
							if($data !="##"){
								// $temparray = $data;
								array_push($ans,$data);
							}
						}
					}
			}else{
				// foreach($practise['options'] as $data) {
				// 	array_push($ans,$data[0]);	
				// }
			}
			
			$newAns = [];
			foreach ($ans as $key => $value) {
				if($value!="##") 
				array_push($newAns, $value);
			}
		}else{
			if(isset($practise['user_answer'])){
				
				foreach($practise['user_answer'] as $key=>$data) {
					$temparray = [];
					if($data !="##"){
						if($data!=""){
							$temparray = explode(";",rtrim($data[0], ';'));
						}
					}
					foreach($temparray as $answrs){
						array_push($ans,$answrs);	
					}
				}
			}else{
				foreach($practise['options'] as $data) {
					array_push($ans,$data[0]);	
				}
			}
			$newAns = [];
			foreach ($ans as $key => $value) {
				if($value!="##") 
				array_push($newAns, $value);
			}
		}
		?>
			<form class="reading-no-blanks_form" id="reading-no-blanks_form-<?php echo $practise['id'];?>">
			    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
			    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
			    <input type="hidden" class="is_save" name="is_save" value="">
			    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
				<input type="hidden" class="is_roleplay"  name="is_roleplay" value="true" >
				<input type="hidden" class="is_roleplay_submit" name="is_roleplay_submit" value="1">

				<?php
					if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){ 
							$depend =explode("_",$practise['dependingpractiseid']);
						?>

						<input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
						<input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">

						<div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
							<p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
						</div>
				<?php } 

					$rolePlayQuestions = explode("##",$practise['question']);
					$rolePlayUsers = explode("@@",$rolePlayQuestions[0]);
					$userAnswer = array();
					// dd($rolePlayQuestions);
					if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
						foreach($practise['user_answer'] as $userAns){
							if(is_array($userAns)){
								$userAns = $userAns[0];
								$userAns = explode(";",$userAns);
								foreach($userAns as $userAn){
					                if(!empty($userAn)){
					                  	$userAnswer[] = $userAn;
					                }
								}
							}
							else{
					            if(!empty(trim($userAns))){
					                $userAnswer[] = $userAns;
					            }

							}
						}
					} 

					if(isset($practise['is_roleplay']) && $practise['is_roleplay'] &&  isset($practise['dependingpractiseid']) && $practise['dependingpractiseid']!="" && isset($practise['depending_practise_details'])) {
								$rolePlayQuestions_depend = explode("##",$practise['depending_practise_details']['question']);
								$rolePlayUsers_depend = explode("@@",$rolePlayQuestions_depend[0]);
								
									$tempinc = 0;

								foreach($rolePlayUsers_depend as $s=>$rolePlayUser){
										$exploded_question_depend = explode(PHP_EOL, $rolePlayQuestions_depend[$s+1]); ?>
										<div class="content-box multiple-choice s-button-box d-none selected_option_description selected_option_description_{{$s}}" id="s-button-<?php echo $s.''.$s;?>">
											<ul class="list-unstyled">
												<?php
													
													foreach($exploded_question_depend as $question){
															
														if(empty(trim($question))){ continue;} ?>

														<li>
															<?php
															if(str_contains($question,'@@')) {
															 	
																 	echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$tempincey1, &$newAns, &$data, &$question, &$tempinc, &$practise) {
																 		
															 			$ans = isset($practise['dependingpractise_answer'][$tempinc])?trim($practise['dependingpractise_answer'][$tempinc]):'';
																	

																 		$value = strlen($ans);
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
																 				<span contenteditable="false" class="enter_disable spandata fillblanks stringProper text-left" style="min-width:'.$style.' !important;">'.$ans.'</span>
																 				<input type="hidden" class="form-control form-control-inline appendspan"  value="'.$ans.'">
																				
																			</span>';


											                           	$tempinc = $tempinc+2;
																		return $str;
																	}, $question);
															
															}else{
																echo $question;
															}
															?>
														</li>
											<?php   }?>
				                				
											</ul>
										</div>
										<?php 
									} 
						 }
					?>
					<br>
					<div class="component-two-click mb-4">
						<div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
							<?php
							if(!empty($rolePlayUsers)){
								$userAnsCount = 0;
								
								foreach($rolePlayUsers as $c=>$rolePlayUser){?>
									<a href="#!" id="s-button-<?php echo $c;?>" class="btn btn-dark s-button-{{$practise['id']}} selected_option selected_option_{{$c}} {{$practise['id']}}"  data-key="{{$c}}"><?php echo trim($rolePlayUser);?></a>
								<?php }
							}?>
						</div>
						<div class="two-click-content w-100">
							<?php
								//	pr($userAnswer);
								$k = 0;
								if(!empty($rolePlayUsers)) {
										$reading = 0;
									foreach($rolePlayUsers as $s=>$rolePlayUser) {
										$exploded_question = explode(PHP_EOL, $rolePlayQuestions[$s+1]); ?>
										<div class="content-box multiple-choice s-button-box d-none selected_option_description selected_option_description_{{$s}}" id="s-button-<?php echo $s.''.$s;?>">
											<ul class="list-unstyled">
												<?php
													
													foreach($exploded_question as $question){
														$tm = 0;
														if(empty(trim($question))){ continue;} ?>

														<li>
															<?php
															if(str_contains($question,'@@')) {
															 	if(substr_count($question,"@@")>2){

																	echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$newAns, &$data, &$question, &$k, &$reading, &$practise, &$tm) {

															 			$ans = isset($practise['user_answer'][$reading])?explode(";",$practise['user_answer'][$reading][0]):'';
																		$newAns = isset($ans[$tm])?trim($ans[$tm]):"";


															 			$value = strlen($newAns);
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
																 				<span contenteditable="true" class="enter_disable spandata fillblanks stringProper text-left" style="min-width:'.$style.' !important;">'.$newAns.'</span>
																 				<input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="'.$newAns.'">
																			</span>';
											                           	$k++;
											                           	$tm++;
																		return $str;
																	}, $question);


																}else{

																 	echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$newAns, &$data, &$question, &$k) {
																 		$ans = isset($newAns[$k])?trim($newAns[$k]):'';
																	 		$value = strlen($ans);
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
																 				<span contenteditable="true" class="enter_disable spandata fillblanks stringProper text-left" style="min-width:'.$style.' !important;">'.$ans.'</span>
																 				<input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="'.$ans.'">
																				
																			</span>';

											                           	$k++;
																		return $str;
																	}, $question);

																}
															}
															?>
														</li>
													<?php   
													}
													?>
				                				<input type="hidden" name="blanks[]" value="##">
											</ul>
										</div>
										<?php 

										 	$reading = $reading+2;
									} 
								}?>
						</div>
					</div>
						
					<div class="alert alert-success" role="alert" style="display:none"></div>
					<div class="alert alert-danger" role="alert" style="display:none"></div>

					<ul class="list-inline list-buttons">
					    <li class="list-inline-item">
								<button class="btn btn-primary btnSubmits_reding submitBtn_{{$practise['id']}}" data-is_save="0">Save</button>
					    </li>
					    <li class="list-inline-item">
								<button class="btn btn-primary btnSubmits_reding submitBtn_{{$practise['id']}}" data-is_save="1">Submit</button>
					    </li>
					</ul>
				</form>
<?php 
}elseif($practise['typeofdependingpractice'] =="get_answers_put_into_questions_odd"){
		?>
			<form class="reading-no-blanks_form" id="reading-no-blanks_form-<?php echo $practise['id'];?>">
			    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
			    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
			    <input type="hidden" class="is_save" name="is_save" value="">
			    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
				<input type="hidden" class="is_roleplay"  name="is_roleplay" value="true" >
				<input type="hidden" class="is_roleplay_submit" name="is_roleplay_submit" value="1">

				<?php
					if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){ 
							$depend =explode("_",$practise['dependingpractiseid']);
						?>

						<input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
						<input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">

						<div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
							<p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
						</div>
				<?php } 

					$rolePlayQuestions = explode("##",$practise['question']);
					$rolePlayUsers = explode("@@",$rolePlayQuestions[0]);
					$userAnswer = array();
					
					?>

					<div class="component-two-click mb-4">
						<div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
							<?php
							if(!empty($rolePlayUsers)){
							$userAnsCount = 0;
							
							foreach($rolePlayUsers as $c=>$rolePlayUser){?>
								<a href="#!" id="s-button-<?php echo $c;?>" class="btn btn-dark s-button-{{$practise['id']}} selected_option selected_option_{{$c}} {{$practise['id']}}"  data-key="{{$c}}"><?php echo trim($rolePlayUser);?></a>
							<?php }}?>
						</div>
						<div class="two-click-content w-100">
							<?php
								$k = 0;
								$rolplayInc = 0;
								if(!empty($rolePlayUsers)){
									foreach($rolePlayUsers as $s=>$rolePlayUser){
										$exploded_question = explode(PHP_EOL, $rolePlayQuestions[$s+1]); 
										?>
										<div class="content-box multiple-choice s-button-box d-none selected_option_description selected_option_description_{{$s}}" id="s-button-<?php echo $s.''.$s;?>">
											<ul class="list-unstyled">
												<?php
													$flag = true;
													$newAnswers = !empty($practise['dependingpractise_answer'])?!empty($practise['dependingpractise_answer'][$rolplayInc][0])?explode(";",$practise['dependingpractise_answer'][$rolplayInc][0]):[]:[];
													$user_answer = !empty($practise['user_answer'])?!empty($practise['user_answer'][$rolplayInc][0])?explode(";",$practise['user_answer'][$rolplayInc][0]):[]:[];
													if(!empty($newAnswers)){
														$single = 0;
														$ddouble = 0;
														foreach($exploded_question as $question){

															if(empty(trim($question))){ continue;} ?>

															<li>
																<?php

																if(str_contains($question,'@@')) {
																 	
																 	if($flag){

																	 	echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$newAns, &$data, &$question,  &$single,  &$newAnswers) {

																	 		$ans = isset($newAnswers[$single])?($newAnswers[$single]!=" ")?$newAnswers[$single]:'___':'___';
																			// $str ='';
																			$str ='<span class="resizing-input">'.$ans.'<span style="display:none"></span></span>';
												                           	$single++;
																			return $str;

																		}, $question);
																		$flag = false;

																 	}else{

																 		echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$newAns, &$ddouble, &$question, &$k,  &$newAnswers, &$user_answer) {
																	 		$ans = isset($user_answer[$ddouble])?trim($user_answer[$ddouble]):'';


																	 		$value = strlen($ans);
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
																	 				<span contenteditable="true" class="enter_disable spandata fillblanks stringProper text-left"  style="min-width:'.$style.' !important;">'.$ans.'</span>
																	 				<input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="'.$ans.'">
																					
																				</span>';
																				$ddouble++;


												                           	$k++;
																			return $str;
																			
																		}, $question);
																		$flag = true;
																 	}
																
																}
																?>
															</li>
															<?php   
														} 
													} else {
														?>
															<?php $depend =explode("_",$practise['dependingpractiseid']); ?>
															<input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
															<input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
															<div id="dependant_pr_{{$practise['id']}}" style="border: 2px dashed gray; border-radius: 12px;">
																<p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
															</div>
															<script type="text/javascript">
																// setTimeout(function(){
																// 	$('.hidebuttons').fadeOut();
																// },1000);
															</script>
														<?php
													}
											?>
				                				<input type="hidden" name="blanks[]" value="##">
											</ul>
										</div>
										<?php 
										$rolplayInc = $rolplayInc+2;
									} 
								}?>
						</div>
					</div>
						
					<div class="alert alert-success" role="alert" style="display:none"></div>
					<div class="alert alert-danger" role="alert" style="display:none"></div>

					<ul class="list-inline list-buttons hidebuttons">
					    <li class="list-inline-item">
								<button class="btn btn-primary btnSubmits_reding submitBtn_{{$practise['id']}}" data-is_save="0">Save</button>
					    </li>
					    <li class="list-inline-item">
								<button class="btn btn-primary btnSubmits_reding submitBtn_{{$practise['id']}}" data-is_save="1">Submit</button>
					    </li>
					</ul>
				</form>
<?php
}elseif($practise['typeofdependingpractice'] =="get_answers_generate_questions_underline"){
		// dd($practise);
		?>
			<form class="reading-no-blanks_form" id="reading-no-blanks_form-<?php echo $practise['id'];?>">
			    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
			    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
			    <input type="hidden" class="is_save" name="is_save" value="">
			    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
				<input type="hidden" class="is_roleplay"  name="is_roleplay" value="true" >
				<input type="hidden" class="is_roleplay_submit" name="is_roleplay_submit" value="1">
				<input type="hidden" class="is_uniqueExercise" name="is_uniqueExercise" value="1">

				<?php
					if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
							$depend =explode("_",$practise['dependingpractiseid']);
						?>

						<input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
						<input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}" >

						<div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
							<p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
						</div>
				<?php }

					$rolePlayQuestions = explode("##",$practise['question']);
					$rolePlayUsers = explode("@@",$rolePlayQuestions[0]);
					$userAnswer = array();
					if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
						foreach($practise['user_answer'] as $userAns){
							if(is_array($userAns)){
								$userAns = $userAns[0];
								$userAns = explode(";",$userAns);
								foreach($userAns as $userAn){
					                if(!empty($userAn)){
					                  	$userAnswer[] = $userAn;
					                }
								}
							}
							else{
					            if(!empty(trim($userAns))){
					                $userAnswer[] = $userAns;
					            }

							}
						}
					}

					
					?>
					<div class="component-two-click mb-4">
						<div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
							<?php
							if(!empty($rolePlayUsers)){
								$userAnsCount = 0;
								
								foreach($rolePlayUsers as $c=>$rolePlayUser){?>
									<a href="#!" id="s-button-<?php echo $c;?>" class="btn btn-dark s-button-{{$practise['id']}} selected_option selected_option_{{$c}} {{$practise['id']}}"  data-key="{{$c}}"><?php echo trim($rolePlayUser);?></a>
								<?php }
							}?>
						</div>
						<div class="two-click-content w-100">
							<?php
								//	pr($userAnswer);
								$k = 0;
								if(!empty($rolePlayUsers)) {
									foreach($rolePlayUsers as $s=>$rolePlayUser) {
										$exploded_question = explode(PHP_EOL, $rolePlayQuestions[$s+1]); ?>
										<div class="content-box multiple-choice s-button-box d-none selected_option_description selected_option_description_{{$s}}" id="s-button-<?php echo $s.''.$s;?>">
											<ul class="list-unstyled">
												<?php
													
													foreach($exploded_question as $question){
														
														if(empty(trim($question))){ continue;} ?>

														<li>
															<?php
															if(str_contains($question,'@@')) {
															 	if(substr_count($question,"@@")>2){
																	echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$newAns, &$data, &$question, &$k) {
															 			$ans = isset($newAns[$k])?trim($newAns[$k]):'';

															 			$value = strlen($ans);
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
																 				<span contenteditable="true" class="enter_disable spandata fillblanks stringProper text-left" style="min-width:'.$style.' !important;">'.$ans.'</span>
																 				<input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="'.$ans.'">
																				
																			</span>';


											                           	$k++;
																		return $str;
																	}, $question);
																}else{
																 	echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$newAns, &$data, &$question, &$k) {
																 		$ans = isset($newAns[$k])?trim($newAns[$k]):'';

																		$value = strlen($ans);
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
																 				<span contenteditable="true" class="enter_disable spandata fillblanks stringProper text-left" style="min-width:'.$style.' !important;">'.$ans.'</span>
																 				<input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="'.$ans.'">
																				
																			</span>';

											                           	$k++;
																		return $str;
																	}, $question);
																}
															}
															?>
														</li>
													<?php   
													}
													?>
				                				
											</ul>
										</div>
										<?php 
									}

								}?>
						</div>
					</div>

					<?php
						if(isset($practise['is_roleplay']) && $practise['is_roleplay'] &&  isset($practise['dependingpractiseid']) && $practise['dependingpractiseid']!="" && isset($practise['depending_practise_details'])) {
						
							$rolePlayQuestions_depend 	= explode("##",$practise['depending_practise_details']['question']);
							$rolePlayUsers_depend 		= explode("@@",$rolePlayQuestions_depend[0]);
							$tempinc = 0;
							$formateInc = 0;

							$tempincdata = 0;
							foreach($rolePlayUsers_depend as $s=>$rolePlayUser){
								// dd($rolePlayQuestions_depend[$s+1]);
								$exploded_question_depend = explode("<br><br>", $rolePlayQuestions_depend[$s+1]); 
								$exploded_question_depend = array_filter($exploded_question_depend);
								$exploded_question_depend = array_merge($exploded_question_depend);
								?>
								<div class="content-box multiple-choice s-button-box d-none selected_option_description selected_option_description_{{$s}}" id="s-button-<?php echo $s.''.$s;?>">
									<ul class="appenddata_{{$tempincdata}}">
										<?php
											foreach($exploded_question_depend as $question){
												?><li class="list-item underline_text_list_item1 list-unstyled">{!!$question!!}</li><?php
											}
											?>
									</ul>
								</div>
								<br>
								<?php 
								$tempincdata++;
								}

							}
								 ?>	


					<div class="alert alert-success" role="alert" style="display:none"></div>
					<div class="alert alert-danger" role="alert" style="display:none"></div>

					<ul class="list-inline list-buttons">
					    <li class="list-inline-item">
								<button class="save_btn btn btn-primary btnSubmits_reding submitBtn_{{$practise['id']}}" data-is_save="0">Save</button>
					    </li>
					    <li class="list-inline-item">
								<button class="submit_btn btn btn-primary btnSubmits_reding submitBtn_{{$practise['id']}}" data-is_save="1">Submit</button>
					    </li>
					</ul>
			</form>

			<script type="text/javascript">
				
				setTimeout(function(){
					highlight();
				},500);

				function highlight() {

			    	var current_key = 0;
			        var wordNumber;
			       
			        var end=0;
					var temp =0;

					for(var e=0;e<2;e++) {

 						var k=0;
				        $('.appenddata_'+e).find('.underline_text_list_item1').each(function(key) {
							var paragraph		=	"";
							var str 			= 	$(this).text();
							var $this 			=	$(this);
							str.replace(/[ ]{2,}/gi," ");
							$this.attr('data-total_characters', str.length);
							$this.attr('data-total_words', str.split(' ').length);
							var words = $this.first().text().trim().split(' ');
							var newWord 	= $this.first().text().trim();
							newWord 		= newWord.replace("  ","");
							var words 		= newWord.split(' ');
							for(var i=0; i<words.length;i++){
								var word = $.trim(words[i].replace(/^\s+/,""));
								if(word !="") {
									wordNumber = k;
									if(i==0 && key==0) {
									    end=word.length;
									} else {
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
									var start = end-word.length
									var iName= "text_ans[0][0]["+wordNumber+"][i]";
									var fColorName =  "text_ans[0][0]["+wordNumber+"][fColor]"
									var foregroundColorSpanName = "text_ans[0][0]["+wordNumber+"][foregroundColorSpan]";
									var wordName="text_ans[0][0]["+wordNumber+"][word]";
									var startName = "text_ans[0][0]["+wordNumber+"][start]";
									var endName = "text_ans[0][0]["+wordNumber+"][end]";
									paragraph+="<span class='highlight-text' id="+wordNumber+" data-key="+key+" data-wordlength="+word.length+"><input type='hidden' class='i' disabled name="+iName+" value="+wordNumber+"><input type='hidden' class='fColor' disabled name="+fColorName+" value='-1145286'><input type='hidden' class='foregroundColorSpan' disabled name="+foregroundColorSpanName+" value='-1145286'> <input type='hidden' class='word' disabled name="+wordName+" value="+words[i]+" ><input type='hidden' disabled name="+startName+" class='start' value="+start+" ><input disabled type='hidden' name="+endName+" value="+parseInt(end)+" class='end'>"+word+"</span>"
									$this.html(paragraph);
								}
								k++;
							}
				    	});
			    	}
				}
			</script>
			<?php 

				$array = [];
				if(!empty($practise['dependingpractise_answer'])){
					if(isset($practise['user_answer'])) {

						$k=0;
						$finalArray = [];
						for ($i=0; $i <2 ; $i++) {
							$data  = $practise['dependingpractise_answer'][$k]!=""?json_decode($practise['dependingpractise_answer'][$k][0][0]):[];
							foreach ($data as $key => $value) {
								$finalArray[$i][$value->i] =$value->i ;
							}
							$k =$k+2;
						}

						if(!isset($finalArray[0])){
							$finalArray[0] = [];
						}
						if(!isset($finalArray[1])){
							$finalArray[1] = [];
						}
						ksort($finalArray);

						$s = 0;
						// dd($finalArray);
						foreach ($finalArray as $key => $value) {
							// echo "1";
								(ksort($value));
								$datas  = $practise['user_answer'][$s]!=""?explode(";",$practise['user_answer'][$s][0]):[];
								$datas = array_filter($datas);
								$datas = array_merge($datas);
								// echo count($value).'-------'.count($data);
								// echo $s;
								// if($s==1){

								// echo "<pre>";
								// print_r($datas);
								// print_r(count($value));
								// echo "<br>";
								// print_r(count($datas));
								// echo "</pre>";
								

							if(count($value)!=count($datas)){

								$k=0;
								$array = [];
								for ($i=0; $i <2 ; $i++) {
									$data  = $practise['dependingpractise_answer'][$k]!=""?json_decode($practise['dependingpractise_answer'][$k][0][0]):[];
									foreach ($data as $key => $value) {
										$array[$i][$value->i] =$value->word;
										ksort($array);
									}
									$k =$k+2;
								}
							}else{


								$m = 0;
								foreach ($value as $keys => $insideLoop) {
									$array[$key][$keys]= isset($datas[$m])?$datas[$m]:"";
									$m++;	
								}
									
							}
								$s=$s+2;
						}
						// dd($array);
					} else {


						$k=0;
						$array = [];
						for ($i=0; $i <2 ; $i++) {
							$data  = $practise['dependingpractise_answer'][$k]!=""?json_decode($practise['dependingpractise_answer'][$k][0][0]):[];
							foreach ($data as $key => $value) {
								$array[$i][$value->i] =$value->word;
								ksort($array);
							}
							$k =$k+2;
						}


					}

					$array = addslashes(json_encode($array)) ;
				}

			?>
			<script>
				setTimeout(function(){

					var ans = "<?php echo !empty($array)?$array:"{}"?>";
					ans = JSON.parse(ans);
					for(var e=0;e<2;e++) {
						$.each(ans[e], function (key,value) {

									var size = "3ch !important";
									if(value.length == 1 || value.length == 2 ){
										size = "1ch !important";
									}

								$('.appenddata_'+e).find('#'+key).html('<span class="resizing-input1">\
				 				<span contenteditable="true" class="enter_disable spandata fillblanks stringProper text-left"  style="min-width:'+size+'" >'+value+'</span>\
				 				<input type="hidden" class="form-control form-control-inline appendspan" name="blanks['+e+'][]" value="'+value+'"></span>');

						});
					}

				},2000);
			</script>
<?php
}