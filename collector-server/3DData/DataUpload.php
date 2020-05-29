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
?>

<?php
if(isset($_GET['floor'])){
    $floor = mysqli_real_escape_string($conn, $_GET['floor']);
    $x = mysqli_real_escape_string($conn, $_GET['x']);
    $y = mysqli_real_escape_string($conn, $_GET['y']);
    
    //echo "<script>var floor=\"$floor\";</script>";
    //echo "<script>var x=\"$x\";</script>";
    //echo "<script>var y=\"$y\";</script>";
}
else{
    die("incorrect url");
}
?>


<html>
<head>
    
    <STYLE type=text/css>
div.scroll
{
background-color:#FFFFFF;
width:700px;
height:200px;
overflow:auto;
}    
        
BODY {
	FONT-SIZE: 18px; 
}
table {
    border-spacing: 1px
}
OL LI {
	MARGIN: 8px
}
#con {
	FONT-SIZE: 18px; WIDTH: 470px
}
#tags {
	PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; MARGIN: 1px 1px 1px 10px; WIDTH: 400px; PADDING-TOP: 0px; HEIGHT: 30px
}
#tags LI {
    FLOAT: left; MARGIN-RIGHT: 1px; LIST-STYLE-TYPE: none; HEIGHT: 23px
}
#tags LI A {
	PADDING-RIGHT: 10px; PADDING-LEFT: 10px; FLOAT: left; PADDING-BOTTOM: 0px; COLOR: #999; LINE-HEIGHT: 23px; PADDING-TOP: 0px; HEIGHT: 23px; TEXT-DECORATION: none
}
#tags LI.emptyTag {
	BACKGROUND: none transparent scroll repeat 0% 0%; WIDTH: 4px
}
#tags LI.selectTag {
	BACKGROUND-POSITION: left top; MARGIN-BOTTOM: -2px; POSITION: relative; HEIGHT: 25px
}
#tags LI.selectTag A {
	BACKGROUND-POSITION: right top; COLOR: #000; LINE-HEIGHT: 25px; HEIGHT: 25px
}
#tagContent {
	BORDER-RIGHT: #B87070 2px solid; PADDING-RIGHT: 2px; BORDER-TOP: #B87070 2px solid; PADDING-LEFT: 2px; PADDING-BOTTOM: 2px; BORDER-LEFT: #B87070 2px solid; PADDING-TOP: 2px; BORDER-BOTTOM: #B87070 2px solid; BACKGROUND-COLOR: #fff
}
.tagContent {
	PADDING-RIGHT: 10px; DISPLAY: none; PADDING-LEFT: 10px;  PADDING-BOTTOM: 10px; WIDTH: 1900px; PADDING-TOP: 10px; HEIGHT: 250px
}
#tagContent DIV.selectTag {
	DISPLAY: block
}
</STYLE>
</head>
    

<body>
    <section>
    <h2>
    Upload data file at position:
    <meta charset="utf-8">
    </h2>
        
    <?php echo "<b>Map default value:</b><br>";
        echo " x : {$x}<br>";
        echo " y : {$y}<br>";
        echo " floor : {$floor}<br><br>";
        // echo "<h3>Please choose what kind of file you are uploading.</h3>";
    ?>
    
        
        
   
    </section>

    <script>
        function checkUpload(){
            alert("Please double check the position information before uploading files.");
        }
    </script>
    
    <script type=text/javascript>
    function selectTag(showContent,selfObj){
        var tag = document.getElementById("tags").getElementsByTagName("li");
        var taglength = tag.length;
        for(i=0; i<taglength; i++){
            tag[i].className = "";
        }
        selfObj.parentNode.className = "selectTag";
        for(i=0; j=document.getElementById("tagContent"+i); i++){
            j.style.display = "none";
        }
        document.getElementById(showContent).style.display = "block";
    }
    </script>
    
    <script>
        function checkRaw(){
             var urlRaw = "handlerRaw.php?floor=" + submitEndRaw.floorInputRaw.value + "&x=" + submitEndRaw.xInputRaw.value + "&y=" + submitEndRaw.yInputRaw.value;
             document.getElementById('submitRaw').action = urlRaw;
        }
        function checkPro(){
             var urlPro = "handlerPro.php?floor=" + submitEndPro.floorInputPro.value + "&x=" + submitEndPro.xInputPro.value + "&y=" + submitEndPro.yInputPro.value;
             document.getElementById('submitPro').action = urlPro;
        }
        function processRaw(floor, x, y, rawID){
            var urlProcRaw = "processRaw.php?floor=" + floor + "&x=" + x + "&y=" + y + "&id=" + rawID;
            window.location.href = 'http://localhost/3DData/' + urlProcRaw;
        }
    </script>

    <script type="text/javascript" language="javascript">
        function callRecordClient() {
            shell = new ActiveXObject("WScript.Shell");
            shell.run("client.bat", 1, false);
        }
    </script>
    
    <DIV id=con>
    <UL id=tags>
    <LI><A onClick="selectTag('tagContent0',this)" 
    href="javascript:void(0)">RawData</A> </LI>
