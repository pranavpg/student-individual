<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
        <p>
          <strong><?php
            // echo $practise['title'];
            // pr($practise);
          ?></strong>
        </p>
          <form class="save_set_in_order_vertical_listening_form_{{$practise['id']}}">
          <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
          <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
          <input type="hidden" class="is_save" name="is_save" value="">
          <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
           <?php $exploded_question  =  explode("\r\n", $practise['question']); $i=1;
            $exploded_question = array_filter(array_merge(array(0), $exploded_question));
            //dd($exploded_question);
           ?>
           @if( !empty( $practise['audio_file'] ) )
				@include('practice.common.audio_player')
		@endif
        <?php //echo '<pre>'; print_r($exploded_question);  ?>
            <div class="vertical-set-order">
                <ul class="list-unstyled" id="columns">
                  @php $k = 1; @endphp
                  @if(isset($practise['user_answer']) && !empty($practise['user_answer']))
                    <?php $exploded_answer  =  explode(";", $practise['user_answer']); $i=1; 
                    // pr($exploded_answer);
                    // array_pop($exploded_answer); ?>

                    @foreach($exploded_answer as $p=> $item)

                        @if($item == "@@" || strpos($item, '@@'))

                        @else
                            @if(isset($exploded_question[$item]))
                                <li class="list-item" draggable="true" data-group="{{$k}}">
                                    <span class="text-left text-muted"><b>{!! $exploded_question[$item] !!}</b></span>
                                    <input type="hidden" name="inOrderAnswer[]" value="{{$item}}">
                                </li>
                            @endif
                        @endif

                       @php  $i++; @endphp

                    @endforeach
                  @else
                    @foreach($exploded_question as $p=> $item)
                        <?php if($item == "@@" || strpos($item, '@@')){
                             $k++;
                             echo '<br><input type="hidden" name="inOrderAnswer[]" value="'.$item.'" draggable="false"><br>';
                          }else{ ?>
                            <li class="list-item" draggable="true" data-group="{{$k}}">
                                    <span class="text-left text-muted"><b>{!! $item !!}</b></span>
                                    <input type="hidden" name="inOrderAnswer[]" value="{{$p}}">
                                </li>
                            <?php $i++;
                            }
                        ?>
                    @endforeach
                  @endif
                  <li class="list-item"  draggable="false" data-group="{{$k}}" >
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br> 
                  </li>
                </ul>
            </div>

        <div class="alert alert-success" role="alert" style="display:none">
          This is a success alert check it out!
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
      $(document).on('click',".inOrderVrLsBtn_{{$practise['id']}}" ,function() {
        
        if($(this).attr('data-is_save') == '1'){
            $(this).closest('.active').find('.msg').fadeOut();
        }else{
            $(this).closest('.active').find('.msg').fadeIn();
        }

        var reviewPopup = '{!!$reviewPopup!!}';
         var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){
                    var fullView= $(".save_set_in_order_vertical_listening_form_{{$practise['id']}}").html();
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js" integrity="sha512-0bEtK0USNd96MnO4XhH8jhv3nyRF0eK87pJke6pkYf3cM0uDIhNJy9ltuzqgypoIFXw3JSuiy04tVk4AjpZdZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/base/jquery-ui.css">
<script>
    $(function() {
    $("#columns").sortable({
        revert: true,
        stop: function (e, t) {        
            // alert($(this).data('index'));
        },
        receive: function (ev, ui) {                  
            var $target = ($(this).data().uiSortable  || $(this).data().sortable).currentItem;
                
            var $source = $(ui.sender);                
           $target.data('index',$source.data('index'));
        }
    });
});

        var dragSrcEl = null;

       /* function handleDragStart(e) {
            // Target (this) element is the source node.
            dragSrcEl = this;

            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', this.outerHTML);

            this.classList.add('dragElem');
        }*/

        // function handleDragOver(e) {
        //     if (e.preventDefault) {
        //         e.preventDefault(); 
        //     }
        //     this.classList.add('over');

        //     e.dataTransfer.dropEffect = 'move'; 

        //     return false;
        // }

        // function handleDragEnter(e) {
        // }

       /* function handleDragLeave(e) {
            this.classList.remove('over'); // this / e.target is previous target element.
        }*/
/*
        function handleDrop(e) {
           

            if (e.stopPropagation) {
                e.stopPropagation(); 
            }

            

            if(this.getAttribute('data-group') == dragSrcEl.getAttribute('data-group'))
            {
                if (dragSrcEl != this) {
               


                    console.log(dragSrcEl.getAttribute('data-group'));

                    this.parentNode.removeChild(dragSrcEl);
                    var dropHTML = e.dataTransfer.getData('text/html');
                    this.insertAdjacentHTML('beforebegin', dropHTML);
                    var dropElem = this.previousSibling;
                    addDnDHandlers(dropElem);

                }

            }

            this.classList.remove('over');
            return false;
        }
*/
      /*  function handleDragEnd(e) {
            this.classList.remove('over');

        }*/

       /* function addDnDHandlers(elem) {
            elem.addEventListener('dragstart', handleDragStart, false);
            elem.addEventListener('dragenter', handleDragEnter, false)
            elem.addEventListener('dragover', handleDragOver, false);
            elem.addEventListener('dragleave', handleDragLeave, false);
            elem.addEventListener('drop', handleDrop, false);
            elem.addEventListener('dragend', handleDragEnd, false);

        }*/

        /*var cols = document.querySelectorAll('#columns .list-item');
        [].forEach.call(cols, addDnDHandlers);*/


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
