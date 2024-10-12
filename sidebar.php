
  <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div>
      
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" style="font-size: larger;">
                <?php if (_session('login')) : ?>
                  <li class="nav-item">
            <a href="?m=data" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Data
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?m=fpg" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                FPG
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="aksi.php?act=logout" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
                <?php else : ?>
                    <li><a href="?m=tentang"><span class="glyphicon glyphicon-stats"></span> <strong>Tentang</strong></a></li>
                    <li><a href="?m=login"><span class="glyphicon glyphicon-log-in"></span> <strong>Login</strong></a></li>
                <?php endif ?>
            </ul>
        </nav>
    </div>
</div>


 