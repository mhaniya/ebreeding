<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?php echo $n_sapi_belum_pkb; ?></h3>

                        <p>Sapi IB Belum PKB</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="/lap_reproduksi/sapi_belum_pkb" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?php echo $n_sapi_dara_belum_ib; ?></h3>

                        <p>Sapi Dara Belum IB</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="/lap_reproduksi/sapi_dara_belum_ib" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        Populasi Sapi Hidup Hari ini
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-stripped table-bordered" id="tblpopulasi">
                            <thead>
                                <tr>
                                    <!-- <th class='text-center' style='width:20px;'>No</th> -->
                                    <th class='text-center'>Farm</th>
                                    <th class='text-center' style='width:100px;'>Jantan</th>
                                    <th class='text-center' style='width:100px;'>Betina</th>
                                    <th class='text-center' style='width:100px;'>Jumlah</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <th>Jumlah</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- BAR CHART -->
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Grafik Populasi Sapi Hidup Hari Ini</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="barChart" style="height:230px; min-height:230px"></canvas>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- <div class="col-md-6">
                     <div class="card card-primary">
                         <div class="card-header">
                             Produksi Susu 5 Tahun Terakhir
                         </div>
                         <div class="card-body table-responsive">
                             <table class="table table-stripped table-bordered" id="tblproduksi">
                                 <thead>
                                     <tr>
                                         <!-- <th class='text-center' style='width:20px;'>No</th> -->
            <!-- <th class='text-center'>Tahun</th> -->
            <!-- <th class='text-center' style='width:100px;'>R Pagi</th>
                                         <th class='text-center' style='width:100px;'>R Sore</th> -->
            <!-- <th class='text-center' style='width:100px;'>Rerata</th> -->
            <!-- </tr> -->
            <!-- </thead>  -->
            <!-- <tfoot>
                                        <th>Jumlah</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                 </tfoot> -->
            <!-- </table>
                         </div>
                     </div>
                 </div> -->
            <!-- <div class="col-md-6">
                     <div class="card card-info">
                         <div class="card-header">
                             <h3 class="card-title">Grafik Produksi Susu 5 Tahun Terakhir</h3>

                             <div class="card-tools">
                                 <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                         class="fas fa-minus"></i>
                                 </button>
                                 <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                         class="fas fa-times"></i></button>
                             </div>
                         </div>
                         <div class="card-body">
                             <div class="chart">
                                 <canvas id="lineChart" style="height:250px; min-height:250px"></canvas>
                             </div>
                         </div> -->
            <!-- /.card-body -->
            <!-- </div>
                 </div> -->

            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        Untuk dilaksanakan PKB Hari ini
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-stripped table-bordered" id="tblpkb">
                            <thead>
                                <tr>
                                    <!-- <th class='text-center' style='width:20px;'>No</th> -->
                                    <!-- <th class='text-center' >Tanggal</th> -->
                                    <th class='text-center'>No Tag</th>
                                    <!-- <th class='text-center'>Nomor Register</th> -->
                                    <th class='text-center'>Farm</th>

                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        Pengamatan Birahi Hari ini
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-stripped table-bordered" id="tblib">
                            <thead>
                                <tr>
                                    <!-- <th class='text-center' style='width:20px;'>No</th> -->
                                    <!-- <th class='text-center' >Tanggal</th> -->
                                    <th class='text-center'>No Tag</th>
                                    <th class='text-center'>Status</th>
                                    <th class='text-center'>Farm</th>

                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>