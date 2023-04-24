
<?php //dd($practise); ?>
<p>
  <strong>{!!$practise['title']!!}</strong>
  <?php
    $answerExists = false;
    if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
      $answerExists = true;
    }
  ?>
</p>

  <?php 
  if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) && empty($practise['dependingpractise_answer'][0]) ){
      $depend =explode("_",$practise['dependingpractiseid']);
  ?>
    <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
      <p style="margin: 15px;">In order to do this task you need to have completed
      <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
    </div>
    <?php
    } else {
    ?>
     <!---------->
     @if(isset($practise['dependingpractise_answer'][0]) && isset($practise['depending_practise_details']['question_type']))
      @if($practise['depending_practise_details']['question_type'] == "writing_lines")
       @php
          $dependent_ans = $practise['dependingpractise_answer'][0];
       @endphp
       <div class="multiple-choice">
          <?php $k=1; ?>
         @foreach ($dependent_ans as $key=>$item)
          @php $item = str_replace("@@", "", $item); @endphp
              <div class="form-group d-flex align-items-start form-group-label focus">
                  <span class="label">{{$k}}</span>
                  <span class="textarea form-control form-control-textarea stringProper text-left" role="textbox" placeholder="Write here...">{{ isset($item)?$item: "" }}</span>
              </div>
          <?php $k++; ?>
         @endforeach
      </div>
      @endif
     @endif
    <!---------->
    <form class="save_listening_speaking_form_{{$practise['id']}}">
      <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
      <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
      <input type="hidden" class="is_save" name="is_save" value="">
      <input type="hidden" class="practise_type" name="practice_type" value="{{$practise['type']}}">
      <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
      <!----------------->
      @if(isset($practise['depending_practise_details']))
       @if($practise['depending_practise_details']['question_type'] == "two_blank_table" || $practise['depending_practise_details']['question_type'] == "two_table_option")
         @php
          $questions = explode(PHP_EOL,$practise['depending_practise_details']['question']);
          $heading   = explode("@@",$questions[0]);
          $tbody     = explode("@@",$questions[1]);
          $dependent_ans = isset($practise['dependingpractise_answer'][0][0])?$practise['dependingpractise_answer'][0][0]:[];
         @endphp
          <table style="border: 1px solid black;">
           <thead>
             <tr>
               @foreach($heading as $value)
                <th>{{$value}}</th>
               @endforeach
             </tr>
           </thead>
           <tbody>
             @foreach($tbody as $key => $value)
              <tr>
               @if($practise['depending_practise_details']['question_type'] == "two_table_option")
                <td class="td">{{isset($dependent_ans[$key+1]['col_1'])?$dependent_ans[$key+1]['col_1']:''}}</td>
               @else
                <td class="td">{{$value}}</td>
               @endif
               <td>{{isset($dependent_ans[$key+1]['col_2'])?$dependent_ans[$key+1]['col_2']:''}}</td>
              </tr>
             @endforeach
           </tbody>
          </table>
      @endif
     @endif
      <!----------------->
      <!-- /. Component Audio Player -->
      @if(isset($practise['audio_file']))
      <div class="audio-player mt-3">
        <audio preload="auto" controls src="<?php echo isset($practise['audio_file'])?$practise['audio_file']:'';?>" type="audio/mp3" id="audio_{{$practise['id']}}" class="monika">
          <!-- <source > -->
        </audio>
      </div>
      @endif
      @if(isset($practise['dependingpractise_answer'][0]))
       @php 
        $check_arg = $practise['dependingpractise_answer'][0];
       @endphp
       @if(!is_array($check_arg))
        <div class="audio-player">
         <audio preload="auto" controls src="<?php echo isset($practise['dependingpractise_answer'])?$practise['dependingpractise_answer'][0]:'';?>" type="audio/mp3" id="audio_{{$practise['id']}}">
          <!-- <source > -->
         </audio>
        </div>
       @endif
      @endif
      <!-- /. Component Listening Player -->
      @if($practise['type'] == "listening_speaking" || $practise['type'] == "listening_Speaking")
        @if($practise['id'] == "15567189315cc9a553c23b8")
        @php 
            $key = 0;
          @endphp
        @endif
        @include('practice.common.audio_record_div',['key'=>0])
        
      @endif
       <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="listening_speaking" value="0">
      <div class="alert alert-success" role="alert" style="display:none"></div>
      <div class="alert alert-danger" role="alert" style="display:none"></div>
      <!-- <ul class="list-inline list-buttons">
        <li class="list-inline-item"><button class="btn btn-secondary submitBtn submitBtn_{{$practise['id']}}"  data-is_save="0" >Save</button>
        </li>
        <li class="list-inline-item"><button class="btn btn-secondary submitBtn_{{$practise['id']}}" data-is_save="1"  >Submit</button>
        </li>
      </ul> -->
    </form>
    <?php
    } 
?>
<script>
  var token = $('meta[name=csrf-token]').attr('content');
  var upload_url = "{{url('upload-audio')}}";
  var workerDirPath = "{{asset('public/js/audio-recorder/')}}";

</script>

<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<script>
jQuery(function ($) {
        'use strict'
        var supportsAudio = !!document.createElement('audio').canPlayType;
        if (supportsAudio) {
            // initialize plyr
            var i;

               var player = new Plyr("#audio_{{$practise['id']}}", {
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
    });
</script>
<script>
  $(document).ready(function(){
    // alert("{{$practise['id']}}");15505852065c6c0d767a519
    var practice_id = "{{$practise['id']}}"
    if(prectice_id != "1629181912611b57d8ba0d6")
    {
      $(document).find(".save_listening_speaking_form_"+"{{$practise['id']}}").find('.audio-player').css('display','none');
    }
      $(document).find(".save_listening_speaking_form_"+"{{$practise['id']}}").find('fieldset').css('pointer-events','auto');    
  });
</script>
<script>
  $(document).on('click',".submitBtn_{{$practise['id']}}" ,function() {
    $(".submitBtn_{{$practise['id']}}").attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);

    $.ajax({
        url: "{{url('save-speaking-writing')}}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $(".save_listening_speaking_form_{{$practise['id']}}").serialize(),
        success: function (data) {
          $(".submitBtn_{{$practise['id']}}").removeAttr('disabled');

            $('.alert-success').show().html(data.message).fadeOut(4000);

        }
    });
  });
</script>
