<?php //echo "<pre>"; print_r($practise['question']); exit; ?>

    <link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
    <p>
        <strong><?php echo $practise['title']; ?></strong>
    </p>

            @if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid']))
            @php  $depend =explode("_",$practise['dependingpractiseid']); @endphp
                <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;" data-value="{{$practise['id']}}">
                    <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                </div>
            @endif

          <form class="save_four_blank_table_speaking_writing_form_{{$practise['id']}}">
            <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
            <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
            <input type="hidden" class="is_save" name="is_save" value="">
            <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
            <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
            <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">


            <?php

            $exploded_question  =  explode(PHP_EOL, $practise['question']); $i=0;

            $table_header = explode('@@', $exploded_question[0]);
            $table_header = str_replace('\t','',$table_header);

            $answerExists = false;
            if (isset($practise['user_answer']) && !empty($practise['user_answer']))
            {
                $answerExists = true;
            }

            if(is_numeric($exploded_question[1]))
            {
                $firstColumns = array();
            }
            else
            {
                $firstColumns = explode('@@', $exploded_question[1]);
                $exploded_question[1] = count($firstColumns);

            }

            //$columnCount = 1;


            if ($practise['type'] == "four_blank_table_speaking_writing")
            {
                $columnCount = 4;
                $columnClass = 'w-25';
            }

            ?>

<div class="table-container mb-4 text-center">
    <div class="table w-75 m-auto">
        <div class="table-heading thead-dark d-flex justify-content-between">
            @foreach($table_header as $key=> $table_head)
                <?php $table_head = str_replace('/t','',$table_head); ?>
                <div class="d-flex justify-content-center align-items-center th {{ $columnClass }} ">{{$table_head}}</div>
                <div style="display:none">
                    <textarea name="col[]">{{ $table_head }}</textarea>
                    <input type="hidden" name="true_false[]" value="false" />
                </div>
            @endforeach
        </div>

        @for($j = 0;$j < 8 ;$j++) <!-- Total Question Loop -->
            <div class="table-row thead-dark d-flex justify-content-between">
                @for($k = 1; $k <= $columnCount; $k++) <!-- Total Column Loop -->
                    <div class="d-flex justify-content-center align-items-center  border-left td {{ $columnClass }} td-textarea">
                        @if($k == 1 && isset($firstColumns) && !empty($firstColumns) )
                            <span class="textarea form-control form-control-textarea four_table col_{{$j+1}}_{{$k}}"></span>
                            <div style="display:none">
                                <textarea name="col[]" class="col_{{$j+1}}_{{$k}}"></textarea>
                                <input type="hidden" name="true_false[]" value="false" />
                            </div>
                        @else
                            <span class="textarea form-control form-control-textarea four_table col_{{$j+1}}_{{$k}}" role="textbox" contenteditable placeholder="Write here...">
                            @if($answerExists && isset($practise['user_answer']))
                                  {{ $practise['user_answer'][0]['text_ans'][0][0][$j+1]['col_' . $k] }}
                            @endif
                            </span>
                            <div style="display:none">
                                <textarea name="col[]" class="col_{{$j+1}}_{{$k}}">
                                @if($answerExists && isset($practise['user_answer']))
                                    {{ $practise['user_answer'][0]['text_ans'][0][0][$j+1]['col_' . $k] }}
                                @endif
                                </textarea>
                                <input type="hidden" name="true_false[]" value="true" />
                            </div>
                        @endif
                    </div>
                @endfor
            </div>
        @endfor
    </div>
