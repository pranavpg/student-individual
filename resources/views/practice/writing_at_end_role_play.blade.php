
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
                
                    // echo "<pre>";
                    // print_r($practise);
                    // echo "</pre>";
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


                                                        <?php  //dependancy only

                                                        if(strpos($rolePlayQuestions[$s+1], '#%') !== false) { // This code for popup only

                                                            $exploded_question = explode("#%", $rolePlayQuestions[$s+1]);  
                                                            $exploadArray = explode("/t", $exploded_question[1]);
                                                            ?>
                                                                <div  style="text-align: center;">
                                                                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal_{{$s}}">{!! $exploded_question[0] !!}</button>
                                                                </div>
                                                                <div class="modal fade closeOnlyThis" id="myModal_{{$s}}" role="dialog">
                                                                    <div class="modal-dialog">
                                                                      <div class="modal-content">
                                                                        <div class="modal-header">
                                                                          <h4 class="modal-title">{!! $exploded_question[0] !!}</h4>
                                                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                          {!! $exploadArray[0] !!}
                                                                        </div>
                                                                        <div class="modal-footer justify-content-center">
                                                                          <button type="button" class="btn btn-cancel" id="closeOnlyThis">Close</button>
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
                                                                // $flagForDependancy = true;


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
                                                                // dd($userAnswer);
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

                                                                                    $str =' <div class="form-group focus"><span contenteditable="true" role="textbox"  class="textarea form-control form-control-textarea main-answer enter_disable" style="min-width:'.$style.' !important;">'.$ans.'</span>
                                                                                            <input type="hidden" class="form-control text-left pl-0 form-control-inline" name="writeingBox['.$s.'][]" value="'.$ans.'" style="width: 80%;display: inline-table;padding-left: 0px !important;padding-right: 0px !important;"></div>';

                                                                                            // $str ='<div class="form-group focus">
                                                                                            //         <span class="textarea form-control form-control-textarea main-answer enter_disable" role="textbox" contenteditable="" placeholder="Write here..." onpaste="return false;" style="min-width:'.$style.' >'.$ans.'</span>
                                                                                            //         <div style="display:none">
                                                                                            //             <textarea name="writeingBox['.$s.'][]" value="'.$ans.'"></textarea>
                                                                                            //         </div>
                                                                                            //     </div>';


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
                   
                    <ul class="list-inline list-buttons buttons_{{$practise['id']}}">
                        <li class="list-inline-item btnSubmits_temp_{{$practise['id']}}" data="{{$practise['id']}}" data-is_save="0"><button type="button" class="save_btn btn btn-primary  writeAtendUpBtn_{{$practise['id']}} " data-pid="{{$practise['id']}}"
                                data-toggle="modal" data-is_save="0" data-target="#exitmodal"  >Save</button>
                        </li>
                        <li class="list-inline-item btnSubmits_temp_{{$practise['id']}}" data="{{$practise['id']}}" data-is_save="1"><button type="button"
                                class="submit_btn btn btn-primary  writeAtendUpBtn_{{$practise['id']}} " data-pid="{{$practise['id']}} " data-is_save="1" >Submit</button>
                        </li>
                    </ul>
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

                            $(document).on('click','.temp_{{$practise['id']}} .btnSubmits_temp_{{$practise['id']}}' ,function() {
                                // alert($(this).attr("data"))

                                if($(this).attr('data-is_save') == '1'){
                                    $(this).closest('.active').find('.msg').fadeOut();
                                }else{
                                    $(this).closest('.active').find('.msg').fadeIn();
                                }
                                
                                CommonAnsSet();
                                CommonAnsSetDiff();
                                var reviewPopup = '{!!$reviewPopup!!}';
                                  var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
                          
                                    if(markingmethod =="student_self_marking"){
                                        if($(this).attr('data-is_save') == '1'){
                                            var fullView= $(".save_writing_at_end_up_form_role_play_new_{{$practise['id']}}").clone();   
                                            $("#selfMarking_"+$(this).attr("data")).find('#practise_div').html("");

                                            $("#selfMarking_"+$(this).attr("data")).find('#practise_div').html(fullView);

                                            $("#selfMarking_"+$(this).attr("data")).find('.commonFontSize').removeClass("save_writing_at_end_up_form_role_play_new_"+$(this).attr("data"));

                                            $("#selfMarking_"+$(this).attr("data")).modal('toggle');
                                            $("#selfMarking_"+$(this).attr("data")).find('.list-buttons').css("display","none");
                                            $("#selfMarking_"+$(this).attr("data")).find('.alert').css("display","none !important");
                                            $("#selfMarking_"+$(this).attr("data")).find('.text-left').attr("disabled",true);
                                            $("#selfMarking_"+$(this).attr("data")).find('.alert').remove();
                                            $("#selfMarking_"+$(this).attr("data")).find('.textarea').attr("contenteditable","false");

                                            makeFunction($(this).attr("data"))
                                        }
                                    }
                                    if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){

                                        $("#reviewModal_{{$practise['id']}}").modal('toggle');

                                    }

                                $('.btnSubmits_temp').attr('disabled','disabled');
                                var is_save = $(this).attr('data-is_save');
                                $('.is_save:hidden').val(is_save);
                                $.ajax({
                                    url: '<?php echo URL('save-write-atend-up-role-play'); ?>',
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    type: 'POST',
                                    data: $('.save_writing_at_end_up_form_role_play_new_<?php echo $practise['id'];?>').serialize(),
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
   
        $("#closeOnlythis").click(function() {
            $('.closeOnlyThis').modal('hide');
        });

</script>
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
      // $(this).next().val($(this).html())
    
  })
</script>