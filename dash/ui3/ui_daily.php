<?php include $_SERVER['DOCUMENT_ROOT'].'/dash/init_dash.php';?>
<?php include constant('doc_ui').'/ui_header.php';?>
<?php include constant('doc_ui').'/ui_footer.php';?>

<script>

    var daftar_lokasi;
    var data_pdf = new Array();

    function refresh_data() {
        inp = new Object();
        inp.token = "get_data_daily";
        inp.lokasi = get_checkbox_value('list-lokasi');
        inp.bulan = get_month_num(get_combobox_value('i-bulan'));
        inp.tahun = get_combobox_value('i-tahun');
        send(svr_intf + '/intf_get_data_daily.php', inp, show_data);
        
    }

    function show_data(inp) {
        while(data_pdf.length)
            data_pdf.pop();

        clear_childs("content");
        console.log(inp);
        if(inp.err == 1)
            return;
        let lokasi = inp.lokasi;
        for (i = 0; i < lokasi.length; i++) 
        {
            pdf = new Object();
            pdf.cnv1 = null;
            pdf.table1 = null;
            pdf.pengelola = lokasi[i].info[0][0];
            pdf.site = lokasi[i].info[0][1];
            pdf.alamat = lokasi[i].info[0][2];
            data_pdf.push(pdf);

            let title = "Pendapatan Harian Bulan " + get_combobox_value('i-bulan') + " " + get_combobox_value('i-tahun') + " " + lokasi[i].info[0][1];

            // page
            p = add_child("content", "page" + i, "div");
            p.className = "page shadow";
            p.style.maxWidth = "none";
            //p.width = "90vw";

            // page title
            pt = add_child(p.id, "pt" + p.id, "div");
            pt.className = "page-title"

            // label 1
            sp = add_child(pt.id, "sp1" + pt.id, "span");
            sp.innerHTML = lokasi[i].info[0][0];
            sp.className = "font-s bold center";
            sp.style.color = "#0A5994";
            // label 2
            sp = add_child(pt.id, "sp2" + pt.id, "span");
            sp.innerHTML = lokasi[i].info[0][1];
            sp.className = "font-xl bold center";
            sp.style.color = "#0A5994";
            // label 3
            sp = add_child(pt.id, "sp3" + pt.id, "span");
            sp.innerHTML = lokasi[i].info[0][2];
            sp.className = "font-s center";
            sp.style.color = "#0A5994";

            let income = lokasi[i].income;
            if(income.row_count)
                {
                // chapter 1 : table
                c = add_child(p.id, "c1" + p.id, "div");
                c.className = "chapter";

                d = add_child(c.id, "table" + c.id, "div");
                d.style.overflow = "auto";
                d.style.margin = "5px";

                income.numeric[0] = 0;
                pdf.table1 = create_table(d.id, income, "table_click_" + i, title, true);

                // chapter 2 : graphic
                c = add_child(p.id, "c2" + p.id, "div");
                c.className = "chapter";

                c = add_child(c.id, "c3" + c.id, "div");
                c.className = "chapter-item";
                c.style.maxWidth = "800px";
                c.style.margin = "auto";


                // canvas
                cnv = add_child(c.id, "cnv" + c.id, "canvas");
                cnv.setAttribute("height", "250px");

                pdf.cnv1 = cnv;
                ctx = document.getElementById(cnv.id).getContext("2d");
                xValues = new Array();
                yValues = new Array();
                for (let j = 0; j < income.row_count; j++)
                    xValues.push(income.rows[j][0]);

                l1 = new Object();
                l1.label = "Tarif Parkir";
                l1.fill = false;
                l1.lineTension = lineTension;
                l1.borderColor = "dodgerblue";
                l1.data = new Array();
                for (j = 0; j < income.row_count; j++)
                    l1.data.push((income.rows[j][1] + income.rows[j][2]) / 1000);

                l2 = new Object();
                l2.label = "Member";
                l2.fill = false;
                l2.lineTension = lineTension;
                l2.borderColor = "powderblue";
                l2.data = new Array();
                for (j = 0; j < income.row_count; j++)
                    l2.data.push(income.rows[j][3]/1000);

                l3 = new Object();
                l3.label = "Manual";
                l3.fill = false;
                l3.lineTension = lineTension;
                l3.borderColor = "darksalmon";
                l3.data = new Array();
                for (j = 0; j < income.row_count; j++)
                    l3.data.push(income.rows[j][4]/1000);

                l4 = new Object();
                l4.label = "Tiket Masalah";
                l4.fill = false;
                l4.lineTension = lineTension;
                l4.borderColor = "red";
                l4.data = new Array();
                for (j = 0; j < income.row_count; j++)
                    l4.data.push(income.rows[j][5]/1000);

                l5 = new Object();
                l5.label = "Total";
                l5.fill = false;
                l5.lineTension = lineTension;
                l5.borderColor = "green";
                l5.data = new Array();
                for (j = 0; j < income.row_count; j++)
                    l5.data.push(income.rows[j][6]/1000);

                data_income = new Array();
                data_income.push(l1);
                data_income.push(l2);
                data_income.push(l3);
                data_income.push(l4);
                data_income.push(l5);
                new Chart(ctx,{type: "line",data: {labels: xValues, datasets: data_income},options:{elements : {point:{radius:3}},legend: {display: true},
                title: {display: true,text: title, fontColor : '#004040'},scales: {yAxes:[{ticks:{beginAtZero:true,callback: (val) => {return val.toLocaleString() + " k";}}}]}}});

                }
            else
                {
                    sp = add_child(p.id, "", "span");
                    sp.innerHTML = "Tidak tersedia";
                    sp.style.color = "red";
                    sp.className = "font-s";
                }

        }
    }


    function on_load_event() {
        // title
        document.getElementById('page-title').innerHTML = "Pendapatan Harian";

        // filter lokasi
        daftar_lokasi = create_form("modal-container", "form-lokasi");
        daftar_lokasi.form.style.width = "300px";
        daftar_lokasi.caption.innerHTML = "Pilih Lokasi";
        daftar_lokasi.icon.className = "icon-map";
        daftar_lokasi.btn_ok.onclick = function () {
            close_modal();
            refresh_data();
        };
        add_child(daftar_lokasi.content.id, "list-lokasi", "div");

        div = document.getElementById("float-buttons");
        btn = add_child(div.id, "lokasi-btn", "button");
        span = add_child(btn.id, "span-btn1", "span");
        span.className = "icon-map";
        btn.onclick = function () {
            daftar_lokasi.modal.style.display = "block";
        };

        // filter tanggal
        filter_tanggal = create_form("modal-container", "form-tanggal");
        filter_tanggal.form.style.width = "300px";
        filter_tanggal.caption.innerHTML = "Pilih Bulan";
        filter_tanggal.icon.className = "icon-calendar";
        filter_tanggal.btn_ok.onclick = function () {
            close_modal();
            refresh_data();
        };

        const date = new Date();

        add_child(filter_tanggal.content.id, "", "span").innerHTML = "Bulan";
        c = add_child(filter_tanggal.content.id, "i-bulan", "select");
        bln = new Array();
        for(i=0; i<12; i++)
            bln.push(month[i]);
        fill_combobox("i-bulan", bln);
        c.value = month[date.getMonth()];

        add_child(filter_tanggal.content.id, "", "span").innerHTML = "Tahun";
        c = add_child(filter_tanggal.content.id, "i-tahun", "select");
        thn = new Array();
        for(i=0; i<20; i++)
            thn.push(2020 + i);
        fill_combobox("i-tahun", thn);
        c.value = date.getFullYear();


        div = document.getElementById("float-buttons");
        btn = add_child(div.id, "tanggal-btn", "button");
        span = add_child(btn.id, "span-btn1", "span");
        span.className = "icon-calendar";
        btn.onclick = function () {
            filter_tanggal.modal.style.display = "block";
        };

        // btn export
        btn = add_child(div.id, "exp-btn", "button");
        span = add_child(btn.id, "exp-btn1", "span");
        span.className = "icon-file-pdf";
        btn.onclick = function () {
            message('Export', "Export ke file PDF ?", msg_ask, 
            function()
                {
                    close_modal();

                    for(let i=0; i<data_pdf.length; i++)
                        {
                        let p = data_pdf[i];
                        let pdf = new jsPDF('l', 'mm', [297, 210]);

                        let dateObject = new Date();
                        let date = dateObject.toLocaleString();

                        pdf.setFont("Arial");
                        pdf.setFontSize(8);
                        pdf.setTextColor(0,64,128);
                        pdf.setFontStyle('normal');
                        pdf.text("Waktu cetak " + date, 10, 200);


                        if (p.cnv1 != null) {
                            chart = p.cnv1.toDataURL('image/png');
                            pdf.addImage(chart, 'PNG', 50, 30, 200, 150);
                        }

                        // Simpan file PDF
                        pdf.save("data_harian_" + p.site + ".pdf");
                        }
                }
            );
        };


        // btn export
        btn = add_child(div.id, "exc-btn", "button");
        span = add_child(btn.id, "exc-btn1", "span");
        span.className = "icon-file-excel";
        btn.onclick = function () {
            message('Export', "Export ke file Excel ?", msg_ask, 
            function()
                {
                    close_modal();

                    for(let i=0; i<data_pdf.length; i++)
                        {
                        let p = data_pdf[i];
                        if (p.table1 != null) {
                            TableToExcel
                            .convert(p.table1,
                                {
                                name: "data_harian_" + p.site + ".xlsx",
                                sheet: {
                                    name: "Sheet 1" 
                                    }
                                });
                        }
                    }
                }
            );
        };


        // query lokasi
        inp = new Object();
        inp.token = "get_user_location";
        send(svr_intf + '/intf_get_user_location.php', inp,
            function (resp) {
                if (resp.err == 0) {
                    let count = resp.lokasi_user[0].length;
                    let checked = new Array();
                    for (i = 0; i < count; i++)
                        checked.push("true");
                    fill_checkbox("list-lokasi", resp.lokasi_user[0], resp.lokasi_user[1], checked);
                    refresh_data();
                }
            }
        );

    }

</script>
