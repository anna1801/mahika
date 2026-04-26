document.addEventListener('DOMContentLoaded', function () {
  const diffShipping = document.getElementById('diffShipping');
  const shippingDetails = document.getElementById('shippingDetails');

  if (diffShipping && shippingDetails) {
    diffShipping.addEventListener('change', function () {
      if (this.checked) {
        shippingDetails.classList.add('show');
      } else {
        shippingDetails.classList.remove('show');
      }
    });
  }
});