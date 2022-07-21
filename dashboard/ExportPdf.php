<?php

session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("location: ../index.php");
}
require_once  './FPDF/fpdf.php';
include "../config.php";
error_reporting(0);

if (isset($_POST["export"])) {
    $uniqueId = uniqid('Eshop', false);

    $total = $_POST['total'];
    $name1 = $_POST['name1'];
    $number1 = $_POST['number1'];
    $address = $_POST['address'];
    $filename .= 'e-book';
    $filename .= '.pdf';
    $details = '';

    class PDF extends FPDF
    {
        function Header()
        {
            $filename1 = 'e-book';

            // Select Arial bold 15
            $this->SetFont('Arial', 'B', 15);
            // Move to the right
            $this->Cell(80);
            // Framed title
            $this->Cell(30, 10,  $filename1, 0, 1, 'C');
            // Line break
            $this->Ln(10);
        }
    }
    $pdf = new PDF('p', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);

    $pdf->Cell(60, 10, 'ID', '1', '0', 'C');
    $pdf->Cell(60, 10, 'customer name', '1', '0', 'C');
    $pdf->Cell(40, 10, 'Number', '1', '1', 'C');

    $pdf->Cell(60, 10,  $uniqueId, '1', '0', 'C');
    $pdf->Cell(60, 10, $name1, '1', '0', 'C');
    $pdf->Cell(40, 10,  $number1, '1', '1', 'C');
    $pdf->Ln(10);

    $pdf->Cell(10, 10, '#', '1', '0', 'C');
    $pdf->Cell(40, 10, 'Item Name', '1', '0', 'C');
    $pdf->Cell(40, 10, 'Quantity', '1', '0', 'C');
    $pdf->Cell(40, 10, 'Unit Price', '1', '0', 'C');
    $pdf->Cell(40, 10, 'Total Price', '1', '1', 'C');




    $pdf->SetFont('Arial', '', 10);
    $count = 1;
    foreach ($_SESSION["shopping_cart"] as &$product) {


        $pdf->Cell(10, 10, $count, '1', '0', 'C');
        $pdf->Cell(40, 10, $product["name"], '1', '0', 'C');
        $pdf->Cell(40, 10, $product["quantity"], '1', '0', 'C');
        $pdf->Cell(40, 10, $product["price"], '1', '0', 'C');
        $pdf->Cell(40, 10,  $product["price"] *  $product["quantity"], '1', '1', 'C');

        $details .= $product["name"];
        $details .= '-';
        $details .= '\t';
        $details .= $product["quantity"];
        $details .= '-';
        $details .= '\t';
        $details .=  $product["price"] *  $product["quantity"];
        $details .= ',';
        $details .= '\n';




        $count += 1;
        $total_price += ($product["price"] * $product["quantity"]);
    }
    $details .=   'Total-';
    $details .=   $total_price;
    $sql1 = "INSERT INTO customer VALUES(Null,'$name1','$uniqueId','$number1','$address','$details',Now())";
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

    $pdf->Cell(170, 20, 'TOTAL:' . $total_price, '1', '0', 'C');
    $pdf->Output('D', $filename, false);
    exit();
}