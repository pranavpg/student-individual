<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
<p><strong>{!! $practise['title'] !!}</strong></p>

<?php
// dd($practise);
  if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid']) && !empty($practise['dependingpractiseid']) && isset($practise['dependingpractise_answer']) && empty($practise['dependingpractise_answer']) ){
      $depend =explode("_",$practise['dependingpractiseid']);
      if(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer'])){
        $displayPractise="block";
        $displayDependancy="none";

       }else{
        $displayPractise="none";
        $displayDependancy="block";
       }
    ?>
      <input type="hidden" class="get_answers_put_into_quetions_topic_id" name="get_answers_put_into_quetions_topic_id" value="{{$topicId}}">
      <input type="hidden" class="get_answers_put_into_quetions_task_id" name="depend_task_id" value="{{$depend[0]}}">
    <input type="hidden" class="get_answers_put_into_quetions_practise_id" name="depend_practise_id" value="{{$depend[1]}}">

    <div id="dependant_pr_{{$practise['id']}}" style="display:{{$displayDependancy}}; border: 2px dashed gray; border-radius: 12px;">
    <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
    </div>
    <?php 
  }?>
<style>
.bg-list-light-red {
    background-color: #ffcccb;
}
.draw-image {
  padding: 10px;
}
.draw-image img {
  border-radius: 18px;
}
</style>

<?php
// echo '<pre>'; print_r($practise);
//  dd($practise);
$q1=array();
$q2=array();
$answerExists = false;
if(!empty($practise['user_answer'])){
    $answerExists = true;
    if($practise['type']=='match_answer_speaking'){
      $user_ans = explode(';',$practise['user_answer'][0]['text_ans']);
      array_pop($user_ans);
    }
    else {
      if(isset($practise['user_answer']) && !empty($practise['user_answer']) && !is_array($practise['user_answer'])){
        $answerExists = true;
        $user_ans = explode(';',$practise['user_answer']);
        array_pop($user_ans);
      }
      
       //dd($user_ans); //2;5; ; ;4;3;
    }
   
}
?>

<?php
 if($practise['type']=="match_answer" || $practise['type']=='match_answer_speaking' || $practise['type']=="match_answer_listening_image" || $practise['type']=='match_answer_image' || $practise['type']=="match_answer_listening") 
  {
    $displayPractise="block";
    $displayDependancy="none";
    $condition = !empty($practise['question']) && !empty($practise['question_2']);

    $q1 = $practise['question'];
    // $q2 = $practise['question_2'];
    
     $q2 = isset($practise['question_2'])?$practise['question_2']:[];

    if(isset($q1[0]) && str_contains($q1[0],'#@')){
      $explode_question = explode( '#@', $q1[0]);
      $explode_question_header = explode( '@@', $explode_question[0]);
      $q1[0] = $explode_question[1];
    } else {

      $explode_question         = explode( '#@', $q2[0]);
      $explode_question_header  = explode( '@@', $explode_question[0]);
    // dd($explode_question);
      $q2[0] = isset($explode_question[1])?$explode_question[1]:"";
    }
  }

// dd($q2);
  ?>
