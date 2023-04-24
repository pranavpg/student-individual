<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
<p><strong>{!! $practise['title'] !!}</strong>
<form class="save_speaking_up_option_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">


    @include('practice.common.audio_record_div',['key'=>0])

    <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="speaking_up_option" value="0">


    @php
      $exploded_question  =  explode(PHP_EOL, $practise['question']);
      $table_header = explode('@@', $exploded_question[0]);
      $table_header = array_map('trim',$table_header);
      $table_header = array_chunk($table_header, 4);

    @endphp

    
    @foreach($table_header as $key=>$value)
        <div class="suggestion-list d-flex flex-wrap justify-content-center">
            @for ($i = 0; $i < count($value); $i++)
                @if($key != 5)
                <div class="d-inline-flex flex-grow-1 suggestion_box justify-content-center col-md-3">
                        @switch($value[$i])
                            @case('performingarts')
                                performing arts
                                @break
                            @case('student’sunion')
                                student’s union
                                @break
                            @case('sixthform')
                                sixth form
                                @break
                             @case('secondaryschool')
                                secondary school
                                @break
                            @default
                                {{ $value[$i] }}
                        @endswitch
                </div>
                @else
                <div class="d-inline-flex flex-grow-1 suggestion_box justify-content-center col-md-6">
                    {{ $value[$i] }}
                </div>
                @endif
            @endfor
        </div>
    @endforeach
    </br>  </br>
    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
    <ul class="list-inline list-buttons">
        <li class="list-inline-item">
          <input type="button" class="save_btn submitBtn_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
        </li>
        <li class="list-inline-item">
          <input type="button" class="submit_btn submitBtn_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">
        </li>
    </ul>
</form>

<script type="text/javascript">

$(document).on('click',".submitBtn_{{$practise['id']}}" ,function() {

    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }
    
    $(".submitBtn_{{$practise['id']}}").attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);

    $.ajax({
        url: "{{ route('save-speaking-up-option') }}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $(".save_speaking_up_option_form_{{$practise['id']}}").serialize(),
        success: function (data) {
        $(".submitBtn_{{$practise['id']}}").removeAttr('disabled');
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

var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";

</script>
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
