<p><strong>{!! $practise['title']!!}</strong></p>
	<?php
/*    echo "<pre>";
    echo "</pre>";*/
if($practise['id'] == "15590482255ced30216ac5e" ){
    // dd($practise);
}
        $answerExists = false;
        if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
          $answerExists = true;
          $user_answer = $practise['user_answer'];
        }

        $question                       =  $practise['question'];
        $question_option                =  explode('## ', $question);
        //dd($question_option);

        $partners                       =  explode(" @@ ", $question_option[0]);

// dd($partners);

        unset($question_option[0]);
        $questions = array_values($question_option);
        //dd($questions);
         if($practise['id'] == "15590482255ced30216ac5e" ){
            // dd($questions);
        }
        // $explode_question = explode('##', $practise['question']);
        //dd($practise['user_answer'][0][0]);


	?>

    <!-- Compoent - Two click slider-->
    <div class="component-two-click mb-4" id="practise_{{$practise['id']}}">
        <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
            @foreach($partners as $key => $item)
                <?php
                    if(str_contains($item, '##')) {
                        $last_ans = explode('##',$item);
                        $item= $last_ans[0];
                    }
                ?>
                <a href="#!" aria-describedby="tooltip" class="btn btn-dark selected_option selected_option_{{$practise['id']}} selected_option_{{$key}}" data-key="{{$key}}">
                    {{ $item }}
                </a>
            @endforeach
        </div>

   


        @if(!empty($questions))
        

        @foreach ($questions as $k=> $v)
                    @if(strpos($v, '#% ') !== false)
                            <?php $explode_title = explode('#% ', $v); ?>
                            <?php $table = explode('/t', $explode_title[1]); ?>
                           

                        <div class="modal fade add-summary-modal" id="tapscriptmodal_{{$practise['id']}}_{{$k}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 150000;">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">&nbsp;</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body vocabulary-body">
                                        {!! $table[0] !!}
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade add-summary-modala" id="tapscriptmodala_{{$practise['id']}}_{{$k}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 150000;">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">&nbsp;</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body vocabulary-body">
                                        {!! $table[0] !!}
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
        @endforeach
        <form class="save_two_blank_table_tapescript_form_{{$practise['id']}}" id="form_{{$practise['id']}}">
            <div class="two-click-content w-100" >
              <?php $m=0; ?>
                @foreach ($questions as $k=> $v)
                    <div class="content-box multiple-choice d-none selected_option_description selected_option_description_{{$practise['id']}}_{{$k}}">
                    @if(strpos($v, '#% ') !== false)
                            <?php $explode_title = explode('#% ', $v); ?>
                            <?php $table = explode('/t', $explode_title[1]); ?>
                            <div class="text-center mb-4">
                                <a id="" href="#!" class="btn btn-dark modalbtn_{{$practise['id']}}" data-modalid={{$k}} >
                                    {!! $explode_title[0] !!}
                                </a>
                            </div>



                            <?php

                                $table_head = explode(PHP_EOL, $table[1]);
                                $table_rows = $table_head[1];

                                $table_headers = explode(" @@ ", $table_head[0]);
                                $table_row    = explode(" @@ ", $table_rows);

                            ?>

                            
                        

                            <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
                            <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
                            <input type="hidden" class="is_save" name="is_save" value="">
                            <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
                            <input type="hidden" name="table_type" value="2">
                            <input type="hidden" name="is_roleplay" value="true" >
                            <input type="hidden" class="is_roleplay_submit" name="is_roleplay_submit" value="0">
                            <input type="hidden" name="last_ans" value="{{ $item }}" >
                            <input type="hidden" name="total_roleplay_card" value="{{count($questions)}}">
                            <input type="hidden" name="current_card" value="{{$k+1}}">
                            <div id="table_dependent_{{$k}}" >
                                <div class="table-container text-center w-75 m-auto mb-4 d-none done" id="table_{{$k}}">
                                    <div class="table">
                                        <div class="table-heading thead-dark d-flex justify-content-between">
                                            @foreach ($table_headers as $h)
                                                <div class="d-flex justify-content-center align-items-center th w-50">{!! $h !!}
                                                    <div style="display:none">
                                                        <span class="textarea form-control form-control-textarea newtextarea" role="textbox" contenteditable placeholder="Write here..."></span>
                                                        <textarea name="col[]">{!! $h !!}</textarea>
                                                        <input type="hidden" name="true_false[]" value="false" />
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        @foreach($table_row as $r => $rv)

                                            <div class="table-row thead-dark d-flex justify-content-between">
                                                @for($p = 1; $p < count($table_headers); $p++)
                                                    <div class="d-flex justify-content-center align-items-center p-3 border-left td w-50 td-textarea">
                                                        {!! $rv !!}
                                                        <div style="display:none">
                                                            <textarea name="col[]">{!! $rv !!}</textarea>
                                                            <input type="hidden" name="true_false[]" value="false" />
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-center align-items-center td w-50 td-textarea">
                                                        <span class="textarea form-control form-control-textarea newtextarea" role="textbox" contenteditable placeholder="Write here...">
                                                            <?php if(isset($practise['user_answer']) && !empty($practise['user_answer']))
                                                                {

                                                                    if(!empty($user_answer[$m][0][0][$r+1]['col_2']))
                                                                    {
                                                                        echo $user_answer[$m][0][0][$r+1]['col_2'];
                                                                    }
                                                                }
                                                            ?>
                                                        </span>
                                                        <div style="display:none">
                                                            <textarea name="col[]"></textarea>
                                                            <input type="hidden" name="true_false[]" value="true" />
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                    @endif
                    </div>
                    <?php $m+=2;?>
                @endforeach
            </div>

        @endif
        <div class="outer-submit-btn">
          <div class="alert alert-success" role="alert" style="display:none"></div>
          <div class="alert alert-danger" role="alert" style="display:none"></div>
          <ul class="list-inline list-buttons outer-submit-btn">
              <li class="list-inline-item">
                  <input type="button" class="save_btn submitBtn_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
              </li>
              <li class="list-inline-item">
                  <input type="button" class="submit_btn submitBtn_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">
              </li>
          </ul>
        </div>
         </form>
    </div>

         @php
        $reviewPopup=true;
        @endphp
        @if(isset($practise["markingmethod"]) && $practise["markingmethod"] == "student_self_marking")
        @include('practice.common.student_self_marking')

        @endif
        @php
        $lastPractice=end($practises);
        @endphp
        @if($lastPractice['id'] == $practise['id'])
        @include('practice.common.review-popup')
        @else
        @php
        $reviewPopup=false;
        @endphp
        @endif

  <!--   <div class="modal fade add-summary-modal" id="tapscriptmodal_{{$practise['id']}}_{{$k}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="color:#000">
                <div class="modal-body vocabulary-body">
                    {!! $table[0] !!}
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn  btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> -->
    <!-- ./ Compoent - Two click slider Ends-->

    <!-- /. List Button Start-->



<script>





    $(document).ready(function(){

        $('.calll').click(function(){
            $('.add-summary-modal').each(function(){
                $(this).modal("hide")  
            })
        });
        var prid = "{{$practise['id']}}";
        function setTextareaContent(){

            $(".newtextarea").each(function(){
                var currentVal = $(this).html();
                $(this).next().find('textarea').text(currentVal);
            });
        }
        function popupAccordian(){
            // alert(("#selfMarking_{{$practise['id']}}"));
             $("#selfMarking_{{$practise['id']}}").find(".selected_option_{{$practise['id']}}").click(function () {
                    var content_key = $(this).attr('data-key');
                    // alert(content_key)
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find(".selected_option_{{$practise['id']}}").not(this).toggleClass('d-none');
                    $(this).toggleClass('btn-bg');
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.selected_option_description_{{$practise["id"]}}_'+content_key).toggleClass('d-none');
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.selected_option_'+content_key).show();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.table-container').toggleClass('d-none');

                    if( $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.selected_option_description:visible').length>0 ) {
                        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.is_roleplay_submit').val(0);
                        // $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.outer-submit-btn').hide();

                    } else {
                        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.is_roleplay_submit').val(1);
                        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.outer-submit-btn').show();
                    }
                });

                $("#selfMarking_{{$practise['id']}} .modalbtn_{{$practise['id']}}").on('click', function(e){
                
                    e.preventDefault();
                    var modalid = $(this).data('modalid');
                    $('#tapscriptmodala_{{$practise["id"]}}_'+modalid).modal('show');
                    return false;
                });

                 $('#selfMarking_{{$practise['id']}} .calll').click(function(){
                    $('.add-summary-modala').each(function(){
                        $(this).modal("hide")  
                    })
                });

        }


        $('.submitBtn_{{$practise["id"]}}').on('click', function(e) {

            if($(this).attr('data-is_save') == '1'){
                $(this).closest('.active').find('.msg').fadeOut();
            }else{
                $(this).closest('.active').find('.msg').fadeIn();
            }

            
            var reviewPopup = '{!!$reviewPopup!!}';
            var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            // alert(markingmethod);
            if(markingmethod =="student_self_marking"){
                // alert($(this).attr('data-is_save'))
                if($(this).attr('data-is_save') == '1'){
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
                    var fullView= $("#practise_{{$practise['id']}}").html();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
                    pid = "{{$practise['id']}}";
                    if(pid =="15590482255ced30216ac5e"){
                        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.submitBtn_15590482255ced30216ac5e').css('display','none');
                    }
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('show');
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.newtextarea').attr('contenteditable',false);



                    /*$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.newtextarea').each(function(){
                        $(this).attr("contenteditable","false")
                    });*/
                 
                    popupAccordian();
                }
            }
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){

                $("#reviewModal_{{$practise['id']}}").modal('toggle');

            }

            var btnid = $(this).data('id');
              setTextareaContent();
            e.preventDefault();
            if( btnid!==undefined){
          //    alert(btnid)
              
              var formdata = $("#form_"+prid+"_"+btnid).serialize();
              console.log(formdata);
            }
            else{

            }
            var is_save = $(this).attr('data-is_save');
            $(".save_two_blank_table_tapescript_form_{{$practise['id']}}").find('.is_save:hidden').val(is_save);
            var formdata = $(".save_two_blank_table_tapescript_form_{{$practise['id']}}").serialize();
            // $('.is_save:hidden').val(is_save);



            $.ajax({
                url: '<?php echo URL('save-two-blank-table-tapescript'); ?>',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                data: formdata,
                success: function (data) {
                    $('.submitBtn_{{$practise["id"]}}').removeAttr('disabled');
                    if(data.success){
                        $('.alert-danger').hide();
                        $('.alert-success').show().html(data.message).fadeOut(8000);
                    }else{
                        $('.alert-success').hide();
                        $('.alert-danger').show().html(data.message).fadeOut(8000);
                    }
                }
            });

            return false;
        });


        $("#practise_{{$practise['id']}}").find(".selected_option_{{$practise['id']}}").click(function () {
            var content_key = $(this).attr('data-key');
            $("#practise_{{$practise['id']}}").find(".selected_option_{{$practise['id']}}").not(this).toggleClass('d-none');
            $(this).toggleClass('btn-bg');
            $("#practise_{{$practise['id']}}").find('.selected_option_description_{{$practise["id"]}}_'+content_key).toggleClass('d-none');
            $("#practise_{{$practise['id']}}").find('.selected_option_'+content_key).show();
            $("#practise_{{$practise['id']}}").find('.table-container').toggleClass('d-none');

            if( $("#practise_{{$practise['id']}}").find('.selected_option_description:visible').length>0 ){
                $("#practise_{{$practise['id']}}").find('.is_roleplay_submit').val(0);
                // $("#practise_{{$practise['id']}}").find('.outer-submit-btn').hide();

            }else{
                $("#practise_{{$practise['id']}}").find('.is_roleplay_submit').val(1);
                $("#practise_{{$practise['id']}}").find('.outer-submit-btn').show();
            }
        });

        $(".modalbtn_{{$practise['id']}}").on('click', function(e){
            e.preventDefault();
            var modalid = $(this).data('modalid');
            $('#tapscriptmodal_{{$practise["id"]}}_'+modalid).modal('show');
            return false;
        });



    });
</script>
