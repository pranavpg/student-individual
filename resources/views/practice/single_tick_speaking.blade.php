<p><strong>{!! $practise['title'] !!}</strong></p>
<form class="save_single_tick_speaking_form_{{$practise['id']}}">
<input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
<input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
<input type="hidden" class="is_save" name="is_save" value="">
<input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

@if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid']))
    @php
    $depend = explode("_",$practise['dependingpractiseid']);
    @endphp
    <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
    <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
    <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
    <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice
        @if($depend[3] == 1) {{ A }} @endif @if($depend[3] == 2) {{ B }} @endif @if($depend[3] == 3) {{ C }} @endif @if($depend[3] == 4) {{ D }} @endif @if($depend[3] == 5) {{ E }} @endif @if($depend[3] == 6) {{ F }} @endif
            </strong> Please complete this first.</p>
    </div>
@endif
@php
    $exploded_question  =  explode("#@", $practise['question']); $i=1;
    $final_Quetsion  =  explode("@@", $exploded_question[1]); $i=1;
@endphp
        <div class="tab-pane fade show active" id="abc-b" role="tabpanel"
                    aria-labelledby="abc-b-tab">
            @if($practise['type'] == "single_tick_speaking")
               @php
                 $model  =  explode("#%", $practise['question']);
               @endphp

               <?php 
                    if(count($model)>1) {

                        if(isset($model[0])){ ?>
                                <div  style="text-align: center;">
                                    <button id="openmodel" class=" btn btn-primary">{{$model[0]}}</button>
                                </div>
                        <?php
                        }
                    }
                ?>
                
                @include('practice.common.audio_record_div')
                <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="audio_single" value="0">
            @endif
            
            <div class="true-false_buttons-aes mb-5">
                @foreach($final_Quetsion as $key=>$item)
                    @if($item != '')
                    <div class="form-check pl-0 mb-4">
                        <input type="radio" class="form-check-input my-radio" id="cc{{$key}}" name="checkBox[]" value="{{$item}}"
                          {{ isset($practise['user_answer'][0]['text_ans'][$key]['checked']) && !empty($practise['user_answer'][0]['text_ans'][$key]['checked']) == 'true' ?  'checked' :  "" }}  >
                        <label class="form-check-label form-check-label_true" for="cc{{$key}}" name="checkBox[{{$key}}]">{{ $item }}</label>
                        <input type="hidden" name="question[]" value='{{$item}}'>
                    </div>
                    @endif
                @endforeach
            </div>
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
        </div>
</form>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">{{isset($model[0])?$model[0]:""}}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php 
        if(isset($model[1])){
            $data = explode("/t 1", $model[1]);
            echo $data[0];
        }
       
        ?>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('#openmodel').click(function(){
        $('#myModal').modal("show");
        return false;
    });
})
$(document).on('click',".submitBtn_{{$practise['id']}}" ,function() {
    $(".single_tick_speaking_form_{{$practise['id']}}").attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);

    $.ajax({
        url: "{{ route('save-single-tick-speaking') }}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $(".save_single_tick_speaking_form_{{$practise['id']}}").serialize(),
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
$(document).on('click','.delete-icon', function() {
    $('.practice_audio').attr('src','');

    $('.audioplayer-bar-played').css('width','0%');
    $(this).hide();
    $('div.audio-element').css('pointer-events','none');
    //$('.submitBtn').attr('disabled','disabeld');
    var practise_id = $(this).find('a').attr('data-pid');
    $(this).parent().find('.record-icon').show();
    $(this).parent().find('.stop-button').hide();
    $.ajax({
      url: '<?php echo URL('delete-audio'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: {practice_id:practise_id},
      success: function (data) {

      }
  });
});
</script>
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
