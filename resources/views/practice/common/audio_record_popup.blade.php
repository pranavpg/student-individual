

  <style type="text/css">
    .recordModalButtonOpen {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        border-radius: 100%;
        background-color: #264B82;
    }
    .pauseBtn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        border-radius: 100%;
        background-color: #264B82;
    }
  </style>
  <script>

    var parentId = "";
    $(document).on('click', '.recordButton', function(){
        // $('.animated__mic__icon').show();   
    });

    $(document).on('click', '.close__modal', function(){
      var isRecording = $('.close__modal').attr('recording');
      if(isRecording=='1'){

        $('.stopButton').trigger('click')
      } else {
        $('.new-audio-record-modal').modal('toggle')
      }
    });
    $(document).on('click', '.recordModalButtonOpen', function(){
        if(!disableWhenRecord){
            alert("Please stop recording.")
            return;
        }
        counter=300;
        $('.active_recording').each(function(){
            $(this).removeClass("active_recording")
        })
        $(this).parent().hide();
        // $('.animated__mic__icon').hide();
        // $('.loader__icon').hide();
        $('.mic__icon').show();

        $('.close__modal').attr('recording',0);
        // $('.pauseButton').hide();
        // $('.stopButton').hide();

        $('.new-audio-record-modal').modal({
            backdrop: 'static',
            keyboard: false
        });
      var data_key = $(this).attr('data-key');
      parentId = data_key;
      var data_que = $(this).attr('data-q');
      var prid = $(this).attr('data-pid')
      //  $('.new-audio-record-modal').modal('toggle');
    /*  alert(parentId)
      alert(data_que)
      alert(prid)
      alert(data_key)
*/
      $(document).find('.deleted_audio_'+prid+'_'+data_key).val('0')
      // alert(data_key)
      $('.new__record__button-'+data_key).show();
      // $('.pause-'+data_key).show();
      $('.displayOnly-'+data_key).show();
      // $('.displayOnly-'+data_key).addClass("stopButton");
      // $('.displayOnly-'+data_key).addClass("new__stop__button");
      $('.new__record__button-'+data_key).attr('data-pid',prid );
      $('.new__record__button-'+data_key).addClass('active_recording');
      $('.new__record__button-'+data_key).attr('data-key', data_key );

      $('.new__record__button-'+data_key).attr('id', "record_audio"+data_key  )
      $('.audio__controls').find('img').removeClass('active');

      $('.new__stop__button-'+data_key).fadeIn();
      $('.new__stop__button-'+data_key).attr('data-pid', $(this).attr('data-pid') );
      $('.new__stop__button-'+data_key).attr('data-key', data_key );
      $('.new__stop__button-'+data_key).attr('id', "stop_recording"+data_key  );

      $('.new__pause__button-'+data_key).fadeIn();
      $('.new__pause__button-'+data_key).attr('data-pid', $(this).attr('data-pid') );
      $('.new__pause__button-'+data_key).attr('data-key', data_key );
      $('.new__pause__button-'+data_key).attr('id', "pause_recording"+data_key  );

      $('.new__resume__button-'+data_key).attr('data-pid', $(this).attr('data-pid') );
      $('.new__resume__button-'+data_key).attr('data-key', data_key );
      $('.new__resume__button-'+data_key).attr('id', "pause_recording"+data_key  );

      $('.audio__progress__success').css('width', '0%');
      $('.audio__progress__success').attr('data-width', 0);
      $('.audio__progress__remaining').css('width', '100%');
      $('.audio__progress__remaining').attr('data-width', 100);

      if( $.trim(data_que) != ""){
        $('.modal__question').show();
        $('.modal__question').html(data_que);
      } else{
        $('.modal__question').hide();
      }

    });

    $(document).on('click', '.new__record__button', function(){
      $('.close__modal').attr('recording',1);
      $('.mic__icon').hide();
      // $('.animated__mic__icon').show();
      $('.new__record__button').hide();
      $('.new__stop__button, .new__pause__button').show();

    });

    $(document).on('click', '.stopButton', function(){

        timer2  = "5:00";
        $('.countdown-'+parentId).css("display","none");
      $('.audio__controls').find('button').removeClass('active');
      $(this).addClass('active')
      // $('.animated__mic__icon').hide();
      // $('.mic__icon').hide();
      // alert("Asdasd")
      // $('.loader__icon').show();
      $('.new__stop__button-'+parentId).hide();
      $('.new__stop__button__old-'+parentId).hide();
      $('.new__record__button-'+parentId).hide();
      $('.new__pause__button-'+parentId).hide();
      $('.new__resume__button-'+parentId).hide();
      var data_key = $(this).attr('data-key' );
      var pid =$(this).attr('data-pid');
      
      $('.pause-'+parentId).hide();
      // alert(pid)
      // alert(data_key)
      $('.answer_audio-'+pid+'-'+data_key).parent().find('.audioplayer-playpause').css('display', 'flex')
      $('.mic-icon-'+data_key).hide();
      // $('.delete-recording-'+pid+'-'+data_key).show();


    });


    $(document).on('click', '.onlyPause', function(){
      // $('.animated__mic__icon').hide();
     /* $('.mic__icon').show();
      $('.new__pause__button-'+parentId).hide();
      $('.new__resume__button-'+parentId).show();

      $('.displayOnly-'+parentId).hide();
      $('.displayOnlyOld-'+parentId).show();*/
    });


    $(document).on('click', '.pauseresume', function(){
      /*$('.mic__icon').hide();
      // $('.animated__mic__icon').show();
      $('.new__resume__button-'+parentId).hide();
      $('.new__pause__button-'+parentId).show();
      
      $('.displayOnly-'+parentId).show();
      $('.displayOnlyOld-'+parentId).hide();*/
      

    });

  </script>
