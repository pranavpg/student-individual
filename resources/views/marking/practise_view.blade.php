<div class="row">
	<div class="col-12">
		<div class="course-tab-content"> 
			<div class="tab-content pl-2" id="pills-teacher--tabContent">
				<?php
					$practise 				= $practises;
					$markingmethod 			= $practises['markingmethod'];
					$comment 				= html_entity_decode(json_encode($practises['teacher_comment']));
					$top_book_class			="";
					$content_shrink_class 	= "";
					if( empty( $practise['marks_gained'] ) ) {
						$save_btn_class = "justify-content-center";
					} else {
						$save_btn_class = "justify-content-end";
						$content_shrink_class = "course-content_shrink";
					}
					// echo "<pre>";
					// print_r($practises);
					// echo "</pre>";
					// dd();
				?>
				<div class="tab-pane fade show active" id="abc-<?php echo $practise['id'];?>" >
					<input type="hidden" value="{{ $practise['student_practise_id'] }}" class="student_practise_id">
					<input type="hidden" value="{{ $practise['markingmethod'] }}" id="markingmethod">
					<input type="hidden" value="{{ $taskId }}" id="taskId" class="taskId">
					<fieldset class="practice-fieldset">
						<div class="mb-4 pr-3 allow_draw" id="{{$markingmethod=='manual'?'allow_draw_0':''}}">
							@include('common.practice-types')
						</div>
						@if($markingmethod=='manual')
							<img style="display:block;" class="getDrawMarkingImage">
						@endif
					</fieldset>
				</div>
			</div>
		</div>
	</div>
</div>
<link rel="stylesheet" type="text/css" href="{{url('public/audio/css/demo.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/audio/css/audioplayer.css')}}">
<script src="{{  url('public/audio/js/audioplayer.js') }}"></script>
<script type="text/javascript">
	$(function(){
		$('.practice_audio').audioPlayer();
		setTimeout(() => {
		  $('.audioplayer-playpause').fadeIn();
		},3000);
	});
	var marks_gained 	= "{{ $practises['marks_gained'] }}";
	var teacher_emoji 	= "{{ $practises['teacher_emoji'] }}";
	var teacher_comment = {!! $comment !!};
	var marks 			= "{{ isset($practises['mark'])?$practises['mark']:'0' }}";
/*	alert(teacher_comment);
	alert(marks);
	alert(marks_gained);
	alert(teacher_emoji);*/
	window.flagForsubmit= true;
  	$('.mark').val(marks_gained);
	$('.mark').attr("onkeyup","this.value = minmax(this.value, 0, "+marks+")");
	$('.orignal_mark').html("/"+marks);
	$('.orignal_mark').attr("data",marks);
	$('.comment').val(teacher_comment);
	$('.emoji').removeClass("active");
	if(teacher_emoji!=""){
		$('.emoji').eq(teacher_emoji-1).addClass("active");
	}
	if(window.findParent == 3){
		window.flagForsubmit 	= false;
	}

	$(document).ready(function(){
		$('.stringProper').css('pointer-events','none');
		$('.enter_disable').attr("contenteditable","false");
		$('.spandata').attr("contenteditable","false");
		$('.fillblanks').attr("contenteditable","false");
		$('.fillblanks').attr("contenteditable","false");
		$('.textarea').attr("contenteditable","false");
		$('.resizing-input1').attr("contenteditable","false");
		$('.resizing-input1').css("border-bottom","none");
	});
</script>
