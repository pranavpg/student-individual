
<?php
      //echo '<pre>'; print_r($practise);
    $answerExists = false; $answer =$exploded_question= array();
    if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
      $answerExists = true;
      // $answers = $practise['user_answer'][0]['text_ans'][0];
    }
    // dd($practise);
    if(isset($practise['question']) && !empty($practise['question'])){      
      $exploded_question = explode(PHP_EOL,$practise['question']);
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
  ?>



<div class="showPreviousPractice_{{$practise['id']}}  mb-4">
</div>

<form class="writing_at_end_speakingform_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  <input type="hidden" class="is_roleplay" name="role_play" value="1">
    <input type="hidden" class="is_roleplay_submit" name="is_roleplay_submit" value="1">


    <?php
	  // $answerExists = false;
	  $exploded_question  = array();

	  if( !empty( $practise['question'])) {
		$explode_question = explode('##',$practise['question']);
		$two_tabs= explode(' @@', $explode_question[0]);
		$roleplay_question =array();
     array_shift($explode_question);
      // echo '<pre>'; print_r($practise);
		 
    }
    ?>

  <div>
    <div class="component-two-click mb-4">
        @if(!empty($two_tabs))
            <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
              @foreach($two_tabs as $key => $value)
                <a href="javascript:;" class="btn btn-dark selected_option selected_option_{{$key}}" data-key="{{$key}}">{{$value}}</a>
              @endforeach
            </div>
            <input type="hidden" name="tabcount" value="{{count($two_tabs)}}">
        @endif
        <div class="two-click-content w-100">
          @if(!empty($explode_question))
          <?php $answer_count=0; $txtwritingCount=0; ?>
          
            @foreach($explode_question as $k => $v)
              <div class="content-box multiple-choice d-none selected_option_description selected_option_description_{{$k}}" >
                  <?php                
                  //    echo "sdfsdfsdfsdfdsf sd dsfsd";
                if($practise['type']== 'writing_at_end_speaking_up'){
                    ?>
                    <div class="row w-100 d-flex flex-wrap">
                    <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$k}}" name="user_audio[{{$k}}][audio_deleted]" value="0">
                    <input type="hidden" name="user_audio[{{$k}}][path]" class="audio_path{{$answer_count}}">
                    <div class="col-12 col-lg-12">
                      @include('practice.common.audio_record_div',['key'=>$answer_count])
                    </div>
                  </div>
                  <?php
                    $speakingWriting = explode(PHP_EOL,$v); 
                      if(count($speakingWriting) == 1){
                        $speakingWriting[1]='';
                      }
                      // $txtwritingCount=0;
                    foreach($speakingWriting as $key=> $value){
                      if($value != "" && str_contains($value,'@@')){
                        ?>
                          <div class="row w-100 d-flex flex-wrap">
                          <div class="col-12 col-lg-12"><br>
                         <p>{!!str_replace('@@','',$value)!!}</p>
                            <div class="component-control-box"> 
                            <span class="textarea form-control form-control-textarea stringProper text-left" role="textbox" contenteditable placeholder="Write here..."><?php if(isset($practise['user_answer'][$answer_count]['text_ans'][$key])){echo $practise['user_answer'][$answer_count]['text_ans'][$key];}?></span>
                            <div style="display:none">
                                                <textarea name="user_answer[{{$answer_count}}][text_ans][{{$key}}]">
                                                <?php
                                                      if (isset($practise['user_answer'][$answer_count]['text_ans'][$key]))
                                                      {
                                                        echo($practise['type'] == "writing_at_end_speaking_up" )?$practise['user_answer'][$answer_count]['text_ans'][$key]:'';
                                                      }
                                                  ?>
                                                </textarea>
                            </div>
                            <!-- <div style="display:none">
                              <textarea name="user_answer[{{$key}}][text_ans]">
                              
                              </textarea> 
                            </div>-->
                          </div>
                            <!-- <input type="hidden" name="user_answer[{{$txtwritingCount}}][audio_exists]" value=" "> -->
                          </div>
                        </div>
                        <?php
                      }else{
                        ?>
                          <input type="hidden" name="user_answer[{{$answer_count}}][text_ans][{{$key}}]">

                          <p>{!!$value!!}</p>
                        <?php
                      }
            
                      $txtwritingCount++;
                    } ?>
            
                  <?php
            
                } ?>    
                <?php $answer_count++ ?>     
                <input type="hidden" name="user_answer[{{$answer_count++}}]" value="##">         
                  
              
              </div>
            
            @endforeach
          @endif
        </div>
    </div>
      <!-- <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="user_audio[0][audio_deleted]" value="0">
      <input type="hidden" name="user_audio[0][path]" class="audio_path0">
     {{-- @include('practice.common.audio_record_div',['key'=>0])--}} -->
      

      <!-- /. Component Audio Player END-->

      <!-- <ul class="list-unstyled">
        @foreach($exploded_question as $key=>$item)

          <li>
          @if(str_contains($item,'@@'))
              @php $item = str_replace('@@', '', $item); @endphp
              {!! $item !!}
            <span class="textarea form-control form-control-textarea enter_disable" role="textbox"
                contenteditable placeholder="Write here...">
                <?php
                  // if($answerExists == true && array_key_exists($key, $practise['user_answer'][0]['text_ans']))
                  // {
                  //     echo str_replace(" ", "&nbsp;", $practise['user_answer'][0]['text_ans'][$key]);
                  //     // echo $practise['user_answer'][0]['text_ans'][$key];
                  // }elseif(isset($dependAnswer[0][$key]) && !empty($dependAnswer[0][$key])){
                  //   echo $dependAnswer[0][$key];
                  // }
                ?>
            </span>
            <div style="display:none">
                <textarea name="text_ans[{{$key}}]">
                <?php
                    // if($answerExists == true && array_key_exists($key, $practise['user_answer'][0]['text_ans']))
                    // {
                    //   // echo $practise['user_answer'][0]['text_ans'][$key];
                    //   echo str_replace(" ", "&nbsp;", $practise['user_answer'][0]['text_ans'][$key]);
                      
                    // }elseif(isset($dependAnswer[0][$key]) && !empty($dependAnswer[0][$key])){
                    //   echo $dependAnswer[0][$key];
                    // }
                ?>
                </textarea>
              </div>
          </li>
          @else
          <input type="hidden" name="text_ans[{{$key}}]" value="">

          {!! $item !!}
          @endif
        @endforeach
    </ul> -->



      <div class="alert alert-success" role="alert" style="display:none"></div>
      <div class="alert alert-danger" role="alert" style="display:none"></div>
      <ul class="list-inline list-buttons">
          <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn writing_at_end_up_speaking_up_{{$practise['id']}}" data-pid="{{$practise['id']}}"
                  data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
          </li>
          <li class="list-inline-item"><button type="button"
                  class="submit_btn btn btn-primary submitBtn writing_at_end_up_speaking_up_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1" >Submit</button>
          </li>
      </ul>
  </div>
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
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
<script>
  $(function () {
    $('.writing_at_end_speakingform_{{$practise["id"]}}').find(".selected_option").click(function () {
      var content_key = $(this).attr('data-key');
   
      $(".writing_at_end_speakingform_{{$practise['id']}}").find('.selected_option').not(this).toggleClass('d-none');
      $('.writing_at_end_speakingform_{{$practise["id"]}}').find('.selected_option_description_'+content_key).toggleClass('d-none');
      $('.writing_at_end_speakingform_{{$practise["id"]}}').find('.selected_option_description_'+content_key).show();
      $(this).toggleClass('btn-bg');
      
      $(".showPreviousPractice_{{$practise['id']}}").html("")
      if( $('.writing_at_end_speakingform_{{$practise["id"]}}').find('.selected_option_description:visible').length>0 ){
        roleplayDependent(content_key)
        $(".showPreviousPractice_{{$practise['id']}}").show();
        $('.writing_at_end_speakingform_{{$practise["id"]}}').find('.is_roleplay_submit').val(0);
      }else{
        $('.writing_at_end_speakingform_{{$practise["id"]}}').find('.is_roleplay_submit').val(1);
        $(".showPreviousPractice_{{$practise['id']}}").hide();
        $(".showPreviousPractice_{{$practise['id']}}").html("")
      }
    });
  });
  </script>
