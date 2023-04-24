<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
          <p>
          <strong><?php
          echo $practise['title'];
          ?></strong>
        </p>
          <form class="save_multi_tick_form_{{$practise['id']}}">
          <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
          <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
          <input type="hidden" class="is_save" name="is_save" value="">
          <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
          @if( !empty( $practise['audio_file'] ) )
					  @include('practice.common.audio_player')
					@endif

          <?php
          //echo '<pre>'; print_r($practise);
          if(strpos($practise['question'],' #@')){
            $class= 'multiple-check';
            $checkSize=" ";
            $practise['question'] =  str_replace("1 #@","@@",$practise['question']);
            $exploded_question  =  explode("@@", $practise['question']);
          }else{
            $class='multiple-check d-flex flex-wrap';
            $checkSize="w-25";
            if(isset($practise['options']) && !empty($practise['options'])){
              foreach($practise['options'] as $item){
                $exploded_question[] = $item[0];
              }
            }else{
              $exploded_question  =  explode("@@", $practise['question']);

            }
          }
            $i=1;
             //echo '<pre>'; print_r($practise);
           ?>
            <div class="{{$class}}">
          @if(isset($practise['user_answer'][0]) && !empty($practise['user_answer'][0]))
              @foreach($practise['user_answer'][0] as $item)
                  <div class="custom-control custom-checkbox {{$checkSize}} col-12 col-sm-6 col-md-3 col-lg-5 col-xl-4">
                      <input type="checkbox" class="custom-control-input cbox_{{$practise['id']}}" id="cc{{$i}}"   name="checkBox[]" value="{{$item['name']}}" <?php if($item['checked']==true){echo "checked"; } ?>>
                      <label class="custom-control-label" for="cc{{$i}}">
                     <?php echo $item['name']; ?></label>
                          <input type="hidden" name="question[]" value="{{$item['name']}}">
                  </div>
                  <?php $i++;?>
              @endforeach
          @else
            @foreach($exploded_question as $item)
              @if(!empty($item))
                  <div class="custom-control custom-checkbox {{$checkSize}} col-12 col-sm-6 col-md-3 col-lg-5 col-xl-4">
                      <input type="checkbox" class="custom-control-input cbox_{{$practise['id']}}" id="cc{{$i}}"   name="checkBox[]" value="{{$item}}">
                      <label class="custom-control-label" for="cc{{$i}}">
                      <?php echo $item ?> </label>
                          <input type="hidden" name="question[]" value='{{$item}}'>
                  </div>
                  <?php $i++;?>
                  @endif
              @endforeach
          @endif
          </div>

          <div class="alert alert-success" role="alert" style="display:none"></div>
				  <div class="alert alert-danger" role="alert" style="display:none"></div>
        <ul class="list-inline list-buttons">
            <li class="list-inline-item">
              <!-- <a href="#!" class="btn btn-primary"
                    data-toggle="modal" data-target="#exitmodal">Save</a> -->
                    <input type="button" class="save_btn multiTickBtn_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
            </li>
            <li class="list-inline-item">
             <input type="button" class="submit_btn multiTickBtn_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">

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
      $(document).on('click','.cbox_{{$practise["id"]}}',function(){
         var getid = this.id;
         var getcheckbox = $(".save_multi_tick_form_{{$practise['id']}}").find("#"+getid);
         if(getcheckbox.prop('checked') == true)
         {             
             $('#'+getid).attr('checked',true);
         }
         else
         {
             $('#'+getid).removeAttr('checked');
         }
      });
    //----------------------------------------------------------------------------------------------------------------------
      $(document).on('click',".multiTickBtn_{{$practise['id']}}" ,function() {
        if($(this).attr('data-is_save') == '1'){
            $(this).closest('.active').find('.msg').fadeOut();
        }else{
            $(this).closest('.active').find('.msg').fadeIn();
        }

        var reviewPopup = '{!!$reviewPopup!!}';
       var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){
                    var fullView= $(".save_multi_tick_form_{{$practise['id']}}").html();
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

        $(".multiTickBtn_{{$practise['id']}}").attr('disabled','disabled');
        var is_save = $(this).attr('data-is_save');
        $('.is_save:hidden').val(is_save);
        // setTextareaContent();
        $.ajax({
            url: "{{url('save-multiple-tick')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: $(".save_multi_tick_form_{{$practise['id']}}").serialize(),
            success: function (data) {
              $(".multiTickBtn_{{$practise['id']}}").removeAttr('disabled');

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
</script>
 

<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>



<script src="{{ asset('public/js/audioplayer.js') }}"></script>
