<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
// echo '<pre>'; 
// dd($practise);
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
      $exploded_question = explode(PHP_EOL,$practise['question']);
    } 
?>
<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">

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
          <!-- /. box -->
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
              <!-- /. box -->
            @endforeach
          @endif

          <br/>
      </div>
      
      <div class="showPreviousPractice mb-4 {{!empty($practise['depending_practise_details']['question_type'])?$practise['depending_practise_details']['question_type']:''}} showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}">
      </div>

      <div class="alert alert-success" role="alert" style="display:none"></div>
      <div class="alert alert-danger" role="alert" style="display:none"></div>
      <ul class="list-inline list-buttons">
          <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn_{{$practise['id']}}"
                  data-toggle="modal" data-is_save="0" data-target="#exitmodal"  >Save</button>
          </li>
          <li class="list-inline-item"><button type="button"
                  class="submit_btn btn btn-primary submitBtn_{{$practise['id']}}" data-is_save="1"  >Submit</button>
          </li>
      </ul>
    </form>
        
    @endif

      @php
        $reviewPopup=true;
      @endphp
      @if(isset($practise["markingmethod"]) && $practise["markingmethod"] == "student_self_marking")

        @include('practice.common.student_self_marking')

      @endif
      @php
        $lastPractice=end($practises);
      @endphp
      @if($lastPractice['id'] == $practise['id'])
        @include('practice.common.review-popup')
      @else
        @php
          $reviewPopup=false;
        @endphp
      @endif
</div>
<script>
  if(data1==undefined ){
    var data1=[];
  }
  var token = $('meta[name=csrf-token]').attr('content');
  var upload_url = "{{url('upload-audio')}}";
  var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
  data1["{{$practise['id']}}"]= {"dependentpractice_ans": "{{$data[$practise['id']]['dependentpractice_ans']}}" };
  data1["{{$practise['id']}}"]["isRolePlayPractice"] = "{{$data[$practise['id']]['isRolePlayPractice']}}"
  data1["{{$practise['id']}}"]["is_dependent"] = "{{$data[$practise['id']]['is_dependent']}}"; 

  if(data1["{{$practise['id']}}"]["is_dependent"]==1){    
    if(data1["{{$practise['id']}}"]["dependentpractice_ans"]==0 ){
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


  $(document).on('click',".submitBtn_{{$practise['id']}}" ,function() {
    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }
    
    var reviewPopup = '{!!$reviewPopup!!}';
    var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
    if(markingmethod =="student_self_marking"){
        if($(this).attr('data-is_save') == '1'){


            var AllAudio = new Array();
            var checkAudioAva = new Array();
            $('.form_{{$practise['id']}} .main-audio-record-div').each(function(){

                if($(this).find(".practice_audio").children().attr("src").indexOf("sample-audio.mp3") !== -1) {
                  checkAudioAva.push("false");
                  // alert($(this).find('.audio-element').html());
                  AllAudio.push($(this).find('.audio-element').html())
                }else{
                  checkAudioAva.push("true");
                  AllAudio.push($(this).find(".practice_audio").children().attr("src"))
                }

            });


            var fullView= $(".form_{{$practise['id']}}").html();
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.modal-body').css("pointer-events","none !important");


            var tempInc = 0;
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.main-audio-record-div').each(function(){
                $(this).parent().prepend("<div class='append_"+tempInc+" myclass audio-player ' data="+tempInc+"></div>")
                tempInc++;
            });

            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.main-audio-record-div').each(function(){
              $(this).remove()
            }); 

            $.each(AllAudio,function(k,v){
              var audioTemp   = ' <audio preload="auto" controls class="practice_audio answer_audio-{{$practise['id']}}-'+k+'">\
                                <source src="'+v+'" type="audio/mp3">\
                            </audio>';
              var disableIcon = "";
              if(checkAudioAva[k] ==="true"){
                $('.append_'+k).append(audioTemp)
                disableIcon =false;
                Audioplay("{{$practise['id']}}",k,disableIcon);
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
    $(".submitBtn_{{$practise['id']}}").attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);

    $.ajax({
        url: "{{url('save-speaking-multiple-up')}}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
         data: $(".form_{{$practise['id']}}").serialize(),
        // data: $('.form_{{$practise["id"]}}').find(".showPreviousPractice:input:not(:input)").serialize(),
        success: function (data) {
          $(".submitBtn_{{$practise['id']}}").removeAttr('disabled');

          if(data.success){
            $('.form_{{$practise["id"]}}').find('.alert-danger').hide();
            $('.form_{{$practise["id"]}}').find('.alert-success').show().html(data.message).fadeOut(8000);
          } else {
            $('.form_{{$practise["id"]}}').find('.alert-success').hide();
            $('.form_{{$practise["id"]}}').find('.alert-danger').show().html(data.message).fadeOut(8000);
          }
        }
    });
  });
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
            $('.form_{{$practise["id"]}}').find('.alert-success').show().html(data.message).fadeOut(8000);
          } else {
            $('.form_{{$practise["id"]}}').find('.alert-success').hide();
            $('.form_{{$practise["id"]}}').find('.alert-danger').show().html(data.message).fadeOut(8000);
          }
        }
      });
    });
  </script>
