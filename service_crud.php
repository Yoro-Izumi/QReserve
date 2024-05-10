<?php
session_start();
include "connect_database.php";
include "src/get_data_from_database/get_services.php";
include "src/get_data_from_database/get_table_hours_price.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['serviceName'])){
        $serviceName = mysqli_real_escape_string($conn, $_POST['serviceName']);
        $serviceCapacity = mysqli_real_escape_string($conn, $_POST['capacity']);
        $serviceRate = mysqli_real_escape_string($conn, $_POST['serviceRate']);

        // For uploading the service image
        $serviceImage = $_FILES["serviceImage"];
        $serviceImageName = $_FILES["serviceImage"]["name"];
        $serviceImageSize = $_FILES["serviceImage"]["size"];
        $serviceImageTmpName = $_FILES["serviceImage"]["tmp_name"];
        $serviceImageError = $_FILES["serviceImage"]["error"];
        $serviceImageType = $_FILES["serviceImage"]["type"];

        //To change the name of image to have a unique name then move it to a different location
        $serviceImageExt = explode(".",$serviceImageName); //separate the actual name of file to its extension
        $serviceImageActualExt = strtolower(end($serviceImageExt)); // image extension lower cased
        $serviceImageNewName = $serviceName .".". $serviceImageActualExt; 
        $serviceImage = $serviceImageNewName;
        //Upload the image to the server
        $serviceImageLocation = "src/images/Services/". $serviceImage;
        move_uploaded_file($serviceImageTmpName, $serviceImageLocation); 

        //add price
        $hour = 1;
        $qryAddNewPrice = "INSERT INTO `hour_price`(`hoursID`, `numberOfHours`, `normalPrice`, `succeedingHourPrice`) VALUES (NULL,?,?,?)";
        $connAddNewPrice = mysqli_prepare($conn, $qryAddNewPrice);
        mysqli_stmt_bind_param($connAddNewPrice,'iii',$hour,$serviceRate,$serviceRate);
        mysqli_stmt_execute($connAddNewPrice);

        $priceID = mysqli_insert_id($conn);

        //add new service
        $qryAddNewService = "INSERT INTO `services`(`serviceID`, `serviceName`, `serviceCapacity`, `serviceRate`, `serviceImage`, `superAdminID`) VALUES (NULL,?,?,?,?,?)";
        $connAddNewService = mysqli_prepare($conn, $qryAddNewService);
        mysqli_stmt_bind_param($connAddNewService,'siisi',$serviceName,$serviceCapacity,$priceID,$serviceImage,$_SESSION["userSuperAdminID"]);
        mysqli_stmt_execute($connAddNewService);

        unset($_POST['serviceName']);
        unset($_POST['capacity']);
        unset($_POST['serviceRate']);
    }
}
    if(isset($_POST['editID'])){
    //editID editServiceName editServiceRate editCapacity editImage
    
    $newServiceID = mysqli_real_escape_string($conn, $_POST['editID']);
    $newServiceName = mysqli_real_escape_string($conn, $_POST['editServiceName']);
    $newServiceCapacity = mysqli_real_escape_string($conn, $_POST['editCapacity']);
    $newServiceRate = mysqli_real_escape_string($conn, $_POST['editServiceRate']);

    foreach($arrayServices as $services){
        //(int)$eTime[0]
        if($services['serviceID'] == $newServiceID){
            
            $hoursID = $services['serviceRate'];
            $hours = 1;
            $qryUpdatePriceHour = "UPDATE `hour_price` SET `numberOfHours`=?,`normalPrice`=?,`succeedingHourPrice`=? WHERE `hoursID`=?";
            $connUpdatePriceHour = mysqli_prepare($conn, $qryUpdatePriceHour);
            mysqli_stmt_bind_param($connUpdatePriceHour,'iiii',$hours,$newServiceRate,$newServiceRate,$hoursID);
            mysqli_stmt_execute($connUpdatePriceHour);

            //$ID = mysqli_insert_id($conn);

            $serviceImage = $services['serviceImage'];

            $directory = 'src/images/Services/';

            // Check if the file exists before attempting to delete it
            if (file_exists($directory . $serviceImage)) {
                unlink($directory . $serviceImage);
            if (unlink($directory . $serviceImage)) {
                echo "Image '$serviceImage' has been deleted successfully.";
            } else {
                echo "Failed to delete the image.";
            }
            } else {
                echo "Image '$serviceImage' does not exist.";
            }
        }
            
    } 
       // For uploading the service image
       $newServiceImage = $_FILES["editImage"];
       $newServiceImageName = $_FILES["editImage"]["name"];
       $newServiceImageSize = $_FILES["editImage"]["size"];
       $newServiceImageTmpName = $_FILES["editImage"]["tmp_name"];
       $newServiceImageError = $_FILES["editImage"]["error"];
       $newServiceImageType = $_FILES["editImage"]["type"];

       //To change the name of image to have a unique name then move it to a different location
       $newServiceImageExt = explode(".",$newServiceImageName); //separate the actual name of file to its extension
       $newServiceImageActualExt = strtolower(end($newServiceImageExt)); // image extension lower cased
       $newServiceImageNewName = $newServiceName .".". $newServiceImageActualExt; 
       $newImage = $newServiceImageNewName;
       //Upload the image to the server
       $newServiceImageLocation = "src/images/Services/". $newImage;
       move_uploaded_file($newServiceImageTmpName, $newServiceImageLocation); 
        // $qryUpdateService = "UPDATE `services` SET `serviceID`=[value-1],`serviceName`=[value-2],`serviceCapacity`=[value-3],`serviceRate`=[value-4],`serviceImage`=[value-5],`superAdminID`=[value-6] WHERE serviceID = ?";
        $qryUpdateService = "UPDATE `services` SET `serviceName`= ?,`serviceCapacity`=?,`serviceImage`=?,`superAdminID`=? WHERE serviceID = ?";
        $connUpdateService = mysqli_prepare($conn, $qryUpdateService);
        mysqli_stmt_bind_param($connUpdateService,'sissi',$newServiceName,$newServiceCapacity,$newImage,$_SESSION["userSuperAdminID"],$newServiceID);
        mysqli_stmt_execute($connUpdateService);
            
    }

