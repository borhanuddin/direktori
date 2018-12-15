<!DOCTYPE html>
<html lang="ms">

<head>
    
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Direktori MdI - Pentadbir</title>
    
    <!-- Favicon -->
    <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo base_url(); ?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo base_url(); ?>plugins/node-waves/waves.css" rel="stylesheet" />
    
    <!-- Animation Css -->
    <link href="<?php echo base_url(); ?>plugins/animate-css/animate.css" rel="stylesheet" />
    
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo base_url(); ?>css/themes/all-themes.css" rel="stylesheet" />
    <?php
    if (isset($extraCSS) and is_array($extraCSS)) {
        foreach ($extraCSS as $commnet => $css) {
            echo "\n\t<!-- $commnet -->\n\t";
            $link = (substr( $css, 0, 2 ) === "//") ? $css : base_url() . $css;
            echo "<link href=\"$link\" rel=\"stylesheet\">\n";
            
            echo (end($extraCSS) !== $css) ? "\t" : "\n";
        }
    } else { echo "\n"; }
    ?>
    <!-- Custom Css -->
    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/custom.css" rel="stylesheet">
    <?php
    if (isset($customCSS) and is_array($customCSS)) {
        foreach ($customCSS as $css) {
            echo "<link href=\"" . base_url() . "$css\" rel=\"stylesheet\">\n";
            
            echo (end($customCSS) !== $css) ? "\t" : "\n";
        }
    } else { echo "\n"; }
    ?>
</head>

<body class="theme-mdi">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
<!--    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>-->
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?php echo site_url('pentadbir/dashboard'); ?>">Pentadbir Sistem Direktori MdI</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <!--<li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>-->
                    <!-- #END# Call Search -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <?php
                    $NamaImg = explode("@", $userdata['staf_emel']);
                    $StafImage = "images/staf/{$NamaImg[0]}.jpg";
                    $StafImage = (@getimagesize($StafImage)) ? base_url($StafImage) : $StafImage = '../../images/user.png';
                    ?>
                    <img src="<?php echo $StafImage; ?>" style="border-radius: 10%;" width="34" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $userdata['staf_nama']; ?></div>
                    <div class="email"><?php echo $userdata['staf_emel']; ?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="<?php echo site_url('pentadbir/profail'); ?>"><i class="material-icons">person</i>Profail</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="<?php echo site_url('pentadbir/log_keluar'); ?>"><i class="material-icons">input</i>Log Keluar</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">NAVIGASI UTAMA</li>
                    <li<?php if ('DASHBOARD' == $title) { echo ' class="active"'; } ?>>
                        <a href="<?php echo site_url('pentadbir/dashboard'); ?>">
                            <i class="material-icons">dashboard</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li<?php if ('ORGANISASI' == $title) { echo ' class="active"'; } ?>>
                        <a href="<?php echo site_url('pentadbir/organisasi'); ?>">
                            <i class="material-icons">account_balance</i>
                            <span>Organisasi</span>
                        </a>
                    </li>
                    <li<?php if ('PENJAWATAN' == $title) { echo ' class="active"'; } ?>>
                        <a href="<?php echo site_url('pentadbir/penjawatan'); ?>">
                            <i class="material-icons">contacts</i>
                            <span>Penjawatan</span>
                        </a>
                    </li>
                    <li<?php if ('STAF' == $title) { echo ' class="active"'; } ?>>
                        <a href="<?php echo site_url('pentadbir/staf'); ?>">
                            <i class="material-icons">wc</i>
                            <span>Staf</span>
                        </a>
                    </li>
                    <li<?php if ('GAMBAR' == $title) { echo ' class="active"'; } ?>>
                        <a href="<?php echo site_url('pentadbir/gambar'); ?>">
                            <i class="material-icons">account_box</i>
                            <span>Gambar</span>
                        </a>
                    </li>
                    <li class="header">&nbsp;</li>
                    <li>
                        <a href="<?php echo site_url(); ?>" target="_blank">
                            <i class="material-icons col-red">launch</i>
                            <span>Sistem Direktori</span>
                        </a>
                    </li>
