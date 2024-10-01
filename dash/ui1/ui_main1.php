<?php include $_SERVER['DOCUMENT_ROOT'].'/dash/init_dash.php';?>
<?php include constant('doc_ui').'/ui_header.php';?>
<?php include constant('doc_ui').'/ui_footer.php';?>


<script>
var daftar_lokasi;
var refreshTmr = setInterval(refreshTimer, 60000);
function refreshTimer() 
{
    refresh_data();
}
    

function refresh_data() 
    {
        inp = new Object();
        inp.token = "get_data_home";
        inp.lokasi = get_checkbox_value('list-lokasi');
        send(svr_intf + '/intf_get_data_home.php', inp, show_data);
    }

function show_data(inp)
{
    clear_childs("content");

    console.log(inp);

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

        realtime = lokasi[i].realtime;
        // realtime data
        if(realtime.length)
            {
            total = 0;
            for(j = 0; j <realtime.length; j++)
                total += realtime[j][2];
            sp = add_child(c.id, "sp3" + c.id, "span");
            sp.innerHTML = "Total Rp. " + total.toLocaleString();
            sp.className = "font-l bold";
            sp.style.color = "green";

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
            sp = add_child(c.id, "sp2" + c.id, "span");
            sp.innerHTML = "Pendapatan merupakan pendapatan parkir + member + manual - tiket masalah";
            sp.className = "font-s";

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
            ctx = document.getElementById(cnv.id).getContext("2d");
            clr = new Array();
            xValues = new Array();
            yValues = new Array();

            for (j = 0; j < income.length; j++) 
                {
                xValues.push(income[j][0]);
                clr.push(get_color(j));
                }

            for (j = 0; j < income.length; j++) 
                yValues.push(income[j][1]/1000);

            new Chart
                (
                    ctx,
                    {
                        type: "bar",
                        data:
                        {
                            labels: xValues,
                            datasets:
                                [
                                    {
                                        backgroundColor: clr,
                                        data: yValues
                                    }
                                ]
                        },
                        options:
                        {
                            legend: { display: false },
                            title:
                            {
                                display: true,
                                text: "Pendapatan 7 Hari Kebelakang"
                            },

                            scales:
                            {
                                yAxes:
                                    [
                                        {
                                            ticks:
                                            {
                                                callback: (val) => {
                                                    return new Intl.NumberFormat().format(val) + " k";
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
            sp = add_child(c.id, "sp2" + c.id, "span");
            sp.innerHTML = "Pendapatan merupakan pendapatan parkir + member + manual - tiket masalah";
            sp.className = "font-s";


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
            ctx = document.getElementById(cnv.id).getContext("2d");
            clr = new Array();
            xValues = new Array();
            yValues = new Array();

            for (j = 0; j < income.length; j++) 
                {
                xValues.push(get_month_name(income[j][0]%100) + ' ' + Math.floor(income[j][0] / 100));
                clr.push(get_color(j));
                }

            for (j = 0; j < income.length; j++) 
                yValues.push(income[j][1]/1000);

            new Chart
                (
                    ctx,
                    {
                        type: "bar",
                        data:
                        {
                            labels: xValues,
                            datasets:
                                [
                                    {
                                        backgroundColor: clr,
                                        data: yValues
                                    }
                                ]
                        },
                        options:
                        {
                            legend: { display: false },
                            title:
                            {
                                display: true,
                                text: "Pendapatan 6 Bulan Kebelakang"
                            },

                            scales:
                            {
                                yAxes:
                                    [
                                        {
                                            ticks:
                                            {
                                                callback: (val) => {
                                                    return new Intl.NumberFormat().format(val) + " k";
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
            sp = add_child(c.id, "sp2" + c.id, "span");
            sp.innerHTML = "Pendapatan merupakan pendapatan parkir + member + manual - tiket masalah";
            sp.className = "font-s";

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
            ctx = document.getElementById(cnv.id).getContext("2d");
            clr = new Array();
            xValues = new Array();
            yValues = new Array();

            for (j = 0; j < income.length; j++) 
                {
                xValues.push(income[j][0]);
                clr.push(get_color(j));
                }

            for (j = 0; j < income.length; j++) 
                yValues.push(income[j][1]/1000);

            new Chart
                (
                    ctx,
                    {
                        type: "bar",
                        data:
                        {
                            labels: xValues,
                            datasets:
                                [
                                    {
                                        backgroundColor: clr,
                                        data: yValues
                                    }
                                ]
                        },
                        options:
                        {
                            legend: { display: false },
                            title:
                            {
                                display: true,
                                text: "Pendapatan 6 Tahun Kebelakang"
                            },

                            scales:
                            {
                                yAxes:
                                    [
                                        {
                                            ticks:
                                            {
                                                callback: (val) => {
                                                    return new Intl.NumberFormat().format(val) + " k";
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

        // filter button
        div = document.getElementById("float-buttons");
        btn = add_child(div.id, "lokasi-btn", "button");
        span = add_child(btn.id, "span-btn", "span");
        span.className = "icon-filter";
        btn.onclick = function () {
            daftar_lokasi.modal.style.display = "block";
        };

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

        // query lokasi
        inp = new Object();
        inp.token = "get_user_location";
        send(svr_intf + '/intf_get_user_location.php', inp, fill_location);
    }


</script>