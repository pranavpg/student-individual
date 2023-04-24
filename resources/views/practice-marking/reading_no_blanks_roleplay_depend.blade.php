<?php 
if(isset($practise['options'])) {
		$ans = [];
		if(isset($practise['user_answer'])){
			foreach($practise['user_answer'] as $key=>$data) {
				$temparray = [];
				if($data !="##"){
					if($data == ""){
						// $temparray[] = "";

					}else{
						$temparray = explode(";",rtrim($data[0], ';'));
					}
				}
				foreach($temparray as $answrs){
					if($answrs!="##")
					array_push($ans,$answrs);	
				}
			}
			// 
		}else{
			if(isset($practise['options'])){

				foreach($practise['options'] as $data) {
					array_push($ans,$data[0]);	
				}
			}
		}
		$newAns = [];
		foreach ($ans as $key => $value) {
			if($value!="##") 
			array_push($newAns, $value);
		}
		// dd($newAns);
		// dd($newAns);
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
								<a href="#!" id="s-button-<?php echo $c;?>" class="btn btn-dark s-button-{{$practise['id']}} selected_option selected_option_{{$c}} {{$practise['id']}}"  data-key="{{$c}}" data="{{$practise['id']}}"><?php echo trim($rolePlayUser);?></a>
							<?php }}?>
						</div>
						<div class="two-click-content w-100">
							<?php
								$k = 0;
								if(!empty($rolePlayUsers)){
									$rolplayIncNormal = 0;
									foreach($rolePlayUsers as $s=>$rolePlayUser) {
										$exploded_question = explode(PHP_EOL, $rolePlayQuestions[$s+1]); ?>
										<div class="content-box multiple-choice s-button-box d-none selected_option_description selected_option_description_{{$s}}" id="s-button-<?php echo $s.''.$s;?>">
											<ul class="list-unstyled">
												<?php
													$newsinc = 0;
													foreach($exploded_question as $newKey =>$question) {

														$newAnswers = !empty($practise['user_answer'])?!empty($practise['user_answer'][$rolplayIncNormal][0])?explode(";",$practise['user_answer'][$rolplayIncNormal][0]):[]:[];

														if(empty(trim($question))) { continue;} ?>
														<li>
															<?php
																if(str_contains($question,'@@')) {
															 	echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$newAns, &$data, &$question, &$k, &$newAnswers, &$newKey, &$newsinc) {
															 			$nans = "";
															 			if(isset($newAnswers[$newsinc])){
															 				$nans = $newAnswers[$newsinc];
															 			}
															 			else{  
																			$nans = isset($newAns[$k])?$newAns[$k]:"";
															 			}

														 				$value = strlen($nans);
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
															 				<span contenteditable="true" class="enter_disable spandata fillblanks stringProper" style="min-width:'.$style.' !important;">'.$nans.'</span>
															 				<input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="'.$nans.'">
																			
																		</span>';
										                           	$k++;
										                           	$newsinc++; 
																	return $str;
																}, $question);
															}
															?>
														</li>
														<?php 

													}
													?>
				                				<input type="hidden" name="blanks[]" value="##">
											</ul>
										</div>
										<?php $rolplayIncNormal = $rolplayIncNormal+2; 
									}
								} ?>
						</div>
					</div>
					
				<div class="alert alert-success" role="alert" style="display:none"></div>
				<div class="alert alert-danger" role="alert" style="display:none"></div>

				<ul class="list-inline list-buttons">
				    <li class="list-inline-item">
							<button class="btn btn-secondary btnSubmits_reding submitBtn_{{$practise['id']}}" data-is_save="0">Save</button>
				    </li>
				    <li class="list-inline-item">
							<button class="btn btn-secondary btnSubmits_reding submitBtn_{{$practise['id']}}" data-is_save="1"  >Submit</button>
				    </li>
				</ul>
			</form>

