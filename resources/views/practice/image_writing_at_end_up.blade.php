<?php
  $answerExists = false;
  // dd($practise);
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
    $answers = $practise['user_answer'];
   // pr($answers); 
    //dd($answers);
  }
  $two_tabs = array();
  $i=0;
  $two_tabs = explode('@@', str_replace('{}','',$practise['question_2'][0]));
    $question_list = array();
    $question_list[0] = $practise['question'][0];
    $question_list[1] = $practise['question'][0];
    $previous_practise_id = "";
    if(isset($practise['dependingpractiseid'])){
        $dependingpractiseid = explode('_',$practise['dependingpractiseid']);
        $previous_practise_id = $dependingpractiseid[1];
    }
    $previous_practise_id='';

    

?>
<p><strong>{!!$practise['title']!!}</strong></p>



<?php if(isset($practise['is_roleplay']) && $practise['is_roleplay']) { ?>

   
    @include('practice.image_writing_at_end_up_role_play')

<?php }else{ ?>

    <form class="form_{{$practise['id']}} commonFontSize">
      <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
      <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
      <input type="hidden" class="is_save" name="is_save" value="">
      <input type="hidden" class="practise_type" name="practise_type" value="{{$practise['type']}}">
      <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
      <input type="hidden" class="is_roleplay_submit" name="is_roleplay_submit" value="1">


      <!-- Compoent - Two click slider-->
        <div class="component-two-click mb-4" >


            <div class="content-box multiple-choice  student_bottom selected_option_description selected_option_description true__false__block">
                <picture class="picture picture-with-border d-flex w-50 mr-auto ml-auto mb-4" style="width: 75% !important;">
                    <img src="{{$practise['question'][0]}}" alt="" class="img-fluid w-100">
                </picture>  
                <div class="multiple-choice underline__blank">
                    
                </div>
              
            </div>

            <ul class="list-unstyled">
                    <?php
                    $point = 0;
                    $s = 0;
                    if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
                        if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
                        $answerExists = true;
                        if(!empty($practise['user_answer'][0])){
                          $user_ans = $practise['user_answer'][0];
                        }
                      }
                    }
                    foreach($practise['question_2']  as $question) {
                        if(empty(trim($question))){ continue;}
                        ?>
                        <li>
                            <?php
                                if(str_contains($question,'@@')) {
                                    $ans = "";
                                    echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$newAns, &$data, &$question, &$k, &$userAnswer, &$ans, &$s, &$newinc, &$point, &$user_ans) {
                                        if(!empty($user_ans[$s])){
                                            // $str = '<span class="resizing-input1">
                                            //         <span contenteditable class="textarea form-control form-control-textarea  enter_disable spandata fillblanks stringProper text-left" placeholder="Enter text here....">'.$user_ans[$s].'</span>
                                            //         <input type="hidden" class="form-control form-control-inline appendspan" name="writeingBox[]" value="'.$user_ans[$s].'">
                                                    
                                            //     </span>';

                                                $str ='<span class=""><input type="text" class="form-control text-left pl-0 form-control-inline disableClass" name="writeingBox[]" value="'.$user_ans[$s].'" style="width: 80%;display: inline-table;padding-left: 0px !important;padding-right: 0px !important;" autocomplete="off" placeholder="Enter text here..."></span>';
                                          $k=$k+2;
                                          $newinc++;
                                          $point++;
                                        } else{

                                            $str ='<span class=""><input type="text" class="form-control text-left pl-0 form-control-inline disableClass" name="writeingBox[]" autocomplete="off" value="" style="width: 80%;display: inline-table;padding-left: 0px !important;padding-right: 0px !important;" placeholder="Enter text here..."></span>';

                                          // $str = '<span class="resizing-input1">
                                          //           <span contenteditable class="textarea form-control form-control-textarea  enter_disable spandata fillblanks stringProper text-left" placeholder="Enter text here...."></span>
                                          //           <input type="hidden" class="form-control form-control-inline appendspan" name="writeingBox[]" value="">
                                                    
                                          //       </span>';
                                        }
                                        return $str;
                                    }, $question);
                                } else { 
                                        $point++;
                                    echo '<input type="hidden" class="form-control text-left pl-0 form-control-inline" name="writeingBox[]"  style="width: 80%;display: inline-table;">';
                                    echo $question;
                                }
                                $s++;
                            ?>
                        </li>
                        <?php 
                    }
                ?>
            </ul>
      </div>
      <!-- ./ Compoent - Two click slider Ends-->

      <!-- /. List Button Start-->

    	<div class="alert alert-success" role="alert" style="display:none"></div>
    	<div class="alert alert-danger" role="alert" style="display:none"></div>
    	<ul class="list-inline list-buttons">
    	    <li class="list-inline-item">
                <input type="button" class="save_btn btn btn-primary submitBtn true_false_submitBtn_{{$practise['id']}}" data-is_save="0" value="Save">
    	    </li>
    	    <li class="list-inline-item">
                <input type="button" class="submit_btn btn btn-primary submitBtn true_false_submitBtn_{{$practise['id']}}" data-is_save="1" value="Submit">
          </li>
          <input type="hidden" name="role_play">
    	</ul>
    </form>

   


<?php } ?>
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

  var feedbackPopup     = true;
  var facilityFeedback  = true;
   var courseFeedback = false;
