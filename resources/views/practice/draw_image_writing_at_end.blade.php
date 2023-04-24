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
<p> <strong>{!! $practise['title'] !!}</strong> </p>

<?php
// dd($practise);
    $load_image = ( isset($practise['user_answer']) && $practise['user_answer'][0]['path'] !== "") ? $practise['user_answer'][0]['path'] : "";
    if(!empty($load_image)){
      $filename =  explode('/', $practise['user_answer'][0]['path']);


      @$rawImage = file_get_contents($load_image);
      if($rawImage)
      {
        file_put_contents(public_path("images/draw/".end($filename)),$rawImage);
        $load_image = asset('/public/images/draw/').'/'.end($filename);
      }
    }
    $watermarkimage = (!empty($practise['question'][0]) && is_array($practise['question']))?$practise['question'][0]: "";
    if( !empty($watermarkimage) ) {
        $noImage = false;
        $filenameWatermark =  explode('/', $watermarkimage);
        @$rawImageWatermark = file_get_contents($watermarkimage);
        if($rawImageWatermark)
        {
            file_put_contents(public_path("images/draw/".end($filenameWatermark)),$rawImageWatermark);
            $watermarkimage = asset('/public/images/draw/').'/'.end($filenameWatermark);
        }
        $style="object-fit:contain;height:400px;width:500px;";
    } else {
        $noImage = true;
        $watermarkimage = asset('public/images/icon-pencil.svg');
        $style="object-fit:contain;height:100px;width:100px;";
    }
  //  pr($watermarkimage);
?>
    <form class="save_draw_img_writing_form_{{$practise['id']}}">
        <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
        <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
        <input type="hidden" class="is_save" name="is_save" value="">
        <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
        <input type="hidden" class="practise_type" name="practise_type" value="{{$practise['type']}}">
        <div style="display: none"><input type="hidden" name="drawimage" id="drawimage_{{$practise['id']}}"></div>
        <div id="svgid" style="display: none"></div>

        <?php // echo '<pre>'; print_r($practise);
        $exploded_question  = array();
            if(!empty($practise['question'])){
                if(!is_array($practise['question']) && strpos($practise['question'],"@@")){
                    $exploded_question  =  explode('@@', $practise['question']);
                }else{
                    if(is_array($practise['question'])){
                        $question_img=$practise['question'][0];
                    }
                    if(is_array($practise['question_2'])){
                     $exploded_question  =  $practise['question_2'];
                    }
                }
            }
           // echo '<pre>'; 
            // dd($exploded_question);
            // dd($watermarkimage);
            // dd($practise);
            $exploded_question = array_filter($exploded_question);
        ?>
        <div class="multiple-choice mb-4">

            @foreach($exploded_question as $key=>$item)

            <div class="form-group form-group-label focus">
                <span class="label">{{str_replace('@@','',$item)}}</span>
                <br>
                <span class="textarea form-control form-control-textarea" role="textbox"
                    contenteditable="" placeholder="Write here..."><?php if(isset($practise['user_answer'][0]['text_ans']) && !empty($practise['user_answer'][0]['text_ans'])){echo $practise['user_answer'][0]['text_ans'][$key];}?></span>
                    <div style="display:none">

                        <textarea name="text_ans[]"><?php if(isset($practise['user_answer'][0]['text_ans']) && !empty($practise['user_answer'][0]['text_ans'])){echo $practise['user_answer'][0]['text_ans'][$key];}?></textarea>

                    </div>
            </div>
            @endforeach
 

            <div class="draw-image d-flex align-items-center justify-content-center mb-4">
              @if(!empty($practise['user_answer'][0]) && $practise['user_answer'][0]['path'] !="")
                <a href="#!" class="d-flex align-items-end" data-toggle="modal" data-target="#drawModal" id="getdrawImage">
                    <img  src="{{ $load_image }}" alt="Pencil" crossOrigin="Anonymous" style="object-fit:contain;height:400px;width:500px;"  class="mr-n4 img-fluid" id="saved_image">
                </a>
              @else
                  <a href="#!" class="d-flex align-items-end" data-toggle="modal" data-target="#drawModal" id="getdrawImage">
                      <img src="{{$watermarkimage}}" style="{{$style}}" alt="Pencil" class="mr-n4">
                  </a>
              @endif
            </div>
        </div>

        <!-- Modal -->
        <div class="modal" id="drawModal" tabindex="-1" aria-labelledby="drawModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
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

        <!--Component Form Slider End-->
        <div class="alert alert-success" role="alert" style="display:none"></div>
        <div class="alert alert-danger" role="alert" style="display:none"></div>
        <ul class="list-inline list-buttons">
          <li class="list-inline-item">
              <input type="button" class="save_btn draw_img_writing_btn_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
          </li>
          <li class="list-inline-item">
              <input type="button" class="submit_btn draw_img_writing_btn_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">
          </li>
        </ul>
      </form>



