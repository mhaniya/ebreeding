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
       
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
             'excel', 'pdf', 'print'
        ],
    });
    function tampil_data(){
		    $.ajax({
		        type  : 'ajax',
		        url   : '/lap_produktifitas/Produksi_dan_tetua/get_json_produksi_dan_tetua',
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
                                        "<td style='text-align:center;'>"+data[i].tgllaktasi+"</td>"+
                                        "<td style='text-align:center;'>"+data[i].xlaktasi+"</td>"+
                                        "<td>"+(data[i].tglibterakhir==null?"-":data[i].tglibterakhir)+"</td>"+
                                        "<td>"+(data[i].kodesemenibterakhir==null?"-":data[i].kodesemenibterakhir)+"</td>"+
                                        "<td>"+(data[i].namasemenibterakhir==null?"-":data[i].namasemenibterakhir)+"</td>"+
                                        "<td>"+data[i].tagsapipedet+"</td>"+
                                        "<td>"+data[i].kelaminpedet+"</td>"+
                                        "<td>"+data[i].bobotlahirpedet+"</td>"+
                                        "<td>"+data[i].produksisusuterkoreksi+"</td>"+
                                        "<td>"+(data[i].kodesire==null?"-":data[i].kodesire)+"</td>"+
                                        "<td>"+(data[i].namasire==null?"-":data[i].namasire)+"</td>"+
                                        "<td>"+(data[i].kodedam==null?"-":data[i].kodedam)+"</td>"+
                                        "<td>"+(data[i].namadam==null?"-":data[i].namadam)+"</td>"+
                                        "<td>"+(data[i].kodepgs==null?"-":data[i].kodepgs)+"</td>"+
                                        "<td>"+(data[i].namapgs==null?"-":data[i].namapgs)+"</td>"+
                                        "<td>"+(data[i].kodepgd==null?"-":data[i].kodepgd)+"</td>"+
                                        "<td>"+(data[i].namapgd==null?"-":data[i].namapgd)+"</td>"+
                                        "<td>"+(data[i].kodemgs==null?"-":data[i].kodemgs)+"</td>"+
                                        "<td>"+(data[i].namamgs==null?"-":data[i].namamgs)+"</td>"+
                                        "<td>"+(data[i].kodemgd==null?"-":data[i].kodemgd)+"</td>"+
                                        "<td>"+(data[i].namamgd==null?"-":data[i].namamgd)+"</td>"+
                                    "</tr>";
		            }
		            $('#show_data').html(html);
		        }

		    });
	};
    
    
        
     
});
</script>
</body>

</html>