<!-- DataTables -->
<script src="/assets/template/adminlte/plugins/datatables/jquery.dataTables.js"></script>
<script src="/assets/template/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- FLOT CHARTS -->
<script src="/assets/template/adminlte/plugins/flot/jquery.flot.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="/assets/template/adminlte/plugins/flot-old/jquery.flot.resize.min.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="/assets/template/adminlte/plugins/flot-old/jquery.flot.pie.min.js"></script>
<script src="/assets/js/highcharts.js"></script>
<script type="text/javascript">
$(function() {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'pertumbuhancontainer', //letakan grafik di div id container
                //Type grafik, anda bisa ganti menjadi area,bar,column dan bar
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: 'Pertumbuhan Bobot Badan',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: { //X axis menampilkan data tahun 
                categories: [<?php
					$i=0;
					$n=$pertumbuhan->num_rows();
					foreach($pertumbuhan->result() as $row){
                        $i++;
						echo "'".$this->fungsi->date_to_tanggal3($row->tanggal)."'";
						if(($i!=1)||($i!=$n))echo ",";
					}
				?>]
            },
            yAxis: {
                title: { //label yAxis
                    text: 'Bobot Badan'
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
                name: 'Pertumbuhan Bobot Sapi dengan Tag <?php echo $tagsapi;?>',
                //data yang akan ditampilkan 
                data: [<?php
					$i=0;
					$n=$pertumbuhan->num_rows();
					foreach($pertumbuhan->result() as $row){$i++;
						echo $row->bobotkg;
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
                renderTo: 'susucontainer', //letakan grafik di div id container
                //Type grafik, anda bisa ganti menjadi area,bar,column dan bar
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: 'Grafik Produksi Susu Per Laktasi',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: { //X axis menampilkan data tahun 
                categories: [<?php
					$i=0;
					$n=$produksi->num_rows();
					foreach($produksi->result() as $row){$i++;
						echo "'XLAKTASI : ".$row->xlaktasi."'";
						if(($i!=1)||($i!=$n))echo ",";
					}
				?>]
            },
            yAxis: {
                title: { //label yAxis
                    text: 'Jumlah Produksi'
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
                name: 'Produksi Susu Sapi dengan Tag <?=$tagsapi;?>',
                //data yang akan ditampilkan 
                data: [<?php
					$i=0;
					$n=$produksi->num_rows();
					foreach($produksi->result() as $row){$i++;
						echo $row->jmlproduksi;
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
                renderTo: 'susucontainer1', //letakan grafik di div id container
                //Type grafik, anda bisa ganti menjadi area,bar,column dan bar
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: 'Grafik Produksi Susu Per Tanggal Produksi',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: { //X axis menampilkan data tahun 
                categories: [<?php
					$i=0;
					$n=$produksi1->num_rows();
					foreach($produksi1->result() as $row){$i++;
						echo "'".$row->tanggal."'";
						if(($i!=1)||($i!=$n))echo ",";
					}
				?>]
            },
            yAxis: {
                title: { //label yAxis
                    text: 'Jumlah Produksi'
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
                name: 'Produksi Susu Sapi dengan Tag <?=$tagsapi;?>',
                //data yang akan ditampilkan 
                data: [<?php
					$i=0;
					$n=$produksi1->num_rows();
					foreach($produksi1->result() as $row){$i++;
						echo $row->pagi+$row->sore;
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

    $(".preloader").fadeOut();

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

    var idsapi = $('#idsapi').val();

    $('#tblproduksiperlaktasi').DataTable({
        "processing": true,
        "stateSave": true,
        "ajax": "<?php echo site_url('analisa/produksi/get_analisa_produksi_per_laktasi'); ?>/" +
            idsapi,
        "columns": [{
                "data": null,
                "class": "text-right"
            },
            {
                "data": "xlaktasi",
                "class": "text-center"
            },
            {
                "data": "minproduksi",
                "class": "text-right"
            },
            {
                "data": "maxproduksi",
                "class": "text-right"
            },
            {
                "data": "produksinyata",
                "class": "text-right"
            },
            {
                "data": "jhp",
                "class": "text-right"
            },
            {
                "data": "terkoreksi",
                "class": "text-right"
            },
        ],
        "order": [
            [1, "asc"]
        ],
        "rowCallback": function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);

            $('td:eq(0)', row).html(index);
        },
    });
    $('#tblproduksipertanggal').DataTable({
        "processing": true,
        // "stateSave": true,
        "ajax": "<?php echo site_url('produksi/susu_vertikal/getProduksiPerLaktasiByIDSapi'); ?>/" +
            idsapi,
        "columns": [{
                "data": null,
                "class": "text-right"
            },
            {
                "data": "tanggal",
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
        ],
        "order": [
            [1, "desc"]
        ],
        "rowCallback": function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);

            $('td:eq(0)', row).html(index);
        },
    });

    $('#tblpertumbuhan').dataTable({
        "columns": [{
                "data": "",
                "orderable": false
            },
            {
                "data": "tanggal",
            },
            {
                "data": "bobotkg"
            },
        ],
        "order": [
            [1, "desc"]
        ],
        "rowCallback": function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);

            $('td:eq(0)', row).html(index);
        },
    });
    $('#tblkesehatan').dataTable({
        "columns": [{
                "data": "",
                "orderable": false
            },
            {
                "data": "tanggal",
            },
            {
                "data": "kategori",
            },
            {
                "data": "diagnosa",
            },
            {
                "data": "keterangan",
            }
        ],
        "order": [
            [1, "desc"]
        ],
        "rowCallback": function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);

            $('td:eq(0)', row).html(index);
        },
    });
    $('#tbltetua').dataTable();
    $('#tblreproduksi').dataTable();
});

$("#kotakUpload").click(function() {
    $("#filefoto").click();
});

//memanggil fungsi untuk menangani file upload saat milih File
$('#filefoto').on('change', fileUpload);

function fileUpload(event) {
    //memberitahu pengguna tentang status file upload
    $("#kotakUpload").html(event.target.value + " mengupload...");

    //mendapatkan file yang dipilih
    files = event.target.files;

    //memeriksa data form 
    var data = new FormData();

    //file data is presented as an array
    for (var i = 0; i < files.length; i++) {
        var file = files[i];

        if (!file.type.match('image.*')) {
            //memeriksa format file
            $("#kotakUpload").html("Silakan pilih file gambar.");
        } else if (file.size > 2097152) {
            //memeriksa ukuran file (dalam bytes)
            $("#kotakUpload").html("Maaf, file Anda terlalu besar (melebihi 2 MB)");
        } else {
            //menambahkan file yang dapat diunggah ke objek FormData

            data.append('file', file, file.name);

            //membuat XMLHttpRequest baru
            var xhr = new XMLHttpRequest();

            //data file post yang untuk diupload
            xhr.open('POST', '/identifikasi/sapi/upload', true);
            xhr.send(data);

            xhr.onload = function() {
                //mendapatkan respon dan menunjukkan status upload
                var response = JSON.parse(xhr.responseText);
                var statusresponse = response.status;
                var statusresponse = statusresponse.split('|');


                if (xhr.status === 200 && statusresponse[0] == 'ok') {
                    $("#kotakUpload").html(
                        "File telah berhasil diupload. Klik untuk mengupload file lainnya.");
                    $("#namafile").val(statusresponse[1]);

                    var htm = "<img src='/assets/images/upload/foto/sapi/" + statusresponse[1] +
                        "' class='col-sm-8' style='margin-left:10px;background:gray;'>";

                    $("#gambar").html(htm);
                    // $('#kotakUpload').hide();
                } else if (response.status == 'type_err') {
                    $("#kotakUpload").html(
                        "Silakan pilih file gambar. Klik untuk mengupload file lainnya.");
                } else {
                    $("#kotakUpload").html("Ada sedikit masalah, silakan coba lagi.");
                }
            };
        }
    }
}

//mencegah browser dari membuka file ketika didrag and drop
$(document).on('drop dragover', function(e) {
    e.preventDefault();
});


function settetua(jenis, idsapi) {
    $('[name="id"]').val(idsapi);
    $('[name="nomorregister"]').val("");
    $('[name="tagsapi"]').val("");
    $('[name="namasapi"]').val("");
    $('[name="tgllahir"]').val("");
    $.ajax({
        type: "GET",
        url: "/identifikasi/sapi/gettetua/" + jenis + "/" + idsapi,
    }).done(function(data) {
        obj = JSON.parse(data);
        if ((jenis == "Sire") || (jenis == "PGS") || (jenis == "MGS")) {
            $('[name="id"]').val(idsapi);
            $('[name="nomorregister"]').val(obj[0].nomorregisterpejantan);
            $('[name="tagsapi"]').val(obj[0].tagpejantan);
            $('[name="namasapi"]').val(obj[0].namapejantan);
            $('[name="tgllahir"]').val(obj[0].tgllahirpejantan);
            $('[name="idsapi"]').val(obj[0].idpejantan);
            $('#jenistetuajantan').html(jenis);
            $('#Modaltetuajantan').modal('show');
        } else
        if ((jenis == "Dam") || (jenis == "PGD") || (jenis == "MGD")) {
            $('[name="id"]').val(idsapi);
            $('[name="nomorregister"]').val(obj[0].nomorregisterinduk);
            $('[name="tagsapi"]').val(obj[0].taginduk);
            $('[name="namasapi"]').val(obj[0].namainduk);
            $('[name="tgllahir"]').val(obj[0].tgllahirinduk);
            $('[name="idsapi"]').val(obj[0].idinduk);
            $('#jenistetuainduk').html(jenis);
            $('#Modaltetuainduk').modal('show');
        }


    });
}


$("#tagsapitetuajantan").coolautosuggest({
    url: "/identifikasi/semen/get_data_bykode/",
    showDescription: true,
    width: 400,
    onSelected: function(result) {
        if (result != null) {
            $('#idsapitetuajantan').val(result.idsapi);
            $('#tagsapitetuajantan').val(result.id);
            $('#namasapitetuajantan').val(result.description);
        } else {

        }
    }
});
$("#namasapitetuajantan").coolautosuggest({
    url: "/identifikasi/semen/get_data_bynama/",
    showDescription: true,
    width: 400,
    onSelected: function(result) {
        if (result != null) {
            $('#idsapitetuajantan').val(result.idsapi);
            $('#tagsapitetuajantan').val(result.id);
            $('#namasapitetuajantan').val(result.description);
        } else {

        }
    }
});
$("#tagsapitetuainduk").coolautosuggest({
    url: "/identifikasi/sapi/get_data_bykode/",
    showDescription: true,
    width: 400,
    onSelected: function(result) {
        if (result != null) {
            $('#idsapitetuainduk').val(result.id);
            $('#tagsapitetuainduk').val(result.data);
            $('#namasapitetuainduk').val(result.description);
        } else {

        }
    }
});
$("#namasapitetuainduk").coolautosuggest({
    url: "/identifikasi/sapi/get_data_bynama/",
    showDescription: true,
    width: 400,
    onSelected: function(result) {
        if (result != null) {
            $('#idsapitetuainduk').val(result.id);
            $('#tagsapitetuainduk').val(result.data);
            $('#namasapitetuainduk').val(result.description);
        } else {

        }
    }
});

function cetakSertifikat(idsapi){
		$.ajax({
			type:"POST",
			url:"<?php echo base_url();?>identifikasi/sapi/settanggalsertifikat",
			data:"tanggal="+$('#tglsertifikat').val()+"&idsapi="+idsapi,
			success:function(msg){
				
			}
		});
		window.open('<?php echo base_url();?>identifikasi/sapi/cetaksertifikat/'+idsapi);
	}

function cetakSertifikatlspro(idsapi) {

    window.open('<?php echo base_url();?>identifikasi/sapi/cetaksertifikatlspro/' + idsapi);
}
</script>
</body>

</html>