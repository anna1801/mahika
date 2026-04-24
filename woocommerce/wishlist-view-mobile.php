<?php
    defined( 'ABSPATH' ) || exit;

    $wishlist_items = $wishlist->get_items();

    wishlist_table($wishlist_items);
?>