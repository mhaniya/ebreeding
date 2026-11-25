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
    var t = $("#tblsemen").dataTable({
        dom: '<"top"if>rt<"bottom"p>',
        initComplete: function() {
            var api = this.api();
            $('#tblsemen_filter input')
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
        orderable: false,
        ajax: {
            "url": "<?php echo base_url().'index.php/identifikasi/semen/get_data'?>",
            "type": "POST"
        },
        columns: [{
                "data": "kodesemen",
                "orderable": false
            },
            {
                "data": "kodesemen"
            },
            {
                "data": "namasemen"
            },
            {
                "data": "tgllahir"
            },
            {
                "data": "kodesire"
            },
            {
                "data": "namasire"
            },
            {
                "data": "kodedam"
            },
            {
                "data": "namadam"
            },
            {
                "data": "aksi"
            },
            // {"data": "hapus"},
            // {"data": "editpass"}
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
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
    });

    $('#tblsemen').on('click', '#editdata', function() {
        var id = $(this).data('id');
        $.ajax({
            type:"GET",
            url:"/identifikasi/semen/get_by_id/"+id,
            success:function(msg){
                var data=JSON.parse(msg);
                $('#edtkode').val(id);
                $('#edtkodesemen').val(data['kodesemen']);
                $('#edtnamasemen').val(data['namasemen']);
                $('#edttanggallahir').val(data['tgllahir']);
                $('#edtidsire').val(data['idsire']);
                $('#edtkodesire').val(data['kodesire']);
                $('#edtnamasire').val(data['namasire']);
                $('#edtiddam').val(data['iddam']);
                $('#edtkodedam').val(data['kodedam']);
                $('#edtnamadam').val(data['namadam']);
            }
        })
        $('#Modaledit').modal('show');
    });
    $('#tblsemen').on('click', '#hapusdata', function() {
        var id = $(this).data('id');
        $('#Modalhapus').modal('show');
        $('[name="id"]').val(id);
    });
    $('#tambahdata').on('click', function() {
        $('#Modaltambah').modal('show');
    });

    $('#frmtambah').submit(function(e) {
        let kodesemen=$('#kodesemen').val();
        let namasemen=$('#namasemen').val();
         
        if(kodesemen.trim()==""){
            $('#kodesemenerr').html('Kode semen harus diisi');
            e.preventDefault();
        }else
        if(namasemen.trim()==""){
            $('#kodesemenerr').html('');
            $('#namasemenerr').html('Nama semen harus diisi');
            e.preventDefault();
         }else
         if(kodesemen.trim()!=""){
             $.ajax({
                 type:"POST",
                 url:"/identifikasi/semen/get_num_kodesemen",
                 data:{kodesemen:kodesemen},
                 success:function(msg){
                     if(msg>0){
                        $('#kodesemenerr').html('Kode semen sudah ada');
                         e.preventDefault();
                     }
                 }
            });
        }
    });

    $("#edtkodesire").on('keydown',function(){
        $('#edtidsire').val('');
        // $('#edtnamasire').val('');
    })
    $("#edtnamasire").on('keydown',function(){
        $('#edtidsire').val('');
        // $('#edtnamasire').val('');
    })
    $("#edtkodedam").on('keydown',function(){
        $('#edtiddam').val('');
        // $('#edtnamadam').val('');
    })
    $("#edtnamadam").on('keydown',function(){
        $('#edtiddam').val('');
        // $('#edtnamadam').val('');
    })
    $("#edtkodesire").coolautosuggest({
        url: "/identifikasi/semen/get_data_bykode/",
        showDescription: true,
        width: 400,
        onSelected: function(result) {

            if (result != null) {
                $('#edtidsire').val(result.idsapi);
                $('#edtkodesire').val(result.id);
                $('#edtnamasire').val(result.description);
            } else {

            }
        }
    });
    $("#edtnamasire").coolautosuggest({
        url: "/identifikasi/semen/get_data_bynama/",
        showDescription: true,
        width: 400,
        onSelected: function(result) {

            if (result != null) {
                $('#edtidsire').val(result.idsapi);
                $('#edtkodesire').val(result.id);
                $('#edtnamasire').val(result.description);
            } else {

            }
        }
    });
    $("#edtkodedam").coolautosuggest({
        url: "/identifikasi/semen/get_dam_bykode/",
        showDescription: true,
        width: 400,
        onSelected: function(result) {

            if (result != null) {
                $('#edtiddam').val(result.idsapi);
                $('#edtkodedam').val(result.id);
                $('#edtnamadam').val(result.description);
            } else {

            }
        }
    });
    $("#edtnamadam").coolautosuggest({
        url: "/identifikasi/semen/get_dam_bynama/",
        showDescription: true,
        width: 400,
        onSelected: function(result) {

            if (result != null) {
                $('#edtiddam').val(result.idsapi);
                $('#edtkodedam').val(result.id);
                $('#edtnamadam').val(result.description);
            } else {

            }
        }
    });
});
</script>
</body>

</html>