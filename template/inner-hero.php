<?php
if (is_page()) {
  $title = get_the_title();
}
?>
<section id="about-hero">
    <div class="about-hero-bg"></div>
    <div class="about-hero-overlay"></div>
    <div class="text-center reveal">
        <h1 class="about-hero-title"><span><?php echo $title; ?></span></h1>
        <div class="breadcrumb-wrap reveal custom-style-3" >
            <a href="index.html">Home</a>
            <span class="mx-2">/</span>
            <span><?php echo $title; ?></span>
        </div>
    </div>
</section>