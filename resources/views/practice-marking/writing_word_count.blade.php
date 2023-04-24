<p>
  <strong>{!! $practise['title'] !!} </strong>
  <?php
  
      $answerExists = false;
      if(isset($practise['user_answer']) && !empty($practise['user_answer']))
      {
            $answerExists = true;
      }
      $exploded_question = isset($practise['question'])?$practise['question']:'';
 ?>
</p>
<form class="writing_word_count_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    <?php
      if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
          $depend =explode("_",$practise['dependingpractiseid']);
      ?>
          <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
          <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
      <?php } ?>
      
      <?php
            $style = "";
            if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) ){
                $depend = explode("_",$practise['dependingpractiseid']); ?>
              <div id="dependant_pr_0" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; display:none">
                   <p style="margin: 15px;">In order to do this task you need to have completed
                      <strong>Practice <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
             </div>
        <?php } ?>
        <div id="writing_word_count_div_practice">
            <p><strong>Word count: <span class="text-pink"></span></strong></p>

            <div class="form-group">
                <span class="textarea form-control form-control-textarea" id="span_TextArea" role="textbox"  disabled  contenteditable="" placeholder="Write here..." onkeyup="wordCount()">
                    <?php echo ( isset($practise['user_answer']) && $answerExists == true ) ? nl2br($practise['user_answer']) :  $exploded_question; ?>
                  </span>
                    <input type="hidden" name="user_answer" id="user_answer">
            </div>
            <div class="alert alert-success" role="alert" style="display:none"></div>
            <div class="alert alert-danger" role="alert" style="display:none"></div>
       </div>
  </form>

  @if(!empty($practise['dependingpractiseid']) && $practise['is_dependent']==1)
  @if(!isset($practise['user_answer']) || empty($practise['user_answer']))
  <script>
  $(window).on('load', function() {
    var practise_id = $(".writing_word_count_form_{{$practise['id']}}").find('.depend_practise_id').val();
    if(practise_id){
        getDependingPractisess();
    } else{
      $('.previous_practice_answer_exists_{{$practise["id"]}}').show();
    }
    function getDependingPractisess(){
      var topic_id= $(".writing_word_count_form_{{$practise['id']}}").find('.topic_id').val();
      var task_id=$(".writing_word_count_form_{{$practise['id']}}").find('.depend_task_id').val();
      var practise_id=$(".writing_word_count_form_{{$practise['id']}}").find('.depend_practise_id').val();
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
           console.log('===>',data)
            if(jQuery.isEmptyObject(data) == false && data.user_Answer){
              if(data && data.user_Answer[0]!==undefined ){
                $("#writing_word_count_div_practice").show();
                $("#span_TextArea").text(data.user_Answer[0]['text_ans'][0]);
                wordCount();
              }
            } else {
                $("#dependant_pr_0").css("display", "block");
                $("#writing_word_count_div_practice").hide();
            }
          }
      });
    }
  });
</script>
@endif
@endif
  <script>
    function setTextareaContent(){
      var currentVal = $("#span_TextArea").html();
      $('#user_answer').val(currentVal);
    }
    function wordCount() {
        var str = $.trim($("#span_TextArea").text());
        console.log(str);
        if(str.length < 1)
        {
          var words = 0;
          $('.text-pink').html(words);
        }
        else
        {
          var words =  str.split(' ').length;
          $('.text-pink').html(words);
        }
    }
    $(function(){
        wordCount();
    })
  </script>
