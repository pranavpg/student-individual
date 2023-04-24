<p><strong>{!!$practise['title']!!}</strong></p>
<?php
    // echo "<pre>";dd($practise);
    $answerExists = false;
    $exploded_question  = array();
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
    
    if (isset($practise['user_answer']) && !empty($practise['user_answer']))
    {
        $answerExists = true;
    }
    if ($practise['type'] == 'single_speaking_writing')
    {
        //|| $practise['type']=='single_speaking_up_writing'
        $exp_question = explode('@@', $practise['question']);
        $exp_question_description = explode('##', end($exp_question));
        array_shift($exp_question_description);
        // pr($exp_question_description);
        
    }
    else
    {
        if(!empty($practise['question'])){

            if(!empty($practise['is_roleplay'])){
                $explode_question = explode('##', $practise['question']);
                
                $exp_question = explode('@@', $explode_question[0]);
             
                $question_description = array();
                $exp_question_description = array();
                for ($i = 1;$i <= count($exp_question);$i++)
                {
                    // if(!empty($explode_question[$i])){
                        $question_description[$i] = $explode_question[$i];
                    //}
                }
              
                $exp_question_description = array_values($question_description);
              
            } else{
                $question =  !empty($practise['question'])?$practise['question']:"";
                
            }
        } 
    }
?>
<!-- Compoent - Two click slider-->

    @if( !empty($practise['is_roleplay']) )
        @include('practice.single_speaking_writing_roleplay')
    @else 

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
        ?>
        <div class="previous_practice_answer_exists_{{$practise['id']}}" style="display:none">
            <div class="showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}">
            </div>
            
            <form class="form_{{$practise['id']}}">
                <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
                <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
                <input type="hidden" class="is_save" name="is_save" value="">
                <input type="hidden" class="practise_type" name="practise_type" value="{{$practise['type']}}">
                <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
                @if ( $practise['type']=='single_speaking_up_writing' )
                    @include('practice.common.audio_record_div',['key'=>0])
                @endif

                @if(!empty($question))
                <p> {!! str_replace('@@','',$question) !!}</p>
                @endif
                <div class="form-slider p-0 mb-4">
                    @if(!empty($practise['typeofdependingpractice']) && ($practise['typeofdependingpractice']=='get_answers_put_into_answers' || $practise['typeofdependingpractice']=='get_answers_put_into_quetions') )
                        <div class="component-control-box">
                            <span class="textarea form-control form-control-textarea test_1" role="textbox" {{($practise['typeofdependingpractice']=='get_answers_put_into_quetions')?'contenteditable':''}} placeholder="Write here...">
                                <?php
                                    if($practise['typeofdependingpractice']=='get_answers_put_into_quetions' && !empty($practise['user_answer'][0]['text_ans'][0])){
                                        echo !empty( $practise['user_answer'][0]['text_ans'][0] )?nl2br($practise['user_answer'][0]['text_ans'][0]):"";
                                    } else {

                                        echo !empty( $practise['dependingpractise_answer'][0] )?nl2br($practise['dependingpractise_answer'][0]):"";
                                    }
                                ?>
                            </span>
                            <div style="display:none">
                                <textarea name="user_answer[0][text_ans][0]">
                                <?php
                   
                                    if($practise['typeofdependingpractice']=='get_answers_put_into_quetions' && !empty($practise['user_answer'][0]['text_ans'][0])){
                                        echo !empty( $practise['user_answer'][0]['text_ans'][0] )?$practise['user_answer'][0]['text_ans'][0]:"";
                                    } else {
                                        echo !empty( $practise['dependingpractise_answer'][0] )?$practise['dependingpractise_answer'][0]:"";
                                    }
                                    
                                ?>
                                </textarea>
                                <input type="hidden" name="user_answer[0][path]" class="audio_path0">
                                <input type="hidden" name="user_answer[0][audio_record]" class="audio_record0" value="{{ !empty($practise['user_answer'][0]['path'])?$practise['user_answer'][0]['path']:''}}">
                                <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{0}}" name="user_answer[0][audio_deleted]" value="0">
                            </div>
                        </div>
                    @else
                        <div class="component-control-box">
                            <span class="textarea form-control form-control-textarea test_2 stringProper" role="textbox" contenteditable placeholder="Write here..."> <?php
                                if ($answerExists)
                                {
                                    echo !empty($practise['user_answer'][0]['text_ans'][0])?$practise['user_answer'][0]['text_ans'][0]:"";
                                }?></span>
                            <div style="display:none">
                                <textarea name="user_answer[0][text_ans][0]">
                                <?php
                                    if ($answerExists)
                                    {
                                        echo !empty($practise['user_answer'][0]['text_ans'][0])?$practise['user_answer'][0]['text_ans'][0]:"";
                                    }
                                ?>
                                </textarea>
                                <input type="hidden" name="user_answer[0][path]" class="audio_path0">
                                <input type="hidden" name="user_answer[0][audio_record]" class="audio_record0" value="{{ !empty($practise['user_answer'][0]['path'])?$practise['user_answer'][0]['path']:''}}">
                                <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{0}}" name="text_ans[0][audio_deleted]" value="0">
                            </div>
                        </div>
                    @endif
                </div>
                @if ( $practise['type']=='single_speaking_writing' )
                    @include('practice.common.audio_record_div',['key'=>0])
                @endif
             
            </form>
        </div>
    @endif
    <script>
        var feedbackExits       = "<?php echo isset($feedbackExits)?$feedbackExits:''; ?>";
        var feedbackPopup       = true;
        var facilityFeedback    = true;
        var courseFeedback      = false;
        if(data==undefined ){
            var data=[];
        }
        data["{{$practise['id']}}"]= {"dependentpractice_ans": "{{$data[$practise['id']]['dependentpractice_ans']}}" };
        data["{{$practise['id']}}"]["isRolePlayPractice"] = "{{$data[$practise['id']]['isRolePlayPractice']}}"
        data["{{$practise['id']}}"]["is_dependent"] = "{{$data[$practise['id']]['is_dependent']}}"; 
        var token = $('meta[name=csrf-token]').attr('content');
        var upload_url = "{{url('upload-audio')}}";
        var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
        
    </script>
    <script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
    
