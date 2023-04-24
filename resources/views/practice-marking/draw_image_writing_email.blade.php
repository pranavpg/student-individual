<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<link rel="stylesheet" href="{{ asset('public/literally/css/literallycanvas.css') }}">
<style>
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
        @$rawImage = file_get_contents($load_image);
        if($rawImage)
        {
            file_put_contents("./public/images/draw/".end($filename),$rawImage);
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
    <div class="form-slider p-0 mb-4">
        <div class="component-control-box">
            <span class="textarea form-control form-control-textarea main-answer enter_disable" role="textbox" contenteditable disabled placeholder="Write here...">{{isset($practise['user_answer'][0]['text_ans'][0]) && !empty($practise['user_answer'][0]['text_ans'][0]) ? $practise['user_answer'][0]['text_ans'][0] : ''}}</span>
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
    </form>
    <div class="modal" id="drawModal" tabindex="-1" aria-labelledby="drawModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="fs-container">
                        <div class="backgrounds" id="canvas__{{$practise['id']}}"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-no-border" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary canvasSave_{{$practise['id']}}"  data-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/react/0.14.7/react-with-addons.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/react/0.14.7/react-dom.js"></script>
    <script src="{{ asset('public/literally/js/literallycanvas.js') }}"></script>
    <script type="text/javascript">
    var canvas
    var answer_image = "{{ $load_image }}";
    var newImage = new Image(698, 362);
    newImage.src = answer_image;
    $(document).ready(function () {
        $(document).bind('touchmove', function (e) {
            if (e.target === document.documentElement) {
                return e.preventDefault();
            }
        });
        $('#drawModal').on('show.bs.modal', function(){
          setTimeout(() => {
            canvas =  LC.init(document.getElementsByClassName('backgrounds')[0],{
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
    function setTextareaContent(){
        $("span.textarea.form-control").each(function(){
            var currentVal = $(this).html();
            // console.log('===========>', currentVal)
            $(this).next().find("textarea").val(currentVal);
        })
    }

    </script>
