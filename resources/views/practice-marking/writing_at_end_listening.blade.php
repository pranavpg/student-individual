<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
	$data[$practise['id']] = array();
	$data[$practise['id']]['isRolePlayPractice'] = (!empty($practise['is_roleplay']) &&  $practise['is_roleplay']==1)?1:0;
	$data[$practise['id']]['typeofdependingpractice'] = !empty($practise['typeofdependingpractice']) ? $practise['typeofdependingpractice'] : "";
	$data[$practise['id']]['setFullViewFromPreviousPractice'] = !empty($practise['depending_practise_details']['dependant_practise_id']) ? $practise['depending_practise_details']['dependant_practise_id']:"";
	$data[$practise['id']]['dependant_practise_topic_id'] = !empty($practise['depending_practise_details']['dependant_practise_topic_id']) ? $practise['depending_practise_details']['dependant_practise_topic_id']:"";
	$data[$practise['id']]['dependant_practise_task_id'] = !empty($practise['depending_practise_details']['dependant_practise_task_id']) ? $practise['depending_practise_details']['dependant_practise_task_id']:"";
	$data[$practise['id']]['dependant_practise_question_type'] = !empty($practise['depending_practise_details']['question_type']) ? $practise['depending_practise_details']['question_type']:"";
	$data[$practise['id']]['dependentpractice_ans'] = !empty($practise['dependingpractise_answer'])?1:0;
	$data[$practise['id']]['is_dependent'] = !empty($practise['is_dependent']) ? 1 : 0;
  $user_ans = "";
  $answerExists = false;
  $user_answer = [];
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
    $user_answer = $practise['user_answer'][0]; 
  } else {
    if($data[$practise['id']]['typeofdependingpractice']=='get_answers_put_into_answers'){
      $answerExists = true;
      $user_answer = !empty($practise['dependingpractise_answer'])?$practise['dependingpractise_answer'][0]:[];
    }
  }
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
  	}
    $temparray = [];
    if(!empty($practise['dependingpractise_answer'])){
        foreach ($practise['dependingpractise_answer'] as $key => $value) {
            array_push($temparray, $value);  
        }
    }
    $exploded_question = $temparray;
		$exploded_question = !empty($practise['question'])?explode(PHP_EOL,$practise['question']):"";
?>

