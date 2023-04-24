<?php

  $recordKey = !empty($key)?$key:0;
  if(!empty($practise['user_answer'])){
   
    $prac['user_answer'] = !empty($audio_user_answer)?$audio_user_answer:$practise['user_answer'];
  }
  //pr($prac['user_answer']);
  $fieldset_disabled = "disabled";
  $delete_icon_style="display: none";
  $record_icon_style="display: block";
  $play_icon = 0;


  if( $practise['type']=='single_speaking_up_conversation_simple_view' ||
      $practise['type']=='speaking_multiple_single_image' ||
      $practise['type']=='speaking_multiple_listening' ||
      $practise['type']=='speaking_multiple_up' ||
      $practise['type']=='speaking_up_option' ||
      $practise['type']=='speaking_multiple' ){
    if( !empty($prac['user_answer'][$recordKey]) ){
      if($practise['type']=='speaking_multiple_up'){
        if(str_contains($prac['user_answer'][$recordKey],'##')){
           
          if(isset($prac['user_answer'][$recordKey+1])){
            
             $prac['user_answer'][$recordKey] = $prac['user_answer'][$recordKey+1];
          }
        }
      }
    
      $delete_icon_style="display: block";
      $record_icon_style="display: none";
      $play_icon = 1;
    }
    $fieldset_disabled="";
  }
  else  if(  $practise['type']=='draw_image_speaking_single_image'){
    if( (!empty($practise['is_roleplay']) && $practise['is_roleplay']==1) && !empty($prac['user_answer'][$recordKey][0]) ){
   
      $delete_icon_style="display: block";
      $record_icon_style="display: none";
      $play_icon = 1;
    } 
    // else{
    //   if( !empty($prac['user_answer'][0]) ){
   
    //     $delete_icon_style="display: block";
    //     $record_icon_style="display: none";
    //     $play_icon = 1;
    //   } 
    // }
    $fieldset_disabled="";
  }
 /* else  if( $practise['type']=='single_speaking_writing' ){

    if( !empty($prac['user_answer'][$recordKey]) ){
      $delete_icon_style="display: block";
      $record_icon_style="display: none";
      $play_icon = 1;
    }
    $fieldset_disabled="";
  }*/
  else if( $practise['type']=='two_table_option_speaking_up' || $practise['type']=='reading_no_blanks_speaking' || $practise['type']=='underline_text_speaking_down' || $practise['type']=='writing_at_end_speaking_multiple' || $practise['type']=='writing_at_end_speaking_multiple_up' || $practise['type']=='writing_at_end_up_speaking_multiple_up' || $practise['type']=='writing_at_end_up_speaking_multiple'||   $practise['type']=='single_image_writing_at_end_speaking' || $practise['type'] == 'writing_at_end_speaking_multiple_record_video'){

    if( !empty($prac['user_answer'][$recordKey]['path']) ){
      $delete_icon_style="display: block";
      $record_icon_style="display: none";
      $play_icon = 1;
    }else{
        $play_icon = 0;
    }
    $fieldset_disabled="";
  }
  elseif( $practise['type']=='hide_show_answer_speaking_up' ){
    if( !empty($prac['user_answer']) ){
      $delete_icon_style="display: block";
      $record_icon_style="display: none";

    }
    $fieldset_disabled="";
  } else {
    // echo "asdasdasdasd";die;
    if(!empty($prac['user_answer'][$recordKey]['path'])){
      // pr($prac['user_answer'][$recordKey]['path']);
      $play_icon = 1;
      $delete_icon_style="display: block";
      $record_icon_style="display: none";

    }else{
      $play_icon = 0;
  }
      $fieldset_disabled="";
  }



  if(!empty($practise['typeofdependingpractice']) && $practise['typeofdependingpractice']=="get_questions_and_answers"){
    if( $practise['type']=='speaking_writing_up' ){
      if( !empty($practise['user_answer'][$recordKey]['path']) ){
        $delete_icon_style="display: block";
        $record_icon_style="display: none";
        $play_icon = 1;
     //   $prac['user_answer'] = !empty($practise['dependingpractise_answer'][$recordKey]['path'])?$practise['dependingpractise_answer']:"";
      }else{
          $play_icon = 0;
          
      }
      $fieldset_disabled="";
    }
  }


