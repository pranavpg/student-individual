@if($practise['id']  == "1662980569631f11d97c744" OR $practise['id'] == "1662980928631f13404a739" )
   @include('practice.speaking_multiple_listening_level0')
@else
<?php
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
 // echo '<pre>'; print_r($practise);
?>
<div class="showPreviousPractice_{{$practise['id']}}  mb-4"></div>
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
        @foreach($two_tabs as $key => $value)
          <div class="content-box multiple-choice d-none selected_option_description selected_option_description_{{$key}}">
            <div class="showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}  mb-4">
            </div>
          </div>
        @endforeach
      @endif
      @if(!empty($two_tabs))
          <div class="row two-click justify-content-center mb-4 w-100 mx-auto">
            @foreach($two_tabs as $key => $value)
              <a href="javascript:;" class="btn btn-dark selected_option selected_option_{{$key}} mw-100 mx-1 my-1 mx-md-1 col-5 col-sm-5 col-md-3 col-lg-3 col-xl-3" data-key="{{$key}}">{{$value}}</a>
            @endforeach
          </div>
          <input type="hidden" name="tabcount" value="{{count($two_tabs)}}">
      @endif
      <?php
        //pr($explode_question);
      ?>
      <div class="two-click-content w-100">
        @if(!empty($explode_question))
        <?php $answer_count=0; ?>

          @foreach($explode_question as $k => $v)
            <div class="content-box multiple-choice d-none selected_option_description selected_option_description_{{$k}}" >
                <?php  
                  //  print_r($v);
                  if(str_contains($v,'@@')){
                    $speakingQuestion = explode('@@',$v);
                    // echo '<pre>'; print_r($speakingQuestion); 
                     $answer_count = 0;
                    foreach($speakingQuestion as $kk => $vv){
                      if(isset($vv) && !empty($vv)){
                ?>
                    <div class="row w-100 d-flex flex-wrap">
                      <div class="col-12 col-lg-12">

                        <p>{!! nl2br($vv) !!}</p>
                        <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$answer_count}}" name="user_answer[{{$answer_count}}][audio_deleted]" value="0">
                        <input type="hidden" name="user_answer[{{$answer_count}}][path]" class="audio_path{{$answer_count}}" value="{{!empty($practise['user_answer'][$answer_count])?$practise['user_answer'][$answer_count]:''}}">
                        <input type="hidden" name="user_answer[{{$answer_count}}][audio_exists]" value="{{ !empty($practise['user_answer'][$answer_count])?1:0}} ">
                      </div>
                    </div>
                    <div class="row w-100 d-flex flex-wrap">
                      <div class="col-12 col-lg-12">
                        @include('practice.common.audio_record_div',['key'=>$answer_count])
                      </div>
                    </div>
                    <?php $answer_count++; 
                    ?>
              <?php 
                      }
                } 
             ?>
              <input type="hidden" name="user_answer[{{$answer_count}}]" value="##">
          
              <?php   $answer_count++; } else { ?>
             <?php //$answer_count = 1; ?>
                <div class="row w-100 d-flex flex-wrap">
                  <div class="col-12 col-lg-12">
                    <p>{!! nl2br($v) !!}</p>
                    <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$answer_count}}" name="user_answer[{{$answer_count}}][audio_deleted]" value="0">                  
                    <input type="hidden" name="user_answer[{{$answer_count}}][path]" class="audio_path{{$answer_count}}" value="{{!empty($practise['user_answer'][$answer_count])?$practise['user_answer'][$answer_count]:''}}">
                    <input type="hidden" name="user_answer[{{$answer_count}}][audio_exists]" value="{{ !empty($practise['user_answer'][$answer_count])?1:0}} ">
                  </div>
                </div>
                <div class="row w-100 d-flex flex-wrap">
                  <div class="col-12 col-lg-12">
                   @include('practice.common.audio_record_div',['key'=> $answer_count])
                  </div>
                </div>
                <?php $answer_count++ ?>
                <input type="hidden" name="user_answer[{{$answer_count}}]" value="##">
            <?php $answer_count++;} ?>
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
      $(".showPreviousPractice_{{$practise['id']}}").html("")
      if( $('.form_{{$practise["id"]}}').find('.selected_option_description:visible').length>0 ){
        roleplayDependent(content_key)
        $(".showPreviousPractice_{{$practise['id']}}").show();
        $('.form_{{$practise["id"]}}').find('.is_roleplay_submit').val(0);
      }else{
        $('.form_{{$practise["id"]}}').find('.is_roleplay_submit').val(1);
        $(".showPreviousPractice_{{$practise['id']}}").hide();
        $(".showPreviousPractice_{{$practise['id']}}").html("")
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
 
      var da5ata=[];
    function roleplayDependent(content_key){
      da5ata["{{$practise['id']}}"] = new Array();
      // alert(da5ata["{{$practise['id']}}"]["typeofdependingpractice"])
      da5ata["{{$practise['id']}}"]["typeofdependingpractice"] = "{{$data[$practise['id']]['typeofdependingpractice']}}";
      da5ata["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{$data[$practise['id']]['dependant_practise_question_type']}}";
      if(da5ata["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_hide_show" || da5ata["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_parentextra" || da5ata["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_gen_que_double" || da5ata["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero_parentextra_get_questions_and_answers" || da5ata["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" || da5ata["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_get_ans" || da5ata["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view"){
        da5ata["{{$practise['id']}}"]["dependant_practise_task_id"] =  "{{$data[$practise['id']]['dependant_practise_task_id']}}";
        da5ata["{{$practise['id']}}"]["dependant_practise_id"] = "{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}";
        $(function () {
          $('.cover-spin').fadeIn();
        });
        if(da5ata["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
          
          // IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
          if(da5ata["{{$practise['id']}}"]["dependant_practise_id"] !="" ){
            setTimeout(function(){ 
              //-----for level 0-------------
              if(da5ata["{{$practise['id']}}"]["dependant_practise_id"]!= "16656582096347ed6156e82")
              {
                    var prevHTML = $(document).find('.course-tab-content').find('#abc-'+da5ata["{{$practise['id']}}"]["dependant_practise_id"]).find('form').find('.selected_option_description_'+content_key).html();  
              }
              else
              {
                    var prevHTML = $(document).find('.course-tab-content').find('#abc-'+da5ata["{{$practise['id']}}"]["dependant_practise_id"]).find('form').find('.lv0_selected_option_description_'+content_key).html();       
              }  
              $(".showPreviousPractice_{{$practise['id']}}").html(prevHTML);
              $(".showPreviousPractice_{{$practise['id']}}").css('pointer-events','none');
              $(".showPreviousPractice_{{$practise['id']}}").find('ul.list-buttons, input:hidden, textarea').remove();
              if(da5ata["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" ){
                
                if( da5ata["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up" || da5ata["{{$practise['id']}}"]["dependant_practise_question_type"] == "single_speaking_up_writing") {
                  $(".showPreviousPractice_{{$practise['id']}}").find('fieldset').remove();
                }
              }
              $('.cover-spin').fadeOut();
            }, 8000)
          }
        } else {
          
          // IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
          // DO NOT REMOVE BELOW   CODE
          var baseUrl = "{{url('/')}}";
          da5ata["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{$data[$practise['id']]['dependant_practise_topic_id']}}";
          var dependentURL = baseUrl+'/topic/'+da5ata["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+da5ata["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+da5ata["{{$practise['id']}}"]["dependant_practise_id"];
          $.get(dependentURL,  //
          function (dataHtml, textStatus, jqXHR) {  // success callback
            var prevHTML = $(dataHtml).find('.course-tab-content').find('#abc-'+da5ata["{{$practise['id']}}"]["dependant_practise_id"]).find('form').find('.selected_option_description_'+content_key).html();         
            // alert(da5ata["{{$practise['id']}}"]["dependant_practise_id"]);
            $('.showPreviousPractice_'+da5ata["{{$practise['id']}}"]["dependant_practise_id"]).html(prevHTML);
            $(".showPreviousPractice_"+da5ata["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
            $(".showPreviousPractice_"+da5ata["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, input:hidden, textarea').remove();
            if(da5ata["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view" && da5ata["{{$practise['id']}}"]["dependant_practise_question_type"] == "speaking_writing"){
                $(".showPreviousPractice_"+da5ata["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
            }
            if(da5ata["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
              
              if(da5ata["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up" || da5ata["{{$practise['id']}}"]["dependant_practise_question_type"] == "speaking_writing") {
              // alert();
                $(".showPreviousPractice_"+da5ata["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
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
@endif