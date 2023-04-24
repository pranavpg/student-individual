<?php
  $user_ans="";

  // pr($practise);

  $answerExists = false;
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;

  }
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
<?php } ?>
<style>
.correct_ans:before{
  background-color: #008000 !important;
}
</style>
<div class="previous_practice_answer_exists_{{$practise['id']}}" style="{{$style}}">
  <p><strong>{!! $practise['title'] !!}</strong></p>
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
    <div class="multiple-choice multiple-check append_self_marking_html">




    </div>

    <div class="mb-4 text-center"><a href="javascript:void(0)" class="btn btn-dark check-answer">Check Answers</a></div>

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
</div>
<script>
$(document).on('click','.submitBtn_{{$practise["id"]}}' ,function() {
    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }
	var $this = $(this);
  $this.attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.form_{{$practise["id"]}}').find('.is_save:hidden').val(is_save);
  $('.form_{{$practise["id"]}}').find("span.textarea.form-control").each(function(){
		var currentVal = $(this).html();
		$(this).next().find("textarea").val(currentVal);
	});

  $.ajax({
      url: '<?php echo URL('save-mcq-self-marking'); ?>',
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
    //  console.log('d====>',dependent_ans)
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
            if(data.question!=null && data.question!=undefined) {

              $('.form_{{$practise["id"]}}').find('.first-question').remove()
              $('.previous_practice_answer_exists_{{$practise["id"]}}').show();
              $('#dependant_pr_{{$practise['id']}}').hide();

              var answer = data.user_Answer[0];
              if(dependent_ans!=""){
                var user_submitted_ans =  JSON.parse(dependent_ans);
              } else {
                var user_submitted_ans ="";
              }
              console.log('===>',data)
              var appendHTML = "";
              var range_az = ['a','b','c'];

              answer.forEach((item, i) => {
                    //  console.log('d====>',user_submitted_ans[i])
                var selected_answer ="";
                var   correctClass = "";
                var appendOptions = "";
                  console.log('===>',item.answer  )
                for(var j=0; j< item.total_option; j++){
                  var option = item['option_'+range_az[j]];
                  var option_name = "user_answer["+i+"][option_"+range_az[j]+"]";
                  var checked="";
                  var selected_answer="";
                  var ans_pos = -1;
                  var ans = "";

                  if(user_submitted_ans!=""){
                    ans_pos = user_submitted_ans[i].ans_pos;
                    ans = user_submitted_ans[i].ans;
                  }
                  if(user_submitted_ans!="" && j==parseInt(user_submitted_ans[i].ans_pos)){
                    checked="checked";
                     selected_answer = user_submitted_ans[i].ans_pos+'@@'+user_submitted_ans[i].ans;
                     var correct_ans = user_submitted_ans[i].correct_ans;

                  }else{
                    selected_answer = j+'@@'+option;
                    var correct_ans=item.answer
                  }


                  if(parseInt(item.answer)==j){
                    correctClass = "correctClass"
                  }else{
                    correctClass = ""
                  }
                  var selected_answer_name = "user_answer["+i+"][user_selected_answer]";
                  appendOptions+= `<div class="custom-control custom-checkbox w-md-33">
                                    <input type="radio" class="custom-control-input" id="cc_`+i+`_`+j+`" `+checked+`  value="`+selected_answer+`" name="`+selected_answer_name+`" >
                                    <label class="custom-control-label `+correctClass+`" for="cc_`+i+`_`+j+`">`+option+`</label>
                                      <input type="hidden" value="`+option+`" name="`+option_name+`">

                                </div>`;
                }
                appendHTML +=  `<div class="choice-box">
                  <p>`+item.question+` </p>
                  <input type="hidden" value="`+item.question+`" name="user_answer[`+i+`][question]">
                  <input type="hidden" value="`+item.total_option+`" name="user_answer[`+i+`][total_option]">
                  <input type="hidden" value="`+correct_ans+`" name="user_answer[`+i+`][correct_ans]">
                  <input type="hidden" value="`+item.answer+`" name="user_answer[`+i+`][answer]">

                  <div class="d-flex ieukcc-boxo">`+
                      appendOptions
                  +`</div>

                </div>`;
              });

              $('.form_{{$practise["id"]}}').find('.append_self_marking_html').html(appendHTML);



              <!-- /. Choice Box -->


            } else {
              $('.previous_practice_answer_exists_{{$practise["id"]}}').hide();
              $('#dependant_pr_{{$practise['id']}}').show();
            }
          }
      });
    }
  });
  $('.check-answer').on('click', function(){
  $('.form_{{$practise["id"]}}').find('label.correctClass').css('background-color',"")
    $('.form_{{$practise["id"]}}').find('label.correctClass').addClass('correct_ans')
  });
</script>
@endif
