<?php //echo '<pre>'; print_r($practise); exit;?>
    <p>
        <strong>{{ $practise['title'] }}</strong>
    </p>
    @php
        $answerExists = false;

        if(strpos($practise['question'], '#@') !== false) {
            $exploded_question  =  explode(PHP_EOL, $practise['question']);
            $exploded_question  =  str_replace("1 #@", "@@", $exploded_question);
            $exploded_question  =  explode("@@", $practise['question']);
        }
        else
        {
            $exploded_question  =  explode('@@', $practise['question']);
        }

        $exploded_question  =  str_replace("\r\n", "", $exploded_question);

        if(isset($practise['user_answer']) && !empty($practise['user_answer']))
        {
            $answerExists = true;
        }   

        //pr($practise);

    @endphp
      <form class="save_single_tick_writing_form_{{$practise['id']}}">
        <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
        <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
        <input type="hidden" class="is_save" name="is_save" value="">
        <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

        @foreach($exploded_question as $key=>$item)
                @if(!empty($item))
                @php if(strpos($item, '1 #@') !== false)
                   $item = str_replace("1 #@", "", $item)
                @endphp
               <div class="custom-control custom-radio custom-radio_single mb-4">
                <input type="radio" class="custom-control-input" id="cc{{$key}}" name="checkBox[]" value="{{$item}}"
                    <?php if($answerExists): ?> {{$practise['user_answer'][0][$key]['checked'] == 1 ?  'checked' :  "" }} <?php endif ?> >
                    <label class="custom-control-label" for="cc{{$key}}" name="checkBox[{{$key}}]">{{ $item }}</label>
                    <input type="hidden" name="question[]" value='{{$item}}'>
                </div>
                @endif
        @endforeach
        <div class="form-slider p-0 mb-4">
            <div class="component-control-box focus">
                <span class="textarea form-control form-control-textarea" role="textbox" contenteditable="" placeholder="Write here...">
                    @php
                        if($answerExists):
                            echo str_replace( " ", "&nbsp;", str_replace( "\n", "<br>", $practise['user_answer'][1][0]));
                        endif;
                    @endphp
                </span>
                <div style="display:none">
                    <textarea name="text_ans">
                    @php
                        if($answerExists):
                            echo str_replace( " ", "&nbsp;", str_replace( "\n", "<br>", $practise['user_answer'][1][0]));
                        endif;
                    @endphp
                    </textarea>
                  </div>
            </div>
        </div>
            <div class="alert alert-success" role="alert" style="display:none"></div>
            <div class="alert alert-danger" role="alert" style="display:none"></div>
                <ul class="list-inline list-buttons">
                    <li class="list-inline-item">
                        <input type="button" class="save_btn singleTickWritingBtn_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
                    </li>
                    <li class="list-inline-item">
                        <input type="button" class="submit_btn singleTickWritingBtn_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">
                    </li>
                </ul>

        </form>



<script>
    function setTextareaContent(){
        $("span.textarea.form-control").each(function(){
            var currentVal = $(this).html();
            $(this).next().find("textarea").val(currentVal);
        })
    }

  $(document).on('click',".singleTickWritingBtn_{{$practise['id']}}" ,function() {

    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }
    

    $(".singleTickWritingBtn_{{$practise['id']}}").attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);

    setTextareaContent();
    $.ajax({
        url: "{{url('save_single_tick_writing')}}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $(".save_single_tick_writing_form_{{$practise['id']}}").serialize(),
        success: function (data) {
          $(".singleTickWritingBtn_{{$practise['id']}}").removeAttr('disabled');

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

