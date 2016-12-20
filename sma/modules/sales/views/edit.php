<?php
$reference_no = array(
    'name' => 'reference_no',
    'id' => 'reference_no',
    'value' => $inv->reference_no,
    'class' => 'span4'
);
$date = array(
    'name' => 'date',
    'id' => 'date',
    'value' => date(PHP_DATE, strtotime($inv->date)),
    'class' => 'span4'
);

$note = array(
    'name' => 'note',
    'id' => 'note',
    'value' => $inv->note,
    'class' => 'input-block-level',
    'style' => 'height: 100px;'
);


$pr_value = sizeof($inv_products);
$cno = $pr_value + 1;
?>

<link href="<?php echo $this->config->base_url(); ?>assets/css/datepicker.css" rel="stylesheet">
<style type="text/css">
    .table th { text-align:center; }
    .table td { vertical-align: middle; }
    .table td:last-child { text-align: center !important;}
    .select {
        min-height: 26px !important;  
        height: 26px !important;
        text-align:left !important;
        background: url(<?php echo $this->config->base_url(); ?>assets/img/darrow.png) no-repeat right transparent;
    }
</style>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/validation.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var count = <?php echo $cno; ?>;
        var an = <?php echo $cno; ?>;
        $("#date").datepicker({
            format: "<?php echo JS_DATE; ?>",
            autoclose: true
        });
        //$(".tip").tooltip({placement: "right", trigger: "focus"});
        $('form').form();

        $('#code').keydown(function(e) {
            var item_price;
            var item_name;
            var item_code;

            if (e.keyCode == 13) {

                if (an >=<?php echo TOTAL_ROWS; ?>) {
                    alert("You have reached the max item limit.");
                    return false;
                }
                if (count >= 200) {
                    alert("You have reached the max item limit.");
                    return false;
                }

                item_code = $(this).val();

                $.ajax({
                    type: "get",
                    async: false,
                    url: "<?php echo $this->config->base_url(); ?>index.php?module=sales&view=scan_item",
                    data: {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash() ?>", code: item_code},
                    dataType: "json",
                    success: function(data) {

                        item_price = data.price;
                        item_name = data.name.replace(/"/g, "&#034;").replace(/'/g, "&#039;");;

                    },
                    error: function() {
                        alert('<?php echo $this->lang->line('code_error'); ?>');
                        item_name = false;
                    }

                });

                if (item_name == false) {
                    $(this).val('');
                    return false;
                }


                var newTr = $('<tr id="row_' + count + '"></tr>');
                newTr.html('<td><input name="product' + count + '" type="hidden" value="' + item_code + '"><input class="span5 tran" style="text-align:left;" name="item' + count + '" type="text" value="' + item_name + ' (' + item_code + ')"></td><?php
if (PRODUCT_SERIAL) {
    echo '<td><input class="span2 tran2" name="serial\'+ count +\'" type="text" value=""></td>';
}
if (DISCOUNT_OPTION == 2) {
    echo '<td><select class="span2 tran" data-placeholder="Select..." name="discount\' + count + \'" id="tax_rate\' + count + \'">';
    foreach ($discounts as $discount) {
        echo "<option value=" . $discount->id;
        if ($discount->id == DEFAULT_DISCOUNT) {
            echo ' selected="selected"';
        }
        echo ">" . $discount->name . "</option>";
    }
    echo '</select></td>';
}
if (TAX1) {
    echo '<td><select class="input-block-level" data-placeholder="Select..." name="tax_rate\' + count + \'" id="tax_rate\' + count + \'">';
    foreach ($tax_rates as $tax) {
        echo "<option value=" . $tax->id;
        if ($tax->id == DEFAULT_TAX) {
            echo ' selected="selected"';
        }
        echo ">" . $tax->name . "</option>";
    }
    echo '</select></td>';
}
?><td><input class="input-block-level text-center" name="quantity' + count + '" type="text" value="1" onClick="this.select();"></td><td><input class="span2 tran" style="text-align:right;" name="unit_price' + count + '" type="text" value="' + item_price + '"></td><td><i class="icon-trash tip del" id="' + count + '" title="Remove this Item" style="cursor:pointer;" data-placement="right"></i></td>');
                newTr.prependTo("#dyTable");

                count++;
                an++;
                $("form select").chosen({no_results_text: "<?php echo $this->lang->line('no_results_matched'); ?>", disable_search_threshold: 5, allow_single_deselect: true});

                $(this).val('');
                e.preventDefault();
                return false;
            }

        });

        $('#code').bind('keypress', function(e)
        {
            if (e.keyCode == 13)
            {
                e.preventDefault();
                return false;
            }
        });

        $("#dyTable").on("click", '.del', function() {

            var delID = $(this).attr('id');

            row_id = $("#row_" + delID);
            row_id.remove();

            an--;

        });

<?php if ($this->input->post('submit')) {
    echo "$('.item_name').hide();";
} ?>
        $(".show_hide").slideDown('slow');

        $('.show_hide').click(function() {
            $(".item_name").slideToggle();
            return false;
        });

        $("#name").autocomplete({
            source: function(request, response) {
                $.ajax({url: "<?php echo site_url('module=sales&view=suggestions'); ?>",
                    data: {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash() ?>", term: $("#name").val()},
                    dataType: "json",
                    type: "get",
                    success: function(data) {
                        response(data);
                    },
                    error: function(result) {
                        alert('<?php echo $this->lang->line('no_suggestions'); ?>');
                        $('.ui-autocomplete-input').removeClass("ui-autocomplete-loading");
                        $('#codes').val('');
                        return false;
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
            $(this).removeClass('ui-autocomplete-loading');

                if (an >=<?php echo TOTAL_ROWS; ?>) {
                    alert("You have reached the max item limit.");
                    return false;
                }
                if (count >= 200) {
                    alert("You have reached the max item limit.");
                    return false;
                }
                var item_code;
                var item_price;
                var item_name = ui.item.label;

                $.ajax({
                    type: "get",
                    async: false,
                    url: "<?php echo $this->config->base_url(); ?>index.php?module=sales&view=add_item",
                    data: {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash() ?>", name: item_name},
                    dataType: "json",
                    success: function(data) {

                        item_code = data.code;
                        item_price = data.price;

                    },
                    error: function() {
                        alert('<?php echo $this->lang->line('code_error'); ?>');
                        $('.ui-autocomplete-loading').removeClass("ui-autocomplete-loading");
                        item_name = false;
                    }

                });

                if (item_name == false) {
                    $(this).val('');
                    return false;
                }


                var newTr = $('<tr id="row_' + count + '"></tr>');
                newTr.html('<td><input name="product' + count + '" type="hidden" value="' + item_code + '"><input class="span5 tran" style="text-align:left;" name="item' + count + '" type="text" value="' + item_name.replace(/"/g, "&#034;").replace(/'/g, "&#039;") + ' (' + item_code + ')"></td><?php
if (PRODUCT_SERIAL) {
    echo '<td><input class="span2 tran2" name="serial\'+ count +\'" type="text" value=""></td>';
}
if (DISCOUNT_OPTION == 2) {
    echo '<td><select class="span2 tran" data-placeholder="Select..." name="discount\' + count + \'" id="discount-\' + count + \'">';
    foreach ($discounts as $discount) {
        echo "<option value=" . $discount->id;
        if ($discount->id == DEFAULT_DISCOUNT) {
            echo ' selected="selected"';
        }
        echo ">" . $discount->name . "</option>";
    }
    echo '</select></td>';
} if (TAX1) {
    echo '<td><select class="input-block-level" data-placeholder="Select..." name="tax_rate\' + count + \'" id="tax_rate-\' + count + \'">';
    foreach ($tax_rates as $tax) {
        echo "<option value=" . $tax->id;
        if ($tax->id == DEFAULT_TAX) {
            echo ' selected="selected"';
        }
        echo ">" . $tax->name . "</option>";
    }
    echo '</select></td>';
}
?><td><input class="input-block-level text-center" name="quantity' + count + '" id="quantity-' + count + '" type="text" value="1" onClick="this.select();"></td><td><input class="span2 tran" style="text-align:right;" name="unit_price' + count + '" id="price-' + count + '" type="text" value="' + item_price + '"></td><td><i class="icon-trash tip del" id="' + count + '" title="Remove this Item" style="cursor:pointer;" data-placement="right"></i></td>');
                newTr.prependTo("#dyTable");

                count++;
                an++;
                $("form select").chosen({no_results_text: "<?php echo $this->lang->line('no_results_matched'); ?>", disable_search_threshold: 5, allow_single_deselect: true});

            },
            close: function() {
                $('#name').val('');
            }
        });

        $("#codes").autocomplete({
            source: function(request, response) {
                $.ajax({url: "<?php echo site_url('module=sales&view=codeSuggestions'); ?>",
                    data: {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash() ?>", term: $("#codes").val()},
                    dataType: "json",
                    type: "get",
                    success: function(data) {
                        response(data);
                    },
                    error: function(result) {
                        alert('<?php echo $this->lang->line('no_suggestions'); ?>');
                        $('.ui-autocomplete-input').removeClass("ui-autocomplete-loading");
                        $('#codes').val('');
                        return false;
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
            $(this).removeClass('ui-autocomplete-loading');

                if (an >=<?php echo TOTAL_ROWS; ?>) {
                    alert("You have reached the max item limit.");
                    return false;
                }
                if (count >= 200) {
                    alert("You have reached the max item limit.");
                    return false;
                }
                var item_price;
                var item_code = ui.item.label;

                $.ajax({
                    type: "get",
                    async: false,
                    url: "<?php echo $this->config->base_url(); ?>index.php?module=sales&view=scan_item",
                    data: {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash() ?>", code: item_code},
                    dataType: "json",
                    success: function(data) {

                        item_price = data.price;
                        item_name = data.name.replace(/"/g, "&#034;").replace(/'/g, "&#039;");;

                    },
                    error: function() {
                        alert('<?php echo $this->lang->line('code_error'); ?>');
                        item_name = false;
                    }

                });

                if (item_name == false) {
                    $(this).val('');
                    return false;
                }


                var newTr = $('<tr id="row_' + count + '"></tr>');
                newTr.html('<td><input name="product' + count + '" type="hidden" value="' + item_code + '"><input class="span5 tran" style="text-align:left;" name="item' + count + '" type="text" value="' + item_name + ' (' + item_code + ')"></td><?php
if (PRODUCT_SERIAL) {
    echo '<td><input class="span2 tran2" name="serial\'+ count +\'" type="text" value=""></td>';
}
if (DISCOUNT_OPTION == 2) {
    echo '<td><select class="span2 tran" data-placeholder="Select..." name="discount\' + count + \'" id="tax_rate\' + count + \'">';
    foreach ($discounts as $discount) {
        echo "<option value=" . $discount->id;
        if ($discount->id == DEFAULT_DISCOUNT) {
            echo ' selected="selected"';
        }
        echo ">" . $discount->name . "</option>";
    }
    echo '</select></td>';
}
if (TAX1) {
    echo '<td><select class="input-block-level" data-placeholder="Select..." name="tax_rate\' + count + \'" id="tax_rate\' + count + \'">';
    foreach ($tax_rates as $tax) {
        echo "<option value=" . $tax->id;
        if ($tax->id == DEFAULT_TAX) {
            echo ' selected="selected"';
        }
        echo ">" . $tax->name . "</option>";
    }
    echo '</select></td>';
}
?><td><input class="input-block-level text-center" name="quantity' + count + '" type="text" value="1" onClick="this.select();"></td><td><input class="span2 tran" style="text-align:right;" name="unit_price' + count + '" type="text" value="' + item_price + '"></td><td><i class="icon-trash tip del" id="' + count + '" title="Remove this Item" style="cursor:pointer;" data-placement="right"></i></td>');
                newTr.prependTo("#dyTable");

                count++;
                an++;
                $("form select").chosen({no_results_text: "<?php echo $this->lang->line('no_results_matched'); ?>", disable_search_threshold: 5, allow_single_deselect: true});



            },
            close: function() {
                $('#codes').val('');
            }
        });

        $(".ui-autocomplete ").addClass('span4');
        $('#item_name').bind('keypress', function(e)
        {
            if (e.keyCode == 13)
            {
                e.preventDefault();
                return false;
            }
        });

        $("form").submit(function() {
            if (an <= 1) {
                alert("<?php echo $this->lang->line('no_invoice_item'); ?>");
                return false;
            }
        });

        $('#customer_l').on('click', function() {
            setTimeout(function() {
                $('#customer_s').trigger('liszt:open');
            }, 0);
        });
        $('#biller_l').on('click', function() {
            setTimeout(function() {
                $('#biller_s').trigger('liszt:open');
            }, 0);
        });
        $('#warehouse_l').on('click', function() {
            setTimeout(function() {
                $('#warehouse_s').trigger('liszt:open');
            }, 0);
        });
        $('#discount_l').on('click', function() {
            setTimeout(function() {
                $('#discount_s').trigger('liszt:open');
            }, 0);
        });
        $('#tax2_l').on('click', function() {
            setTimeout(function() {
                $('#tax2_s').trigger('liszt:open');
            }, 0);
        });
        $('#byTab a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        })

        //For Product Name
        $('#byTab a:last').tab('show');

        //For Barcode Scanner Please uncommetn the below 3 lines just remove the // only
        //$('#byTab a:first').tab('show');
        //$('#by_name').removeClass('active');
        //$('#by_code').addClass('active');

    });
</script>

        <?php if ($message) {
            echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>";
        } ?>

<h3 class="title"><?php echo $page_title; ?></h3>
<p><?php echo $this->lang->line("enter_info"); ?></p>

        <?php $attrib = array('class' => 'form-horizontal', 'id' => 'addSale_form');
        echo form_open("module=sales&view=edit&id=" . $id, $attrib); ?>
<div class="control-group">
    <label class="control-label" for="date"><?php echo $this->lang->line("date"); ?></label>
    <div class="controls"> <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : date(PHP_DATE, strtotime($inv->date))), 'class="span4" id="date" required="required" data-error="' . $this->lang->line("date") . ' ' . $this->lang->line("is_required") . '"'); ?></div>
</div>
<div class="control-group">
    <label class="control-label" for="reference_no"><?php echo $this->lang->line("reference_no"); ?></label>
    <div class="controls"> <?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : $inv->reference_no), 'class="span4 tip" id="reference_no" required="required" data-error="' . $this->lang->line("reference_no") . ' ' . $this->lang->line("is_required") . '"'); ?> </div>
</div>
<div class="control-group">
    <label class="control-label" id="biller_l"><?php echo $this->lang->line("biller"); ?></label>
    <div class="controls">  <?php
        $bl[""] = "";
        foreach ($billers as $biller) {
            $bl[$biller->id] = $biller->name;
        }
        echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : $inv->biller_id), 'id="biller_s" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("biller") . '" required="required" data-error="' . $this->lang->line("biller") . ' ' . $this->lang->line("is_required") . '"');
        ?> </div>
</div>
<div class="control-group">
    <label class="control-label" id="customer_l"><?php echo $this->lang->line("customer"); ?></label>
    <div class="controls">  <?php
        $cu[""] = "";
        foreach ($customers as $customer) {
            if ($customer->company == "-" || !$customer->company) {
                $cu[$customer->id] = $customer->name . " (P)";
            } else {
                $cu[$customer->id] = $customer->company . " (C)";
            }
        }
        echo form_dropdown('customer', $cu, (isset($_POST['customer']) ? $_POST['customer'] : $inv->customer_id), 'id="customer_s" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("customer") . '" required="required" data-error="' . $this->lang->line("customer") . ' ' . $this->lang->line("is_required") . '"');
        ?> </div>
</div>
<?php if (TAX2) { ?>
    <div class="control-group">
        <label class="control-label" id="tax2_l"><?php echo $this->lang->line("tax2"); ?></label>
        <div class="controls">  <?php
    $tr[""] = "";
    foreach ($tax_rates as $tax) {
        $tr[$tax->id] = $tax->name;
    }
    echo form_dropdown('tax2', $tr, (isset($_POST['tax2']) ? $_POST['tax2'] : $inv->tax_rate2_id), 'id="tax2_s" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("tax2") . '" required="required" data-error="' . $this->lang->line("tax2") . ' ' . $this->lang->line("is_required") . '"');
    ?> </div>
    </div>
<?php } ?>
<?php if (DISCOUNT_OPTION == 1) { ?>
    <div class="control-group">
        <label class="control-label" id="discount_l"><?php echo $this->lang->line("discount"); ?></label>
        <div class="controls">  <?php
    $ds[""] = "";
    foreach ($discounts as $discount) {
        $ds[$discount->id] = $discount->name;
    }
    echo form_dropdown('inv_discount', $ds, (isset($_POST['inv_discount']) ? $_POST['inv_discount'] : $inv->discount_id), 'id="discount_s" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("discount") . '" required="required" data-error="' . $this->lang->line("discount") . ' ' . $this->lang->line("is_required") . '"');
    ?> </div>
    </div>
<?php } ?>
<div class="control-group" style="margin-bottom:5px;">
    <label class="control-label" for="shipping"><?php echo $this->lang->line("shipping"); ?></label>
    <div class="controls"> <?php echo form_input('shipping', $inv->shipping, 'class="span4" id="shipping"'); ?>
    </div>
</div>

<div class="control-group">
    <div class="controls">
        <div class="span4" id="drag">
            <div class="add_options clearfix" id="add_options">
                <div id="draggable"><?php echo $this->lang->line('draggable'); ?></div>
                <div class="fancy-tab-container">
                    <ul class="nav nav-tabs three-tabs fancy" id="byTab">
                        <li class="active"><a href="#by_code" id="select_by_code"><?php echo $this->lang->line("barcode_scanner"); ?></a></li>
                        <li><a href="#by_codes" id="select_by_codes"><?php echo $this->lang->line("product_code"); ?></a></li>
                        <li><a href="#by_name" id="select_by_name"><?php echo $this->lang->line("product_name"); ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane tab-bg" id="by_code" > <?php echo form_input('code', '', 'class="input-block-level ttip" id="code" data-placement="top" data-trigger="focus" placeholder="' . $this->lang->line("barcode_scanner") . '" title="' . $this->lang->line("use_barcode_scanner_tip") . '"'); ?> </div>
                        <div class="tab-pane tab-bg" id="by_codes" > <?php echo form_input('codes', '', 'class="input-block-level ttip" id="codes" data-placement="top" data-trigger="focus" placeholder="' . $this->lang->line("product_code") . '" title="' . $this->lang->line("au_pr_name_tip") . '"'); ?> </div>
                        <div class="tab-pane tab-bg active" id="by_name"> <?php echo form_input('name', '', 'class="input-block-level ttip" id="name" data-placement="top" data-trigger="focus" placeholder="' . $this->lang->line("product_name") . '" title="' . $this->lang->line("au_pr_name_tip") . '"'); ?> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="control-group table-group">
    <label class="control-label table-label"><?php echo $this->lang->line("invoice_items"); ?></label>
    <div class="controls table-controls">
        <table id="dyTable" class="table items table-striped table-bordered table-condensed table-hover">
            <thead>
            <th class="span5"><?php echo $this->lang->line("product_name") . " (" . $this->lang->line("product_code") . ")"; ?></th>
<?php if (PRODUCT_SERIAL) {
    echo '<th class="span2">' . $this->lang->line("serial_no") . '</th>';
} ?>
<?php if (DISCOUNT_OPTION == 2) {
    echo '<th class="span2">' . $this->lang->line("discount") . '</th>';
} ?>
        <?php if (TAX1) {
            echo '<th class="span2">' . $this->lang->line("tax_rate") . '</th>';
        } ?>
            <th class="span2"><?php echo $this->lang->line("quantity"); ?></th>
            <th class="span2"><?php echo $this->lang->line("unit_price"); ?></th>
            <th style="width: 20px;"><i class="icon-trash" style="opacity:0.5; filter:alpha(opacity=50);"></i></th>
            </thead>
            <tbody>
<?php
$r = 1;
foreach ($inv_products as $prod) {

    echo '<tr id="row_' . $r . '"><td><input name="product' . $r . '" type="hidden" value="' . $prod->product_code . '"><input class="span5 tran" style="text-align:left;" name="item' . $r . '" type="text" value="' . str_replace(array('"', '\''), array('&#034;', '&#039;'), $prod->product_name) . ' (' . $prod->product_code . ')"></td>';
    if (PRODUCT_SERIAL) {
        echo '<td><input class="span2 tran2" name="serial' . $r . '" id="serial' . $r . '" type="text" value="' . $prod->serial_no . '"></td>';
    }
    if (DISCOUNT_OPTION == 2) {
        echo '<td><select class="span2 tran" data-placeholder="Select..." name="discount' . $r . '" id="discount-' . $r . '">';
        foreach ($discounts as $discount) {
            echo "<option value=" . $discount->id;
            if ($discount->id == $prod->discount_id) {
                echo ' selected="selected"';
            }
            echo ">" . $discount->name . "</option>";
        }
        echo '</select></td>';
    }

    if (TAX1) {
        echo '<td><select class="input-block-level" data-placeholder="Select..." name="tax_rate' . $r . '" id="tax_rate-' . $r . '">';
        foreach ($tax_rates as $tax) {
            echo "<option value=" . $tax->id;
            if ($tax->id == $prod->tax_rate_id) {
                echo ' selected="selected"';
            }
            echo ">" . $tax->name . "</option>";
        }
        echo '</select></td>';
    }

    echo '<td><input class="input-block-level text-center" name="quantity' . $r . '" id="quantity-' . $r . '" type="text" value="' . $prod->quantity . '"></td><td><input class="span2 tran" style="text-align:right;" name="unit_price' . $r . '" name="price-' . $r . '" type="text" value="' . $prod->unit_price . '"></td><td><i class="icon-trash tip del" id="' . $r . '" title="Remove this Item" style="cursor:pointer;" data-placement="right"></i></td></tr>';
    $r++;
}
?>
            </tbody>
        </table>
    </div>
</div>  

<div class="control-group">
    <label class="control-label" for="internal_note"><?php echo $this->lang->line("internal_note"); ?></label>
    <div class="controls">
<?php echo form_textarea('internal_note', (isset($_POST['internal_note']) ? $_POST['internal_note'] : html_entity_decode($inv->internal_note)), 'class="input-block-level" id="internal_note" style="margin-top: 10px; height: 100px;"'); ?> 
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="note"><?php echo $this->lang->line("on_invoice_note"); ?></label>
    <div class="controls">
<?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : html_entity_decode($inv->note)), 'class="input-block-level" id="note" style="margin-top: 10px; height: 100px;"'); ?> 
    </div>
</div>

<div class="control-group"><div class="controls"><?php echo form_submit('submit', $this->lang->line("submit"), 'class="btn btn-primary" style="padding: 6px 15px;"'); ?></div></div>
<?php echo form_close(); ?> 
