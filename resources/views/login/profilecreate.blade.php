@extends('layouts.app')
@section('content')

<link href="{{ asset('public/css/_login.css') }}?n={{ env('CACTH') }}" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('public/css/create-profile/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/fonts/font/flaticon.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/create-profile/font-awesome.min.css') }}">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
<link rel="stylesheet" href="{{ asset('public/css/create-profile/custom.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/create-profile/mstepper.min.css') }}">

<div class="login-main d-flex flex-wrap">
	<div class="w-55 login-sidebar">
		<div class="logo mb-5">
			<img src="{{ asset('public/images/logo-main.svg') }}" alt="IEUK Student" class="img-fluid" width="100%">
		</div>
		<div class="login-slider">
			<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<div class="carousel-item active">
						<img src="{{asset('public/images/icon-digital-learning.svg')}}" class="d-block w-100" alt="Digital Learning">
						<div class="carousel-caption d-none d-md-block">
							<h2>Digital Learning</h2>
							<p>Welcome to the world of Imperial English UK, a place where there is no limit to what you can achieve. </p>
						</div>
					</div>
					<div class="carousel-item">
						<img src="{{asset('public/images/icon-creative-learning.svg')}}" class="d-block w-100" alt="Creative Learning">
						<div class="carousel-caption d-none d-md-block">
							<h2>Creative Learning</h2>
							<p>Task based activities to stimulate your mind and encourage analysis of performance to develop as an independent learner. </p>
						</div>
					</div>
					<div class="carousel-item">
						<img src="{{asset('public/images/icon-graded-learning.svg')}}" class="d-block w-100" alt="Graded Learning">
						<div class="carousel-caption d-none d-md-block">
							<h2>Graded Learning</h2>
							<p>Exposure to authentic, natural models of English designed to meet your needs & requirements.</p>
						</div>
					</div>
				</div>
				<ol class="carousel-indicators">
					<li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
					<li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
					<li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
				</ol>
			</div>
		</div>
	</div>

	<div class="login-form w-45 d-flex flex-wrap justify-content-center align-items-center">
		<div class="back-button">
			<a href="<?php echo URL('/')?>" title="Skip"> 
				<img src="{{ asset('public/images/icon-back.svg')}}" alt="Back" class="img-fluid">
			</a>
		</div>
		<div class="login">
			<div class="login-heading">
				<div class="heading-icon">
					<img src="{{asset('public/images/icon-login-user.svg')}}" alt="Student login" class="img-fluid">
				</div>
				<h1><strong>Create</strong> Profile</h1>
			</div>
			<div class="login__form">
				<form class="create_profile_form">
					<div class="create-profile-block mb-0">
						<ul class="stepper linear list-group">
							<li class="step active">
								<fieldset class='profile-step-1'>
									<div class="step-title block__heading mb-3">
										<span class="block__heading_name">Gender:</span>
										<span class="block__heading_value selected_gender">Male</span>
									</div>
									<div class="step-content">
										<div class="step-form">
											<div class="form-check form-check-inline step-form_gender">
												<input class="form-check-input" name="gender" type="radio" name="gender" id="radio-male" value="Male">
												<label class="form-check-label" for="radio-male">
													<span class="label-icon">
														<img src="{{asset('public/images/icon-radio-male.svg')}}" alt="Male" class="img-fluid">
													</span>
													<span class="label-name">Male</span>
												</label>
											</div>
											<div class="form-check form-check-inline step-form_gender">
												<input class="form-check-input" name="gender" type="radio" name="gender" id="radio-female" value="Female">
												<label class="form-check-label" for="radio-female">
													<span class="label-icon">
														<img src="{{asset('public/images/icon-radio-female.svg')}}" alt="Female" class="img-fluid">
													</span>
													<span class="label-name">Female</span>
												</label>
											</div>
											<div class="form-check form-check-inline step-form_gender">
												<input class="form-check-input" name="gender" type="radio" name="gender" id="inlineRadio3" value="Not Specified">
												<label class="form-check-label" for="inlineRadio3">Not Specified</label>
											</div>
										</div>
										<div class="step-actions" style="display:none">
											<button class="btn btn-primary next-step save_gender" id="genderBtn">Save</button>
										</div>
									</div>
								</fieldset>
							</li>
							<li class="step">
								<fieldset class="profile-step-2">
									<div class="step-title block__heading mb-3">
										<span class="block__heading_name">Date of Birth: </span>
										<span class="block__heading_value show_dob">01-02-1998</span>
									</div>
									<div class="step-content">
										<div class="form-row mb-3">
											<div class="form-group col-md-4">
												<div class="form-group">
													<input type="text" name="day" placeholder="Select DOB" id="dob" readonly="true"  class="form-control input_address">
												</div>
												
												 <!--  <select id="" class="form-control select_day" name="day">
													<option value="">Day</option>
													@for($i=1; $i<=31; $i++)
														<?php
															$selected_day = ($i<10)?'0'.$i:$i;
														?>
														<option value="{{$selected_day}}">{{$selected_day}}</option>
													@endfor

												</select> -->
											</div>
											 <!-- <div class="form-group col-md-4">
												<select id="" class="form-control select_month" name="month">
													<option selected>Month</option>
													@for($i=1; $i<=12; $i++)
																<?php
																	$month = ($i<10)?'0'.$i:$i;
																?>
																<option value="{{$month}}">{{$month}}</option>
															@endfor
												</select>
											</div>
											<div class="form-group col-md-4">
												<select id="" class="form-control select_year" name="year">
													<option value="">Year</option>
															@for($i=date('Y')-10; $i>=1970; $i--)
																<option  value="{{$i}}">{{$i}}</option>
															@endfor
												</select>
											</div> -->
										</div>
										<div class="step-actions">
											<button class="btn btn-primary next-step save_dob">Save</button>
										</div>
									</div>
								</fieldset>
							</li>

							<li class="step">
								<fieldset class="profile-step-3">
								<div class="step-title block__heading mb-3">
									<span class="block__heading_name">Ethnicity: </span>
									<span class="block__heading_value show_ethnicity">Please select ethicity</span>
								</div>
								<div class="step-content">
									<div class="form-group mb-3">
										<select id="" class="form-control ethnicity" name="ethnicity">

                                            @foreach ($data['ethnicity'] as $ethnicity )
                                            <option value="{{$ethnicity}}">{{$ethnicity}}</option>
                                            @endforeach


										</select>
									</div>
									<div class="step-actions" style="display:none">
										<button class="btn btn-primary next-step">Save</button>
									</div>
								</div>
							</fieldset>
							</li>

							<li class="step">
                                <fieldset class="profile-step-4">
								<div class="step-title block__heading mb-3">
									<span class="block__heading_name">Employment Status: </span>
									<span class="block__heading_value show_employmentstatus"> Please select employment status</span>
								</div>
								<div class="step-content">
									<div class="form-group mb-3">
										<select id="" class="form-control employmentstatus" name="employmentstatus">

                                            @foreach ($data['employment_status'] as $employment_status )
                                            <option value="{{$employment_status}}">{{$employment_status}}</option>
                                            @endforeach
										</select>
									</div>
									<div class="step-actions" style="display:none">
										<button class="btn btn-primary next-step">Save</button>
									</div>
								</div>
                                </fieldset>
							</li>

							<li class="step">
                                <fieldset class="profile-step-5">
								<div class="step-title block__heading mb-3">
									<span class="block__heading_name">Ability Status: </span>
									<span class="block__heading_value show_abilitystatus"> Please select Ability status</span>
								</div>
								<div class="step-content">
									<div class="form-group mb-3">
										<select id="" class="form-control abilitystatus" name="abilitystatus">
											@foreach ($data['ability_status'] as $ability_status )
                                            <option value="{{$ability_status}}">{{$ability_status}}</option>
                                            @endforeach
										</select>
									</div>
									<div class="step-actions" style="display:none">
										<button class="btn btn-primary next-step">Save</button>
									</div>
								</div>
							</li>

							<li class="step address-wrap">
								<div class="step-title block__heading mb-3">
									<span class="block__heading_name">Address: </span>
                                    <span class="block__heading_value show_address"> </span>

								</div>
								<div class="step-content">
									<div class="form-group">
										<input type="text" class="form-control input_address" id="input_address" name="address" placeholder="Address">

									</div>
									<div class="form-row">
										<div class="form-group col-md-4">
											<select id="country-dropdown" class="form-control input_country" name="country">
												<option selected>Country</option>
                                                <?php foreach($countries as $country){?>
                                                    <?php //dd($countrys_name);?>
                                                    <option value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                                                <?php }?>
                                                
											</select>
										</div>
										<div class="form-group col-md-4">
											<select id="state-dropdown" class="form-control" name="state">
												<option selected>State</option>

											</select>
										</div>
                                        <div class="form-group col-md-4">
											<select id="city-dropdown" class="form-control" name="city">
												<option selected>City</option>
											</select>
										</div>
										<div class="form-group col-md-4">
											<input type="text" class="form-control input_zipcode" id="postal-code" placeholder="Pincode" name="zipcode">

											<div class="invalid-feedback">
												Invalid Postal Code
											</div>
										</div>
									</div>
									<div class="step-actions">
										<button class="btn btn-primary next-step submitBtn" type="submit">Finish</button>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script src="{{ asset('public/js/create-profile/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/js/create-profile/mstepper.min.js') }}"></script>