</div>


            <div class="alert alert-success" role="alert" style="display:none"></div>
            <div class="alert alert-danger" role="alert" style="display:none"></div>
            <ul class="list-inline list-buttons">
                <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary four_blank_table_speaking_writingBtn{{$practise['id']}}"
                         data-is_save="0" >Save</button>
                </li>
                <li class="list-inline-item"><button type="button"
                        class="submit_btn btn btn-primary four_blank_table_speaking_writingBtn{{$practise['id']}}" data-is_save="1" >Submit</button>
                </li>
            </ul>

            <input type="hidden" name="table_type" value="<?php echo $columnCount; ?>" />
            </form>


    <script type="text/javascript">
    function setTextareaContent(){
        $("span.textarea.form-control").each(function(){
            var currentVal = $(this).html();
            $(this).next().find("textarea").val(currentVal);
        })
    }
    function getDependingPractises(){

        var topic_id= $(".save_four_blank_table_speaking_writing_form_{{$practise['id']}}").find('.topic_id').val();
        var task_id=$(".save_four_blank_table_speaking_writing_form_{{$practise['id']}}").find('input.depend_task_id').val();
        var practise_id=$(".save_four_blank_table_speaking_writing_form_{{$practise['id']}}").find('input.depend_practise_id').val();
        var storagedata = localStorage.getItem('{{$topicId}}_{{ Session::get('user_data')['student_id']}}');
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

                if(data['success'] == false || jQuery.isEmptyObject(data) || storagedata == ""){
                  $("#dependant_pr_{{$practise['id']}}").css("display", "block");
                  $(".save_four_blank_table_speaking_writing_form_{{$practise['id']}}").css("display", "none");
                  return false;
                }
                else
                {
                    $("#dependant_pr_{{$practise['id']}}").css("display", "none");
                    $(".save_four_blank_table_speaking_writing_form_{{$practise['id']}}").css("display", "block");

                    var result = data['user_Answer'][0];
                    console.log('4====>',result);
                    for(var i=0; i< result[0].length; i++)
                    {
                        if(i>0){
                            $('.four_table.col_'+i+'_1').html(result[0][i]['col_1']).val(result[0][i]['col_1'])
                            $('.four_table.col_'+i+'_3').html(result[0][i]['col_2']).val(result[0][i]['col_2'])
                            $('.four_table.col_'+i+'_4').html(result[0][i]['col_3']).val(result[0][i]['col_3'])
                        }
                    }


                    if(storagedata !== "")
                    {
                        var explodedanswers = storagedata.split(',');
                        for(var v=0; v <= explodedanswers.length; v++)
                        {
                            $('.four_table.col_'+v+'_2').html(explodedanswers[v]).val(explodedanswers[v]);
                        }
                    }

                }

                //if(data['user_Answer'])
                //{

                //}
            }
        });

    }
    </script>
    <script type="text/javascript">

    $(document).ready(function(){
        <?php if($practise['type'] == 'four_blank_table_speaking_writing'): ?>
            var practise_id=$("#dependant_pr_{{$practise['id']}}").data("value");
            if(practise_id){
                var x = getDependingPractises() ;
            }
        <?php endif; ?>
    })

    $(document).on('click','.four_blank_table_speaking_writingBtn{{$practise['id']}}' ,function() {
        if($(this).attr('data-is_save') == '1'){
                $(this).closest('.active').find('.msg').fadeOut();
            }else{
                $(this).closest('.active').find('.msg').fadeIn();
            }
      $('.four_blank_table_speaking_writingBtn{{$practise['id']}}').attr('disabled','disabled');
      var is_save = $(this).attr('data-is_save');
      $('.is_save:hidden').val(is_save);
      setTextareaContent();
      $.ajax({
          url: '<?php echo URL('save_four_blank_table_speaking_writing_form'); ?>',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          type: 'POST',
          data: $('.save_four_blank_table_speaking_writing_form_{{$practise['id']}}').serialize(),
          success: function (data) {
                $('.four_blank_table_speaking_writingBtn{{$practise['id']}}').removeAttr('disabled');
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
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>

    <script>jQuery(function ($) {
        'use strict'
        var supportsAudio = !!document.createElement("audio").canPlayType;
        if (supportsAudio) {
            // initialize plyr
            var i;

               var player = new Plyr("#audio_{{$practise['id']}}", {
                controls: [

                    'play',
                    'progress',
                    'current-time',

                ]
            });


        } else {
            // no audio support
            $('.column').addClass('hidden');
            var noSupport = $('#audio1').text();
            $('.container').append('<p class="no-support">' + noSupport + '</p>');
        }
    });
    </script>
