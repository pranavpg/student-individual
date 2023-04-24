<p>
	<strong><?php 	echo $practise['title']; ?></strong>
</p>
<?php
  $answerExists = false;
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
  }

?>
<form class="form_{{$practise['id']}}">
    <center>
    <?php 
      if(!empty($practise['dependingpractise_answer'])){
        ?>  
        <ul style=" min-width: 696px; list-style: none; padding-top: 20px;margin-bottom: 31px;">
        <?php
          foreach ($practise['dependingpractise_answer'][0] as $key => $value) {
              echo "<li style='    display: inline;padding: 10px;border: solid 1px orange;'>".$value."</li>";
          }
        ?>  
        </ul>
        <?php
      }
    ?>
  </center>
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="topic_id_multi_image" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

    <?php // echo '<pre>'; print_r($practise);  exit();
        if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
            $depend =explode("_",$practise['dependingpractiseid']);?>
            <input type="hidden" class="depend_task_id_multi_image" name="depend_task_id" value="{{$depend[0]}}">
            <input type="hidden" class="depend_practise_id_multi_image" name="depend_practise_id" value="{{$depend[1]}}">
            <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
                <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
            </div>
    <?php } ?>

  @if(!empty($practise['question_2']))
    <div class="suggestion-list row justify-content-center mr-auto ml-auto mb-4">
        @foreach($practise['question_2'] as $key => $value)
        <div class="suggestion_box col-md-4 justify-content-center text-center">
            {{ $value}}
        </div>
        @endforeach
    </div>
  @endif
  <div class="w-100"></div>

        <span class="boxappend"></span>
  @if(!empty($practise['question']))
    <div class="image-box__writting w-75 mr-auto ml-auto row imagetag">
      @foreach($practise['question'] as $k => $v)
        <div class="col-4 writting mb-4 pl-0">
            <picture class="picture mb-3 text-center" >
                <img src="{{$v}}" alt="" class="img-fluid" style="width:100%;">
            </picture>
            <!-- Component - Form Control-->
            <div class="form-group" >
              <span class="textarea form-control form-control-textarea main-answer" role="textbox" contenteditable placeholder="Write here...">
                <?php
                  if ($answerExists)
                  {
                      echo  !empty($practise['user_answer'][$k][0])?$practise['user_answer'][$k][0]:"";
                  }
                ?>
              </span>
              <div style="display:none">

                <textarea name="user_answer[{{$k}}][0]" class="main-answer-input">
                <?php
                    if ($answerExists)
                    {
                      echo  !empty($practise['user_answer'][$k][0])?$practise['user_answer'][$k][0]:"";
                    }
                ?>
                </textarea>
              </div>
            </div>
        </div>
      @endforeach
    </div>
  @endif
</form>
<style type="text/css">
    .boxappend li{
        display: block;
        width: auto;
        height: auto;
        border: 2px solid #af5a13;
        float: left;
        padding: 11px;
    }
     
</style>
<script>
    $(document).ready(function(){
        setTimeout(function(){
            getDependingPractises();
        },400)
    });
    function getDependingPractises(){

          var topic_id= $('.topic_id_multi_image').val();
          var task_id=$('input.depend_task_id_multi_image').val();
          var practise_id=$('input.depend_practise_id_multi_image').val();
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
                console.log(data);
                  if(typeof data['success'] !== "undefined"){
                      var text = "<ul>";
                      data['user_Answer'][0].forEach(function(number) {
                          if(number != ""){
                              text += "<li>"+number+"</li>";
                          }
                      });
                      text += "</ul>";
                      $('.boxappend').html(text)
                  }
              }
          });

      }
</script>
