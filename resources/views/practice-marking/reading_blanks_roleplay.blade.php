@php
 $split_text = explode('##', $practise['question']);
 $conversation_option =  explode('@@',$split_text[0]);
 $tab_content = array();
 $i = 0;
 $count = substr_count($practise['question'],"@@");
 foreach($split_text as $key => $value)
 {
     if($key>0)
     {
         $tab_content[$i] = $value;
         $i++;
     } 
 }
 $options = array();
 $i = 0;
 $j = 0;
 foreach($practise['options'] as $key => $value)
 {
     if($value[0] == "##")
     {
         $i++;
         $j=0;
     }
     else
     {
         $options[$i][$j] = $value;
         $j++;
     }
 }
 $ans=array();
 $answerExists = false;
 if(isset($practise['user_answer']) && !empty($practise['user_answer']))
 {
     $new_ans = array();
     $answerExists = true;
     $user_answer  = $practise['user_answer'];
     $i = 0;
     $j = 0;
     foreach($user_answer as $key => $value)
     {
         if($value == "##")
         {
             $j=0;
         }
         else
         {
             $new_ans[$i] = $value;
             $i++;
         }
     }
 }
@endphp
<form class="form_{{$practise['id']}}" >
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  <input type="hidden" name="is_roleplay" value="true" >
  <input type="hidden" class="is_roleplay_submit" name="is_roleplay_submit" value="1">
  <!-- Compoent - Two click slider-->
  <div class="component-two-click mb-4">
    @if(!empty($conversation_option))
     <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
      @foreach($conversation_option as $key => $value)
            <a href="javascript:void(0)" class="btn btn-dark selected_option selected_option_{{$key}}" data-key="{{$key}}">{{$value}}</a>
      @endforeach
           <div {{$key}} class="two-click-content w-100">
        @if(!empty($tab_content))
         @foreach($tab_content as $key => $value)
          <?php if($options[$key] && !empty($options[$key])) { ?>
                <div class="match-answer d-none selected_option_description1_{{$key}}">
                    <div class="form-slider w-100 mr-auto ml-auto mb-5">
                        <div class="owl-carousel owl-theme diffowl">
                            @if(!empty($options[$key]))
                                @foreach($options[$key] as $k => $value1)
                                 <div class="item align-middle" data-itemNo="{{$k}}">
                                   <div class="table-slider-box text-center d-flex mt-3 pb-3" id="parent_{{$k}}">
                                    @foreach($value1 as $x=> $val)
                                        <?php 
                                            $border_class = ($x == 0 ? 'border-right' : '');
                                            $active_class = 'background-color: initial';
                                            if($answerExists == true)
                                            {
                                                    $active_class = 'background-color: #D2DBE3;';
                                            }
                                        ?>
                                        <div class="w-50 table-option mr-2 shadow bg-white {{ $border_class }} ">
                                            <a href="#!" class="task-options" id="{{$k}}_{{$x}}_{{$key}}" data-pos="{{$x}}" style="" data="{{$k}}" data-content="{{$val}}" class="{{$k}}_{{$x}}">{{ $val }}</a>
                                        </div>
                                    @endforeach
                                   </div>
                                 </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
        <br>
        <?php } ?>
          <div {{$key}} class="content-box multiple-choice d-none selected_option_description selected_option_description_{{$key}}">
            <div class="simple-list mb-4">
                <ul class="list-unstyled commonFontSize" >
                    <?php 
                     $inc = 0; 
                        if(str_contains($value,'@@')){
                          echo $outValue = preg_replace_callback('/@@/',function ($m) use (&$key, &$c, &$userAnswer, &$flag, &$s, &$value, &$practise, &$inc ,&$new_ans) {
                                $valnew = isset($new_ans[$key][0][$inc]['ans'])?$new_ans[$key][0][$inc]['ans']:'';
                                $valpos = isset($new_ans[$key][0][$inc]['ans_pos'])?$new_ans[$key][0][$inc]['ans_pos']:'';
                                $str = '<span class="resizing-input1">
                                        <span readonly disabled contenteditable="false" class="enter_disable spandata fillblanks stringProper text-left disable_writing edit_span"id="text-val'.$inc.$key.'">'.$valnew.'</span>
                                        <input type="hidden" class="form-control form-control-inline appendspan text_question" name="text_ans[ans]['.$key.'][]" id="hidden-val'.$inc.$key.'"value="'.$valnew.'">
                                        <input type = "hidden" class="form-control form-control-inline appendspan text_question"
                                         name="text_pos[ans]['.$key.'][]" id="hidden-pos'.$inc.$key.'"value="'.$valpos.'">
                                    </span>';
                                  $inc++;
                                 return $str;
                                }, $value);
                        }
                        else
                        {
                             echo  $value;
                        }
                        echo "<br>"
                    ?>
                </ul>
            </div>
          </div>
         @endforeach
        @endif
      </div>
     </div>
    @endif
  </div>
  <input type="hidden" name="ptype" value="reading_blanks" />
</form>
<script type="text/javascript">
//--------------------------------------------------------------------------------------------------------------
$(function () {
    $(".selected_option").click(function () {
       var content_key = $(this).attr('data-key');
       $('.selected_option').not(this).toggleClass('d-none');
       $('.selected_option_description_'+content_key).toggleClass('d-none');
       $('.selected_option_description1_'+content_key).toggleClass('d-none');
       $('.selected_option_'+content_key).show();
       $(this).toggleClass('btn-bg');
       $('.is_roleplay_submit').val(0);
    });
});
//-------------------------------------------------------------------------------------------------------------
$(document).ready(function() {
    var maxcounter= {{ $count }} ;
    var selected_option = '';
    var owl =  $('.diffowl');
    var selected_item ='';
    var selected_color='#D2DBE3';
    owl.owlCarousel({
        loop:false,
        margin: 10,
        pagination: false,
        items: 1,
        nav: true,
        dots: false,
        touchDrag:false,
        mouseDrag:false,
        onInitialized: function()
        {
             if($(this).find(".owl-item.active").index() == $(this).find(".own-item").first().index()) {
                  
             }
        },
        onChange: function()
        {

        }
    })
    $(".task-options").click(function(){
       let  newVal       =  this.id;
       let  optionVal    =  $(this).attr("data-content");
       let  dpos         =  $(this).attr("data-pos");
       let  secVal       =  newVal.split("_"); 
       let  currentBlank =  secVal[0];
       let  cuurentTab   =  secVal[2];
       let  current_id   =  "text-val"+currentBlank+cuurentTab;
       let  current_hidden   =  "hidden-val"+currentBlank+cuurentTab;
       let  current_pos      =  "hidden-pos"+currentBlank+cuurentTab;
       $("#"+current_id).text(optionVal);
       $("#"+current_hidden).val(optionVal); 
       $("#"+current_pos).val(dpos); 
    });
});
//-------------------------------------------------------------------------------------------------------------
</script>
