<?php

   // if($conn){
        // Code to execute when the connection is successful
            if(isset($_POST["submitReserve"])){
                $selectDate = mysqli_real_escape_string($conn,$_POST["selectDate"]);
                $timeDifference = 0;
                $selectStartTime = mysqli_real_escape_string($conn,$_POST["selectStartTime"]);
                $selectEndTime = mysqli_real_escape_string($conn,$_POST["selectEndTime"]);
                $sTime = explode(":",$selectStartTime); $startTime = (int)$sTime[0];
                $eTime = explode(":",$selectEndTime); $endTime = (int)$eTime[0];
                    if($startTime < $endTime){
                        $timeDifference = $endTime - $startTime;
                    }
                    else{
                        $timeDifference = $startTime - $endTime;
                    }
                $poolTable = mysqli_real_escape_string($conn,$_POST["selectTable"]);
                $hoursID = $timeDifference;
                $paymentID = 1;
                $reservationStatus = "Pending";

                /* For uploading the ID
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
                move_uploaded_file($idImageTmpName, $idImageLocation); */

                //For payment history to update later if customer paid
                $p = 0;
                $insertPaymentInformationQuery = "INSERT INTO `payment_history`(`paymentID`, `customerID`, `paymentAmount`) VALUES (NULL,?,?)";   
                $prepareInsertPaymentInformation = mysqli_prepare($conn,$insertPaymentInformationQuery);
                mysqli_stmt_bind_param($prepareInsertPaymentInformation,"ii",$customerID,$p);
                mysqli_stmt_execute($prepareInsertPaymentInformation);

                $paymentID = mysqli_insert_id($conn); //Get the primary key of payment_history in order to set the key as foreign key to another table


                //For reservation information
                $reservationQuery = "INSERT INTO `pool_table_reservation`(`reservationID`, `tableID`, `memberID`, `paymentID`,`adminID`, `serviceID`, `reservationDate`, `reservationTimeStart`, `reservationTimeEnd`, `reservationStatus`) VALUES (NULL,?,?,?,NULL,1,?,?,?,?)";
                $reservationPrepare = mysqli_prepare($conn,$reservationQuery);
                mysqli_stmt_bind_param($reservationPrepare,"iiissss",$poolTable,$userID,$paymentID,$selectDate,$selectStartTime,$selectEndTime,$reservationStatus);
                mysqli_stmt_execute($reservationPrepare);
                
                header("location:booking_form.php");
            }
mysqli_close($conn);
