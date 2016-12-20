<link href="<?php echo $this->config->base_url(); ?>assets/css/datepicker.css" rel="stylesheet">
<style type="text/css">
    .table th { text-align:center; }
    .table td { vertical-align: middle; }
    .table td:last-child { text-align: center !important;}
</style>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui.js"></script>
<link href="<?php echo $this->config->base_url(); ?>assets/css/redactor.css" rel="stylesheet">
<script src="<?php echo $this->config->base_url(); ?>assets/js/redactor.min.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/validation.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('#byTab a, #noteTab a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        });
        //$('#byTab #select_by_code, #noteTab a:last').tab('show');
        //$('#byTab #select_by_codes, #noteTab a:last').tab('show');
        $('#byTab #select_by_name, #noteTab a:last').tab('show');
        $("#date").datepicker({
            format: "<?php echo JS_DATE; ?>",
            autoclose: true
        });
        $("#date").datepicker("setDate", new Date());
        $('form').form();

        var count = 1;
        var an = 1;
        var tax_rates = <?php echo json_encode($tax_rates); ?>;
        var DT = <?php echo DEFAULT_TAX; ?>;
        $('#code').keydown(function(e) {
            var item_cost, item_name, item_code, pr_tax;

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
                    url: "<?php echo $this->config->base_url(); ?>index.php?module=inventories&view=scan_item",
                    data: {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash() ?>", code: item_code},
                    dataType: "json",
                    success: function(data) {

                        item_cost = data.cost;
                        item_name = data.name;
                        pr_tax = data.tax_rate;

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
                var taxes = '';
                $.each(tax_rates, function() {
                    if (pr_tax) {
                        if (this.id == pr_tax.id) {
                            taxes += '<option value="' + this.id + '" selected="selected">' + this.name + '</option>';
                        } else {
                            taxes += '<option value="' + this.id + '">' + this.name + '</option>';
                        }
                    } else {
                        if (this.id == DT) {
                            taxes += '<option value="' + this.id + '" selected="selected">' + this.name + '</option>';
                        } else {
                            taxes += '<option value="' + this.id + '">' + this.name + '</option>';
                        }
                    }
                });

                var newTr = $('<tr id="row_' + count + '"></tr>');
                newTr.html('<td><input name="product' + count + '" type="hidden" value="' + item_code + '"><input class="span5 tran" style="text-align:left;" name="item' + count + '" type="text" value="' + item_name + ' (' + item_code + ')"></td><?php if (TAX1) { ?><td><select class="input-block-level" data-placeholder="Select..." name="tax_rate' + count + '" id="tax_rate-' + count + '">' + taxes + '</select></td><?php } ?><td><input class="input-block-level text-center" name="quantity' + count + '" type="text" value="1" onClick="this.select();"></td><td><input class="span2 tran" style="text-align:right;" name="unit_cost' + count + '" type="text" value="' + item_cost + '"></td><td><i class="icon-trash tip del" id="' + count + '" title="Remove this Item" style="cursor:pointer;" data-placement="right"></i></td>');
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

<?php
if ($this->input->post('submit')) {
    echo "$('.item_name').hide();";
}
?>
        $(".show_hide").slideDown('slow');

        $('.show_hide').click(function() {
            $(".item_name").slideToggle();
        });

        $("#name").autocomplete({
            source: function(request, response) {
                $.ajax({url: "<?php echo site_url('module=inventories&view=suggestions'); ?>",
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
                var item_cost;
                var pr_tax;
                var item_name = ui.item.label;

                $.ajax({
                    type: "get",
                    async: false,
                    url: "<?php echo $this->config->base_url(); ?>index.php?module=inventories&view=add_item",
                    data: {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash() ?>", name: item_name},
                    dataType: "json",
                    success: function(data) {

                        item_code = data.code;
                        item_cost = data.cost;
                        pr_tax = data.tax_rate;

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
                var taxes = '';
                $.each(tax_rates, function() {
                    if (pr_tax) {
                        if (this.id == pr_tax.id) {
                            taxes += '<option value="' + this.id + '" selected="selected">' + this.name + '</option>';
                        } else {
                            taxes += '<option value="' + this.id + '">' + this.name + '</option>';
                        }
                    } else {
                        if (this.id == DT) {
                            taxes += '<option value="' + this.id + '" selected="selected">' + this.name + '</option>';
                        } else {
                            taxes += '<option value="' + this.id + '">' + this.name + '</option>';
                        }
                    }
                });

                var newTr = $('<tr id="row_' + count + '"></tr>');
                newTr.html('<td><input name="product' + count + '" type="hidden" value="' + item_code + '"><input class="span5 tran" style="text-align:left;" name="item' + count + '" type="text" value="' + item_name + ' (' + item_code + ')"></td><?php if (TAX1) { ?><td><select class="input-block-level" data-placeholder="Select..." name="tax_rate' + count + '" id="tax_rate-' + count + '">' + taxes + '</select></td><?php } ?><td><input class="input-block-level text-center" name="quantity' + count + '" type="text" value="1" onClick="this.select();"></td><td><input class="span2 tran" style="text-align:right;" name="unit_cost' + count + '" type="text" value="' + item_cost + '"></td><td><i class="icon-trash tip del" id="' + count + '" title="Remove this Item" style="cursor:pointer;" data-placement="right"></i></td>');
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
                $.ajax({url: "<?php echo site_url('module=inventories&view=codeSuggestions'); ?>",
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
                var item_cost;
                var pr_tax;
                var item_code = ui.item.label;

                $.ajax({
                    type: "get",
                    async: false,
                    url: "<?php echo $this->config->base_url(); ?>index.php?module=inventories&view=scan_item",
                    data: {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash() ?>", code: item_code},
                    dataType: "json",
                    success: function(data) {

                        item_cost = data.cost;
                        item_name = data.name;
                        pr_tax = data.tax_rate;

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
                var taxes = '';
                $.each(tax_rates, function() {
                    if (pr_tax) {
                        if (this.id == pr_tax.id) {
                            taxes += '<option value="' + this.id + '" selected="selected">' + this.name + '</option>';
                        } else {
                            taxes += '<option value="' + this.id + '">' + this.name + '</option>';
                        }
                    } else {
                        if (this.id == DT) {
                            taxes += '<option value="' + this.id + '" selected="selected">' + this.name + '</option>';
                        } else {
                            taxes += '<option value="' + this.id + '">' + this.name + '</option>';
                        }
                    }
                });

                var newTr = $('<tr id="row_' + count + '"></tr>');
                newTr.html('<td><input name="product' + count + '" type="hidden" value="' + item_code + '"><input class="span5 tran" style="text-align:left;" name="item' + count + '" type="text" value="' + item_name + ' (' + item_code + ')"></td><?php if (TAX1) { ?><td><select class="input-block-level" data-placeholder="Select..." name="tax_rate' + count + '" id="tax_rate-' + count + '">' + taxes + '</select></td><?php } ?><td><input class="input-block-level text-center" name="quantity' + count + '" type="text" value="1" onClick="this.select();"></td><td><input class="span2 tran" style="text-align:right;" name="unit_cost' + count + '" type="text" value="' + item_cost + '"></td><td><i class="icon-trash tip del" id="' + count + '" title="Remove this Item" style="cursor:pointer;" data-placement="right"></i></td>');
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

        $('#supplier_l').on('click', function() {
            setTimeout(function() {
                $('#supplier_s').trigger('liszt:open');
            }, 0);
        });
        $('#warehouse_l').on('click', function() {
            setTimeout(function() {
                $('#warehouse_s').trigger('liszt:open');
            }, 0);
        });
        $("#add_options").draggable({refreshPositions: true});

    });
</script>

<?php
if ($message) {
    echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>";
}
?>

<h3 class="title"><?php echo $page_title; ?></h3>
<p><?php echo $this->lang->line("enter_info"); ?></p>

<?php $attrib = array('class' => 'form-horizontal', 'id' => 'addSale_form');
echo form_open("module=inventories&view=add", $attrib);
?>
<div class="control-group">
    <label class="control-label" for="date"><?php echo $this->lang->line("date"); ?></label>
    <div class="controls"> <?php echo form_input($date, (isset($_POST['date']) ? $_POST['date'] : ""), 'class="span4" id="date" required="required" data-error="' . $this->lang->line("date") . ' ' . $this->lang->line("is_required") . '"'); ?></div>
</div>
<div class="control-group">
    <label class="control-label" for="reference_no"><?php echo $this->lang->line("reference_no"); ?></label>
    <div class="controls"> <?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : $rnumber), 'class="span4 tip" id="reference_no" required="required" data-error="' . $this->lang->line("reference_no") . ' ' . $this->lang->line("is_required") . '"'); ?> </div>
</div>
<div class="control-group">
    <label class="control-label" id="warehouse_l"><?php echo $this->lang->line("warehouse"); ?></label>
    <div class="controls">  <?php
        $wh[''] = '';
        foreach ($warehouses as $warehouse) {
            $wh[$warehouse->id] = $warehouse->name;
        }
        echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : DEFAULT_WAREHOUSE), 'id="warehouse_s" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("warehouse") . '" required="required" data-error="' . $this->lang->line("warehouse") . ' ' . $this->lang->line("is_required") . '"');
        ?> </div>
</div>
<div class="control-group">
    <label class="control-label" id="supplier_l"><?php echo $this->lang->line("supplier"); ?></label>
    <div class="controls">  <?php
        $sp[""] = "";
        foreach ($suppliers as $supplier) {
            if ($supplier->company == "-" || !$supplier->company) {
                $sp[$supplier->id] = $supplier->name . " (P)";
            } else {
                $sp[$supplier->id] = $supplier->company . " (C)";
            }
        }
        echo form_dropdown('supplier', $sp, (isset($_POST['supplier']) ? $_POST['supplier'] : ""), 'id="supplier_s" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("supplier") . '" required="required" data-error="' . $this->lang->line("supplier") . ' ' . $this->lang->line("is_required") . '"');
        ?> </div>
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

<div class="control-group">
    <label class="control-label"><?php echo $this->lang->line("inventory_items"); ?></label>
    <div class="controls">
        <table id="dyTable" class="table items table-striped table-bordered table-condensed table-hover">
            <thead>
            <th class="span5"><?php echo $this->lang->line("product_name") . " (" . $this->lang->line("product_code") . ")"; ?></th>
<?php
if (TAX1) {
    echo '<th class="span2">' . $this->lang->line("tax_rate") . '</th>';
}
?>
            <th class="span2"><?php echo $this->lang->line("quantity"); ?></th>
            <th class="span2"><?php echo $this->lang->line("unit_cost"); ?></th>
            <th style="width: 20px;"><i class="icon-trash" style="opacity:0.5; filter:alpha(opacity=50);"></i></th>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>   


<div class="control-group">
    <label class="control-label" for="note"><?php echo $this->lang->line("note"); ?></label>
    <div class="controls"> <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'id="note" class="input-block-level" style="margin-top: 10px; height: 100px;"'); ?> </div>
</div>
<div class="control-group"><div class="controls"><?php echo form_submit('submit', $this->lang->line("submit"), 'class="btn btn-primary" style="padding: 6px 15px;"'); ?></div></div>
<?php echo form_close(); ?> 

