<html>
<head>
<title> Home </title>
<link href="styles.css" rel="stylesheet">
<script src="SecurityManager.js"></script>
<script>
function main() {
    
	//start grid function
    var grid=function (){
        var perObjArr=SecurityManager.GetAllPermissions();   
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
        
        for(var i=0; i<perObjArr.length; i++)
        {    
            var row = document.createElement("TR");
            row.setAttribute("id", "myTr"+i);
            document.getElementById("myTable").appendChild(row);
        
            var cell = document.createElement("TD");
            var text = document.createTextNode(perObjArr[i].ID);
            cell.appendChild(text);
            document.getElementById("myTr"+i).appendChild(cell);

            cell = document.createElement("TD");
            text = document.createTextNode(perObjArr[i].perName);
            cell.appendChild(text);
            document.getElementById("myTr"+i).appendChild(cell);

            cell = document.createElement("TD");
            text = document.createTextNode(perObjArr[i].perDesc);
            cell.appendChild(text);
            document.getElementById("myTr"+i).appendChild(cell);

			
            cell = document.createElement("TD");
            var link = document.createElement("A");
            text = document.createTextNode("Delete");
            link.setAttribute("href", "#");
			link.setAttribute("onclick","delPer(this)");
			link.setAttribute("id", perObjArr[i].ID);
            link.appendChild(text);
            cell.appendChild(link);
            document.getElementById("myTr"+i).appendChild(cell);

            cell = document.createElement("TD");
            link = document.createElement("A");
            text = document.createTextNode("Edit");
            link.setAttribute("href", "#");
			link.setAttribute("onclick","editPer(this)");
			link.setAttribute("id", perObjArr[i].ID);
            link.appendChild(text);
            cell.appendChild(link);
            document.getElementById("myTr"+i).appendChild(cell);
        }
    }	//end grid function
	
    grid();
	
    var btnSave=document.getElementById("btnSave");
    btnSave.onclick=function() {	//start save function
        var perObjArr=SecurityManager.GetAllPermissions();
		var perObj=new Object();
        perObj.perName=document.getElementById("txtName").value;
        perObj.perDesc=document.getElementById("txtDesc").value;
        if(perObj.perName=="")
            alert("Enter Permission!");
        else if(perObj.perDesc=="")
            alert("Enter permissions's description");
        else
            {
                var isPerExist=false;
                for(var i=0; i<perObjArr.length && !isPerExist; i++)
                {    
                    if(perObjArr[i].perName.toUpperCase()==perObj.perName.toUpperCase())
                        isPerExist=true;
                }
                if(isPerExist)
                    alert("Permission Already Existed. Try another One!");            
                else
                {
                    SecurityManager.SavePermission(perObj,function(i) { alert("Permission Added Successfully! ID is "+i.ID);
                            location.reload();}, function() { alert ("Permission does not added")} );
                }
            }
    }	//end save function
	
	var btnClear=document.getElementById("btnClear");
	btnClear.onclick = function()
	{
		document.getElementById("txtName").value="";
        document.getElementById("txtDesc").value="";
	}
}

function delPer(hyperObj) {
		var id=Number(hyperObj.id);
		if(confirm("Do you want to continue ?"))
			SecurityManager.DeletePermission(id,function(i) { alert("Permission Deleted Successfully! ID is "+i);
						location.reload();}, function() { alert ("Permission does not deleted");} );
		else
			location.reload();
}
	
function editPer(hyperObj) {
	var id=Number(hyperObj.id);
	var perObj=SecurityManager.GetPermissionById(id);
	document.getElementById("txtName").value=perObj.perName;
	document.getElementById("txtDesc").value=perObj.perDesc;
	var btnSave=document.getElementById("btnSave");
    btnSave.onclick=function(){
		var perObj1=new Object();
		perObj1.ID=id;
        perObj1.perName=document.getElementById("txtName").value;
        perObj1.perDesc=document.getElementById("txtDesc").value;	
		SecurityManager.SavePermission(perObj1,function(i) { alert("Data Edit Successfully! ID is "+i.ID);
						location.reload();}, function() { alert ("Permission does not edit")} );		
	}
	
}
</script>
<head>
<body onload="main();">
   <div  class="menu">
       <ul>
            <li> <a href="adminHome.php" >Home</a> </li>
            <li> <a href="userManagement.php" >User Management</a> </li>
            <li> <a href="roleManagement.php" >Role Management</a> </li>
            <li> <a class="active" href="permissionManagement.php" >Permissions Management</a> </li>
            <li> <a href="rolePermissionManagement.php" >Role-Permissions Assignment</a> </li>
            <li> <a href="userRoleManagement.php" >User-Role Assignment</a> </li>
           <li> <a href="login.php" >Logout</a> </li>
        </ul>
    </div>

    <div>
		<form class="container1" style="float:left;">
			<h1>Permission Management</h1>
			<span>Permission Name: </span> <input type="text" id="txtName" ><br>
			<span>Description: </span> <input type="text" id="txtDesc" ><br>        
			<input type="button" id="btnSave" value="Save">
			<input type="button" id="btnClear" value="Clear">
		</form>
    </div>
   
</body>
</html>