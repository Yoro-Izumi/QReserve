<?php
include "../../connect_database.php";
include "get_pool_table_info.php";
include "convert_to_normal_time.php";

$lastNumber = sizeof($arrayPoolTables);
$tables = array();

foreach ($arrayPoolTables as $poolTables) {
    $poolTableNumber = $poolTables['poolTableNumber'];
    $poolTableStatus = $poolTables['poolTableStatus'];
    $poolTableTimeStart = $poolTables['timeStarted'];
    $poolTablesTimeEnd = $poolTables['timeEnd'];
    $tables[] = array(
        "poolTableNumber" => $poolTableNumber,
        "poolTableStatus" => $poolTableStatus,
        "poolTableTimeStart" => $poolTableTimeStart,
        "poolTableTimeEnd" => $poolTablesTimeEnd
    );
}

// Rearrange the $tables array based on the desired pattern
function rearrangeTables($tables, $lastNumber) {
    $rows = ceil(sqrt($lastNumber));
    $cols = $rows;
    $result = array_fill(0, $cols, array_fill(0, $rows, null));

    // Rearrange elements
    $k = 0;
    for ($i = 0; $i < $cols; $i++) {
        for ($j = 0; $j < $rows; $j++) {
            if ($k < $lastNumber) {
                $result[$j][$i] = $tables[$k];
                $k++;
            }
        }
    }

    // Flatten the result array
    $flattenedResult = [];
    foreach ($result as $subArray) {
        foreach ($subArray as $element) {
            if ($element !== null) {
                $flattenedResult[] = $element;
            }
        }
    }

    return $flattenedResult;
}

$rearrangedTables = rearrangeTables($tables, $lastNumber);

foreach ($rearrangedTables as $ptable) {
    $poolTableNumber = $ptable['poolTableNumber'];
    $status = $ptable['poolTableStatus'];
    $tStart = explode(" ",$ptable['poolTableTimeStart']);
    $tEnd = explode(" ",$ptable['poolTableTimeEnd']);
    $time = convertToNormalTime($tStart[1])."-".convertToNormalTime($tEnd[1]);
    $tableBoxColor = "table-box";
        if($status != "Available"){
            $status = $time;
            $tableBoxColor = "table-box-not-available"; 
        }
        else{
            $tableBox = "table-box";
        }
    ?>
    <div class="col-md-3 mb-3">
        <div class="<?php echo $tableBoxColor;?>">
            <div class="table-number">
                <?php echo $poolTableNumber; ?>
            </div>
            <div class="table-time">
                <p id="tangina"><?php echo $status; ?></p>
            </div>
        </div>
    </div>
    <?php
}


?>