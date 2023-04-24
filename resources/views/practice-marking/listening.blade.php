

<p>
	<strong>{!! $practise['title'] !!}</strong>
<?php
 if(isset($practise['id']))
 {
       if($practise['id'] == "1666012725634d5635dea54" || $practise['id'] == "16656595856347f2c118a12")
       {
         $data[$practise['id']] = array();
         $data[$practise['id']]['isRolePlayPractice'] = (!empty($practise['is_roleplay']) &&  $practise['is_roleplay']==1)?1:0;
         $data[$practise['id']]['typeofdependingpractice'] = !empty($practise['typeofdependingpractice']) ? $practise['typeofdependingpractice'] : "";
         $data[$practise['id']]['setFullViewFromPreviousPractice'] = !empty($practise['depending_practise_details']['dependant_practise_id']) ? $practise['depending_practise_details']['dependant_practise_id']:"";
         $data[$practise['id']]['dependant_practise_topic_id'] = !empty($practise['depending_practise_details']['dependant_practise_topic_id']) ? $practise['depending_practise_details']['dependant_practise_topic_id']:"";
         $data[$practise['id']]['dependant_practise_task_id'] = !empty($practise['depending_practise_details']['dependant_practise_task_id']) ? $practise['depending_practise_details']['dependant_practise_task_id']:"";
         $data[$practise['id']]['dependant_practise_question_type'] = !empty($practise['depending_practise_details']['question_type']) ? $practise['depending_practise_details']['question_type']:"";
         $data[$practise['id']]['dependentpractice_ans'] = !empty($practise['dependingpractise_answer'])?1:0;
         $data[$practise['id']]['is_dependent'] = !empty($practise['is_dependent']) ? 1 : 0;
       }
 }
if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1  && isset($practise['dependingpractise_answer'])&& empty($practise['dependingpractise_answer'])){
  $depend =explode("_",$practise['dependingpractiseid']);
  $style= "display:none"; 
  
?>
  <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; display:block">
    <p style="margin: 15px;">In order to do this task you need to have completed
    <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
  </div>
<?php
}else{
  $style= "display:block"; 
?>
@if(isset($practise['id']))
 @if($practise['id'] == "1666012725634d5635dea54" || $practise['id'] == "16656595856347f2c118a12")
   <div class="showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}} mb-4"></div>
 @endif
@endif
<?php
}?>
    @php
      $answerExists = false;
      if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
        $answerExists = true;
      }
    @endphp
</p>
<!--------------ADD DEPENDENT TWO COLUMN TABLE--------->
  @if(isset($practise['depending_practise_details']['question_type']))
   @if($practise['depending_practise_details']['question_type'] == "two_blank_table")
     @if(isset($practise['dependingpractise_answer'][0][0]))
       <table class="table">
       @foreach($practise['dependingpractise_answer'][0][0] as $k => $val)
        @if($k == 0)
         <thead>
           <tr class="table-row thead-dark d-flex justify-content-between">
              <th class="d-flex justify-content-center th w-50">{{isset($val['col_1'])?$val['col_1']:''}}</th>
              <th class="d-flex justify-content-center th w-50">{{isset($val['col_1'])?$val['col_2']:''}}</th>
           </tr>
         </thead>
         <tbody>
        @else
           <tr class="table-row thead-dark d-flex justify-content-between">
              <td class="d-flex justify-content-center border td  w-50">{{isset($val['col_1'])?$val['col_1']:''}}</td>
              <td class="d-flex justify-content-center border td  w-50">{{isset($val['col_1'])?$val['col_2']:''}}</td>
           </tr>
        @endif
       @endforeach
         </tbody>
       </table>
       <br>
     @endif
   @endif
  @endif
  <!--------------------------------------------------------------->
<form class="save_listening_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practise_type" name="practice_type" value="{{$practise['type']}}">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

  <!-- /. Component Audio Player -->
  	<div class="audio-player">
		<audio preload="auto" controls controlsList="nodownload">
			<source src="{{ $practise['audio_file'] }}" type="audio/mp3" >
		</audio>
	</div>
  <!-- /. Component Audio Player END-->
  <!-- /. Component Listening Player -->
  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
<!--   <ul class="list-inline list-buttons">
    <li class="list-inline-item">
        <input type="button" class="btnsavelistening_{{$practise['id']}} btn btn-secondary" value="Save" data-is_save="0">
    </li>
    <li class="list-inline-item">
        <input type="button" class="btnsavelistening_{{$practise['id']}} btn btn-secondary" value="Submit" data-is_save="1">
    </li>
</ul> -->
</form>
<script>
  var token = $('meta[name=csrf-token]').attr('content');
	var upload_url = "{{url('upload-audio')}}";
	var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
	$('.delete-icon').on('click', function() {
		$('.practice_audio').attr('src','');
		$(document).find('.stop-button').hide();
		$('.audioplayer-bar-played').css('width','0%');
		$('.delete-icon').hide();
		$('div.audio-element').css('pointer-events','none');
		$('.submitBtn').attr('disabled','disabeld');
		var practise_id = $('.practise_id:hidden').val();
		$.ajax({
	      url: '<?php echo URL('delete-audio'); ?>',
	      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	      type: 'POST',
	      data: {practice_id:practise_id},
	      success: function (data) {

	      }
	  });
 	});
