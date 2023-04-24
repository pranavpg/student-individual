        
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
      
        <div class="alert alert-success" role="alert" style="display:none"></div>
				<div class="alert alert-danger" role="alert" style="display:none"></div>
        <ul class="list-inline list-buttons">
            <li class="list-inline-item">
              <!-- <a href="#!" class="btn btn-primary"
                    data-toggle="modal" data-target="#exitmodal">Save</a> -->
                    <input type="button" class="save_btn single_tick_btn_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
            </li>
            <li class="list-inline-item">
             <input type="button" class="submit_btn single_tick_btn_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">

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
      <script src="{{ asset('public/js/audioplayer.js') }}"></script>
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
      $(document).on('click',".single_tick_btn_{{$practise['id']}}" ,function() {

        if($(this).attr('data-is_save') == '1'){
            $(this).closest('.active').find('.msg').fadeOut();
        }else{
            $(this).closest('.active').find('.msg').fadeIn();
        }
        
        var reviewPopup = '{!!$reviewPopup!!}';
        var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){
                    var fullView= $(".save_single_tick_form_{{$practise['id']}}").html();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
                }
            }
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){

                $("#reviewModal_{{$practise['id']}}").modal('toggle');

            }
        $(".single_tick_btn_{{$practise['id']}}").attr('disabled','disabled');
        var is_save = $(this).attr('data-is_save');
        $('.is_save:hidden').val(is_save);
        // setTextareaContent();
        $.ajax({
            url: "{{url('save-single-tick')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: $(".save_single_tick_form_{{$practise['id']}}").serialize(),
            success: function (data) {
              $(".single_tick_btn_{{$practise['id']}}").removeAttr('disabled');

              if(data.success){
                $('.alert-danger').hide();
                $('.alert-success').show().html(data.message).fadeOut(8000);
              }else{
                $('.alert-success').hide();
                $('.alert-danger').show().html(data.message).fadeOut(8000);
              }
                
            }
        });

      });

    //   $( document ).ready(function() {
    //     var practise_id=$(".save_single_tick_form_{{$practise['id']}}").find('.depend_practise_id').val();
    //     if(practise_id){
    //         var x = getDependingPractise() ; 
           
    //     }
         

    //     function getDependingPractise(){
          
    //       var topic_id= $(".save_single_tick_form_{{$practise['id']}}").find('.topic_id').val();
    //       var task_id=$(".save_single_tick_form_{{$practise['id']}}").find('.depend_task_id').val();
    //       var practise_id=$(".save_single_tick_form_{{$practise['id']}}").find('.depend_practise_id').val();
  
    //           $.ajax({
    //               url: "{{url('get-student-practisce-answer')}}",
    //               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //               type: 'POST',
    //               data:{
    //                   topic_id,
    //                   task_id,
    //                   practise_id
    //               },
    //               dataType:'JSON',
    //               success: function (data) {
    //                   if(data['success'] == false){
    //                     $("#dependant_pr_{{$practise['id']}}").css("display", "block");
    //                     $("#multipul_check_{{$practise['id']}}").css("display", "none");
    //                     //  $("#multi_choice_btn_{{$practise['id']}}}").css("display", "none");
    //                   }else{
    //                     $("#dependant_pr_{{$practise['id']}}").css("display", "none");
    //                     $("#multipul_check_{{$practise['id']}}").css("display", "block");
    //                     // $("#multi_choice_btn_{{$practise['id']}}").css("display", "block");
    //                   }
    //                   var result =  document.location +data.user_Answer;
                      
    //                 //   console.log('====>',data);
    //                   var res = result.split(";");
    //                 var i =0;
    //                 $.each(res, function( index, value ) {
    //                     if(value !==""){
    //                         value = value.replace(document.location, "");
    //                         // alert( value ); 
    //                         $("#span_multi_choice_"+i).html("<b><font color = '#03A9F4'>"+value+"</font></b>");
    //                         $("#dependan_answer_"+i).val("<b><font color = '#03A9F4'>"+value+"</font></b>");
    //                         i= i+1;
    //                     }
                        
    //                 });
    //               }
    //           });
    //     }
      

           
     //});
</script>
