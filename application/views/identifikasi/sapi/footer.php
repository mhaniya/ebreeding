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
    var t = $('#tbldata').DataTable({
        "processing": true,
        "serverSide": true,
        "stateSave": true,
        "ajax": "<?php echo site_url('identifikasi/sapi/ajax_tabel'); ?>",
        "columns": [

            {
                "data": null,
                "class": "text-center",
                "orderable": false
            },
            {
                "data": "nomorregister",
                "class": "text-center"
            },
            {
                "data": "tagsapi",
                "class": "text-center"
            },
            {
                "data": "kelamin",
                "class": "text-center"
            },
            {
                "data": "tgllahir",
                "class": "text-center"
            },
            {
                "data": "bobotlahir",
                "class": "text-center"
            },
            {
                "data": "balai_uzur"
            },
            {
                "data": "status_asal"
            },
            {
                "data": "status_bunting"
            },
            {
                "data": "status_laktasi"
            },
            {
                "data": "namafarm"
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
        lengthMenu:[
            [10,25,50,-1],
            ['10 baris','25 baris','50 baris','semua baris'],
        ],
        buttons: [
            'pageLength', 'excel', 'pdf', 'print'
        ],
        // createdRow: function(row, data, dataIndex, cells) {
        //   a = data["tgl_lahir"].split("-");
        //   n = a.length;
        //   if ((data["nipd"] === "") ||
        //     (data["nm_pd"] === "") ||
        //     (data["jk"] === "") ||
        //     (data["nm_ibu_kandung"] === "") ||
        //     (data["id_agama"] === "") ||
        //     ((data["nik"] != null) && (data["nik"].length < 16)) ||
        //     !(data["ds_kel"]) ||
        //     (data["ds_kel"] === "") ||
        //     (data["id_wil"] === "") ||
        //     (data["a_terima_kps"] === "") ||
        //     (data["tmpt_lahir"] === "") ||
        //     (data["tgl_lahir"] === "") ||
        //     (n != 3)
        //   ) {
        //     $(row).addClass('Highlight');

        //   }
        // },

    });
    $(".preloader").fadeOut();
    
    $('#kodepropinsi').on('change', function() {
        var kode = this.value;
        update_list("#kodekabupaten", "/wilayah/get_list_data_by_propinsi/" +
            kode, '0');
        resetsel("#kodekecamatan");
        resetsel("#idfarm");
        <?php
            if($halaman=="index"){
        ?>
        location.reload();
        <?php } ?>
    });
    $('#kodekabupaten').on('change', function() {
        var kodepropinsi = $('#kodepropinsi').val();
        var kodekabupaten = this.value;
        update_list("#kodekecamatan", "/wilayah/get_list_data_by_kabupaten/" +
            kodepropinsi + "/" + kodekabupaten, '0');
        resetsel('#idfarm');
        <?php
            if($halaman=="index"){
        ?>
        location.reload();
        <?php } ?>
    });
    $('#kodekecamatan').on('change', function() {
        var kodepropinsi = $('#kodepropinsi').val();
        var kodekabupaten = $('#kodekabupaten').val();
        var kodekecamatan = this.value;
        update_list("#idfarm", "/identifikasi/peternakan/get_list_data_by_kecamatan/" +
            kodepropinsi + "/" + kodekabupaten + "/" + kodekecamatan, '0');
        <?php
            if($halaman=="index"){
        ?>
        location.reload();
        <?php } ?>
    });

    $('#idfarm').on('change', function() {
        <?php
            if($halaman=="index"){
        ?>
        var idfarm = $('#idfarm').val();
        $.ajax({
            type: "POST",
            url: "/identifikasi/peternakan/pilihfarm",
            data: {
                idfarm: idfarm
            },
        }).done(function(result) {
            location.reload();
        })
        <?php } ?>
    });

    $('#tbldata').on('click', '#hapusdata', function() {
        var id = $(this).data('id');
        $('[name="id"]').val(id);
        var tagsapi = $('#tagsapi-' + id).html();
        $('#tagsapi').html(tagsapi);
        $('#Modalhapus').modal('show');
    });

    $('#alasan').on('change', function() {
        if ($('#alasan').val() == 1) {
            $('#tanggalmati').show();
        } else
            $('#tanggalmati').hide();
    });

    $('#p_semuajkel').on('click', function() {
        var kelamin = "";
        $.ajax({
            type: "POST",
            url: "/identifikasi/sapi/pilihkelamin",
            data: {
                kelamin: kelamin
            },
        }).done(function(result) {
            location.reload();
        })
    })
    $('#p_jantan').on('click', function() {
        var kelamin = "Jantan";
        $.ajax({
            type: "POST",
            url: "/identifikasi/sapi/pilihkelamin",
            data: {
                kelamin: kelamin
            },
        }).done(function(result) {
            location.reload();
        })
    })
    $('#p_betina').on('click', function() {
        var kelamin = "Betina";
        $.ajax({
            type: "POST",
            url: "/identifikasi/sapi/pilihkelamin",
            data: {
                kelamin: kelamin
            },
        }).done(function(result) {
            location.reload();
        })
    })
    $('#p_hidup').on('click', function() {
        var status = "";
        $.ajax({
            type: "POST",
            url: "/identifikasi/sapi/pilihstatus",
            data: {
                status: status
            },
        }).done(function(result) {
            location.reload();
        })
    })
    $('#p_mati').on('click', function() {
        var status = "Mati";
        $.ajax({
            type: "POST",
            url: "/identifikasi/sapi/pilihstatus",
            data: {
                status: status
            },
        }).done(function(result) {
            location.reload();
        })
    })
    $('#p_afkir').on('click', function() {
        var status = "Afkir";
        $.ajax({
            type: "POST",
            url: "/identifikasi/sapi/pilihstatus",
            data: {
                status: status
            },
        }).done(function(result) {
            location.reload();
        })
    })
    $('#p_dijual').on('click', function() {
        var status = "Dijual";
        $.ajax({
            type: "POST",
            url: "/identifikasi/sapi/pilihstatus",
            data: {
                status: status
            },
        }).done(function(result) {
            location.reload();
        })
    })
    $('#p_hibah').on('click', function() {
        var status = "Hibah";
        $.ajax({
            type: "POST",
            url: "/identifikasi/sapi/pilihstatus",
            data: {
                status: status
            },
        }).done(function(result) {
            location.reload();
        })
    })
    $('#p_is_balai').on('click', function() {
        if ($(this).prop("checked") == true) {
            var is_balai = "1";
        } else {
            var is_balai = "0";
        };
        $.ajax({
            type: "POST",
            url: "/identifikasi/sapi/pilih_balai",
            data: {
                is_balai: is_balai
            },
        }).done(function(result) {
            location.reload();
        })
    })
    $('#p_is_uzur').on('click', function() {
        if ($('#p_is_uzur').checked()) {
            var is_uzur = "1";
        } else {
            var is_uzur = "0";
        };
        $.ajax({
            type: "POST",
            url: "/identifikasi/sapi/pilih_uzur",
            data: {
                is_uzur: is_uzur
            },
        }).done(function(result) {
            location.reload();
        })
    })
    $('#p_is_vbc').on('click', function() {
        if ($('#p_is_vbc').checked()) {
            var is_vbc = "1";
        } else {
            var is_vbc = "0";
        };
        $.ajax({
            type: "POST",
            url: "/identifikasi/sapi/pilih_vbc",
            data: {
                is_vbc: is_vbc
            },
        }).done(function(result) {
            location.reload();
        })
    })
});
$("#kotakUpload").click(function() {
    $("#file").click();
});

