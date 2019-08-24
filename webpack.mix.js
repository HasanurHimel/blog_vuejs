const mix = require('laravel-mix');



mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');



// frontend
mix.styles([
    'resources/css/frontend/bootstrap.min.css',
    'resources/css/frontend/animate.css',
    'resources/css/frontend/font.css',
    'resources/css/frontend/li-scroller.css',
    'resources/css/frontend/slick.css',
    'resources/css/frontend/theme.css',
    'resources/css/frontend/style.css',
    'resources/css/frontend/prism.css',
], 'public/css/frontend_all.css')
    .scripts([
        'resources/js/frontend/jquery.min.js',
        'resources/js/frontend/wow.min.js',
        'resources/js/frontend/bootstrap.min.js',
        'resources/js/frontend/slick.min.js',
        'resources/js/frontend/jquery.li-scroller.1.0.js',
        'resources/js/frontend/jquery.newsTicker.min.js',
        'resources/js/frontend/jquery.fancybox.pack.js',
        'resources/js/frontend/custom.js',
        'resources/js/frontend/prism.js',
    ], 'public/js/frontend_all.js').version();


                  // backend

mix.styles([
    'resources/css/backend/blue.css',
    'resources/css/backend/bootstrap3-wysihtml5.min.css',
    'resources/css/backend/dataTables.bootstrap4.css',
    'resources/css/backend/datepicker3.css',
    'resources/css/backend/daterangepicker-bs3.css',
    'resources/css/backend/jquery-jvectormap-1.2.2.css',
    'resources/css/backend/morris.css',
    'resources/css/backend/adminlte.min.css',
    'resources/css/backend/select2.min.css',
    'resources/css/backend/samples.css',
    'resources/css/backend/neo.css',
], 'public/css/backend_all.css')
    .scripts([
        'resources/js/backend/bootstrap.bundle.js',
        'resources/js/backend/adminlte.js',
        'resources/js/backend/select2.full.min.js',
        'resources/js/backend/ckeditor.js',
        'resources/js/backend/sample.js',
        // 'resources/js/backend/bootstrap3-wysihtml5.all.min.js',
        // 'resources/js/backend/bootstrap-datepicker.js',
        // 'resources/js/backend/dashboard.js',
        // 'resources/js/backend/dataTables.bootstrap4.js',
        // 'resources/js/backend/daterangepicker.js',
        // 'resources/js/backend/demo.js',
        // 'resources/js/backend/fastclick.js',
        // 'resources/js/backend/jquery.dataTables.js',
        // 'resources/js/backend/jquery.knob.js',
        // 'resources/js/backend/jquery.min.js',
        // 'resources/js/backend/jquery.slimscroll.min.js',
        // 'resources/js/backend/jquery.sparkline.min.js',
        // 'resources/js/backend/jquery-jvectormap-1.2.2.min.js',
        // 'resources/js/backend/jquery-jvectormap-world-mill-en.js',
        // 'resources/js/backend/morris.js',

    ], 'public/js/backend_all.js').version();


