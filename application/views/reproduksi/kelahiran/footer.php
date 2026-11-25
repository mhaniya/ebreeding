<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolautosuggest.js"></script>
<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolfieldset.js"></script>
<script src="/assets/js/list.js"></script>
<script src="/assets/js/app.js"></script>
<script>
$(document).ready(function() {
    var importKelahiranCsrf = null;
    <?php if ($this->config->item('csrf_protection')) { ?>
    importKelahiranCsrf = {
        name: <?=json_encode($this->security->get_csrf_token_name()); ?>,
        hash: <?=json_encode($this->security->get_csrf_hash()); ?>
    };
    <?php } ?>
    $('#btnInfo').on('click', function() { $('#ModalinfoKelahiran').modal('show'); });
    $('#ModalinfoKelahiran .modal-body').css({'max-height': '65vh', 'overflow-y': 'auto'});
    $('#btnLaporanImportKelahiran').on('click', function() { $('#ModalLaporanImportKelahiran').modal('show'); });
    $('#kotakUpload').on('click', function() { $('#fileImportKelahiran').click(); });
    $('#fileImportKelahiran').on('change', function() {
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
        if (importKelahiranCsrf) { body.append(importKelahiranCsrf.name, importKelahiranCsrf.hash); }
        $('#kotakUpload').prop('disabled', true);
        toastr.info('Mengimport data kelahiran...');
        $.ajax({
            url: '/reproduksi/kelahiran/import',
            type: 'POST',
            data: body,
            processData: false,
            contentType: false,
            dataType: 'json'
        }).done(function(result) {
            if (result.csrf) { importKelahiranCsrf = result.csrf; }
            var box = $('#hasilImportKelahiran').empty().show();
            $('<p>').text('Import selesai: ' + result.success + ' baris berhasil, ' +
                result.errors.length + ' baris/pesan kesalahan; ' + result.calves + ' pedet baru.').appendTo(box);
            $.each(result.errors, function(_, message) {
                $('<div>').addClass('text-danger').text(message).appendTo(box);
            });
            $.each(result.warnings, function(_, message) {
                $('<div>').addClass('text-warning').text(message).appendTo(box);
            });
            $('#ModalLaporanImportKelahiran').modal('show');
            $('#tbldata').DataTable().ajax.reload(null, false);
        }).fail(function() {
            toastr.error('Import gagal. File tidak dapat diproses; muat ulang halaman lalu coba kembali.');
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
            "url": "/reproduksi/kelahiran/get_data",
            "type": "POST"
        },
        columns: [{
                "data": "idkelahiran",
                "orderable": false
            },
            {
                "data": "tanggal",
                "class": "text-center",
                // "render": function(data, display, row) {
                //     return data.substr(8, 2) + "-" + data.substr(5, 2) + "-" + data.substr(0,
                //         4);
                // }
            },
            {
                "data": "tagsapi"
            },
            {
                "data": "nomorregister",
                "class": "text-center"
            },
            {
                "data": "tanggalib",
                "class": "text-center"
            },
            {
                "data": "xlaktasi",
                "class": "text-center"
            },
            {
                "data": "statuslahir",
            },

            {
                "data": "tagsapianak",
                "class": "text-center"
            },
            {
                "data": "nomorregisteranak",
                "class": "text-center"
            },
            {
                "data": "jkelanak",
                "class": "text-center"
            },
            {
                "data": "keterangan",
                "class": "text-center"
            },
            {
                "data": "aksi"
            },
            // {"data": "editpass"}
        ],

        order: [
            [1, 'asc'],
            [2, 'asc'],
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
            url: "/reproduksi/kelahiran/get_data_by_idkelahiran/" + id,
            success: function(msg) {
                var data = JSON.parse(msg);
                $('#edtidkelahiran').val(id);
                $('#edttanggal').val(data['tanggal']);
                $('#edttagsapiInduk').val(data['tagsapi']);
                $('#edtnomorregisterInduk').val(data['nomorregister']);
                $('#edtidsapiInduk').val(data['idsapi']);
                $('#edtxlaktasi').val(data['xlaktasi']);
                $('#edtstatus_kelahiran').val(data['statuslahir']);
                $('#edtidsapiPedet').val(data['idsapipedet']);
                $('#edttagsapiPedet').val(data['tagsapipedet']);
                $('#edtjkelpedet').val(data['jkelpedet']);
                $('#edtbobotlahir').val(data['bobotlahirpedet']);
                $('#edtketerangan').val(data['keterangan']);
                $('#edtidpetugas').val(data['idpetugas']);
                $('#edtpetugas').val(data['namapetugas']);
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
    $("#tagsapiInduk").coolautosuggest({
        url: "/identifikasi/sapi/get_data_bytagsapi/",
        showDescription: true,
        width: 400,
        onSelected: function(result) {

            if (result != null) {
                $('#idsapiInduk').val(result.id);
                $('#nomorregisterInduk').val(result.description);
            } else {

            }
        }
    });
    $("#edttagsapiInduk").coolautosuggest({
        url: "/identifikasi/sapi/get_data_bytagsapi/",
        showDescription: true,
        width: 400,
        onSelected: function(result) {

            if (result != null) {
                $('#edtidsapiInduk').val(result.id);
                $('#edtnomorregisterInduk').val(result.description);
            } else {

            }
        }
    });
    $("#edttagsapiPedet").coolautosuggest({
        url: "/identifikasi/sapi/get_data_bytagsapi/",
        showDescription: true,
        width: 400,
        onSelected: function(result) {

            if (result != null) {
                $('#edtidsapiPedet').val(result.id);
                $('#edtjkelpedet').val(result.kelamin); 
            } else {

            }
        }
    });
    $("#petugas").coolautosuggest({
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

    $('#tagsapiInduk').on('change', function() {
        tagsapiInduk=$("#tagsapiInduk").val();
        $.ajax({
            type: "POST",
            url: "/identifikasi/sapi/get_numdata_bytagsapi",
            data: {"tagsapi": tagsapiInduk},
            success: function(msg) {
                $('#tagsapiPedet').val("");
                if(msg==0){
                    $('#nomorregisterInduk').val("");
                    $('#idsapiInduk').val("");
                    // $('#btnsimpan').prop('disabled',true);
                }else{
                    $.ajax({
                        type: "POST",
                        url: "/identifikasi/sapi/get_data_bytagsapiequal",
                        data: {"tagsapi": tagsapiInduk},
                        success: function(msg1) {
                            result=JSON.parse(msg1);
                            $('#idsapiInduk').val(result[0].id);
                            $('#nomorregisterInduk').val(result[0].description);
                        }
                    });
                }
            }
        })
    });

    $('#tagsapiPedet').on('change', function() {
        tagsapi = $('#tagsapiPedet').val();
        $.ajax({
            type: "POST",
            url: "/identifikasi/sapi/get_numdata_bytagsapi",
            data: {
                "tagsapi": tagsapi
            },
            success: function(msg) {
                // $('#btnsimpan').prop('disabled', (msg > 0));
                if (msg == 0) {
                    status=($("#idsapiInduk").val()==""); 
                    if(status=="true"){
                        // $('#btnsimpan').prop('disabled', true);
                    }
                    else{
                        // $('#btnsimpan').prop('disabled', false);
                    }
                }
            }
        })
    });
    
});
function cekstatus(){
    var status=$('#statuspedet').val();
    
    $('#bobotlahir2').prop('disabled',true);
    $('#tagsapiPedet2').prop('disabled',true);
    $('#jkelpedet2').prop('disabled',true);
    $('#jkelpedet2').val('');
    $('#pedet2').fadeOut();
     
    if(status=="Abortus"){
       $('#bobotlahir').prop('disabled',true);
       $('#tagsapiPedet').prop('disabled',true);
       $('#jkelpedet').prop('disabled',true);
       $('#jkelpedet').val('');
       $('#status_kelahiran').val('Abortus'); 
    }else if(status=="Kembar"){
        $('#pedet2').fadeIn();
        $('#bobotlahir2').prop('disabled',false);
        $('#tagsapiPedet2').prop('disabled',false);
        $('#jkelpedet2').prop('disabled',false);
        $('#jkelpedet2').val('');
        
        $('#bobotlahir').prop('disabled',false);
        $('#tagsapiPedet').prop('disabled',false);
        $('#jkelpedet').prop('disabled',false);
        $('#jkelpedet').val('');
        $('#status_kelahiran').val('Kembar');
       
    }else{
       $('#bobotlahir').prop('disabled',false);
       $('#tagsapiPedet').prop('disabled',false);
       $('#jkelpedet').prop('disabled',false);
       $('#status_kelahiran').val('Single');
    }
}
function cekstatus1(){
    var status=$('#status_kelahiran').val();
    $('#bobotlahir2').prop('disabled',true);
    $('#tagsapiPedet2').prop('disabled',true);
    $('#jkelpedet2').prop('disabled',true);
    $('#jkelpedet2').val('');
    $('#pedet2').fadeOut(); 
    if(status=="Abortus"){
       $('#bobotlahir').prop('disabled',true);
       $('#tagsapiPedet').prop('disabled',true);
       $('#jkelpedet').prop('disabled',true);
       $('#jkelpedet').val('');
    //    $('#status_kelahiran').val('Abortus'); 
    }else if(status=="kembar"){
        $('#pedet2').fadeIn();
        $('#bobotlahir2').prop('disabled',false);
        $('#tagsapiPedet2').prop('disabled',false);
        $('#jkelpedet2').prop('disabled',false);
        $('#jkelpedet2').val('');
        
        $('#bobotlahir').prop('disabled',false);
        $('#tagsapiPedet').prop('disabled',false);
        $('#jkelpedet').prop('disabled',false);
        $('#jkelpedet').val('');
        // $('#status_kelahiran').val('kembar');
       
    }else{
       $('#bobotlahir').prop('disabled',false);
       $('#tagsapiPedet').prop('disabled',false);
       $('#jkelpedet').prop('disabled',false);
    //    $('#status_kelahiran').val('single');
    }
}
</script>
</body>

</html>
