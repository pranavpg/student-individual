<p>
	<strong><?php
    // dd($practise);
	echo $practise['title'];
?></strong>
</p>
<style type="text/css">
	*[contenteditable]:empty:before {
		content: "\feff";
	}

	.appendspan {
		color:red;
	}
</style>
<form class="save_reading_no_blank_no_space_form_{{$practise['id']}}">
	<input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
	<input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
	<input type="hidden" class="is_save" name="is_save" value="">
	<input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
	<?php 

	if (strpos($practise['question'], '#!') !== false) {
		$Tapescript  =  explode("#!", $practise['question']);
		$modelLable  =  explode("#%", $Tapescript[0]);
		$exploded_question  =  explode(PHP_EOL, $Tapescript[1]);
	}else{
		$exploded_question  =  explode(PHP_EOL, $practise['question']);
	}
	// dd($exploded_question);
	if( isset($practise['user_answer']) && !empty($practise['user_answer'])){
		$practise['user_answer'][0] = str_replace("&nbsp;", " ",$practise['user_answer'][0]);
		$usrAns = explode(';',$practise['user_answer'][0]);

	}
	$i=0 ; $k=0;
	// echo '<pre>'; print_r( $usrAns); exit;
	if (strpos($practise['question'], '#!') !== false) {
		?>

		<div style="text-align: center;">
			<button class="btn btn-info" id="openmodal" style="margin-bottom: 16px;">{{$modelLable[0]}}</button>
		</div>
	<?php } ?>
	<div class="paragraph-noun text-left">
		@foreach($exploded_question as $key=> $item)

		<?php $questions  = explode("<br>",$item); ?>
		@foreach($questions as $question)

		@if(strpos($question,"@@"))
		<?php
		$question = str_replace('@@','***@@',$question);
		$exQuestion= explode('@@',$question);
		// dd($exQuestion);
		?>
		<ul class="list-inline">

			@foreach($exQuestion as $eq)
			@if(strpos($eq,"***"))
			<li class="list-inline-item">
				<?php
				if(isset($usrAns[$i])){
					$ans= $usrAns[$i++];

				}else{
					$ans= "";
				}

				?>

				<?php echo str_replace('***','<span class="resizing-input1" style="margin-left: -3px;">
					<span contenteditable="true" class="enter_disable spandata fillblanks stringProper text-left">'.$ans.'</span>
					<input type="hidden" class="form-control form-control-inline appendspan" name="writeingBox['.$k++.']" value="'.$ans.'">
					</span>',$eq);  ?>

				</li>
				@else
				{{$eq}}
				@endif
				@endforeach

			</ul>
			@else
			@if($question == '@@')
			<?php
			$question = str_replace('@@','***@@',$question);
			$exQuestion= explode('@@',trim($question));
			?>
			<ul class="list-inline">

				@foreach($exQuestion as $eq)
				@if(isset($eq) && !empty($eq))
				<li class="list-inline-item">
					<?php
					if(isset($usrAns[$i])){
						$ans= $usrAns[$i++];

					}else{
						$ans= "";
					}
					?>
					<?php echo str_replace('***','<span class="resizing-input1" style="margin-left: -3px;">
						<span contenteditable="true" class="enter_disable spandata fillblanks stringProper text-left">'.$ans.'</span>
						<input type="hidden" class="form-control form-control-inline appendspan" name="writeingBox['.$k++.']" value="'.$ans.'">
						</span>',$eq);  ?>

					</li>

					@endif
					@endforeach
				</ul>
				@else
				<p>{!!$question!!}</p>
				@endif

				@endif

				@endforeach

				@endforeach
			</div>

			<div class="alert alert-success mt-4" role="alert" style="display:none"></div>
			<div class="alert alert-danger mt-4" role="alert" style="display:none"></div>
			<ul class="list-inline list-buttons mt-4">
				<li class="list-inline-item">
					<input type="button" class="save_btn readingNoBlakNoSpace_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
				</li>
				<li class="list-inline-item">
					<input type="button" class="submit_btn readingNoBlakNoSpace_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">

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
		<?php  if (strpos($practise['question'], '#!') !== false) { ?>
			<div id="myModal" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">{!! $modelLable[0] !!}</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">{!! $modelLable[1] !!}</div>
						<div class="modal-footer justify-content-center">
							<button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
						</div>
					</div>

				</div>
			</div>
		<?php } ?>



		<script>



			$(document).ready(function(){
				setTimeout(function(){
// alert("Asd")
$('.appendspan').each(function(){
            // alert($(this).val())
          // alert($(this).val())
            // alert($(this).closest('.resizing-input1').find('.enter_disable').attr("class"))
            $(this).closest('.resizing-input1').find('.enter_disable').text("")
            $(this).closest('.resizing-input1').find('.enter_disable').text($(this).val())
          });
},500)
			})

			$(document).on('keyup','.spandata',function(){
				$(this).next().val($(this).html())
			})

			function CommonAnsSet(){
				$('.spandata').each(function(){
					$(this).next().val( $(this).html() )
				})
			}

			$(document).ready(function(){

				$('#openmodal').click(function(){
					$('#myModal').modal("show")
					return false;
				})
			});

			$(document).on('click',".readingNoBlakNoSpace_{{$practise['id']}}" ,function() {

				if($(this).attr('data-is_save') == '1'){
					$(this).closest('.active').find('.msg').fadeOut();
				}else{
					$(this).closest('.active').find('.msg').fadeIn();
				}


				CommonAnsSet();
				var reviewPopup = '{!!$reviewPopup!!}';
				var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
				if(markingmethod =="student_self_marking"){
					if($(this).attr('data-is_save') == '1'){
						var fullView= $(".save_reading_no_blank_no_space_form_{{$practise['id']}}").html();
						$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
						$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
						$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
						$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
						$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
						$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.spandata').attr("contenteditable","false");
					}
				}
				if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){

					$("#reviewModal_{{$practise['id']}}").modal('toggle');

				}
				$(".readingNoBlakNoSpace_{{$practise['id']}}").attr('disabled','disabled');
				var is_save = $(this).attr('data-is_save');
				$('.is_save:hidden').val(is_save);

				$.ajax({
					url: "{{url('reading-no-blanks-no-space')}}",
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					type: 'POST',
					data: $(".save_reading_no_blank_no_space_form_{{$practise['id']}}").serialize(),
					success: function (data) {
						$(".readingNoBlakNoSpace_{{$practise['id']}}").removeAttr('disabled');

						$('.alert-success').show().html(data.message).fadeOut(8000);

					}
				});


			});
		</script>
