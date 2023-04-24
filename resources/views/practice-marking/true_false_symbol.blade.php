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
                               
                                  @if($practise['id'] == "16285225216111481908772")
                                      @php 
                                         $answers1 = $practise['dependingpractise_answer'][0]['text_ans'];  
                                         $answers  = $practise['user_answer'][0]
                                      @endphp
                                  @else 
                                     @php $answers = $practise['user_answer'][0];  @endphp
                                  @endif
                                
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
                                <?php 
                                  if($practise['id'] == "16285225216111481908772")
                                  {
                                ?>
                                    <span id="dependan_answer_{{$key}}"><?php echo isset($answers1[$key])?$answers1[$key]:'';?></span>
                                <?php
                                  }
                                  else
                                  {
                                ?>
                                   <span id="dependan_answer_{{$key}}"></span>
                                <?php
                                  }
                                ?>
                               

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
                            <?php //$i++; ?>
            							@endif
            						@endforeach
            					@endif

			           </div>
			<div class="alert alert-success" role="alert" style="display:none"></div>
			<div class="alert alert-danger" role="alert" style="display:none"></div>
    </form>

<script type="text/javascript">
// .save_true_false_symbol_form_15569134205ccc9d0c8568e
function getDependingPractise(){


//alert("{{$practise['id']}}");
if("{{$practise['id']}}" =="15569134205ccc9d0c8568e"){
    var topic_id= $('.topic_id').val();
    var task_id=$('.depend_task_id').val();
    var practise_id=$('.depend_practise_id').val();
    var student_id = "{{request()->segment(4)}}";
}else{
    var topic_id= $(".save_true_false_symbol_form_{{$practise['id']}}").find('.topic_id').val();
    var task_id=$(".save_true_false_symbol_form_{{$practise['id']}}").find('.depend_task_id').val();
    var practise_id=$(".save_true_false_symbol_form_{{$practise['id']}}").find('.depend_practise_id').val();
    var student_id = "{{request()->segment(4)}}";
}

    $.ajax({
        url: "{{url('get-student-practisce-answer')}}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data:{
            topic_id,
            task_id,
            practise_id,
            student_id
        },
        dataType:'JSON',
        success: function (data) {

                console.log(data);
                var pid = "{{$practise['id']}}";
                if(pid == "16285225216111481908772")
                {
                      $("#dependant_pr_{{$practise['id']}}").css("display", "none");
                      $(".save_true_false_symbol_form_{{$practise['id']}}").css("display", "block");
                }
                else
                {
                    if(data['success'] == false){
                      $("#dependant_pr_{{$practise['id']}}").css("display", "block");
                      $(".save_true_false_symbol_form_{{$practise['id']}}").css("display", "none");

                    }else{
                      $("#dependant_pr_{{$practise['id']}}").css("display", "none");
                      $(".save_true_false_symbol_form_{{$practise['id']}}").css("display", "block");

                    }

                    var i =0;
                      $.each(data['user_Answer'][0], function( index, value ) {
                        //console.log(value);
                          $("#dependan_answer_"+i).html('<p>'+value+'</p>');
                          $(".dependan_answer_"+i).val(value);
                          i= i+1;
                      });
                }

        }
    });

}

var practise_id=$("#dependant_pr_{{$practise['id']}}").data("value");
            if(practise_id){
                var x = getDependingPractise() ;
            }


$(document).on('click',".true_false_symbol_form_{{$practise['id']}}" ,function() {
  //  $(".true_false_symbol_form_{{$practise['id']}}").attr('disabled','disabled');
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
                $('.alert-success').show().html(data.message).fadeOut(4000);
            }else{
                $('.alert-success').hide();
                $('.alert-danger').show().html(data.message).fadeOut(4000);
            }
        }
    });
});
</script>
