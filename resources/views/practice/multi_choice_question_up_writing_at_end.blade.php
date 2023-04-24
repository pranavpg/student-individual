<p><strong><?php echo $practise['title']; ?></strong></p>

<style>
.multi_choice_question_writing_end .custom-checkbox .custom-control-label:before {
    border-color: #007bff;
    background-color: #fff !important;
}

.multi_choice_question_writing_end .multiple-check .custom-control-input:checked~.custom-control-label:after, .multiple-check .custom-control-input:checked~.custom-control-label:before {
    border-color: #d55b7d !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    outline: none !important;
    background-color: #d55b7d !important;
    background-image: url(https://s3.amazonaws.com/imperialenglish.co.uk/ieukstudentpublic/images/icon-custom-check.svg) !important;
    background-position: center !important;
    background-repeat: no-repeat !important;
    background-size: 18px auto !important;
}
</style>
      <form class="multi_choice_question_writing_end save_multi_choice_question_writing_end_form_{{$practise['id']}}">
          <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
          <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
          <input type="hidden" class="is_save" name="is_save" value="">
          <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
          @if( !empty( $practise['audio_file'] ) )
         
					  @include('practice.common.audio_player')
					@endif
          <?php //echo '<pre>'; print_r($practise);
          $answerExists = false;
          if(!empty($practise['user_answer'])){
              $answerExists = true;
            }
          if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
            $depend =explode("_",$practise['dependingpractiseid']);

            ?>
             <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
             <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">

        <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
                <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
          </div>
       <?php } ?>
          <div class="multiple-choice multiple-check " id="multipul_check_{{$practise['id']}}">

          <?php
          $exploded_question  =  explode(PHP_EOL, $practise['question']); $i=0;
         // echo '<pre>'; print_r($exploded_question);
          ?>

          @foreach($exploded_question as $key => $question)
                <div class="multiple-choice">
                    <p><?php
                    if($practise['type'] == "multi_choice_question_up_writing_at_end"){
                      echo str_replace('@@',"<span id='span_multi_choice_$key'></span>",$question) ;
                    }
                    ?>

                    <?php $i=0 ?>
                    @if( $practise['type'] == "multi_choice_question_writing_at_end_up_listening")
                    <!-- <div class="d-flex align-items-start form-group form-group__custom mb-3">
                                                <span class="mr-2"><strong>1)</strong></span>
                                                <span class="textarea form-control " role="textbox" contenteditable
                                                    placeholder="Write here..."></span>
                                            </div> -->
                      <div class="d-flex align-items-start form-group form-group__custom mb-3">
                      <span class="mr-2"><strong><?php echo str_replace('.'," ",$question) ?></strong></span>
                                                <span class="textarea form-control form-control-textarea stringProper text-left" role="textbox"
                                                    contenteditable placeholder="Write here..."> <?php
                                if ($answerExists)
                                {
                                  echo  $practise['user_answer'][0][$key]['text_ans'];
                                }
                            ?></span>
                             <div style="display:none">
                           <textarea name="writingBox[{{$key}}]">
                            <?php
                                if ($answerExists)
                                {
                                  echo  $practise['user_answer'][0][$key]['text_ans'];
                                }
                            ?>
                        </textarea>
                      </div>
                      </div>
                    @endif</p>
                    <div class="multiple-check d-flex flex-wrap mb-0">
                      @foreach($practise['options'][$key] as $k=>$value)

                      <div class="custom-control custom-checkbox w-33">
                          <input type="radio" class="custom-control-input" id="cc{{$key}}{{$k}}" name="user_answer[{{$key}}]" value="{{$i++.'@@'.$value}}" {{ isset($practise['user_answer'][0][$key]['ans']) && !empty($practise['user_answer'][0][$key]['ans']) && $practise['user_answer'][0][$key]['ans'] == $value ?  'checked' :  " " }}>
                          <label class="custom-control-label" for="cc{{$key}}{{$k}}">{{$value}}</label>

                      </div>
                      @endforeach
                      </div>
                     @if($practise['type'] == "multi_choice_question_up_writing_at_end")
                     <div class="form-group">
                                                <span class="textarea form-control form-control-textarea stringProper text-left" role="textbox"
                                                    contenteditable placeholder="Write here..."> <?php
                                if ($answerExists)
                                {
                                  echo  $practise['user_answer'][0][$key]['text_ans'];
                                }
                            ?></span>
                             <div style="display:none">
                           <textarea name="writingBox[{{$key}}]">
                            <?php
                                if ($answerExists)
                                {
                                  echo  $practise['user_answer'][0][$key]['text_ans'];
                                }
                            ?>
                        </textarea>
                      </div>
                      </div>
                     @endif

                      <input type="hidden" name="user_default_answer[]" value="-1" >


                </div>
                <!-- /. Choice Box -->
                @endforeach

