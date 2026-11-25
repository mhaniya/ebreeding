<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolautosuggest.js"></script>
<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolfieldset.js"></script>
<script src="/assets/js/list.js"></script>
<script src="/assets/js/app.js"></script>
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
        stateSave: true,
        // serverSide: true,
        searching: true,
        ordering: true,
        ajax: {
            "url": "/reproduksi/et/get_data",
            "type": "POST"
        },
        columns: [{
                "data": "idtransfer",
                "orderable": false
            },
            {
                "data": "tanggal",
                "class": "text-center"
            },
            {
                "data": "tagsapirecipient",
                "class": "text-center"
            },
            {
                "data": "nomorregisterrecipient",
                "class": "text-center"
            },
            {
                "data": "tagsapidonor",
                "class": "text-center"
            },
            {
                "data": "nomorregisterdonor",
                "class": "text-center"
            },

            {
                "data": "keterangan",
                "class": "text-center"
            },
            {
                "data": "namapetugas",
                "class": "text-center"
            },
            {
                "data": "aksi"
            }, 
        ],

        order: [
            [0, 'desc'],
            [1, 'asc'],
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
            url: "/reproduksi/et/get_data_by_id/" + id,
            success: function(msg) {
                var data = JSON.parse(msg);
                $('#idtransfer').val(id);
                $('#edttanggal').val(data['tanggal']);
                $('#edttagsapi_r').val(data['tagsapirecipient']);
                $('#edtnomorregister_r').val(data['nomorregisterrecipient']);
                $('#edtidsapi_r').val(data['idsapirecipient']);
                $('#edttagsapi_d').val(data['tagsapidonor']);
                $('#edtnomorregister_d').val(data['nomorregisterdonor']);
                $('#edtidsapi_d').val(data['idsapidonor']);
                $('#edtnamapetugas').val(data['namapetugas']);
                $('#edtidpetugas').val(data['idpetugas']);
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
    $("#tagsapi_r").coolautosuggest({
        url: "/identifikasi/sapi/get_data_bytagsapi/",
        showDescription: true,
        width: 400,
        onSelected: function(result) {

            if (result != null) {
                $('#idsapi_r').val(result.id);
                $('#nomorregister_r').val(result.description);
            } else {

            }
        }
    });
    $("#tagsapi_d").coolautosuggest({
        url: "/identifikasi/sapi/get_data_bytagsapi/",
        showDescription: true,
        width: 400,
        onSelected: function(result) {
            if (result != null) {
                $('#idsapi_d').val(result.id);
                $('#nomorregister_d').val(result.description);
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
    $("#edttagsapi_r").coolautosuggest({
        url: "/identifikasi/sapi/get_data_bytagsapi/",
        showDescription: true,
        width: 400,
        onSelected: function(result) {

            if (result != null) {
                $('#edtidsapi_r').val(result.id);
                alert(result.id);
                $('#edtnomorregister_r').val(result.description);
            } else {

            }
        }
    });
    $("#edttagsapi_d").coolautosuggest({
        url: "/identifikasi/sapi/get_data_bytagsapi/",
        showDescription: true,
        width: 400,
        onSelected: function(result) {
            if (result != null) {
                $('#edtidsapi_d').val(result.id);
                alert(result.id);
                $('#edtnomorregister_d').val(result.description);
            } else {

            }
        }
    });

    $("#edtnamapetugas").coolautosuggest({
        url: "/identifikasi/petugas/get_data_bynama/",
        showDescription: true,
        width: 400,
        onSelected: function(result) {

            if (result != null) {
                $('#edtidpetugas').val(result.id);
            } else {

            }
        }
    });

});
</script>
</body>

</html>