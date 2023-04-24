        
        <p>
          <strong><?php
          echo $practise['title'];
          ?></strong>
        </p>
          <form class="save_single_tick_form_{{$practise['id']}}">
          <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
          <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
          <input type="hidden" class="is_save" name="is_save" value="">
          <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
          <?php // echo '<pre>'; print_r($practise); 
          if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
            $depend =explode("_",$practise['dependingpractiseid']); 
            
            ?>
             <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
             <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
        <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
                <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
          </div>
       <?php  } ?>
       @if(isset($practise['question']) && !empty($practise['question']))
      <?php if(strpos($practise['question'],' #@')){
            // $class= 'multiple-check';
            $checkSize="w-35";
            $practise['question'] =  str_replace("1 #@"," ",$practise['question']);
            $exploded_question  =  explode('@@', $practise['question']);
          }else{
            // $class='multiple-check d-flex flex-wrap';
            $checkSize="w-25";
            $exploded_question  =  explode("@@", $practise['question']);
          } 
      
          ?>
       @endif
       <div class="multiple-check d-flex flex-wrap">
         @foreach( $exploded_question as $key => $value)
         <?php if($value =="") continue;?>
         <input type="hidden" name="user_answer[{{$key}}][name]" value="{{$value}}">

          <div class="custom-control custom-radio {{$checkSize}}" style="width: 100%;">
              <input type="radio" class="custom-control-input" id="cc_{{$key}}" name="user_checked" value="{{$key}}" {{isset($practise['user_answer'][0][$key]['checked']) && !empty($practise['user_answer'][0][$key]['checked']) ? 'checked':''}} >
              <label class="custom-control-label" for="cc_{{$key}}"><?php echo $value ?></label>
          </div>
          <br>
        @endforeach
      </div>
      </form>
      <script src="{{ asset('public/js/audioplayer.js') }}"></script>
   