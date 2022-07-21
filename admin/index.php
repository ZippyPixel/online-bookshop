<?php

session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
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

// delete
if (isset($_POST['delete']) && $_POST['delete'] != "") {

    $id = $_POST['delete'];
    $sql3 = "DELETE FROM products  WHERE id ='$id'";
    $result3 = mysqli_query($conn, $sql3);
}
if (isset($_POST['edit']) && $_POST['edit'] != "") {

    $id = $_POST['edit'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $file = $_FILES['image']['tmp_name'];
    if (!isset($file)) {
        // echo "Please select a profile pic";
    } else {


        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $image_name = addslashes($FILES['image']['name']);
        $image_size = getimagesize($_FILES['image']['tmp_name']);

        if ($image_size == FALSE) {
            // echo "That isn't a image.";
            $status = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>   That is not a image </strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>';
        } else {

            $update = $conn->query("UPDATE products SET image='$image' WHERE id='$id'");
        }
    }

    $sql3 = "UPDATE products SET name='$name',price=$price,quantity=$quantity  WHERE id ='$id'";
    $result3 = mysqli_query($conn, $sql3);
}
// add item
if (isset($_POST['add']) && $_POST['add'] != "") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $code = $_POST['code'];

    $flag = 0;
    $pic = 0;

    $file = $_FILES['image']['tmp_name'];
    if (!isset($file)) {
        // echo "Please select a profile pic";
    } else {


        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $image_name = addslashes($FILES['image']['name']);
        $image_size = getimagesize($_FILES['image']['tmp_name']);

        if ($image_size == FALSE) {
            // echo "That isn't a image.";
            $status = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>   That is not a image </strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>';
        } else {
            $pic = 1;
        }
    }

    $sql2 = "SELECT * FROM products";
    $result2 = mysqli_query($conn, $sql2);

    while ($row = $result2->fetch_assoc()) {
        $db_code = $row['code'];
        if ($db_code == $code) {
            $flag = 1;
            break;
        }
    }
    if ($flag != 1) {
        $sql3 = "INSERT INTO products(name, code, image, price, quantity) VALUES 
        ('$name','$code','$image',$price,'$quantity')";
        $result3 = mysqli_query($conn, $sql3);
    } else {
        $status = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>   product code should be unique! </strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>';
    }
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

            <div class="my-3 text-right">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary text-uppercase" data-toggle="modal" data-target="#exampleModalCenter">
                    add products
                </button>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">add product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleInputPassword1"> name -</label>
                                    <div class="input-group-prepend">

                                        <input type="text" class="form-control" id="name" name="name" required="">
                                    </div>
                                    <label for="exampleInputPassword1"> code (must be unique*) -</label>
                                    <div class="input-group-prepend">

                                        <input type="text" class="form-control" id="code" name="code" required="">
                                    </div>
                                    <label for="exampleInputPassword1"> price -</label>
                                    <div class="input-group-prepend">

                                        <input type="text" class="form-control" id="price" name="price" required="">
                                    </div>
                                    <label for="exampleInputPassword1"> quantity -</label>
                                    <div class="input-group-prepend">

                                        <input type="text" class="form-control" id="quantity" name="quantity" required="">
                                    </div>
                                    <label for="exampleInputPassword1"> image -</label>
                                    <div class="input-group-prepend">

                                        <input type="file" name="image" class="form-control" id="file" required="">
                                    </div>


                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                <button class="btn btn-success text-uppercase" type="submit" name="add" value="add">add item</button>



                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive my-3">
                <table class="table text-capitalize table-hover table-bordered text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>product</th>
                            <th>code</th>
                            <th>name</th>
                            <th>price</th>
                            <th>quantity</th>
                            <th>edit</th>
                            <th>delete</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2 = "SELECT * FROM products ";
                        $result2 = mysqli_query($conn, $sql2);
                        $count = 1;
                        while ($row = $result2->fetch_assoc()) {
                        ?>
                            <tr>


                                <td><?php echo $count; ?></td>
                                <td><?php
                                    if ($row['image'] == '') {
                                        echo '<a class="test-popup-link" href="../img/cart.png"><img src="../img/cart.png" class="img-fluid"  width="60px"/></a>';
                                    } else {
                                        echo '<a class="test-popup-link" href="data:image/jpeg;base64,' . base64_encode($row['image']) . '"><img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" class="img-fluid"  width="60px"/></a>';
                                    }
                                    ?></td>
                                <td><?php echo $row['code']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['price']; ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td>

                                    <button class=" btn btn-outline-success text-uppercase" type="button" data-toggle="modal" data-target="#exampleModalCenter<?php echo $count ?>">edit</button>


                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalCenter<?php echo $count ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Edit</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="" method="POST" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1"> name -</label>
                                                            <div class="input-group-prepend">

                                                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>" required="">
                                                            </div>
                                                            <label for="exampleInputPassword1"> price -</label>
                                                            <div class="input-group-prepend">

                                                                <input type="text" class="form-control" id="price" name="price" value="<?php echo $row['price']; ?>" required="">
                                                            </div>
                                                            <label for="exampleInputPassword1"> quantity -</label>
                                                            <div class="input-group-prepend">

                                                                <input type="text" class="form-control" id="quantity" name="quantity" value="<?php echo $row['quantity']; ?>" required="">
                                                            </div>
                                                            <label for="exampleInputPassword1"> image -</label>
                                                            <div class="input-group-prepend">

                                                                <input type="file" name="image" class="form-control" id="file">
                                                            </div>


                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                                        <button class="btn btn-success text-uppercase" type="submit" name="edit" value="<?php echo $row['id']; ?>">edit</button>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    <form action="" method="POST">
                                        <button class=" btn btn-outline-danger text-uppercase" type="submit" name="delete" value="<?php echo $row['id']; ?>">delete</button>
                                    </form>
                                </td>
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