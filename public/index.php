<?php
require_once('config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png"/>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Welcome to Ticket Dashboard</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <meta name="viewport" content="width=device-width"/>
    <!-- Bootstrap core CSS     -->
    <link href="<?php echo _CDN_HOST ?>/assets/css/bootstrap.min.css" rel="stylesheet"/>
    <!--  Material Dashboard CSS    -->
    <link href="<?php echo _CDN_HOST ?>/assets/css/material-dashboard.css" rel="stylesheet"/>
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo _CDN_HOST ?>/assets/css/demo.css" rel="stylesheet"/>
    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons"/>
</head>

<body>
<nav class="navbar navbar-primary navbar-transparent navbar-absolute">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
    </div>
</nav>
<div class="wrapper wrapper-full-page">
    <div class="full-page login-page" filter-color="black"
         data-image="<?php echo _CDN_HOST ?>/assets/img/login.jpeg">
        <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                        <form method="post">
                            <div class="card card-login card-hidden">
                                <div class="card-header text-center" data-background-color="rose">
                                    <h4 class="card-title">Welcome!</h4>
                                </div>
                                <div class="card-content">
                                    <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">perm_identity</i>
                                            </span>
                                        <div class="form-group label-floating">
                                            <input id="username" name="username" type="text" class="form-control" placeholder="NIK" required>
											<input type="hidden" name="CsrfToken" id="CsrfToken" value="<?php echo $_SESSION['csrf_token']; ?>" >
                                        </div>
                                    </div>
                                    <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                        <div class="form-group label-floating">
                                            <input id="pass" name="pass" type="password" class="form-control" placeholder="Password" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-3"></label>
                                        <div class="col-md-9">
                                            <!--                                                <button type="button" id="eye">-->
                                            <!--                                                    <img src="https://cdn0.iconfinder.com/data/icons/feather/96/eye-16.png"/>-->
                                            <!--<!--alt="eye"/>-->
                                            <!--                                                </button>-->
                                            <button type="button" id="eye" class="btn btn-just-icon btn-simple">
                                                <i class="material-icons">visibility</i>
                                            </button>
                                            <label>Show Password</label>
                                            <script>
                                                function show() {
                                                    var p = document.getElementById('pass');
                                                    p.setAttribute('type', 'text');
                                                }

                                                function hide() {
                                                    var p = document.getElementById('pass');
                                                    p.setAttribute('type', 'password');
                                                }

                                                var pwShown = 0;

                                                document.getElementById("eye").addEventListener("click", function () {
                                                    if (pwShown == 0) {
                                                        pwShown = 1;
                                                        show();
                                                    } else {
                                                        pwShown = 0;
                                                        hide();
                                                    }
                                                }, false);
                                            </script>
                                        </div>
                                    </div>
                                    <!--                                    <div class="row">-->
                                    <!--                                        <label class="col-md-1"></label>-->
                                    <!--                                        <div class="col-md-9">-->
                                    <!--                                            <div class="checkbox form-horizontal-checkbox">-->
                                    <!--                                                <label>-->
                                    <!--                                                    <input type="checkbox" name="optionsCheckboxes"> Remember Me-->
                                    <!--                                                </label>-->
                                    <!--                                            </div>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                </div>
                                <div class="footer text-center">
                                    <a onclick="sendData()" type="button" class="btn btn-rose btn-simple btn-wd btn-lg">GO</a>
                                    <script>
                                        function sendData() {
                                            var username = $("#username").val();
                                            var pass = $("#pass").val();
                                            $.ajax({
                                                url: '<?php echo _BASE_DIR ?>/pros_login.php',
                                                method: 'POST',
                                                data: {
                                                    username: username,
                                                    pass: pass
                                                },
                                                dataType: "json",
                                                success: function (data) {
                                                    if (parseInt(data.status) == 1) {
                                                        $(location).attr('href', '<?php echo _BASE_DIR ?>vw/vw_dashboard.php');
                                                        $.ajax({
                                                            method: 'POST',
                                                            data: {
                                                                role: data.role
                                                            },
                                                        });
                                                    } else {
                                                        swal({
                                                            type: 'error',
                                                            title: 'Login Gagal !'
                                                        })
                                                    }
                                                }
                                            });
                                        }
                                    </script>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <p class="copyright pull-right">
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                </p>
            </div>
        </footer>
    </div>
</div>
</body>
<!--   Core JS Files   -->
<script src="<?php echo _CDN_HOST ?>/assets/js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="<?php echo _CDN_HOST ?>/assets/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo _CDN_HOST ?>/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo _CDN_HOST ?>/assets/js/material.min.js" type="text/javascript"></script>
<script src="<?php echo _CDN_HOST ?>/assets/js/perfect-scrollbar.jquery.min.js"
        type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="<?php echo _CDN_HOST ?>/assets/js/jquery.validate.min.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?php echo _CDN_HOST ?>/assets/js/moment.min.js"></script>
<!--  Charts Plugin -->
<script src="<?php echo _CDN_HOST ?>/assets/js/chartist.min.js"></script>
<!--  Plugin for the Wizard -->
<script src="<?php echo _CDN_HOST ?>/assets/js/jquery.bootstrap-wizard.js"></script>
<!--  Notifications Plugin    -->
<script src="<?php echo _CDN_HOST ?>/assets/js/bootstrap-notify.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?php echo _CDN_HOST ?>/assets/js/bootstrap-datetimepicker.js"></script>
<!-- Vector Map plugin -->
<script src="<?php echo _CDN_HOST ?>/assets/js/jquery-jvectormap.js"></script>
<!-- Sliders Plugin -->
<script src="<?php echo _CDN_HOST ?>/assets/js/nouislider.min.js"></script>
<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js"></script>
<!-- Select Plugin -->
<script src="<?php echo _CDN_HOST ?>/assets/js/jquery.select-bootstrap.js"></script>
<!--  DataTables.net Plugin    -->
<script src="<?php echo _CDN_HOST ?>/assets/js/jquery.datatables.js"></script>
<!-- Sweet Alert 2 plugin -->
<script src="<?php echo _CDN_HOST ?>/assets/js/sweetalert2.js"></script>
<!--	Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="<?php echo _CDN_HOST ?>/assets/js/jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin    -->
<script src="<?php echo _CDN_HOST ?>/assets/js/fullcalendar.min.js"></script>
<!-- TagsInput Plugin -->
<script src="<?php echo _CDN_HOST ?>/assets/js/jquery.tagsinput.js"></script>
<!-- Material Dashboard javascript methods -->
<script src="<?php echo _CDN_HOST ?>/assets/js/material-dashboard.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo _CDN_HOST ?>/assets/js/demo.js"></script>
<script type="text/javascript">
    $().ready(function () {
        demo.checkFullPageBackgroundImage();

        setTimeout(function () {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700)
    });
</script>


</html>