@endif

@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==0 && $practise['typeofdependingpractice']!='get_answers_generate_quetions' )
<script>

  if(data1["{{$practise['id']}}"]["dependentpractice_ans"]==1 ){
    data1["{{$practise['id']}}"]["typeofdependingpractice"] = "{{ $data[$practise['id']]['typeofdependingpractice'] }}";
    data1["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
    if(data1["{{$practise['id']}}"]["typeofdependingpractice"] == "set_full_view_remove_top_zero" || data1["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data1["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data1["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data1["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data1["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data1["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data1["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view"){
    data1["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
    data1["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
        $(function () {
         $('.cover-spin').fadeIn();
        }); //issue in other practice spiner loop was continue 
      if(data1["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
        
        // IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
        if(data1["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
           //------STATIC--------------------
            let pid = "{{$practise['id']}}";
            if(pid == '15531823245c93ae744f5d8')
            {
             data1["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('.table-container').html();  
           
            }
            else
            {
               data1["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html(); 
            }      
            //-------STATIC------------------
            setTimeout(function(){ 
          
              $(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).html(data1["{{$practise['id']}}"]["prevHTML"]);
              $(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
              $(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('span.textarea').removeAttr('contenteditable');
              $('.cover-spin').fadeOut();
              $(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]+" .showPreviousPractice_reding_"+$('.reading-no-blanks_form').find('.depend_practise_id').val()).remove();
              $(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
              $(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert').remove();
              $(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find( 'input[type="hidden"]').remove();
              if( data1["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_top_zero"){
                if(data1["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_blanks") {
                    $(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('.match-answer').remove();
                } 
              }
              if(data1["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
                 if(data1["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_up_speaking_up" || data1["{{$practise['id']}}"]["dependant_practise_question_type"] == "two_blank_table_speaking_up") {
                  $(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
                } 
              }
              //----------------STATIC------
              if(pid == '15531823245c93ae744f5d8')
              {
                 $(".showPreviousPractice .audio-player").remove();
              }
              //------------------------------
              $('.cover-spin').fadeOut();
            }, 8000 ); 
        }
      } else {
              // IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
        // DO NOT REMOVE BELOW   CODE ==================== 
        var baseUrl = "{{url('/')}}";
        var p_id = "{{$practise['id']}}";
        data1["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
        data1["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data1["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data1["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data1["{{$practise['id']}}"]["dependant_practise_id"];
        $.get(data1["{{$practise['id']}}"]["dependentURL"],  //
          function (dataHTML, textStatus, jqXHR) {  // success callback
        
          if(  data1["{{$practise['id']}}"]["dependant_practise_id"]!==undefined){
            setTimeout(function(){ 
              data1["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
              $(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).html(data1["{{$practise['id']}}"]["prevHTML"]);
              $(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
              $(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, .alert').remove();
              $(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find( 'input[type="hidden"]').remove();

              if(p_id == "15563936215cc4ae957b8ea" || p_id == "15688118305d822b36876bc"){
                $(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').css('display','none');
              }


              $('.cover-spin').fadeOut();
              if(data1["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
              
                if(data1["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up" ||data1["{{$practise['id']}}"]["dependant_practise_question_type"] ==  "writing_at_end_up_speaking_up") {
                  $(document).find(".showPreviousPractice_"+data1["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
                }
              }
              $('.cover-spin').fadeOut();
            },8000, data1);  
          }
        });
        $.get("https://cdn.plyr.io/3.5.6/plyr.css");

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
  .showPreviousPractice.reading_no_blanks [contenteditable] {
    outline: 0px solid transparent;
  }

  .showPreviousPractice.reading_no_blanks *[contenteditable]:empty:before
  {
      content: "\feff"; /* ZERO WIDTH NO-BREAK SPACE */
  }

  .showPreviousPractice.reading_no_blanks .resizing-input1 {
    display: inline-flex; /* takes only the content's width */
    /*align-items: stretch; by default / takes care of the equal height among all flex-items (children) */
  }

  .showPreviousPractice.reading_no_blanks .appendspan {
    color:red;
  }

  .showPreviousPractice.reading_no_blanks .resizing-input1 > * {
      margin: 0 5px !important; /* just for demonstration */
  }
</style>