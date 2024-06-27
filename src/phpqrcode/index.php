<?php
    // Include the QR code library
    include 'src/phpqrcode/phpqrcode/qrlib.php';

    // Data to encode into the QR code
    $data = decryptData($memberControlNumber, $key);

    // Output file name
    $outputFile = 'src/phpqrcode/temp/'.$data.'.png';

    // Generate QR code
    QRcode::png($data, $outputFile);

?>
