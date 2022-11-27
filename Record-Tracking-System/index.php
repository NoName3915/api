<?php
    require_once 'DBRecord.php';

    if(isset($_REQUEST['del'])){
        $uid = intval($_GET['del']);
        $sql = "DELETE FROM record_fields WHERE id=:id";
        $query=$dbh->prepare($sql);

        $query->bindParam(':id', $uid, PDO::PARAM_STR);
        $query->execute();

        echo "<script>alert('Record Successfully Deleted!');</script>";
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

    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-16">
                <h3> DOCUMENT RECORDS</h3> <hr/>
                <a href="insert.php" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Add New Record</a>
                <br>
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="example">
                        <thead>
                            <th>#</th>
                            <th>Photos</th>
                            <th> Document Tracking Number</th>
                            <th>Document Title</th>
                            <th>Document Type</th>
                            <th>Origin of Document</th>
                            <th>Date Received</th>
                            <th>Destination of Document</th>
                            <th>Tags</th>
                            <th>Tools</th>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT * FROM record_fields";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);

                                $cnt=1;
                                if($query->rowCount() > 0){
                                    foreach($results as $result)
                                {
                            ?>
                                <tr>
                                    <td><?php echo htmlentities($cnt);?></td>
                                    <td><img src="<?php echo htmlentities(!empty($result->Photo))? ' ' .htmlentities($result->Photo): 'upload/Default.jpg';?>" class="img-square" width="50" height="50"></td>
                                    <td><?php echo htmlentities($result->Tracking_number);?></td>
                                    <td><?php echo htmlentities($result->Title);?></td>
                                    <td><?php echo htmlentities($result->Types);?></td>
                                    <td><?php echo htmlentities($result->Origin);?></td>
                                    <td><?php echo htmlentities($result->Dates);?></td>
                                    <td><?php echo htmlentities($result->Destination);?></td>
                                    <td><?php echo htmlentities($result->Tags);?></td>
                                    <td>
                                        <a href="upload-photo.php?id=<?php echo htmlentities($result->id);?>" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-picture"></span></a>
                                        <a href="update.php?id=<?php echo htmlentities($result->id);?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <a href="index.php?del=<?php echo htmlentities($result->id);?>" class="btn btn-danger btn-sm" onClick="return confirm('Do you really want to delete?')"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>
                                </tr>
                            <?php
                                $cnt++;
                                }}
                            ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#example').DataTable();
        });
    </script>
</html>