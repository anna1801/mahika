<?php
    if (is_page()) {
        $title = get_the_title();
    } elseif (is_shop()) {
        $title = get_the_title(wc_get_page_id('shop'));
    }
?>
<section id="page-hero">
    <div class="page-hero-bg"></div>
    <div class="page-hero-overlay"></div>
    <div class="text-center reveal">
        <h1 class="page-hero-title"><span><?php echo $title; ?></span></h1>
        <div class="breadcrumb-wrap reveal custom-style-3" >
            <a href="<?php echo site_url(); ?>">Home</a>
            <span class="mx-2">/</span>
            <span><?php echo $title; ?></span>
        </div>
    </div>
</section>