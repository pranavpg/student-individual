

<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
  $answerExists = false;
  $user_ans="";
  if(!empty($practise['user_answer'])){
      $answerExists = true;
      $answer = $practise['user_answer'];
  }
  // dd($practise);
?>
<?php
  $style="";
  if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) ){
    $depend =explode("_",$practise['dependingpractiseid']);
    $style= "display:none";
    if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
      $answerExists = true;
      if(!empty($practise['user_answer'])){
        $user_ans = $practise['user_answer'];
      }
    }
?>
    <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; display:none">
      <p style="margin: 15px;">In order to do this task you need to have completed
      <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
   </div>
<?php } ?>
<!--Component Conversation-->

<div class="previous_practice_answer_exists_{{$practise['id']}}" style="{{$style}}">
  <form class="form_{{$practise['id']}}" >
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practise_type" name="practice_type" value="{{$practise['type']}}">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="hide_show_answer_speaking_up" value="0">
    <?php
      if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
        $depend =explode("_",$practise['dependingpractiseid']);
    ?>
        <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
        <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
    <?php } ?>
    @include('practice.common.audio_record_div')
    <!-- /. Audio Player -->

    <div class="true-false appendQue_{{$practise['id']}}">


        <!-- /. box -->

    </div>
    <input type="hidden" name="audio_path" class="audio_path0" value="{{ $user_ans }}">
    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
    <ul class="list-inline list-buttons">
        <li class="list-inline-item"><button type="button" class="btn btn-secondary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"
                data-toggle="modal" data-is_save="0" data-target="#exitmodal"  >Save</button>
        </li>
        <li class="list-inline-item"><button type="button"
                class="btn btn-secondary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1" >Submit</button>
        </li>
    </ul>
  </form>
</div>
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>

<script>
$(document).on('click','.submitBtn_{{$practise["id"]}}' ,function() {

$('.submitBtn_{{$practise["id"]}}').attr('disabled','disabled');
var is_save = $(this).attr('data-is_save');
$('.is_save:hidden').val(is_save);

$.ajax({
    url: '<?php echo URL('save-hide-show-answer-speaking-up'); ?>',
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    type: 'POST',
    data: $('.form_{{$practise["id"]}}').serialize(),
    success: function (data) {
      $('.submitBtn_{{$practise["id"]}}').removeAttr('disabled');
      if(data.success){
        if(is_save==1){
          // =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
          setTimeout(function(){
              $('.alert-success').hide();
            var isNextTaskDependent =  $('.nav-link.active').parent().next().find('a').attr('data-dependent');
            if( isNextTaskDependent == 1 ){
              var dependentPractiseId =  $('.nav-link.active').parent().next().find('a').attr('data-id');
              var baseUrl = "{{url('/')}}";
              var topic_id = "{{request()->segment(2)}}";
              var task_id = "{{request()->segment(3)}}";
              //window.location.href=baseUrl+'/topic/'+topic_id+'/'+task_id+'?n='+dependentPractiseId

            } else {
               //$('.nav-link.active').parent().next().find('a').trigger('click');
            }
          },1000);
          // =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
        }

        $('.alert-danger').hide();
        $('.alert-success').show().html(data.message).fadeOut(4000);
      } else {
        $('.alert-success').hide();
        $('.alert-danger').show().html(data.message).fadeOut(4000);
      }
    }
});
});
</script>

@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 )
   
<script>

