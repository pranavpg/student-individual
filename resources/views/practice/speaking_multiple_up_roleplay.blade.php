<?php
// pr($practise);
  $answerExists = false;
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
  }
  $two_tabs = array();
  $i=0;
  if( !empty( $practise['question'] ) ) {
    $explode_question = explode('##',$practise['question']);
    $two_tabs= explode(' @@', $explode_question[0]);
    $roleplay_question =array();
    array_shift($explode_question);
  }
//pr($practise);
?>
<div class="showPreviousPractice_{{$practise['id']}}  mb-4">
</div>
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
      @if(!empty($two_tabs))
          <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
            @foreach($two_tabs as $key => $value)
              <a href="javascript:;" class="btn btn-dark selected_option selected_option_{{$key}}" data-key="{{$key}}">{{$value}}</a>
            @endforeach
          </div>
          <input type="hidden" name="tabcount" value="{{count($two_tabs)}}">
      @endif
      <div class="two-click-content w-100">
        @if(!empty($explode_question))
        <?php $answer_count=0; ?>
          @foreach($explode_question as $k => $v)
            <div class="content-box multiple-choice d-none selected_option_description selected_option_description_{{$k}}" >
                <?php 
                
                  if(str_contains($v,'@@')){
                   
                    $speakingQuestion = explode(' @@',$v);
                    foreach($speakingQuestion as $kk => $vv){
                ?>
                    <div class="row w-100 d-flex flex-wrap">
                        <div class="col-12 col-lg-12">
                            @include('practice.common.audio_record_div',['key'=>$answer_count])

                        </div>
                    </div>
                            <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$answer_count}}" name="speaking_multiple_up{{$answer_count}}" value="0">
                    <div class="row w-100 d-flex flex-wrap">
                      <div class="col-12 col-lg-12">

                        <p>{!! nl2br($vv) !!}</p>
                        <input type="hidden" name="user_answer[{{$answer_count}}][path]" class="audio_path{{$answer_count}}" value="{{!empty($practise['user_answer'][$answer_count])?$practise['user_answer'][$answer_count]:''}}">
                        <input type="hidden" name="user_answer[{{$answer_count}}][audio_exists]" value="{{ !empty($practise['user_answer'][$answer_count])?1:0}} ">
                      </div>
                    </div>
                      
                    
                    <?php $answer_count++ ?>
                    
              <?php } ?>
                  <input type="hidden" name="user_answer[{{$answer_count}}]" value="##">
              <?php $answer_count++; } else { ?>
                <div class="row w-100 d-flex flex-wrap">
                  <div class="col-12 col-lg-12">
                    @include('practice.common.audio_record_div',['key'=>$k])
                     <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$k}}" name="speaking_multiple_up{{$k}}" value="0">
                  </div>
                </div>
                <div class="row w-100 d-flex flex-wrap">
                  <div class="col-12 col-lg-12">
                    <p>{!! nl2br($v) !!}</p>
                    <input type="hidden" name="user_answer[{{$answer_count}}][path]" class="audio_path{{$k}}" value="{{!empty($practise['user_answer'][$answer_count])?$practise['user_answer'][$answer_count]:''}}">
                    <input type="hidden" name="user_answer[{{$answer_count}}][audio_exists]" value="{{ !empty($practise['user_answer'][$answer_count])?1:0}} ">
                  </div>
                </div>
                  
                
                <?php $answer_count++ ?>
                <input type="hidden" name="user_answer[{{$answer_count}}]" value="##">
            <?php $answer_count++;  } ?>
            </div>
           
          @endforeach
        @endif
      </div>
  </div>
  <!-- ./ Compoent - Two click slider Ends-->

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
<script>
  $(function () {
    $('.form_{{$practise["id"]}}').find(".selected_option").click(function () {
      var content_key = $(this).attr('data-key');
   
      $(".form_{{$practise['id']}}").find('.selected_option').not(this).toggleClass('d-none');
      $('.form_{{$practise["id"]}}').find('.selected_option_description_'+content_key).toggleClass('d-none');
      $('.form_{{$practise["id"]}}').find('.selected_option_description_'+content_key).show();
      $(this).toggleClass('btn-bg');
      roleplayDependent(content_key)
      
      if( $('.form_{{$practise["id"]}}').find('.selected_option_description:visible').length>0 ){
        $(".showPreviousPractice_{{$practise['id']}}").show();
        $('.form_{{$practise["id"]}}').find('.is_roleplay_submit').val(0);
      }else{
        $('.form_{{$practise["id"]}}').find('.is_roleplay_submit').val(1);
        $(".showPreviousPractice_{{$practise['id']}}").hide();
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
    $('.submitBtn_{{$practise["id"]}}').attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);
    setTextareaContent();
    $.ajax({
        url: '<?php echo URL('save-speaking-multiple-single-image'); ?>',
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
</script>

@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==1 && $practise['typeofdependingpractice']!='get_answers_generate_quetions' )
  <script>
    var data=[]
 
    function roleplayDependent(content_key){
      
      data["{{$practise['id']}}"]["typeofdependingpractice"] = "{{$data[$practise['id']]['typeofdependingpractice']}}";
      data["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{$data[$practise['id']]['dependant_practise_question_type']}}";
      if(data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_hide_show" || data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_parentextra" || data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_gen_que_double" || data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" || data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_get_ans" || data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view"){
        data["{{$practise['id']}}"]["dependant_practise_task_id"] =  "{{$data[$practise['id']]['dependant_practise_task_id']}}";
        data["{{$practise['id']}}"]["dependant_practise_id"] = "{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}";
        $(function () {
          $('.cover-spin').fadeIn();
        });
        if(data["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
          
          // IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
          if(data["{{$practise['id']}}"]["dependant_practise_id"] !="" ){
            setTimeout(function(){ 
              var prevHTML = $(document).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').find('.selected_option_description_'+content_key).html();				 
             
              $(".showPreviousPractice_{{$practise['id']}}").html(prevHTML);
              $(".showPreviousPractice_{{$practise['id']}}").css('pointer-events','none');
              $(".showPreviousPractice_{{$practise['id']}}").find('ul.list-buttons').remove();
              if(data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
                if( data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
                  $(".showPreviousPractice_{{$practise['id']}}").find('findset').remove();
                }
              }
              $('.cover-spin').fadeOut();
            }, 1000)
          }
        } else {
          
          // IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
          // DO NOT REMOVE BELOW   CODE
          var baseUrl = "{{url('/')}}";
          data["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{$data[$practise['id']]['dependant_practise_topic_id']}}";
          var dependentURL = baseUrl+'/topic/'+data["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data["{{$practise['id']}}"]["dependant_practise_id"];
          $.get(dependentURL,  //
          function (data, textStatus, jqXHR) {  // success callback
            var prevHTML = $(document).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').find('.selected_option_description_'+content_key).html();				 
             
            $('.showPreviousPractice_'+data["{{$practise['id']}}"]["dependant_practise_id"]).html(prevHTML);
            $(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
            $(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
            if(data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
              
              if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
                $(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
              }
            }
            $('.cover-spin').fadeOut();
          });
        }
      }  
    }
  </script>
@else
<script>
function roleplayDependent(content_key){
  return true;
}
</script>
@endif
<script>
  var token = $('meta[name=csrf-token]').attr('content');
  var upload_url = "{{url('upload-audio')}}";
  var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
</script>
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
