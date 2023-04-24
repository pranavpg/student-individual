
        <p>
          <strong><?php
          echo $practise['title'];
          // echo "<pre>";
          // print_r($practise); 
          ?></strong>
        </p>
          <form class="save_multi_choice_multipul_question_form_{{$practise['id']}}">
          <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
          <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
          <input type="hidden" class="is_save" name="is_save" value="">
          <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
          <?php // echo '<pre>'; print_r($practise['user_answer']);
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
                    <p><?php echo str_replace('@@',"<span id='span_multi_choice_$key'></span>",$question) ?></p>
                    <?php $i=0 ?>
                    <div class="multiple-check w-75 mb-4 d-flex flex-wrap mb-0">
                     <?php
                     $userAnswer=array();
                      if(isset($practise['user_answer'][0][$key]['ans']) && !empty($practise['user_answer'][0][$key]['ans'])){
                        //$userAnswer= explode(":",$practise['user_answer'][0][$key]['ans']);
                        $userAnswer = $practise['user_answer'][0][$key]['ans_pos'];
                      }
                     ?>
                      @foreach($practise['options'][$key] as $k=>$value)

                      <div class="custom-control custom-checkbox mb-1 w-25">
                          <input type="checkbox" class="custom-control-input" id="cc{{$key}}{{$k}}" name="user_answer[{{$key}}][]" value="{{$i.'@@'.$value}}" <?php if(!empty($userAnswer) && (in_array($k, $userAnswer))){ echo "checked";}?>>
                          <label class="custom-control-label" for="cc{{$key}}{{$k}}">{{$value}}</label>

                      </div>
                      <?php $i++; ?>
                      @endforeach
                      <input type="hidden" name="user_default_answer[]" value="-1" >

                  </div>
                </div>
                @endforeach
      </div>
      </form>
      <script src="{{ asset('public/js/audioplayer.js') }}"></script>
      <script>
      $( document ).ready(function() {
        var practise_id=$(".save_multi_choice_multipul_question_form_{{$practise['id']}}").find('.depend_practise_id').val();
        if(practise_id){
            var x = getDependingPractise() ;

        }


        function getDependingPractise(){

          var topic_id= $(".save_multi_choice_multipul_question_form_{{$practise['id']}}").find('.topic_id').val();
          var task_id=$(".save_multi_choice_multipul_question_form_{{$practise['id']}}").find('.depend_task_id').val();
          var practise_id=$(".save_multi_choice_multipul_question_form_{{$practise['id']}}").find('.depend_practise_id').val();

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
