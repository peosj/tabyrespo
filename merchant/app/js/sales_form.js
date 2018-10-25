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
    var mendfields = ["pos_id", "hardware_id", "store_name", "city", "state", "zip", "contact1", "contact_type_comment"];
    var sbmtstatus = mendatoryFields(mendfields);
    
    
    
    
    /////// cheking mendatory for contay type tab
    
        var contacttab = ["merchant_contact_status", "contact_type", "contact_type_followup_date", "pos_status"];
        var contacttab1 = mendatoryFields(contacttab);
        if(!contacttab1)
        {
            document.getElementById('tb1').style.color = "#ff0000";
            sbmtstatus = false;
        }
        else
        {
            document.getElementById('tb1').style.color = "#3C8DBC";
        }
    
    /////////////////////////////////////////////
    
    
    /////// cheking mendatory for need assessment tab
    var contactstatus = document.getElementById('merchant_contact_status').value;
    if(contactstatus == "Contacted / Visited")
    {
        var needassessenttab = ["type_of_edc", "tid_configured", "no_of_pos", "no_of_outlet", "daily_closure", "ecs_status"];
        var needassessenttab1 = mendatoryFields(needassessenttab);
        if(!needassessenttab1)
        {
            document.getElementById('tb2').style.color = "#ff0000";
            sbmtstatus = false;
        }
        else
        {
            document.getElementById('tb2').style.color = "#3C8DBC";
        }
    }
    /////////////////////////////////////////////
    
    
    /////// cheking mendatory for discussion type tab
    var contactstatus = document.getElementById('merchant_contact_status').value;
    if(contactstatus == "Contacted / Visited")
    {
        if(document.getElementById("activation").checked || document.getElementById("ar_collection").checked || document.getElementById("retention").checked || document.getElementById("cross_sale").checked || document.getElementById("general_awareness").checked || document.getElementById("complaints").checked)
        {
            document.getElementById('tb3').style.color = "#3C8DBC";            
        }
        else
        {
            document.getElementById('tb3').style.color = "#ff0000";
            sbmtstatus = false;
        }
    }
    /////////////////////////////////////////////  
    
    /////// cheking mendatory for opportunity tab
    var contactstatus = document.getElementById('merchant_contact_status').value;
    if(contactstatus == "Contacted / Visited")
    {
        var opportunitytab = ["cross_sale_possible"];
        var opportunitytab1 = mendatoryFields(opportunitytab);
        if(!opportunitytab1)
        {
            document.getElementById('tb4').style.color = "#ff0000";
            sbmtstatus = false;
        }
        else
        {
            document.getElementById('tb4').style.color = "#3C8DBC";
        }
    }
    /////////////////////////////////////////////      
    
    
        
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