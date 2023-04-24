<p><strong><?php echo $practise['title']; ?></strong> </p>
<?php
// pr($practise);
?>
  <form class="save_true_false_a_g_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
      <?php
          if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
              $depend =explode("_",$practise['dependingpractiseid']);
              ?>
               <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
               <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
               <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
                  <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
              </div>
              <?php

          }

          $exploded_question=array();
          if(!empty($practise['question'])){
              $exploded_question  =  explode(PHP_EOL,$practise['question']);
          }

          $i=0;
// echo '<pre>'; print_r($exploded_question); 

      ?>
      <div class="true-false true-false_withoutBefore" id="true_false_{{$practise['id']}}">

        @foreach($exploded_question as $key => $item)
          <div class="box box-flex align-items-center">
            <div class="box__left flex-grow-1">
                <p> <?php 
                // echo str_replace('@@',"<span id='span_true_false'></span>",$item) 
                if(str_contains($item,'@@')){
                  $outValue = preg_replace_callback('/@@/',
                  function ($m) use (&$key, &$count, &$item) {
                    // $ans= !empty($exp_answer[$count])?trim(str_replace('_','',$exp_answer[$count])):"";
                    $count++;
                    $str = '<span id="span_true_false_'.$count.'"></span><input type="hidden" name="dependan_answer[]" id="dependan_answer_'.$count.'" value="'.$item.'">';
                    return $str;
                  }
                  , $item);

                }
                ?> {!! $outValue !!}</p>
                <input type="hidden" name="user_question[]" value="{{$item}}">
                
            </div>
            <div class="true-false_buttons">
              <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="true_false[{{$key}}]" id="inlineRadioTrue{{$key}}" value="1" {{ isset($practise['user_answer'][0][$key]['true_false']) && !empty($practise['user_answer'][0][$key]['true_false']) && $practise['user_answer'][0][$key]['true_false'] == '1' ?  'checked' :  " " }} >
                  <label class="form-check-label" for="inlineRadioTrue{{$key}}">A</label>
              </div>
              <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="true_false[{{$key}}]" id="inlineRadioFalse{{$key}}" value="0" {{ isset($practise['user_answer'][0][$key]['true_false'])  && $practise['user_answer'][0][$key]['true_false'] == '0' ?  'checked' :  '' }} >
                  <label class="form-check-label" for="inlineRadioFalse{{$key}}">G</label>
              </div>
            </div>
          </div>
          <!-- <?php //$i++; ?> -->
          <!-- /. box -->
        @endforeach


        <div class="alert alert-success" role="alert" style="display:none"></div>
        <div class="alert alert-danger" role="alert" style="display:none"></div>
        <!-- <ul class="list-inline list-buttons">
          <li class="list-inline-item">
            <a href="#!" class="btn btn-secondary"
                  data-toggle="modal" data-target="#exitmodal">Save</a>
                  <input type="button" class="true_false_ag_btn_{{$practise['id']}} btn btn-secondary" value="Save" data-is_save="0">
          </li>
          <li class="list-inline-item">
           <input type="button" class="true_false_ag_btn_{{$practise['id']}} btn btn-secondary" value="Submit" data-is_save="1">

          </li>
        </ul> -->
      </div>

</form>

      <script>

      $(document).on('click',".true_false_ag_btn_{{$practise['id']}}" ,function() {
        $(".true_false_ag_btn_{{$practise['id']}}").attr('disabled','disabled');
        var is_save = $(this).attr('data-is_save');
        $('.is_save:hidden').val(is_save);
        // setTextareaContent();
        $.ajax({
            url: "{{url('save-true-false-a-g')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: $(".save_true_false_a_g_form_{{$practise['id']}}").serialize(),
            success: function (data) {
              $(".true_false_ag_btn_{{$practise['id']}}").removeAttr('disabled');

                // $('.alert-success').show().html(data.message).fadeOut(4000);
                if(data.success){
					$(".save_true_false_a_g_form_{{$practise['id']}}").find('.alert-danger').hide();
					$(".save_true_false_a_g_form_{{$practise['id']}}").find('.alert-success').show().html(data.message).fadeOut(4000);
				} else {
					$(".save_true_false_a_g_form_{{$practise['id']}}").find('.alert-success').hide();
					$(".save_true_false_a_g_form_{{$practise['id']}}").find('.alert-danger').show().html(data.message).fadeOut(4000);
				}
            }
        });

      });
      $( document ).ready(function() {
        var practise_id=$(".save_true_false_a_g_form_{{$practise['id']}}").find('.depend_practise_id').val();
        if(practise_id){
            var x = getDependingPractise() ;

        }


        function getDependingPractise(){

          var topic_id= $(".save_true_false_a_g_form_{{$practise['id']}}").find('.topic_id').val();
          var task_id=$(".save_true_false_a_g_form_{{$practise['id']}}").find('.depend_task_id').val();
          var practise_id=$(".save_true_false_a_g_form_{{$practise['id']}}").find('.depend_practise_id').val();

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
                        // $("#dependant_pr_{{$practise['id']}}").css("display", "block");
                        // $("#true_false_{{$practise['id']}}").css("display", "none");

                      }else{
                        $("#dependant_pr_{{$practise['id']}}").css("display", "none");
                        $("#true_false_{{$practise['id']}}").css("display", "block");

                      }
                      // console.log('data=======+>',data.user_Answer[0]);
                      var result =  document.location +data.user_Answer[0];
                      var res = result.split(";");

                    var i =1;
                    $.each(res, function( index, value ) {
                        if(value !==""){
                            value = value.replace(document.location, "");
                            // alert( value );
                          // console.log(value);
                          $("#span_true_false_"+i).html("<b><font color = '#03A9F4'>"+value+"</font></b>&nbsp;");
                            $("#dependan_answer_"+i).val("<b><font color = '#03A9F4'>"+value+"</font></b>&nbsp;");
                            i= i+1;
                        }

                    });
                  }
              });
        }



    });

</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<!-- <script src="{{ asset('public/js/audioplayer.js') }}"></script> -->
