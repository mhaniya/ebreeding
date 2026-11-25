$(document).ready(function() {
    $('#kodepropinsi').on('change', function() {
        var kode = this.value;
        update_list("#kodekabupaten", "/wilayah/get_list_data_by_propinsi/" + kode, '0');
        resetsel("#kodekecamatan");
        resetsel("#idfarm");
        location.reload();
    });
    $('#kodekabupaten').on('change', function() {
        var kodepropinsi = $('#kodepropinsi').val();
        var kodekabupaten = this.value;
        update_list("#kodekecamatan", "/wilayah/get_list_data_by_kabupaten/" + kodepropinsi + "/" + kodekabupaten, '0');
        resetsel('#idfarm');
        location.reload();
    });
    $('#kodekecamatan').on('change', function() {
        var kodepropinsi = $('#kodepropinsi').val();
        var kodekabupaten = $('#kodekabupaten').val();
        var kodekecamatan = this.value;
        update_list("#idfarm", "/identifikasi/peternakan/get_list_data_by_kecamatan/" +
            kodepropinsi + "/" + kodekabupaten + "/" + kodekecamatan, '0');
        location.reload();
    });

    $('#idfarm').on('change', function() {

        var idfarm = $('#idfarm').val();
        $.ajax({
            type: "POST",
            url: "/identifikasi/peternakan/pilihfarm",
            data: {
                idfarm: idfarm
            },
        }).done(function(result) {
            location.reload();
        })

    });
    $('#tahun').on('change', function() {

        var tahun = $('#tahun').val();
        $.ajax({
            type: "POST",
            url: "/identifikasi/sapi/pilihtahun",
            data: {
                tahun: tahun
            },
        }).done(function(result) {
            location.reload();
        })
    });
    $('#bulan').on('change', function() {

        var bulan = $('#bulan').val();
        $.ajax({
            type: "POST",
            url: "/identifikasi/sapi/pilihbulan",
            data: {
                bulan: bulan
            },
        }).done(function(result) {
            location.reload();
        })
    });


    $('#tanggal').on('change', function() {
        var tanggal = $('#tanggal').val();
        $.ajax({
            type: "POST",
            url: "/identifikasi/sapi/pilihtanggal",
            data: {
                tanggal: tanggal
            },
        }).done(function(result) {
            location.reload();
        })
    });



    $('#xlaktasi').on('change', function() {

        var xlaktasi = $('#xlaktasi').val();
        $.ajax({
            type: "POST",
            url: "/identifikasi/sapi/pilihlaktasi",
            data: {
                xlaktasi: xlaktasi
            },
        }).done(function(result) {
            location.reload();
        })
    });
});