<script src="/assets/js/highcharts.js"></script>
<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolautosuggest.js"></script>
<script language="javascript" type="text/javascript" src="/assets/js/autosuggest/jquery.coolfieldset.js"></script>
<script src="/assets/js/list.js"></script>
<script src="/assets/js/app.js"></script>

<script type="text/javascript">
//2)script untuk membuat grafik, perhatikan setiap komentar agar paham
$(function() {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container', //letakan grafik di div id container
                //Type grafik, anda bisa ganti menjadi area,bar,column dan bar
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: 'Populasi Peternakan Per Propinsi',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: { //X axis menampilkan data tahun 
                categories: [<?php
					$i=0;
					$n=$propinsi->num_rows();
					foreach($propinsi->result() as $row){$i++;
						echo "'$row->namapropinsi'";
						if(($i!=1)||($i!=$n))echo ",";
					}
				?>]
            },
            yAxis: {
                title: { //label yAxis
                    text: 'Banyak Peternakan'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080' //warna dari grafik line
                }]
            },
            tooltip: {
                formatter: function() {
                    return '<b>' + this.series.name + '</b><br/>' +
                        this.x + ': ' + this.y;
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [{
                name: 'Propinsi',
                //data yang akan ditampilkan 
                data: [<?php
					$i=0;
					$n=$propinsi->num_rows();
					foreach($propinsi->result() as $row){$i++;
						echo $row->n;
						if(($i!=1)||($i!=$n))echo ",";
					}
				?>]
            }]
        });
    });

});

$(function() {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'kabupatenContainer', //letakan grafik di div id container
                //Type grafik, anda bisa ganti menjadi area,bar,column dan bar
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: 'Populasi Peternakan Per Kabupaten',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: { //X axis menampilkan data tahun 
                categories: [<?php
					$i=0;
					$n=$kabupaten->num_rows();
					foreach($kabupaten->result() as $row){$i++;
						echo "'$row->namakabupaten'";
						if(($i!=1)||($i!=$n))echo ",";
					}
				?>]
            },
            yAxis: {
                title: { //label yAxis
                    text: 'Banyak Peternakan'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080' //warna dari grafik line
                }]
            },
            tooltip: {
                formatter: function() {
                    return '<b>' + this.series.name + '</b><br/>' +
                        this.x + ': ' + this.y;
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [{
                name: 'Kabupaten',
                //data yang akan ditampilkan 
                data: [<?php
					$i=0;
					$n=$kabupaten->num_rows();
					foreach($kabupaten->result() as $row){$i++;
						echo $row->n;
						if(($i!=1)||($i!=$n))echo ",";
					}
				?>]
            }]
        });
    });

});
</script>
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
    var t = $("#tblsusu").dataTable({
        dom: '<"top"if>rt<"bottom"p>',
        initComplete: function() {
            var api = this.api();
            $('#tblsusu_filter input')
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
            "url": "/produksi/susu_vertikal/get_data",
            "type": "POST"
        },
        columns: [{
                "data": "idpengukuran",
                "orderable": false
            },
            {
                "data": "tanggal",
                "class": "text-center"
            },
            {
                "data": "tagsapi"
            },
            {
                "data": "nomorregister",
                "class": "text-center"
            },
            {
                "data": "pagi",
                "class": "text-right"
            },
            {
                "data": "sore",
                "class": "text-right"
            },
            {
                "data": "jumlah",
                "class": "text-right"
            },
            {
                "data": "xlaktasi",
                "class": "text-center"
            },
            {
                "data": "tglberanak",
                "class": "text-center"
            },
            {
                "data": "aksi"
            },
            // {"data": "editpass"}
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
        }
    });

    $('#tblsusu').on('click', '#editdata', function() {
        var id = $(this).data('id');
        $.ajax({
            type: "GET",
            url: "/produksi/susu_vertikal/get_data_by_idpengukuran/" + id,
            success: function(msg) {
                var data = JSON.parse(msg);
                $('#edtidpengukuran').val(id);
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
    $('#tblsusu').on('click', '#hapusdata', function() {
        var id = $(this).data('id');
        $('#Modalhapus').modal('show');
        $('[name="id"]').val(id);
    });
    $('#tambahdata').on('click', function() {
        $('#Modaltambah').modal('show');
    });

    $('#frmtambah').submit(function(e) {
        let tagsapi = $('#tagsapi').val();
        let idsapi = $('#idsapi').val();

        if (tagsapi.trim() == "") {
            $('#tagsapierr').html('Tag Sapi harus diisi');
            e.preventDefault();
        } else
        if (idsapi.trim() == "") {
            $('#tagsapierr').html('Tag Sapi tidak terdaftar');
            e.preventDefault();
        }
    });
    $("#tagsapi").coolautosuggest({
        url: "/identifikasi/sapi/get_data_bytagsapi/",
        showDescription: true,
        width: 400,
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