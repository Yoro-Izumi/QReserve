
$(document).ready(function () {
    $("#example").DataTable({
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: true,
        scrollX: true,
        pagingType: 'full_numbers',
        language: {
            paginate: {
                first: 'First',
                last: 'Last',
                next: 'Next',
                previous: 'Previous'
            }
        },
        drawCallback: function (settings) {
            var api = this.api();
            var pagination = $(this)
                .closest('.dataTables_wrapper')
                .find('.dataTables_paginate .pagination');

            pagination.html(''); // Clear existing pagination buttons

            var currentPage = api.page();
            var totalPages = api.page.info().pages;

            // Determine the threshold for the number of pages to simplify pagination
            var threshold = 5;

            if (totalPages > 1) {
                // Previous button
                if (currentPage > 0) {
                    pagination.append('<li class="paginate_button page-item previous"><a href="#" aria-controls="example" data-dt-idx="previous" tabindex="0" class="page-link">Previous</a></li>');
                }

                // Show all page numbers if the total number of pages is below the threshold
                if (totalPages <= threshold) {
                    for (var i = 0; i < totalPages; i++) {
                        pagination.append('<li class="paginate_button page-item ' + (currentPage === i ? 'active' : '') + '"><a href="#" aria-controls="example" data-dt-idx="' + i + '" tabindex="0" class="page-link">' + (i + 1) + '</a></li>');
                    }
                } else {
                    // Simplified pagination for larger number of pages
                    // First page
                    pagination.append('<li class="paginate_button page-item ' + (currentPage === 0 ? 'active' : '') + '"><a href="#" aria-controls="example" data-dt-idx="0" tabindex="0" class="page-link">1</a></li>');

                    // Ellipsis for pages before the current page
                    if (currentPage > 2) {
                        pagination.append('<li class="paginate_button page-item disabled"><a href="#" tabindex="-1" class="page-link">...</a></li>');
                    }

                    // Current page and neighbors
                    for (var i = Math.max(1, currentPage - 1); i <= Math.min(currentPage + 1, totalPages - 2); i++) {
                        pagination.append('<li class="paginate_button page-item ' + (currentPage === i ? 'active' : '') + '"><a href="#" aria-controls="example" data-dt-idx="' + i + '" tabindex="0" class="page-link">' + (i + 1) + '</a></li>');
                    }

                    // Ellipsis for pages after the current page
                    if (currentPage < totalPages - 3) {
                        pagination.append('<li class="paginate_button page-item disabled"><a href="#" tabindex="-1" class="page-link">...</a></li>');
                    }

                    // Last page
                    pagination.append('<li class="paginate_button page-item ' + (currentPage === totalPages - 1 ? 'active' : '') + '"><a href="#" aria-controls="example" data-dt-idx="' + (totalPages - 1) + '" tabindex="0" class="page-link">' + totalPages + '</a></li>');
                }

                // Next button
                if (currentPage < totalPages - 1) {
                    pagination.append('<li class="paginate_button page-item next"><a href="#" aria-controls="example" data-dt-idx="next" tabindex="0" class="page-link">Next</a></li>');
                }
            }

            pagination.find('a').on('click', function (e) {
                e.preventDefault();
                var newPage = $(this).data('dt-idx');
                if (newPage === 'previous') {
                    api.page('previous').draw('page');
                } else if (newPage === 'next') {
                    api.page('next').draw('page');
                } else {
                    api.page(parseInt(newPage)).draw('page');
                }
            });
        }
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
            url: 'reservation_table.php', // Change this to the PHP file that contains the table content
            type: 'GET',
            success: function (response) {
                $('#example tbody').html($(response).find('#example tbody').html());
                attachCheckboxListeners(); // Attach event listeners for checkboxes after AJAX call
            }
        });
    }
    

    // Attach event listeners for checkboxes
    function attachCheckboxListeners() {
        const checkboxes = document.querySelectorAll('.reservation-checkbox');
        // var editreservationButton = document.getElementById('edit-reservation');
        // var deletereservationButton = document.getElementById('delete-reservation');
        var checkedCount = 0;

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
                editreservationButton.disabled = checkedCount !== 1; // Disable edit button if no checkbox is checked or more than one checkbox is checked
                deletereservationButton.disabled = checkedCount === 0; // Disable delete button if no checkbox is checked

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
    startInterval();
});

