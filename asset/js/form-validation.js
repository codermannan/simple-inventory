

//==========================================================
//  Add Supplier Form Validation
//==========================================================
$().ready(function() {
    $("#addSupplierForm").validate({


        rules: {

            company_name: {
                required: true
            },
            supplier_name: {
                required: true
            },

            email: {
                required: true,
                email: true
            },

            phone: {
                required: true,
                number: true

            }
        },

        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        }
    })
});



//==========================================================
//  Add Product Form Validation
//==========================================================
jQuery.validator.addMethod("noSpace", function(value, element) {
    return value.indexOf(" ") < 0 && value != "";
}, "Space are not allowed");
$().ready(function() {
    $("#addProductForm").validate({
        ignore: [],
        rules: {

            product_name: {
                required: true
            },
            subcategory_id: {
                required: true
            },

            tax_id: {
                required: true
            },

            buying_price: {
                required: true,
                number:true

            },
            selling_price: {
                required: true,
                number:true,
                greaterThanSelling: "#buying_price"

            },
            product_quantity: {
                required: true,
                number:true

            },
            notify_quantity: {
                required: true,
                number:true,
                greaterThanInventory: "#product_quantity"
            },
            offer_price: {
                number:true
            },
            "tier_price[]": {
                number:true
            },
            "tier_quantity[]": {
                number:true
            },

            end_date: { greaterThanDate: "#start_date" }
        },

        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }

    })
});

$("[id=submit]").submit(function(e) {
    if (e.preventDefault()) {
    }

});


//==========================================================
//  Damage Product Form Validation
//==========================================================
$().ready(function() {
    $("#damageProductForm").validate({


        rules: {

            product_id: {
                required: true
            },
            qty: {
                required: true
            },

            note: {
                required: true
            },

            decrease: {
                required: true
            }
        },

        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        }
    })
});


//==========================================================
//  Add Customer Form Validation
//==========================================================
$().ready(function() {
    $("#addCustomerForm").validate({
        ignore: [],

        rules: {

            customer_name: {
                required: true
            },
            email: {
                required: true,
                email:true
            },

            phone: {
                required: true,
                number: true
            },

            discount: {
                required: true,
                number: true
            },

            address:{
                required: function()
                {
                    CKEDITOR.instances.ck_editor.updateElement();
                },

                minlength:10
            }
        },

        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        }
    })
});


//==========================================================
//  Image Validation
//==========================================================

function imageForm(thisform)
{
    with (thisform)
    {

        if (validateFileExtension(product_image, "valid_msg", "Image files are only allowed!",
                new Array("jpg", "jpeg", "gif", "png")) == false)
        {
            return false;
        }
        if (validateFileSize(product_image, 1048576, "valid_msg", "Image size should be less than 1MB !") == false)
        {
            return false;
        }
    }

}


function companyLogo(thisform)
{

    with (thisform)
    {

        if (validateFileExtension(logo, "valid_msg", "Image files are only allowed!",
                new Array("jpg", "jpeg", "gif", "png")) == false)
        {
            return false;
        }
        if (validateFileSize(logo, 1048576, "valid_msg", "Image size should be less than 1MB !") == false)
        {
            return false;
        }
    }

}

function employeeImage(thisform)
{
    with (thisform)
    {

        if (validateFileExtension(employee_image, "valid_msg", "Image files are only allowed!",
                new Array("jpg", "jpeg", "gif", "png")) == false)
        {
            return false;
        }
        if (validateFileSize(employee_image, 1048576, "valid_msg", "Image size should be less than 1MB !") == false)
        {
            return false;
        }
    }

}




function validateFileExtension(component, msg_id, msg, extns)
{

    var flag = 0;
    with (component)
    {
        var ext = value.substring(value.lastIndexOf('.') + 1);
        if (ext) {
            for (i = 0; i < extns.length; i++)
            {
                if (ext == extns[i])
                {
                    flag = 0;
                    break;
                }
                else
                {
                    flag = 1;
                }
            }
            if (flag != 0)
            {
                document.getElementById(msg_id).innerHTML = msg;
                component.value = "";
                component.style.backgroundColor = "#eab1b1";
                component.style.border = "thin solid #000000";
                component.focus();
                return false;
            }
            else
            {
                return true;
            }
        }
    }
}

function validateFileSize(component, maxSize, msg_id, msg)
{
    if (navigator.appName == "Microsoft Internet Explorer")
    {
        if (component.value)
        {
            var oas = new ActiveXObject("Scripting.FileSystemObject");
            var e = oas.getFile(component.value);
            var size = e.size;
        }
    }
    else
    {
        if (component.files[0] != undefined)
        {
            size = component.files[0].size;
        }
    }
    if (size != undefined && size > maxSize)
    {
        document.getElementById(msg_id).innerHTML = msg;
        component.value = "";
        component.style.backgroundColor = "#eab1b1";
        component.style.border = "thin solid #000000";
        component.focus();
        return false;
    }
    else
    {
        return true;
    }
}