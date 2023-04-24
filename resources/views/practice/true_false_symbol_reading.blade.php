<p>
  <strong><?php echo $practise['title']; //dd($practise);
  // echo '<pre>'; print_r($practise); 
  ?></strong>
</p>
<form class="save_true_false_symbol_reading_form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  @if(isset($practise['typeofdependingpractice']))
    <input type="hidden" class="typeofdependingpractice" name="typeofdependingpractice" value="{{$practise['typeofdependingpractice']}}">
  @endif


    <?php
    if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
        $depend =explode("_",$practise['dependingpractiseid']);
    ?>
      <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
      <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
      <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
      <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
     </div>
     <br>
       <?php

    }

    if(isset($practise['typeofdependingpractice']) && $practise['typeofdependingpractice'] == 'get_answers_put_into_questions_self_marking' && $practise['depending_practise_details']['question_type'] == 'reading_total_blanks_speaking'){
              // pr($practise['question']);

      $practise['question']=  str_replace("@@","***@@",$practise['question']);
        $practise['question']= str_replace("#!"," ",$practise['question']);
        $exploded_question = explode(PHP_EOL,$practise['question']);
        
        // $exploded_question  =  explode('@@', $practise['question']);
      }else{
          $temp = [];
          $practise['question']=  str_replace("@@","***@@",$practise['question']);
            $practise['question']= str_replace("#!","@@",$practise['question']);
            $exploded_question  =  explode('@@', $practise['question']);                      

            foreach ($exploded_question as $key => $value) {
                
                array_push($temp, str_replace("\r\n","", $value));
                # code...
            }
             $exploded_question = $temp;                
      }


    $user_answer = false;

    if(isset($practise['user_answer'])){
        $answerExists = true;
        
          // dd($practise['user_answer'][0]);
        $answers = '';
        foreach ($practise['user_answer'][0] as $key => $value) {
            if (!empty($value['true_false'])) {
              # code...
              $answers[$key] = $value['true_false'];
            }
        }
        $final_answer = json_encode($answers);
        //dd($practise['user_answer']);
    }

    $i=0;

    //dd($exploded_question);
     ?>

    <div class="true-false" id="true_false_{{$practise['id']}}">
      @if(isset($practise['typeofdependingpractice']) && $practise['typeofdependingpractice'] == 'get_questions_and_answers_self_marking_double' && isset($practise['typeofdependingpractice'])) 
      
                  @foreach($exploded_question as $key => $item)
                    <div class="box box-flex d-flex align-items-center">
                        <div class="box__left box__left_radio"> 
                              <p> <?php echo str_replace('***',"<span id='span_true_false_readings_$i'></span>", $item) ?> </p>
                        </div>
                        @if(strpos($item,"***"))

                          <input type="hidden" name="user_question[]" value="{{$item.' @@'}}">
                          <input type="hidden" name="dependan_answer[]" id="dependan_answer_{{$i}}" value="{{$item.' @@'}}">
                          <div class="true-false_buttons true-false_buttons_radio">
                              <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio"
                                      name="true_false[{{$i}}]" id="inlineRadioTrue{{$i}}"
                                      value="1" {{ isset($practise['user_answer'][0][$i]['true_false']) && !empty($practise['user_answer'][0][$i]['true_false']) && $practise['user_answer'][0][$i]['true_false'] == '1' ?  'checked' :  " " }} >
                                  <label class="form-check-label form-check-label_true"
                                      for="inlineRadioTrue{{$i}}"></label>
                              </div>
                              <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio"
                                      name="true_false[{{$i}}]" id="inlineRadioFalse{{$i}}"
                                      value="0" {{ isset($practise['user_answer'][0][$i]['true_false'])  && $practise['user_answer'][0][$i]['true_false'] == '0' ?  'checked' :  '' }} >
                                  <label class="form-check-label form-check-label_false"
                                      for="inlineRadioFalse{{$i}}"></label>
                              </div>
                          </div>
                          <?php $i++; ?>
                        @endif
                    </div>
                      <!-- /. box -->
                  @endforeach
              @if(isset($practise['dependingpractise_answer']))
                  @if(isset($practise['depending_practise_details']))
                    @if(isset($practise['depending_practise_details']['independant_practise']))
                      @if(isset($practise['depending_practise_details']['independant_practise']['user_answer'][0]) )

                          <?php $user_answer = explode(';', $practise['depending_practise_details']['independant_practise']['user_answer'][0]);  ?>
                            @foreach($user_answer as $key => $item)
                            @if(!empty($practise['dependingpractise_answer'][0][$key]) && isset($practise['dependingpractise_answer'][0][$key]) )
                              @if(isset($practise['depending_practise_details']['independant_practise']['practise_details']['question'][$key]))
                             <div class="box box-flex d-flex align-items-center">
                              <div class="box__left box__left_radio"> 
                                      <p> {{ isset($practise['depending_practise_details']['independant_practise']['practise_details']['question'][$key]) ?  str_replace("Word @@ Synonym #@","",$practise['depending_practise_details']['independant_practise']['practise_details']['question'][$key] ) :  '' }} 
                                      :
                                     {{ isset($practise['depending_practise_details']['independant_practise']['practise_details']['question_2'][$item]) ?  $practise['depending_practise_details']['independant_practise']['practise_details']['question_2'][$item]  :  '' }} 
                                    </p>
                                    <p>{{$practise['dependingpractise_answer'][0][$key]}}</p>
                              </div>

                                <input type="hidden" name="user_question[]" value="{{ isset($practise['depending_practise_details']['independant_practise']['practise_details']['question'][$key]) ?  str_replace('Word @@ Synonym #@','',$practise['depending_practise_details']['independant_practise']['practise_details']['question'][$key] ) :  '' }} 
                                      :
                                     {{ isset($practise['depending_practise_details']['independant_practise']['practise_details']['question_2'][$item]) ?  $practise['depending_practise_details']['independant_practise']['practise_details']['question_2'][$item]  :  '' }} <br>{{$practise['dependingpractise_answer'][0][$key]}} @@ ">
                                <input type="hidden" name="dependan_answer[]" id="dependan_answer_{{$i}}" value="{{$practise['dependingpractise_answer'][0][$key]}}">
                                <div class="true-false_buttons true-false_buttons_radio">
                                    <div class="form-check form-check-inline">
                                    <input type="hidden" name="true_false[{{$i}}]" value="-1" >
                                        <input class="form-check-input" type="radio"
                                            name="true_false[{{$i}}]" id="inlineRadioTrue{{$i}}"
                                            value="1" {{ isset($practise['user_answer'][0][$i]['true_false']) && !empty($practise['user_answer'][0][$i]['true_false']) && $practise['user_answer'][0][$i]['true_false'] == '1' ?  'checked' :  " " }} >
                                        <label class="form-check-label form-check-label_true"
                                            for="inlineRadioTrue{{$i}}"></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"
                                            name="true_false[{{$i}}]" id="inlineRadioFalse{{$i}}"
                                            value="0" {{ isset($practise['user_answer'][0][$i]['true_false'])  && $practise['user_answer'][0][$i]['true_false'] == '0' ?  'checked' :  '' }} >
                                        <label class="form-check-label form-check-label_false"
                                            for="inlineRadioFalse{{$i}}"></label>
                                    </div>
                                </div>
                                <?php $i++; ?>
                              </div>
                              @endif
                              @endif
                            @endforeach
                        @endif
                      @endif
                    @endif
                  @endif
              @elseif(isset($practise['typeofdependingpractice']) && $practise['typeofdependingpractice'] == 'get_speaking_audios_self_marking') 
                  <?php // echo '<pre>'; print_r($exploded_question);  ?>
                   @foreach($exploded_question as $key => $item)
                    <?php $key2 = $key - 1 ;?>
                    @if(!empty($practise['dependingpractise_answer'][$key2]) && isset($practise['dependingpractise_answer'][$key2]))
                    <div class="box box-flex d-flex align-items-center">
                        <div class="box__left box__left_radio"> 
                              <p> <?php echo str_replace('***',"<span id='span_true_false_readings_$i'></span>", $item);
                                   
                              ?> </p>
                              <p>@include('practice.common.audio_multi_player',['key'=>$key2,'path'=>$practise['dependingpractise_answer'][$key2]])</p>
                              
                          <input type="hidden" name="path[]" value="{{$practise['dependingpractise_answer'][$key2]}}">
                          <input type="hidden" name="recorded[]" value="true">
                          <input type="hidden" name="played[]" value="false">

                        </div>
                        @if(strpos($item,"***"))

                          <input type="hidden" name="user_question[]" value="{{isset($practise['dependingpractise_answer'][0]['text_ans'][$key]) ?  $practise['dependingpractise_answer'][0]['text_ans'][$key] :  str_replace('***','',$item)}}@@">
                          <input type="hidden" name="dependan_answer[]" id="dependan_answer_{{$i}}" value="{{isset($practise['dependingpractise_answer'][0]['text_ans'][$key]) ?  $practise['dependingpractise_answer'][0]['text_ans'][$key] :  '' }}">
                          <div class="true-false_buttons true-false_buttons_radio">
                              <div class="form-check form-check-inline">
                              <input type="hidden" name="true_false[{{$i}}]" value="-1" >
                                  <input class="form-check-input" type="radio"
                                      name="true_false[{{$i}}]" id="inlineRadioTrue{{$i}}"
                                      value="1" {{ isset($practise['user_answer'][0][$i]['true_false']) && !empty($practise['user_answer'][0][$i]['true_false']) && $practise['user_answer'][0][$i]['true_false'] == '1' ?  'checked' :  " " }} >
                                  <label class="form-check-label form-check-label_true"
                                      for="inlineRadioTrue{{$i}}"></label>
                              </div>
                              <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio"
                                      name="true_false[{{$i}}]" id="inlineRadioFalse{{$i}}"
                                      value="0" {{ isset($practise['user_answer'][0][$i]['true_false'])  && $practise['user_answer'][0][$i]['true_false'] == '0' ?  'checked' :  '' }} >
                                  <label class="form-check-label form-check-label_false"
                                      for="inlineRadioFalse{{$i}}"></label>
                              </div>
                          </div>
                          <?php $i++; ?>
                        
                        @endif
                    </div>
                    @else
                  
                      @if(!str_contains($item,'***'))
                        {!!$item!!}<br><br>
                      @endif
                    @endif
                      <!-- /. box -->
                  @endforeach

              @elseif(isset($practise['typeofdependingpractice']) && $practise['typeofdependingpractice'] == 'get_answers_put_into_quetions')     
                    <?php $ansKey = 0; $ansType = 1; ?>
                     @foreach($exploded_question as $key => $item)
                    <div class="box box-flex d-flex align-items-center">
                        <div class="box__left box__left_radio">
                              <p> 
                              <?php 
                              $str="";
                              $fnalStr = "";
                              $ansType = 1;
                              $usr_ans_que = "";
                              if(strpos($item,"Answer:") || strpos($item, "Question: :") || strpos($item,"Question:")){
                                $ansType = 1;

                                $tf_dp_answers = (isset($practise['dependingpractise_answer'][0]))? explode(";",$practise['dependingpractise_answer'][0]) : [];
                                //dd($tf_dp_answers);
                                $item = str_replace("?<br>","",$item);
                                $item = str_replace("? <br>","",$item);
                                $valSpace1 = (!isset($tf_dp_answers[$ansKey]) || trim($tf_dp_answers[$ansKey]) == "")? "" : $tf_dp_answers[$ansKey];
                                $str ='Question: <span class="resizing-input1"><span contenteditable="false" class="enter_disable spandata fillblanks stringProper text-left" style="color: #03A9F4">'.$valSpace1.'</span></span>?<br />Answer:';
                                $valSpace = (!isset($tf_dp_answers[$ansKey]) || trim($tf_dp_answers[$ansKey]) == "")? '_____' : $tf_dp_answers[$ansKey];
                                $strText ='Question:  <b><font color = "#03A9F4">'.$valSpace.'</font></b><br>@@';

                                $item = str_replace('Question: :',"", $item);
                                $item = str_replace('Question:',"", $item);
                                $item = str_replace('***',"", $item);
                                $fnalStr = str_replace('Answer:',$str, $item);
                                $usr_ans_que = str_replace('Answer:',$strText, $item);
                              }else{
                                if(strpos($item,"***")){
                                  $ansType = 2;
                                }
                                $tf_dp_answers = (isset($practise['dependingpractise_answer'][0]['text_ans']))? $practise['dependingpractise_answer'][0]['text_ans'] : [];
                                $andVal = (isset($tf_dp_answers[$ansKey]))? $tf_dp_answers[$ansKey] : "";
                                if(strpos($item,"Question: ***") > -1){
                                  $ansType = 1;
                                }
                                $str ='<span class="resizing-input1"><span contenteditable="false" style="text-color:#03A9F4" class="enter_disable spandata fillblanks stringProper text-left">'.$andVal.'</span></span>';
                                if(strpos($item,"Question:") == "Question: ***" || strpos($item,"Question:") == "Question: :***"){
                                  $str = "";
                                }
                                $valSpace = (!isset($tf_dp_answers[$ansKey]) || trim($tf_dp_answers[$ansKey]) == "")? '_____' : $tf_dp_answers[$ansKey];
                                $strText ='<b><font color = "#03A9F4">'.$valSpace.'</font></b><br>@@';

                                $item = str_replace('Question: :',"", $item);
                                $item = str_replace('Question:',"", $item);
                                $fnalStr = str_replace('***',$str, $item);
                                $usr_ans_que = str_replace('***',$strText, $item);
                              }
                              echo $fnalStr; ?> </p>
                        </div>
                        @if(strpos($item,"Answer:") || $ansType == 2)
                          <?php $ansKey++;  ?>
                          <input type="hidden" name="customType" value="true">
                          <input type="hidden" name="user_question[]" value="{{$usr_ans_que}}">
                          <input type="hidden" name="dependan_answer[]" id="dependan_answer_{{$i}}" value="{{isset($practise['dependingpractise_answer'][0]['text_ans'][$key]) ?  $practise['dependingpractise_answer'][0]['text_ans'][$key] :  '' }}">
                          <div class="true-false_buttons true-false_buttons_radio">
                              <div class="form-check form-check-inline">
                              <input type="hidden" name="true_false[{{$i}}]" value="-1" >
                                  <input class="form-check-input" type="radio"
                                      name="true_false[{{$i}}]" id="inlineRadioTrue{{$i}}"
                                      value="1" {{isset($practise['user_answer'][0][$i]['true_false']) && !empty($practise['user_answer'][0][$i]['true_false']) && $practise['user_answer'][0][$i]['true_false'] == '1' ?  'checked' :  '' }} >
                                  <label class="form-check-label form-check-label_true"
                                      for="inlineRadioTrue{{$i}}"></label>
                              </div>
                              <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio"
                                      name="true_false[{{$i}}]" id="inlineRadioFalse{{$i}}"
                                      value="0" {{ isset($practise['user_answer'][0][$i]['true_false'])  && $practise['user_answer'][0][$i]['true_false'] == '0' ?  'checked' :  '' }} >
                                  <label class="form-check-label form-check-label_false"
                                      for="inlineRadioFalse{{$i}}"></label>
                              </div>
                          </div>
                          <?php $i++; ?>
                        @endif
                    </div>
                      <!-- /. box -->
                  @endforeach

              @elseif(isset($practise['typeofdependingpractice']) && $practise['typeofdependingpractice'] == 'get_answers_put_into_questions_self_marking')  
                @if($practise['depending_practise_details']['question_type'] == 'reading_total_blanks_speaking' && $practise['typeofdependingpractice'] == 'get_answers_put_into_questions_self_marking') 
                    @php
                      $ans=array();
                          if(isset($practise['dependingpractise_answer'][0]['text_ans']) && !empty($practise['dependingpractise_answer'][0]['text_ans'])){
                          $userAns= explode(';',$practise['dependingpractise_answer'][0]['text_ans']);
                        }
                      $k=0;
                     @endphp
                      @foreach($exploded_question as $key => $item)

                        <div class="box box-flex d-flex align-items-center">
                            <div class="box__left box__left_radio">
                                  <p> <?php  $values=$item;
                              if(str_contains($item,'@@')) {
                                $values=$item;
                                $outValue = preg_replace_callback('/@@/',function ($m) use(&$userAns,&$innerkey,&$p,&$k) {
                                    $valueOrignal = "";
                                    if(!empty($userAns)){
                                      $valueOrignal = trim($userAns[$k]);
                                    }
                                    $valueOrignal = $valueOrignal==""?"____":$valueOrignal;
                                    $str ="<b><span style='color:#03A9F4;'>".$valueOrignal."</span></b>";
                                    return $str;
                                }, $values);

                                $hiddenans = preg_replace_callback('/@@/',function ($m) use(&$userAns,&$innerkey,&$p,&$k) {
                                  $valueOrignal = "";
                                  if(!empty($userAns)){
                                    $valueOrignal = trim($userAns[$k]);
                                  }
                                  $valueOrignal = $valueOrignal==""?"____":$valueOrignal;
                                  $str ="<b><span style='color:#03A9F4;'>".$valueOrignal."</span></b>";
                                  return $str;
                                }, $values);
                                $hiddenans = $hiddenans . "@@";
                                $hiddenans = str_replace('***','',$hiddenans);

                                echo '<input type="hidden" class="form-control form-control-inline appendspan" name="user_question[]" value="'.$hiddenans.'"></span>';
                                $k++;
                                echo str_replace('***','',$outValue);
                              } else {
                                $outValue=$values;
                                echo $outValue;
                              }
                              $item = $outValue; 
                            ?> </p>
                                
                            </div>
                            @if(strpos($item,"***"))

                              <!-- <input type="hidden" name="user_question[]" value="{{$item}}">
                              <input type="hidden" name="dependan_answer[]" id="dependan_answer_{{$i}}" value="{{$item.'@@'}}"> -->
                              <div class="true-false_buttons true-false_buttons_radio">
                                  <div class="form-check form-check-inline">
                                  <input type="hidden" name="true_false[{{$i}}]" value="-1" >
                                      <input class="form-check-input" type="radio"
                                          name="true_false[{{$i}}]" id="inlineRadioTrue{{$i}}"
                                          value="1" {{ isset($practise['user_answer'][0][$i]['true_false']) && !empty($practise['user_answer'][0][$i]['true_false']) && $practise['user_answer'][0][$i]['true_false'] == '1' ?  'checked' :  " " }} >
                                      <label class="form-check-label form-check-label_true"
                                          for="inlineRadioTrue{{$i}}"></label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio"
                                          name="true_false[{{$i}}]" id="inlineRadioFalse{{$i}}"
                                          value="0" {{ isset($practise['user_answer'][0][$i]['true_false'])  && $practise['user_answer'][0][$i]['true_false'] == '0' ?  'checked' :  '' }} >
                                      <label class="form-check-label form-check-label_false"
                                          for="inlineRadioFalse{{$i}}"></label>
                                  </div>
                              </div>
                              <?php $i++; ?>
                            @endif
                        </div>
                          <!-- /. box -->
                      @endforeach
                      <input type="hidden" name="customType" value="true">
                  @else
                  
                  <?php $dependQuestion=array(); ?>  
                  @foreach($exploded_question as $key => $item)
                  <?php  if($item != "***"){ ?>

                      <div class="box box-flex d-flex align-items-center">
                          <div class="box__left box__left_radio">
                                <p> <?php 
                                if(str_contains($item,'***')){
                                  $dependQuestion[]=str_replace('***',"", $item);
                                }else{
                                  echo $item;
                                }
                                // echo str_replace('***',"", $item)  ?> </p>
                          </div>
                          
                      </div>
                    <?php } ?>
                    @endforeach
                  
                  @if(isset($practise['dependingpractise_answer']) && count($practise['dependingpractise_answer']) > 0)
                  @foreach($practise['dependingpractise_answer'][0]['text_ans'] as $key => $item)
                   @if(!empty($item) && isset($item))
                    <div class="box box-flex d-flex align-items-center">
                        <div class="box__left box__left_radio"> 
                         
                          @if(isset($dependQuestion) && !empty($dependQuestion))
                                @php 
                              $item = $dependQuestion[$key]."<br><font color = '#03A9F4'>".$item."</font> @@";
                                   
                                @endphp
                          @else
                            @php 
                              $item = "<font color = '#03A9F4'>".$item."</font> @@";
                            @endphp
                          
                          @endif
                              <p><?php echo str_replace('@@',"", $item)  ?></p>
                        </div>
                       

                          <input type="hidden" name="user_question[]" value="{!!$item!!}">
                          <input type="hidden" name="dependan_answer[]" id="dependan_answer_{{$i}}" value="{{$item.'@@'}}">
                          <div class="true-false_buttons true-false_buttons_radio">
                              <div class="form-check form-check-inline">
                              <input type="hidden" name="true_false[{{$i}}]" value="-1" >
                                  <input class="form-check-input" type="radio"
                                      name="true_false[{{$i}}]" id="inlineRadioTrue{{$i}}"
                                      value="1" {{ isset($practise['user_answer'][0][$i]['true_false']) && !empty($practise['user_answer'][0][$i]['true_false']) && $practise['user_answer'][0][$i]['true_false'] == '1' ?  'checked' :  " " }} >
                                  <label class="form-check-label form-check-label_true"
                                      for="inlineRadioTrue{{$i}}"></label>
                              </div>
                              <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio"
                                      name="true_false[{{$i}}]" id="inlineRadioFalse{{$i}}"
                                      value="0" {{ isset($practise['user_answer'][0][$i]['true_false'])  && $practise['user_answer'][0][$i]['true_false'] == '0' ?  'checked' :  '' }} >
                                  <label class="form-check-label form-check-label_false"
                                      for="inlineRadioFalse{{$i}}"></label>
                              </div>
                          </div>
                          <?php $i++; ?>
                    </div>
                        @endif
                      <!-- /. box -->
                  @endforeach

                  @endif
                  @endif
              @else
                  @foreach($exploded_question as $key => $item)
                    <div class="box box-flex d-flex align-items-center">
                        <div class="box__left box__left_radio"> 
                              <p> <?php echo str_replace('***',"<span id='span_true_false_readings_$i'></span>", $item) ; ?> </p>
                        </div>
                        @if(strpos($item,"***"))

                          <input type="hidden" name="user_question[]" value="{{$item.'@@'}}">
                          <input type="hidden" name="dependan_answer[]" id="dependan_answer_{{$i}}" value="{{isset($practise['dependingpractise_answer'][0][$key]) ?  $practise['dependingpractise_answer'][0][$key] :  ''}}">
                          <div class="true-false_buttons true-false_buttons_radio">
                              <div class="form-check form-check-inline">
                              <input type="hidden" name="true_false[{{$i}}]" value="-1" >
                                  <input class="form-check-input" type="radio"
                                      name="true_false[{{$i}}]" id="inlineRadioTrue{{$i}}"
                                      value="1" {{ isset($practise['user_answer'][0][$i]['true_false']) && !empty($practise['user_answer'][0][$i]['true_false']) && $practise['user_answer'][0][$i]['true_false'] == '1' ?  'checked' :  " " }} >
                                  <label class="form-check-label form-check-label_true"
                                      for="inlineRadioTrue{{$i}}"></label>
                              </div>
                              <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio"
                                      name="true_false[{{$i}}]" id="inlineRadioFalse{{$i}}"
                                      value="0" {{ isset($practise['user_answer'][0][$i]['true_false'])  && $practise['user_answer'][0][$i]['true_false'] == '0' ?  'checked' :  '' }} >
                                  <label class="form-check-label form-check-label_false"
                                      for="inlineRadioFalse{{$i}}"></label>
                              </div>
                          </div>
                          <?php $i++; ?>
                        @endif
                    </div>
                      <!-- /. box -->
                  @endforeach
              @endif
    </div>

        <div class="alert alert-success" role="alert" style="display:none">         
        </div>
        <ul class="list-inline list-buttons">
            <li class="list-inline-item">
              <!-- <a href="#!" class="btn btn-primary"
                    data-toggle="modal" data-target="#exitmodal">Save</a> -->
                    <input type="button" class="save_btn trueFalseSymbolReading_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
            </li>
            <li class="list-inline-item">
             <input type="button" class="submit_btn trueFalseSymbolReading_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">

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
      <?php
        // $checked = json_encode(isset($practise['dependingpractise_answer']));
        if (isset($practise['dependingpractise_answer'])) {
          # code...
          $temp1 = json_encode($practise['dependingpractise_answer']);
        }else{
          $temp1 = "";
        }
      ?>
      <script>

        var temp = "{{json_encode(isset($practise['dependingpractise_answer']))}}";
      
          var temp1 = "{{$temp1}}";

      
        // alert(temp);
      $(document).on('click',".trueFalseSymbolReading_{{$practise['id']}}" ,function() {

          if($(this).attr('data-is_save') == '1'){
                $(this).closest('.active').find('.msg').fadeOut();
            }else{
                $(this).closest('.active').find('.msg').fadeIn();
            }
            
        var reviewPopup = '{!!$reviewPopup!!}';
        var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){
                    var fullView= $(".save_true_false_symbol_reading_form_{{$practise['id']}}").html();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
                }
            }
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){

                $("#reviewModal_{{$practise['id']}}").modal('toggle');

            }

        $(".trueFalseSymbolReading_{{$practise['id']}}").attr('disabled','disabled');
        var is_save = $(this).attr('data-is_save');
        $('.is_save:hidden').val(is_save);
        // setTextareaContent();
        $.ajax({
            url: "{{url('save-true-false-symbol-reading')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: $(".save_true_false_symbol_reading_form_{{$practise['id']}}").serialize(),
            success: function (data) {
              $(".trueFalseSymbolReading_{{$practise['id']}}").removeAttr('disabled');

                $('.alert-success').show().html(data.message).fadeOut(8000);

            }
        });

      });
      $(window).on('load', function() {
        var practise_id=$(".save_true_false_symbol_reading_form_{{$practise['id']}}").find('.depend_practise_id').val();
        if(practise_id){
            var x = getDependingPractise() ;

        }


        function getDependingPractise(){

          var topic_id= $(".save_true_false_symbol_reading_form_{{$practise['id']}}").find('.topic_id').val();
          var task_id=$(".save_true_false_symbol_reading_form_{{$practise['id']}}").find('.depend_task_id').val();
          var practise_id=$(".save_true_false_symbol_reading_form_{{$practise['id']}}").find('.depend_practise_id').val();

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
                      console.log('====>',data);
                      //console.log('====>',data.user_Answer[0].length);
                      var isBlank = true
                      for(var x in data.user_Answer){
                        if(!isNaN(x) && data.user_Answer[x] != ""){
                          isBlank = false
                        }
                      }

                      if(isBlank == false && typeof(data.user_Answer[0]['text_ans']) != undefined){
                        var splitAns = data.user_Answer[0]['text_ans'].split(";");
                        if(splitAns.length > 0){
                          isBlank = true
                          splitAns.forEach(element => {
                            if(element.trim()!=""){
                              isBlank = false
                            }
                          });
                        }
                      }
                      
                      if(temp1 == "[]" || temp == true){
                        $("#dependant_pr_{{$practise['id']}}").css("display", "block");
                          $("#true_false_{{$practise['id']}}").css("display", "none");
                        $("#audio_plyr_{{$practise['id']}}").css("display", "none");
                      }else{
                        // alert("test")
                          $("#dependant_pr_{{$practise['id']}}").css("display", "none");
                          $("#true_false_{{$practise['id']}}").css("display", "block");
                          $("#audio_plyr_{{$practise['id']}}").css("display", "block");
                      }
                      
                      if(jQuery.isEmptyObject(data.user_Answer[0]) || isBlank){
                        $("#dependant_pr_{{$practise['id']}}").css("display", "block");
                        $("#true_false_{{$practise['id']}}").css("display", "none");
                        $("#audio_plyr_{{$practise['id']}}").css("display", "none");
                      }else{
                        $("#dependant_pr_{{$practise['id']}}").css("display", "none");
                        $("#true_false_{{$practise['id']}}").css("display", "block");
                        $("#audio_plyr_{{$practise['id']}}").css("display", "block");
                      }
                    //   var result =  document.location +data.user_Answer;


                    //   // var res = result.split(";");
                    var i =0;
                    if( data.user_Answer)
                    {

                      $.each(data.user_Answer[0]['text_ans'], function( index, value ) {
                        if(value !==""){
                          value = value.replace(document.location, "");
                          // alert( value );

                          $("#span_true_false_readings_"+i).html("<br><b><font color = '#03A9F4'>"+value+"</font></b>");
                          $("#dependan_answer_"+i).val("<br><b><font color = '#03A9F4'>"+value+"</font></b>@@");

                        }
                        else{
                            $("#span_true_false_readings_"+i).html("<br><b><font color = '#03A9F4'></font></b>");
                            $("#dependan_answer_"+i).val("<br><b><font color = '#03A9F4'></font></b>@@");
                        }
                        i= i+1;
                      });
                    }
                  }
              });
        }



    });
</script>

<style type="text/css">
  	*[contenteditable]:empty:before
	{
	    content: "\feff"; /* ZERO WIDTH NO-BREAK SPACE */
	}

	.appendspan {
	 	color:red;
	}
</style>