$(document).ready(function(){
    // Show textarea if 'Others' is selected
    $("input[name='rejectionReason']").change(function() {
        if ($("#thirdOption").is(":checked")) {
            $("#thirdOptionText").show();
        } else {
            $("#thirdOptionText").hide();
        }
    });

    // AJAX code to handle reject reservation
    $("#confirm-reject-reservation-reason").click(function(){
        var formData = new FormData($("#reject-reason-form")[0]);
        // Array to store IDs of selected rows
        var selectedRowsReject = [];

        // Iterate through each checked checkbox
        $(".reservation-checkbox:checked").each(function(){
            // Push the value (ID) of checked checkbox into the array
            selectedRowsReject.push($(this).val());
        });

        // Append the array to the FormData object
        formData.append('selectedRowsReject', JSON.stringify(selectedRowsReject));

        // Get the value of the selected rejection reason radio button
        var rejectionReason = $("input[name='rejectionReason']:checked").val();
        formData.append('rejectionReason', rejectionReason);

        // Append the third option text area value if necessary
        if (rejectionReason === "thirdOption") {
            var thirdOptionTextarea = $("#thirdOptionTextarea").val();
            formData.append('thirdOptionTextarea', thirdOptionTextarea);
        }

        // AJAX call to send formData (including the selected rows IDs)
        $.ajax({
            url: "reservation_crud.php",
            type: "POST",
            data: formData,
            processData: false,  // Important!
            contentType: false,  // Important!
            success: function(response){
                // Reload the page or update the table as needed
                // location.reload(); // For example, reload the page after deletion
            },
            error: function(xhr, status, error){
                console.error("Error:", error);
            }
        });
    });
});

function reload(){
location.reload();
}

