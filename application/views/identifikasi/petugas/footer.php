 
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
    var t = $("#tblpetugas").dataTable({
        dom: '<"top"if>rt<"bottom"p>',
        initComplete: function() {
            var api = this.api();
            $('#tblpetugas_filter input')
                .off('.DT')
                // melakukan proses ketika ada input otomatis
                .on('input.DT', function() {
                    api.search(this.value).draw();
                });
        },
        oLanguage: {
            sProcessing: "Sedang Mengambil Data"
        },
        stateSave: true,
        processing: true,
        serverSide: true,
        searching: true,
        orderable: false,
        ajax: {
            "url": "/identifikasi/petugas/get_data",
            "type": "POST"
        },
        columns: [{
                "data": "idpetugas",
                "orderable": false
            },
            {
                "data": "nama"
            },
            {
                "data": "jabatan"
            },
            {
                "data": "nip"
            },
            {
                "data": "aksi"
            },
            // {"data": "hapus"},
            // {"data": "editpass"}
        ],

        order: [
            [1, 'asc']
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

    $('#tblpetugas').on('click', '#editdata', function() {
        var id = $(this).data('id');
        $.ajax({
            type:"GET",
            url:"/identifikasi/petugas/get_by_idpetugas/"+id,
            success:function(msg){
                var data=JSON.parse(msg);
                $('#idpetugas').val(id); 
                $('#edtnama').val(data['nama']);
                $('#edtjabatan').val(data['jabatan']);
                $('#edtnip').val(data['nip']);
            }
        })
        $('#Modaledit').modal('show');
    });
    $('#tblpetugas').on('click', '#hapusdata', function() {
        var id = $(this).data('id');
        $('#Modalhapus').modal('show');
        $('[name="id"]').val(id);
    });
    $('#tambahdata').on('click', function() {
        $('#Modaltambah').modal('show');
    });

    
});
</script>
</body>

</html>