<!--
            </div>
      <div id="multi_choice_btn_{{$practise['id']}}" style="display:block">         -->

        <div class="alert alert-success" role="alert" style="display:none"></div>
				<div class="alert alert-danger" role="alert" style="display:none"></div>
        <ul class="list-inline list-buttons">
            <li class="list-inline-item">
              <!-- <a href="#!" class="btn btn-primary"
                    data-toggle="modal" data-target="#exitmodal">Save</a> -->
                    <input type="button" class="save_btn multiChoiceQwritingEndBtn_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
            </li>
            <li class="list-inline-item">
             <input type="button" class="submit_btn multiChoiceQwritingEndBtn_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">

            </li>
        </ul>
      </div>
      </form>
      <script src="{{ asset('public/js/audioplayer.js') }}"></script>
      <script>
    // $(function () {
    //           $('audio').audioPlayer();

    //       });
          function setTextareaContent(){
          $("span.textarea.form-control").each(function(){
            var currentVal = $(this).html();
           
            var regex = /<br\s*[\/]?>/gi;
            currentVal=currentVal.replace(regex, "\n");
            var regex = /<div\s*[\/]?>/gi;
            currentVal=currentVal.replace(regex, "\n");
            var regex = /<\/div\s*[\/]?>/gi;
            currentVal=currentVal.replace(regex, "");
            var regex = /&nbsp;/gi;
            currentVal=currentVal.replace(regex, "");

            $(this).next().find("textarea").val(currentVal);
          })
        }
      $(document).on('click',".multiChoiceQwritingEndBtn_{{$practise['id']}}" ,function() {

          if($(this).attr('data-is_save') == '1'){
              $(this).closest('.active').find('.msg').fadeOut();
          }else{
              $(this).closest('.active').find('.msg').fadeIn();
          }

          
        $(".multiChoiceQwritingEndBtn_{{$practise['id']}}").attr('disabled','disabled');
        var is_save = $(this).attr('data-is_save');
        $('.is_save:hidden').val(is_save);
         setTextareaContent();
        $.ajax({
            url: "{{url('save-multi-choice-writing-at-end')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: $(".save_multi_choice_question_writing_end_form_{{$practise['id']}}").serialize(),
            success: function (data) {
              $(".multiChoiceQwritingEndBtn_{{$practise['id']}}").removeAttr('disabled');

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
        var practise_id=$(".save_multi_choice_question_writing_end_form_{{$practise['id']}}").find('.depend_practise_id').val();
        if(practise_id){
            var x = getDependingPractise() ;

        }


        function getDependingPractise(){

          var topic_id= $(".save_multi_choice_question_writing_end_form_{{$practise['id']}}").find('.topic_id').val();
          var task_id=$(".save_multi_choice_question_writing_end_form_{{$practise['id']}}").find('.depend_task_id').val();
          var practise_id=$(".save_multi_choice_question_writing_end_form_{{$practise['id']}}").find('.depend_practise_id').val();

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
                        //  $("#multi_choice_btn_{{$practise['id']}}}").css("display", "none");
                      }else{
                        $("#dependant_pr_{{$practise['id']}}").css("display", "none");
                        $("#multipul_check_{{$practise['id']}}").css("display", "block");
                        // $("#multi_choice_btn_{{$practise['id']}}").css("display", "block");
                      }
                      var result =  document.location +data.user_Answer;

                    //   console.log('====>',data);
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