function AudioplayPopup(pid) {

    var supportsAudio = !!document.createElement('audio').canPlayType;
    if (supportsAudio) {
        $('.modal').find('.plyr__controls:first').remove()
        var i;
        var player = new Plyr(".modal .audio_"+pid, {
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

}
$(function () {


        $(document).on('click','.true_false_submitBtn_{{$practise['id']}}' ,function() {

            if($(this).attr('data-is_save') == '1'){
                  $(this).closest('.active').find('.msg').fadeOut();
              }else{
                  $(this).closest('.active').find('.msg').fadeIn();
              }
            var reviewPopup = '{!!$reviewPopup!!}';
            var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){

                if($(this).attr('data-is_save') == '1'){

                        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
                        var fullView= $(".form_{{$practise['id']}}").clone();
                        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
                        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
                        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
                        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
                        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.true-false_buttons').css('pointer-events',"none");
                        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.disableClass').attr('disabled',"true");
                        // AudioplayPopup("{{$practise['id']}}")
                        openRolePlayINPopup();

                }
            }
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){

                $("#reviewModal_{{$practise['id']}}").modal('toggle');

            }


            $('.btnSubmits_temp').attr('disabled','disabled');
            var is_save = $(this).attr('data-is_save');
            $('.is_save:hidden').val(is_save);
            $.ajax({
                url: '<?php echo URL('save-image-writing-at-end-up-new'); ?>',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                data: $('.form_<?php echo $practise['id'];?>').serialize(),
                success: function (data) {
                    $('.btnSubmits_temp').removeAttr('disabled');
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


    $(".form_{{$practise['id']}}").find(".selected_option").click(function () {
        
        $('.remove_d_done').each(function(){
                $(this).find('.content-box').removeClass('d-done');
        });

        var content_key = $(this).attr('data-key');
        $(".form_{{$practise['id']}}").find('.selected_option').not(this).toggleClass('d-none');
        $(".form_{{$practise['id']}}").find('.selected_option_description_'+content_key).toggleClass('d-none');
        $(".form_{{$practise['id']}}").find('.selected_option_description_temp_'+content_key).toggleClass('d-none');
        $(".form_{{$practise['id']}}").find('.selected_option_'+content_key).show();
        $(this).toggleClass('btn-bg');
     
        if( $('.selected_option_description:visible').length>0 ){
          var ans_key = (content_key == 0) ? 0 : 2;
          $(".form_{{$practise['id']}}").find('.prev_ans_'+ans_key).show();
          $(".form_{{$practise['id']}}").find('.is_roleplay_submit').val(0);
        }else{
          $(".form_{{$practise['id']}}").find('.prev_ans_0').hide();
          $(".form_{{$practise['id']}}").find('.prev_ans_2').hide();
          $(".form_{{$practise['id']}}").find('.is_roleplay_submit').val(1);
        }
        setTimeout(function(){
            $(".form_{{$practise['id']}} .selected_option_description_remove_0").removeClass("d-none");
            $(".form_{{$practise['id']}}").find(".selected_option_description_remove_0").css("display","blank !important");
            $('.remove_d_done').each(function(){
                $(this).find('.content-box').removeClass('d-done');
            });
       },2000)
    });
    $('.save_underline_text_form_{{$previous_practise_id}}').find('span.bg-success').each(function() {
    var blank  = `<p class="d-flex flex-wrap mb-4">1) `+$(this).text()+`
        <span class="textarea ml-1 flex-grow-1 form-control form-control-textarea mw-20" role="textbox" contenteditable placeholder="Write here...">
        </span>
      </p>`
    $('.underline__blank').append(blank)
  })
});

function openRolePlayINPopup(){
    $("#selfMarking_{{$practise['id']}}").find(".selected_option").click(function () {
        $('.remove_d_done').each(function(){
            $(this).find('.content-box').removeClass('d-done');
        });
        setTimeout(function(){
            // alert("Asdasd")
            $('.selected_option_description_remove_0').removeClass("d-none")
        },500);
        var content_key = $(this).attr('data-key');
        $("#selfMarking_{{$practise['id']}}").find('.selected_option').not(this).toggleClass('d-none');
        $("#selfMarking_{{$practise['id']}}").find('.selected_option_description_'+content_key).toggleClass('d-none');
        $("#selfMarking_{{$practise['id']}}").find('.selected_option_description_temp_'+content_key).toggleClass('d-none');
        $("#selfMarking_{{$practise['id']}}").find('.selected_option_'+content_key).show();
        $(this).toggleClass('btn-bg');
     
        if( $('.selected_option_description:visible').length>0 ) {

            var ans_key = (content_key == 0) ? 0 : 2;
            $("#selfMarking_{{$practise['id']}}").find('.prev_ans_'+ans_key).show();
            $("#selfMarking_{{$practise['id']}}").find('.is_roleplay_submit').val(0);

        } else {

            $("#selfMarking_{{$practise['id']}}").find('.prev_ans_0').hide();
            $("#selfMarking_{{$practise['id']}}").find('.prev_ans_2').hide();
            $("#selfMarking_{{$practise['id']}}").find('.is_roleplay_submit').val(1);

        }
    });
}

$(function () {
    $(document).on('keyup','.spandata',function(){
      $(this).next().val($(this).html())
    })
});

</script>

<style type="text/css">
  .form-control:disabled, .form-control[readonly]{
    background-color: #ffffff !important;
  }
    
    

    *[contenteditable]:empty:before
    {
        content: "\feff"; /* ZERO WIDTH NO-BREAK SPACE */
    }

    .appendspan {
        color:red;
    }

    .temp{
        min-width: 0ch !important;
    }

</style>