<!--Component Draw Image End-->
<?php
if($condition) {


  ?>
  <form class="form_{{$practise['id']}}" style="display:{{$displayPractise}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practise_type" name="practice_type" value="{{$practise['type']}}">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    @if($practise['type']=="match_answer_listening" || $practise['type']=="match_answer_listening_image" )
      <div class="audio-player">
        <audio preload="auto" controls src="<?php echo $practise['audio_file'];?>" type="audio/mp3" id="audio_{{$practise['id']}}">
          <!-- <source > -->
        </audio>
      </div>
    @endif
    <div class="match-answer mb-4">
      <div class="row">
        @if(!empty($explode_question_header[0]))
          <div class="col-md-6 match-answer__block">
              <h3>{{$explode_question_header[0]}}</h3>
          </div>
        @endif
        @if(!empty($explode_question_header[1]))
          <div class="col-md-6 match-answer__block">
              <h3>{{$explode_question_header[1]}}</h3>
          </div>
        @endif
      </div>
      <div class="match-answer__block">
          <ul class="list-unstyled row">
            <?php
              $background_color_class =  array('match-option-color-one','match-option-color-two','match-option-color-three','match-option-color-four','match-option-color-five','match-option-color-six','match-option-color-seven','match-option-color-eight','match-option-color-nine','match-option-color-ten','match-option-color-eleven','match-option-color-twelve','match-option-color-thirteen','match-option-color-fourteen','match-option-color-fifteen','match-option-color-sixteen','match-option-color-seventeen','match-option-color-eighteen','match-option-color-ninteen','match-option-color-twenty');
            ?>
            @foreach($q1 as $key => $value)
              @if(!empty(trim($value)))
                <li class="list-item col-12 col-md-6 bg-list-light-gray  question_option  question_option_{{$key}}" data-key="{{$key}}" data-bgcolor="{{$background_color_class[$key]}}">
                  @if($practise['type']=="match_answer_listening_image" || $practise['type']=="match_answer_image" )
                   <?php 
                    $type = Array(1 => 'jpg', 2 => 'jpeg', 3 => 'png', 4 => 'gif'); 
                    $ext = explode(".",$value);
                     $ext = end($ext);
                                      ?>
                   @if(isset($ext[1]))
                     @if(!in_array($ext,$type))
                       {!! $value !!}
                     @else
                       <img src="{{$value}}" width="100px">
                     @endif
                   @else
                      {!! $value !!}
                   @endif
                  @else
                      {!!  $value !!}
                  @endif
                  <input type="hidden" name="text_ans[]" value=" " class="hidden">
                </li>
                <li class="list-item col-12 col-md-6 bg-list-light-gray answer_option answer_option_{{$key}}" data-key="{{$key}}">
                  <strong>{!! !empty($q2[$key])?$q2[$key]:"" !!}</strong>
                </li>
              @endif
            @endforeach
          </ul>
          @if(  $practise['type'] == "match_answer_speaking" )
              @include('practice.common.audio_record_div',['key'=>0])
          @endif
      </div>
    </div>
    <!-- /. Component Match Answer End -->

    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
    <ul class="list-inline list-buttons">
        <li class="list-inline-item"><button class="save_btn btn btn-primary submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
        </li>
        <li class="list-inline-item"><button
                class="submit_btn btn btn-primary submitBtn_{{$practise['id']}}" data-is_save="1" data-pid="{{$practise['id']}}" >Submit</button>
        </li>
    </ul>
  </form>
  <?php
}
?>
  
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

    <?php if($answerExists){ ?>
      
        var user_answers = <?php echo json_encode($user_ans) ?>;
        var submit_answer = [];

        var colors = <?php echo json_encode($background_color_class) ?>;
        console.log("colors: ", colors);

        $('.question_option').each(function(i){
            var c_class = parseInt(user_answers[i]); //4

            if(isNaN(c_class) == false){
                $('.form_{{$practise["id"]}} .question_option:eq('+i+')').addClass(colors[i]);
                $('.form_{{$practise["id"]}} .question_option:eq('+i+')').addClass(' confirmed active-bg');
                $('.form_{{$practise["id"]}} .question_option:eq('+i+')').find('input:hidden').val(c_class);
            }
            else{
                $('.form_{{$practise["id"]}} .question_option:eq('+i+')').find('input:hidden').val(" ");
            }
        });

        $('.form_{{$practise["id"]}} .answer_option').each(function(i){
            var c_class = parseInt(user_answers[i]); //4

            if(isNaN(c_class) == false){
                $('.form_{{$practise["id"]}} .answer_option:eq('+c_class+')').addClass(colors[i]);
                //$('.answer_option:eq('+c_class+')').find('input:hidden').val(i);
                submit_answer.push({ "id": i , "value" : c_class});
            }
            else{
                submit_answer.push({ "id": i , "value" : " "});
            }


        });
        // console.log("submit_ans : ", submit_answer)

    <?php } ?>
});

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
    var $this= $(this)

    if($(".form_{{$practise['id']}}").find(".question_option").hasClass('active-bg')){
   
      if($(".form_{{$practise['id']}}").find(this).hasClass('match-option-color-one')) {
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
        var selected_question = $(".form_{{$practise['id']}} .question_option.active-bg").attr('data-key');
        var selected_answer = parseInt(  $(this).data('key') );
        
        $(".form_{{$practise['id']}} .hidden:eq("+selected_question+")").val();
         $(".form_{{$practise['id']}} .hidden:eq("+selected_question+")").val(selected_answer);
      }
    } else {
      $('.alert-success').hide();
      $('.alert-danger').show().html("Please select any question.").fadeOut(8000);
    }
  });


  $(document).on('click','.submitBtn_{{$practise["id"]}}' ,function(e) {
    e.preventDefault();

    if($(this).attr('data-is_save') == '1'){
          $(this).closest('.active').find('.msg').fadeOut();
      }else{
          $(this).closest('.active').find('.msg').fadeIn();
      }

      
    var audio_src = $('.answer_audio-{{$practise["id"]}}-0').find('source').attr('src');
    var speaking_practise = "{{($practise['type']=='match_answer_speaking')?1:0}}"
    if(speaking_practise==1 && (audio_src.includes("sample-audio") ||  audio_src==undefined || audio_src==null || audio_src==""))
    {
      $('.alert-success').hide();
      $('.alert-danger').show().html('Please record answer...').fadeOut(8000);
    }
    else
    {
      $(this).attr('disabled','disabled');
      var $this = $(this);
      var is_save = $(this).attr('data-is_save');
      $('.is_save:hidden').val(is_save);
     
      $.ajax({
        url: '<?php echo URL('save-match-answer-single-image'); ?>',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $('.form_'+"{{$practise['id']}}").serialize(),
        success: function (data) {
          $this.removeAttr('disabled');
          if(data.success){
            if(is_save=="1"){
              // =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
              setTimeout(function(){
                  $('.alert-success').hide();
                var isNextTaskDependent =  $('.nav-link.active').parent().next().find('a').attr('data-dependent');
                if( isNextTaskDependent == 1 ){
                  var dependentPractiseId =  $('.nav-link.active').parent().next().find('a').attr('data-id');
                  var baseUrl = "{{url('/')}}";
                  var topic_id = "{{request()->segment(2)}}";
                  var task_id = "{{request()->segment(3)}}";
                    //window.location.href=baseUrl+'/topic/'+topic_id+'/'+task_id+'?n='+dependentPractiseId
                  ////$('#abc-'+dependentPractiseId+'-tab').trigger('click');
                } else {
                  //$('.nav-link.active').parent().next().find('a').trigger('click');
                }
              },1000);
              // =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
            }
            $('.alert-danger').hide();
            $('.alert-success').show().html(data.message).fadeOut(8000);
          } else {
            $('.alert-success').hide();
            $('.alert-danger').show().html(data.message).fadeOut(8000);
          }
        }
      });
    }
  });
});
</script>




<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
