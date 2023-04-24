<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">

<p>
	<strong>{!! $practise['title'] !!}</strong>
	@php
	  //dd($practise);
      $answerExists = false;
      if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
        $answerExists = true;
      }
	@endphp
</p>
<form class="save_listening_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practise_type" name="practice_type" value="{{$practise['type']}}">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

  <!-- /. Component Audio Player -->
  	<div class="audio-player">
		<audio preload="auto" controls controlsList="nodownload">
			<source src="{{ $practise['audio_file'] }}" type="audio/mp3" >
		</audio>
	</div>
  <!-- /. Component Audio Player END-->

  <!-- /. Component Listening Player -->


  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
  <ul class="list-inline list-buttons">
    <li class="list-inline-item"><button class="save_btn btn btn-primary submitBtn btnsavelistening_{{$practise['id']}}"  data-is_save="0" >Save</button>
    </li>
    <li class="list-inline-item"><button class="submit_btn btn btn-primary btnsavelistening_{{$practise['id']}}" data-is_save="1"  >Submit</button>
    </li>
  </ul>
</form>
<div class="modal fade" id="feedback_{{$practise['id']}}" tabindex="-1" role="dialog"
	aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header justify-content-center">
				<h5 class="modal-title" id="exampleModalLabel">Review The Task</h5>

				<h6 class="modal-title-center">
					<span>Listening</span>
                </h6>
                <h6 class="modal-title-center">
					<span>How easy did you find this task?</span>
				</h6>
			</div>
			<div class="modal-body">
				<h3>Remarks</h3>

			</div>
			<div class="modal-footer justify-content-start">

			</div>
		</div>
	</div>
</div>

<script>
  var token = $('meta[name=csrf-token]').attr('content');
	var upload_url = "{{url('upload-audio')}}";
	var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
	$('.delete-icon').on('click', function() {
		$('.practice_audio').attr('src','');
		$(document).find('.stop-button').hide();
		$('.audioplayer-bar-played').css('width','0%');
		$('.delete-icon').hide();
		$('div.audio-element').css('pointer-events','none');
		$('.submitBtn').attr('disabled','disabeld');
		var practise_id = $('.practise_id:hidden').val();
		$.ajax({
	      url: '<?php echo URL('delete-audio'); ?>',
	      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	      type: 'POST',
	      data: {practice_id:practise_id},
	      success: function (data) {

	      }
	  });
 	});
</script>

<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<script>

  $(document).on('click',".submitBtn_{{$practise['id']}}" ,function() {
    // $("#feedback_{{$practise['id']}}").modal('show');
    // return false;
    if($(this).attr('data-is_save') == '1'){
          $(this).closest('.active').find('.msg').fadeOut();
      }else{
          $(this).closest('.active').find('.msg').fadeIn();
      }
    $(".btnsavelistening_{{$practise['id']}}").attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);
    //setTextareaContent();
    $.ajax({
        url: "{{url('save_listening')}}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $(".save_listening_form_{{$practise['id']}}").serialize(),
        success: function (data) {
          $(".submitBtn_{{$practise['id']}}").removeAttr('disabled');
          $('.alert-success').show().html(data.message).fadeOut(8000);

        }
    });
  });
</script>
