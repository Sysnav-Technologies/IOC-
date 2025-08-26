<?php
// Include paths for URL constants
require_once __DIR__ . '/../../config/paths.php';

Session::init();
if (isset($_SESSION['loggedIn'])) {
    
} else {
    header('location:' . URL . 'login');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>IOC | Fuel Station management</title>
        <!-- Bootstrap -->
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
        <!-- Include roboto.css to use the Roboto web font, material.css to include the theme and ripples.css to style the ripple effect -->
        <!-- CSS loading animation -->
        <link href="<?php echo CSS ?>dist/css/roboto.min.css" rel="stylesheet">
        <link href="<?php echo CSS ?>dist/css/material.min.css" rel="stylesheet">
        <link href="<?php echo CSS ?>dist/css/ripples.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo CSS1 ?>header/spinkit.css">
        <link rel="stylesheet" type="text/css" href="<?php echo CSS1 ?>login.css">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo CSS ?>header/favicon/favicon-16x16.png">
        <link rel="stylesheet" type="text/css" href="<?php echo CSS1 ?>stocks/stocks.css">

        <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
        <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>

        <!-- CSS for morning stock for stocks module -->
        <link rel="stylesheet" type="text/css" href="<?php echo CSS1 ?>stocks/morning_reading.css">
        <!-- CSS for pump status  -->
        <link rel="stylesheet" type="text/css" href="<?php echo CSS ?>stocks/pump/css/statuses.css">
        <!-- Jquery  -->
        <script type="text/javascript" src="<?php echo JQuery ?>"></script>
        <!-- IOC Configuration -->
        <script type="text/javascript" src="<?php echo CSS1 ?>../js/config.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS1 ?>stocks/graph.css">

        <!-- CSS for branches of branches module -->
        <link rel="stylesheet" type="text/css" href="<?php echo CSS ?>transport/branches/css/index.css">

        <link rel="stylesheet" type="text/css" href="<?php echo CSS ?>index/css/index.css">
        <link rel="stylesheet" type="text/css" href="<?php echo CSS ?>profile/css/index.css">

        <!-- Path for foating action button CSS -->
        <link href="<?php echo FLOATING ?>mfb.css" rel="stylesheet">
        <!-- Path for foating action button JS -->
        <script src="<?php echo FLOATING ?>mfb.js"></script>
        <!-- ICONS for floating action -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/1.5.2/css/ionicons.css">
        <script src="<?php echo BOWER ?>sweetalert/dist/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo BOWER ?>sweetalert/dist/sweetalert.css">
        
        <!-- Currency Helper JS -->
        <script src="<?php echo URL ?>views/js/currency-helper.js"></script>
        <script>
            // Initialize currency settings from PHP
            $(document).ready(function() {
                updateCurrencySettings(<?php echo json_encode(CurrencyHelper::getSettings()); ?>);
            });
        </script>

    </head>
    <body>
        <div id="back-img"></div>
        <div class="navbar navbar-default" id="NavBar">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/" id="brand">IOC<sup>BETA</sup></a>
            </div>
            <div class="navbar-collapse collapse navbar-responsive-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo URL ?>stocks" class="nav-bar">Stocks</a></li>
                    <li><a href="<?php echo URL ?>clients" class="nav-bar">Clients</a></li>
                    <li><a href="<?php echo URL ?>employees" class="nav-bar">Employees</a></li>
                    <li><a href="<?php echo URL ?>transport" class="nav-bar">Transportation</a></li>
                    <li><a href="<?php echo URL ?>carwash" class="nav-bar">Car wash</a></li>
                    <li><a href="<?php echo URL ?>lube_service" class="nav-bar">Lubricant service</a></li>
                    <li><a href="<?php echo URL ?>assets" class="nav-bar">Assets maintenance</a></li>
                    <li><a href="<?php echo URL ?>revenue" class="nav-bar">Revenue</a></li>
                </ul>


                <ul class="nav navbar-nav navbar-right">
                    <!-- <li id="dashboard-li"><a href="index/Dashboard" id="dashboard">Dashboard</a></li>
                    -->
                    <li id="profile"><a href="<?php echo URL ?>profile">Profile</a></li>
                    <li><a href="<?php echo URL ?>index/logout">Logout</a></li>
                    <!--    <li class="dropdown">
                            <a href="bootstrap-elements.html" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0)">Action</a></li>
                                <li><a href="javascript:void(0)">Another action</a></li>
                                <li><a href="javascript:void(0)">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="javascript:void(0)">Separated link</a></li>
                            </ul>
                        </li> -->
                </ul>
            </div>
            <script>
                // Safety mechanism to clear any stuck spinners
                $(document).ready(function() {
                    // Clear any existing spinners after 5 seconds of inactivity
                    setTimeout(function() {
                        if ($('#spinner').children().length > 0) {
                            $('#spinner').empty();
                            console.log('Cleared stuck spinner');
                        }
                    }, 5000);
                    
                    // Global AJAX error handler
                    $(document).ajaxError(function(event, xhr, settings, thrownError) {
                        console.log('AJAX Error:', thrownError);
                        $('#spinner').empty();
                        if (!$('#loader').html()) {
                            $('#loader').html('<div class="alert alert-danger">Network error. Please check your connection and try again.</div>');
                        }
                    });
                });

                $(window).ready(function () {
                    var hash = window.location.hash;
                    $('#loader').empty();
                    $('#spinner').load(buildUrl('views/css/header/spinkit.html'));
                    var len = hash.length;
                    hash = hash.substring(2, len);
                    console.log('Hash value' + hash);
                    if (hash == "") {
                        // setTimeout(function(){
                        //     console.log('timeout');

                        //     $('#spinner').empty();  

                        //         $('#loader').load(buildUrl(''), function(){
                        //             fadeIN();
                        //             window.location.hash = "/";
                        //             console.log('Success !');
                        //         });   

                        // },1000);
                        return false;
                    }
                    console.log(hash);
                    setTimeout(function () {
                        console.log('timeout');

                        $('#spinner').empty();
                        $('#subloader').empty();
                        console.log('YUP ! ' + hashCheck(hash)[0]);
                        
                        function handleInitialError() {
                            $('#spinner').empty();
                            $('#loader').html('<div class="alert alert-danger">Failed to load initial content. Please refresh the page.</div>');
                            fadeIN();
                        }
                        
                        if (hashCheck(hash)[1]) {
                            $('#loader').load(buildUrl(hashCheck(hash)[0]), function (response, status, xhr) {
                                if (status == "error") {
                                    handleInitialError();
                                } else {
                                    fadeIN();
                                    //        window.location.hash = "/" + hash;
                                    console.log('Success !');
                                }
                            });
                            $('#subloader').load(buildUrl('stocks/' + hashCheck(hash)[1]), function (response, status, xhr) {
                                if (status == "error") {
                                    $('#subloader').html('<div class="alert alert-warning">Failed to load sub-content.</div>');
                                } else {
                                    //console.log('morning_stock !');
                                    $('#subloader').hide();
                                    $('#subloader').fadeIn('slow');
                                }
                            });
                        }
                        else {
                            $('#loader').load(buildUrl(hash), function (response, status, xhr) {
                                if (status == "error") {
                                    handleInitialError();
                                } else {
                                    fadeIN();
                                    window.location.hash = "/" + hash;
                                    console.log('Success !');
                                }
                            });
                        }

                    }, 1000);

                    return false;
                });
                function hashCheck(url) {
                    var hashURL = url.split('/');
                    //if(typeof hashURL[1] == 'string'){
                    return hashURL;
                    //}
                }
                // $(window).on('hashchange', function() {
                //     console.log(window.location.hash);   
                //     var hash = window.location.hash;
                //     if(hash == "#stocks"){
                //         alert('Stocks');
                //         setTimeout(function(){
                //             console.log('timeout');

                //             $('#spinner').empty();  

                //                 $('#loader').load(buildUrl('stocks'), function(){
                //                     fadeIN();
                //                     window.location.hash = "stocks";
                //                     console.log('Success !');
                //                 });   

                //         },1000);
                //         $('#subloader').empty();
                //     }
                // });



                $('.nav-bar').click(function (e) {
                    e.preventDefault(); // Prevent default link behavior
                    $('#loader').empty();
                    $('#spinner').load(buildUrl('views/css/header/spinkit.html'));
                    var url = $(this).attr("href");
                    
                    // Extract the controller name from the URL
                    var urlParts = url.split('/');
                    var controller = urlParts[urlParts.length - 1]; // Get the last part
                    
                    console.log('Loading controller:', controller);

                    setTimeout(function () {
                        console.log('timeout');

                        $('#spinner').empty(); // Clear spinner first
                        window.location.hash = "/" + controller;
                        
                        // Add error handling for all AJAX calls
                        function handleError() {
                            $('#spinner').empty();
                            $('#loader').html('<div class="alert alert-danger">Failed to load content. Please try again.</div>');
                            fadeIN();
                        }
                        
                        if (controller == 'stocks') {
                            if (!window.mode) {
                                $('#loader').load(buildUrl('stocks'), function (response, status, xhr) {
                                    if (status == "error") {
                                        handleError();
                                    } else {
                                        $(".cont-card").empty();
                                        console.log('STOCKSSS');
                                        fadeIN();
                                        console.log('Success !');
                                    }
                                });
                            }
                            else if (window.mode == "Dashboard") {
                                $('#loader').load(buildUrl('stocks/stockDashboard'), function (data, status, xhr) {
                                    if (status == "error") {
                                        handleError();
                                    } else {
                                        fadeIN();
                                        console.log(data);
                                    }
                                });
                            }
                        }
                        else if (controller == '/') {
                            $('#loader').load(buildUrl(''), function (response, status, xhr) {
                                if (status == "error") {
                                    handleError();
                                } else {
                                    $(".cont-card").empty();
                                    fadeIN();
                                    console.log('Success index!');
                                }
                            });
                        }
                        else if (controller == "clients") {
                            $('#loader').load(buildUrl('clients'), function (response, status, xhr) {
                                if (status == "error") {
                                    handleError();
                                } else {
                                    fadeIN();
                                    console.log('Success !');
                                }
                            });
                        }
                        else if (controller == "assets") {
                            $('#loader').load(buildUrl('assets'), function (response, status, xhr) {
                                if (status == "error") {
                                    handleError();
                                } else {
                                    $(".cont-card").empty();
                                    fadeIN();
                                    console.log('Success !');
                                }
                            });
                        }
                        else if (controller == "employees") {
                            $('#loader').load(buildUrl('employees'), function (response, status, xhr) {
                                if (status == "error") {
                                    handleError();
                                } else {
                                    $(".cont-card").empty();
                                    fadeIN();
                                    console.log('Success !');
                                }
                            });
                        }
                        else if (controller == "transport") {
                            $('#loader').load(buildUrl('transport'), function (response, status, xhr) {
                                if (status == "error") {
                                    handleError();
                                } else {
                                    $(".cont-card").empty();
                                    fadeIN();
                                    console.log('Success !');
                                }
                            });
                        }
                        else if (controller == "carwash") {
                            $('#loader').load(buildUrl('carwash'), function (response, status, xhr) {
                                if (status == "error") {
                                    handleError();
                                } else {
                                    $(".cont-card").empty();
                                    fadeIN();
                                    console.log('Success !');
                                }
                            });
                        }
                        else if (controller == "lube_service") {
                            $('#loader').load(buildUrl('lube_service'), function (response, status, xhr) {
                                if (status == "error") {
                                    handleError();
                                } else {
                                    $(".cont-card").empty();
                                    fadeIN();
                                    console.log('Success !');
                                }
                            });
                        }
                        else if (controller == "revenue") {
                            $('#loader').load(buildUrl('revenue'), function (response, status, xhr) {
                                if (status == "error") {
                                    handleError();
                                } else {
                                    $(".cont-card").empty();
                                    fadeIN();
                                    console.log('Success !');
                                }
                            });
                        }
                        else {
                            $('#loader').load(buildUrl('err'), function (response, status, xhr) {
                                if (status == "error") {
                                    handleError();
                                } else {
                                    $(".cont-card").empty();
                                    fadeIN();
                                    console.log('Error !');
                                }
                            });
                        }
                    }, 1000);
                    $('#subloader').empty();
                });
                // $('#brand').click(function(e){
                //     $('#loader').load(buildUrl(''), function(){      
                //         console.log('Success !');
                //     }); 
                //    e.preventDefault(); 
                // });
                function fadeIN() {
                    $('#spinner').empty(); // Clear spinner first
                    $('#loader').hide();
                    $('#loader').fadeIn('slow');
                }
                
                // Helper functions to control spinner
                function showSpinner() {
                    $('#spinner').load(buildUrl('views/css/header/spinkit.html'));
                }
                
                function hideSpinner() {
                    $('#spinner').empty();
                }
                
                // Make functions globally available
                window.showSpinner = showSpinner;
                window.hideSpinner = hideSpinner;
                $("#profile").click(function (e) {
                    e.preventDefault();
                    $("#loader").empty();
                    $('#spinner').load(buildUrl('views/css/header/spinkit.html'));
                    $('#subloader').load(buildUrl('profile'), function (response, status, xhr) {
                        if (status == "error") {
                            $('#spinner').empty();
                            $('#subloader').html('<div class="alert alert-danger">Failed to load profile. Please try again.</div>');
                        } else {
                            $(".cont-card").empty();
                            fadeIN();
                            console.log('Success !');
                        }
                    });
                });
                // $('#dashboard').click(function(e){
                //     e.preventDefault();
                //     if(!window.mode){
                //         window.mode = "Dashboard";
                //         $('#NavBar').fadeOut('fast').fadeIn('slow');
                //         setTimeout(function(){
                //             $('#dashboard').text('Quit Dashboard');
                //             $('#NavBar').removeClass('navbar navbar-default').addClass('navbar navbar-inverse');
                //             window.mode = "Dashboard";
                //             $('#loader').empty();
                //         },200);
                //     }
                //     else if(window.mode == "Dashboard"){
                //         $('#NavBar').fadeOut('fast').fadeIn('slow');
                //         setTimeout(function(){
                //             $('#dashboard').text('Dashboard');
                //             $('#NavBar').removeClass('navbar navbar-inverse').addClass('navbar navbar-default');
                //             delete window.mode;
                //             $('#loader').empty();
                //         },200);
                //     }
                // });
                
                //selected tab is highlighted here
                $(".nav a").on("click", function () {
                    $(".nav").find(".active").removeClass("active");
                    $(this).parent().addClass("active");
                });
            </script>
        </div>
        <div class="col-lg-12">
            <div class="row">
                <div id="loader" class="col-md-3"> 

                </div>
                <div id="subloader" class="col-md-9">

                </div>
                <div style="padding-top:100px"></div>
                <div class="spinner" id="spinner">
                </div>
            </div>
        </div>





