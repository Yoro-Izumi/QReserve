$(document).ready(function() {
    $("#example").DataTable({
      paging: true,
      lengthChange: true,
      searching: true,
      ordering: true,
      info: true,
      autoWidth: false,
      responsive: true,
    });
  });



  $(document).ready(function() {
    var intervalID; // Define intervalID variable outside to make it accessible across functions

    // Function to update table content
    function updateTable() {
      $.ajax({
        url: 'reservation_table.php', // Change this to the PHP file that contains the table content
        type: 'GET',
        success: function(response) {
          $('#example').html(response);
          attachCheckboxListeners(); // Attach event listeners for checkboxes after AJAX call
        }
      });
    }

    // Function to start interval
    function startInterval() {
      intervalID = setInterval(updateTable, 1000); // Adjust interval as needed
    }

    // Function to stop interval
    function stopInterval() {
      clearInterval(intervalID);
    }

    // Attach event listeners for checkboxes
function attachCheckboxListeners() {
    const checkboxes = document.querySelectorAll('.reservation-checkbox');
    //var editReservationButton = document.getElementById('edit-reservation');
    //var deleteReservationButton = document.getElementById('delete-reservation');
    var checkedCount = 0; var checkBoxValue;

    //editAdminButton.disabled = true;

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            if (this.checked) {
                checkedCount++;
                if (checkedCount === 1) {
                    // If only one checkbox is checked, set its value
                    // Ensure that checkboxValue is defined and refers to the appropriate element
                    checkboxValue = this.value; // You need to define checkboxValue
                }
            } else {
                checkedCount--;
                if (checkedCount === 1) {
                    // If only one checkbox remains checked after unchecking this one, find and set its value
                    const remainingCheckbox = [...checkboxes].find(checkbox => checkbox.checked);
                    if (remainingCheckbox) {
                        checkboxValue.value = remainingCheckbox.value; // You need to define checkboxValue
                    }
                } else {
                    // If no or multiple checkboxes are checked, clear the value
                    checkboxValue.value = " "; // You need to define checkboxValue
                }
            }
            //editAdminButton.disabled = checkedCount !== 1; // Disable button if no checkbox is checked or more than one checkbox is checked

            // Stop or start interval based on checkbox status
            if (checkedCount > 0) {
                stopInterval();
            } else {
                startInterval();
            }
        });
    });
}


    // Initial table update and start interval
    updateTable();
    startInterval();
  });





  $(document).ready(function(){
    // AJAX code to handle reject reservation
    $("#confirm-reject-reservation").click(function(){
        // Array to store IDs of selected rows
        var selectedRowsReject = [];

        // Iterate through each checked checkbox
        $(".reservation-checkbox:checked").each(function(){
            // Push the value (ID) of checked checkbox into the array
            selectedRowsReject.push($(this).val());
        });

        // AJAX call to send selected rows IDs to delete script
        $.ajax({
            url: "reservation_crud.php",
            type: "POST",
            data: {selectedRowsReject: selectedRowsReject},
            success: function(response){
                // Reload the page or update the table as needed
               // location.reload(); // For example, reload the page after deletion
            },
            error: function(xhr, status, error){
                //console.error("Error:", error);
            }
        });
    });
});

$(document).ready(function(){
    // AJAX code to handle accept reservation
    $("#confirm-accept-reservation").click(function(){
        // Array to store IDs of selected rows
        var selectedRowsAccept = [];

        // Iterate through each checked checkbox
        $(".reservation-checkbox:checked").each(function(){
            // Push the value (ID) of checked checkbox into the array
            selectedRowsAccept.push($(this).val());
        });

        // AJAX call to send selected rows IDs to delete script
        $.ajax({
            url: "reservation_crud.php",
            type: "POST",
            data: {selectedRowsAccept: selectedRowsAccept},
            success: function(response){
                // Reload the page or update the table as needed
               // location.reload(); // For example, reload the page after deletion
            },
            error: function(xhr, status, error){
                //console.error("Error:", error);
            }
        });
    });
});

function reload(){
location.reload();
}



    $(document).ready(function() {
        // Initially disable the Accept and Reject buttons
        $('#accept-reservation').prop('disabled', true);
        $('#reject-reservation').prop('disabled', true);

        // Function to enable/disable the buttons based on checkbox status
        function toggleButtons() {
            var anyChecked = $('.reservation-checkbox:checked').length > 0;
            $('#accept-reservation').prop('disabled', !anyChecked);
            $('#reject-reservation').prop('disabled', !anyChecked);
        }

        // Call the function when the page is ready
        toggleButtons();

        // Attach event listeners to checkboxes to call the function on change
        $(document).on('change', '.reservation-checkbox', function() {
            toggleButtons();
        });
    });