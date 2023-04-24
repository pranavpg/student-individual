<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
	$exploded_question  = array();
  	$user_ans = "";
  	$answerExists = false;
  	if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
		$answerExists = true;
		if(!empty($practise['is_roleplay']) && $practise['is_roleplay']==1 && $practise['type'] !='speaking_multiple'){
			$answers = $practise['user_answer'];
			$new_answer = array_values(array_filter($answers,
					function($item) {
					  return strpos($item, '##') === false;
					}));
			$practise['user_answer'] = $new_answer;
			
		}
	}
	$data[$practise['id']] = array();
	$data[$practise['id']]['isRolePlayPractice'] = (!empty($practise['is_roleplay']) &&  $practise['is_roleplay']==1)?1:0;
	$data[$practise['id']]['typeofdependingpractice'] = !empty($practise['typeofdependingpractice']) ? $practise['typeofdependingpractice'] : "";
	$data[$practise['id']]['setFullViewFromPreviousPractice'] = !empty($practise['depending_practise_details']['dependant_practise_id']) ? $practise['depending_practise_details']['dependant_practise_id']:"";
	$data[$practise['id']]['dependant_practise_topic_id'] = !empty($practise['depending_practise_details']['dependant_practise_topic_id']) ? $practise['depending_practise_details']['dependant_practise_topic_id']:"";
	$data[$practise['id']]['dependant_practise_task_id'] = !empty($practise['depending_practise_details']['dependant_practise_task_id']) ? $practise['depending_practise_details']['dependant_practise_task_id']:"";
	$data[$practise['id']]['dependant_practise_question_type'] = !empty($practise['depending_practise_details']['question_type']) ? $practise['depending_practise_details']['question_type']:"";
	$data[$practise['id']]['dependentpractice_ans'] = !empty($practise['dependingpractise_answer'])?1:0;
	$data[$practise['id']]['is_dependent'] = !empty($practise['is_dependent']) ? 1 : 0;
	
	if(isset($practise['typeofdependingpractice']) && $practise['typeofdependingpractice'] == "set_full_view_gen_que_double"){
		$data[$practise['id']]['setFullViewFromPreviousPractice'] = !empty($practise['depending_practise_details']['independant_practise']['practise_details']['practise_id']) ? $practise['depending_practise_details']['independant_practise']['practise_details']['practise_id']:"";

	}
	// echo "<pre>";
	// print_r($data);
	$style="";
	
	if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) ){
  		$depend =explode("_",$practise['dependingpractiseid']);
		  $style= "display:none"; 
		
?>
		<div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; display:none">
			<p style="margin: 15px;">In order to do this task you need to have completed
			<strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
		</div>
<?php
  	} else {
		if(!empty($practise['question'])){
			$exploded_question = explode(PHP_EOL,$practise['question']);
		}
	}
