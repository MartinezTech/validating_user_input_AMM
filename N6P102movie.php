<?php
$db = mysqli_connect('localhost', 'root', '') or 
    die ('Unable to connect. Check your connection parameters.');
mysqli_select_db($db, 'moviesite') or die(mysqli_error($db));

if ($_GET['action'] == 'edit') {
    //retrieve the record's information 
    $query = 'SELECT
            movie_name, movie_type, movie_year, movie_leadactor, movie_director,
            movie_release, movie_rating
        FROM
            movie
        WHERE
            movie_id = ' . $_GET['id'];
    $result = mysqli_query($db, $query) or die(mysqli_error($db));
    extract(mysqli_fetch_assoc($result));
} else {
    //set values to blank
    $movie_name = '';
    $movie_type = 0;
    $movie_year = date('Y');
    $movie_leadactor = 0;
    $movie_director = 0;
}
?>
<html>
 <head>
  <title><?php echo ucfirst($_GET['action']); ?> Movie</title>
  <style type="text/css">
<!--
#error { background-color: #600; border: 1px solid #FF0; color: #FFF;
 text-align: center; margin: 10px; padding: 10px; }
-->
  </style>
 </head>
 <body>
<?php
if (isset($_GET['error']) && $_GET['error'] != '') {
    echo '<div id="error">' . $_GET['error'] . '</div>';
}
?>
  <form action="N6P103commit.php?action=<?php echo $_GET['action']; ?>&type=movie"
   method="post">
   <table>
    <tr>
     <td>Movie Name</td>
     <td><input type="text" name="movie_name"
      value="<?php echo $movie_name; ?>"/></td>
    </tr><tr>
     <td>Movie Type</td>
     <td><select name="movie_type">
<?php
// select the movie type information
$query = 'SELECT
        movietype_id, movietype_label
    FROM
        movietype
    ORDER BY
        movietype_label';
$result = mysqli_query($db, $query) or die(mysqli_error($db));

// populate the select options with the results
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['movietype_id'] == $movie_type) {
        echo '<option value="' . $row['movietype_id'] .
            '" selected="selected">';
    } else {
        echo '<option value="' . $row['movietype_id'] . '">';
    }
    echo $row['movietype_label'] . '</option>';
}
?>
      </select></td>
    </tr><tr>
     <td>Movie Year</td>
     <td><select name="movie_year">
<?php
// populate the select options with years
for ($yr = date("Y"); $yr >= 1970; $yr--) {
    if ($yr == $movie_year) {
        echo '<option value="' . $yr . '" selected="selected">' . $yr .
            '</option>';
    } else {
        echo '<option value="' . $yr . '">' . $yr . '</option>';
    }
}
?>
      </select></td>
    </tr><tr>
     <td>Lead Actor</td>
     <td><select name="movie_leadactor">
<?php
// select actor records
$query = 'SELECT
        people_id, people_fullname
    FROM
        people
    WHERE
        people_isactor = 1
    ORDER BY
        people_fullname';
$result = mysqli_query($db, $query) or die(mysqli_error($db));

// populate the select options with the results
while ($row = mysqli_fetch_assoc($result)) {
    foreach ($row as $value) {
        if ($row['people_id'] == $movie_leadactor) {
            echo '<option value="' . $row['people_id'] .
                '" selected="selected">';
        } else {
            echo '<option value="' . $row['people_id'] . '">';
        }
        echo $row['people_fullname'] . '</option>';
    }
}
?>
      </select></td>
    </tr><tr>
     <td>Director</td>
     <td><select name="movie_director">
<?php
// select director records
$query = 'SELECT
        people_id, people_fullname
    FROM
        people
    WHERE
        people_isdirector = 1
    ORDER BY
        people_fullname';
$result = mysqli_query($db, $query) or die(mysqli_error($db));

// populate the select options with the results
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['people_id'] == $movie_director) {
        echo '<option value="' . $row['people_id'] .
            '" selected="selected">';
    } else {
        echo '<option value="' . $row['people_id'] . '">';
    }
    echo $row['people_fullname'] . '</option>';
}
?>
      </select></td>
    </tr><tr>
     <td colspan="2" style="text-align: center;">
<?php
if ($_GET['action'] == 'edit') {
    echo '<input type="hidden" value="' . $_GET['id'] . '" name="movie_id" />';
}
?>
      <input type="submit" name="submit"
       value="<?php echo ucfirst($_GET['action']); ?>" />
     </td>
    </tr>
   </table>
  </form>
 </body>
</html>
