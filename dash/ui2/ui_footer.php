    <!--end content-->
    </div>
    <!--end body-->
</body>
    <!--end html-->
</html>


<?php
echo "<script>\r\n";
echo "\tvar svr_ui = '".constant("svr_ui")."';\r\n";
echo "\tvar svr_intf = '".constant("svr_intf")."';\r\n";
echo "</script>\r\n";
?>


<script>
    var svr_ui;
    var svr_intf;

    const msg_ok = 1;
    const msg_err = 2;
    const msg_ask = 3;
    const month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    const color = ["lightsalmon", "lightseagreen", "lightskyblue", "lightsteelblue", "mediumaquamarine", "mediumpurple", "darkgoldenrod", "olive", "lightpink", "salmon", "goldenrod", "olivedrab", "dodgerblue", "gainsboro", "yellowgree", "sandybrown", "darkseagreen", "wheat", "lightcoral", "gold"];
    const color_dark = ["black", "blue", "brown", "crimson", "darkblue", "darkgreen", "darkolivegreen", "darkred", "darkslateblue", "darkslategray", "firebrick", "indigo", "mediumvioletred", "midnightblue", "navy", "purple", "saddlebrown", "darkmagenta", "darkorchid", "mediumblue"];


    // --- logout ---
    function do_logout() {
        message('Logout', 'Logout sesi ?', msg_ask, next_logout);
    }

    function next_logout() {
        close_modal();
        inp = new Object();
        outp = new Object();
        send(svr_intf + '/intf_logout.php', inp, next_logout_2);
    }

    function next_logout_2(outp) {
        window.location = svr_ui + '/ui_main.php';
    }

    // --- ganti password ---
    function do_ganti_password() {
        document.getElementById("i_pass_lama").value = "";
        document.getElementById("i_pass_baru").value = "";
        document.getElementById("i_pass_baru_2").value = "";
        document.getElementById("id-ganti-password").style.display = "block";
    }

    function next_ganti_password() 
        {
        close_modal();
        pass_lama = document.getElementById("i_pass_lama").value;
        pass_baru = document.getElementById("i_pass_baru").value;
        pass_baru_2 = document.getElementById("i_pass_baru_2").value;
        if (pass_lama == "" || pass_baru == "" || pass_baru_2 == "")
            message('Ganti Password', 'Password tidak boleh kosong !', msg_err, null);
        else if(pass_baru != pass_baru_2)
        message('Ganti Password', 'Password baru tidak sama !', msg_err, null);
        else 
            {
            inp = new Object();
            outp = new Object();
            inp.pass_lama = pass_lama;
            inp.pass_baru = pass_baru;
            inp.pass_baru_2 = pass_baru_2;
            send(svr_intf + '/intf_ganti_password.php', inp, next_ganti_password_2);
            }
        }

    function next_ganti_password_2(outp) 
        {
        if (outp.err == 0)
            message('Ganti Password', outp.msg, msg_ok, null);
        else
            message('Ganti Password', outp.msg, msg_err, null);
        }



    // --- login ---
    function do_login() {
        document.getElementById("i_user_id").value = "";
        document.getElementById("i_password").value = "";
        document.getElementById("id-login").style.display = "block";
    }

    function next_login() 
        {
        close_modal();
        user_id = document.getElementById("i_user_id").value;
        password = document.getElementById("i_password").value;
        if (user_id == "" || password == "")
            message('Login', 'User ID atau password tidak boleh kosong !', msg_err, null);
        else 
            {
            inp = new Object();
            outp = new Object();
            inp.id_user = user_id;
            inp.password = password;
            send(svr_intf + '/intf_login.php', inp, next_login_2);
            }
        }

    function next_login_2(outp) 
    {
        if (outp.err == 0)
            window.location = svr_ui + '/ui_main.php';
        else
            message('Login', outp.msg, msg_err, null);
    }

    function message(caption, text, icon, ok_click_event) {
        document.getElementById("id-message").style.display = "block";
        document.getElementById("caption-message").innerHTML = caption;
        document.getElementById("text-message").innerHTML = text;
        s = document.getElementById("icon-message");
        if (icon == msg_ok) {
            document.getElementById("message-cancel").style.display = "none";
            s.className = "icon-thumbsup";
            s.style.color = "blue";
        }
        else if (icon == msg_err) {
            document.getElementById("message-cancel").style.display = "none";
            s.className = "icon-warning1";
            s.style.color = "red";
        }
        else if (icon == msg_ask) {
            document.getElementById("message-cancel").style.display = "block";
            s.className = "icon-comment";
            s.style.color = "yellow";
        }

        if (ok_click_event != null)
            document.getElementById("message-ok").onclick = ok_click_event;
        else
            document.getElementById("message-ok").onclick = close_modal;
    }

    function close_modal() {
        div = document.getElementsByClassName("modal");
        for (i = 0; i < div.length; i++)
            div[i].style.display = "none";
    }

    function toggle_menu() {
        div = document.getElementById('menu-container');
        if (div.style.display != "block") {
            div.style.display = "block";
            document.getElementById("menu-icon").className = "icon-menu4";
        }
        else {
            div.style.display = "none";
            document.getElementById("menu-icon").className = "icon-menu3";
        }
    }

    function hide_menu() {
        div = document.getElementById('menu');
        if (div != null) {
            div.style.display = "none";
            span = document.getElementById("icon-menu");
            if (span != null)
                span.className = "icon-menu3";
        }
    }

    function get_month_name(bln) {
        if (1 <= bln && bln <= 12)
            return month[bln - 1];
        return 'Unknown';
    }

    function get_month_num(bln) {
        for (i = 0; i < 12; i++) {
            if (month[i].toUpperCase() == bln.toUpperCase())
                return i + 1;
        }
        return 1;
    }

    function get_color(num) {
        if (num < 20)
            return color[num];
        else
            return "deepskyblue"
    }
    function get_color_dark(num) {
        if (num < 20)
            return color[num];
        else
            return "dimgray";
    }

    // ---- check box -----
    function fill_checkbox(container_id_str, id_array, string_array, checked_array) {
        clear_childs(container_id_str);
        div = document.getElementById(container_id_str);

        for (i = 0; i < string_array.length; i++) {
            chk = add_child(container_id_str, '', 'input');
            chk.type = "checkbox";
            chk.value = string_array[i];
            chk.id = id_array[i];
            chk.checked = checked_array[i];

            lbl = add_child(container_id_str, '', 'label');
            lbl.innerHTML = string_array[i];

            add_child(container_id_str, '', 'br');
        }

    }

    function get_checkbox_value(container_id_str) {
        items = new Array();
        chk = document.getElementById(container_id_str).getElementsByTagName('input');
        for (let i = 0; i < chk.length; i++) {
            if (chk[i].checked)
                items.push(chk[i].id);
        }
        return items;
    }

    function fill_combobox(id_combo_str, string_array) {
        sel = document.getElementById(id_combo_str);
        for (i = sel.options.length - 1; i >= 0; i--)
            sel.remove(i);
        for (i = 0; i < string_array.length; i++) {
            opt = document.createElement('option');
            opt.text = string_array[i];
            opt.value = string_array[i];
            sel.add(opt);
        }
    }

    function get_combobox_value(id_combo_str) {
        return document.getElementById(id_combo_str).value;
    }

    function add_child(parent_id_str, child_id_str, tag_name) {
        tag = document.createElement(tag_name);
        tag.id = child_id_str;
        if(parent_id_str != null)
            {
            parent = document.getElementById(parent_id_str);
            if(parent != null)
                parent.appendChild(tag);
            }
        return tag;
    }

    function clear_childs(parent_id_str) {
        parent = document.getElementById(parent_id_str);
        if (parent == null)
            return;
        while (parent.firstChild)
            {
                parent.removeChild(parent.firstChild);
            }
    }

    function get_childs_str(parent_id_str) {
        // return child as array of string
        child = new Array();
        obj = document.getElementById(parent_id_str);
        if (obj != null) {
            for (i = 0; i < obj.childNodes.length; i++)
                child.push(obj.childNodes[i].innerHTML);
        }
        return child;
    }

    function create_table(parent_id_str, tab_obj, tb_click_str, caption, width_str, height_str) {
        // parent = ID of div container
        // tb_click = click event as string
        clear_childs(parent_id_str);
        h3 = add_child(parent_id_str, parent_id_str + '_h3', 'h3');
        h3.innerHTML = caption;
        h3.className = "font-l bold";
        h3.setAttribute("style", "color:gray");
        div2 = add_child(parent_id_str, parent_id_str + "_div_tb", "div")
        div2.setAttribute("style", "overflow:auto;height:100%");

        tb = add_child(div2.id, parent_id_str + '_tb', 'table');
        tb.style.width = "100%";
        // header
        tr = add_child(tb.id, parent_id_str + '_tr_h', 'tr');
        for (i = 0; i < tab_obj.col_count; i++) {
            th = add_child(tr.id, parent_id_str + '_tr_h_' + i, 'th');
            th.innerHTML = tab_obj.col_name[i];
            if (tab_obj.visible[i] == 0)
                th.style.display = "none";
        }

        // data
        for (j = 0; j < tab_obj.row_count; j++) {
            tr = add_child(tb.id, parent_id_str + '_tr_d_' + j, 'tr');
            tr.setAttribute('onclick', tb_click_str + "('" + parent_id_str + "_tr_d_" + j + "');");
            for (i = 0; i < tab_obj.col_count; i++) {
                td = add_child(tr.id, parent_id_str + '_tr_d_' + j + '_' + i, 'td');
                if (tab_obj.numeric[i]) {
                    td.innerHTML = tab_obj.rows[j][i].toLocaleString();
                    td.setAttribute("style", "text-align:right");
                }
                else
                    td.innerHTML = tab_obj.rows[j][i];

                if (tab_obj.visible[i] == 0)
                    td.style.display = "none";
            }
        }
        //div = document.getElementById(parent_id_str);
        //div.setAttribute("style", "background-color: var(--main-bkcolor); padding:10px; border-radius:5px;margin-top:10px;margin-bottom:30px;width:" + width_str + ";height:" + height_str + ";");
        return tb;
    }

    function send(url, inp, nextCallback) 
    {
        xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () 
            {
            if (this.readyState == 4 && this.status == 200)
                nextCallback(JSON.parse(this.responseText));
            };
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-xhrencoded");
        xhr.send("" + JSON.stringify(inp));
    }

    function create_form(id_parent_str, id_form_str)
    {

        modal = add_child(id_parent_str, id_form_str, "div");
        modal.className = "modal";
        form = add_child(modal.id, "form" + modal.id, "div");
        form.className = "form";
        
        form_header = add_child(form.id, "form-header" + form.id, "div");
        form_header.className = "form-header";

        span1 = add_child(form_header.id, "span1" + form_header.id,"span");
        span1.className = "font-m bold";
        span1.innerHTML = "Caption";
        span2 = add_child(form_header.id,"span2" + form_header.id,"span");
        span2.className = "icon-map";

        form_content = add_child(form.id, "form-content" + form.id, "div");
        form_content.className = "form-content";

        form_footer = add_child(form.id, "form-footer" + form.id, "div");
        form_footer.className = "form-footer";

        btn_ok = add_child(form_footer.id,"btn-ok" + form_footer.id,"button");
        btn_ok.innerHTML = "OK";
        span3 = add_child(btn_ok.id, "span3" + btn_ok.id, "span");
        span3.className = "icon-checkmark1";

        btn_esc = add_child(form_footer.id,"btn-esc" + form_footer.id,"button");
        btn_esc.innerHTML = "Cancel";
        span4 = add_child(btn_esc.id, "span3" + btn_esc.id, "span");
        span4.className = "icon-cancel";
        btn_esc.onclick = function ()
        {
            close_modal();
        }

        result = new Object();
        result.modal = modal;
        result.form = form;
        result.content = form_content;
        result.caption = span1;
        result.icon = span2;
        result.btn_ok = btn_ok;
        return result;
    }

    window.onload = function () {
        on_load_event();
    }

</script>