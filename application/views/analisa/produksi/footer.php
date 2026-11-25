<script src="/assets/js/list.js"></script>
<script src="/assets/js/app.js"></script>
<script>
$(document).ready(function() {
    var textRenderer = $.fn.dataTable.render.text();
    var productionNumber = new Intl.NumberFormat('id-ID', {minimumFractionDigits: 1, maximumFractionDigits: 1});
    var factorNumber = new Intl.NumberFormat('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    function text(value, type) {
        if (value === null || value === undefined || value === '') {
            return type === 'display' ? '—' : '';
        }
        return type === 'display' ? textRenderer.display(String(value)) : value;
    }
    function numeric(format) {
        return function(value, type) {
            if (value === null || value === undefined || value === '') {
                return type === 'display' ? '—' : null;
            }
            return type === 'display' ? format.format(Number(value)) : Number(value);
        };
    }
    $('#tbldata').DataTable({
        dom: 'Bfrtip',
        processing: true,
        responsive: true,
        order: [],
        language: {
            processing: 'Menghitung analisis produksi...',
            emptyTable: 'Tidak ada data produksi untuk filter yang dipilih.'
        },
        lengthMenu: [[10, 20, 25, 50, -1], ['10 baris', '20 baris', '25 baris', '50 baris', 'Semua Baris']],
        buttons: ['pageLength', 'excel', 'pdf', 'print'],
        ajax: function(request, callback) {
            $('#analisaError').hide();
            $.ajax({
                url: '<?php echo site_url('analisa/produksi/get_all_data'); ?>',
                type: 'GET',
                dataType: 'json'
            }).done(function(rows) {
                if (!Array.isArray(rows)) {
                    $('#analisaError').text('Respons analisis tidak valid. Muat ulang halaman untuk mencoba kembali.').show();
                    callback({data: []});
                    return;
                }
                callback({data: rows});
            }).fail(function() {
                $('#analisaError').text('Analisis gagal dimuat. Muat ulang halaman untuk mencoba kembali.').show();
                callback({data: []});
            });
        },
        columns: [
            {data: null, defaultContent: '', orderable: false},
            {data: 'nomorregister', render: text},
            {data: 'tagsapi', render: text},
            {data: 'tgllahir', render: text},
            {data: 'xlaktasi', render: text},
            {data: 'laktasi_bulanke', render: text},
            {data: 'laktasi_jumlahsusu', render: numeric(productionNumber)},
            {data: 'tgllaktasi', render: text},
            {data: 'tglproduksi', render: text},
            {data: 'jhp', render: text},
            {data: 'umur', render: text},
            {data: 'jumlahhari', render: text},
            {data: 'produksisebelum', render: numeric(productionNumber)},
            {data: 'produksibulanan', render: numeric(productionNumber)},
            {data: 'produksinyata', render: numeric(productionNumber)},
            {data: 'koreksiumur', render: numeric(factorNumber)},
            {data: 'koreksijhp', render: numeric(factorNumber)},
            {data: 'produksiterkoreksi', render: numeric(productionNumber)},
            {data: 'status_koreksi', defaultContent: '', render: text}
        ],
        columnDefs: [{targets: [4, 5, 6, 9, 11, 12, 13, 14, 15, 16, 17], className: 'text-right'}],
        rowCallback: function(row, data, index) {
            var start = this.api().page.info().start;
            $('td:eq(0)', row).text(start + index + 1);
        }
    });
});
</script>
</body>
</html>
