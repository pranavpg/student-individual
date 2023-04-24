{{-- {{ dd($practise) }} --}}
<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
@php
    //$img_option = $practise['question'][0];
    //$exploded_question = $practise['question_2'];
    $exploded_question  =  explode(PHP_EOL, $practise['question']); $i=0;
    $table_header = str_replace('/t','@@', $exploded_question);

    $table_header = explode('@@', $table_header[0]);

    //dd($table_header);

    if(is_numeric($exploded_question[1]))
    {
        $firstColumns = array();
    }
    else
    {
        $firstColumns = explode('@@', $exploded_question[1]);
        $exploded_question[1] = count($firstColumns);

    }
    if ($practise['type'] == "three_blank_table_listening_writing")
    {
        $columnCount = 3;
        $columnClass = 'w-33';
    }

    $answerExists = false;
    if (isset($practise['user_answer']) && !empty($practise['user_answer']))
    {
        $answerExists = true;
    }

    $columnCount = 3;
    $columnClass = 'w-33';
@endphp

<form class="save_three_blank_table_listening_writing_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    <input type="hidden" name="table_type" value="<?php echo $columnCount; ?>" />
<p><strong>{!! $practise['title'] !!}</strong></p>
@include('practice.common.audio_multi_player',['key'=>0,'path'=>isset($practise['audio_file']) ? $practise['audio_file'] : "horse.mp3"])
<div id="container">
<div class="table-container mb-4 text-center">
    <div class="table w-75 mr-auto ml-auto">
        <div class="table-heading thead-dark d-flex justify-content-between">
            @foreach($table_header as $key=> $table_head)
                @if ($loop->first)
                    @php $other_title = $table_head; @endphp
                    @continue
                @endif
                <div class="d-flex justify-content-center align-items-center th {{ $columnClass }} ">{{$table_head}}
                    <div style="display:none">
                        <textarea name="col[]">{{ $table_head }}</textarea>
                        <input type="hidden" name="true_false[]" value="false" />
                    </div>
                </div>    
            @endforeach
        </div>
        @for($j = 0;$j < $exploded_question[1];$j++) <!-- Total Question Loop -->
            <div class="table-row thead-dark d-flex justify-content-between">
                @for($k = 1; $k <= $columnCount; $k++) <!-- Total Column Loop -->
                    <div class="d-flex justify-content-center align-items-center  border-left td {{ $columnClass }} td-textarea">
                        @if($k == 1 && isset($firstColumns) && !empty($firstColumns) )
                            <span class="textarea form-control form-control-textarea col_{{$j+1}}_{{$k}}">{{$firstColumns[$j]}}</span>
                            <div style="display:none">
                                <textarea name="col[]" class="col_{{$j+1}}_{{$k}}">{{ $firstColumns[$j] }}</textarea>
                                <input type="hidden" name="true_false[]" value="false" />
                            </div>
                        @else
                            <span class="textarea form-control form-control-textarea col_{{$j+1}}_{{$k}}" role="textbox" contenteditable placeholder="Write here...">
                            @if($answerExists && isset($practise['user_answer']))
                                {{ $practise['user_answer'][0][0][$j+1]['col_' . $k] }}
                            @endif
                            </span>
                            <div style="display:none">
                                <textarea name="col[]" class="col_{{$j+1}}_{{$k}}">
                                @if($answerExists && isset($practise['user_answer']))
                                    {{ $practise['user_answer'][0][0][$j+1]['col_' . $k] }}
                                @endif
                                </textarea>
                                <input type="hidden" name="true_false[]" value="true" />
                            </div>
                        @endif
                    </div>
                @endfor
            </div>
        @endfor
    </div>
</div>
</div>

<div class="multiple-choice mb-4">
    <p><strong>{{ $other_title }}</strong></p>
    <div class="form-slider p-0">
        <div class="component-control-box">
            <span class="textarea form-control form-control-textarea stringProper text-left" role="textbox" contenteditable placeholder="Write here...">@if($answerExists && isset($practise['user_answer'])){{ $practise['user_answer'][1][0] }}@endif </span>
            <div style="display:none"><textarea name="textarea"></textarea></div>
        </div>
    </div>
</div>

<div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
        <ul class="list-inline list-buttons">
            <li class="list-inline-item">
                <input type="button" class="save_btn threeBlankTableListeningBtn_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
            </li>
            <li class="list-inline-item">
                <input type="button" class="submit_btn threeBlankTableListeningBtn_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">
            </li>
        </ul>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<script>jQuery(function ($) {
    'use strict'
    var supportsAudio = !!document.createElement("audio").canPlayType;
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
function setTextareaContent(){
    $(".save_three_blank_table_listening_writing_form_{{$practise['id']}} span.textarea.form-control").each(function(){
        var currentVal = $(this).html();
        $(this).next().find("textarea").val(currentVal);
    })
}
$(document).on('click','.threeBlankTableListeningBtn_{{$practise['id']}}' ,function() {

        if($(this).attr('data-is_save') == '1'){
            $(this).closest('.active').find('.msg').fadeOut();
        }else{
            $(this).closest('.active').find('.msg').fadeIn();
        }

      $('.threeBlankTableListeningBtn_{{$practise['id']}}').attr('disabled','disabled');
      var is_save = $(this).attr('data-is_save');
      $('.is_save:hidden').val(is_save);
      setTextareaContent();
      $.ajax({
          url: '<?php echo URL('save-three-blank-table-speaking-writing-form'); ?>',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          type: 'POST',
          data: $('.save_three_blank_table_listening_writing_form_{{$practise['id']}}').serialize(),
          success: function (data) {
                $('.threeBlankTableListeningBtn_{{$practise['id']}}').removeAttr('disabled');
                if(data.success){
                    $('.alert-danger').hide();
                    $('.alert-success').show().html(data.message).fadeOut(8000);
                }else{
                    $('.alert-success').hide();
                    $('.alert-danger').show().html(data.message).fadeOut(8000);
                }
          }
      });
    });

</script>


