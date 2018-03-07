<html>
<head>
<title> Home </title>
<link href="styles.css" rel="stylesheet">
<script src="SecurityManager.js"></script>
<script>
function main() {
    var countries = SecurityManager.GetCountries();
    var cmb = document.getElementById('cmbCountries')
    for(var i=0;i<countries.length;i++)
    {
        var opt = document.createElement("option");
        opt.setAttribute("value",countries[i].CountryID);
        opt.innerText = countries[i].Name;
        cmb.appendChild(opt);
    }
    cmb.onchange = function(){
        var citycmb = document.getElementById('cmbCities');
        //Remove all child elements (e.g. options)
        citycmb.innerHTML = '';
        var cities = SecurityManager.GetCitiesByCountryId(cmb.value);
        for(var i=0;i<cities.length;i++)
        {
            var opt = document.createElement("option");
            opt.setAttribute("value",cities[i].CityID);
            opt.innerText = cities[i].Name;
            citycmb.appendChild(opt);
        }   
    }//end of onchange
	
	//start grid function
    var grid=function (){
        var userObjArr=SecurityManager.GetAllUsers();   
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

        var emailHeading = document.createElement("TH");
        var email=document.createTextNode("Email");
        emailHeading.appendChild(email);
        emailHeading.setAttribute("id", "emailHeading");
        document.getElementById("myTr").appendChild(emailHeading);

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

		debugger;
        
        for(var i=0; i<userObjArr.length; i++)
        {    
            var row = document.createElement("TR");
            row.setAttribute("id", "myTr"+i);
            document.getElementById("myTable").appendChild(row);
        
            var cell = document.createElement("TD");
            var text = document.createTextNode(userObjArr[i].ID);
            cell.appendChild(text);
            document.getElementById("myTr"+i).appendChild(cell);

            cell = document.createElement("TD");
            text = document.createTextNode(userObjArr[i].name);
            cell.appendChild(text);
            document.getElementById("myTr"+i).appendChild(cell);

            cell = document.createElement("TD");
            text = document.createTextNode(userObjArr[i].email);
            cell.appendChild(text);
            document.getElementById("myTr"+i).appendChild(cell);

			
            cell = document.createElement("TD");
            var link = document.createElement("A");
            text = document.createTextNode("Delete");
            link.setAttribute("href", "#");
			link.setAttribute("onclick","delUser(this)");
			link.setAttribute("id", userObjArr[i].ID);
            link.appendChild(text);
            cell.appendChild(link);
            document.getElementById("myTr"+i).appendChild(cell);

            cell = document.createElement("TD");
            link = document.createElement("A");
            text = document.createTextNode("Edit");
            link.setAttribute("href", "#");
			link.setAttribute("onclick","editUser(this)");
			link.setAttribute("id", userObjArr[i].ID);
            link.appendChild(text);
            cell.appendChild(link);
            document.getElementById("myTr"+i).appendChild(cell);

            console.log(userObjArr[i]);
        }
    }	//end grid function
	
    grid();
	
    var btnSave=document.getElementById("btnSave");
    btnSave.onclick=function() {	//start save function
        var userObjArr=SecurityManager.GetAllUsers();
		var userObj=new Object();
        userObj.login=document.getElementById("txtLogin").value;
        userObj.password=document.getElementById("txtPassword").value;
        userObj.name=document.getElementById("txtName").value;
        userObj.email=document.getElementById("txtEmail").value;
        var countries = document.getElementById("cmbCountries");
        userObj.country = countries.options[countries.selectedIndex].text;
        var cities = document.getElementById("cmbCities");
		userObj.city = cities.options[cities.selectedIndex].text;
        
        var isLoginExist=false;
        var isEmailExist=false;
        if(userObjArr.length==0)        
		{
			var check=SecurityManager.SaveUser(userObj,function(i) { alert("User Added Successfully! ID is "+i.ID);
						location.reload();}, function() { alert ("User does not added")} );
			
		}					
        else 
        {
            for(var i=0; i<userObjArr.length && !isLoginExist && !isEmailExist ; i++)
            {    
                if(userObjArr[i].login==userObj.login)
                    isLoginExist=true;
                else if(userObjArr[i].email==userObj.email)
                    isEmailExist=true; 
                console.log(userObjArr[i].name);
            }
            if(isLoginExist)
                alert("Login Already Existed. Try another One!");
            else if(isEmailExist)
                alert("Email Already Existed. Try another one!");
            else
            {
                var check=SecurityManager.SaveUser(userObj,function(i) { alert("User Added Successfully! ID is "+i.ID);
						location.reload();}, function() { alert ("User does not added")} );
            }
        }
    }	//end save function
	
	var btnClear=document.getElementById("btnClear");
	btnClear.onclick = function()
	{
		document.getElementById("txtLogin").value="";
        document.getElementById("txtPassword").value="";
        document.getElementById("txtName").value="";
        document.getElementById("txtEmail").value="";
        var countries = document.getElementById("cmbCountries");
        countries.options[countries.selectedIndex].text="--Select--";
        var cities = document.getElementById("cmbCities");
        cities.options[cities.selectedIndex].text="--Select--";
	}
	
	
}

function delUser(hyperObj) {
		var id=Number(hyperObj.id);
		if(confirm("Do you want to continue ?"))
			SecurityManager.DeleteUser(id,function(i) { alert("User Deleted Successfully! ID is "+i);
						location.reload();}, function() { alert ("User does not deleted");} );
		else
			location.reload();
	}
	
function editUser(hyperObj) {
	var id=Number(hyperObj.id);
	var userObj=SecurityManager.GetUserById(id);
	document.getElementById("txtLogin").value=userObj.login;
	document.getElementById("txtPassword").value=userObj.password;
	document.getElementById("txtName").value=userObj.name;
	document.getElementById("txtEmail").value=userObj.email;
	var countries = document.getElementById("cmbCountries");
	countries.options[countries.selectedIndex].text=userObj.country;
	var cities = document.getElementById("cmbCities");
	cities.options[cities.selectedIndex].text=userObj.city;
	 var btnSave=document.getElementById("btnSave");
    btnSave.onclick=function(){
		var userObj1=new Object();
		userObj1.ID=id;
        userObj1.login=document.getElementById("txtLogin").value;
        userObj1.password=document.getElementById("txtPassword").value;
        userObj1.name=document.getElementById("txtName").value;
        userObj1.email=document.getElementById("txtEmail").value;
        var countries = document.getElementById("cmbCountries");
        userObj1.country = countries.options[countries.selectedIndex].text;
        var cities = document.getElementById("cmbCities");
		userObj1.city = cities.options[cities.selectedIndex].text;	
		SecurityManager.SaveUser(userObj1,function(i) { alert("Data Edit Successfully! ID is "+i.ID);
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
        <a href="userRoleAssignment.php" >User-Role Assignment</a>
        <a href="login.php" >Logout</a>
    </div>

    <div>
	<form>
        <h1>Users</h1>
        <span>Login: </span> <input type="text" id="txtLogin" ><br>
        <span>Password: </span> <input type="password" id="txtPassword" ><br>
        <span>Name: </span> <input type="text" id="txtName" ><br>
        <span>Email: </span> <input type="text" id="txtEmail" ><br>
        <span>Country: </span> <select name="" id="cmbCountries"><option>--Select--</option></select><br>
        <span>City: </span> <select name="" id="cmbCities"><option>--Select--</option></select><br><br>
        <input type="submit" id="btnSave" value="Save">
        <input type="submit" id="btnClear" value="Clear">
	</form>
    </div>
   
</body>
</html>