<style type="text/css">
.single-block{ border:1px solid #000000; min-width:100%; min-height:50px; text-align:center; line-height:50px; color:#000; border-radius:10px;}
</style>
<p>
	<strong><?php
	echo $practise['title'];
	?></strong>
	<div style="text-align:center">
    <div id="dice" style="color: #000;"></div>
	</div>
	<style type="text/css">#dice {font-size: 6rem;}</style>
	<script type="text/javascript">
	jQuery(document).ready(function(){

		jQuery("#dice").on('click',function(){
			rollTheDice();
		})
		jQuery("#dice").trigger("click");
	})
	//document.querySelector('input[type=button]').addEventListener('click', function(){rollTheDice();});
	function rollTheDice() {
		var i,
			faceValue,
			output = '',
			diceCount = 1;
		for (i = 0; i < diceCount; i++) {
			faceValue = Math.floor(Math.random() * 6);
			output += "&#x268" + faceValue + "; ";
		}
		document.getElementById('dice').innerHTML = output;
	}
	</script>


	<?php




	$mainQuestion = explode("#!",$practise['question']);
	//echo "<pre>"; print_r($mainQuestion); exit;
	$groupMAterial = $mainQuestion[0];
	$question = $mainQuestion[1];
	//echo "<pre>"; print_r($question); exit;
	$questionSeperation = explode("##",$question);
	$materialSeperation = explode("#@",$groupMAterial);
	array_pop($materialSeperation);

	$materials = explode("@@",$materialSeperation[1]);

	$options = $practise['options'];

	$allOptions = array();
	foreach($options as $option){
		if($option[0] == "##"){
			$i++;
			//$allOptions[$i] = $option[0];
		}else{
			$allOptions[$i][] = $option[0];
		}

	}

	$userAnswer = array();
	if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
		$userAnswer = $practise['user_answer'];
		$customAnswer = array();
		foreach($userAnswer as $userAnswerk){
			if($userAnswerk !== "##"){
				$customAnswer[] = $userAnswerk;
			}
		}
		$userAnswer = $customAnswer;
	}?>
