<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolautosuggest.js"></script>
<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolfieldset.js"></script>
<script src="/assets/js/list.js"></script>
<script src="/assets/js/app.js"></script>
<script>
$(document).ready(function() {
    
 
    tampil_data();
    $('#tbldata').dataTable({
        processing: true,
        stateSave: true, 
        searching: true,
        orderable: false,
        rowCallback: function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
        },
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
    });
    function tampil_data(){
		    $.ajax({
		        type  : 'ajax',
		        url   : '/lap_produktifitas/pertumbuhan_bobot_badan/get_json_report',
		        async : false,
		        dataType : 'json',
		        success : function(data){
		            var html = '';
		            var i;
		            for(i=0; i<data.length; i++){
                        
		                html +=  "<tr>"+
                                        "<td style='text-align:center;'>"+(i+1)+"</td>"+
                                        "<td style='text-align:center;'>"+data[i].tagsapi+"</td>"+
                                        "<td style='text-align:center;'>"+data[i].nomorregister+"</td>"+
                                        "<td style='text-align:center;'>"+data[i].tgllahir+"</td>"+
                                        "<td style='text-align:center;'>"+data[i].umur+"</td>"+
                                        "<td style='text-align:center;'>"+data[i].bobotlahir+"</td>"+
                                        "<td style='text-align:center;'>"+(data[i].tanggal1==null?"-":data[i].tanggal1)+"</td>"+
                                        "<td style='text-align:center;'>"+(data[i].bobotkg1==null?"-":data[i].bobotkg1)+"</td>"+
                                        "<td style='text-align:center;'>"+(data[i].selisih1==null?"-":data[i].selisih1)+"</td>"+
                                        "<td style='text-align:center;'>"+(data[i].tanggal2==null?"-":data[i].tanggal2)+"</td>"+
                                        "<td style='text-align:center;'>"+(data[i].bobotkg2==null?"-":data[i].bobotkg2)+"</td>"+
                                        "<td style='text-align:center;'>"+(data[i].selisih2==null?"-":data[i].selisih2)+"</td>"+
                                        "<td style='text-align:center;'>"+(data[i].tanggal3==null?"-":data[i].tanggal3)+"</td>"+
                                        "<td style='text-align:center;'>"+(data[i].bobotkg3==null?"-":data[i].bobotkg3)+"</td>"+
                                        "<td style='text-align:center;'>"+(data[i].selisih3==null?"-":data[i].selisih3)+"</td>"+
                                        "<td style='text-align:center;'>"+(data[i].tanggal4==null?"-":data[i].tanggal4)+"</td>"+
                                        "<td style='text-align:center;'>"+(data[i].bobotkg4==null?"-":data[i].bobotkg4)+"</td>"+
                                        "<td style='text-align:center;'>"+(data[i].selisih4==null?"-":data[i].selisih4)+"</td>"+
                                        "<td style='text-align:center;'>"+(data[i].tanggal5==null?"-":data[i].tanggal5)+"</td>"+
                                        "<td style='text-align:center;'>"+(data[i].bobotkg5==null?"-":data[i].bobotkg5)+"</td>"+
                                        "<td style='text-align:center;'>"+(data[i].selisih5==null?"-":data[i].selisih5)+"</td>"+
                                        "<td style='text-align:center;'>"+(data[i].tanggal6==null?"-":data[i].tanggal6)+"</td>"+
                                        "<td style='text-align:center;'>"+(data[i].bobotkg6==null?"-":data[i].bobotkg6)+"</td>"+
                                        "<td style='text-align:center;'>"+(data[i].selisih6==null?"-":data[i].selisih6)+"</td>"+
                                        "<td style='text-align:center;'>"+(data[i].tanggal7==null?"-":data[i].tanggal7)+"</td>"+
                                        "<td style='text-align:center;'>"+(data[i].bobotkg7==null?"-":data[i].bobotkg7)+"</td>"+
                                        "<td style='text-align:center;'>"+(data[i].selisih7==null?"-":data[i].selisih7)+"</td>"+
                                        
                                    "</tr>";
		            }
		            $('#show_data').html(html);
		        }

		    });
	};

    
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