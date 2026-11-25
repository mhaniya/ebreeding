<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolautosuggest.js"></script>
<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolfieldset.js"></script>
<script src="/assets/js/list.js"></script>
<script src="/assets/js/app.js"></script>
<script>
$(document).ready(function() {
    var importKeswanCsrf = null;
    <?php if ($this->config->item('csrf_protection')) { ?>
    importKeswanCsrf = {
        name: <?=json_encode($this->security->get_csrf_token_name()); ?>,
        hash: <?=json_encode($this->security->get_csrf_hash()); ?>
    };
    <?php } ?>
    $('#btnInfo').on('click', function() { $('#ModalinfoKeswan').modal('show'); });
    $('#ModalinfoKeswan .modal-body').css({'max-height': '65vh', 'overflow-y': 'auto'});
    $('#btnLaporanImportKeswan').on('click', function() { $('#ModalLaporanImportKeswan').modal('show'); });
    $('#kotakUpload').on('click', function() { $('#fileImportKeswan').click(); });
    $('#fileImportKeswan').on('change', function() {
        var input = this;
        var file = input.files[0];
        if (!file) { return; }
        if (!/\.(xlsx|xls|csv)$/i.test(file.name) || file.size === 0 || file.size > 2097152) {
            toastr.warning('Pilih file .xlsx, .xls, atau .csv, maksimal 2 MB.');
            input.value = '';
            return;
        }
        var body = new FormData();
        body.append('file', file);
        if (importKeswanCsrf) { body.append(importKeswanCsrf.name, importKeswanCsrf.hash); }
        $('#kotakUpload').prop('disabled', true);
        toastr.info('Mengimport pemeriksaan keswan...');
        $.ajax({
            url: <?=json_encode(site_url('kesehatan/pemeriksaan_keswan/import')); ?>,
            type: 'POST', data: body, processData: false, contentType: false, dataType: 'json'
        }).done(function(result) {
            if (result.csrf) { importKeswanCsrf = result.csrf; }
            var box = $('#hasilImportKeswan').empty().show();
            $('<p>').text('Import selesai: ' + result.success + ' baris tersimpan, ' +
                result.skipped + ' baris identik dilewati, ' + result.errors.length + ' pesan kesalahan.').appendTo(box);
            $.each(result.errors, function(_, message) {
                $('<div>').addClass('text-danger').text(message).appendTo(box);
            });
            $.each(result.warnings, function(_, message) {
                $('<div>').addClass('text-warning').text(message).appendTo(box);
            });
            $('#ModalLaporanImportKeswan').modal('show');
            $('#tbldata').DataTable().ajax.reload(null, false);
        }).fail(function() {
            toastr.error('Import gagal. Muat ulang halaman lalu periksa file dan coba kembali.');
        }).always(function() {
            $('#kotakUpload').prop('disabled', false);
            input.value = '';
        });
    });

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
    var t = $("#tbldata").dataTable({
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
            "url": "/kesehatan/pemeriksaan_keswan/get_data",
            "type": "POST"
        },
        columns: [{
                "data": "idpemeriksaan",
                "orderable": false
            },
            {
                "data": "tanggal",
                "class": "text-center",
                "render": function(data, display, row) {
                    return data.substr(0, 10) 
                }
            },
            {
                "data": "tagsapi",
                "class": "text-center"
            },
            {
                "data": "nomorregister",
                "class": "text-center"
            },
            {
                "data": "diagnosa", render: $.fn.dataTable.render.text()
            },
            {
                "data": "pengobatan", render: $.fn.dataTable.render.text()
            },
            {
                "data": "namapetugas", render: $.fn.dataTable.render.text()
            },
            {
                "data": "keterangan"
            },
            {
                "data": "aksi"
            },
        ],

        order: [
            [1, 'desc'],
        ],
        rowCallback: function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
        },
        dom: 'Bfrtip',
        responsive: true,
        lengthMenu:[
            [10,20,25,50,-1],
            ["10 baris","20 baris","25 baris","50 baris","Semua Baris"],
        ],
        buttons: [
            'pageLength', 'excel', 'pdf', 'print'
        ], 
    });

    $('#tbldata').on('click', '#editdata', function() {
        var id = $(this).data('id');
        $.ajax({
            type: "GET",
            url: "/kesehatan/pemeriksaan_keswan/get_data_by_id/" + id,
            success: function(msg) {
                var data = JSON.parse(msg);
                $('#edtidpemeriksaan').val(id);
                tgl=data['tanggal'];
                tanggal=tgl.substr(0,10);
                $('#edttanggal').val(tanggal);
                $('#edttagsapi').val(data['tagsapi']); 
                $('#edtnomorregister').val(data['nomorregister']);
                $('#edtidsapi').val(data['idsapi']);
                $('#edtdiagnosa').val(data['diagnosa']); 
                $('#edtpengobatan').val(data['pengobatan']);
                $('#edtidpetugas').val(data['idpetugas']);
                $('#edtnamapetugas').val(data['namapetugas']);
                $('#edtketerangan').val(data['keterangan']);
            }
        })
        $('#Modaledit').modal('show');
    });
    $('#tbldata').on('click', '#hapusdata', function() {
        var id = $(this).data('id');
        $('#Modalhapus').modal('show');
        $('[name="id"]').val(id);
    });
    $('#tambahdata').on('click', function() {
        $('#Modaltambah').modal('show');
    });

    $('#frmtambah').submit(function(e) {
        let tagsapi = $('#tagsapi').val();
        let idsapi = $('#idsapi').val();

        if (tagsapi.trim() == "") {
            $('#tagsapierr').html('Tag Sapi harus diisi');
            e.preventDefault();
        } else
        if (idsapi.trim() == "") {
            $('#tagsapierr').html('Tag Sapi tidak terdaftar');
            e.preventDefault();
        }
    });
    $("#tagsapi").coolautosuggest({
        url: "/identifikasi/sapi/get_data_bytagsapi/",
        showDescription: true,
        width: 400,
        onSelected: function(result) {

            if (result != null) {
                $('#idsapi').val(result.id);
                $('#nomorregister').val(result.description);
            } else {

            }
        }
    });
    $("#namapetugas").coolautosuggest({
        url: "/identifikasi/petugas/get_data_bynama/",
        showDescription: true,
        width: 400,
        onSelected: function(result) {

            if (result != null) {
                $('#idpetugas').val(result.id);
            } else {

            }
        }
    });
});
</script>
</body>

</html>
