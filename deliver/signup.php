<?php


session_start();

if (isset($_SESSION['deliver'])) {
    header("location: ./index.php");
}
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>e-book</title>
        <!-- icon -->
        <link rel="icon" href="../img/cart.png">
        <!-- bootstrap css -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <!-- google font css-->
        <link href="../css/poppinsfont.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../css/exofont.min.css">
        <!-- icons css css-->
        <link rel="stylesheet" href="../css/all.min.css">
        <!-- iconfont css -->
        <link rel="stylesheet" href="../css/icofont/icofont.min.css">
        <!-- variable css -->
        <link rel="stylesheet" href="../css/variable1.min.css">

        <!-- style css -->
        <link rel="stylesheet" href="../css/style.min.css">
        <!-- resposive css -->
        <link rel="stylesheet" href="../css/responsive.min.css">
    </head>

    <body class="login-body bg-primary">
        <main class="site-main">
            <!-- incharge login area -->
            <section class="login-area bg-primary d-flex align-items-center" id="login">
                <div class="container">
                    <div class="row my-3">
                        <div class=" col-lg-12 col-md-12  my-auto text-right">
                            <a href="./">
                                <p><i class="fas fa-sign-in-alt mx-2"></i>Sign in</p>
                            </a>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-lg-2 col-md-2 mx-auto my-auto text-center">

                            <img src="../img/cart.png" class="img-fluid" alt="">
                            <p>e-book</p>
                            <!-- <hr style="background: white;"> -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 mx-auto my-auto text-center">
                            <p class="section-title  text-uppercase"><span>create a new account for delivary</span>
                            </p>
                        </div>
                    </div>

                    <div class="row my-3">
                        <!-- form area -->
                        <div class="col-lg-4 col-md-4 col-sm-12 form-area mx-auto">
                            <div class="card">
                                <div class="card-body shadow-lg">
                                    <form id="form" action="" method="POST" class="login-form" enctype="multipart/form-data">
                                        <div class="form-group">
                                           
                                            <label for="exampleInputPassword1"> Name <span>*</span></label>
                                            <div class="input-group-prepend">
                                                <span style="border:none;" class="input-group-text"><i
                                            class="fa fa-user"></i></span>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Your Full Name" required="">
                                            </div>
                                            <label for="exampleInputPassword1"> Email <span>*</span></label>
                                            <div class="input-group-prepend">
                                                <span style="border:none;" class="input-group-text"><i
                                            class="far fa-envelope-open"></i></span>
                                                <input type="text" class="form-control" id="email" name="email" placeholder="sample@demo.com" required="">
                                            </div>
                                            <label for="exampleInputPassword1"> Password <span>*</span></label>
                                            <div class="input-group-prepend">
                                                <span style="border:none;" class="input-group-text"><i
                                            class="fas fa-unlock-alt"></i></span>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Your Password" required="">
                                            </div>
                                            <label for="exampleInputPassword1"> confirm Password <span>*</span></label>
                                            <div class="input-group-prepend">
                                                <span style="border:none;" class="input-group-text"><i
                                            class="fas fa-unlock-alt"></i></span>
                                                <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Enter Your Password" required="">
                                            </div>


                                        </div>

                                        <div class="text-center">
                                            <button class="btn btn-primary text-uppercase" type="button" name="sendmsg" id="registerButton">sign up
                                </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class=" col-lg-4 col-md-4  my-auto mx-auto text-right">
                            <a href="./">
                                <p>ALready have an account? sign In</p>
                            </a>
                        </div>
                    </div>
                </div>

            </section>

        </main>
        <?php
    include './footer.php';
    ?>


            <!-- gotop -->
            <div class="container-fluid"><a class="gotop" href="#"><i class="fas fa-level-up-alt"></i></a></div>

            <script src="../js/jquery-3.5.1.min.js"></script>
            <script src="../js/popper.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>
            <script src="../js/jquery.easing.min.js"></script>
            <script type="text/javascript">
                window.addEventListener("scroll", function() {
                    // var header = document.querySelector("section");
                    // header.classList.toggle("sticky", window.scrollY > 0);
                    var gotop = document.querySelector(".gotop");
                    gotop.classList.toggle("gotopbutton", window.scrollY > 0);
                });
                $(function() {

                    $('[data-toggle="tooltip"]').tooltip()
                });
            </script>
            <script src="../js/particles.min.js"></script>
            <script src="../js/app.min.js"></script>
            <script src="../js/alert.min.js"></script>
            <Script>
                $("#registerButton").click(function() {
                    var email = $("#email").val();
                    var password = $("#password").val();
                    var confirmpassword = $("#confirmpassword").val();

                    if (email == "" || password == "" || confirmpassword == "" || password != confirmpassword) {

                        swal.fire("Error!", "Try Again!", "error");
                    } else {
                        swal.fire("Processing", "", "warning");

                        $.ajax({
                            type: "POST",
                            url: 'signupFrom1.php',
                            data: $('.login-form').serialize(),
                            dataType: "JSON",
                            success: function(data) {
                                if (data.error) {
                                    swal.fire("Error!", data.msg, "error");
                                } else {
                                    swal.fire("success!", data.msg, "success").then(okay => {
                                        if (okay) {
                                            window.location.replace("./");
                                        }
                                    });
                                    // window.location.replace("dashboard.php")

                                }
                            }

                        });
                    }
                });
            </Script>

    </body>

    </html>