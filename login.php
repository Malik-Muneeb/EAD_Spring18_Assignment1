<html>
<head>
<title> Login </title>
<link rel="stylesheet" type="text/css" href="styles.css">
<script src="SecurityManager.js"></script>
</head>
<script>
function main() {
    
    var btn=document.getElementById('btnLogin');
    btn.onclick = function() {
        var login=document.getElementById('txtLogin').value;
        var password=document.getElementById('txtPassword').value;
        debugger;
        if(login=="")
            alert("Enter Login Name first!!!");
        else if(password=="")
            alert("Enter Password!!!");
        else
            {
                 var result=SecurityManager.ValidateAdmin(login,password);
                if(result==true)
                    window.location.href="adminHome.php";
                else
                    alert("Invalid UserName/Password");
            }
       
        
    }
    var btn1=document.getElementById('btnLogin1');
    btn1.onclick= function(){
    	var userObjArr=SecurityManager.GetAllUsers();
    	var login=document.getElementById('txtLogin1').value;
        var password=document.getElementById('txtPassword1').value;
        if(login=="")
            alert("Enter Login Name first!!!");
        else if(password=="")
            alert("Enter Password!!!");
        else
            {
                var isExist=false;
                var name;
                for(var i=0; i<userObjArr.length && !isExist; i++)
                {
                    if(userObjArr[i].login==login && userObjArr[i].password==password)
                       {
                           isExist=true;
                           name=userObjArr[i].name; 
                       } 
                }
                if(isExist)
                {
                    window.location.href="userHome.php"//?name="+login;
                    localStorage.setItem('name', name);//to set value
                }
                else
                    alert("Invalid UserName/Password");
            }
    }
}
</script>

<body class="bodyContainer" onload="main();">
    <h1 style="background-color:#006600;color:white;float;margin-right:1050px">Security Manager</h1>
    <div class="container" style="float:left;">
        <h1>Admin Login</h1>
            <form>
                Login: <input id="txtLogin" /> <br>
                Password: <input id="txtPassword" type="password" /> <br>
                <input type="button" id="btnLogin" value="Login" />
                <input class ="cancelbtn" type="reset" value="cancel" />
            </form>
    </div>
    <div class="container" style="float:left;margin-left:20px;">
        <h1>User Login</h1>
            <form>
                Login: <input id="txtLogin1" /> <br>
                Password: <input id="txtPassword1" type="password" /> <br>
                <input type="button" id="btnLogin1" value="Login" />
                <input  class ="cancelbtn" type="reset" value="cancel" />
            </form>
    </div>

</body>
</html>