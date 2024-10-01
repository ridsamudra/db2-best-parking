<?php include $_SERVER['DOCUMENT_ROOT'].'/dash/init_dash.php';?>
<?php include constant('doc_ui').'/ui_header.php';?>
<?php include constant('doc_ui').'/ui_footer.php';?>


<script>

    var selected_user = -1;
    function user_click(arr)
    {
        data = get_childs_str(arr);
        inp = new Object();
        inp.token = "get_location_access";
        inp.id = data[0];
        selected_user = data[0];
        s = document.getElementById("selected-user");
        s.innerHTML = "Pilih akses lokasi untuk user " + data[1];
        s.style.color = "#FF5C0F";

        send(svr_intf + '/intf_get_location_access.php', inp,
        function(resp)
            {
                lokasi = resp.lokasi;
                fill_checkbox("daftar-lokasi", lokasi[0], lokasi[1], lokasi[2]);
            }
        );
    }

    function get_user() {
        // query user
        inp = new Object();
        inp.token = "get_user";
        send(svr_intf + '/intf_get_user.php', inp,
            function (inp) {
                if (inp.err == 0) {
                    inp.user.visible[0] = 0;
                    create_table("tabel-user", inp.user, "user_click","Daftar User", false);
                }
            }
        );
    }

    function on_load_event() {
        // page
        p = add_child("content", "page", "div");
        p.className = "page shadow";
        
        // chapter
        c = add_child(p.id, "c" + p.id, "div");
        c.className = "chapter";

        ci = add_child(c.id, "tabel-user", "div");
        ci.className = "chapter-item";

        s = add_child(c.id,  "s1" + c.id, "span");
        s.innerHTML = "* Pilih/click user pada daftar untuk diberikan hak akses melihat data lokasi";
        s.className = "font-s";
        s.style.color = "#698ED3";

        c = add_child(p.id, "info-user", "div");
        c.className = "chapter";

        s = add_child(c.id, "selected-user", "span");
        s.className = "font-l";


        c = add_child(p.id, "daftar-lokasi", "div");
        c.className = "chapter";

        c = add_child(p.id, "save-btn", "div");
        c.className = "chapter";

        f = add_child(c.id, "f", "div")
        f.className = "form";
        f.style.margin = "0px";

        f1 = add_child(f.id, "f1", "div");
        f1.className = "form-footer";


        b = add_child(f1.id, "", "button");
        b.innerHTML = "Simpan";
        b.onclick = function()
        {
            if(selected_user == -1)
                return;
            inp = new Object();
            inp.token = "set_location_access";
            inp.id = selected_user;
            inp.lokasi = get_checkbox_value("daftar-lokasi");
            send(svr_intf + '/intf_set_location_access.php', inp,
                function (inp) {
                    if (inp.err == 0) 
                        message('Akses Lokasi', inp.msg , msg_ok, null);
                    else
                        message('Akses Lokasi', inp.msg , msg_err, null);
                }
            );
        }
        
        get_user();
    }

</script>