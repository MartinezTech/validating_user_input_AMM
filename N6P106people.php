<?php
$debug = 1;

$db = mysqli_connect('localhost', 'root', 'root') or 
    die ('Unable to connect. Check your connection parameters.');
mysqli_select_db($db, 'moviesite') or die(mysqli_error($db));


switch ($_GET['action']) {
    case 'edit':
        if(isset($_GET['id'])){
            //retrieve the record's information 
            $query_people = 'SELECT people_fullname, people_isactor, people_isdirector
            FROM people
            WHERE people_id = ' . $_GET['id'];
            $result_people = mysqli_query($db, $query_people) or die(mysqli_error($db));
            extract(mysqli_fetch_assoc($result_people));

        }else{
            echo "You must pass id to edit people records<br>";
            break;
        }

        break;
    case 'add':
        //set blank values

        $people_fullname = '';
        $people_isactor = 0;
        $people_isdirector = 0;
        
        break;
}    
?>
<html>
 <head>
  <title><?php echo ucfirst($_GET['action']); ?> People</title>
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
  <form action="N6P107commit.php?action=<?php echo $_GET['action']; ?>&type=people"
   method="post">
   <table>
    <tr>
        <td>Name</td>

        <td><input type="text" name="people_fullname" value="<?php echo $people_fullname; ?>"/></td>
    </tr>
    <tr>
        <td>Actor</td>
        <?php
            if ($people_isactor == 1){
                echo "<td><input type='checkbox' id='people_isactor' name='people_isactor' checked></td>";
            }else{
                echo "<td><input type='checkbox' id='people_isactor' name='people_isactor' ></td>";
            }
        ?>
        </td>
    </tr>
    <tr>
        <td>Director</td>
        <?php
            if ($people_isdirector == 1){
                echo "<td><input type='checkbox' id='people_isdirector' name='people_isdirector' value='Bike' checked></td>";
            }else{
                echo "<td><input type='checkbox' id='people_isdirector' name='people_isdirector' value='Bike'></td>";
            }
        ?>
    </tr>
<?php


?>


<tr><td>
<?php
if ($_GET['action'] == 'edit') {
    echo '<input type="hidden" value="' . $_GET['id'] . '" name="people_id" />';
}

?>
      <input type="submit" name="submit"
       value="<?php echo ucfirst($_GET['action']); ?>" />
     </td>
    </tr>
   </table>
  </form>
  <form action="validate_mail.php" method="post">
    <label for="email">Enter your email:</label>
    <input type="email" id="email" name="email">
  </form>
 </body>
</html>