<p><strong>{!!$practise['title']!!}</strong></p>
<?php

  $answerExists = false;
  //pr($practise['user_answer']);
  $q1=array();
  $q2=array();
  $answerExists = false;
  // dd($practise);
  if(!empty($practise['user_answer'])){
      $answerExists = true;
      $user_ans_student_a = $practise['user_answer'][0]!=""?explode(';',$practise['user_answer'][0]['text_ans']):[];
      array_pop($user_ans_student_a);
      $user_ans_student_b = !empty( $practise['user_answer'][2]['text_ans'] ) ? explode(';',$practise['user_answer'][2]['text_ans']) : "";
      if(!empty($user_ans_student_b)){
        array_pop($user_ans_student_b);
      }
  }
  //pr($user_ans);
  $two_tabs = array();


  if( !empty( $practise['question_2'] ) ) {
    $j=-1;
    foreach ( $practise['question_2'] as $key => $value ) {
      if( str_contains( $value, '{}' ) ){

        $tabs = str_replace('{}', '', $value );
        $two_tabs= explode('@@', $tabs);

      } else if( str_contains($value,'##') ) {
        $i=0;
        $j++;
        $question_list[$j]['question_left'][$i]=array();

      } else if( str_contains($value,'#@') ) {

        $explode_question = explode( '#@', $value);
        $explode_question_header = explode( '@@', $explode_question[0]);
        $question_list[$j]['question_left'][$i] = $explode_question_header[0];
        $question_list[$j]['question_right'][0] = $explode_question_header[1];
        $i++;
        $question_list[$j]['question_left'][$i] = $explode_question[1];
        $i++;

      }
      else {

        $question_list[$j]['question_left'][$i]= $value;

        $i++;

      }
    }
  }

  if( !empty( $practise['question_3'] ) ) {
      $i=1;
    $k=0;
    foreach ( $practise['question_3'] as $key => $value ) {

      if( $k==0 && $value!="##" ) {
        $question_list[$k]['question_right'][$i]= $value;
        $i++;
      }

      if($k==1 && $value!="##") {
        $question_list[$k]['question_right'][$i]= $value;
        $i++;
      }

      if( str_contains($value,'##') ) {
        $i=1;
        $k++;
      }

    }
  }
  //pr($question_list);

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
      @if(!empty($two_tabs))
          <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
            @foreach($two_tabs as $key => $value)
              <a href="#!" class="btn btn-dark selected_option selected_option_{{$key}}" data-key="{{$key}}">{{$value}}</a>
            @endforeach
          </div>
      @endif
      <div class="two-click-content w-100">
        @if(!empty($question_list))
        <?php
            $answer_count=0;
            $dd=0;
            $background_color_class =  array('match-option-color-one','match-option-color-two','match-option-color-three','match-option-color-four','match-option-color-five','match-option-color-six','match-option-color-seven','match-option-color-eight','match-option-color-nine','match-option-color-ten','match-option-color-eleven','match-option-color-twelve','match-option-color-thirteen','match-option-color-fourteen','match-option-color-fifteen','match-option-color-sixteen','match-option-color-seventeen','match-option-color-eighteen','match-option-color-ninteen','match-option-color-twenty');
         ?>
         <input type="hidden" name="user_ans[1]" value="##">
          @foreach($question_list as $k => $v)
            <?php $answer_count = $answer_count + $k; ?>
              <div class="match-answer  mb-4 d-none selected_option_description selected_option_description_{{$k}}" >
                <picture class="picture d-block mb-4">
                    <img src="{{$practise['question'][$k]}}" alt="" height="350px"
                        class="img-fluid picture-with-border d-block mr-auto ml-auto">
                </picture>
                  <div class="row">
                    @if(!empty($question_list[$k]))

                      <div class="col-md-6 match-answer__block">
                          <h3>{{$question_list[$k]['question_left'][0]}}</h3>
                      </div>
                    @endif
                    @if(!empty($question_list[$k]))
                      <div class="col-md-6 match-answer__block">
                          <h3>{{$question_list[$k]['question_right'][0]}}</h3>
                      </div>
                    @endif
                  </div>
                  <div class="match-answer__block">
                      <ul class="list-unstyled row">
                        <?php
                          array_shift($question_list[$k]['question_left']);
                          array_shift($question_list[$k]['question_right']);
                              ?>
                        @foreach($question_list[$k]['question_left'] as $kleft => $vleft)
                          @if(!empty(trim($value)))
                            <li class="list-item col-12 col-md-6 bg-list-light-gray  question_option qo_{{$k}}  question_option_{{$kleft}}" data-k="{{$k}}" data-key="{{$kleft}}" data-bgcolor="{{$background_color_class[$kleft]}}">
                              {!!  $vleft !!}
                              <input type="hidden" name="user_ans[{{$answer_count}}][text_ans][]" value=" " class="hidden">
                              <input type="hidden" name="user_ans[{{$answer_count}}][path]" value="{{$practise['question'][$k]}}">
                            </li>
                            <li class="list-item col-12 col-md-6 bg-list-light-gray  answer_option  ao_{{$k}} answer_option_{{$kleft}}" data-k="{{$k}}" data-key="{{$kleft}}" data-bgcolor="{{$background_color_class[$kleft]}}">
                              {!!  $question_list[$k]['question_right'][$kleft] !!}
                            </li>
                          @endif
                        @endforeach
                      </ul>
                      @include('practice.common.audio_record_div',['key'=>($k==0)?$k:$k+1])
                      <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$dd}}" name="match_answer_single_image_speaking_up{{$dd}}" value="0">

                  </div>
              </div>
            <?php $dd=$dd+2; $answer_count++ ?>
          @endforeach
        @endif
      </div>
  </div>
  <!-- ./ Compoent - Two click slider Ends-->

  <!-- /. List Button Start-->


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
      }else{
        $('.is_roleplay_submit').val(1);
      }
    });
});


