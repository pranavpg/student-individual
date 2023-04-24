<p><strong>{!!$practise['title']!!}</strong></p>
<?php
    // echo "<pre>";
// dd($practise);
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
                    <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="single_speaking_writing" value="0">
                @endif

                @if(!empty($question))
                <p> {!! str_replace('@@','',$question) !!}</p>
                @endif
                <div class="form-slider p-0 mb-4">
                    @if(!empty($practise['typeofdependingpractice']) && ($practise['typeofdependingpractice']=='get_answers_put_into_answers' || $practise['typeofdependingpractice']=='get_answers_put_into_quetions') )
                        <div class="component-control-box">
                            <span class="textarea form-control form-control-textarea " role="textbox" {{($practise['typeofdependingpractice']=='get_answers_put_into_quetions')?'contenteditable':''}} placeholder="Write here...">
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
                            </div>
                        </div>
                    @else
                        <div class="component-control-box">
                            <span class="textarea form-control form-control-textarea stringProper text-left" role="textbox" contenteditable placeholder="Write here..."><?php
                                if ($answerExists)
                                {
                                    echo !empty($practise['user_answer'][0]['text_ans'][0])?$practise['user_answer'][0]['text_ans'][0]:"";
                                }
                            ?>
                            </span>
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
                            </div>
                        </div>
                    @endif
                </div>
                @if ( $practise['type']=='single_speaking_writing' )
                    @include('practice.common.audio_record_div',['key'=>0])
                    <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="single_speaking_writing" value="0">

                @endif
                <!-- ./ Compoent - Two click slider Ends-->
                <div class="alert alert-success" role="alert" style="display:none"></div>
                <div class="alert alert-danger" role="alert" style="display:none"></div>
                <ul class="list-inline list-buttons">
                    <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"
                        data-toggle="modal" data-is_save="0" data-target="#exitmodal">Save</button></li>
                    <li class="list-inline-item"><button type="button"
                        class="submit_btn btn btn-primary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1">Submit</button></li>
                </ul>
            </form>
        </div>
    @endif

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
    <script>
        var feedbackPopup     = true;
        var facilityFeedback    = true;
        var courseFeedback      = false;
        if(data10==undefined ){
            var data10=[];
        }
        data10["{{$practise['id']}}"]= {"dependentpractice_ans": "{{$data[$practise['id']]['dependentpractice_ans']}}" };
        data10["{{$practise['id']}}"]["isRolePlayPractice"] = "{{$data[$practise['id']]['isRolePlayPractice']}}"
        data10["{{$practise['id']}}"]["is_dependent"] = "{{$data[$practise['id']]['is_dependent']}}";

        function Audioplay_new(pid,inc,flagForAudio) {
            
            var supportsAudio = !!document.createElement('audio').canPlayType;
            if (supportsAudio) {
                var i;
                
                var player = new Plyr(".modal .answer_audio-{{$practise['id']}}-"+inc, {
                    controls: [
                        'play',
                        'progress',
                        'current-time'
                    ]
                }); 
            }
        }
        

        $(document).on('click', '.submitBtn_{{$practise["id"]}}', function() {
                    if($(this).attr('data-is_save') == '1'){
                        $(this).closest('.active').find('.msg').fadeOut();
                    }else{
                        $(this).closest('.active').find('.msg').fadeIn();
                    }
                    var reviewPopup = '{!!$reviewPopup!!}';
                    var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';

                    $(".form_{{$practise['id']}}").find('.submitBtn').attr('data-is_save',1);

                    if(markingmethod =="student_self_marking"){
                        if($(this).attr('data-is_save') == '1'){
                            var AllAudio = new Array();
                            var checkAudioAva = new Array();
                            $('.form_{{$practise['id']}} .main-audio-record-div').each(function(){
                                // alert($(this).find(".practice_audio").children().attr("src"))
                                if($(this).find(".practice_audio").children().attr("src").indexOf("sample-audio.mp3") !== -1) {
                                    checkAudioAva.push("false");
                                    // alert($(this).find(".practice_audio").children().attr("src"));
                                    AllAudio.push($(this).html())
                                } else {
                                    checkAudioAva.push("true");
                                    // alert($(this).find(".practice_audio").children().attr("src"));
                                    AllAudio.push($(this).find(".practice_audio").children().attr("src"))
                                }
                            });
                            // alert(checkAudioAva)
                            var fullView= $(".form_{{$practise['id']}}").html();
                            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
                            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
                            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
                            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
                            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
                            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.textarea').attr("contenteditable",false);
                            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.delete-icon-right').remove();
                            


                            var tempInc = 0;
                            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.main-audio-record-div').each(function(){
                                $(this).parent().prepend("<div class='append_"+tempInc+" myclass audio-player ' data="+tempInc+" style='position: relative;display: flex;align-items: center;margin-bottom: 2rem;'></div>")
                                tempInc++;
                            })
                            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.main-audio-record-div').each(function(){
                                $(this).remove()
                            }) 

                            classMarkRolePlay();
                            // var tempInc = 0;
                            $.each(AllAudio,function(k,v){
                                var audioTemp   = ' <audio preload="auto" controls class="practice_audio answer_audio-{{$practise['id']}}-'+k+'">\
                                                      <source src="'+v+'" type="audio/mp3">\
                                                  </audio>';
                                var disableIcon = "";
                                
                                if(checkAudioAva[k] ==="true"){
                                    $('.append_'+k).append(audioTemp)
                                    disableIcon =false;
                                    Audioplay_new("{{$practise['id']}}",k,disableIcon);
                                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}} .append_"+k+" .plyr").css("width","310px");
                                }else{
                                    disableIcon =true;
                                    $('.append_'+k).append(v)
                                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}} .append_"+k ).css("pointer-events","none");
                                }
                                
                            });




                        }
                    }
                    if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){
                        $("#reviewModal_{{$practise['id']}}").modal('toggle');
                    }


            $('.submitBtn').attr('disabled', 'disabled');
            var is_save = $(this).attr('data-is_save');
            // alert(is_save);
            $('.is_save:hidden').val(is_save);
            $("span.textarea.form-control").each(function() {
                var currentVal = $(this).html();
                var regex = /<br\s*[\/]?>/gi;
                currentVal=currentVal.replace(regex, "\n");
                var regex = /<div\s*[\/]?>/gi;
                currentVal=currentVal.replace(regex, "\n");
                var regex = /<\/div\s*[\/]?>/gi;
                currentVal=currentVal.replace(regex, "");
                var regex = /&nbsp;/gi;
                currentVal=currentVal.replace(regex, " ");

                $(this).next().find("textarea").val(currentVal);
            });
            $.ajax({
                url: '<?php echo URL("save-single-speaking-writing"); ?>',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: $('.form_{{$practise["id"]}}').serialize(),
                success: function(data) {
                    $('.submitBtn_{{$practise["id"]}}').removeAttr('disabled');
                    if (data.success) {
                        if(is_save=="1"){
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
                            },2000);
                            // =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
                        } 
                        $('.alert-danger').hide();
                        $('.alert-success').show().html(data.message).fadeOut(8000);
                    } else {
                        $('.alert-success').hide();
                        $('.alert-danger').show().html(data.message).fadeOut(8000);
                    }
                }
            });
        });
        var token = $('meta[name=csrf-token]').attr('content');
        var upload_url = "{{url('upload-audio')}}";
        var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
        
    </script>
    <script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
    
