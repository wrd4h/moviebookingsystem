<?php
include 'db_connect.php';

if(!isset($_GET['movie_id'])){
    header("Location: index.php");
    exit();
}

$movie_id = $_GET['movie_id'];

$movieQuery = mysqli_query(
    $conn,
    "SELECT * FROM movies
     WHERE movie_id='$movie_id'"
);

$movie = mysqli_fetch_assoc($movieQuery);

$showtimesQuery = mysqli_query(
    $conn,
    "SELECT *
     FROM showtimes
     WHERE movie_id='$movie_id'
     ORDER BY show_time ASC"
);

$seatsQuery = mysqli_query(
    $conn,
    "SELECT *
     FROM seats
     ORDER BY seat_row ASC,
     seat_number ASC"
);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Book Ticket
</title>

<link rel="stylesheet"
href="style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<!-- NAVBAR -->

<header class="navbar">

    <div class="logo">

        🎬 CineMax

    </div>

    <nav>

        <a href="index.php">

            Home

        </a>

    </nav>

</header>

<!-- BOOKING SECTION -->

<section class="booking-page">

<div class="booking-container">

<!-- LEFT -->

<div class="movie-booking-card">

    <img
    src="<?php echo $movie['poster_url']; ?>"
    alt="<?php echo $movie['title']; ?>">

</div>

<!-- RIGHT -->

<div class="movie-booking-details">

    <h1>

        <?php
        echo $movie['title'];
        ?>

    </h1>

    <p>

        <strong>Genre:</strong>

        <?php
        echo $movie['genre'];
        ?>

    </p>

    <p>

        <strong>Duration:</strong>

        <?php
        echo $movie['duration'];
        ?>
        mins

    </p>

    <p>

        <strong>Language:</strong>

        <?php
        echo $movie['language'];
        ?>

    </p>

    <p>

        <strong>Description:</strong>

        <?php
        echo $movie['description'];
        ?>

    </p>

</div>

</div>

</section>

<!-- SHOWTIME SECTION -->

<section class="showtime-section">

<h2 class="showtime-title">
    Select Showtime
</h2>

<form
action="payment.php"
method="POST"
id="bookingForm">

<input
type="hidden"
name="movie_id"
value="<?php echo $movie_id; ?>">

<div class="showtime-container">

<?php

while($showtime =
mysqli_fetch_assoc(
$showtimesQuery
)){

?>

<label
class="showtime-card">

<input
type="radio"
name="showtime_id"
value="<?php
echo $showtime['showtime_id'];
?>"

data-price="<?php
echo $showtime['price'];
?>"

required>

<div>

<h3>

<?php
echo date(
"d M Y",
strtotime(
$showtime['show_date']
)
);
?>

</h3>

<p>

<?php
echo date(
"h:i A",
strtotime(
$showtime['show_time']
)
);
?>

</p>

<p>

RM
<?php
echo $showtime['price'];
?>

</p>

</div>

</label>

<?php

}

?>

</div>

<!-- SEAT SELECTION -->

<h2 class="seat-title">

    Select Your Seat

</h2>

<div class="screen">

    SCREEN

</div>

<div class="seat-container">

<?php

while($seat =
mysqli_fetch_assoc(
$seatsQuery
)){

$seatCode =
$seat['seat_row']
.
$seat['seat_number'];

?>

<label
class="seat-box">

<input
type="radio"
name="seat_id"
value="
<?php
echo $seat['seat_id'];
?>"

required>

<span>

<?php
echo $seatCode;
?>

</span>

</label>

<?php

}

?>

</div>

<!-- CUSTOMER DETAILS -->

<div class="customer-form">

<h2>

Customer Information

</h2>

<input
type="text"
name="name"
placeholder="Full Name"
required>

<input
type="email"
name="email"
placeholder="Email Address"
required>

<input
type="text"
name="phone"
placeholder="Phone Number"
required>

</div>

<!-- QUANTITY -->

<div class="quantity-box">

<label>

Quantity

</label>

<input
type="number"
name="quantity"
id="quantity"
value="1"
min="1"
max="10">

</div>

<!-- TOTAL -->

<div class="price-summary">

<h2>

Booking Summary

</h2>

<p>

Selected Movie:
<strong>

<?php
echo $movie['title'];
?>

</strong>

</p>

<p>

Total Price:

<strong
id="totalPrice">

RM 0

</strong>

</p>

</div>

<!-- BUTTON -->

<div class="continue-btn">

<button
type="submit"
class="book-btn">

Continue To Payment

</button>

</div>

</form>

</section>

<script>

const quantityInput =
document.getElementById(
"quantity"
);

const totalPrice =
document.getElementById(
"totalPrice"
);

const showtimeRadios =
document.querySelectorAll(
'input[name="showtime_id"]'
);

function updatePrice(){

let selectedPrice = 0;

showtimeRadios.forEach(

radio => {

if(radio.checked){

selectedPrice =
parseFloat(
radio.dataset.price
);

}

}

);

let qty =
parseInt(
quantityInput.value
);

if(isNaN(qty)){

qty = 1;

}

let total =
selectedPrice * qty;

totalPrice.innerHTML =
"RM "
+
total.toFixed(2);

}

showtimeRadios.forEach(

radio => {

radio.addEventListener(
"change",
updatePrice
);

}

);

quantityInput.addEventListener(
"input",
updatePrice
);

</script>

</body>
</html>