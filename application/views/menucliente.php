<nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-dark navbar-shadow navbar-brand-center">
  <div class="navbar-wrapper">
    <div class="navbar-header">
      <ul class="nav navbar-nav flex-row">
        <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
        <li class="nav-item">
          <a class="navbar-brand" href="#">
            <img class="brand-logo" src="<?= base_url() ?>app-assets/images/logo/m.png" width="25">
            <h3 class="brand-text">
              <span class="d-none d-md-inline">Servicio de Atención al Cliente Post-Venta</span>
              <span class="d-inline d-md-none">PV</span>
            </h3>
          </a>
        </li>
        <li class="nav-item d-md-none">
          <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile">
            <span class="avatar avatar-online">
              <span class="bg-grad-danger circle-usuario"><b>J</b></span>
            </span>
          </a>
        </li>
      </ul>
    </div>
    <div class="navbar-container content" id="nav-superior">
      <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="nav navbar-nav mr-auto float-left">
          <li class="nav-item d-none d-md-block">
            <!-- Ícono de menú en pantallas pequeñas -->
            <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a>
          </li>
        </ul>
        <ul class="nav navbar-nav float-right">
          <!-- MENÚ USUARIO-->
          <li class="dropdown dropdown-user nav-item">
            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
              <span class="avatar avatar-online ">
                <span class="bg-grad-danger circle-usuario">
                  <?= strtoupper(substr($this->session->userdata('nombre'),0,1)); ?>
                </span>
              </span>
              <span class="user-name"><?= $this->session->userdata('nombre'); ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <span class="with-arrow">
                <span style="background: #ab26aa"></span>
              </span>
              <div class="dropdown-menu-header bg-grad-danger" style="padding: 4px">
                <h4 class="dropdown-header m-0">
                  <span class="white text-lowercase"><?= $this->session->userdata('email'); ?></span>
                  <br>
                  <!-- <span class="white text-lowercase font-small-2"><?= $_SESSION['perfil']; ?></span> -->
                </h4>
              </div>
              <!-- <a class="dropdown-item" href="<?= MASTER_LOGIN ?>ctrl_cuenta/inicio"><i class="ft-user"></i> Mi Perfil</a> -->
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="<?= base_url() ?>ctrl_cliente"><i class="ft-power"></i> Cerrar Sesión</a>
            </div>
          </li>

        </ul>
      </div>
    </div>
  </div>
</nav>

<!-- Menú Lateral-->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">

  <!-- main menu content-->
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
      <?php
      foreach ($menu as $item) :
        $activo = ($item['activo'] == true) ? 'active' : '';
        $link = base_url() . $item['ctrl'];
        $icono = $item['icono'];

        ?>
      <li class=" nav-item <?= $activo ?>"><a href="<?= $link ?>"><i class="<?= $icono ?>"></i><span class="menu-title" data-i18n="nav.dash.main"><?= $item['nombre'] ?></span></a>

        <?php
          if (array_key_exists('submenu', $item)) {
            if (count($item['submenu']) > 0) {

              foreach ($item['submenu'] as $sub) {
                $activo2 = ($sub['activo'] == true) ? 'active' : '';
                $sublink = base_url() . $sub['ctrl'];
                $subicono = $sub['icono'];
                ?>
        <ul class="menu-content">
          <li class=" nav-item <?= $activo2 ?>"><a href="<?= $sublink ?>">
              <i class="<?= $subicono ?>"></i>
              <span class="menu-title" data-i18n="nav.dash.main"><?= $sub['nombre'] ?></span></a>
          </li>
        </ul>

        <?php
              }
            }
          }
          ?>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <!-- /main menu content-->
  <!-- main menu footer-->
  <!-- main menu footer-->
</div>