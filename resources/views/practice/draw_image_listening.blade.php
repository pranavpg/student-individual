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
        background-color: transparent !important
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

<p>
<strong><?php
echo $practise['title'];
?></strong>
<?php
//pr($practise);
$load_image = "";
    if(isset($practise['user_answer'])){
        if(isset($practise['user_answer'][0])){
            $load_image = ( isset($practise['user_answer']) && $practise['user_answer'][0] !== "") ? $practise['user_answer'][0].'?v='.rand(10,9999) : "";
            if(!empty($load_image)){
                $filename =  explode('/', $practise['user_answer'][0]);
                @$rawImage = file_get_contents($load_image);
                if($rawImage)
                {
                    file_put_contents(public_path("images/draw/".end($filename)),$rawImage);
                    $load_image = asset('/public/images/draw/').'/'.end($filename);
                }
            }
        }
    }
    $watermarkimage = !empty($practise['question'][0])?$practise['question'][0]:"";
    if(!empty($watermarkimage)){
        $noImage = false;
        $filenameWatermark =  explode('/', $watermarkimage);
        @$rawImageWatermark = file_get_contents($watermarkimage);
        if($rawImageWatermark)
        {
            file_put_contents(public_path("images/draw/".end($filenameWatermark)),$rawImageWatermark);
            $watermarkimage = asset('/public/images/draw/').'/'.end($filenameWatermark);
        }
        $style="object-fit:contain;height:369px;width:645px;";
    } else {
        $noImage = true;
        $watermarkimage = asset('public/images/icon-pencil.svg');
        $style="object-fit:contain;height:100px;width:100px;";
    }
  //  pr($watermarkimage);
