
<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">

<p>
	<strong> {!! $practise['title'] !!}</strong>
</p>
<?php
// echo "<pre>";
// print_r($practise);die;
?>
      	<form class="save_write_at_end_up_listening_form_{{$practise['id']}}">
          <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
          <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
          <input type="hidden" class="is_save" name="is_save" value="">
          <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

					@if( !empty( $practise['audio_file'] ) )
					  @include('practice.common.audio_player')
					@endif

              <?php $exploded_question  =  explode(PHP_EOL, $practise['question']); $i=0;
              if( isset($practise['user_answer']) && !empty($practise['user_answer'])){
                $usrAns = count($practise['user_answer']) - 1;
              }else{
                $usrAns=0;
              }
              ?>
                @foreach($exploded_question as $item)
                  <div class="form-group d-flex align-items-end form-group-label">
                      <span class="label">
                        <?php echo str_replace('@@','',$item);?>
                      </span>
                      <input type="text" class="form-control writeingBox" placeholder="Write here..." name="writeingBox[]" id="writeingBox_{{$i}}" autocomplete="off" value="<?php if(isset($practise['user_answer']) && !empty($practise['user_answer'][$usrAns][$i]) ){ echo $practise['user_answer'][$usrAns][$i];} ?>">
                  </div>
                  <?php $i++; ?>
                  @endforeach

         <div class="alert alert-success" role="alert" style="display:none">
          This is a success alert—check it out!
        </div>
        <!-- <input type="button" class="writeAtendUpLisBtn_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
        <input type="button" class="writeAtendUpLisBtn_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1"> -->

        <ul class="list-inline list-buttons">
          <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn writeAtendUpLisBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"
                  data-toggle="modal" data-is_save="0" data-target="#exitmodal"  >Save</button>
          </li>
          <li class="list-inline-item"><button type="button"
                  class="submit_btn btn btn-primary submitBtn writeAtendUpLisBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1" >Submit</button>
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
<script>
	var save_three_blank_table_url = "{{url('save-write-atend-up')}}";
	var get_three_blank_table_url = "{{url('get-student-practisce-answer')}}";
</script>
<script>
    var player = "";
    function Audioplay(pid){
   
      var supportsAudio = !!document.createElement('audio').canPlayType;
      if (supportsAudio) {
        $('.modal').find('.plyr__controls:first').remove()
              var i;
              player = new Plyr(".modal .audio_"+pid, {
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



  jQuery(function ($) {
        'use strict'
        var supportsAudio = !!document.createElement('audio').canPlayType;
        if (supportsAudio) {
            // initialize plyr
            var i;

               var player = new Plyr("#audio_{{$practise['id']}}", {
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
        //     $('audio').audioPlayer();
        // });
        $(document).on('click',".writeAtendUpLisBtn_{{$practise['id']}}" ,function() {

          if($(this).attr('data-is_save') == '1'){
              $(this).closest('.active').find('.msg').fadeOut();
          }else{
              $(this).closest('.active').find('.msg').fadeIn();
          }

                  
          var reviewPopup = '{!!$reviewPopup!!}';
          var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
                    var fullView= $(".save_write_at_end_up_listening_form_{{$practise['id']}}").clone();
				          	$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
					          $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.writeAtendUpLisBtn_{{$practise['id']}}').remove();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.writeingBox').attr("disabled",true);
                    Audioplay("{{$practise['id']}}")
                }
            }
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){

                $("#reviewModal_{{$practise['id']}}").modal('toggle');

            }
            $(".writeAtendUpLisBtn_{{$practise['id']}}").attr('disabled','disabled');
            var is_save = $(this).attr('data-is_save');
            $('.is_save:hidden').val(is_save);
            //console.log($('.save_write_at_end_up_listening_form').serialize());
            $.ajax({
                url: save_three_blank_table_url,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                data: $('.save_write_at_end_up_listening_form_{{$practise["id"]}}').serialize(),
                success: function (data) {
                  $(".writeAtendUpLisBtn_{{$practise['id']}}").removeAttr('disabled');

                    $('.alert-success').show().html(data.message).fadeOut(8000);

                }
            });

       });
    </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<!-- <script src="{{ asset('public/js/audioplayer.js') }}"></script> -->
