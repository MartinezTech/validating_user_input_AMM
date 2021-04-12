<?php
$debug = 1;
$db = mysqli_connect('localhost', 'root', 'root') or 
    die ('Unable to connect. Check your connection parameters.');
mysqli_select_db($db, 'moviesite') or die(mysqli_error($db));
// Initialize error variable to record wrong inputs
$error = array();
// Import information from checkboxs into util data

if (isset($_POST['people_isactor'])){
    $people_isactor = 1;
}else{
    $people_isactor = 0;
}
if (isset($_POST['people_isdirector'])){
    $people_isdirector = 1;
}else{
    $people_isdirector = 0;
}
switch ($_GET['type']) {
    case 'people':
        // Delete row if the user press delete on admin interface
        if ($_GET['action'] == 'delete'){
            $query_people = 'DELETE FROM PEOPLE WHERE people_id='. $_GET['id'];

            $delete_data_people = mysqli_query($db, $query_people) or die(mysqli_error($db));
            echo "Process completed! Your record has been deleted.<br>";
            echo "Now, you are being redirected to admin.php ...";
            header( "refresh:3;url=admin.php" );
            break;
        }  

        // Check that user introduces people name
        $people_fullname = isset($_POST['people_fullname']) ?
            trim($_POST['people_fullname']) : '';
        if(empty($people_fullname)) {
            $error[] = urlencode('Please enter a people name.');
            echo "Error, put people name";
        }
        // Check user at least check one box
        if ($people_isactor == 0 && $people_isdirector == 0){
            $error[] = urlencode('Please, at least you must check one box');
        }

        // Add new records, edit records or return to form page if data is not valid
        if ($_GET['action'] == 'add'){
            if (empty($error)){
                echo "We are going to insert correct data upon people table";
                //query to insert data after verify data is ok
                $query_people = 'INSERT INTO people
                        (people_fullname, people_isactor, people_isdirector)
                        VALUES
                            ("' . $people_fullname . '",
                            ' . $people_isactor . ',
                            ' . $people_isdirector . ')';
                $insert_data_people = mysqli_query($db, $query_people) or die(mysqli_error($db));
                echo "Process completed! Your record has been added.<br>";
                echo "Now, you are being redirected to admin.php ...";
                header( "refresh:3;url=admin.php" );
            // When data is not good return red msgs with errors
            }else{
                header('Location:N6P106people.php?action=add&error=' . join($error, urlencode('<br/>')));
            }

        } elseif ($_GET['action'] == 'edit'){
            if (empty($error)){

                //query to insert data after verify data is ok
                $query_people = 'UPDATE people
                        SET
                        people_fullname = "' . $people_fullname .'",
                        people_isactor = ' . $people_isactor .',
                        people_isdirector = ' . $people_isdirector . '
                        WHERE 
                        people_id =' . $_POST['people_id'];

                $edit_data_people = mysqli_query($db, $query_people) or die(mysqli_error($db));
                echo "Process completed! Your record has been edited.<br>";
                echo "Now, you are being redirected to admin.php ...";
                header( "refresh:3;url=admin.php" );
        } else{
            header('Location:N6P106people.php?action=edit&id='. $_POST['people_id'] . '&error=' . join($error, urlencode('<br/>')));
        }

        }
}
?>
<html>
 <head>
  <title>Commit</title>
 </head>
 <body>
  <p>Done!</p>
 </body>
</html>