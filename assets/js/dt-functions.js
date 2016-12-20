
     function format_date(oObj) {
            var aDate = oObj.split('-');
            if(JS_DATE == 'dd-mm-yyyy') 
            return aDate[2] + "-" + aDate[1] + "-" + aDate[0];
            else if(JS_DATE === 'dd/mm/yyyy') 
            return aDate[2] + "/" + aDate[1] + "/" + aDate[0];
            else if(JS_DATE == 'dd.mm.yyyy') 
            return aDate[2] + "." + aDate[1] + "." + aDate[0];
            else if(JS_DATE == 'mm/dd/yyyy') 
            return aDate[1] + "/" + aDate[2] + "/" + aDate[0];
            else if(JS_DATE == 'mm-dd-yyyy') 
            return aDate[1] + "-" + aDate[2] + "-" + aDate[0];
            else if(JS_DATE == 'mm.dd.yyyy') 
            return aDate[1] + "." + aDate[2] + "." + aDate[0];
            else 
            return oObj;
    }
         function currencyFormate(x) {
                if(x != null) {
                        var parts = x.toString().split(".");
                        return  parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",")+(parts[1] ? "." + parts[1] : ".00");
                } else {
                        return '0.00';
                }
        }                             