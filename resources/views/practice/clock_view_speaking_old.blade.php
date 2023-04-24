<script src="{{ asset('public/analog/src/clock-1.1.0.js') }}"></script>

<p>
	<strong><?php
	echo $practise['title'];
	?></strong>
	<?php 
	$userAnswer = array();
	if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
		$userAnswer = $practise['user_answer'];
	}?>
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
		</script>
		<?php }?>
		
		
		<div class="col-sm-12"><br /><br /><br /></div>
		<?php $editableClocks = $questions[1];
		for($i=0;$i<$editableClocks;$i++){ 
		
		if(isset($userAnswer) && !empty($userAnswer)){
			$curClocktiming = $userAnswer[0]['text_ans'][0][$i];
		}else{
			$curClocktiming = array();
		}	
		
		
		?>
			<div id="editableclock<?php echo $i;?>" class="col-sm-4 editableclocks" data-target="#editableclock<?php echo $i;?><?php echo $i;?>" data-toggle="modal">
				<?php if(empty($curClocktiming)){?>
				<div style="width:174px; height:174px; border-radius:100%; border:3px solid #E1EED2"></div>
				<?php }?>
			</div>
			
			<?php if(!empty($curClocktiming)){ ?>
				<script>
					var d = new Date();
					d.setHours(<?php echo $curClocktiming['hour'];?>);
					d.setMinutes(<?php echo $curClocktiming['minute'];?>);
					d.setSeconds(<?php echo $curClocktiming['minute'];?>);
					var clock = $("#editableclock<?php echo $i;?>").clock({
						theme: 't3',
						date: d,
						width:250,
						height:250
					});
					data = clock.data('clock');
					data.pause();
				</script>
			<?php }?>
			
			
			
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
											<?php for($j=1; $j<=12;$j++){?>
											<option value="<?php echo $j;?>" <?php if(!empty($curClocktiming) && $curClocktiming['hour'] == $j){?> selected="selected"<?php }?>><?php echo $j;?></option>
											<?php }?>
										</select>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<select class="minutes form-control" name="editableclocks[<?php echo $i;?>][minute]">
											<?php for($j=1; $j<=59;$j++){?>
												<option value="<?php echo $j;?>" <?php if(!empty($curClocktiming) && $curClocktiming['minute'] == $j){?> selected="selected"<?php }?>><?php echo $j;?></option>
											<?php }?>
										</select>
									</div>
								</div>
							</div>
							
							
						</div>
						<div class="modal-footer justify-content-center">
							<button type="button" class="btn btn-primary addclock" data-index="<?php echo $i;?>">Yes</button>
							<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
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
					var minValue = jQuery("#editableclock"+curIndex+curIndex+" .minutes").val();
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
		<ul class="list-inline list-buttons">
			<li class="list-inline-item"><input type="button" class="save_btn btnSubmits btn btn-primary" value="Save" data-is_save="0"></li>
			<li class="list-inline-item"><input type="button" class="submit_btn btnSubmits btn btn-primary" value="Submit" data-is_save="1"></li>
		</ul>
	</form>
</div>


<script type="text/javascript">
$(document).on('click','#clock_view_<?php echo $practise['id'];?> .btnSubmits' ,function() {
  $('#clock_view_<?php echo $practise['id'];?> .btnSubmits').attr('disabled','disabled');
  if($(this).attr('data-is_save') == '1'){
    $(this).closest('.active').find('.msg').fadeOut();
  }else{
    $(this).closest('.active').find('.msg').fadeIn();
  }
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

