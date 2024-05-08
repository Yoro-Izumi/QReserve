<?php
date_default_timezone_set('Asia/Manila');
  include "connect_database.php";
  include "src/get_data_from_database/get_services.php";

echo"  
<thead>
          <tr>
          <tr>
            <th>Actions</th>
            <th>Service Name</th>
            <th>Rates</th>
            <th>Capacity</th>
            <th>Image</th>
          </tr>
        </thead>
        <tbody>";
        foreach($arrayServices as $services){
        echo"
          <tr>
            <td><input type='checkbox' class='service-checkbox' name='serviceID[]' value='{$services['serviceID']}'></td>
            <td>{$services['serviceName']}</td>
            <td>{$services['normalPrice']}</td>
            <td>{$services['serviceCapacity']}</td>
            <td>{$services['serviceImage']}</td>
          </tr>";
        }
        echo "</tbody>";

?>
