<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
<?php //echo '<pre>'; print_r($practise);?>
    <p>
      <strong>{!! $practise['title'] !!}</strong>
    </p>

      <form class="multi_choice_question_speaking_up_{{$practise['id']}}">
        <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
        <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
        <input type="hidden" class="is_save" name="is_save" value="">
        <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
        <input type="hidden" class="practice_type" name="practice_type" value="multi_choice_question_speaking_up">
        <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="audio_reading" value="0">
        <?php  //echo '<pre>'; print_r($practise);
            if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
            $depend =explode("_",$practise['dependingpractiseid']);

          ?>
           <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
           <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
          <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
                <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
          </div>
     <?php } ?>
      @if($practise['type'] == "multi_choice_question_speaking_up")
        @include('practice.common.audio_record_div')
      @endif

      <?php $exploded_question  =  explode("@@", $practise['question']); $i=1;?>
      <div class="multiple-choice multiple-check " id="multipul_check_{{$practise['id']}}">

        <?php
          $exploded_question  =  explode(PHP_EOL, $practise['question']); $i=0;
        ?>
        @foreach($exploded_question as $key => $question)
        <div class="choice-box ">
            <p><?php echo str_replace('@@',"<span id='span_multi_choice_$key'></span>",$question) ?>
            </p>
            <?php $i=0 ?>
            <div class="d-flex">
              @foreach($practise['options'][$key] as $k=>$value)
                <div class="custom-control custom-radio w-33">
                    <input type="radio" class="custom-control-input" id="cc{{$key}}{{$k}}" name="user_answer[{{$key}}]" value="{{$i++.'@@'.$value}}" {{ isset($practise['user_answer'][0]['text_ans'][$key]['ans']) && !empty($practise['user_answer'][0]['text_ans'][$key]['ans']) && $practise['user_answer'][0]['text_ans'][$key]['ans'] == $value ?  'checked' :  " " }}>
                    <label class="custom-control-label" for="cc{{$key}}{{$k}}">{{$value}}</label>
                </div>
              @endforeach
              <input type="hidden" name="user_default_answer[]" value="-1" >

          </div>
        </div>
        <!-- /. Choice Box -->
        @endforeach

      </div>


            <div class="alert alert-success" role="alert" style="display:none"></div>
            <div class="alert alert-danger" role="alert" style="display:none"></div>
            <ul class="list-inline list-buttons">
                <li class="list-inline-item">
                <input type="button" class="save_btn multiTickBtn_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
                </li>
                <li class="list-inline-item">
                <input type="button" class="submit_btn multiTickBtn_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">
                </li>
            </ul>

  </form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
@if($practise['type'] == 'multi_choice_question_speaking_up')
<script>
    jQuery(function ($) {
            'use strict'
            var supportsAudio = !!document.createElement('audio').canPlayType;
            if (supportsAudio) {
                // initialize plyr
                var i;

                   var player = new Plyr("#audio_{{$practise['id']}}", {
                    controls: [

                        'play',
                        'progress',
                        'current-time',

                    ]
                });


            } else {
                // no audio support
                $('.column').addClass('hidden');
                var noSupport = $('#audio1').text();
                $('.container').append('<p class="no-support">' + noSupport + '</p>');
            }
        });
</script>

<script>

    var token = $('meta[name=csrf-token]').attr('content');
    var upload_url = "{{url('upload-audio')}}";
    var workerDirPath = "{{asset('public/js/audio-recorder/')}}";

      // $('.delete-icon').on('click', function() {
      //     $(this).parent().find('.stop-button').hide();
      //     $(this).parent().find('.practice_audio').attr('src','');
      //     $(this).parent().find('.audioplayer-bar-played').css('width','0%');
      //   $(this).hide();
      //   $(this).parent().find('div.audio-element').css('pointer-events','none');
      //     $(this).parent().find('.record-icon').show();
      //     $(this).parent().find('.stop-button').hide();
      //     var practise_id = $('.practise_id:hidden').val();
      //     var audio_key= $(this).attr('data-key');
      //     $.ajax({
      //             url: 'delete-audio',
      //             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      //             type: 'POST',
      //             data: {practice_id:practise_id, 'audio_key':audio_key},
      //             success: function (data) {
      //
      //             }
      //     });
      // });
  </script>

@endif

  <script>
// $(function () {
//           $('audio').audioPlayer();

//       });
//       function setTextareaContent(){
//       $("span.textarea.form-control").each(function(){
//         var currentVal = $(this).html();
//         $(this).next().find("textarea").val(currentVal);
//       })
//     }

  $(document).on('click',".multiTickBtn_{{$practise['id']}}" ,function() {
        // console.log($(".multi_choice_question_speaking_up_{{$practise['id']}}").serialize());
        // console.log('{{url('save-multi-choice-question-speaking-up')}}');
        // return false;
        $(".multiTickBtn_{{$practise['id']}}").attr('disabled','disabled');
        var is_save = $(this).attr('data-is_save');
        $('.is_save:hidden').val(is_save);

        $.ajax({
            url: "{{url('save-multi-choice-question-speaking-up')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: $(".multi_choice_question_speaking_up_{{$practise['id']}}").serialize(),
            success: function (data) {
              $(".multiTickBtn_{{$practise['id']}}").removeAttr('disabled');

              if(data.success){
                $('.alert-danger').hide();
                $('.alert-success').show().html(data.message).fadeOut(8000);
              }else{
                $('.alert-success').hide();
                $('.alert-danger').show().html(data.message).fadeOut(8000);
              }

            }
        });

      });

$( document ).ready(function() {
        //debugger;
        var practise_id=$(".multi_choice_question_speaking_up_{{$practise['id']}}").find('.depend_practise_id').val();
        if(practise_id){
            var x = getDependingPractise();
        }


        function getDependingPractise(){

          var topic_id= $(".multi_choice_question_speaking_up_{{$practise['id']}}").find('.topic_id').val();
          var task_id=$(".multi_choice_question_speaking_up_{{$practise['id']}}").find('.depend_task_id').val();
          var practise_id=$(".multi_choice_question_speaking_up_{{$practise['id']}}").find('.depend_practise_id').val();

              $.ajax({
                  url: "{{url('get-student-practisce-answer')}}",
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  type: 'POST',
                  data:{
                      topic_id,
                      task_id,
                      practise_id
                  },
                  dataType:'JSON',
                  success: function (data) {
                      if(data['success'] == false){
                        $("#dependant_pr_{{$practise['id']}}").css("display", "block");
                        $("#multipul_check_{{$practise['id']}}").css("display", "none");
                      }else{
                        $("#dependant_pr_{{$practise['id']}}").css("display", "none");
                        $("#multipul_check_{{$practise['id']}}").css("display", "block");
                      }
                      var result =  document.location +data;
                      var res = result.split(";");
                      var i =0;
                      $.each(res, function( index, value ) {
                          if(value !==""){
                              value = value.replace(document.location, "");
                              // alert( value );
                              $("#span_multi_choice_"+i).html("<b><font color = '#03A9F4'>"+value+"</font></b>");
                              $("#dependan_answer_"+i).val("<b><font color = '#03A9F4'>"+value+"</font></b>");
                              i= i+1;
                          }

                      });
                  }
              });
        }



    });
</script>
<script src="{{ asset('public/js/audioplayer.js') }}"></script>
