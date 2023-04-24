<?php
                    $flagForDependancy = false;
                    if(isset($practise['dependingpractiseid'])){
                        if($practise['typeofdependingpractice'] == "set_full_view_remove_zero"){
                            $que = explode("##", $practise['depending_practise_details']['question']); 
                            $flagForDependancy = true;
                        }
                    }
                    $rolePlayQuestions = explode("##",$practise['question']);
                    $rolePlayUsers = explode("@@",$rolePlayQuestions[0]);
                    $userAnswer = array();
                    if(isset($practise['user_answer']) && !empty($practise['user_answer'])) {
                        foreach($practise['user_answer'] as $key=>$userAns){
                            if(is_array($userAns)){
                                $userAns = $userAns[0];
                                foreach($userAns as $userAn){
                                    $userAnswer[$key][] = $userAn;
                                }
                            }
                            else{
                                array_push($userAnswer,$userAns);
                            }
                        }
                    }
                    ?>
                        <form class="save_writing_at_end_up_form_role_play_new_{{$practise['id']}} commonFontSize temp_{{$practise['id']}}">
                            <input type="hidden" class="role_play" name="role_play" value="true">
                            <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
                            <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
                            <input type="hidden" class="is_save" name="is_save" value="">
                            <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
                            <input type="hidden" class="practise_type" name="practise_type" value="{{$practise['type']}}">
                          
                                    <div class="component-two-click mb-4">
                                        <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
                                            <?php
                                            if(!empty($rolePlayUsers)){
                                                $userAnsCount = 0;
                                                
                                                foreach($rolePlayUsers as $c=>$rolePlayUser) { ?>
                                                    <a href="#!" id="s-button-<?php echo $c;?>" class="btn btn-dark s-button-{{$practise['id']}} selected_option selected_option_{{$c}} {{$practise['id']}}"  data-key="{{$c}}"><?php echo trim($rolePlayUser);?></a>
                                                <?php 
                                                }
                                            } ?>
                                        </div>
                                        <div class="two-click-content w-100">
                                            <?php
                                            if(isset($practise['typeofdependingpractice'])){
                                                if($practise['typeofdependingpractice'] == "set_full_view_remove_zero"){
                                                    ?>
                                                        <input type="hidden" name="type_of_role_play_child" value="set_full_view_remove_zero">
                                                    <?php
                                                }
                                            }
                                                $k = 0;
                                                $l = 1;
                                                $pp = 0;
                                                if(!empty($rolePlayUsers)){
                                                $newAnsFlag = 0;
                                                foreach($rolePlayUsers as $s=>$rolePlayUser) {
                                                        $sss = 0;
                                                        $exploded_question = explode(PHP_EOL, $rolePlayQuestions[$s+1]);  
                                                        $countindex = count(array_filter($exploded_question));
                                                    ?>  
                                                    <div class="content-box multiple-choice s-button-box d-none selected_option_description selected_option_description_{{$s}}" id="s-button-<?php echo $s.''.$s;?>">
                                                        <?php  
                                                        if(strpos($rolePlayQuestions[$s+1], '#%') !== false) { // This code for popup only

                                                            $exploded_question = explode("#%", $rolePlayQuestions[$s+1]);  
                                                            $exploadArray = explode("/t", $exploded_question[1]);
                                                            ?>
                                                                <div  style="text-align: center;">
                                                                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal_{{$s}}">{!! $exploded_question[0] !!}</button>
                                                                </div>
                                                                <div class="modal fade" id="myModal_{{$s}}" role="dialog">
                                                                    <div class="modal-dialog">
                                                                      <div class="modal-content">
                                                                        <div class="modal-header">
                                                                          <h4 class="modal-title">{!! $exploded_question[0] !!}</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                          {!! $exploadArray[0] !!}
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                          <button type="button" class="btn btn-primary " data-dismiss="modal">Close</button>
                                                                        </div>
                                                                      </div>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                            $exploded_question = explode(PHP_EOL, $exploadArray[1]);  
                                                        }

                                                        $flagForDependancy = false;  // for dependancy only in role play (jignesh)
                                                        if(isset($practise['dependingpractiseid'])){
                                                            if($practise['typeofdependingpractice'] == "set_full_view_remove_zero"){
                                                                $que = explode("##", $practise['depending_practise_details']['question']); 
                                                                    $answare = [];
                                                                    if(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer'])) {
                                                                        $answare = $practise['dependingpractise_answer'];
                                                                        $apval = $answare[$pp]['text_ans'];
                                                                        $newAns = explode(";",$apval);
                                                                    }
                                                                        
                                                                    if(str_contains($que[$l],'@@')) {
                                                                        echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$que, &$l, &$answare, &$newAns, &$sss) {
                                                                                $str = "";
                                                                                if(empty($newAns[$sss])){
                                                                                    $str.= '<span class=" main-answer enter_disable another-main-answer" style="display: inline-table;"></span>'; 
                                                                                }else{
                                                                                    $str.= '<span class=" main-answer enter_disable another-main-answer" style="display: inline-table;color:red;" >'.$newAns[$sss].'</span>'; 
                                                                                }
                                                                                $sss++;
                                                                            return $str;
                                                                        }, $que[$l] );
                                                                        $k++;
                                                                    } else {
                                                                        echo $que[$l];
                                                                    }
                                                            }
                                                        }
                                                        $l++;
                                                        $pp = $pp+2;
                                                        $newinc =0;
                                                        echo "<br><br>";
                                                        ?>  <input type="hidden" name="writeingBox[]" value="##"><?php
                                                        ?>
                                                        <ul class="list-unstyled">
                                                            <?php
                                                                $point = 0;
                                                                foreach($exploded_question as $question) {
                                                                    if(empty(trim($question))){ continue;}
                                                                    ?>
                                                                    <li>
                                                                        <?php
                                                                        if(str_contains($question,'@@')) {
                                                                                $ans = "";
                                                                                echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$newAns, &$data, &$question, &$k, &$userAnswer, &$ans, &$s, &$newinc, &$point, &$newAnsFlag) {
                                                                                    $ans = !empty($userAnswer)?$userAnswer[$newAnsFlag]!=''?$userAnswer[$newAnsFlag][$point]:"":"";
                                                                                    $value = strlen($ans);
                                                                                    if($value == ""){
                                                                                        $style = "3ch";
                                                                                    }else{
                                                                                        if($value == "1" || $value == "2" || $value == "3"){
                                                                                            $style = "1ch";
                                                                                        }else{
                                                                                            $style = "3ch";
                                                                                        }
                                                                                    }
                                                                                    $str =' <div class="form-group focus"><span  disabled contenteditable="true" role="textbox"  class="textarea form-control form-control-textarea main-answer enter_disable" style="min-width:'.$style.' !important;">'.$ans.'</span>
                                                                                            <input type="hidden" class="form-control text-left pl-0 form-control-inline" name="writeingBox['.$s.'][]" value="'.$ans.'" style="width: 80%;display: inline-table;padding-left: 0px !important;padding-right: 0px !important;"></div>';

                                                                                    $k=$k+2;
                                                                                    $newinc++;
                                                                                    $point++;
                                                                                    return $str;
                                                                                }, $question);
                                                                            } else { 
                                                                                    $point++;
                                                                                echo '<input type="hidden" class="form-control text-left pl-0 form-control-inline" name="writeingBox['.$s.'][]" value="" style="width: 80%;display: inline-table;">';
                                                                                echo $question;
                                                                            }
                                                                        ?>
                                                                    </li>
                                                                    <?php 
                                                                }
                                                                $newAnsFlag = $newAnsFlag+2;
                                                            ?>
                                                        </ul>
                                                    </div>
                                            <?php }   
                                            }  ?>
                                        </div>
                                    </div>
                                <br>
                        </form>
                    <script>
                        function makeFunction(id) {
                            $("#selfMarking_"+id+" .temp_"+id+" .s-button-"+id+"").on("click",function(){
                                if($("#selfMarking_"+id+"  .s-button-"+id+".d-none").length > 0){
                                    $("#selfMarking_"+id+"  .s-button-"+id+".d-none");
                                    $("#selfMarking_"+id+"  .s-button-box").addClass("d-none");
                                    $("#selfMarking_"+id+"  .s-button-box").find('.alert').remove()

                                    $("#selfMarking_"+id+"  .s-button-"+id+"").removeClass("d-none").removeClass("btn-bg");
                                    return false;
                                }
                                $("#selfMarking_"+id+" .temp_"+id+" .s-button-"+id+"").addClass("d-none");
                                $(this).removeClass("d-none").addClass("btn-bg");
                                var curId = $(this).attr("id");
                                curId = curId.replace("s-button-","");
                                $("#selfMarking_"+id+" .temp_"+id+" #s-button-"+curId+curId).removeClass("d-none");
                            });
                        }
                        $(function () {
                            $(".selected_option").click(function () {
                                var content_key = $(this).attr('data-key');
                                if( $('.selected_option_description:visible').length>0 ){
                                  $('.is_roleplay_submit').val(0);
                                }else{
                                  $('.is_roleplay_submit').val(1);
                                } 
                            });
                        });
                      $(".save_writing_at_end_up_form_role_play_new_<?php echo $practise['id'];?> .s-button-<?php echo $practise['id'];?>").on("click",function(){
                          if($(".save_writing_at_end_up_form_role_play_new_<?php echo $practise['id'];?> .s-button-<?php echo $practise['id'];?>.d-none").length > 0){
                            $(".save_writing_at_end_up_form_role_play_new_<?php echo $practise['id'];?> .s-button-<?php echo $practise['id'];?>.d-none");
                            $(".save_writing_at_end_up_form_role_play_new_<?php echo $practise['id'];?> .s-button-box").addClass("d-none");
                            $(".save_writing_at_end_up_form_role_play_new_<?php echo $practise['id'];?> .s-button-<?php echo $practise['id'];?>").removeClass("d-none").removeClass("btn-bg");
                            return false;
                          }
                          $(".save_writing_at_end_up_form_role_play_new_<?php echo $practise['id'];?> .s-button-box,.s-button-<?php echo $practise['id'];?>").addClass("d-none");
                          $(this).removeClass("d-none").addClass("btn-bg");
                          var curId = $(this).attr("id");
                          curId = curId.replace("s-button-","");
                          $(".save_writing_at_end_up_form_role_play_new_<?php echo $practise['id'];?> #s-button-"+curId+curId).removeClass("d-none");
                        })
                    </script>
                    <div class="alert alert-success" role="alert" style="display:none">
                        This is a success alert—check it out!
                    </div>
                    <?php
                    if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) ){
                        $depend =explode("_",$practise['dependingpractiseid']);
                        if(empty($practise['dependingpractise_answer'])){
                            ?>
                                <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
                                     <p style="margin: 15px;">In order to do this task you need to have completed
                                        <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                               </div>
                               <script type="text/javascript">
                                   $('.save_writing_at_end_up_form_role_play_new_{{$practise["id"]}}').fadeOut();
                                   $('.buttons_{{$practise["id"]}}').fadeOut();
                               </script>
                            <?php
                        }
                    }
                    ?>                

<style type="text/css">
    *[contenteditable]:empty:before
    {
        content: "\feff"; /* ZERO WIDTH NO-BREAK SPACE */
    }
    .appendspan {
        color:red;
    }
</style>
<script type="text/javascript">
    function CommonAnsSet(){
        $('.spandata').each(function(){
            $(this).next().val( $(this).html() )
        })
    }
    function CommonAnsSetDiff(){
        $('.textarea').each(function(){
            $(this).next().val( $(this).html() )
        })
    }
    var flag = true;
  $(document).on('keyup','.spandata',function(){
        var value = $(this).html().trim().length
        if(value == ""){
            $(this).css("min-width","3ch");
        }else{
            if(value == "1" || value == "2" || value == "3"){
                $(this).css("min-width","1ch");
            }else{
                if(flag){
                    flag = false;
                    $(this).css("min-width","3ch");
                }
            }
        }
  });
</script>