<div class="previous_practice_answer_exists_{{$practise['id']}}" style="{{$style}}">
  <form class="form_{{$practise['id']}}">
    @if($practise['type']=='writing_at_end_listening' && !empty( $practise['audio_file'] ))
      @include('practice.common.audio_player')
    @endif
    <div class="showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}"></div>
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
    @if(!empty($practise['options']))
      <div class="suggestion-list d-flex flex-wrap w-50 mr-auto ml-auto mb-4 justify-content-center">
          @foreach($practise['options'] as $key => $value)
              @if($value[$key] !== '')
                  <div class="d-inline-flex flex-grow-1 suggestion_box justify-content-center">
                      {{ $value[0]}}
                  </div>
              @endif
          @endforeach
      </div>
    @endif
    <div class="multiple-choice">
        <?php
        if(isset($practise['dependingpractiseid']) ) {
            if(!empty($practise['dependingpractise_answer'])) {
                if($practise['typeofdependingpractice'] =="get_answers_put_into_quetions_numbers" ) {
                      $user_answer_old = !empty($practise['dependingpractise_answer'])?$practise['dependingpractise_answer'][0]:[];
                      $answ = !empty($practise['dependingpractise_answer'])?$practise['dependingpractise_answer'][0]:[];
                      $tempk = 0;
                      if(!empty($exploded_question)) {
                          foreach( $exploded_question as $key => $value ){
                            if($user_answer_old[$key] == "") continue;
                              if(str_contains($value, '@@')) {
                                  ?>
                                    <div class="choice-box1">
                                        <p class="mb-0 main-question">{{$key+1}}. {!! !empty($answ)?$answ[$key]:""  !!} </p>
                                        <div class="form-group">
                                            <span class="textarea form-control form-control-textarea main-answer enter_disable" role="textbox"  enabled contenteditable placeholder="Write here...">
                                                <?php
                                                if ($answerExists)
                                                {
                                                    echo  !empty($user_answer[$tempk])?str_replace(" ","&nbsp;",nl2br($user_answer[$tempk])):"";
                                                }
                                                ?>
                                            </span>
                                            <div style="display:none">
                                                <textarea name="user_answer[0][{{$tempk}}]" class="main-answer-input">
                                                  <?php
                                                  if ($answerExists) {
                                                    echo  !empty($user_answer[$tempk])?str_replace(" ","&nbsp;",nl2br($user_answer[$tempk])):"";
                                                  }
                                                  ?>
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $tempk++;
                              }else{
                                  ?>
                                  <div class="first-question">
                                      <p class="mb-0  main-answer"><strong>{{ strip_tags(nl2br($answ[$key])) }} </strong></p>
                                      <input type="hidden" name="user_answer[0][{{$key}}]">
                                  </div>
                                  <?php
                              }
                          }
                      }else{
                          ?>  
                          <script type="text/javascript">
                              $("#dependant_pr_{{$practise['id']}}").fadeIn();
                          </script>
                          <?php
                      } 
                }elseif($practise['typeofdependingpractice'] =="get_answers_put_into_answers" ) {
                    if(isset($practise['user_answer'])){
                        $user_answer = $practise['user_answer'][0];
                    }elseif(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer'])){

                        $user_answer = $practise['dependingpractise_answer'][0];
                    }
                    $answ = !empty($practise['dependingpractise_answer'])?$practise['dependingpractise_answer'][0]:[];

                    if( !empty($exploded_question) ){
                        foreach( $exploded_question as $key => $value ){
                          if (str_contains($value, '@@')){
                            ?>
                              <div class="choice-box1">
                                    <p class="mb-0 main-question"> {!! str_replace("@@","",nl2br($value))  !!} </p>
                                    <div class="form-group">
                                        <span class="textarea form-control form-control-textarea main-answer enter_disable" role="textbox" enabled contenteditable placeholder="Write here...">
                                          <?php
                                            if ($answerExists) {
                                                echo  !empty($user_answer[$key])?str_replace(" ","&nbsp;",nl2br($user_answer[$key])):"";
                                            }
                                          ?>
                                        </span>
                                        <div style="display:none">
                                            <textarea name="user_answer[0][{{$key}}]" class="main-answer-input">
                                                <?php
                                                if ($answerExists) {
                                                    echo  !empty($user_answer[$key])?str_replace(" ","&nbsp;",nl2br($user_answer[$key])):"";
                                                }
                                                ?>
                                            </textarea>
                                        </div>
                                    </div>
                              </div>
                              <?php
                          }else{
                                ?>
                              <div class="first-question">
                              <p class="mb-0  main-answer"><strong>{{ strip_tags(nl2br($answ[$key])) }} </strong></p>
                              <input type="hidden" name="user_answer[0][{{$key}}]">
                              </div>
                              <?php
                          }
                        }
                    }else{
                        ?>  
                        <script type="text/javascript">
                            $("#dependant_pr_{{$practise['id']}}").fadeIn();
                        </script>
                        <?php 
                    }
                }elseif($practise['typeofdependingpractice'] =="get_questions_and_answers_parentextra_withdep" ) {
                    $answ = !empty($practise['dependingpractise_answer'])?explode(";",$practise['dependingpractise_answer'][0]):[];
                    $temp = [];
                       foreach ($answ as $key => $value) {
                        if($value !== ' '){
                            array_push($temp,$value);
                        }else{
                            array_push($temp,"");

                        }
                       }

                    $question1 = isset($practise['depending_practise_details']['question'])?$practise['depending_practise_details']['question']:[];
                    $question2 = isset($practise['depending_practise_details']['question_2'])?$practise['depending_practise_details']['question_2']:[];

                   
                    // dd($question1);
                    if(!empty($answ)) {
                        $p=0;
                        foreach( $temp as $key => $value ){

                            if($value!="") {

                                
                                        ?>
                                      <div class="first-question">
                                      <p class="mb-0  main-answer"><strong>
                                        <?php 
                                            if($key == 0){
                                                $data1 = explode("#@",$question1[$key]);
                                                echo $data1[1];
                                            }else{

                                                echo $question1[$key];
                                            }
                                        ?>
                                        : {{$question2[$value]}}</strong></p>
                                      <input type="hidden" name="user_answer[0][{{$p}}]">

                                      <div class="form-group">
                                              <span class="textarea form-control form-control-textarea main-answer enter_disable" role="textbox" contenteditable placeholder="Write here...">
                                                  <?php
                                                  if ($answerExists)
                                                  {
                                                      echo  !empty($user_answer[$p])?str_replace(" ","&nbsp;",nl2br($user_answer[$p])):"";
                                                  }
                                                  ?>
                                              </span>
                                              <div style="display:none">

                                                  <textarea name="user_answer[0][{{$p}}]" class="main-answer-input">
                                                  <?php
                                                  if ($answerExists)
                                                  {
                                                  echo  !empty($user_answer[$p])?str_replace(" ","&nbsp;",nl2br($user_answer[$p])):"";

                                                  }
                                                  ?>
                                                  </textarea>
                                              </div>
                                          </div>

                                      </div>
                                      <br>
                                      <?php
                              
                                $p++;
                            }
                        }

                    }else{
                        ?>  
                        <script type="text/javascript">
                            $("#dependant_pr_{{$practise['id']}}").fadeIn();
                        </script>
                        <?php 
                    }
                }elseif($practise['typeofdependingpractice'] =="get_single_audio" ) {
                    if(!empty($practise['dependingpractise_answer'])){
                        $practise['audio_file']=$practise['dependingpractise_answer'][0];
                        ?>
                            @include('practice.common.audio_player')
                        <?php
                    }
                     if( !empty($exploded_question) ){
                        foreach( $exploded_question as $key => $value ){
                          if (str_contains($value, '@@')){
                            ?>
                              <div class="choice-box1">
                                  <p class="mb-0 main-question">
                                      {!! str_replace("@@","",$value)!!}
                                  </p>
                                  <div class="form-group">
                                      <span class="textarea form-control form-control-textarea main-answer enter_disable" role="textbox" contenteditable placeholder="Write here...">
                                          <?php
                                          if ($answerExists) {
                                              echo  !empty($user_answer[$key])?str_replace(" ","&nbsp;",nl2br($user_answer[$key])):"";
                                          }
                                          ?>
                                      </span>
                                      <div style="display:none">
                                          <textarea name="user_answer[0][{{$key}}]" class="main-answer-input">
                                            <?php
                                              if ($answerExists) {
                                                  echo  !empty($user_answer[$key])?str_replace(" ","&nbsp;",nl2br($user_answer[$key])):"";
                                              }
                                            ?>
                                          </textarea>
                                      </div>
                                  </div>
                              </div>
                              <?php
                          }else{
                                ?>
                              <div class="first-question">
                              <p class="mb-0  main-answer"><strong>{!! str_replace("0#","",$value)!!} </strong></p>
                              <input type="hidden" name="user_answer[0][{{$key}}]">
                              </div>
                              <br>
                              <?php
                          }
                        }
                    }else{
                        ?>  
                        <script type="text/javascript">
                            $("#dependant_pr_{{$practise['id']}}").fadeIn();
                        </script>
                        <?php 
                    }
                }elseif($practise['typeofdependingpractice'] =="get_answers_put_into_questions_odd" ) {
                        $answ = !empty($practise['dependingpractise_answer'])?$practise['dependingpractise_answer'][0]:[];
                        $questionss =  [];
                        foreach($answ as $index=>$data_new) {
                            if($data_new['true_false']===1 || $data_new['true_false']==="1" ){
                                array_push($questionss,$data_new['question']);
                            }
                        }   
                        if( !empty($questionss) ){
                            foreach( $questionss as $key => $value ){
                              if (str_contains($value, '@@')){
                                ?>
                                  <div class="choice-box1">
                                      <p class="mb-0 main-question">{!!str_replace("@@","&nbsp;",nl2br($value))!!}</p>
                                      <div class="form-group">
                                          <span class="textarea form-control form-control-textarea main-answer enter_disable" role="textbox" contenteditable placeholder="Write here...">
                                              <?php
                                              if ($answerExists) {
                                                  echo  !empty($user_answer[$key])?str_replace("@@","&nbsp;",nl2br($user_answer[$key])):"";
                                              }
                                              ?>
                                          </span>
                                          <div style="display:none">
                                              <textarea name="user_answer[0][{{$key}}]" class="main-answer-input">
                                              <?php
                                              if ($answerExists) {
                                                echo  !empty($user_answer[$key])?str_replace("@@","&nbsp;",nl2br($user_answer[$key])):"";
                                              }
                                              ?>
                                              </textarea>
                                          </div>
                                      </div>
                                  </div>
                                  <?php
                              }else{
                                    ?>
                                  <div class="first-question">
                                  <p class="mb-0  main-answer"><strong>{{ strip_tags(nl2br($answ[$key])) }} </strong></p>
                                  <input type="hidden" name="user_answer[0][{{$key}}]">
                                  </div>
                                  <?php
                              }
                            }
                        } else {
                            ?>  
                            <script type="text/javascript">
                                $("#dependant_pr_{{$practise['id']}}").fadeIn();
                            </script>
                            <?php 
                        }
                }elseif($practise['typeofdependingpractice'] =="set_full_view_remove_zero" ) {
                            $answ = isset($practise['depending_practise_details']['question'])?explode(" ", $practise['depending_practise_details']['question']):[];
                            if( !empty($exploded_question) ){
                                foreach( $exploded_question as $key => $value ){
                                  if (str_contains($value, '@@')){
                                    ?>
                                      <div class="choice-box1">
                                          <p class="mb-0 main-question"> {!! !empty($answ)?$answ[$key]:""  !!} </p>
                                          <div class="form-group">
                                              <span class="textarea form-control form-control-textarea main-answer enter_disable" role="textbox" contenteditable placeholder="Write here...">
                                                  <?php
                                                  if ($answerExists) {
                                                      echo  !empty($user_answer[$key])?str_replace(" ","&nbsp;",nl2br($user_answer[$key])):"";
                                                  }
                                                  ?>
                                              </span>
                                              <div style="display:none">
                                                  <textarea name="user_answer[0][{{$key}}]" class="main-answer-input">
                                                  <?php
                                                  if ($answerExists) {
                                                    echo  !empty($user_answer[$key])?str_replace(" ","&nbsp;",nl2br($user_answer[$key])):"";
                                                  }
                                                  ?>
                                                  </textarea>
                                              </div>
                                          </div>
                                      </div>
                                      <?php
                                  }else{
                                        ?>
                                      <div class="first-question">
                                      <p class="mb-0  main-answer"><strong>{{ strip_tags(nl2br($answ[$key])) }} </strong></p>
                                      <input type="hidden" name="user_answer[0][{{$key}}]">
                                      </div>
                                      <?php
                                  }
                                }
                            } else {
                                ?>  
                                <script type="text/javascript">
                                    $("#dependant_pr_{{$practise['id']}}").fadeIn();
                                </script>
                                <?php 
                            }
                }
            }
        }else{
                $questionstemp = explode(PHP_EOL,$practise['question']);
                 $tempArray = array();
                  foreach($questionstemp as $new => $datas){
                      if($datas!="\r" && $datas!="" && $datas!=" "){
                          array_push($tempArray,$datas);
                      }
                  }
                  $questionstemp = $tempArray;
                  if( !empty($questionstemp) ){
                    $tempinc = 0;
                    foreach( $questionstemp as $key => $value ){
                        if (str_contains($value, '@@')) {
                            ?>
                              <div class="choice-box1">
                                    <p class="mb-0 main-question">{!! nl2br(str_replace('@@', '', trim($value))) !!}</p>
                                    <div class="form-group">
                                        <span class="textarea form-control form-control-textarea main-answer enter_disable" role="textbox" contenteditable placeholder="Write here...">
                                            <?php
                                            if ($answerExists) {
                                                echo  !empty($user_answer[$key])?str_replace(" ","&nbsp;",nl2br($user_answer[$key])):"";
                                            }
                                            ?>
                                        </span>
                                        <div style="display:none">
                                            <textarea name="user_answer[0][{{$key}}]" class="main-answer-input">
                                                <?php
                                                if ($answerExists) {
                                                    echo  !empty($user_answer[$key])?str_replace(" ","&nbsp;",nl2br($user_answer[$key])):"";
                                                }
                                                ?>
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $tempinc++;
                        }else{
                            ?>
                                <div class="first-question">
                                    <p class="mb-0  main-answer"><strong>{{ strip_tags(nl2br($value)) }} </strong></p>
                                    <input type="hidden" name="user_answer[0][{{$key}}]">
                                </div>
                            <?php
                        }
                    }
                }
        }
        ?>
    </div>
    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
  </form>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
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
  var pid = "{{$practise['id']}}";
	if(data["{{$practise['id']}}"]["is_dependent"]==1){
		
		if(data["{{$practise['id']}}"]["dependentpractice_ans"]==0 ){
			$(".previous_practice_answer_exists_{{$practise['id']}}").hide();
			$("#dependant_pr_{{$practise['id']}}").show();
		} else {
			$(".previous_practice_answer_exists_{{$practise['id']}}").show();
      if(pid == '15569641265ccd631ee50f2') {
         $(".showPreviousPractice_15569639935ccd6299819c4").hide();
      }
			$("#dependant_pr_{{$practise['id']}}").hide();
		}
	}

