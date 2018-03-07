<html>
<head>
<title> Home </title>
<link href="styles.css" rel="stylesheet">
<script src="SecurityManager.js"></script>
<script>
function main() {
    
    var user = SecurityManager.GetAllUsers();
    cmb = document.getElementById('cmbUser')
    for(var i=0;i<user.length;i++)
    {
        var opt = document.createElement("option");
        opt.setAttribute("value",user[i].ID);
        opt.innerText = user[i].name;
        cmb.appendChild(opt);
    }
    var role = SecurityManager.GetAllRoles();
    var cmb = document.getElementById('cmbRole')
    for(var i=0;i<role.length;i++)
    {
        var opt = document.createElement("option");
        opt.setAttribute("value",role[i].ID);
        opt.innerText = role[i].roleName;
        cmb.appendChild(opt);
    }
    
	//start grid function
    var grid=function (){
        var userRoleObjArr=SecurityManager.GetAllUserRoles();   
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

        var userHeading = document.createElement("TH");
        var user=document.createTextNode("User");
        userHeading.appendChild(user);
        userHeading.setAttribute("id", "userHeading");
        document.getElementById("myTr").appendChild(userHeading);

        var roleHeading = document.createElement("TH");
        var role=document.createTextNode("Role");
        roleHeading.appendChild(role);
        roleHeading.setAttribute("id", "roleHeading");
        document.getElementById("myTr").appendChild(roleHeading);

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
        
        for(var i=0; i<userRoleObjArr.length; i++)
        {    
            var row = document.createElement("TR");
            row.setAttribute("id", "myTr"+i);
            document.getElementById("myTable").appendChild(row);
        
            var cell = document.createElement("TD");
            var text = document.createTextNode(userRoleObjArr[i].ID);
            cell.appendChild(text);
            document.getElementById("myTr"+i).appendChild(cell);

            cell = document.createElement("TD");
            text = document.createTextNode(userRoleObjArr[i].user);
            cell.appendChild(text);
            document.getElementById("myTr"+i).appendChild(cell);

            cell = document.createElement("TD");
            text = document.createTextNode(userRoleObjArr[i].role);
            cell.appendChild(text);
            document.getElementById("myTr"+i).appendChild(cell);

			
            cell = document.createElement("TD");
            var link = document.createElement("A");
            text = document.createTextNode("Delete");
            link.setAttribute("href", "#");
			link.setAttribute("onclick","delUserRole(this)");
			link.setAttribute("id", userRoleObjArr[i].ID);
            link.appendChild(text);
            cell.appendChild(link);
            document.getElementById("myTr"+i).appendChild(cell);

            cell = document.createElement("TD");
            link = document.createElement("A");
            text = document.createTextNode("Edit");
            link.setAttribute("href", "#");
			link.setAttribute("onclick","editUserRole(this)");
			link.setAttribute("id", userRoleObjArr[i].ID);
            link.appendChild(text);
            cell.appendChild(link);
            document.getElementById("myTr"+i).appendChild(cell);
        }
    }	//end grid function
	
    grid();
	
    var btnSave=document.getElementById("btnSave");
    btnSave.onclick=function() {	//start save function
        var userRoleObjArr=SecurityManager.GetAllUserRoles();
		var userRoleObj=new Object();        
        var user=document.getElementById("cmbUser");
        userRoleObj.user=user.options[user.selectedIndex].text;
        var role = document.getElementById("cmbRole");
        userRoleObj.role = role.options[role.selectedIndex].text;
        if(userRoleObj.user=="--Select--")
            alert("First Select User."); 
        else if(userRoleObj.role=="--Select--")
            alert("First Select Role.");  
        else
        {
			SecurityManager.SaveUserRole(userRoleObj,function(i) { alert("User-Role Added Successfully! ID is "+i.ID);
					location.reload();}, function() { alert ("User-Role does not added")} );
		}
    }	//end save function
	
	var btnClear=document.getElementById("btnClear");
	btnClear.onclick = function()
	{
        var user=document.getElementById("cmbPer");
        user.options[user.selectedIndex].text="--Select--";
        var role = document.getElementById("cmbRole");
        role.options[role.selectedIndex].text="--Select--";
	}
}

function delUserRole(hyperObj) {
		var id=Number(hyperObj.id);
		if(confirm("Do you want to continue ?"))
			SecurityManager.DeleteUserRole(id,function(i) { alert("User-Role Deleted Successfully! ID is "+i);
						location.reload();}, function() { alert ("User-Role does not deleted");} );
		else
			location.reload();
}
	
function editUserRole(hyperObj) {
	var id=Number(hyperObj.id);
	var userRoleObj=SecurityManager.GetUserRoleById(id);
    var user=document.getElementById("cmbUser");
    user.options[user.selectedIndex].text=userRoleObj.user;
    var role = document.getElementById("cmbRole");
    role.options[role.selectedIndex].text=userRoleObj.role;
	var btnSave=document.getElementById("btnSave");
    btnSave.onclick=function(){
		var userRoleObj1=new Object();
		userRoleObj1.ID=id;
        userRoleObj1.user=user.options[user.selectedIndex].text;
        userRoleObj1.role=role.options[role.selectedIndex].text;
		SecurityManager.SaveUserRole(userRoleObj1,function(i) { alert("Data Edit Successfully! ID is "+i.ID);
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
			<h1>User-Role Management</h1>
			<span>User: </span>  <select name="" id="cmbUser"><option>--Select--</option></select><br>
			<span>Role: </span>  <select name="" id="cmbRole"><option>--Select--</option></select><br><br>
			<input type="submit" id="btnSave" value="Save">
			<input type="submit" id="btnClear" value="Clear">
		</form>
    </div>
   
</body>
</html>