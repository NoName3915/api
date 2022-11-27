<?php
    require_once 'DBRecord.php';
    if(isset($_POST['upload'])){
        $userid=intval($_GET['id']);

        $file_name=$_FILES['file']['name'];
        $file_temp=$_FILES['file']['tmp_name'];
        $file_size=$_FILES['file']['size'];
        $file_type=$_FILES['file']['type'];

        $location="upload/".$file_name;

        if($file_size < 524880 ){
            if(move_uploaded_file($file_temp,$location)){
                try{
                    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql ="UPDATE record_fields SET Photo='$location' WHERE id='$userid'";
                    $dbh->exec($sql);
                }catch(PDOException $e){
                    echo $e->getMessage();
                }
                $dbh = null;
                header('location:index.php');
            }
        }else{
            echo "<script>alert('File size is to large to upload');</script>";
        }
    }
?>
<html>

<head>

    <title>Document Tracking System</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>
<body>
    <?php
        $userid=intval($_GET['id']);
        $sql = "SELECT * FROM record_fields WHERE id='$userid'";
        $query=$dbh->prepare($sql);
        $query->execute();
        $result = $query->fetch();
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>UPLOAD PHOTO</h3>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Upload Here</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                    <button type="submit" name="upload" class="btn btn-danger"> Upload</button>
                </form>
            </div>
        </div>
    </div>


</body>
</html>