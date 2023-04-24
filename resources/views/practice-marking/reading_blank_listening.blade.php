
<style>
    .active-answer{
        background-color: #D2DBE3;
    }
    .course-book ul:not(.nav) li .form-control-inline{
        min-width: 308px;
    }
    .form-control:disabled, .form-control[readonly]{
        background-color: initial;
    }
</style>
<?php //echo "<pre>"; print_r($practise['options']) ; print_r($practise['question']); ?>
<p>
    <strong>{{ $practise['title'] }}</strong>
</p>

@if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid']))
<?php  $depend =explode("_",$practise['dependingpractiseid']); ?>
    <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;" data-value="{{$practise['id']}}">
        <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
    </div>
@endif

@php
    $answerExists = false;
    $exploded_question  =  explode(PHP_EOL, $practise['question']);
    $exploded_question  =  str_replace("@@.", "", $exploded_question);
    //dd($exploded_question);
    //dd($practise['options']);
    if (isset($practise['user_answer']) && !empty($practise['user_answer']))
    {
        $answerExists = true;
        $user_answer = $practise['user_answer'][0];
        //dd($user_answer);

        foreach($user_answer as $y=> $answers){
            $ans[$y] = $answers['ans_pos'];
        }

        $final_answers = json_encode($ans);
        //dd($final_answers);
    }
    //dd($practise['user_answer'][0]);
    $ans=array();
@endphp

<form class="readingtotalblanks_speakingup_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    <?php if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])): ?>
        <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
        <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
    <?php endif ?>


    <br>

    @if(isset($practise['options']))
    <div class="match-answer">
        <div class="form-slider mb-5">
            <div class="owl-carousel">
                @if(!empty($practise['options']))
                    @foreach($practise['options'] as $k => $value)
                        <div class="item">
                            <div class="table-slider-box text-center d-flex flex-wrap">
                                @foreach($value as $x=> $val)
                                    <?php $border_class = ($x == 0 ? 'border-right' : '');
                                      $active_class = 'background-color: initial';
                                       if($answerExists == true)
                                       {
                                           if( (int) $practise['user_answer'][0][$k]['ans_pos'] === (int)$x)
                                           {
                                                $active_class = 'background-color: #D2DBE3;';
                                           }
                                       }
                                    ?>
                                    <div class="w-50 table-option {{ $border_class }}">
                                    <a href="#!" id="{{$k}}_{{$x}}" data-pos="{{$x}}" style="{{ $active_class }}">{{ $val }}</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <br>
    @endif

    @if($practise['type'] == "reading_blank_listening")
        @include('practice.common.audio_player')
    @endif
    <br>

    <div class="simple-list mb-4">
        <ul class="list-unstyled list-decimal" >
            @foreach($exploded_question as $key=>$item)
                @if(!empty($item))
                    <li contenteditable="false">{{ str_replace("...", "", substr($item,2)) }}
                        <span class="" contenteditable="false">
                            <input type="hidden" name="text_ans[{{$key}}][ans_pos]" id="ans_pos_{{$key}}">
                            <input type="text" class="form-control text-left pl-0 form-control-inline text_question" id="text_ans_{{$key}}" name="text_ans[{{$key}}][ans]" data-id="{{$key}}" value="{{ $answerExists == true ? $practise['user_answer'][0][$key]['ans'] : "" }}" >
                            <span id="span_multi_choice_{{$key}}" style="display:none;"></span>
                            .
                        </span>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>

        <!-- <ul class="list-inline list-buttons">
            <li class="list-inline-item">
                <input type="button" class="readingtotalblanks_speakingupBtn_{{$practise['id']}} btn btn-secondary" value="Save" data-is_save="0">
            </li>
            <li class="list-inline-item">
                <input type="button" class="readingtotalblanks_speakingupBtn_{{$practise['id']}} btn btn-secondary" value="Submit" data-is_save="1">
            </li>
        </ul> -->

</form>
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<script src="{{asset('public/js/owl.carousel.js')}}"></script>
@if($practise['type'] == 'reading_total_blanks_speaking_up')
<script>

