<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<link rel="stylesheet" href="{{ asset('public/literally/css/literallycanvas.css') }}">

<style>

/* .fs-container {
        width: 320px;
        margin: auto;
      } */

    .literally {
      width: 100%;
      height: 100%;
      position: relative;
      background-color: #fff !important
    }
    .literally .lc-picker{
      background-color: transparent !important
    }
    .literally .horz-toolbar{
      background-color: transparent !important
    }
    .draw_img_full_screen {
        width: 100%;
    }
    .draw_img_full_screen img {
        width: 100%;
    }
    .draw-image > a::before {
        background: none;
    }
    .draw-image > a::after {
        background: none;
    }
  </style>

  <?php
      $load_image = ( isset($practise['user_answer']) && $practise['user_answer'][0]['path'] !== "") ? $practise['user_answer'][0]['path'] : "";
      if(!empty($load_image)){
        $filename =  explode('/', $practise['user_answer'][0]['path']);
        $local_path = asset('/public/images/draw/').'/'.end($filename);
        //file_put_contents(end($filename), file_get_contents('https://media.geeksforgeeks.org/wp-content/uploads/geeksforgeeks-6-1.png'));
        @$rawImage = file_get_contents($load_image);
        if($rawImage)
        {
            file_put_contents(public_path("images/draw/".end($filename)),$rawImage);
            $load_image = asset('/public/images/draw/').'/'.end($filename);
        }

      }
   ?>
<p><strong>{{ $practise['title'] }}</strong></p>
    <form class="save_draw_img_writing_email_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    <div style="display: none"><textarea name="drawimage" id="drawimage_{{$practise['id']}}"></textarea></div>
    <div id="svgid" style="display: none"></div>

    <div class="draw-image d-flex align-items-center justify-content-center mb-4 img-thumbnail">
        @if(isset($practise['user_answer'][0]['path']) && $practise['user_answer'][0]['path'] !== "")

            <a href="#!" class="d-flex align-items-end" data-toggle="modal" data-target="#drawModal" id="getdrawImage">
                <img  src="{{ $load_image }}" alt="Pencil" crossOrigin="Anonymous"  class="mr-n4 img-fluid" id="saved_image">
            </a>
        @else
            <a href="#!" class="d-flex align-items-end ieuks-ctdbtn" data-toggle="modal" data-target="#drawModal" id="getdrawImage">
                <img src="{{ asset('public/images/icon-pencil.svg') }}" alt="Pencil" class="mr-n4">
                <span id="text-info">Click here to draw</span>
            </a>
        @endif
    </div>

    <!--Component Form Slider-->
    <div class="form-slider p-0 mb-4">
        <div class="component-control-box">
                <!-- <input type="text" class="textarea form-control form-control-textarea" id="text_ans"  name="text_ans" role="textbox" value="{{isset($practise['user_answer'][0]['text_ans'][0]) && !empty($practise['user_answer'][0]['text_ans'][0]) ? $practise['user_answer'][0]['text_ans'][0] : ''}}"
                contenteditable placeholder="Write here..." > -->

                <span class="textarea form-control form-control-textarea main-answer enter_disable" role="textbox" contenteditable placeholder="Write here...">{{isset($practise['user_answer'][0]['text_ans'][0]) && !empty($practise['user_answer'][0]['text_ans'][0]) ? $practise['user_answer'][0]['text_ans'][0] : ''}}</span>
                <div style="display:none">
                    <textarea name="text_ans" class="main-answer-input">{{isset($practise['user_answer'][0]['text_ans'][0]) && !empty($practise['user_answer'][0]['text_ans'][0]) ? $practise['user_answer'][0]['text_ans'][0] : ''}}</textarea>
                </div>

        </div>
    </div>
<div class="form-slider p-0 mb-4 text-center">
<a href="{!!$load_image!!}" class="btn btn-info" download id="sendTeacher">Download</a>

</div>
    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>

    <ul class="list-inline list-buttons">
        <input type="hidden" name="image_get" id="image_get" value="">
        <li class="list-inline-item">
        <input type="button" class="save_btn  draw_img_writing_email_form_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
        </li>
        <li class="list-inline-item">
            <input type="button" class="submit_btn  draw_img_writing_email_form_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">
        </li>
    </ul>

    </form>


    <!-- Modal -->
    <div class="modal" id="drawModal" tabindex="-1" aria-labelledby="drawModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="fs-container">
                        <div class="backgrounds" id="canvas__{{$practise['id']}}"></div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary canvasSave_{{$practise['id']}}" data-dismiss="modal">Save changes</button>
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


