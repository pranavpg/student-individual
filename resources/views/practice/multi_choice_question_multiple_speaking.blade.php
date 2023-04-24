<p><strong>{!!$practise['title']!!}</strong></p>
<?php
//pr($practise);
//pr(json_encode($practise['user_answer']));
$exp_question = explode(PHP_EOL, $practise['question']);

?>
<style>
.multi_choice_question_ms .custom-checkbox .custom-control-label:before {
    border-color: #007bff;
    background-color: #fff !important;
}

.multi_choice_question_ms .multiple-check .custom-control-input:checked~.custom-control-label:after, .multiple-check .custom-control-input:checked~.custom-control-label:before {
    border-color: #d55b7d !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    outline: none !important;
    background-color: #d55b7d !important;
    background-image: url(https://s3.amazonaws.com/imperialenglish.co.uk/ieukstudentpublic/images/icon-custom-check.svg) !important;
    background-position: center !important;
    background-repeat: no-repeat !important;
    background-size: 18px auto !important;
}
</style>
<!-- Compoent - Two click slider-->
<form class="multi_choice_question_ms form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_type" name="practise_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
<!-- /.Audio Player-->
  @if(!empty($exp_question))
    <div class="multiple-choice multiple-check">
      @foreach($exp_question as $key => $value)
   
        <div class="choice-box">
          <p> {{ substr(strstr($value, '.'), 1)}} </p>
          <?php
              $userAnswer=array();
              //pr($practise['user_answer'][0]['text_ans']);
               if(isset($practise['user_answer'][0]['text_ans'][$key]['ans']) && !empty($practise['user_answer'][0]['text_ans'][$key]['ans'])){
                 $userAnswer= explode(":",$practise['user_answer'][0]['text_ans'][$key]['ans']);
               }
              // pr()
          ?>
          <div class="d-flex ieukcc-boxo">
            @foreach($practise['options'][$key] as $k => $v )
              <?php $ans_val = $k."@@".$v; ?>
              <div class="custom-control custom-checkbox w-md-33">
                  <input type="checkbox" class="custom-control-input" id="cc_{{$key}}_{{$k}}_{{$v}}" name="user_answer[{{$key}}][]" value="{{$ans_val}}" <?php if(!empty($userAnswer) && (in_array($v, $userAnswer))){ echo "checked";}?>>
                  <label class="custom-control-label" for="cc_{{$key}}_{{$k}}_{{$v}}">{{$v}}</label>
              </div>
            @endforeach
          </div>
        </div>
        <input type="hidden" name="user_default_answer[]" value="{{$value}}" >

      @endforeach
      <!-- /. Choice Box -->
    </div>
  @endif
  <!-- Audio Player-->
  @include('practice.common.audio_record_div',['key'=>0])
  <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="multi_choice_question_multiple_speaking" value="0">

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
<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<script>

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
$(document).on('click','.submitBtn_{{$practise["id"]}}' ,function() {

              // alert(('.record_{{$practise["id"]}} .audioplayer'))
              // alert($('.record_'+$(this).attr("data-pid")+' .audioplayer').hasClass("audioplayer-playing"));

                if($(this).attr('data-is_save') == '1'){
                  $(this).closest('.active').find('.msg').fadeOut();
              }else{
                  $(this).closest('.active').find('.msg').fadeIn();
              }
              

            if($('.record_'+$(this).attr("data-pid")+' .audioplayer').hasClass("audioplayer-playing")){
                $('.audioplayer-playpause').click()
            }
            var reviewPopup = '{!!$reviewPopup!!}';
            var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){


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
                    var fullView= $(".form_{{$practise['id']}}").clone();
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
				          	$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.custom-control').css("pointer-events","none");


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

  $('.submitBtn').attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.is_save:hidden').val(is_save);

  $.ajax({
      url: '<?php echo URL('save-multi-choice-question-multiple-speaking'); ?>',
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