<!-- dependency: React.js -->
<script src="//cdnjs.cloudflare.com/ajax/libs/react/0.14.7/react-with-addons.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/react/0.14.7/react-dom.js"></script>
<script src="{{ asset('public/literally/js/literallycanvas.js') }}"></script>

<script type="text/javascript">

    var canvas
    var answer_image = "{{ $load_image }}";
    var newImage = new Image(1000,500);
    newImage.src = answer_image;
    var watermarkImage = new Image();
    watermarkImage.src = "{{ (!$noImage)?$watermarkimage:'' }}";

    if(answer_image==""){
      var bg_img = watermarkImage;
      var scale_img = 0.9;
      var x_axis = 170;
      var y_axis=100;
    } else {
        var scale_img = 0.9;
      var bg_img=newImage;
      var x_axis = 10;
      var y_axis = 40;
    }

    function setTextareaContent(){
        $("span.textarea.form-control").each(function(){
            var currentVal = $(this).html();
            $(this).next().find("textarea").val(currentVal);
        })
    }


    $(document).ready(function () {
        // disable scrolling on touch devices so we can actually draw
        $(document).bind('touchmove', function (e) {
            if (e.target === document.documentElement) {
                return e.preventDefault();
            }
        });

        $('#drawModal').on('show.bs.modal', function(){
            
            var saved_image_path = $("#drawimage_{{$practise['id']}}").val();
            
            if(saved_image_path!==undefined && (saved_image_path.includes('http') || saved_image_path=="")){
                setTimeout(() => {
                    canvas =  LC.init(document.getElementsByClassName('backgrounds')[0],
                    {
                        imageURLPrefix: '{{ asset('public/literally/img') }}',
                        toolbarPosition: 'top',
                        defaultStrokeWidth: 2,
                        strokeWidths: [1, 2, 3, 5, 30],
                        keyboardShortcuts: false,

                    });
                
                    canvas.saveShape(LC.createShape('Image', {x: x_axis, y: y_axis, image: bg_img,  scale:scale_img}));
                    window.dispatchEvent(new Event('resize'));
                }, 300);
            }
        })

    });

    /*  Canvas jquery local save image */
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
        $("#getdrawImage").find('img').css({'height':'400px', "width":"500", "object-fit":"content"})
        $("#text-info").text('');
        $("#getdrawImage").closest('img').addClass('img-fluid m-2');
    });



    /*  draw_image_writing_email jquery save image */
    $(document).on('click',".draw_img_writing_btn_{{$practise['id']}}" ,function(e) {
        e.preventDefault();

        if($(this).attr('data-is_save') == '1'){
            $(this).closest('.active').find('.msg').fadeOut();
        }else{
            $(this).closest('.active').find('.msg').fadeIn();
        }
        var is_save = $(this).attr('data-is_save');
        $('.is_save:hidden').val(is_save);
        setTextareaContent();

        $.ajax({
            url: "{{url('save-draw-image-writing')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: $(".save_draw_img_writing_form_{{$practise['id']}}").serialize(),
            beforeSend: function(){

            },
            success: function (data) {
            $(".draw_img_writing_btn_{{$practise['id']}}").removeAttr('disabled');
                if(data.success){
                  
                    if(is_save=="1"){
                        
                        // =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
                        setTimeout(function(){
                                $('.alert-success').hide();
                            var isNextTaskDependent =  $('.nav-link.active').parent().next().find('a').attr('data-dependent');
                            if( isNextTaskDependent == 1 ){
                                var dependentPractiseId =  $('.nav-link.active').parent().next().find('a').attr('data-id');
                                var baseUrl = "{{url('/')}}";
                                var topic_id = "{{request()->segment(2)}}";
                                var task_id = "{{request()->segment(3)}}";
                                    //window.location.href=baseUrl+'/topic/'+topic_id+'/'+task_id+'?n='+dependentPractiseId
                                ////$('#abc-'+dependentPractiseId+'-tab').trigger('click');
                            } else {
                                 //$('.nav-link.active').parent().next().find('a').trigger('click');
                            }
                        },2000);
                        // =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
                    }
                    $('.alert-danger').hide();
                    $('.alert-success').show().html(data.message).fadeOut(8000);
                }else{
                    $('.alert-success').hide();
                    $('.alert-danger').show().html(data.message).fadeOut(8000);
                }
            }
        });
    });
</script>
