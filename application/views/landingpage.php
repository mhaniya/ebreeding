<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>e-Breeding BBPTUHPT Baturraden</title>
    <link rel="stylesheet" href="/assets/styles/style.css">
    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/assets/slider/themes/default/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="/assets/slider/themes/light/light.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="/assets/slider/themes/dark/dark.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="/assets/slider/themes/bar/bar.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="/assets/slider/nivo-slider.css" type="text/css" media="screen" />
    <!-- <link rel="stylesheet" href="/assets/slider/demo/style.css" type="text/css" media="screen" /> -->
</head>

<body>
    <header>
        <div class="jumbotron">
            <!-- <img src="/assets/images/gb2.jpg"  id="gb0" class="featured-image slide" alt="sejarah" style="display:inline;border-radius: 5px;">
            <img src="/assets/images/gb3.jpg"  id="gb1" class="featured-image slide" alt="sejarah" style="display:none;border-radius: 5px;">
            <img src="/assets/images/gb4.jpg"  id="gb2" class="featured-image slide" alt="sejarah" style="display:none;border-radius: 5px;"> -->
            <div id="wrapper">
                <div class="slider-wrapper theme-default">
                    <div id="slider" class="nivoSlider"> 
                        <img src="/assets/images/gb1.jpg" data-thumb="/assets/assets/images/gb1.jpg" alt="" />
                        <a href="#"><img src="/assets/images/gb2.jpg" data-thumb="/assets/images/gb2.jpg" alt="" title="" /></a> 
                        <img src="/assets/images/gb3.jpg" data-thumb="/assets/images/gb3.jpg" alt="" data-transition="slideInLeft" /> 
                        <img src="/assets/images/gb4.jpg" data-thumb="/assets/images/gb4.jpg" alt="" title="" />
                    </div>
                    <!-- <div id="htmlcaption" class="nivo-html-caption"></div> -->
                </div> 
            </div>
            <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
        </div>
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/landingpage/analisa">e-Analisa</a></li>
                <li><a href="/login">e-Breeding</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div id="content">

            <article class="card">
                <h2 id="sejarah">e-Breeding</h2>
                <img src="/assets/images/bg_cheader.jpg" class="featured-image" alt="">
                <p>e-Breeding  merupakan aplikasi yang dipergunakan untuk mengelola data sapi perah sedemikian rupa sehingga data berkaitan dengan produktivitas ternak dapat dikelola dengan baik, dikelompokkan berdasar kriteria tertentu yang ditetapkan, dan dilakukan perhitungan tertentu. Sertifikat bibit ternak dapat dikeluarkan menggunakan aplikasi ini. Aplikasi e-Breeding dapat diakses dengan menggunakan jaringan internet baik melalui PC, Laptop, maupun Smartphone. </p>
                <p></p>
                <!-- <p>Software Breeding Sapi Perah menghasilkan informasi performance dari sapi, laporan-laporan produksi, reproduksi dan analisa dari Sapi Perah. Analisa yang bisa dilakukan dengan Aplikasi Breeding ini diantaranya seperti Calving Interval (CI), Service Per Conception (SC), Days Open (DO), IB Post Partus  -->
</p>
               
            </article>

        </div>
        <aside>
            <article class="profile card">
                <h2>
                    <header>e-Breeding BBPTUHPT Baturraden</header>
                </h2>
                <p>
                <header>Balai Besar Pembibitan Hijauan Pakan Ternak Baturraden</header>
                </p>
                <header>
                    <figure>
                        <img src="/assets/images/bbptusp.png">
                        <figcaption>BBPTUHPT</figcaption>
                    </figure>
                </header>
                <section>
                    <!-- <h3>Informasi Lainnya</h3>
                    <table>
                        <tr>
                            <th>Negara</th>
                            <td>Indonesia</td>
                        </tr>
                        <tr>
                            <th>Hari jadi</th>
                            <td>25 September 1810</td>
                        </tr>
                        <tr>
                            <th>Luas Total</th>
                            <td>167.67 km<sup>2</sup></td>
                        </tr>
                        <tr>
                            <th>Bahasa Daerah</th>
                            <td>Sunda</td>
                        </tr>
                        <tr>
                            <th>Kode Telepon</th>
                            <td>+62 22</td>
                        </tr>
                    </table> -->
                </section>

            </article>
        </aside>
    </main>
    <footer>
        e-Breeding &#169; 2020 BBPTUHPT Baturraden 
    </footer>
    <script src="/assets/template/adminlte2/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script type="text/javascript" src="/assets/slider/jquery.nivo.slider.js"></script>
            <script type="text/javascript">
            $(window).load(function() {
                $('#slider').nivoSlider();
            });
            </script>
            <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-36251023-1']);
            _gaq.push(['_setDomainName', 'jqueryscript.net']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') +
                    '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();
            </script> 
    <script>
    // var myVar = setInterval(ganti, 5000);
    var i=0;
    function ganti() {

        let slides = $('.slide');
        slides.hide();
        i++;
        if(i>=slides.length)i=0;
        console.log(i);
        $('#gb'+i).fadeIn();
        // if (slides[0].style.display == "none") {
        //     // slides[0].style.display = "inline";
        //     // slides[1].style.display = "none"

        // } else {
        //     // slides[0].style.display = "none";
        //     // slides[1].style.display = "inline"
        // }
    }
    </script>
</body>

</html>