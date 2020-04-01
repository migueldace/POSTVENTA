<style type="text/css">
  /*
  .navbar-nav .mega-dropdown-menu{
    width: calc(35% - 0px);
  }*/

</style>

<li class="dropdown nav-item mega-dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"> <i class="ft-cloud"></i>Plataformas</a>
  <ul class="mega-dropdown-menu dropdown-menu row">
 
    <li class="col-md-12"> <!-- col-md-4 original -->
      <h6 class="dropdown-menu-header text-uppercase">
        <i class="fa fa-random"></i> Cambiar Plataforma
      </h6>
      <ul class="drilldown-menu">
        <li class="menu-list">
          <ul>
            <li>
              <a class="dropdown-item" href="<?= MASTER_LOGIN ?>ctrl_login/index"><i class="ft-home"></i> Inicio Innovamalpo</a>
            </li>            
            <?php foreach ($_menu as $m): ?>
              <li><a href="#"><i class="<?= $m->departamentoIcono ?>"></i> <?= $m->departamentoNombre ?></a>
                <ul>
                  <?php foreach ($m->plataformas as $p): ?>
                    <li><a class="dropdown-item" href="<?= $p->plataformaCarpeta ?>">
                      <i class="<?= $p->plataformaIcono ?>"></i>  <?= $p->plataformaNombre ?></a></li>
                  <?php endforeach ?>
                </ul>
              </li>
            <?php endforeach ?>
          </ul>
        </li>
      </ul>
    </li>
   
  </ul>
</li>