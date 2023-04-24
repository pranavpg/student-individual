<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
    $answerExists = false;
    $answers=array();
    if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
      $answerExists = true;
      $answers = $practise['user_answer'][0];
    }
   
    $exploded_question = explode(PHP_EOL,$practise['question']);

  ?>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  <!-- /. Component Audio Player END-->
  @if($practise['type']=="true_false_radio_listening")
    @include('practice.common.audio_player')
  @endif
  <div class="true-flase-radio multiple-choice">
      <!-- /. Box -->
      @if(!empty($exploded_question))
        @foreach($exploded_question as $key => $value)
          <div class="box">
            <?php
            $explode_option = explode('@@', $value);
           
            ?>
            @if(!empty($explode_option))
              @foreach($explode_option as $k => $v)
                <div class="box-flex d-flex align-items-center">
                  @if($k==0)
                    <input type="hidden" name="text_ans[{{$key}}][question]" value="{{$value}}">
                  @endif
                  <div class="box__left box__left_radio">
                      <p style="white-space: pre;">{!! $v !!}</p>
                  </div>
                  <div class="true-false_buttons true-false_buttons_radio">
                      <div class="form-check form-check-inline">

                          <input class="form-check-input true_option" type="radio"
      	                      name="text_ans[{{$key}}][selection]"
                              id="inlineRadioTrue_{{$key}}_{{$k}}"
                              value="{{$k}}" {{ ($answerExists && $answers[$key]['selection'] ==$k)?"checked":""}} >
      	                  <label class="form-check-label form-check-label_true" for="inlineRadioTrue_{{$key}}_{{$k}}"></label>

                      </div>
                  </div>
              </div>
              @endforeach
            @endif
          </div>
        @endforeach
      @endif
      <!-- /. Box -->
  </div>

  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
  <ul class="list-inline list-buttons">
      <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn trueFalseRadioBtn" data-pid="{{$practise['id']}}"
              data-toggle="modal" data-is_save="0" data-target="#exitmodal"  >Save</button>
      </li>
      <li class="list-inline-item"><button type="button"
              class="submit_btn btn btn-primary submitBtn trueFalseRadioBtn" data-pid="{{$practise['id']}}" data-is_save="1"  >Submit</button>
      </li>
  </ul>
</form>
@if(isset($practise["markingmethod"]) && $practise["markingmethod"] == "student_self_marking")
	@include('practice.common.student_self_marking')
@endif
@php
	$lastPractice=end($practises);
@endphp
@if($lastPractice['id'] == $practise['id'])
	@include('practice.common.review-popup')
	@php
		$reviewPopup=true;
	@endphp
@else
	@php
		$reviewPopup=false;
	@endphp
@endif
<script>
//------begginer self marking-------------------
  $(".true_option").on('change',function(){
    var get_id   = $(this).attr('id');
    var get_remove_id  =get_id.split("_");
    if(get_remove_id[2] == 1)
    {
       var new_val = 0;
       var get_current_id =  get_remove_id[0]+'_'+get_remove_id[1]+'_'+new_val;
       $('#'+get_current_id).removeAttr('checked',false);
       $('#'+get_id).attr('checked',true);
    }
    else
    {
       var new_val = 1;
       var get_current_id =  get_remove_id[0]+'_'+get_remove_id[1]+'_'+new_val;
       $('#'+get_current_id).removeAttr('checked',false);
       $('#'+get_id).attr('checked',true);
    }
  });
//----------------------------
var feedbackPopup = true;
var courseFeedback = true;
$(document).on('click','.trueFalseRadioBtn' ,function() {
      if($(this).attr('data-is_save') == '1'){
          $(this).closest('.active').find('.msg').fadeOut();
      }else{
          $(this).closest('.active').find('.msg').fadeIn();
      }
  var reviewPopup = '{!!$reviewPopup!!}';
    var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){
                    var fullView= $(".form_{{$practise['id']}}").html();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
                }
            }
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){

                $("#reviewModal_{{$practise['id']}}").modal('toggle');

            }
  var pid= $(this).attr('data-pid');

	var $this = $(this);
  $this.attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.form_'+pid).find('.is_save:hidden').val(is_save);

  $.ajax({
      url: '<?php echo URL('save-true-false-radio'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('.form_'+pid).serialize(),
      success: function (data) {
        $this.removeAttr('disabled');
				if(data.success){
					$('.form_'+pid).find('.alert-danger').hide();
					$('.form_'+pid).find('.alert-success').show().html(data.message).fadeOut(8000);
				} else {
					$('.form_'+pid).find('.alert-success').hide();
					$('.form_'+pid).find('.alert-danger').show().html(data.message).fadeOut(8000);
				}
      }
  });
});


</script>
