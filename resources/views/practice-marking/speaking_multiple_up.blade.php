<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
    $user_ans = "";
    $answerExists = false;
    if(isset($practise['user_answer']) && !empty($practise['user_answer'] && !empty($practise['user_answer'][0]))){
      $answerExists = true;
      if(!empty($practise['is_roleplay']) && $practise['is_roleplay']==1){
        $answers = $practise['user_answer'];
        $new_answer = array_values(array_filter($answers,
            function($item) {
              return strpos($item, '##') === false;
            }));
       // $practise['user_answer'] = $new_answer;
      }
    }
   // dd($practise);
  $data[$practise['id']] = array();
  $data[$practise['id']]['isRolePlayPractice'] = (!empty($practise['is_roleplay']) &&  $practise['is_roleplay']==1)?1:0;
  $data[$practise['id']]['typeofdependingpractice'] = !empty($practise['typeofdependingpractice']) ? $practise['typeofdependingpractice'] : "";
  $data[$practise['id']]['setFullViewFromPreviousPractice'] = !empty($practise['depending_practise_details']['dependant_practise_id']) ? $practise['depending_practise_details']['dependant_practise_id']:"";
  $data[$practise['id']]['dependant_practise_topic_id'] = !empty($practise['depending_practise_details']['dependant_practise_topic_id']) ? $practise['depending_practise_details']['dependant_practise_topic_id']:"";
  $data[$practise['id']]['dependant_practise_task_id'] = !empty($practise['depending_practise_details']['dependant_practise_task_id']) ? $practise['depending_practise_details']['dependant_practise_task_id']:"";
  $data[$practise['id']]['dependant_practise_question_type'] = !empty($practise['depending_practise_details']['question_type']) ? $practise['depending_practise_details']['question_type']:"";
  $data[$practise['id']]['dependentpractice_ans'] = !empty($practise['dependingpractise_answer'])?1:0;
  $data[$practise['id']]['is_dependent'] = !empty($practise['is_dependent']) ? 1 : 0;
  // echo "<pre>";
  // dd($practise);
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
      //dd('fgrg');
      $exploded_question = explode(PHP_EOL,$practise['question']);
    }
 
?>


<!-- if(!$answerExists) -->
<div class="previous_practice_answer_exists_{{$practise['id']}}" style="display:none">
    @if($data[$practise['id']]['typeofdependingpractice']=='set_full_view_hide_show')
      <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
        <a href="javascript:;" class="btn btn-dark selected_option_hide_show ">Show View</a>
      </div>

    @endif
   
    @if(!empty($practise['is_roleplay']) && $practise['is_roleplay']==1)

      @include('practice.speaking_multiple_up_roleplay')
    @else
         
    <form class="form_{{$practise['id']}}">
      <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
      <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
      <input type="hidden" class="is_save" name="is_save" value="">
      <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
      <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
      <input type="hidden" name="text_ans[0][path]" class="audio_path0">
       <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="speaking_multiple_up" value="0">
      <?php
        if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
          $depend =explode("_",$practise['dependingpractiseid']);
      ?>

        <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
        <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
      <?php } ?>
      @if($practise['type'] == "speaking_multiple_up")

          <input type="hidden" name="single_audio" value="true">
          <input type="hidden" name="user_answer[0][path]" class="audio_path{{0}}" value="{{!empty($practise['user_answer'])?$practise['user_answer'][0]:''}}">
          <input type="hidden" name="user_answer[0][audio_exists]" value="{{ !empty($practise['user_answer'][0])?1:0}}">
          @if($practise['id'] == '15566219665cc82a8ea2100' ||  $practise['id'] == '15566932945cc9412e4e968' ||  $practise['id'] == '15567003625cc95cca123e0' ||  $practise['id'] == '15567189105cc9a53e4526a' || $practise['id'] == '15506880815c6d9f510a1c9')
            @php
              $key = 0;
            @endphp
          @endif
          @include('practice.common.audio_record_div')

      @endif


      <?php
        $answerExists = false;

        if(!empty($practise['typeofdependingpractice']) && $practise['typeofdependingpractice']=='get_answers_generate_quetions') {

          if($practise['type']=='speaking_multiple_up'){
            if( !empty( $practise['dependingpractise_answer'][0] ) && is_array($practise['dependingpractise_answer'][0])){
              $exploded_question  =  $practise['dependingpractise_answer'][0];
            } 
          }  
        }
      
        if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
          $answerExists = true;
        }
      ?>
      <div class="multiple-choice">
          @if( !empty($exploded_question) )
            @foreach( $exploded_question as $key => $value )
              @if (str_contains($value, ' @@'))
                <div class="choice-box">
                    <p class="mb-0">{!! nl2br(str_replace(' @@', '', $value)) !!} </p>
                    <div class="form-group">
                        <span class="textarea form-control form-control-textarea"
                            role="textbox" contenteditable
                            placeholder="Write here...">
                            <?php
                              if ($answerExists)
                              {
                                  echo  nl2br($practise['user_answer'][0][$key]);
                              }
                            ?>
                          </span>
                          <div style="display:none">
                            <textarea name="user_answer[0][{{$key}}]">
                            <?php
                                if ($answerExists)
                                {
                                  echo  $practise['user_answer'][0][$key];
                                }
                            ?>
                            </textarea>
                          </div>
                    </div>
                </div>
              @else
                <p class="mb-0">{!! nl2br(str_replace(' @@', '', $value)) !!} </p>
              @endif
            @endforeach
          @endif
          <br/>
      </div>

      <div class="showPreviousPractice mb-4 {{!empty($practise['depending_practise_details']['question_type'])?$practise['depending_practise_details']['question_type']:''}} showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}">
      </div>
    </form>
    @endif
