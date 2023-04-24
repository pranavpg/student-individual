<form class="form_{{$practise['id']}} commonFontSize">
      <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
      <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
      <input type="hidden" class="is_save" name="is_save" value="">
      <input type="hidden" class="practise_type" name="practise_type" value="{{$practise['type']}}">
      <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
      <input type="hidden" name="is_roleplay" value="true" >
      <input type="hidden" class="is_roleplay_submit" name="is_roleplay_submit" value="1">
      <div class="component-two-click mb-4" >
            <?php 
            // dd($practise);
                $dependancy = explode("##",$practise['depending_practise_details']['question']);
                $dependancy_data[0] = $dependancy[1]; 
                $dependancy_data[1] = $dependancy[2];

                $que = [];
                $full_ans = [];
                // dd($practise['dependingpractise_answer']);
                foreach ($practise['dependingpractise_answer'] as $key => $value) {
                    if($value!="##" && $value !=""){
                        $ss = 0;
                        foreach(json_decode($value[0][0])  as $key1=>$data){
                            // dd($data);
                            $que[$key][$ss] = $data->word;
                            $full_ans[$key][$ss] = $data;
                            $ss++;
                        }
                    }
                }

                foreach ($dependancy_data as $key4 => $valuez) {
                    ?>
                       <div class="content-box multiple-choice d-none student_bottom selected_option_description selected_option_description_temp_{{$key4}} true__false__block remove_d_done" style="color: #30475e;">
                            <div class="underline_text_list_item underline_text_list_item_{{$key4}}">
                                               
                            </div>
                        </div><br>
                <?php }
            ?>

            @if(!empty($two_tabs))
                <?php $k = 0; ?>
                <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
                    @foreach($two_tabs as $key => $value)
                        <?php 
                        if($key==0){
                            $tbkey = $key;
                        } else {
                            $tbkey = $key+1;
                        }
                        if(empty($answers[$tbkey]) && request()->segment(1)=="topic-iframe") {
                          $tab_val = $value."<br/>No answers submitted";
                          $btn_class= 'btn-light';
                        } else {
                          $tab_val=$value;
                          $btn_class= 'btn-dark selected_option';
                        }
                        ?>
                            <div class="prev_ans_{{$k}}" style="display:none;"></div>
                            <a href="javascript:void(0)" class="btn {{$btn_class}}  selected_option_{{$key}}" data-key="{{$key}}">{!!$tab_val!!}</a>
                            <?php $k+=2; ?>
                    @endforeach
                </div>
            @endif
         
      


           

            <div class="two-click-content w-100">
                @if(!empty($question_list))
                    <?php
                      $answer_count=0;
                      $roleplay_count = 0;
                      $test = 0;
                         $p=0;
                    ?>
                    @foreach($question_list as $key => $value)
                        <?php
                            if($key>0) {
                                $roleplay_count+=2;
                            }
                        ?>

                        <div class="content-box multiple-choice d-none student_bottom_{{$roleplay_count}} selected_option_description selected_option_description_{{$key}} true__false__block">

                       
                            <div class="multiple-choice underline__blank"></div>
                                <?php
                                $inc = 0;
                                if(isset($que[$test])){
                                    ?>
                                         <picture class="picture picture-with-border d-flex w-50 mr-auto ml-auto mb-4">
                                            <img src="{{$value}}" alt="" class="img-fluid w-100">
                                        </picture>  
                                    <?php
                                    $inctemp = 0;
                                    // dd($que[$test]);
                                    ksort($que[$test]);
                                    $quedata = array_merge($que[$test]);

                                    foreach($quedata  as $keya=>$question) {
                                        $ans = "";
                                     
                                        if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
                                            if($practise['user_answer'][$p]!="" ){
                                                if(isset($practise['user_answer'][$p][0][$inctemp]) && $practise['user_answer'][$p][0][$inctemp]!=""){
                                                    $ans = !empty($practise['user_answer'][$p])?$practise['user_answer'][$p][0][$inctemp]:'';
                                                }
                                            }
                                        }
                                        echo $question;


                                        echo '<span class=""><input type="text" class="form-control text-left pl-0 form-control-inline disableClass" name="writeingBox['.$key.']['.$keya.']" value="'.$ans.'" style="width: 80%;display: inline-table;padding-left: 0px !important;padding-right: 0px !important;margin-left: 8px;" placeholder="Enter text here..."></span><br><br>';
                                        $inc++;
                                        
                                        $inctemp++;
                                    }
                                        $p =$p+2;
                                }else{
                                      $depend =explode("_",$practise['dependingpractiseid']);
                                    ?>
                                     <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
                                         <p style="margin: 15px;">In order to do this task you need to have completed
                                            <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                                    </div>
                                    <?php
                                }
                              ?>
                        </div>

                      <?php $answer_count++; $test=$test+2;?>
                    @endforeach
                  @endif


            </div>
        </div>

    	<div class="alert alert-success" role="alert" style="display:none"></div>
    	<div class="alert alert-danger" role="alert" style="display:none"></div>
    	<ul class="list-inline list-buttons dependancy_button">
    	    <li class="list-inline-item">
                <input type="button" class="save_btn btn btn-primary submitBtn true_false_submitBtn_{{$practise['id']}}" data-is_save="0" value="Save">
    	    </li>
    	    <li class="list-inline-item">
                <input type="button" class="submit_btn btn btn-primary submitBtn true_false_submitBtn_{{$practise['id']}}" data-is_save="1" value="Submit">
    	    </li>
    	</ul>
    </form>
    <script type="text/javascript">
        var Ans = '{{json_encode($full_ans)}}';
        setTimeout(function(){
            if(Ans!="[]"){

                $('.previous_practice_answer_exists_'+$('.dependancy_practise_id').val()+' .selected_option_description_0').clone().appendTo('.underline_text_list_item_0');
                $('.previous_practice_answer_exists_'+$('.dependancy_practise_id').val()+' .selected_option_description_1').clone().appendTo('.underline_text_list_item_1');
                // $('.selected_option_description_temp_0  .content-box').removeClass('d-done')
                $('.selected_option_description_temp_0').find('.content-box').removeClass('d-done')
                $('.selected_option_description_temp_1').find('.content-box').removeClass('d-done')
            }else{
                $('.dependancy_button').fadeOut();
            }


            setTimeout(function(){
                $('.remove_d_done').each(function(){
                    $(this).find('.content-box').removeClass('d-done');
                });
            },2000);

        },3000);
    </script>