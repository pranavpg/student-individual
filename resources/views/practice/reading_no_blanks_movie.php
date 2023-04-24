
<p>
	<strong><?php
	// dd($practise);
	echo $practise['title'];
	?></strong>
</p>

<?php 
$exploded_question  =  explode(PHP_EOL, $practise['question']);
$answerExists = false;
if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
	$userAnswer = array();
	$userAnswer = $practise['user_answer'][0];
	$userAnswer = explode(";",$userAnswer);
}
?>

    <div class="table-container">
      <form class="reading-no-blanks_form_<?php echo $practise['id'];?>">
        <input type="hidden" class="topic_id" name="topic_id" value="<?php echo $topicId;?>">
        <input type="hidden" class="task_id" name="task_id" value="<?php echo $taskId;?>">
        <input type="hidden" class="is_save" name="is_save" value="">
        <input type="hidden" class="practise_id" name="practise_id" value="<?php echo $practise['id'];?>">
        
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery("#show_hide_movie").on("click",function(){
					var curType = jQuery(".reading-no-blanks_form_<?php echo $practise['id'];?> ul li").last().find("input").attr("type");
					if(curType == "password"){
						jQuery(".reading-no-blanks_form_<?php echo $practise['id'];?> ul li").last().find("input").attr("type","text");
						jQuery(this).text("Hide");
					}else{
						jQuery(".reading-no-blanks_form_<?php echo $practise['id'];?> ul li").last().find("input").attr("type","password");
						jQuery(this).text("Show");
					}
				})
			})
		</script>
		
		<ul class="list-unstyled">
		<?php 
		$k = 0;
		// echo "<pre>";
		// print_r($exploded_question);
		// echo "</pre>";

		$exploded_question = array_filter($exploded_question);
        $exploded_question = array_merge($exploded_question);
        $tempArray = array();
        foreach($exploded_question as $new => $data){
            if($data!="\r"){
                array_push($tempArray,$data);
            }
        }
        $exploded_question = $tempArray;

        
		foreach($exploded_question as $key=>$question){
			if($question==""){ echo "<li><br></li>"; continue;}
			$value = '';
			if(isset($userAnswer[$key]) && !empty($userAnswer[$key])){
				$value = $userAnswer[$key];
			}
			$question = str_replace("@@",'<span class="resizing-input '.$key.'"><input type="text" class="form-control form-control-inline rounded-0" name="blanks[]" style="text-align:left;padding-left:0px;padding-right:0px;" value="'.$value.'"><span style="display:none"></span></span>',$question);
			?>
			<li><?php echo $question;?></li>
		<?php $k++; }?>
		
		
	</ul>
	
	<p><a href="javascript:void(0);" id="show_hide_movie" class="btn btn-dark">Hide</a></p>
		
		
        <div class="alert alert-success" role="alert" style="display:none"></div>
		<div class="alert alert-danger" role="alert" style="display:none"></div>
        <input type="button" class="save_btn btnSubmits btn btn-primary" value="Save" data-is_save="0">
        <input type="button" class="submit_btn btnSubmits btn btn-primary" value="Submit" data-is_save="1">
      </form>
    </div>


<script type="text/javascript">
$(document).on('click','.reading-no-blanks_form_<?php echo $practise['id'];?> .btnSubmits' ,function() {
	if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }
  $('.reading-no-blanks_form_<?php echo $practise['id'];?> .btnSubmits').attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.is_save:hidden').val(is_save);
  $.ajax({
      url: '<?php echo URL('reading-no-blanks'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('.reading-no-blanks_form_<?php echo $practise['id'];?>').serialize(),
      success: function (data) {
        $('.reading-no-blanks_form_<?php echo $practise['id'];?> .btnSubmits').removeAttr('disabled');
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