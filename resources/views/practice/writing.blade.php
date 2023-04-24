<p><strong>{!! $practise['title']; !!}</strong></p>

<?php //$practise['answer_key']= ''; 
//echo '<pre>'; print_r($practise);   ?>
<?php
$previous_practice_id="";
if(!empty($practise['dependingpractiseid'])){
  $dependend_practise = explode('_', $practise['dependingpractiseid'] ) ;
  $previous_practice_id = $dependend_practise[1];
}
?>
@php
    $data[$practise['id']] = array();
	$data[$practise['id']]['isRolePlayPractice'] = (!empty($practise['is_roleplay']) &&  $practise['is_roleplay']==1)?1:0;
	$data[$practise['id']]['typeofdependingpractice'] = !empty($practise['typeofdependingpractice']) ? $practise['typeofdependingpractice'] : "";
	$data[$practise['id']]['setFullViewFromPreviousPractice'] = !empty($practise['depending_practise_details']['dependant_practise_id']) ? $practise['depending_practise_details']['dependant_practise_id']:"";
	$data[$practise['id']]['dependant_practise_topic_id'] = !empty($practise['depending_practise_details']['dependant_practise_topic_id']) ? $practise['depending_practise_details']['dependant_practise_topic_id']:"";
	$data[$practise['id']]['dependant_practise_task_id'] = !empty($practise['depending_practise_details']['dependant_practise_task_id']) ? $practise['depending_practise_details']['dependant_practise_task_id']:"";
	$data[$practise['id']]['dependant_practise_question_type'] = !empty($practise['depending_practise_details']['question_type']) ? $practise['depending_practise_details']['question_type']:"";
	$data[$practise['id']]['dependentpractice_ans'] = !empty($practise['dependingpractise_answer'])?1:0;
	$data[$practise['id']]['is_dependent'] = !empty($practise['is_dependent']) ? 1 : 0;
@endphp

@if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer']))
    @if($practise['typeofdependingpractice'] != 'get_answers_put_into_quetions_parentextra')
        <div class="showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}">
        </div>
    @endif
    <br>
