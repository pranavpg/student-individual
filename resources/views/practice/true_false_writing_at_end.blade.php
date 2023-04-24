<p>
	<strong>{!!$practise['title']!!}</strong>
	<?php
		 //pr($practise);
		if($practise['type']=='true_false_writing_at_end' && isset($practise['is_roleplay']) ){
			$rolplayexercise  =  explode('##', $practise['question']);
			$tabs  =  explode('@@', $rolplayexercise[0]);
		}elseif($practise['type']=='true_false_writing_at_end_simple' || $practise['type']=='true_false_writing_at_end'){

			
			$true="True";
			$false="False";
			
			if(isset($practise['question']) && str_contains($practise['question'],'#@')){
				$option= explode('#@',$practise['question']);
				
				$trueFalse= explode('@@',$option[0]);
				$practise['question']=$option[1];
				$true=$trueFalse[0];
				$false=$trueFalse[1];
			}
				$exploded_question  =  explode('@@', $practise['question']);
			
		}else{
			$exploded_question = explode('@@',$practise['question']);
		}
		$answerExists = false;
		$answers=array();
		if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
			$answerExists = true;
			if($practise['type'] == "true_false_speaking_writing_simple" ){

				$answers = $practise['user_answer'][0]['text_ans'][0];
			} else {
				$answers = $practise['user_answer'];
			}
		}
		
	?>
</p>
<form class="save_true_false_speaking_form_{{$practise['id']}}"  id="reading-no-blanks_form-<?php echo $practise['id'];?>">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
	@if($practise['type']=='true_false_writing_at_end' )
		@include('practice.true_false_writing_at_end_with_simple')
	@elseif($practise['type']=='true_false_writing_at_end_simple')
		@include('practice.true_false_writing_at_simple')
	@endif
  <div class="alert alert-success" role="alert" style="display:none"></div>
	<div class="alert alert-danger" role="alert" style="display:none"></div>
	<ul class="list-inline list-buttons">
	    <li class="list-inline-item"><button class="save_btn btn btn-primary submitBtn_new"
	            data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
	    </li>
	    <li class="list-inline-item"><button
	            class="submit_btn btn btn-primary submitBtn_new" data-is_save="1" >Submit</button>
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
@if($practise['type']!="true_false_writing_at_end_simple")
	<script type="text/javascript">
		$(".notallowspeical").keypress(function(e){
			var k;
		   	document.all ? k = e.keyCode : k = e.which;
			// 33,64,35,36,37,94,38,42,40,41,125,123,34,58,62,63
		   	return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
		});
		$('.false_option').on('click', function(){
			$(this).parent().parent().parent().find('.textarea').show()
		})
		$('.true_option').on('click', function(){
			$(this).parent().parent().parent().find('.textarea').hide()
		});
		$('.t_f_simple').keypress(
		function(event){
			if(event.which == '13') {
			event.preventDefault();
			}
		});
	</script>
@endif
	<script type="text/javascript">
	function setTextareaContent(){
		$("span.textarea.form-control").each(function(){
			var currentVal = $(this).html();
			currentVal= currentVal.replace('&nbsp;',' ');
			currentVal= currentVal.replace('nbsp;',' ');
			currentVal= currentVal.replace('&amp;',' ');
			currentVal= currentVal.replace('amp;',' ');
			currentVal= currentVal.replace('<br>','\n');
			currentVal= currentVal.replace('<div>','\n');
			currentVal= currentVal.replace('</div>','');
			$(this).next().find("textarea").val(currentVal);
		})
	}
	</script>

<script>


$(document).on('click','.submitBtn_new' ,function() {
	    if($(this).attr('data-is_save') == '1'){
            $(this).closest('.active').find('.msg').fadeOut();
        }else{
            $(this).closest('.active').find('.msg').fadeIn();
        }

	var reviewPopup = '{!!$reviewPopup!!}';
    var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){
                    $('#practise_div').html("");
					var fullView= $(".save_true_false_speaking_form_{{$practise['id']}}").clone(true);
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.form-check-inline').css('pointer-events','none');
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.form-control-textarea').css('pointer-events','none');
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
                }
            }
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){

                $("#reviewModal_{{$practise['id']}}").modal('toggle');

            }

  $('.submitBtn_new').attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.is_save:hidden').val(is_save);
  setTextareaContent();
  $.ajax({
      url: '<?php echo URL('save-true-false-speaking'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('.save_true_false_speaking_form_{{$practise["id"]}}').serialize(),
      success: function (data) {
        $('.submitBtn_new').removeAttr('disabled');
				if(data.success){
					$('.alert-danger').hide();
					$('.alert-success').show().html(data.message).fadeOut(8000);
				} else {
					$('.alert-success').hide();
					$('.alert-danger').show().html(data.message).fadeOut(8000);
				}
      }
  });
  return false;
});

var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";

</script>
