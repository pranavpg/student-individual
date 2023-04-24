<?php 

  if($practise['depending_practise_details']['question_type']=="underline_text_multi_color"){

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
    <div class="showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}"></div>
    <?php
    $exploded_question = explode(PHP_EOL,$practise['question']); 

        $user_answer_temp = [];
            if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
                $answerExists = true;
                $user_answer_temp = $practise['user_answer'][0]['text_ans'];
            }
        ?>

        @if( !empty($exploded_question) )

        <?php 
        $s = 0;
        foreach($exploded_question as $key => $value) {
              if(str_contains($value,'@@')) {
                echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$value, &$s, &$ans, &$user_answer_temp) {

                          $str = "";
                          $ans = "";
                          if(!empty($user_answer_temp)){
                              $ans = $user_answer_temp[$s];
                          }
                          $str.= '<div class="choice-box4 j"><input type="text" class="form-control text-left pl-0 form-control-inline" name="text_ans[]" value="'.$ans.'" style="display: inline-table; color: red; font-weight: 600; text-align: left;"></div>';
                          $s++; 
                          echo "<br>";
                      return $str;
                }, $value);
              
              }else{
                  echo "<br>";
                  echo $value;
              }
        }
          ?>
        @endif
        <script type="text/javascript">
           
                if(data32==undefined ){
                    var data32=[];
                }
                var token = $('meta[name=csrf-token]').attr('content');
                var upload_url = "{{url('upload-audio')}}";
                var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
                data32["{{$practise['id']}}"]= {"dependentpractice_ans": "{{$data[$practise['id']]['dependentpractice_ans']}}" };
                data32["{{$practise['id']}}"]["isRolePlayPractice"] = "{{$data[$practise['id']]['isRolePlayPractice']}}"
                data32["{{$practise['id']}}"]["is_dependent"] = "{{$data[$practise['id']]['is_dependent']}}"; 
                if(data32["{{$practise['id']}}"]["is_dependent"]==1){
                    
                    if(data32["{{$practise['id']}}"]["dependentpractice_ans"]==0 ){
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
            data32["{{$practise['id']}}"]["typeofdependingpractice"] = "{{ $data[$practise['id']]['typeofdependingpractice'] }}";
            data32["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
            if(data32["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data32["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data32["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data32["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data32["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data32["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data32["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view" || data32["{{$practise['id']}}"]["typeofdependingpractice"] =="underline_text_multi_color"){
                data32["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
                data32["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
             
                if(data32["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
              
                     
                    // IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
                    if(data32["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
                        setTimeout(function(){ 
                         
                             data32["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data32["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();               
                         
                            $(document).find(".showPreviousPractice_"+data32["{{$practise['id']}}"]["dependant_practise_id"]).html(data32["{{$practise['id']}}"]["prevHTML"]);
                            $(document).find(".showPreviousPractice_"+data32["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
                            $(document).find(".showPreviousPractice_"+data32["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
                            $(document).find(".showPreviousPractice_"+data32["{{$practise['id']}}"]["dependant_practise_id"]).find('.pickcolor__heading').remove();
                            $(document).find(".showPreviousPractice_"+data32["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert').remove();
                            if( data32["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
                                if(data32["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
                                    $(document).find(".showPreviousPractice_"+data32["{{$practise['id']}}"]["dependant_practise_id"]).find('findset').remove();
                                }
                            }

                        }, 8000,data32 )
                    }
                } else {
                 
                    // IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
                    // DO NOT REMOVE BELOW   CODE
                    var baseUrl = "{{url('/')}}";
                    data32["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
                    data32["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data32["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data32["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data32["{{$practise['id']}}"]["dependant_practise_id"];
                    $.get(data32["{{$practise['id']}}"]["dependentURL"],  //
                    function (dataHTML, textStatus, jqXHR) {  // success callback
                        data32["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data32["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
                        $(document).find(".showPreviousPractice_"+data32["{{$practise['id']}}"]["dependant_practise_id"]).html(data32["{{$practise['id']}}"]["prevHTML"]);
                        $(document).find(".showPreviousPractice_"+data32["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
                        $(document).find(".showPreviousPractice_"+data32["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, .alert, input').remove();
                        
                        if(data32["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
                             
                            if(data32["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
                                $(document).find(".showPreviousPractice_"+data32["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
                            }
                        }
                    });
                }
            }  
        </script>
        @endif
  <?php


  }else{

    $exploded_question = explode(PHP_EOL,$practise['depending_practise_details']['question']);
    ?>
    @if( !empty($exploded_question) )
  
          <?php 
            foreach($exploded_question as $key => $value) {
                $user_answer_temp = !empty($practise['dependingpractise_answer'])?$practise['dependingpractise_answer'][0]['text_ans']:[];
                if(str_contains($value,'@@')) {
                  echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$value, &$key, &$ans, &$user_answer_temp) {
                            $str = "";
                            $ans = "";
                            if(!empty($user_answer_temp)){
                                $ans = $user_answer_temp[$key];
                            }
                            $str.= '<div class="choice-box4 j"><input type="text" class="form-control text-left pl-0 form-control-inline" value="'.$ans.'"  disabled style="display: inline-table; color: red; font-weight: 600; text-align: left;"></div>';
                          
                            echo "<br>";
                        return $str;
                  }, $value);
                
                }else{
                    echo "<br>";
                    echo $value;
                }
            }

          ?>
          
      @endif


  <?php $exploded_question = explode(PHP_EOL,$practise['question']); 

      $user_answer_temp = [];
        if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
          $answerExists = true;
          $user_answer_temp = $practise['user_answer'][0]['text_ans'];
        }
    ?>

    @if( !empty($exploded_question) )

      <?php 
      $s = 0;
        foreach($exploded_question as $key => $value) {
            if(str_contains($value,'@@')) {
              echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$value, &$s, &$ans, &$user_answer_temp) {

                        $str = "";
                        $ans = "";
                        if(!empty($user_answer_temp)){
                            $ans = $user_answer_temp[$s];
                        }
                        $str.= '<div class="choice-box4 j"><input type="text" class="form-control text-left pl-0 form-control-inline" name="text_ans[]" value="'.$ans.'" style="display: inline-table; color: red; font-weight: 600; text-align: left;"></div>';
                        $s++; 
                        echo "<br>";
                    return $str;
              }, $value);
            
            }else{
                echo "<br>";
                echo $value;
            }
        }

      ?>
      
  @endif
  @if(  $practise['type']=="writing_at_end_speaking")
    @include('practice.common.audio_record_div',['key'=>0])
  @endif

<?php
}

