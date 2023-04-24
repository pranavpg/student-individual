
<?php //echo "<pre>"; print_r($practise['options']) ; print_r($practise['question']); 
//dd($practise); ?>
<p>
    <strong>{{ $practise['title'] }}</strong>
</p>
<style>
    .form-control:disabled, .form-control[readonly]{
        background-color : initial;
    }
</style>

@if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid']))
@php  $depend =explode("_",$practise['dependingpractiseid']); @endphp
    <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;" data-value="{{$practise['id']}}">
        <p style="margin: 15px;">In order to do this task you need to have completed <span style="color:orange;font-weight: 600;">Task {{$depend[2]}}</span> <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
    </div>
@endif

@php
    $answerExists = false;
    $exploded_question  =  explode("@@", $practise['question']);
    $exploded_question  =  str_replace("\r\n", "", $exploded_question);

    if (isset($practise['user_answer']) && !empty($practise['user_answer']))
    {
        $answerExists = true;
        $user_answer = explode(";",  $practise['user_answer'][0]['text_ans']);
    }
    //dd($user_answer);
   
@endphp

<form class="readingtotalblanks_speakingup_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{ isset($depend) ? $depend[0] : "" }}">
    <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{ isset($depend) ? $depend[1] : "" }}">

    @if($practise['type'] == "reading_total_blanks_speaking_up")
        @include('practice.common.audio_record_div')
         <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="audio_reading" value="0">
    @endif
    <br>

    @if(isset($practise['options']))
    <div class="match-answer">
        <div class="form-slider mb-5">
            <div class="owl-carousel">
                @if(!empty($practise['options']))
                    <div class="item">
                        <div class="table-slider-box ietsb-mobv text-center d-flex flex-wrap">
                            @foreach($practise['options'] as $key => $value)
                                <div class="w-33 ietsob-mobv table-option border">
                                    <a href="#!" id="practiseoptions_{{$key}}" data-key="{{$key}}" class="practiseoptions">{{ $value[0]}}</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <br>
    @endif
    <div class="simple-list mb-4">
        <ul class="list-unstyled list-decimal">
           <?php
           $question_final = array(); 
            foreach($exploded_question as $data){
                if($data !=""){
                    array_push($question_final, $data);
                }
            }
             $counter = count($question_final);
           ?>
            @foreach($question_final as $key=>$item)
                @if(!empty($item))
                    <li>{{ str_replace("...", "", substr($item,2)) }}
                        <?php if(!empty($practise['dependingpractise_answer'])){
                                echo $practise['dependingpractise_answer'][0][$key];
                        } ?>
                        <span class="resizing-input1 text-left" contenteditable="false" id="text_ans_{{$key}}" style="margin-left: 0px;{{$key==0?'border-bottom: 2px solid rgb(8, 56, 99)':""}}">{{ (isset($practise['user_answer']) && $answerExists == true) ? isset($user_answer[$key])?$user_answer[$key]:"" : ""  }} </span>
                        <input type="hidden" readonly style="min-width: 255px;background-color:white;" class="form-control  pl-0 form-control-inline" 
                        value="{{ (isset($practise['user_answer']) && $answerExists == true) ? isset($user_answer[$key])?$user_answer[$key]:"" : ""  }}" name="text_ans[]">
                            <span id="span_multi_choice_{{$key}}" style="display:none;"></span>
                     
                    </li>
                @else
                    {{ $counter-- }}
                @endif
            @endforeach
        </ul>
    </div>

    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
        <ul class="list-inline list-buttons">
            <li class="list-inline-item">
                <input type="button" class="readingtotalblanks_speakingupBtn_{{$practise['id']}} btn btn-secondary" value="Save" data-is_save="0">
            </li>
            <li class="list-inline-item">
                <input type="button" class="readingtotalblanks_speakingupBtn_{{$practise['id']}} btn btn-secondary" value="Submit" data-is_save="1">
            </li>
        </ul>

