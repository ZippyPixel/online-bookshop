<?php

session_start();
if (!isset($_SESSION['deliver']) || $_SESSION['deliver'] !== true) {
    header("location: ./login.php");
}
$name = $_SESSION['name'];
include "../config.php";
error_reporting(0);
$status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>   Welcome </strong> ' . $name . ' 
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>';

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
    <!-- zoom in animantion css -->
    <link href="../css/aos.min.css" rel="stylesheet">
    <!-- google font css-->
    <link href="../css/poppinsfont.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/exofont.min.css">
    <!-- iconfont css -->
    <link rel="stylesheet" href="../css/icofont/icofont.min.css">
    <!-- icons css css-->
    <link rel="stylesheet" href="../css/all.min.css">

    <!-- carousel css -->
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/owl.theme.default.min.css">
    <!-- magnatic popup -->
    <link rel="stylesheet" href="../Magnific-Popup/dist/magnific-popup.min.css">
    <!-- variable css -->
    <link rel="stylesheet" href="../css/variable1.min.css">

    <!-- sidebar css -->
    <link rel="stylesheet" href="../css/sidebar1.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="../css/style.min.css">
    <!-- resposive css -->
    <link rel="stylesheet" href="../css/responsive.min.css">
</head>

<body>

    <!-- side bar -->

    <section>
        <div class="container d-flex align-items-center justify-content-around">

            <nav class="nav-menu d-none d-lg-block">
                <div class="logo text-center">
                    <img src="../img/cart.png" alt="" class="img-fluid"><span>e-book</span>
                </div>
                <hr>
                <?php
                include "./sidebar.php";
                ?>

            </nav>

        </div>


        <?php
        $id = $_SESSION['id'];

        $sql = "SELECT * FROM user WHERE id ='$id'";
        $result = mysqli_query($conn, $sql);
        while ($row = $result->fetch_assoc()) {

        ?>

            <!-- main body -->
            <main class="site-main main">
                <!-- incharge info area -->
                <div class="container info text-right">
                    <div>
                        <p>
                            <?php
                            if ($row['pic'] == '') {
                                echo '<a class="test-popup-link" href="../img/person.png"><img src="../img/person.png"/></a>';
                            } else {
                                echo '<a class="test-popup-link" href="data:image/jpeg;base64,' . base64_encode($row['pic']) . '"><img src="data:image/jpeg;base64,' . base64_encode($row['pic']) . '"/></a>';
                            }

                            ?>
                            <?php echo "Welcome " . $_SESSION['name'] ?>
                        </p>

                        <hr>
                    </div>
                </div>
            <?php

        }
            ?>

            <!-- cart -->



    </section>
    <section class="main">

        <div class="container">
            <!-- <div style="clear:both;"></div> -->
            <!-- mesaage box -->
            <div class="message_box">
                <?php echo $status; ?>
            </div>
            <div class="table-responsive my-3">
                <table class="table text-capitalize table-hover table-bordered text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>date</th>
                            <th>Id</th>
                            <th>name</th>
                            <th>number</th>
                            <th>adress</th>
                            <th>amount</th>
                            <th>details</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2 = "SELECT * FROM purchase WHERE status='1' ORDER BY date ASC";
                        $result2 = mysqli_query($conn, $sql2);
                        $count = 1;
                        while ($row = $result2->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $row['date']; ?></td>
                                <td><?php echo $row['uniqueId']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['number']; ?></td>
                                <td><?php echo $row['address']; ?></td>
                                <td><?php echo $row['amount']; ?></td>
                                <td><?php echo $row['purchase']; ?></td>
                            
                            </tr>
                        <?php
                            $count += 1;
                        }
                        ?>
                    </tbody>
                </table>
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
        windo
        w.addEventListener("scroll", function() {
            // var header = document.querySelector("section");
            // header.classList.toggle("sticky", window.scrollY > 0);
            var gotop = document.querySelector(".gotop");
            gotop.classList.toggle("gotopbutton", window.scrollY > 0);
        });
        $(function() {

            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
    <script src="../js/aos.min.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../Magnific-Popup/dist/jquery.magnific-popup.min.js"></script>
    <script src="../js/header.min.js"></script>
    <script src="../js/alert.min.js"></script>
    <script src="../js/index.js"></script>
</body>

</html>