</script>

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

  var token = $('meta[name=csrf-token]').attr('content');
  var upload_url = "{{url('upload-audio')}}";
  var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
</script>
<script>

$(window).on('load', function() {

    <?php if($answerExists): ?>

        var colors = <?php echo json_encode($background_color_class) ?>;

        var user_answers_a = <?php echo json_encode($user_ans_student_a) ?>;
        console.log('----)',user_answers_a)
        var submit_answer_a = [];
        $('.qo_0').each(function(i){
            var c_class = parseInt(user_answers_a[i]); //4
            if(isNaN(c_class) == false){
                $('.qo_0:eq('+i+')').addClass(colors[i]);
                $('.qo_0:eq('+i+')').addClass(' confirmed active-bg');
                $('.qo_0:eq('+i+')').find('input.hidden').val(c_class);
            } else {
                $('.qo_0:eq('+i+')').find('input.hidden').val(" ");
            }
        });

        $('.ao_0').each(function(i){
            var c_class = parseInt(user_answers_a[i]);
            if(isNaN(c_class) == false){
                $('.ao_0:eq('+c_class+')').addClass(colors[i]);
                submit_answer_a.push({ "id": i , "value" : c_class});
            } else{
                submit_answer_a.push({ "id": i , "value" : " "});
            }
        });


        var user_answers_b = <?php echo json_encode($user_ans_student_b) ?>;
        var submit_answer_b = [];
        $('.qo_1').each(function(i){
            var c_class = parseInt(user_answers_b[i]); //4
            if(isNaN(c_class) == false){
                $('.qo_1:eq('+i+')').addClass(colors[i]);
                $('.qo_1:eq('+i+')').addClass(' confirmed active-bg');
                $('.qo_1:eq('+i+')').find('input.hidden').val(c_class);
            } else {
                $('.qo_1:eq('+i+')').find('input.hidden').val(" ");
            }
        });

        $('.ao_1').each(function(i){
            var c_class = parseInt(user_answers_b[i]);
            if(isNaN(c_class) == false){
                $('.ao_1:eq('+c_class+')').addClass(colors[i]);
                submit_answer_b.push({ "id": i , "value" : c_class});
            } else{
                submit_answer_b.push({ "id": i , "value" : " "});
            }
        });



    <?php endif ?>
});
function popupRoleplay(){

    $(".self_marking_modal_popup .selected_option").click(function () {

        var content_key = $(this).attr('data-key');
        $('.self_marking_modal_popup  .selected_option').not(this).toggleClass('d-none');
        $('.self_marking_modal_popup  .selected_option_description_'+content_key).toggleClass('d-none');
        $('.self_marking_modal_popup  .selected_option_'+content_key).show();
        $(this).toggleClass('btn-bg');
        if( $('.self_marking_modal_popup  .selected_option_description:visible').length>0 ){
            $('.self_marking_modal_popup .is_roleplay_submit').val(0);
        }else{
            $('.self_marking_modal_popup  .is_roleplay_submit').val(1);
        }

    });
}
$(document).ready(function() {
  $(".form_{{$practise['id']}}").find('.question_option').on('click', function() {
 
    if($(".form_{{$practise['id']}}").find(".question_option").hasClass('confirmed')) {
    //  alert()
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("active-bg");
      $(this).addClass('active-bg')
      var bg_color = $(this).attr('data-bgcolor');
      $(".form_{{$practise['id']}}").find('.answer_option').removeClass(bg_color);
      $(this).toggleClass(bg_color);
    } else {
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("match-option-color-one active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("match-option-color-two active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("match-option-color-three active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("match-option-color-four active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("match-option-color-five active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("match-option-color-six active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("match-option-color-seven active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("match-option-color-eight active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("match-option-color-nine active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("match-option-color-ten active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("match-option-color-eleven active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("match-option-color-twelve active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("match-option-color-thirteen active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("match-option-color-fourteen active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("match-option-color-fifteen active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("match-option-color-sixteen active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("match-option-color-seventeen active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("match-option-color-eighteen active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("match-option-color-ninteen active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("match-option-color-twenty active-bg");

      $(".form_{{$practise['id']}}").find(".question_option").addClass('bg-list-light-gray');
      $(this).addClass('active-bg');
      var bg_color = $(this).attr('data-bgcolor');
      $(this).toggleClass(bg_color );
    }

  });

  $(".form_{{$practise['id']}}").find('.answer_option').on('click', function() {

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
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove()
                }
            }
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){

                $("#reviewModal_{{$practise['id']}}").modal('toggle');

            }

    var $this= $(this)
    var current_roleplay_card = $this.attr('data-k');
    if($(".form_{{$practise['id']}}").find(".question_option").hasClass('active-bg')){

      if( $(this).hasClass('match-option-color-one')) {
        $(this).removeClass('match-option-color-one');
        $(".form_{{$practise['id']}}").find('.question_option.match-option-color-one').removeClass('match-option-color-one').removeClass('confirmed').removeClass('active-bg');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');

      }
      else if( $(this).hasClass('match-option-color-two')) {
        $(this).removeClass('match-option-color-two');
        $(".form_{{$practise['id']}}").find('.question_option.match-option-color-two').removeClass('match-option-color-two').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
          $(this).find('input').val('');
      }
      else if( $(this).hasClass('match-option-color-three')) {
        $(this).removeClass('match-option-color-three');
        $(".form_{{$practise['id']}}").find('.question_option.match-option-color-three').removeClass('match-option-color-three').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
          $(this).find('input').val('');
      }
      else if( $(this).hasClass('match-option-color-four')) {
        $(this).removeClass('match-option-color-four');
        $(".form_{{$practise['id']}}").find('.question_option.match-option-color-four').removeClass('match-option-color-four').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
          $(this).find('input').val('');
      }
      else if( $(this).hasClass('match-option-color-four')) {
        $(this).removeClass('match-option-color-four');
        $(".form_{{$practise['id']}}").find('.question_option.match-option-color-four').removeClass('match-option-color-four').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }

      else if( $(this).hasClass('match-option-color-five')) {
        $(this).removeClass('match-option-color-five');
        $(".form_{{$practise['id']}}").find('.question_option.match-option-color-five').removeClass('match-option-color-five').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
      else if( $(this).hasClass('match-option-color-six')) {
        $(this).removeClass('match-option-color-six');
        $(".form_{{$practise['id']}}").find('.question_option.match-option-color-six').removeClass('match-option-color-six').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
      else if( $(this).hasClass('match-option-color-seven')) {
        $(this).removeClass('match-option-color-seven');
        $(".form_{{$practise['id']}}").find('.question_option.match-option-color-seven').removeClass('match-option-color-seven').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
      else if( $(this).hasClass('match-option-color-eight')) {
        $(this).removeClass('match-option-color-eight');
        $(".form_{{$practise['id']}}").find('.question_option.match-option-color-eight').removeClass('match-option-color-eight').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
      else if( $(this).hasClass('match-option-color-nine')) {
        $(this).removeClass('match-option-color-nine');
        $(".form_{{$practise['id']}}").find('.question_option.match-option-color-nine').removeClass('match-option-color-nine').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
      else if( $(this).hasClass('match-option-color-ten')) {
        $(this).removeClass('match-option-color-ten');
        $(".form_{{$practise['id']}}").find('.question_option.match-option-color-ten').removeClass('match-option-color-ten').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
      else if( $(this).hasClass('match-option-color-eleven')) {
        $(this).removeClass('match-option-color-eleven');
        $(".form_{{$practise['id']}}").find('.question_option.match-option-color-eleven').removeClass('match-option-color-eleven').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
      else if( $(this).hasClass('match-option-color-twelve')) {
        $(this).removeClass('match-option-color-twelve');
        $(".form_{{$practise['id']}}").find('.question_option.match-option-color-twelve').removeClass('match-option-color-twelve').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
      else if( $(this).hasClass('match-option-color-thirteen')) {
        $(this).removeClass('match-option-color-thirteen');
        $(".form_{{$practise['id']}}").find('.question_option.match-option-color-thirteen').removeClass('match-option-color-thirteen').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
      else if( $(this).hasClass('match-option-color-fourteen')) {
        $(this).removeClass('match-option-color-fourteen');
        $(".form_{{$practise['id']}}").find('.question_option.match-option-color-fourteen').removeClass('match-option-color-fourteen').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
      else if( $(this).hasClass('match-option-color-fifteen')) {
        $(this).removeClass('match-option-color-fifteen');
        $(".form_{{$practise['id']}}").find('.question_option.match-option-color-fifteen').removeClass('match-option-color-fifteen').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
      else if( $(this).hasClass('match-option-color-sixteen')) {
        $(this).removeClass('match-option-color-sixteen');
        $(".form_{{$practise['id']}}").find('.question_option.match-option-color-sixteen').removeClass('match-option-color-sixteen').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
      else if( $(this).hasClass('match-option-color-seventeen')) {
        $(this).removeClass('match-option-color-seventeen');
        $(".form_{{$practise['id']}}").find('.question_option.match-option-color-seventeen').removeClass('match-option-color-seventeen').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
      else if( $(this).hasClass('match-option-color-eighteen')) {
        $(this).removeClass('match-option-color-eighteen');
        $(".form_{{$practise['id']}}").find('.question_option.match-option-color-eighteen').removeClass('match-option-color-eighteen').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
      else if( $(this).hasClass('match-option-color-ninteen')) {
        $(this).removeClass('match-option-color-ninteen');
        $(".form_{{$practise['id']}}").find('.question_option.match-option-color-ninteen').removeClass('match-option-color-ninteen').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
      else if( $(this).hasClass('match-option-color-twenty')) {
        $(this).removeClass('match-option-color-twenty');
        $(".form_{{$practise['id']}}").find('.question_option.match-option-color-twenty').removeClass('match-option-color-twenty').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
       else {
        var chosen_option = $(".form_{{$practise['id']}}").find('.question_option.active-bg').attr('data-bgcolor');
        $(".form_{{$practise['id']}}").find('.answer_option').removeClass(chosen_option);
        $(this).addClass(chosen_option);
        $(".form_{{$practise['id']}}").find('.question_option.'+chosen_option).addClass('confirmed');

        //var selected_answer = $(".form_{{$practise['id']}}").find('.question_option.'+chosen_option).attr('data-key');
        var selected_question = $('.question_option.active-bg').attr('data-key');
        var current_roleplay_card_key = $('.question_option.active-bg').attr('data-k');
        var selected_answer = parseInt(  $(this).data('key') );
        $('.qo_'+current_roleplay_card_key+' .hidden:eq('+selected_question+')').val("");
        $('.qo_'+current_roleplay_card_key+' .hidden:eq('+selected_question+')').val(selected_answer);
      }
    } else {
      $('.alert-success').hide();
      $('.alert-danger').show().html("Please select any question.").fadeOut(4000);
    }
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
});
</script>

<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
