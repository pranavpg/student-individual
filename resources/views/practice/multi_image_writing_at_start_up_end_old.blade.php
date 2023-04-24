<p><strong>{{$practise['title']}}</strong></p>
<?php
//pr($practise);
  $answerExists = false;

  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
    $answers = $practise['user_answer'][0];

  }

  if($practise['question_2']){
    $img_count = count($practise['question_2']);
    $q2=array();
    $i=0;
    foreach ($practise['question_2'] as $key => $value) {
      if($value=='@#'){
        $i++;
      }
      if($value!='@#'){
        $q2[$i][$key] = $value;
      }
    }

  }
?>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
	<input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

  @if( !empty($practise['question']) )
        <?php $i = 0; ?>
    @foreach($practise['question'] as $key => $value)
      <div class="row multi__image mb-5 flex-wrap align-items-center multiple-choice">
        <div class="col-5 image text-center">
            <img src="{{$value}}" alt="" class="img-fluid">
        </div>

          <div class="col-7 multi-description">

            @foreach($q2[$key] as $text_key => $text_ans)

              <p class="text-pink"><strong>{{ str_replace('@@', '' ,$text_ans) }}</strong></p>

              <div class="form-group d-flex align-items-start form-group-label">
                  <strong class="label">Q.</strong>
                  <span class="textarea form-control form-control-textarea main-answer" role="textbox" contenteditable placeholder="Write here...">
                    <?php
                      if ($answerExists)
                      {
                          echo  !empty($practise['user_answer'][0][$i]['start'])?$practise['user_answer'][0][$i]['start']:"";
                      }
                    ?>
                  </span>
                  <div style="display:none">

                    <textarea name="user_answer[0][{{$i}}][start]" class="main-answer-input">
                    <?php
                        if ($answerExists)
                        {
                          echo  !empty($practise['user_answer'][0][$i]['start'])?$practise['user_answer'][0][$i]['start']:"";
                        }
                    ?>
                    </textarea>
                  </div>
              </div>
              <div class="form-group d-flex align-items-start form-group-label">
                  <strong class="label">A.</strong>
                  <span class="textarea form-control form-control-textarea main-answer" role="textbox" contenteditable placeholder="Write here...">
                    <?php
                      if ($answerExists)
                      {
                        echo  !empty($practise['user_answer'][0][$i]['end'])?$practise['user_answer'][0][$i]['end']:"";
                      }
                    ?>
                  </span>
                  <div style="display:none">

                    <textarea name="user_answer[0][{{$i}}][end]" class="main-answer-input">
                    <?php
                        if ($answerExists)
                        {
                        echo  !empty($practise['user_answer'][0][$i]['end'])?$practise['user_answer'][0][$i]['end']:"";
                        }
                    ?>
                    </textarea>
                  </div>
              </div>
              <?php $i++; ?>
            @endforeach
          </div>
      </div>
    @endforeach
  @endif

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
    $('.form_{{$practise["id"]}}').find("span.textarea.form-control").each(function(){
  		var currentVal = $(this).html();
  		$(this).next().find("textarea").val(currentVal);
  	});

    $.ajax({
        url: '<?php echo URL('save-multi-image-writing-at-start-up-end'); ?>',
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
