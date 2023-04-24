<p><strong>{!! $practise['title'] !!}</strong>
@if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid']))
    @php  $depend =explode("_",$practise['dependingpractiseid']); @endphp
    <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;" data-value="{{$practise['id']}}">
        <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
    </div>
@endif
@php
    $answerExists = false;
@endphp
@if(isset($practise['user_answer']) && !empty($practise['user_answer']))
    @php $answerExists = true;  @endphp
@endif
<?php //dd($practise); ?>
</p>
    <form class="save_true_false_symbol_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{isset($depend[0])?$depend[0]:''}}">
    <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{isset($depend[1])?$depend[1]:''}}">

			@php
				$exploded_question  =  explode('@@', $practise['question']);
				$answerExists = false;
            @endphp
                    @if(isset($practise['user_answer']) && !empty($practise['user_answer']))
                    @php
                            $answerExists = true;
                    @endphp
                            @if($practise['type'] == "true_false_symbol")
                                @php	$answers = $practise['user_answer'][0];  @endphp
                            @else
                                @php	$answers = $practise['user_answer'][0]['text_ans']; @endphp
                            @endif
                    @endif
                    <div class="true-false true-false_withoutBefore">
            					@if(!empty($exploded_question))
            						@foreach($exploded_question as $key => $value)
            							@if(!empty($value))
                            <div class="box box-flex d-flex align-items-center">
                              <div class="box__left box__left_radio">
            										@if($practise['type'] == "true_false_symbol")
                                  <h6>{{ $value }}</h6>
            										@endif
                                <span id="dependan_answer_{{$key}}"></span>

                              </div>
                              <div class="true-false_buttons true-false_buttons_radio">
        										<input type="hidden" name="text_ans[{{$key}}][question]"  value="{{ $value  }}" >
                                <input type="hidden" name="text_ans[{{$key}}][answer]"  class="dependan_answer_{{$key}}" value="" >
        												<div class="form-check form-check-inline">

        														<input class="form-check-input" type="radio" name="text_ans[{{$key}}][true_false]" id="inlineRadioTrue{{$key}}" value="1" {{ ($answerExists && isset($answers[$key]['true_false']) && $answers[$key]['true_false']==1) ?"checked":""}} >
        														<label class="form-check-label form-check-label_true" for="inlineRadioTrue{{$key}}"></label>
        												</div>
        												<div class="form-check form-check-inline">
        														<input class="form-check-input" type="radio" name="text_ans[{{$key}}][true_false]" id="inlineRadioFalse{{$key}}" value="0" {{ ($answerExists && isset($answers[$key]['true_false']) &&  $answers[$key]['true_false']==0) ?"checked":""}}>
        														<label class="form-check-label form-check-label_false" for="inlineRadioFalse{{$key}}"></label>
        												</div>
        										  </div>
      								      </div>
                            <?php $i++; ?>
            							@endif
            						@endforeach
            					@endif

			           </div>
			<div class="alert alert-success" role="alert" style="display:none"></div>
			<div class="alert alert-danger" role="alert" style="display:none"></div>
            <ul class="list-inline list-buttons">
            <li class="list-inline-item">
                <input type="button" class="save_btn true_false_symbol_form_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
                </li>
                <li class="list-inline-item">
                <input type="button" class="submit_btn true_false_symbol_form_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">
                </li>
            </ul>
    </form>
<script type="text/javascript">

function getDependingPractise(){

var topic_id= $(".save_true_false_symbol_form_{{$practise['id']}}").find('.topic_id').val();
var task_id=$(".save_true_false_symbol_form_{{$practise['id']}}").find('.depend_task_id').val();
var practise_id=$(".save_true_false_symbol_form_{{$practise['id']}}").find('.depend_practise_id').val();

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

                // console.log(data);
                    if(data['success'] == false){
                      $("#dependant_pr_{{$practise['id']}}").css("display", "block");
                      $(".save_true_false_symbol_form_{{$practise['id']}}").css("display", "none");

                    }else{
                      $("#dependant_pr_{{$practise['id']}}").css("display", "none");
                      $(".save_true_false_symbol_form_{{$practise['id']}}").css("display", "block");

                    }
                    var i =0;
                    let practice_type = "{{$practise['type']}}";
                    if(practice_type == "true_false_symbol")
                    {
                       var new_answers = data['user_Answer'][0]['text_ans'];
                    }
                    else
                    {
                       var new_answers = data['user_Answer'][0];
                    }
                    $.each(new_answers, function( index, value ) {
                        console.log(value);
                          $("#dependan_answer_"+i).html('<p>'+value+'</p>');
                          $(".dependan_answer_"+i).val(value);
                          i= i+1;
                    });

        }
    });

}

var practise_id=$("#dependant_pr_{{$practise['id']}}").data("value");
            if(practise_id){
                var x = getDependingPractise() ;
            }


$(document).on('click',".true_false_symbol_form_{{$practise['id']}}" ,function() {
  //  $(".true_false_symbol_form_{{$practise['id']}}").attr('disabled','disabled');

    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }

    
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);

    $.ajax({
        url: "{{ route('save-true-false-symbol') }}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $(".save_true_false_symbol_form_{{$practise['id']}}").serialize(),
        success: function (data) {
        $(".save_true_false_symbol_form_{{$practise['id']}}").removeAttr('disabled');
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