@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==0 && $practise['typeofdependingpractice']!='get_answers_generate_quetions' )
<script>
    if(data["{{$practise['id']}}"]["is_dependent"]==1){
        
        if(data["{{$practise['id']}}"]["dependentpractice_ans"]==0 ){
            $(".previous_practice_answer_exists_{{$practise['id']}}").hide();
            $("#dependant_pr_{{$practise['id']}}").show();
        } else {
            $(".previous_practice_answer_exists_{{$practise['id']}}").show();
            $("#dependant_pr_{{$practise['id']}}").hide();
        }
    } 
    else{
        $(".previous_practice_answer_exists_{{$practise['id']}}").show();
        $("#dependant_pr_{{$practise['id']}}").hide();
    }
    if(data["{{$practise['id']}}"]["dependentpractice_ans"]==1 ) {
        data["{{$practise['id']}}"]["typeofdependingpractice"] = "{{ $data[$practise['id']]['typeofdependingpractice'] }}";
        data["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
        if(data["{{$practise['id']}}"]["typeofdependingpractice"] == "set_full_view_remove_top_zero" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view"){
            $(document).ready(function(){

                if($('.cover-spin').is(":hidden")===true){
                     
                    $('.cover-spin').fadeIn();
                }
            });
            data["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
            data["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
            
            if(data["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
                
                // IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
                if(data["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
                    
                    if("{{$practise['id']}}" == "15568820885ccc22a86d946"){
                        data["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).html();                
                    }else{
                        data["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();                
                    }
                    $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(data["{{$practise['id']}}"]["prevHTML"]);
                    $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
                    setTimeout(function(){ 
                        $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('span.textarea').removeAttr('contenteditable');
                        $('.cover-spin').fadeOut();
                        $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
                        $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert').remove();
                        $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find( 'input[type="hidden"]').remove();
                    
                        if( data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_top_zero"){
                            if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_blanks") {
                                $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.match-answer').remove();
                                $('.cover-spin').fadeOut();
                            } 
                        }
                        if( data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view" && data["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_total_blanks_edit"){
                            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.match-answer').remove();
                        $('.cover-spin').fadeOut();
                        }
                        

                        if( data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
                            
                            if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up" || data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_up_speaking_up" || data["{{$practise['id']}}"]["dependant_practise_question_type"] == "single_speaking_up_writing" ) {

                                if("{{$practise['id']}}" == "15568820885ccc22a86d946"){
                                    $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.teacher-feedback-form').remove();
                                    $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.record_15689088485d83a6301c551').remove();
                                    $('.previous_practice_answer_exists_15689088485d83a6301c551')
                                }else{
                                    $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
                                }

                                $('.cover-spin').fadeOut(); 
                            } 
                        } 
                    }, 4000 )
                    
                   
                }  
                
            } else {
                
                    // IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
                // DO NOT REMOVE BELOW   CODE ====================  
                var baseUrl = "{{url('/')}}";
                data["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
                data["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data["{{$practise['id']}}"]["dependant_practise_id"]+'&user_id={{ isset($studentId)?$studentId:'' }}';
               
                 
                $.get(data["{{$practise['id']}}"]["dependentURL"],  //
                        function (dataHTML, textStatus, jqXHR) {  // success callback
                console.log(dataHTML)
                    if(  data["{{$practise['id']}}"]["dependant_practise_id"]!==undefined){
                        setTimeout(function(){
                            
                            
                            
                            var getFullHTML = $(dataHTML).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).html();
                            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(getFullHTML);
                            data["{{$practise['id']}}"]["prevHTML"] =  $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form:first').clone();
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
                        },4000);
                    }
                });
                $.get("https://cdn.plyr.io/3.5.6/plyr.css");

            }
        }  
    }
</script>
@else 
    <script>
        $(document).ready(function(){
            $('.cover-spin').fadeOut();

        });
        
        $(".previous_practice_answer_exists_{{$practise['id']}}").show();
        $("#dependant_pr_{{$practise['id']}}").hide();
    </script>
    <style type="text/css">
        .stringProper{
            white-space: pre-line;
        }
    </style>
@endif