<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="theme-color" content="#6640b2">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Sistemas para la Gestión Malpo SPA">
  <meta name="keywords" content="malpo, innovamalpo, gerencia técnica, administración, inmobiliaria">
  <meta name="author" content="Malpo SPA">

  <title>Sin Perfil</title>

  <link rel="apple-touch-icon" href="<?= base_url() ?>app-assets/images/ico/apple-icon-120.png">
  <link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>app-assets/images/ico/favicon.ico">

  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/vendors.css">
  <!-- END VENDOR CSS-->
  <!-- BEGIN STACK CSS-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/app.css">
  <!-- END STACK CSS-->
  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/core/menu/menu-types/vertical-overlay-menu.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/pages/error.css">
  <!-- END Page Level CSS-->
  <!-- BEGIN Custom CSS-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/style.css">
  <!-- END Custom CSS-->
</head>
<body class="vertical-layout vertical-overlay-menu 1-column   menu-expanded blank-page blank-page"
data-open="click" data-menu="vertical-overlay-menu" data-col="1-column">
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="flexbox-container">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-md-4 col-10 p-0">
              <div class="card-header bg-transparent border-0">
                <h2 class="error-code text-center mb-2">403</h2>
                <h3 class="text-uppercase text-center">Error 403 <br> Acceso Denegado.</h3>
              </div>
              <div class="card-content">
                <fieldset class="row py-2">
                  <div class="text-center col-12">
                    <p>Posiblemente no se ha asignado un <i>Perfil de Usuario</i> en esta plataforma. Si el problema persiste debe comunicarse con el <code>Administrador del Sistema.</code></p>
                  </div>
                </fieldset>
                <div class="row py-2">
                  <div class="col-12 col-sm-6 col-md-6">
                    <a href="javascript:history.back()" class="btn btn-primary btn-block"><i class="ft-corner-up-left"></i> Volver</a>
                  </div>
                  <div class="col-12 col-sm-6 col-md-6">
                    <a href="<?= base_url() ?>ctrl_inicio/logout"" class="btn btn-danger btn-block"><i class="ft-power"></i>  Cerrar Sesión</a>
                  </div>
                </div>
              </div>
              <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="col-12 text-center">
                     <img src="<?= base_url() ?>app-assets/images/logo/logo.png" alt="Malpo" width="200">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <!-- BEGIN VENDOR JS-->
  <script src="<?= base_url() ?>app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="<?= base_url() ?>app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"
  type="text/javascript"></script>
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN STACK JS-->
  <script src="<?= base_url() ?>app-assets/js/core/app-menu.js" type="text/javascript"></script>
  <script src="<?= base_url() ?>app-assets/js/core/app.js" type="text/javascript"></script>
  <script src="<?= base_url() ?>app-assets/js/scripts/customizer.js" type="text/javascript"></script>
  <!-- END STACK JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script src="<?= base_url() ?>app-assets/js/scripts/forms/form-login-register.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
</body>
</html>