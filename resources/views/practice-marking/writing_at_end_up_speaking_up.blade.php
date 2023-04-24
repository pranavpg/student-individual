<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
  	$user_ans = "";
  	$answerExists = false;
  	if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
      $answerExists = true;
      if(!empty($practise['is_roleplay']) && $practise['is_roleplay']==1){
        $answers = $practise['user_answer'];
        $new_answer = array_values(array_filter($answers,
            function($item) {
              return strpos($item, '##') === false;
            }));
        $practise['user_answer'] = $new_answer;
      }
    }
	$data[$practise['id']] = array();
	$data[$practise['id']]['isRolePlayPractice'] = (!empty($practise['is_roleplay']) &&  $practise['is_roleplay']==1)?1:0;
	$data[$practise['id']]['typeofdependingpractice'] = !empty($practise['typeofdependingpractice']) ? $practise['typeofdependingpractice'] : "";
	$data[$practise['id']]['setFullViewFromPreviousPractice'] = !empty($practise['depending_practise_details']['dependant_practise_id']) ? $practise['depending_practise_details']['dependant_practise_id']:"";
	$data[$practise['id']]['dependant_practise_topic_id'] = !empty($practise['depending_practise_details']['dependant_practise_topic_id']) ? $practise['depending_practise_details']['dependant_practise_topic_id']:"";
	$data[$practise['id']]['dependant_practise_task_id'] = !empty($practise['depending_practise_details']['dependant_practise_task_id']) ? $practise['depending_practise_details']['dependant_practise_task_id']:"";
	$data[$practise['id']]['dependant_practise_question_type'] = !empty($practise['depending_practise_details']['question_type']) ? $practise['depending_practise_details']['question_type']:"";
	$data[$practise['id']]['dependentpractice_ans'] = !empty($practise['dependingpractise_answer'])?1:0;
	$data[$practise['id']]['is_dependent'] = !empty($practise['is_dependent']) ? 1 : 0;
	$style="";
	
	if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) ){
  		$depend =explode("_",$practise['dependingpractiseid']);
		  $style= "display:none"; 
?>
		<div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; display:none">
			<p style="margin: 15px;">In order to do this task you need to have completed
			<strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
		</div>
<?php
  	} 
		$exploded_question = explode(PHP_EOL,$practise['question']);
?>

<div class="previous_practice_answer_exists_{{$practise['id']}}" style="display:none">
  @if($data[$practise['id']]['typeofdependingpractice']=='set_full_view_hide_show')
		<div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
			<a href="javascript:;" class="btn btn-dark selected_option_hide_show ">Show View</a>
		</div>
	@endif
  @if(!empty($practise['is_roleplay']) && $practise['is_roleplay']==1)
    @include('practice.speaking_multiple_up_roleplay')
	@else
    <div class="showPreviousPractice_{{$data[$practise['id']]['setFullViewFromPreviousPractice']}}">
		</div>
    <form class="form_{{$practise['id']}}">
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

        @if($practise['type']=='writing_at_end_up_speaking_up')
          @include('practice.common.audio_record_div',['key'=>0])
        @endif
      <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="writing_at_end_up_speaking_up" value="0">
      <div class="multiple-choice mb-4">
        @if(!empty($exploded_question))
        <?php $i=0; ?>
          @foreach($exploded_question as $key => $value)
            <div class="box row d-flex align-items-end mb-4">
              @if(!empty(trim($value)) )
                @if(str_contains($value,'@@'))
                    <div class="col-12 col-md-12 choice-box-left">
                        <p>{!!trim(str_replace('@@','',$value)) !!} </p> 
                    </div>
                   @if(isset($practise['typeofdependingpractice'][0]) && $practise['typeofdependingpractice'] == 'get_answers_put_into_answers')
                        @php
                       // $answer="";
                        if(isset($practise['dependingpractise_answer'][0][$key])){
                          $answer = $practise['dependingpractise_answer'][0][$key];
                        }
                       // echo $answer;
                        @endphp
                    @else
                      @php  $answer=""; @endphp 
                    @endif
                    @if(isset($practise['user_answer'][0]['text_ans'][$i]) && !empty($practise['user_answer'][0]['text_ans'][$i]))
                      @php $answer="";  $answer = str_replace(" ","&nbsp;",$practise['user_answer'][0]['text_ans'][$i]);  @endphp
                    @endif                    
                    <div class="col-12 {{ (strlen(trim(str_replace('@@','',$value)))>3)?'col-md-6':'col-md-12' }}  form-group mb-0">
                        <span class="textarea form-control form-control-textarea enter_disable" role="textbox" disabled contenteditable placeholder="Write here...">
                            <?php
                              if (isset($answer) && !empty($answer)) { echo $answer; }
                            ?> </span>
                            <div style="display:none">
                                <textarea name="text_ans[{{$i}}]">
                                    <?php
                                        if (isset($answer) && !empty($answer)) {                               
                                          echo  $answer;
                                          $answer="";
                                        }
                                    ?>
                                </textarea>
                            </div>
                    </div>
                  @else
                  <p>  {!!trim($value) !!}</p>
                  <input type="hidden" name="text_ans[{{$i}}]" value="">
                  @endif
                  <?php $i++; ?>
                @endif
            </div> 
          @endforeach
        @endif
      </div>
      @if($practise['type']=='writing_at_end_up_speaking')
        @include('practice.common.audio_record_div',['key'=>0])
      @endif
      <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="writing_at_end_up_speaking_up" value="0">
      <div class="alert alert-success" role="alert" style="display:none"></div>
      <div class="alert alert-danger" role="alert" style="display:none"></div>
    </form>
  @endif