<script>
    var practice_type="{{$practise['type']}}";
    var token = $('meta[name=csrf-token]').attr('content');
    var upload_url = "{{url('upload-audio')}}";
    var workerDirPath = "{{asset('public/js/audio-recorder/')}}";

	var data=[]
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
	} else {
    $(".previous_practice_answer_exists_{{$practise['id']}}").show();
			$("#dependant_pr_{{$practise['id']}}").hide();
  }

</script>
@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==1 && $practise['typeofdependingpractice']!='get_answers_generate_quetions' )
  <script>
  var data=[]
 
    function roleplayDependent(content_key){
      data["{{$practise['id']}}"]["typeofdependingpractice"] = "{{$data[$practise['id']]['typeofdependingpractice']}}";
      data["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{$data[$practise['id']]['dependant_practise_question_type']}}";
      if(data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_hide_show" || data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_parentextra" || data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_gen_que_double" || data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" || data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_get_ans" || data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view"){
        data["{{$practise['id']}}"]["dependant_practise_task_id"] =  "{{$data[$practise['id']]['dependant_practise_task_id']}}";
        data["{{$practise['id']}}"]["dependant_practise_id"] = "{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}";
        $(function () {
          $('.cover-spin').fadeIn();
        });
        if(data["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
          
          // IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
          if(data["{{$practise['id']}}"]["dependant_practise_id"] !="" ){
            
            setTimeout(function(){ 
              var prevHTML = $(document).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').find('.appenddata_'+content_key).html();
              console.log(prevHTML);				 
              // var prevHTML = $(document).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').find('.appenddata_1').html();         
             
              $(".showPreviousPractice_{{$practise['id']}}").html(prevHTML);
              $(".showPreviousPractice_{{$practise['id']}}").css('pointer-events','none');
              $(".showPreviousPractice_{{$practise['id']}}").find('ul.list-buttons').remove();
              if(data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
                if( data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
                  $(".showPreviousPractice_{{$practise['id']}}").find('fieldset').remove();
                }
              }
              $('.cover-spin').fadeOut();

              $('.showPreviousPractice_{{$practise['id']}} .underline_text_list_item1').css({"margin-bottom":"1.45rem","font-size":"1.125rem","color":"#30475e"})
            }, 2000)
          }
        } else {
          
          // IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
          // DO NOT REMOVE BELOW   CODE
          var baseUrl = "{{url('/')}}";
          data["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{$data[$practise['id']]['dependant_practise_topic_id']}}";
          var dependentURL = baseUrl+'/topic/'+data["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data["{{$practise['id']}}"]["dependant_practise_id"];
          $.get(dependentURL,  //
          function (data, textStatus, jqXHR) {  // success callback

            var prevHTML = $(document).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').find('.selected_option_description_'+content_key).html();				 
             
            $('.showPreviousPractice_'+data["{{$practise['id']}}"]["dependant_practise_id"]).html(prevHTML);
            
            $(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
            $(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
            if(data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){              
              if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
                $(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
              }
            }
            $('.cover-spin').fadeOut();
          });


        }
      }  
    }
  </script>
@else
<script>
// function roleplayDependent(content_key){
//   alert("asdasd")
//   return true;
// }
</script>
@endif