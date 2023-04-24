 
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_type" name="practise_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  <input type="hidden" name="is_roleplay" value="true" >
  <input type="hidden" class="is_roleplay_submit" name="is_roleplay_submit" value="1">
<?php   //echo '<pre>'; print_r($practise); echo '</pre>'; ?>
  <div class="component-two-click mb-4">
    @if($practise['id'] != "15511967375c7562416dad0")
    <div class="showPreviousPractice_{{$practise['id']}} mb-4"></div>
    @endif

    @if(isset($exp_question)&& !empty($exp_question))
    <input type="hidden" name="rolplay_tab_count" value="{{count($exp_question)}}">
    <?php $answer_count=0;
    
    ?>
    <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
        @foreach($exp_question as $key => $value)
        <?php
          if (str_contains($value, '##'))
          {
              $last_ans = explode('##', $value);
              $value = $last_ans[0];
          }
          ?>
        
        <a href="#!" class="btn btn-dark selected_option selected_option_{{$key}}" data-ans_count={{$answer_count}} data-key="{{$key}}" data-show_dependent_error="{{ ( !empty($practise['dependingpractiseid']) && empty($practise['dependingpractise_answer'][$answer_count]) )?1:0 }}" >{{$value}}</a>
        <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$answer_count}}" name="single_speaking_writing_roleplay{{$answer_count}}" value="0">
        <?php $answer_count+=2 ?>
        @endforeach
    </div>
    @endif
    @if(!empty($exp_question_description)) 
   
      <div class="two-click-content w-100">
      <?php $answer_count=0; ?>
        @foreach($exp_question_description as $k => $v)
          @if(!empty($v))
           
            <div class="content-box multiple-choice d-none selected_option_description selected_option_description_{{$k}}">

              @if( !empty($practise['dependingpractiseid']) && empty($practise['dependingpractise_answer'][$answer_count]) )
                  @php 
                    $depend = explode("_",$practise['dependingpractiseid']);
                    $depenMessage="block";
                    $answer_block = "none";
                  @endphp

                  <div class="dependant_pr_{{$practise['id']}}"  style="margin-top:15px; border: 2px dashed gray; border-radius: 13px; ">
                      <p style="margin: 15px;">In order to do this task you need to have completed
                      <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                </div>
              @else
                  @php 
                    
                    $depenMessage="none";
                    $answer_block = "block";

                  @endphp
              @endif 
                
                  <?php 
                   
                    if( str_contains($exp_question_description[$k],'#%') ){
                
                      $question_ts = explode('#%', $exp_question_description[$k]);
                      $read_text_tab = $question_ts[0];
                      $exploded_question_ts = explode('/t', $question_ts[1]);
                      
                      $read_text_description = $exploded_question_ts[0]; 
                    }
                  ?>
                <div style="display:{{$answer_block}}">
                  @if(!empty($read_text_description ))
                      <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
                          <a href="javascript:;" data-toggle="modal" data-target="#read_text_modal_{{$answer_count}}" class="btn btn-dark selected_option_hide_show ">{{ !empty($read_text_tab) ? $read_text_tab : "Read Text" }}</a>
                      </div>

                      <div class="modal subdeoModal" id="read_text_modal_{{$answer_count}}" tabindex="-1" role="dialog" aria-labelledby="deoModalTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered deoModal" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="deoModalTitle">{!! !empty($read_text_tab) ? $read_text_tab : "Read Text" !!}</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <div class="modal-body">
                                  <p>{!! nl2br($read_text_description)  !!}</p>
                              </div>
                              <div class="modal-footer justify-content-center">
                                  <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
                              </div>
                          </div>
                          </div>
                      </div>
                  @endif

                  @if ( $practise['type']=='single_speaking_up_writing' )
                  <input type="hidden" name="user_answer[{{$k}}][path]" class="audio_path{{$answer_count}}">
                  <input type="hidden" name="user_answer[{{$k}}][audio_record]" class="audio_record{{$answer_count}}" value="{{ !empty($practise['user_answer'][$answer_count]['path'])?$practise['user_answer'][$answer_count]['path']:''}}">
                    @include('practice.common.audio_record_div',['key'=>$answer_count])
                  @endif
                  <?php 
                  
                    //pr($question_ts );
                  ?>
                  @if( empty($exp_question_description[$k]) && !str_contains($exp_question_description[$k],'#%') )
                  <p> {!! str_replace('@@','',$v) !!}</p>
                  @elseif( !empty($exp_question_description[$k]) && !str_contains($exp_question_description[$k],'#%') )
                  <p> {!! str_replace('@@','',$v) !!}</p>
                  @elseif(!empty($question_ts[2]))
                  <p> {!! str_replace('@@','',$question_ts[2]) !!}</p>
                  @endif
                  <div class="form-slider p-0 mb-4">
                    <div class="component-control-box">
                      <span class="textarea form-control form-control-textarea enter_disable" role="textbox" contenteditable placeholder="Write here..."><?php if ($answerExists){echo !empty($practise['user_answer'][$answer_count]['text_ans'][0])?trim($practise['user_answer'][$answer_count]['text_ans'][0]):"";}?></span>
                      <div style="display:none">
                          <textarea name="user_answer[{{$k}}][text_ans]">
                          <?php
                            if ($answerExists)
                            {
                              echo !empty($practise['user_answer'][$answer_count]['text_ans'][0])?$practise['user_answer'][$answer_count]['text_ans'][0]:"";
                            }
                          ?>
                          </textarea>
                          <input type="text" name="user_answer[{{$k}}][path]" class="audio_path{{$answer_count}}">
                          <input type="hidden" name="user_answer[{{$k}}][audio_record]" class="audio_record{{$answer_count}}" value="{{ !empty($practise['user_answer'][$answer_count]['path'])?$practise['user_answer'][$answer_count]['path']:''}}">
                      </div>
                    </div>
                  </div>
                  @if ( $practise['type']=='single_speaking_writing' )
                    @include('practice.common.audio_record_div',['key'=>$answer_count])

                  @endif
                </div>            
            </div>
          @endif
          <?php $answer_count+=2 ?>
          @endforeach
      </div>
    @endif
  </div>
  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
  <ul class="list-inline list-buttons">
      <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary saveBtn submitBtn_{{$practise['id']}}"   data-pid="{{$practise['id']}}"
          data-toggle="modal" data-is_save="0" data-target="#exitmodal">Save</button></li>
      <li class="list-inline-item"><button type="button"
          class="submit_btn btn btn-primary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"   data-is_save="1">Submit</button></li>
  </ul>
