<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
@if( !empty($practise['question']))
        <p>
          <strong><?php
        //  pr($practise);
          echo $practise['title'];
          ?></strong>
        </p>
    <form class="save_set_in_order_vertical_listening_form_{{$practise['id']}}">
          <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
          <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
          <input type="hidden" class="is_save" name="is_save" value="">
          <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
           <?php $exploded_question  =  explode("\r\n", $practise['question']); $i=1;?>
            @if( !empty( $practise['audio_file'] ) )
        					  @include('practice.common.audio_player')
        		@endif
        <?php
              $at_the_rate_array = array();
              if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
              //  $exploded_question = explode(PHP_EOL, $practise['question']);
                $user_answer = explode(';', $practise['user_answer']);
                $order_question_array = array();
                $order_answer_array = array();

                $i=0;
                $k=0;
                $l=0;
//pr($user_answer);

                foreach($user_answer as $key => $value)
                {
                  if($value=='@@'){
                    $at_the_rate_array[$i] = $key;
                    $i++;
                    $k=0;
                  }
                  if($value!='@@') {

                    $order_question_array[$i][$key] = $value;
                    //if(!empty($user_answer[$l])){
                      $order_answer_array[$i][$k] = (int) $user_answer[$l];
                  //  }
                    $k++;
                  }
                  $l++;
                }
              } else{
                $order_question_array = array();
                $i=0;
                $k=0;
                foreach($exploded_question as $key => $value)
                {
                  if($value=='@@'){
                    $at_the_rate_array[$i] = $k;
                    $i++;
                    $k=0;
                  }
                  if($value!='@@') {
                    $order_question_array[$i][$k] = $value;
                    $k++;
                  }
                }
              }
        //  pr($order_question_array);
           ?>
            <div class="vertical-set-order">

                @if(isset($practise['user_answer']) && !empty($practise['user_answer']))
                  @foreach($order_answer_array as $key => $value)
                    <ul class="list-unstyled columns mb-5" id="columns">
                        @if( !empty($value) )
                          @foreach($value as $val)
                            <li class="list-item" draggable="true">
                              <span class="{{($practise['type']=='set_in_order_vertical_listening')?'text-left':''}}">{{$exploded_question[$val]}}</span>
                              <input type="hidden" name="inOrderAnswer[]" value="{{$val}}">
                            </li>
                          @endforeach
                        @endif
                    </ul>
                    @if(!empty($at_the_rate_array[$key]))
                      <input type="hidden" name="inOrderAnswer[]" value="{{ $at_the_rate_array[$key] }}">
                    @endif
                  @endforeach
                @else
                  @foreach($order_question_array as $key => $value)
                    <ul class="list-unstyled columns mb-5" id="columns">
                        @if(!empty($value) )
                          @foreach($value as $k=> $v)
                            <li class="list-item" draggable="true">
                                <span class="text-left">{{$v}}</span>
                                <input type="hidden" name="inOrderAnswer[]" value="{{$k}}">
                            </li>
                          @endforeach
                        @endif
                    </ul>
                    @if(!empty($at_the_rate_array[$key]))
                      <input type="hidden" name="inOrderAnswer[]" value="{{ $at_the_rate_array[$key] }}">
                    @endif
                  @endforeach
                @endif
            </div>

        <div class="alert alert-success" role="alert" style="display:none">
          This is a success alert—check it out!
        </div>
        <ul class="list-inline list-buttons">
            <li class="list-inline-item">
              <!-- <a href="#!" class="btn btn-primary"
                    data-toggle="modal" data-target="#exitmodal">Save</a> -->
                    <input type="button" class="save_btn inOrderVrLsBtn_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
            </li>
            <li class="list-inline-item">
             <input type="button" class="submit_btn inOrderVrLsBtn_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">

            </li>
        </ul>

    </form>
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
      $(document).on('click',".inOrderVrLsBtn_{{$practise['id']}}" ,function() {
        if($(this).attr('data-is_save') == '1'){
            $(this).closest('.active').find('.msg').fadeOut();
        }else{
            $(this).closest('.active').find('.msg').fadeIn();
        }
        
        $(".inOrderVrLsBtn_{{$practise['id']}}").attr('disabled','disabled');
        var is_save = $(this).attr('data-is_save');
        $('.is_save:hidden').val(is_save);
        // setTextareaContent();
        $.ajax({
            url: "{{url('save-setin-order-vertical-listening')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: $(".save_set_in_order_vertical_listening_form_{{$practise['id']}}").serialize(),
            success: function (data) {
              $(".inOrderVrLsBtn_{{$practise['id']}}").removeAttr('disabled');

                $('.alert-success').show().html(data.message).fadeOut(8000);

            }
        });

      });
</script>
<script>
        var dragSrcEl = null;

        function handleDragStart(e) {
            // Target (this) element is the source node.
            dragSrcEl = this;

            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', this.outerHTML);

            this.classList.add('dragElem');
        }

        function handleDragOver(e) {
            if (e.preventDefault) {
                e.preventDefault(); // Necessary. Allows us to drop.
            }
            this.classList.add('over');

            e.dataTransfer.dropEffect = 'move'; // See the section on the DataTransfer object.

            return false;
        }

        function handleDragEnter(e) {
            // this / e.target is the current hover target.
        }

        function handleDragLeave(e) {
            this.classList.remove('over'); // this / e.target is previous target element.
        }

        function handleDrop(e) {
            // this/e.target is current target element.

            if (e.stopPropagation) {
                e.stopPropagation(); // Stops some browsers from redirecting.
            }

            // Don't do anything if dropping the same column we're dragging.
            if (dragSrcEl != this) {
                // Set the source column's HTML to the HTML of the column we dropped on.
                //alert(this.outerHTML);
                //dragSrcEl.innerHTML = this.innerHTML;
                //this.innerHTML = e.dataTransfer.getData('text/html');
                this.parentNode.removeChild(dragSrcEl);
                var dropHTML = e.dataTransfer.getData('text/html');
                this.insertAdjacentHTML('beforebegin', dropHTML);
                var dropElem = this.previousSibling;
                addDnDHandlers(dropElem);

            }
            this.classList.remove('over');
            return false;
        }

        function handleDragEnd(e) {
            // this/e.target is the source node.
            this.classList.remove('over');

            /*[].forEach.call(cols, function (col) {
              col.classList.remove('over');
            });*/
        }

        function addDnDHandlers(elem) {
            elem.addEventListener('dragstart', handleDragStart, false);
            elem.addEventListener('dragenter', handleDragEnter, false)
            elem.addEventListener('dragover', handleDragOver, false);
            elem.addEventListener('dragleave', handleDragLeave, false);
            elem.addEventListener('drop', handleDrop, false);
            elem.addEventListener('dragend', handleDragEnd, false);

        }

        var cols = document.querySelectorAll('#columns .list-item');
        [].forEach.call(cols, addDnDHandlers);


        // $(function () {
        //     $('audio').audioPlayer();
        // });

        // auto resizing input
    </script>
<!-- <script src="{{ asset('public/js/audioplayer.js') }}"></script> -->

<script>jQuery(function ($) {
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js" integrity="sha512-0bEtK0USNd96MnO4XhH8jhv3nyRF0eK87pJke6pkYf3cM0uDIhNJy9ltuzqgypoIFXw3JSuiy04tVk4AjpZdZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

