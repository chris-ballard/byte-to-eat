document.addEventListener('DOMContentLoaded', function () {
  const selects = document.querySelectorAll('.form-select');
  const placeOrderButton = document.querySelector('#order_place_order');
  placeOrderButton.disabled = true;

  // Function to check if any select has a valid option selected
  function updateButtonState() {
    let anySelected = false;
    selects.forEach(select => {
      if (select.value !== '' && select.value !== null) {
        anySelected = true;
      }
    });
    placeOrderButton.disabled = !anySelected;
  }

  // Enable fields and check state on change
  selects.forEach(select => {
    select.addEventListener('change', function () {
      updateButtonState(); // Check if we should enable the button
    });
  });

  // Initially call the state update to handle pre-filled forms
  updateButtonState();
});
