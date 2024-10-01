<?php 
include $_SERVER['DOCUMENT_ROOT'].'/dash/init_dash.php';
if(!is_logged())
	header('Location: '.constant('svr_ui').'/ui_main.php');
else	
    {
    include constant('doc_ui').'/ui_header.php';
    include constant('doc_ui').'/ui_footer.php';
    }
?>


<script>
var selected_user=-1;function user_click(e){data=get_childs_str(e),inp=new Object,inp.token="get_location_access",inp.id=data[0],selected_user=data[0],s=document.getElementById("selected-user"),s.innerHTML="Pilih akses lokasi untuk user "+data[1],send(svr_intf+"/intf_get_location_access.php",inp,function(e){lokasi=e.lokasi,fill_checkbox("daftar-lokasi",lokasi[0],lokasi[1],lokasi[2])})}function get_user(){inp=new Object,inp.token="get_user",send(svr_intf+"/intf_get_user.php",inp,function(e){0==e.err&&(e.user.visible[0]=0,create_table("tabel-user",e.user,"user_click","Daftar User",!1))})}function on_load_event(){p=add_child("content","page","div"),p.className="page",p.setAttribute("style","padding:10px;margin:auto;width:400px;background-color:var(--black-2)"),tb=add_child(p.id,"tabel-user","div"),s=add_child(p.id,"s1"+p.id,"span"),s.innerHTML="Pilih/click user pada daftar diatas untuk mengedit akses lokasi",s.className="font-m",s.style.color="white",c=add_child(p.id,"info-user","div"),c.className="chapter",f=add_child(p.id,"form"+p.id,"div"),f.className="form",f.setAttribute("style","margin-top:20px;"),fh=add_child(f.id,"fh","div"),fh.className="form-header",s=add_child(fh.id,"selected-user","span"),s.innerHTML="Pilih akses lokasi untuk user ",fc=add_child(f.id,"daftar-lokasi","div"),fc.className="form-content",ff=add_child(f.id,"footer"+p.id,"div"),ff.className="form-footer",b=add_child(ff.id,"","button"),b.innerHTML="Simpan",b.onclick=function(){-1!=selected_user&&(inp=new Object,inp.token="set_location_access",inp.id=selected_user,inp.lokasi=get_checkbox_value("daftar-lokasi"),send(svr_intf+"/intf_set_location_access.php",inp,function(e){0==e.err?message("Akses Lokasi",e.msg,msg_ok,null):message("Akses Lokasi",e.msg,msg_err,null)}))},get_user()}
</script>