<!-- dependency: React.js -->
<script src="//cdnjs.cloudflare.com/ajax/libs/react/0.14.7/react-with-addons.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/react/0.14.7/react-dom.js"></script>
<script src="{{ asset('public/literally/js/literallycanvas.js') }}"></script>


    <script type="text/javascript">
    var canvas
    var answer_image = "{{ $load_image }}";
    var newImage = new Image(698, 362);
    newImage.src = answer_image;
    $(document).ready(function () {
        // disable scrolling on touch devices so we can actually draw
        $(document).bind('touchmove', function (e) {

            if (e.target === document.documentElement) {
                return e.preventDefault();
            }
        });
        // the only LC-specific thing we have to do


        $('#drawModal').on('show.bs.modal', function(){
          setTimeout(() => {

            canvas =  LC.init(document.getElementsByClassName('backgrounds')[0],
            {
                imageURLPrefix: '{{ asset('public/literally/img') }}',
                toolbarPosition: 'top',
                defaultStrokeWidth: 2,
                strokeWidths: [1, 2, 3, 5, 30],
                keyboardShortcuts: false,

            });
            canvas.saveShape(LC.createShape('Image', {x: 10, y: 10, image: newImage}));

            window.dispatchEvent(new Event('resize'));
          }, 100);
        })
    });

    $(document).on('click',".canvasSave_{{$practise['id']}}" ,function(e) {

        // $(".canvasSave_{{$practise['id']}}").attr('disabled','disabled');
        // check if //domain.com or http://domain.com is a different origin
        if (/^([\w]+\:)?\/\//.test(answer_image) && answer_image.indexOf(location.host) === -1) {
          document.getElementById("saved_image").crossOrigin = "anonymous";
          newImage.crossOrigin = "Anonymous"; // or "use-credentials"
        }

        var image=  canvas.canvasForExport().toDataURL().split(',')[1];
        var dataURL = "data:image/png;base64,"+image
        $("#sendTeacher").attr("href", dataURL);
        newImage.src = dataURL;

        $("#drawimage_{{$practise['id']}}").val(dataURL);
        $("#getdrawImage").find('img').attr('src', dataURL);
        $("#text-info").text('');
        $("#getdrawImage").closest('img').addClass('img-fluid m-2');
    });

    // $(document).on('click',".canvasSave_{{$practise['id']}}" ,function() {
    //
    //     $(".canvasSave_{{$practise['id']}}").attr('disabled','disabled');
    //
    //     var svgString = canvas.getSVGString();
    //
    //     var svgdiv = document.getElementById("svgid").innerHTML = svgString;
    //     var svg = $('#svgid').find('svg');
    //
    //     var newImages = new Image();
    //     svg[0].toDataURL("image/png", {
    //         callback: function(data) {
    //             newImages.setAttribute("src", data);
    //             $("#drawimage_{{$practise['id']}}").val(data);
    //             console.log(data);
    //
    //             $("#getdrawImage").find('img').attr('src', data);
    //
    //             $("#text-info").text('');
    //             $("#getdrawImage").addClass('img-fluid m-2')
    //             //a.style.display = "inline"
    //         }
    //     });
    // });

   /*  draw_image_writing_email jquery save image */
        $(document).on('click',".draw_img_writing_email_form_{{$practise['id']}}" ,function() {
            if($(this).attr('data-is_save') == '1'){
                $(this).closest('.active').find('.msg').fadeOut();
            }else{
                $(this).closest('.active').find('.msg').fadeIn();
            }
            // CommonAnsSetDiff();
            var is_save = $(this).attr('data-is_save');
            $('.is_save:hidden').val(is_save);
            setTextareaContent();
            $.ajax({
                url: "{{url('save-draw-image-writing')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                data: $(".save_draw_img_writing_email_form_{{$practise['id']}}").serialize(),
                success: function (data) {
                $(".draw_img_writing_email_form_{{$practise['id']}}").removeAttr('disabled');
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

        function setTextareaContent(){

            $("span.textarea.form-control").each(function(){
                var currentVal = $(this).html();
                // console.log('===========>', currentVal)
                $(this).next().find("textarea").val(currentVal);
            })
        }

    </script>
