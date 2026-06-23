<?php

include 'db_connect.php';

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    header("Location:index.php");
    exit();
}

// ======================================
// GET FORM DATA
// ======================================

$movie_id = $_POST['movie_id'];

$showtime_id = $_POST['showtime_id'];

$seat_id = $_POST['seat_id'];

$name = mysqli_real_escape_string(
$conn,
$_POST['name']
);

$email = mysqli_real_escape_string(
$conn,
$_POST['email']
);

$phone = mysqli_real_escape_string(
$conn,
$_POST['phone']
);

$quantity = $_POST['quantity'];

$total = $_POST['total'];

$payment_method =
$_POST['payment_method'];


// ======================================
// INSERT USER
// ======================================

$userQuery = mysqli_query(

$conn,

"INSERT INTO users
(
full_name,
email,
password,
phone
)

VALUES

(
'$name',
'$email',
'123456',
'$phone'
)"

);

$user_id =
mysqli_insert_id($conn);


// ======================================
// INSERT BOOKING
// ======================================

$bookingQuery = mysqli_query(

$conn,

"INSERT INTO bookings
(
user_id,
showtime_id,
total_price,
booking_status
)

VALUES

(
'$user_id',
'$showtime_id',
'$total',
'confirmed'
)"

);

$booking_id =
mysqli_insert_id($conn);


// ======================================
// INSERT BOOKING DETAILS
// ======================================

mysqli_query(

$conn,

"INSERT INTO booking_details
(
booking_id,
seat_id
)

VALUES

(
'$booking_id',
'$seat_id'
)"

);


// ======================================
// INSERT PAYMENT
// ======================================

mysqli_query(

$conn,

"INSERT INTO payments
(
booking_id,
payment_method,
payment_status,
amount
)

VALUES

(
'$booking_id',
'$payment_method',
'paid',
'$total'
)"

);


// ======================================
// UPDATE SEAT STATUS
// ======================================

mysqli_query(

$conn,

"UPDATE seats

SET

status='booked'

WHERE seat_id='$seat_id'"

);


// ======================================
// REDIRECT TO TICKET
// ======================================

header(

"Location: ticket.php?booking_id="
.
$booking_id

);

exit();

?>