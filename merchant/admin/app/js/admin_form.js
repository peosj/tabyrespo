function isNumberKey(evt)
{
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 46 || charCode > 57))
            return false;
            
         return true;
}
      
function mendatoryFields(a)
{
    
    var fieldblank = a.length;

    for (i = 0; i < a.length; i++) 
    {
        id = a[i];    
    
        var fldchk = document.getElementById(id).value;
        if(fldchk.length == 0)
        {
            document.getElementById(id).style.borderColor = "#ff6868";
            document.getElementById(id).style.background = "#ffe7fe";            
        }
        else
        {
            document.getElementById(id).style.borderColor = "#CCC";
            document.getElementById(id).style.background = "#ffffff"; 
            fieldblank--;        
        }                
   }
   
   
       //alert(fieldblank);
        if(fieldblank == 0)
        {
            document.getElementById('errormsg').style.display = "none";
            return true;
        }
        else
        {
            document.getElementById('errormsg').style.display = "block";
            document.getElementById('errormsg').scrollIntoView();
            return false;
        }
}


function tab1ContactTypeSubmit()
{
    var mendfields = ["profile", "emp_id", "name", "email", "phone"];
    var sbmtstatus = mendatoryFields(mendfields);
        
    if(sbmtstatus == true)
    {
        document.frm.submit();
        return false;
    }    
    else
    {
        return false;
    }  
}