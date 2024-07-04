<?php
session_start();
include "connect_database.php";
include "src/get_data_from_database/get_services.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['serviceName'])) {
        $serviceName = mysqli_real_escape_string($conn, $_POST['serviceName']);
        $serviceCapacity = (int) mysqli_real_escape_string($conn, $_POST['capacity']);
        //$serviceRateWithPeso = mysqli_real_escape_string($conn, $_POST['serviceRate']); //₱
        $serviceRate = (int)mysqli_real_escape_string($conn, $_POST['serviceRate']); //$serviceRateWithPeso;

        // For uploading the service image
        $serviceImage = $_FILES["serviceImage"]; 
        $serviceImageName = $serviceImage["name"];
        $serviceImageTmpName = $serviceImage["tmp_name"];
        $serviceImageError = $serviceImage["error"];

        // Ensure there's no error in file upload
        if ($serviceImageError === UPLOAD_ERR_OK) {
            $serviceImageExt = explode(".", $serviceImageName);
            $serviceImageActualExt = strtolower(end($serviceImageExt));
            $serviceImageNewName = $serviceName . "." . $serviceImageActualExt;
            $serviceImageLocation = "src/images/Services/" . $serviceImageNewName;

            // Upload the image
            if (move_uploaded_file($serviceImageTmpName, $serviceImageLocation)) {
                $qryAddNewService = "INSERT INTO `services` (`serviceName`, `serviceCapacity`, `serviceRate`, `serviceImage`, `superAdminID`) VALUES (?, ?, ?, ?, ?)";
                $connAddNewService = mysqli_prepare($conn, $qryAddNewService);
                mysqli_stmt_bind_param($connAddNewService, 'siisi', $serviceName, $serviceCapacity, $serviceRate, $serviceImageNewName, $_SESSION["userSuperAdminID"]);
                
                if (mysqli_stmt_execute($connAddNewService)) {
                    echo "Service added successfully.";
                } else {
                    echo "Error adding service: " . mysqli_error($conn);
                }
            } else {
                echo "Error uploading the image.";
            }
        } else {
            echo "Error in file upload: " . $serviceImageError;
        }

        unset($_POST['serviceName'], $_POST['capacity'], $_POST['serviceRate']);
    }

    if (isset($_POST['editID'])) {
        $newServiceID = (int) mysqli_real_escape_string($conn, $_POST['editID']);
        $newServiceName = mysqli_real_escape_string($conn, $_POST['editServiceName']);
        $newServiceCapacity = (int) mysqli_real_escape_string($conn, $_POST['editCapacity']);
        $newServiceRate = (int) mysqli_real_escape_string($conn, $_POST['editServiceRate']);
        $isImageChosen = mysqli_real_escape_string($conn, $_POST['isImage']);
        $newServiceImage = $_FILES["editImage"];
    
        if ($isImageChosen === 'true') {
            $newServiceImageName = $newServiceImage["name"];
            $newServiceImageTmpName = $newServiceImage["tmp_name"];
            $newServiceImageError = $newServiceImage["error"];
    
            if ($newServiceImageError === UPLOAD_ERR_OK) {
                $newServiceImageExt = explode(".", $newServiceImageName);
                $newServiceImageActualExt = strtolower(end($newServiceImageExt));
                $newServiceImageNewName = $newServiceName . "." . $newServiceImageActualExt;
                $newServiceImageLocation = "src/images/Services/" . $newServiceImageNewName;
    
                // Upload the new image
                if (move_uploaded_file($newServiceImageTmpName, $newServiceImageLocation)) {
                    // Delete the old image if exists
                    $qryGetOldImage = "SELECT serviceImage FROM services WHERE serviceID = ?";
                    $connGetOldImage = mysqli_prepare($conn, $qryGetOldImage);
                    mysqli_stmt_bind_param($connGetOldImage, 'i', $newServiceID);
                    mysqli_stmt_execute($connGetOldImage);
                    $resultGetOldImage = mysqli_stmt_get_result($connGetOldImage);
                    $oldImage = mysqli_fetch_assoc($resultGetOldImage)['serviceImage'];
                    $oldImagePath = "src/images/Services/" . $oldImage;
    
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
    
                    // Update service with new image
                    $qryUpdateService = "UPDATE `services` SET `serviceName` = ?, `serviceCapacity` = ?, `serviceRate` = ?, `serviceImage` = ?, `superAdminID` = ? WHERE `serviceID` = ?";
                    $connUpdateService = mysqli_prepare($conn, $qryUpdateService);
                    mysqli_stmt_bind_param($connUpdateService, 'siisii', $newServiceName, $newServiceCapacity, $newServiceRate, $newServiceImageNewName, $_SESSION["userSuperAdminID"], $newServiceID);
                } else {
                    echo "Error uploading the new image.";
                    exit;
                }
            } else {
                echo "Error with image upload: " . $newServiceImageError;
                exit;
            }
        } 
        else {
            // Update service without changing the image
            $qryUpdateService = "UPDATE `services` SET `serviceName` = ?, `serviceCapacity` = ?, `serviceRate` = ?, `superAdminID` = ? WHERE `serviceID` = ?";
            $connUpdateService = mysqli_prepare($conn, $qryUpdateService);
            mysqli_stmt_bind_param($connUpdateService, 'siiii', $newServiceName, $newServiceCapacity, $newServiceRate, $_SESSION["userSuperAdminID"], $newServiceID);
        }
    
        // Execute the update query
        if (mysqli_stmt_execute($connUpdateService)) {
            echo "Service updated successfully.";
        } else {
            echo "Error updating service: " . mysqli_error($conn);
        }
    }
    
    if (isset($_POST['selectedRows'])) {
        $selectedRows = $_POST['selectedRows'];
        foreach ($selectedRows as $rowId) {
            $rowId = (int) $rowId;

            // Get and delete the service image
            $qryGetServiceImage = "SELECT serviceImage FROM services WHERE serviceID = ?";
            $connGetServiceImage = mysqli_prepare($conn, $qryGetServiceImage);
            mysqli_stmt_bind_param($connGetServiceImage, 'i', $rowId);
            mysqli_stmt_execute($connGetServiceImage);
            $resultGetServiceImage = mysqli_stmt_get_result($connGetServiceImage);
            $serviceImage = mysqli_fetch_assoc($resultGetServiceImage)['serviceImage'];
            $serviceImagePath = "src/images/Services/" . $serviceImage;

            if (file_exists($serviceImagePath)) {
                if (!unlink($serviceImagePath)) {
                    echo "Failed to delete image: $serviceImage";
                }
            } else {
                echo "Image $serviceImage does not exist.";
            }

            // Delete the service
            $qryDeleteService = "DELETE FROM `services` WHERE serviceID = ?";
            $connDeleteService = mysqli_prepare($conn, $qryDeleteService);
            mysqli_stmt_bind_param($connDeleteService, 'i', $rowId);
            if (mysqli_stmt_execute($connDeleteService)) {
                echo "Service with ID $rowId deleted successfully.";
            } else {
                echo "Error deleting service: " . mysqli_error($conn);
            }
        }

        unset($_POST['selectedRows']);
    }
}
?>
