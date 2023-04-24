<p> 
    <strong>{!! $practise['title'] !!}</strong>
	   <?php
        $answerExists = false;
        if(isset($practise['user_answer']) && !empty($practise['user_answer'])) {
            $answerExists = true;
            $user_answer = $practise['user_answer'];
        }
        $exploded_question = $practise['question'];   
	?>
</p>
<form class="writing_edit_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
        <p>
            <div class="form-slider p-0 mb-4">
                <div class="component-control-box">
                    <span class="textarea form-control form-control-textarea" role="textbox" disabled contenteditable="" placeholder="Write here...">{!! isset($practise['user_answer']) && $answerExists == true ? nl2br($user_answer) : $exploded_question !!}</span>
                    <input type="hidden" name="user_answer" value="{{ isset($practise['user_answer']) && $answerExists == true ? $user_answer : ''  }}">
                </div>
            </div>
        </p>
    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
    <ul class="list-inline list-buttons">
        <li class="list-inline-item"><button type="button" class="btn btn-secondary submitWritingEditBtn{{$practise['id']}}"
                data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
        </li>
        <li class="list-inline-item"><button type="button"
                class="btn btn-secondary submitWritingEditBtn{{$practise['id']}}" data-is_save="1" >Submit</button>
        </li>
    </ul>
  </form>
  <script>
    function setTextareaContents(){
        $("span.textarea.form-control").each(function(){
            var currentVal = $(this).html();
            
            $(this).next("input").val(currentVal);
        })
    }
  </script>
