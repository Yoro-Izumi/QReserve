// Disables confirm button first
function checkInputs() {
    const serviceName = document.getElementById('serviceName').value.trim();
    const serviceRate = document.getElementById('serviceRate').value.trim();
    const capacity = document.getElementById('capacity').value.trim();
    const serviceImage = document.getElementById('serviceImage').value.trim();

    const confirmButton = document.getElementById('confirmButton');

    if (serviceName !== '' && serviceRate !== '' && capacity !== '' && serviceImage !== '') {
        confirmButton.disabled = false;
    } else {
        confirmButton.disabled = true;
    }
}

function resetForm() {
    document.getElementById('add-new-service-form').reset();
    checkInputs();
}

//function trim the peso sign from edit service rate input field
function trimRate(){ 
    var serviceRate = document.getElementById('editServiceRate').value; 
    document.getElementById('editServiceRate').value = serviceRate.slice(0);
}










//   For trimming whitespaces
function handleInput(event) {
    const inputValue = event.target.value.trim(); // Remove leading and trailing whitespaces
    const lastChar = inputValue.slice(-1); // Get the last character of the input

    // Check if the input is only whitespaces and it's not the last character
    if (inputValue === '' || (inputValue === ' ' && lastChar !== ' ')) {
        event.target.value = ''; // Clear the input if it's only whitespaces
    }
}











// Goes back to the confirmation and addition of new service
function editService() {
    // Close the confirmation modal
    $('#confirm-add-new-service-modal').modal('hide');

    // Open the add service modal
    $('#add-service-modal').modal('show');
}











