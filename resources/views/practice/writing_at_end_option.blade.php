  <p><strong>{!! $practise['title'] !!}</strong></p>
<?php
  $user_ans="";
   
  $answerExists = false;
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
    // if(empty($practise['user_answer'][0][0])){
    //   array_shift($practise['user_answer'][0]);
    //   $practise['user_answer'][0] = array_values($practise['user_answer'][0]);
    // }
  }

?>
<?php
  $style="";
  if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) ){
    $depend =explode("_",$practise['dependingpractiseid']);
    $style= "display:none";
    if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
      $answerExists = true;
      if(!empty($practise['user_answer'][0])){
        $user_ans = $practise['user_answer'][0];
      }
    }
?>
      <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; display:none">
           <p style="margin: 15px;">In order to do this task you need to have completed
              <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
     </div>
<?php
    } else {
      $exploded_question = explode(PHP_EOL,$practise['question']);

    }
 ?>

<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
<div class="previous_practice_answer_exists_{{$practise['id']}}" style="{{$style}}">

  @if($practise['type']=='writing_at_end_listening' && !empty( $practise['audio_file'] ))
    @include('practice.common.audio_player')
  @endif
  <form class="form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    <?php
      if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
        $depend =explode("_",$practise['dependingpractiseid']);
    ?>
        <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
        <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
    <?php } ?>
    @if(!empty($practise['options']))
      <div class="suggestion-list d-flex flex-wrap w-50 mr-auto ml-auto mb-4 justify-content-center">
          @foreach($practise['options'] as $key => $value)
          <div class="d-inline-flex flex-grow-1 suggestion_box justify-content-center">
              {{ $value[0]}}
          </div>
          @endforeach
      </div>
    @endif

    <div class="multiple-choice">
        <!-- /. box -->
        @if( !empty($exploded_question) )
            @foreach( $exploded_question as $key => $value )
               
              @if (str_contains($value, '@@'))
                  <div class="choice-box">
                      @if(  $practise['type']=="writing_at_end_option")
                          <p class="mb-0">{!! nl2br(substr(str_replace('@@', '', $value),2)) !!} </p>
                      @else
                          <p class="mb-0 main-question">{!! nl2br(str_replace('@@', '', $value)) !!} </p>
                      @endif
                      <div class="form-group">
                          <span class="textarea form-control form-control-textarea main-answer enter_disable" role="textbox" contenteditable placeholder="Write here...">
                              <?php
                              if ($answerExists)
                              {
                                  echo  !empty($practise['user_answer'][0][$key])?str_replace(" ","&nbsp;",nl2br($practise['user_answer'][0][$key])):"";
                              }
                              ?>
                          </span>
                          <div style="display:none">

                              <textarea name="user_answer[0][{{$key}}]" class="main-answer-input">
                              <?php
                              if ($answerExists)
                              {
                              echo  !empty($practise['user_answer'][0][$key])?str_replace(" ","&nbsp;",nl2br($practise['user_answer'][0][$key])):"";

                              }
                              ?>
                              </textarea>
                          </div>
                      </div>
                  </div>
              @else
                  <div class="first-question">
                  <p class="mb-0  main-answer"><strong>{{ strip_tags(nl2br($value)) }} </strong></p>
                  <input type="hidden" name="user_answer[0][{{$key}}]">
                  </div>
              @endif
            @endforeach
        @endif
    </div>

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
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<script>
jQuery(function ($) {
        'use strict'
        var supportsAudio = !!document.createElement('audio').canPlayType;
        if (supportsAudio) {
            // initialize plyr
            var i;

               var player = new Plyr("#audio_{{$practise['id']}}", {
                controls: [
                  'play',
                  'progress',
                  'current-time'
                ]
            });


        } else {
            // no audio support
            $('.column').addClass('hidden');
            var noSupport = $('#audio1').text();
            $('.container').append('<p class="no-support">' + noSupport + '</p>');
        }
    });
</script>
<script>
$(document).on('click','.submitBtn_{{$practise["id"]}}' ,function() {

  // $("#reviewModal_{{$practise['id']}}").modal('toggle');
  // return false;
  if($(this).attr('data-is_save') == '1'){
      $(this).closest('.active').find('.msg').fadeOut();
  }else{
      $(this).closest('.active').find('.msg').fadeIn();
  }
  var reviewPopup = '{!!$reviewPopup!!}';
    var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){
                    var fullView= $('.form_{{$practise["id"]}}').html();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.textarea').attr("contenteditable","false");
                }
            }
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){
                $("#reviewModal_{{$practise['id']}}").modal('toggle');

            }
	var $this = $(this);
  $this.attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.form_{{$practise["id"]}}').find('.is_save:hidden').val(is_save);
  $('.form_{{$practise["id"]}}').find("span.textarea.form-control").each(function(){
		var currentVal = $(this).text();
		$(this).next().find("textarea").val(currentVal);
	});

  $.ajax({
      url: '<?php echo URL('save-writing-at-end-option'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('.form_{{$practise["id"]}}').serialize(),
      success: function (data) {
        console.log(data);
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
@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 )
  <script>
  $( document ).ready(function() {
    var practise_id = $(".form_{{$practise['id']}}").find('.depend_practise_id').val();
    if(practise_id){
      getDependingPractise();
    } else{
      $('.previous_practice_answer_exists_{{$practise["id"]}}').show();
    }

    function getDependingPractise(){

      var topic_id= $(".form_{{$practise['id']}}").find('.topic_id').val();
      var task_id=$(".form_{{$practise['id']}}").find('.depend_task_id').val();
      var practise_id=$(".form_{{$practise['id']}}").find('.depend_practise_id').val();
      var dependent_ans = '<?php echo !empty($user_ans)?json_encode($user_ans):"" ?>';
      //console.log('d====>',dependent_ans)
      $.ajax({
          url: "{{url('get-student-practisce-answer')}}",
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          type: 'POST',
          data:{
              topic_id,
              task_id,
              practise_id
          },
          dataType:'JSON',
          success: function (data) {
            if(data.question!=null && data.question!=undefined){
              $('.form_{{$practise["id"]}}').find('.first-question').remove()
              $('.previous_practice_answer_exists_{{$practise["id"]}}').show();
              $('#dependant_pr_{{$practise["id"]}}').hide();
              var question = data.question;
              var answer = data.user_Answer[0];
              var question_array = question.split(':');

              var str ="";
              if(answer){
                answer.forEach((item, i) => {
                  console.log(i, '===',item)
                  if($.trim(i)!=""){
                    $(".form_{{$practise['id']}}").find(".main-question:eq("+(i-1)+")").html(item)
                    if(dependent_ans!="" ){
                      var parsed_dependent_ans = JSON.parse(dependent_ans);
                      //  console.log('=====>',parsed_dependent_ans[i]);
                      $(".form_{{$practise['id']}}").find(".main-answer-input:eq("+(i-1)+")").val(parsed_dependent_ans[i-1]);
                      $(".form_{{$practise['id']}}").find(".main-answer:eq("+(i-1)+")").html(parsed_dependent_ans[i-1]);
                    }
                  }
                });
              }

            } else {
              $('.previous_practice_answer_exists_{{$practise["id"]}}').hide();
              $('#dependant_pr_{{$practise['id']}}').show();
            }
          }
      });
    }
  });
</script>
@endif