if(!empty($hide_icons) && $hide_icons==1 ){
  $fieldset_disabled = "";
  $delete_icon_style="display: none";
    $record_icon_style="display: none";
}
if($practise['type']=='draw_image_speaking' ||  $practise['type']=='draw_image_speaking_single_image'){
    if(isset($practise['is_roleplay']) && $practise['is_roleplay']=="true"){
         if(isset($practise['user_answer'])){
            if(isset($practise['user_answer'][$recordKey])){

                if(isset($practise['user_answer'][$recordKey][0]) && $practise['user_answer'][$recordKey][0] !=""){

                    if($practise['user_answer'][$recordKey] !=""){
                        $delete_icon_style="display: block";
                        $record_icon_style="display: none";
                        $play_icon = 1;
                    }else{
                        $delete_icon_style="display: none";
                        $record_icon_style="display: block";
                        $play_icon = 0;
                    }
                }else{
                    $delete_icon_style="display: none";
                    $record_icon_style="display: block";
                    $play_icon = 0;
                }
            }
        }
        
    }else{
        if(isset($practise['user_answer'])){
            if($practise['user_answer'][0] !=""){
                $delete_icon_style="display: block";
                $record_icon_style="display: none";
                $play_icon = 1;
            }else{
                $delete_icon_style="display: none";
                $record_icon_style="display: block";
                $play_icon = 0;
            }
        }
    }
}




if($practise['type']=='single_speaking_writing'){
    if(isset($practise['is_roleplay']) && $practise['is_roleplay']=="true"){
         if(isset($practise['user_answer'])){
            if(isset($practise['user_answer'][$recordKey])){
                if(isset($practise['user_answer'][$recordKey]['path']) && $practise['user_answer'][$recordKey]['path'] !=""){

                    if($practise['user_answer'][$recordKey] !=""){
                        $delete_icon_style="display: block";
                        $record_icon_style="display: none";
                        $play_icon = 1;
                    }else{
                        $delete_icon_style="display: none";
                        $record_icon_style="display: block";
                        $play_icon = 0;
                    }
                }else{
                    $delete_icon_style="display: none";
                    $record_icon_style="display: block";
                    $play_icon = 0;
                }
            }
        }
        
    }else{
        // dd("jignesh");
        if(isset($practise['user_answer'])){
            if($practise['user_answer'][0]['path'] !=""){
                $delete_icon_style="display: block";
                $record_icon_style="display: none";
                $play_icon = 1;
            }else{
                $delete_icon_style="display: none";
                $record_icon_style="display: block";
                $play_icon = 0;
            }
        }
    }

}


if($practise['type']=='match_answer_single_image_speaking_up'){
    if(isset($practise['is_roleplay']) && $practise['is_roleplay']=="true"){
         if(isset($practise['user_answer'])){
            if(isset($practise['user_answer'][$recordKey])){
                if(isset($practise['user_answer'][$recordKey]['path']) && $practise['user_answer'][$recordKey]['path'] !=""){

                    if($practise['user_answer'][$recordKey]['path'] !=""){
                        // dd($practise['user_answer'][$recordKey]['path']);
                        $delete_icon_style="display: block";
                        $record_icon_style="display: none";
                        $play_icon = 1;
                    }else{
                        $delete_icon_style="display: none";
                        $record_icon_style="display: block";
                        $play_icon = 0;
                    }
                }else{
                    $delete_icon_style="display: none";
                    $record_icon_style="display: block";
                    $play_icon = 0;
                }
            }
        }
        
    }
}

