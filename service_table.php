<!-- <?php
date_default_timezone_set('Asia/Manila');
  include "connect_database.php";
  include "src/get_data_from_database/get_services.php";

echo"  

        <tbody>";
        foreach($arrayServices as $services){
        echo"
          <tr>
            <td><input type='checkbox' onchange='getSelected(this)' class='service-checkbox' name='serviceID[]' value='{$services['serviceID']}'></td>
            <td>{$services['serviceName']}</td>
            <td>₱{$services['serviceRate']}</td>
            <td>{$services['serviceCapacity']}</td>
            <td>{$services['serviceImage']}</td>
          </tr>";
        }
        echo "</tbody>";

?> -->
