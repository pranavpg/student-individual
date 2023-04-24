<p><strong>{{ $practise['title'] }}</strong></p>
<form class="save_record_video_form_{{$practise['id']}}">
<input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
<input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
<input type="hidden" class="is_save" name="is_save" value="">
<input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">       
@if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid']))
    @php
    $depend = explode("_",$practise['dependingpractiseid'])       
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
$answerExists = "";
@endphp
@if(isset($practise['user_answer']) && !empty($practise['user_answer']))
        @php   
            $answerExists = $practise['user_answer']; 
        @endphp
@endif

        <div class="tab-pane fade show active" id="abc-b" role="tabpanel"
                                        aria-labelledby="abc-b-tab">
            <p><strong>Write or Paste your url below:</strong></p>

           
             <!-- /. Componetnt - Record Video -->
             <div class="record-video d-flex align-items-end mb-4">
                <strong>www.</strong> 
                <span class="textarea form-control form-control-textarea" role="textbox" contenteditable="" placeholder="Write here...">
                    {{ $answerExists }}
                </span>
                <div style="display:none">
                    <textarea name="text_ans">
                       {{ $answerExists }}
                    </textarea>
                  </div>       
            </div>
            <!-- /. Componetnt - Record Video End-->
           
            <div class="alert alert-success" role="alert" style="display:none"></div>
            <div class="alert alert-danger" role="alert" style="display:none"></div>
            <ul class="list-inline list-buttons">
            <li class="list-inline-item">
                <input type="button" class="record_video_form_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
                </li>
                <li class="list-inline-item">
                <input type="button" class="record_video_form_{{$practise['id']}}  btn btn-primary" value="Submit" data-is_save="1">
                </li>
            </ul>
        </div>
</form>


<script>
    function setTextareaContent(){
        $("span.textarea.form-control").each(function(){
            var currentVal = $(this).html();
            $(this).next().find("textarea").val(currentVal);
        })
    }

  $(document).on('click',".record_video_form_{{$practise['id']}}" ,function() {
    
    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }

    $(".record_video_form_{{$practise['id']}}").attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);

    setTextareaContent();
    $.ajax({
        url: "{{url('save-record-video')}}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $(".save_record_video_form_{{$practise['id']}}").serialize(),
        success: function (data) {
          $(".save_record_video_form_{{$practise['id']}}").removeAttr('disabled');

          if(data.success){
            $('.alert-danger').hide();
            $('.alert-success').show().html(data.message).fadeOut(8000);
          }else{
            $('.alert-success').hide();
            $('.alert-danger').show().html(data.message).fadeOut(8000);is_save
          }

        }
    });

  });
</script>

