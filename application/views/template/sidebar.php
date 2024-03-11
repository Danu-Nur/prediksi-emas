<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="#" class="app-brand-link">
              
              <span class=" menu-text fw-bolder ms-2">WEB SAW</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">

  
      <?php if ($this->session->userdata('status') === 'ADMIN') : 
          $links = array(
            array('Dashboard', base_url('admin/admin'),'bx-home-circle','ds'),
            array('Data Harga Emas', base_url('admin/Dataset_emas'),'bx-file','de'),
            array('Data Label', base_url('admin/Label'),'bx-file','dl'),
            array('Data Users', base_url('admin/users'),'bx-user','dr'),
            array('Hitung Metode', base_url('admin/Metode'),'bx-calculator','mtd'),
          );
          
          // Loop through the links and generate list items
          foreach ($links as $link) {
            $isActive = $menu === $link[3] ? 'active' : '';
            echo '<li class="menu-item '.$isActive.'">';
            echo '<a href="'. $link[1] .'" class="menu-link">';
            echo '<i class="menu-icon tf-icons bx '.$link[2].'"></i>';
            echo '<div data-i18n="Analytics">'. $link[0] .'</div>';
            echo '</a></li>';
          } ?>
      <?php else : 
          $links = array(
            array('Dashboard', base_url('user/User'),'bx-home-circle','ds'),
            array('Hitung Metode', base_url('user/Metode'),'bx-calculator','mtd'),
          );
          
          // Loop through the links and generate list items
          foreach ($links as $link) {
            $isActive = $menu === $link[3] ? 'active' : '';
            echo '<li class="menu-item '.$isActive.'">';
            echo '<a href="'. $link[1] .'" class="menu-link">';
            echo '<i class="menu-icon tf-icons bx '.$link[2].'"></i>';
            echo '<div data-i18n="Analytics">'. $link[0] .'</div>';
            echo '</a></li>';
          }?>
      <?php endif; ?>
    <?php
    // Define a list of links with link text and URL
  
    ?>
        </aside>
