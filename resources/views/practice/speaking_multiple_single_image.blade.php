<p><strong>{!!$practise['title']!!}</strong></p>
<?php
  //  echo '<pre>'; print_r($practise); 
  $answerExists = false;
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
    $answers = $practise['user_answer'];
    $new_answer = array_values(array_filter($answers,
            function($item) {
              return strpos($item, '##') === false;
            }));
    $practise['user_answer'] = $new_answer;
  }
  $two_tabs = array();
  $i=0;
  if(!empty( $practise['question_2'] ) ) {
    foreach ( $practise['question_2'] as $key => $value ) {
      if( str_contains( $value, '{}' ) ){
        $tabs = str_replace('{}', '', $value );
        $two_tabs= explode('@@', $tabs);
      } else if(str_contains($value,'##')){
        $question_list[$i]=array();
      } else {
        $question_list[$i]['question_image'] = isset($practise['question'][$i])?$practise['question'][$i]:'';
        $question_list[$i]['question_text']  = $value;
        $i++;
      }
      $col=6;
    }
    if(!isset($question_list) || empty($question_list)){
      foreach($practise['question'] as $k=> $item){
        $question_list[$k]['question_image'] = $item;
        $question_list[$k]['question_text']='';
      }
      $col=12;
    }
  }
  // pr($question_list);
