@extends('layouts.app')
@section('content')
<style type="text/css">
 #cover-spin {
     position: fixed;
     width: 100%;
     left: 0;
     right: 0;
     top: 0;
     bottom: 0;
     background-color: rgba(255, 255, 255, 0.7);
     z-index: 9999;
     display: none;
 }
 @-webkit-keyframes spin {
     from {
         -webkit-transform: rotate(0deg);
     }
     to {
         -webkit-transform: rotate(360deg);
     }
 }
 @keyframes spin {
     from {
         transform: rotate(0deg);
     }
     to {
         transform: rotate(360deg);
     }
 }
 #cover-spin::after {
     content: '';
     display: block;
     position: absolute;
     left: 48%;
     top: 40%;
     width: 40px;
     height: 40px;
     border-style: solid;
     border-color: black;
     border-top-color: transparent;
     border-width: 4px;
     border-radius: 50%;
     -webkit-animation: spin .8s linear infinite;
     animation: spin .8s linear infinite;
 }
 .ui-datepicker {
     background: #30475e;
     border: 1px solid #555;
     color: #EEE;
 }
 .stringProperNew {
     white-space: break-spaces;
 }
 
 .closeGoBack {
     right: 0;
     top: 0;
     margin-right: 20px;
     margin-top: 15px;
     position: absolute;
 }
 
 .commonFontSize {
     font-size: 1.125rem;
     font-weight: 500;
     color: #30475e;
 }
 
 .page-loader-wrapper {
     z-index: 99999999;
     position: fixed;
     top: 0;
     left: 0;
     bottom: 0;
     right: 0;
     width: 100%;
     height: 100%;
     background: rgba(111, 89, 89, .4);
     overflow: hidden;
     text-align: center;
 }
 
 .page-loader-wrapper .loader {
     position: relative;
     top: calc(50% - 30px);
 }
 
 .loading-img-spin {
     position: absolute;
     top: 50%;
     left: 50%;
     width: 150px;
     height: 150px;
     margin: -130px 0 20px -75px;
     /*-webkit-animation: spin 1.5s linear infinite;
 -moz-animation: spin 1.5s linear infinite;
 animation: spin 1.5s linear infinite;*/
 }
 /************************** New Register Form Css************************/
 
 .reg-main .login-form .login {
     min-width: 330px !important;
 }
 
 .reg-main .reg-form .fname-label-group .title-select {
     max-width: 78px;
 }
 
 .reg-main .reg-form .fname-label-group.form-label-group>label {
     left: 80px;
     top: 0px;
 }
 
 .reg-main .reg-form select.form-control {
     border: none;
     border-bottom: 1px solid #9fa9c5;
     border-radius: 0;
     background-color: transparent;
     background-size: 11px auto;
     margin-right: 4px;
 }
 
 .reg-main .form-label-group input,
 .form-label-group label,
 .form-label-group select {
     height: 3.125rem;
     padding: .75rem .75rem .75rem 0;
     color: #315376;
     font-weight: 500;
     font-size: 17px;
 }
 
 .reg-main .form-label-group input:not(:placeholder-shown) {
     padding-top: .5rem !important;
     padding-bottom: .25rem !important;
 }
 
 .reg-main .login-form {
     background-image: none !important;
 }
 
 .reg-main input::placeholder {
     color: #315376 !important;
     font-weight: 500;
     opacity: 1;
     /* Firefox */
 }
 
 .reg-main input:-ms-input-placeholder {
     /* Internet Explorer 10-11 */
     color: #315376 !important;
     font-weight: 500;
 }
 
 .reg-main input::-ms-input-placeholder {
     /* Microsoft Edge */
     color: #315376 !important;
     font-weight: 500;
 }
 
 .reg-main .form-control__name {
     background-image: url("https://student.imperial-english.com/public/images/icon-form-control-email.svg");
     background-position: calc(100% - 5px) center;
     background-repeat: no-repeat;
 }
 
 .reg-main .login-heading strong a {
     color: #d55b7d;
 }
 
 .reg-main .form-check-label a {
     color: #d55b7d;
 }
 
 @media (min-width: 0px) and (max-width: 767px) {
     .reg-main .login-main .login-form {
         width: 100% !important;
         background: none;
         background-image: none;
         height: auto;
         text-align: center;
     }
 }
 </style>
 <link href="https://student.imperial-english.com/public/css/responsive1.css?v=2011" rel="stylesheet">
 <link href="https://student.imperial-english.com/public/css/responsive2.css?v=2011" rel="stylesheet">
 <script type="text/javascript">
  (function(w, d, v3) {
      w.chaportConfig = {
          appId: '62b6c7e3ae84592f3096d376',
          launcher: {
              show: false
          },
          appearance: {
              position: ['left', 20, 20],
              textStatuses: true
          }
      };
      if (w.chaport) return;
      v3 = w.chaport = {};
      v3._q = [];
      v3._l = {};
      v3.q = function() {
          v3._q.push(arguments)
      };
      v3.on = function(e, fn) {
          if (!v3._l[e]) v3._l[e] = [];
          v3._l[e].push(fn)
      };
      var s = d.createElement('script');
      s.type = 'text/javascript';
      s.async = true;
      s.src = 'https://app.chaport.com/javascripts/insert.js';
      var ss = d.getElementsByTagName('script')[0];
      ss.parentNode.insertBefore(s, ss)
  })(window, document);
  window.chaport.on('ready', function() {
      $(".expand-chat-support").click(function() {
          // window.chaport.openIn({ selector: '#divyesh' });
          window.chaport.open();
          // window.chaport.toggle();
      });
      $(".chat-support").click(function() {
          window.chaport.open();
      });
  });
