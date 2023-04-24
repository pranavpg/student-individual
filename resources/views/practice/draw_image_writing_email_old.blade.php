<p><strong>{{ $practise['title'] }}</strong></p>
    <form class="save_draw_img_writing_email_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    <input type="hidden" class="drawimage_{{$practise['id']}}" name="drawimage" >
    
    <div class="draw-image d-flex align-items-center justify-content-center mb-4">
        <a href="#!" class="d-flex align-items-end" data-toggle="modal"
                data-target="#drawModal"><img src="{{ asset('public/images/icon-pencil.svg') }}" alt="Pencil"
                    class="mr-n4">Click here to draw</a>
    </div>

    <!--Component Form Slider-->
    <div class="form-slider p-0 mb-4">
            <div class="component-control-box">
                    <input type="text" class="textarea form-control form-control-textarea" id="text_ans"  name="text_ans" role="textbox" value="{{isset($practise['user_answer'][0]['text_ans'][0]) && !empty($practise['user_answer'][0]['text_ans'][0]) ? $practise['user_answer'][0]['text_ans'][0] : ''}}"
                    contenteditable placeholder="Write here..." >
            </div>
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
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="fs-container">
                        <div class="literally images-in-drawing">
                            <canvas id="canvas" ></canvas>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> 


<script src="{{ asset('public/js/literallycanvas.fat.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            
            // disable scrolling on touch devices so we can actually draw
            $(document).bind('touchmove', function (e) {

                if (e.target === document.documentElement) {
                    return e.preventDefault();
                }
            });
            // the only LC-specific thing we have to do
           var LC =   $('.literally').literallycanvas();

            $('.draw-image a').on('click', function () {
                $(window).trigger('resize');
                setTimeout(function () {
                    $(window).trigger('resize');
                }, 10);
            });
        
        });

   /*  Canvas jquery local save image */    
        $(document).on('click',".btn-primary" ,function() {
            $(".btn-primary").attr('disabled','disabled');
            var canvas = document.getElementById('canvas');
			var dataURL = canvas.toDataURL();
            $('#image_get').val(dataURL);
        });

   /*  draw_image_writing_email jquery save image */         
        $(document).on('click',".draw_img_writing_email_form_{{$practise['id']}}" ,function() {
            if($(this).attr('data-is_save') == '1'){
                $(this).closest('.active').find('.msg').fadeOut();
            }else{
                $(this).closest('.active').find('.msg').fadeIn();
            }
            var is_save = $(this).attr('data-is_save');
            $('.is_save:hidden').val(is_save);
            setTextareaContent();
            $.ajax({
                url: "{{route('save-draw-image-writing-email')}}",
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

    </script>

@if(isset($practise['user_answer'][0]['path']) && !empty($practise['user_answer'][0]['path']))

<script>
//alert("{{ $practise['user_answer'][0]['path'] }}");
  $(document).ready(function() {
    var LC =   $('.literally').literallycanvas();

    var lc = LC.init(
      document.getElementsByClassName('literally images-in-drawing'));
    var newImage = new Image()
    newImage.src = "{{$practise['user_answer'][0]['path']}}";
    lc.saveShape(LC.createShape('Image', {x: 10, y: 10, image: newImage}));
  });
</script>
@endif


