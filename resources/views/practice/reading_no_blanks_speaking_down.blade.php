<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
  // pr($practise);
  $answerExists = false;
  if(!empty($practise['user_answer'])){
    $answerExists = true;
    //  pr($practise['user_answer']);
    $answer = $practise['user_answer'][0]['text_ans'];
  }
  $practise['question'] = nl2br($practise['question']);
  $exploded_question = explode(PHP_EOL,$practise['question']);
  $json_encoded_question = json_encode($exploded_question, true);
  $count = 0;
?>
@if(!empty($exploded_question))
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

  <div class="multiple-choice mb-4">
    
    @foreach($exploded_question as $key => $value)
      

            <?php
            if(!empty($answer)){
                $exp_answer = array_filter(explode(';',$answer));
              //  pr($exp_answer);
            }
            if(str_contains($value,'@@')){

               echo $outValue = preg_replace_callback('/@@/',function ($m) use (&$key, &$count, &$exp_answer) {
                    $ans= !empty($exp_answer[$count])?trim($exp_answer[$count]):"";
                    $count++;
                    $str = '<span style="padding-bottom: 0px !important; line-height: 19px !important;" class="textarea d-inline-flex mw-20 form-control form-control-textarea conversation_answer_'.$count.'" role="textbox" contenteditable placeholder="Write here...">'.$ans.'</span><input type="hidden" name="text_ans[]" value="'.$ans.'">';
                    return $str;
                    }, $value);
            }else{
                echo "<div style='margin-top:15px;'>".$value."</div>";
            }
            
            if( $key%2==0 ){
                $class="mr-auto mb-4";
            } else {
                $class="convrersation-box__dark ml-auto mb-4";
            }

            ?>
      
    @endforeach
  </div>

@endif
<input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="audio_reading" value="0">
@include('practice.common.audio_record_div',['key'=>0])
<div class="alert alert-success" role="alert" style="display:none"></div>
<div class="alert alert-danger" role="alert" style="display:none"></div>
<ul class="list-inline list-buttons">
    <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"
            data-toggle="modal" data-is_save="0" data-target="#exitmodal"  >Save</button>
    </li>
    <li class="list-inline-item"><button type="button"
            class="submit_btn btn btn-primary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1" >Submit</button>
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
<script>
function setInputContent(){
  $('.form_{{$practise["id"]}}').find("span.textarea.form-control").each(function(i){
    var currentVal = $(this).html();
    //  console.log(i,'====>,',currentVal)
    if($.trim(currentVal)!=""){

      $(this).next().val(currentVal);
    }
  });
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


$('.form_{{$practise["id"]}}').on('click','.submitBtn_{{$practise["id"]}}' ,function() {

            if($(this).attr('data-is_save') == '1'){
              $(this).closest('.active').find('.msg').fadeOut();
          }else{
              $(this).closest('.active').find('.msg').fadeIn();
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



                    var fullView= $(".form_{{$practise['id']}}").html();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.textarea').attr('contenteditable',false);


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

  $('.submitBtn_{{$practise["id"]}}').attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.is_save:hidden').val(is_save);
    setInputContent();
  $.ajax({
      url: '<?php echo URL('save-reading-no-blanks-speaking-down'); ?>',
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
$(document).on('click','.delete-icon', function() {
  $(this).parent().find('.stop-button').hide();
  $(this).parent().find('.practice_audio').attr('src','');
  $(this).parent().find('.audioplayer-bar-played').css('width','0%');
  $(this).hide();
  $(this).parent().find('div.audio-element').css('pointer-events','none');
  $(this).parent().find('.record-icon').show();
  $(this).parent().find('.stop-button').hide();
  var practise_id = $('.practise_id:hidden').val();
	$.ajax({
      url: '<?php echo URL('delete-audio'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: {practice_id:practise_id},
      success: function (data) {

      }
  });
//	$('.audio-element').html('').append('<div class="audio-player d-flex flex-wrap justify-content-end"><audio preload="auto" controls class="practice_audio"> <source src="{{asset("public/horse.mp3")}}" type="audio/mp3"> </audio></div>');
});
</script>
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