@elseif(isset($practise['typeofdependingpractice']) && !empty($practise['typeofdependingpractice']))

     @if($practise['typeofdependingpractice'] == 'set_full_view_remove_zero' || $practise['typeofdependingpractice'] == 'set_full_view' || $practise['typeofdependingpractice'] =='set_full_view_remove_top_zero' )
    <div id="defined_dependant_task_{{$practise['id']}}" style=" border: 2px dashed gray; border-radius: 12px;">
        <p style="margin: 15px;">In order to do this task you need to have completed <strong>Task {{$dependend_practise[2]}} Practice <?php if($dependend_practise[3] == 1){echo "A";} if($dependend_practise[3] == 2){echo "B";}if($dependend_practise[3] == 3){echo "C";}if($dependend_practise[3] == 4){echo "D";}if($dependend_practise[3] == 5){echo "E";} if($dependend_practise[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
    </div>
    
    @endif
@endif

<form class="save_writing_at_end_up_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    <input type="hidden" class="practise_type" name="practise_type" value="{{$practise['type']}}">
    <?php
    //  echo "<pre>";
    //  print_r($practise);
    // echo "</pre>";
    $exploded_question =array();

      if($practise['type']=='Writing'){
        $exploded_question =array();
        $answerExists = false;
        if( isset($practise['user_answer']) && !empty($practise['user_answer'])){
          $answerExists = true;
        }
      } else {
        if(str_contains($practise['question'],'#%')){
            
            $tapScript=explode('#%',$practise['question']);
            $tapscriptTitle= $tapScript[0];
           
            $tapScript1  =  explode('/t',$tapScript[1]);
            $tapScriptDiscription = $tapScript1[0];
            $exploded_question  =  explode(PHP_EOL, $tapScript1[1]);        
      }else{
        $temp  =  !empty($practise['question'])?explode(PHP_EOL, $practise['question']):"";
        // dd($temp);
        foreach($temp as $value){
            if( $value!="\r"){
                array_push($exploded_question,$value);
            }
        }
      }
        $i=0;
        if( isset($practise['user_answer']) && !empty($practise['user_answer'])){
        $usrAns = count($practise['user_answer']) - 1;
        } else {
        $usrAns=0;
        }
      }
        $w=0;
    ?>
    @if(isset($practise['dependingpractiseid']) && !empty($practise['dependingpractiseid']))
        @php
            $depend =explode("_",$practise['dependingpractiseid']);
        @endphp
    @endif
    @if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid']) && $practise['typeofdependingpractice'] == 'get_questions_and_answers_double')
      @php 
        if(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer'])){
          
            if(isset($practise['is_roleplay']) && !empty($practise['is_roleplay'])){
            
                if(isset($practise['question']) && !empty($practise['question']) && str_contains($practise['question'],'##')){
                    $roleplay = explode('##',$practise['question']);                    
                    $roleplayTitle= explode('@@',$roleplay[0])
                    @endphp
                    <div class="tab-content" id="abc-tabContent">
                        <div class="tab-pane fade show active" id="abc-b" role="tabpanel" aria-labelledby="abc-b-tab">
                            <div class="component-two-click mb-4">
                                <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
                                    @foreach($roleplayTitle as $k=> $title)
                                        <a href="javascript:;" id="s-button-{{$k}}" class="btn btn-dark selected_option selected_option_{{$k}} s-button">{!!$title!!}</a>
                                    @endforeach                            
                                </div>
                                @php 
                                    array_shift($roleplay);
                                    $roleplayKey = 0;
                                @endphp 
                                @if(isset($practise['depending_practise_details']['question']) && !empty($practise['depending_practise_details']['question']))
                                    @php 
                                        $dependingQuestion = explode('@@',$practise['depending_practise_details']['question']); 
                                    @endphp
                                @endif
                                @if(isset($practise['depending_practise_details']['independant_practise']['practise_details']['question']) && $practise['depending_practise_details']['independant_practise']['practise_details']['question_type'] == 'single_speaking_up_writing')
                                                            @if(str_contains($practise['depending_practise_details']['independant_practise']['practise_details']['question'],'##'))
                                                            @php
                                                                $independantQuestion= explode('##',$practise['depending_practise_details']['independant_practise']['practise_details']['question']);
                                                                array_shift($independantQuestion);
                                                            @endphp
                                                            @endif
                                        @endif
                                <div class="two-click-content w-100">
                                    @foreach($roleplay as $key=> $roleplayQuestion)                                    
                                        <div class="content-box multiple-choice s-button-box selected_option_description selected_option_description_{{$key}} d-none" id="s-button-{{$key.''.$key}}">
                                            <div class="w-100">
                                            @if(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer']))
                                                @if(isset($practise['dependingpractise_answer'][$roleplayKey]['text_ans'][0]))
                                                    @if(isset($practise['depending_practise_details']['independant_practise']['user_answer'][$roleplayKey]['text_ans'][0]))
                                                        <strong>{!!$independantQuestion[$key]!!}</strong>
                                                        <br>
                                                        {!!nl2br($practise['depending_practise_details']['independant_practise']['user_answer'][$roleplayKey]['text_ans'][0])!!}
                                                    @endif
                                                    <br><br>
                                                <strong>{!!str_replace('##','',$dependingQuestion[$key])!!}</strong><br>
                                                    {!!nl2br($practise['dependingpractise_answer'][$roleplayKey]['text_ans'][0])!!} 
                                                    @php 
                                                        $displayDependBox= 'none';
                                                        $displayWriting='block';
                                                    @endphp
                                                @else
                                                    @php 
                                                        $displayDependBox= 'block';
                                                        $displayWriting='none';
                                                    @endphp                                          
                                                @endif
                                            @endif
                                            <p>
                                            <br>
                                            <div style="display:{{$displayWriting}}">
                                                <strong>{!! $roleplayQuestion !!}</strong></p>
                                                <p>
                                                    <div class="form-slider p-0 mb-4">
                                                        <div class="component-control-box">
                                                            <span class="textarea form-control form-control-textarea set_full_view_main stringProper text-left test_4" role="textbox" contenteditable="" placeholder="Write here..." >{!! isset($practise['user_answer'][$roleplayKey]) && $answerExists == true ? nl2br($practise['user_answer'][$roleplayKey]) : ''!!}</span>
                                                            <input type="hidden" name="writeingBox[]" value="">
                                                           
                                                        </div>
                                                    </div>
                                                </p>
                                            </div>
                                            <div id="defined_dependant_task_{{$practise['id']}}" style="display:{{$displayDependBox}}; border: 2px dashed gray; border-radius: 12px;">
                                                <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                                            </div>
                                            </div>
                                        </div>
                                    @php $roleplayKey= $roleplayKey + 2 ; @endphp
                                    @endforeach
                                    <input type="hidden" name="role_play" value='1'>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                }               
            @endphp
            <script>
                $( document ).ready(function() {
                    $('.list-buttons').css('display','block')
                });
            </script>
            @php
            }
        }else{
            $depend =explode("_",$practise['dependingpractiseid']);
            if(isset($practise['is_roleplay']) && !empty($practise['is_roleplay'])){
               
                if(isset($practise['question']) && !empty($practise['question']) && str_contains($practise['question'],'##')){
                    $roleplay = explode('##',$practise['question']);
                    
                    $roleplayTitle= explode('@@',$roleplay[0]);
                 
                @endphp
                <div class="tab-content" id="abc-tabContent">
				    <div class="tab-pane fade show active" id="abc-b" role="tabpanel" aria-labelledby="abc-b-tab">
                        <div class="component-two-click mb-4">
						    <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
                                @foreach($roleplayTitle as $k=> $title)
                                    <a href="#!" id="s-button-{{$k}}" class="btn btn-dark selected_option selected_option_{{$k}} s-button">{!!$title!!}</a>
                                    
                                @endforeach                            
                            </div>
                           
                            <div class="two-click-content w-100">
                                @foreach($roleplay as $key=> $roleplayQuestion)
                                
                                <div class="content-box multiple-choice s-button-box selected_option_description selected_option_description_{{$key}} d-none" id="s-button-{{$key.''.$key}}">

                                       
                                        <div class="w-100">
                                            <div id="defined_dependant_task_{{$practise['id']}}" style="display:block; border: 2px dashed gray; border-radius: 12px;">
                                                <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                                            </div>
                                        </div>
                                    </div>
                                
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @php
                }

            }
            
            @endphp
            
           
            <script>
            $( document ).ready(function() {
                $('.save_writing_at_end_up_form_{{$practise["id"]}} .list-buttons').css('display','none')
            });
            </script>
            @php
        }
        
      @endphp 
    @elseif(!empty($exploded_question))
        @if(isset($practise['is_dependent']) && !empty($practise['is_dependent']))
       
            @if(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer']))
                <script>
                    $( document ).ready(function() {
                        $('#writing_at_end_up_main_div_{{$practise["id"]}}').css('display','block');
                        $('.save_writing_at_end_up_form_{{$practise["id"]}} .list-buttons').css('display','block');
                        $('#defined_dependant_task_{{$practise["id"]}} .list-buttons').css('display','none');

                    });
                </script>
            @else
            
                <script>
                    $( document ).ready(function() {
                        $('#writing_at_end_up_main_div_{{$practise["id"]}}').css('display','none');
                        $('.save_writing_at_end_up_form_{{$practise["id"]}} .list-buttons').css('display','none');
                        $('#defined_dependant_task_{{$practise["id"]}}').css('display','block')

                    });
                </script>
            @endif
        @endif        
     
    <div id="writing_at_end_up_main_div_{{$practise['id']}}">
        @if(isset($tapscriptTitle) && !empty($tapscriptTitle))
            <div class="text-center mb-4">
                            <a id="" href="#!" class="btn btn-dark modalbtn" data-modalid='1' >
                                {{ $tapscriptTitle }}
                            </a>
            </div>
        @endif
       <?php
    //    dd($exploded_question);
       ?>
        @foreach($exploded_question as $key=>$item)
        <?php 
        if(isset($practise['typeofdependingpractice']) && $practise['typeofdependingpractice']=='get_answers_put_into_answers'){
            
            if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
                $user_answer = isset($practise['user_answer'])?$practise['user_answer'][0]:[];
                $new_user_ans = [];
                foreach($user_answer as $key=>$ans){
                    // if($ans!=""){
                        array_push($new_user_ans, $ans);
                    // }
                }
            }elseif(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer'])){
                $user_answer = isset($practise['dependingpractise_answer'])?$practise['dependingpractise_answer'][0]:[];
                $new_user_ans = [];
                foreach($user_answer as $key=>$ans){
                    // if($ans!=""){
                        array_push($new_user_ans, $ans);
                    // }
                }
            }
        }else{
            $user_answer = isset($practise['user_answer'])?$practise['user_answer'][0]:[];
            $new_user_ans = [];
            foreach($user_answer as $key=>$ans){
                // if($ans!=""){
                    array_push($new_user_ans, $ans);
                // }
            }
        }
        if(str_contains($item,'@@')) {
   
                    echo '<div class="writing_at_end_upform-group-label" >'.$outValue = preg_replace_callback('/@@/',
                                function ($m) use (&$key1, &$c_t, &$w, &$item, &$key, &$new_user_ans) {
                                    $data = "";
                                    if(!empty($new_user_ans)) {
                                        if(isset($new_user_ans[$w]) && $new_user_ans[$w]!="") {
                                            $data = $new_user_ans[$w];
                                        } else {
                                            $data = "";
                                        }
                                    }else{
                                        $data = "";
                                    }
                            $ans= "";
                            
                            // $str .= '<span class="label" style="margin:0;">';
                            $str = '</label><textarea type="text" class="form-control writing_at_end_up_form-control" name="writeingBox[]" id="writeingBox_'.$w.'" placeholder="Write here..."  value="'.$data.'" rows="1">'.$data.'</textarea>';
                            // $str .= '</span>';
                            $str .='</div><br>';

                    $w++;
                    return $str;
                }, '<label class="writing_at_end_up_label">'.$item);
            }else{
                if($item != ""){
                    $w++;
                    echo $outValue = '<div><input type="hidden" name="writeingBox[]">'.$item.'</div>';
                }
            }
        ?>

            <?php $i++;?>
        @endforeach
        </div>
    @elseif(isset($practise['is_roleplay']) && !empty($practise['is_roleplay']) && $practise['is_roleplay'] == 1)
        @php
        if(isset($practise['question']) && !empty($practise['question']) && str_contains($practise['question'],'##')){
            $roleplay = explode('##',$practise['question']);                    
            $roleplayTitle= explode('@@',$roleplay[0]);
            @endphp
            <div class="tab-content" id="abc-tabContent">
                <div class="tab-pane fade show active" id="abc-b" role="tabpanel" aria-labelledby="abc-b-tab">
                    <div class="component-two-click mb-4">
                        <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
                            @foreach($roleplayTitle as $k=> $title)
                                <a href="#!" id="s-button-{{$k}}" class="btn btn-dark selected_option selected_option_{{$k}} s-button">{!!$title!!}</a>
                                
                            @endforeach                            
                        </div>
                        @php 
                            array_shift($roleplay);
                            $roleplayKey = 0;
                        @endphp                        
                        
                        <div class="two-click-content w-100">
                            @foreach($roleplay as $key=> $roleplayQuestion)
                                <div class="content-box multiple-choice s-button-box selected_option_description selected_option_description_{{$key}} d-none" id="s-button-{{$key.''.$key}}">
                                
                                    <div class="w-100">                                    
                                   
                                    <br>                                  
                                        <p class="">
                                        @if($practise['id'] !== "162972322461239a58da5c3")
                                        {!! str_replace('@@',' ',$roleplayQuestion) !!}
                                        @else
                                        {!! nl2br(e(str_replace(['@@','<b>','</b>','<br>'],'',$roleplayQuestion))) !!}
                                        @endif
                                        </p>
                                        
                                        <p>
                                            <div class="form-slider p-0 mb-4">
                                                <div class="component-control-box">
                                                    <span class="textarea form-control form-control-textarea set_full_view_main stringProper text-left stringProperNew test_1" role="textbox" contenteditable="" placeholder="Write here..." >{!! isset($practise['user_answer'][$roleplayKey]) && $answerExists == true ? $practise['user_answer'][$roleplayKey] : ''!!}</span>
                                                    <input type="hidden" name="writeingBox[]" value="">
                                                    
                                                </div>
                                            </div>
                                        </p>
                                    
                                    
                                    </div>
                                </div>
                            @php $roleplayKey= $roleplayKey + 2 ; @endphp
                            @endforeach
                            <input type="hidden" name="role_play" value='1'>
                        </div>
                    </div>
                </div>
            </div>
            @php
            
        }
        @endphp   
    @else
        @if(isset($practise['typeofdependingpractice']))
        
            @if(($practise['typeofdependingpractice'] === 'set_full_view_remove_zero'|| $practise['typeofdependingpractice'] ==="set_full_view" ) && $practise['type'] == 'Writing' )
                
                @if(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer']))
                
                @if(isset($practise['question']) && !empty($practise['question']))
                @if(str_contains($practise['question'],'#%'))
                    @php 
                        $tapScript=explode('#%',$practise['question']);
                        $tapscriptTitle= $tapScript[0];
                        $tapScriptDiscription=$tapScript[1];
                    @endphp
                        <div class="text-center mb-4">
                                <a id="" href="#!" class="btn btn-dark modalbtn" data-modalid='1' >
                                    {!! $tapscriptTitle !!}
                                </a>
                            </div> 
                   
                @else
                    {!!str_replace('@@','',$practise['question'])!!}<br>
                @endif
                    
                    
                @endif

                <p style="display: none;" id="set_full_view">
                    <div class="form-slider p-0 mb-4">
                        <div class="component-control-box">
                            <span class="textarea form-control form-control-textarea set_full_view_main stringProper text-left stringProperNew test_1" role="textbox" contenteditable="" placeholder="Write here..." >{!! isset($practise['user_answer']) && $answerExists == true ? nl2br($practise['user_answer']) : ''!!}</span>
                            <input type="hidden" name="writeingBox_dependancy" value="{{ isset($practise['user_answer']) && $answerExists == true ? $practise['user_answer'] : ''  }}">
                        </div>
                    </div>
                </p>
                @endif
            @elseif($practise['typeofdependingpractice'] === 'get_answers_put_into_quetions' && $practise['depending_practise_details']['question_type'] != 'Writing')
                @if(isset($practise['dependingpractise_answer'][0]) && !empty($practise['dependingpractise_answer'][0]))
                    @foreach($practise['dependingpractise_answer'][0] as $dependingAnswer)
                        @if(isset($dependingAnswer['checked']) && !empty($dependingAnswer['checked']))
                        <br>
                            {!!$dependingAnswer['name']!!}
                            <br><br>
                        @endif
                    @endforeach

                    @if(isset($practise['question']) && !empty($practise['question']))
                    {!!$practise['question']!!}
                    @endif
                        <p>                    
                            <div class="form-slider p-0 mb-4">
                                <div class="component-control-box">
                                    <span class="textarea form-control form-control-textarea stringProper text-left" role="textbox" contenteditable="" placeholder="Write here..." >{!! isset($practise['user_answer']) && $answerExists == true ? $practise['user_answer'] : ''!!}</span>
                                    <input type="hidden" name="writeingBox" value="{{ isset($practise['user_answer']) && $answerExists == true ? $practise['user_answer'] : ''  }}">
                                </div>
                            </div>
                        </p>
                @else
                <div id="defined_dependant_task_{{$practise['id']}}" style=" border: 2px dashed gray; border-radius: 12px;">
                                                <p style="margin: 15px;">In order to do this task you need to have completed <strong>Task {{$depend[2]}} Practice <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                </div>

                @endif

            @else
            <p>                    
                            <div class="form-slider p-0 mb-4">
                                <div class="component-control-box">
                                    <span class="textarea form-control form-control-textarea set_full_view_main stringProper text-left stringProperNew test_1" role="textbox" contenteditable="" placeholder="Write here..." >{!! isset($practise['user_answer']) && $answerExists == true ? nl2br($practise['user_answer']) : ''!!}</span>
                                    <input type="hidden" name="writeingBox" value="{{ isset($practise['user_answer']) && $answerExists == true ? $practise['user_answer'] : ''  }}">
                                </div>
                            </div>
                        </p>
            @endif
        @else
       
            <p>
            @if(str_contains($practise['question'],'#%'))
                    @php 
                        $tapScript=explode('#%',$practise['question']);
                        $tapscriptTitle= $tapScript[0];
                        $tapScriptDiscription=$tapScript[1];
                    @endphp
                        <div class="text-center mb-4">
                                <a id="" href="#!" class="btn btn-dark modalbtn" data-modalid='1' >
                                    {!! $tapscriptTitle !!}
                                </a>
                            </div> 
                   
                @else
                    {!!str_replace('@@','',$practise['question'])!!}<br>
                @endif
                <div class="form-slider p-0 mb-4">
                    <div class="component-control-box">
                        <span class="textarea form-control form-control-textarea set_full_view_main stringProper text-left stringProperNew test_1" role="textbox" contenteditable="" placeholder="Write here..." >{!! isset($practise['user_answer']) && $answerExists == true ? nl2br($practise['user_answer']) : ''!!}</span>
                        <input type="hidden" name="writeingBox" value="{{ isset($practise['user_answer']) && $answerExists == true ? $practise['user_answer'] : ''  }}">
                    </div>
                </div>
            </p>
        @endif
    @endif
    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
    <br>
    <ul class="list-inline list-buttons">
        <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn writeAtendUpBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"
                data-toggle="modal" data-is_save="0" data-target="#exitmodal"  >Save</button>
        </li>
        <li class="list-inline-item"><button type="button"
                class="submit_btn btn btn-primary submitBtn writeAtendUpBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1" >Submit</button>
        </li>
    </ul>
</form>
<div class="modal fade add-summary-modal" id="tapscriptmodal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 15000;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-file-alt"></i> Tape Script</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body vocabulary-body">
            @if(isset($tapScriptDiscription) && !empty($tapScriptDiscription))
                {!! $tapScriptDiscription !!}
            @endif
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@if(isset($practise["markingmethod"]) && $practise["markingmethod"] == "student_self_marking")
<!-- if($practise["markingmethod"] == "student_self_marking") -->
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
<p>
    <?php  if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])) {
        $depend =explode("_",$practise['dependingpractiseid']); ?>

            <input type="hidden" class="message_dependannt_task_id" name="depend_task_id" value="{{$depend[0]}}">
            <input type="hidden" class="message_dependannt_practice_id" name="depend_practise_id" value="{{$depend[1]}}">

            <div id="defined_dependant_task_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
                <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
            </div>
    <?php } ?>
</p>
 <?php  if(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer']) && isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])&& $practise['typeofdependingpractice'] != 'get_questions_and_answers_double'  && $practise['typeofdependingpractice'] !='set_full_view'){?>
    <script type="text/javascript">
        
        setTimeout(function(){
            // $('#cover-spin').fadeIn();
            var dependancType= '{{isset($practise["typeofdependingpractice"] ) && $practise["typeofdependingpractice"] == "get_answers_put_into_quetions_parentextra" ? "get_answers_put_into_quetions_parentextra" :"" }}';
            if(dependancType!="get_answers_put_into_quetions_parentextra"){
                getWritingDependancy();
            }
        },1000);
        function getWritingDependancy() {
            var topic_id    = $(".topic_id").val();
            var task_id     = $("input.message_dependannt_task_id").val();
            var practise_id = $("input.message_dependannt_practice_id").val();
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
                    // console.log(data);
                    // $('#cover-spin').fadeOut();
                    if(typeof(data.success) != "undefined") {
                        $("#defined_dependant_task_{{$practise['id']}}").fadeIn();
                        $("#set_full_view").fadeIn();
                        $(".save_writing_at_end_up_form_{{$practise['id']}}").fadeOut();
                    }else{
                        // $(".set_full_view_main").html(data.user_Answer[0]);
                        // console.log(data.user_Answer[0])
                    }
                }
            });
        }
    </script>
 <?php } ?>
 <script>

    var sorting             = "{{ isset($topic_tasks_new)?$topic_tasks_new:$topic_tasks[0]['sorting'] }}";
    var courseType          = "<?php echo $CourseDetails; ?>";
    var courseType          = courseType.split("-");
    var courseType          = courseType[0];
    var feedbackPopup       = true;

    if(courseType == "AES" && sorting == 30){
        var facilityFeedback    = false;
        var courseFeedback      = true;
    }else{
        var facilityFeedback    = false;
        var courseFeedback      = true;
    }

	if(data29==undefined ){
		var data29=[];
	}
 	var token = $('meta[name=csrf-token]').attr('content');
	var upload_url = "{{url('upload-audio')}}";
	var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
	data29["{{$practise['id']}}"]= {"dependentpractice_ans": "{{$data[$practise['id']]['dependentpractice_ans']}}" };
	data29["{{$practise['id']}}"]["isRolePlayPractice"] = "{{$data[$practise['id']]['isRolePlayPractice']}}"
	data29["{{$practise['id']}}"]["is_dependent"] = "{{$data[$practise['id']]['is_dependent']}}"; 
	if(data29["{{$practise['id']}}"]["is_dependent"]==1){
		
		if(data29["{{$practise['id']}}"]["dependentpractice_ans"]==0 ){
			$(".previous_practice_answer_exists_{{$practise['id']}}").hide();
			$("#dependant_pr_{{$practise['id']}}").show();
		} else {
			$(".previous_practice_answer_exists_{{$practise['id']}}").show();
			$("#dependant_pr_{{$practise['id']}}").hide();
		}
	}
