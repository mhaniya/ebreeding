<!-- DataTables -->
<script src="/assets/template/adminlte/plugins/datatables/jquery.dataTables.js"></script>
<script src="/assets/template/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolautosuggest.js"></script>
<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolfieldset.js"></script>
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
        // stateSave: true,
        // serverSide: true,
        searching: true,
        ordering: true,
        ajax: {
            "url": "/kesehatan/pemasukan_obat/get_data",
            "type": "POST"
        },
        columns: [{
                "data": "idpemasukan",
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
                "data": "namaobat"
            },
            {
                "data": "jumlah",
                "class": "text-right"
            },
            {
                "data": "namasatuan"
            },
            {
                "data": "namapetugas"
            },
            {"data": "aksi"}, 
        ],
        
        order: [ 
            [1, 'asc'],
        ],
        rowCallback: function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
        }
    });

    $('#tbldata').on('click', '#editdata', function() {
        var id = $(this).data('id');
        $.ajax({
            type:"GET",
            url:"/kesehatan/pemasukan_obat/get_data_by_id/"+id,
            success:function(msg){
                var data=JSON.parse(msg);
                $('#edtidpemasukan').val(id);
                $('#edttanggal').val(data['tanggal']);
                $('#edtnamaobat').val(data['namaobat']);
                $('#edtidobat').val(data['idobat']);
                $('#edtjumlah').val(data['jumlah']);
                
                $('#edtidsatuan').val(data['idsatuan']);
                $('#edtpetugas').val(data['namapetugas']);
                $('#edtidpetugas').val(data['idpetugas']);
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
    $("#namaobat").coolautosuggest({
			url: "/kesehatan/obat/get_data_bynama/",
            showDescription:true,
            width:400,
			onSelected: function(result) {

				if (result != null) {
                    $('#idobat').val(result.id);
				} 
			}
    	});
    $("#edtnamaobat").coolautosuggest({
			url: "/kesehatan/obat/get_data_bynama/",
            showDescription:true,
            width:400,
			onSelected: function(result) {

				if (result != null) {
                    $('#edtidobat').val(result.id);
				} 
			}
    	});
    $("#petugas").coolautosuggest({
			url: "/identifikasi/petugas/get_data_bynama/",
            showDescription:true,
            width:400,
			onSelected: function(result) {

				if (result != null) {
                    $('#idpetugas').val(result.id);
				} 
			}
    	});
    $("#edtpetugas").coolautosuggest({
			url: "/identifikasi/petugas/get_data_bynama/",
            showDescription:true,
            width:400,
			onSelected: function(result) {

				if (result != null) {
                    $('#edtidpetugas').val(result.id);
				} 
			}
    	});
     
});
</script>
</body>

</html>