<html>
<head>
<title> Home </title>
<link href="styles.css" rel="stylesheet">
<script src="SecurityManager.js"></script>
<script>
function main() {
    var name=localStorage.getItem('name');
    var userRoleArr=SecurityManager.GetAllUserRoles();
    var roles=[];
    var roleCount=0;
    for(var i=0; i<userRoleArr.length; i++)
        {
            if(userRoleArr[i].user==name)
                roles[roleCount++]=userRoleArr[i].role;
        }
    var rolePerArr=SecurityManager.GetAllRolePermissions();
    var per=[];
    var perCount=0;
    var div=document.createElement("div");
    div.setAttribute("class","rolePermission")
    var ol=document.createElement("ol");
    for(var i=0; i<roles.length; i++)
        {
            var li=document.createElement("li");
            li.setAttribute("class","roleProperty")
            var role=document.createTextNode("Role: "+roles[i]);
            li.appendChild(role);
            ol.appendChild(li);
            document.body.appendChild(ol);
            var bold=document.createElement("b");
            bold.appendChild(document.createTextNode("Permissions")); 
            ol.appendChild(bold);
            for(var j=0; j<rolePerArr.length; j++)
                {
                     if(rolePerArr[j].role==roles[i])
                     {
                        per[perCount++]=rolePerArr[i].per;
                        var ul=document.createElement("ul");
                        var li=document.createElement("li");
                        var per=document.createTextNode(rolePerArr[j].per);
                        li.appendChild(per);
                        ul.appendChild(li);
                        ol.appendChild(ul);
                     }
                    
                }
        }
    div.appendChild(ol);
    document.body.appendChild(div);
   
}
</script>
<head>

<body onload="main();">
    <div  class="menu">
       <ul>
            <li><a class="active" href="userHome.php" >Home</a></li>
            <li><a href="login.php" >Logout</a></li>
        </ul>
    </div>

    <div>
        <h1>Welcome  <script>document.write(localStorage.getItem('name'));</script></h1>
    </div>
   
</body>
</html>