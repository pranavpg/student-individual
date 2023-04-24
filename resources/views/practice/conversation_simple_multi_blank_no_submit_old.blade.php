       <p>
          <strong><?php
          echo $practise['title'];
          ?></strong>
        </p>
  <form class="form_{{$practise['id']}}">
          <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
          <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
          <input type="hidden" class="is_save" name="is_save" value="">
          <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
          <?php // echo '<pre>'; print_r($practise);  exit();
          if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
            $depend =explode("_",$practise['dependingpractiseid']); 
            
            
            ?>
             <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
             <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
         
              <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
                      <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                </div>
            <?php } ?> 

        <div class="conversation d-flex flex-column">
          @foreach($practise['question'] as $key => $question)
            @if(strpos($question, "A.") !== false)
            <div class="convrersation-box mr-auto mb-4">
            
            <p>
                {{ $question }}
              </p>
              
            </div>
            @else   
            <div class="convrersation-box convrersation-box__dark ml-auto mb-4">
            
            <p>
              {{ $question }}
              </p>
            </div>
            @endif           
          @endforeach
            <!-- /. Conversation Box -->
  </div>
  <!--Component Conversation End-->

  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
  <ul class="list-inline list-buttons">
      <li class="list-inline-item"><button class="btn btn-primary submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
      </li>
      <li class="list-inline-item"><button
              class="btn btn-primary submitBtn_{{$practise['id']}}" data-is_save="1" data-pid="{{$practise['id']}}" >Submit</button>
      </li>
  </ul>
</form>
<script>
  function setInputContent(){
    $('.form_{{$practise["id"]}}').find("span.textarea.form-control").each(function(i){
      var currentVal = $(this).html();
      //  console.log(i,'====>,',currentVal)
      if($.trim(currentVal)!=""){

        $(this).next().val('_'+currentVal+'_');
      } else {
        $(this).next().val(currentVal);
      }
    });
  }
  $('.form_{{$practise["id"]}}').on('click','.submitBtn_{{$practise["id"]}}' ,function() {

    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
      }else{
        $(this).closest('.active').find('.msg').fadeIn();
      }
      
    $('.submitBtn_{{$practise["id"]}}').attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);
      setInputContent();
    $.ajax({
        url: '<?php echo URL('save-conversation-simple-multi-blank-no-submit'); ?>',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $('.form_{{$practise["id"]}}').serialize(),
        success: function (data) {
          $('.submitBtn_{{$practise["id"]}}').removeAttr('disabled');
          if(data.success){
            $('.alert-danger').hide();
            $('.alert-success').show().html(data.message).fadeOut(8000);
          } else {
            $('.alert-success').hide();
            $('.alert-danger').show().html(data.message).fadeOut(8000);
          }
        }
    });
  });
</script>
 
