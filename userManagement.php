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

    function grid() {
        var userObjArr=SecurityManager.GetAllUsers();   
        var table = document.createElement("TABLE");
        table.setAttribute("id", "myTable");
        document.body.appendChild(table);

        var row = document.createElement("TR");
        row.setAttribute("id", "myTr");
        document.getElementById("myTable").appendChild(row);
        
        var heading = document.createElement("TH");
        heading.setAttribute("id", "myTh");
        document.getElementById("myTable").appendChild(heading);

      
        for(var i=0; i<userObjArr.length; i++)
        {    
              var row = document.createElement("TR");
        row.setAttribute("id", "myTr");
        document.getElementById("myTable").appendChild(row);

        var z = document.createElement("TD");
        var t = document.createTextNode("cell");
        z.appendChild(t);
        document.getElementById("myTr").appendChild(z);
           console.log(userObjArr[i].name);
        }
    }

    var gridFunc=grid;
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
        console.log(txtEmail);
        console.log(countryName);
        console.log(cityName);
        var userObj=new Object();
        userObj.login=txtLogin;
        userObj.password=txtPassword;
        userObj.name=txtName;
        userObj.email=txtEmail;
        userObj.country=countryName;
        userObj.city=cityName;
        var isLoginExist=false;
        var isEmailExist=false;
        if(userObjArr.length==0)
        {
            var check=SecurityManager.SaveUser(userObj);
            console.log(check);
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
                var check=SecurityManager.SaveUser(userObj);
                console.log(check);
                if(check==true)
                    alert("User Added Successfully!");
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
        <span>Password: </span> <input type="password" id="txtPassword" ><br>
        <span>Name: </span> <input type="text" id="txtName" ><br>
        <span>Email: </span> <input type="text" id="txtEmail" ><br>
        <span>Country: </span> <select name="" id="cmbCountries"><option>--Select--</option></select><br>
        <span>City: </span> <select name="" id="cmbCities"><option>--Select--</option></select><br><br>
        <input type="submit" id="btnSave" value="Save">
        <input type="submit" id="btnClear" value="Clear">
    </div>
   
</body>
</html>