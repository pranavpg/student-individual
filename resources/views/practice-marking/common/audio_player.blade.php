
<style type="text/css">
    .plyr__control{
        pointer-events: auto;
    }
</style>
<div class="audio-player">
    <audio preload="none" controls  src="<?php echo $practise['audio_file'];?>"  type="audio/mp4" class="audio_{{$practise['id']}}" style="pointer-events: auto;"></audio>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>

<script>jQuery(function ($) {
        'use strict'
        var supportsAudio = !!document.createElement('audio').canPlayType;
        if (supportsAudio) {
            // initialize plyr
            var i;

               var player = new Plyr(".audio_{{$practise['id']}}", {
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
