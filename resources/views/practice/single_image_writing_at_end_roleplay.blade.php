@if($practise['id'] != "167697001163f4881be1885" && $practise['id'] != "1666885830635aa8c6350d6"
&& $practise['id'] != "1666885932635aa92c42751" && $practise['id'] != "16656582096347ed6156e82")
<?php
//  echo '<pre>'; print_r($practise); echo '</pre>'; 
    $answerExists = false;
    if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
      $answerExists = true;
    }
    if(isset($practise['question_2']) && !empty( $practise['question_2'] ) ) {
      // $explode_question = explode('##',$practise['question_2']);
      $practise['question_2'][0] = str_replace('{}','',$practise['question_2'][0]);
      $two_tabs= explode('@@', $practise['question_2'][0]);
      $roleplay_question =array();
      $explode_question= $practise['question'];
      $explode_question_2= $practise['question_2'][2];
      // array_shift($explode_question);
    }
  ?>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  <input type="hidden" name="is_roleplay" value="true" >
  <input type="hidden" class="is_roleplay_submit" name="is_roleplay_submit" value="1">
  <!-- /. Component Audio Player END-->
  
    
  <div class="component-two-click mb-4">
      @if(!empty($two_tabs))
          <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
            @foreach($two_tabs as $key => $value)
              <a href="javascript:;" class="btn btn-dark selected_option selected_option_{{$key}}" data-key="{{$key}}">{{$value}}</a>
            @endforeach 
          </div>
          <input type="hidden" name="tabcount" value="{{count($two_tabs)}}">
      @endif
      <div class="two-click-content w-100">
        @if(!empty($explode_question))
        <?php $answer_count =$roleplayCount= 0; $txtwritingCount = 0; ?>
        
          @foreach($explode_question as $k => $v)
            <div class="content-box multiple-choice d-none selected_option_description selected_option_description_{{$k}}" >
              <div class="draw-image draw-image__small mb-5 text-center">
                <img style="margin:15px" width="600px" src="{{$v}}" />
              </div>              
            <div class="form-group">
                      <span class="textarea form-control form-control-textarea stringProper text-left enter_disable" role="textbox" contenteditable placeholder="Write here..."><?php if (isset($practise['user_answer'][$answer_count][0][0]) && !empty($practise['user_answer'][$answer_count][0][0])) { echo ($practise['user_answer'][$answer_count][0][0]); } ?></span>
                      <div style="display:none">
                        <textarea name="user_answer[{{$answer_count}}][0][0]">
                        <?php
                            if(isset($practise['user_answer'][$answer_count][0][0]) && !empty($practise['user_answer'][$answer_count][0][0]))
                            {
                              echo  $practise['user_answer'][$answer_count][0][0];
                            }
                        ?>
                        </textarea>
                      </div>
                      </div>  
          </div>
          @php $answer_count= $answer_count + 2; 
            $roleplayCount= $answer_count-1 ;
           @endphp
          <input type="hidden" name="user_answer[{{$roleplayCount}}]" value="##">
          @endforeach
        @endif
      </div>
  </div>

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
<script>
  $(function () {
    $('.form_{{$practise["id"]}}').find(".selected_option").click(function () {
      var content_key = $(this).attr('data-key');
   
      $(".form_{{$practise['id']}}").find('.selected_option').not(this).toggleClass('d-none');
      $('.form_{{$practise["id"]}}').find('.selected_option_description_'+content_key).toggleClass('d-none');
      $('.form_{{$practise["id"]}}').find('.selected_option_description_'+content_key).show();
      $(this).toggleClass('btn-bg');
      
      $(".showPreviousPractice_{{$practise['id']}}").html("")
      if( $('.form_{{$practise["id"]}}').find('.selected_option_description:visible').length>0 ){
        //roleplayDependent(content_key)
        $(".showPreviousPractice_{{$practise['id']}}").show();
        $('.form_{{$practise["id"]}}').find('.is_roleplay_submit').val(0);
      }else{
        $('.form_{{$practise["id"]}}').find('.is_roleplay_submit').val(1);
        $(".showPreviousPractice_{{$practise['id']}}").hide();
        $(".showPreviousPractice_{{$practise['id']}}").html("")
      }
    });
  });
</script>
@else
  <!-- add static for level 0  aes topic 1 task 1a t -->
  @include('practice.lev0-topic-task1')
@endif