//memanggil fungsi untuk menangani file upload saat milih File
$('#file').on('change', fileUpload);

function fileUpload(event) {
    //memberitahu pengguna tentang status file upload
    
    //mendapatkan file yang dipilih
    files = event.target.files;

    //memeriksa data form 
    var data = new FormData();

    //file data is presented as an array
    for (var i = 0; i < files.length; i++) {
        var file = files[i]; 
        if (!file.type.match('application/vnd.ms-excel')) {
            //memeriksa format file
            toastr.warning("Silahkan pilih file Excel (xls)");
        } else if (file.size > 2097152) {
            //memeriksa ukuran file (dalam bytes)
            toastr.warning("Maaf, file Anda terlalu besar (melebihi 2 MB)");
        } else {
            //menambahkan file yang dapat diunggah ke objek FormData
            toastr.success(event.target.value + " mengupload...");
            data.append('file', file, file.name);

            //membuat XMLHttpRequest baru
            var xhr = new XMLHttpRequest();

            //data file post yang untuk diupload
            xhr.open('POST', '/identifikasi/sapi/upload_excel', true);
            xhr.send(data);

            xhr.onload = function() {
                //mendapatkan respon dan menunjukkan status upload
                var response = JSON.parse(xhr.responseText);
                var statusresponse = response.status;
                var statusresponse = statusresponse.split('|');


                if (xhr.status === 200 && statusresponse[0] == 'ok') {
                      
                    namafile=statusresponse[1];
                    
                    $.ajax({
                        type:"POST",
                        url:"/identifikasi/sapi/import",
                        data:{filename:namafile},
                        success:function(hasil){
                            location.reload();
                        }
                    })
                    // $('#kotakUpload').hide();
                } else if (response.status == 'type_err') {
                    toastr.warning("Silakan pilih file excel/csv");
                } else {
                    toastr.warning("Ada sedikit masalah, silakan coba lagi.");
                }
            };
        }
    }
}
</script>
</body>

</html>