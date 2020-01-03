<?php
    $servername = "localhost";
    $username = "root";
    $password = "CSCFm4a1";

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

    if(isset($_GET['floor'])){
        $floor = mysqli_real_escape_string($conn, $_GET['floor']);
        $x = mysqli_real_escape_string($conn, $_GET['x']);
        $y = mysqli_real_escape_string($conn, $_GET['y']);
    }
    //print_r($_FILES);
    $filename=$_FILES['dataPro']['name'];
    $type=$_FILES['dataPro']['type'];
    $tmp_name=$_FILES['dataPro']['tmp_name'];
    $size=$_FILES['dataPro']['size'];
    $error=$_FILES['dataPro']['error'];

    $date=date('Ymdhis');
    $newnametemp=explode('.',$filename);
    $newPath=$date.'.'.$newnametemp[1];
    $oldPath=$_FILES['dataPro']['tmp_name'];
    
    rename($oldPath,"DataSet/".$newPath);

    $time = date("Y-m-d");
    $sql = "INSERT INTO DataSet (floor, x, y, lastModifyDate, src) VALUES ('{$floor}', {$x}, {$y}, '{$time}', 'DataSet/{$newPath}')";

    if (mysqli_query($conn, $sql)) {
        echo "Uploading to Database...<br>";
        echo "Data upload Succeed!<br><br>";
        echo "If you want to upload again at this position, please click on the button below.<br>";
        echo "<b>Do you want to upload again?<b/>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
    
    

    //move_uploaded_file($tmp_name, "DataSet/".$filename);
?>


<input type="button" value="upload again" onclick="javascrtpt:window.location.href='http://localhost:80/3DData/DataUpload.php?floor=<?php echo "{$floor}"; ?>&x=<?php echo "{$x}"; ?>&y=<?php echo "{$y}"; ?>'">



