$(document).ready(function () {
    $("#example").DataTable({
        paging: true,
        lengthChange: true,
        searching: true, // Ensure this option is set to true
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: true,
        scrollX: true // Enable horizontal scrolling
    });
});


// JavaScript functions for handling bulk actions
function deleteSelected() {
    // Implement delete logic here
    console.log("Delete selected rows");
}

function editSelected() {
    // Implement edit logic here
    console.log("Edit selected rows");
}




$(document).ready(function () {
    // Function to update table content
    function updateTable() {
        $.ajax({
            url: 'admin_table.php', // Change this to the PHP file that contains the table content
            type: 'GET',
            success: function (response) {
                $('#example tbody').html($(response).find('#example tbody').html());
                attachCheckboxListeners(); // Attach event listeners for checkboxes after AJAX call
            }
        });
    }
    

    // Attach event listeners for checkboxes
    function attachCheckboxListeners() {
        const checkboxes = document.querySelectorAll('.admin-checkbox');
        var editAdminButton = document.getElementById('edit-admin');
        var deleteAdminButton = document.getElementById('delete-admin');
        var checkedCount = 0;

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    checkedCount++;
                    if (checkedCount === 1) {
                        // If only one checkbox is checked, set its value
                        checkBoxValue = this.value;
                        document.getElementById("edit-admin-val").value = this.value;
                    }
                } else {
                    checkedCount--;
                    if (checkedCount === 1) {
                        // If only one checkbox remains checked after unchecking this one, find and set its value
                        const remainingCheckbox = [...checkboxes].find(checkbox => checkbox.checked);
                        if (remainingCheckbox) {
                            checkBoxValue = remainingCheckbox.value;
                            document.getElementById('edit-admin-val').value = remainingCheckbox.value;
                        }
                    } else {
                        // If no or multiple checkboxes are checked, clear the value
                        checkBoxValue = " ";
                    }
                }
                editAdminButton.disabled = checkedCount !== 1; // Disable edit button if no checkbox is checked or more than one checkbox is checked
                deleteAdminButton.disabled = checkedCount === 0; // Disable delete button if no checkbox is checked

                // Stop or start interval based on checkbox status
                if (checkedCount > 0) {
                    stopInterval();
                } else {
                    startInterval();
                }
            });
        });
    }

    // Initial table update
    updateTable();
});


$("#edit-admin").click(function(){
    // Get the value from the input field
    var value = document.getElementById('edit-admin-val').value;

    // Redirect to the PHP file with the value as a query parameter
    window.location.href = 'edit_service.php?value=' + encodeURIComponent(value);
});



//   script for deleting admin
$(document).ready(function(){
    // AJAX code to handle deletion
    $("#confirm-delete-button").click(function(){
        // Array to store IDs of selected rows
        var selectedRows = [];

        // Iterate through each checked checkbox
        $(".admin-checkbox:checked").each(function(){
            // Push the value (ID) of checked checkbox into the array
            selectedRows.push($(this).val());
        });

        // AJAX call to send selected rows IDs to delete script
        $.ajax({
            url: "service_crud.php",
            type: "POST",
            data: {selectedRows: selectedRows},
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

//reload page
function reload(){
location.reload();
}