?>
<?php 
if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) && empty($practise['dependingpractise_answer'][0]) ){
      $depend =explode("_",$practise['dependingpractiseid']);
?>
  <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
      <p style="margin: 15px;">In order to do this task you need to have completed
      <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
  </div>
<?php
} 
else 
{
?>
<!-- Add match answer dependency for level 0 -->
@if(isset($practise['depending_practise_details']))
    @if($practise['depending_practise_details']['question_type'] == "match_answer")
      @php
       $q1       = array();
       $question = explode('#@',$practise['depending_practise_details']['question'][0]);
       $q1       = $practise['depending_practise_details']['question'];
       $q1[0]    = $question[1];
       $q2       = $practise['depending_practise_details']['question_2'];
       $heading  = explode('@@',$question[0]);
      @endphp
      <div class="match-answer mb-4">
       <div class="row"> 
        <div class="col-md-6 col-6 match-answer__block">
              <h3>{{isset($heading[0])?$heading[0]:''}}</h3>
        </div>
        <div class="col-md-6 col-6 match-answer__block">
              <h3>{{isset($heading[1])?$heading[1]:''}}</h3>
        </div>
       </div>
       <div class="match-answer mb-4">
        <div class="match-answer__block">
          <ul class="list-unstyled row">
            <?php
              $background_color_class =  array('match-option-color-one','match-option-color-two','match-option-color-three','match-option-color-four','match-option-color-five','match-option-color-six','match-option-color-seven','match-option-color-eight','match-option-color-nine','match-option-color-ten','match-option-color-eleven','match-option-color-twelve','match-option-color-thirteen','match-option-color-fourteen','match-option-color-fifteen','match-option-color-sixteen','match-option-color-seventeen','match-option-color-eighteen','match-option-color-ninteen','match-option-color-twenty');
            ?>
            @php
             $depending_practice_ans = isset($practise['dependingpractise_answer'][0])?$practise['dependingpractise_answer'][0]:[];
             $depending_practice_ans = explode(";",$practise['dependingpractise_answer'][0]);
             array_pop($depending_practice_ans);
            @endphp
            @php 
             $ans = array(); 
             foreach($depending_practice_ans as $key => $value)
             {
                 if($value != " " && $value != "")
                 {
                   $ans[(int)$value]  = $key;
                 }
                 else
                 {
                     $ans[(int)$value]  = -1;
                 }
             }
            @endphp
            @foreach($q1 as $key => $value)
              @if(!empty(trim($value)))
                @if(!empty($q2[$key]))
                  @if(isset($depending_practice_ans[$key]))
                    @if($depending_practice_ans[$key] != " " && $depending_practice_ans[$key] != "")
                       @php
                        //$new_key = (int)$depending_practice_ans[$key];
                       @endphp
                       <li class="list-item col-12 col-md-6 bg-list-light-gray answer_option answer_option_{{$key}} {{$background_color_class[$key]}}" data-key="{{$key}}">
                        <strong>{!! $value !!}</strong>
                       </li>
                       @if(isset($ans[$key]))
                       @if($ans[$key] == -1)
                         <li class="list-item col-12 col-md-6 bg-list-light-gray answer_option answer_option_{{$key}}" data-key="{{$key}}">
                            <strong>{!! !empty($q2[$key])?$q2[$key]:"" !!}</strong>
                       @else
                         <li class="list-item col-12 col-md-6 bg-list-light-gray answer_option answer_option_{{$key}} {{$background_color_class[$ans[$key]]}}" data-key="{{$key}}">
                            <strong>{!! !empty($q2[$key])?$q2[$key]:"" !!}</strong>
                       </li>
                       @endif
                       @else
                        <li class="list-item col-12 col-md-6 bg-list-light-gray answer_option answer_option_{{$key}}" data-key="{{$key}}">
                            <strong>{!! !empty($q2[$key])?$q2[$key]:"" !!}</strong>
                       @endif
                    @else
                      <li class="list-item col-12 col-md-6 bg-list-light-gray answer_option answer_option_{{$key}}" data-key="{{$key}}">
                        <strong>{!! $value !!}</strong>
                      </li>
                      @if(isset($ans[$key]))
                      @if($ans[$key] !== -1)
                        <li class="list-item col-12 col-md-6 bg-list-light-gray answer_option answer_option_{{$key}} {{$background_color_class[$ans[$key]]}}" data-key="{{$key}}">
                              <strong>{!! !empty($q2[$key])?$q2[$key]:"" !!}</strong>
                      @else
                      <li class="list-item col-12 col-md-6 bg-list-light-gray answer_option answer_option_{{$key}}" data-key="{{$key}}">
                       <strong>{!! !empty($q2[$key])?$q2[$key]:"" !!}</strong>
                      </li>
                      @endif
                      @else
                          <li class="list-item col-12 col-md-6 bg-list-light-gray answer_option answer_option_{{$key}}" data-key="{{$key}}">
                            <strong>{!! !empty($q2[$key])?$q2[$key]:"" !!}</strong>
                      @endif
                    @endif
                  @else
                    <li class="list-item col-12 col-md-6 bg-list-light-gray answer_option answer_option_{{$key}}" data-key="{{$key}}">
                        <strong>{!! $value !!}</strong>
                    </li>
                    <li class="list-item col-12 col-md-6 bg-list-light-gray answer_option answer_option_{{$key}}" data-key="{{$key}}">
                     <strong>{!! !empty($q2[$key])?$q2[$key]:"" !!}</strong>
                    </li>
                  @endif
                @else
                 <li>
                 </li>
                @endif
              @else
              @endif
            @endforeach
          </ul>
         </div>
       </div>
      </div>
    @endif
@endif
<!-- -------------------------------------------------------------->
<div class="set_full_view"></div>
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
      @php
       $roleplayClass = "";
      @endphp
      @if(!empty($two_tabs))
          <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
            @foreach($two_tabs as $key => $value)
              <a href="#!" class="btn btn-dark selected_option selected_option_{{$key.$practise['id']}} ws-{{$practise['id']}}" data-key="{{$key.$practise['id']}}">{{$value}}</a>
            @endforeach
          </div>
          <input type="hidden" name="tabcount" value="{{count($two_tabs)}}">
       @php
        $roleplayClass = "d-none";
       @endphp
      @endif
      
      @if($practise['id'] == "1663929017632d8ab9d9046" || $practise['id'] == "16655831236346c81316db0")
       <div class="two-click-content w-100">
        @if(!empty($question_list))
        <?php $answer_count=0; ?>
        <?php   //echo '<pre>'; print_r($question_list); 
         
         ?>
          @foreach($question_list as $k => $v)
            <?php //$answer_count = $answer_count; 
              // $dnone = ($practise['id'] == "166730514863610ebcd29db" || $practise['id'] == "16630800926320969caa89f" || $practise['id'] ==  "1663926307632d8023be635" ||$practise['id'] =="1665051877633eace53d5cf" || $practise['id'] == "16656408836347a9b346eee" || $practise['id'] == "16666902996357acfb6c1c4" || $practise['id'] == "16653934826343e34a02cb1" || $practise['id'] == "1628080176610a8830a1413" || $practise['id'] == "16631494946321a5b615f2e" || $practise['id'] == "16631687526321f0f0037cf")?'':'d-none';
            ?>
              <div class="content-box multiple-choice selected_option_description selected_option_description_{{$k.$practise['id']}} {{$roleplayClass}}" >
                 @if(isset($v['question_image']))
                  @if($v['question_image'] !="" )
                    <div class="row w-100 d-flex flex-wrap">
                        <div class="col-12 col-lg-{{$col}}">
                            <picture class="picture">
                                <img src="{{$v['question_image']}}" alt="" class="img-fluid">
                            </picture>
                        </div>   
                    </div>
                  @endif
                 @endif
                 <div class="col-12 col-lg-6">
                          <input type="hidden" name="user_answer[{{$k}}][path]" class="audio_path{{$k}}" value="{{!empty($practise['user_answer'][$k])?$practise['user_answer'][$k]:''}}">
                          <input type="hidden" name="user_answer[{{$k}}][audio_exists]" value="{{ !empty($practise['user_answer'][$k])?1:0}} ">


                        </div>
                  <div class="row w-100 d-flex flex-wrap">
                    <div class="col-12 col-lg-12">
                      @if(isset($v['question_text']) && !empty($v['question_text']))
                          <p>{!! nl2br($v['question_text']) !!}</p>
                      @endif
                      @include('practice.common.audio_record_div',['key'=>$k])
                      <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$k}}" name="speaking_multiple_single_image{{$k}}" value="0">
                    </div>
                  </div>
              </div> <?php $answer_count++ ?>
          @endforeach
        @endif
      </div>
      @else
      <div class="two-click-content w-100">
        @if(!empty($question_list))
        <?php $answer_count=0; ?>
        <?php   //echo '<pre>'; print_r($question_list); 
          //dd($practise['user_answer']);
         ?>
          @foreach($question_list as $k => $v)
            <?php //$answer_count = $answer_count; 
              // $dnone = ($practise['id'] == "166730514863610ebcd29db" || $practise['id'] == "16630800926320969caa89f" || $practise['id'] ==  "1663926307632d8023be635" ||$practise['id'] =="1665051877633eace53d5cf" || $practise['id'] == "16656408836347a9b346eee" || $practise['id'] == "16666902996357acfb6c1c4" || $practise['id'] == "16653934826343e34a02cb1" || $practise['id'] == "1628080176610a8830a1413" || $practise['id'] == "16631494946321a5b615f2e" || $practise['id'] == "16631687526321f0f0037cf")?'':'d-none';
            ?>
              <div class="content-box multiple-choice selected_option_description selected_option_description_{{$k.$practise['id']}} {{$roleplayClass}}" >
                 @if(isset($v['question_image']))
                  @if($v['question_image'] !="" )
                    <div class="row w-100 d-flex flex-wrap">
                        <div class="col-12 col-lg-{{$col}}">
                            <picture class="picture">
                                <img src="{{$v['question_image']}}" alt="" class="img-fluid">
                            </picture>
                        </div>
                        <div class="col-12 col-lg-6">
                          <input type="hidden" name="user_answer[{{$answer_count}}][path]" class="audio_path{{$k}}" value="{{!empty($practise['user_answer'][$answer_count])?$practise['user_answer'][$answer_count]:''}}">
                          <input type="hidden" name="user_answer[{{$answer_count}}][audio_exists]" value="{{ !empty($practise['user_answer'][$answer_count])?1:0}} ">
                        </div>
                    </div>
                  @endif
                 @endif
                  <div class="row w-100 d-flex flex-wrap">
                    <div class="col-12 col-lg-12">
                      @if(isset($v['question_text']) && !empty($v['question_text']))
                          <p>{!! nl2br($v['question_text']) !!}</p>
                      @endif
                      @include('practice.common.audio_record_div',['key'=>$k])
                      <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$k}}" name="speaking_multiple_single_image{{$k}}" value="0">

                    </div>
                  </div>
              </div> <?php $answer_count++ ?>
              <input type="hidden" name="user_answer[{{$answer_count++}}]"value="##">
           
          @endforeach
        @endif
      </div>
      @endif
  </div>
  <!-- ./ Compoent - Two click slider Ends-->
  <!-- /. List Button Start-->
  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
  <ul class="list-inline list-buttons">
      <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"
              data-toggle="modal" id="{{$practise['id']}}" data-is_save="0" data-target="#exitmodal">Save</button>
      </li>
      <li class="list-inline-item"><button type="button"
              class="submit_btn btn btn-primary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1">Submit</button>
      </li>
  </ul>
</form>
<?php 
}
?>
<script>
//$(function () {
    $(".ws-{{$practise['id']}}").click(function () {
      var content_key = $(this).attr('data-key');
      // alert(content_key);
      $('.selected_option').not(this).toggleClass('d-none');
      $('.selected_option_description_'+content_key).toggleClass('d-none');
      $('.selected_option_'+content_key).fadeIn();
      $(this).toggleClass('btn-bg');
    //  alert($('.selected_option_description:visible').length)
      // if( $('.selected_option_description:visible').length>0 ){
        $('.is_roleplay_submit').val(0);
      // }else{
      //   $('.is_roleplay_submit').val(1);
      // }
    });
//});

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
   if($(this).attr('data-is_save') == '1'){ 
    $('.is_roleplay_submit').val(0);
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
var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
</script>
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
