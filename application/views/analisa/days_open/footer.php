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
        ordering: true,
        ajax: {
            "url": "/analisa/days_open/get_data",
            "type": "POST"
        },
        columns: [{
                "data": null,
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
                "data": "xlaktasi",
                "class": "text-center"
            },
            {
                "data": "tglmelahirkan",
                "class": "text-center"
            },
            {
                "data": "tgl_ib",
                "class": "text-center" 
            },
            {
                "data": "selisihhari",
                "class": "text-center"
            },
        ],
        
        order: [
            [0, 'desc'],
            [1, 'asc'],
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