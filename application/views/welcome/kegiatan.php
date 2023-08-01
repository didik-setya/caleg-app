<style>
  .detailimage {
    cursor: pointer;
  }
</style>
<h5><b>Kegiatan</b></h5>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

              <?php if($user->id_role == 2){ ?>
                <?php 
                  $check_penempatan_relawan = $this->m->check_penempatan_relawan();
                    if($check_penempatan_relawan > 0){
                      $action = '';
                    } else {
                      $action = 'disabled';
                    }
                ?>

                <button <?= $action ?> class="btn btn-sm btn-success" id="addData"><i class="fa fa-plus"></i> Tambah</button>
              <?php } ?>

                <div class="mt-3 table-responsive">
                  <?php if($user->id_role == 2){ ?>
                    <table class="table table-bordered w-100" id="load_kegiatan">
                      <thead>
                        <tr class="bg-dark text-white">
                          <th>#</th>
                          <th>Tanggal</th>
                          <th>Foto Kegiatan</th>
                          <th>Keterangan</th>
                          <th>Lokasi</th>
                          <th>Jumlah Peserta</th>
                          <th><i class="fa fa-cogs"></i></th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  <?php } else { ?>
                    <table class="table table-bordered w-100" id="load_kegiatan">
                      <thead>
                        <tr class="bg-dark text-white">
                          <th>#</th>
                          <th>Tanggal</th>
                          <th>Foto Kegiatan</th>
                          <th>Keterangan</th>
                          <th>Lokasi</th>
                          <th>Jumlah Peserta</th>
                          <th>Nama Relawan</th>
                          <th><i class="fa fa-cogs"></i></th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  <?php } ?>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Tambah kegiatan Baru</h5>
      </div>
      <form action="<?= base_url('welcome/add_kegiatan') ?>" enctype="multipart/form-data" method="post" id="formAddKegiatan">
      <div class="modal-body">

      <div class="form-group">
        <label>Tanggal Kegiatan</label>
        <input type="date" name="tgl" id="tgl" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Keterangan</label>
        <input type="text" name="ket" id="ket" class="form-control">
        <small class="text-danger" id="err_ket"></small>
      </div>

      <div class="form-group">
        <label>Tempat</label>
        <textarea name="loc" id="loc" cols="30" rows="5" class="form-control"></textarea>
        <small class="text-danger" id="err_loc"></small>
      </div>

      <div class="form-group">
        <label>Jumlah Peserta</label>
        <input type="number" name="jml" id="jml" class="form-control">
        <small class="text-danger" id="err_jml"></small>
      </div>

       <div class="form-group">
        <label>Foto</label>
        <input type="file" class="form-control" name="foto[]" id="foto" multiple="multiple" accept="image/*" required>
       </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="toAdd">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalAllFoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Foto Kegiatan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="loadListPhoto">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <?php if($user->id_role == 2){ ?>
          <button type="button" class="btn btn-primary" id="toAddNewPhoto"><i class="fa fa-plus"></i> Tambah</button>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="loadFoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      
      <div class="modal-body" >
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <img src="" id="showImageSelected" alt="foto" class="w-100">
      </div>
      
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addNewPhoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-light">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Foto Baru</h5>
      </div>
      <form action="<?= base_url('welcome/add_new_photo_kegiatan'); ?>" method="post" id="add_new_photo" enctype="multipart/form-data">
      <div class="modal-body">
        <input type="hidden" name="kegiatan" id="kegiatan_id">
        <div class="form-group">
          <label>Pilih Foto</label>
          <input type="file" name="foto[]" id="foto_add" class="form-control" required multiple="multiple" accept="image/*">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="toSaveNewPhoto">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalEditData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Edit Data kegiatan</h5>
      </div>
      <form action="<?= base_url('welcome/edit_kegiatan') ?>" method="post" id="formEditData">
      <div class="modal-body">
      <input type="hidden" name="kegiatan" id="id_kegiatan_edit">
      <div class="form-group">
        <label>Tanggal Kegiatan</label>
        <input type="date" name="tgl" id="tgl_edit" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Keterangan</label>
        <input type="text" name="ket" id="ket_edit" class="form-control">
        <small class="text-danger" id="err_ket_edit"></small>
      </div>

      <div class="form-group">
        <label>Tempat</label>
        <textarea name="loc" id="loc_edit" cols="30" rows="5" class="form-control"></textarea>
        <small class="text-danger" id="err_loc_edit"></small>
      </div>

      <div class="form-group">
        <label>Jumlah Peserta</label>
        <input type="number" name="jml" id="jml_edit" class="form-control">
        <small class="text-danger" id="err_jml_edit"></small>
      </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="toEdit">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>

    $(document).ready(function(){
      // load_data_kegiatan();
      load_datatable();
    });

    $('#addData').click(function(){
        $('#modalAdd').modal('show');
        $('#tgl').val('');
        $('#ket').val('');
        $('#loc').val('');
        $('#jml').val('');
        $('#foto').val('');

        $('#err_ket').html('');
        $('#err_jml').html('');
        $('#err_loc').html('');
    });

    $('#formAddKegiatan').submit(function(e){
      e.preventDefault();
      $('#toAdd').attr('disabled', true);

      $.ajax({
        url: $(this).attr('action'),
        data: new FormData(this),
        type: 'POST',
        dataType: 'JSON',
        contentType: false,
        processData: false,
        success: function(d){
          reload_data_member();
          $('#toAdd').removeAttr('disabled');
          if(d.type == 'validation'){
            if(d.err_ket == ''){
              $('#err_ket').html('');
            } else {
              $('#err_ket').html(d.err_ket);
            }

            if(d.err_loc == ''){
              $('#err_loc').html('');
            } else {
              $('#err_loc').html(d.err_loc);
            }

            if(d.err_jml == ''){
              $('#err_jml').html('');
            } else {
              $('#err_jml').html(d.err_jml);
            }
          } else if(d.type == 'result'){
            $('#modalAdd').modal('hide');
            if(d.status == true){
              toastr["success"](d.msg, "Success");
            } else {
              toastr["error"](d.msg, "Error");
            }
          }
        },
        error: function(xhr){
          $('#toAdd').removeAttr('disabled');
          $('#modalAdd').modal('hide');
                    if(xhr.status === 0){
                        toastr["error"]("No internet access", "Error");
                    } else if(xhr.status == 404){
                        toastr["error"]("Page not found", "Error");
                    } else if(xhr.status == 500){
                        toastr["error"]("Internal server error", "Error");
                    } else {
                        toastr["error"]("Unknow error", "Error");
                    }
        }
        
      });

    });

    $(document).on('click', '.view_photo', function(){
      let id = $(this).data('id');
      let kegiatan = $(this).data('kegiatan');

      const loading_animation = '<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';

      $('#loadListPhoto').html(loading_animation);
      $('#modalAllFoto').modal('show');
      $('#toAddNewPhoto').data('id', kegiatan);

      $.ajax({
        url: '<?= base_url('ajax/load_list_foto_kegiatan'); ?>',
        data: {id: id},
        type: 'POST',
        success: function(d){
          $('#loadListPhoto').html(d);
        },
        error: function(xhr){
               
               if(xhr.status === 0){
                   toastr["error"]("No internet access", "Error");
               } else if(xhr.status == 404){
                   toastr["error"]("Page not found", "Error");
               } else if(xhr.status == 500){
                   toastr["error"]("Internal server error", "Error");
               } else {
                   toastr["error"]("Unknow error", "Error");
               }
       }
      });

    });

    $(document).on('click', '.detailimage', function(){
      let link = $(this).attr('src');
      $('#showImageSelected').attr('src', link);
      $('#loadFoto').modal('show');
    });

    $(document).on('click', '.delete-Photo', function(){
      let id = $(this).data('id');
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Untuk menghapus foto ini",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '<?= base_url('welcome/delete_photo_kegiatan') ?>',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
              $('#modalAllFoto').modal('hide');
              if(d.success == true){
                toastr["success"](d.msg, "Success");
              } else {
                toastr["error"](d.msg, "Error");
              }
            },
            error: function(xhr){
               
               if(xhr.status === 0){
                   toastr["error"]("No internet access", "Error");
               } else if(xhr.status == 404){
                   toastr["error"]("Page not found", "Error");
               } else if(xhr.status == 500){
                   toastr["error"]("Internal server error", "Error");
               } else {
                   toastr["error"]("Unknow error", "Error");
               }
            }
          });
        }
      })
    });

    $('#toAddNewPhoto').click(function(){
      $('#modalAllFoto').modal('hide');
      let id = $(this).data('id');
      $('#kegiatan_id').val(id);
      $('#addNewPhoto').modal('show');
      $('#foto_add').val('');
    });

    $('#add_new_photo').submit(function(e){
      e.preventDefault();
      $('#toSaveNewPhoto').attr('disabled', true);

      $.ajax({
        url: $(this).attr('action'),
        data: new FormData(this),
        type: 'POST',
        dataType: 'JSON',
        contentType: false,
        processData: false,
        success: function(d){
          $('#toSaveNewPhoto').removeAttr('disabled');
          $('#addNewPhoto').modal('hide');

          if(d.status == true){
            toastr["success"](d.msg, "Success");
          } else {
            toastr["error"](d.msg, "Error");
          }

        },
        error: function(xhr){
          $('#toSaveNewPhoto').removeAttr('disabled');
          $('#addNewPhoto').modal('hide');
                    if(xhr.status === 0){
                        toastr["error"]("No internet access", "Error");
                    } else if(xhr.status == 404){
                        toastr["error"]("Page not found", "Error");
                    } else if(xhr.status == 500){
                        toastr["error"]("Internal server error", "Error");
                    } else {
                        toastr["error"]("Unknow error", "Error");
                    }
        }
      });

    });

    $(document).on('click', '.edit_data', function(){
      let id = $(this).data('id');
      $('#id_kegiatan_edit').val(id);

      $('#tgl_edit').val('');
      $('#ket_edit').val('');
      $('#loc_edit').val('');
      $('#jml_edit').val('');
      $('#err_ket_edit').html('');
      $('#err_jml_edit').html('');
      $('#err_loc_edit').html('');

      $.ajax({
        url: '<?= base_url('welcome/get_data_kegiatan_row') ?>',
        data: {id: id},
        type: 'POST',
        dataType: 'JSON',
        success: function(d){
          $('#tgl_edit').val(d.tgl);
          $('#ket_edit').val(d.keterangan);
          $('#loc_edit').val(d.tempat);
          $('#jml_edit').val(d.jml_peserta);
        },
        error: function(xhr){
               
               if(xhr.status === 0){
                   toastr["error"]("No internet access", "Error");
               } else if(xhr.status == 404){
                   toastr["error"]("Page not found", "Error");
               } else if(xhr.status == 500){
                   toastr["error"]("Internal server error", "Error");
               } else {
                   toastr["error"]("Unknow error", "Error");
               }
       }
      });
      $('#modalEditData').modal('show');
    });

    $('#formEditData').submit(function(e){
      e.preventDefault();
      $('#toEdit').attr('disabled', true);

      $.ajax({
        url: $(this).attr('action'),
        data: $(this).serialize(),
        type: 'POST',
        dataType: 'JSON',
        success: function(d){
          reload_data_member();
          $('#toAdd').removeAttr('disabled');
          if(d.type == 'validation'){
            if(d.err_ket == ''){
              $('#err_ket_edit').html('');
            } else {
              $('#err_ket_edit').html(d.err_ket);
            }

            if(d.err_loc == ''){
              $('#err_loc_edit').html('');
            } else {
              $('#err_loc_edit').html(d.err_loc);
            }

            if(d.err_jml == ''){
              $('#err_jml_edit').html('');
            } else {
              $('#err_jml_edit').html(d.err_jml);
            }
          } else if(d.type == 'result'){
            $('#modalEditData').modal('hide');
            if(d.status == true){
              toastr["success"](d.msg, "Success");
            } else {
              toastr["error"](d.msg, "Error");
            }
          }
        },
        error: function(xhr){
          $('#toEdit').removeAttr('disabled');
          $('#modalEditData').modal('hide');
                    if(xhr.status === 0){
                        toastr["error"]("No internet access", "Error");
                    } else if(xhr.status == 404){
                        toastr["error"]("Page not found", "Error");
                    } else if(xhr.status == 500){
                        toastr["error"]("Internal server error", "Error");
                    } else {
                        toastr["error"]("Unknow error", "Error");
                    }
        }
        
      });
    });

    $(document).on('click', '.delete_data', function(){
      let id = $(this).data('id');
        Swal.fire({
          title: 'Apakah anda yakin?',
          text: "Untuk menghapus data ini",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '<?= base_url('welcome/delete_data_kegiatan') ?>',
              data: {id: id},
              type: 'POST',
              dataType: 'JSON',
              success: function(d){
                reload_data_member();
                if(d.success == true){
                  toastr["success"](d.msg, "Success");
                } else {
                  toastr["error"](d.msg, "Error");
                }
              },
              error: function(xhr){
                reload_data_member();
                if(xhr.status === 0){
                    toastr["error"]("No internet access", "Error");
                } else if(xhr.status == 404){
                    toastr["error"]("Page not found", "Error");
                } else if(xhr.status == 500){
                    toastr["error"]("Internal server error", "Error");
                } else {
                    toastr["error"]("Unknow error", "Error");
                }
              }
            });
          }
        })
    });

    // function load_data_kegiatan(){
    //   const loading_animation = '<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
    //     $('#load_data_kegiatan').html(loading_animation);

    //     $.ajax({
    //         url: '<?= base_url('ajax/load_data_kegiatan'); ?>',
    //         type: 'POST',
    //         success: function(d){
    //             $('#load_data_kegiatan').html(d);
    //         },
    //         error: function(xhr){
               
    //                 if(xhr.status === 0){
    //                     toastr["error"]("No internet access", "Error");
    //                 } else if(xhr.status == 404){
    //                     toastr["error"]("Page not found", "Error");
    //                 } else if(xhr.status == 500){
    //                     toastr["error"]("Internal server error", "Error");
    //                 } else {
    //                     toastr["error"]("Unknow error", "Error");
    //                 }
    //         }
    //     });
    // }

    function reload_data_member(){
        $('#load_kegiatan').DataTable().destroy();
        load_datatable();
    }

    function load_datatable(){
      let datatable = $('#load_kegiatan').dataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('ajax/get_datatable_kegiatan')?>",
                "type": "POST"
            },
            "columnDefs": [
                { 
                    "targets": [ 0 ], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
            "iDisplayLength": 10,
            "ordering": false,
        });
    }
</script>

