<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolautosuggest.js"></script>
<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolfieldset.js"></script>
<script src="/assets/js/list.js"></script>
<script src="/assets/js/app.js"></script>
<script>
$(document).ready(function() {
    var kualitasCsrf = null;
    <?php if ($this->config->item('csrf_protection')) { ?>
    kualitasCsrf = {name: <?=json_encode($this->security->get_csrf_token_name()); ?>, hash: <?=json_encode($this->security->get_csrf_hash()); ?>};
    <?php } ?>
    $('#btnInfo').on('click', function() { $('#ModalPanduanKualitasSusu').modal('show'); });
    $('#btnLaporanKualitasSusu').on('click', function() { $('#ModalLaporanKualitasSusu').modal('show'); });
    $('#kotakUpload').on('click', function() { $('#fileImportKualitasSusu').click(); });
    $('#fileImportKualitasSusu').on('change', function() {
        var input = this, file = input.files[0];
        if (!file) { return; }
        if (!/\.(xls|xlsx|csv)$/i.test(file.name) || !file.size || file.size > 2097152) { toastr.warning('Pilih file .xls, .xlsx, atau .csv, maksimal 2 MB.'); input.value = ''; return; }
        var body = new FormData(); body.append('file', file);
        if (kualitasCsrf) { body.append(kualitasCsrf.name, kualitasCsrf.hash); }
        $('#kotakUpload').prop('disabled', true);
        $.ajax({url: <?=json_encode(site_url('produksi/kualitas_susu/import')); ?>, type: 'POST', data: body, processData: false, contentType: false, dataType: 'json'})
        .done(function(result) {
            if (result.csrf) { kualitasCsrf = result.csrf; }
            var box = $('#hasilImportKualitasSusu').empty();
            $('<p>').text('Import selesai: ' + result.success + ' baris berhasil, ' + result.errors.length + ' pesan kesalahan.').appendTo(box);
            $.each(result.errors, function(_, msg) { $('<div>').addClass('text-danger').text(msg).appendTo(box); });
            $.each(result.warnings, function(_, msg) { $('<div>').addClass('text-warning').text(msg).appendTo(box); });
            $('#ModalLaporanKualitasSusu').modal('show');
            $('#tbldata').DataTable().ajax.reload(null, false);
        }).fail(function() { toastr.error('Import gagal. Muat ulang halaman dan periksa file atau log aplikasi.'); })
        .always(function() { $('#kotakUpload').prop('disabled', false); input.value = ''; });
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
        // "serverSide"    : true,
        "processing"    : true,
        "paging"        : true, 
        "info"          : true,
        "autoWidth"     : false,
        "stateSave"     : true,
        "searching"     : true,
        "ordering"      : true,
        "ajax": {
            "url": "/produksi/kualitas_susu/get_data",
            "type": "POST"
        },
        columns: [
            {
                "data": "idpengukuran",
                "orderable": false
            },
            {
                "data": "tanggal",
                "class": "text-center",
                // "render":function(data,display,row){
                //     var tgl=data.split('-');
                //     var tanggal=tgl[2]+"-"+tgl[1]+"-"+tgl[0];
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
                "data": "kadarlemak",
                "class": "text-right"
            },
            {
                "data": "kadarair",
                "class": "text-right"
            },
            {
                "data": "kadarbk",
                "class": "text-right"
            },
            {
                "data": "protein",
                "class": "text-center"
            },
            {
                "data": "bahankeringtanpalemak",
                "class": "text-center"
            },
            {
                "data": "beratjenis",
                "class": "text-center"
            },
            {
                "data": "laktosa",
                "class": "text-center"
            },
            {"data": "aksi"}, 
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
            type:"GET",
            url:"/produksi/kualitas_susu/get_data_by_idpengukuran/"+id,
            success:function(msg){
                var data=JSON.parse(msg);
                $('#idpengukuran').val(id);
                tgl=data['tanggal'];
                tanggal=tgl.substr(0,4)+"-"+tgl.substr(5,2)+"-"+tgl.substr(8,2);
                $('#tanggal').val(tanggal);
                $('#tagsapi').val(data['tagsapi']);
                $('#nomorregister').val(data['nomorregister']);
                $('#idsapi').val(data['idsapi']);
                $('#kadarlemak').val(data['kadarlemak']);
                $('#kadarair').val(data['kadarair']);
                $('#kadarbk').val(data['kadarbk']);
                $('#bktl').val(data['bahankeringtanpalemak']);
                $('#protein').val(data['protein']);
                $('#beratjenis').val(data['beratjenis']);
                $('#laktosa').val(data['laktosa']);
            }
        })
        document.getElementById('frmtambah').action='/produksi/kualitas_susu/update';
        
        $('#Modaltambah').modal('show');
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
