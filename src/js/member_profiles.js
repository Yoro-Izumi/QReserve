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
  
  $(document).ready(function () {
    var intervalID; // Define intervalID variable outside to make it accessible across functions
  
    // Function to update table content
    function updateTable() {
      $.ajax({
        url: "member_table.php", // Change this to the PHP file that contains the table content
        type: "GET",
        success: function (response) {
          $("#example").html(response);
          attachCheckboxListeners(); // Attach event listeners for checkboxes after AJAX call
        },
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
      const checkboxes = document.querySelectorAll(".member-checkbox");
      var editMemberButton = document.getElementById("edit-member");
      var deleteMemberButton = document.getElementById('delete-member');
      var checkedCount = 0;
      var checkBoxValue;
  
      editMemberButton.disabled = true;
      deleteMemberButton.disabled = true;
  
      checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", function () {
          if (this.checked) {
            checkedCount++;
            if (checkedCount === 1) {
              // If only one checkbox is checked, set its value
              // Ensure that checkboxValue is defined and refers to the appropriate element
              checkboxValue = this.value;
              document.getElementById("edit-member-val").value = this.value;
            }
          } else {
            checkedCount--;
            if (checkedCount === 1) {
              // If only one checkbox remains checked after unchecking this one, find and set its value
              const remainingCheckbox = [...checkboxes].find(
                (checkbox) => checkbox.checked
              );
              if (remainingCheckbox) {
                checkboxValue = remainingCheckbox.value;
                document.getElementById("edit-member-val").value =
                  remainingCheckbox.value;
              }
            } else {
              // If no or multiple checkboxes are checked, clear the value
              checkboxValue = " ";
            }
          }
          editMemberButton.disabled = checkedCount !== 1; // Disable button if no checkbox is checked or more than one checkbox is checked
          deleteMemberButton.disabled = checkedCount === 0; // Disable delete button if no checkbox is checked
  
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
  
  // AJAX code to handle deletion
  $(document).ready(function () {
    $("#confirm-delete-member").click(function () {
      // Array to store IDs of selected rows
      var selectedRows = [];
  
      // Iterate through each checked checkbox
      $(".member-checkbox:checked").each(function () {
        // Push the value (ID) of checked checkbox into the array
        selectedRows.push($(this).val());
      });
  
      // AJAX call to send selected rows IDs to delete script
      $.ajax({
        url: "member_crud.php",
        type: "POST",
        data: { selectedRows: selectedRows },
        success: function (response) {
          // Reload the page or update the table as needed
          location.reload(); // For example, reload the page after deletion
        },
        error: function (xhr, status, error) {
          console.error("Error:", error);
        },
      });
    });
  });
  
  // Reload page
  function reload() {
    location.reload();
  }
  
  // Send data to edit member page
  $("#edit-member").click(function () {
    // Get the value from the input field
    var value = document.getElementById("edit-member-val").value;
  
    // Redirect to the PHP file with the value as a query parameter
    window.location.href =
      "edit_member_account.php?value=" + encodeURIComponent(value);
  });
  