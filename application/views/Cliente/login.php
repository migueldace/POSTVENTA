<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#6640b2">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Sistemas para la Gestión Malpo SPA">
    <meta name="keywords" content="malpo, innovamalpo, gerencia técnica, administración, inmobiliaria">
    <meta name="author" content="Malpo SPA">
    <title>Inicio Innova Malpo</title>
    <link rel="apple-touch-icon" href="<?= base_url() ?>app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/vendors.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/forms/icheck/icheck.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/forms/icheck/custom.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/plugins/animate/animate.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN STACK CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/app.css">
    <!-- END STACK CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/pages/login-register.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/style.css">

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/login.css">
    <!-- END Custom CSS-->
    
  </head>
  <body class="vertical-layout vertical-menu 1-column bg-full-screen-image menu-expanded blank-page blank-page" data-open="click" data-menu="vertical-menu" data-col="1-column">
  <!-- ////////////////////////////////////////////////////////////////////////////-->
    
    <video autoplay muted loop id="myVideo" poster="<?= base_url() ?>assets/img/cover.png">
      <source src="<?= base_url() ?>assets/videos/web.mp4" type="video/mp4">
    </video>
      
    <div class="content-body">
      <section class="flexbox-container"><!---->
        <div class="col-12 d-flex align-items-center justify-content-center mt-3 mb-2"><!--  -->
          <div class="col-md-4 col-10 box-shadow-2 p-0">
            <div class="card border-grey border-lighten-3 m-0"><!-- m-0 -->
              <div class="card-header border-0">
                <div class="card-title text-center">
                  <div class="p-0 animated pulse">
                    <img src="<?= base_url() ?>assets/img/logo_innova_2.png" width="90%" alt="innovamalpomalpo" class="innova-logo">                   
                  </div>
                </div>
                
              </div>
              <div class="card-content">
                <div class="card-body">
                  <h6 class="card-subtitle text-white text-center  pt-0">
                    <span>Ingreso Plataforma de Atención para el Cliente <br>Post-Venta</span>
                  </h6>
                  <br>
                  <form role="form"  action="<?php echo base_url() ?>Ctrl_cliente/inicio" method="post" class="login-form">
                    <fieldset class="form-group position-relative mb-1">
                      <input type="text" class="form-control form-control-lg" id="usuario" name="usuario" placeholder="Ingrese Rut sin puntos ni guion" maxlength="9" minlength="8" required>
                      <div class="form-control-position animated tada">
                        <i class="fa fa-user icono-input"></i>
                      </div>
                    </fieldset>

                    <fieldset class="form-group position-relative">
                      <input type="email" class="form-control form-control-lg" id="clave" name="clave" placeholder="Correo Electrónico" required>
                      <div class="form-control-position animated tada">
                        <i class="fa fa-key icono-input"></i>
                      </div>
                    </fieldset>
                    <!-- <div class="g-recaptcha"  align="center" data-sitekey="6LeZjDkUAAAAAF0Qfqa7Dnmoox7XWtJPuBK-gpI2"></div> -->
                    <!-- <div class="form-group row d-none">
                      <div class="col-md-6 col-12 text-center text-md-right"><a href="recover-password.html" class="text-white">¿Olvidó la contraseña?</a></div>
                    </div> -->
                    <!-- <div class="text-center"> -->
                      <!-- <?php if ($error): ?> -->
                        <!-- <div class="alert alert-danger mb-2" role="alert">
                          <strong><i class="fa fa-fw fa-exclamation-triangle"></i> Error!</strong> <?= $error ?> 
                        </div> -->
                        <!-- <?php endif; ?> -->
                        <!-- <div> -->
                    <button type="submit" class="btn btn-primary btn-lg btn-block animated fadeInDown" id="btn_login"><i class="fa fa-lock"></i> Ingresar</button>

                          <!-- </div> -->
                  </form>
                </div>
              <div class="card-footer">
                <div class="">
                  <p class="text-center m-0">
                    <span class="text-white">Si no tiene correo asociado o no lo recuerda, favor comunicarse con Call Center al número: <br>600 818 3000 - (71) 223 3397</span>
                    <!-- <a href="<?= base_url() ?>Ctrl_cuenta/Recuperar" class="text-white"><i class="fa fa-info-circle icono-input"></i> Recuperar contraseña</a> -->
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
     </section>
    </div>

  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <!-- GOOGLE CAPTCHA -->
    <script src='https://www.google.com/recaptcha/api.js?hl=es'></script>
  <!-- BEGIN VENDOR JS-->
  <script src="<?= base_url() ?>app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
  <script src="<?= base_url() ?>app-assets/vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
  <script src="<?= base_url() ?>app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"
  type="text/javascript"></script>
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN STACK JS-->
  <script src="<?= base_url() ?>app-assets/js/core/app-menu.js" type="text/javascript"></script>
  <script src="<?= base_url() ?>app-assets/js/core/app.js" type="text/javascript"></script>
  <!-- END STACK JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script src="<?= base_url() ?>app-assets/js/scripts/forms/form-login-register.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->

  <script>
  var video = document.getElementById("myVideo");
  var btn = document.getElementById("myBtn");

  function myFunction() {
    if (video.paused) {
      video.play();
      btn.innerHTML = "Pause";
    } else {
      video.pause();
      btn.innerHTML = "Play";
    }
  }
  <?php
      if($this->session->flashdata('mensaje')){ 
  ?>                    
        Swal.fire("Atención!", "<?php echo $this->session->flashdata('mensaje');?>", "info");            
  <?php 
      }
  ?>
</script>
  

</body>
</html>