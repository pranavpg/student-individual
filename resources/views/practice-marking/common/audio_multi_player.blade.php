
<?php
$recordKey = !empty($key)?$key:0;
$recordpath = !empty($path)?$path:0;

  if(!empty($practise['user_answer'])){
   
    $prac['user_answer'] = !empty($audio_user_answer)?$audio_user_answer:$practise['user_answer'];
  }
  ?>
<div class="audio-player">
    <audio preload="none" controls  src="<?php echo $recordpath;?>"  type="audio/mp4" id="audio_{{$practise['id']}}_{{$recordKey}}"></audio>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>

<script>jQuery(function ($) {
        'use strict'
        var supportsAudio = !!document.createElement('audio').canPlayType;
        if (supportsAudio) {
            // initialize plyr
            var i;

               var player = new Plyr("#audio_{{$practise['id']}}_{{$recordKey}}", {
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
