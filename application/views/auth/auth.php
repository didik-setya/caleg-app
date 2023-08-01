<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/toastr/build/toastr.min.css') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/toastr/build/toastr.min.js') ?>"></script>

    <style>
        html, body {
            height: 100%;
        }

        #bg-login {
            background: url('<?= base_url('assets/img/logo/bglogin1.jpg') ?>') no-repeat center;

            min-height: 100%;
            background-size: cover;
        }

        .btn-login {
            background: #990000;
            color: #ffffff;
        }

        .btn-login:hover{
            background: #e3de44;
            color: #000000;
        }
        #bg-login h4 {
            color: #ffffff;
            font-family: 'Lato', sans-serif;
            font-weight: bold;
        }

        #bg-login i {
            color: #ffffff;
            font-size: 20px;
        }
        #content-right h2 {
            color: #000000;
            font-family: 'Lato', sans-serif;
            font-weight: bold;
        }
    </style>

    <title>Login</title>
</head>

<body>
    <div class="container-fluid" style="height: 100%">
        <div class="row vh-100">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 position-relative" id="bg-login">
                <div class="pt-5 text-center">
                    <h4>Sistem Informasi <br> Pemenangan Eko Wahyudi</h4>
                    <i>Masook Pak Eko</i>
                </div>
                <div class="position-absolute" style="bottom: 0">
                    <img src="<?= base_url('assets/img/logo/logogerindra.png') ?>" alt="logo">
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 position-relative px-5" id="content-right">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-9 col-sm-12 col-lg-9 mb-5 pb-5">
                        <div class="mt-5 pt-5 mb-4">
                            <h2>Selamat Datang</h2>
                        </div>

                        <form action="<?= base_url('auth/validation_login') ?>" id="formLogin" method="post">
                            <div class="form-group">
                                <label><b>Email</b></label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Ketikkan email">
                                <small class="text-danger" id="err_email"></small>
                            </div>
                            <div class="form-group">
                                <label><b>Password</b></label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Ketikkan password">
                                <small class="text-danger" id="err_password"></small>
                            </div>


                            <button class="btn w-100 btn-login mt-3 mb-2" type="submit" id="toLogin">Login</button>
                            <a href="<?= base_url('auth/forgotpassword') ?>"><small>Lupa Password?</small></a>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="scs_msg" data-msg="<?= $this->session->flashdata('message_scs') ?>"></div>
    <div id="err_msg" data-msg="<?= $this->session->flashdata('message_err') ?>"></div>

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
