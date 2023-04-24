<p><strong>{!! $practise['title'] !!}</strong>

@if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid']))
    @php  $depend =explode("_",$practise['dependingpractiseid']); @endphp
    <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;" data-value="{{$practise['id']}}">
        <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
    </div>
@endif
<form class="save_hide_show_answer_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
    <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">

    <div class="true-false appendQue_{{$practise['id']}}">
    </div>

    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
    <ul class="list-inline list-buttons">
    <li class="list-inline-item">
        <input type="button" class="save_btn submitBtn_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
        </li>
        <li class="list-inline-item">
        <input type="button" class="submit_btn submitBtn_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">
        </li>
    </ul>
</form>

<script type="text/javascript">
var feedbackExits = "<?php echo $feedbackExits; ?>";
$(document).on("click", ".btn-ShowHide", function () {
    $(this).parent().parent().find('.box__left__hiddenContent').slideToggle();
    $(this).toggleClass('btn-primary');
    $(this).toggleClass('btn-dark');
    $(".btn-ShowHide.btn-dark").text("Hide Password");
    $(".btn-ShowHide.btn-primary").text("Show Password");

});

var practise_id = $(".save_hide_show_answer_form_{{$practise['id']}}").find('.depend_practise_id').val();

if(practise_id){
    getDependingPractise()
} else{
    $('.save_hide_show_answer_form_{{$practise["id"]}}').show();
}


function getDependingPractise(){

    var topic_id= $(".save_hide_show_answer_form_{{$practise['id']}}").find('.topic_id').val();
    var task_id=$(".save_hide_show_answer_form_{{$practise['id']}}").find('.depend_task_id').val();
    var practise_id=$(".save_hide_show_answer_form_{{$practise['id']}}").find('.depend_practise_id').val();

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
          console.log('===>',JSON.stringify(data))

            if(data.question!=null && data.question!=undefined){

              $('.save_hide_show_answer_form_{{$practise["id"]}}').show();
              $('#dependant_pr_{{$practise['id']}}').hide();
              var question = data.question;
              var answer = data.user_Answer[0];
              var question_array = question.split(':');

              if(data.dependent_user_Answer[0].length>0){
                var appendQue="";
                data.dependent_user_Answer[0].forEach((item, i) => {
                  if(item.trim()!=""){

                      appendQue +=  `<div class="box box-flex d-flex align-items-start">
                        <div class="box__left flex-grow-1">
                              <p>`+(i+1)+`. `+item+`</p>
                            <div class="box__left__hiddenContent">
                                <p>Answer : `+data.user_Answer[0][i]+`</p>
                            </div>
                        </div>
                        <div class="true-false_buttons">
                            <a href="javascript:void(0)" class="btn btn-ShowHide btn-primary ">Show
                                Answer</a>
                        </div>
                      </div>`;

                  }

                });
                $('.appendQue_{{$practise["id"]}}').html(appendQue)
              }

            } else {
              $('.save_hide_show_answer_form_{{$practise["id"]}}').hide();
              $('#dependant_pr_{{$practise['id']}}').show();
            }

        }
    });
}
$(document).on('click',".submitBtn_{{$practise['id']}}" ,function() {
    
      if($(this).attr('data-is_save') == '1'){
                $(this).closest('.active').find('.msg').fadeOut();
            }else{
                $(this).closest('.active').find('.msg').fadeIn();
            }
       var isSubmit = $(this).attr('data-is_save')
    $(".submitBtn_{{$practise['id']}}").attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);

    $.ajax({
        url: "{{ route('save-hide-show-answer') }}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $(".save_hide_show_answer_form_{{$practise['id']}}").serialize(),
        success: function (data) {
            if(isSubmit == '1'){
                if(feedbackExits==""){
                    $('#course-feedback-init-mid').modal("show")
                    $('#course-feedback-init-mid').find('#feedback-form-modalLabel').text('ELT MID-COURSE FEEDBACK FORM')
                }
            }
            $(".submitBtn_{{$practise['id']}}").removeAttr('disabled');
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
</script>