<?php }else{


		$ans = [];
		if(isset($practise['user_answer'])){
			foreach($practise['user_answer'] as $key=>$data) {
				$temparray = [];
				if($data !="##"){
					if($data == ""){
						// $temparray[] = "";

					}else{
						$temparray = explode(";",rtrim($data[0], ';'));
					}
				}
				foreach($temparray as $answrs){
					if($answrs!="##")
					array_push($ans,$answrs);	
				}
			}
			// 
		}else{
			if(isset($practise['options'])){

				foreach($practise['options'] as $data) {
					array_push($ans,$data[0]);	
				}
			}
		}

		$newAns = [];
		foreach ($ans as $key => $value) {
			if($value!="##") 
			array_push($newAns, $value);
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
								<a href="#!" id="s-button-<?php echo $c;?>" class="btn btn-dark s-button-{{$practise['id']}} selected_option selected_option_{{$c}} {{$practise['id']}}"  data-key="{{$c}}" data="{{$practise['id']}}"><?php echo trim($rolePlayUser);?></a>
							<?php }}?>
						</div>
						<div class="two-click-content w-100">
							<?php
								$k = 0;
								if(!empty($rolePlayUsers)){
									$rolplayIncNormal = 0;
									$tempAnsInc = 0;
									foreach($rolePlayUsers as $s=>$rolePlayUser) {
										$exploded_question = explode(PHP_EOL, $rolePlayQuestions[$s+1]); ?>
										<div class="content-box multiple-choice s-button-box d-none selected_option_description selected_option_description_{{$s}}" id="s-button-<?php echo $s.''.$s;?>">
											<ul class="list-unstyled">
												<?php
													$newsinc = 0;
													foreach($exploded_question as $newKey =>$question) {

														// $newAnswers = !empty($practise['user_answer'])?!empty($practise['user_answer'][$rolplayIncNormal][0])?explode(";",$practise['user_answer'][$rolplayIncNormal][0]):[]:[];
														// dd($practise);
														if(!empty($practise['user_answer'])){
															if($practise['user_answer'][$tempAnsInc]!=""){
																$newAnswers = explode(";",$practise['user_answer'][$tempAnsInc][0]);
															}
														}

														if(empty(trim($question))) { continue;} ?>
														<li>
															<?php
																if(str_contains($question,'@@')) {
															 	echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$newAns, &$data, &$question, &$k, &$newAnswers, &$newKey, &$newsinc) {
															 			$nans = "";
															 			if(isset($newAnswers[$newsinc])){
															 				$nans = trim($newAnswers[$newsinc]);
															 			}
															 			// else{
																			// $nans = isset($newAns[$k])?$newAns[$k]:"";
															 			// }

														 				$value = strlen($nans);
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
															 				<span contenteditable="true" class="enter_disable spandata fillblanks stringProper" style="min-width:'.$style.' !important;">'.$nans.'</span>
															 				<input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="'.$nans.'">
																			
																		</span>';
										                           	$k++;
										                           	$newsinc++; 
																	return $str;
																}, $question);
															}
															?>
														</li>
														<?php 

													}
													$tempAnsInc = $tempAnsInc+2;
													?>
				                				<input type="hidden" name="blanks[]" value="##">
											</ul>
										</div>
										<?php $rolplayIncNormal = $rolplayIncNormal+2; 
									}
								} ?>
						</div>
					</div>
					
				<div class="alert alert-success" role="alert" style="display:none"></div>
				<div class="alert alert-danger" role="alert" style="display:none"></div>

				<!-- <ul class="list-inline list-buttons">
				    <li class="list-inline-item">
							<button class="btn btn-secondary btnSubmits_reding submitBtn_{{$practise['id']}}" data-is_save="0">Save</button>
				    </li>
				    <li class="list-inline-item">
							<button class="btn btn-secondary btnSubmits_reding submitBtn_{{$practise['id']}}" data-is_save="1"  >Submit</button>
				    </li>
				</ul> -->
			</form>
		<?php

}


?>