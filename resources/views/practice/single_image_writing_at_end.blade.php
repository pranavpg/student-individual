<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
// dd($practise);
    $answerExists = false;
    if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
      $answerExists = true;
    }

  ?>
  @if(isset($practise['is_roleplay']) && !empty($practise['is_roleplay']) && $practise['type'] == 'single_image_writing_at_end')
    @include('practice.single_image_writing_at_end_roleplay')
  @else
  <form class="form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    <!-- /. Component Audio Player END-->
    
      <div class="draw-image draw-image__small mb-5 text-center">
        <img width="600px" src="{{$practise['question'][0]}}" class="w-100 p-3" /> <!--- margin removed and classes added -->
      </div>
      <!--Component Draw Image End-->
      @if(!empty($practise['question_2']))
      <?php //echo '<pre>'; print_r($practise);  echo '</pre>'; ?>
        @foreach($practise['question_2'] as $key => $value)

        <div class="box__left box__left_radio">
              @if(str_contains($value, '@@') == false)
                        <p > <?php echo $value ;?> </p>
                        <input type="hidden" name="user_answer[{{$key}}]" value="">
              @else
                        <p style="margin-bottom: 0.45rem !important;"> <?php echo str_replace("@@","",$value) ;?> </p>
              @endif          
                  </div>
          @if(str_contains($value, '@@') != false)       
                  <div class="form-group">
                      <span class="textarea form-control form-control-textarea stringProper text-left enter_disable" role="textbox" contenteditable placeholder="Write here..."><?php if ($answerExists) { echo  rtrim($practise['user_answer'][0][$key]); } ?></span>
                      <div style="display:none">
                        <textarea name="user_answer[{{$key}}]">
                        <?php
                            if ($answerExists)
                            {
                              echo  $practise['user_answer'][0][$key];
                            }
                        ?>
                        </textarea>
                      </div>
                  </div>
          @endif       
        @endforeach
      @endif
  



    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
    <ul class="list-inline list-buttons">
        <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn writing_at_end_up_speaking_up_{{$practise['id']}}" data-pid="{{$practise['id']}}"
                data-toggle="modal" data-is_save="0" data-target="#exitmodal"  >Save</button>
        </li>
        <li class="list-inline-item"><button type="button"
                class="submit_btn btn btn-primary submitBtn writing_at_end_up_speaking_up_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1"  >Submit</button>
        </li>
    </ul>
  </form>
@endif
 @if(isset($practise["markingmethod"]) && $practise["markingmethod"] == "student_self_marking")
            @include('practice.common.student_self_marking')
        @endif
        @php 
            $lastPractice=end($practises);
        @endphp 
        @if($lastPractice['id'] == $practise['id'])
            @include('practice.common.review-popup')
            @php
                $reviewPopup=true;                
            @endphp
        @else
            @php
                $reviewPopup=false;                
            @endphp
        @endif
<script>

$(document).on('click','.writing_at_end_up_speaking_up_{{$practise["id"]}}' ,function() {
   var pid= $(this).attr('data-pid');
    var reviewPopup = '{!!$reviewPopup!!}';
    var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);
    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }
    if(markingmethod =="student_self_marking"){
        if($(this).attr('data-is_save') == '1'){
            $('#practise_div').html("");
            var fullView= $(".form_{{$practise['id']}}").clone(true);
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find(".textarea").attr("contenteditable",false);
        }
    }
    if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){      
      $("#reviewModal_{{$practise['id']}}").modal('toggle');
    }
	var $this = $(this);
  $this.attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.form_'+pid).find('.is_save:hidden').val(is_save);
  $('.form_'+pid).find("span.textarea.form-control").each(function(){
    var currentVal = $(this).html();
    var regex = /<br\s*[\/]?>/gi;
    currentVal=currentVal.replace(regex, "\n");
    var regex = /<div\s*[\/]?>/gi;
    currentVal=currentVal.replace(regex, "\n");
    var regex = /<\/div\s*[\/]?>/gi;
    currentVal=currentVal.replace(regex, "");
    var regex = /&nbsp;/gi;
    currentVal=currentVal.replace(regex, "");
		$(this).next().find("textarea").val(currentVal);
	});

  $.ajax({
      url: '<?php echo URL('save-single-image-writing'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('.form_'+pid).serialize(),
      success: function (data) {
        $this.removeAttr('disabled');
				if(data.success){
					$('.form_'+pid).find('.alert-danger').hide();
					$('.form_'+pid).find('.alert-success').show().html(data.message).fadeOut(8000);
				} else {
					$('.form_'+pid).find('.alert-success').hide();
					$('.form_'+pid).find('.alert-danger').show().html(data.message).fadeOut(8000);
				}
      }
  });
});
</script>
<script>
  // $(document).on('click','.can',function(){
  //    let delid = this.id;
  //    alert(delid);
  //    $("#selfMarking_"+delid).modal('hide');
  //    $(".modal-backdrop").removeClass('show');
  // })
</script>
