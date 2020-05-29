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


    if(isset($_GET['floor'])){
        $floor = mysqli_real_escape_string($conn, $_GET['floor']);
        $x = mysqli_real_escape_string($conn, $_GET['x']);
        $y = mysqli_real_escape_string($conn, $_GET['y']);
    }
    else{
        die("incorrect url");
    }

    // print_r($_FILES);
    $filename=$_FILES['dataRaw']['name'];
    $type=$_FILES['dataRaw']['type'];
    $tmp_name=$_FILES['dataRaw']['tmp_name'];
    $size=$_FILES['dataRaw']['size'];
    $error=$_FILES['dataRaw']['error'];
    
    $date=date('Ymdhis');
    $newnametemp=explode('.',$filename);
    if ($newnametemp[1] == "bag"){
    
        $newPath=$date.'.'.$newnametemp[1];
        $oldPath=$_FILES['dataRaw']['tmp_name'];

        @rename($oldPath,"RawData/".$newPath);

        $time = date("Y-m-d H:i:s");
        $sql = "INSERT INTO RawData (floor, x, y, lastModifyDate, whetherPostprocessed, src) VALUES ('{$floor}', {$x}, {$y}, '{$time}', 0, 'RawData/{$newPath}')";


        $floor = mysqli_real_escape_string($conn, $_GET['floor']);
        $x = mysqli_real_escape_string($conn, $_GET['x']);
        $y = mysqli_real_escape_string($conn, $_GET['y']);

        if (mysqli_query($conn, $sql)) {
            echo "Uploading to Database...<br>";
            echo "RawData upload Success!<br><br>";
            // echo "If you want to upload again at this position, please click on the button below.<br>";
            // echo "<b>Do you want to upload again?<b/>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }


        mysqli_close($conn);
    }
    else{
        echo "This is not a bag file!<br>";
        echo "Please click on the button below to upload again.<br>";
        echo "<b>Do you want to upload again?<b/>";
    }
    
?>

<input type="button" value="Return" onclick="javascrtpt:window.location.href='http://localhost:80/3DData/DataUpload.php?floor=<?php echo "{$floor}"; ?>&x=<?php echo "{$x}"; ?>&y=<?php echo "{$y}"; ?>'">
    
</body>
</html>