if(isset($_POST['selectedRows'])){ 
    $selectedRows = $_POST['selectedRows'];
        foreach($selectedRows as $rowId){
            //delete image first
            $qryGetServiceImage = "SELECT serviceImage FROM services WHERE serviceID = ?";
            $connGetServiceImage = mysqli_prepare($conn, $qryGetServiceImage);
            mysqli_stmt_bind_param($connGetServiceImage,'i',$rowId);
            mysqli_stmt_execute($connGetServiceImage);
            $resultGetServiceImage = mysqli_stmt_get_result($connGetServiceImage);
            $rowGetServiceImage = mysqli_fetch_assoc($resultGetServiceImage);
            $serviceImage = $rowGetServiceImage['serviceImage']."";
            
            // Define the directory path where the image files are stored
            $directory = 'src/images/Services/';

            // Check if the file exists before attempting to delete it
            if (file_exists($directory . $serviceImage)) {
                unlink($directory . $serviceImage);
            if (unlink($directory . $serviceImage)) {
                echo "Image '$serviceImage' has been deleted successfully.";
            } else {
                echo "Failed to delete the image.";
            }
            } else {
                echo "Image '$serviceImage' does not exist.";
            }
            //delete service
            $qryDeleteService = "DELETE FROM `services` WHERE serviceID = ?";
            $connDeleteService = mysqli_prepare($conn, $qryDeleteService);
            mysqli_stmt_bind_param($connDeleteService,'i',$rowId);
            mysqli_stmt_execute($connDeleteService);
        }
      // Assuming you want to return a success message
        echo "Rows deleted successfully";
        unset($_POST['selectedRows']);
}

