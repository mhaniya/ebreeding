<!-- DataTables -->


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
    var t = $("#tbldata").DataTable({
        dom: '<"top"if>rt<"bottom"p>',
       
        initComplete: function() {
            var api = this.api();
            $('#tbldata_filter input')
                .off('.DT')
                // melakukan proses ketika ada input otomatis
                .on('input.DT', function() {
                    api.search(this.value).draw();
                });
        },
        oLanguage: {
            sProcessing: "Sedang Mengambil Data"
        },
        processing: true,
        // stateSave: true,
        // serverSide: true,
        searching: true,
        ordering: true,
        ajax: {
            "url": "<?php echo base_url().'index.php/identifikasi/pengguna/get_data'?>",
            "type": "POST"
        },
        columns: [{
                "data": "user_id",
                "orderable": false
            },
            {"data": "user_nama"},
            {"data": "level_nama"},
            {"data": "user_username"},
            {"data": "namakoperasi"},
            {"data": "namafarm"},
            {"data": "user_aktif"},
            {
                "data": "aksi","class":"text-center"
            }, 
        ],
        columnDefs: [{
            targets: 6,
            render: function(data) {
                if (data == 0)
                    return "Tidak Aktif";
                else
                    return "Aktif";
            }
        }],
        order: [
            [2, 'desc'],
        ],
       
        rowCallback: function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
    });

    // tombol hapus
    $('#tbldata').on('click', '#hapusdata', function() {
        var id = $(this).data('id');
        $('#Modalhapus').modal('show');
        $('[name="id"]').val(id);
    });


});
</script>
</body>

</html>