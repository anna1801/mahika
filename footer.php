</main>
<?php wp_footer(); ?>

  <footer>
    <div class="container">
      <div class="row g-4">
        <?php
          echo '<div class="col-md-4">';
            $logo = get_field('logo', 'option');
            if($logo) :
              echo '<img src="'.$logo['url'].'" class="logo-white mb-3" alt="'.$logo['alt'].'" />';
            endif;

            $footer_about = get_field('footer_about', 'option');
            if($footer_about) :
              echo '<p class="custom-style-7">'.$footer_about.'</p>';
            endif;

            if( have_rows('social_links', 'option') ):
              echo '<div class="footer-social mt-3">';
                while( have_rows('social_links', 'option') ): the_row();
                  $icon = get_sub_field('icon');
                  $url = get_sub_field('url');
                  echo '<a href="'.$url.'" target="_blank"><i class="bi bi-'.$icon.'"></i></a>';
                endwhile;
              echo '</div>';
            endif;
          echo '</div>';
         
          $locations = get_nav_menu_locations();

          $location1 = 'footer-menu-1';
          if (isset($locations[$location1])) :
            echo '<div class="col-6 col-md-2">';
              $menu = wp_get_nav_menu_object($locations[$location1]);
              echo '<h6>'.$menu->name.'</h6>';
              wp_nav_menu([
                'theme_location' => $location1,
                'container'      => 'div',
                'items_wrap'     => '%3$s',
                'walker'         => new Footer_Menu_Walker(),
              ]);
            echo '</div>';
          endif;

          $location2 = 'footer-menu-2';
          if (isset($locations[$location2])) :
            echo '<div class="col-6 col-md-3">';
              $menu = wp_get_nav_menu_object($locations[$location2]);
              echo '<h6>'.$menu->name.'</h6>';
              wp_nav_menu([
                'theme_location' => $location2,
                'container'      => 'div',
                'items_wrap'     => '%3$s',
                'walker'         => new Footer_Menu_Walker(),
              ]);
            echo '</div>';
          endif;

          if( have_rows('contact_details', 'option') ):
            echo '<div class="col-md-3">';
              $contact_label = get_field('contact_label', 'option');
              if($contact_label) :
                echo '<h6>'.$contact_label.'</h6>';
              endif;
              while( have_rows('contact_details', 'option') ): the_row();
                $icon = get_sub_field('icon');
                $url = get_sub_field('url');
                $value = get_sub_field('value');
                if($url) {
                  $link = $url;
                } else {
                  $link = 'javascript:void(0)';
                }
                echo '<p><a href="'.$link.'"><i class="bi bi-'.$icon.' me-1 custom-style-8"></i>'.$value.'</a></p>';
              endwhile;
            echo '</div>';
          endif;
        ?>
      </div>
      <div class="footer-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
        <?php
          $copyright_text = get_field('copyright_text', 'option');
          if($copyright_text) :
            echo '<span>'.$copyright_text.'</span>';
          endif;
        ?>
        <span>Powered by <a href="https://www.theoldschool.in/" target="_blank">The Old School</a></span>
      </div>
    </div>
  </footer>

  <button id="backTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <i class="bi bi-chevron-up"></i>
  </button>

  </body>
</html>