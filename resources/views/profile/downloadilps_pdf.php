<style>
table,
th {
 	border: 1px solid black;
  }
</style>
<?php if(!empty($student_ilps)) { ?>
<table width="100%">
	<tr>
		<td colspan="4" align="center">ILP-Student Led</td>
	</tr>

	<tr>
		<td colspan="4"><?php echo 'Student Id:-' . ' ' . Session::get('user_id_new');?> </td>
	</tr>

	<tr style="background-color:black;color:white;">
		<td>Course_name</td>
		<td>level_name</td>
		<td>Date</td>
		<td>What did you do?</td>
		<td>How did this help you?</td>
		<td>Comments</td>
	</tr>

		<?php
		usort($student_ilps, function ($a, $b)
		{
			return (int)$b['record_date'] - (int)$a['record_date'];
		});
		$k = 0;
		foreach ($student_ilps as $student_ilp)
		{
		//dd($student_ilp);
		?>
		<tr>
			<td><?php echo $student_ilp['coursename'] ?></td>
			<td><?php echo $student_ilp['lavalname'] ?></td>
			<td><?php echo date("d-m-Y", strtotime($student_ilp['record_date'])); ?></td>
			<td><?php echo $student_ilp['what_did_you_do']; ?></td>
			<td><?php echo $student_ilp['how_did_this_help']; ?></td>
			<td><?php echo $student_ilp['comments']; ?></td>
		</tr>
		<?php
		 $k++;
		}
		?>
		<?php 
		if ($k == 0)
		{ 
			?>
		<tr>
			<td colspan="4">No Records Found</td>
		<?php
			} 
		?>
	</tr>
</table>

<?php } ?>


<style>
	table, th { border: 1px solid black;  }
</style>

<?php 
	if(!empty($teacher_ilps)) { 
?>
<table width="100%">
	<tr>
		<td colspan="4" align="center">ILP-Teacher Led</td>
	</tr>

	<tr style="background-color:black;color:white;">
		<td>Created On</td>
		<td>Target</td>
		<td>Next Review Date</td>
		<td></td>
	</tr>
	<?php
	$s = 0;
	foreach ($teacher_ilps as $teacher_ilp)
	{
	?>                                    
	<tr>
		<td><?php echo date("d-m-Y", strtotime($teacher_ilp['created_at'])); ?></td>
		<td><?php echo $teacher_ilp['end_target']; ?></td>
		<td><?php echo date("d-m-Y", strtotime($teacher_ilp['new_next_review_date'])); ?></td>
		<td></td>
	</tr>
	<!-- /. Card -->
	<?php $s++;
	} ?>
	<?php if ($s == 0)
	{ ?>

	<tr>

		<td colspan="4">No Records Found</td>
		<?php
		} ?>
	</tr>
</table>
<?php } ?>