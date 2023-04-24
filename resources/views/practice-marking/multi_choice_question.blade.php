<p><strong><?php echo $practise['title'];?></strong> </p>
<style>
.mcq .custom-check .custom-control-label:before {
    border-color: #007bff;
    background-color: #fff !important;
}
.mcq .custom-checkbox .custom-control-input:indeterminate~.custom-control-label:before{
  border-color: #007bff;
  background-color: #fff !important;
}
.mcq .multiple-check .custom-control-input:checked~.custom-control-label:after, .mcq .multiple-check .custom-control-input:checked~.custom-control-label:before {
    border-color: #d55b7d !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    outline: none !important;
    background-color: #d55b7d !important;
    background-image: url('https://s3.amazonaws.com/imperialenglish.co.uk/ieukstudentpublic/images/icon-custom-check.svg') !important;
    background-position: center !important;
    background-repeat: no-repeat !important;
    background-size: 18px auto !important;
}
</style>
        <form class="mcq save_multi_choice_question_form_{{$practise['id']}}">
              <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
              <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
              <input type="hidden" class="is_save" name="is_save" value="">
              <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
              @if( !empty( $practise['audio_file'] ) )
                @include('practice.common.audio_player')
              @endif
              <?php
              if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
                $depend =explode("_",$practise['dependingpractiseid']);
                ?>
                 <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
                 <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">

            <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
                    <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
              </div>
           <?php } ?>
              <div class=" multiple-check " id="multipul_check_{{$practise['id']}}">
              @if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && isset($practise['dependingpractiseid']) && !empty($practise['dependingpractiseid']) && isset($practise['depending_practise_details']['question_type']) && !empty($practise['depending_practise_details']['question_type']) && $practise['depending_practise_details']['question_type'] == 'match_answer')
                @php
                  if(isset($practise['dependingpractise_answer'][0]) && !empty($practise['dependingpractise_answer'][0])){
                      $dependAnswer= explode(';',$practise['dependingpractise_answer'][0]);
                      if(end($dependAnswer) == ""){
                        array_pop($dependAnswer);
                      }
                      if(isset($practise['depending_practise_details']['question']) && isset($practise['depending_practise_details']['question_2'])){
                        
                        foreach($dependAnswer as $key=> $ans) {
                          if(str_contains($practise['depending_practise_details']['question'][$key],'#@')){
                            $explodeQuestion=explode('#@',$practise['depending_practise_details']['question'][$key]);
                            $practise['depending_practise_details']['question'][$key]=$explodeQuestion[1];
                          }
                          $exploded_question[]=isset($practise['depending_practise_details']['question'][$key])?$practise['depending_practise_details']['question'][$key]:''.' '.$practise['depending_practise_details']['question_2'][$ans];
                        }
                      }
                      @endphp
                      @php
                  }else{
                    $exploded_question=[];
                    @endphp
                    <script>
                    $( document ).ready(function() {
                        $('.save_multi_choice_question_form_{{$practise["id"]}} .list-buttons').css('display','none')
                    });
                    </script>
                      <div id="dependant_pr_{{$practise['id']}}" style="display:block; border: 2px dashed gray; border-radius: 12px;">
                        <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                    </div>
                    @php
                  }
                @endphp
              @else
                @php
                  $exploded_question  =  isset($practise['question'])?explode(PHP_EOL, $practise['question']):[];
                @endphp
              @endif
              <?php $i=0;  
              ?>
              @foreach($exploded_question as $key => $question)
                <div class="choice-box">
                  @if(isset($practise['is_dependent']) && !empty($practise['is_dependent']))
                  <p><?php echo str_replace('@@',"<span id='span_multi_choice_$key'></span>",$question); ?>   </p>
                  @endif
                  <p><?php echo str_replace('@@',".......",$question); ?>   </p>
                  <?php $i=0 ?>
                  <?php
                    $userAnswer=array();
                    if(isset($practise['user_answer'][0][$key]['ans']) && !empty($practise['user_answer'][0][$key]['ans'])){
                        $userAnswer= explode(":",$practise['user_answer'][0][$key]['ans']);
                    }
                  ?>
                    <div class="d-flex  ieukcc-boxo">
                        @foreach($practise['options'][$key] as $k=>$value)
                          <div class="custom-control custom-checkbox w-md-33">
                              <input type="radio" class="custom-control-input" id="cc_1{{$key}}{{$k}}" name="user_answer_[{{$key}}]" value="{{  $i.'@@'.$value }}" <?php if(!empty($userAnswer) && (in_array($value, $userAnswer))){ echo "checked";}?>>
                              <label class="custom-control-label" for="cc_1{{$key}}{{$k}}">{{$value}}</label>
                          </div>
                          <?php $i++; ?>
                        @endforeach
                    </div>
                </div>
              @endforeach
              @if(isset($practise['question']))
                @foreach($practise['options'] as $option)
                  <input type="hidden" name="user_default_answer[]" value="-1" >
                @endforeach
              @endif
          </div>
      </form>
      <script src="{{ asset('public/js/audioplayer.js') }}"></script>
      <script>
          function Audioplay(pid){
            var supportsAudio = !!document.createElement('audio').canPlayType;
            if (supportsAudio) {
              $('.modal').find('.plyr__controls:first').remove()
                    var i;
                     var player = new Plyr(".modal .audio_{{$practise['id']}}", {
                        controls: [
                            'play',
                            'progress',
                            'current-time'
                        ]
                    }); 
                } else {
                    $('.column').addClass('hidden');
                    var noSupport = $('#audio1').text();
                    $('.container').append('<p class="no-support">' + noSupport + '</p>');
                } 
          }
      </script>
@if(isset($practise['typeofdependingpractice']) && !empty($practise['typeofdependingpractice']) && $practise['typeofdependingpractice'] != 'get_answers_generate_quetions')
  <script>
      $(document).ready(function() {
        var practise_id=$(".save_multi_choice_question_form_{{$practise['id']}}").find('.depend_practise_id').val();
        if(practise_id){
            var x = getDependingPractise() ;
        }
        function getDependingPractise(){
          var topic_id= $(".save_multi_choice_question_form_{{$practise['id']}}").find('.topic_id').val();
          var task_id=$(".save_multi_choice_question_form_{{$practise['id']}}").find('.depend_task_id').val();
          var practise_id=$(".save_multi_choice_question_form_{{$practise['id']}}").find('.depend_practise_id').val();
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
                      if(data['success'] == false){
                        $("#dependant_pr_{{$practise['id']}}").css("display", "block");
                        $("#multipul_check_{{$practise['id']}}").css("display", "none");
                      }else{
                        $("#dependant_pr_{{$practise['id']}}").css("display", "none");
                        $("#multipul_check_{{$practise['id']}}").css("display", "block");
                      }
                      var result =  document.location +data.user_Answer[0];
                      var res = result.split(";");
                    var i =0;
                    $.each(res, function( index, value ) {
                        if(value !==""){
                            value = value.replace(document.location, "");
                            $("#span_multi_choice_"+i).html("<b><font color = '#03A9F4'>"+value+"</font></b>");
                            $("#dependan_answer_"+i).val("<b><font color = '#03A9F4'>"+value+"</font></b>");
                            i= i+1;
                        }
                    });
                  }
              });
        }
    });
</script>
@endif
<script src="{{ asset('public/js/audioplayer.js') }}"></script>