<footer class="main-footer">
    <strong>Copyright &copy; BBPTUHPT Baturraden</strong>
    All rights reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/assets/template/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/assets/template/adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="/assets/template/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="/assets/template/adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="/assets/template/adminlte/plugins/toastr/toastr.min.js"></script>
<!-- ChartJS -->
<script src="/assets/template/adminlte/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="/assets/template/adminlte/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="/assets/template/adminlte/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="/assets/template/adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="/assets/template/adminlte/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/assets/template/adminlte/plugins/moment/moment.min.js"></script>
<script src="/assets/template/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/assets/template/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="/assets/template/adminlte/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="/assets/template/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets/template/adminlte/dist/js/adminlte.js"></script>
<script src="/assets/js/autosuggest/jquery.coolautosuggest.js"></script>
<script src="/assets/js/autosuggest/jquery.coolfieldset.js"></script>

<script src="/assets/template/adminlte/plugins/datatables/jquery.dataTables.js"></script>
<script src="/assets/template/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script type="text/javascript" language="javascript" src="/assets/template/adminlte/plugins/datatables-buttons/js/add/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="/assets/template/adminlte/plugins/datatables-buttons/js/add/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="/assets/template/adminlte/plugins/datatables-buttons/js/add/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="/assets/template/adminlte/plugins/datatables-buttons/js/add/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="/assets/template/adminlte/plugins/datatables-buttons/js/add/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="/assets/template/adminlte/plugins/datatables-buttons/js/add/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="/assets/template/adminlte/plugins/datatables-buttons/js/add/buttons.print.min.js"></script>

<script>
$(function() {
    
   
    
    <?php 
        $status_info=$this->session->flashdata('status_info');
    ?>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    <?php if($this->session->flashdata('status_insert')=="success"){ ?>
    toastr.success('Data berhasil ditambahkan.')
    <?php }else
		if($this->session->flashdata('status_update')=="success"){ ?>
    Toast.fire({
        type: 'success',
        title: 'Data berhasil diperbarui'
    })
    <?php }else
		if($this->session->flashdata('status_delete')=="success"){ ?>
            toastr.success('Data berhasil dihapus.')
    <?php }else
		if($status_info<>""){ ?>
            toastr.success("<?php echo $status_info;?>");
    <?php } ?>

    $('#btnInfo').on('click',function(){
        $('#Modalinfo').modal('show');
    })
});
</script>