<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolautosuggest.js"></script>
<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolfieldset.js"></script>
<script src="/assets/js/list.js"></script>
<script src="/assets/js/app.js"></script>
<script>
$(document).ready(function() {
    var importPertumbuhanCsrf = null;
    <?php if ($this->config->item('csrf_protection')) { ?>
    importPertumbuhanCsrf = {
        name: <?=json_encode($this->security->get_csrf_token_name()); ?>,
        hash: <?=json_encode($this->security->get_csrf_hash()); ?>
    };
    <?php } ?>
    $('#btnInfo').on('click', function() { $('#ModalinfoPertumbuhan').modal('show'); });
    $('#btnLaporanImportPertumbuhan').on('click', function() { $('#ModalLaporanImportPertumbuhan').modal('show'); });
    $('#kotakUpload').on('click', function() { $('#fileImportPertumbuhan').click(); });
    $('#fileImportPertumbuhan').on('change', function() {
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
        if (importPertumbuhanCsrf) { body.append(importPertumbuhanCsrf.name, importPertumbuhanCsrf.hash); }
        $('#kotakUpload').prop('disabled', true);
        toastr.info('Mengimport data pertumbuhan...');
        $.ajax({
            url: <?=json_encode(site_url('produksi/pertumbuhan/import')); ?>,
            type: 'POST', data: body, processData: false, contentType: false, dataType: 'json'
        }).done(function(result) {
            if (result.csrf) { importPertumbuhanCsrf = result.csrf; }
            var box = $('#hasilImportPertumbuhan').empty().show();
            $('<p>').text('Import selesai: ' + result.success + ' baris berhasil, ' +
                result.errors.length + ' pesan kesalahan.').appendTo(box);
            $.each(result.errors, function(_, message) {
                $('<div>').addClass('text-danger').text(message).appendTo(box);
            });
            $.each(result.warnings, function(_, message) {
                $('<div>').addClass('text-warning').text(message).appendTo(box);
            });
            $('#ModalLaporanImportPertumbuhan').modal('show');
            $('#tblpertumbuhan').DataTable().ajax.reload(null, false);
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
    var t = $("#tblpertumbuhan").dataTable({
        dom: '<"top"if>rt<"bottom"p>',
        initComplete: function() {
            var api = this.api();
            $('#tblpertumbuhan_filter input')
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
            "url": "/produksi/pertumbuhan/get_data",
            "type": "POST"
        },
        columns: [{
                "data": "idpengukuran",
                "orderable": false
            },
            {
                "data": "tanggal",
                "class": "text-center" ,
                // "render":function(data,display,row){
                //     var tgl=data.split('-');
                //     var tanggal=tgl[2]+"-"+tgl[1]+"-"+tgl[0];
                //     return tanggal;
                // }
                
            },
            {"data": "tagsapi"},
            {
                "data": "nomorregister",
                "class": "text-center"
            },
            {
                "data": "umur",
                "class": "text-center",
                "render":function(data){
                    return Math.round( data * 100 + Number.EPSILON ) / 100 ;
                }
            },
            {
                "data": "bobotkg",
                "class": "text-center"
            },
            {
                "data": "lingkar_dada",
                "class": "text-center"
            },
            {
                "data": "prediksi_bobot_badan",
                "class": "text-center",
                render:function(data){
                    return Math.round( data * 100 + Number.EPSILON ) / 100 ;
                }
            },
            {
                "data": "panjang_badan",
                "class": "text-center"
            },
            {
                "data": "tinggi_gumba",
                "class": "text-center"
            },
            {
                "data": "lingkar_skrotum",
                "class": "text-center"
            },
            {"data": "aksi"},
            
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

    $('#tblpertumbuhan').on('click', '#editdata', function() {
        var id = $(this).data('id');
        $.ajax({
            type:"GET",
            url:"/produksi/pertumbuhan/get_data_by_idpengukuran/"+id,
            success:function(msg){
                var data=JSON.parse(msg);
                $('#idpengukuran').val(id);
                tgl=data['tanggal'];
                tanggal=tgl.substr(0,4)+"-"+tgl.substr(5,2)+"-"+tgl.substr(8,2);
                $('#tanggal').val(tanggal);
                $('#tagsapi').val(data['tagsapi']);
                $('#nomorregister').val(data['nomorregister']);
                $('#idsapi').val(data['idsapi']);
                $('#bobotkg').val(data['bobotkg']);
                $('#lingkar_dada').val(data['lingkar_dada']);
                $('#panjang_badan').val(data['panjang_badan']);
                $('#tinggi_gumba').val(data['tinggi_gumba']);
                $('#lingkar_skrotum').val(data['lingkar_skrotum']);
            }
        })
        document.getElementById('frmtambah').action='/produksi/pertumbuhan/update';
        $('#Modaltambah').modal('show');
    });
    $('#tblpertumbuhan').on('click', '#hapusdata', function() {
        var id = $(this).data('id');
        $('#Modalhapus').modal('show');
        $('[name="id"]').val(id);
    });
    $('#tambahdata').on('click', function() {
        $('#Modaltambah').modal('show');
    });

    $('#frmtambah').submit(function(e) {
        let tagsapi=$('#tagsapi').val();
        let idsapi=$('#idsapi').val();
 
        if(tagsapi.trim()==""){
            $('#tagsapierr').html('Tag Sapi harus diisi');
            e.preventDefault();
        }else
        if(idsapi.trim()==""){
            $('#tagsapierr').html('Tag Sapi tidak terdaftar');
            e.preventDefault();
        }
    });
    $("#tagsapi").coolautosuggest({
			url: "/identifikasi/sapi/get_data_bytagsapi/",
            showDescription:true,
            width:400,
			onSelected: function(result) {

				if (result != null) {
                    $('#idsapi').val(result.id);
                    $('#nomorregister').val(result.description);
				} else {

				}
			}
    	});
     
});
</script>
</body>

</html>
