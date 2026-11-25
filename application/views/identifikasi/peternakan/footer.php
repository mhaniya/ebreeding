<script src="/assets/js/list.js"></script>

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
        stateSave: true,
        ordering: true,
        ajax: {
            "url": "<?php echo base_url().'index.php/identifikasi/peternakan/get_data'?>",
            "type": "POST"
        },
        columns: [{
                "data": "idfarm",
                "orderable": false
            },
            {
                "data": "idfarm"
            },
            {
                "data": "namafarm"
            },
            {
                "data": "namapeternak"
            },
            {
                "data": "alamatfarm"
            },
            {
                "data": "namakecamatan"
            },
            {
                "data": "namakabupaten"
            },
            {
                "data": "namapropinsi"
            },
            {
                "data": "aksi",
                "orderable":false,
            },
        ],
        order: [
            [1, 'asc']
        ],
        columnDefs: [{
            targets: 5,
            render: function(data) {
                if (data == 0)
                    return "Tidak Aktif";
                else
                    return "Aktif";
            }
        }],
        rowCallback: function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
        },
        dom: 'Bfrtip',
        lengthMenu:[
            [10,25,50,-1],
            ['10 baris','25 baris','50 baris','semua baris'],
        ],
        buttons: [
            'pageLength', 'excel', 'pdf', 'print'
        ],
    });

    // tombol hapus
    $('#tbldata').on('click', '#hapusdata', function() {
        var id = $(this).data('id');
        $('#Modalhapus').modal('show');
        $('[name="id"]').val(id);
    });

    $('#kodepropinsi').on('change', function() {
        var kode = this.value;
        update_list("#kodekabupaten", "/wilayah/get_list_data_by_propinsi/" +
            kode, '0');
        resetsel("#kodekecamatan");
        resetsel("#idfarm");

        location.reload();
    });
    $('#kodekabupaten').on('change', function() {
        var kodepropinsi = $('#kodepropinsi').val();
        var kodekabupaten = this.value;
        update_list("#kodekecamatan", "/wilayah/get_list_data_by_kabupaten/" +
            kodepropinsi + "/" + kodekabupaten, '0');
        resetsel('#idfarm');

        location.reload();
    });
    $('#kodekecamatan').on('change', function() {
        var kodepropinsi = $('#kodepropinsi').val();
        var kodekabupaten = $('#kodekabupaten').val();
        var kodekecamatan = this.value;
        update_list("#idfarm", "/identifikasi/peternakan/get_list_data_by_kecamatan/" +
            kodepropinsi + "/" + kodekabupaten + "/" + kodekecamatan, '0');

        location.reload();
    });
});

$("#kotakUpload").click(function() {
    $("#file").click();
});

//memanggil fungsi untuk menangani file upload saat milih File
$('#file').on('change', fileUpload);

function fileUpload(event) {
    //memberitahu pengguna tentang status file upload
    toastr.waning(event.target.value + " mengupload...");

    //mendapatkan file yang dipilih
    files = event.target.files;

    //memeriksa data form 
    var data = new FormData();

    //file data is presented as an array
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        
        if (!file.type.match('application/vnd.ms-excel')) {
            //memeriksa format file
            toastr.waning("Silahkan pilih file excel.");
        } else if (file.size > 2097152) {
            //memeriksa ukuran file (dalam bytes)
            toastr.waning("Maaf, file Anda terlalu besar (melebihi 2 MB)");
        } else {
            //menambahkan file yang dapat diunggah ke objek FormData

            data.append('file', file, file.name);

            //membuat XMLHttpRequest baru
            var xhr = new XMLHttpRequest();

            //data file post yang untuk diupload
            xhr.open('POST', '/identifikasi/peternakan/upload', true);
            xhr.send(data);

            xhr.onload = function() {
                //mendapatkan respon dan menunjukkan status upload
                var response = JSON.parse(xhr.responseText);
                var statusresponse = response.status;
                var statusresponse = statusresponse.split('|');


                if (xhr.status === 200 && statusresponse[0] == 'ok') {
                    toastr.waning("File telah berhasil diupload. Klik untuk mengupload file lainnya");
                    $("#namafile").val(statusresponse[1]);
                    namafile=statusresponse[1];
                    
                    $.ajax({
                        type:"POST",
                        url:"/identifikasi/peternakan/import",
                        data:{namafile:namafile},
                        success:function(hasil){
                            location.reload();
                        }
                    })
                    // $('#kotakUpload').hide();
                } else if (response.status == 'type_err') {
                    toastr.waning("Silakan pilih file excel/csv");
                } else {
                    toastr.waning("Ada sedikit masalah, silakan coba lagi");
                }
            };
        }
    }
}
</script>
</body>

</html>