if($practise['type']=='speaking_multiple_up'){
    if(isset($practise['is_roleplay']) && $practise['is_roleplay']=="true"){
         if(isset($practise['user_answer'])){
            if(isset($practise['user_answer'][$recordKey])){
                if( $practise['user_answer'][$recordKey] !=""){

                    if($practise['user_answer'][$recordKey] !=""){
                        // dd($practise['user_answer'][$recordKey]['path']);
                        $delete_icon_style="display: block";
                        $record_icon_style="display: none";
                        $play_icon = 1;
                    }else{
                        $delete_icon_style="display: none";
                        $record_icon_style="display: block";
                        $play_icon = 0;
                    }
                }else{
                    $delete_icon_style="display: none";
                    $record_icon_style="display: block";
                    $play_icon = 0;
                }
            }
        }
        
    }
}

/*if($practise['type']=='draw_image_speaking_single_image'){
    dd($practise);
}    */

?>
<fieldset {{$fieldset_disabled}}>
    <?php 
        if($practise['id'] == "15505788505c6bf4a286aa5"){
            $delete_icon_style = "display: none";
        }

    ?>

<div class="main-audio-record-div d-flex justify-content-end align-items-center {{($practise['type']=='writing_at_end_up_speaking_up' || $practise['type']=='two_table_option_speaking_up' || $practise['type']=='reading_total_blanks_speaking' || $practise['type']=='writing_at_end_speaking_up' || $practise['type']=='writing_at_end_up_speaking' || $practise['type']=='single_speaking_up_conversation_simple_view' || $practise['type']=='single_speaking_up_writing' || $practise['type']=='single_speaking_writing' ||  $practise['type']=='writing_at_end_speaking' || $practise['type']=='true_false_speaking_simple' || $practise['type']=='two_blank_table_speaking' || $practise['type']=='two_blank_table_speaking_up' || $practise['type']=='three_blank_table_speaking' || $practise['type']=='four_blank_table_speaking_up'  || $practise['type']=='listening_speaking' || $practise['type']=='listening_Speaking' || $practise['type']=='reading_no_blanks_speaking' ||  $practise['type']== 'match_answer_single_image_speaking_up' || $practise['type']=='draw_image_speaking' ||  $practise['type']=='single_image_writing_at_end_speaking'  )?'justify-content-start':''}} record_{{$practise['id']}}">

  <div class="delete-recording-{{$practise['id']}}-{{$recordKey}} delete-icon {{( $practise['type']=='single_speaking_up_conversation_simple_view' || $practise['type']=='single_speaking_up_writing' || $practise['type']=='single_speaking_writing' ||  $practise['type']=='writing_at_end_speaking' || $practise['type']=='true_false_speaking_simple' || $practise['type']=='two_blank_table_speaking' || $practise['type']=='two_blank_table_speaking_up' || $practise['type']=='three_blank_table_speaking' || $practise['type']=='four_blank_table_speaking_up'  || $practise['type']=='listening_speaking' || $practise['type']=='listening_Speaking' ||   $practise['type']=='match_answer_single_image_speaking_up' || $practise['type']=='reading_no_blanks_speaking' || $practise['type']=='writing_at_end_up_speaking' ||  $practise['type']=='single_image_writing_at_end_speaking'  || $practise['type']=='draw_image_speaking'  )?'delete-icon-left':'delete-icon-right'}}"  id="delete-recording-{{$recordKey}}" data-pid="{{$practise['id']}}" data-key={{$recordKey}} style="{{$delete_icon_style}}">
     
      <!-- <a href="javascript:;"  data-pid={{$practise['id']}} data-key="{{$recordKey}}" class="deleteRecordingButton deleteRecordingButton_{{$recordKey}}" visible="true" data-toggle="modal"  onclick="openModelForConform('{{$practise['id']}}','{{$recordKey}}')"><i class="fas fa-trash"></i></a> -->
  </div>

  <div  class="audio-element">
    <div class="audio-player d-flex flex-wrap" style="position: relative;">
        @if(  $practise['type']=='speaking_up_option' || $practise['type']=='single_speaking_up_conversation_simple_view' || $practise['type']=='speaking_multiple_single_image' || $practise['type']=='speaking_multiple_listening'  || $practise['type']=='speaking_multiple' )
          <audio preload="auto" controls class="practice_audio answer_audio-{{$practise['id']}}-{{$recordKey}}">
              <source src="{{ !empty($prac['user_answer'][$recordKey])?$prac['user_answer'][$recordKey]:asset('public/sample-audio.mp3')}}" type="audio/mp3">
          </audio>
        @elseif( $practise['type']=='hide_show_answer_speaking_up' )
          <audio preload="auto" controls class="practice_audio answer_audio-{{$practise['id']}}-{{$recordKey}}">
              <source src="{{ !empty($prac['user_answer'])?$prac['user_answer']:asset('public/sample-audio.mp3')}}" type="audio/mp3">
          </audio>
        @elseif($practise['type']=='underline_text_speaking_down')
            <audio preload="auto" controls class="practice_audio answer_audio-{{$practise['id']}}-{{$recordKey}}">
                <source src="{{ !empty($prac['user_answer'][0]['path'])?$prac['user_answer'][0]['path']:asset('public/horse.mp3')}}" type="audio/mp3">
            </audio>
        @elseif($practise['type']=='draw_image_speaking_single_image')
            <?php 
            
                  if((!empty($practise['is_roleplay']) && $practise['is_roleplay']==1)){
                    if(isset($prac['user_answer'][$recordKey][0]) && !empty($prac['user_answer'][$recordKey][0])){

                      $saved_audio = $prac['user_answer'][$recordKey][0];
                      $delete_icon_style="display: block";
                      $record_icon_style="display: none";
                      $play_icon = 1;
                    }else{
                      $saved_audio="";
                    }
                  }  else {
                    $delete_icon_style="display: block";
                    $record_icon_style="display: none";
                    $play_icon = 1;
                    $saved_audio = !empty($prac['user_answer'][0])?$prac['user_answer'][0]:"";
                  }
                    
            ?>
           
              <audio preload="auto" controls class="practice_audio answer_audio-{{$practise['id']}}-{{$recordKey}}">
                  <source src="{{ !empty($saved_audio)?$saved_audio:asset('public/horse.mp3')}}" type="audio/mp3">
              </audio>
        @elseif($practise['type']=='reading_no_blanks_listening_speaking_down' && isset($prac['user_answer']) && array_key_exists('path', $prac['user_answer'][0]) )

            <audio preload="auto" controls class="practice_audio answer_audio-{{$practise['id']}}-{{$recordKey}}">
                <source src="{{ !empty($prac['user_answer'][0]['path'])?$prac['user_answer'][0]['path']:asset('public/horse.mp3')}}" type="audio/mp3">
            </audio>
        @elseif($practise['type']=='speaking_multiple_up' )
            <audio preload="auto" controls class="practice_audio answer_audio-{{$practise['id']}}-{{$recordKey}}">
                <source src="{{ !empty($prac['user_answer'][0])?$prac['user_answer'][0]:asset('public/horse.mp3')}}" type="audio/mp3">
            </audio>
        @elseif($practise['type']=='writing_at_end_listening' )
            <audio preload="auto" controls class="practice_audio answer_audio-{{$practise['id']}}-{{$recordKey}}">
                <source src="{{ !empty($prac['user_answer'][0])?$prac['user_answer'][0]:asset('public/horse.mp3')}}" type="audio/mp3">
            </audio>
        @elseif($practise['type']=='draw_image_speaking' )
            @if(isset($practise['is_roleplay']) && $practise['is_roleplay']=="true")
                <audio preload="auto" controls class="practice_audio answer_audio-{{$practise['id']}}-{{$recordKey}}">
                    <source src="{{ !empty($prac['user_answer'][$recordKey][0])?$prac['user_answer'][$recordKey][0]:asset('public/horse.mp3')}}" type="audio/mp3">
                </audio>
            @else
                <audio preload="auto" controls class="practice_audio answer_audio-{{$practise['id']}}-{{$recordKey}}">
                    <source src="{{ !empty($prac['user_answer'][0])?$prac['user_answer'][0]:asset('public/horse.mp3')}}" type="audio/mp3">
                </audio>
            @endif
        @else
          <audio  preload="auto" controls class="practice_audio answer_audio-{{$practise['id']}}-{{$recordKey}}">
              <source src="{{ !empty($prac['user_answer'][$recordKey]['path'])?$prac['user_answer'][$recordKey]['path']:asset('public/sample-audio.mp3')}}" type="audio/mp3">
          </audio>
        @endif
      <div class="countdown countdown-{{$recordKey}} {{($practise['type']=='writing_at_end_up_speaking_up' || $practise['type']=='two_table_option_speaking_up' || $practise['type']=='reading_total_blanks_speaking' || $practise['type']=='writing_at_end_speaking_up' || $practise['type']=='writing_at_end_up_speaking' || $practise['type']=='single_speaking_up_conversation_simple_view' || $practise['type']=='single_speaking_up_writing' || $practise['type']=='single_speaking_writing' ||  $practise['type']=='writing_at_end_speaking' || $practise['type']=='true_false_speaking_simple' || $practise['type']=='two_blank_table_speaking' || $practise['type']=='two_blank_table_speaking_up' || $practise['type']=='three_blank_table_speaking' || $practise['type']=='four_blank_table_speaking_up'  || $practise['type']=='listening_speaking' || $practise['type']=='listening_Speaking' || $practise['type']=='reading_no_blanks_speaking' ||  $practise['type']== 'match_answer_single_image_speaking_up' || $practise['type']=='draw_image_speaking' ||  $practise['type']=='single_image_writing_at_end_speaking'  )?'right':''}}" style="position: absolute;
      top: 49px;
      left: 273px;-webkit-box-ordinal-group: 4;
    -ms-flex-order: 3;
    order: 3;
    display: block;
    margin: 0;
    font-size: .875rem;
    font-weight: 600;
    color: #315F94;"></div>
    </div>
  </div>

    <div class="record-icon mic-icon-{{$recordKey}}" >
      <a href="javascript:void(0);" data-q="{{ !empty($q) ? $q : '' }}" data-pid={{$practise['id']}} data-key="{{$recordKey}}" class="audio-record-modal recordModalButtonOpen recordButton new__record__button-{{$recordKey}}" visible="yes">
        <i class="fas fa-microphone"></i>
      </a>
    </div>

    <div class=" pause pause-{{$recordKey}}" style="display:none">
      <a href="javascript:void(0);" data-q="{{ !empty($q) ? $q : '' }}" data-pid={{$practise['id']}} data-key="{{$recordKey}}" class="audio-record-modal pauseBtn" visible="yes"><i class="fas fa-pause-circle"></i></a>
    </div>


    

    <div class="animated__mic__icon justify-content-center displayOnly-{{$recordKey}} new__stop__button-{{$recordKey}}"  style="display:none;margin-right: 12px;">
      <img src="{{asset('public/images/voice_rec.gif')}}"  style="width: 56px;    margin-right: -7px;"/>

        <!--       <div class="audio__progress">
        <div class="audio__progress__bar audio__progress__success" data-width="0" style="width:0%">

        </div>
        <div class="audio__progress__bar audio__progress__remaining" data-width="100" style="width:100%">

        </div>
      </div> -->

    </div>
    <div class="animated__mic__icon_old justify-content-center displayOnlyOld-{{$recordKey}} new__stop__button__old-{{$recordKey}}"  style="display:none;margin-right: 12px;">
      <img src="{{asset('public/images/audio-ori.png')}}"  style="width: 56px;margin-top: 7px;    margin-right: -7px;"/>

    </div>
    <!-- <div class="pauseButton " style="display:none"> -->
      <div class="audio__controls">
        <!-- <a class="btn new__pause__button-{{$recordKey}} pauseButton onlyPause"><i class="fas fa-pause"></i></a> -->
        <img src="{{asset('public/images/pauseBefore.png')}}" class=" new__pause__button-{{$recordKey}} pauseButton onlyPause commonCss" >
        <img src="{{asset('public/images/resumePause.png')}}" class=" new__resume__button-{{$recordKey}} pauseButton pauseresume commonCss" >
        <img src="{{asset('public/images/stopAudio.png')}}" class="new__stop__button-{{$recordKey}} stopButton commonCss" >
        <!-- <button type="button" class="btn new__pause__button-{{$recordKey}} pauseButton onlyPause" style="display:none"><i class="fas fa-pause"></i></button> -->
        <!-- </div> -->
        <!-- <button type="button" class="btn new__resume__button-{{$recordKey}} pauseButton pauseresume" style="display:none">Resume</button> -->
        <!-- <div class="stopButton " style="display:none"> -->
        <!-- <button type="button" class="btn new__stop__button-{{$recordKey}} stopButton" style="display:none">Stop</button> -->
      </div>


    <!-- </div> -->
    <!-- <div class="loader__icon justify-content-center"  style="display:none">
      <img src="{{asset('public/images/animated-loader.gif')}}"  />
      <h5  class="modal-title" >Processing your audio</h5>
    </div> -->
    


    
      <!-- <button type="button" class="btn new__record__button ">Record</button> -->
      <!--       <button type="button" class="btn new__pause__button pauseButton" style="display:none">Pause</button>
      <button type="button" class="btn new__resume__button pauseButton" style="display:none">Resume</button> -->
      <!-- <button type="button" class="btn new__stop__button stopButton" style="display:none">Stop</button> -->


