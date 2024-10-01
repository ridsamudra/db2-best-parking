<?php include $_SERVER['DOCUMENT_ROOT'].'/dash/init_dash.php';?>
<?php include constant('doc_ui').'/ui_header.php';?>
<?php include constant('doc_ui').'/ui_footer.php';?>



<script>

function row_click(id_str)
{
    s = get_childs_str(id_str);
    document.getElementById("i-id").value = s[0];
    document.getElementById("i-id-user").value = s[1];
    document.getElementById("i-nama-user").value = s[2];
}

function clear_input()
{
    document.getElementById("i-id").value = -1;
    document.getElementById("i-id-user").value = "";
    document.getElementById("i-nama-user").value = "";
}

function show_user()
{
    // query lokasi
    inp = new Object();
    inp.token = "get_user";
    send(svr_intf + '/intf_get_user.php', inp,
        function (resp) {
            if (resp.err == 0) {
                resp.user.visible[0] = 0;
                create_table("tabel-user", resp.user, "row_click", "Daftar User", false);
            }
        }
    );
}

function on_load_event() 
    {
        document.getElementById('page-title').innerHTML = "Daftar User";

        // page
        p = add_child("content", "page", "div");
        p.className = "page shadow";

        // chapter
        c = add_child(p.id, "d1", "div");
        c.className = "chapter";

        // form
        f = add_child(c.id, "f", "div");
        f.style.margin = "0px";

        f2 = add_child(f.id, "f2", "div");
        f3 = add_child(f.id, "f3", "div");

        f.className = "form";
        f2.className = "form-content";
        f3.className = "form-footer";
        
        i = add_child(f2.id, "i-id","input");
        i.style.display = "none";
        i.type = "text";
        i.value = -1;

        add_child(f2.id, "", "span").innerHTML = "ID User";
        i = add_child(f2.id, "i-id-user","input");
        i.type = "text";
        
        add_child(f2.id, "", "span").innerHTML = "Nama User";
        i = add_child(f2.id, "i-nama-user","input");
        i.type = "text";
        

        b = add_child(f3.id, "", "button");
        b.innerHTML = "Baru";
        b.onclick = function()
                {
                    clear_input();
                };

        b = add_child(f3.id, "", "button");
        b.innerHTML = "Simpan";
        b.onclick = function()
                {
                if(document.getElementById("i-id-user").value == ""  || document.getElementById("i-nama-user").value == "")
                    {
                        message('User', "ID dan nama user tidak boleh kosong !", msg_err, null);
                        return;
                    }
                inp = new Object();
                inp.token = "save_user";
                inp.id = document.getElementById("i-id").value;
                inp.id_user = document.getElementById("i-id-user").value;
                inp.nama_user = document.getElementById("i-nama-user").value;
                send(svr_intf + '/intf_save_user.php', inp, function(resp) 
                        {
                            if(resp.err == 1)
                                message('User', resp.msg, msg_err, null);
                            else
                                {
                                clear_input();
                                show_user();
                                message('User', resp.msg, msg_ok, null);
                                }
                        }
                    );
                };

        b = add_child(f3.id, "", "button");
        b.innerHTML = "Hapus";
        b.onclick = function()
                {
                id = document.getElementById("i-id").value;
                if(id == -1)
                    return;
                message('User', "Hapus user " + document.getElementById("i-id-user").value + " ?", msg_ask,
                    function()
                            {
                            inp = new Object();
                            inp.token = "delete_user";
                            inp.id = document.getElementById("i-id").value;
                            inp.id_user = document.getElementById("i-id-user").value;
                            inp.nama_user = document.getElementById("i-nama-user").value;
                            send(svr_intf + '/intf_delete_user.php', inp, 
                                    function (resp) 
                                        {
                                        close_modal();
                                        clear_input();
                                        show_user();
                                        message('User', resp.msg, msg_ok, null);
                                        }
                                );
                            }
                    );
                };



        // chapter
        c = add_child(p.id, "c" + p.id, "div");
        c.className = "chapter";

        ci = add_child(c.id, "tabel-user", "div");
        ci.className = "chapter-item";

        s = add_child(c.id,  "s1" + c.id, "span");
        s.innerHTML = "* Untuk mengedit data user -> pilih user pada daftar -> edit data -> click Simpan.";
        s.className = "font-s";
        s.style.color = "#698ED3";

        s = add_child(c.id,  "s2" + c.id, "span");
        s.innerHTML = "** Untuk menghapus data user -> pilih user pada daftar -> click Hapus.";
        s.className = "font-s";
        s.style.color = "#698ED3";

        show_user();

    }

</script>
