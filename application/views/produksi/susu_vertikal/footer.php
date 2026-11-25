<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolautosuggest.js"></script>
<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolfieldset.js"></script>
<script src="/assets/js/list.js"></script>
<script src="/assets/js/app.js"></script>
<script>
$(document).ready(function() {
    $('#btnLaporanImportSusu').on('click', function() {
        $('#ModalLaporanImportSusu').modal('show');
    });
    if ($('#ModalLaporanImportSusu').attr('data-auto-show') === '1') {
        $('#ModalLaporanImportSusu').modal('show');
    }
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
        serverSide: true,
        searching: true,
        ordering: false,
        ajax: {
            "url": "/produksi/susu_vertikal/get_data",
            "type": "POST"
        },
        columns: [{
                "data": "idpengukuran",
                "orderable": false
            },
            {
                "data": "tanggal",
                "class": "text-center",
                // "render": function(data, display, row) {
                //     var tgl = data.split('-');
                //     var tanggal = tgl[2] + "-" + tgl[1] + "-" + tgl[0];
                //     return tanggal;
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
                "data": "kandang",
                "defaultContent": "",
                "render": $.fn.dataTable.render.text()
            },
            {
                "data": "pagi",
                "class": "text-right"
            },
            {
                "data": "sore",
                "class": "text-right"
            },
            {
                "data": "jumlah",
                "class": "text-right"
            },
            {
                "data": "xlaktasi",
                "class": "text-center"
            },
            {
                "data": "tglberanak",
                "class": "text-center",
                "searchable": false
            },
            {
                "data": "aksi"
            },
        ],
        order: [
            [1, 'desc'],
            [8, 'desc'],
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
            url: "/produksi/susu_vertikal/get_data_by_idpengukuran/" + id,
            success: function(msg) {
                var data = JSON.parse(msg);
                $('#edtidpengukuran').val(id);
                $('#edttanggal').val(data['tanggal']);
                $('#edttagsapi').val(data['tagsapi']);
                $('#edtnomorregister').val(data['nomorregister']);
                $('#edtidsapi').val(data['idsapi']);
                $('#edtkandang').val(data['kandang'] || '');
                $('#edtpagi').val(data['pagi']);
                $('#edtsore').val(data['sore']);
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
});
$("#kotakUploadPerTanggal").click(function() {
    $("#filePerTanggal").click();
});
$("#kotakUploadPerBulan").click(function() {
    $("#filePerBulan").click();
});

//memanggil fungsi untuk menangani file upload saat milih File
$('#filePerTanggal').on('change', fileUploadPerTanggal);
$('#filePerBulan').on('change', fileUploadPerBulan);

function fileUploadPerTanggal(event) {
    //memberitahu pengguna tentang status file upload

    //mendapatkan file yang dipilih
    var files = event.target.files;

    //memeriksa data form 
    var data = new FormData();

    //file data is presented as an array
    for (var i = 0; i < files.length; i++) {
        var file = files[i];

        if (!/\.(xlsx|xls|csv)$/i.test(file.name)) {
            //memeriksa format file
            toastr.warning("Pilih file .xlsx, .xls, atau .csv.");
        } else if (file.size > 2097152) {
            //memeriksa ukuran file (dalam bytes)
            toastr.warning("Maaf, file Anda terlalu besar (melebihi 2 MB)");
        } else {
            //menambahkan file yang dapat diunggah ke objek FormData

            toastr.info(file.name + " mengupload...");
            data.append('file', file, file.name);

            //membuat XMLHttpRequest baru
            var xhr = new XMLHttpRequest();

            //data file post yang untuk diupload
            xhr.open('POST', '/produksi/susu_vertikal/upload/per_tanggal', true);
            xhr.send(data);

            xhr.onload = function() {
                //mendapatkan respon dan menunjukkan status upload
                var response = JSON.parse(xhr.responseText);
                var statusresponse = response.status;
                var statusresponse = statusresponse.split('|');


                if (xhr.status === 200 && statusresponse[0] == 'ok') {
                    toastr.success("File telah berhasil diupload. Klik untuk mengupload file lainnya");
                    $("#namafile").val(statusresponse[1]);
                    namafile = statusresponse[1];

                    $.ajax({
                        type: "POST",
                        url: "/produksi/susu_vertikal/import/per_tanggal",
                        data: {
                            namafile: namafile
                        },
                        success: function(hasil) {
                            location.reload();
                        }
                    })
                    // $('#kotakUpload').hide();
                } else if (response.status == 'type_err') {
                    toastr.warning("Pilih file .xlsx, .xls, atau .csv.");
                } else {
                    toastr.warning("Ada sedikit masalah, silakan coba lagi");
                }
            };
        }
    }
}

function pilihtanggal() {
    var tanggal = $('#tanggal').val();
    $.ajax({
        type: "POST",
        url: "/identifikasi/sapi/pilihtanggal",
        data: {
            tanggal: tanggal
        },
    }).done(function(result) {
        location.reload();
    })
}

$('#chktanggal').on('change', function() {
    var chktanggal = $('#chktanggal').prop('checked');
    
    $.ajax({
        type: "POST",
        url: "/identifikasi/sapi/pilihchktanggal",
        data: {
            chktanggal: chktanggal
        },
    }).done(function(result) {
        location.reload();
    })
});

function fileUploadPerBulan(event) {
    //memberitahu pengguna tentang status file upload

    //mendapatkan file yang dipilih
    var files = event.target.files;

    //memeriksa data form 
    var data = new FormData();

    //file data is presented as an array
    for (var i = 0; i < files.length; i++) {
        var file = files[i];

        if (!/\.(xlsx|xls|csv)$/i.test(file.name)) {
            //memeriksa format file
            toastr.warning("Pilih file .xlsx, .xls, atau .csv.");
        } else if (file.size > 2097152) {
            //memeriksa ukuran file (dalam bytes)
            toastr.warning("Maaf, file Anda terlalu besar (melebihi 2 MB)");
        } else {
            //menambahkan file yang dapat diunggah ke objek FormData

            toastr.info(file.name + " mengupload...");
            data.append('file', file, file.name);

            //membuat XMLHttpRequest baru
            var xhr = new XMLHttpRequest();

            //data file post yang untuk diupload
            xhr.open('POST', '/produksi/susu_vertikal/upload/per_bulan', true);
            xhr.send(data);

            xhr.onload = function() {
                //mendapatkan respon dan menunjukkan status upload
                var response = JSON.parse(xhr.responseText);
                var statusresponse = response.status;
                var statusresponse = statusresponse.split('|');


                if (xhr.status === 200 && statusresponse[0] == 'ok') {
                    toastr.success("File telah berhasil diupload. Klik untuk mengupload file lainnya");
                    $("#namafile").val(statusresponse[1]);
                    namafile = statusresponse[1];

                    $.ajax({
                        type: "POST",
                        url: "/produksi/susu_vertikal/import/per_bulan",
                        data: {
                            namafile: namafile
                        },
                        success: function(hasil) {
                            location.reload();
                        }
                    })
                    // $('#kotakUpload').hide();
                } else if (response.status == 'type_err') {
                    toastr.warning("Pilih file .xlsx, .xls, atau .csv.");
                } else {
                    toastr.warning("Ada sedikit masalah, silakan coba lagi");
                }
            };
        }
    }
}
function setTwoNumberDecimal(event) {
    this.value = parseFloat(this.value).toFixed(1);
}
</script>
</body>

</html>