</script>
<!-- <body class=" "> -->
<div class="hide-menu"></div>
    <a style="display:none" id="scrll-top" class="scrolltop" href="javascript:void(0);" onclick="scrolltoTop()"><img src="https://student.imperial-english.com/public/images/scrolltoTop-arrow.png" alt="" class="img-fluid" width="20px"></a>
    <div class="page-loader-wrapper" style="display:none">
        <div class="loader">
            <img class="loading-img-spin" src="https://student.imperial-english.com/public/images/logo-main.svg" alt="admin">
            <p class="primary font-weight-bolder">Please wait...</p>
        </div>
    </div>
    <header class="mobile-header">
        <div class="mb-menu menu-option">
            <a href="javascript:void(0)"><img class="mbmenubutton" src="https://student.imperial-english.com/public/images/mobilemenu-icon.png" alt="menuicon" width="24px" height="24px"></a>
        </div>
        <div class="mb-menu menu-back">
            <a href="" onclick="window.history.go(-1); return false;"><img class="mbmenubutton" src="https://student.imperial-english.com/public/images/icon-back-white.svg" alt="Back"></a>
        </div>

        <div class="mh-logo"><img src='https://student.imperial-english.com/public/images/mob-logo-w.png' srcset='https://student.imperial-english.com/public/images/mob-logo-w-2x.png 2x' alt="Imperial English UK"></div>
    </header>
    <style>
        .menu-option {
            display: none;
        }
    </style>
    <link href="https://student.imperial-english.com/public/css/_login.css?n=2011" rel="stylesheet">
    <div class="login-chatsupport">
        <a href="javascript:void(0);" class="login-expand-chat-support">
            <img src="https://student.imperial-english.com/public/images/task-chat-support.png" alt="Chat Support" style="width:50px;">
        </a>
    </div>
    <div class="reg-main login-main d-flex flex-wrap">
        <div class="w-55 login-sidebar">
            <div class="logo mb-5">
                <img src="https://student.imperial-english.com/public/images/logo-main.svg" alt="IEUK Student" class="img-fluid" width="100%">
            </div>
            <div class="login-slider">
                <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://student.imperial-english.com/public/images/ieuk-mobile-logo.png" class="d-block" alt="Digital Learning">
                            <div class="carousel-caption">
                                <h2>British Standard, Quality and Qualification</h2>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="https://student.imperial-english.com/public/images/icon-digital-learning.svg" class="d-block w-100" alt="Digital Learning">
                            <div class="carousel-caption">
                                <h2>Digital Learning</h2>
                                <p>Welcome to the world of Imperial English UK, a place where there is no limit to what you can achieve. </p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="https://student.imperial-english.com/public/images/icon-creative-learning.svg" class="d-block w-100" alt="Creative Learning">
                            <div class="carousel-caption">
                                <h2>Creative Learning</h2>
                                <p>Task based activities to stimulate your mind and encourage analysis of performance to develop as an independent learner. </p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="https://student.imperial-english.com/public/images/icon-graded-learning.svg" class="d-block w-100" alt="Graded Learning">
                            <div class="carousel-caption">
                                <h2>Graded Learning</h2>
                                <p>Exposure to authentic, natural models of English designed to meet your needs & requirements.</p>
                            </div>
                        </div>
                    </div>
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                        <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
                        <li data-target="#carouselExampleCaptions" data-slide-to="3"></li>
                    </ol>
                </div>
                <div class="row w-100">
                    <div class="col-12 col-md-12 media_buttons">
                        <a href="https://play.google.com/store/apps/details?id=com.ieuk_student&hl=en_IN&gl=US" target="_blank">
                            <img style="width: 40%;max-width: 190px;margin-top: 10px;margin-right: 15px;" alt="Google Play" src="https://student.imperial-english.com/public/images/ieuk-student-app-playstore.png">
                        </a>
                        <a href="https://www.youtube.com/watch?v=vQ1XZXSY0Ng" target="_blank">
                            <img style="width: 40%;max-width: 190px;margin-top: 10px;" alt="instructions" src="https://student.imperial-english.com/public/images/ieuk-student-app.png">
                        </a>
                    </div>
                </div>
                <div class="media_icons mt-3 mt-md-5 text-center text-md-left mb-3 mb-md-0">
                    <a href="https://www.facebook.com/IEUK1" target="_blank"><i class="fa-brands fa-facebook-f mr-3"></i></a>
                    <a href="https://www.instagram.com/imperial_english_uk/" target="_blank"><i class="fa-brands fa-instagram mr-3"></i></a>
                    <a href="https://www.linkedin.com/company/imperial-english-uk/" target="_blank"><i class="fa-brands fa-linkedin-in mr-3"></i></a>
                    <a href="https://www.youtube.com/channel/UC7dCskN5FgYjbzSLCrDOEUw" target="_blank"><i class="fa-brands fa-youtube mr-3"></i></a>
                </div>
            </div>
        </div>

        <div class="reg-form login-form w-45 d-flex flex-wrap justify-content-center align-items-center">
            <div class="login">
                <div class="login-heading text-center">
                    <div class="heading-icon mb-3">
                        <!-- <img src="https://student.imperial-english.com/public/images/icon-login-user.svg" alt="Student login" class="img-fluid"> -->
                        <img src="https://student.imperial-english.com/public/images/icon-crown.svg" alt="Student login" class="img-fluid" width="80">
                    </div>
                    <h1 class="mb-3"><strong>Create</strong> Account</h1>
                    <h4> Already have an account? <strong> <a href="">Login</a></strong></h4>
                </div>
                <div class="login__form">
                    <form action="" id="my_form" autocomplete="off" method="post" onsubmit="return false;">
                        <div class="form-group form-group__verification_error" id="error_message">
                            <em class="d-flex">
														<span class="error-img">
															<img src="https://student.imperial-english.com/public/images/icon-invalid-code.svg" alt="">
														</span>
														<span class="error-text" style="max-width:300px;"></span>
													</em>
                        </div>
                        <div class="d-flex form-label-group fname-label-group">
                            <select class="form-control title-select" id="title" name="title">
								               <option value="Mr">Mr.</option>
								               <option value="Mrs">Mrs.</option>
								               <option value="Ms">Ms.</option>
							              </select>
                            <input type="text" class="form-control form-control__name" placeholder="First Name" name="firstname" id="firstname" autocomplete="off">

                            <!-- <label for="first-name">First Name</label> -->
                            <div class="invalid-feedback">Invalid First</div>
                        </div>
                        <div class="form-label-group">
                            <input type="text" class="form-control form-control__name" placeholder="Last Name" name="lastname" id="lastname" autocomplete="off">
                            <!-- <label for="last-name">Last Name</label> -->
                            <div class="invalid-feedback">Invalid Last Name</div>
                        </div>
                        <div class="form-label-group">
                            <input type="text" class="form-control form-control__email" placeholder="Email" name="email" id="email" autocomplete="off">
                            <!-- <label for="user_email">Email address</label> -->
                            <div class="invalid-feedback">Invalid E-mail</div>
                        </div>
                        <div class="form-label-group">
                          <select class="form-control form-control__email" placeholder="" name="country" id="country">
							    <option value="">Select Country</option>
                              @foreach($data['result'] as $key => $value)
							    <option value="{{$value['id']}}">{{$value['name']}}</option>
                              @endforeach
						   </select>
                          <div class="invalid-feedback">Invalid Country</div>
                        </div>
                        <div class="form-label-group form-label-group__last position-relative mb-3">
                            <input type="password" class="form-control form-control__password" autocomplete="off" placeholder="Password" name="password" id="password">
                            <!-- <label for="user_password">Password</label> -->
                            <i id="eye-icon" class="fa fa-eye"></i>
                            <div class="invalid-feedback">Invalid password</div>
                        </div>
                        <div class="d-flex my-4 justify-content-center">
                         <input class="mr-2" type="checkbox" value="" id="flexCheckChecked" checked>
                         <label class="form-check-label" for="flexCheckChecked">Our <a href="">terms of use</a> & <a href="">privacy policy</a></label>
                        </div>
                        <button type="submit" class="btn btn-danger btn-sm mb-2 mx-auto d-block">Register</button>
                        <!-- <p class=" text-center"><a href="https://student.imperial-english.com/forgot-password">Forgot your password?</a></p> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.19/jquery.touchSwipe.min.js"></script>
    <script type="text/javascript">
        $(".carousel .carousel-inner").swipe({
            swipeLeft: function(event, direction, distance, duration, fingerCount) {
                this.parent().carousel("next");
            },
            swipeRight: function() {
                this.parent().carousel("prev");
            },
            threshold: 0,
            tap: function(event, target) {
                window.location = $(this).find(".carousel-item.active a").attr("href");
            },
            excludedElements: "label, button, input, select, textarea, .noSwipe"
        });
    </script>

    <script type="text/javascript">
        $("#my_form").validate({
            rules: {
            	  firstname: {
                    required: !0,
                },
                lastname: {
                    required: !0,
                },
                email: {
                    required: !0,
                    email:true,
                },
                country: {
                    required: !0,
                },
                password: {
                    required: !0,
                    minlength: 8
                },
            },
            errorElement: "div",
            errorClass: "invalid-feedback",
            submitHandler: function(form) {
                $("#my_form").find("input[type='submit']").prop("disabled", true);
                $("#my_form").find("input[type='submit']").attr("value", "Submitting...");
                $("#my_form").find("button[type='submit']").prop("disabled", true);
                $("#my_form").find("button[type='submit']").text("Submitting...");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url:  "store",
                    data: $("#my_form").serialize(),
                    dataType: "json",
                    success: function(res) {
                        console.log(res)
                        if (!res.success) {
                            $("#error_message .error-text").text(res.message);
                            $("#error_message").show();
                        } 
                        else 
                        {
                           alert("Student Register Successfully");
                           $("#error_message .error-text").text('');
                           $("#error_message").hide();
                           window.location = 'http://individual.local/';
                        }
                        $("#my_form").find("input[type='submit']").prop("disabled", false);
                        $("#my_form").find("input[type='submit']").attr("value", "Sign In");
                        $("#my_form").find("button[type='submit']").prop("disabled", false);
                        $("#my_form").find("button[type='submit']").text("Sign In");
                    }
                });
                return false;
            }
        })
    </script>
    <script>
        $(document).ready(function() {
            // setTimeout(() => {
            //   $('#error_message1').fadeOut();
            // }, 5000);
            $("#eye-icon").click(function() {
                $("#user_password").toggleClass('form-control__password_hidden');
                $("#user_password").toggleClass('form-control__password');

                $('.form-control__password').prop("type", 'password');
                $('.form-control__password_hidden').prop("type", 'text');

            });
        });
    </script>

    <script type="text/javascript">
        (function(w, d, v3) {
            w.chaportConfig = {
                appId: '62b6c7e3ae84592f3096d376',
                launcher: {
                    show: false
                },
                appearance: {
                    position: ['right', 20, 20],
                    textStatuses: true
                }
            };
            if (w.chaport) return;
            v3 = w.chaport = {};
            v3._q = [];
            v3._l = {};
            v3.q = function() {
                v3._q.push(arguments)
            };
            v3.on = function(e, fn) {
                if (!v3._l[e]) v3._l[e] = [];
                v3._l[e].push(fn)
            };
            var s = d.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = 'https://app.chaport.com/javascripts/insert.js';
            var ss = d.getElementsByTagName('script')[0];
            ss.parentNode.insertBefore(s, ss)
        })(window, document);

        window.chaport.on('ready', function() {
            $(".login-expand-chat-support").click(function() {
                window.chaport.open();
            });
        });
    </script>





    <div class="cover-spin" id="cover-spin"></div>
    <script src="https://student.imperial-english.com/public/js/general.js"></script>
    <script src="https://student.imperial-english.com/public/js/custom.js"></script>
    <script src="https://student.imperial-english.com/public/js/pdf-popup.js"></script>
    <script>
        $(document).ready(function() {
            $('.keydwn').keydown(function(e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    return false;
                }
            });
            $('span.textarea').attr("onpaste", "return false;")

            $('.enter_disable').keypress(function(event) {
                if (event.which == '13') {
                    event.preventDefault();
                }
            });

            $('.goBackYes').click(function() {
                // $(".course-book").toggleClass("fullscreen");
                // $(".course-content").toggleClass("scrollbar");
                // $(".speaking-course").toggleClass("d-flex")
                // $('#goBack').modal('toggle')
            })

            $('.close-course').click(function() {
                // $('#goBack').modal('toggle')
            })
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.d-scrollbar').scrollbar();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            jQuery("#add-facility").click(function() {
                $("#add-facility").attr('disabled', true);
                $("#add_feedback_facility_form .form-control_underline").each(function() {
                    $(this).next().val($(this).text())
                });
                $.ajax({
                    url: "ddd",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: $("#add_feedback_facility_form").serialize(),
                    success: function(data) {
                        // $("#feedback_add_btn").removeAttr('disabled');

                        if (data.success) {
                            setTimeout(function() {
                                window.location.reload();
                                // $("#add-facility").removeAttr('disabled');
                            }, 2000);
                            $('#add_feedback_facility_form .alert-danger').hide();
                            $('#add_feedback_facility_form .alert-success').show().html(data.message).fadeOut(6000);
                        } else {
                            $('#add_feedback_facility_form .alert-success').hide();
                            $('#add_feedback_facility_form .alert-danger').show().html(data.message).fadeOut(6000);
                        }
                    }
                });
            });
            jQuery("#add-add-course").click(function() {
                $("#add-add-course").attr('disabled', true);
                $("#add_feedback_course_end_form .form-control_underline").each(function() {
                    $(this).next().val($(this).text())
                });

                $.ajax({
                    url: "https://student.imperial-english.com/profile/add-course-end-feedbacks",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: $("#add_feedback_course_end_form").serialize(),
                    success: function(data) {


                        if (data.success) {
                            setTimeout(function() {
                                window.location.reload()
                                    // $("#add-add-course").removeAttr('disabled');
                            }, 2000);
                            $('#add_feedback_course_end_form .alert-danger').hide();
                            $('#add_feedback_course_end_form .alert-success').show().html(data.message).fadeOut(6000);
                        } else {
                            $('#add_feedback_course_end_form .alert-success').hide();
                            $('#add_feedback_course_end_form .alert-danger').show().html(data.message).fadeOut(6000);
                        }
                    }
                });
            });

            jQuery("#add-init-course").click(function() {
                $("#add-init-course").attr('disabled', true);
                $("#add_feedback_course_mid_init_form .form-control_underline").each(function() {
                    $(this).next().val($(this).text())
                });

                $.ajax({
                    url: "https://student.imperial-english.com/profile/add-course-init-mid-feedbacks",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: $("#add_feedback_course_mid_init_form").serialize(),
                    success: function(data) {


                        if (data.success) {
                            setTimeout(function() {
                                window.location.reload()
                                    // $("#add-init-course").removeAttr('disabled');
                            }, 2000);
                            $('#add_feedback_course_mid_init_form .alert-danger').hide();
                            $('#add_feedback_course_mid_init_form .alert-success').show().html(data.message).fadeOut(6000);
                        } else {
                            $('#add_feedback_course_mid_init_form .alert-success').hide();
                            $('#add_feedback_course_mid_init_form .alert-danger').show().html(data.message).fadeOut(6000);
                        }
                    }
                });
            });

        });

        $('body').on('dragstart drop', function(e) {
            e.preventDefault();
            return false;
        });

        //== responsive for header mobile menu ==// 
        $(document).ready(function() {
            //== on change size window reload
            //  $(window).resize(function(){location.reload();});
            if (window.matchMedia('(max-width: 767px)').matches) {

                $("header.mobile-header a").on("click", function(event) {
                    $("aside#sidebar.sidebar-menu").toggle();
                    $(this).toggleClass('on');
                    $('aside#sidebar.sidebar-menu').toggleClass('on');
                    event.stopPropagation();
                });
                $("main.dashboard,header.mobile-header").on("click", function(event) {
                    $("aside#sidebar.sidebar-menu").hide();
                    $('header.mobile-header a').prop('checked', true);
                    $('header.mobile-header a').removeClass('on');
                    $('aside#sidebar.sidebar-menu').removeClass('on');

                });

                //      // backbutton body margin
                //      var bkbtnoh  = $(".course-book a.mobbackbtn-b").outerHeight();      
                //      $('body').css({
                //          "margin-bottom": bkbtnoh
                //      });

            }
            //== responsive for header mobile menu ==//
            //== page Reload ==//
            //  if (window.DeviceOrientationEvent) {
            //      window.addEventListener('orientationchange', function() { 
            //          alert('hello');
            //          location.reload(); }, false);
            //  }

            window.addEventListener("orientationchange", function() {
                //    alert(window.orientation);
                location.reload();

            }, false);
        });
        //if (window.matchMedia('(max-width:926px').matches) {
        //  $(window).resize(function(){location.reload();});
        //  
        //}else{
        //  
        //}
    </script>
    <script>
        function scrolltoTop() {
            setTimeout(function() {
                $('html, body').animate({
                    scrollTop: $('body').offset().top
                }, 1000);
            }, 100);
        }

        var mybutton = document.getElementById("scrll-top");


        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 1000 || document.documentElement.scrollTop > 1000) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.datatable').DataTable();
        });
        $(document).ready(function() {
            $(".custom-select2-dropdown").select2();
            $('.custom-select2-dropdown').on("select2:open", function() {
                $('.select2-results__options').addClass('d-scrollbar');
                $('.select2-results__options').scrollbar();
            });
        });
        $(document).ready(function() {
            $(".custom-select2-dropdown-nosearch").select2({
                minimumResultsForSearch: -1
            });
            $('.custom-select2-dropdown-nosearch').on("select2:open", function() {
                $('.select2-results__options').addClass('d-scrollbar');
                $('.select2-results__options').scrollbar();
            });
        });
        $(document).ready(function() {
            $(".custom-select2-dropdown-nosearch2").select2({
                minimumResultsForSearch: -1
            });
            $('.custom-select2-dropdown-nosearch2').on("select2:open", function() {
                $('.select2-results__options').addClass('d-scrollbar');
                $('.select2-results__options').scrollbar();
            });
        });
    </script>
    <script type="text/javascript">
        function textAreaAdjust(element) {
            element.style.height = "1px";
            element.style.height = (25 + element.scrollHeight) + "px";
        }
    </script>
    <script type="text/javascript">
        $(".open-filter").click(function() {
            $("aside.filter-sidebar").addClass("openclose");
        });

        $(".close-filter").click(function() {
            $("aside.filter-sidebar.openclose").removeClass("openclose");
        });

        $(document).ready(function() {
            $("#moreInfo").click(function() {
                $(".info-details").slideDown("slow");
            });
            $(".moreInfo").click(function() {
                $(".dashboard-info-details").slideDown("slow");
            });
            $(function() {
                $('body').on('mouseup', function() {
                    $('.info-details').hide();
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).on('keyup', '.fillblanks', function() {
            var value = $(this).html().trim().length;
            if (value == "") {
                $(this).css("min-width", "3ch");
                $(this).css("display", "inline-block");
            } else {
                if (value == "1" || value == "2" || value == "3") {
                    $(this).css("min-width", "1ch");
                    $(this).css("display", "inherit");
                } else {
                    if (flag) {
                        flag = false;
                        $(this).css("min-width", "3ch");
                        $(this).css("display", "inherit");
                    }
                }
            }
        });
    </script>

    <script type="">

        $(".nav-opener").click(function(){ $("body").toggleClass("open-black-bg"); })

    </script>

    <script>
        $(document).on('click', "#openmodal", function() {
            var url = $(this).attr("data-id");
            // PDFObject.embed('https://s3.amazonaws.com/imperialenglish.co.uk/'+url, "#datas",{height: "60rem"});
            const app_url = 'https://s3.amazonaws.com/imperialenglish.co.uk/';
            PDFObject.embed(app_url + url, "#datas", {
                height: "60rem"
            });
            $('#myModal').modal("show")
        });
        $(document).on('click', "#openmodal_forvideo", function() {
            var url = $(this).attr("data-id");
            var url2 = $(this).attr("data-id2");
            var url_update = 'https://www.youtube.com/embed/' + url2 + '';
            $("#datas").show().html('<iframe width="653" height="345" src="' + url_update + '"></iframe>');
            $('#myModal').modal("show")
        });
        $(document).on('click', "#close_video", function() {
            $("#datas").show().html('');
        });
    </script>

    <script type="text/javascript">
        window.NREUM || (NREUM = {});
        NREUM.info = {
            "beacon": "bam.nr-data.net",
            "licenseKey": "NRJS-a00d8cfd76fe2509b44",
            "applicationID": "1028219721",
            "transactionName": "Nl1aZBNVVkNTUkVbVg8XeVMVXVdeHXBBQmUpTExAPXdXXkZDXl5VBEpLbCVVS1hQXlBAXSJXVkQTW1RcV0NxW1cFXUA=",
            "queueTime": 0,
            "applicationTime": 13,
            "atts": "GhpZEltPRU0=",
            "errorBeacon": "bam.nr-data.net",
            "agent": ""
        }
    </script>
@endsection
