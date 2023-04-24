<p>
	<strong><?php 	echo $practise['title']; ?></strong>
</p>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
	<input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">

  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

  <?php
	//echo "<pre>";print_r($practise);
	  $answerExists = false;
		$exploded_question  = array();
		if(!empty($practise['question'])){
			$exploded_question  =  explode('@@', $practise['question']);
		}
		if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
			$answerExists = true;
		}
		if( $practise['type']=="writing_at_end_up_speaking_multiple" ){
			$first_div_class = "multiple-choice";
			$div_span = "form-group mb-0";
		} elseif($practise['type']=="writing_at_end_up_speaking_multiple_up") {
			$first_div_class = "";
			$div_span = "form-group d-flex align-items-start form-group-label mb-5";
		}

  ?>
	<div class="{{$first_div_class}}">
		@if(!empty($exploded_question))
			@foreach($exploded_question as $key => $value)
				@if(!empty($value))
					@if($practise['type']=="writing_at_end_up_speaking_multiple" )
						<p class="mb-0">{{$value}}</p>
					@endif
					@if($practise['type']=="writing_at_end_up_speaking_multiple_up" )
						@include('practice.common.audio_record_div')
					@endif
						<div class="{{$div_span}}">
							@if($practise['type']=="writing_at_end_up_speaking_multiple_up" )
							  <span class="label">{{trim($value)}}</span>
							@endif
							<span class="textarea form-control form-control-textarea stringProper text-left" role="textbox"contenteditable placeholder="Write here..."><?php if ($answerExists){echo  $practise['user_answer'][$key]['text_ans'];}?></span>
							<div style="display:none">
								<textarea name="text_ans[{{$key}}][text_ans]">
								<?php
										if ($answerExists)
										{
											echo  $practise['user_answer'][$key]['text_ans'];
										}
								?>
								</textarea>
							</div>
								<input type="hidden" name="text_ans[{{$key}}][path]" class="audio_path{{$key}}" value="{{!empty($practise['user_answer'][$key]['path'])?$practise['user_answer'][$key]['path']:''}}">
								<input type="hidden" name="text_ans[{{$key}}][audio_exists]" value="{{ !empty($practise['user_answer'][$key]['path'])?1:0}}">
								<input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$key}}" name="text_ans[{{$key}}][audio_deleted]" value="0">
						</div>
						@if($practise['type']=="writing_at_end_up_speaking_multiple" )
							@include('practice.common.audio_record_div')
						@endif

				@endif
			@endforeach
		@endif
	</div>

	<div class="alert alert-success" role="alert" style="display:none"></div>
	<div class="alert alert-danger" role="alert" style="display:none"></div>
	<ul class="list-inline list-buttons">
			<li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"
							data-toggle="modal" data-is_save="0" data-target="#exitmodal">Save</button>
			</li>
			<li class="list-inline-item"><button type="button"
							class="submit_btn btn btn-primary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1">Submit</button>
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
<script type="text/javascript">
	var upload_url = "{{url('upload-audio')}}";
//desabel enter for textbox 
$(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
function setTextareaContent(pid){
	$('.form_'+pid).find("span.textarea.form-control").each(function(){
		var currentVal = $(this).text();
		$(this).next().find("textarea").val(currentVal);
	});
}

$(document).on('click','.submitBtn_{{$practise["id"]}}' ,function() {
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
	var $this = $(this);
	var pid= $(this).attr('data-pid');
	$this.attr('disabled','disabled');
	var is_save = $(this).attr('data-is_save');
	$('.form_'+pid).find('.is_save:hidden').val(is_save);
	setTextareaContent(pid);
	$.ajax({
		url: '<?php echo URL('save-writing-at-end-up-speaking-multiple'); ?>',
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
			$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
			$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
			$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
			$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
        }
	});
	if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){
	    $("#reviewModal_{{$practise['id']}}").modal('toggle');
	}
	var $this = $(this);
	var pid= $(this).attr('data-pid');
	$this.attr('disabled','disabled');
	var is_save = $(this).attr('data-is_save');
	$('.form_'+pid).find('.is_save:hidden').val(is_save);
	setTextareaContent(pid);
	$.ajax({
		url: '<?php echo URL('save-writing-at-end-up-speaking-multiple'); ?>',
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
	setTimeout(() => {
		$('.form_'+pid).find('.audioplayer-playpause').css("display","flex");
	}, 1000)
});
	var token = $('meta[name=csrf-token]').attr('content');
	
	var workerDirPath = "{{asset('public/js/audio-recorder/')}}";

</script>

<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
