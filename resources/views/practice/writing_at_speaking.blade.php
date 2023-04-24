<p><strong>{!! $practise['title'] !!} Test Amit</strong></p>
<?php
    //pr($practise);
    $answerExists = false; $answer = array();
    if(isset($practise['user_answer']) && !empty($practise['user_answer'][0]['text_ans'])){
      $answerExists = true;
      $answers = $practise['user_answer'][0]['text_ans'];
    }
    //dd($practise['user_answer']);
    $exploded_question = explode(PHP_EOL,$practise['question']);

  ?>
<form class="writing_at_end_speakingform_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  {{-- <input type="hidden" class="practice_type" name="practice_type" value="writing_at_end_speaking_up"> --}}

    <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="user_audio[0][audio_deleted]" value="0">
    <input type="hidden" name="user_audio[0][path]" class="audio_path0">
    @include('practice.common.audio_record_div',['key'=>0])


  <!-- /. Component Audio Player END-->

        <ul class="list-unstyled">
            @foreach($exploded_question as $key=>$item)

               <li>
                   @php $item = str_replace('@@', '', $item); @endphp
                   {{ $item }}
                <span class="textarea form-control form-control-textarea" role="textbox"
                    contenteditable placeholder="Write here...">
                    <?php
                      if($answerExists == true && array_key_exists($key, $practise['user_answer'][0]['text_ans']))
                      {
                          echo $practise['user_answer'][0]['text_ans'][$key];
                      }
                    ?>
                </span>
                <div style="display:none">
                    <textarea name="text_ans[{{$key}}]">
                    <?php
                        if($answerExists == true && array_key_exists($key, $practise['user_answer'][0]['text_ans']))
                        {
                          echo $practise['user_answer'][0]['text_ans'][$key];
                        }
                    ?>
                    </textarea>
                  </div>
               </li>
            @endforeach
        </ul>




  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
  <ul class="list-inline list-buttons">
      <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn writing_at_end_up_speaking_up" data-pid="{{$practise['id']}}"
              data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
      </li>
      <li class="list-inline-item"><button type="button"
              class="submit_btn btn btn-primary submitBtn writing_at_end_up_speaking_up" data-pid="{{$practise['id']}}" data-is_save="1" >Submit</button>
      </li>
  </ul>
</form>
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>

<script>
var practice_type="{{$practise['type']}}";
var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";

$(document).on('click','.writing_at_end_up_speaking_up' ,function() {

  if($(this).attr('data-is_save') == '1'){
      $(this).closest('.active').find('.msg').fadeOut();
  }else{
      $(this).closest('.active').find('.msg').fadeIn();
  }
                  
  var pid= $(this).attr('data-pid');

	var $this = $(this);
  $this.attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.writing_at_end_speakingform_{{$practise['id']}}').find('.is_save:hidden').val(is_save);
  $('.writing_at_end_speakingform_{{$practise['id']}}').find("span.textarea.form-control").each(function(){
		var currentVal = $(this).html();
		$(this).next().find("textarea").val(currentVal);
	});

  $.ajax({
      url: '<?php echo URL('save-writing-at-end-speakings'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('.writing_at_end_speakingform_{{$practise['id']}}').serialize(),
      success: function (data) {
        $this.removeAttr('disabled');
				if(data.success){
					$('.writing_at_end_speakingform_{{$practise['id']}}').find('.alert-danger').hide();
					$('.writing_at_end_speakingform_{{$practise['id']}}').find('.alert-success').show().html(data.message).fadeOut(8000);
				} else {
					$('.writing_at_end_speakingform_{{$practise['id']}}').find('.alert-success').hide();
					$('.writing_at_end_speakingform_{{$practise['id']}}').find('.alert-danger').show().html(data.message).fadeOut(8000);
				}
      }
  });
});


</script>
