<?php

include 'db_connect.php';

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    header("Location: index.php");
    exit();
}

$movie_id = $_POST['movie_id'];
$showtime_id = $_POST['showtime_id'];
$seat_id = $_POST['seat_id'];

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$quantity = $_POST['quantity'];

$movieQuery = mysqli_query(
    $conn,
    "SELECT * FROM movies
    WHERE movie_id='$movie_id'"
);

$movie = mysqli_fetch_assoc($movieQuery);

$showtimeQuery = mysqli_query(
    $conn,
    "SELECT * FROM showtimes
    WHERE showtime_id='$showtime_id'"
);

$showtime = mysqli_fetch_assoc($showtimeQuery);

$seatQuery = mysqli_query(
    $conn,
    "SELECT * FROM seats
    WHERE seat_id='$seat_id'"
);

$seat = mysqli_fetch_assoc($seatQuery);

$total =
$showtime['price']
*
$quantity;

$seatCode =
$seat['seat_row']
.
$seat['seat_number'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Payment
</title>

<link rel="stylesheet"
href="style.css">

</head>

<body>

<header class="navbar">

<div class="logo">

🎬 CineMax

</div>

</header>

<section
class="payment-section">

<div
class="payment-card">

<h1>

Payment

</h1>

<div
class="order-summary">

<h2>

Booking Summary

</h2>

<p>

Movie:
<strong>

<?php
echo $movie['title'];
?>

</strong>

</p>

<p>

Seat:
<strong>

<?php
echo $seatCode;
?>

</strong>

</p>

<p>

Quantity:
<strong>

<?php
echo $quantity;
?>

</strong>

</p>

<p>

Showtime:
<strong>

<?php
echo date(
"h:i A",
strtotime(
$showtime['show_time']
)
);
?>

</strong>

</p>

<p>

Total:
<strong>

RM
<?php
echo number_format(
$total,
2
);
?>

</strong>

</p>

</div>

<form
action="process_booking.php"
method="POST">

<input
type="hidden"
name="movie_id"
value="<?php echo $movie_id; ?>">

<input
type="hidden"
name="showtime_id"
value="<?php echo $showtime_id; ?>">

<input
type="hidden"
name="seat_id"
value="<?php echo $seat_id; ?>">

<input
type="hidden"
name="name"
value="<?php echo $name; ?>">

<input
type="hidden"
name="email"
value="<?php echo $email; ?>">

<input
type="hidden"
name="phone"
value="<?php echo $phone; ?>">

<input
type="hidden"
name="quantity"
value="<?php echo $quantity; ?>">

<input
type="hidden"
name="total"
value="<?php echo $total; ?>">

<h2>

Choose Payment Method

</h2>

<div class="payment-methods">

<label class="payment-option">

<input
type="radio"
name="payment_method"
value="Touch n Go"
required>

<span>

Touch n Go

</span>

</label>

<label class="payment-option">

<input
type="radio"
name="payment_method"
value="Online Banking">

<span>

Online Banking

</span>

</label>

<label class="payment-option">

<input
type="radio"
name="payment_method"
value="Credit Card">

<span>

Credit Card

</span>

</label>

<label class="payment-option">

<input
type="radio"
name="payment_method"
value="Debit Card">

<span>

Debit Card

</span>

</label>

</div>

<div
style="
text-align:center;
margin-top:30px;
">

<button
type="submit"
class="book-btn">

Confirm Payment

</button>

</div>

</form>

</div>

</section>

</body>
</html>