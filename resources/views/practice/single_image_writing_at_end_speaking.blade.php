<p><strong>{!!$practise['title']!!}</strong></p>
<style type="text/css">
  #iframe_aim2 {
    height: 100%;
    width: 100%;
  }
</style>
<?php
//pr($practise);
  $answerExists = false;
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
    $answers = $practise['user_answer'];
    //echo $answers[0]['text_ans'][0];die;
  }
  $tabs = array();
  $i=0;
  if( !empty( $practise['question_2'] ) ) {
    foreach ( $practise['question_2'] as $key => $value ) {
      if( str_contains( $value, '{}' ) ){
        $tabs = str_replace('{}', '', $value );
        $tabs= explode('@@', $tabs);
      } else if(str_contains($value,'##')){
        $i++;
        $question_list[$i]  =array();
      } else {
        //$question_list[$i]['question_image'] = $practise['question'][$i];
        $question_list[$i][$key] = str_replace('@@', '', $value);

      //    $i++;

      }
    }
  }
?>
<!-- Compoent - Two click slider-->
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_type" name="practise_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  <input type="hidden" name="is_roleplay" value="true" >
  <input type="hidden" class="is_roleplay_submit" name="is_roleplay_submit" value="1">

  <!-- Compoent - Two click slider-->
  <div class="component-two-click mb-4">
      @if(!empty($tabs))
          <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
            @foreach($tabs as $key => $value)
              <a href="#!" class="btn btn-dark selected_option selected_option_{{$key}}" data-key="{{$key}}">{{$value}}</a>
            @endforeach
          </div>
      @endif
      @if(!empty($question_list))
        <?php $j = 0;
          $count=0;
          $last_key = array_key_last($question_list);
        ?>
          <div class="two-click-content w-100">
            @foreach($question_list as $q_key=>$q_value)
              <div class="content-box multiple-choice d-none selected_option_description selected_option_description_{{$count}}" >
                <picture class="picture d-block mb-4">
                    <img src="{{$practise['question'][$count]}}" alt=""
                        class="img-fluid picture-with-border d-block mr-auto ml-auto">
                </picture>
                <?php $kk=0; ?>
                @foreach($q_value as $k=>$v)

                  <p class="mb-0">{!! $v !!}</p>
                  <!-- Component - Form Control-->
                  <div class="form-group">
                    <span class="textarea form-control form-control-textarea main-answer stringProper text-left enter_disable" role="textbox" contenteditable placeholder="Write here..."><?php if ($answerExists) { echo  !empty($answers[$j]['text_ans'][$kk])?nl2br($answers[$j]['text_ans'][$kk]):"";}?></span>
                    <div style="display:none">

                      <textarea name="user_answer[{{$j}}][text_ans][{{$kk}}]" class="main-answer-input">
                      <?php
                          if($answerExists)
                          {
                            echo  !empty($practise['user_answer'][$j]['text_ans'][$kk])?$practise['user_answer'][$j]['text_ans'][$kk]:"";
                          }
                      ?>
                      </textarea>
                    </div>
                  </div>

                <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$kk}}" name="single_image_writing_at_end_speaking[{{$kk}}]" value="0">
                  <?php $kk++; ?>
                @endforeach
                <!-- /. Component - Form Control End-->
                
                @include('practice.common.audio_record_div',['key'=>$j])
                



              </div>
              <input type="hidden" name="user_answer[{{$j}}][audio_exists]" value="{{ !empty($practise['user_answer'][$j]['path'])?1:0}}">
              <input type="hidden" name="user_answer[{{$j}}][path]" class="audio_path{{$j}}" value="{{!empty($practise['user_answer'][$j]['path'])?$practise['user_answer'][$j]['path']:''}}">
              <?php $j++;
                if($last_key!=$q_key ){
              ?>
                <input type="hidden" name="user_answer[{{$j}}]" value="##">
              <?php } $j++; $count++;?>
            @endforeach
          </div>

      @endif
  </div>
  <!-- ./ Compoent - Two click slider Ends-->

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
<script>
$(function () {

    $(".selected_option").click(function () {
      var content_key = $(this).attr('data-key');
      $('.selected_option').not(this).toggleClass('d-none');
      $('.selected_option_description_'+content_key).toggleClass('d-none');
      $('.selected_option_'+content_key).show();
      $(this).toggleClass('btn-bg');
      //  alert($('.selected_option_description:visible').length)
      if( $('.selected_option_description:visible').length>0 ){
        $('.is_roleplay_submit').val(0);
      } else {
        $('.is_roleplay_submit').val(1);
      }
    });
});

function setTextareaContent(){
	$("span.textarea.form-control").each(function(){
		var currentVal = $(this).html();
		$(this).next().find("textarea").val(currentVal);
	})
}

$(document).on('click','.submitBtn_{{$practise["id"]}}' ,function() {
  if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }
  $('.submitBtn').attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.is_save:hidden').val(is_save);
  setTextareaContent();
  $.ajax({
      url: '<?php echo URL('save-single-image-writing-at-end-speaking-new'); ?>',
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