</div>
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
<script>
var practice_type="{{$practise['type']}}";
var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
  if(data==undefined ){
    var data=[];
  }
	var token = $('meta[name=csrf-token]').attr('content');
	var upload_url = "{{url('upload-audio')}}";
	var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
  data["{{$practise['id']}}"]= {"dependentpractice_ans": "{{$data[$practise['id']]['dependentpractice_ans']}}" };
	data["{{$practise['id']}}"]["isRolePlayPractice"] = "{{$data[$practise['id']]['isRolePlayPractice']}}"
	data["{{$practise['id']}}"]["is_dependent"] = "{{$data[$practise['id']]['is_dependent']}}"; 
	if(data["{{$practise['id']}}"]["is_dependent"]==1){
		if(data["{{$practise['id']}}"]["dependentpractice_ans"]==0 ){
			$(".previous_practice_answer_exists_{{$practise['id']}}").hide();
			$("#dependant_pr_{{$practise['id']}}").show();
		} else {
			$(".previous_practice_answer_exists_{{$practise['id']}}").show();
			$("#dependant_pr_{{$practise['id']}}").hide();
		}
	} else{
    $(".previous_practice_answer_exists_{{$practise['id']}}").show();
			$("#dependant_pr_{{$practise['id']}}").hide();
  }
