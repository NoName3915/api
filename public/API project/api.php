<?php

header("Access-Control-Allow-Origin: *");

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
    require '../src/vendor/autoload.php';
    $app = new \Slim\App;

    //Create/Save endpoint to save details
    $app->post('/docuNew',function (Request $request, Response $response, array $args) 
    {
        //Database
        $servername = "localhost";
        $username = "root";
        $password = "";
        //Collaborators: "change the database name"
        $dbname = "";
       
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error)
        {
            die("Connection Failed: " . $conn->connect_error);
        }
        //Specify Tablename
        $sql = "SELECT * FROM tableName";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0)
        {
            $data = array();
            while($row = $result->fetch_assoc())
            {
                //replace "input" to html input id
                //replace "dbcolumn" according to databes column names
                array_push($data, array(
                    "docTrack"=>$row["DocuTracker"],
                    "docTitle"=>$row["DocTitle"],
                    "docOrigin"=>$row["DocOrigin"],
                    "docDateRecieved"=>$row["DateRecieved"],
                    "docDestination"=>$row["Destination"],
                    "docTag"=>$row["Tags"]
                ));
            }

            $data_body=array("status"=>"success","data"=>$data);
            $response->getBody()->write(json_encode($data_body));
        }
        else
        {
            $response->geyBody()->write(array("stauts"=>"success","data"=>null));
        }
        $conn->close();
        return $response;

    });

    //Search endpoint
    $app->post('/docuSearch', function (Request $request, Response $response, array $args)
    {
        $data=json_decode($request->getBody());
        $id = $data->id;

        //Database
        $servername = "localhost";
        $username = "root";
        $password = "";
        //Collaborators: "change the database name"
        $dbname = "";
       
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error)
        {
            die("Connection Failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM tableName WHERE id = '". $id."'";
        $reslut = $conn->query($sql);
        if ($resilt->num_rows > 0)
        {
            $data = array();
            while($row = $result->fetch_assoc())
            {
                array_push($data, array(
                    "input"=>$row["dbcolumn"],
                    "input"=>$row["dbcolumn"],
                    "input"=>$row["dbcolumn"],
                ));
            }
            $data_body=array("status"=>"success","data"=>$data);
            $response->getBody()->write(json_encode($data_body));
        }
        else
        {
            $response->geyBody()->write(array("stauts"=>"success","data"=>null));
        }
        $conn->close();
        return $response;

    });

    //Update endpoint
    $app->post('/docuUpdate',function (Request $request, Response $response, array $args) 
    {
        $data=json_decode($request->getBody());
        $docTrack = $data->DocuTracker;
        //replace input accourding to id and column name
       
        $docTitle = $data->DocTitle;
        $docOrigin = $data->DocOrigin;
        $docDateRecieved = $data->DateRecieved;
        $docDestination = $data->Destination;
        $docTag = $data->Tags;

        //Database
        $servername = "localhost";
        $username = "root";
        $password = "";
        //Collaborators: "change the database name"
        $dbname = "";
        try
        {
            $conn = new mysqli($servername, $username, $password, $dbname);
            PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            
            $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            
            $sql = "UPDATE tableName set 
            DocTitle='". $docTitle . "', 
            DocOrigin='". $docOrigin . "', 
            DatRecieved='". $docDateRecieved . "', 
            Destination='". $docDestination . "', 
            Tags='". $docTag . "' 
            where DocuTracker='". $docTrack . "'";

            $conn->exec($sql);
            $response->getBody()->write(json_encode(array("status"=>"success","data"=>null)));
        }
        catch(PDOException $e)
        {
            $response->getBody()->write(json_encode(array("status"=>"error", "message"=>$e->getMessage())));
        }
        $conn = null;

        return $response;
    });

    //Delete Endpoint
    $app->post('/docuDelete',function (Request $request, Response $response, array $args) 
    {
        $data=json_decode($request->getBody());
        $id = $data->$id;
        
        //Database
        $servername = "localhost";
        $username = "root";
        $password = "";
        //Collaborators: "change the database name"
        $dbname = "";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error)
        {
            die("Connection Failed: " . $conn->connect_error);
        }
        $sql = "DELETE FROM tableName where DocTracker='". $docTrack ."'";
        if ($conn->query($sql) === TRUE)
        {
            $response->getBody()->write(json_encode(array("status"=>"success","data"=>null)));
        }
        $conn->close();
        return $response;
    });

    $app->post('/docUpload',function (Request $request, Response $response, array $args) 
    {
    
        $currentDirectory = getcwd();
        $uploadDirectory = "/uploads/";

        $errors = []; // Store errors here

        $fileExtensionsAllowed = ['jpeg','jpg','png']; // These will be the only file extensions allowed 

        $fileName = $_FILES['the_file']['name'];
        $fileSize = $_FILES['the_file']['size'];
        $fileTmpName  = $_FILES['the_file']['tmp_name'];
        $fileType = $_FILES['the_file']['type'];
        $fileExtension = strtolower(end(explode('.',$fileName)));

        $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName); 

        if (isset($_POST['submit'])) {

        if (! in_array($fileExtension,$fileExtensionsAllowed)) {
            $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
        }

        if ($fileSize > 4000000) {
            $errors[] = "File exceeds maximum size (4MB)";
        }

        if (empty($errors)) {
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

            if ($didUpload) {
            echo "The file " . basename($fileName) . " has been uploaded";
            } else {
            echo "An error occurred. Please contact the administrator.";
            }
        } else {
            foreach ($errors as $error) {
            echo $error . "These are the errors" . "\n";
            }
        }

    }
    });
    //spare endpoints
    /*
    
    
    $app->post('/docuNew',function (Request $request, Response $response, array $args) 
    {});
    $app->post('/docuNew',function (Request $request, Response $response, array $args) 
    {});
    $app->post('/docuNew',function (Request $request, Response $response, array $args) 
    {});
    */

$app->run();
?>
