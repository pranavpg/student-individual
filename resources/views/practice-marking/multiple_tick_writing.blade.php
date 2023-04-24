<?php

    $answerExists = false;
    $anscount = 0;
    if(isset($practise['user_answer']) && count($practise['user_answer'][0]) > 0)
    {
        $answerExists = true;
        $useranswer = $practise['user_answer'][0];
        foreach($practise['user_answer'][0] as $data){
            if($data['check']){
            $anscount++;

            }
        }
    }
?>
    <p>
      <strong>{{ $practise['title'] }}</strong>
    </p>
      <form class="save_multiple_tick_writing_form_{{$practise['id']}}">
      <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
      <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
      <input type="hidden" class="is_save" name="is_save" value="">
      <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
      <div class="true-false true-false__check">
      <?php $exploded_question  =  explode(PHP_EOL, $practise['question']); $i=0; $max_answer_counter = $exploded_question[0]; $question = explode("@@", $exploded_question[1]); ?>
      @php $i=1; @endphp
        @foreach($question as $key=> $item)

                <div class="box box-flex">
                    <div class="d-flex align-items-center">
                        <div class="box__left flex-grow-1">
                            <p>
                              {{ $i.")"  }}&nbsp;  {!! str_replace('5', '', $item) !!}
                            </p>
                        </div>
                        <div class="true-false_buttons d-flex justify-content-end w-10">
                            <div class="custom-control custom-checkbox custom-checkbox_single">
                                <input type="checkbox" class="custom-control-input multiTickWriting" id="cc{{$i}}" name="checkbox[]" value="{!! str_replace('5','', $item)!!}" {{ $answerExists == true ? ($useranswer[$key]['check']==true ? "checked" : "") : ""  }}>
                                <label class="custom-control-label" for="cc{{$i}}"></label>
                                <input type="hidden" name="useranswer[]" value="{!! str_replace('5','', $item)!!}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group w-100 {{ $answerExists == true ? ($useranswer[$key]['check']==true ? "" : "d-none") : "d-none"}}">
                        <span class="textarea form-control form-control-textarea"
                            role="textbox" contenteditable
                            placeholder="Write here...">{{ $answerExists == true ? $useranswer[$key]['text_ans'] : "" }} </span>
                            <div style="display:none">
                                <textarea name="text_ans[{{$key}}]">
                                    {{ $answerExists == true ? $useranswer[$key]['text_ans'] : ""}}
                                </textarea>
                            </div>
                    </div>
                </div>
              <?php $i++;?>
          @endforeach

      </div>

      <div class="alert alert-success" role="alert" style="display:none"></div>
      <div class="alert alert-danger" role="alert" style="display:none"></div>
        <ul class="list-inline list-buttons">
            <li class="list-inline-item">
            <!-- <a href="#!" class="btn btn-secondary"
                    data-toggle="modal" data-target="#exitmodal">Save</a> -->
                <input type="button" class="multiple_tick_writing_Btn_{{$practise['id']}} btn btn-secondary" value="Save" data-is_save="0">
            </li>
            <li class="list-inline-item">
            <input type="button" class="multiple_tick_writing_Btn_{{$practise['id']}} btn btn-secondary" value="Submit" data-is_save="1">

            </li>
        </ul>

  </form>
  
  <script>

var counter = 0; 
var new_counter  = 0; 
var max_counter = '<?php echo trim($max_answer_counter);?>';
var anscount = '<?php echo $anscount;?>';
new_counter =anscount; 
$(document).on('click', ".multiTickWriting", function (e) {
    if($(this).is(":checked")){
        new_counter++;
    }
    else if($(this).not(":checked")){
        new_counter--;
    }
    $(this).parent().parent().parent().parent().find('.form-group').toggleClass("d-none");

    if(new_counter > max_counter){
        alert('You are able to select only 5 questions with answers...');
        $(this).prop('checked', false);
        $(this).parent().parent().parent().parent().find('.form-group').toggleClass("d-none");
        new_counter--;
        return false;
    }
});

function setTextareaContent(){
    $(".save_multiple_tick_writing_form_{{$practise['id']}} span.textarea.form-control").each(function(){
        var currentVal = $(this).html();
        $(this).next().find("textarea").val(currentVal).html(currentVal);
    })
}
  $(document).on('click',".multiple_tick_writing_Btn_{{$practise['id']}}" ,function() {

    $(".multiple_tick_writing_Btn_{{$practise['id']}}").attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);
    setTextareaContent();
    $.ajax({
        url: "{{url('save-multiple-tick-writing')}}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $(".save_multiple_tick_writing_form_{{$practise['id']}}").serialize(),
        success: function (data) {
          $(".multiple_tick_writing_Btn_{{$practise['id']}}").removeAttr('disabled');

          if(data.success){
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
            $('.alert-success').show().html(data.message).fadeOut(4000);
          }else{
            $('.alert-success').hide();
            $('.alert-danger').show().html(data.message).fadeOut(4000);
          }

        }
    });

  });
</script>
<script src="{{ asset('public/js/audioplayer.js') }}"></script>
