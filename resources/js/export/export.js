function exportToExcel(tableID){
    
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6' style='height: 75px; text-align: center; width: 250px'>";
    var textRange; var j=0;
    tab = document.getElementById(tableID); // id of table
    var ecols= $('input[name ="ecols"]:checked') 
    console.log(ecols);

    for(j = 0 ; j < tab.rows.length ; j++)
    {
        if (j!==0) {
            tab_text=tab_text+"<tr>";
        }
        // tab_text=tab_text;
        if (ecols.length==0) {
            tab_text=tab_text+tab.rows[j].innerHTML.toUpperCase()+"</tr>";
        } else {
            // only add selected columns
            
            for (i = 0 ; i < ecols.length ; i++) {
                var colIndex = parseInt(ecols[i].value, 10);
                tab_text=tab_text+"<td>"+tab.rows[j].cells[colIndex].innerHTML.toUpperCase()+"</td>";
            }
            tab_text=tab_text+"</tr>";
        } 
        //tab_text=tab_text+"</tr>";
    }

    tab_text= tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); //remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); //remove input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer

    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write( 'sep=,\r\n' + tab_text);
        txtArea1.document.close();
        txtArea1.focus();
        sa=txtArea1.document.execCommand("SaveAs",true,"sudhir123.txt");
    }

    else {
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
    }
    
    return (sa);
}