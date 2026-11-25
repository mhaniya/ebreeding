<!-- AdminLTE dashboard demo (This is only for demo purposes) -->

<!-- AdminLTE for demo purposes -->

<script>
    $(document).ready(function() {

        $('input:radio[name="options"]').change(
            function() {
                location.href = '/pilih/sesi/' + $(this).val();
            });

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
        
        <?php
        
        if ($this->session->userdata('sesi_aktif') == 'sapi') {
        ?>
            var t = $('#tblpopulasi').DataTable({
                "processing": true,
                "stateSave": true,
                "searching": false,
                "paging": false,
                "info": false,
                "ajax": "<?php echo site_url('lap_populasi/populasi_sapi/get_data_today'); ?>",
                "columns": [

                    {
                        "data": "namafarm"
                    },
                    {
                        "data": "jantan",
                        "class": "text-right",
                    },
                    {
                        "data": "betina",
                        "class": "text-right",
                    },
                    {
                        "data": "jumlah",
                        "class": "text-right",
                    },
                ],

                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api(),
                        data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };

                    // Total over all pages
                    totalJ = api
                        .column(1)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    totalB = api
                        .column(2)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    total = api
                        .column(3)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Update footer
                    $(api.column(1).footer()).html(totalJ);
                    $(api.column(2).footer()).html(totalB);
                    $(api.column(3).footer()).html(total);
                },
                dom: 'Bfrtip',
                responsive: true,
                buttons: []
            });
        <?php } else { ?>
            var t = $('#tblpopulasi').DataTable({
                "processing": true,
                "stateSave": true,
                "searching": false,
                "paging": false,
                "info": false,
                "ajax": "<?php echo site_url('lap_populasi/populasi_kambing/get_data_today'); ?>",
                "columns": [

                    {
                        "data": "namarumpun"
                    },
                    {
                        "data": "jantan",
                        "class": "text-right",
                    },
                    {
                        "data": "betina",
                        "class": "text-right",
                    },
                    {
                        "data": "jumlah",
                        "class": "text-right",
                    },
                ],

                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api(),
                        data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };

                    // Total over all pages
                    totalJ = api
                        .column(1)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    totalB = api
                        .column(2)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    total = api
                        .column(3)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Update footer
                    $(api.column(1).footer()).html(totalJ);
                    $(api.column(2).footer()).html(totalB);
                    $(api.column(3).footer()).html(total);
                },
                dom: 'Bfrtip',
                responsive: true,
                buttons: []
            });
        <?php } ?>

        var t = $('#tblpkb').DataTable({
            "processing": true,
            "stateSave": true,
            "serverSide": true,
            "ajax": "<?php echo site_url('reproduksi/pkb/get_data_should_pkb_today'); ?>",
            "columns": [

                {
                    "data": "tagsapi",
                    "class": "text-center",
                },
                // {
                //     "data": "nomorregister",
                //     "class":"text-center",
                // },
                {
                    "data": "namafarm",
                },
            ],
            dom: 'Bfrtip',
            responsive: true,
            buttons: []
        });
        var t = $('#tblib').DataTable({
            "processing": true,
            "stateSave": true,
            "serverSide": true,
            "stateSave": true,
            "ajax": "<?php echo site_url('reproduksi/ib/get_pengamatan_birahi_today'); ?>",
            "columns": [

                {
                    "data": "tagsapi",
                    "class": "text-center",
                },
                // {
                //     "data": "ibke",
                //     "class":"text-center",
                // },
                {
                    "data": "status",
                },
                {
                    "data": "namafarm",
                },
            ],
            dom: 'Bfrtip',
            responsive: true,
            buttons: []
        });
        <?php
        if ($idfarmuser <> "") {
            if($this->session->userdata('pilihsesi')=='sapi')
                $rs = $this->M_sapi->get_populasi_today();
            else
                $rs = $this->M_kambing->get_populasi_today();
            $row = $rs->row();
            $jantan = $row->jantan;
            $betina = $row->betina;

        ?>
            var donutData = {
                labels: [
                    'Jantan',
                    'Betina'
                ],
                datasets: [{
                    data: [<?php echo $jantan; ?>, <?php echo $betina; ?>],
                    backgroundColor: ['#f56954', '#00a65a'],
                }]
            }
            //-------------
            //- PIE CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            
            var pieChartCanvas = $('#barChart').get(0).getContext('2d')

            var pieData = donutData;
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            var pieChart = new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            })
        <?php } else { ?>
            var areaChartData = {
                labels: [
                    <?php
                    if($this->session->userdata('pilihsesi')=='sapi'){
                        $rs = $this->M_sapi->get_populasi_today();
                        foreach ($rs->result() as $row) {
                            echo "'$row->namafarm',";
                        }
                    }else{
                        $rs = $this->M_kambing->get_populasi_today();
                        foreach ($rs->result() as $row) {
                            echo "'$row->namarumpun',";
                        }
                    }
                    
                    ?>

                ],
                datasets: [{
                        label: 'Jantan',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [
                            <?php
                            $rs = $this->M_sapi->get_populasi_today();
                            foreach ($rs->result() as $row) {
                                echo "'$row->jantan',";
                            }
                            ?>
                        ]
                    },
                    {
                        label: 'Betina',
                        backgroundColor: 'rgba(210, 214, 222, 1)',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(210, 214, 222, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: [
                            <?php
                            $rs = $this->M_sapi->get_populasi_today();
                            foreach ($rs->result() as $row) {
                                echo "'$row->betina',";
                            }
                            ?>
                        ]
                    },
                    {
                        label: 'Jumlah',
                        backgroundColor: 'rgba(210, 1, 1, 1)',
                        borderColor: 'rgba(210, 1, 1, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(210, 1, 1, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,1,1,1)',
                        data: [
                            <?php
                            $rs = $this->M_sapi->get_populasi_today();
                            foreach ($rs->result() as $row) {
                                echo "'$row->jumlah',";
                            }
                            ?>
                        ]
                    },
                ]
            }


            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChartData = jQuery.extend(true, {}, areaChartData)
            var temp0 = areaChartData.datasets[0]
            var temp1 = areaChartData.datasets[1]
            barChartData.datasets[0] = temp1
            barChartData.datasets[1] = temp0

            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false
            }

            var barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            });
        <?php }; ?>
        var areaChartData = {
            labels: [
                <?php
                $rs = $this->M_susu->get_produksi_per_tahun();
                foreach ($rs->result() as $row) {
                    echo "'$row->tahun',";
                }
                ?>
            ],
            datasets: [{
                label: 'Pagi',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: [
                    <?php
                    $rs = $this->M_susu->get_produksi_per_tahun();
                    foreach ($rs->result() as $row) {
                        echo "'$row->pagi',";
                    }
                    ?>
                ]
            }, {
                label: 'Sore',
                backgroundColor: 'rgba(210, 214, 222, 1)',
                borderColor: 'rgba(210, 214, 222, 1)',
                pointRadius: false,
                pointColor: 'rgba(210, 214, 222, 1)',
                pointStrokeColor: '#c1c7d1',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data: [
                    <?php
                    $rs = $this->M_susu->get_produksi_per_tahun();
                    foreach ($rs->result() as $row) {
                        echo "'$row->sore',";
                    }
                    ?>
                ]
            }, {
                label: 'Jumlah',
                backgroundColor: 'rgba(210, 1, 1, 1)',
                borderColor: 'rgba(210, 1, 1, 1)',
                pointRadius: false,
                pointColor: 'rgba(210, 1, 1, 1)',
                pointStrokeColor: '#c1c7d1',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(220,1,1,1)',
                data: [
                    <?php
                    $rs = $this->M_susu->get_produksi_per_tahun();
                    foreach ($rs->result() as $row) {
                        echo "'$row->jumlah',";
                    }
                    ?>
                ]
            }, ]
        }

        var areaChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: true
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false,
                    }
                }],
                yAxes: [{
                    gridLines: {
                        display: true,
                    }
                }]
            }
        }

        //-------------
        //- LINE CHART -
        //--------------
        // var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
        var lineChartOptions = jQuery.extend(true, {}, areaChartOptions)
        var lineChartData = jQuery.extend(true, {}, areaChartData)
        lineChartData.datasets[0].fill = false;
        lineChartData.datasets[1].fill = false;
        lineChartData.datasets[2].fill = false;
        lineChartOptions.datasetFill = false

        // var lineChart = new Chart(lineChartCanvas, {
        //     type: 'line',
        //     data: lineChartData,
        //     options: lineChartOptions
        // });


        $(".preloader").fadeOut();
    })
</script>
</body>

</html>