</div>

<!-- {{-- whean audio was not record or submited in user answer --}}  -->
@if(!empty($prac['user_answer']))
  @if($practise['type']=='speaking_multiple' ||
        $practise['type']=='listening_speaking' ||
        $practise['type']=='four_blank_table_speaking_writing' ||
        $practise['type']=='three_table_option_speaking' ||
        $practise['type']=='speaking_multiple_listening' ||
        $practise['type']=='single_speaking_writing' ||
        $practise['type']=='single_speaking_up_writing' ||
        $practise['type']=='speaking_up_option' ||
        $practise['type']=='underline_text_speaking_down' ||
        $practise['type']=='reading_no_blanks_speaking'||
        $practise['type']=='writing_at_end_speaking_multiple_record_video' ||
        $practise['type']=='writing_at_end_speaking_multiple' ||
        $practise['type']=='writing_at_end_speaking_multiple_up' ||
        $practise['type']=='writing_at_end_up_speaking_multiple_up' ||
        $practise['type']=='match_answer_single_image_speaking_up'||
        $practise['type']=='listening_Speaking'||
        $practise['type']=='single_image_writing_at_end_speaking' ||
        $practise['type']=='draw_image_speaking' ||
        $practise['type']=='speaking_multiple_single_image' ||
        $practise['type']=='true_false_speaking_up_simple' ||
        $practise['type']=='speaking_writing_up' ||
        $practise['type']=='speaking_writing' ||
        $practise['type']=='writing_at_end_up_speaking' ||
        $practise['type']=='writing_at_end_speaking_up' ||        
        $practise['type']=='two_blank_table_speaking_up' ||
        $practise['type']=='draw_image_speaking_single_image' || 
        $practise['type']=='reading_total_blanks_speaking_up' || 
        $practise['type']=='writing_at_end_speaking' ||
        $practise['type']=='writing_at_end_up_speaking_up' ||
        $practise['type']=='multi_choice_question_speaking_up' ||
        $practise['type']=='multi_choice_question_multiple_speaking' ||
        $practise['type']=='reading_no_blanks_listening_speaking_down' ||
        $practise['type']=='reading_total_blanks_speaking' || 
        $practise['type']=='two_table_option_speaking_up' ||
        $practise['type']=='two_table_option_speaking' ||
        $practise['type']=='speaking_multiple_up' ||       
        $practise['type']=='five_blank_table_speaking_up' ||       
        $practise['type']=='reading_no_blanks_speaking_down' ||       
        $practise['type']=='three_blank_table_speaking_up' || 
        $practise['type']=='speaking_multiple_single_writing' ||       
        $practise['type']=='single_speaking_up_conversation_simple_view' ||       
        $practise['type']=='single_image_writing_at_end_speaking_up' ||       
        $practise['type']=='three_blank_table_speaking' ||       
        $practise['type']=='true_false_speaking_writing_simple' ||       
        $practise['type']=='true_false_symbol_speaking' ||       
        $practise['type']=='clock_view_speaking' ||       
        $practise['type']=='single_tick_speaking' ||       
        $practise['type']=='two_blank_table_speaking' ||       
        $practise['type']=='match_answer_speaking' ||       
        $practise['type']=='four_blank_table_speaking_up' ||       
        $practise['type']=='true_false_speaking_simple' ||       
        $practise['type']=='writing_at_end_speaking_multiple_up_listening' ||       
        $practise['type']=='writing_at_end_up_speaking_multiple')
    @if($play_icon)
      <script>
        setTimeout(function(){

          $('.record_{{$practise["id"]}}').find('.answer_audio-{{$practise["id"]}}-{{$recordKey}}').next().show();
          $('.record_{{$practise["id"]}}').find('.mic-icon-{{$recordKey}}').hide();
        },2000)
      </script>
    @else
      <script>
        setTimeout(function(){
          $('.record_{{$practise["id"]}}').find('.answer_audio-{{$practise["id"]}}-{{$recordKey}}').next().hide();
          $('.record_{{$practise["id"]}}').find('.mic-icon-{{$recordKey}}').css({'margin-left':'-60px'}).show();
        },2000);
      </script>
    @endif
  @else
    <script>
      $('.record_{{$practise["id"]}}').find('.audioplayer-playpause').show();
      $('.record_{{$practise["id"]}}').find('.mic-icon-{{$recordKey}}').hide();
    </script>
  @endif

