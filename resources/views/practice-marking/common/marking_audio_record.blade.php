<?php

  $recordKey = !empty($key)?$key:0;
  if(!empty($topic_tasks['feedbacks'][0]['teacher_audio'])){

    $delete_icon_style="display: block";
    $record_icon_style="display: none";
    $play_icon = 1;
  } else {
    $delete_icon_style="display: none";
    $record_icon_style="display: block";
    $play_icon = 0;
  }


 
?>
 
<div class="main-audio-record-div record_marking">
	<div class="audio-element">
		<div class="audio-player d-flex flex-wrap">
			<audio  preload="auto" id="marking_audio1" controls class="practice_audio1   marking_answer_audio1" emptied>
				<source src="{{!empty($topic_tasks['feedbacks'][0]['teacher_audio'])?$topic_tasks['feedbacks'][0]['teacher_audio']:''}}" type="audio/mp3">
			</audio>
		</div>
	</div>
	
	<div class="delete-recording marking-delete-recording delete-icon1 delete-icon-right" id="delete-recording-{{$recordKey}}" data-pid="{{$practise['id']}}" data-key={{$recordKey}} style="{{$delete_icon_style}}">
		<a href="javascript:void(0);" data-pid={{$practise['id']}} data-key="{{$recordKey}}" class="deleteRecordingButton" visible="true"><i class="fas fa-trash"></i></a>
	</div>

	<div class="record-icon mic-icon-{{$recordKey}}">
		<a href="javascript:void(0);" data-q="{{ !empty($q) ? $q : '' }}" data-student_id="{{$student_id}}"  data-pid={{$practise_id}} data-key="{{$recordKey}}" class="audio-record-modal recordModalButton" visible="yes"><i class="fas fa-microphone"></i></a>
	</div>
</div>

@if($play_icon)
      <script>
        setTimeout(function(){
          $('.record_marking').find('.marking_answer_audio').next().show();
          $('.record_marking').find('.mic-icon-{{$recordKey}}').hide();
        },1000)
      </script>
    @else
      <script>
        setTimeout(function(){
          $('.record_marking').find('.marking_answer_audio').next().hide();
          $('.record_marking').find('.mic-icon-{{$recordKey}}').css({'margin-left':'-60px'}).show();
        },1000);
      </script>
    @endif
  
<script>
    jQuery(function ($) {
        'use strict'
        var supportsAudio = !!document.createElement('audio').canPlayType;
        if (supportsAudio) {
            // initialize plyr
            var i;

               var player = new Plyr("#marking_audio1", {
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

        // setTimeout(function(){
        //   $('.record_marking').find('.mic-icon-{{$recordKey}}').show();
        //   $('.record_marking').find('.plyr__controls__item.plyr__control').hide();
        //   $('.record_marking').find('.mic-icon-{{$recordKey}}').css({'margin-left':'-60px'});
        //   $('.record_marking').show();
        // },300)
    });
</script>
@if(!isset($topic_tasks['feedbacks'][0]['teacher_audio']) || empty($topic_tasks['feedbacks'][0]['teacher_audio']))
<script>
    jQuery(function ($) {
        setTimeout(function(){
          $('.record_marking').find('.mic-icon-{{$recordKey}}').show();
          $('.record_marking').find('.plyr__controls__item.plyr__control').hide();
          $('.record_marking').find('.mic-icon-{{$recordKey}}').css({'margin-left':'-60px'});
          $('.record_marking').show();
        },300)
    });
</script>
@endif