?>
</p>
    <form class="save_draw_img_listening_form_{{$practise['id']}}">
        <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
        <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
        <input type="hidden" class="is_save" name="is_save" value="">
        <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
        <div style="display: none"><textarea name="drawimage" id="drawimage_{{$practise['id']}}"></textarea></div>
        <div id="svgid" style="display: none"></div>
       <?php //echo '<pre>'; print_r($practise);?>
        @if( !empty( $practise['audio_file'] ) )
    			@include('practice.common.audio_player')
    		@endif
        <div class="draw-image d-flex align-items-center justify-content-center mb-4">
            @if(isset($practise['user_answer'][0]) && $practise['user_answer'][0] !== "")
              <a href="#!" class="d-flex align-items-end" data-toggle="modal123" data-target="#drawModal234" id="getdrawImage">
                  <img  src="{{ $load_image }}" alt="Pencil" crossOrigin="Anonymous" style="object-fit:contain;height:369px;width:645px;"  class="mr-n4 img-fluid" id="saved_image">
              </a>
            @else
              <a href="#!" class="d-flex align-items-end" data-toggle="modal123" data-target="#drawModal234" id="getdrawImage">
                <img  src="{{$watermarkimage}}" style="{{$style}}" alt="Pencil1" class="mr-n4">
              </a>
            @endif
        </div>
        <!--Component Form Slider End-->
        <div class="alert alert-success" role="alert" style="display:none"></div>
        <div class="alert alert-danger" role="alert" style="display:none"></div>
        <ul class="list-inline list-buttons">
            <li class="list-inline-item">
                <input type="button" class="save_btn draw_img_listening_btn_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
            </li>
            <li class="list-inline-item">
                <input type="button" class="submit_btn draw_img_listening_btn_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">
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
    <!-- Modal -->
    <div class="modal" id="drawModal" tabindex="-1" aria-labelledby="drawModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body" >
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
var canvas; 
var answer_image = "{{ trim($load_image) }}";     
$(document).ready(function () {
    // disable scrolling on touch devices so we can actually draw
    $(document).bind('touchmove', function (e) {
        if (e.target === document.documentElement) {
            return e.preventDefault();
        }
    }); 

    
    $('#getdrawImage').on('click', function(){
   
        $(".canvasSave_{{$practise['id']}}").removeAttr("disabled");
        var saved_image_path = $('#getdrawImage').find('img').prop('src');
        var flag = true
        var x_axis=0;
        var y_axis=0; 
        var scale_img = 1;
        if(answer_image==""){    
            if(saved_image_path.includes('http') || saved_image_path=="" ){
                var newImage = new Image();
                newImage.src = answer_image;
                var watermarkImage = new Image(); 
                var imgsrc = $(watermarkImage).attr('src')
                if(imgsrc==undefined){
                    $('#drawModal').modal('toggle');
                } else {
                    watermarkImage.onload = function() { 
                        $('.modal-dialog').css("min-width",this.width+150); 
                        $('#drawModal').modal('toggle');
                    } 
                }
                watermarkImage.src = "{{ (!$noImage)?$watermarkimage:'' }}"; 
                var bg_img = watermarkImage
            }else{
                if( saved_image_path.includes('data:image') ){ 
                    var watermarkImage = new Image(); 
                    var imgsrc = $(watermarkImage).attr('src')
                    if(imgsrc==undefined){
                        $('#drawModal').modal('toggle');
                    } else {
                        watermarkImage.onload = function() { 
                            $('.modal-dialog').css("min-width",this.width+150); 
                            $('#drawModal').modal('toggle');
                        } 
                    }
                    watermarkImage.src =  saved_image_path
                    var bg_img = watermarkImage
                } else { 
                    var flag = false
                }
            }
        } else {
           
            if(saved_image_path.includes('http') || saved_image_path==""){
                var newImage = new Image();
                newImage.src = answer_image;
                var watermarkImage = new Image(); 
                var imgsrc = $(watermarkImage).attr('src')
                if(imgsrc==undefined){
                    $('#drawModal').modal('toggle');
                } else {
                    watermarkImage.onload = function() { 
                        $('.modal-dialog').css("min-width",this.width); 
                        $('#drawModal').modal('toggle');
                    } 
                } 
                watermarkImage.src = "{{ (!$noImage)?$watermarkimage:'' }}";
                var bg_img=newImage;
            } else {
                if( saved_image_path.includes('data:image') ){
                    var watermarkImage = new Image(); 
                    var imgsrc = $(watermarkImage).attr('src')
                    if(imgsrc==undefined){
                        $('#drawModal').modal('toggle');
                    } else {
                        watermarkImage.onload = function() { 
                            $('.modal-dialog').css("min-width",this.width); 
                            $('#drawModal').modal('toggle');
                        } 
                    } 
                    watermarkImage.src =  saved_image_path
                    var bg_img = watermarkImage
                } else { 
                    var flag = false
                }
            }
        }
        if (flag){  
            setTimeout(() => {
                canvas =  LC.init(document.getElementsByClassName('backgrounds')[0],
                { 
                    imageURLPrefix: "{{ asset('public/literally/img') }}",
                    toolbarPosition: 'top',
                    defaultStrokeWidth: 2, 
                    strokeWidths: [1, 2, 3, 5, 30],
                    keyboardShortcuts: false,
                }); 
                canvas.saveShape(LC.createShape('Image', {x: x_axis, y: y_axis, image: bg_img,  scale: scale_img  }));
                window.dispatchEvent(new Event('resize'));
            }, 450);
        }
    }); 
});
/*  Canvas jquery local save image */
$(document).on('click',".canvasSave_{{$practise['id']}}" ,function() {
    $(".canvasSave_{{$practise['id']}}").attr('disabled','disabled');
    var image=  canvas.canvasForExport().toDataURL().split(',')[1];
    var dataURL = "data:image/png;base64,"+image
    //  newImage.src = dataURL;
    $("#drawimage_{{$practise['id']}}").val(dataURL);
    
    $("#getdrawImage").find('img').attr('src', dataURL);
    $("#getdrawImage").find('img').css({  "width":"645", "height":"369px", "object-fit":"content"})
    $("#text-info").text('');
    $("#getdrawImage").closest('img').addClass('img-fluid m-2');
});
/*  draw_image_writing_email jquery save image */
$(document).on('click',".draw_img_listening_btn_{{$practise['id']}}" ,function() {

if($(this).attr('data-is_save') == '1'){
    $(this).closest('.active').find('.msg').fadeOut();
}else{
    $(this).closest('.active').find('.msg').fadeIn();
}


    var reviewPopup = '{!!$reviewPopup!!}';
    var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){
                    var fullView= $(".save_draw_img_listening_form_{{$practise['id']}}").html();
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
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);
    // setTextareaContent();
    $.ajax({
        url: "{{url('save-draw-image-listening')}}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $(".save_draw_img_listening_form_{{$practise['id']}}").serialize(),
        success: function (data) {
        $(".draw_img_listening_btn_{{$practise['id']}}").removeAttr('disabled');
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