?>
<div class="previous_practice_answer_exists_{{$practise['id']}} dependancy_audio_parent" style="{{$style}}">
	@if($data[$practise['id']]['typeofdependingpractice']=='set_full_view_hide_show')
		<div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
			<a href="javascript:;" class="btn btn-dark selected_option_hide_show ">Show View</a>
		</div>
	@endif
	@if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer']))
	 @if($practise['id'] == "16666321706356c9ea91601" OR $practise['id'] == "16666322186356ca1a045be" OR $practise['id'] == "16278907736107a45519333" OR $practise['id'] == "1628061724610a401c98600" OR $practise['id'] == "1665676723634835b30802d" OR $practise['id'] == "166332821663245fd8d0681" OR $practise['id'] =="16284933756110d63fdb659" OR $practise['id'] == "162851498061112aa4b2fed")
      @foreach($practise['dependingpractise_answer'] as $key => $value)
      <div class="form-slider p-0 mb-4">
         <div class="component-control-box">
            <span class="textarea form-control form-control-textarea set_full_view stringProper" role="textbox" disabled="" contenteditable="false" placeholder="Write here..." style="pointer-events: none;">{{$value}}</span>
        </div>
      </div>
      @endforeach
     @endif
    @endif
	@if(!empty($practise['is_roleplay']) && $practise['is_roleplay']==1)
		@include('practice.speaking_multiple_listening_roleplay')
	@else
		<div class="showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}" id="previousSetfullview">
		 </div>
		 <br><br>
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
			@if($practise['type'] == "speaking_multiple_listening")
				@include('practice.common.audio_player')
			@endif
			<?php
				$answerExists = false;
				if(!empty($practise['question'])){
					if($practise['type']=='speaking_multiple'){
						$exploded_question  =  explode(' @@', $practise['question']);
					} elseif($practise['type']=='speaking_multiple_listening') {
						$exploded_question  =  explode(PHP_EOL, $practise['question']);
					}
					
				}	
				if(!empty($practise['typeofdependingpractice']) && $practise['typeofdependingpractice']=='get_answers_generate_quetions') {
					?>
					<script>
						$( document ).ready(function() {
							$('#previousSetfullview').css("display",'none');
						});
					</script>
					<?php
					if(isset($practise['depending_practise_details']))
					{
						if($practise['depending_practise_details']['question_type'] =='speaking_multiple' || $practise['depending_practise_details']['question_type'] =='writing_at_end' || $practise['depending_practise_details']['question_type'] == 'writing_at_end_up'){
							
							if( !empty( $practise['dependingpractise_answer'][0] ) && is_array($practise['dependingpractise_answer'][0])){
								$exploded_question  =  $practise['dependingpractise_answer'][0];
							} 
						}  
						else if( $practise['depending_practise_details']['question_type']=='single_tick' ){
							 
							if( !empty( $practise['dependingpractise_answer'][0] ) && is_array($practise['dependingpractise_answer'][0])){
								  
								$exploded_question = array();
								foreach($practise['dependingpractise_answer'][0] as $key => $value){
									if(!empty($value['checked']) && $value['checked']==1){
										array_push($exploded_question,$value['name']);
									}
								} 
							}  
						}
				   }
				}
				if(!empty($practise['typeofdependingpractice']) && $practise['typeofdependingpractice']=='get_questions_and_answers') {
					if($practise['type']=='speaking_multiple'){
						if(isset($practise['depending_practise_details']['question_type']) && !empty($practise['depending_practise_details']['question_type']) && $practise['depending_practise_details']['question_type'] == "reading_total_blanks_edit" && isset($practise['dependingpractise_answer'])&& !empty($practise['dependingpractise_answer'])){
							$questions  =  explode(PHP_EOL, $practise['depending_practise_details']['question']);
							$userAnswer = explode(';',$practise['dependingpractise_answer'][0]);
							$c = 0;
							foreach($questions as $key => $value)
                            {
									if(trim($userAnswer[$key]) != ''){

									
                                            if(str_contains($value,'@@')){
                                                $value= str_replace("<br>"," ",$value);
                                        //  $value = str_replace('<br>', '', $value);
                                         $exploded_question[] = preg_replace_callback('/@@/',
                                                    function ($m) use (&$key, &$c, &$userAnswer) {
                                                        $ans= !empty($userAnswer[$key])?trim($userAnswer[$key]):"";
                                                        $str = $ans;
                                                        $c++;
                                                        return $str;
                                                    }, $value);
											}
										}
    
							} 
						}elseif( !empty( $practise['depending_practise_details']['question'] ) ){
							$exploded_question  =  explode(PHP_EOL, $practise['depending_practise_details']['question']);
							 
						} 
					}  
				}
				if(isset($practise['typeofdependingpractice']) && !empty($practise['typeofdependingpractice']) && $practise['typeofdependingpractice']=='set_full_view_gen_que_double'){
					if($practise['type']=='speaking_multiple'){
						if( isset($practise['dependingpractise_answer']['0']) && !empty($practise['dependingpractise_answer']['0']) ){
							if(is_array($practise['dependingpractise_answer']['0'])){
								$exploded_question  = array_filter($practise['dependingpractise_answer']['0']);
							}else{

								$exploded_question[]  = $practise['dependingpractise_answer']['0'];
							}
							
						} 
					}  
				}
				if(isset($practise['typeofdependingpractice']) && !empty($practise['typeofdependingpractice']) && $practise['typeofdependingpractice']=='get_questions_and_answers' && $practise['depending_practise_details']['question_type'] == 'multi_choice_question_multiple'){
					if($practise['type']=='speaking_multiple'){
						
						if(isset($practise['dependingpractise_answer']['0']) && !empty($practise['dependingpractise_answer']['0']) ){
							
							if(is_array($practise['dependingpractise_answer']['0'])){
								$dependQuestion= explode(PHP_EOL,$practise['depending_practise_details']['question']);
								$exploded_question=[];
								foreach($practise['dependingpractise_answer']['0'] as $key => $value ){
									
									if(!empty($value['ans'])){
										$exploded_question[]= $dependQuestion[$key].' : '.$value['ans'];
									}

								}
							
							}
							
						} 
					}
				}
				if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
					$answerExists = true;
				}
			 
			?>
			<?php 
			// echo '<pre>'; print_r($exploded_question); echo '</pre>';
			?>
				
			@if(!empty($exploded_question))
				@foreach($exploded_question as $key => $value)
					@if(!empty($value))
						<div class="multiple-choice">
							<?php 
								// $temp = str_replace("<b>", "", $value);
								$temp = str_replace("<div>", "", $value);
								// $temp = str_replace("</b>", "", $temp);
								$temp = str_replace("</div>", "", $temp);
								$temp = str_replace("!#", "", $temp);
							 
							?>
							<p class="mb-0"><?php echo $temp; ?></p> 
							@if(!str_contains($value,'!#'))
								@include('practice.common.audio_record_div',['q'=> $key])
							@endif
						</div>
						<input type="hidden" name="text_ans[{{$key}}][path]" class="audio_path{{$key}}">
					@endif
				@endforeach
			@else
				
				@if(empty($practise['dependingpractiseid']))
					<div class="multiple-choice">
						<?php
						 if($practise['id']=="15567281815cc9c975593b8"){
						    $key = 0;    
						  }
						 elseif($practise['id']=="15517790915c7e45136ddc8"){
						    $key = 0;    
						  }
						?>
						@include('practice.common.audio_record_div')
					</div>
					<input type="hidden" name="text_ans[0][path]" class="audio_path0">
				@else 
					@if(empty($data[$practise['id']]['setFullViewFromPreviousPractice']))
						@if(!empty($practise['dependingpractise_answer'][0]) && is_array($practise['dependingpractise_answer'][0]))
							
							@foreach($practise['dependingpractise_answer'][0] as $key => $value)
								@if(!empty($value)) 
									<div class="multiple-choice">
										<p class="mb-0">{!! $value !!}</p>
										@include('practice.common.audio_record_div',['q'=> $value])
									</div>
									<input type="hidden" name="text_ans[{{$key}}][path]" class="audio_path{{$key}}">
								@endif
							@endforeach
						@elseif(!empty($practise['dependingpractise_answer'][0]) )
							<div class="multiple-choice">
								@if(empty( $data[$practise['id']]['setFullViewFromPreviousPractice'] ))
									<p class="mb-0">{!!$practise['dependingpractise_answer'][0]!!}</p>
								@endif
								@include('practice.common.audio_record_div',['q'=> $practise['dependingpractise_answer'][0]])
							</div>
							<input type="hidden" name="text_ans[0][path]" class="audio_path0">
						@else
							@if(!empty($practise['dependingpractise_answer']))
						
								<div class="multiple-choice">
									@if(empty($data[$practise['id']]['setFullViewFromPreviousPractice'] ))
										<p class="mb-0">{!!isset($practise['dependingpractise_answer'])?$practise['dependingpractise_answer']:""!!}</p>
									@endif
									@include('practice.common.audio_record_div',['q'=> $practise['dependingpractise_answer']])
								</div>
								<input type="hidden" name="text_ans[0][path]" class="audio_path0">
						 
								 	
							@endif
						@endif
					@else
						<div class="multiple-choice">
						<?php //dd($practise); ?>

							@include('practice.common.audio_record_div',['key'=>0])
						</div>
						<input type="hidden" name="text_ans[0][path]" class="audio_path0">
					@endif
				@endif
			@endif
		
		</form>
			
			
		@endif