// =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
// var next_practice_id = "{{request()->n}}";
// if(next_practice_id && next_practice_id!=""){
//   $('#abc-'+next_practice_id+'-tab').trigger('click');
//   $('.course-tab-content.scrollbar').find('.tab-pane').removeClass('active').removeClass('show');
//   $('#abc-'+next_practice_id).addClass('active show')
// }
// =========================== END   : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
  $( document ).ready(function() {
    var practise_id = $("#abc-{{$practise['id']}}").find('.practise_id').val();

    if(practise_id){
      getDependingPractise();
    } else{
      $('.previous_practice_answer_exists_{{$practise["id"]}}').show();
    }

    


    $(document).on("click", ".btn-ShowHide", function () {
        $(this).parent().parent().find('.box__left__hiddenContent').slideToggle();
        $(this).toggleClass('btn-primary');
        $(this).toggleClass('btn-dark');
    });

    function getDependingPractise(){
      var topic_id    = $("#abc-{{$practise['id']}}").find('.topic_id').val();
      var task_id     = $("#abc-{{$practise['id']}}").find('.depend_task_id').val();
      var practise_id = $("#abc-{{$practise['id']}}").find('.depend_practise_id').val();
      var student_id  = "{{ Request::segment(4)}}";
      // alert(student_id);
      //console.log('d====>',dependent_ans)
      $.ajax({
          url: "{{url('get-student-practisce-answer')}}",
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          type: 'POST',
          data:{
              topic_id,
              task_id,
              practise_id,
              student_id
          },
          dataType:'JSON',
          success: function (data) {
          console.log(data);
           if(data.dependent_question_type =="writing_at_end_up"){
                  if(data.question!=null && data.question!=undefined){
                
                        $('.previous_practice_answer_exists_{{$practise["id"]}}').show();
                        $('#dependant_pr_{{$practise["id"]}}').hide();

                        var question = data.question;
                        var answer = data.user_Answer[0];
                        var question_array = question.split(':');

                        if(data.dependent_user_Answer && data.dependent_user_Answer[0].length>0){
                          var appendQue="";
                          var k=0;
                          console.log('it===>',answer)
                          console.log(data.dependent_user_Answer[0])
                          
                          data.dependent_user_Answer[0].forEach((item, i) => {
                            if(item.trim()!=""){
                                  k++;
                                appendQue +=  `<div class="box box-flex d-flex align-items-start">
                                  <div class="box__left flex-grow-1">
                                        <p>`+k+`. `+item+`</p>
                                      <div class="box__left__hiddenContent">
                                          <p>Answer : `+answer[k-1]+`</p>
                                      </div>
                                  </div>
                                  <div class="true-false_buttons">
                                      <a href="javascript:void(0)" class="btn btn-ShowHide btn-primary btn-no-border">Show
                                          Answer</a>
                                  </div>
                                </div>`;

                              
                            }
                          });
                          $('.appendQue_{{$practise["id"]}}').html(appendQue)
                        }

                      } else {

                        $('.previous_practice_answer_exists_{{$practise["id"]}}').hide();
                        $('#dependant_pr_{{$practise["id"]}}').show();
                      }
              }else if(data.dependent_question_type =="writing_at_end"){
                  
                  if(data.question!=null && data.question!=undefined){
                
                        $('.previous_practice_answer_exists_{{$practise["id"]}}').show();
                        $('#dependant_pr_{{$practise["id"]}}').hide();

                        var question = data.question;
                        var answer = data.user_Answer[0];
                        var question_array = question.split(':');

                        if(data.dependent_user_Answer && data.dependent_user_Answer[0].length>0){
                          var appendQue="";
                          var k=0;
                          // console.log('it===>',answer)

                          var newArray = data.dependent_user_Answer[0].filter(function(v){return v!==''});
                            console.log(newArray);
                            console.log("asdasd");
                            console.log(answer);
                          newArray.forEach((item, i) => {
                            if(item.trim()!=""){
                                  k++;
                                appendQue +=  `<div class="box box-flex d-flex align-items-start">
                                  <div class="box__left flex-grow-1">
                                        <p>`+k+`. `+item+`</p>
                                      <div class="box__left__hiddenContent">
                                          <p>Answer : `+answer[i]+`</p>
                                      </div>
                                  </div>
                                  <div class="true-false_buttons">
                                      <a href="javascript:void(0)" class="btn btn-ShowHide btn-primary btn-no-border">Show
                                          Answer</a>
                                  </div>
                                </div>`; 
                            }
                          });
                          $('.appendQue_{{$practise["id"]}}').html(appendQue)
                        }

                      } else {

                        $('.previous_practice_answer_exists_{{$practise["id"]}}').hide();
                        $('#dependant_pr_{{$practise["id"]}}').show();
                      }
              }else{
                // alert('ewfwef');
                if(data.question!=null && data.question!=undefined){

                  $('.previous_practice_answer_exists_{{$practise["id"]}}').show();
                  $('#dependant_pr_{{$practise["id"]}}').hide();

                  var question = data.question;
                  var answer = data.user_Answer[0];
                  var question_array = question.split('@@');
                  if(data.user_Answer && data.user_Answer[0].length>0){
                    // console.log(data.user_Answer);
                    var appendQue="";
                    var k=0;
                    // console.log('it===>',answer)
                    // console.log(data.user_Answer[0]);
                    data.user_Answer[0].forEach((item, i) => {
                      if(item.text_ans !=""){
                          k++;
                          appendQue +=  `<div class="box box-flex d-flex align-items-start">
                            <div class="box__left flex-grow-1">
                                  <p>`+k+`. `+question_array[i].replace("5","")+`</p>
                                <div class="box__left__hiddenContent">
                                    <p>Answer : `+item.text_ans+`</p>
                                </div>
                            </div>
                            <div class="true-false_buttons">
                                <a href="javascript:void(0)" class="btn btn-ShowHide btn-primary btn-no-border">Show
                                    Answer</a>
                            </div>
                          </div>`;
                      }
                    });
                    $('.appendQue_{{$practise["id"]}}').html(appendQue)
                  }

                } else {

                  $('.previous_practice_answer_exists_{{$practise["id"]}}').hide();
                  $('#dependant_pr_{{$practise["id"]}}').show();
                }
           }
            
          }
      });
    }
  });

          // setTimeout(function(){
          // $(".true-false_buttons").each(function(){
          //   $(this).fadeIn()
          //   $(this).css("display","block !important")
          //   $(this).find('a').css("display","block !important")
          //   $(this).find('.btn-no-border').css("display","block !important")
          // })
          //     alert("asdasd")
          //   $('.appendQue_15567174555cc99f8fa7c55 .btn-ShowHide').fadeIn();
          //   $(".btn-ShowHide").css("display","block !important")
          // },6000)
  </script>

@endif