<script>
     $(document).ready(function() {
   
     	$('#dob').datepicker({
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
    		changeYear: true,
		});


        $('#country-dropdown').on('change', function() {
            var country_id = this.value;
         //  alert(country_id);
            $("#state-dropdown").html('');
            $.ajax({
                url: "{{url('/state')}}",
                type: "POST",
                data: {
                    country_id: country_id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) {
                   // console.log(result);
                    $('#state-dropdown').html('<option value="">Select State</option>');
                    $.each(result.states, function(key, value) {
                      //  console.log(result.states);
                        $("#state-dropdown").append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    $('#city-dropdown').html('<option value="">Select State First</option>');
                }
            });
        });
        $('#state-dropdown').on('change', function() {
            var state_id = this.value;
           // alert(state_id);
            $("#city-dropdown").html('');
            $.ajax({
                url: "{{url('/getCities')}}",
                type: "POST",
                data: {
                    state_id: state_id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#city-dropdown').html('<option value="">Select City</option>');

                    $.each(result.cities, function(key, value) {
                       // console.log(result.cities);
                        $("#city-dropdown").append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        });
     });
</script>
















		<script>
		var stepper = document.querySelector('.stepper');
		var stepperInstace = new MStepper(stepper, {
		// options
		firstActive: 0 // this is the default
		})
		jQuery(document).ready(function(){
			jQuery("li.step").click(function(){
				if(jQuery(this).hasClass("done")){
					stepperInstace.openStep($(this).index());
				}
			})
		})

		$(document).ready(function(){

            var get_cities_url = "{{url('/cities')}}";
            var update_profile_url = "{{url('/do-update-profile')}}";
            var nextPage = "{{url('/')}}";
            $('input[type=radio][name=gender]').change(function() {

                if ($('input[name="gender"]:checked').val() === 'Male') {
                    $('.selected_gender').html('Male');
                    // $("#male").addClass("active");
                    // $("#female").removeClass("active");
                } else if ($('input[name="gender"]:checked').val() === 'Female') {
                    $('.selected_gender').html('Female');
                    // $("#female").addClass("active");
                    // $("#male").removeClass("active");
                } else {
                $('.selected_gender').html('Not Specified');
                }
                $('.profile-step-1').find('button').click();


                $('.profile-step-2').removeAttr('disabled')
            });
            $('.city_dropdown').on('click','.dropdown-item', function() {
            var selected_val = $(this).attr('data-val');
            // if( $(this).hasClass('dropdown-city') ){
            //     $('.input_city').val(selected_val);
            // }

            $(this).parent().parent().find('button').html(selected_val+'<i class="fa fa-angle-down mr-2 text08"></i>')

            });
            // $('.dropdown-item').on('click', function() {

            //     var selected_val = $(this).attr('data-val');
            //     if( $(this).hasClass('dropdown-day') ){
            //         $('.show_dob').attr('data-selectedDay',selected_val);
            //     }
            //     if( $(this).hasClass('dropdown-month') ){
            //         $('.show_dob').attr('data-selectedMonth',selected_val);
            //     }
            //     if( $(this).hasClass('dropdown-year') ){
            //         $('.show_dob').attr('data-selectedYear',selected_val);
            //     }

            //     if( $(this).hasClass('dropdown-ethnicity') ){
            //         $('.show_ethnicity').attr('data-selectedEthnicity',selected_val);
            //     }
            //     if( $(this).hasClass('dropdown-employmentstatus') ){
            //         $('.show_employmentstatus').attr('data-selectedEmploymentstatus',selected_val);
            //     }

            //     if( $(this).hasClass('dropdown-abilitystatus') ){
            //         $('.show_abilitystatus').attr('data-selectedAbilitystatus',selected_val);
            //     }
            //     if( $(this).hasClass('dropdown-country') ){
            //         $('.input_country').val(selected_val);
            //     }
            //     if( $(this).hasClass('dropdown-city') ){
            //         $('.input_city').val(selected_val);
            //     }

            //     $(this).parent().parent().find('button').html(selected_val+'<i class="fa fa-angle-down mr-2 text08"></i>')
            // });

            $('.save_dob').on('click', function() {
                var selected_day = $('.select_day').val();
                var selected_month = $('.select_month').val();
                var selected_year = $('.select_year').val();
                var dob = selected_day+'-'+selected_month+'-'+selected_year
                if(selected_day!="" && selected_month!="" && selected_year!=""){
                if(dob=='--') {
                    dob="";
                    $('.input_dob').val('');
                } else {
                    $('.profile-step-3').removeAttr('disabled');
                    $('.input_dob').val(dob);
                }

                $('.show_dob').html($('#dob').val());
                } else {
                    $('.input_dob').val('');
                    $('.show_dob').html('Select date of birth');
                    $('.profile-step-3').attr('disabled','disabled');
                }
            });

            $('.ethnicity').on('change', function(){
                var selected_ethnicity = $('.ethnicity').val();
                if(selected_ethnicity!=""){
                $('.show_ethnicity').html(selected_ethnicity);
                $('.profile-step-4').removeAttr('disabled');
                $('.profile-step-3').find('button').click();
                } else {
                $('.show_ethnicity').html("Please select ethicity");
                $('.profile-step-4').attr('disabled','disabled');
                }
            })

            $('.employmentstatus').on('change', function(){
                var selected_employmentstatus = $('.employmentstatus').val();
                if(selected_employmentstatus!=""){
                $('.show_employmentstatus').html(selected_employmentstatus);
                $('.profile-step-5').removeAttr('disabled');
                $('.profile-step-4').find('button').click();
                } else {
                $('.show_employmentstatus').html("Please select employment status");
                $('.profile-step-5').attr('disabled','disabled');
                }
            });

            $('.abilitystatus').on('change', function(){
                var selected_abilitystatus = $('.abilitystatus').val();
                if(selected_abilitystatus!=""){
                //$('.input_abilitystatus').val(selected_abilitystatus);
                $('.show_abilitystatus').html(selected_abilitystatus);
                    $('.profile-step-6').removeAttr('disabled');
                    $('.profile-step-5').find('button').click();
                setTimeout(function(){

                    window.scrollTo(0,document.body.scrollHeight);
                },1000)
                } else {
                    $('.show_abilitystatus').html("Please select ability status");
                $('.profile-step-6').attr('disabled','disabled');
                }
            });
            $.validator.addMethod("noSpecialChar", function(value, element) {
            return this.optional(element) || /^[a-zA-Z0-9 ]+$/i.test(value);
            });
            jQuery.validator.addMethod("noSpace", function(value, element) {
            return  $.trim(value) != "";
            });
            // $(".create_profile_form").validate({
            //     ignore: []  ,
            //     rules: {
            //     gender: {
            //         required: true,
            //     },

            //    ability_status: {
            //         required: true,
            //     },
            //     ethnicity: {
            //         required: true,
            //     },
            //     employment_status: {
            //         required: true,
            //     },
            //     address: {
            //         required: true,
            //         noSpace: true
            //     },
            //         country: {
            //         required: true,
            //     },
            //     city: {
            //         required: true,
            //     },
            //     post_code: {
            //         required:true,
            //         noSpecialChar: true
            //     },

            //     },
            //     messages: {
            //     gender: {
            //         required: 'Please select gender',
            //     },
            //     date_of_birth: {
            //         required: 'Please select date of birth',
            //     },
            //     ethnicity: {
            //         required: "Please select ethnicity",
            //     },
            //     employment_status: {
            //         required: "Please select employment status",
            //     },
            //     ability_status: {
            //         required: "Please select ability status",
            //     },
            //     address: {
            //         required: "Please enter address",
            //         noSpace:"Please enter valid address"
            //     },
            //         country: {
            //         required: "Please select country",
            //     },
            //     city: {
            //         required: "Please select city",
            //     },
            //     post_code: {
            //         required:"Please enter post code",
            //         noSpecialChar:  "Please enter only letters and number",

            //     },
            //     },
            //     invalidHandler: function(form, validator) {
            //         var errors = validator.numberOfInvalids();
            //         console.log('errors====>', validator)
            //         if (errors) {
            //         $('.show-error-msg').show().html(validator.errorList[0].message)
            //         validator.errorList[0].element.focus(); //Set Focus
            //         }
            //     },
            //     errorPlacement: function (error, element) {
            //         // error.insertAfter(element);
            //         //element.parent().parent().append(error)
            //         // console.log('=====>',error)
            //         // $('.show-error-msg').html(error)
            //     }
            // });

            $(".submitBtn").on('click', function(){
                console.log($(".create_profile_form").serialize());
            // if($(".create_profile_form").valid()){
                $(".submitBtn").attr('disabled', 'disabled');
                $(".submitBtn").val("Please wait...");
                $.ajax({
                    url: update_profile_url,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    dataType: "JSON",
                    data: $(".create_profile_form").serialize() ,
                    success: function (data) {
                        $(".submitBtn").removeAttr('disabled');
                        $(".submitBtn").val("Submit");
                    //    $('.show-error-msg').html(data.original.message)
                        setTimeout(function(){
                        window.location.href=nextPage;
                        },2000)

                    },

                });
            // }

            });

            // $('.input_address, .input_zipcode').on('keyup', function() {
            //     setAddress()
            // })
            // $('.input_country').on('change', function(){
            // setAddress()
            // var country  = $('.input_country').val();

            // $.ajax({
            //     url: get_cities_url,
            //     headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //     type: 'POST',
            //     dataType: "JSON",
            //     data: {'country': country},
            //     success: function (data) {
            //     console.log('cities===>',data)
            //     var city_list = "<option value=''>Select city</option>";
            //     for(var i=0; i<data.length;i++){
            //         city_list += '  <option value="'+data[i]+'">'+data[i]+'</option>'
            //     }
            //     $('.input_city').html(city_list)

            //     }
            // });
            // })

            function setAddress(){
                var fulladdress = "";
                var address  = $('.input_address').val();
                var zipcode  = $('.input_zipcode').val();
                var country  = $('.input_country').val();

                var city  = $('.input_city').val();

                if($.trim(address) !=""  && $.trim(address)!=undefined ){
                    fulladdress += ' '+address+', ';
                }

                if($.trim(city) !=""  && $.trim(city)!=undefined ){
                    fulladdress += ' '+city+ ', ';
                }

                if($.trim(country) !=""  && $.trim(country)!=undefined ){
                    fulladdress += ' '+country+', ';
                }

                if($.trim(zipcode) !=""  && $.trim(zipcode)!=undefined ){
                    fulladdress += ' '+zipcode;
                }
                $('.show_address').html(fulladdress );
            }


            });

		</script>

@endsection
