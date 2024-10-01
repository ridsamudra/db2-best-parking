<?php include $_SERVER['DOCUMENT_ROOT'].'/dash/init_dash.php';?>
<?php include constant('doc_ui').'/ui_header.php';?>
<?php include constant('doc_ui').'/ui_footer.php';?>


<script>

var daftar_lokasi;
var refreshTmr = setInterval(refreshTimer, 300000);

function refreshTimer() 
{
    refresh_data();
}

function refresh_data() {
        inp = new Object();
        inp.token = "get_data_home";
        inp.lokasi = get_checkbox_value('list-lokasi');
        send(svr_intf + '/intf_get_data_home.php', inp, show_data);
    }

function show_data(inp)
{
    clear_childs("content");
    if(inp.err == 1)
        return;
    for(i = 0; i < inp.lokasi.length; i++)
        {
        lokasi = inp.lokasi;
        // page
        p = add_child("content", "page" + i, "div");
        p.className = "page shadow";

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

        c = add_child(p.id, "c" + p.id, "div");
        c.className = "chapter";
        // chapter title
        sp = add_child(c.id, "sp1" + c.id, "span");
        sp.innerHTML = "Pendapatan Realtime";
        sp.className = "font-l bold";

        sp = add_child(c.id, "sp6" + c.id, "span");
        sp.innerHTML = "Pendapatan berjalan untuk tanggal operasional saat ini";
        sp.className = "font-s";
        sp.style.color = "#0080FF";

        realtime = lokasi[i].realtime;
        // realtime data
        if(realtime.length)
            {
            add_child(c.id, "br1" + c.id, "br");

            total = 0;
            for(j = 0; j <realtime.length; j++)
                total += realtime[j][2];
            sp = add_child(c.id, "sp3" + c.id, "span");
            sp.innerHTML = "Total Rp. " + total.toLocaleString();
            sp.className = "font-l bold";
            sp.style.color = "green";

            sp = add_child(c.id, "sp5" + c.id, "span");
            sp.innerHTML = "Tanggal operasional " + realtime[0][3];
            sp.className = "font-s";

            sp = add_child(c.id, "sp4" + c.id, "span");
            sp.innerHTML = "Waktu update " + realtime[0][4];
            sp.className = "font-s";

            // chapter items
            cis = add_child(c.id, "cis" + c.id, "div");
            cis.className = "chapter-items";
            // chapter item
            for(j = 0; j <realtime.length; j++)
                {
                ci = add_child(cis.id, "ci" + cis.id + j, "div");
                ci.className = "chapter-item";
                if(realtime[j][0] == 'MEMBER')
                    {
                    ci.style.backgroundColor = "#D5EAFF";
                    ci.style.border = "3px solid #004080"
                    }   


                sp = add_child(ci.id, "sp2" + ci.id + j, "span");
                sp.innerHTML = realtime[j][0];
                sp.className = "font-s bold";
                sp.style.color = get_color_dark(j);

                sp = add_child(ci.id, "sp3" + ci.id + j, "span");
                sp.innerHTML = realtime[j][1].toLocaleString() + " transaksi";
                sp.className = "font-s bold right";

                sp = add_child(ci.id, "sp3" + ci.id + j, "span");
                sp.innerHTML = "Rp. " + realtime[j][2].toLocaleString();
                sp.className = "font-s bold font-l right";
                sp.style.color = "#005151";
                }

            // chapter items
            cis = add_child(c.id, "cis2" + c.id, "div");
            cis.className = "chapter-items";
            // chapter item
            ci = add_child(cis.id, "ci" + cis.id, "div");
            ci.className = "chapter-item";
            ci.style.width = "100%";
            // canvas
            cnv = add_child(ci.id, "cnv123" + ci.id, "canvas");
            
            ctx = document.getElementById(cnv.id).getContext("2d");
            const xValues = new Array();
            for(j=0; j<realtime.length;j++)
                xValues.push(realtime[j][0]);

            const yValues = new Array();
            for(j=0; j<realtime.length;j++)
                yValues.push(realtime[j][2]);

            const barColors = new Array();
            for(j=0; j<realtime.length;j++)
                barColors.push(get_color_dark(j));

            new Chart(cnv.id, 
                    {
                    type: "pie",
                    data: 
                        {
                        labels: xValues,
                        datasets: 
                            [
                                {
                                backgroundColor: barColors,
                                data: yValues
                                }
                            ]
                        },
                    options: 
                        {
                        title: {
                            display: true,
                            text: "Pendapatan Realtime"
                            }
                        }
                    }
                );
             
            }
        else
            {
            sp = add_child(c.id, "sp2" + c.id, "span");
            sp.innerHTML = "Tidak tersedia";
            sp.className = "font-s bold";
            sp.style.color = "red";
            }

        // 7 hari Kebelakang
        c = add_child(p.id, "c2" + p.id, "div");
        c.className = "chapter";
        // chapter title
        sp = add_child(c.id, "sp1" + c.id, "span");
        sp.innerHTML = "Pendapatan 7 Hari Kebelakang";
        sp.className = "font-l bold";

        income = lokasi[i].income7;
        if (income.length) 
            {
            // chapter items
            cis = add_child(c.id, "cis" + c.id, "div");
            cis.className = "chapter-items";
            // chapter item
            ci = add_child(cis.id, "ci" + cis.id, "div");
            ci.className = "chapter-item";
            ci.style.width = "100%";
            //ci.style.height = "200px";

            // canvas
            cnv = add_child(ci.id, "cnv" + ci.id, "canvas");
            cnv.setAttribute("height","250px");
            ctx = document.getElementById(cnv.id).getContext("2d");
            xValues = new Array();
            yValues = new Array();
            for (j = 0; j < income.length; j++) 
                xValues.push(income[j][0]);
            
            l1 = new Object();
            l1.label = "Tarif Parkir";
            l1.fill = false;
            l1.backgroundColor = "dodgerblue";
            l1.data = new Array();
            for (j = 0; j < income.length; j++)
                l1.data.push(income[j][1]/1000);

            l2 = new Object();
            l2.label = "Member";
            l2.fill = false;
            l2.backgroundColor = "powderblue";
            l2.data = new Array();
            for (j = 0; j < income.length; j++)
                l2.data.push(income[j][2]/1000);
            
            l3 = new Object();
            l3.label = "Manual";
            l3.fill = false;
            l3.backgroundColor = "darksalmon";
            l3.data = new Array();
            for (j = 0; j < income.length; j++)
                l3.data.push(income[j][3]/1000);
            
            l4 = new Object();
            l4.label = "Tiket Masalah";
            l4.fill = false;
            l4.backgroundColor = "red";
            l4.data = new Array();
            for (j = 0; j < income.length; j++)
                l4.data.push(income[j][4]/1000);
            
            l5 = new Object();
            l5.label = "Total";
            l5.fill = false;
            l5.backgroundColor = "green";
            l5.data = new Array();
            for (j = 0; j < income.length; j++)
                l5.data.push(income[j][5]/1000);

            data_income = new Array();
            shown = get_checkbox_value("list-income");
            for (j = 0; j < shown.length; j++) {
                id = shown[j] ;
                if (id == "1")
                    data_income.push(l1);
                if (id == "2")
                    data_income.push(l2);
                if (id == "3")
                    data_income.push(l3);
                if (id == "4")
                    data_income.push(l4);
                if (id == "5")
                    data_income.push(l5);
            }

            new Chart
                (
                    ctx,
                    {
                        type: "bar",
                        data:
                        {
                            labels: xValues,
                            datasets: data_income
                        },
                        options:
                        {
                            legend: 
                                { 
                                    display: true 
                                },
                            title:
                                {
                                display: false,
                                text: ""
                                },
                            scales:
                                {
                                yAxes:
                                    [
                                        {
                                        ticks:
                                            {
                                            beginAtZero:true,
                                            callback: (val) => 
                                                {
                                                return val.toLocaleString() + " k";
                                                }
                                            }
                                        }
                                    ]
                                }
                        }
                    }
                );

            // end graph
            }
        else 
            {
            sp = add_child(c.id, "sp2" + c.id, "span");
            sp.innerHTML = "Tidak tersedia";
            sp.className = "font-s bold";
            sp.style.color = "red";
            }

        // 6 bulan terkhir
        c = add_child(p.id, "c3" + p.id, "div");
        c.className = "chapter";
        // chapter title
        sp = add_child(c.id, "sp1" + c.id, "span");
        sp.innerHTML = "Pendapatan 6 Bulan Kebelakang";
        sp.className = "font-l bold";

        income = lokasi[i].income6;
        if (income.length) 
            {
            // chapter items
            cis = add_child(c.id, "cis" + c.id, "div");
            cis.className = "chapter-items";
            // chapter item
            ci = add_child(cis.id, "ci" + cis.id, "div");
            ci.className = "chapter-item";
            ci.style.width = "100%";

            // canvas
            cnv = add_child(ci.id, "cnv" + ci.id, "canvas");
            cnv.setAttribute("height","250px");
            ctx = document.getElementById(cnv.id).getContext("2d");
            xValues = new Array();
            yValues = new Array();
            for (j = 0; j < income.length; j++) 
                xValues.push(get_month_name(income[j][0] % 100) + " " + Math.floor(income[j][0] / 100).toString());
            
            l1 = new Object();
            l1.label = "Tarif Parkir";
            l1.fill = false;
            l1.backgroundColor = "dodgerblue";
            l1.data = new Array();
            for (j = 0; j < income.length; j++)
                l1.data.push(income[j][1]/1000);

            l2 = new Object();
            l2.label = "Member";
            l2.fill = false;
            l2.backgroundColor = "powderblue";
            l2.data = new Array();
            for (j = 0; j < income.length; j++)
                l2.data.push(income[j][2]/1000);
            
            l3 = new Object();
            l3.label = "Manual";
            l3.fill = false;
            l3.backgroundColor = "darksalmon";
            l3.data = new Array();
            for (j = 0; j < income.length; j++)
                l3.data.push(income[j][3]/1000);
            
            l4 = new Object();
            l4.label = "Tiket Masalah";
            l4.fill = false;
            l4.backgroundColor = "red";
            l4.data = new Array();
            for (j = 0; j < income.length; j++)
                l4.data.push(income[j][4]/1000);
            
            l5 = new Object();
            l5.label = "Total";
            l5.fill = false;
            l5.backgroundColor = "green";
            l5.data = new Array();
            for (j = 0; j < income.length; j++)
                l5.data.push(income[j][5]/1000);

            data_income = new Array();
            shown = get_checkbox_value("list-income");
            for (j = 0; j < shown.length; j++) {
                id = shown[j] ;
                if (id == "1")
                    data_income.push(l1);
                if (id == "2")
                    data_income.push(l2);
                if (id == "3")
                    data_income.push(l3);
                if (id == "4")
                    data_income.push(l4);
                if (id == "5")
                    data_income.push(l5);
            }

            new Chart
                (
                    ctx,
                    {
                        type: "bar",
                        data:
                        {
                            labels: xValues,
                            datasets: data_income
                        },
                        options:
                        {
                            legend: 
                                { 
                                    display: true 
                                },
                            title:
                                {
                                display: false,
                                text: ""
                                },
                            scales:
                                {
                                yAxes:
                                    [
                                        {
                                        ticks:
                                            {
                                            beginAtZero:true,
                                            callback: (val) => 
                                                {
                                                return val.toLocaleString() + " k";
                                                }
                                            }
                                        }
                                    ]
                                }
                        }
                    }
                );
            // end graph
            }
        else 
            {
            sp = add_child(c.id, "sp2" + c.id, "span");
            sp.innerHTML = "Tidak tersedia";
            sp.className = "font-s bold";
            sp.style.color = "red";
            }


        // 6 tahun terkhir
        c = add_child(p.id, "c4" + p.id, "div");
        c.className = "chapter";
        // chapter title
        sp = add_child(c.id, "sp1" + c.id, "span");
        sp.innerHTML = "Pendapatan 6 Tahun Kebelakang";
        sp.className = "font-l bold";

        income = lokasi[i].income62;
        if (income.length) 
            {
            // chapter items
            cis = add_child(c.id, "cis" + c.id, "div");
            cis.className = "chapter-items";
            // chapter item
            ci = add_child(cis.id, "ci" + cis.id, "div");
            ci.className = "chapter-item";
            ci.style.width = "100%";

            // canvas
            cnv = add_child(ci.id, "cnv" + ci.id, "canvas");
            cnv.setAttribute("height","250px");
            ctx = document.getElementById(cnv.id).getContext("2d");
            xValues = new Array();
            yValues = new Array();
            for (j = 0; j < income.length; j++) 
                xValues.push(income[j][0]);
            
            l1 = new Object();
            l1.label = "Tarif Parkir";
            l1.fill = true;
            l1.backgroundColor = "dodgerblue";
            l1.data = new Array();
            for (j = 0; j < income.length; j++)
                l1.data.push(income[j][1]/1000);

            l2 = new Object();
            l2.label = "Member";
            l2.fill = true;
            l2.backgroundColor = "powderblue";
            l2.data = new Array();
            for (j = 0; j < income.length; j++)
                l2.data.push(income[j][2]/1000);
            
            l3 = new Object();
            l3.label = "Manual";
            l3.fill = true;
            l3.backgroundColor = "darksalmon";
            l3.data = new Array();
            for (j = 0; j < income.length; j++)
                l3.data.push(income[j][3]/1000);
            
            l4 = new Object();
            l4.label = "Tiket Masalah";
            l4.fill = true;
            l4.backgroundColor = "red";
            l4.data = new Array();
            for (j = 0; j < income.length; j++)
                l4.data.push(income[j][4]/1000);
            
            l5 = new Object();
            l5.label = "Total";
            l5.fill = true;
            l5.backgroundColor = "green";
            l5.data = new Array();
            for (j = 0; j < income.length; j++)
                l5.data.push(income[j][5]/1000);

            data_income = new Array();
            shown = get_checkbox_value("list-income");
            for (j = 0; j < shown.length; j++) {
                id = shown[j] ;
                if (id == "1")
                    data_income.push(l1);
                if (id == "2")
                    data_income.push(l2);
                if (id == "3")
                    data_income.push(l3);
                if (id == "4")
                    data_income.push(l4);
                if (id == "5")
                    data_income.push(l5);
            }

            new Chart
                (
                    ctx,
                    {
                        type: "bar",
                        data:
                        {
                            labels: xValues,
                            datasets: data_income
                        },
                        options:
                        {
                            legend: 
                                { 
                                    display: true 
                                },
                            title:
                                {
                                display: false,
                                text: ""
                                },
                            scales:
                                {
                                yAxes:
                                    [
                                        {
                                        ticks:
                                            {
                                            beginAtZero:true,
                                            callback: (val) => 
                                                {
                                                return val.toLocaleString() + " k";
                                                }
                                            }
                                        }
                                    ]
                                }
                        }
                    }
                );
            // end graph
            }
        else 
            {
            sp = add_child(c.id, "sp2" + c.id, "span");
            sp.innerHTML = "Tidak tersedia";
            sp.className = "font-s bold";
            sp.style.color = "red";
            }



        }    


}


    function fill_location(inp) {
        if (inp.err == 0) {
            let count = inp.lokasi_user[0].length;
            let checked = new Array();
            for (i = 0; i < count; i++)
                checked.push("true");
            fill_checkbox("list-lokasi", inp.lokasi_user[0], inp.lokasi_user[1], checked);
            refresh_data();
        }
    }

    function on_load_event() {
        document.getElementById('page-title').innerHTML = "Dashboard";

        // form pilih lokasi
        daftar_lokasi = create_form("modal-container", "form-lokasi");
        daftar_lokasi.form.style.width = "300px";
        daftar_lokasi.caption.innerHTML = "Daftar Lokasi";
        daftar_lokasi.icon.className = "icon-map";
        daftar_lokasi.btn_ok.onclick = function () {
            close_modal();
            refresh_data();
        };
        add_child(daftar_lokasi.content.id, "list-lokasi", "div");

        // form pilih income
        jenis_income = create_form("modal-container", "form-income");
        jenis_income.form.style.width = "300px";
        jenis_income.caption.innerHTML = "Jenis Pendapatan";
        jenis_income.icon.className = "icon-banknote";
        jenis_income.btn_ok.onclick = function () {
            close_modal();
            refresh_data();
        };
        add_child(jenis_income.content.id, "list-income", "div");
        jenis = ["Tarif Parkir", "Member", "Manual", "Tiket Masalah", "Total"];
        id = ["1","2","3","4","5"];
        checked = ["1", "1", "1", "1", "1"];
        fill_checkbox("list-income", id, jenis, checked);
        
        
        // filter button
        div = document.getElementById("float-buttons");
        btn = add_child(div.id, "lokasi-btn", "button");
        span = add_child(btn.id, "span-btn1", "span");
        span.className = "icon-map";
        btn.onclick = function () {
            daftar_lokasi.modal.style.display = "block";
        };

        // filter income
        btn = add_child(div.id, "income-btn", "button");
        span = add_child(btn.id, "span-btn2", "span");
        span.className = "icon-banknote";
        btn.onclick = function () {
            jenis_income.modal.style.display = "block";
        };


        // query lokasi
        inp = new Object();
        inp.token = "get_user_location";
        send(svr_intf + '/intf_get_user_location.php', inp, fill_location);
    }


</script>