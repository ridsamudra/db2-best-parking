<!DOCTYPE html>
<!--------------------------------------------- head --------------------------------------->
<head>
    <link rel="stylesheet" type="text/css" href= "<?php echo constant('svr_lib');?>/font.css"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <title><?php echo constant('app_title');?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        :root {
            --menu-height: 40px;
            --menu-width: 150px;
            --menu-bk-color: #343C49;
            --menu-fg-color: white;
            --menu-hover-color: #4E596D;
            --icon-size: 30px;

            --menu-bar-bk-color: #66C2AF;
            --menu-bar-fg-color: white;

            --form-bk-color: #66C2AF;
            --form-fg-color: white;
            --form-hover-color: #9CD8CC;
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            padding: 0px;
            margin: 0px;
            font-weight: lighter;
        }

        .icon-size {
            font-size: 150%;
        }

        span {
            display: block;
        }

        body {
            font-family: 'Calibri';
            width: 100%;
            margin: 0px;
        }

        div {
            border: 0px solid gray;
            box-sizing: border-box;
        }

        .logo {
            background-image: url('<?php echo constant('svr_lib')?>/logo1.png');
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: center;
        }

        .shadow {
            box-shadow: 5px 5px 5px #888888;
        }

        /* menu bar*/
        .menu-bar {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            height: var(--icon-size);
            background-color: var(--menu-bar-bk-color);
            color: var(--menu-bar-fg-color);
            padding-left: 10px;
            padding-right: 10px;
        }

        /* menu */
        .menu-container {
            position: absolute;
            width: fit-content;
            height: calc(100vh - var(--icon-size));
            background-color: var(--menu-bk-color);
            display: none;
        }

        .menu {
            display: flex;
            flex-direction: row;
            height: var(--menu-height);
            width: var(--menu-width);
            background-color: var(--menu-bk-color);
            color: var(--menu-fg-color);
            cursor: pointer;
            white-space: nowrap;
            justify-content: space-between;
            align-items: center;
        }

        .menu-icon {
            font-size: 150%;
            display: flex;
            justify-content: center;
            align-items: center;
            width: var(--icon-size);
            height: var(--icon-size);
            cursor: pointer;
        }

        .menu-label {
            margin: auto;
            flex: 1;
        }

        .menu:hover {
            background-color: var(--menu-hover-color);
        }


        .menu span {
            display: inline;
            font-size: 150%;
            margin-right: 10px;
        }

        .menu button {
            width: 100%;
            height: 100%;
            background-color: var(--menu-bk-color);
            text-align: left;
            cursor: pointer;
            color: var(--menu-bar-fg-color);
            font-size: 12px;
            padding: 10px;
            vertical-align: center;
            border: none;
        }

        .menu button:hover {
            background-color: var(--menu-hover-color);
        }

        .menu:hover .sub-menu-container {
            display: block;
        }

        /* sub menu */
        .sub-menu-container {
            position: absolute;
            display: none;
        }

        .sub-menu {
            display: flex;
            flex-direction: row;
            height: var(--menu-height);
            width: var(--menu-width);
            background-color: var(--menu-bk-color);
            color: var(--menu-fg-color);
            cursor: pointer;
            white-space: nowrap;
            justify-content: space-between;
            align-items: center;
        }

        .sub-menu a {
            text-decoration: none;
            color: var(--menu-fg-color);
        }

        .sub-menu:hover {
            background-color: var(--menu-hover-color);
        }

        .modal {
            display: none;
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }


        .font-s {
            font-size: 12px;
        }

        .font-m {
            font-size: 14px;
        }

        .font-l {
            font-size: 16px;
        }

        .font-xl {
            font-size: 18px;
        }

        .font-xxl {
            font-size: 20px;
        }

        .font-xxxl {
            font-size: 24px;
        }

        .bold {
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .content {
            width: 100vw;
            height: calc(100vh - var(--icon-size));
            overflow-y: auto;
            background-color: #004646;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .page {
            margin: 5px;
            padding: 5px;
            width: calc(100vw - 35px);
            border: 0px solid black;
            background-color: white;
            border: 1px solid #D4D4D4;
            border-radius: 10px;
            max-width: 600px;
        }

        .page-title {
            background-color: var(--menu-bar-bk-color);
            padding: 5px;
            color: white;
            margin-bottom: 5px;
            border-radius: 5px;
        }

        .chapter {
            background-color: #F2F4F7;
            padding: 5px;
            border-radius: 5px;
            color: #4E596D;
            margin-top: 5px;
        }

        .chapter-items {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: center;
            border-radius: 5px;
            margin-top: 5px;
        }

        .chapter-item {
            background-color: white;
            min-width: 100px;
            padding: 5px;
            border-radius: 5px;
            min-height: 50px;
            margin:5px;
        }

        .form {
            margin: auto;
            margin-top: 50px;
            border-radius: 5px;
            padding: 5px;
            background-color: white;
            color: #4E596D;
            border:1px solid gray;
        }

        .form-header {
            padding: 5px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: baseline;
            background-color: var(--form-bk-color);
        }

        .form-content {
            padding: 5px;
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }

        .form-footer {
            padding: 5px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .form button {
            color: #4E596D;
            border-radius: 5px;
            border: none;
            padding: 5px;
            cursor: pointer;
            white-space: nowrap;
            min-width: 60px;
            background-color: var(--form-bk-color);
        }

        .form button:hover {
            background-color: var(--form-hover-color);
        }

        .float-buttons {
            position: absolute;
            /*top: calc(5px + var(--icon-size));*/
            bottom: 5px;
            right: 25px;
            padding: 10px;
            display: flex;
            flex-direction: column;
        }

        .float-buttons button
        {
            margin-top: 10px;
            border: none;
            width: 48px;
            height: 48px;
            border-radius: 24px;
            cursor: pointer;
            font-size: 150%;
            color: white;
            background-color: #4F5764;
            opacity: 0.2;

        }
        .float-buttons button:hover
        {
            opacity: 1;
        }


    </style>
</head>

<body>
    <div id = "float-buttons" class="float-buttons">
    </div>

    <div id = "modal-container">
        <!--login-->
        <div id="id-login" class="modal">
            <div id="login-form" class="form" style="width: 250px;">
                <div class="form-header">
                    <span class="font-l bold">Login</span>
                    <span class="icon-key"></span>
                </div>
                <div class="form-content">
                    <span class="font-m">User ID</span>
                    <input id="i_user_id" type="text"></input>
                    <span class="font-m">Password</span>
                    <input id="i_password" type="password"></input>
                </div>
                <div class="form-footer">
                    <button class="font-s" onclick="next_login();"><span class="icon-checkmark1"></span>OK</button>
                    <button class="font-s" onclick="close_modal()"><span class="icon-cancel"></span>Cancel</button>
                </div>
            </div>
        </div>

        <!--message box-->
        <div id="id-message" class="modal">
            <div id="login-form" class="form" style="width: 250px;">
                <div class="form-header">
                    <span class="font-m bold" id="caption-message">Login</span>
                    <span id="icon-message" class="icon-key"></span>
                </div>
                <div class="form-content">
                    <span class="font-s" id="text-message">User ID</span>
                </div>
                <div class="form-footer">
                    <button class="font-s" id="message-ok"><span class="icon-checkmark1"></span>OK</button>
                    <button class="font-s" id="message-cancel" onclick="close_modal()"><span class="icon-cancel"></span>Cancel</button>
                </div>
            </div>
        </div>
    </div>


    <!-- start body -->
    <div class="menu-bar">
        <div class="menu-icon">
            <span class="icon-menu3" id="menu-icon" onclick="toggle_menu()"></span>
        </div>
        <div style="flex: 1;display: flex; align-items: center; justify-content: center;">
            <span id = "page-title" class="font-l bold">Title1</span>
        </div>
        <div>
            <?php 
            if(is_logged())
                echo 
                '
                <span class="font-s">'.$_SESSION['id_user'.constant('app_name')].'</span>
                <span class="font-s">'.$_SESSION['nama_user'.constant('app_name')].'</span>
                ';
            ?>
        </div>
    </div>

    <div id="menu-container" class="menu-container">
        <div class="logo" style="width: var(--menu-width);height: var(--menu-height);"></div>

        <?php
        if(is_logged())
            {
                // --- start php ----
                echo '<div class="menu">
                    <button><span class="icon-banknote"></span>Pendapatan</button>
                    <div style="height: var(--menu-height);">
                        <div class="sub-menu-container">
                            <!--sub menu 1-->
                            <div class="sub-menu">
                                <button onclick="window.open(\'\',\'_self\')"><span class="icon-calendar"></span>Harian</button>
                            </div>
                            <!--sub menu 2-->
                            <div class="sub-menu">
                                <button onclick="window.open(\'\',\'_self\')"><span class="icon-calendar"></span>Bulanan</button>
                            </div>
                            <!--sub menu 3-->
                            <div class="sub-menu">
                                <button onclick="window.open(\'\',\'_self\')"><span class="icon-calendar"></span>Tahunan</button>
                            </div>
                        </div>
                    </div>
                </div>';
                // --- end php ----
                if($_SESSION['admin'.constant('app_name')] == 1)
                {
                    echo '<div class="menu">
                        <button><span class="icon-users"></span>Admin</button>
                        <div style="height: var(--menu-height);">
                            <div class="sub-menu-container">
                                <!--sub menu 1-->
                                <div class="sub-menu">
                                    <button onclick="window.open(\'\',\'_self\')"><span class="icon-users"></span>Daftar User</button>
                                </div>
                                <!--sub menu 2-->
                                <div class="sub-menu">
                                    <button onclick="window.open(\'\',\'_self\')"><span class="icon-location"></span>Lokasi
                                        User</button>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            }
        ?>

        <!--menu 3-->
        <div class="menu">
            <button><span class="icon-user"></span>User</button>
            <div style="height: var(--menu-height);">
                <div class="sub-menu-container">

                    <?php
                    if(is_logged())
                        {
                            echo '<div class="sub-menu">
                            <button onclick="do_logout()"><span class="icon-exit"></span>Logout</button>
                            </div>
                            <div class="sub-menu">
                                <button onclick=""><span class="icon-key"></span>Ganti Password</button>
                            </div>';
                        }
                    else
                        {
                            echo '<div class="sub-menu">
                            <button onclick="do_login()""><span class=" icon-enter"></span>Login</button>
                            </div>';
                        }
                    ?>

                </div>
            </div>
        </div>
    </div>


    <!--content-->
    <div id="content" class="content">