@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==0 && $practise['typeofdependingpractice']!='get_answers_generate_quetions' )
<script>
    if(data10["{{$practise['id']}}"]["is_dependent"]==1){
        
        if(data10["{{$practise['id']}}"]["dependentpractice_ans"]==0 ){
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
    if(data10["{{$practise['id']}}"]["dependentpractice_ans"]==1 ) {
        data10["{{$practise['id']}}"]["typeofdependingpractice"] = "{{ $data[$practise['id']]['typeofdependingpractice'] }}";
        data10["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
        if(data10["{{$practise['id']}}"]["typeofdependingpractice"] == "set_full_view_remove_top_zero" || data10["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data10["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data10["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data10["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data10["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data10["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data10["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view"){
            $(document).ready(function(){

                if($('.cover-spin').is(":hidden")===true){
                     
                    $('.cover-spin').fadeIn();
                }
            });
            data10["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
            data10["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
            
            if(data10["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
                
                // IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
                if(data10["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
                
                    data10["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data10["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();                
                    $(document).find(".showPreviousPractice_"+data10["{{$practise['id']}}"]["dependant_practise_id"]).html(data10["{{$practise['id']}}"]["prevHTML"]);
                    $(document).find(".showPreviousPractice_"+data10["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
                    setTimeout(function(){ 
                        $(document).find(".showPreviousPractice_"+data10["{{$practise['id']}}"]["dependant_practise_id"]).find('span.textarea').removeAttr('contenteditable');
                        $('.cover-spin').fadeOut();
                        $(document).find(".showPreviousPractice_"+data10["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
                        $(document).find(".showPreviousPractice_"+data10["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert').remove();
                        $(document).find(".showPreviousPractice_"+data10["{{$practise['id']}}"]["dependant_practise_id"]).find( 'input[type="hidden"]').remove();
                    
                        if( data10["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_top_zero"){
                            if(data10["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_blanks") {
                                $(document).find(".showPreviousPractice_"+data10["{{$practise['id']}}"]["dependant_practise_id"]).find('.match-answer').remove();
                                $('.cover-spin').fadeOut();
                            } 
                        }
                        if( data10["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view" && data10["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_total_blanks_edit"){
                            $(document).find(".showPreviousPractice_"+data10["{{$practise['id']}}"]["dependant_practise_id"]).find('.match-answer').remove();
                        $('.cover-spin').fadeOut();
                        }
                        

                        if( data10["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
                            
                            if(data10["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up" || data10["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_up_speaking_up" || data10["{{$practise['id']}}"]["dependant_practise_question_type"] == "single_speaking_up_writing" ) {
                                $(document).find(".showPreviousPractice_"+data10["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
                                $('.cover-spin').fadeOut(); 
                            } 
                        } 
                    }, 8000 )
                    
                   
                }  
                
            } else {
                
                    // IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
                // DO NOT REMOVE BELOW   CODE ====================  
                var baseUrl = "{{url('/')}}";
                data10["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
                data10["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data10["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data10["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data10["{{$practise['id']}}"]["dependant_practise_id"];
               
                 
                $.get(data10["{{$practise['id']}}"]["dependentURL"],  //
                        function (dataHTML, textStatus, jqXHR) {  // success callback
                console.log(dataHTML)
                    if(  data10["{{$practise['id']}}"]["dependant_practise_id"]!==undefined){
                        setTimeout(function(){
                            
                            
                            
                            var getFullHTML = $(dataHTML).find('.course-tab-content').find('#abc-'+data10["{{$practise['id']}}"]["dependant_practise_id"]).html();
                            $(document).find(".showPreviousPractice_"+data10["{{$practise['id']}}"]["dependant_practise_id"]).html(getFullHTML);
                            data10["{{$practise['id']}}"]["prevHTML"] =  $(document).find(".showPreviousPractice_"+data10["{{$practise['id']}}"]["dependant_practise_id"]).find('form:first').clone();
                            $(document).find(".showPreviousPractice_"+data10["{{$practise['id']}}"]["dependant_practise_id"]).html(data10["{{$practise['id']}}"]["prevHTML"]);



                            $(document).find(".showPreviousPractice_"+data10["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
                            $(document).find(".showPreviousPractice_"+data10["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, .alert').remove();
                            $(document).find(".showPreviousPractice_"+data10["{{$practise['id']}}"]["dependant_practise_id"]).find( 'input[type="hidden"]').remove();
                            
                            if(data10["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
                                if(data10["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
                                    $(document).find(".showPreviousPractice_"+data10["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
                                }
                            }
                            $('.cover-spin').fadeOut();
                        },8000);
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
@endif