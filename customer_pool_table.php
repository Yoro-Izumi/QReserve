<?php 
  include "connect_database.php";
  include "encodeDecode.php";
  include "src/get_data_from_database/get_pool_table_info.php";
  include "src/get_data_from_database/get_walk_in.php";
  include "src/get_data_from_database/get_reservation_info.php";
  include "src/get_data_from_database/get_customer_information.php";
  include "src/get_data_from_database/convert_to_normal_time.php";

$key = "TheGreatestNumberIs73";
date_default_timezone_set('Asia/Manila');



echo "<thead>
          <tr>
            <th>Pool Table</th>
            <th>Time Started</th>
            <th>Expected End Time</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>";
$currentDate = date('Y-m-d');
$currentTime = date('H:i:s');

        foreach($arrayPoolTables as $poolTables){
            

              if($poolTables['customerName'] == NULL){
                $customerName = "None";
              }
              else{ $customerName = $poolTables['customerName']; }

              $poolTableStatus = $poolTables['poolTableStatus']; $poolTableNumber = $poolTables['poolTableNumber']; 
              $timeStarted = explode(' ',$poolTables['timeStarted']); 
              $timeEnd = explode(' ',$poolTables['timeEnd']);
            
            echo "<tr>
              <td>".$poolTableNumber."</td>
              <td>".($poolTableStatus == "Available" ? "--:--" : convertToNormalTime($timeStarted[1]))."</td>
              <td>".($poolTableStatus == "Available" ? "--:--" : convertToNormalTime($timeEnd[1]))."</td>";
                if($poolTableStatus == "Done" || $poolTableStatus == "Available"){
                  $status = "badge bg-success";
                }
                else if($poolTableStatus == "Reserved" || $poolTableStatus == "Waiting"){
                  $status = "badge bg-warning";
                }
                else{
                  $status = "badge bg-danger";
                }
             echo "<td><span class='".$status."'>".$poolTableStatus."</span></td>
            </tr>";
             }
        echo "</tbody>";

