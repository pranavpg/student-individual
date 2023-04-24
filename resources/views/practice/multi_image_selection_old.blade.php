<p>
	<strong><?php 	echo $practise['title']; ?></strong>
</p>
<?php
  //pr($practise);
  $answerExists = false;
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
    $answers = $practise['user_answer'][0];
  }

?>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
	<input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

  <div class="multiple-choice  mb-4">
      <div class="true-false_buttons-aes d-flex flex-wrap w-75 ml-auto mr-auto">
        @foreach($practise['question'] as $k => $v)
          <div class="form-check w-50 mb-4">
              <input class="form-check-input" type="radio"
                  name="text_radio[0][checked]"
                  id="inlineRadioTrue_{{$k}}"
                  value="{{$k}}" {{ ($answerExists && $answers[$k]['checked'] ==1)?"checked":""}} >

              <label class="form-check-label form-check-label_center" for="inlineRadioTrue_{{$k}}">
                  <img src="{{$v}}" alt="" class="img-fluid img-checkbox">
              </label>
              <input type="hidden" name="text_ans[0][{{$k}}][image]" value="{{$v}}">
          </div>

        @endforeach
      </div>
  </div>



    <!-- /. List Button Start-->
    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
    <ul class="list-inline list-buttons">
        <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"
                data-toggle="modal" data-is_save="0" data-target="#exitmodal"  >Save</button>
        </li>
        <li class="list-inline-item"><button type="button"
                class="submit_btn btn btn-primary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1" >Submit</button>
        </li>
    </ul>
  </form>
  <script>


  $(document).on('click','.submitBtn_{{$practise["id"]}}' ,function() {

    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }
    var pid= $(this).attr('data-pid');

  	var $this = $(this);
    $this.attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.form_{{$practise["id"]}}').find('.is_save:hidden').val(is_save);


    $.ajax({
        url: '<?php echo URL('save-multi-image-selection'); ?>',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $('.form_{{$practise["id"]}}').serialize(),
        success: function (data) {
          $this.removeAttr('disabled');
  				if(data.success){
  					$('.form_{{$practise["id"]}}').find('.alert-danger').hide();
  					$('.form_{{$practise["id"]}}').find('.alert-success').show().html(data.message).fadeOut(8000);
  				} else {
  					$('.form_{{$practise["id"]}}').find('.alert-success').hide();
  					$('.form_{{$practise["id"]}}').find('.alert-danger').show().html(data.message).fadeOut(8000);
  				}
        }
    });
  });
  </script>
