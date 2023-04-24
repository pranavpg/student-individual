<p><strong><?php echo $practise['title']; //dd($practise['user_answer']) ?></strong> </p>
@php 
// dd($practise); 
@endphp

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

              <?php  //echo '<pre>'; print_r($practise);
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
                  $exploded_question  =  explode(PHP_EOL, $practise['question']);
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
                              &nbsp;&nbsp;
                          </div>
                          <?php $i++; ?>
                        @endforeach

                       

                    </div>
                </div>
              @endforeach
              @foreach($practise['options'] as $option)
                <input type="hidden" name="user_default_answer[]" value="-1" >
              @endforeach

                 <!--
                </div>
          <div id="multi_choice_btn_{{$practise['id']}}" style="display:block">         -->

            <div class="alert alert-success" role="alert" style="display:none"></div>
            <div class="alert alert-danger" role="alert" style="display:none"></div>
            <ul class="list-inline list-buttons">
                <li class="list-inline-item">
                  <!-- <a href="#!" class="btn btn-primary"
                        data-toggle="modal" data-target="#exitmodal">Save</a> -->
                        <input type="button" class="save_btn multiChoiceQuestionBtn_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0" data-pi="{{$practise['id']}}">
                </li>
                <li class="list-inline-item">
                 <input type="button" class="submit_btn multiChoiceQuestionBtn_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1" data-pi="{{$practise['id']}}">
                </li>
            </ul>
          </div>
      </form>
      @if(isset($practise["markingmethod"]) && $practise["markingmethod"] == "student_self_marking")
           
        @include('practice.common.student_self_marking')
        
      @endif
      @php 
          $lastPractice=end($practises);
      @endphp 
      @if($lastPractice['id'] == $practise['id'])
        @include('practice.common.review-popup')
          @php
              $reviewPopup=true;                
          @endphp
      @else
          @php
              $reviewPopup=false;                
          @endphp
      @endif
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
                    // no audio support
                    $('.column').addClass('hidden');
                    var noSupport = $('#audio1').text();
                    $('.container').append('<p class="no-support">' + noSupport + '</p>');
                } 
          }


          $(document).on('click',".multiChoiceQuestionBtn_{{$practise['id']}}" ,function() {
              if($(this).attr('data-is_save') == '1'){
                  $(this).closest('.active').find('.msg').fadeOut();
              }else{
                  $(this).closest('.active').find('.msg').fadeIn();
              }
            if($('.save_multi_choice_question_form_'+$(this).attr("data-pi")+' .plyr--full-ui').hasClass("plyr--playing")){
                $('.plyr__controls__item').click()
            }
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){
                    $("#reviewModal_{{$practise['id']}}").modal('toggle');
            }
            //-----------------------------------------------------------------------------------------------------------------
            var reviewPopup   = '{!!$reviewPopup!!}';    
            //-----------------------------------------------------------------------------------------------------------------
        $(".multiChoiceQuestionBtn_{{$practise['id']}}").attr('disabled','disabled');
        var is_save = $(this).attr('data-is_save');
        $('.is_save:hidden').val(is_save);
        // setTextareaContent();
        $.ajax({
            url: "{{url('save-multi-choice-question')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: $(".save_multi_choice_question_form_{{$practise['id']}}").serialize(),
            success: function (data) {
              $(".multiChoiceQuestionBtn_{{$practise['id']}}").removeAttr('disabled');
              if(data.success){
                if(is_save=="1"){
                  // =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
                  setTimeout(function(){
                      $('.alert-success').hide();
                    var isNextTaskDependent =  $('.nav-link.active').parent().next().find('a').attr('data-dependent');
                    if( isNextTaskDependent == 1 ){
                      var dependentPractiseId =  $('.nav-link.active').parent().next().find('a').attr('data-id');
                      var baseUrl = "{{url('/')}}";
                      var topic_id = "{{request()->segment(2)}}";
                      var task_id = "{{request()->segment(3)}}";
                       // //window.location.href=baseUrl+'/topic/'+topic_id+'/'+task_id+'?n='+dependentPractiseId
                      ////$('#abc-'+dependentPractiseId+'-tab').trigger('click');
                    } else {
                      ////$('.nav-link.active').parent().next().find('a').trigger('click');
                    }
                  },2000);
                  //=========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
                }
                $('.alert-danger').hide();
                $('.alert-success').show().html(data.message).fadeOut(8000);
                if(is_save == "1")
                {
                  var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
                  if(markingmethod =="student_self_marking"){                     
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
                     var fullView= $(".save_multi_choice_question_form_{{$practise['id']}}").clone();
                     $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
                     $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
                     $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
                     $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
                     $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.choice-box').css("pointer-events","none");
                     $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
                          Audioplay("{{$practise['id']}}");             
                  }
                }
              }else{
                $('.alert-success').hide();
                $('.alert-danger').show().html(data.message).fadeOut(8000);
              }
            }
        });        
      });
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
                        //  $("#multi_choice_btn_{{$practise['id']}}}").css("display", "none");
                      }else{
                        $("#dependant_pr_{{$practise['id']}}").css("display", "none");
                        $("#multipul_check_{{$practise['id']}}").css("display", "block");
                        // $("#multi_choice_btn_{{$practise['id']}}").css("display", "block");
                      }
                      var result =  document.location +data.user_Answer[0];
                    //   console.log('====>',data);
                      var res = result.split(";");
                    var i =0;
                    $.each(res, function( index, value ) {
                        if(value !==""){
                            value = value.replace(document.location, "");
                            // alert( value );
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