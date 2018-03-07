<html>
<head>
<title> Home </title>
<link href="styles.css" rel="stylesheet">
<script src="SecurityManager.js"></script>
<script>
function main() {
    
	//start grid function
    var grid=function (){
        var roleObjArr=SecurityManager.GetAllRoles();   
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

        var nameHeading = document.createElement("TH");
        var name=document.createTextNode("Name");
        nameHeading.appendChild(name);
        nameHeading.setAttribute("id", "nameHeading");
        document.getElementById("myTr").appendChild(nameHeading);

        var descHeading = document.createElement("TH");
        var desc=document.createTextNode("Description");
        descHeading.appendChild(desc);
        descHeading.setAttribute("id", "descHeading");
        document.getElementById("myTr").appendChild(descHeading);

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
        
        for(var i=0; i<roleObjArr.length; i++)
        {    
            var row = document.createElement("TR");
            row.setAttribute("id", "myTr"+i);
            document.getElementById("myTable").appendChild(row);
        
            var cell = document.createElement("TD");
            var text = document.createTextNode(roleObjArr[i].ID);
            cell.appendChild(text);
            document.getElementById("myTr"+i).appendChild(cell);

            cell = document.createElement("TD");
            text = document.createTextNode(roleObjArr[i].roleName);
            cell.appendChild(text);
            document.getElementById("myTr"+i).appendChild(cell);

            cell = document.createElement("TD");
            text = document.createTextNode(roleObjArr[i].roleDesc);
            cell.appendChild(text);
            document.getElementById("myTr"+i).appendChild(cell);

			
            cell = document.createElement("TD");
            var link = document.createElement("A");
            text = document.createTextNode("Delete");
            link.setAttribute("href", "#");
			link.setAttribute("onclick","delRole(this)");
			link.setAttribute("id", roleObjArr[i].ID);
            link.appendChild(text);
            cell.appendChild(link);
            document.getElementById("myTr"+i).appendChild(cell);

            cell = document.createElement("TD");
            link = document.createElement("A");
            text = document.createTextNode("Edit");
            link.setAttribute("href", "#");
			link.setAttribute("onclick","editRole(this)");
			link.setAttribute("id", roleObjArr[i].ID);
            link.appendChild(text);
            cell.appendChild(link);
            document.getElementById("myTr"+i).appendChild(cell);
        }
    }	//end grid function
	
    grid();
	
    var btnSave=document.getElementById("btnSave");
    btnSave.onclick=function() {	//start save function
        var roleObjArr=SecurityManager.GetAllRoles();
		var roleObj=new Object();
        roleObj.roleName=document.getElementById("txtName").value;
        roleObj.roleDesc=document.getElementById("txtDesc").value;
        
		var isRoleExist=false;
        for(var i=0; i<roleObjArr.length && !isRoleExist; i++)
		{    
			if(roleObjArr[i].roleName.toUpperCase()==roleObj.roleName.toUpperCase())
				isRoleExist=true;
		}
		if(isRoleExist)
			alert("Role Already Existed. Try another One!");            
		else
		{
			SecurityManager.SaveRole(roleObj,function(i) { alert("Role Added Successfully! ID is "+i.ID);
					location.reload();}, function() { alert ("Role does not added")} );
		}
    }	//end save function
	
	var btnClear=document.getElementById("btnClear");
	btnClear.onclick = function()
	{
		document.getElementById("txtName").value="";
        document.getElementById("txtDesc").value="";
	}
}

function delRole(hyperObj) {
		var id=Number(hyperObj.id);
		if(confirm("Do you want to continue ?"))
			SecurityManager.DeleteRole(id,function(i) { alert("Role Deleted Successfully! ID is "+i);
						location.reload();}, function() { alert ("Role does not deleted");} );
		else
			location.reload();
}
	
function editRole(hyperObj) {
	var id=Number(hyperObj.id);
	var roleObj=SecurityManager.GetRoleById(id);
	document.getElementById("txtName").value=roleObj.roleName;
	document.getElementById("txtDesc").value=roleObj.roleDesc;
	var btnSave=document.getElementById("btnSave");
    btnSave.onclick=function(){
		var roleObj1=new Object();
		roleObj1.ID=id;
        roleObj1.roleName=document.getElementById("txtName").value;
        roleObj1.roleDesc=document.getElementById("txtDesc").value;	
		SecurityManager.SaveRole(roleObj1,function(i) { alert("Data Edit Successfully! ID is "+i.ID);
						location.reload();}, function() { alert ("User does not edit")} );		
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
			<h1>Role Management</h1>
			<span>Role Name: </span> <input type="text" id="txtName" ><br>
			<span>Description: </span> <input type="text" id="txtDesc" ><br>        
			<input type="submit" id="btnSave" value="Save">
			<input type="submit" id="btnClear" value="Clear">
		</form>
    </div>
   
</body>
</html>