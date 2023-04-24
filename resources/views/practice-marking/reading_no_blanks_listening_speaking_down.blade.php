

<p>
	<strong>{!! $practise['title'] !!}</strong>
	@php

      $exploded_question = explode(PHP_EOL, $practise['question']);
      //dd($exploded_question);
      $counter = 0;
      $answerExists = false;
      if(isset($practise['user_answer']) && !empty($practise['user_answer']))
      {
            $answerExists = true;
            $userAnswer = $practise['user_answer'][0]['text_ans'];
            $userAnswer = explode(";", $userAnswer);
            $final_answer = json_encode($userAnswer);

      }

	@endphp
</p>



<form class="save_reading_no_blanks_listening_speaking_down_form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="audio_reading" value="0">
  <!-- /. Component Audio Player -->
	<div class="audio-player">
		<audio preload="auto" class="audio_file" controls controlsList="nodownload">
			<source src="<?php echo $practise['audio_file']?>" type="audio/mp3" >
		</audio>
    </div>


  <!-- /. Component Audio Player END-->
@foreach($exploded_question as $key=>$item)
    <p class="focus">
        @php
            $replace = '<span class="textarea form-control form-control-textarea d-inline-flex mw-20" role="textbox" contenteditable="" placeholder="Write here..." id="text_ans"></span><input type="hidden" name="text_ans[]">';
        @endphp
        {!! str_replace("@@",  $replace , $item) !!}
    </p>
@endforeach

<?php
//pr($practise['user_answer']);
?>
<br>
@if($practise['type'] == "reading_no_blanks_listening_speaking_down")
    @include('practice.common.audio_record_div',['key'=>0])
@endif

</form>

<!--
<script type="text/javascript">
    $(document).ready(function(){
        foreach($userAnswer as $k=>$userAns):
            $(".reading-no-blanks_form ul.list-unstyled input.form-control-inline:eq()").val('');
        endforeach
    })
</script>
-->
<script>
  var token = $('meta[name=csrf-token]').attr('content');
	var upload_url = "{{url('upload-audio')}}";
	var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
@if($practise['type'] == 'reading_no_blanks_listening_speaking_down')
<script>
jQuery(function ($) {
	'use strict'
	var supportsAudio = !!document.createElement('audio').canPlayType;
    if (supportsAudio)
    {

		var i;

			 var player = new Plyr('audio.audio_file', {
				controls: [

						'play',
						'progress',
						'current-time',

				]
		});


    } else
    {
		// no audio support
		$('.column').addClass('hidden');
		var noSupport = $('#audio1').text();
		$('.container').append('<p class="no-support">' + noSupport + '</p>');
	}
});
</script>

@endif

<script>
  function setTextareaContents()
  {

    $(".save_reading_no_blanks_listening_speaking_down_form_{{$practise['id']}} .form-control-textarea").each(function(){
        var currentVal = $(this).html();
        $(this).next('input').val(currentVal);
    })
 }

 function isEmpty(val){
    return (val === undefined || val == null || val.trim().length <= 0 || val.trim() == " ") ? true : false;
 }

 function Audioplay(pid,inc,flagForAudio){
    var supportsAudio = !!document.createElement('audio').canPlayType;
    if (supportsAudio) {
        var i;
        var player = new Plyr(".modal .answer_audio-{{$practise['id']}}-"+inc, {
            controls: [
                'play',
                'progress',
                'current-time'
            ]
        }); 
    }
}
 function Audioplay1(pid,inc,flagForAudio){
   jQuery(function ($) {
        'use strict'
        var supportsAudio = !!document.createElement('audio').canPlayType;
        if (supportsAudio) {
            // initialize plyr
            var i;

               var player = new Plyr(".self_marking_modal_popup .audio_file", {
                controls: [

                    'play',
                    'progress',
                    'current-time',

                ]
            });


        } else {
            // no audio support
            $('.column').addClass('hidden');
            var noSupport = $('#audio1').text();
            $('.container').append('<p class="no-support">' + noSupport + '</p>');
        }
        setTimeout(function(){

          $('.plyr__controls:first').remove();
          // $('.plyr__controls:first').fadeOut();
        },2000);
    });
}



</script>

<?php if($answerExists): ?>

<script>
    $(window).on('load', function() {

        var answers = <?php echo $final_answer; ?>;
        $(".save_reading_no_blanks_listening_speaking_down_form_{{$practise['id']}} .form-control-textarea").each(function(i){
            $(this).html(answers[i]);
            $(this).next('input').val(answers[i]);
        });

    })
</script>

<?php endif ?>

<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
