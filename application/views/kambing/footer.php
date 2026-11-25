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
            "ajax": "<?php echo site_url('kambing/ajax_tabel'); ?>",
            "columns": [

                {
                    "data": null,
                    "class": "text-center",
                    "orderable": false
                },
                {
                    "data": "eartag",
                    "class": "text-center"
                },
                {
                    "data": "rumpun",
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
                    "data": "taginduk",
                    "class": "text-center"
                },
                {
                    "data": "tagindukjantan",
                    "class": "text-center"
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
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 baris', '25 baris', '50 baris', 'semua baris'],
            ],
            buttons: [
                'pageLength', 'excel', 'pdf', 'print'
            ],
        });
        $(".preloader").fadeOut();

        $('#btnupload').on('click', function() {
            $('#file').click();
        })

        $('#tbldata').on('click', '#hapusdata', function() {
            var id = $(this).data('id');
            $('[name="id"]').val(id);
            var eartag = $('#eartag-' + id).html();
            $('#eartag').html(eartag);
            $('#Modalhapus').modal('show');
        });


    });
    $("#kotakUpload").click(function() {
        $("#file").click();
    });


    function preview_image(event) {
        var reader = new FileReader();
        reader.readAsDataURL(event.target.files[0]);
        reader.onload = function() {
            var output = document.getElementById('foto');
            output.src = reader.result;
            fileUpload(event);
        }
        reader.onerror = function(error) {
            console.log('Error: ', error);
        };
       
    }

    //memanggil fungsi untuk menangani file upload saat milih File
    // $('#file').on('change', fileUpload);
    // $('#file').on('change', preview_image(event));

    function fileUpload(event) {
        //memberitahu pengguna tentang status file upload
        $("#kotakUpload").html(event.target.value + " mengupload...");

        //mendapatkan file yang dipilih
        files = event.target.files;

        //memeriksa data form 
        var data = new FormData();

        //file data is presented as an array
        for (var i = 0; i < files.length; i++) {
            var file = files[i];

            if (!file.type.match('image.*')) {
                //memeriksa format file
                $("#kotakUpload").html("Silakan pilih file gambar.");
            } else if (file.size > 2097152) {
                //memeriksa ukuran file (dalam bytes)
                $("#kotakUpload").html("Maaf, file Anda terlalu besar (melebihi 2 MB)");
            } else {
                //menambahkan file yang dapat diunggah ke objek FormData

                data.append('file', file, file.name);

                //membuat XMLHttpRequest baru
                var xhr = new XMLHttpRequest();

                //data file post yang untuk diupload
                xhr.open('POST', '/identifikasi/kambing/upload', true);
                xhr.send(data);

                xhr.onload = function() {
                    //mendapatkan respon dan menunjukkan status upload
                    var response = JSON.parse(xhr.responseText);
                    var statusresponse = response.status;
                    var statusresponse = statusresponse.split('|');


                    if (xhr.status === 200 && statusresponse[0] == 'ok') {
                        $("#kotakUpload").html(
                            "File telah berhasil diupload dengan nama "+statusresponse[1]+". Klik untuk mengupload file lainnya.");
                        // $("#namafile").val(statusresponse[1]);

                        // var htm = "<img src='/assets/images/upload/foto/kambing/" + statusresponse[1] +
                        //     "' class='col-sm-8' style='margin-left:10px;background:gray;'>";

                        // $("#gambar").html(htm);
                        // $('#kotakUpload').hide();
                    } else if (response.status == 'type_err') {
                        $("#kotakUpload").html(
                            "Silakan pilih file gambar. Klik untuk mengupload file lainnya.");
                    } else {
                        $("#kotakUpload").html("Ada sedikit masalah, silakan coba lagi.");
                    }
                };
            }
        }
    }
</script>
</body>

</html>