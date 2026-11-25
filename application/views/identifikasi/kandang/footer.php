 <script>
$(document).ready(function() {
    $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
        return {
            "iStart": oSettings._iDisplayStart,
            "iEnd": oSettings.fnDisplayEnd(),
            "iLength": oSettings._iDisplayLength,
            "iTotal": oSettings.fnRecordsTotal(),
            "iFilteredTotal": oSettings.fnRecordsDisplay(),
            "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
            "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
        };
    };
    var t = $('#tblkandang').DataTable({
        "processing": true,
        "stateSave": true,
        "serverSide": true,
        "stateSave": true,
        "ajax": "<?php echo site_url('identifikasi/kandang/ajax_tabel'); ?>",
        "columns": [

            {
                "data": null,
                "class": "text-center",
                "orderable": false
            },
            {
                "data": "namapropinsi"
            },
            {
                "data": "namakabupaten"
            },
            {
                "data": "namakecamatan"
            },
            {
                "data": "namafarm"
            },
            {
                "data": "namakandang"
            },
            {
                "data": "lokasikandang"
            },
            {
                "data": "kapasitas"
            },
            {
                "data": "aksi",
                "class": "text-center"
            }

        ],
        "order": [
            [3, 'desc'],
            [1, 'asc']
        ],
        "rowCallback": function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);

            $('td:eq(0)', row).html(index);
        },
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'excel', 'pdf', 'print'
        ]
    });
    $(".preloader").fadeOut();

    <?php
          $info=$this->session->flashdata('info');
          
          if($info<>""){
            echo "alert('$info');";
          }
      ?>


    $('#tblkandang').on('click', '#hapusdata', function() {
        var id = $(this).data('id');
        $('#Modalhapus').modal('show');
        $('[name="id"]').val(id);
    });

});
 </script>
 </body>

 </html>