<p><strong>{!! $practise['title'] !!}</strong></p>

<?php
  $answerExists = false;
  if(!empty($practise['user_answer'])){
      $answerExists = true;
      $answer = $practise['user_answer'];
  }else if(!empty($practise['question_2'])){
      $preanswer = $practise['question_2'];
  }
?>
<!--Component Conversation-->
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

  <div class="conversation d-flex flex-column">
    @if(!empty($practise['question']))
       @foreach( $practise['question'] as $key => $value )
        <?php
          $count = 0;
          $k=$key;
            if(!empty($answer[$key])){
              $exp_answer =  array_filter(explode(';',$answer[$key]));
            }
            if(!empty($preanswer[$key])){
              $exp_answer = array_filter(explode('@@',$preanswer[$key]));
            }
            if(str_contains($value,'@@')){
              $outValue = preg_replace_callback('/@@/',
                  function ($m) use (&$key, &$count, &$exp_answer) {
                    $ans= !empty($exp_answer[$count])?trim(str_replace('_','',$exp_answer[$count])):"";
                    $count++;
                    $str = '<span class="textarea d-inline-flex mw-20 form-control form-control-textarea conversation_answer_'.$count.'" role="textbox" contenteditable placeholder="Write here...">'.$ans.'</span><input type="hidden" name="text_ans['.$key.']['.$count.']" value="'.$ans.'">';
                    return $str;
                  }
                  , $value);
            } else {
              $outValue = $value.'<input type="hidden" name="text_ans['.$key.'][0]" value="">';
            }


          if( $key%2==0 ){
            $class="mr-auto mb-4";
          } else {
            $class="convrersation-box__dark ml-auto mb-4";
          }
        ?>
        <div class="convrersation-box {{$class}}">
            <p> {!! $outValue !!}</p>
        </div>
      @endforeach
    @endif

      <!-- /. Conversation Box -->
  </div>
  <!--Component Conversation End-->

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
  function setInputContent(pid){
    $('.form_'+pid).find("span.textarea.form-control").each(function(i){
      var currentVal = $(this).html();
      //console.log(i,'====>,',currentVal)
      if($.trim(currentVal)!=""){

        $(this).next().val('_'+currentVal+'_');
      } else {
        $(this).next().val(currentVal);
      }
    });
  }
  $('.form_{{$practise["id"]}}').on('click','.submitBtn_{{$practise["id"]}}' ,function() {

    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
      }else{
        $(this).closest('.active').find('.msg').fadeIn();
      }
      var reviewPopup = '{!!$reviewPopup!!}';
      var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
      if(markingmethod =="student_self_marking"){
        if($(this).attr('data-is_save') == '1'){                    
          var fullView= $(".form_{{$practise['id']}}").html();                    
          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.enter_disable').attr("contenteditable",false);
          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.textarea').attr("contenteditable",false);
        }
      }
      if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){
                $("#reviewModal_{{$practise['id']}}").modal('toggle');
      }
      
    $('.submitBtn_{{$practise["id"]}}').attr('disabled','disabled');
    var pid =  $(this).attr('data-pid');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);
      setInputContent(pid);
    $.ajax({
        url: '<?php echo URL('save-conversation-simple-multi-blank'); ?>',
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
    return false;
  });
</script>