</div>


<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
 
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
	if(data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view"){
	 
	  if(data["{{$practise['id']}}"]["typeofdependingpractice"] == "set_full_view_gen_que_double"){
			data["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{isset($practise['depending_practise_details']['independant_practise']['practise_details']['task_id'])?$practise['depending_practise_details']['independant_practise']['practise_details']['task_id']:''}}";
			data["{{$practise['id']}}"]["dependant_practise_id"] = "{{ isset($practise['depending_practise_details']['independant_practise']['practise_details']['practise_id']) ? $practise['depending_practise_details']['independant_practise']['practise_details']['practise_id'] :''}}";
	  }else{
		data["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{$data[$practise['id']]['dependant_practise_task_id'] }}";
		data["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
	  }
		$(function () {
			$('.cover-spin').fadeIn();
		});
		
		if(data["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
			// IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
			
			if(data["{{$practise['id']}}"]["dependant_practise_id"] !=""){

				setTimeout(function(){ 
					
					 data["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).html();
					//add for containtable none---------
					$(document).find(".table-container").find('span').attr("contenteditable","false");		
					//----------------------------------		
					$(document).find(".table-row").css('pointer-events','none'); 
					$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(data["{{$practise['id']}}"]["prevHTML"]);
					$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
					$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
					$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert').remove();
					$(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('.match-answer').hide();//add for level 0
					$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.teacher-feedback-form').remove();
					$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.spandata').attr("contenteditable","false")
					if( data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view"){
						if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "speaking_writing_up" && data["{{$practise['id']}}"]["typeofdependingpractice"] == "set_full_view" ){	
							$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
						}
					if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_total_blanks_edit") {
							$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.form-slider').remove();
						}
					}
					if( data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
						if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up" || data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_up_speaking_up") {
							if($practise['id'] == "15567282975cc9c9e9b6cab"){
								$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').find('fieldset').remove();
							}else{
								$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
							}
						}
					}
					$('.cover-spin').fadeOut();
				}, 3000,data )
			}
		} else {				
			// IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
			// DO NOT REMOVE BELOW   CODE
		var baseUrl = "{{url('/')}}";
		var pid2= "{{$practise['id']}}";
		// alert(pid2);
		data["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
        data["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
       		// new working url
	       	if(pid2 == "15567095475cc980aba8451"){
	       	 	data["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data["{{$practise['id']}}"]["dependant_practise_id"]+'&user_id={{ isset($studentId)?$studentId:'' }}';
	       	}else if(pid2 == "15567356465cc9e69ea94d3"){
	       		data["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/practice-detail/'+data["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data["{{$practise['id']}}"]["dependant_practise_task_id"]+'/{{ isset($studentId)?$studentId:'' }}';
	       	}else if(pid2 == "15505790685c6bf57ccb012"){
	       		data["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data["{{$practise['id']}}"]["dependant_practise_task_id"]+'/{{ isset($studentId)?$studentId:'' }}';
	       	}else{
	       		data["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data["{{$practise['id']}}"]["dependant_practise_id"]+'&user_id={{ isset($studentId)?$studentId:'' }}';

	       		// data["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/practice-detail/'+data["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data["{{$practise['id']}}"]["dependant_practise_id"]+'&user_id={{ isset($studentId)?$studentId:'' }}';
	       	}
	       	// alert(pid2)
	       	 // console.log(data["{{$practise['id']}}"]["dependentURL"]);
			setTimeout(function(){ 
				$.get(data["{{$practise['id']}}"]["dependentURL"],  //
				function (dataHTML, textStatus, jqXHR) {  // success callback
					if(pid2=="15567095475cc980aba8451"){
						data["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
					}
					else if(pid2 == "15505790685c6bf57ccb012"){
						data["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).html();
					}
					else if(pid2 == "15553363615cb48ca927c95" || pid2 == "15554838255cb6ccb1912ee"){
						data["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('.save_writing_at_end_up_form_'+data["{{$practise['id']}}"]["dependant_practise_id"]).html();
					}
					else{
						data["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();	
					}

					 console.log(data["{{$practise['id']}}"]["prevHTML"]);

					$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(data["{{$practise['id']}}"]["prevHTML"]);
					$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
					$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, .alert, input:hidden').remove();
					
							$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.spandata').attr("contenteditable",false);
					if(data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
						 
						if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
							$(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
						}
					}
					$('.cover-spin').fadeOut();

				});
			 }, 5000,data )
		}
	}  
</script>
@endif

@if($data[$practise['id']]['typeofdependingpractice']=='set_full_view_hide_show')
<script>
$("#previousSetfullview").hide();
	$(".selected_option_hide_show").click(function () {
		// alert();
		var text = $(this).text();
		$(this).text(
				text == "Hide View" ? "Show View" : "Hide View"
				
			);
			
		$("#previousSetfullview").toggle();
	});

 
</script>
@endif
<script>
$( document ).ready(function() {
	if('{{$practise["id"]}}'=="15566127405cc80684220a2"){
		$('.record_{{$practise["id"]}}').find('#delete-recording-0').hide();	
	}else{
		$('.record_{{$practise["id"]}}').find('#delete-recording-0').show();	
	}
});
</script>
<style type="text/css">
	.myclass{
		position: relative;
	    display: flex;
	    align-items: center;
	    margin-bottom: 2rem;
	}
</style>
<!--- Static Condition for beginner ges topic 09 task 8 AB-->
@if(isset($_GET['n']))
 @if($_GET['n'] == "1629890534612627e6028cd")
    <style type="text/css">
     #abc-1629890534612627e6028cd
     {
         display: block  !important;
     }
     #abc-1629890480612627b01e67d
     {
         display: none;
     }
    </style>
 @endif
@endif
<!--- Static Condition for beginner ges topic 21 task 8 AB-->
@if($practise['id'] == "16656578776347ec15c9b8b")
<style type="text/css">
	.record_16656578776347ec15c9b8b .plyr__controls
	{
		display: none !important; 
	}
</style>
@endif
<!--- Static Condition for beginner ges topic 09 task 8 AB-->
@if(isset($_GET['n']))
 @if($_GET['n'] == "16666234996356a80b34528")
    <style type="text/css">
     #abc-16666234266356a7c2ed325
     {
         display: none;
     }
     #abc-16666234696356a7ed13f21
     {
     	display: none;
     }
    </style>
 @endif
@endif
@if(isset($_GET['n']))
 @if($_GET['n'] == "16666235386356a8327e126")
    <style type="text/css">
     #abc-16666234266356a7c2ed325
     {
         display: none;
     }
     #abc-16666234696356a7ed13f21
     {
     	display: none;
     }
     #abc-16666234996356a80b34528
     {
     	display: none;
     }
    </style>
 @endif
@endif
<!------------------------------------------------------------->