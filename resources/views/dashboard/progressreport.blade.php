@extends('layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&family=Roboto:wght@100;300;400;500;700&display=swap"
rel="stylesheet">
<!--<link href="{{asset('public/css/style.css')}}" rel="stylesheet">-->
<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
<style>
	.mb-menu { display: none; }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>

<div class="back d-block d-md-none">
	<a href="{{url('porfolio_assessment')}}" class="btn btn-sm btn-light open-filter backbtn">
		<span class="mobonly"><img src="{{asset('public/images/icon-back-white.svg')}}" alt="" class="img-fluid" width="14px"></span>
	</a>
</div>


<main class="dashboard">
	<div class="container-fluid">
		<div class="row">
			@include('common.sidebar')
			<section class="main notes ieuk-wrm col-sm-12">
				<div class="summary-heading p-3">
					<a href="{{url('porfolio_assessment')}}" class="back-button position-absolute"><i class="fa-solid fa-chevron-left"></i> back</a>
					<h1 class="text-center pageheading"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Student Progress Report</h1>
				</div>
				<div class="main__content progress-report">
					<div class="row">
						<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-4">
							<div class="progress-details">
								<h4>Student Details</h4>
								<div class="row p-3">
									<div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-6">
										<h6>Student ID</h6>
										<h5>{{$student_details['student_id'] ?? ""}}</h5>
									</div>
									<div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-6">
										<h6>Student Name</h6>
										<h5>{{$student_details['student_name'] ?? ""}}</h5>
									</div>
									<div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-6">
										<h6>Course Name</h6>
										<h5>{{$student_details['student_course'] ?? ""}}</h5>
									</div>
									<div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-6">
										<h6>Course Level</h6>
										<h5>{{$student_details['course_level'] ?? ""}}</h5>
									</div>
									<div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-12">
										<h6>Student Email</h6>
										<h5>{{$student_details['student_email'] ?? ""}}</h5>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-4">
							<div class="progress-details">
								<h4>Course Progress Details</h4>
								<div class="row p-3">
									<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
										<h6>Submission</h6>
										<h6>(No. of Tasks / Total Tasks)</h6>
										<h5>{{$course_progress_detail['total_submission']}}</h5>
										<h6>Submission Completed</h6>
										<h5>{{$course_progress_detail['total_submission_pr']}}</h5>
									</div>
									<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
										<h6>Achievement</h6>
										<h6>(No. of Marks / Total Marks)</h6>
										<h5>{{$course_progress_detail['total_achievement']}}</h5>
										<h6>Achievement Completed</h6>
										<h5>{{$course_progress_detail['total_achievement_pr']}}</h5>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-4 mb-4">
							<div class="progress-details">
								<h4>Skill Wise Progress Details</h4>
								<div class="row pl-3 pr-3 pb-3">
									<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
										<div class="table-responsive">
											<table class="table border-0">
												<thead>
													<tr>
														<th>Skill Area</th>
														<th>Total Marks</th>
														<th>Total Marks(%)</th>
													</tr>
												</thead>
												<tbody>
													@if(!empty($progress_by_skill))
													@foreach($progress_by_skill as $item1)
													<tr>
														<td>{{$item1['skill_area']}}</td>
														<td>{{$item1['total_marks']}}</td>
														<td>{{$item1['total_marks_pr']}}</td>
													</tr>
													@endforeach
													@else
													<tr>
														<td colspan="3">No Record Found</td>
													</tr>
													@endif
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-4">
							<div class="progress-details">
								<h4>Attendance Details</h4>
								<div class="row pl-3 pr-3 pb-3">
									<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
										<div class="table-responsive">
											<table class="table border-0">
												<thead>
													<tr>
														<th>Class Name</th>
														<th>Total Hours</th>
														<th>Total Attended hours</th>
														<th>Attendance(%)</th>
														<th>Times Present</th>
														<th>Times Absent</th>
														<th>Times Authorised Absent</th>
														<th>Times Late</th>
													</tr>
												</thead>
												<tbody>
													@if(!empty($class_record))
													@foreach($class_record as $item)
													<tr>
														<td>{{$item['class_name']}}</td>
														<td>{{$item['total_hour']}}</td>
														<td>{{$item['attended_hours']}}</td>
														<td>{{$item['attendance_ratio']}}%</td>
														<td>{{$item['time_present']}}</td>
														<td>{{$item['times_absent']}}</td>
														<td>{{$item['times_authorised_absent']}}</td>
														<td>{{$item['times_late']}}</td>
													</tr>
													@endforeach
													@else
													<tr>
														<td colspan="8">No Record Found</td>
													</tr>
													@endif
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			@endsection