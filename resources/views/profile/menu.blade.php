<div class="management-slider-top">
  <div class="owl-carousel owl-theme ieukprofleowl">
	<!-- /. Items-->
	<div class="item"> <a href="{{ URL('profile/ilps') }}" data-selected="5" class="d-flex flex-wrap justify-content-center management-slider_button <?php if(request()->segment(2) == "ilps"){ echo "active"; }?>"> <span class="slider-icon"> <img src="{{ asset('public/images/icon-management-ilp.svg') }}" alt="ILP" class="img-fluid"> </span> <span class="slider-title d-flex flex-wrap justify-content-center align-items-center"> ILP </span> </a> </div>
	<!-- /. Items-->
    <div class="item"> <a href="{{ URL('profile/course') }}" data-selected="1" class="d-flex flex-wrap justify-content-center management-slider_button <?php if(request()->segment(2) == "course"){ echo "active"; }?>"> <span class="slider-icon"> <img src="{{ asset('public/images/icon-management-courses.svg') }}" alt="Timetable &amp; Attendence" class="img-fluid"> </span> <span class="slider-title d-flex flex-wrap justify-content-center align-items-center"> Registered Courses </span> </a> </div>
	<!-- /. Items-->
    <div class="item"> <a href="{{ URL('profile/certificate') }}" data-selected="4" class="d-flex flex-wrap justify-content-center management-slider_button <?php if(request()->segment(2) == "certificate"){ echo "active"; }?>"> <span class="slider-icon"> <img src="{{ asset('public/images/icon-management-observation.svg') }}" alt="Certificate Details" class="img-fluid"> </span> <span class="slider-title d-flex flex-wrap justify-content-center align-items-center"> Certificate Details </span> </a> </div>
    <!-- /. Items-->
  </div>
</div>
<script>
	$('.owl-carousel').owlCarousel({
		loop: false,
		margin: 30,
		touchDrag: false,
		nav: true,
		dots:false,
		responsive: {
			0: {
				items: 2,
				touchDrag: true,
			},
			575: {
				items: 3,
				touchDrag: true,
			},
			768: {
				items: 3,
				touchDrag: true,
			},	
			992: {
				items: 5
			},
			1200: {
				items: 8
			},
			1400: {
				items: 10
			}
		}
	})	
 $(".ieukprofleowl .owl-prev").html('<i class="fas fa-arrow-left"></i>');
 $(".ieukprofleowl .owl-next").html('<i class="fas fa-arrow-right"></i>');

$('.owl-carousel').trigger('to.owl.carousel',$('.owl-item .item a.active').attr('data-selected'));
</script>