<!--     <LI><A onClick="selectTag('tagContent1',this)" 
    href="javascript:void(0)">Post-processed Data</A> </LI> -->
    </UL> 
    <DIV id=tagContent>
    <DIV class="tagContent selectTag" id=tagContent0>
        Your raw data file should be of format ".bag".<br>
        <!-- <a href="client_proto:\\">Start collecting in real time here</a><br> -->
        <!-- <a href="javascript:callRecordClient()">Start collecting in real time here</a><br> -->
        <!-- <a href="App_Exec.hta">Start collecting in real time here</a><br> -->
        You can change the position parameters if needed.<br>
        <form id="submitRaw" name="submitEndRaw" action="" onsubmiturl method="post" enctype="multipart/form-data">
        
        x  : <input type="text" name="xInputRaw" oninput="value=value.replace(/[^\d]/g,'')" value="<?php echo "{$x}";?>"><br/>
        y     : <input type="text" name="yInputRaw" oninput="value=value.replace(/[^\d]/g,'')" value="<?php echo "{$y}";?>"><br/>
        floor : <input type="text" name="floorInputRaw" value="<?php echo "{$floor}";?>"><br/><br/>

        <!-- <input type="file" onclick="checkUpload()" name="dataRaw"> -->
        <input type="file" name="dataRaw">

        <input type="submit" value="send" onclick="checkRaw()" >

        </form>
    </DIV>
    <!-- <DIV class=tagContent id=tagContent1>
        Your post-processed data file should be of format:<br>
        ".pcd", ".ply" or other 3D Data format.<br>
        You can change the position parameters if needed.<br>
        <form id="submitPro" name="submitEndPro" action="" onsubmiturl method="post" enctype="multipart/form-data">
        
        x  : <input type="text" name="xInputPro" oninput="value=value.replace(/[^\d]/g,'')" value="<?php echo "{$x}";?>"><br/>
        y     : <input type="text" name="yInputPro" oninput="value=value.replace(/[^\d]/g,'')" value="<?php echo "{$y}";?>"><br/>
        floor : <input type="text" name="floorInputPro" value="<?php echo "{$floor}";?>"><br/><br/>

        <input type="file" onclick="checkUpload()" name="dataPro">

        <input type="submit" value="send" onclick="checkPro()" >

        </form>
    </DIV> -->
    </DIV></DIV>
    
    <br><h3>Process New Rawdata</h3>
    <DIV id="gdt_id" name="gdt_name" class="scroll"><table border="1">
        <tr>
        <th>Rawdata_x</th>
        <th>Rawdata_y</th>
        <th>Rawdata_floor</th>
        <th>Upload Time</th>
        <th>Process Status</th>
        </tr>
        <?php
            $sql="SELECT * FROM Rawdata";
            $selectResult=$conn->query($sql);
            while($row=mysqli_fetch_assoc($selectResult)){
                if($row['whetherPostprocessed'] == 0){
                    echo "<tr>";
                    echo "<td>{$row['x']}</td>";
                    echo "<td>{$row['y']}</td>";
                    echo "<td>{$row['floor']}</td>";
                    echo "<td>{$row['lastModifyDate']}</td>";
                    echo "<td>Not Processed</td>";
                    echo "<td><input type=\"button\" value=\"Process\" onClick=\"processRaw('{$floor}', {$x}, {$y}, {$row['id']})\"></td>";
                } else {
                    echo "<tr>";
                    echo "<td>{$row['x']}</td>";
                    echo "<td>{$row['y']}</td>";
                    echo "<td>{$row['floor']}</td>";
                    echo "<td>{$row['lastModifyDate']}</td>";
                    echo "<td>Processed</td>";
                    // echo "<td><input type=\"button\" value=\"process\"></td>";
                }
            }
        ?>
        
        </table>
    </DIV>
    
    <br><h3>Show Reconstructed Data</h3>
    <DIV id="srd_id" name="srd_name" class="scroll"><table border="1">
        <tr>
        <th>Rawdata_floor</th>
        <th>Last Update Time</th>
        </tr>
        <?php
            $sql_srd="SELECT * FROM Dataset";
            $selectResult_srd=$conn->query($sql_srd);
            while($row=mysqli_fetch_assoc($selectResult_srd)){
                echo "<tr>";
                echo "<td>{$row['floor']}</td>";
                echo "<td>{$row['lastModifyDate']}</td>";
                echo "<td><input type=\"button\" value=\"View Model\" onClick=\"window.open(`http://rwcpu1.cse.ust.hk/3d-map/visualization/plyViewer/plane.html`, '_blank')\"></td>";
            }
            $conn->close();
        ?>
        
        </table>
    </DIV>

    
    
    
    
    
    
    
    
    
</body>

</html>