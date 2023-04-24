  <form class="save_true_false_listening_symbol_form_{{$practise['id']}}">
        <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
        <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
        <input type="hidden" class="is_save" name="is_save" value="">
        <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
        <div class="audio-player" id="audio_plyr_{{$practise['id']}}">
            <audio preload controls id="audio1" src="<?php echo $practise['audio_file']; ?>" type="audio/mpga"></audio>
        </div>
        <?php
            if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
                $depend =explode("_",$practise['dependingpractiseid']); ?>
                <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
                <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
                <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
                    <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                </div>
        <?php }

        $exploded_question=array();
       // dump($practise['question']);
        if(!empty($practise['question'])){
            if(strpos($practise['question'],"\r\n")){
                $practise['question'] =  str_replace("@@","",$practise['question']);
                $exploded_question    =  explode("\r\n", $practise['question']);
                //dump($exploded_question);
 
            }else{
                $practise['question'] =  str_replace("@@","***@@",$practise['question']);
                $exploded_question    =  explode("@@",$practise['question']);
            }
        }
        $i=0;
        //dd($exploded_question);
        ?>
         <div class="true-false" id="true_false_{{$practise['id']}}">
           @foreach($exploded_question as $key => $value)
            <div class="box box-flex d-flex align-items-center">
              <div class="box__left box__left_radio">
                <p>{{$value}}</p>
              </div>
              <?php 
                  echo '<input type="hidden" class="form-control form-control-inline appendspan" name="user_question[]" value="'.$value.'"></span>';
                  $checked_true  = "";
                  $checked_false = "";
                  if(!empty($practise['user_answer'])){
                    if(isset($practise['user_answer'][0][$key])){
                      if($practise['user_answer'][0][$key]['true_false'] == "1"){
                         $checked_true = "checked";
                      }elseif($practise['user_answer'][0][$key]['true_false'] == "0"){
                            $checked_false = "checked";
                      }
                    }
                  }                                                                            
               ?>
               <div class="true-false_buttons true-false_buttons_radio">
                 <div class="form-check form-check-inline">
                    <input class="form-check-input pos-true" data-val={{$key}} type="radio" name="true_false[{{$key}}]" id="inlineRadioTrue{{$key}}" value="1" {{$checked_true}}>
                    <label class="form-check-label form-check-label_true" for="inlineRadioTrue{{$key}}"></label>
                 </div>
                 <div class="form-check form-check-inline">
                    <input class="form-check-input pos-false" data-val={{$key}} type="radio" name="true_false[{{$key}}]" id="inlineRadioFalse{{$key}}" value="0" {{$checked_false}}>
                    <label class="form-check-label form-check-label_false" for="inlineRadioFalse{{$key}}"></label>
                 </div>
               </div>
            </div>
           @endforeach
         </div>
          <div class="questions"></div>
        <br>
        <div class="alert alert-success" role="alert" style="display:none"></div>
        <div class="alert alert-danger" role="alert" style="display:none"></div>
        <ul class="list-inline list-buttons">
            <li class="list-inline-item">
                <input type="button" class="save_btn trueFalseLisSymbol_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
            </li>
            <li class="list-inline-item">
                <input type="button" class="submit_btn trueFalseLisSymbol_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">
            </li>
        </ul>
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
<script type="text/javascript">            
jQuery(function ($) {
  'use strict'
  var supportsAudio = !!document.createElement('audio').canPlayType;
  if(supportsAudio) {
    var i;
    var player = new Plyr('audio', {
        controls: [
            'play',
            'progress',
            'current-time',
        ]
    });
  } 
  else 
  {
    $('.column').addClass('hidden');
    var noSupport = $('#audio1').text();
    $('.container').append('<p class="no-support">' + noSupport + '</p>');
  }
});
$(document).on('click',".trueFalseLisSymbol_{{$practise['id']}}" ,function() {
  if($(this).attr('data-is_save') == '1'){
      $(this).closest('.active').find('.msg').fadeOut();
  }else{
      $(this).closest('.active').find('.msg').fadeIn();
  }
   var reviewPopup = '{!!$reviewPopup!!}';
   var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
   if(markingmethod =="student_self_marking"){
    if($(this).attr('data-is_save') == '1'){
        var fullView= $(".save_true_false_listening_symbol_form_{{$practise['id']}}").html();
        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
    }
   }
  $(".trueFalseLisSymbol_{{$practise['id']}}").attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.is_save:hidden').val(is_save);
  $.ajax({
     url: "{{url('save-true-false-listening-symbols')}}",
     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
     type: 'POST',
     data: $(".save_true_false_listening_symbol_form_{{$practise['id']}}").serialize(),
     success: function (data) {
     $(".trueFalseLisSymbol_{{$practise['id']}}").removeAttr('disabled');
        if(data.success){
          $(".save_true_false_listening_symbol_form_{{$practise['id']}}").find('.alert-danger').hide();
          $(".save_true_false_listening_symbol_form_{{$practise['id']}}").find('.alert-success').show().html(data.message).fadeOut(8000);
        } else {
          $(".save_true_false_listening_symbol_form_{{$practise['id']}}").find('.alert-success').hide();
          $(".save_true_false_listening_symbol_form_{{$practise['id']}}").find('.alert-danger').show().html(data.message).fadeOut(8000);
        }
     }
  });
});
$(document).on('click','.pos-true',function(){
    let current_pos  =  $(this).attr('data-val');
    $('#inlineRadioTrue'+current_pos).attr('checked', true); // Checks it
    $('#inlineRadioFalse'+current_pos).attr('checked', false);
}); 
$(document).on('click','.pos-false',function(){
    let current_pos  =  $(this).attr('data-val');
    $('#inlineRadioFalse'+current_pos).attr('checked', true);
    $('#inlineRadioTrue'+current_pos).attr('checked', false); // Checks it
});
</script>