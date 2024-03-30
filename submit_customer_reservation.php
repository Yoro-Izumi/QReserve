<?php
include "connect_database.php";

   // if($conn){
        // Code to execute when the connection is successful
            if(isset($_POST["submitReserve"])){
                $customerFirstName = mysqli_real_escape_string($conn,$_POST["firstName"]);
                $customerLastName = mysqli_real_escape_string($conn,$_POST["lastName"]);
                $customerMiddleName = mysqli_real_escape_string($conn,$_POST["middleName"]);
                $customerBirthdate = mysqli_real_escape_string($conn,$_POST["birthDate"]);
                $customerPhone = mysqli_real_escape_string($conn,$_POST["contactNumber"]);
                $customerEmail = mysqli_real_escape_string($conn,$_POST["email"]);
                $selectDate = mysqli_real_escape_string( $conn,$_POST["selectDate"]);
                $startTime = mysqli_real_escape_string( $conn,$_POST["startTime"]);
                $endTime = mysqli_real_escape_string( $conn,$_POST["endTime"]);
                $timeDifference = mysqli_real_escape_string( $conn,$_POST["timeDifference"]);
                $poolTable = 1;//mysqli_real_escape_string( $conn,$_POST["selectTable"]);
                $customerID = 1;
                $hoursID = $timeDifference;
                $paymentID = 1;
                $reservationStatus = "pending";

                // For uploading the ID
                $idImage = $_FILES["validId"];
                $idImageName = $_FILES["validId"]["name"];
                $idImageSize = $_FILES["validId"]["size"];
                $idImageTmpName = $_FILES["validId"]["tmp_name"];
                $idImageError = $_FILES["validId"]["error"];
                $idImageType = $_FILES["validId"]["type"];

                //To change the name of image to have a unique name then move it to a different location
                $idImageExt = explode(".",$idImageName); //separate the actual name of file to its extension
                $idImageActualExt = strtolower(end($idImageExt)); // image extension lower cased
                $idImageNewName = uniqid('',true) .".". $idImageActualExt; 
                $validId = $idImageNewName;
                //Upload the image to the server
                $idImageLocation = "uploadedImages/". $validId;
                move_uploaded_file($idImageTmpName, $idImageLocation);

                //Query to insert data into the database
                //For customer information
                $customerInfoQuery = "INSERT INTO `customer_info`(`customerID`, `customerFirstName`, `customerLastName`, `customerMiddleName`, `customerBirthdate`, `customerNumber`, `customerEmail`,`validID`) VALUES (NULL,?,?,?,?,?,?,?)";   
                $customerInfoPrepare = mysqli_prepare($conn,$customerInfoQuery);
                mysqli_stmt_bind_param($customerInfoPrepare,"sssssss",$customerFirstName,$customerLastName,$customerMiddleName,$customerBirthdate,$customerPhone,$customerEmail,$validId);
                mysqli_stmt_execute($customerInfoPrepare);

                $customerID = mysqli_insert_id($conn); //Get the key of customer_information in order to set the key as foreign key to another table

                //For reservation information
                $reservationQuery = "INSERT INTO `pool_table_reservation`(`reservationID`, `tableID`, `customerID`, `hoursID`, `paymentID`, `reservationDate`, `reservationTimeStart`, `reservationTimeEnd`, `reservationStatus`) VALUES (NULL,?,?,?,?,?,?,?,?)";
                $reservationPrepare = mysqli_prepare($conn,$reservationQuery);
                mysqli_stmt_bind_param($reservationPrepare,"iiiissss",$poolTable,$customerID,$hoursID,$paymentID,$selectDate,$startTime,$endTime,$reservationStatus);
                mysqli_stmt_execute($reservationPrepare);
                
                header("location:booking_form.html");
            }
   /* } else {
        // Code to execute when the connection is not successful
        if (!$conn) {
            echo "Failed to connect to the database: " . mysqli_connect_error();
            header("location:booking_form.html");
        }
    }*/
    


?>