<p><strong>{!!$practise['title']!!}</strong></p>
<?php
//pr($practise);
  $answerExists = false;
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
    $answers = $practise['user_answer'][0];
  }
  $exp_question = explode(PHP_EOL, $practise['question']);

  //pr($practise);
?>
<style>
.percentage_background.active{
  background-color: grey;
}
</style>
<!-- Compoent - Two click slider-->
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_type" name="practise_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

  <div class="set_sequence mb-5">
    @if(!empty($exp_question))
      <ul class="list-inline d-flex flex-wrap justify-content-between text-center mb-2">
        @foreach($exp_question as $key => $value)
          <li class="list-inline-item flex-grow-1"><a href="javascript:void(0)" data-val ="{{$value}}" class="sequence_option">{{$value}}</a></li>
        @endforeach
      </ul>
    @endif
      <div class="sequence-box">
        <?php
          $last_key = array_key_last($exp_question);
          $first_key = array_key_first($exp_question);
          // echo $last_key;die;
        ?>
          <ul class="list-inline d-flex flex-wrap align-items-end justify-content-between text-center">
              @foreach($exp_question as $key => $value)
              <?php
                if($key == $first_key){
                  $show_percentage= '0%';
                } else if($key == $last_key){
                  $show_percentage= '100%';
                } else {
                  $show_percentage= "";
                }
              ?>
                <li class="list-inline-item flex-grow-1">
                    <span class="sequence__number">{{$show_percentage}}</span>
                    <a href="javascript:void(0)" class="percentage_background {{($key==0)?'active':''}}">
                      {{($answerExists)?$answers[$key]:""}}
                    </a>
                    <input type="hidden" name="options[]" value="{{($answerExists)?$answers[$key]:""}}">
                </li>
              @endforeach

          </ul>
      </div>
  </div>

  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
  <ul class="list-inline list-buttons">
      <li class="list-inline-item"><button type="button" class="btn btn-primary submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"
              data-toggle="modal" data-is_save="0" data-target="#exitmodal">Save</button>
      </li>
      <li class="list-inline-item"><button type="button"
              class="btn btn-primary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1">Submit</button>
      </li>
  </ul>
</form>

<script>
  $('.percentage_background').on('click', function(){
    $('.percentage_background').removeClass('active');
    $(this).addClass('active');
      $('.percentage_background').removeAttr('style');
  });
  $('.sequence_option').on('click', function() {

    $('.percentage_background.active').css("background-color", "white");
    var val = $.trim($(this).attr('data-val'));
    $('.percentage_background.active').html(val);
    $('.percentage_background.active').next().val(val)
  });
  $(document).on('click','.submitBtn_{{$practise["id"]}}' ,function() {

    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }
    
    $('.submitBtn').attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);
    $.ajax({
      url: '<?php echo URL('save-set-in-sequence'); ?>',
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
