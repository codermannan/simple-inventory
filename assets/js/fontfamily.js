$(document).ready(function() {
     function format_date(oObj) {
            var aDate = oObj.split('-');
            <?php if(JS_DATE == 'dd-mm-yyyy') { ?>
            return aDate[2] + "-" + aDate[1] + "-" + aDate[0];
            <?php } elseif(JS_DATE == 'dd/mm/yyyy') { ?>
            return aDate[2] + "/" + aDate[1] + "/" + aDate[0];
            <?php } elseif(JS_DATE == 'dd.mm.yyyy') { ?>
            return aDate[2] + "." + aDate[1] + "." + aDate[0];
            <?php } elseif(JS_DATE == 'mm/dd/yyyy') { ?>
            return aDate[1] + "/" + aDate[2] + "/" + aDate[0];
            <?php } elseif(JS_DATE == 'mm-dd-yyyy') { ?>
            return aDate[1] + "-" + aDate[2] + "-" + aDate[0];
            <?php } elseif(JS_DATE == 'mm.dd.yyyy') { ?>
            return aDate[1] + "." + aDate[2] + "." + aDate[0];
            <?php } else { ?>
            return oObj;
            <?php } ?>
    }
         function currencyFormate(x) {
                if(x != null) {
                        var parts = x.toString().split(".");
                        return  parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",")+(parts[1] ? "." + parts[1] : ".00");
                } else {
                        return '0.00';
                }

        }
});                                