</p>
    <div class="table-container">



		<div class="container">
			<div class="row">
			<?php $displayBlocks = explode(" @@ ",$questionSeperation[0]);
			$differentPractises = array();
			foreach($displayBlocks as $i=>$displayBlock){
				$curMaterials = explode(":",$materials[$i]);
				$differentPractises[] = $curMaterials[4];
			?>
				<div class="col-sm-3" style="margin-bottom:20px;">
					<div class="single-block" style=" <?php if($curMaterials[0] == -1){?> cursor:none; pointer-events:none; <?php }?> background:<?php echo $curMaterials[1];?>; color:<?php echo $curMaterials[2];?>; border-color:<?php echo $curMaterials[2];?>;" <?php if(!empty($curMaterials[4])){?> data-toggle="modal" data-target="#practise_block_<?php echo $practise['id'];?>_<?php echo $i;?>"<?php }?>>
						<?php echo $displayBlock;?>
					</div>

					<?php if(!empty($curMaterials[4])){?>


						<div class="modal fade" id="practise_block_<?php echo $practise['id'];?>_<?php echo $i;?>">
							<div class="modal-dialog modal-dialog-centered" role="document" style="max-width:700px;">
								<div class="modal-content">
									<div class="modal-header justify-content-center">
										<h5 class="modal-title" style="color:#d55b7d"><?php echo $displayBlock;?></h5>
									</div>
									<form class="board_game" id="board_game_<?php echo $practise['id'];?>_<?php echo $i;?>">
									<div class="modal-body">

											<input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
											<input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
											<input type="hidden" class="is_save" name="is_save" value="">
											<input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
											<input type="hidden" name="answer_index" value="<?php echo $i;?>" />


										   <?php if($curMaterials[4] == "writing"){?>
										   <p><?php echo $questionSeperation[$i+1];?></p>
										   <div class="form-group d-flex align-items-end form-group-label">
												  <?php
												  $value = '';
												  if(isset($userAnswer[$i]) && !empty($userAnswer[$i])){
												  	$value = $userAnswer[$i];
												  }?>
												  <input type="text" class="form-control" placeholder="Write here..." name="writeingBox[]" value="<?php echo $value;?>" />
											  </div>
										   <?php }elseif($curMaterials[4] == "reading_total_blanks"){?>


										   <?php
										   if(isset($allOptions[$i]) && !empty($allOptions[$i])){?>
											<div class="match-answer">
												<div class="form-slider w-100 mr-auto ml-auto mb-5">
													<div class="owl-carousel owl-theme">
														<div class="item">
															<div class="table-slider-box ietsb-mobv text-center d-flex flex-wrap">
																<?php foreach($allOptions[$i] as $options){?>
																<div class="w-33 ietsob-mobv table-option border">
																	<a href="javascript:void(0);"><?php echo $options;?></a>
																</div>
																<?php }?>
															</div>
														</div>
													</div>
												</div>
												<!-- /. Table Slider-->
											</div>
											<ul class="list-unstyled">
												<li>
													<?php
													$value = '';

												  $value = '';
												  if(isset($userAnswer[$i]) && !empty($userAnswer[$i])){
												  	$value = $userAnswer[$i][0];
												  	$value = str_replace(";","",$value);
												  }


													$disQue = str_replace("@@",'<span class="resizing-input"><input type="text" class="form-control form-control-inline" name="blanks[]" style="text-align:left" value="'.$value.'"><span style="display:none"></span></span>',$questionSeperation[$i+1]);
													echo $disQue;
													?>
												</li>
											</ul>
											<?php }?>

										    <?php }elseif($curMaterials[4] == "four_blank_table"){?>
											 <?php
											 $exploded_question = explode(PHP_EOL, $questionSeperation[$i+1]);
											 $table_header = explode('@@', $exploded_question[0]);
											 $columnsStartWith = 0;
											$firstColumns = explode('@@', $exploded_question[$columnsStartWith]);
											$totalColumnCounts = $exploded_question[1];
											$columnCount = 4;
											$columnClass = 'w-25';
											$countElement = 0;
											?>
											<div class="table-container mb-4 text-center">
												<div class="table m-auto">
													<?php if($columnCount > 1 && !empty($table_header)){?>
														<div class="table-heading thead-dark d-flex justify-content-between">
															<?php foreach ($table_header as $table_head) { ?>
															<div class="d-flex justify-content-center align-items-center th <?php echo $columnClass; ?>"><?php echo $table_head; ?></div>
															<div style="display:none">
																<textarea name="col[]"><?php echo $table_head; ?></textarea>
																<input type="hidden" name="true_false[]" value="false" />
															</div>
															<?php $countElement++;} ?>
														</div>
														<?php }?>

												</div>


											<?php
											if(isset($totalColumnCounts)){
												for ($j = 0;$j < $totalColumnCounts;$j++) { ?>
												<div class="table-row thead-dark d-flex justify-content-between">
													<?php for ($k = 1;$k <= $columnCount;$k++) { ?>
														<div class="d-flex justify-content-center align-items-center  border-left td <?php echo $columnClass; ?> <?php if($columnCount == 4){ echo "border-right";}?> td-textarea">
															<span class="textarea form-control form-control-textarea" role="textbox" contenteditable placeholder="Write here...">
															<?php
															$value = '';
															if(isset($userAnswer[$i]) && !empty($userAnswer[$i])){
																$value = $userAnswer[$i][0][0][$j + 1]['col_' . $k];
															}
															echo $value;
															?>
															</span>
															<div style="display:none">
																<textarea name="col[]"><?php echo $value;?></textarea>
																<input type="hidden" name="true_false[]" value="true" />
															</div>
														</div>
													<?php $countElement++;}?>
												</div>
												<?php }
											}
											?>

											<?php }?>






											<div class="alert alert-success" role="alert" style="display:none"></div>
											<div class="alert alert-danger" role="alert" style="display:none"></div>
											<input type="hidden" name="practise_type" class="practise_type" value="<?php echo $curMaterials[4];?>" />


									</div>
									<div class="modal-footer justify-content-center">
										<input type="button" class="save_btn btnSubmitssss btn btn-primary" value="Save" data-is_save="0" data-id="board_game_<?php echo $practise['id'];?>_<?php echo $i;?>">
										<input type="button" class="submit_btn btnSubmitssss btn btn-primary" value="Submit" data-is_save="1" data-id="board_game_<?php echo $practise['id'];?>_<?php echo $i;?>">
                                    </div>


                                     </form>


								</div>
							</div>
						</div>

					<?php }?>



                </div>


			<?php }?>
			</div>
        </div>
        <div class="alert alert-success" role="alert" style="display:none"></div>
		<div class="alert alert-danger" role="alert" style="display:none"></div>
        <ul class="list-inline list-buttons">
            <li class="list-inline-item">
                <input type="button" class="btn btn-primary" value="Save" data-is_save="0">
            </li>
            <li class="list-inline-item">
                <input type="button" class="btn btn-primary" value="Submit" data-is_save="1">
            </li>
        </ul>
    </div>