</form>

@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==1 && $practise['typeofdependingpractice']!='get_answers_generate_quetions' )
<script>

  if(data23==undefined ){
    var data23=[];
  }
    $(function() {

        data23["{{$practise['id']}}"]= [];
        data23["{{$practise['id']}}"]["dependent_is_roleplay"] = "{{$data[$practise['id']]['dependent_is_roleplay']}}";
        // alert(data23["{{$practise['id']}}"]["dependent_is_roleplay"]);
               // alert('.form_'+"{{$practise['id']}}");
            $(".form_{{$practise['id']}}").find(".selected_option").click(function() {
            var content_key = $(this).attr('data-key');
            var ans_count = $(this).attr('data-ans_count');
            var show_dependent_error = parseInt($(this).attr('data-show_dependent_error'));
           
            $(".form_{{$practise['id']}}").find('.selected_option').not(this).toggleClass('d-none');
            $(".form_{{$practise['id']}}").find('.selected_option_description_' + content_key).toggleClass('d-none');
            $(".form_{{$practise['id']}}").find('.selected_option_' + content_key).show();
            $(".form_{{$practise['id']}}").find(this).toggleClass('btn-bg');
            var answer_count = 0;
            var answer_number = 0;
            $(".showPreviousPractice_{{$practise['id']}}").html("")
            if(content_key>0) {
              answer_count  = parseInt(content_key);
              answer_number = parseInt(ans_count);
            }
            if($(".form_{{$practise['id']}}").find('.selected_option_description:visible').length > 0) {
            // alert(show_dependent_error); 
                if(data23["{{$practise['id']}}"]["dependent_is_roleplay"] && show_dependent_error!=1){
                  roleplayDependent(content_key, answer_count)
                }
                if($('.audio_record'+answer_number).val() == ""){
                  // $('.submitBtn_{{$practise['id']}}' ).prop("disabled", true);
                }else {
                  $('.submitBtn_{{$practise['id']}}' ).prop("disabled", false);
                }
                $(".dependant_pr_{{$practise['id']}}").show();
                $(".form_{{$practise['id']}}").find('.is_roleplay_submit').val(0);
                // o to 1 converted
                $(".form_{{$practise['id']}}").find('.submitBtn').attr('data-is_save', 1);
            } else {
                $(".dependant_pr_{{$practise['id']}}").hide();
                $(".showPreviousPractice_{{$practise['id']}}").html("").show();
                $('.submitBtn_{{$practise['id']}}' ).prop("disabled", false);
                $(".form_{{$practise['id']}}").find('.is_roleplay_submit').val(1);
                $(".form_{{$practise['id']}}").find('.submitBtn').attr('data-is_save',1);
            }
        });
    });
 
    function classMarkRolePlay(){
      $(".self_marking_modal_popup").find(".selected_option").click(function() {
            var content_key = $(this).attr('data-key');
            var ans_count = $(this).attr('data-ans_count');
            var show_dependent_error = parseInt($(this).attr('data-show_dependent_error'));
           
            $(".self_marking_modal_popup").find('.selected_option').not(this).toggleClass('d-none');
            $(".self_marking_modal_popup").find('.selected_option_description_' + content_key).toggleClass('d-none');
            $(".self_marking_modal_popup").find('.selected_option_' + content_key).show();
            $(".self_marking_modal_popup").find(this).toggleClass('btn-bg');
            var answer_count = 0;
            var answer_number = 0;
            $(".self_marking_modal_popup .showPreviousPractice_{{$practise['id']}}").html("")
            if(content_key>0) {
                answer_count = parseInt(content_key);
                answer_number = parseInt(ans_count)
            }
            
            if ($(".self_marking_modal_popup").find('.selected_option_description:visible').length > 0) {
                if(  data23["{{$practise['id']}}"]["dependent_is_roleplay"] && show_dependent_error!=1){
                  roleplayDependentpopup(content_key, answer_count)
                }

                if( $('.self_marking_modal_popup .audio_record'+answer_number).val()=="" ){
                  // $('.self_marking_modal_popup .submitBtn_{{$practise['id']}}' ).prop("disabled", true);
                }else {
                  $('.self_marking_modal_popup .submitBtn_{{$practise['id']}}' ).prop("disabled", false);
                }
                
                $(".self_marking_modal_popup .dependant_pr_{{$practise['id']}}").show();
                $(".self_marking_modal_popup").find('.is_roleplay_submit').val(0);
                $(".self_marking_modal_popup").find('.submitBtn').attr('data-is_save', 0);
            } else {
             
                $(".self_marking_modal_popup .dependant_pr_{{$practise['id']}}").hide();
                $(".self_marking_modal_popup .showPreviousPractice_{{$practise['id']}}").html("").show();
                $('.self_marking_modal_popup .submitBtn_{{$practise['id']}}' ).prop("disabled", false);
                $(".self_marking_modal_popup").find('.is_roleplay_submit').val(1);
                $(".self_marking_modal_popup").find('.submitBtn').attr('data-is_save',1);
            }
        });
    }
    function roleplayDependentpopup(content_key, answer_count){
       data23["{{$practise['id']}}"] = [];
      data23["{{$practise['id']}}"]["typeofdependingpractice"] = "{{$data[$practise['id']]['typeofdependingpractice']}}";
      data23["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{$data[$practise['id']]['dependant_practise_question_type']}}";
      if(data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_hide_show" || data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_parentextra" || data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_gen_que_double" || data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" || data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_get_ans" || data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view"){
        data23["{{$practise['id']}}"]["dependant_practise_task_id"] =  "{{$data[$practise['id']]['dependant_practise_task_id']}}";
        data23["{{$practise['id']}}"]["dependant_practise_id"] = "{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}";
        $(function () {
            $('.cover-spin').fadeIn();
        })
        if(data23["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{ request()->segment(3)}}"){
          
          // IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
          if(data23["{{$practise['id']}}"]["dependant_practise_id"] !="" ){

            setTimeout(function(){ 
               
              $(".self_marking_modal_popup .showPreviousPractice_{{$practise['id']}}").html("");
              if(data23["{{$practise['id']}}"]["dependent_is_roleplay"] ==1 ){
            
                var prevHTML = $(document).find('.course-tab-content').find('#abc-'+data23["{{$practise['id']}}"]["dependant_practise_id"]).find('form').find( '.selected_option_description_'+answer_count).html();  
                if(prevHTML==undefined){
                  var prevHTML = $(document).find('.course-tab-content').find('#abc-'+data23["{{$practise['id']}}"]["dependant_practise_id"]).find('form').find( '#table_dependent_'+answer_count).html();  
                }      
              } else {
                var prevHTML = $(document).find('.course-tab-content').find('#abc-'+data23["{{$practise['id']}}"]["dependant_practise_id"]).find('form').find( '.selected_option_description_'+content_key ).html();         
              }
 
             
              $(".self_marking_modal_popup .showPreviousPractice_{{$practise['id']}}").html(prevHTML).show();
              $(".self_marking_modal_popup .showPreviousPractice_{{$practise['id']}}").css('pointer-events','none');
              $(".self_marking_modal_popup .showPreviousPractice_{{$practise['id']}}").find('ul.list-buttons').remove();
              $(".self_marking_modal_popup .showPreviousPractice_{{$practise['id']}}").find('div.table-container').removeClass('d-none');
             
              if(data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
                if( data23["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up" ||  data23["{{$practise['id']}}"]["dependant_practise_question_type"] == "single_speaking_up_writing") {
                  $(".self_marking_modal_popup .showPreviousPractice_{{$practise['id']}}").find('fieldset').remove();
                }
              }
              if(data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero_parentextra_get_questions_and_answers"){
                if( data23["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up" ||  data23["{{$practise['id']}}"]["dependant_practise_question_type"] == "single_speaking_up_writing") {
                  $(".self_marking_modal_popup .showPreviousPractice_{{$practise['id']}}").find('fieldset').remove();
                  $(".self_marking_modal_popup .showPreviousPractice_{{$practise['id']}}").find('.two-click').remove();
                }
              }  
              $('.cover-spin').fadeOut();
            }, 2000)
          }
        } else {
          
          // IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
          // DO NOT REMOVE BELOW   CODE
          var baseUrl = "{{url('/')}}";
          data23["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{$data[$practise['id']]['dependant_practise_topic_id']}}";
          var dependentURL = baseUrl+'/topic/'+data23["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data23["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data23["{{$practise['id']}}"]["dependant_practise_id"];
          $.get(dependentURL,  //
          function (dataHTML, textStatus, jqXHR) {  // success callback
            
            var prevHTML = $(dataHTML).find('.course-tab-content').find('#abc-'+data23["{{$practise['id']}}"]["dependant_practise_id"]).find('.selected_option_description_'+content_key).html();
            $(document).find(".showPreviousPractice_{{$practise['id']}}").html(prevHTML);
         
            
            
            $(".showPreviousPractice_{{$practise['id']}}").css('pointer-events','none');
            $(".showPreviousPractice_{{$practise['id']}}").find('ul.list-buttons').remove();
            if(data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
              
              if(data23["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up" ||  data23["{{$practise['id']}}"]["dependant_practise_question_type"] == "single_speaking_up_writing") {
                $(".showPreviousPractice_{{$practise['id']}}").find('fieldset').remove();
              }
              if(data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero_parentextra_get_questions_and_answers" ||data23["{{$practise['id']}}"]["typeofdependingpractice"]== "set_full_view_remove_zero"){
                if( data23["{{$practise['id']}}"]["dependant_practise_question_type"] == "three_blank_table_speaking_up" ||  data23["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up" ||  data23["{{$practise['id']}}"]["dependant_practise_question_type"] == "single_speaking_up_writing") {
                  $(".showPreviousPractice_{{$practise['id']}}").find('fieldset').remove();
                }
              }
              
            }
            $('.cover-spin').fadeOut();
          });
        }
      }  
    }
    function roleplayDependent(content_key, answer_count){

       data23["{{$practise['id']}}"] = [];

      data23["{{$practise['id']}}"]["typeofdependingpractice"] = "{{$data[$practise['id']]['typeofdependingpractice']}}";
      data23["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{$data[$practise['id']]['dependant_practise_question_type']}}";
      if(data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_hide_show" || data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_parentextra" || data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_gen_que_double" || data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" || data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_get_ans" || data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view"){
        data23["{{$practise['id']}}"]["dependant_practise_task_id"] =  "{{$data[$practise['id']]['dependant_practise_task_id']}}";
        data23["{{$practise['id']}}"]["dependant_practise_id"] = "{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}";
        $(function () {
            $('.cover-spin').fadeIn();
        })
        if(data23["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{ request()->segment(3)}}"){
          
          // IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
          if(data23["{{$practise['id']}}"]["dependant_practise_id"] !="" ){

            setTimeout(function(){ 
               
              $(".showPreviousPractice_{{$practise['id']}}").html("");
              if(data23["{{$practise['id']}}"]["dependent_is_roleplay"] ==1 ){
            
                var prevHTML = $(document).find('.course-tab-content').find('#abc-'+data23["{{$practise['id']}}"]["dependant_practise_id"]).find('form').find( '.selected_option_description_'+answer_count).html();  
                if(prevHTML==undefined){
                  var prevHTML = $(document).find('.course-tab-content').find('#abc-'+data23["{{$practise['id']}}"]["dependant_practise_id"]).find('form').find( '#table_dependent_'+answer_count).html();  
                }      
              } else {
                var prevHTML = $(document).find('.course-tab-content').find('#abc-'+data23["{{$practise['id']}}"]["dependant_practise_id"]).find('form').find( '.selected_option_description_'+content_key ).html();         
              }
 
             
              $(".showPreviousPractice_{{$practise['id']}}").html(prevHTML).show();
              $(".showPreviousPractice_{{$practise['id']}}").css('pointer-events','none');
              $(".showPreviousPractice_{{$practise['id']}}").find('ul.list-buttons').remove();
              $(".showPreviousPractice_{{$practise['id']}}").find('div.table-container').removeClass('d-none');
             
              if(data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
                if( data23["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up" ||  data23["{{$practise['id']}}"]["dependant_practise_question_type"] == "single_speaking_up_writing") {
                  $(".showPreviousPractice_{{$practise['id']}}").find('fieldset').remove();
                }
              }
              if(data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero_parentextra_get_questions_and_answers"){
                if( data23["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up" ||  data23["{{$practise['id']}}"]["dependant_practise_question_type"] == "single_speaking_up_writing") {
                  $(".showPreviousPractice_{{$practise['id']}}").find('fieldset').remove();
                  $(".showPreviousPractice_{{$practise['id']}}").find('.two-click').remove();
                }
              }  
              $('.cover-spin').fadeOut();
            }, 2000)
          }
        } else {
          
          // IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
          // DO NOT REMOVE BELOW   CODE
          var baseUrl = "{{url('/')}}";
          data23["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{$data[$practise['id']]['dependant_practise_topic_id']}}";
          var dependentURL = baseUrl+'/topic/'+data23["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data23["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data23["{{$practise['id']}}"]["dependant_practise_id"];
          $.get(dependentURL,  //
          function (dataHTML, textStatus, jqXHR) {  // success callback
            
            var prevHTML = $(dataHTML).find('.course-tab-content').find('#abc-'+data23["{{$practise['id']}}"]["dependant_practise_id"]).find('.selected_option_description_'+content_key).html();
            $(document).find(".showPreviousPractice_{{$practise['id']}}").html(prevHTML);   
            
            $(".showPreviousPractice_{{$practise['id']}}").css('pointer-events','none');
            $(".showPreviousPractice_{{$practise['id']}}").find('ul.list-buttons').remove();
            if(data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
              
              if(data23["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up" ||  data23["{{$practise['id']}}"]["dependant_practise_question_type"] == "single_speaking_up_writing") {
                $(".showPreviousPractice_{{$practise['id']}}").find('fieldset').remove();
              }
              if(data23["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero_parentextra_get_questions_and_answers" ||data23["{{$practise['id']}}"]["typeofdependingpractice"]== "set_full_view_remove_zero"){
                if( data23["{{$practise['id']}}"]["dependant_practise_question_type"] == "three_blank_table_speaking_up" ||  data23["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up" ||  data23["{{$practise['id']}}"]["dependant_practise_question_type"] == "single_speaking_up_writing") {
                  $(".showPreviousPractice_{{$practise['id']}}").find('fieldset').remove();
                }
              }
              
            }
            $('.cover-spin').fadeOut();
          });
        }
      }  
    }
  </script>
@elseif(empty($practise['is_dependent']) && $practise['is_roleplay']==1 )
<script>
    $(".form_{{$practise['id']}}").find(".selected_option").click(function() {
      
      var content_key = $(this).attr('data-key');
      var ans_count = $(this).attr('data-ans_count');
      var show_dependent_error = parseInt($(this).attr('data-show_dependent_error'));
      
      $(".form_{{$practise['id']}}").find('.selected_option').not(this).toggleClass('d-none');
      $(".form_{{$practise['id']}}").find('.selected_option_description_' + content_key).toggleClass('d-none');
      $(".form_{{$practise['id']}}").find('.selected_option_' + content_key).show();
      $(".form_{{$practise['id']}}").find(this).toggleClass('btn-bg');
      var answer_count = 0;
      $(".showPreviousPractice_{{$practise['id']}}").html("")
      if(ans_count>0) {
        answer_count = parseInt(ans_count)  ;
      }
      
      if ($(".form_{{$practise['id']}}").find('.selected_option_description:visible').length > 0) {
        
        $(".dependant_pr_{{$practise['id']}}").show(); 
        if( $('.audio_record'+answer_count).val()=="" ){
          // $('.submitBtn_{{$practise['id']}}' ).prop("disabled", true);
        } else {
          $('.submitBtn_{{$practise['id']}}' ).prop("disabled", false);
        }
        $(".form_{{$practise['id']}}").find('.is_roleplay_submit').val(0);
        var pid = "{{$practise['id']}}";
        if(pid == '15511967375c7562416dad0')
        {
           $(".form_{{$practise['id']}}").find('.submitBtn').attr('data-is_save', 1);
        }
        else
        {
           // alert('chnage o to 1');
           $(".form_{{$practise['id']}}").find('.submitBtn').attr('data-is_save', 1);
        }
      } else {
        $(".dependant_pr_{{$practise['id']}}").hide();
        $('.submitBtn_{{$practise['id']}}' ).prop("disabled", false);
        $(".showPreviousPractice_{{$practise['id']}}").html("")
        $(".form_{{$practise['id']}}").find('.is_roleplay_submit').val(1);
        $(".form_{{$practise['id']}}").find('.submitBtn').attr('data-is_save',1);
      }
    });
</script>
@else
<script>

function roleplayDependent(content_key,answer_count="0"){
  return true;
}
</script>
@endif
<script>
  var token         = $('meta[name=csrf-token]').attr('content');
  var upload_url    = "{{url('upload-audio')}}";
  var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
</script>
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