@if( !empty($practise['is_roleplay']) && empty($prac['user_answer'][$recordKey][0]))

<script>
        setTimeout(function(){
        /*  $('.record_{{$practise["id"]}}').find('.answer_audio-{{$practise["id"]}}-{{$recordKey}}').next().hide();
          $('.record_{{$practise["id"]}}').find('.mic-icon-{{$recordKey}}').css({'margin-left':'-60px'}).show();*/
        },1000);
      </script>

    <script>
      navigator.permissions.query(
                { name: 'microphone' }
              ).then(function(permissionStatus){
                  console.log(permissionStatus.state); 
                  if(permissionStatus.state=='denied'){
                    $('.mic__icon ').html("<div><h3>Please grant permission for microphone</h3></div>");
                    $('.audio__controls').html('')
                  }
                  permissionStatus.onchange = function(){
                      console.log("Permission changed to " + this.state);
                  }
              })
            $(document).ready(function(){
            

              setTimeout(function(){

                $('.record_{{$practise["id"]}}').find('.mic-icon-{{$recordKey}}').show();
                $('.record_{{$practise["id"]}}').find('.audioplayer-playpause').hide();
                $('.record_{{$practise["id"]}}').find('.mic-icon-{{$recordKey}}').css({'margin-left':'-60px'});
                $('.record_{{$practise["id"]}}').show();
              },300)
            });
    </script>
