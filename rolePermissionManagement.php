<html>
<head>
<title> Home </title>
<link href="styles.css" rel="stylesheet">
<script src="SecurityManager.js"></script>
<script>
function main() {
    var role = SecurityManager.GetAllRoles();
    var cmb = document.getElementById('cmbRole')
    for(var i=0;i<role.length;i++)
    {
        var opt = document.createElement("option");
        opt.setAttribute("value",role[i].ID);
        opt.innerText = role[i].roleName;
        cmb.appendChild(opt);
    }
    var per = SecurityManager.GetAllPermissions();
    cmb = document.getElementById('cmbPer')
    for(var i=0;i<per.length;i++)
    {
        var opt = document.createElement("option");
        opt.setAttribute("value",per[i].ID);
        opt.innerText = per[i].perName;
        cmb.appendChild(opt);
    }
    
	//start grid function
    var grid=function (){
        var rolePerObjArr=SecurityManager.GetAllRolePermissions();   
        var table = document.createElement("TABLE");
        table.setAttribute("id", "myTable");
        table.setAttribute("border","1");
        document.body.appendChild(table);

        var row = document.createElement("TR");
        row.setAttribute("id", "myTr");
        document.getElementById("myTable").appendChild(row);

        var idHeading = document.createElement("TH");
        var id=document.createTextNode("ID");
        idHeading.appendChild(id);
        idHeading.setAttribute("id", "idHeading");
        document.getElementById("myTr").appendChild(idHeading);

        var roleHeading = document.createElement("TH");
        var role=document.createTextNode("Role");
        roleHeading.appendChild(role);
        roleHeading.setAttribute("id", "roleHeading");
        document.getElementById("myTr").appendChild(roleHeading);

        var perHeading = document.createElement("TH");
        var per=document.createTextNode("Permission");
        perHeading.appendChild(per);
        perHeading.setAttribute("id", "perHeading");
        document.getElementById("myTr").appendChild(perHeading);

        var delHeading = document.createElement("TH");
        var del=document.createTextNode("Delete");
        delHeading.appendChild(del);
        delHeading.setAttribute("id", "delHeading");
        document.getElementById("myTr").appendChild(delHeading);

        var editHeading = document.createElement("TH");
        var edit=document.createTextNode("Edit");
        editHeading.appendChild(edit);
        editHeading.setAttribute("id", "editHeading");
        document.getElementById("myTr").appendChild(editHeading);
        
        for(var i=0; i<rolePerObjArr.length; i++)
        {    
            var row = document.createElement("TR");
            row.setAttribute("id", "myTr"+i);
            document.getElementById("myTable").appendChild(row);
        
            var cell = document.createElement("TD");
            var text = document.createTextNode(rolePerObjArr[i].ID);
            cell.appendChild(text);
            document.getElementById("myTr"+i).appendChild(cell);

            cell = document.createElement("TD");
            text = document.createTextNode(rolePerObjArr[i].role);
            cell.appendChild(text);
            document.getElementById("myTr"+i).appendChild(cell);

            cell = document.createElement("TD");
            text = document.createTextNode(rolePerObjArr[i].per);
            cell.appendChild(text);
            document.getElementById("myTr"+i).appendChild(cell);

			
            cell = document.createElement("TD");
            var link = document.createElement("A");
            text = document.createTextNode("Delete");
            link.setAttribute("href", "#");
			link.setAttribute("onclick","delRolePer(this)");
			link.setAttribute("id", rolePerObjArr[i].ID);
            link.appendChild(text);
            cell.appendChild(link);
            document.getElementById("myTr"+i).appendChild(cell);

            cell = document.createElement("TD");
            link = document.createElement("A");
            text = document.createTextNode("Edit");
            link.setAttribute("href", "#");
			link.setAttribute("onclick","editRolePer(this)");
			link.setAttribute("id", rolePerObjArr[i].ID);
            link.appendChild(text);
            cell.appendChild(link);
            document.getElementById("myTr"+i).appendChild(cell);
        }
    }	//end grid function
	
    grid();
	
    var btnSave=document.getElementById("btnSave");
    btnSave.onclick=function() {	//start save function
        var rolePerObjArr=SecurityManager.GetAllRolePermissions();
		var rolePerObj=new Object();
        var role = document.getElementById("cmbRole");
        rolePerObj.role = role.options[role.selectedIndex].text;
        var per=document.getElementById("cmbPer");
        rolePerObj.per=per.options[per.selectedIndex].text;
        console.log(rolePerObj.per);
        if(rolePerObj.role=="--Select--" )
            alert("First Select Role.");
        else if(rolePerObj.per=="--Select--")
            alert("First Select Permission.");
        else
            SecurityManager.SaveRolePermission(rolePerObj,function(i) { alert("Role-Permission Added Successfully! ID is "+i.ID);
                    location.reload();}, function() { alert ("Role-Permission does not added")} );
    }	//end save function
	
	var btnClear=document.getElementById("btnClear");
	btnClear.onclick = function()
	{
        var role = document.getElementById("cmbRole");
        role.options[role.selectedIndex].text="--Select--";
        var per=document.getElementById("cmbPer");
        per.options[per.selectedIndex].text="--Select--";
	}
}

function delRolePer(hyperObj) {
		var id=Number(hyperObj.id);
		if(confirm("Do you want to continue ?"))
			SecurityManager.DeleteRolePermission(id,function(i) { alert("Role-Permission Deleted Successfully! ID is "+i);
						location.reload();}, function() { alert ("Role-Permission does not deleted");} );
		else
			location.reload();
}
	
function editRolePer(hyperObj) {
	var id=Number(hyperObj.id);
	var rolePerObj=SecurityManager.GetRolePermissionById(id);
	var role = document.getElementById("cmbRole");
    role.options[role.selectedIndex].text=rolePerObj.role;
    var per=document.getElementById("cmbPer");
    per.options[per.selectedIndex].text=rolePerObj.per;
	var btnSave=document.getElementById("btnSave");
    btnSave.onclick=function(){
		var rolePerObj1=new Object();
		rolePerObj1.ID=id;
        rolePerObj1.role=role.options[role.selectedIndex].text;
        rolePerObj1.per=per.options[per.selectedIndex].text;
		SecurityManager.SaveRolePermission(rolePerObj1,function(i) { alert("Data Edit Successfully! ID is "+i.ID);
						location.reload();}, function() { alert ("Data does not edit")} );		
	}
	
}
</script>
<head>
<body onload="main();">
    <div  class="menu">
        <a href="adminHome.php" >Home</a>
        <a href="userManagement.php" >User Management</a>
        <a href="roleManagement.php" >Role Management</a>
        <a href="permissionManagement.php" >Permissions Management</a>
        <a href="rolePermissionManagement.php" >Role-Permissions Assignment</a>
        <a href="userRoleManagement.php" >User-Role Assignment</a>
        <a href="login.php" >Logout</a>
    </div>

    <div>
		<form>
			<h1>Role-Permissions Management</h1>

			<span>Role: </span><select name="" id="cmbRole"><option>--Select--</option></select><br>
			<span>Permission: </span>  <select name="" id="cmbPer"><option>--Select--</option></select><br><br>
			<input type="submit" id="btnSave" value="Save">
			<input type="submit" id="btnClear" value="Clear">
		</form>
    </div>
   
</body>
</html>