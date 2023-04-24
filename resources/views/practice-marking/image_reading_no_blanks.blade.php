{{-- {{ dd($practise) }} --}}
@php
    $img_option = $practise['question'][0];
    $exploded_question = $practise['question_2'];
    $answerExists = false;
    if(isset($practise['user_answer'])):
        $answerExists = true;
        $user_ans = json_encode( explode(";", $practise['user_answer'][0]) );
    endif

@endphp

<form class="save_image_reading_no_blanks_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

<p><strong>{!! $practise['title'] !!}</strong></p>
<picture class="picture picture-with-border d-flex w-75 mr-auto ml-auto mb-4">
    <img src="{{ $img_option }}" alt="" class="img-fluid w-100">
</picture>

<ul class="list-unstyled list-decimal commonFontSize">
    @foreach ($exploded_question as $key=> $item)
            <?php 
                if(str_contains($item,'@@')) {
                    $k=0;
                    echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$c_t, &$data, &$value, &$k) {
                            $str = '<span class="resizing-input1">
                                    <span readonly disabled contenteditable="true" class="enter_disable spandata fillblanks stringProper disable_writing"  ></span>
                                    <input type="hidden" class="form-control form-control-inline appendspan" name="text_ans[]" value=""></span>';

                        return $str;
                    }, $item);
                }
                echo "<br>";
            ?>
    @endforeach
</ul>
<div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
        <!-- <ul class="list-inline list-buttons">
            <li class="list-inline-item">
                <input type="button" class="imagereadingnoblanksBtn_{{$practise['id']}} btn btn-secondary" value="Save" data-is_save="0">
            </li>
            <li class="list-inline-item">
                <input type="button" class="imagereadingnoblanksBtn_{{$practise['id']}} btn btn-secondary" value="Submit" data-is_save="1">
            </li>
        </ul> -->
</form>
@php
    $reviewPopup=false;
@endphp
<style type="text/css">
    [contenteditable] {
        outline: 0px solid transparent;
    }

    *[contenteditable]:empty:before {
        content: "\feff";
    }

    .stringProper {
        display: inline-flex; 
      
    }
    .appendspan {
        color:red;
    }
    .stringProper > * {
        margin: 0 5px !important; /* just for demonstration */
    }
</style>
<script>
    function setTextareaContent(){
        $(".save_image_reading_no_blanks_form_{{$practise['id']}}").find("span.textarea.form-control").each(function(){
            var currentVal = $(this).html();
            $(this).next().find("input:hidden").val(currentVal);
        })
    }
    function CommonAnsSet(){
        $('.spandata').each(function(){
            $(this).next().val( $(this).html() )
        })
    }
    $(document).on('keyup','.spandata',function(){
        $(this).next().val($(this).html())
    })
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
  })

<?php if($answerExists): ?>
    var answers = {!! $user_ans !!};
    $(".save_image_reading_no_blanks_form_{{$practise['id']}}").find("input.form-control-inline").each(function(i){
        $(this).val(answers[i]);
    })
    var flag = true;
    $(".save_image_reading_no_blanks_form_{{$practise['id']}}").find(".spandata").each(function(i){
        if(answers[i] == ""){
            $(this).css("min-width","3ch");
        }else{
            if(answers[i].length == "1" || answers[i].length == "2" || answers[i].length == "3"){
                $(this).css("min-width","1ch");
            }else{
                if(flag){
                    flag = false;
                    $(this).css("min-width","3ch");
                }
            }
        }
        // $(this.css(answers[i]).text(answers[i]);
        $(this).val(answers[i]).text(answers[i]);
    })
<?php endif ?>
</script>
