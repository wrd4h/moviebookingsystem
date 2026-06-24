<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

$movies = mysqli_query($conn, "SELECT * FROM movies ORDER BY movie_id DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineMax Cinema</title>

    <link rel="stylesheet" href="style.css">

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

        <a href="#home">Home</a>

        <a href="#movies">Movies</a>

        <a href="#experience">Experience</a>

        <a href="#contact">Contact</a>

    </nav>

</header>



<!-- HERO SECTION -->

<section id="home" class="hero">

    <div class="hero-content">

        <h1>
            WELCOME,
            Experience Movies Like Never Before
        </h1>

        <p>
            Premium movie experience with luxury seating,
            immersive sound and seamless online booking.
        </p>

        <a href="#movies" class="hero-btn">
            Explore Movies
        </a>

    </div>

</section>



<!-- MOVIES -->

<section id="movies" class="movies-section">

    <h2 class="section-title">
        Now Showing
    </h2>


    <div class="movie-container">


        <?php

        if(mysqli_num_rows($movies) > 0){


            while($movie = mysqli_fetch_assoc($movies)){


        ?>


        <div class="movie-card">


            <div class="poster-wrapper">

                <img 
                src="images/<?php echo isset($movie['image']) ? $movie['image'] : 'default.jpg'; ?>" 
                alt="Movie Poster">

            </div>



            <div class="movie-info">


                <h3>
                    <?php echo $movie['title']; ?>
                </h3>


                <p>
                    <?php echo $movie['description']; ?>
                </p>


                <a href="booking.php?movie_id=<?php echo $movie['movie_id']; ?>" class="book-btn">

                    Book Now

                </a>


            </div>


        </div>



        <?php

            }


        } else {


            echo '

            <div class="empty-movies">

                <h3>No Movies Found</h3>

                <p>Please insert movies into database.</p>

            </div>

            ';


        }


        ?>


    </div>


</section>





<!-- EXPERIENCE SECTION -->


<section id="experience" class="experience-section">


    <h2 class="section-title">

        Why Choose CineMax

    </h2>



    <div class="feature-grid">



        <div class="feature-card">


            <i class="fa-solid fa-couch"></i>


            <h3>
                Luxury Seating
            </h3>


            <p>
                Enjoy premium comfort with spacious seating.
            </p>


        </div>





        <div class="feature-card">


            <i class="fa-solid fa-volume-high"></i>


            <h3>
                Dolby Sound
            </h3>


            <p>
                Crystal clear cinematic audio experience.
            </p>


        </div>





        <div class="feature-card">


            <i class="fa-solid fa-ticket"></i>


            <h3>
                Easy Booking
            </h3>


            <p>
                Book tickets in seconds.
            </p>


        </div>





        <div class="feature-card">


            <i class="fa-solid fa-film"></i>


            <h3>
                Latest Movies
            </h3>


            <p>
                Watch the latest blockbuster releases.
            </p>


        </div>



    </div>


</section>





<!-- FOOTER -->


<footer id="contact">


    <h3>
        🎬 CineMax Cinema
    </h3>


    <p>
        Premium Movie Booking System
    </p>


    <p>
        © 2026 CineMax Cinema. All Rights Reserved.
    </p>


</footer>



<script src="assets/script.js"></script>


</body>
</html>
