<html>
<body>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";

    // create connection
    $conn = new mysqli($servername, $username, $password);

    // check whether it works
    if ($conn->connect_error) {
        die("connection failed: " . $conn->connect_error);
    }
    mysqli_select_db($conn, 'threeDData');


    if (isset($_GET['id']) && isset($_GET['floor']) && isset($_GET['x']) && isset($_GET['y'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $floor = mysqli_real_escape_string($conn, $_GET['floor']);
        $x = mysqli_real_escape_string($conn, $_GET['x']);
        $y = mysqli_real_escape_string($conn, $_GET['y']);
    } else {
        die("incorrect url");
    }

    $sql_find_raw = 'SELECT * FROM RawData WHERE id = '.$id;

    // echo($sql_find_raw);

    $selectResult = $conn->query($sql_find_raw);
    $row = mysqli_fetch_assoc($selectResult);
    if (!isset($row)) {
        echo "No data found.<br>";
    } else {

        $sql_update_raw = 'UPDATE RawData SET whetherPostprocessed = 1 WHERE id = '.$id;
        $current_time = date("Y-m-d H:i:s");
        $sql_update_pro = 'UPDATE DataSet SET lastModifyDate = \''.$current_time.'\' WHERE floor = \''.$floor.'\'';

        // echo $sql_update_pro.'<br>';

        $conn->begin_transaction();
        if (mysqli_query($conn, $sql_update_raw) && mysqli_query($conn, $sql_update_pro)) {
            $conn->commit();

            echo "Process succeeded!<br>";
        } else {
            $conn->rollback();

            echo "Process failed!<br>";
        }

        mysqli_close($conn);

    }
    
?>

<input type="button" value="Return" onclick="javascrtpt:window.location.href='http://localhost:80/3DData/DataUpload.php?floor=<?php echo "{$floor}"; ?>&x=<?php echo "{$x}"; ?>&y=<?php echo "{$y}"; ?>'">
    
</body>
</html>