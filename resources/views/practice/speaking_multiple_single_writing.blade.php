<p>
	<strong><?php 	echo $practise['title']; ?></strong>
</p>
<?php
   //pr($practise);
  $exp_question = explode(PHP_EOL, $practise['question']);
  //pr($exp_question);
	  $answerExists = false;

		if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
			$answerExists = true;
		}
?>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
	<input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

  <div class="multiple-choice">
  	 <?php $answer_count=0; ?>
      @if(!empty($exp_question))
        @foreach($exp_question as $key=> $value)
          <p class="mb-3">{{$value}}</p>
          @include('practice.common.audio_record_div',['q'=> $key])
          			 <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$key}}" name="speaking_multiple_single_writing_{{$key}}" value="0">
					<input type="hidden" name="text_ans[{{$key}}][path]" class="audio_path{{$key}}" value="{{!empty($practise['user_answer'][$key]['path'])?$practise['user_answer'][$key]['path']:''}}">
					<input type="hidden" name="text_ans[{{$key}}][audio_exists]" value="{{ !empty($practise['user_answer'][$key]['path'])?1:0}}">
					@if( $key > 0)
						<input type="hidden" name="text_ans[{{$key}}][text_ans]" value="" >
					@endif
					 <?php //$answer_count++; ?>
        @endforeach
      @endif


      <!--Component Form Slider-->
      <div class="form-slider p-0 mb-4">
        <div class="component-control-box">
          <span class="textarea form-control form-control-textarea" role="textbox"
							contenteditable placeholder="Write here...">
							<?php
								if ($answerExists)
								{
										echo  $practise['user_answer'][0]['text_ans'][0];
								}
							?>
					</span>
					<div style="display:none">
						<textarea name="text_ans[0][text_ans][0]">
						<?php
								if ($answerExists)
								{
									echo  $practise['user_answer'][0]['text_ans'][0];
								}
						?>
						</textarea>

					</div>
        </div>
      </div>
  </div>

  <!-- /. List Button Start-->
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
<script type="text/javascript">
function setTextareaContent(){
	$('.form_{{$practise["id"]}}').find("span.textarea.form-control").each(function(){
		var currentVal = $(this).html();
		$(this).next().find("textarea").val(currentVal);
	});
}

$(document).on('click','.submitBtn_{{$practise["id"]}}' ,function() {
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

					// alert(AllAudio)
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
                    var fullView= $(".form_{{$practise['id']}}").html();
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.textarea').attr("contenteditable",false);

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
						var audioTemp 	= ' <audio preload="auto" controls class="practice_audio answer_audio-{{$practise['id']}}-'+k+'">\
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
	var $this = $(this);

  $this.attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.form_{{$practise["id"]}}').find('.is_save:hidden').val(is_save);
  setTextareaContent();
  $.ajax({
      url: '<?php echo URL('save-speaking-multiple-single-writing'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('.form_{{$practise["id"]}}').serialize(),
      success: function (data) {
        $this.removeAttr('disabled');
				if(data.success){
					$('.form_{{$practise["id"]}}').find('.alert-danger').hide();
					$('.form_{{$practise["id"]}}').find('.alert-success').show().html(data.message).fadeOut(8000);
				} else {
					$('.form_{{$practise["id"]}}').find('.alert-success').hide();
					$('.form_{{$practise["id"]}}').find('.alert-danger').show().html(data.message).fadeOut(8000);
				}
      }
  });
});

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

var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
/*$('.delete-icon').on('click', function() {
	$(this).parent().find('.stop-button').hide();
	$(this).parent().find('.practice_audio').attr('src','');
	$(this).parent().find('.audioplayer-bar-played').css('width','0%');
	$(this).hide();
	$(this).parent().find('div.audio-element').css('pointer-events','none');
	$(this).parent().find('.record-icon').show();
	$(this).parent().find('.stop-button').hide();
	var practise_id = $('.practise_id:hidden').val();
	var audio_key= $(this).attr('data-key');
	$.ajax({
      url: '<?php //echo URL('delete-audio'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: {practice_id:practise_id, audio_key:audio_key},
      success: function (data) {

      }
  });
});*/
</script>
