<?php
$db = mysqli_connect('localhost', 'root', '') or 
    die ('Unable to connect. Check your connection parameters.');
mysqli_select_db($db, 'moviesite') or die(mysqli_error($db));

//alter the movie table to include release and rating
$query = 'ALTER TABLE movie ADD COLUMN (
    movie_release INTEGER UNSIGNED DEFAULT 0,
    movie_rating  TINYINT UNSIGNED DEFAULT 5)';
mysqli_query($db, $query) or die(mysqli_error($db));

echo 'Movie database successfully updated!';
?>
