<?php
  $recordKey = !empty($key)?$key:0;
  //dd($recordKey);
  $delete_icon_style="display: none";
    $record_icon_style="display: block";
  if(!empty($practise['user_answer'])){
    $delete_icon_style="display: block";
  }

  if(!empty($practise['user_answer'])){
    $record_icon_style="display: none";
  }

?>
<div class="main-audio-record-div  record_{{$practise['id']}}" >
  <div class="delete-icon"  id="delete-recording-{{$recordKey}}" style="{{$delete_icon_style}}">
      <a href="javascript:;"  data-pid={{$practise['id']}} data-key="{{$recordKey}}" class="deleteRecordingButton" visible="true"><i class="fas fa-trash"></i></a>
  </div>
  <div  class="audio-element">
    <div class="audio-player d-flex flex-wrap {{( $practise['type']=='writing_at_end_speaking' || $practise['type']=='true_false_speaking_simple' || $practise['type']=='two_blank_table_speaking' || $practise['type']=='three_blank_table_speaking' || $practise['type']=='four_blank_table_speaking_up'  || $practise['type']=='listening_speaking' )?'justify-content-end':''}}">
        @if($practise['type']=='speaking_multiple_listening')
          <audio preload="auto" controls class="practice_audio" id="answer_audio{{$recordKey}}">
              <source src="{{ !empty($practise['user_answer'])?$practise['user_answer'][$recordKey]:asset('public/horse.mp3')}}" type="audio/mp3">
          </audio>
        @elseif($practise['type']=='underline_text_speaking_down')
            <audio preload="auto" controls class="practice_audio" id="answer_audio{{$recordKey}}">
                <source src="{{ !empty($practise['user_answer'][0]['path'])? $practise['user_answer'][0]['path'] : asset('public/horse.mp3') }}" type="audio/mp3">
            </audio>
        @elseif($practise['type']=='reading_no_blanks_listening_speaking_down' && isset($practise['user_answer']) && array_key_exists('path', $practise['user_answer'][0]) )
            <audio preload="auto" controls class="practice_audio" id="answer_audio{{$recordKey}}">
                <source src="{{  !empty($practise['user_answer'][0]['path'])? $practise['user_answer'][0]['path']:asset('public/horse.mp3')}}" type="audio/mp3">
            </audio>
        {{-- @elseif(array_key_exists('path', $practise['user_answer']) )
          <audio preload="auto" controls class="practice_audio" id="answer_audio{{$recordKey}}">
              <source src="{{ !empty($practise['user_answer'])?$practise['user_answer'][0]['path']:asset('public/horse.mp3')}}" type="audio/mp3">
          </audio> --}}
        @else
          <audio preload="auto" controls class="practice_audio" id="answer_audio{{$recordKey}}">
              <source src="{{ asset('public/horse.mp3')}}" type="audio/mp3">
          </audio>
        @endif
    </div>
  </div>
  <div class="record-icon mic-icon-{{$recordKey}}" style="{{$record_icon_style}}">
      <a href="javascript:;" data-pid={{$practise['id']}} data-key="{{$recordKey}}" class="recordButton" id="record_audio{{$recordKey}}" visible="true"><i class="fas fa-microphone"></i></a>
  </div>
  <div class="record-icon audio-recorder stop-button stop-button-{{$recordKey}}" style="display:none">
    <a href="javascript:void(0);" data-pid={{$practise['id']}} data-key="{{$recordKey}}" id="stop_recording{{$recordKey}}" class="stopButton" visible="yes"><i class="fas fa-stop"></i></a>
    <!-- <a href="javascript:;" style="display:none" class="playButton" visible="true"><i class="fas fa-play"></i></a> -->
  </div>
</div>
