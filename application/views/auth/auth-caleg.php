<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/toastr/build/toastr.min.css') ?>">
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/toastr/build/toastr.min.js') ?>"></script>


    <style>
      html, body {
          height: 100%;
          background-image: url('<?= base_url('assets/img/logo/gerindra2.png') ?>');
          background-repeat: no-repeat;
          background-attachment: fixed;
          min-height: 100%;
          background-size: cover;
          background-position: center;
      }

      .container-fluid {
        min-height: 100%;
        background: rgba(255, 0, 0, 0.6);
      }

      #foto-eko {
        width: 170px;
        padding-top: 3rem;
        border-bottom: 5px solid #fcef35;
        border-radius: 5px;

      }

      #title-app {
        color: black;
        font-size: 25px;
      }
      #eko {
        color: #fcef35;
      }
      #caption-app {
        color: #fcef35;
        font-size: 17px;
      }

      .form-group label b {
        color: black;
      }

      .btn-login {
        background: #910a00;
        color: white;
      }


    </style>

    <title>Login Page</title>

  </head>
  <body>

    <div class="container-fluid" style="width: 100%">
      <div class="row vh-100 justify-content-center">
        <div class="col-10 col-sm-10 col-md-8 col-lg-3">

          <div class="text-center mb-3">

              <img src="<?= base_url('assets/img/logo/eko.png') ?>" alt="pak-eko" id="foto-eko">

          </div>

          <div class="text-center" id="title-app">
            <b>Pak</b> <b id="eko">Eko</b> <b>App</b> <br>
          </div>
          <div class="text-center">
            <span id="caption-app">Sistem Aplikasi Pemenangan Pak Eko</span>
          </div>
          <form action="<?= base_url('auth/validation_login') ?>" id="formLogin" method="post">
            <div class="form-group mt-3">
              <label><b>Email</b></label>
              <input type="text" name="email" class="form-control" id="email" placeholder="Masukkan Email">
              <small class="text-danger" id="err_email"></small>
            </div>

            <div class="form-group">
              <label><b>Password</b></label>
              <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan Password">
              <small class="text-danger" id="err_password"></small>
            </div>

            <button type="submit" id="toLogin" class="btn btn-login w-100">Login</button>
            <a href="<?= base_url('auth/forgotpassword') ?>" style="color: black"><small><b>Lupa Password?</b></small></a>

          </form>
        </div>
      </div>
    </div>

    <div id="scs_msg" data-msg="<?= $this->session->flashdata('message_scs') ?>"></div>
    <div id="err_msg" data-msg="<?= $this->session->flashdata('message_err') ?>"></div>



    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script type="text/javascript">
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

    <script>
        $('#formLogin').submit(function(e) {
            e.preventDefault();
            $('#toLogin').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('#toLogin').attr('disabled', true);

            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                type: 'POST',
                dataType: 'JSON',
                success: function(d) {
                    $('#toLogin').html('Login');
                    $('#toLogin').removeAttr('disabled');

                    if (d.type == 'validation') {
                        if (d.err_email == '') {
                            $('#err_email').html('');
                        } else {
                            $('#err_email').html(d.err_email);
                        }

                        if (d.err_pass == '') {
                            $('#err_password').html('');
                        } else {
                            $('#err_password').html(d.err_pass);
                        }
                    } else if (d.type == 'result') {
                        $('#err_email').html('');
                        $('#err_password').html('');


                        if (d.success == false) {
                            toastr["error"](d.msg, "Error");
                        } else {
                            $('#email').val('');
                            $('#password').val('');

                            toastr["success"](d.msg, "Success");
                            setTimeout(() => {
                                window.location.href = d.redirect;
                            }, 1700);
                        }
                    }
                },
                error: function(xhr) {
                    $('#toLogin').html('Login');
                    $('#toLogin').removeAttr('disabled');

                    if (xhr.status === 0) {
                        toastr["error"]("No internet access", "Error");
                    } else if (xhr.status == 404) {
                        toastr["error"]("Page not found", "Error");
                    } else if (xhr.status == 500) {
                        toastr["error"]("Internal server error", "Error");
                    } else {
                        toastr["error"]("Unknow error", "Error");
                    }
                }
            });

        });
    </script>

    <script>
      let scs = $('#scs_msg').data('msg');
      let err = $('#err_msg').data('msg');

      if(scs){
        toastr["success"](scs, "Success");
      }

      if(err){
        toastr["error"](err, "Error");
      }
    </script>
  </body>
</html>
