
<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">

        <p>
          <strong><?php
          echo $practise['title'];
          ?></strong>
          <?php //dd($practise)//echo '<pre>'; print_r($practise); ?>
        </p>
          <form class="save_true_false_listening_simple_form_{{$practise['id']}}">
          <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
          <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
          <input type="hidden" class="is_save" name="is_save" value="">
          <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
          <?php if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
                $depend =explode("_",$practise['dependingpractiseid']); 
          ?>
                 <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
                 <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
                 <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
                    <p style="margin: 15px;">In order to do this task you need to have completed <strong style="color:#e0790b">Task <?php echo $depend[2]; ?></strong> <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                </div>
           <?php  } ?>
             <!-- /. Component Audio Player -->
             @if( !empty( $practise['audio_file'] ) )
					  @include('practice.common.audio_player')
		    @endif
            <!-- /. Component Audio Player END-->
            <?php 
                if(!isset($practise['dependingpractiseid'])){
                    if(isset($practise['question']) && !empty($practise['question'])){
                        $exploded_question  =  explode(PHP_EOL, $practise['question']); ?>
                        @foreach($exploded_question as $k => $question)
                            <div class="true-false">
                                <div class="box box-flex align-items-center">
                                    <div class="box__left flex-grow-1">
                                        <p>{{str_replace('@@','',$question)}} </p>
                                    
                                    </div>
                                    <div class="true-false_buttons">
                                        <div class="form-check form-check-inline">
                                        <input type="hidden" name="userans[{{$k}}][question]" value="{{$question}}">
                                        
                                            <input class="form-check-input" type="radio"
                                                name="userans[{{$k}}][true_false]" id="inlineRadioTrue_{{$k}}" value="1" {{ isset($practise['user_answer'][0][$k]['true_false']) && !empty($practise['user_answer'][0][$k]['true_false']) && $practise['user_answer'][0][$k]['true_false'] == '1' ?  'checked' :  " " }}>
                                            <label class="form-check-label" for="inlineRadioTrue_{{$k}}">True</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                name="userans[{{$k}}][true_false]" id="inlineRadiofalse_{{$k}}" value="0" {{ isset($practise['user_answer'][0][$k]['true_false'])  && $practise['user_answer'][0][$k]['true_false'] == '0' ?  'checked' :  '' }}>
                                            <label class="form-check-label" for="inlineRadiofalse_{{$k}}">False</label>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        @endforeach
                    <?php
                    }


            }else{
                        $exploded_question  =  explode(PHP_EOL, $practise['depending_practise_details']['question']);

                        $ans  =  !empty($practise['dependingpractise_answer'])?$practise['dependingpractise_answer'][0]:[];

                            $newaaa = array();
                            foreach($ans as $k => $val){
                                if($val['ans'] ==""){
                                    //nothing too do 
                                }else{
                                    $newaaa[$k] = $val;
                                }
                            }
                            $test = array_keys($newaaa);
                            $qew =array();
                            foreach($exploded_question as $key=>$dd){
                                if(in_array($key,$test))
                                {
                                  $qew[$key] = $dd;
                                }
                            } 
                        // dd($qew);
                        if(!empty($newaaa)){ ?>
                            @foreach($qew as $k => $question)
                                <div class="true-false">
                                    <div class="box box-flex align-items-center">
                                        <div class="box__left flex-grow-1">
                                            <p>{{str_replace('@@',!empty($newaaa)?' : '.$newaaa[$k]['ans']:'',$question)}} </p>
                                        </div>
                                        <div class="true-false_buttons">
                                            <div class="form-check form-check-inline">
                                            <input type="hidden" name="userans[{{$k}}][question]" value="{{$question}}">
                                            
                                                <input class="form-check-input" type="radio"
                                                    name="userans[{{$k}}][true_false]" id="inlineRadioTrue_{{$k}}" value="1" {{ isset($practise['user_answer'][0][$k]['true_false']) && !empty($practise['user_answer'][0][$k]['true_false']) && $practise['user_answer'][0][$k]['true_false'] == '1' ?  'checked' :  " " }}>
                                                <label class="form-check-label" for="inlineRadioTrue_{{$k}}">True</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    name="userans[{{$k}}][true_false]" id="inlineRadiofalse_{{$k}}" value="0" {{ isset($practise['user_answer'][0][$k]['true_false'])  && $practise['user_answer'][0][$k]['true_false'] == '0' ?  'checked' :  '' }}>
                                                <label class="form-check-label" for="inlineRadiofalse_{{$k}}">False</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            @endforeach
                    <?php
                        }else{
                            $depend =explode("_",$practise['dependingpractiseid']);
                            ?>
                                     <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
                                     <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
                                     <div id="dependant_pr_{{$practise['id']}}" style=" border: 2px dashed gray; border-radius: 12px;">
                                        <p style="margin: 15px;">In order to do this task you need to have completed <strong style="color:#e0790b">Task <?php echo $depend[2]; ?></strong> <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                                    </div><br>
                                    <script type="text/javascript">
                                        setTimeout(function(){

                                        $('.audio-player').fadeOut();
                                        $('.submitbuttons').fadeOut();
                                        },600)
                                    </script>
                        <?php } 
            } 
            ?>
            
        <div class="alert alert-success" role="alert" style="display:none">
            This is a success alert—check it out!
        </div>
        
        <div class="alert alert-danger" role="alert" style="display:none"></div>
        <ul class="list-inline list-buttons submitbuttons">
            <li class="list-inline-item">
              <!-- <a href="#!" class="btn btn-primary"
                    data-toggle="modal" data-target="#exitmodal">Save</a> -->
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
      <script>jQuery(function ($) {
        'use strict'
        var supportsAudio = !!document.createElement("#audio_plyr_{{$practise['id']}}").canPlayType;
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
         
    // $(function () {
    //           $('audio').audioPlayer();

    //       });
    //       function setTextareaContent(){
    //       $("span.textarea.form-control").each(function(){
    //         var currentVal = $(this).html();
    //         $(this).next().find("textarea").val(currentVal);
    //       })
    //     }
      $(document).on('click',".trueFalseLisSymbol_{{$practise['id']}}" ,function() {

        var reviewPopup = '{!!$reviewPopup!!}';
        var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
                    var fullView= $(".save_true_false_listening_simple_form_{{$practise['id']}}").clone();
          					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
          					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
          					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
          					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.true-false_buttons').css('pointer-events',"none");
                    AudioplayPopup("{{$practise['id']}}")
                    function AudioplayPopup(pid){ 
                       
   
                        var supportsAudio = !!document.createElement('audio').canPlayType;
                        if (supportsAudio) {
                            $('.modal').find('.plyr__controls:first').remove()
                                var i;
                                var player = new Plyr(".modal .audio_"+pid, {
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
                }
            }
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){

                $("#reviewModal_{{$practise['id']}}").modal('toggle');

            }
        $(".trueFalseLisSymbol_{{$practise['id']}}").attr('disabled','disabled');
        var is_save = $(this).attr('data-is_save');
        $('.is_save:hidden').val(is_save);
        // setTextareaContent();
        $.ajax({
            url: "{{url('save-true-false-listening-simple')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: $(".save_true_false_listening_simple_form_{{$practise['id']}}").serialize(),
            success: function (data) {
              $(".trueFalseLisSymbol_{{$practise['id']}}").removeAttr('disabled');

              if(data.success){
					$(".save_true_false_listening_simple_form_{{$practise['id']}}").find('.alert-danger').hide();
					$(".save_true_false_listening_simple_form_{{$practise['id']}}").find('.alert-success').show().html(data.message).fadeOut(8000);
				} else {
					$(".save_true_false_listening_simple_form_{{$practise['id']}}").find('.alert-success').hide();
					$(".save_true_false_listening_simple_form_{{$practise['id']}}").find('.alert-danger').show().html(data.message).fadeOut(8000);
				}
                
            }
        });

      });
   /*   $( document ).ready(function() {
        var practise_id=$(".save_true_false_listening_simple_form_{{$practise['id']}}").find('.depend_practise_id').val();
        if(practise_id){
            var x = getDependingPractise() ; 
           
        }
         

        function getDependingPractise(){
          
          var topic_id= $(".save_true_false_listening_simple_form_{{$practise['id']}}").find('.topic_id').val();
          var task_id=$(".save_true_false_listening_simple_form_{{$practise['id']}}").find('.depend_task_id').val();
          var practise_id=$(".save_true_false_listening_simple_form_{{$practise['id']}}").find('.depend_practise_id').val();
  
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
                        $("#true_false_{{$practise['id']}}").css("display", "none");
                        $("#audio_plyr_{{$practise['id']}}").css("display", "none");
                      }else{
                        $("#dependant_pr_{{$practise['id']}}").css("display", "none");
                        $("#true_false_{{$practise['id']}}").css("display", "block");
                        $("#audio_plyr_{{$practise['id']}}").css("display", "block");
                      }
                      var result =  document.location +data.user_Answer;
                      
                    //   console.log('====>',data);
                      var res = result.split(";");
                    var i =0;
                    $.each(res, function( index, value ) {
                        if(value !==""){
                            value = value.replace(document.location, "");
                            // alert( value ); 
                            $("#span_true_false_"+i).html("<b><font color = '#03A9F4'>"+value+"</font></b>");
                            $("#dependan_answer_"+i).val("<b><font color = '#03A9F4'>"+value+"</font></b>");
                            i= i+1;
                        }
                        
                    });
                  }
              });
        }
      

           
    });*/
     
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<!-- <script src="{{ asset('public/js/audioplayer.js') }}"></script> -->