</div>
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
  } else{
    $(".previous_practice_answer_exists_{{$practise['id']}}").show();
      $("#dependant_pr_{{$practise['id']}}").hide();
  }
</script>
 @if(empty($practise['is_roleplay'])  )
<script>
   function Audioplay(pid,inc,flagForAudio){
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
</script>
@endif
@if(!empty($practise['is_roleplay']) && $practise['is_roleplay']==1 && $practise['type']=="speaking_multiple_listening")

  <script>
    $(document).on('click',".submitBtn_{{$practise['id']}}" ,function() {
      $(".submitBtn_{{$practise['id']}}").attr('disabled','disabled');
      var is_save = $(this).attr('data-is_save');
      $('.is_save:hidden').val(is_save);

      $.ajax({
        url: "{{url('save-speaking-multiple-listening')}}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $(".form_{{$practise['id']}}").serialize(),
        success: function (data) {
          $(".submitBtn_{{$practise['id']}}").removeAttr('disabled');

          if(data.success){
            $('.form_{{$practise["id"]}}').find('.alert-danger').hide();
            $('.form_{{$practise["id"]}}').find('.alert-success').show().html(data.message).fadeOut(4000);
          } else {
            $('.form_{{$practise["id"]}}').find('.alert-success').hide();
            $('.form_{{$practise["id"]}}').find('.alert-danger').show().html(data.message).fadeOut(4000);
          }
        }
      });
    });
  </script>
@endif
@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==0 && $practise['typeofdependingpractice']!='get_answers_generate_quetions' )
<script>
  if(data["{{$practise['id']}}"]["dependentpractice_ans"]==1 ){
  
    data["{{$practise['id']}}"]["typeofdependingpractice"] = "{{ $data[$practise['id']]['typeofdependingpractice'] }}";
    data["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
    if(data["{{$practise['id']}}"]["typeofdependingpractice"] == "set_full_view_remove_top_zero" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view"){
    data["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
    data["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
        $(function () {
         $('.cover-spin').fadeIn();
        }); //issue in other practice spiner loop was continue 
      if(data["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
        var pid= "{{$practise['id']}}";
        // IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
        if(data["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
            if(pid == "15511827105c752b76af488" || pid == "15566932945cc9412e4e968" || pid == "15506880815c6d9f510a1c9"){
              data["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('.previous_practice_answer_exists_'+data["{{$practise['id']}}"]["dependant_practise_id"]).html(); 
            }else if(pid=="15506880815c6d9f510a1c9"){
              data["{{$practise['id']}}"]["prevHTML"] = $(document).find('.save_writing_at_end_up_form_'+data["{{$practise['id']}}"]["dependant_practise_id"]).html();
            }
            else{
              data["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
            }
            console.log(data["{{$practise['id']}}"]["prevHTML"])
            setTimeout(function(){ 
              $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(data["{{$practise['id']}}"]["prevHTML"]);
              $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
              $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('span.textarea').removeAttr('contenteditable');
              $('.cover-spin').fadeOut();
              $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]+" .showPreviousPractice_reding_"+$('.reading-no-blanks_form').find('.depend_practise_id').val()).remove();
              $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
              $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert').remove();
              $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find( 'input[type="hidden"]').remove();
              if( data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_top_zero"){
                if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_blanks") {
                    $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.match-answer').remove();
                } 
              }
             

              if( data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
                 if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_up_speaking_up" || data["{{$practise['id']}}"]["dependant_practise_question_type"] == "two_blank_table_speaking_up") {
                  $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
                } 
              }
              $('.cover-spin').fadeOut();
            }, 4000 ); 
        }
      } else {
            
              // IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
        // DO NOT REMOVE BELOW   CODE ==================== 
        var baseUrl = "{{url('/')}}";
        var pid_1 = "{{$practise['id']}}";
        
        data["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
        data["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data["{{$practise['id']}}"]["dependant_practise_id"]+'&user_id={{ isset($studentId)?$studentId:'' }}';
        $.get(data["{{$practise['id']}}"]["dependentURL"],  //
          function (dataHTML, textStatus, jqXHR) {  // success callback
        
          if(  data["{{$practise['id']}}"]["dependant_practise_id"]!==undefined){
            setTimeout(function(){ 
                if("{{$practise['id']}}" == "15567003625cc95cca123e0"){
                    data["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).html();
                }
                else if("{{$practise['id']}}" == "15506880815c6d9f510a1c9"){
                 
                 }
                else{
                    data["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
                }
              $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(data["{{$practise['id']}}"]["prevHTML"]);
              $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
              $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, .alert').remove();
              $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find( 'input[type="hidden"]').remove();

              if(pid_1 =="15566932945cc9412e4e968"){
                $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
                $(document).find(".previous_practice_answer_exists_"+pid_1).find('form').css('pointer-events','auto');  
              }
              if(pid_1 =="15567003625cc95cca123e0"){
                $(document).find(".previous_practice_answer_exists_"+pid_1).find('form').css('pointer-events','auto'); 
              }

              $('.cover-spin').fadeOut();
              if(data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
              
                if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up" ||data["{{$practise['id']}}"]["dependant_practise_question_type"] ==  "writing_at_end_up_speaking_up") {
                  $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
                }
              }
              $('.cover-spin').fadeOut();
            },4000, data);  
          }
        });
        //$.get("https://cdn.plyr.io/3.5.6/plyr.css");

      }
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
<style type="text/css">
  .showPreviousPractice.reading_no_blanks *[contenteditable]:empty:before
  {
      content: "\feff"; /* ZERO WIDTH NO-BREAK SPACE */
  }
  .showPreviousPractice.reading_no_blanks .appendspan {
    color:red;
  }
</style>