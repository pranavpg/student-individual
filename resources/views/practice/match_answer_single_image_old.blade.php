<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
<p><strong>{!! $practise['title'] !!}</strong></p>
<style>
.bg-list-light-red {
    background-color: #ffcccb;
}

</style>

<?php
$q1=array();
$q2=array();
$answerExists = false;
if(!empty($practise['user_answer'])){
    $answerExists = true;
    if($practise['type']=='match_answer_speaking'){
      $user_ans = explode(';',$practise['user_answer'][0]['text_ans']);
      array_pop($user_ans);
    } else {
      $user_ans = explode(';',$practise['user_answer']);
      array_pop($user_ans);
    }
    //pr($user_ans);
}

?>

<?php
if($practise['type']=='match_answer_single_image'){

  if(!empty($practise['question_3'])){

    $condition = !empty($practise['question_2']) && !empty($practise['question_3']);
    $q2 = $practise['question_3'];
  } else {
    $condition = !empty($practise['question_2']);

  }

  $q1 = $practise['question_2'];

  //pr($q2);
  if(str_contains($q1[0],'#@')){
    $explode_question = explode( '#@', $q1[0]);
    $explode_question_header = explode( '@@', $explode_question[0]);
    $q1[0] = $explode_question[1];
  } else {
    $explode_question = explode( '#@', $q2[0]);
    $explode_question_header = explode( '@@', $explode_question[0]);
    $q2[0] = $explode_question[1];
  }
?>
  <div class="draw-image mb-4" style="display:none">
    <img width="600px" src="{!! $practise['question'][0] !!}">
  </div>
<?php
} else if($practise['type']=="match_answer" || $practise['type']=='match_answer_speaking' || $practise['type']=="match_answer_listening_image" || $practise['type']=='match_answer_image' || $practise['type']=="match_answer_listening") {
    $condition = !empty($practise['question']) && !empty($practise['question_2']);

    $q1 = $practise['question'];
    $q2 = $practise['question_2'];
    if(str_contains($q1[0],'#@')){
      $explode_question = explode( '#@', $q1[0]);
      $explode_question_header = explode( '@@', $explode_question[0]);
      $q1[0] = $explode_question[1];
    } else {
      $explode_question = explode( '#@', $q2[0]);
      $explode_question_header = explode( '@@', $explode_question[0]);
      $q2[0] = $explode_question[1];
    }
  }

?>
<!--Component Draw Image End-->
<?php
if($condition ) {

    // pr($practise['question_2']);
?>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  @if($practise['type']=="match_answer_listening" || $practise['type']=="match_answer_listening_image" ){
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
      <input type="hidden" name="reverse_array" class="reverse_array" value="0">
        <ul class="list-unstyled row">
          <?php
        // pr($user_ans);
        $background_color_class =  array("bg-list-light-yello",
                                          "bg-list-purple",
                                          "bg-list-pink",
                                          "bg-list-navy",
                                          'bg-list-yellow',
                                          'bg-list-light-green',
                                          'bg-list-light-danger',
                                          'bg-list-light-pink',
                                          'bg-list-light-blue',
                                          'bg-list-light-red','');

                                         //pr($user_ans);
          ?>
          @foreach($q1 as $key => $value)
            @if(!empty(trim($value)) && !empty($user_ans))
              <?php $answer_color[$user_ans[$key]] = $background_color_class[$key]; ?>
            @endif
          @endforeach


          @foreach($q1 as $key => $value)
            @if(!empty(trim($value)))
              <?php
                if($answerExists){
                  $k = !empty($user_ans[$key])?$user_ans[$key]:0;

                }else{
                  $k = $key;
                }
               ?>
              <li class="list-item col-12 col-md-6 bg-list-light-gray question_option {{($answerExists)?$background_color_class[$key].' confirmed active-bg':''}}  question_option_{{$key}}" data-key="{{$key}}" data-bgcolor="{{$background_color_class[$key]}}">
                @if($practise['type']=="match_answer_listening_image" || $practise['type']=="match_answer_image" )
                <img src="{{$value}}" width="100px">
                @else
                  {!!  $value !!}
                @endif
              </li>
              <li class="list-item col-12 col-md-6 bg-list-light-gray answer_option {{($answerExists)?$answer_color[$key]:''}} answer_option_{{$key}}" >
                <strong>{!! !empty($q2[$key])?$q2[$key]:"" !!}</strong>
                <input type="hidden" name="text_ans[]" value="{{($answerExists)?$k:''}}">
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
<?php
  }
?>
</form>
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

	$('.delete-icon').on('click', function() {
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
				url: '<?php echo URL('delete-audio'); ?>',
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				type: 'POST',
				data: {practice_id:practise_id, 'audio_key':audio_key},
				success: function (data) {

				}
		});
	});
