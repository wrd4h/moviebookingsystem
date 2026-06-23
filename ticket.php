<?php

require_once 'db_connect.php';

if(!isset($_GET['booking_id'])){

    header("Location:index.php");
    exit();

}

$booking_id = $_GET['booking_id'];

$query = mysqli_query(

$conn,

"SELECT

bookings.booking_id,
bookings.total_price,
bookings.booking_date,

users.full_name,
users.email,
users.phone,

movies.title,

showtimes.show_date,
showtimes.show_time,

payments.payment_method,

seats.seat_row,
seats.seat_number

FROM bookings

INNER JOIN users
ON bookings.user_id = users.user_id

INNER JOIN showtimes
ON bookings.showtime_id = showtimes.showtime_id

INNER JOIN movies
ON showtimes.movie_id = movies.movie_id

INNER JOIN booking_details
ON bookings.booking_id = booking_details.booking_id

INNER JOIN seats
ON booking_details.seat_id = seats.seat_id

INNER JOIN payments
ON bookings.booking_id = payments.booking_id

WHERE bookings.booking_id='$booking_id'"

);

$data = mysqli_fetch_assoc($query);

$seatCode =
$data['seat_row']
.
$data['seat_number'];

$qrText =
"CineMax Booking ID : "
.
$data['booking_id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>

Movie Ticket

</title>

<link rel="stylesheet"
href="style.css">

</head>

<body>

<section class="ticket-page">

<div class="ticket-card">

<div class="ticket-header">

<h1>

🎬 CineMax Ticket

</h1>

<p>

Booking Confirmed

</p>

</div>

<div class="ticket-body">

<div class="ticket-info">

<p>

<strong>
Booking ID:
</strong>

#<?php
echo $data['booking_id'];
?>

</p>

<p>

<strong>
Customer:
</strong>

<?php
echo $data['full_name'];
?>

</p>

<p>

<strong>
Movie:
</strong>

<?php
echo $data['title'];
?>

</p>

<p>

<strong>
Seat:
</strong>

<?php
echo $seatCode;
?>

</p>

<p>

<strong>
Show Date:
</strong>

<?php
echo date(
"d M Y",
strtotime(
$data['show_date']
)
);
?>

</p>

<p>

<strong>
Show Time:
</strong>

<?php
echo date(
"h:i A",
strtotime(
$data['show_time']
)
);
?>

</p>

<p>

<strong>
Payment:
</strong>

<?php
echo $data['payment_method'];
?>

</p>

<p>

<strong>
Total:
</strong>

RM
<?php
echo number_format(
$data['total_price'],
2
);
?>

</p>

</div>

<div class="ticket-qr">

<img

src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo urlencode($qrText); ?>"

alt="QR Code">

</div>

</div>

<div class="ticket-footer">

<button
onclick="window.print()"
class="book-btn">

Print Ticket

</button>

<a
href="index.php"
class="book-btn">

Book Another Movie

</a>

</div>

</div>

</section>

</body>

</html>