$(document).ready(function(){
    // AJAX code to handle reject reservation
    $("#confirm-accept-reservation").click(function(){
        // Array to store IDs of selected rows
        var selectedRowsAccept = [];

        // Iterate through each checked checkbox
        $(".reservation-checkbox:checked").each(function(){
            // Push the value (ID) of checked checkbox into the array
            selectedRowsAccept.push($(this).val());
        });

        // AJAX call to send selected rows IDs to accept reservation script
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





// Function to fetch data based on the scanned QR code ID
function fetchInfo(id) {
    fetch('zgetInfo.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById('result').innerText = data.error;
                document.getElementById('modal-body-content').innerText = data.error;
                $('#invalid_qr_modal').modal('show'); // Show the invalid QR code modal
            } else {
                const info = data.info;
                const infoText = `
                    <p><strong>Reservation ID:</strong> ${info.reservationID}</p>
                    <p><strong>Member ID:</strong> ${info.memberID}</p>
                    <p><strong>Table Number:</strong> ${info.tableNumber}</p>
                    <p><strong>Reservation Status:</strong> ${info.reservationStatus}</p>
                    <p><strong>Reservation Date:</strong> ${info.reservationDate}</p>
                    <p><strong>Reservation Time Start:</strong> ${info.reservationTimeStart}</p>
                    <p><strong>Reservation Time End:</strong> ${info.reservationTimeEnd}</p>
                `;
                document.getElementById('result').innerText = infoText;

                // Show the modal with the fetched data
                document.getElementById('modal-body-content').innerHTML = infoText;
                $('#reservation_details').modal('show');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('result').innerText = 'An error occurred while fetching the data.';
            document.getElementById('modal-body-content').innerText = 'An error occurred while fetching the data.';
            $('#invalid_qr_modal').modal('show'); // Show the invalid QR code modal in case of an error
        });
}


// Function to hide the keyboard on mobile devices
function hideMobileKeyboard() {
    // Temporarily create an input, focus it, then blur it
    const field = document.createElement('input');
    field.setAttribute('type', 'text');
    field.setAttribute('style', 'position: absolute; top: -9999px;');
    document.body.appendChild(field);
    field.focus();
    field.blur();
    document.body.removeChild(field);
}



document.addEventListener('DOMContentLoaded', () => {
    const qrInput = document.getElementById('qrInput');
    const formInputs = document.querySelectorAll('form input:not(#qrInput)'); // Exclude qrInput from the list

    // Ensure the QR input field is always focused when necessary
    function focusQrInput() {
        if (document.activeElement !== qrInput && !document.querySelector('form input:focus')) {
            qrInput.focus();
            qrInput.scrollIntoView({ block: 'center', behavior: 'smooth' }); // Scroll into the center
        }
    }

    qrInput.addEventListener('keydown', (event) => {
        const id = qrInput.value.trim();
        if (id && event.key === 'Enter') {
            fetchInfo(id);
            hideMobileKeyboard();  // Hide the mobile keyboard
            qrInput.value = '';  // Clear the input field after scanning
        }
    });

    // Add event listeners to all form inputs to manage focus
    formInputs.forEach(input => {
        input.addEventListener('focus', () => {
            // Temporarily disable QR input focus
            document.removeEventListener('click', focusQrInput);
        });

        input.addEventListener('blur', () => {
            // Re-enable QR input focus after a delay
            setTimeout(() => {
                document.addEventListener('click', focusQrInput);
            }, 100);
        });
    });

    // Make DataTable pagination and number of entry dropdown clickable
    function allowInteractionOnDataTable() {
        // Adding click event to the DataTable elements to stop propagation
        document.querySelectorAll('.dataTables_paginate, .dataTables_length, .dataTables_filter').forEach(element => {
            element.addEventListener('click', (event) => {
                event.stopPropagation(); // Stop the focus event from triggering on QR input
            });
        });

        // Adding focus and blur events to the dropdown to handle focus properly
        document.querySelectorAll('.dataTables_length select').forEach(select => {
            select.addEventListener('focus', () => {
                // Temporarily disable QR input focus
                document.removeEventListener('click', focusQrInput);
            });

            select.addEventListener('blur', () => {
                // Re-enable QR input focus after a delay
                setTimeout(() => {
                    document.addEventListener('click', focusQrInput);
                }, 100);
            });
        });
    }

    // Call the function to make DataTable interactions work
    allowInteractionOnDataTable();

    // Initial focus on the QR input field
    focusQrInput();
    // Ensure the QR input field remains focused after interactions
    document.addEventListener('click', (event) => {
        // Check if the click is inside the DataTable controls
        const isInsideDataTableControls = event.target.closest('.dataTables_paginate, .dataTables_length, .dataTables_filter');
        if (!isInsideDataTableControls) {
            focusQrInput();
        }
    });

    // Close button in the modal
    document.getElementById('submitReserve').addEventListener('click', () => {
        $('#reservation_details').modal('hide');
    });
});








/*document.addEventListener('DOMContentLoaded', () => {
    const qrInput = document.getElementById('qrInput');
    const formInputs = document.querySelectorAll('form input:not(#qrInput)'); // Exclude qrInput from the list

    // Ensure the QR input field is always focused when necessary
    function focusQrInput() {
        if (document.activeElement !== qrInput && !document.querySelector('form input:focus')) {
            qrInput.focus();
            qrInput.scrollIntoView({ block: 'center', behavior: 'smooth' }); // Scroll into the center
        }
    }

    qrInput.addEventListener('keydown', (event) => {
        const id = qrInput.value.trim();
        if (id && event.key === 'Enter') {
            fetchInfo(id);
            hideMobileKeyboard();  // Hide the mobile keyboard
            qrInput.value = '';  // Clear the input field after scanning
        }
    });

    // Add event listeners to all form inputs to manage focus
    formInputs.forEach(input => {
        input.addEventListener('focus', () => {
            // Temporarily disable QR input focus
            document.removeEventListener('click', focusQrInput);
        });

        input.addEventListener('blur', () => {
            // Re-enable QR input focus after a delay
            setTimeout(() => {
                document.addEventListener('click', focusQrInput);
            }, 100);
        });
    });

    // Make DataTable pagination and number of entry dropdown clickable
    function allowInteractionOnDataTable() {
        // Adding click event to the DataTable elements to stop propagation
        document.querySelectorAll('.dataTables_paginate, .dataTables_length, .dataTables_filter').forEach(element => {
            element.addEventListener('click', (event) => {
                event.stopPropagation(); // Stop the focus event from triggering on QR input
            });
        });

        // Adding focus and blur events to the dropdown to handle focus properly
        document.querySelectorAll('.dataTables_length select').forEach(select => {
            select.addEventListener('focus', () => {
                // Temporarily disable QR input focus
                document.removeEventListener('click', focusQrInput);
            });

            select.addEventListener('blur', () => {
                // Re-enable QR input focus after a delay
                setTimeout(() => {
                    document.addEventListener('click', focusQrInput);
                }, 100);
            });
        });
    }

    // Call the function to make DataTable interactions work
    allowInteractionOnDataTable();

    // Initial focus on the QR input field
    focusQrInput();
    // Ensure the QR input field remains focused after interactions
    document.addEventListener('click', focusQrInput);

    // Close button in the modal
    document.getElementById('submitReserve').addEventListener('click', () => {
        $('#reservation_details').modal('hide');
    });
});*/








    // for reject modal
    document.addEventListener('DOMContentLoaded', function () {
        const thirdOption = document.getElementById('thirdOption');
        const thirdOptionText = document.getElementById('thirdOptionText');
        const thirdOptionTextarea = document.getElementById('thirdOptionTextarea');
        const wordCount = document.getElementById('wordCount');
        
        const radioButtons = document.querySelectorAll('input[name="rejectionReason"]');
        
        radioButtons.forEach(radio => {
          radio.addEventListener('change', function () {
            if (this.id === 'thirdOption') {
              thirdOptionText.style.display = 'block';
              thirdOptionTextarea.focus();  // Set focus to the textarea
            } else {
              thirdOptionText.style.display = 'none';
              thirdOptionTextarea.value = '';  // Clear the textarea value
              wordCount.textContent = '0 / 50 words';  // Reset the word count
            }
          });
        });
        
        thirdOptionTextarea.addEventListener('input', function () {
          const words = this.value.split(/\s+/).filter(word => word.length > 0);
          if (words.length > 50) {
            this.value = words.slice(0, 50).join(' ');
            wordCount.textContent = '50 / 50 words';  // Correct the word count display
          } else {
            wordCount.textContent = `${words.length} / 50 words`;
          }
        });
      });
      


    //   shotgun for accept
    document.getElementById('confirm-accept-reservation').addEventListener('click', function() {
        this.disabled = true;
        // Perform your AJAX request or form submission here
        
        // Re-enable the button after the request is complete or on modal close
        document.getElementById('accept-modal').addEventListener('hidden.bs.modal', function () {
          document.getElementById('confirm-accept-reservation').disabled = false;
        });
      });

    //   shotgun for reject
    document.getElementById('confirm-reject-reservation-reason').addEventListener('click', function() {
        this.disabled = true;
        // Perform your AJAX request or form submission here
        
        // Re-enable the button after the request is complete or on modal close
        document.getElementById('reject-confirmation-modal').addEventListener('hidden.bs.modal', function () {
          document.getElementById('confirm-reject-reservation-reason').disabled = false;
        });
      });