<?php

   // if($conn){
        // Code to execute when the connection is successful
            if(isset($_POST["submitReserve"])){
                $customerFirstName = encryptData(mysqli_real_escape_string($conn,$_POST["firstName"]),$key);
                $customerLastName = encryptData(mysqli_real_escape_string($conn,$_POST["lastName"]),$key);
                $customerMiddleName = encryptData(mysqli_real_escape_string($conn,$_POST["middleName"]),$key) ;
                $customerBirthdate = mysqli_real_escape_string($conn,$_POST["birthDate"]);
                $customerPhone = encryptData(mysqli_real_escape_string($conn,$_POST["contactNumber"]),$key);
                $customerEmail = encryptData(mysqli_real_escape_string($conn,$_POST["email"]),$key);
                $selectDate = mysqli_real_escape_string($conn,$_POST["validity"]);
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

                //Query to insert data into the database
                //For customer information
                //$insertCustomerInfoQuery = "INSERT INTO `customer_info`(`customerID`, `customerFirstName`, `customerLastName`, `customerMiddleName`, `customerBirthdate`, `customerNumber`, `customerEmail`,`validID`) VALUES (NULL,?,?,?,?,?,?,?)";   
                //$prepareInsertCustomerInfo = mysqli_prepare($conn,$insertCustomerInfoQuery);
                //mysqli_stmt_bind_param($prepareInsertCustomerInfo,"sssssss",$customerFirstName,$customerLastName,$customerMiddleName,$customerBirthdate,$customerPhone,$customerEmail,$validId);
                //mysqli_stmt_execute($prepareInsertCustomerInfo);

                //$customerID = mysqli_insert_id($conn); //Get the primary key of customer_information in order to set the key as foreign key to another table

                //For payment history to update later if customer paid
                $p = 0;
                $insertPaymentInformationQuery = "INSERT INTO `payment_history`(`paymentID`, `customerID`, `paymentAmount`) VALUES (NULL,?,?)";   
                $prepareInsertPaymentInformation = mysqli_prepare($conn,$insertPaymentInformationQuery);
                mysqli_stmt_bind_param($prepareInsertPaymentInformation,"ii",$customerID,$p);
                mysqli_stmt_execute($prepareInsertPaymentInformation);

                $paymentID = mysqli_insert_id($conn); //Get the primary key of payment_history in order to set the key as foreign key to another table


                //For reservation information
                //                   INSERT INTO `pool_table_reservation`(`reservationID`, `tableID`, `customerID`, `hoursID`, `paymentID`, `reservationDate`, `reservationTimeStart`, `reservationTimeEnd`, `reservationStatus`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9])
                $reservationQuery = "INSERT INTO `pool_table_reservation`(`reservationID`, `tableID`, `customerID`, `hoursID`, `paymentID`, `reservationDate`, `reservationTimeStart`, `reservationTimeEnd`, `reservationStatus`) VALUES (NULL,?,?,?,?,?,?,?,?)";
                $reservationPrepare = mysqli_prepare($conn,$reservationQuery);
                mysqli_stmt_bind_param($reservationPrepare,"iiiissss",$poolTable,$customerID,$hoursID,$paymentID,$selectDate,$selectStartTime,$selectEndTime,$reservationStatus);
                mysqli_stmt_execute($reservationPrepare);
                
                header("location:booking_form.php");
            }
mysqli_close($conn);
