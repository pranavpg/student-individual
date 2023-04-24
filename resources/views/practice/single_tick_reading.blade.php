<p><strong>{{ $practise['title'] }}</strong></p>
<form class="save_single_tick_reading_form_{{$practise['id']}}">
<input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
<input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
<input type="hidden" class="is_save" name="is_save" value="">
<input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">     
@if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid']))
    @php
    $exploded_question  =  explode("#@", $practise['question']); $i=1;
    $depend = explode("_",$practise['dependingpractiseid']); 
    @endphp
@endif 

<input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
<input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
<div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
<p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
</div>    

     <div  id="single_tick_reading_{{$practise['id']}}">
     <div class="tab-pane fade show active" id="abc-b" role="tabpanel"
                                        aria-labelledby="abc-b-tab">
                                        
                                        <!--Component Form Slider-->
                                        <div class="form-slider p-0 mb-4">
                                            <div class="component-control-box">
                                            <input type="text"  id="span_text_ans" class="textarea form-control form-control-textarea" role="textbox"
                    contenteditable placeholder="Write here..." name="text_ans" readonly="">
                                            </div>
                                        </div>

                                        <!--Component Form Slider End-->
                                        <div class="multiple-choice mb-4">
                                            <p>
                                            {!! $exploded_question[1] !!}
                                            </p>                                            
                                        </div>
                                        <div class="multiple-check d-flex flex-wrap mb-5">
                                            <div class="w-33"></div>
                                                    <div class="w-25 true-false_buttons-aes">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="checked" id="inlineRadio1"  value="Correct" {{ isset($practise['user_answer'][0][0]['checked']) && !empty($practise['user_answer'][0][0]['checked']) == 'true' ?  'checked' :  " " }}/>
                                                            <label class="form-check-label form-check-label_true"
                                                                for="inlineRadio1">Correct</label>
                                                        </div>
                                                    </div>
                                                    <div class="w-25 true-false_buttons-aes">
                                                        <div class="form-check form-check-inline">
                
                                                            <input class="form-check-input" type="radio"
                                                                name="checked" id="inlineRadio2"  value="Incorrect" {{ isset($practise['user_answer'][0][1]['checked']) && !empty($practise['user_answer'][0][1]['checked']) == 'true' ?  'checked' :  " " }} />
                                                            <label class="form-check-label form-check-label_true"
                                                                for="inlineRadio2">Incorrect</label>
                                                        </div>
                                                    </div>
                                        </div>
                    <div class="alert alert-success" role="alert" style="display:none"></div>
                    <div class="alert alert-danger" role="alert" style="display:none"></div>
            <ul class="list-inline list-buttons">
            <li class="list-inline-item">
                <input type="button" class="save_btn single_tick_reading_form_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
                </li>
                <li class="list-inline-item">
                <input type="button" class="submit_btn single_tick_reading_form_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">
                </li>
            </ul>
        </div>
</form>

<script type="text/javascript">
    /* record_video jquery save */         
$(document).on('click',".single_tick_reading_form_{{$practise['id']}}" ,function() {

    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }
        

        
    $(".single_tick_reading_form_{{$practise['id']}}").attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);

    $.ajax({
        url: "{{ route('save-single-tick-reading-diff') }}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $(".save_single_tick_reading_form_{{$practise['id']}}").serialize(),
        success: function (data) {  
            $(".save_single_tick_reading_form_{{$practise['id']}}").removeAttr('disabled');
            $("input").removeAttr('disabled');
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
        var practise_id=$(".save_single_tick_reading_form_{{$practise['id']}}").find('.depend_practise_id').val();
        if(practise_id){
            var x = getDependingPractise() ;

        }

        function getDependingPractise(){

          var topic_id = $(".save_single_tick_reading_form_{{$practise['id']}}").find('.topic_id').val();
          var task_id=$(".save_single_tick_reading_form_{{$practise['id']}}").find('.depend_task_id').val();
          var practise_id=$(".save_single_tick_reading_form_{{$practise['id']}}").find('.depend_practise_id').val();

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
                        $("#single_tick_reading_{{$practise['id']}}").css("display", "none");
                        $("#audio_plyr_{{$practise['id']}}").css("display", "none");
                      }else{
                        $("#dependant_pr_{{$practise['id']}}").css("display", "none");
                        $("#single_tick_reading_{{$practise['id']}}").css("display", "block");
                        $("#audio_plyr_{{$practise['id']}}").css("display", "block");
                      }
                      
                       console.log('====>',data['user_Answer'][0]['text_ans'][0]);


                       $("#span_text_ans").val(data['user_Answer'][0]['text_ans'][0]);

                  }
              });
        }

    });

</script>