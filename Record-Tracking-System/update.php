<?php
    require_once 'DBRecord.php';

    if(isset($_POST['update'])){

        $userid = intval($_GET['id']);
        $tracking_number=$_POST['tracking_number'];
        $title=$_POST['title'];
        $types=$_POST['types'];
        $origin=$_POST['origin'];
        $dates=$_POST['dates'];
        $destination=$_POST['destination'];
        $tags=$_POST['tags'];

        $sql = "UPDATE record_fields SET Tracking_number=:track, Title=:tit, Types=:typ, Origin=:ori, Dates=:dat, Destination=:des, Tags=:tag WHERE id=:uid";
        
        $query = $dbh->prepare($sql);



        $query->bindParam('track',$tracking_number, PDO::PARAM_STR);
        $query->bindParam('tit',$title, PDO::PARAM_STR);
        $query->bindParam('typ',$types, PDO::PARAM_STR);
        $query->bindParam('ori',$origin, PDO::PARAM_STR);
        $query->bindParam('dat',$dates, PDO::PARAM_STR);
        $query->bindParam('des',$destination, PDO::PARAM_STR);
        $query->bindParam('tag',$tags, PDO::PARAM_STR);
        $query->bindParam('uid',$userid, PDO::PARAM_STR);
        

        $query->execute();
        echo "<script>alert('Record Updated Successfully!');</script>";
        echo "<script>window.location.href='index.php'</script>";
    
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Tracking System</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

</head>
<body>
    <div class="container">
        <div class="row">
        <div class="col-md-12">
            <h3> DOCUMENT RECORDS </h3>
        </div>
    </div>

    <?php
                $userid=intval($_GET['id']);
                $sql ="SELECT * FROM record_fields WHERE id=:uid";
                $query = $dbh->prepare($sql);

                $query->bindParam('uid',$userid,PDO::PARAM_STR);
                $query->execute();
                $result=$query->fetchAll(PDO::FETCH_OBJ);
                
                $cnt=1;
                if($query->rowCount() >0 )
                {
                      foreach($result as $results);  
                 {
            ?>



    <form name="insertrecord" method="POST">
        <div class="row">
            <div class="col-md-6">
                <b> Tracking Number</b>
                <input type="text" name="tracking_number" value="<?php echo htmlentities($results->Tracking_number);?>" class="form-control" required>
            </div>

            <div class="col-md-6">
                <b> Document Title</b>
                <input type="text" name="title" value="<?php echo htmlentities($results->Title);?>" class="form-control" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <b> Document Type</b>
                <select name="types" value="<?php echo htmlentities($results->Types);?>" class="form-control" required >
			        <option value="">--Select Document Type--</option>
                    <option value="JPG">JPG</option>
                    <option value="JPEG">JPEG</option>
                    <option value="PDF">PDF</option>
                    <option value="PNG">PNG</option>
		        </select>
            </div>

            <div class="col-md-6">
                <b> Origin of Document</b>
                <input type="text" name="origin" value="<?php echo htmlentities($results->Origin);?>" class="form-control" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <b> Date Recieved</b>
                <input type="date" name="dates" placeholder="Select Date" value="<?php echo htmlentities($results->Dates);?>" class="form-control" required >
            </div>

            <div class="col-md-6">
                <b> Destination of Document</b>
                <input type="text" name="destination" value="<?php echo htmlentities($results->Destination);?>" class="form-control" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <b> Tags</b>
                <input type="text" name="tags" value="<?php echo htmlentities($results->Tags);?>" class="form-control" required>
            </div>
        </div>


        <div class="row" style="margin-top:1%">
            <div class="col-md-12">
                <input type="submit" name="update" class="btn btn-success" value="SUBMIT">
                <a href="index.php" class="btn btn-danger"> BACK</a>
            </div>
        </div>
            <?php
        }}
            ?>
    </form>
    </div>
</body>
</html>