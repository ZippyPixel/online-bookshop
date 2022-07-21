<?php

session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("location: ../index.php");
}
$id = $_SESSION['id'];
include "../config.php";
error_reporting(0);

// if ($_GET['name'] == '' || $_GET['number'] == '' || $_GET['address'] == '') {
//     header("location: ../index.php");
// }

$val_id = urlencode($_POST['val_id']);
$store_id = urlencode("techb5fcaadff19ed6");
$store_passwd = urlencode("techb5fcaadff19ed6@ssl");
$requested_url = ("https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php?val_id=" . $val_id . "&store_id=" . $store_id . "&store_passwd=" . $store_passwd . "&v=1&format=json");

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $requested_url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); # IF YOU RUN FROM LOCAL PC
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); # IF YOU RUN FROM LOCAL PC

$result = curl_exec($handle);

$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

if ($code == 200 && !(curl_errno($handle))) {

    # TO CONVERT AS ARRAY
    # $result = json_decode($result, true);
    # $status = $result['status'];

    # TO CONVERT AS OBJECT
    $result = json_decode($result);

    # TRANSACTION INFO
    $status = $result->status;
    $tran_date = $result->tran_date;
    $tran_id = $result->tran_id;
    $val_id = $result->val_id;
    $amount = $result->amount;
    $store_amount = $result->store_amount;
    $bank_tran_id = $result->bank_tran_id;
    $card_type = $result->card_type;

    # EMI INFO
    $emi_instalment = $result->emi_instalment;
    $emi_amount = $result->emi_amount;
    $emi_description = $result->emi_description;
    $emi_issuer = $result->emi_issuer;

    # ISSUER INFO
    $card_no = $result->card_no;
    $card_issuer = $result->card_issuer;
    $card_brand = $result->card_brand;
    $card_issuer_country = $result->card_issuer_country;
    $card_issuer_country_code = $result->card_issuer_country_code;

    # API AUTHENTICATION
    $APIConnect = $result->APIConnect;
    $validated_on = $result->validated_on;
    $gw_version = $result->gw_version;

    $details = '';
    $uniqueId = uniqid('Ebook', false);
    $name = $_GET['name'];
    $number = $_GET['number'];
    $address = $_GET['address'];
    // insert to database
    foreach ($_SESSION["shopping_cart"] as &$product) {
        $details .= $product["name"];
        $details .= '-';
        $details .= '\t';
        $details .= $product["quantity"];
        $details .= 'x';
        $details .= '-';
        $details .= '\t';
        $details .=  $product["price"] *  $product["quantity"];
        $details .= ',';
        $details .= '\n';
    }
    $sql1 = "INSERT INTO purchase (User_ID, name, uniqueId, number, address, purchase, amount, date)
     VALUES($id,'$name','$uniqueId','$number','$address','$details',$amount,Now())";
    mysqli_query($conn, $sql1);

    foreach ($_SESSION["shopping_cart"] as &$value) {
        // update quantity
        $sql3 = "SELECT * FROM products WHERE code ='" . $value['code'] . "'";
        $result3 = mysqli_query($conn, $sql3);
        $row = $result3->fetch_assoc();
        $updateQuantity = $row['quantity'] - $value['quantity'];

        $sql4 = "UPDATE products SET quantity= $updateQuantity WHERE code ='" . $value['code'] . "'";
        $result4 = mysqli_query($conn, $sql4);
    }
    unset($_SESSION["shopping_cart"]);

} else {

    echo "Failed to connect with SSLCOMMERZ";
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
            <!-- status -->

            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Well done! <?php echo $_GET['name'] ?></h4>
                <p> you have successfully completed your <?php echo $amount?> payment .</p>
                <hr>
                <p class="mb-0">You will get your delivery soon.</p>
            </div>
        </div>
    </section>
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