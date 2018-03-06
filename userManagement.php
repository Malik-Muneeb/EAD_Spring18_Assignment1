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

    var btnSave=document.getElementById("btnSave");
    btnSave.onclick=function() {
        var userObjArr=SecurityManager.GetAllUsers();
        var txtLogin=document.getElementById("txtLogin").value;
        var txtPassword=document.getElementById("txtPassword").value;
        var txtName=document.getElementById("txtName").value;
        var txtEmail=document.getElementById("txtEmail").value;
        var countries = document.getElementById("cmbCountries");
        var countryName = countries.options[countries.selectedIndex].text;
        var cities = document.getElementById("cmbCities");
        var cityName = cities.options[cities.selectedIndex].text;
        console.log(txtLogin);
        console.log(txtPassword);
        console.log(txtName);
        console.log(cityName);
        console.log(cityName);
        console.log(cityName);
        if(userObjArr.length==0)
        {

        }
        else 
        {
        for(var i=0; i<userObjArr.length; i++)
        {
            console.log(userObjArr[i]);
        }
        }
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
        <h1>Users</h1>
        <span>Login: </span> <input type="text" id="txtLogin" ><br>
        <span>Password: </span> <input type="text" id="txtPassword" ><br>
        <span>Name: </span> <input type="text" id="txtName" ><br>
        <span>Email: </span> <input type="text" id="txtEmail" ><br>
        <span>Country: </span> <select name="" id="cmbCountries"><option>--Select--</option></select><br>
        <span>City: </span> <select name="" id="cmbCities"><option>--Select--</option></select><br><br>
        <input type="submit" id="btnSave" value="Save">
        <input type="submit" id="btnClear" value="Clear">
    </div>
   
</body>
</html>