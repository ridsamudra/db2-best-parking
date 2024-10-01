<!DOCTYPE html>
<!--------------------------------------------- head --------------------------------------->
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!--script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.min.js"></script-->
    <!--script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script-->
    <script src="<?php echo constant('svr_lib');?>/jspdf.min.js"></script>
    <link rel="stylesheet" type="text/css" href= "<?php echo constant('svr_lib');?>/font.css"> 
    <title><?php echo constant('app_title');?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        :root {
            --main-color:#FF7F27;
            --main-color-trans-1:rgb(255, 127, 39, 0.25);
            --main-color-trans-2:rgb(255, 127, 39, 0.5);
            --main-color-trans-3:rgb(255, 127, 39, 0.75);
            --main-color-trans-4:rgb(255, 127, 39, 1);
            --black-1:#000000;
            --black-2:#313131;
            --black-3:#404040;
            --nav-bar-height:30px;
            --menu-bar-height: 50px;
            --menu-item-height:40px;
            --menu-item-width:150px;}

        h1, h2, h3, h4, h5 {
            padding: 0px;
            margin: 0px;
            font-weight: lighter;}
        .icon-size {
            font-size: 150%;}
        body {
            font-family: 'Calibri';
            width: 100%;
            margin: 0px;}
        div {
            border: 0px solid gray;
            box-sizing: border-box;}
        .logo {
            background-image: url('<?php echo constant('svr_lib')?>/logo2.png');
            background-size: 100% 100%;
            width: 100%;
            background-repeat: no-repeat;
            background-position: center;}

        /* FORM */
        .form {
            margin: auto;
            margin-top: 50px;
            background-color: var(--black-2);
            color: white;
            font-size: 80%;}
        .form-header {
            background-image: linear-gradient(var(--main-color-trans-2), var(--black-2));
            background-color: none;
            display: flex;
            flex-direction: row;
            justify-content:space-between;
            align-items: center;
            padding: 10px;
            height:40px;
            font-weight: bold;}
        .form-icon {
                font-size: 150%;}
        .form-content span{
                display: block;}
        .form-content {
            padding: 10px;}
        .form-content span{
                margin-bottom: 5px;}
        .form-content input[type=text], input[type=password] {
                padding: 5px;
                border: none;
                border-bottom: 1px solid white;
                color : white;
                background-color: var(--black-2);
                width: calc(100% - 10px);}
        .form-footer {
            background-image: linear-gradient(var(--black-2), var(--main-color-trans-2));
            background-color: none;
            display: flex;
            flex-direction: row;
            justify-content:space-between;
            align-items:center;
            padding: 10px;}
        .form button {
            width: 120px;
            color: white;
            border: none;
            cursor: pointer;
            height: 35px;
            background: none;}
        .form button:hover {
            background-image: linear-gradient(var(--main-color-trans-2), var(--black-1));}

        /* MENU */
        .menu-container {
            position: absolute;
            height: calc(100vh - var(--menu-bar-height));
            background-color: #C0C0C0;
            display: none;
            z-index: 1;}
        .menu-item {
            display: flex;
            flex-direction: row;}
        .menu-content {
            display: none;}
        .menu-content-item {
            position: absolute;
            background-color: var(--black-2);}
        .menu-button {
            width: var(--menu-item-width);
            color: white;
            border: none;
            cursor: pointer;
            height: var(--menu-item-height);
            text-align: left;
            background: var(--black-3);
            /*background-image: linear-gradient(var(--main-color-trans-1), var(--black-1));*/
            }
        .menu-item:hover .menu-button 
            {
            /*background-image: linear-gradient(var(--main-color-trans-3), var(--black-2));*/
            background: var(--main-color);
            }
        .menu-item:hover .menu-content {
            display: block;}
        .sub-menu-button {
            width: var(--menu-item-width);
            color: white;
            border: none;
            cursor: pointer;
            height: var(--menu-item-height);
            text-align: left;
            background: var(--black-3);
            /*background-image: linear-gradient(var(--main-color-trans-1), var(--black-1));*/
        }
        .sub-menu-button:hover 
            {
                /*background-image: linear-gradient(var(--main-color-trans-3), var(--black-2));*/
                background-color: var(--main-color);
            }
        .menu-content span {
            font-size: 150%;}
        .shadow {
            box-shadow: 5px 5px 5px #888888;}

       /* MENU BAR */
       .menu-bar {
            height: var(--menu-bar-height);
            display: flex;
            flex-direction: row;
            color: white;
            background-color: var(--black-1);
            justify-content: space-between;
            align-items: center;
            background-image: linear-gradient(var(--main-color-trans-2), var(--black-1)) ;}
        .menu-bar-icon{
            font-size: 150%;
            padding: 5px;
            cursor: pointer;}
        .menu-bar-title {
            text-align: center;
            flex: 1;
            padding: 5px;}
        .menu-bar-user {
            padding: 5px;}
        .menu-bar-user span {
            display: block;
            font-size: 10px;}

        /* NAV BAR */
        .nav-bar {
                background-color: white;
                border: none;
                height : var(--nav-bar-height);
                display: flex;
                flex-direction: row;}
        .nav-btn {
                border: none;
                padding-top: 0px;
                padding-bottom: 0px;
                padding-left: 10px;
                padding-right: 10px;
                /*border-radius: 15px;*/
                cursor: pointer;
                margin-left: 10px;
                color: black;
                background-color: white;
                /*background-image: linear-gradient(var(--main-color-trans-2), var(--black-1));*/}
        .nav-btn:hover {
                /*background-image: linear-gradient(var(--main-color-trans-3), var(--black-1));*/
                background-color: var(--main-color);
                }
 
        /* FLOAT BUTTON */
        .float-buttons {
            z-index: 2;
            position: absolute;
            bottom: 5px;
            right: 25px;
            padding: 10px;
            display: flex;
            flex-direction: column;}
        .float-buttons button{
            margin-top: 10px;
            border: none;
            width: 48px;
            height: 48px;
            border-radius: 24px;
            cursor: pointer;
            font-size: 150%;
            color: white;
            background-color: #888888;
            opacity: 0.5;}
        .float-buttons button:hover {opacity: 1}


        /* TABLE */
        table
            {
                background-color: var(--black-2);
                /*background-image: linear-gradient(var(--main-color-trans-2), var(--black-1));*/
                white-space: nowrap;
                border-collapse	: collapse;
                color: white;
                font-size: 80%;
            }

        th
            {
                background-image: linear-gradient(var(--main-color-trans-2), var(--black-1));
            }

        th, td
        {
            /*background-color: none;*/
            padding: 5px;
            cursor: pointer;
            border: 1px solid var(--black-1);
        }

        tr:hover td
            {
                background-image: linear-gradient(var(--main-color-trans-2), var(--black-2));
            }

        /* FONT */
        .font-s {font-size: 12px;}
        .font-m {font-size: 14px;}
        .font-l {font-size: 16px;}
        .font-xl {font-size: 18px;}
        .font-xxl {font-size: 20px;}
        .font-xxxl {font-size: 24px;}
        .bold {font-weight: bold;}
        .center {text-align: center;}
        .right {text-align: right;}

        .modal {
            display: none;
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 2;}
        .content {
            border : 0px solid blue;
            width: 100vw;
            height: calc(100vh - var(--menu-bar-height) - var(--nav-bar-height));
            overflow: auto;
            background-color: white;
            z-index: -1;}
        .page {
            width: 100vw;
        }


        /* DATA */
        .flex{
            display: flex;
            flex-direction: row;
            padding-top: 10px;}
        .item-width {
                width : 32%;}
        .item-height {
                height : 33%;}
        .flex-item {
                display: flex;
                flex-direction: column;
                padding-left: 10px;}
        .flex-item-header {
            padding: 5px;
            background-color: black;
            text-align: center;
            font-weight: bold;
            color: white;
            font-size: 12px;}
        .flex-item-content {
                flex: 1;}
        .flex-item-content-detail {
                min-width: 120px;
                max-height: 80px;
                display: flex;
                flex-direction: column;
                background-color: var(--black-3);
                padding: 5px;
                margin: 5px;
                /*border-radius: 15px;*/
                text-align: center;
                /*background-image: linear-gradient(var(--main-color-trans-1), var(--black-1));*/
                }
        .flex-item-content-detail span {
                display: block;
                font-size: 12px;}
        .flex-item-footer {
            display: flex;
            flex-direction: column;
            min-height: 15px;
            /*background-color: none;*/
            background-color: var(--black-3);
            text-align: center;
            color: white;
            font-size: 12px;}
            

        @media screen and (max-width: 900px) {
            .flex
            {
            display: flex;
            flex-direction: column;
            }

            .item-width
            {
                width : 100%;
            }

            .item-height
            {
                height : unset;
            }

            .flex-item
            {
                flex : unset;
                margin-top: 10px;
            }

            .page 
            {
            width: calc(100vw - 30px);
            }}

        select {
                padding: 5px;
                color : gray;}



    </style>
</head>

<body style = "background-color: #E6E6E6;" onresize="body_resize()">
    <div id = "float-buttons" class="float-buttons">
    </div>

    <div id = "modal-container">
        <!--login-->
        <div id="id-login" class="modal">
            <div id="" class="form" style="width: 300px;">
                <div class="form-header">
                    <span class="form-caption">Login</span>
                    <span class="icon-key form-icon"></span>
                </div>
                <div class="form-content">
                    <span>User ID</span>
                    <input id="i_user_id" type="text"></input>
                    <span>Password</span>
                    <input id="i_password" type="password"></input>
                </div>
                <div class="form-footer">
                    <button onclick="next_login();"><span class="icon-checkmark1 form-icon" style="color: lime;"></span> OK</button>
                    <button onclick="close_modal()"><span class="icon-cancel form-icon" style="color: red;"></span> Cancel</button>
                </div>
            </div>
        </div>

        <!--ganti pass-->
        <div id="id-ganti-password" class="modal">
            <div id="" class="form" style="width: 300px;">
                <div class="form-header">
                    <span class="form-caption">Ganti Password</span>
                    <span class="icon-key form-icon"></span>
                </div>
                <div class="form-content">
                    <span >Password Lama</span>
                    <input id="i_pass_lama" type="password"></input>
                    <span >Password Baru</span>
                    <input id="i_pass_baru" type="password"></input>
                    <span >Ulangi Password Baru</span>
                    <input id="i_pass_baru_2" type="password"></input>
                </div>
                <div class="form-footer">
                    <button onclick="next_ganti_password();"><span class="icon-checkmark1 form-icon" style="color: lime;"></span> OK</button>
                    <button onclick="close_modal()"><span class="icon-cancel form-icon" style="color: red;"></span> Cancel</button>
                </div>
            </div>
        </div>

        <!--message box-->
        <div id="id-message" class="modal">
            <div id="" class="form" style="width: 250px;">
                <div class="form-header">
                    <span class="form-caption" id="caption-message">Login</span>
                    <span id="icon-message" class="icon-key form-icon"></span>
                </div>
                <div class="form-content">
                    <span id="text-message">User ID</span>
                </div>
                <div class="form-footer">
                    <button id="message-ok"><span style="color:lime;" class="icon-checkmark1 form-icon"></span> OK</button>
                    <button id="message-cancel" onclick="close_modal()"><span style = "color:red" class="icon-cancel form-icon"></span> Cancel</button>
                </div>
            </div>
        </div>
    </div>


    <!-- start body -->
    <div class="menu-bar">
        <div>
            <span class="icon-menu3 menu-bar-icon" id="menu-icon" onclick="toggle_menu()"></span>
        </div>
        <div id = "page-title" class="menu-bar-title">
        </div>

        <!--div class="menu-bar-user">
            <span class="font-s"><?php echo constant('app_company');?></span>
            <span class="font-s"><?php echo constant('app_copyright');?></span>
        </div-->

        <div class="menu-bar-user">
            <?php 
            if(is_logged())
                echo 
                '
                <span class="font-s">'.$_SESSION['id_user'.constant('app_name')].'</span>
                <span class="font-s">'.$_SESSION['nama_user'.constant('app_name')].'</span>
                ';
            ?>
        </div>
        <div>
            <span class="icon-home menu-bar-icon" id="" onclick="window.open('<?php echo constant('svr_ui');?>/ui_main.php','_self')"></span>
        </div>
    </div>

    <div id="menu-container" class="menu-container">
        <div class="logo" style="width:var(--menu-item-width);height: var(--menu-item-height);)"></div>

        <?php
        if(is_logged())
            {
                // --- start php ----
                echo '<div class="menu-item"">
                    <button class="menu-button"><span class="icon-banknote"></span> Pendapatan</button>
                        <div class="menu-content">
                            <div class="menu-content-item">
                                <!--sub menu 1-->
                                <button class="sub-menu-button" onclick="window.open(\''.constant("svr_ui").'/ui_daily.php\',\'_self\')"><span class="icon-calendar"></span> Harian</button>
                                <!--sub menu 2-->
                                <button class="sub-menu-button" onclick="window.open(\''.constant("svr_ui").'/ui_monthly.php\',\'_self\')"><span class="icon-calendar"></span> Bulanan</button>
                                <!--sub menu 3-->
                                <button class="sub-menu-button" onclick="window.open(\''.constant("svr_ui").'/ui_annualy.php\',\'_self\')"><span class="icon-calendar"></span> Tahunan</button>
                            </div>
                        </div>
                </div>';
                // --- end php ----
                if($_SESSION['admin'.constant('app_name')] == 1)
                {
                    echo '<div class="menu-item">
                        <button class="menu-button"><span class="icon-users"></span> Admin</button>
                        <div class="menu-content"">
                            <div class="menu-content-item">
                                <!--sub menu 1-->
                                    <button class="sub-menu-button" onclick="window.open(\''.constant("svr_ui").'/ui_user.php\',\'_self\')"><span class="icon-users"></span> Daftar User</button>
                                <!--sub menu 2-->
                                    <button class="sub-menu-button" onclick="window.open(\''.constant("svr_ui").'/ui_user_location.php\',\'_self\')"><span class="icon-location"></span> Lokasi User</button>
                            </div>
                        </div>
                    </div>';
                }
            }
        ?>

        <!--menu 3-->
        <div class="menu-item">
            <?php
                if(is_logged())
                    echo '<button class="menu-button"><span class="icon-user"></span> '.$_SESSION['id_user'.constant('app_name')].'</button>';
                else    
                    echo '<button class="menu-button"><span class="icon-user"></span> User</button>';
            ?>

            <div class="menu-content">
                <div class="menu-content-item">

                    <?php
                    if(is_logged())
                        {
                            echo '
                            <button class="sub-menu-button" onclick="do_logout()"><span class="icon-exit"></span> Logout</button>
                            <button class="sub-menu-button"  onclick="do_ganti_password()"><span class="icon-key"></span> Ganti Password</button>
                            ';
                        }
                    else
                        {
                            echo '
                            <button class="sub-menu-button"  onclick="do_login()""><span class=" icon-enter"></span> Login</button>
                            ';
                        }
                    ?>

                </div>
            </div>
        </div>
    </div>

    <div id="nav-bar" class="nav-bar">
    </div>

    <!--content-->
    <div id="content" class="content">
