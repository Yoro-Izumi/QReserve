<!--<!DOCTYPE html>
    <html lang="en">
        <head>
            value of qr will depend on the value inside textInput
            <input type="hidden" id="qrInput" value="qr code">
            <img id="qrcodeImage" src="" alt="QR Code Image">
        </head>    
    </html>-->

    <script>


        // Add an input or on change event listener to the text input
        window.addEventListener('load', function() {
           // Get the text input and QR code image elements
        var textInput = document.getElementById('qrInput');
        var qrCodeImgElement = document.getElementById('qrcodeImage');   
          // Get the current value of the text input
          var inputValue = qrInput.value;
      
          // Generate QR code using qrcode-generator library
          var typeNumber = 4; // Adjust this value as needed
          var errorCorrectionLevel = 'L';
          var qr = qrcode(typeNumber, errorCorrectionLevel);
          qr.addData(inputValue);
          qr.make();
      
          // Create a canvas element to draw the QR code
          var canvas = document.createElement('canvas');
          var context = canvas.getContext('2d');
          var qrCodeData = qr.createDataURL(8); // Adjust the scale as needed
      
          // Set canvas dimensions and draw QR code
          canvas.width = qr.getModuleCount() * 8;
          canvas.height = qr.getModuleCount() * 8;
          var imageObj = new Image();
          imageObj.src = qrCodeData;
          imageObj.onload = function () {
            context.drawImage(imageObj, 0, 0, canvas.width, canvas.height);
      
            // Get the data URL of the canvas
            var qrImage = canvas.toDataURL('image/png');
      
            // Set the generated QR code as the image source
            qrCodeImgElement.src = qrImage;
          };
        });
      </script>

    <script src="js/qrcode.js"></script>
    <script src="js/html2canvas.min.js"></script>