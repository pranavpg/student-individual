<p><strong>{!! $practise['title'] !!}</strong>
@if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid']))
    @php  $depend =explode("_",$practise['dependingpractiseid']); @endphp
    <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;" data-value="{{$practise['id']}}">
        <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
    </div>
@endif
    <form class="save_true_false_writing_at_end_all_symbol_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
    <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
    <?php
    //    dd($practise);
	    $exploded_question  =  explode('@@', $practise['question']);
		$answerExists = false;
		$answers=array();
		if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
			$answerExists = true;
			$answers = $practise['user_answer'][0];
		}
	?>          
                 
                <div class="true-false true-false_withoutBefore">
                @if(!empty($exploded_question))

                    @foreach($exploded_question as $key => $value)
                        @if(!empty($value))
                                <div class="box box-flex d-flex align-items-center">
                                        <div class="box__left box__left_radio">
                                    @if($practise['type'] == "true_false_writing_at_end_all_symbol")
                                        <p>{{ $value }}</p>
                                    @endif
                                    <div class="form-group">

                            <span class="textarea form-control form-control-textarea stringProper" role="textbox" disabled contenteditable placeholder="Write here...">
                                <?php
                                    if($answerExists)
                                    {
                                        echo  $answers[$key]['text_ans'];
                                    }
                                ?>
                            </span>
                            <div style="display:none">
                                <textarea name="text_ans[{{$key}}][text_ans]">
                                <?php
                                    if ($answerExists)
                                    {
                                        echo  $answers[$key]['text_ans'];
                                    }
                                ?>
                                </textarea>
                            </div>
                    </div>
                </div>
                        <div class="true-false_buttons true-false_buttons_radio">
                                    <input type="hidden" name="text_ans[{{$key}}][question]"  value="{{ $value  }}" >
                                    <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="text_ans[{{$key}}][true_false]" id="RadioTrue{{$key}}" value="1" {{ ($answerExists && isset($answers[$key]['true_false']) && !empty($answers[$key]['true_false']) ==1)?"checked":""}} >
                                            <label class="form-check-label form-check-label_true" for="RadioTrue{{$key}}"></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="text_ans[{{$key}}][true_false]" id="RadioFalse{{$key}}" value="0" {{ ($answerExists && isset($answers[$key]['true_false']) && !empty($answers[$key]['true_false']) ==0)?"checked":""}}>
                                            <label class="form-check-label form-check-label_false" for="RadioFalse{{$key}}"></label>
                                    </div>

                            </div>
                        </div>
							@endif
						@endforeach
					@endif
			</div>
            <div class="multiple-choice">
                <p>Points:</p>
                <div class="form-slider p-0 mb-4">
                    <div class="component-control-box">
                    <span class="textarea form-control form-control-textarea stringProper" role="textbox" disabled contenteditable placeholder="Write here...">
                                <?php
                                    if ($answerExists)
                                    {
                                        echo  $practise['user_answer'][1][0];
                                    }
                                ?>
                            </span>
                            <div style="display:none">
                                <textarea name="points_ans">
                                <?php
                                    if($answerExists)
                                    {
                                        echo  $practise['user_answer'][1][0];
                                    }
                                ?>
                                </textarea>
                            </div>
                    </div>
                </div>
            </div>

			<div class="alert alert-success" role="alert" style="display:none"></div>
			<div class="alert alert-danger" role="alert" style="display:none"></div>
            <ul class="list-inline list-buttons">
    </form>

<script type="text/javascript">
var submited_answer='';
var activeTab = localStorage.getItem('{{$practise['id']}}'+'_'+'{{ isset(Session::get('user_data')['student_id'])?Session::get('user_data')['student_id']:'' }}');
$('.nav-item a').on('shown.bs.tab', function (e) {
    e.preventDefault();
    var current_tab = $(e.target).attr('href');
    localStorage.removeItem('{{$practise['id']}}'+'_'+'{{ isset(Session::get('user_data')['student_id'])?Session::get('user_data')['student_id']:'' }}');
    localStorage.setItem('{{$practise['id']}}'+'_'+'{{ isset(Session::get('user_data')['student_id'])?Session::get('user_data')['student_id']:'' }}', current_tab);
});
<?php if(isset($practise['user_answer']) && $answerExists == true ): ?>
    submited_answer = <?php echo json_encode($answers); ?>;
    console.log('submited_answer', submited_answer)
<?php endif; ?>

$(document).ready(function(){
    var practise_id=$("#dependant_pr_{{$practise['id']}}").data("value");
    if(practise_id){
        var x = getDependingPractise() ;
    }
})
$(window).on('load', function(){
    if(activeTab){
        $('#abc-tab a[href="' + activeTab + '"]').tab('show');
    }
})

