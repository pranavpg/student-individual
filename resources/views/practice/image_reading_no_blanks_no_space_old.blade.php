<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
// pr($practise);
  $answerExists = false;
  if(!empty($practise['user_answer'])){
    $answerExists = true;
    $answer = explode( ';',$practise['user_answer'][0]);
  }  $count = 0;
//pr($answer);
?>

<picture class="picture picture-with-border d-flex w-75 mr-auto ml-auto mb-4" style="width:350px !important; height:300px !important;">
    <img src="{{$practise['question'][0]}}" alt="" class="img-fluid w-100" >
</picture>
<!--Component Conversation-->
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

  <div class="paragraph-noun text-left">
    @if(!empty($practise['question_2']))
      @foreach($practise['question_2'] as $key => $value)
      <?php

        $k=$key;

          if(str_contains($value,'@@')){
            $outValue = preg_replace_callback('/@@/',
                function ($m) use (&$key, &$count, &$answer) {
                  $ans=$answer[$count];
                  $count++;
                //  $str = '<span class="textarea d-inline-flex mw-20 form-control form-control-textarea conversation_answer_'.$count.'" role="textbox" contenteditable placeholder="Write here...">'.$ans.'</span><input type="hidden" name="text_ans['.$key.']['.$count.']" value="'.$ans.'">';
                  $str = '<span class="ml-2 resizing-input"><input type="text"  name="text_ans[]" class="write_in_blank form-control form-control-inline" value="'.$ans.'"><span style="display:none"></span></span>';
                  return $str;
                }
                , $value);
          } else {
            $outValue = $value;
          }



      ?>
        <div class="paragraph-noun_box">
            <ul class="list-inline">
                <li class="list-inline-item">
                  {!! $outValue !!}
                </li>

            </ul>
        </div>
      @endforeach
    @endif

      <!-- /. paragraph noun box-->
  </div>
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
<script>
$(document).on('keypress', '.write_in_blank', function() {
    $(this).css('min-width','14px');
});
  $('.form_{{$practise["id"]}}').on('click','.submitBtn_{{$practise["id"]}}' ,function() {
    if($(this).attr('data-is_save') == '1'){
          $(this).closest('.active').find('.msg').fadeOut();
      }else{
          $(this).closest('.active').find('.msg').fadeIn();
      }
    $('.submitBtn_{{$practise["id"]}}').attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);

    $.ajax({
        url: '<?php echo URL('save-image-reading-no-blanks-no-space'); ?>',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $('.form_{{$practise["id"]}}').serialize(),
        success: function (data) {
          $('.submitBtn_{{$practise["id"]}}').removeAttr('disabled');
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
</script>
