var passerdchk = 0;
var emailcheck = 0;
function chkRepeatPassword()
{                                
//alert('ok');
                var newpassword = document.getElementById('password').value;
                var newpassword1 = document.getElementById('password1').value;
                
                if(newpassword != newpassword1)
                {
                                                document.getElementById('password').style.border = "1px solid #f56954";
                                                document.getElementById('password').style.background = "#ffaca0";
                                                document.getElementById('password1').style.border = "1px solid #f56954";
                                                document.getElementById('password1').style.background = "#ffaca0";
                                                var er = document.getElementById('errormsg');
                                                var er1 = document.getElementById('error');
                                                er1.innerHTML = "Password and Repeat Password Mismatch !";
                                                er.style.display = "block";
                                                passerdchk = 1;
                                                var suc = document.getElementById('successmsg');
                                                suc.style.display = "none";
                }   
                else
                {
                                                document.getElementById('password').style.border = "1px solid #ffffff";
                                                document.getElementById('password').style.background = "#ffffff";
                                                document.getElementById('password1').style.border = "1px solid #ffffff";
                                                document.getElementById('password1').style.background = "#ffffff";
                                                var er = document.getElementById('errormsg');                                                
                                                er.style.display = "none";
                                                passerdchk = 0;
                                                var suc = document.getElementById('successmsg');
                                                suc.style.display = "none";
                }                                 
}
               
               
               
function emailCheck()
{
        var email = document.getElementById('email').value;
        var emailPat = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        var matchArray = email.match(emailPat);
        if (matchArray == null)
        {
            document.getElementById('email').style.border = "1px solid #f56954";
            document.getElementById('email').style.background = "#ffaca0";       
            email.focus;    
            emailcheck = 1;
            
                                                var er = document.getElementById('errormsg');
                                                var er1 = document.getElementById('error');
                                                er1.innerHTML = "Please enter correct Email !";
                                                er.style.display = "block";                                                
                                                var suc = document.getElementById('successmsg');
                                                suc.style.display = "none";
        }
        else
        {
            document.getElementById('email').style.border = "1px solid #ffffff";
            document.getElementById('email').style.background = "#ffffff";                       
            emailcheck = 0;
            
                                                var er = document.getElementById('errormsg');                                                
                                                er.style.display = "none";                                                
                                                var suc = document.getElementById('successmsg');
                                                suc.style.display = "none";
        }
}    



function isNumberKey(evt)
{
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 46 || charCode > 57))
            return false;
            
         return true;
}


function createUser()
{
    var pwd = document.getElementById('password').value;
    var emp_id = document.getElementById('emp_id').value;
    var manager = document.getElementById('manager').value;
    
    //alert(pwd.length);
    //alert(emp_id.length);
    //alert(passerdchk);
    //alert(emailcheck);
    
    if(passerdchk == '0' && emailcheck == '0' && pwd.length>0 && emp_id.length>0 && manager.length>0)
    {
        document.frm.submit();
    }
    else
    {
                                                var er = document.getElementById('errormsg');
                                                var er1 = document.getElementById('error');
                                                er1.innerHTML = "Please fill all fields correctly !";
                                                er.style.display = "block";                                                
                                                var suc = document.getElementById('successmsg');
                                                suc.style.display = "none";
        return false;
    }
    
}     



function validate()
{
    var profile = document.getElementById('profile').value;
    if(profile == "Sales")
    {
        var Manager1 = document.getElementById('Manager1').value;
        var Manager2 = document.getElementById('Manager2').value;
        if(manager1 == "" || manager2 == "")
        {
            document.getElementById('errormsg').style.display = "block";
            return false;
        }
        else
        {
            document.getElementById('errormsg').style.display = "block";
            return true;
        }
    }
    
    if(profile == "Manager1")
    {        
        var Manager2 = document.getElementById('Manager2').value;
        if(manager2 == "")
        {
            document.getElementById('errormsg').style.display = "block";
            return false;
        }
        else
        {
            document.getElementById('errormsg').style.display = "block";
            return true;
        }
    }    
    
    
    return true;
}     