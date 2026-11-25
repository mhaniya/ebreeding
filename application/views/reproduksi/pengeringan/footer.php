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
        ordering: false,
        ajax: {
            "url": "/reproduksi/pengeringan/get_data",
            "type": "POST"
        },
        columns: [
            {
                "data": "idpengeringan",
                "orderable": false
            },
            
            {
                "data": "tagsapi",
                "class": "text-center"
            },
            {
                "data": "nomorregister",
                "class": "text-center"
            },
            {
                "data": "tglmulai",
                "class": "text-center",
                "render":function(data,display,row){
                    if (data!=null){
                        return data.substr(8,2)+"-"+data.substr(5,2)+"-"+data.substr(0,4);
                    }else
                        return null;
                }
            },
            {
                "data": "tglakhir",
                "class": "text-center",
                "render":function(data,display,row){
                    if (data!=null){
                        return data.substr(8,2)+"-"+data.substr(5,2)+"-"+data.substr(0,4);
                    }else
                        return null;
                }
            },
            {
                "data": "keterangan"
            },
            {"data": "aksi"}, 
        ],
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
            url:"/produksi/susu_vertikal/get_data_by_idpengeringan/"+id,
            success:function(msg){
                var data=JSON.parse(msg);
                $('#edtidpengeringan').val(id);
                $('#edttanggal').val(data['tanggal']);
                $('#edttagsapi').val(data['tagsapi']);
                $('#edtnomorregister').val(data['nomorregister']);
                $('#edtidsapi').val(data['idsapi']);
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
        $('#tagsapi').val("");
        $('#nomorregister').val("");
        $('#idsapi').val("");
        $('#tglmulai').val("<?php echo date('Y-m-d');?>");
        $('#tglakhir').val("<?php echo date('Y-m-d');?>");
        $('#keterangan').val("");
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