// Bulk Actions for the table
$(document).ready(function () {
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

// JavaScript functions for handling bulk actions
function deleteSelected() {
    // Implement delete logic here
    console.log("Delete selected rows");
}

function editSelected() {
    // Implement edit logic here
    console.log("Edit selected rows");
}











// Deleting service
$(document).ready(function () {
    // AJAX code to handle deletion
    $("#delete-service").click(function () {
        // Array to store IDs of selected rows
        var selectedRows = [];

        // Iterate through each checked checkbox
        $(".service-checkbox:checked").each(function () {
            // Push the value (ID) of checked checkbox into the array
            selectedRows.push($(this).val());
        });

        // Open the delete confirmation modal if at least one checkbox is checked
        if (selectedRows.length > 0) {
            $('#delete-service-modal').modal('show');
        }
    });

    // Handle deletion confirmation
    $("#confirm-delete-button").click(function () {
        // Array to store IDs of selected rows
        var selectedRows = [];

        // Iterate through each checked checkbox
        $(".service-checkbox:checked").each(function () {
            // Push the value (ID) of checked checkbox into the array
            selectedRows.push($(this).val());
        });

        // AJAX call to send selected rows IDs to delete script
        $.ajax({
            url: "service_crud.php",
            type: "POST",
            data: {
                selectedRows: selectedRows
            },
            success: function (response) {
                // Reload the page or update the table as needed
                location.reload(); // For example, reload the page after deletion
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
            }
        });
    });
});












// 
function getSelected(checkbox) {
    if (checkbox.checked) {
        var row = checkbox.parentNode.parentNode; // Get the row containing the checkbox
        var cells = row.getElementsByTagName("td");

        // Retrieve data from cells
        var name = cells[1].innerText.trim(); // Service Name
        var rate = cells[2].innerText.trim(); // Rates
        var capacity = cells[3].innerText.trim(); // Capacity
        //var Rate = split("₱",rate);

        // Assign values to input fields
        document.getElementById("editServiceName").value = name;
        document.getElementById("editServiceRate").value = rate.slice(1);
        document.getElementById("editCapacity").value = capacity;
    }
}









// Edit Service
$(document).ready(function () {
    $('#confirm-edit-service').click(function (e) {
        e.preventDefault();

        var formData = new FormData($('#edit-new-service-form')[0]);

        $.ajax({
            type: 'POST',
            url: 'service_crud.php',
            data: formData,
            processData: false,
            contentType: false,
            // success: function(response){
            //     // Handle success response here
            //     //alert(response); // For demonstration purposes, you can display an alert with the response
            //     //location.reload();
            //   },
            error: function (xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
            }
        });
    });
});

function reload() {
    location.reload();
}











// IDK what is this but andito yung disable and enabled state ng delete and edit button
$(document).ready(function () {
    var intervalID; // Define intervalID variable outside to make it accessible across functions

    // Function to update table content
    function updateTable() {
        $.ajax({
            url: 'service_table.php', // Change this to the PHP file that contains the table content
            type: 'GET',
            success: function (response) {
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
        const checkboxes = document.querySelectorAll('.service-checkbox');
        const checkboxValue = document.getElementById('editID');
        var editServiceButton = document.getElementById('edit-service');
        var deleteServiceButton = document.getElementById('delete-service');
        var checkedCount = 0;

        editServiceButton.disabled = true;
        deleteServiceButton.disabled = true; // Disable delete button initially

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    checkedCount++;

                    if (checkedCount === 1) {
                        // If only one checkbox is checked, set its value
                        checkboxValue.value = this.value;
                        
                    }
                } else {
                    checkedCount--;
                    if (checkedCount === 1) {
                        // If only one checkbox remains checked after unchecking this one, find and set its value
                        const remainingCheckbox = [...checkboxes].find(checkbox => checkbox.checked);
                        if (remainingCheckbox) {
                            checkboxValue.value = remainingCheckbox.value;
                            getSelected(checkbox);
                        }
                    } else {
                        // If no or multiple checkboxes are checked, clear the value
                        checkboxValue.value = " ";
                    }
                }
                editServiceButton.disabled = checkedCount !== 1; // Disable edit button if no checkbox is checked or more than one checkbox is checked
                deleteServiceButton.disabled = checkedCount === 0; // Disable delete button if no checkbox is checked

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











// Inserting of data
$(document).ready(function () {
    $('#confirm_add_service_button').click(function (e) {
        e.preventDefault();

        var formData = new FormData($('#add-new-service-form')[0]);

        $.ajax({
            type: 'POST',
            url: 'service_crud.php', // Replace 'service_crud.php' with the URL of your PHP script
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // Handle success response here
                //alert(response); // For demonstration purposes, you can display an alert with the response
                $('#success-add-service-modal').modal('hide'); // Close the modal after successful insertion
                location.reload(); // Reload the page or update the table as needed
            },
            error: function (xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
            }
        });
    });
});










$(document).ready(function() {
  $('#confirmButton').click(function(e) {
    e.preventDefault();

    // Get the values of user inputs from the add-service-modal
    var serviceName = $('#serviceName').val();
    var serviceRate = $('#serviceRate').val();
    var capacity = $('#capacity').val();
    var serviceImage = $('#serviceImage').val();

    // Update the labels in the confirm-add-new-service-modal
    $('#serviceNameLabel').text(serviceName);
    $('#serviceRateLabel').text(serviceRate);
    $('#capacityLabel').text(capacity);
    $('#serviceImageLabel').text(serviceImage);

    // Show the confirm-add-new-service-modal
    $('#confirm-add-new-service-modal').modal('show');
  });
});















// For add rates
function validateRateInput(input) {
    input.value = input.value.replace(/[^0-9,.]/g, '');
  
    if (/^[,.]+$/.test(input.value)) {
      input.value = '';
    }
  }

  








$(document).ready(function() {
    $("#confirmButton").click(function() {
      const content = getUserInputs();
      console.log(content); // Debugging: check what content is generated
      $("#confirm-add-new-service-modal .modal-body").html(content);
    });
  });
  
  function getUserInputs() {
    const serviceName = $("#serviceName").val();
    const serviceRate = $("#serviceRate").val();
    const capacity = $("#capacity").val();
    const serviceImage = $("#serviceImage").val();
  
    console.log(serviceName, serviceRate, capacity, serviceImage); // Debugging: check if values are fetched correctly
  
    return `
      <div class="modal-content-wrapper">
        <p><span class="modal-label text-truncate">Name:</span> <span class="modal-input">${serviceName}</span></p>
        <p><span class="modal-label text-truncate">Rate:</span> <span class="modal-input">${serviceRate}</span></p>
        <p><span class="modal-label text-truncate">Capacity:</span> <span class="modal-input">${capacity}</span></p>
        <p class="text-truncate"><span class="modal-label">Image:</span> <span class="modal-input">${serviceImage}</span></p>
      </div>
    `;
  }