</script>
<!--Add static condition for level 0 -->
@php $button_status = false; @endphp
@if(isset($_GET['n']))
 @if($_GET['n'] == "1665737328634922706efbf" || $_GET['n'] == "16667126206358042cea4d0")
  @php
   $button_status = true;
  @endphp
 @endif
@endif
<!-- -->
@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==0 && $practise['typeofdependingpractice']!='get_answers_generate_quetions' )
<script>

	data29["{{$practise['id']}}"]["typeofdependingpractice"] = "{{ $data[$practise['id']]['typeofdependingpractice'] }}";
	data29["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
	if(data29["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data29["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data29["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data29["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data29["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data29["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data29["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view" || data29["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_top_zero"){
        
		data29["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
		data29["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
        $(function () {
            // $('.cover-spin').fadeIn();
        });
		if(data29["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
             // alert("1")
             var pid = "{{$practise['id']}}";
			// IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
			if(data29["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
                setTimeout(function(){ 
                    data29["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data29["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();				 
				    $(document).find(".showPreviousPractice_"+data29["{{$practise['id']}}"]["dependant_practise_id"]).html(data29["{{$practise['id']}}"]["prevHTML"]);
					$(document).find(".showPreviousPractice_"+data29["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
					$(document).find(".showPreviousPractice_"+data29["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
					$(document).find(".showPreviousPractice_"+data29["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert').remove();
                    let b_status = "{{$button_status}}";
                    if(b_status == true)
                    {
                        if('.blankTableBtn_dependacy_"+data29["{{$practise['id']}}"]["dependant_practise_id"]')
                        {
                             $(".save_btn.blankTableBtn_dependacy_"+data29["{{$practise['id']}}"]["dependant_practise_id"]).hide();
                             $(".submit_btn.blankTableBtn_dependacy_"+data29["{{$practise['id']}}"]["dependant_practise_id"]).hide();
                        }
                    }
					if(data29["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero")
                    {
						if(data29["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
							$(document).find(".showPreviousPractice_"+data29["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
                        }
                        if(data29["{{$practise['id']}}"]["dependant_practise_question_type"] == "set_in_order_vertical_listening") {
							$(document).find(".showPreviousPractice_"+data29["{{$practise['id']}}"]["dependant_practise_id"]).find('.audio-player').remove();
						}

                        if(pid == "15508570365c70334c45874" || pid=="15554876095cb6db79084cf"){
                            if(data29["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" ){
                                $(document).find(".showPreviousPractice_"+data29["{{$practise['id']}}"]["dependant_practise_id"]).find('.audio-player').remove();
                            }   
                        }
					}
                    // $('.cover-spin').fadeOut();
				}, 5000,data29 )
			}
		} else {
            // alert("2")
			// IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
			// DO NOT REMOVE BELOW   CODE
			var baseUrl = "{{url('/')}}";
			data29["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
			data29["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data29["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data29["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data29["{{$practise['id']}}"]["dependant_practise_id"];
			$.get(data29["{{$practise['id']}}"]["dependentURL"],  //
			function (dataHTML, textStatus, jqXHR) {  // success callback
				data29["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data29["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
				$(document).find(".showPreviousPractice_"+data29["{{$practise['id']}}"]["dependant_practise_id"]).html(data29["{{$practise['id']}}"]["prevHTML"]);
				$(document).find(".showPreviousPractice_"+data29["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
				$(document).find(".showPreviousPractice_"+data29["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, .alert').remove();
				
				if(data29["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
					 
					if(data29["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
						$(document).find(".showPreviousPractice_"+data29["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
					}
				}
             
			});
		}
	} else {
	 
		setTimeout(function(){
			// $('#cover-spin').fadeIn();
            getSpeakingMultipleDependency();
            // $('.cover-spin').fadeOut();
		},5000);
		
		function getSpeakingMultipleDependency(){

			var topic_id= $(".form_{{$practise['id']}}").find('.topic_id').val();
			var task_id=$(".form_{{$practise['id']}}").find('.depend_task_id').val();
			var practise_id=$(".form_{{$practise['id']}}").find('.depend_practise_id').val();
			var dependent_ans = '<?php echo !empty($user_ans)?json_encode($user_ans):"" ?>';
			console.log('d====>',dependent_ans)
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
					// var question = data.question;
					// var answer = data.user_Answer[0];
					// var question_array = question.split(':');

					// var str ="";

					// if(answer){

					// 	var j = 0;
					// 	answer.forEach((item, i) => {
					// 		//console.log(i, '===>',item)
					// 		if($.trim(item)!=""){

					// 		var dependent_question=`<div class="choice-box"><p class="mb-0 main-question another-main-question">`+item+`</p><div class="form-group"><span class="textarea form-control form-control-textarea main-answer enter_disable another-main-answer" role="textbox" contenteditable placeholder="Write here..."></span><div style="display:none"><textarea name="user_answer[0][`+i+`]" class="main-answer-input"></textarea></div></div></div>`;
					// 		$(".form_{{$practise['id']}}").find('.multiple-choice').append(dependent_question);

					// 		//$(".form_{{$practise['id']}}").find(".main-question:eq("+j+")").html(item)
					// 		if(dependent_ans!="" ){
					// 			var parsed_dependent_ans = JSON.parse(dependent_ans);
					// 			console.log('pd=====>',parsed_dependent_ans[i]);
					// 			$(".form_{{$practise['id']}}").find(".main-answer-input:eq("+j+")").val(parsed_dependent_ans[j]);
					// 			$(".form_{{$practise['id']}}").find(".main-answer:eq("+j+")").html(parsed_dependent_ans[j]);
					// 		}
					// 		j++;
					// 		}
					// 	});
					// }

				} else {
					$('.previous_practice_answer_exists_{{$practise["id"]}}').hide();
					$('#dependant_pr_{{$practise["id"]}}').show();
				}
				}
			});
		}
	}
</script>
@endif
<script type="text/javascript">
$(function () {
    // $('.cover-spin').fadeIn();
	// two click js
	$(".save_writing_at_end_up_form_<?php echo $practise['id'];?> .s-button").on("click",function(){
		if($(".save_writing_at_end_up_form_<?php echo $practise['id'];?> .s-button.d-none").length > 0){
			$(".save_writing_at_end_up_form_<?php echo $practise['id'];?> .s-button.d-none");
			$(".save_writing_at_end_up_form_<?php echo $practise['id'];?> .s-button-box").addClass("d-none");
			$(".save_writing_at_end_up_form_<?php echo $practise['id'];?> .s-button").removeClass("d-none").removeClass("btn-bg");
       
			return false;
		}
		$(".save_writing_at_end_up_form_<?php echo $practise['id'];?> .s-button-box,.s-button").addClass("d-none");
		$(this).removeClass("d-none").addClass("btn-bg");
		var curId = $(this).attr("id");
		curId = curId.replace("s-button-","");
		$(".save_writing_at_end_up_form_<?php echo $practise['id'];?> #s-button-"+curId+curId).removeClass("d-none");
	})
	/*$("#p-button").click(function () {
		$("#police, #s-button").toggleClass("d-none");
		$(this).toggleClass('btn-bg');
	});

	$("#s-button").click(function () {
		$("#suspect, #p-button").toggleClass("d-none");
		$(this).toggleClass('btn-bg');
	});*/
});
$(document).ready(function() {
    $('.modalbtn').on('click', function(e){
            e.preventDefault();
            var modalid = $(this).data('modalid');
            $('#tapscriptmodal_'+modalid).modal('show');
            return false;
        });

  function setTextareaContents(){
        $("span.textarea.form-control").each(function(){
            var currentVal = $(this).html();
            var regex = /<br\s*[\/]?>/gi;
            currentVal=currentVal.replace(regex, "\n");
            var regex = /<div\s*[\/]?>/gi;
            currentVal=currentVal.replace(regex, "\n");
            var regex = /<\/div\s*[\/]?>/gi;
            currentVal=currentVal.replace(regex, "");
            var regex = /&nbsp;/gi;
            currentVal=currentVal.replace(regex, "");

            
            $(this).next("input").val(currentVal);
        })
    }
  
  $(document).on('click',".writeAtendUpBtn_{{$practise['id']}}" ,function() {

    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }
    
    var reviewPopup = '{!!$reviewPopup!!}';
    var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                
                if($(this).attr('data-is_save') == '1'){
                    $('#practise_div').html("");
                    
                    var fullView1= $(".showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}").clone(true);
                    var fullView= $(".save_writing_at_end_up_form_{{$practise['id']}}").clone(true);
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView1);

					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find(".textarea").attr("contenteditable",false);

                }
            }
            
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){
                
                $("#reviewModal_{{$practise['id']}}").modal('toggle');

            }
    //console.log("{{$practise['id']}}");
    $(".writeAtendUpBtn_{{$practise['id']}}").attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);
    // $('.save_writing_at_end_up_form_{{$practise["id"]}}').find("span.textarea.form-control").each(function(){
    //   var currentVal = $(this).html();
    //   $(this).next().find("textarea").val(currentVal);
    // });
    setTextareaContents();
    $.ajax({
        url: "{{url('save-write-atend-up')}}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $(".save_writing_at_end_up_form_{{$practise['id']}}").serialize(),
        success: function (data) {
          $(".writeAtendUpBtn_{{$practise['id']}}").removeAttr('disabled');
          if(is_save==1){
            // =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
            // setTimeout(function(){
            //     $('.alert-success').hide();
            //   var isNextTaskDependent =  $('.nav-link.active').parent().next().find('a').attr('data-dependent');
              
            // //   var nextdependent = $('.nav-link.active').parent().next().find('a').attr('data-nextdependent');
            // //   var isLastPractise = $('.nav-link.active').parent().next().find('a').attr('data-islastpractise');
            // //   var nextid = $('.nav-link.active').parent().next().find('a').attr('data-nextid');
            // //   if(isLastPractise == 1 && nextdependent == 1){
            // //     var topic_id = "{{request()->segment(2)}}";
            // //     var task_id = "{{request()->segment(3)}}";
            // //       //window.location.href=baseUrl+'/topic/'+topic_id+'/'+task_id+';
            // //   }
            //   if( isNextTaskDependent == 1 ){
            //     var dependentPractiseId =  $('.nav-link.active').parent().next().find('a').attr('data-id');
            //     var baseUrl = "{{url('/')}}";
            //     var topic_id = "{{request()->segment(2)}}";
            //     var task_id = "{{request()->segment(3)}}";
            //      // //window.location.href=baseUrl+'/topic/'+topic_id+'/'+task_id+'?n='+dependentPractiseId

            //   } else {
            //     ////$('.nav-link.active').parent().next().find('a').trigger('click');
            //   }
             
            // },1000);
            // =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
          }

          $('.alert-success').show().html(data.message).fadeOut(8000);

        }
    });
  });
});
</script>
@if($practise['type'] == "writing_at_end_up")
    <script src="{{ asset('public/js/autosize.js') }}"></script>
    <script>
        autosize(document.querySelectorAll('textarea'));
    </script>
@endif
