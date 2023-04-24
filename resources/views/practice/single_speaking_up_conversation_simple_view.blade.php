<p><strong>{{$practise['title']}}</strong></p>
<?php
//pr($practise);
  $answerExists = false;

  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
    $answers = $practise['user_answer'][0];
  }
?>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
	<input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
      <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="single_speaking_up_conversation_simple_view" value="0">

  @include('practice.common.audio_record_div',['key'=>0])
  <!--Component Conversation-->
  <div class="conversation d-flex flex-column">
    @if( !empty($practise['question']))
      @foreach($practise['question'] as $key => $value)
        <div class="{{($key%2==0)?' convrersation-box mr-auto mb-4 convrersation-box__dark':''}}">
            <p style="float: right;" class="{{($key%2==1)?'convrersation-box':''}}">{!! $value !!}</p>
        </div>
      @endforeach
    @endif

  </div>
  <!--Component Conversation End-->


  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
  <ul class="list-inline list-buttons">
      <li class="list-inline-item"><button class="save_btn btn btn-primary submitBtn_{{$practise['id']}}"
              data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
      </li>
      <li class="list-inline-item"><button
              class="submit_btn btn btn-primary submitBtn_{{$practise['id']}}" data-is_save="1"  >Submit</button>
      </li>
  </ul>
</form>


  <script type="text/javascript">

  $(document).on('click','.submitBtn_{{$practise["id"]}}' ,function() {

    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }
    

    $('.submitBtn_{{$practise["id"]}}').attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);

    $.ajax({
        url: '<?php echo URL('save-single-speaking-up-conversation-simple-view'); ?>',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $('.form_{{$practise["id"]}}').serialize(),
        success: function (data) {
          $('.submitBtn_{{$practise["id"]}}').removeAttr('disabled');
  				if(data.success){
  					$('.alert-danger').hide();
  					$('.alert-success').show().html(data.message).fadeOut(8000);
  				} else {
  					$('.alert-success').hide();
  					$('.alert-danger').show().html(data.message).fadeOut(8000);
  				}
        }
    });
  });
  var token = $('meta[name=csrf-token]').attr('content');
  var upload_url = "{{url('upload-audio')}}";
  var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
  </script>
  <script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
