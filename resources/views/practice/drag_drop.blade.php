<p><strong>{!! $practise['title'] !!}</strong></p>

<?php
//echo "<pre>"; print_r($practise); exit;
  $answerExists = false;
  if(!empty($practise['user_answer'])){
      $answerExists = true;
      $answer = $practise['user_answer'];
  }
  //pr($practise);
  $image  = $practise['question'][0];
?>
<!--Component Conversation-->
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

  <!-- Componetnt Drag and Drop-->
  <div class="drag-drop mb-5">
      
      <div id="droppable" class="ui-widget-header m-auto" style="border:0; position:inherit;">
	  	<ul class="list-unstyled gallery d-flex justify-content-between">
          <li class="list-item">
              <a href="#!" class="draggable">The main road</a>
          </li>
          <li class="list-item">
              <a href="#!" class="draggable">The traffic lights</a>
          </li>
          <li class="list-item">
              <a href="#!" class="draggable">A bridge</a>
          </li>
          <li class="list-item">
              <a href="#!" class="draggable">A path</a>
          </li>
          <li class="list-item">
              <a href="#!" class="draggable">The main road</a>
          </li>
          <li class="list-item">
              <a href="#!" class="draggable">A river</a>
          </li>
      </ul>
	  	<img src="{{ asset('public/images/drag_drop.jpeg') }}" id="main_image" alt="Drop Image" class="img-fluid d-block m-auto" style="width:498px; height:317px;">
	  </div>
	  <div id="output_image" style="margin-top:50px; position:absolute; z-index:-1; opacity:0;">
		<textarea name="drag_drop_image" id="drag_drop_image"></textarea>
		<img src="" alt="" id="captured" />
	  </div>
	  <?php /*?><script type="text/javascript">
	  window.addEventListener("DOMContentLoaded", function()
	{
		var image  = document.getElementById("main_image");
		var canvas = document.getElementById("droppable");
		//document.body.appendChild(canvas);
	
		canvas.width  = image.width;
		canvas.height = image.height;
	
		var context = canvas.getContext("2d");
	
		context.drawImage(image, 0, 0);
		
		
		
	});
	  </script><?php */?>
  </div>

  <!-- /. Componetnt Drag and Drop-->

  <!-- /. List Button Start-->
  <div class="alert alert-success" role="alert" style="display:none"></div>
				<div class="alert alert-danger" role="alert" style="display:none"></div>
  <ul class="list-inline list-buttons">
      <li class="list-inline-item"><a href="javascript:void(0);" class="save_btn btn btn-primary submitBtn"
              data-toggle="modal" data-target="#exitmodal">Save</a>
      </li>
      <li class="list-inline-item"><a href="javascript:void(0);"
              class="submit_btn btn btn-primary submitBtn">Submit</a>
      </li>
  </ul>
  
</form>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('public/js/html2canvas.js') }}"></script>
<script type='text/javascript'>
 function screenshot(){
	getScreenshotOfElement($("#droppable").get(0), 0, 70, 690, 447, function(data) {
		$("img#captured").attr("src", "data:image/png;base64,"+data);
		$("#drag_drop_image").val(data);
		
		$('.form_<?php echo $practise['id'];?> .submitBtn').attr('disabled','disabled');
		  var is_save = $(this).attr('data-is_save');
		  $('.is_save:hidden').val(is_save);
		  $.ajax({
			  url: '<?php echo URL('save_drag_drop'); ?>',
			  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			  type: 'POST',
			  data: $('.form_<?php echo $practise['id'];?>').serialize(),
			  success: function (data) {
					$('.form_<?php echo $practise['id'];?> .submitBtn').removeAttr('disabled');
					if(data.success){
						$('.form_<?php echo $practise['id'];?> .alert-danger').hide();
						$('.form_<?php echo $practise['id'];?> .alert-success').show().html(data.message).fadeOut(8000);
					}else{
						$('.form_<?php echo $practise['id'];?> .alert-success').hide();
						$('.form_<?php echo $practise['id'];?> .alert-danger').show().html(data.message).fadeOut(8000);
					}
			  }
		  });
		
		
		
	});
 }
 function getScreenshotOfElement(element, posX, posY, width, height, callback) {
 	$("canvas").remove();
	$("#output_image img").attr("src","");
    $("#drag_drop_image").val('');
	html2canvas(element, {
        onrendered: function (canvas) {
            var context = canvas.getContext('2d');
            var imageData = context.getImageData(posX, posY, width, height).data;
            var outputCanvas = document.createElement('canvas');
            var outputContext = outputCanvas.getContext('2d');
            outputCanvas.width = width;
            outputCanvas.height = height;

            var idata = outputContext.createImageData(width, height);
            idata.data.set(imageData);
            outputContext.putImageData(idata, 0, 0);
            callback(outputCanvas.toDataURL().replace("data:image/png;base64,", ""));
        },
        width: width,
        height: height,
        useCORS: true,
        taintTest: false,
        allowTaint: false
    });
}
 </script>
<script type="text/javascript">
$(document).on('click','.twoBlankTableBtn' ,function() {
  
});
</script> 
<script>
    jQuery(document).ready(function ($) {
        $(".draggable").draggable({
			//helper:"clone",
			//containment:"#droppable"
		});
        $("#droppable").droppable({
            accept: ".draggable",
            classes: {
                "ui-droppable-active": "ui-state-active",
                "ui-droppable-hover": "ui-state-hover"
            },
            drop: function (event, ui) {
				//ui.draggable.parent().appendTo($(this).find("ul"));
                /*$(this)
                    .addClass("ui-state-highlight")
                    .find("p")
                    .html("Dropped!");*/
            }
        });
        $('.form_<?php echo $practise['id'];?> .submitBtn').on('click', function() {
          screenshot();
		  
          // html2canvas($("#droppable"), {
          //   onrendered: function(canvas) {
          //     // canvas is the final rendered <canvas> element
          //     var myImage = canvas.toDataURL("image/png");
          //     console.log(myImage)
          //     window.open(myImage);
          //   }
          // });
        })

    });
</script>
