<?php
// echo "<pre>";
// print_r($practise);
// echo "</pre>";
if(!isset($practise['dependingpractiseid'])){

	?>
		@include('practice.reading_no_blanks_roleplay_depend')
	<?php
}else{
	?>
		@include('practice.reading_no_blanks_roleplay_depend_normal')
	<?php
} 
