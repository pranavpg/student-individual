<form class="save_true_false_listening_symbol_form_{{$practise['id']}}">
                    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
                    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
                    <input type="hidden" class="is_save" name="is_save" value="">
                    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
                    <?php
                        $displayData = true;
                        if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
                            $depend =explode("_",$practise['dependingpractiseid']); 
                            if(empty($practise['dependingpractise_answer'])){ 
                                $displayData = false;
                                ?>

                                <input type="hidden" class="true_false_listening_symbol_task_id" name="true_false_listening_symbol_task_id" value="{{$depend[0]}}">
                                <input type="hidden" class="true_false_listening_symbol_practise_id" name="true_false_listening_symbol_practise_id" value="{{$depend[1]}}">
                                <div id="dependant_pr_{{$practise['id']}}" style="border: 2px dashed gray; border-radius: 12px;">
                                    <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                                </div>
                                <script type="text/javascript">
                                    setTimeout(function(){
                                        $('.removeButton').fadeOut();
                                    },1000)
                                </script>
                            <?php } ?>
                            <input type="hidden" class="true_false_listening_symbol_task_id" name="true_false_listening_symbol_task_id" value="{{$depend[0]}}">
                                <input type="hidden" class="true_false_listening_symbol_practise_id" name="true_false_listening_symbol_practise_id" value="{{$depend[1]}}">
                    <?php }

                    $exploded_question=array();
                    if(!empty($practise['question'])){
                        if(strpos($practise['question'],"\r\n")){
                            $practise['question']=  str_replace("@@","***",$practise['question']);
                            $exploded_question  =  explode("\r\n", $practise['question']);

                        }else{
                            $practise['question']=  str_replace("@@","***@@",$practise['question']);
                            $exploded_question  =  explode("@@",$practise['question']);
                        }
                    }
                    $i=0;
                    ?>
                    @if($displayData)
                    <div class="true-false" id="true_false_{{$practise['id']}}">

                        <?php 
                            // dd($practise);
                        if($practise['typeofdependingpractice'] == "get_answers_put_into_questions_self_marking" && ($practise['depending_practise_details']['question_type'] == "reading_no_blanks" || $practise['depending_practise_details']['question_type'] == "reading_total_blanks")|| $practise['depending_practise_details']['question_type'] == "writing_at_end"|| $practise['depending_practise_details']['question_type'] == "reading_no_blanks_listening"|| $practise['depending_practise_details']['question_type'] == "underline_text" || $practise['depending_practise_details']['question_type'] == "multi_choice_question_multiple" || $practise['depending_practise_details']['question_type'] == "match_answer"|| $practise['depending_practise_details']['question_type'] == "writing_at_end_up_listening"|| $practise['depending_practise_details']['question_type'] == "writing_at_end_up"|| $practise['depending_practise_details']['question_type'] == "writing_at_end_up_speaking_up"|| $practise['depending_practise_details']['question_type'] == "underline_text_listening" || $practise['depending_practise_details']['question_type'] == "reading_total_blanks_edit" || $practise['depending_practise_details']['question_type'] == "reading_blanks") {

                               if(!empty($practise['dependingpractise_answer'])){
                                    ?>
                                        @if(!empty($practise['audio_file']))
                                            @include('practice.common.audio_player')
                                        @endif
                                    <?php
                                    
                                    if($practise['depending_practise_details']['question_type'] == "reading_total_blanks") {

                                        if (strpos($practise['question'], '^$^') !== false) {
                                            $practise['question']   = str_replace("^$^", "", $practise['question']);
                                            $questions              = explode("***@@", $practise['question']);

                                            $tempAns = [];
                                            foreach($questions as $key => $value) {
                                                if($value!="\r"){ 
                                                    array_push($tempAns, $value);
                                                }else{
                                                }
                                            }
                                            $questions = $tempAns;

                                            
                                            $dependancy_ans     = !empty($practise['dependingpractise_answer'])?explode(";", $practise['dependingpractise_answer'][0]):[];
                                            $tempAns = [];
                                            foreach ($dependancy_ans as $key => $value) {
                                                if($value == " " || $value == "") { 
                                                    // array_push($tempAns,"");
                                                } else {
                                                    array_push($tempAns,$value);
                                                }
                                            }   

                                            $dependancy_ans = $tempAns;
                                            foreach($tempAns as $newKey =>$answers) {
                                                ?>
                                                <div class="box box-flex d-flex align-items-center">
                                                    <div class="box__left box__left_radio">
                                                        <p>
                                                        <?php
                                                        $color = "'#03A9F4'";
                                                        if(count($questions)-2 == $newKey){
                                                            echo $str ='<span id="span_true_false_" >'.$questions[$newKey].' <b><span style="color:#03A9F4;">'.$answers.'</span></b>'.$questions[count($questions)-1].'</span><input type="hidden" name="user_question[]" value="'.$questions[$newKey].' <b><font color = '.$color.'>'.$answers.'</font></b>'.$questions[count($questions)-1].'</span>">';
                                                        }else{
                                                            echo $str ='<span id="span_true_false_" >'.$questions[$newKey].' <b><span style="color:#03A9F4;">'.$answers.'</span><input type="hidden" name="user_question[]" value="'.$questions[$newKey].' <b><font color = '.$color.'>'.$answers.'</font></b>" >';
                                                        }
                                                        ?>
                                                            
                                                        </p>
                                                    </div>

                                                    <?php 

                                                        $checked_true = "";
                                                        $checked_false = "";
                                                        if(!empty($practise['user_answer'])) {
                                                            if(isset($practise['user_answer'][0][$newKey])){

                                                                if($practise['user_answer'][0][$newKey]['true_false'] == "1"){
                                                                    $checked_true = "checked";
                                                                }elseif($practise['user_answer'][0][$newKey]['true_false'] == "0"){
                                                                    $checked_false = "checked";
                                                                }
                                                            }
                                                        }

                                    

                                                            ?>
                                                            <div class="true-false_buttons true-false_buttons_radio">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="true_false[{{$newKey}}]" id="inlineRadioTrue{{$newKey}}" value="1" {{$checked_true}}>
                                                                    <label class="form-check-label form-check-label_true" for="inlineRadioTrue{{$newKey}}"></label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="true_false[{{$newKey}}]" id="inlineRadioFalse{{$newKey}}" value="0" {{$checked_false}}>
                                                                    <label class="form-check-label form-check-label_false" for="inlineRadioFalse{{$newKey}}"></label>
                                                                </div>
                                                            </div>

                                                 
                                                </div>
                                                <?php
                                            }
                                        }else{
                                            
                                            $questions  =  explode(PHP_EOL, $practise['depending_practise_details']['question']);
                                            $questions = array_filter($questions);
                                            $questions = array_merge($questions);

                                            $tempAns = [];
                                            foreach($questions as $key => $value) {
                                                if($value!="\r"){ 
                                                    array_push($tempAns, $value);
                                                }else{
                                                }
                                            }
                                            $questions = $tempAns;

                                            $dependancy_ans     = !empty($practise['dependingpractise_answer'])?explode(";", $practise['dependingpractise_answer'][0]):[];
                                            $dependancy_ans     = array_filter($dependancy_ans);
                                            $dependancy_ans     = array_merge($dependancy_ans);
                                            // dd($questions);
                                            $c =0; 
                                            $ss =0; 
                                            $true_false_count = 0;
                                            foreach($questions as $newKey =>$value) { 
                                                $is_true_false = true;?>
                                                <div class="box box-flex d-flex align-items-center">
                                                    <div class="box__left box__left_radio">
                                                        <p>
                                                            <?php
                                                                if(str_contains($value,'@@')) {
                                                                    echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key, &$c, &$userAnswer, &$newKey, &$flag, &$s, &$dependancy_ans, &$value) {
                                                                        $s++;
                                                                        $ans= !empty($dependancy_ans[$c])?trim($dependancy_ans[$c]):"";

                                                                        $new = $flag?$s.".":"";
                                                                        $oldQue = str_replace("@@",$ans , $value);
                                                                        // $str =$ans;


                                                                        $newAns = $ans==""?"____":$ans;
                                                                        $str ="<b><span style='color:#03A9F4;'>".$newAns."</span></b>";


                                                                        $c++;
                                                                        return $str;
                                                                    }, $value);

                                                                    $hiddenans = preg_replace_callback('/@@/', function ($m) use (&$key, &$ss, &$userAnswer, &$newKey, &$flag, &$s, &$dependancy_ans, &$value) {
                                                                        // $s++;
                                                                        $ans= !empty($dependancy_ans[$ss])?trim($dependancy_ans[$ss]):"";

                                                                        $new = $flag?$s.".":"";
                                                                        $oldQue = str_replace("@@",$ans , $value);


                                                                        // $oldQue = str_replace("@@",$ans , $value);
                                                                        $newAns = $ans==""?"____":$ans;
                                                                        $str ="<b><font color = '#03A9F4'>".$newAns."</font></b>";


                                                                        // $str =$ans;
                                                                        $ss++;
                                                                        return $str;
                                                                    }, $value);
                                                                     echo '<input type="hidden" class="form-control form-control-inline appendspan" name="user_question[]" value="'.$hiddenans.'"></span>';
                                                                }
                                                                else
                                                                { 
                                                                      echo $value;
                                                                      $is_true_false = false;
                                                                      //add else for begginer
                                                                }

                                                                // $ans= !empty($dependancy_ans[$newKey])?trim($dependancy_ans[$newKey]):"";
                                                                // $oldQue = str_replace("@@",$ans , $value);
                                                                // $str = $ans;
                                                               
                                                            ?>
                                                        </p>
                                                    </div>
                                                    <?php 
                                                    if($is_true_false == true)
                                                    {
                                                        $checked_true = "";
                                                        $checked_false = "";
                                                        if(!empty($practise['user_answer'])) {
                                                            if(isset($practise['user_answer'][0][$true_false_count])) {

                                                                if($practise['user_answer'][0][$true_false_count]['true_false'] == "1"){
                                                                    $checked_true = "checked";
                                                                }elseif($practise['user_answer'][0][$true_false_count]['true_false'] == "0"){
                                                                    $checked_false = "checked";
                                                                }

                                                            }
                                                        }
                                                    }
                                                    ?>
                                                  <?php 
                                                  if($is_true_false == true)
                                                  {
                                                  ?>
                                                    <div class="true-false_buttons true-false_buttons_radio">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="true_false[{{$true_false_count}}]" id="inlineRadioTrue{{  $true_false_count}}" value="1" {{$checked_true}}>
                                                            <label class="form-check-label form-check-label_true" for="inlineRadioTrue{{$true_false_count}}"></label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="true_false[{{$true_false_count}}]" id="inlineRadioFalse{{$true_false_count}}" value="0" {{$checked_false}}>
                                                            <label class="form-check-label form-check-label_false" for="inlineRadioFalse{{$true_false_count}}"></label>
                                                        </div>
                                                    </div>
                                                  <?php 
                                                   $true_false_count++;
                                                   }
                                                  ?>
                                                </div>
                                                <?php
                                            }

                                        }
                                    }elseif($practise['depending_practise_details']['question_type'] == "underline_text_listening" ){

                                        $questions          = explode(PHP_EOL, $practise['depending_practise_details']['question']);
                                        $tempAns = [];
                                        foreach($questions as $key => $value) {
                                            if($value!="\r"){
                                                array_push($tempAns, $value);
                                            }
                                        }

                                        $questions = $tempAns;
                                        $dependancy_ans     =  explode(';',$practise['dependingpractise_answer'][0][0]);

                                        $tempQue = [];
                                        foreach ($dependancy_ans as $key => $value) {
                                           $newData = json_decode($value);
                                            foreach ($newData as $key => $innerValueWord) {
                                                array_push($tempQue,$innerValueWord->word);
                                            }
                                        }

                                        $s=0;
                                        foreach($questions as $newKey =>$question) {
                                            ?>
                                            <div class="box box-flex d-flex align-items-center">
                                                <div class="box__left box__left_radio">
                                                    <p>
                                                        <?php  echo $str ='<span id="span_true_false_" class="underline underline_'.$newKey.'">'.$question.'</span><input type="hidden" class="hidden_'.$newKey.'" name="user_question[]" value="'.$question.'">'; ?>
                                                    </p>
                                                </div>

                                                <?php 
                                                    $checked_true = "";
                                                    $checked_false = "";
                                                    if(!empty($practise['user_answer'])){
                                                        if(isset($practise['user_answer'][0][$s])){

                                                            if($practise['user_answer'][0][$s]['true_false'] == "1"){
                                                                $checked_true = "checked";
                                                            }elseif($practise['user_answer'][0][$s]['true_false'] == "0"){
                                                                $checked_false = "checked";
                                                            }
                                                        }
                                                    }
                                                ?>
                                                <div class="true-false_buttons true-false_buttons_radio">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="true_false[{{$s}}]" id="inlineRadioTrue{{$s}}" value="1" {{$checked_true}}>
                                                        <label class="form-check-label form-check-label_true" for="inlineRadioTrue{{$s}}"></label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="true_false[{{$s}}]" id="inlineRadioFalse{{$s}}" value="0" {{$checked_false}}>
                                                        <label class="form-check-label form-check-label_false" for="inlineRadioFalse{{$s}}"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $s++;
                                        }
                                        ?>
                                            <script type="text/javascript">
                                                setTimeout(function(){
                                                        $(document).ready(function(){
                                                            var current_key = 0;
                                                            var wordNumber;
                                                            var k=0;
                                                            var end=0;
                                                            var pid = "<?php echo $practise['id'] ?>"

                                                            $('.underline').each(function(key) {
                                                                var paragraph="";
                                                                var str = $(this).text();
                                                                var $this =$(this);
                                                                str.replace(/[ ]{2,}/gi," ");
                                                                $this.attr('data-total_characters', str.length);
                                                                $this.attr('data-total_words', str.split(' ').length);
                                                                var newWord = $this.first().text().trim()
                                                                
                                                                var words   = newWord.split(' ');

                                                                for(var i=0; i<words.length;i++) {
                                                                    var word = words[i];
                                                                    // console.log(word);
                                                                    wordNumber = k;
                                                                    if(word.trim()!=""){
                                                                        if(i==0 && key==0){
                                                                                end=word.length;
                                                                        }else{
                                                                            if(key>=1){
                                                                                if(i==0){
                                                                                    end+=word.length;
                                                                                    end+= 3
                                                                                } else{
                                                                                    end+=word.length;
                                                                                    end++;
                                                                                }
                                                                            } else {
                                                                                end+=word.length;
                                                                            }
                                                                        }
                                                                        var start = end-word.length
                                                                        var iName= "text_ans[0][0]["+wordNumber+"][i]";
                                                                        var fColorName =  "text_ans[0][0]["+wordNumber+"][fColor]"
                                                                        var foregroundColorSpanName = "text_ans[0][0]["+wordNumber+"][foregroundColorSpan]";
                                                                        var wordName="text_ans[0][0]["+wordNumber+"][word]";
                                                                        var startName = "text_ans[0][0]["+wordNumber+"][start]";
                                                                        var endName = "text_ans[0][0]["+wordNumber+"][end]";
                                                                        paragraph+="<span class='highlight-text' id="+wordNumber+" data-key="+key+" data-wordlength="+word.length+"><input type='hidden' class='i' disabled name="+iName+" value="+wordNumber+"><input type='hidden' class='fColor' disabled name="+fColorName+" value='-1145286'><input type='hidden' class='foregroundColorSpan' disabled name="+foregroundColorSpanName+" value='-1145286'> <input type='hidden' class='word' disabled name="+wordName+" value="+words[i]+" ><input type='hidden' disabled name="+startName+" class='start' value="+start+" ><input disabled type='hidden' name="+endName+" value="+parseInt(end)+" class='end'><span class='word'>"+word.replace(/^\s+/,"")+"</span></span>"
                                                                        $this.html(paragraph);
                                                                    }
                                                                    k++;
                                                                }
                                                            });
                                                        });
                                                        
                                                        setTimeout(function(){

                                                            var answers='<?php echo addslashes($practise['dependingpractise_answer'][0][0]) ?>';
                                                            if( answers !=""){

                                                                var parsedAnswer = JSON.parse(answers);
                                                                if( parsedAnswer!==undefined && parsedAnswer!==null ){
                                                                    var d=0;
                                                                    $.each(parsedAnswer, function(key, value) {
                                                                   
                                                                         $('.true-false').find("#"+value.i).addClass('colorChange');
                                                                         $('.true-false').find("#"+value.i).find('input').removeAttr('disabled');
                                                                         d++;
                                                                    });
                                                                }
                                                            }


                                                            $('.underline').each(function(key){
                                                                console.log(key);
                                                                var text = "";
                                                                $(this).find('.highlight-text').each(function(){
                                                                    if($(this).hasClass("colorChange")){
                                                                        text+="<font color='#EE863A'> "+$(this).find(".word").text()+" </font>";
                                                                    }else{
                                                                        text+=" "+$(this).find(".word").text()+" ";
                                                                    }
                                                                });
                                                                 $(this).closest('p').find('.hidden_'+key).val(text);
                                                            });

                                                        },1000);

                                                },2000);

                                               

                                            </script>
                                            <style type="text/css">
                                                .colorChange{
                                                    color:orange;
                                                }
                                            </style>
                                        <?php
                                    }elseif($practise['depending_practise_details']['question_type'] == "writing_at_end_up_speaking_up"){

                                        // dd($practise);
                                        $questions          = explode(PHP_EOL, $practise['depending_practise_details']['question']);
                                        
                                        $tempAns = [];
                                        foreach($questions as $key => $value) {
                                            if($value!="\r"){ 
                                                array_push($tempAns, $value);
                                            }else{
                                            }
                                        }
                                        $questions = $tempAns;

                                        $dependancy_ans     = $practise['dependingpractise_answer'][0];
                                        $tempAns = [];
                                        foreach($dependancy_ans['text_ans'] as $value){
                                            array_push($tempAns,$value);
                                        }
                                        $dependancy_ans = $tempAns;
                                        $s=0;
                                        foreach($questions as $newKey =>$question) {
                                            ?>
                                            <div class="box box-flex d-flex align-items-center">
                                                <div class="box__left box__left_radio">
                                                    <p>
                                                    <?php
                                                        if(str_contains($question,'@@')) {
                                                            echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$dependancy_ans,&$newKey,&$question) {
                                                                $answeQue = str_replace("@@",$dependancy_ans[$newKey] , $question);
                                                                $ans = $dependancy_ans[$newKey] !=""?$dependancy_ans[$newKey]:"_______";
                                                               $str ='<span id="span_true_false_" style="color:#00adff;"><br>'.$ans.'</span>';
                                                                return $str;
                                                            }, $question);

                                                            
                                                            $tempAns = preg_replace_callback('/@@/', function ($m) use (&$dependancy_ans,&$newKey,&$question) {

                                                                $answeQue   = str_replace("@@",$dependancy_ans[$newKey],$question);
                                                                $ans        = $dependancy_ans[$newKey] !=""?$dependancy_ans[$newKey]:"_______";
                                                                $str       = "<br><b><font color = '#03A9F4'>".$ans." </font></b>";
                                                                return $str;

                                                            }, $question);
                                                            echo '<input type="hidden" name="user_question[]" value="'.$tempAns.'">';
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                                <?php 
                                                    $checked_true = "";
                                                    $checked_false = "";
                                                    if(!empty($practise['user_answer'])){
                                                        if(isset($practise['user_answer'][0][$newKey])){
                                                            if($practise['user_answer'][0][$newKey]['true_false'] == "1"){
                                                                $checked_true = "checked";
                                                            }elseif($practise['user_answer'][0][$newKey]['true_false'] == "0"){
                                                                $checked_false = "checked";
                                                            }
                                                        }
                                                    }
                                                    // if(str_contains($question,'@@')) {
                                                ?>
                                                <div class="true-false_buttons true-false_buttons_radio">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="true_false[{{$s}}]" id="inlineRadioTrue{{$s}}" value="1" {{$checked_true}}>
                                                        <label class="form-check-label form-check-label_true" for="inlineRadioTrue{{$s}}"></label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="true_false[{{$s}}]" id="inlineRadioFalse{{$s}}" value="0" {{$checked_false}}>
                                                        <label class="form-check-label form-check-label_false" for="inlineRadioFalse{{$s}}"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                                $s++;
                                        }
                                    }elseif($practise['depending_practise_details']['question_type'] == "writing_at_end_up_listening"){

                                        $questions          = explode(PHP_EOL, $practise['depending_practise_details']['question']);

                                        $tempAns = [];
                                        foreach($questions as $key => $value) {
                                            if($value!="\r"){ 
                                                array_push($tempAns, $value);
                                            }else{
                                            }
                                        }
                                        $questions = $tempAns;


                                        $dependancy_ans     = $practise['dependingpractise_answer'][0];
                                        $tempAns = [];
                                        foreach($dependancy_ans as $value){
                                            array_push($tempAns,$value);
                                        }
                                        $dependancy_ans = $tempAns;
                                        $s=0;
                                        foreach($questions as $newKey =>$question) {
                                            // if($dependancy_ans[$newKey]=="")  continue;
                                        
                                            ?>
                                            <div class="box box-flex d-flex align-items-center">
                                                <div class="box__left box__left_radio">
                                                    <p>
                                                    <?php
                                                        if(str_contains($question,'@@')) {
                                                            echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$dependancy_ans,&$newKey,&$question) {
                                                                $answeQue = str_replace("@@",$dependancy_ans[$newKey] , $question);
                                                                $ans = $dependancy_ans[$newKey] !=""?$dependancy_ans[$newKey]:"_______";
                                                               $str ='<span id="span_true_false_" style="color:#00adff;"><br>'.$ans.'</span><input type="hidden" name="user_question[]" value="'.$answeQue.'">';
                                                                return $str;
                                                            }, $question);
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                                <?php 
                                                    $checked_true = "";
                                                    $checked_false = "";
                                                    if(!empty($practise['user_answer'])){
                                                        if(isset($practise['user_answer'][0][$newKey])){
                                                            if($practise['user_answer'][0][$newKey]['true_false'] == "1"){
                                                                $checked_true = "checked";
                                                            }elseif($practise['user_answer'][0][$newKey]['true_false'] == "0"){
                                                                $checked_false = "checked";
                                                            }
                                                        }
                                                    }
                                                    // if(str_contains($question,'@@')) {
                                                ?>
                                                <div class="true-false_buttons true-false_buttons_radio">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="true_false[{{$s}}]" id="inlineRadioTrue{{$s}}" value="1" {{$checked_true}}>
                                                        <label class="form-check-label form-check-label_true" for="inlineRadioTrue{{$s}}"></label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="true_false[{{$s}}]" id="inlineRadioFalse{{$s}}" value="0" {{$checked_false}}>
                                                        <label class="form-check-label form-check-label_false" for="inlineRadioFalse{{$s}}"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                                $s++;
                                        }
                                    }elseif($practise['depending_practise_details']['question_type'] == "writing_at_end_up"){


                                            $questions          = explode(PHP_EOL, $practise['depending_practise_details']['question']);
                                            
                                            $tempAns = [];
                                            foreach($questions as $key => $value) {
                                                if($value!="\r"){ 
                                                    array_push($tempAns, $value);
                                                }else{
                                                }
                                            }
                                            $questions = $tempAns;

                                        

                                            $dependancy_ans     = $practise['dependingpractise_answer'][0];
                                            $tempAns = [];
                                            foreach($dependancy_ans as $value){
                                                array_push($tempAns,$value);
                                            }
                                            $dependancy_ans = $tempAns;
                                            $s=0;
                                            foreach($questions as $newKey =>$question) {
                                                // if($dependancy_ans[$newKey]=="")  continue;
                                            
                                                ?>
                                                <div class="box box-flex d-flex align-items-center">
                                                    <div class="box__left box__left_radio">
                                                        <p>
                                                        <?php
                                                            if(str_contains($question,'@@')) {
                                                                echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$dependancy_ans,&$newKey,&$question) {
                                                                    $answeQue = str_replace("@@",$dependancy_ans[$newKey] , $question);
                                                                    $ans = $dependancy_ans[$newKey] !=""?$dependancy_ans[$newKey]:"_______";
                                                                    $str ='<span id="span_true_false_" style="color:#00adff;">'.$ans.'</span>';
                                                                    return $str;
                                                                }, $question);
                                                                $tempAns = preg_replace_callback('/@@/', function ($m) use (&$dependancy_ans,&$newKey,&$question) {

                                                                    $answeQue   = str_replace("@@",$dependancy_ans[$newKey],$question);
                                                                    $ans        = $dependancy_ans[$newKey] !=""?$dependancy_ans[$newKey]:"_______";
                                                                    $str       = "<b><font color = '#03A9F4'>".$ans." </font></b>";
                                                                    return $str;

                                                                }, $question);
                                                                echo '<input type="hidden" name="user_question[]" value="'.$tempAns.'">';
                                                            }
                                                            ?>
                                                        </p>
                                                    </div>
                                                    <?php 
                                                        $checked_true = "";
                                                        $checked_false = "";
                                                        if(!empty($practise['user_answer'])){
                                                            if(isset($practise['user_answer'][0][$newKey])){
                                                                if($practise['user_answer'][0][$newKey]['true_false'] == "1"){
                                                                    $checked_true = "checked";
                                                                }elseif($practise['user_answer'][0][$newKey]['true_false'] == "0"){
                                                                    $checked_false = "checked";
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                    <div class="true-false_buttons true-false_buttons_radio">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="true_false[{{$s}}]" id="inlineRadioTrue{{$s}}" value="1" {{$checked_true}}>
                                                            <label class="form-check-label form-check-label_true" for="inlineRadioTrue{{$s}}"></label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="true_false[{{$s}}]" id="inlineRadioFalse{{$s}}" value="0" {{$checked_false}}>
                                                            <label class="form-check-label form-check-label_false" for="inlineRadioFalse{{$s}}"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                    $s++;
                                            }

                                    }elseif($practise['depending_practise_details']['question_type'] == "match_answer"){


                                        $questions          = $practise['depending_practise_details']['question'];

                                        $tempAns = [];
                                        foreach($questions as $key => $value) {
                                            if($value!="\r"){ 
                                                array_push($tempAns, $value);
                                            }else{
                                            }
                                        }
                                        $questions = $tempAns;


                                        $newQue = explode("#@",$questions[0]);
                                        $questions[0] = $newQue[1];
                                        $questions2          = $practise['depending_practise_details']['question_2'];
                                        $dependancy_ans     =  explode(";", $practise['dependingpractise_answer'][0]);

                                        $tempAns = [];
                                        foreach($dependancy_ans as $value){
                                            if($value == " " || $value == "" ){
                                                array_push($tempAns,"");
                                            }else{
                                                array_push($tempAns,$value);
                                            }
                                        }
                                        // dd($tempAns);
                                        $dependancy_ans = $tempAns;
                                        $s=0;
                                        foreach($dependancy_ans as $newKey =>$ans) {
                                            if($ans=="")  continue;
                                        
                                            ?>
                                            <div class="box box-flex d-flex align-items-center">
                                                <div class="box__left box__left_radio">
                                                    <p>
                                                        <?php echo $str =' <span id="span_true_false_" >'.$questions[$newKey].' - '.$questions2[$ans].'</span><input type="hidden" name="user_question[]" value="'.$questions[$newKey].' - '.$questions2[$ans].'">'; ?>
                                                    </p>
                                                </div>

                                                <?php 
                                                    $checked_true = "";
                                                    $checked_false = "";
                                                    // dd($practise['user_answer']);
                                                    if(!empty($practise['user_answer'])){
                                                        if(isset($practise['user_answer'][0][$s])){

                                                            if($practise['user_answer'][0][$s]['true_false'] == "1"){
                                                                $checked_true = "checked";
                                                            }elseif($practise['user_answer'][0][$s]['true_false'] == "0"){
                                                                $checked_false = "checked";
                                                            }else{

                                                            }
                                                        }
                                                    }
                                                ?>
                                                <div class="true-false_buttons true-false_buttons_radio">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="true_false[{{$s}}]" id="inlineRadioTrue{{$s}}" value="1" {{$checked_true}}>
                                                        <label class="form-check-label form-check-label_true" for="inlineRadioTrue{{$s}}"></label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="true_false[{{$s}}]" id="inlineRadioFalse{{$s}}" value="0" {{$checked_false}}>
                                                        <label class="form-check-label form-check-label_false" for="inlineRadioFalse{{$s}}"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                                $s++;
                                        }
                                    }elseif($practise['depending_practise_details']['question_type'] == "multi_choice_question_multiple"){
                                        // dd($practise);
                                        $questions          = explode(PHP_EOL, $practise['depending_practise_details']['question']);


                                        $tempAns = [];
                                        foreach($questions as $key => $value) {
                                            if($value!="\r"){ 
                                                array_push($tempAns, $value);
                                            }else{
                                            }
                                        }
                                        $questions = $tempAns;
                                            


                                        $dependancy_ans     =  $practise['dependingpractise_answer'][0];
                                        $tempAns = [];
                                        foreach($dependancy_ans as $value){
                                            array_push($tempAns,$value['ans']);
                                        }
                                        // dd($tempAns);
                                        $dependancy_ans = $tempAns;
                                        $s=0;
                                        foreach($questions as $newKey =>$question) {
                                            if($dependancy_ans[$newKey]=="")  continue;
                                        
                                            ?>
                                            <div class="box box-flex d-flex align-items-center">
                                                <div class="box__left box__left_radio">
                                                    <p>
                                                    <?php
                                                        if(str_contains($question,'@@')) {

                                                            echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$dependancy_ans,&$newKey,&$question) {

                                                                $answeQue = str_replace("@@",' : '.$dependancy_ans[$newKey] , $question);

                                                                $ans = $dependancy_ans[$newKey] !=""?$dependancy_ans[$newKey]:"_______";

                                                                $str ='<span id="span_true_false_" > : '.$ans.'</span><input type="hidden" name="user_question[]" value="'.$answeQue.'">';

                                                                return $str;

                                                            }, $question);

                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                                <?php 
                                                    $checked_true = "";
                                                    $checked_false = "";
                                                    if(!empty($practise['user_answer'])){
                                                        if(isset($practise['user_answer'][0][$s])){
                                                            if($practise['user_answer'][0][$s]['true_false'] == "1"){
                                                                $checked_true = "checked";
                                                            }elseif($practise['user_answer'][0][$s]['true_false'] == "0"){
                                                                $checked_false = "checked";
                                                            }
                                                        }
                                                    }
                                                    if(str_contains($question,'@@')) {
                                                ?>
                                                <div class="true-false_buttons true-false_buttons_radio">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="true_false[{{$s}}]" id="inlineRadioTrue{{$s}}" value="1" {{$checked_true}}>
                                                        <label class="form-check-label form-check-label_true" for="inlineRadioTrue{{$s}}"></label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="true_false[{{$s}}]" id="inlineRadioFalse{{$s}}" value="0" {{$checked_false}}>
                                                        <label class="form-check-label form-check-label_false" for="inlineRadioFalse{{$s}}"></label>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            </div>
                                            <?php
                                                $s++;
                                        }
                                    }elseif($practise['depending_practise_details']['question_type'] == "underline_text"){


                                        ?>
                                        <div class="appendToDependancy"></div>
                                        <br>
                                            <script type="text/javascript">
                                                setTimeout(function(){
                                                    $('#{{$depend[1]}}').clone().appendTo('.appendToDependancy');
                                                },1000)
                                            </script>
                                        <?php

                                        $questions          = explode('@@', $practise['depending_practise_details']['question']);
                                        $dependancy_ans     =  explode(';',$practise['dependingpractise_answer'][0][0]);

                                        $tempQue = [];
                                        foreach ($dependancy_ans as $key => $value) {
                                            if($value == ""){
                                                continue;
                                            }
                                           $newData = json_decode($value);
                                            foreach ($newData as $key => $innerValueWord) {
                                                array_push($tempQue,$innerValueWord->word);
                                            }
                                        }
                                        $dependancy_ans = $tempQue;
                                        $tempFlag = true;
                                        foreach($dependancy_ans  as $newKey =>$question) {
                                            ?>
                                            <div class="box box-flex d-flex align-items-center">
                                                <div class="box__left box__left_radio">
                                                    <p>
                                                        <?php
                                                            echo $str ='<span id="span_true_false_">'.$question.'</span><input type="hidden" name="user_question[]" value="'.$question.'">';
                                                        ?>
                                                    </p>
                                                </div>

                                                <?php 
                                                    $checked_true = "";
                                                    $checked_false = "";
                                                    if(!empty($practise['user_answer'])){
                                                        if(isset($practise['user_answer'][0][$newKey])){

                                                            if($practise['user_answer'][0][$newKey]['true_false'] == "1"){
                                                                $checked_true = "checked";
                                                            }elseif($practise['user_answer'][0][$newKey]['true_false'] == "0"){
                                                                $checked_false = "checked";
                                                            }else{

                                                            }
                                                        }
                                                    }
                                                   
                                                ?>
                                                <div class="true-false_buttons true-false_buttons_radio">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="true_false[{{$newKey}}]" id="inlineRadioTrue{{$newKey}}" value="1" {{$checked_true}}>
                                                        <label class="form-check-label form-check-label_true" for="inlineRadioTrue{{$newKey}}"></label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="true_false[{{$newKey}}]" id="inlineRadioFalse{{$newKey}}" value="0" {{$checked_false}}>
                                                        <label class="form-check-label form-check-label_false" for="inlineRadioFalse{{$newKey}}"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }elseif($practise['depending_practise_details']['question_type'] == "reading_no_blanks_listening" OR $practise['depending_practise_details']['question_type'] == "reading_total_blanks_edit" OR $practise['depending_practise_details']['question_type'] == "reading_blanks"){

                                        if (strpos($practise['question'], '^$^') !== false) {

                                            $practise['question']           =   str_replace("^$^", "", $practise['question']);
                                            $questions                      =   explode('***', $practise['question']);
                                            $dependancy_ans                 =   explode(';',$practise['dependingpractise_answer'][0]);
                                            // dd($dependancy_ans);
                                            $tempFlag = true;
                                            foreach($dependancy_ans  as $newKey =>$question) {
                                                if($question == "") continue;
                                                ?>
                                                <div class="box box-flex d-flex align-items-center">
                                                    <div class="box__left box__left_radio">
                                                        <p>
                                                         <?php
                                                                if(count($dependancy_ans)==$newKey+2) {
                                                                        $ifUndeline = $dependancy_ans[$newKey]!=" "?$dependancy_ans[$newKey]:"___";
                                                                        echo $str ='<span id="span_true_false_">'.nl2br($questions[$newKey]).'<span style="color:blue;">'.$ifUndeline.'</span>'.$questions[$newKey+1].'</span>';

                                                                        $ifUndeline = $dependancy_ans[$newKey]!=" "?" <b><font color = '#03A9F4'>".$dependancy_ans[$newKey]."</font></b>":"___";
                                                                        echo'<input type="hidden" name="user_question[]" value="'.$questions[$newKey].' '.$ifUndeline.' '.$questions[$newKey+1].'">';
                                                                        $tempFlag = false;
                                                                }else{
                                                                   
                                                                        $ifUndeline = $dependancy_ans[$newKey]!=" "?$dependancy_ans[$newKey]:"___";
                                                                        echo $str ='<span id="span_true_false_">'.nl2br($questions[$newKey]).'<span style="color:blue;">'.$ifUndeline.'</span></span>';

                                                                        $ifUndeline = $dependancy_ans[$newKey]!=" "?" <b><font color = '#03A9F4'>".$dependancy_ans[$newKey]."</font></b>":"___";

                                                                        echo '<input type="hidden" name="user_question[]" value="'.$questions[$newKey].' '.$ifUndeline.'">';
                                                                 
                                                               }
                                                            ?>
                                                            
                                                        </p>
                                                    </div>

                                                    <?php 
                                                        $checked_true = "";
                                                        $checked_false = "";
                                                        if(!empty($practise['user_answer'])){
                                                            if(isset($practise['user_answer'][0][$newKey])){

                                                                if($practise['user_answer'][0][$newKey]['true_false'] == "1"){
                                                                    $checked_true = "checked";
                                                                }elseif($practise['user_answer'][0][$newKey]['true_false'] == "0"){
                                                                    $checked_false = "checked";
                                                                }else{

                                                                }
                                                            }
                                                        }
                                                        // if(count($dependancy_ans)!=$newKey+1){
                                                       
                                                    ?>
                                                    <div class="true-false_buttons true-false_buttons_radio">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="true_false[{{$newKey}}]" id="inlineRadioTrue{{$newKey}}" value="1" {{$checked_true}}>
                                                            <label class="form-check-label form-check-label_true" for="inlineRadioTrue{{$newKey}}"></label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="true_false[{{$newKey}}]" id="inlineRadioFalse{{$newKey}}" value="0" {{$checked_false}}>
                                                            <label class="form-check-label form-check-label_false" for="inlineRadioFalse{{$newKey}}"></label>
                                                        </div>
                                                    </div>
                                                <?php //} ?>
                                             
                                                </div>
                                                <?php
                                            }

                                        }else{
                                            // dd($practise);

                                                $questions          =   explode(PHP_EOL, $practise['depending_practise_details']['question']);
                                                $questions          =   array_filter($questions);
                                                $questions          =   array_merge($questions);
                                                $tempAns = [];
                                                foreach($questions as $key => $value) {
                                                    if($value!="\r"){ 
                                                        array_push($tempAns, $value);
                                                    }else{
                                                    }
                                                }
                                                $questions = $tempAns;
                                                if($practise['depending_practise_details']['question_type'] != "reading_blanks")
                                                {
                                                   $dependancy_ans     =   !empty($practise['dependingpractise_answer'])?explode(";", $practise['dependingpractise_answer'][0]):[];
                                                }
                                                else
                                                { 
                                                      $dependancy_ans = isset($practise['dependingpractise_answer'][0])?array_column($practise['dependingpractise_answer'][0],'ans'):[];
                                                }
                                                // $dependancy_ans     = array_filter($dependancy_ans);
                                                // $dependancy_ans     = array_merge($dependancy_ans);
                                                // dd($questions);
                                                // dd($dependancy_ans);
                                                $c =0; 
                                                $kk =0; 
                                                $true_false = 0;
                                                foreach($questions as $newKey =>$value) { 
                                                    $is_true_false = true;
                                                    ?>
                                                    <div class="box box-flex d-flex align-items-center">
                                                        <div class="box__left box__left_radio">
                                                            <p>
                                                                <?php
                                                                    $oldQue = "";
                                                                    if(str_contains($value,'@@')) {
                                                                        echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key, &$c, &$userAnswer, &$newKey, &$flag, &$s, &$dependancy_ans, &$value) {
                                                                            $s++;
                                                                            $ans= !empty($dependancy_ans[$c])?trim($dependancy_ans[$c]):"";
                                                                            $new = $flag?$s.".":"";
                                                                            $oldQue = str_replace("@@",$ans , $value);
                                                                            $newAns = $ans==""?"____":$ans;
                                                                            $str ="<b><span style='color:#03A9F4;'> ".$newAns." </span></b>";
                                                                            $c++;
                                                                            return $str;
                                                                        }, $value);

                                                                        $hiddenans = preg_replace_callback('/@@/', function ($m) use (&$key, &$kk, &$userAnswer, &$newKey, &$flag, &$s, &$dependancy_ans, &$value) {
                                                                            $s++;
                                                                            $ans= !empty($dependancy_ans[$kk])?trim($dependancy_ans[$kk]):"";

                                                                            $new = $flag?$s.".":"";
                                                                            $oldQue = str_replace("@@",$ans , $value);
                                                                            $newAns = $ans==""?"____":$ans;
                                                                            $str ="<b><font color = '#03A9F4'> ".$newAns." </font></b>";
                                                                            // $str =$ans;
                                                                            $kk++;
                                                                            return $str;
                                                                        }, $value);

                                                                        echo '<input type="hidden" class="form-control form-control-inline appendspan" name="user_question[]" value="'.$hiddenans.'"></span>';

                                                                         
                                                                    }
                                                                    else
                                                                    { 
                                                                          echo $value;
                                                                          $is_true_false = false;
                                                                          //add else for begginer
                                                                    }
                                                                ?>
                                                            </p>
                                                        </div>
                                                        <?php 
                                                        if($is_true_false == true)
                                                        {
                                                           $checked_true = "";
                                                           $checked_false = "";

                                                            if(!empty($practise['user_answer'])) {
                                                                if(isset($practise['user_answer'][0][$true_false])) {

                                                                    if($practise['user_answer'][0][$true_false]['true_false'] == "1"){
                                                                        $checked_true = "checked";
                                                                    }elseif($practise['user_answer'][0][$true_false]['true_false'] == "0"){
                                                                        $checked_false = "checked";
                                                                    }

                                                                }
                                                            }
                                                        }
                                                        ?>
                                                        <?php 
                                                        if($is_true_false == true)
                                                        {
                                                        ?>
                                                        <div class="true-false_buttons true-false_buttons_radio">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="true_false[{{$true_false}}]" id="inlineRadioTrue{{$true_false}}" value="1" {{$checked_true}}>
                                                                <label class="form-check-label form-check-label_true" for="inlineRadioTrue{{$true_false}}"></label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="true_false[{{$true_false}}]" id="inlineRadioFalse{{$true_false}}" value="0" {{$checked_false}}>
                                                                <label class="form-check-label form-check-label_false" for="inlineRadioFalse{{$true_false}}"></label>
                                                            </div>
                                                        </div>
                                                        <?php 
                                                        $true_false++;
                                                        }
                                                        ?>
                                                    </div>

                                                    <?php
                                                }

                                        }
                                    }elseif($practise['depending_practise_details']['question_type'] == "writing_at_end"){

                                        $tempQuestions = [];
                                        if(!empty($practise['user_answer'])){

                                            foreach ($practise['user_answer'][0] as $key => $value) {
                                                array_push($tempQuestions,$value['question']);
                                            }
                                            $questions      = $tempQuestions;

                                        }

                                        $questions          = explode(PHP_EOL, $practise['depending_practise_details']['question']);

                                        $tempAns = [];
                                        foreach($questions as $key => $value) {
                                            if($value!="\r"){ 
                                                array_push($tempAns, $value);
                                            }else{
                                            }
                                        }
                                        $questions = $tempAns;

                                        $dependancy_ans     =  $practise['dependingpractise_answer'][0];
                                        // dd($practise);
                                         $s = 0;
                                         $temppinc = 0;
                                        foreach($questions as $newKey =>$question) {
                                            ?>
                                            <div class="box box-flex d-flex align-items-center">
                                                <div class="box__left box__left_radio">
                                                    <p>
                                                    <?php
                                                   
                                                        if(str_contains($question,'@@')) {
                                                            echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$dependancy_ans,&$newKey,&$question,&$practise,&$s) {
                                                                $s++;
                                                                $undeLine = $dependancy_ans[$newKey]!=""?$dependancy_ans[$newKey]:"_____";
                                                                $answeQue = str_replace("@@","<br><b><font color = '#03A9F4'>".$undeLine."</font></b>" , $question);

                                                                if(!empty($practise['user_answer'])) {
                                                                    $ans = $dependancy_ans[$newKey] !=""?$dependancy_ans[$newKey]:"";
                                                                }else{
                                                                    $ans = $dependancy_ans[$newKey] !=""?$dependancy_ans[$newKey]:"_____";
                                                                }

                                                                $str ='<br><span id="span_true_false_" style="color:#00adff;">'.$ans.'</span><input type="hidden" name="user_question[]" value="'.$answeQue.'">';
                                                                return $str;
                                                            }, $question);
                                                        }else{

                                                            $str ='<input type="hidden" name="user_question[]" value="">';
                                                            echo $question;
                                                        }

                                                        ?>
                                                        
                                                    </p>
                                                </div>

                                                <?php 
                                                 
                                              

                                                $checked_true = "";
                                                $checked_false = "";
                                                if(!empty($practise['user_answer'])){
                                                    if(isset($practise['user_answer'][0][$temppinc])){
                                                        if($practise['user_answer'][0][$temppinc]['true_false'] == "1"){
                                                            $checked_true = "checked";
                                                        }elseif($practise['user_answer'][0][$temppinc]['true_false'] == "0"){
                                                            $checked_false = "checked";
                                                        }
                                                    }
                                                }
                                                if(str_contains($question,'@@')) {
                                                     
                                                        ?>
                                                        <div class="true-false_buttons true-false_buttons_radio">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="true_false[{{$temppinc}}]" id="inlineRadioTrue{{$temppinc}}" value="1" {{$checked_true}}>
                                                                <label class="form-check-label form-check-label_true" for="inlineRadioTrue{{$temppinc}}"></label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="true_false[{{$temppinc}}]" id="inlineRadioFalse{{$temppinc}}" value="0" {{$checked_false}}>
                                                                <label class="form-check-label form-check-label_false" for="inlineRadioFalse{{$temppinc}}"></label>
                                                            </div>
                                                        </div><?php    $temppinc++;
                                                } 
                                            ?>
                                            </div>
                                            <?php
                                        }
                                    }elseif($practise['depending_practise_details']['question_type'] == "reading_no_blanks"){

                                        // dd($practise);
                                        if (strpos($practise['question'], '^$^') === false) {

                                            $questions      =   explode(PHP_EOL, $practise['depending_practise_details']['question']);
                                            $questions      =   array_filter($questions);
                                            $questions      =   array_merge($questions);

                                            $tempAns = [];
                                            foreach($questions as $key => $value) {
                                                if($value!="\r"){ 
                                                    array_push($tempAns, $value);
                                                }else{
                                                }
                                            }
                                            $questions = $tempAns;

                                            $tempAns = [];
                                            foreach($questions as $key => $value) {
                                                if($value!="\r"){ 
                                                    // array_push($tempAns, "");
                                                    array_push($tempAns, $value);
                                                }else{
                                                }
                                            }
                                            $questions = $tempAns;
                                            // dd($questions);
                                            $dependancy_ans     = !empty($practise['dependingpractise_answer'])?explode(";", $practise['dependingpractise_answer'][0]):[];
                                            // $dependancy_ans     = array_filter($dependancy_ans);
                                            // $dependancy_ans     = array_merge($dependancy_ans);
                                            $c =0; 
                                            $kk =0; 
                                            foreach($questions as $newKey =>$value) { 
                                                ?>
                                                <div class="box box-flex d-flex align-items-center">
                                                    <div class="box__left box__left_radio">
                                                        <p>
                                                            <?php
                                                                if(str_contains($value,'@@')) {
                                                                    echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key, &$c, &$userAnswer, &$newKey, &$flag, &$s, &$dependancy_ans, &$value) {
                                                                        $s++;
                                                                        $ans= !empty($dependancy_ans[$c])?trim($dependancy_ans[$c]):"";

                                                                        $new = $flag?$s.".":"";
                                                                        // $oldQue = str_replace("@@",$ans , $value);
                                                                        $newAns = $ans==""?"____":$ans;
                                                                        $str ="<b><span style='color:#03A9F4;'>".$newAns."</span></b>";
                                                                        $c++;
                                                                        return $str;
                                                                    }, $value);

                                                                    $forans = preg_replace_callback('/@@/', function ($m) use (&$key, &$kk,  &$newKey, &$flag, &$s, &$dependancy_ans, &$value) {
                                                                      
                                                                        $ans= !empty($dependancy_ans[$kk])?trim($dependancy_ans[$kk]):"";

                                                                        $new = $flag?$s.".":"";
                                                                        // $oldQue = str_replace("@@",$ans , $value);
                                                                        $newAns = $ans==""?"____":$ans;
                                                                        $str ="<b><font color = '#03A9F4'>".$newAns."</font></b>";
                                                                        $kk++;
                                                                        return $str;
                                                                    }, $value);

                                                                    echo '<input type="hidden" class="form-control form-control-inline appendspan" name="user_question[]" value="'.$forans.'"></span>';
                                                                }
                                                            ?>
                                                        </p>
                                                    </div>
                                                    <?php 

                                                    $checked_true = "";
                                                    $checked_false = "";

                                                    if(!empty($practise['user_answer'])) {
                                                        if(isset($practise['user_answer'][0][$newKey])) {

                                                            if($practise['user_answer'][0][$newKey]['true_false'] == "1"){
                                                                $checked_true = "checked";
                                                            }elseif($practise['user_answer'][0][$newKey]['true_false'] == "0"){
                                                                $checked_false = "checked";
                                                            }

                                                        }
                                                    }

                     

                                                    ?>
                                                    <div class="true-false_buttons true-false_buttons_radio">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="true_false[{{$newKey}}]" id="inlineRadioTrue{{$newKey}}" value="1" {{$checked_true}}>
                                                            <label class="form-check-label form-check-label_true" for="inlineRadioTrue{{$newKey}}"></label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="true_false[{{$newKey}}]" id="inlineRadioFalse{{$newKey}}" value="0" {{$checked_false}}>
                                                            <label class="form-check-label form-check-label_false" for="inlineRadioFalse{{$newKey}}"></label>
                                                        </div>
                                                    </div>
                                   
                                                </div>

                                                <?php
                                            
                                            }
                                        }else{
                                                //jignesh
                                            $practise['question']           = str_replace("^$^", "", $practise['question']);
                                            $tempQue                        = explode("***", $practise['question']);
                                            $questions                      = explode("***", $practise['question']);
                                            $questions[count($questions)-2] = $questions[count($questions)-2]."".$questions[count($questions)-1];
                                            $questions[count($questions)-1] = "";
                                            $questions                      = array_filter($questions);
                                            $questions                      = array_merge($questions);

                                            $tempAns = [];
                                            foreach($questions as $key => $value) {
                                                if($value!="\r"){ 
                                                    array_push($tempAns, $value);
                                                }else{
                                                }
                                            }
                                            $questions = $tempAns;


                                            $dependancy_ans                 = !empty($practise['dependingpractise_answer'])?explode(";", $practise['dependingpractise_answer'][0]):[];
                                            $tempAns = [];
                                            foreach ($dependancy_ans as $key => $value) {
                                                if($value == " " || $value == "") { 
                                                    array_push($tempAns,"");
                                                } else {
                                                    array_push($tempAns,$value);
                                                }
                                            }

                                            $dependancy_ans = $tempAns;
                                            foreach($questions as $newKey =>$question) { 
                                                $questionss = str_replace("@@", "", $question);
                                                ?>
                                                <div class="box box-flex d-flex align-items-center">
                                                    <div class="box__left box__left_radio">
                                                        <p>
                                                            <?php
                                                            if(count($questions)-1 == $newKey){
                                                                $ans    = $dependancy_ans[$newKey]!=""?$dependancy_ans[$newKey]:"";
                                                                $new    = str_replace("@@", "", $tempQue[$newKey]);
                                                                $last   = str_replace("@@", "", $tempQue[$newKey+1]);

                                                                $newAns = $ans==""?"____":$ans;

                                                                
                                                                $newaas ="<b><font color = '#03A9F4'>".$newAns."</font></b>";

                                                                // dd($tempQue[$newKey]);
                                                                $question = substr($question, 2);
                                                                $lasNewnew    = str_replace("@@",$newaas, $question);
                                                                // dd($lasNewnew);

                                                                echo $str ='<span id="span_true_false_" >'. nl2br($new) .'</span><span style="color:#1eadf1;">'.$newAns.'</span>'.$last.'<input type="hidden" name="user_question[]" value="'.$lasNewnew.'">';
                                                            }else{
                                                                $ans = $dependancy_ans[$newKey]!=""?$dependancy_ans[$newKey]:"";
                                                                $newaas ="<b><font color = '#03A9F4'>".$ans."</font></b>";
                                                                $newAns = $ans==""?"____":$ans;

                                                                echo $str ='<span id="span_true_false_" >'. nl2br($questionss) .'</span><span style="color:#1eadf1;">'.$newAns.'</span><input type="hidden" name="user_question[]" value="'.$questionss.''.$newaas.'">';
                                                            }
                                                            ?>
                                                        </p>
                                                    </div>

                                                    <?php 

                                                        $checked_true = "";
                                                        $checked_false = "";
                                                        if(!empty($practise['user_answer'])) {
                                                            if(isset($practise['user_answer'][0][$newKey])){

                                                                if($practise['user_answer'][0][$newKey]['true_false'] == "1"){
                                                                    $checked_true = "checked";
                                                                }elseif($practise['user_answer'][0][$newKey]['true_false'] == "0"){
                                                                    $checked_false = "checked";
                                                                }
                                                            }
                                                        }
                                                    ?>

                                                    <div class="true-false_buttons true-false_buttons_radio">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="true_false[{{$newKey}}]" id="inlineRadioTrue{{$newKey}}" value="1" {{$checked_true}}>
                                                            <label class="form-check-label form-check-label_true" for="inlineRadioTrue{{$newKey}}"></label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="true_false[{{$newKey}}]" id="inlineRadioFalse{{$newKey}}" value="0" {{$checked_false}}>
                                                            <label class="form-check-label form-check-label_false" for="inlineRadioFalse{{$newKey}}"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }else {

                                        $questions          = explode(PHP_EOL, $practise['depending_practise_details']['question']);
                                        $dependancy_ans     = !empty($practise['dependingpractise_answer'])?explode(";", $practise['dependingpractise_answer'][0]):[];

                                        foreach($questions as $newKey =>$question) {
                                            ?>
                                            <div class="box box-flex d-flex align-items-center">
                                                <div class="box__left box__left_radio">
                                                    <p>
                                                    <?php
                                                        if(str_contains($question,'@@')) {
                                                            echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$dependancy_ans,&$newKey,&$question) {
                                                                $answeQue = str_replace("@@",$dependancy_ans[$newKey] , $question);
                                                               $str ='<span id="span_true_false_">'.$dependancy_ans[$newKey].'</span><input type="hidden" name="user_question[]" value="'.$answeQue.'">';
                                                                return $str;
                                                            }, $question);
                                                        }

                                                        ?>
                                                        
                                                    </p>
                                                </div>

                                                <?php 
                                                        $checked_true = "";
                                                        $checked_false = "";
                                                        if(!empty($practise['user_answer'])){
                                                            if($practise['user_answer'][0][$newKey]['true_false'] == "1"){
                                                                $checked_true = "checked";
                                                            }elseif($practise['user_answer'][0][$newKey]['true_false'] == "0"){
                                                                $checked_false = "checked";
                                                            }else{

                                                            }
                                                        }
                                                ?>
                                                <div class="true-false_buttons true-false_buttons_radio">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="true_false[{{$newKey}}]" id="inlineRadioTrue{{$newKey}}" value="1" {{$checked_true}}>
                                                        <label class="form-check-label form-check-label_true" for="inlineRadioTrue{{$newKey}}"></label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="true_false[{{$newKey}}]" id="inlineRadioFalse{{$newKey}}" value="0" {{$checked_false}}>
                                                        <label class="form-check-label form-check-label_false" for="inlineRadioFalse{{$newKey}}"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                               
                            }elseif($practise['typeofdependingpractice'] == "get_answers_generate_quetions" && ($practise['depending_practise_details']['question_type'] == "reading_total_blanks") ){
                                ?>
                                        @if(!empty($practise['audio_file']))
                                            @include('practice.common.audio_player')
                                        @endif

                                <?php
                                            $questions  =  explode(PHP_EOL, $practise['depending_practise_details']['question']);
                                            $questions = array_filter($questions);
                                            $questions = array_merge($questions);

                                            $tempAns = [];
                                            foreach($questions as $key => $value) {
                                                if($value!="\r"){ 
                                                    array_push($tempAns, $value);
                                                }else{
                                                }
                                            }
                                            $questions = $tempAns;

                                            $dependancy_ans     = !empty($practise['dependingpractise_answer'])?explode(";", $practise['dependingpractise_answer'][0]):[];
                                            $dependancy_ans     = array_filter($dependancy_ans);
                                            $dependancy_ans     = array_merge($dependancy_ans);
            
                                            $c =0; 
                                            $t =0; 

                                            foreach($questions as $newKey =>$value) { 
                                                 ?>
                                                <div class="box box-flex d-flex align-items-center">
                                                    <div class="box__left box__left_radio">
                                                        <p>
                                                            <?php
                                                                if(str_contains($value,'@@')) {
                                                                    echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key, &$c, &$userAnswer, &$newKey, &$flag, &$s, &$dependancy_ans, &$value) {
                                                                        $s++;
                                                                        $ans= !empty($dependancy_ans[$c])?trim($dependancy_ans[$c]):"";
                                                                        $new = $flag?$s.".":"";
                                                                        $oldQue = str_replace("@@",$ans , $value);
                                                                        $str ="<span style='color:#03A9F4;'>".$ans."</span>";
                                                                        $c++;
                                                                        return $str;
                                                                    }, $value);

                                                                    $temp = preg_replace_callback('/@@/', function ($m) use (&$key, &$t, &$userAnswer, &$newKey, &$flag, &$s, &$dependancy_ans, &$value) {
                                                                        $s++;
                                                                        $ans= !empty($dependancy_ans[$t])?trim($dependancy_ans[$t]):"";
                                                                        $new = $flag?$s.".":"";
                                                                        $oldQue = str_replace("@@",$ans , $value);
                                                                        $str ="<b><font color = '#03A9F4'>".$ans."</font></b>";
                                                                        $t++;
                                                                        return $str;
                                                                    }, $value);

                                                                    echo '<input type="hidden" class="form-control form-control-inline appendspan" name="user_question[]" value="'.$temp.'"></span>';
                                                                }
                                                            ?>
                                                        </p>
                                                    </div>
                                                    <?php 

                                                    $checked_true = "";
                                                    $checked_false = "";

                                                    if(!empty($practise['user_answer'])) {
                                                        if(isset($practise['user_answer'][0][$newKey])) {

                                                            if($practise['user_answer'][0][$newKey]['true_false'] == "1"){
                                                                $checked_true = "checked";
                                                            }elseif($practise['user_answer'][0][$newKey]['true_false'] == "0"){
                                                                $checked_false = "checked";
                                                            }

                                                        }
                                                    }

                     

                                                    ?>
                                                    <div class="true-false_buttons true-false_buttons_radio">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="true_false[{{$newKey}}]" id="inlineRadioTrue{{$newKey}}" value="1" {{$checked_true}}>
                                                            <label class="form-check-label form-check-label_true" for="inlineRadioTrue{{$newKey}}"></label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="true_false[{{$newKey}}]" id="inlineRadioFalse{{$newKey}}" value="0" {{$checked_false}}>
                                                            <label class="form-check-label form-check-label_false" for="inlineRadioFalse{{$newKey}}"></label>
                                                        </div>
                                                    </div>
                                   
                                                </div>

                                                <?php
                                        
                                            }


                        }
                        ?>
                    </div>
                    @endif
                    <br>
                    <div class="alert alert-success" role="alert" style="display:none"></div>
                    <div class="alert alert-danger" role="alert" style="display:none"></div>
                    <ul class="list-inline list-buttons removeButton">
                        <li class="list-inline-item">
                            <input type="button" class="save_btn trueFalseLisSymbol_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
                        </li>
                        <li class="list-inline-item">
                            <input type="button" class="submit_btn trueFalseLisSymbol_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">
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
                <script type="text/javascript">


        $(document).ready(function(){
      

            $(document).on('click',".trueFalseLisSymbol_{{$practise['id']}}" ,function() {
                if($(this).attr('data-is_save') == '1'){
                    $(this).closest('.active').find('.msg').fadeOut();
                }else{
                    $(this).closest('.active').find('.msg').fadeIn();
                }
                var reviewPopup = '{!!$reviewPopup!!}';
                var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
                if(markingmethod =="student_self_marking"){
                    if($(this).attr('data-is_save') == '1'){
                        var fullView= $(".save_underline_text_form_{{$practise['id']}}").html();
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

            
                $(".trueFalseLisSymbol_{{$practise['id']}}").attr('disabled','disabled');
                var is_save = $(this).attr('data-is_save');
                $('.is_save:hidden').val(is_save);


                $.ajax({
                    url: "{{url('save-true-false-listening-symbols')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    data: $(".save_true_false_listening_symbol_form_{{$practise['id']}}").serialize(),
                    success: function (data) {
                        $(".trueFalseLisSymbol_{{$practise['id']}}").removeAttr('disabled');
                        if(data.success){
                            $(".save_true_false_listening_symbol_form_{{$practise['id']}}").find('.alert-danger').hide();
                            $(".save_true_false_listening_symbol_form_{{$practise['id']}}").find('.alert-success').show().html(data.message).fadeOut(8000);
                        } else {
                            $(".save_true_false_listening_symbol_form_{{$practise['id']}}").find('.alert-success').hide();
                            $(".save_true_false_listening_symbol_form_{{$practise['id']}}").find('.alert-danger').show().html(data.message).fadeOut(8000);
                        }
                    }
                });
            });
        });

      
    </script>