</script>

<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<script>
  jQuery(function ($) {
    'use strict'
    var supportsAudio = !!document.createElement('audio').canPlayType;
    if (supportsAudio) {
        // initialize plyr
        var i;

           var player = new Plyr('audio', {
            controls: [

                'play',
                'progress',
                'current-time',

            ]
        });


    } else {
        // no audio support
        $('.column').addClass('hidden');
        var noSupport = $('#audio1').text();
        $('.container').append('<p class="no-support">' + noSupport + '</p>');
    }
  });
</script>
<script>

  $(document).on('click',".btnsavelistening_{{$practise['id']}}" ,function() {
    // $("#feedback_{{$practise['id']}}").modal('show');
    // return false;

    $(".btnsavelistening_{{$practise['id']}}").attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);
    //setTextareaContent();
    $.ajax({
        url: "{{url('save_listening')}}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $(".save_listening_form_{{$practise['id']}}").serialize(),
        success: function (data) {
          $(".btnsavelistening_{{$practise['id']}}").removeAttr('disabled');
          $('.alert-success').show().html(data.message).fadeOut(4000);

        }
    });
  });
</script>
@if(isset($practise['id']))
@if($practise['id'] == "1666012725634d5635dea54" || $practise['id'] == "16656595856347f2c118a12")
<script>
  if(data13==undefined ){
    var data13=[];
  } 
  data13["{{$practise['id']}}"]= {"dependentpractice_ans": "{{$data[$practise['id']]['dependentpractice_ans']}}" };
  data13["{{$practise['id']}}"]["isRolePlayPractice"] = "{{$data[$practise['id']]['isRolePlayPractice']}}"
  data13["{{$practise['id']}}"]["is_dependent"] = "{{$data[$practise['id']]['is_dependent']}}"; 
  if(data13["{{$practise['id']}}"]["is_dependent"]==1){
    if(data13["{{$practise['id']}}"]["dependentpractice_ans"]==0 ){
      $(".previous_practice_answer_exists_{{$practise['id']}}").hide();
      $("#dependant_pr_{{$practise['id']}}").show();
    } else {
      $(".previous_practice_answer_exists_{{$practise['id']}}").show();
      $("#dependant_pr_{{$practise['id']}}").hide();
    }
  } else {
    $(".previous_practice_answer_exists_{{$practise['id']}}").show();
    $("#dependant_pr_{{$practise['id']}}").hide();
  }

  
</script>

@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==0 && $practise['typeofdependingpractice']!='get_answers_generate_quetions' )
<script>

  data13["{{$practise['id']}}"]["typeofdependingpractice"] = "{{ $data[$practise['id']]['typeofdependingpractice'] }}";
  data13["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
  if(data13["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data13["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data13["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data13["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data13["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data13["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data13["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view"){
    
    data13["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
    data13["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
    $(function () {
      $('.cover-spin').fadeIn();
    });
    if(data13["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
       

      // IF DEPENDENT PRACTICE BELONGS TO SAME TASK THEN USE BELOW CODE.
      if(data13["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
        
         
         setTimeout(function(){ 
         
           data13["{{$practise['id']}}"]["prevHTML"] = $(document).find('#abc-'+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();         
         
          $(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).html(data13["{{$practise['id']}}"]["prevHTML"]);
          $(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
          $(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
          $(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert').remove();

          if( data13["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" ){
            if(data13["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_no_blanks_listening_speaking_down"  || data13["{{$practise['id']}}"]["dependant_practise_question_type"]== "single_speaking_up_writing" ) {
              $(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('.audio-player').remove();
              $(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
            }
          } 
          $('.cover-spin').fadeOut();
         }, 8000 )
      }
    } else {
    
      // IF DEPENDENT PRACTICE BELONGS TO PREVIOUS TASK THEN USE BELOW CODE.
      // DO NOT REMOVE BELOW   CODE
      var baseUrl = "{{url('/')}}";
      data13["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
      data13["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data13["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data13["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data13["{{$practise['id']}}"]["dependant_practise_id"];
      $.get(data13["{{$practise['id']}}"]["dependentURL"],  //
      function (dataHTML, textStatus, jqXHR) {  // success callback
        setTimeout(function(){
          data13["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
          $(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).html(data13["{{$practise['id']}}"]["prevHTML"]);
          $(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
          $(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, .alert, input:hidden').remove();
          
          if(data13["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero" ){
            
            if(data13["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_no_blanks_listening_speaking_down" || data13["{{$practise['id']}}"]["dependant_practise_question_type"]== "single_speaking_up_writing") {
              $(document).find(".showPreviousPractice_"+data13["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
            }
          }
          $('.cover-spin').fadeOut();
        },8000)
        
      });
    }
  }  
</script>
@endif
@endif
@endif