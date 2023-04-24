@if(isset($practise["markingmethod"]) && $practise["markingmethod"] == "student_self_marking")
    @include('practice.common.student_self_marking')
@endif
@php
    $lastPractice=end($practises);
@endphp
 @php
    $reviewPopup=false;
@endphp

<p><strong>{{$practise['title']}}</strong></p>


<form class="save_assessment_instructions_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
<?php //echo '<pre>'; print_r($practise); ?>



    <div class="multiple-choice mb-4 text-center">
        <div class="text-left mb-4" style="
    border: 1px dashed;
    border-radius: 20px;
    padding: 25px;
    background-color: aliceblue;
">
            {!!$practise['question']!!}
        </div>
    </div>

   
<script type="text/javascript">
var feedbackPopup       = true;
var courseFeedback      = true;
var facilityFeedback    = false;
$(document).on('click','.trueFalseRadioBtn' ,function() {

    var reviewPopup = '{!!$reviewPopup!!}';
    var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
           
    if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){

        $("#reviewModal_{{$practise['id']}}").modal('toggle');

    }
  var pid= $(this).attr('data-pid');

    var $this = $(this);
  // $this.attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.form_'+pid).find('.is_save:hidden').val(is_save);

 
});
</script>