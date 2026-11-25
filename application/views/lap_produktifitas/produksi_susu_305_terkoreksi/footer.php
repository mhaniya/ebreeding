<!-- DataTables -->
<script src="/assets/template/adminlte/plugins/datatables/jquery.dataTables.js"></script>
<script src="/assets/template/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolautosuggest.js"></script>
<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolfieldset.js"></script>
<script src="/assets/js/list.js"></script>
<script src="/assets/js/app.js"></script>
<script>
$(document).ready(function() {
    tampil_data();
    $('#dataku').dataTable({
		responsive:true,
		"columnDefs": [{ "orderable": false, "targets": 1 }],
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
    });
    function tampil_data(){
		    $.ajax({
		        type  : 'ajax',
		        url   : '/lap_produktifitas/produksi_susu_305_terkoreksi/get_data',
		        async : false,
		        dataType : 'json',
		        success : function(data){
		            var html = '';
		            var i;
		            for(i=0; i<data.length; i++){
						nomor=i+1;
		                html += '<tr>'+
		                  		'<td style="text-align:center;">'+nomor+'</td>'+
								 
		                  		'<td style="text-align:center;">'+data[i].tagsapi+'</td>'+
		                  		'<td style="text-align:center;">'+data[i].nomorregister+'</td>'+
		                        '<td style="text-align:center;">'+data[i].xlaktasi+'</td>'+
		                        '<td style="text-align:center;">'+data[i].jhp+'</td>'+
		                        '<td style="text-align:center;">'+Math.round(data[i].produksinyata*100)/100+'</td>'+
		                        '<td style="text-align:center;">'+Math.round(data[i].produksi305*100)/100+'</td>'+
		                        '</tr>';
		            }
                     
		            $('#show_data').html(html);
		        }

		    });
		}
    
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