</script>
<script>

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
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("bg-list-light-yello active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("bg-list-purple active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("bg-list-pink active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("bg-list-navy active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("bg-list-yellow active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("bg-list-light-green active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("bg-list-light-danger active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("bg-list-light-pink active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").removeClass("bg-list-light-red active-bg");
      $(".form_{{$practise['id']}}").find(".question_option").addClass('bg-list-light-gray');
      $(this).addClass('active-bg');
      var bg_color = $(this).attr('data-bgcolor');
      $(this).toggleClass(bg_color );
    }

  });

  $(".form_{{$practise['id']}}").find('.answer_option').on('click', function() {
    var $this= $(this)

    if($(".form_{{$practise['id']}}").find(".question_option").hasClass('active-bg')){
      if( $(this).hasClass('bg-list-light-yello')) {
        $(this).removeClass('bg-list-light-yello');
        $(".form_{{$practise['id']}}").find('.question_option.bg-list-light-yello').removeClass('bg-list-light-yello').removeClass('confirmed').removeClass('active-bg');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
      else if( $(this).hasClass('bg-list-purple')) {
        $(this).removeClass('bg-list-purple');
        $(".form_{{$practise['id']}}").find('.question_option.bg-list-purple').removeClass('bg-list-purple').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
          $(this).find('input').val('');
      }
      else if( $(this).hasClass('bg-list-pink')) {
        $(this).removeClass('bg-list-pink');
        $(".form_{{$practise['id']}}").find('.question_option.bg-list-pink').removeClass('bg-list-pink').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
          $(this).find('input').val('');
      }
      else if( $(this).hasClass('bg-list-navy')) {
        $(this).removeClass('bg-list-navy');
        $(".form_{{$practise['id']}}").find('.question_option.bg-list-navy').removeClass('bg-list-navy').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
          $(this).find('input').val('');
      }
      else if( $(this).hasClass('bg-list-navy')) {
        $(this).removeClass('bg-list-navy');
        $(".form_{{$practise['id']}}").find('.question_option.bg-list-navy').removeClass('bg-list-navy').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }

      else if( $(this).hasClass('bg-list-yellow')) {
        $(this).removeClass('bg-list-yellow');
        $(".form_{{$practise['id']}}").find('.question_option.bg-list-yellow').removeClass('bg-list-yellow').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
      else if( $(this).hasClass('bg-list-light-green')) {
        $(this).removeClass('bg-list-light-green');
        $(".form_{{$practise['id']}}").find('.question_option.bg-list-light-green').removeClass('bg-list-light-green').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
      else if( $(this).hasClass('bg-list-light-danger')) {
        $(this).removeClass('bg-list-light-danger');
        $(".form_{{$practise['id']}}").find('.question_option.bg-list-light-danger').removeClass('bg-list-light-danger').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
      else if( $(this).hasClass('bg-list-light-pink')) {
        $(this).removeClass('bg-list-light-pink');
        $(".form_{{$practise['id']}}").find('.question_option.bg-list-light-pink').removeClass('bg-list-light-pink').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
      else if( $(this).hasClass('bg-list-light-red')) {
        $(this).removeClass('bg-list-light-red');
        $(".form_{{$practise['id']}}").find('.question_option.bg-list-light-red').removeClass('bg-list-light-red').removeClass('confirmed');
        $(".form_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
        $(this).find('input').val('');
      }
       else {
         $('.reverse_array').val(1)
        var chosen_option = $(".form_{{$practise['id']}}").find('.question_option.active-bg').attr('data-bgcolor');
        $(".form_{{$practise['id']}}").find('.answer_option').removeClass(chosen_option);
        $(this).addClass(chosen_option);
        $(".form_{{$practise['id']}}").find('.question_option.'+chosen_option).addClass('confirmed');
        var selected_answer = $(".form_{{$practise['id']}}").find('.question_option.'+chosen_option).attr('data-key');
        $(this).find('input:hidden').val(selected_answer);
      }
    } else {
      $('.alert-success').hide();
      $('.alert-danger').show().html("Please select any question.").fadeOut(8000);
    }
  });


  $(document).on('click','.submitBtn_{{$practise["id"]}}' ,function() {

    
    if($(this).attr('data-is_save') == '1'){
          $(this).closest('.active').find('.msg').fadeOut();
      }else{
          $(this).closest('.active').find('.msg').fadeIn();
      }

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
  					$('.alert-danger').hide();
  					$('.alert-success').show().html(data.message).fadeOut(8000);
  				} else {
  					$('.alert-success').hide();
  					$('.alert-danger').show().html(data.message).fadeOut(8000);
  				}
        }
    });
  });
});
</script>




<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
