    <?php 
     //dd($practise);
    //  echo '<pre>'; print_r($practise);
        $rolePlayQuestions = explode("##",$practise['question']);
        $rolePlayUsers = explode("@@",$rolePlayQuestions[0]);
    ?>
  <input type="hidden" class="role_play" name="role_play" value="{{$topicId}}">

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
                $newFlag = 0;
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
                                $flagForDependancy = false;
                        
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
                                                        echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$newAns, &$data, &$question, &$k, &$userAnswer, &$ans, &$s, &$newinc, &$point, &$newAnsFlag, &$practise) {
                                                            $new = [];
                                                            if(isset($practise['user_answer'])) {
                                                                if(is_array($practise['user_answer'][$newAnsFlag])) {
                                                                    $new = $practise['user_answer'][$newAnsFlag]['text_ans'];
                                                                }
                                                            }
                                                            $ans = "";
                                                            if(isset($new[$point]) && $new[$point]!=""){

                                                                $ans = $new[$point];
                                                            }

                                                            $str ='<span class="resizing-input1"><input type="text" class="form-control text-left pl-0 form-control-inline" name="text_ans['.$s.'][]" value="'.$ans.'" style="width: 100%;display: inline-table;padding-left: 0px !important;padding-right: 0px !important;"></span>';
                                                            $k=$k+2;
                                                            $newinc++;
                                                        $point++;
                                                            
                                                            return $str;
                                                        }, $question);
                                                    } else { 
                                                           
                                                        $point++;
                                                        echo '<input type="hidden" class="form-control text-left pl-0 form-control-inline" name="text_ans['.$s.'][]" value="#####" style="width: 80%;display: inline-table;">';
                                                        echo $question;
                                                    }
                                                ?>
                                            </li>
                                            <?php 
                                        }
                                        
                                    ?>
                                    <div class="row w-100 d-flex flex-wrap">
                                    <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$newFlag}}" name="writing_at_end_speaking_role_play{{$newFlag}}" value="0">
                                    <input type="hidden" name="user_audio[{{$s}}][path]" class="audio_path{{$newAnsFlag}}">
                                    <div class="col-12 col-lg-12">
                                    @include('practice.common.audio_record_div',['key'=>$newAnsFlag])
                                    </div>
                                    <?php  $newAnsFlag = $newAnsFlag+2; ?>
                                </div>
                                   
                                </ul>
                            </div>
            <?php $newFlag= $newFlag+2;}   

            }  ?>
        </div>
    </div>

<script>
    $(function () {
            setTimeout(function(){
                if("{{$practise['id']}}" == "15569652825ccd67a23e747"){
                    $('.form_15569652825ccd67a23e747').find('.multiple-choice').css("pointer-events",'all')
                }
            },2000);
            $(".selected_option").click(function () {
                var content_key = $(this).attr('data-key');
                if( $('.selected_option_description:visible').length>0 ){
                  $('.is_roleplay_submit').val(0);
                }else{
                  $('.is_roleplay_submit').val(1);
                } 
            });
        });

        $(document).on('click','.btnSubmits_temp_{{$practise['id']}}' ,function() {
            $('.btnSubmits_temp').attr('disabled','disabled');
            var is_save = $(this).attr('data-is_save');
            $('.is_save:hidden').val(is_save);
            $.ajax({
                url: '<?php echo URL('save-write-atend-up-role-play'); ?>',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                data: $('.form_<?php echo $practise['id'];?>').serialize(),
                success: function (data) {
                    $('.btnSubmits_temp').removeAttr('disabled');
                    if(data.success){
                        $('.alert-danger').hide();
                        $('.alert-success').show().html(data.message).fadeOut(4000);
                    }else{
                        $('.alert-success').hide();
                        $('.alert-danger').show().html(data.message).fadeOut(4000);
                    }
                }
            });
        });
          $(".form_<?php echo $practise['id'];?> .s-button-<?php echo $practise['id'];?>").on("click",function(){
              if($(".form_<?php echo $practise['id'];?> .s-button-<?php echo $practise['id'];?>.d-none").length > 0){
                $(".form_<?php echo $practise['id'];?> .s-button-<?php echo $practise['id'];?>.d-none");
                $(".form_<?php echo $practise['id'];?> .s-button-box").addClass("d-none");
                $(".form_<?php echo $practise['id'];?> .s-button-<?php echo $practise['id'];?>").removeClass("d-none").removeClass("btn-bg");
                return false;
              }
              $(".form_<?php echo $practise['id'];?> .s-button-box,.s-button-<?php echo $practise['id'];?>").addClass("d-none");
              $(this).removeClass("d-none").addClass("btn-bg");
              var curId = $(this).attr("id");
              curId = curId.replace("s-button-","");
              $(".form_<?php echo $practise['id'];?> #s-button-"+curId+curId).removeClass("d-none");
            })
</script>