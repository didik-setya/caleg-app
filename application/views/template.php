<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/logo.png" rel="icon">
  <title><?= $title ?></title>
  <link href="<?= base_url('assets/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url('assets/') ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url('assets/') ?>css/ruang-admin.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/toastr/build/toastr.min.css') ?>">
  <link href="<?= base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/') ?>vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">


  <script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url('assets/toastr/build/toastr.min.js') ?>"></script>
  <script src="<?= base_url('assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets/') ?>vendor/select2/dist/js/select2.min.js"></script>
  <script src="<?= base_url('assets/') ?>vendor/chart.js/Chart.min.js"></script>
  <script src="<?= base_url('assets/') ?>package/dist/sweetalert2.all.min.js"></script>

  <script src="<?= base_url('assets/chart/dist/chart.umd.js') ?>"></script>

  <script>
    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "1700",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
  </script>

</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" style="background: #f2f2f2" href="">
        <div class="sidebar-brand-icon">
          <img src="<?= base_url('assets/img/logo/logogerindra.png') ?>">
        </div>
        <div class="sidebar-brand-text mx-3"></div>
      </a>

        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('dashboard') ?>" style="color: #2e3359">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
        </li>

        <?php foreach(get_menu() as $menu){ ?>

          <?php if($menu->new_tab == 1){
              $target = 'target="_blank"';
            } else {
              $target = '';
            }
          ?>

          <?php if($menu->other_link == 1){ ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= $menu->new_link ?>" style="color: #2e3359" <?= $target ?>>
                <i class="<?= $menu->icon ?>"></i>
                <span><?= $menu->nama_menu ?></span></a>
            </li>
          <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url($menu->url) ?>" style="color: #2e3359" <?= $target ?>>
                <i class="<?= $menu->icon ?>"></i>
                <span><?= $menu->nama_menu ?></span></a>
            </li>
          <?php } ?>

        <?php } ?>


      <div class="version d-none" id="version-ruangadmin"></div>
    </ul>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top" style="background: #d40000">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="<?= base_url('assets/img/user/' . $user->img) ?>" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small"><?= $user->nama ?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?= base_url('user') ?>">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="<?= base_url('user/setting') ?>">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>

                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= base_url('auth/logout') ?>">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <!-- content in here -->
          <?php $this->load->view($view); ?>
        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>copyright &copy; <script>
                document.write(new Date().getFullYear());
              </script>
            </span>
          </div>
        </div>
      </footer>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="<?= base_url('assets/') ?>js/ruang-admin.min.js"></script>
  <script>
    let interval;
    $(document).ready(function(){
      interval = setInterval(() => {
        check_user();
      }, 3000);
    });

    $('.count').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
      }, {
          duration: 1300,
          easing: 'swing',
          step: function (now) {
              $(this).text(Math.ceil(now));
          }
      });
    });

    function check_user(){

      $.ajax({
        url: '<?= base_url('pub/check') ?>',
        type: 'POST',
        dataType: 'JSON',
        success: function(d){
          if(d.sess != 1){

            clearInterval(interval);

            Swal.fire({
              title: 'Oppss....',
              text: "Sesi telah habis, silahkan login kembali",
              icon: 'warning',
              showCancelButton: false,
              confirmButtonColor: '#62278f',
              cancelButtonColor: '#d33',
              confirmButtonText: 'OK',
              allowOutsideClick: false
            }).then((result) => {
              if (result.value) {
                window.location.href = '<?= base_url('auth/logout') ?>';
              }
            });
            }
        }
      })


    }
  </script>
</body>

</html>