</script>
@if(!empty($practise['is_dependent']) && $practise['is_dependent']==1 && $data[$practise['id']]['isRolePlayPractice']==0 && $practise['typeofdependingpractice']!='get_answers_generate_quetions' )
<script>
	if(data["{{$practise['id']}}"]["dependentpractice_ans"]==1 ){
    data["{{$practise['id']}}"]["typeofdependingpractice"] = "{{ $data[$practise['id']]['typeofdependingpractice'] }}";
    data["{{$practise['id']}}"]["dependant_practise_question_type"]  = "{{ $data[$practise['id']]['dependant_practise_question_type'] }}";
    if(data["{{$practise['id']}}"]["typeofdependingpractice"] == "set_full_view_remove_top_zero" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_hide_show" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_parentextra" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_gen_que_double" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero_parentextra_get_questions_and_answers" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_remove_zero" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view_get_ans" || data["{{$practise['id']}}"]["typeofdependingpractice"] =="set_full_view"){
      data["{{$practise['id']}}"]["dependant_practise_task_id"] = "{{ $data[$practise['id']]['dependant_practise_task_id'] }}";
      data["{{$practise['id']}}"]["dependant_practise_id"] = "{{ $data[$practise['id']]['setFullViewFromPreviousPractice'] }}";
      if(data["{{$practise['id']}}"]["dependant_practise_task_id"] == "{{request()->segment(3)}}"){
        if(data["{{$practise['id']}}"]["dependant_practise_id"] !=""  ){
            setTimeout(function(){
              data["{{$practise['id']}}"]["prevHTML"] = $(document).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();				 
              $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(data["{{$practise['id']}}"]["prevHTML"]);
              $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
              $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons').remove();
              $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.alert').remove();
              $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find( 'input[type="hidden"]').remove();
            }, 2000)
            if( data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_top_zero"){
              if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "reading_blanks") {
                setTimeout(function(){
                  $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('.match-answer').remove();
                },1000)
              } 
            }
            if( data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
              if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_up_speaking_up") {
                setTimeout(function(){
                  $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
                },1000)
              } 
            }
            $('.cover-spin').fadeOut();
        }
      } else {
        var pid = "{{$practise['id']}}";
        // alert(pid);
        var baseUrl = "{{url('/')}}";
        data["{{$practise['id']}}"]["dependant_practise_topic_id"] = "{{ $data[$practise['id']]['dependant_practise_topic_id'] }}";
        data["{{$practise['id']}}"]["dependentURL"] = baseUrl+'/topic/'+data["{{$practise['id']}}"]["dependant_practise_topic_id"]+'/'+data["{{$practise['id']}}"]["dependant_practise_task_id"]+'?n='+data["{{$practise['id']}}"]["dependant_practise_id"]+'&user_id={{ isset($studentId)?$studentId:'' }}';
        $.get(data["{{$practise['id']}}"]["dependentURL"],  //
          function (dataHTML, textStatus, jqXHR) {  // success callback
          if(  data["{{$practise['id']}}"]["dependant_practise_id"]!==undefined){
          data["{{$practise['id']}}"]["prevHTML"] = $(dataHTML).find('.course-tab-content').find('#abc-'+data["{{$practise['id']}}"]["dependant_practise_id"]).find('form').html();
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).html(data["{{$practise['id']}}"]["prevHTML"]);
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).css('pointer-events','none');
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('ul.list-buttons, .alert').remove();
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find( 'input[type="hidden"]').remove();
            $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find( '.dependancyview').remove();
            if(pid == "15567071975cc9777dc6348"){
              $(document).find(".previous_practice_answer_exists_"+pid).find('form').css('pointer-events','auto');
            }

            if(data["{{$practise['id']}}"]["typeofdependingpractice"]=="set_full_view_remove_zero"){
              if(data["{{$practise['id']}}"]["dependant_practise_question_type"] == "writing_at_end_speaking_up") {
                $(document).find(".showPreviousPractice_"+data["{{$practise['id']}}"]["dependant_practise_id"]).find('fieldset').remove();
              }
            }
            $('.cover-spin').fadeOut();
          }
        });
        $.get("https://cdn.plyr.io/3.5.6/plyr.css");

      }
    } else {
      setTimeout(function(){
      },2000);
      function getSpeakingMultipleUpDependency(){
        var topic_id= $(".form_{{$practise['id']}}").find('.topic_id').val();
        var task_id=$(".form_{{$practise['id']}}").find('.depend_task_id').val();
        var practise_id=$(".form_{{$practise['id']}}").find('.depend_practise_id').val();
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
             
              if(data.question!=null && data.question!=undefined){
                $('.previous_practice_answer_exists_{{$practise["id"]}}').show();
                $('#dependant_pr_{{$practise['id']}}').hide();
                var question = data.question;
                var answer = data.user_Answer[0];
                console.log(answer);
                var question_array = question.split('\n');
                var str ="";
                var k=0;
                question_array.forEach((item, i) => {
                  if (item.includes( ' @@')){
                    str += `<div class="choice-box">
                              <p class="mb-0">`+item.replace('@@','')+`</p>
                                <div class="form-group">
                                  <span class="textarea form-control form-control-textarea" role="textbox" >`+answer[k]+`</span>
                                </div>
                              </div>`;
                              $k= k+1;
                  } else {
                        str += `  <p class="mb-0">` +item+ `</p>`;
                  }
                });
                str+='<br/>';
              } else {
                $('.previous_practice_answer_exists_{{$practise["id"]}}').hide();
                $('#dependant_pr_{{$practise['id']}}').show();
              }
            }
        });
        }
    }
  }
</script>
@endif
@if($data[$practise['id']]['typeofdependingpractice']=='set_full_view_hide_show')
<script>
$(".showPreviousPractice_{{$practise['id']}}").hide();
$(".selected_option_hide_show").click(function () {
      var text = $(this).text();
    $(this).text(
        	text == "Hide View" ? "Show View" : "Hide View"
		);
	$(".showPreviousPractice_{{$practise['id']}}").toggle();
});
 
</script>
@endif