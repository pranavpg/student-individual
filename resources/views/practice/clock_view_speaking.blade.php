<script src="{{ asset('public/analog/src/clock-1.1.0.js') }}"></script>
<p>
	<strong>
		<?php
			echo $practise['title'];
			//pr($practise);
		?>
	</strong>
	<?php
		$userAnswer = array();
		if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
			$userAnswer = $practise['user_answer'];
		}
	?>
</p>

    <div class="table-container">
      <form class="clock_view" id="clock_view_<?php echo $practise['id'];?>">
        <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
        <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
        <input type="hidden" class="is_save" name="is_save" value="">
        <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
        <div class="container">
			<div class="row">

			<div class="col-sm-12">
			@include('practice.common.audio_record_div',['key'=>0])
			<input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="clock_view_speaking" value="0">

			</div>


				<?php $questions = explode(PHP_EOL, $practise['question']);
		$clocks = explode("@@",$questions[0]);
		foreach($clocks as $i=>$clock){

		$clock = trim($clock);
		$clock = explode(":",$clock);
		?>
			<div id="clock<?php echo $i;?>" class="col-sm-4 customclocks"></div>

			<input type="hidden" name="clock[<?php echo $i;?>][hour]" value="<?php echo $clock[0];?>" />
			<input type="hidden" name="clock[<?php echo $i;?>][minute]" value="<?php echo $clock[1];?>" />



			<script>
				var d = new Date();
				d.setHours(<?php echo $clock[0];?>);
				d.setMinutes(<?php echo $clock[1];?>);
				d.setSeconds(<?php echo $clock[1];?>);
				var clock = $("#clock<?php echo $i;?>").clock({
					theme: 't3',
					date: d,
					width:250,
					height:250
				});
				data = clock.data('clock');
				data.pause();

				$('#clock<?php echo $i;?>').append('<div class="clock-overlay" style="background-color: #fff; height: 50px; position: relative; margin-top: 194px"></div>');
			</script>
		<?php }?>


		<div class="col-sm-12"><br /><br /><br /></div>
		<?php $editableClocks = $questions[1];

		for($i=0;$i<$editableClocks;$i++){

		if(isset($userAnswer) && !empty($userAnswer) && !empty($userAnswer[0]['text_ans'][0][$i]['hour'])){
			$curClocktiming = $userAnswer[0]['text_ans'][0][$i];
		}else{
			$curClocktiming = array();
		}


		?>
			<div id="editableclock<?php echo $i;?>" class="col-sm-4 editableclocks" data-target="#editableclock<?php echo $i;?><?php echo $i;?>" data-toggle="modal">
				<?php if(empty($curClocktiming)){?>
					<div style="width:174px; height:174px;margin-bottom:50px; border-radius:100%; border:3px solid #E1EED2"></div>
				<?php }?>
			</div>


				<script>
                    <?php if(!empty($curClocktiming)): ?>

                        var d = new Date();

                        d.setHours(<?php echo (int)$curClocktiming['hour'];?>);
                        d.setMinutes(<?php echo (int)$curClocktiming['minute'];?>);
                        //d.setSeconds(<?php echo (int)$curClocktiming['minute'];?>);

                        var t = d.getHours() +":"+ d.getMinutes();
                        var clock = $("#editableclock<?php echo $i;?>").clock({
                            theme: 't3',
                            date: d,
                            width:250,
                            height:250
                        });
                        data = clock.data('clock');
                        data.pause();
						$('#editableclock<?php echo $i;?>').append('<div class="clock-overlay" style="background-color: #fff; height: 50px; position: relative; margin-top: 194px"></div>');

                    <?php endif ?>
				</script>





			<div class="modal fade editableclockModal" id="editableclock<?php echo $i;?><?php echo $i;?>">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header justify-content-center">
							<h5 class="modal-title" id="erasemodalLongTitle">Add Clock Time</h5>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<select class="hour form-control" name="editableclocks[<?php echo $i;?>][hour]">
												<option value="" selected>Select Hour</option>
											@for($j=1; $j<=12;$j++)
												@if(!empty($curClocktiming) && $curClocktiming['hour'] == $j)
													<option value="<?php echo $j;?>" <?php if(!empty($curClocktiming) && $curClocktiming['hour'] == $j){?> selected="selected"<?php }?>><?php echo $j;?></option>
												@else
														<option value="<?php echo $j;?>" ><?php echo $j;?></option>
												@endif
											@endfor
										</select>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<select class="minutes form-control" name="editableclocks[<?php echo $i;?>][minute]">
											<option value="0" selected>Select Minute</option>
											@for($k=1; $k<=59;$k++)
												@if(!empty($curClocktiming) && $curClocktiming['minute'] == $k)
													<option value="<?php echo $k;?>" <?php if(!empty($curClocktiming) && $curClocktiming['minute'] == $k){?> selected="selected"<?php }?>><?php echo $k;?></option>
												@else

													<option value="<?php echo $k;?>"><?php echo $k;?></option>
												@endif
											@endfor
										</select>
									</div>
								</div>
							</div>


						</div>
						<div class="modal-footer justify-content-center">
							<button type="button" class="btn btn-primary addclock" data-index="<?php echo $i;?>">Yes</button>
							<button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
		<?php }?>

		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery(".addclock").on("click",function(){
			 
					var curIndex = jQuery(this).attr("data-index");
					var d = new Date();
					var hourValue = jQuery("#editableclock"+curIndex+curIndex+" .hour").val();
					if($.trim(hourValue) == "" ){
						hourValue = 1;
						//alert('#editableclock'+curIndex.toString()+curIndex.toString())
						$('#editableclock'+curIndex.toString()+curIndex.toString() ).find('.hour').val(1)
					}
					var minValue = jQuery("#editableclock"+curIndex+curIndex+" .minutes").val();
					if($.trim(minValue) == "" ){
						minValue=0;
						
						$('#editableclock'+curIndex.toString()+curIndex.toString() ).find('.minutes').val(0)
					}
					d.setHours(hourValue);
					d.setMinutes(minValue);
					d.setSeconds(minValue);
					$("#editableclock"+curIndex+" div").remove();
					var clock = $("#editableclock"+curIndex).clock({
						theme: 't3',
						date: d,
						width:250,
						height:250
					});
					data = clock.data('clock');
					data.pause();
					$('#editableclock'+curIndex).append('<div class="clock-overlay" style="background-color: #fff; height: 50px; position: relative; margin-top: 194px"></div>');

					jQuery("#editableclock"+curIndex+curIndex).modal("toggle");
				})
			})
		</script>



			</div>




		</div>



		<br /><br />


		<div class="alert alert-success" role="alert" style="display:none"></div>
		<div class="alert alert-danger" role="alert" style="display:none"></div>
		<input type="hidden" name="speaking_one" value="true" />
        <input type="button" class="btnSubmits btn btn-primary" value="Save" data-is_save="0">
        <input type="button" class="btnSubmits btn btn-primary" value="Submit" data-is_save="1">


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
    </div>


<script type="text/javascript">
var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
// $('.customclocks, .editableclocks').each(function(){
// 	$(this).find(':last-child').hide()
// })


$(document).on('click','#clock_view_<?php echo $practise['id'];?> .btnSubmits' ,function() {
	if($(this).attr('data-is_save') == '1'){
	    $(this).closest('.active').find('.msg').fadeOut();
	  }else{
	    $(this).closest('.active').find('.msg').fadeIn();
	  }
	var reviewPopup = '{!!$reviewPopup!!}';
    var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){
                    var fullView= $('#clock_view_<?php echo $practise['id'];?> ').html();
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
  $('#clock_view_<?php echo $practise['id'];?> .btnSubmits').attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.is_save:hidden').val(is_save);
  $.ajax({
      url: '<?php echo URL('clock_submit'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('#clock_view_<?php echo $practise['id'];?> ').serialize(),
      success: function (data) {
        $('#clock_view_<?php echo $practise['id'];?> .btnSubmits').removeAttr('disabled');
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