</form>
{{-- <script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script> --}}
{{-- <script src="{{ asset('public/js/owl.carousel.js') }}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<script src="{{ asset('public/js/audioplayer.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script>
var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
// $('.owl-carousel').owlCarousel({
//     loop: false,
//     margin: 10,
//     nav: true,
//     items: 1
// })
</script>
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
    $("span.textarea.form-control").each(function(){
        var currentVal = $(this).html();
        $(this).next().find("textarea").val(currentVal);
    })
}

$(document).on('click',".readingtotalblanks_speakingupBtn_{{$practise['id']}}" ,function() {
    $(".readingtotalblanks_speakingupBtn_{{$practise['id']}}").attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);

    setTextareaContent();
    $.ajax({
        url: "{{url('save-reading-no-blanks-listening-speaking-down')}}",
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

    var selected_option = '';
    var counter = 0; maxcounter={{ $counter }}

    function isEmpty(val){
        return (val === undefined || val == null || val.length <= 0) ? true : false;
    }


    $('a.practiseoptions').on('click', function(e){
         $('.text-left').each(function(){
            $(this).css('color','red');
         });
        e.preventDefault();
        var selected_item = $(this).text();
        selected_option = selected_item;
        $('.text-left:eq('+counter+')').text(selected_item).css('color','darkorange');
        $('.text-left:eq('+counter+')').next().val(selected_item);
    });

    // var owl =  $('.owl-carousel');

    // owl.on('to.owl.carousel changed.owl.carousel', function(event) {
    //     console.log(event);
    // });

    $('.owl-carousel').owlCarousel({
        nav: true,
        items: 1,
        loop:false,
        responsiveClass:true,
        dots: 0
    });

    if($('div.owl-nav').hasClass('disabled')) {
        $('div.owl-nav').removeClass('disabled');
    }

    // Go to the next item
    $('.owl-next').click(function() {
        $('.resizing-input1').each(function(){
            $(this).css("border-bottom","1px solid black")
        });
        if(counter >= (maxcounter-1))
        {
            alert('Max Limit Reached');
            return false;
        }
        var newId = counter+1;
        $('#text_ans_'+newId).css('color','#083863');
        $('#text_ans_'+newId).css('border-bottom','2px solid rgb(8 56 99)');
        if($('#text_ans_'+counter).text().length <= 0){
            alert('You missed a gap');
            return false;
        }
        else {
            console.log(counter++);
            $('.text-left:eq('+counter+')').focus();
        }

    });
    // Go to the previous item
    $('.owl-prev').click(function() {
        $('.resizing-input1').each(function(){
            $(this).css("border-bottom","1px solid black")
        });
        if(counter <= 0) {
            alert('Max Limit Reached');
            return false;
        }
        console.log(counter--);

        var newId = counter+1;
        $('#text_ans_'+counter).css('color','#083863');
        $('#text_ans_'+counter).css('border-bottom','2px solid rgb(8 56 99)');

        $('.text-left:eq('+counter+')').focus();
    });


    <?php if($practise['type'] == "reading_total_blanks_speaking_up"):?>



        topic_id= $(".readingtotalblanks_speakingup_form_{{$practise['id']}}").find('.topic_id').val();
        task_id=$(".readingtotalblanks_speakingup_form_{{$practise['id']}}").find('.depend_task_id').val();
        practise_id=$(".readingtotalblanks_speakingup_form_{{$practise['id']}}").find('.depend_practise_id').val();

        $.ajax({
            url: "{{url('get-student-practisce-answer')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data:{
                topic_id,
                task_id,
                practise_id
            },
            dataType:'JSON',
            success: function (data) {

                if(data['success'] == false)
                {
                    $("#dependant_pr_{{$practise['id']}}").css("display", "block");
                    $(".readingtotalblanks_speakingup_form_{{$practise['id']}}").css("display", "none");
                }
                else
                {
                    $("#dependant_pr_{{$practise['id']}}").css("display", "none");
                    $(".readingtotalblanks_speakingup_form_{{$practise['id']}}").css("display", "block");
                }

                var result = data[0];
                console.log('====>',result);
                if(result!==undefined){
                  for(var i=0; i< result[0].length; i++)
                  {
                    $('#span_multi_choice_'+i).html(result[i]).val(result[i])
                  }
                }
            }
        });

    <?php endif; ?>

})

</script>

<style type="text/css">


    *[contenteditable]:empty:before
    {
        content: "\feff"; /* ZERO WIDTH NO-BREAK SPACE */
    }

   

    .appendspan {
        color:red;
    }

 
</style>