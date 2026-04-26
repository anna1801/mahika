// Quantity 
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.qty-btn');
    if (!btn) return;

    const wrapper = btn.closest('.d-flex');
    const input = wrapper.querySelector('.qty-input');

    if (!input) return;

    let value = parseInt(input.value) || 0;
    const step = parseInt(input.step) || 1;
    const min = parseInt(input.min) || 0;
    const max = parseInt(input.max) || 9999;

    if (btn.classList.contains('plus')) {
        value = Math.min(value + step, max);
    }

    if (btn.classList.contains('minus')) {
        value = Math.max(value - step, min);
    }

    input.value = value;

    // trigger WooCommerce update detection
    input.dispatchEvent(new Event('change', { bubbles: true }));

    // enable update cart button (important)
    const updateBtn = document.querySelector('button[name="update_cart"]');
    if (updateBtn) updateBtn.disabled = false;
});