</script>
@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==0 && $practise['typeofdependingpractice']!='get_answers_generate_quetions' )
<script>
	if(data["{{$practise['id']}}"]["dependentpractice_ans"]==1 ){
    data["{{$practise['id']}}"]["typeofdependingpractice"] = "{{ $data[$practise['id']]['typeofdependingpractice'] }}";
    data["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
    if(data["{{$practise['id']}}"]["typeofdependingpractice"] == "set_full_view_remove_top_zero" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="get_answers_put_into_answers"){
      data["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
      data["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";

      if(data["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
        if(data["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
            data["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();				 
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(data["{{$practise['id']}}"]["prevHTML"]);
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
            setTimeout(function(){ 
              $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('span.textarea').removeAttr('contenteditable');
            }, 1000 )
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert').remove();
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find( 'input[type="hidden"]').remove();
            if( data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_top_zero"){
              if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_blanks") {
                setTimeout(function(){
                  $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.match-answer').remove();
                },1000)
              } 
            }
            if( data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
              if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_up_speaking_up") {
                setTimeout(function(){
                  $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
                },1000)
              } 
            }
            $('.cover-spin').fadeOut();
        }
      } else {
        var baseUrl = "{{url('/')}}";
        data["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
        data["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data["{{$practise['id']}}"]["dependant_practise_id"]+'&user_id={{ isset($studentId)?$studentId:'' }}';
        $.get(data["{{$practise['id']}}"]["dependentURL"],  //
        function (dataHTML, textStatus, jqXHR) {  // success callback
          if(  data["{{$practise['id']}}"]["dependant_practise_id"]!==undefined){
          data["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(data["{{$practise['id']}}"]["prevHTML"]);
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, .alert').remove();
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find( 'input[type="hidden"]').remove();
            
            if(data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
              if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
                $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
              }
            }
            $('.cover-spin').fadeOut();
          }
        });
      }
    } else {
    
    }
  }
</script>
@endif
@if($data[$practise['id']]['typeofdependingpractice']=='set_full_view_hide_show')
<script>
$(".showPreviousPractice_{{$practise['id']}}").hide();
$(".selected_option_hide_show").click(function () {
      var text = $(this).text();
    $(this).text(
        	text == "Hide View" ? "Show View" : "Hide View"
		);
	$(".showPreviousPractice_{{$practise['id']}}").toggle();
});
</script>
@endif

