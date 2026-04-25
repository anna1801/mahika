document.addEventListener('DOMContentLoaded', function () {

    // re-initialize minicart sidebar beacuse fragments stops default js code from theme file

    let cartOpen = false;

    const cart = () => document.getElementById('cartSidebar');
    const overlay = () => document.getElementById('cartOverlay');

    document.getElementById('cartTrigger')?.addEventListener('click', function (e) {
        e.stopPropagation();
        cart()?.classList.add('open');
        overlay()?.classList.add('active');
        cartOpen = true;
    });

    function closeCart() {
        cart()?.classList.remove('open');
        overlay()?.classList.remove('active');
        cartOpen = false;
    }

    document.addEventListener('click', function (e) {
        if (e.target.closest('#closeCart')) closeCart();
    });

    overlay()?.addEventListener('click', closeCart);

    jQuery(document.body).on('wc_fragments_refreshed', function () {
        if (cartOpen) {
            cart()?.classList.add('open');
            overlay()?.classList.add('active');
        }
    });

});