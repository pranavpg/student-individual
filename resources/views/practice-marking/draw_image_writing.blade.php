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
        @$rawImage = file_get_contents($load_image);
        if($rawImage)
        {
            file_put_contents("./public/images/draw/".end($filename),$rawImage);
            $load_image = asset('/public/images/draw/').'/'.end($filename);
        }
    }

    $watermarkimage  = !empty($practise['question'][0])?$practise['question'][0]:"";
    $watermarkimage1 = !empty($practise['question'][0])?$practise['question'][0]:"";//add for level 0
    if(!empty($watermarkimage)){
        $noImage = false;
        $filenameWatermark =  explode('/', $watermarkimage);
        @$rawImageWatermark = file_get_contents($watermarkimage);
        if($rawImageWatermark)
        {
            file_put_contents("./public/images/draw/".end($filenameWatermark),$rawImageWatermark);
            $watermarkimage = asset('/public/images/draw/').'/'.end($filenameWatermark);
        }
        $style="object-fit:contain;height:369px;width:645px;";
    } else {
        $noImage = true;
        $watermarkimage = asset('public/images/icon-pencil.svg');
        $style="object-fit:contain;height:100px;width:100px;";
    }
 ?>
<p><strong>{{ $practise['title'] }}</strong></p>
<form class="save_draw_img_writing_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    <div style="display: none"><textarea name="drawimage" id="drawimage_{{$practise['id']}}"></textarea></div>
    <div id="svgid" style="display: none"></div>

    <div class="draw-image d-flex align-items-center justify-content-center mb-4 img-thumbnail">
        @if(isset($practise['user_answer'][0]['path']) && $practise['user_answer'][0]['path'] !== "")
            <a href="#!" class="d-flex align-items-end" data-toggle="modal" data-target="#drawModal" id="getdrawImage">
                <img  src="{{ $load_image }}" alt="Pencil" crossOrigin="Anonymous" style="object-fit:contain;height:369px;width:645px;"  class="mr-n4 img-fluid" id="saved_image">
            </a>
        @else 
            <a href="#!" class="d-flex align-items-end ieuks-ctdbtn" data-toggle="modal" data-target="#drawModal" id="getdrawImage">
                <img  src="{{$watermarkimage1}}" style="{{$style}}" alt="Pencil1" class="mr-n4">
                <span id="text-info">Click here to draw</span>
            </a>
        @endif
    </div>

    <!--Component Form Slider-->
    <div class="form-slider p-0 mb-4">
        <div class="component-control-box">
                <input type="text" class="textarea form-control form-control-textarea" id="text_ans"  disabled="true" name="text_ans" role="textbox" value="{{isset($practise['user_answer'][0]['text_ans'][0]) && !empty($practise['user_answer'][0]['text_ans'][0]) ? $practise['user_answer'][0]['text_ans'][0] : ''}}"
                contenteditable disabled placeholder="Write here..." >
        </div>
    </div>
    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-no-border" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary canvasSave_{{$practise['id']}}"  data-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>


<!-- dependency: React.js -->
<script src="//cdnjs.cloudflare.com/ajax/libs/react/0.14.7/react-with-addons.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/react/0.14.7/react-dom.js"></script>
<script src="{{ asset('public/literally/js/literallycanvas.js') }}"></script>

<script type="text/javascript">

    var canvas;
    var answer_image = "{{ $load_image }}";
    var newImage = new Image();
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
            $(".canvasSave_{{$practise['id']}}").removeAttr("disabled");
            var saved_image_path = $('#getdrawImage').find('img').prop('src');
            var flag = true
            var x_axis=0;
            var y_axis=0; 
            var scale_img = 1;
            if(answer_image==""){    
                // var x_axis="{{ (!$noImage)?'10':'170' }}";
                // var y_axis="{{ (!$noImage)?'10':'80' }}"; 
                // var scale_img = 0.6;
                if(saved_image_path.includes('http') || saved_image_path==""){
                    var newImage = new Image();
                    newImage.src = answer_image;
                    var watermarkImage = new Image();
                    watermarkImage.src = "{{ (!$noImage)?$watermarkimage:'' }}";
                    var bg_img = watermarkImage
                }else{
                    var flag = false
                }
            } else {
                // var x_axis=10;
                // var y_axis=10;
                // var scale_img = 0.9;  
                if(saved_image_path.includes('http') || saved_image_path==""){
                    var newImage = new Image();
                    newImage.src = answer_image;
                    var watermarkImage = new Image();
                    //watermarkImage.src = "{{ $watermarkimage }}";
                    watermarkImage.src = "{{ (!$noImage)?$watermarkimage:'' }}";
                    var bg_img=newImage;
                } else {
                    var flag = false
                }
            }
            
            if (flag){
                setTimeout(() => {
                    canvas =  LC.init(document.getElementsByClassName('backgrounds')[0],
                    {
                        imageURLPrefix: '{{ asset('public/literally/img') }}',
                        toolbarPosition: 'top',
                        defaultStrokeWidth: 2,
                        strokeWidths: [1, 2, 3, 5, 30],
                        keyboardShortcuts: false,

                    });
                    canvas.saveShape(LC.createShape('Image', {x: x_axis, y: y_axis, image: bg_img,  scale: scale_img}));
                    window.dispatchEvent(new Event('resize'));
                }, 450);
            }
        });
    });


    $(document).on('click',".canvasSave_{{$practise['id']}}" ,function() {

        $(".canvasSave_{{$practise['id']}}").attr('disabled','disabled');
        // check if //domain.com or http://domain.com is a different origin
        if (/^([\w]+\:)?\/\//.test(answer_image) && answer_image.indexOf(location.host) === -1) {
          document.getElementById("saved_image").crossOrigin = "anonymous";
          newImage.crossOrigin = "Anonymous"; // or "use-credentials"
        }

        var image=  canvas.canvasForExport().toDataURL().split(',')[1];
        var dataURL = "data:image/png;base64,"+image
        newImage.src = dataURL;

        $("#drawimage_{{$practise['id']}}").val(dataURL);
        $("#getdrawImage").find('img').attr('src', dataURL);
        $("#getdrawImage").find('img').css({  "width":"645", "height":"369px", "object-fit":"content"})
        $("#text-info").text('');
        $("#getdrawImage").closest('img').addClass('img-fluid m-2');
    });

    /*  draw_image_writing_email jquery save image */
    $(document).on('click',".draw_img_writing_email_form_{{$practise['id']}}" ,function() {
        var is_save = $(this).attr('data-is_save');
        $('.is_save:hidden').val(is_save);
        setTextareaContent();
        $.ajax({
            url: "{{url('save-draw-image-writing')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: $(".save_draw_img_writing_form_{{$practise['id']}}").serialize(),
            success: function (data) {
            $(".draw_img_writing_email_form_{{$practise['id']}}").removeAttr('disabled');
                if(data.success){
                    $('.alert-danger').hide();
                    $('.alert-success').show().html(data.message).fadeOut(4000);
                }else{
                    $('.alert-success').hide();
                    $('.alert-danger').show().html(data.message).fadeOut(4000);
                }
            }
        });
    });
</script>