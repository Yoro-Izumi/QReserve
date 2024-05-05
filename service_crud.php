<?php
session_start();
include "connect_database.php";

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
        $serviceImageLocation = "images/Services/". $serviceImage;
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
    if(isset($_POST['update_service_button'])){
       // $qryUpdateService = "UPDATE `services` SET `serviceID`=[value-1],`serviceName`=[value-2],`serviceCapacity`=[value-3],`serviceRate`=[value-4],`serviceImage`=[value-5],`superAdminID`=[value-6] WHERE serviceID = ?";

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
            $directory = 'images/Services/';

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

