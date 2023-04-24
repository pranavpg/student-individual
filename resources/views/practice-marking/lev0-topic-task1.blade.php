<?php
    $rolecard_images  =  $practise['question'];
    $i = 0;
    $j = -1;
    $questions  = array();
    $rolecards  = array();
    foreach($practise['question_2'] as $key => $value)
    {
        if($key == 0)
        {
              $rolecards   = str_replace('{}','',$value);
              $rolecards   = explode('@@',$rolecards);
        }
        else
        {
             if($value == "##")
             {
             	 $i = 0;
             	 $j++;
             }
             else
             {
             	 $questions[$j][$i]  = $value;
             	 $i++;
             }   
        }
    }
    $k = 0;
    $user_answer  =  array();
    if(!empty($practise['user_answer']))
    {
         foreach($practise['user_answer'] as $key1 => $val)
         {
             if($val == "##")
             {
                 $k++;
             }
             else
             {
                 $user_answer[$k]  = $val;
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
  <input type="hidden" name="is_roleplay" value="true" >
  <input type="hidden" class="is_roleplay_submit" name="is_roleplay_submit" value="1">
  <!------------------------------------------->
  <div class="component-two-click mb-4">
    @if(!empty($rolecards))
      <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
        @foreach($rolecards as $k => $value)
         <a href="javascript:;" class="btn btn-dark lv0_selected_option lv0_selected_option_{{$k}}" data-key="{{$k}}">{{$value}}</a>
        @endforeach
      </div>
      <input type="hidden" name="tabcount" value="{{count($rolecards)}}">
    @endif
    <div class="two-click-content w-100">
        @if(!empty($questions))
          @php $roleplayCount = 0; @endphp
          @foreach($rolecards as $key => $value)
            <div class="content-box multiple-choice d-none selected_option_description lv0_selected_option_description_{{$key}}" >
              <div class="draw-image draw-image__small mb-5 text-center">
                <img style="margin:15px" width="600px" src="{{isset($rolecard_images[$key])?$rolecard_images[$key]:''}}" />
              </div>
                @foreach($questions[$key] as $new_key => $value1)
                   <div class="form-group my-2">
                      <p><b>{{str_replace("@@","",$value1)}}</b></p>
                      @if(str_contains($value1,"@@"))
                          <span class="textarea form-control form-control-textarea stringProper text-left enter_disable" role="textbox" contenteditable placeholder="Write here...">{{isset($user_answer[$key][0][$new_key])?$user_answer[$key][0][$new_key]:''}}</span>
                          <div style="display:none">
                           <textarea name="user_answer[{{$roleplayCount}}][0][{{$new_key}}]">
                            @php
                               if(isset($user_answer[$key][0][$new_key]))
                               {
                                   if(!is_null($user_answer[$key][0][$new_key]))
                                   {
                                        echo $user_answer[$key][0][$new_key]; 
                                   }
                               }
                            @endphp
                           </textarea>
                          </div>
                      @endif
                   </div>
                   <br>
                @endforeach
                @php
                 $roleplayCount++;
                @endphp
                <input type="hidden" name="user_answer[{{$roleplayCount}}]" value="##">
                @php
                 $roleplayCount++;
                @endphp
            </div>
          @endforeach
        @endif
    </div>
  </div>
  <!------------------------------------------->
  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
</form>
<script type="text/javascript">
  $(function () {
    $('.form_{{$practise["id"]}}').find(".lv0_selected_option").click(function () {
      var content_key = $(this).attr('data-key');
      $('.lv0_selected_option').not(this).toggleClass('d-none');
      $('.lv0_selected_option_description_'+content_key).toggleClass('d-none');
      $('.lv0_selected_option_description_'+content_key).show();
      $(this).toggleClass('btn-bg');
      $('.is_roleplay_submit').val(0);  
    });
  });
</script>