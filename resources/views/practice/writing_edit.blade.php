<p>
	<strong>{!! $practise['title'] !!}</strong>
	<?php
      $answerExists = false;
      if(isset($practise['user_answer']) && !empty($practise['user_answer']))
      {
            $answerExists = true;
            $user_answer = $practise['user_answer'];
      }
      $exploded_question = $practise['question'];
      //dd($user_answer);

	?>
</p>
<form class="writing_edit_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

    <?php // echo $practise['user_answer']; ?>
        <p>
        
            <div class="form-slider p-0 mb-4">
                <div class="component-control-box">
                    <span class="textarea form-control form-control-textarea" role="textbox" contenteditable="" placeholder="Write here...">{!! isset($practise['user_answer']) && $answerExists == true ? nl2br($user_answer) : $exploded_question !!}</span>
                    <input type="hidden" name="user_answer" value="{{ isset($practise['user_answer']) && $answerExists == true ? $user_answer : ''  }}">
                </div>
            </div>

        </p>

    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
    <ul class="list-inline list-buttons">
        <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitWritingEditBtn{{$practise['id']}}"
                data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
        </li>
        <li class="list-inline-item"><button type="button"
                class="submit_btn btn btn-primary submitWritingEditBtn{{$practise['id']}}" data-is_save="1" >Submit</button>
        </li>
    </ul>
  </form>
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
 
    function setTextareaContents(){
        $("span.textarea.form-control").each(function(){
            var currentVal = $(this).html();
            
            $(this).next("input").val(currentVal);
        })
    }
    
  $('.submitWritingEditBtn{{$practise['id']}}').on('click', function(e) {

        if($(this).attr('data-is_save') == '1'){
            $(this).closest('.active').find('.msg').fadeOut();
        }else{
            $(this).closest('.active').find('.msg').fadeIn();
        }
        
    var reviewPopup = '{!!$reviewPopup!!}';
    var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){
                    var fullView= $(".writing_edit_form_{{$practise['id']}}").html();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.textarea').attr('contenteditable','false');
                }
            }
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){

                $("#reviewModal_{{$practise['id']}}").modal('toggle');

            }
    e.preventDefault();
    $('.submitWritingEditBtn{{$practise['id']}}').attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);
    setTextareaContents();

    $.ajax({
        url: '<?php echo URL('save-writing-edit'); ?>',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $('.writing_edit_form_{{$practise['id']}}').serialize(),
        success: function (data) {
            $('.submitWritingEditBtn{{$practise['id']}}').removeAttr('disabled');
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
