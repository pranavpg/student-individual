<p>
	<strong>{!! $practise['title']!!}</strong></p>
	<?php
	  //  pr($practise);
      $answerExists = false;

        if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
            $answerExists = true;
        }

        $question                       =  $practise['question'];
        $question_option                =  explode(PHP_EOL, $question);

        $table_rows                     =  $question_option[1];

        $table_heads                    = explode(" /t ", $question_option[0], 2);
        $textbox_title                  = str_replace("@@", '', $table_heads[0]);

        $table_headers                  = explode(' @@ ', $table_heads[1]);
	?>

<form class="save_three_blank_table_writing_up_form_{{$practise['id']}}">

    <input type="hidden" class="task_type" name="task_type" value="{{$practise['type']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    <input type="hidden" name="table_type" value="3">


<div class="multiple-choice mb-4">
    <p><strong>{{ $textbox_title }}</strong></p>
    <div class="form-slider p-0">
        <div class="component-control-box focus">
            <span class="textarea form-control form-control-textarea" role="textbox" disabled contenteditable="" placeholder="Write here...">
                <?php if ($answerExists)
                {
                    echo $practise['user_answer'][1][0];
                }?>
                </span>
                <div style="display:none">
                    <textarea name="textarea[]">
                        <?php
                            if ($answerExists) {
                                echo $practise['user_answer'][1][0];
                            }
                        ?>
                    </textarea>
                </div>
        </div>
    </div>
</div>
<div class="table-container mb-4 text-center">
    <div class="table w-75 mr-auto ml-auto">
        <div class="table-heading thead-dark d-flex justify-content-between">
            @foreach($table_headers as $item)
                <div class="d-flex justify-content-center align-items-center th w-33">
                    {{ $item }}
                </div>
                <div style="display:none">
                <textarea name="col[]">{{$item}}</textarea>
                    <input type="hidden" name="true_false[]" value="false" />
                </div>
            @endforeach
        </div>
        @for($j = 0; $j < $table_rows; $j++)
            <div class="table-row thead-dark d-flex justify-content-between">
                @for($i = 1; $i <= count($table_headers); $i++)
                    <div class="d-flex justify-content-center align-items-center border-left td w-33 td-textarea">
                        <span class="textarea form-control form-control-textarea" role="textbox" disabled contenteditable="" placeholder="Write here...">
                            <?php if($answerExists)
                                {
                                    echo $practise['user_answer'][0][0][$j+1]['col_'. $i];
                                }
							?>
                        </span>
                        <div style="display:none">
                            <textarea name="col[]">
                            <?php
                                if ($answerExists) {
                                    echo $practise['user_answer'][0][0][$j+1]['col_'. $i];
                                }
                            ?>
                            </textarea>
                            <input type="hidden" name="true_false[]" value="true" />
                        </div>
                    </div>
                @endfor
            </div>
        @endfor
    </div>
</div>
</form>
<script>
    function setTextareaContent(){
        $(".save_three_blank_table_writing_up_form_{{$practise['id']}} span.textarea.form-control").each(function(){
            var currentVal = $(this).html();
            $(this).next().find("textarea").val(currentVal);
        })
    }
</script>
