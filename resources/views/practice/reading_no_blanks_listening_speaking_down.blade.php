<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">

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

  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
  <ul class="list-inline list-buttons">
    <li class="list-inline-item"><button class="save_btn btn btn-primary submitBtn readingnoblanks_listening_speakingupBtn_{{$practise['id']}}"  data-is_save="0" >Save</button>
    </li>
    <li class="list-inline-item"><button class="submit_btn btn btn-primary readingnoblanks_listening_speakingupBtn_{{$practise['id']}}" data-is_save="1"  >Submit</button>
    </li>
  </ul>
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



  $(document).on('click',".readingnoblanks_listening_speakingupBtn_{{$practise['id']}}" ,function() {
        if($(this).attr('data-is_save') == '1'){
            $(this).closest('.active').find('.msg').fadeOut();
        }else{
            $(this).closest('.active').find('.msg').fadeIn();
        }
      var reviewPopup = '{!!$reviewPopup!!}';
      var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
        if(markingmethod =="student_self_marking"){
            if($(this).attr('data-is_save') == '1'){

                    // Audioplay1()
                    var AllAudio = new Array();
                    var checkAudioAva = new Array();
                    $('.main-audio-record-div').each(function(){
                        // alert($(this).find('fieldset').html());

                        if($(this).find(".practice_audio").children().attr("src").indexOf("sample-audio.mp3") !== -1){
                            checkAudioAva.push("false");
                            AllAudio.push($(this).html())
                        }else{
                            checkAudioAva.push("true");
                            AllAudio.push($(this).find(".practice_audio").children().attr("src"))
                        }
                    });



                  $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
                  var fullView= $(".save_reading_no_blanks_listening_speaking_down_form_{{$practise['id']}}").clone();
                  $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
                  $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
                  $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
                  $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
                  $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.textarea').attr("contenteditable","false");
                  $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();


                   var tempInc = 0;
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.main-audio-record-div').each(function(){
                        $(this).parent().prepend("<div class='append_"+tempInc+" myclass audio-player ' data="+tempInc+" style='    position: relative;display: flex;align-items: center;margin-bottom: 2rem;'></div>")
                        tempInc++;
                    })
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.main-audio-record-div').each(function(){
                        $(this).remove()
                    }) 
                    // var tempInc = 0;
                    $.each(AllAudio,function(k,v){
                        var audioTemp   = ' <audio preload="auto" controls class="practice_audio answer_audio-{{$practise['id']}}-'+k+'">\
                                              <source src="'+v+'" type="audio/mp3">\
                                          </audio>';
                        var disableIcon = "";
                        if(checkAudioAva[k] ==="true"){
                            $('.append_'+k).append(audioTemp)
                            disableIcon =false;
                            Audioplay("{{$practise['id']}}",k,disableIcon);
                            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}} .append_"+k+" .plyr").css("width","310px");
                        }else{
                            disableIcon =true;
                            $('.append_'+k).append(v)
                            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}} .append_"+k ).css("pointer-events","none");
                        }
                        
                    });



            }
        }
        if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){
            $("#reviewModal_{{$practise['id']}}").modal('toggle');

        }


    $(".readingnoblanks_listening_speakingupBtn_{{$practise['id']}}").attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);

    setTextareaContents();

    $.ajax({
        url: "{{url('save-reading-no-blanks-listening-speaking-down')}}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $(".save_reading_no_blanks_listening_speaking_down_form_{{$practise['id']}}").serialize(),
        success: function (data) {
          $(".readingnoblanks_listening_speakingupBtn_{{$practise['id']}}").removeAttr('disabled');

          if(data.success){
            $('.alert-danger').hide();
            $('.alert-success').show().html(data.message).fadeOut(8000);
          }else{
            $('.alert-success').hide();
            $('.alert-danger').show().html(data.message).fadeOut(8000);
          }

        }
    });

  });

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