function setTextareaContent(){
	$("span.textarea.form-control").each(function(){
		var currentVal = $(this).html();
		$(this).next().find("textarea").val(currentVal);
	})
}
function getDependingPractise(){
    var topic_id= $("#abc-{{$practise['id']}}").find('.topic_id').val();
    var task_id=  $("#abc-{{$practise['id']}}").find('.depend_task_id').val();
    var practise_id = $("#abc-{{$practise['id']}}").find('.depend_practise_id').val();
    var student_id = "{{ Request::segment(4)}}";
    $.ajax({
        url: "{{url('get-student-practisce-answer')}}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data:{
            topic_id,
            task_id,
            practise_id,
            student_id
        },
        dataType:'JSON',
        success: function (data) {
            if(jQuery.isEmptyObject(data) == false) {
                if(data.success == true || !jQuery.isEmptyObject(data.user_Answer)) {
                    $("#dependant_pr_{{$practise['id']}}").css("display", "none");
                    $(".save_true_false_writing_at_end_all_symbol_form_{{$practise['id']}}").css("display", "block");
                    var prev_ans = data.user_Answer[0];
                    var html = '';
                    var x = 0;
                    prev_ans.forEach(function(ele, i) {

                        if( parseInt(ele.true_false) >= 0)
                        {
                            var tex = (ele.true_false == "0" ? "FALSE" : "TRUE");
                            var ans_pos = parseInt(ele.ans_pos);
                            var prev_ans = (ele.true_false == "0" ? '&nbsp;&nbsp;<span>  Corrected : '+`${ele.text_ans}`+'</span>' : '');
                            que = ele.question.replace('@@', '');
                            html += '<div class="box box-flex d-flex align-items-center">'
                            html += '<div class="box__left box__left_radio">'
                            html += '<p>'+`${que}`+'</p><p>'+`${tex}`+' : '+`${ele.ans}`+prev_ans+'</p>'
                            html += '<div class="form-group">'
                            html += '<span class="textarea form-control form-control-textarea" role="textbox" contenteditable placeholder="Write here..." id="span_'+`${i}`+'">'
                            html += '</span>'
                            html += '<div style="display:none"><textarea name="text_ans['+`${i}`+'][text_ans]"></textarea></div>'
                            html += '</div></div>'
                            html += '<div class="true-false_buttons true-false_buttons_radio">'
                            html += '<input type="hidden" name="text_ans['+`${i}`+'][question]"  value="'+`${ele.question}`+'" >'
                            html += '<div class="form-check form-check-inline">'
                            html += '<input class="form-check-input radio_true'+`${x}`+'" type="radio" name="text_ans['+`${i}`+'][true_false]" id="RadioTrue'+`${i}`+'" value="1">'
                            html += '<label class="form-check-label form-check-label_true" for="RadioTrue'+`${i}`+'"></label>'
                            html += '</div>'
                            html += '<div class="form-check form-check-inline">'
                            html += '<input class="form-check-input radio_false'+`${x}`+'" type="radio" name="text_ans['+`${i}`+'][true_false]" id="RadioFalse'+`${i}`+'" value="0">'
                            html += '<label class="form-check-label form-check-label_false" for="RadioFalse'+`${i}`+'"></label>'
                            html += '</div>'
                            html += '</div>'
                            html += '</div></div>';
                            x++;
                        }
                    });
                    $('.true-false_withoutBefore').html('');
                    $('.true-false_withoutBefore').html(html);
                    if(submited_answer !== '' && submited_answer.length > 0) {
                        submited_answer.forEach( (item, i) => {
                            if( item.true_false == "1" || parseInt(item.true_false) == 1){
                                console.log('.radio_true:'+`${i}`);
                                $('.radio_true'+`${i}`).attr('checked','checked');
                                $('#span_'+`${i}`).html(item.text_ans);
                                $('#span_'+`${i}`).closest('div').find('textarea').html(item.text_ans).text(item.text_ans);
                            }
                            if(item.true_false == "0" || parseInt(item.true_false) == 0){
                                $('.radio_false'+`${i}`).attr('checked','checked');
                                $('#span_'+`${i}`).html(item.text_ans);
                                $('#span_'+`${i}`).closest('div').find('textarea').html(item.text_ans).text(item.text_ans);
                            }
                        })
                    }
                }else {
                    $("#dependant_pr_{{$practise['id']}}").css("display", "block");
                    $(".save_true_false_writing_at_end_all_symbol_form_{{$practise['id']}}").css("display", "none");
                }
            }
            else
            {
                $("#dependant_pr_{{$practise['id']}}").css("display", "block");
                $(".save_true_false_writing_at_end_all_symbol_form_{{$practise['id']}}").css("display", "none");
            }

        }
    });

}



</script>