<script src="{{asset('public/js/owl.carousel.js')}}"></script>
<script>

    $(document).ready(function(){
        $('.btn-primary').on('click', function(e){
            e.preventDefault();
            $('.alert-success').show().html("All answers successfully submitted.").fadeOut(8000);
        })
    })

	function setTextareaContent(){
		$("span.textarea.form-control").each(function(){
			var currentVal = $(this).html();
			$(this).next().find("textarea").val(currentVal);
		})
	}
	$(function () {
		$('.owl-carousel').owlCarousel({
			loop: true,
			margin: 10,
			nav: true,
			items: 1
		})
		<?php foreach($displayBlocks as $i=>$displayBlock){ ?>
		$('#practise_block_<?php echo $practise['id'];?>_<?php echo $i;?> .resizing-input input').on('focus',function(){
			$('#practise_block_<?php echo $practise['id'];?>_<?php echo $i;?> .resizing-input input').removeClass("active");
			$(this).addClass("active");
		})
		$("#practise_block_<?php echo $practise['id'];?>_<?php echo $i;?> .match-answer .table-slider-box .table-option a").on('click',function(){
			if($('#practise_block_<?php echo $practise['id'];?>_<?php echo $i;?> .resizing-input input.active').length > 0){
				var curText = $(this).text();
				$('#practise_block_<?php echo $practise['id'];?>_<?php echo $i;?> .resizing-input input.active').val(curText);
				//$('#image_reading_total_blanks_<?php echo $practise['id'];?> .resizing-input input.active').removeClass("active");
			}
		})
		$('#practise_block_<?php echo $practise['id'];?>_<?php echo $i;?> .resizing-input input').keypress(function(e) {
			return false
		});
		<?php }?>
	});
</script>
<script type="text/javascript">
$(document).on('click','.btnSubmitssss' ,function() {
	var curId = $(this).attr("data-id");
	var actionNAme = $("#"+curId+" .class").val();
  $('#'+curId+' .btnSubmitssss').attr('disabled','disabled');
  if($(this).attr('data-is_save') == '1'){
    $(this).closest('.active').find('.msg').fadeOut();
  }else{
    $(this).closest('.active').find('.msg').fadeIn();
  }
  var is_save = $(this).attr('data-is_save');
  $('#'+curId+' .is_save:hidden').val(is_save);
  setTextareaContent();
  $.ajax({
      url: '<?php echo URL('board_game_post'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('#'+curId).serialize(),
      success: function (data) {
        	$('.btnSubmitssss').removeAttr('disabled');
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

