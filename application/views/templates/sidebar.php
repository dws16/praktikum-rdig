<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" style="background-color:#961B1B;" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center mb-4" href="<?= base_url('profile') ?>">
    <div class="sidebar-brand-icon rotate-30">
      <i class="fas fa-circle-notch"></i>
    </div>
    <div class="sidebar-brand-text mx-3">B401</div>
  </a>

  <?php
  $role_id = $this->session->userdata('role_id');
  $queryMenu = "SELECT `user_menu`.`id`,`menu`
                    FROM `user_menu` JOIN `user_access_menu`
                    ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                    WHERE `user_access_menu`.`role_id` = $role_id
                    ORDER BY `user_access_menu`.`menu_id` ASC
                    ";
  $menu = $this->db->query($queryMenu)->result_array();
  ?>

  <?php foreach ($menu as $m) : ?>

    <div class="sidebar-heading">
      <?= $m['menu']; ?>
    </div>

    <?php
    $menuId = $m['id'];
    $querySubMenu = "SELECT *
                    FROM `user_sub_menu`
                    WHERE `menu_id` = $menuId
                    AND `is_active` = 1
                    ";
    $SubMenu = $this->db->query($querySubMenu)->result_array();
    ?>

    <?php foreach ($SubMenu as $sm) : ?>
      <?php if ($title == $sm['title']) : ?>
        <li class="nav-item active">
        <?php else : ?>
        <li class="nav-item">
        <?php endif; ?>
        <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
          <i class="<?= $sm['icon']; ?>"></i>
          <span><?= $sm['title']; ?></span></a>
        </li>
      <?php endforeach; ?>
      <!-- Divider -->
      <hr class="sidebar-divider mt-3">
    <?php endforeach; ?>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->