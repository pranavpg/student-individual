
<p>
	<strong> {!! $practise['title'] !!}</strong>
</p>
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
                <input type="text" class="form-control writeingBox" placeholder="Write here..." name="writeingBox[]" id="writeingBox_{{$i}}" value="<?php if(isset($practise['user_answer']) && !empty($practise['user_answer'][$usrAns][$i]) ){ echo $practise['user_answer'][$usrAns][$i];} ?>">
            </div>
            <?php $i++; ?>
            @endforeach
   <div class="alert alert-success" role="alert" style="display:none">
    This is a success alert—check it out!
  </div>
</form>
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
              $('.column').addClass('hidden');
              var noSupport = $('#audio1').text();
              $('.container').append('<p class="no-support">' + noSupport + '</p>');
          } 
    }
  jQuery(function ($) {
        'use strict'
        var supportsAudio = !!document.createElement('audio').canPlayType;
        if (supportsAudio) {
            var i;
               var player = new Plyr("#audio_{{$practise['id']}}", {
                controls: [
                    'play',
                    'progress',
                    'current-time',
                ]
            });
        } else {
            $('.column').addClass('hidden');
            var noSupport = $('#audio1').text();
            $('.container').append('<p class="no-support">' + noSupport + '</p>');
        }
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<!-- <script src="{{ asset('public/js/audioplayer.js') }}"></script> -->
