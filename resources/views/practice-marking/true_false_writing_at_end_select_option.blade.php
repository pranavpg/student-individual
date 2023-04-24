<p><strong>{!! $practise['title'] !!}</strong>
</p>
    <form class="save_true_false_writing_at_end_select_option_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    <?php
	    $exploded_question  =  explode(PHP_EOL, $practise['question']);
		$answerExists = false;
		$answers=array();
		if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
			$answerExists = true;
			$answers = $practise['user_answer'][0];
        }

	?>
    <div class="true-false mb-5">
            @foreach($exploded_question as $key => $value)
            <div class="box box-flex d-flex align-items-center">
                <div class="box__left flex-grow-1">
                        @if(!empty($value))
                            @if(strpos($value, ' @@') !== false)
                                @php
                                    $value = str_replace(" @@","", $value);
                                @endphp
                            @endif
                        @endif

                        <p>{{$value}}</p>
                        <!-- Component - Form Control-->
                            <div class="form-group mb-3">
                            <?php
                                    $style="display:none";
                                        if(isset($answers[$key]['true_false']) && !empty($answers[$key]['true_false']) ==0){
                                            $style="display:block";
                                        }
                                    ?>
                                <span style="{{$style}}" class="textarea form-control form-control-textarea stringProper" role="textbox" disabled contenteditable placeholder="Write here...">
                                    <?php
                                            if($answerExists)
                                            {
                                                echo  ltrim($answers[$key]['text_ans']);
                                            }
                                        ?>
                                    </span>
                                    <div style="display:none">
                                        <textarea name="text_ans[{{$key}}][text_ans]">
                                        <?php
                                            if($answerExists)
                                            {
                                                echo  $answers[$key]['text_ans'];
                                            }
                                        ?>
                                        </textarea>
                                    </div>
                            </div>
                        <div class="multiple-check d-flex flex-wrap mb-0">
                            @for ($i = 1; $i <= 5; $i++)
                                <div class="custom-control custom-radio mb-0 w-20">
                                    <input type="radio" class="custom-control-input" id="cc{{$key}}{{$i}}" required name="text_ans[{{$key}}][ans]" value="{{$i}}" {{ ($answerExists && $answers[$key]['ans'] == $i ) ? "checked":""}}>
                                    <label class="custom-control-label" for="cc{{$key}}{{$i}}">{{$i}}</label>
                                </div>
                            @endfor
                        </div>
                </div>
                <div class="true-false_buttons">
                    <input type="hidden" name="text_ans[{{$key}}][question]"  value="{{ $value }}@@" >
                    <div class="form-check form-check-inline">
                        <input class="form-check-input true_option" type="radio"
                            name="text_ans[{{$key}}][true_false]" id="inlineRadioTrue{{$key}}" value="1" {{ ($answerExists && $answers[$key]['true_false']==1)?"checked":""}} >
                        <label class="form-check-label" for="inlineRadioTrue{{$key}}">True</label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input false_option" type="radio"
                        name="text_ans[{{$key}}][true_false]" id="inlineRadioFalse{{$key}}" value="0" {{ ($answerExists && $answers[$key]['true_false']==0)?"checked":""}} >
                    <label class="form-check-label" for="inlineRadioFalse{{$key}}">False</label>
                    </div>
                </div>
            </div>
            @endforeach
    </div>
	<div class="alert alert-success" role="alert" style="display:none"></div>
	<div class="alert alert-danger" role="alert" style="display:none"></div>
    </form>
<script type="text/javascript">
function getCheckbox(_e){
    if($(_e).is(':checked')){
        $(_e).val(_e);
        $(_e).next().find('input').val(_e+1);
    }
}
$('.false_option').on('click', function(){
	$(this).parent().parent().parent().find('.textarea').show()
});
$('.true_option').on('click', function(){
	$(this).parent().parent().parent().find('.textarea').hide()
});
function setTextareaContent(){
	$("span.textarea.form-control").each(function(){
		var currentVal = $(this).html();
		$(this).next().find("textarea").val(currentVal);
	})
}
</script>