<!--                    <li>
                        <a href="javascript:void(0);">
                            <i class="material-icons col-amber">donut_large</i>
                            <span>Warning</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">
                            <i class="material-icons col-light-blue">donut_large</i>
                            <span>Information</span>
                        </a>
                    </li>-->
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2017 <a href="javascript:void(0);">MdI - Direktori</a>.
                </div>
                <div class="version" title="Released Candidate #01">
                    <b>Versi: </b> 1.0.3
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
                <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <li data-theme="red" class="active">
                            <div class="red"></div>
                            <span>Red</span>
                        </li>
                        <li data-theme="pink">
                            <div class="pink"></div>
                            <span>Pink</span>
                        </li>
                        <li data-theme="purple">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>
                        <li data-theme="deep-purple">
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                        <li data-theme="indigo">
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                        <li data-theme="blue">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="light-blue">
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                        <li data-theme="cyan">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="teal">
                            <div class="teal"></div>
                            <span>Teal</span>
                        </li>
                        <li data-theme="green">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="light-green">
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                        <li data-theme="lime">
                            <div class="lime"></div>
                            <span>Lime</span>
                        </li>
                        <li data-theme="yellow">
                            <div class="yellow"></div>
                            <span>Yellow</span>
                        </li>
                        <li data-theme="amber">
                            <div class="amber"></div>
                            <span>Amber</span>
                        </li>
                        <li data-theme="orange">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="deep-orange">
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                        <li data-theme="brown">
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                        <li data-theme="grey">
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                        <li data-theme="blue-grey">
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                        <li data-theme="black">
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="settings">
                    <div class="demo-settings">
                        <p>GENERAL SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Paparan Navigasi</span>
                                <div class="switch">
                                    <label><input id="chkSidebar" type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
<?php echo $content; ?> 
        </div>
    </section>

    <!-- Jquery Core Js -->
    <script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.js"></script>
    
    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo base_url(); ?>plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
    
    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo base_url(); ?>plugins/node-waves/waves.js"></script>
    
    <!-- Jquery CountTo Plugin Js -->
    <script src="<?php echo base_url(); ?>plugins/jquery-countto/jquery.countTo.js"></script>
    
    <!-- Bootstrap Notify Plugin Js -->
    <script src="<?php echo base_url(); ?>plugins/bootstrap-notify/bootstrap-notify.js"></script>
    <?php
    if (isset($extraJS) and is_array($extraJS)) {
        foreach ($extraJS as $commnet => $js) {
            echo "\n\t<!-- $commnet -->";
            if (is_array($js)) {
                foreach($js as $js2) {
                    $link = (substr( $js2, 0, 2 ) === "//") ? $js2 : base_url() . $js2;
                    echo "\n\t<script src=\"$link\"></script>";
                    echo (end($js) !== $js2) ? "\t" : "\n\t";
                }
            } else {
                $link = (substr( $js, 0, 2 ) === "//") ? $js : base_url() . $js;
                echo "\n\t<script src=\"$link\"></script>\n";
            }
            
            echo (end($extraJS) !== $js) ? "\t" : "\n";
        }
    } else { echo "\n"; }
    ?>
    <!-- Custom js -->
    <script>var base_url = '<?php echo base_url(); ?>';</script>
    <script src="<?php echo base_url(); ?>js/admin_settings.js"></script>
    <script src="<?php echo base_url(); ?>js/admin.js"></script>
    <script src="<?php echo base_url(); ?>js/demo.js"></script>
    <?php
    if (isset($customJS) and is_array($customJS)) {
        foreach ($customJS as $cjs) {
            echo "<script src=\"" . base_url() . "$cjs\"></script>";
            echo (end($customJS) !== $cjs) ? "\n\t" : "\n\t\n";
        }
    } else { echo "\n"; }
    ?>
    <?php
    if ($this->session->flashdata()) {
        $flashdataKey = key($this->session->flashdata());
        $flashdataMsg = $this->session->flashdata($flashdataKey);
    ?>
    <script>
        $(function () {
            showNotification('<?php echo $flashdataKey; ?>', '<?php echo $flashdataMsg; ?>', 'bottom', 'center');
        });
        
        function showNotification(colorName, text, placementFrom, placementAlign, animateEnter, animateExit) {
            if (colorName === null || colorName === '') { colorName = 'bg-black'; }
            if (text === null || text === '') { text = 'Turning standard Bootstrap alerts'; }
            if (animateEnter === null || animateEnter === '') { animateEnter = 'animated fadeInDown'; }
            if (animateExit === null || animateExit === '') { animateExit = 'animated fadeOutUp'; }
            var allowDismiss = true;

            $.notify({
                // options
                message: text
            },
            {
                // settings
                type: colorName,
                allow_dismiss: allowDismiss,
                newest_on_top: true,
                timer: 1000,
                placement: {
                    from: placementFrom,
                    align: placementAlign
                },
                animate: {
                    enter: animateEnter,
                    exit: animateExit
                },
                template: '<div data-notify="container" class="bootstrap-notify-container alert alert-dismissible {0} ' + (allowDismiss ? "p-r-35" : "") + '" role="alert">' +
                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                    '<span data-notify="icon"></span> ' +
                    '<span data-notify="title">{1}</span> ' +
                    '<span data-notify="message">{2}</span>' +
                    '<div class="progress" data-notify="progressbar">' +
                    '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                    '</div>' +
                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
                    '</div>'
            });
        };
    </script>
    <?php } ?>

</body>

</html>