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
    $('#tbldata').dataTable({
			responsive:true,
			"columnDefs": [{ "orderable": false, "targets": 1 }]
    });
    function tampil_data(){
		    $.ajax({
		        type  : 'ajax',
		        url   : '/lap_populasi/populasi_sapi_berdasarkan_umur/get_data',
		        async : false,
		        dataType : 'json',
		        success : function(data){
		            var html = '';
		            var i;
		            for(i=0; i<data.length; i++){
						nomor=i+1;
		                html += '<tr>'+
		                  		'<td style="text-align:center;">'+nomor+'</td>'+
								 
		                  		'<td >'+data[i].namafarm+'</td>'+
		                  		'<td >'+data[i].namakecamatan+'</td>'+
		                        '<td style="text-align:center;">'+data[i].totalSapiHidup+'</td>'+
		                        '<td style="text-align:center;">'+data[i].BetinaTanpaTglLahir+'</td>'+
		                        '<td style="text-align:center;">'+data[i].Betinakurang4bl+'</td>'+
		                        '<td style="text-align:center;">'+data[i].Betinakurang12bl+'</td>'+
		                        '<td style="text-align:center;">'+data[i].Betinalebih1th+'</td>'+
		                        '<td style="text-align:center;">'+data[i].totalSapiBetina+'</td>'+
		                        '<td style="text-align:center;">'+data[i].totalSapiBetinaAfkir+'</td>'+
		                        '<td style="text-align:center;">'+data[i].totalSapiBetinaMati+'</td>'+
		                        '<td style="text-align:center;">'+data[i].JantanTanpaTglLahir+'</td>'+
		                        '<td style="text-align:center;">'+data[i].Jantankurang4bl+'</td>'+
		                        '<td style="text-align:center;">'+data[i].Jantankurang12bl+'</td>'+
		                        '<td style="text-align:center;">'+data[i].Jantanlebih1th+'</td>'+
		                        '<td style="text-align:center;">'+data[i].totalSapiJantan+'</td>'+
		                        '<td style="text-align:center;">'+data[i].totalSapiJantanAfkir+'</td>'+
		                        '<td style="text-align:center;">'+data[i].totalSapiJantanMati+'</td>'+
		                        
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