@endif

@else

    <script>
 navigator.permissions.query(
          { name: 'microphone' }
        ).then(function(permissionStatus){
            console.log(permissionStatus.state); 
            if(permissionStatus.state=='denied'){
              $('.mic__icon ').html("<div><h3>Please grant permission for microphone</h3></div>");
              $('.audio__controls').html('')
            }
            permissionStatus.onchange = function(){
                console.log("Permission changed to " + this.state);
            }
        })
      $(document).ready(function(){
       

        setTimeout(function(){

          $('.record_{{$practise["id"]}}').find('.mic-icon-{{$recordKey}}').show();
          $('.record_{{$practise["id"]}}').find('.audioplayer-playpause').hide();
          $('.record_{{$practise["id"]}}').find('.mic-icon-{{$recordKey}}').css({'margin-left':'-60px'});
          $('.record_{{$practise["id"]}}').show();
        },300)
      });
    </script>

@endif

</fieldset>
<style type="text/css">
  .commonCss{
    width: 56px;
    display: none;
    cursor: pointer;
    margin-top: 6px;
  }
  .recordModalButtonOpen{
    color: white;
  }
  /*.pauseButton,.stopButton{
    border-radius: 14px !important;
    background-color: #2f475e !important;
    color: white !important;
    padding: 5px !important;
    min-width: 4rem !important;
  }*/
</style>



