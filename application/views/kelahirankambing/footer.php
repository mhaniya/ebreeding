<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolautosuggest.js"></script>
<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolfieldset.js"></script>
<script src="/assets/js/list.js"></script>
<script>
    (function($) {
        $.fn.inputFilter = function(callback, errMsg) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop focusout", function(e) {
                if (callback(this.value)) {
                    // Accepted value
                    if (["keydown", "mousedown", "focusout"].indexOf(e.type) >= 0) {
                        $(this).removeClass("input-error");
                        this.setCustomValidity("");
                    }
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    // Rejected value - restore the previous one
                    $(this).addClass("input-error");
                    this.setCustomValidity(errMsg);
                    this.reportValidity();
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    // Rejected value - nothing to restore
                    this.value = "";
                }
            });
        };
    }(jQuery));

    function fun_AllowOnlyAmountAndDot(txt) {
        if (event.keyCode > 47 && event.keyCode < 58 || event.keyCode == 46) {
            var txtbx = document.getElementById(txt);
            var amount = document.getElementById(txt).value;
            var present = 0;
            var count = 0;

            if (amount.indexOf(".", present) || amount.indexOf(".", present + 1)); {
                // alert('0');
            }

            /*if(amount.length==2)
            {
              if(event.keyCode != 46)
              return false;
            }*/
            do {
                present = amount.indexOf(".", present);
                if (present != -1) {
                    count++;
                    present++;
                }
            }
            while (present != -1);
            if (present == -1 && amount.length == 0 && event.keyCode == 46) {
                event.keyCode = 0;
                //alert("Wrong position of decimal point not  allowed !!");
                return false;
            }

            if (count >= 1 && event.keyCode == 46) {

                event.keyCode = 0;
                //alert("Only one decimal point is allowed !!");
                return false;
            }
            if (count == 1) {
                var lastdigits = amount.substring(amount.indexOf(".") + 1, amount.length);
                if (lastdigits.length >= 2) {
                    //alert("Two decimal places only allowed");
                    event.keyCode = 0;
                    return false;
                }
            }
            return true;
        } else {
            event.keyCode = 0;
            //alert("Only Numbers with dot allowed !!");
            return false;
        }

    }
    $(document).ready(function() {

        // $("#bobotlahir").inputFilter(function(value) {
        //     return /^\d*$/.test(value); // Allow digits only, using a RegExp
        // }, "Only digits allowed");
        
        $('#bobotlahir').on('keypress',function(){
            return fun_AllowOnlyAmountAndDot(this.id);
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

        var t = $('#tbldata').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "ajax": "<?php echo site_url('identifikasi/kelahirankambing/ajax_tabel'); ?>",
            "columns": [{
                    "data": null,
                    "class": "text-center",
                    "orderable": false
                },
                {
                    "data": "tgllahir",
                    "class": "text-center"
                },
                {
                    "data": "eartag_induk",
                    "class": "text-center"
                },
                {
                    "data": "eartag_anak",
                    "class": "text-center"
                },
                {
                    "data": "status_kelahiran",
                    "class": "text-center"
                },
                {
                    "data": "statuslahiranak",
                    "class": "text-center"
                },
                {
                    "data": "bobotlahir",
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



        $('#tbldata').on('click', '#hapusdata', function() {
            var id = $(this).data('id');
           
            $('[name="id"]').val(id);
            
            
            var eartag = $('#eartag-' + id).val();
            
            $('#eartag').html(eartag);
            
            $('#Modalhapus').modal('show');
        });

        $('#status').on('change', function() {
            let status = $('#status').val();
            $.ajax({
                type: "POST",
                url: "/kambing/pilihstatus",
                data: {
                    status: status
                },
            }).done(function(result) {
                location.reload();
            })
        });

        
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
                xhr.open('POST', '/kambing/upload_excel', true);
                xhr.send(data);

                xhr.onload = function() {
                    //mendapatkan respon dan menunjukkan status upload
                    var response = JSON.parse(xhr.responseText);
                    var statusresponse = response.status;
                    var statusresponse = statusresponse.split('|');


                    if (xhr.status === 200 && statusresponse[0] == 'ok') {

                        namafile = statusresponse[1];

                        $.ajax({
                            type: "POST",
                            url: "/kambing/import",
                            data: {
                                filename: namafile
                            },
                            success: function(hasil) {
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

    $("#eartag_induk").coolautosuggest({
        url: "/identifikasi/kambing/get_data_bytagkambing/",
        showDescription: true,
        width: 400,
        onSelected: function(result) {
            if (result != null) {
                $('#eartag_induk').val(result.id);
                $('#rumpun').val(result.rumpun);
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
</script>
</body>

</html>