jQuery(function ($) {
	'use strict'
	var supportsAudio = !!document.createElement('audio').canPlayType;
	if (supportsAudio) {
			// initialize plyr
			var i;

				 var player = new Plyr('audio.audio_file', {
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

@endif
<script>
function setTextareaContent(){
    $(".readingtotalblanks_speakingup_form_{{$practise['id']}} span.textarea.form-control").each(function(){
        var currentVal = $(this).html();
        $(this).next().find("textarea").val(currentVal);
    })
}

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
});

$(document).on('click',".readingtotalblanks_speakingupBtn_{{$practise['id']}}" ,function() {
    $(".readingtotalblanks_speakingupBtn_{{$practise['id']}}").attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);

    //setTextareaContent();
    $.ajax({
        url: "{{url('save_reading_total_blank_speakingup')}}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $(".readingtotalblanks_speakingup_form_{{$practise['id']}}").serialize(),
        success: function (data) {
          $(".readingtotalblanks_speakingupBtn_{{$practise['id']}}").removeAttr('disabled');

          if(data.success){
            $('.alert-danger').hide();
            $('.alert-success').show().html(data.message).fadeOut(4000);
          }else{
            $('.alert-success').hide();
            $('.alert-danger').show().html(data.message).fadeOut(4000);
          }

        }
    });

  });

$(document).ready(function()
{
   $('.text_question').prop('readonly', true);


   var maxcounter={{ count($exploded_question) }}

    function isEmpty(val){
        return (val === undefined || val == null || val.length <= 0) ? true : false;
    }



    var selected_option = '';

    var owl =  $('.owl-carousel');


    var selected_item ='';
    var selected_color='#D2DBE3';
    owl.owlCarousel({
        loop: false,
        margin: 10,
        pagination: false,
        items: 1,
        nav: true,
        dots: false,
        onInitialized: function()
        {

            if( $(this).find(".owl-item.active").index() == $(this).find(".own-item").first().index() ) {

            }


        },
        onChange: function()
        {

        }
    })

    $('.owl-next').off("click");
    $('.owl-prev').off("click");


    var counter = 0;


    var text_init_color="darkorange";
    var text_append_color="darkblue";

    $('.table-option a').on('click', function(e){
        e.preventDefault();
        selected_item = $(this).text();
        textbox_index = $(this).attr('id');
        ans_pos_index = $(this).data('pos');
        $('.table-option a').css('background-color', '');

        console.log(selected_item);
        //$('.text_question:eq('+counter+')').focus();

        $('#text_ans_'+counter+'').val(selected_item).text(selected_item).css('color', text_append_color);
        $('#ans_pos_'+counter+'').val(ans_pos_index);
    })


    $(".owl-next").on("click", function(e) {
         e.preventDefault();

         if(counter >= maxcounter){
             return false;
         }
         if(selected_item !== "")
         {
             $('#text_ans_'+counter+'').css('color', text_init_color);
             counter++;
             console.log(counter);
             $('#text_ans_'+counter+'').focus();
             owl.trigger('next.owl.carousel', [300]);
             selected_item="";
             return false;
         }
         if($('#text_ans_'+counter+'').val() !== "")
         {
             $('#text_ans_'+counter+'').css('color', text_init_color);
             counter++;
             console.log(counter);
             $('#text_ans_'+counter+'').focus();
             owl.trigger('next.owl.carousel', [300]);

             selected_item="";
             return false;
         }
         else
         {
             alert('Oops! You missed a gap!')
             return false;
         }
    })


    $(".owl-prev").on("click", function(e) {
        e.preventDefault();

        if(counter == 0){
            selected_item="";
            return false;
        }
        counter--;


        $('#text_ans_'+counter+'').focus();
        $('#text_ans_'+counter+'').css('color', text_append_color);
        selected_item = $('#text_ans_'+counter+'').val();
        selected_item_index = $('#text_ans_'+counter+'').data('id');

        //owl.trigger('prev.owl.carousel', [selected_item_index, 300]);
        owl.trigger('to.owl.carousel', [selected_item_index, 0]);
        $('.table-option a').css('background-color', '');
        var coritem = $('.table-slider-box').find('a:contains('+selected_item+')').css('background-color', selected_color);
        //selected_item= selected_item;

        console.log(counter);

        return false;

    })


})

</script>
