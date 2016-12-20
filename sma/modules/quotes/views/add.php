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
        var shipping = 0;
        var total = 0;
        var total_discount = 0;
        var total_tax1 = 0;
        var total_tax2 = 0;
        var DT = <?php echo DEFAULT_DISCOUNT; ?>;
        var discount_method = <?php echo DISCOUNT_METHOD; ?>;
        var tax_rates = <?php echo json_encode($tax_rates); ?>;
        var discounts = <?php echo json_encode($discounts); ?>;
<?php if (DISCOUNT_OPTION == 1) { ?>
            var discount = <?php echo $discount_rate; ?>;
            var discount_type = <?php echo $discount_type; ?>;
<?php } ?>
<?php if (DISCOUNT_OPTION == 2) { ?>
            var discount2 = <?php echo $discount_rate2; ?>;
            var discount_type2 = <?php echo $discount_type2; ?>;
<?php } ?>
<?php if (TAX1) { ?>
            var tax_rate = <?php echo $tax_rate; ?>;
            var tax_type = <?php echo $tax_type; ?>;
<?php } ?>
<?php if (TAX2) { ?>
            var tax_rate2 = <?php echo $tax_rate2; ?>;
            var tax_type2 = <?php echo $tax_type2; ?>;
<?php } ?>

        $('#code').keydown(function(e) {
            var item_price, item_name, item_code, pr_tax;

            if (e.keyCode == 13) {

                if (an >=<?php echo TOTAL_ROWS; ?>) {
                    bootbox.alert("You have reached the max item limit.");
                    return false;
                }
                if (count >= 200) {
                    bootbox.alert("You have reached the max item limit.");
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
                        item_name = data.name;
                        pr_tax = data.tax_rate;

                    },
                    error: function() {
                        bootbox.alert('<?php echo $this->lang->line('code_error'); ?>');
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
                newTr.html('<td><input name="product' + count + '" type="hidden" value="' + item_code + '"><input class="span5 tran" style="text-align:left;" name="item' + count + '" type="text" value="' + item_name + ' (' + item_code + ')"></td><?php
if (DISCOUNT_OPTION == 2) {
    echo '<td><select class="span2 select tran" data-placeholder="Select..." name="discount\' + count + \'" id="discount-\' + count + \'">';
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
    ?><td><select class="input-block-level" data-placeholder="Select..." name="tax_rate' + count + '" id="tax_rate-' + count + '">' + taxes + '</select></td><?php }
?><td><input class="input-block-level text-center" name="quantity' + count + '" type="text" value="1" id="quantity-' + count + '" onClick="this.select();"></td><td><input class="span2 tran" style="text-align:right;" name="unit_price' + count + '" type="text" id="price-' + count + '" value="' + item_price + '"></td><td><i class="icon-trash tip del" id="' + count + '" title="Remove this Item" style="cursor:pointer;" data-placement="right"></i></td>');
                newTr.prependTo("#dyTable");

                count++;
                an++;
<?php if (TAX1) { ?>

                    if (pr_tax) {
                        if (pr_tax.type == 2) {
                            pr_tax_rate = parseFloat(pr_tax.rate);
                        }
                        if (pr_tax.type == 1) {
                            pr_tax_rate = (item_price * parseFloat(pr_tax.rate)) / 100;
                        }
                        total_tax1 += pr_tax_rate;
                    } else {
                        if (tax_type == 2) {
                            pr_tax_rate = tax_rate;
                        }
                        if (tax_type == 1) {
                            pr_tax_rate = (item_price * tax_rate) / 100;
                        }
                        total_tax1 += pr_tax_rate;
                    }


<?php } else { ?>
                    pr_tax_rate = 0;
<?php } ?>

                total += parseFloat(item_price);

<?php if (TAX2) { ?>
                    if (tax_type2 == 2) {
                        total_tax2 = tax_rate2;
                    }
                    if (tax_type2 == 1) {
                        total_tax2 = (total * tax_rate2) / 100;
                    }
<?php } ?>
<?php if (DISCOUNT_METHOD == 1 && DISCOUNT_OPTION == 1) { ?>
                    if (discount_type == 2) {
                        total_discount = discount;
                    }
                    if (discount_type == 1) {
                        total_discount = (total * discount) / 100;
                    }
<?php } elseif (DISCOUNT_METHOD == 2 && DISCOUNT_OPTION == 1) { ?>
                    if (discount_type == 2) {
                        total_discount = discount;
                    }
                    if (discount_type == 1) {
                        total_discount = ((total + total_tax1 + total_tax2) * discount) / 100;
                    }
<?php } ?>

<?php if (DISCOUNT_OPTION == 2) { ?>

    <?php if (DISCOUNT_METHOD == 1) { ?>
                        if (discount_type2 == 2) {
                            pr_discount = discount2;
                        }
                        if (discount_type2 == 1) {
                            pr_discount = (item_price * discount2) / 100;
                        }
    <?php } elseif (DISCOUNT_METHOD == 2) { ?>
                        if (discount_type2 == 2) {
                            pr_discount = discount2;
                        }
                        if (discount_type2 == 1) {
                            pr_discount = ((parseFloat(item_price) + pr_tax_rate) * discount2) / 100;
                        }
    <?php } ?>
                    total_discount += pr_discount;
<?php } ?>

                gtotal = ((total + total_tax1 + total_tax2) - total_discount) + shipping;
                $('#total').val(total.toFixed(2));
<?php if (DISCOUNT_OPTION == 1 || DISCOUNT_OPTION == 2) { ?>$('#tds').val(total_discount.toFixed(2));<?php } ?>
<?php if (TAX1) { ?>$('#ttax1').val(total_tax1.toFixed(2));<?php } ?>
<?php if (TAX2) { ?>$('#ttax2').val(total_tax2.toFixed(2));<?php } ?>
                                $('#gtotal').val(gtotal.toFixed(2));

                                $(this).val('');
                                e.preventDefault();
                                return false;
                            }

                        });

                        $('#code').bind('keypress', function(e) {
                            if (e.keyCode == 13) {
                                e.preventDefault();
                                return false;
                            }
                        });

                        $("#dyTable").on("click", '.del', function() {

                            var delID = $(this).attr('id');
                            var rw_no = delID;
                            var p1 = $('#price-' + rw_no);
                            var q1 = $('#quantity-' + rw_no);

<?php if (TAX1) { ?>
                                var t1_val = $('#tax_rate-' + rw_no).val();
                                var taxes = '';
                                $.each(tax_rates, function() {
                                    if (this.id == t1_val) {
                                        new_tax_rate = parseFloat(this.rate);
                                        new_tax_type = parseFloat(this.type);
                                    }
                                });

<?php } else { ?>
                                new_pr_tax_rate = 0;
<?php } ?>

<?php if (DISCOUNT_OPTION == 2) { ?>
                                var d1_val = $('#discount-' + rw_no).val();
                                $.each(discounts, function() {
                                    if (this.id == d1_val) {
                                        new_discount_rate = parseFloat(this.discount);
                                        new_discount_type = parseFloat(this.type);
                                    }
                                });

<?php } ?>

                            var price = parseFloat(p1.val());
                            var quantity = parseInt(q1.val());
                            var row_price = price * quantity;
                            total = total - row_price;

<?php if (TAX1) { ?>
                                if (new_tax_type == 2) {
                                    new_pr_tax_rate = new_tax_rate;
                                }
                                if (new_tax_type == 1) {
                                    new_pr_tax_rate = (row_price * new_tax_rate) / 100;
                                }
                                total_tax1 = total_tax1 - new_pr_tax_rate;
<?php } ?>

<?php if (DISCOUNT_OPTION == 2) { ?>

    <?php if (DISCOUNT_METHOD == 1) { ?>
                                    if (new_discount_type == 2) {
                                        new_pr_discount = new_discount_rate;
                                    }
                                    if (new_discount_type == 1) {
                                        new_pr_discount = (row_price * new_discount_rate) / 100;
                                    }
    <?php } elseif (DISCOUNT_METHOD == 2) { ?>
                                    if (new_discount_type == 2) {
                                        new_pr_discount = new_discount_rate;
                                    }
                                    if (new_discount_type == 1) {
                                        new_pr_discount = ((row_price + new_pr_tax_rate) * new_discount_rate) / 100;
                                    }
    <?php } ?>
                                total_discount -= new_pr_discount;
<?php } ?>

<?php if (TAX2) { ?>
                                if (tax_type2 == 2) {
                                    total_tax2 = tax_rate2;
                                }
                                if (tax_type2 == 1) {
                                    total_tax2 = (total * tax_rate2) / 100;
                                }
<?php } ?>

<?php if (DISCOUNT_METHOD == 1 && DISCOUNT_OPTION == 1) { ?>
                                if (discount_type == 2) {
                                    new_discount_value = discount;
                                }
                                if (discount_type == 1) {
                                    new_discount_value = (total * discount) / 100;
                                }
                                total_discount = new_discount_value;
<?php } elseif (DISCOUNT_METHOD == 2 && DISCOUNT_OPTION == 1) { ?>
                                if (discount_type == 2) {
                                    new_discount_value = discount;
                                }
                                if (discount_type == 1) {
                                    new_discount_value = ((total + total_tax1 + total_tax2) * discount) / 100;
                                }
                                total_discount = new_discount_value;
<?php } ?>

                            gtotal = ((total + total_tax1 + total_tax2) - total_discount) + shipping;
                            $('#total').val(total.toFixed(2));
<?php if (DISCOUNT_OPTION == 1 || DISCOUNT_OPTION == 2) { ?>$('#tds').val(total_discount.toFixed(2));<?php } ?>
<?php if (TAX1) { ?>$('#ttax1').val(total_tax1.toFixed(2));<?php } ?>
<?php if (TAX2) { ?>$('#ttax2').val(total_tax2.toFixed(2));<?php } ?>
                            $('#gtotal').val(gtotal.toFixed(2));

                            row_id = $("#row_" + delID);
                            row_id.remove();
                            an--;
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
                                    bootbox.alert("You have reached the max item limit.");
                                    return false;
                                }
                                if (count >= 200) {
                                    bootbox.alert("You have reached the max item limit.");
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
                                        pr_tax = data.tax_rate;

                                    },
                                    error: function() {
                                        bootbox.alert('<?php echo $this->lang->line('code_error'); ?>');
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
                                newTr.html('<td><input name="product' + count + '" type="hidden" value="' + item_code + '"><input class="span5 tran" style="text-align:left;" name="item' + count + '" type="text" value="' + item_name + ' (' + item_code + ')"></td><?php
if (DISCOUNT_OPTION == 2) {
    echo '<td><select class="span2 select tran" data-placeholder="Select..." name="discount\' + count + \'" id="discount-\' + count + \'">';
    foreach ($discounts as $discount) {
        echo "<option value=" . $discount->id;
        if ($discount->id == DEFAULT_DISCOUNT) {
            echo ' selected="selected"';
        }
        echo ">" . $discount->name . "</option>";
    }
    echo '</select></td>';
} if (TAX1) {
    ?><td><select class="input-block-level" data-placeholder="Select..." name="tax_rate' + count + '" id="tax_rate-' + count + '">' + taxes + '</select></td><?php }
?><td><input class="input-block-level text-center" name="quantity' + count + '" type="text" value="1" id="quantity-' + count + '" onClick="this.select();"></td><td><input class="span2 tran" style="text-align:right;" name="unit_price' + count + '" id="price-' + count + '" type="text" value="' + item_price + '"></td><td><i class="icon-trash tip del" id="' + count + '" title="Remove this Item" style="cursor:pointer;" data-placement="right"></i></td>');
                                newTr.prependTo("#dyTable");

                                count++;
                                an++;

<?php if (TAX1) { ?>
                                    if (pr_tax) {
                                        if (pr_tax.type == 2) {
                                            pr_tax_rate = parseFloat(pr_tax.rate);
                                        }
                                        if (pr_tax.type == 1) {
                                            pr_tax_rate = (item_price * parseFloat(pr_tax.rate)) / 100;
                                        }
                                        total_tax1 += pr_tax_rate;
                                    } else {
                                        if (tax_type == 2) {
                                            pr_tax_rate = tax_rate;
                                        }
                                        if (tax_type == 1) {
                                            pr_tax_rate = (item_price * tax_rate) / 100;
                                        }
                                        total_tax1 += pr_tax_rate;
                                    }
<?php } else { ?>
                                    pr_tax_rate = 0;
<?php } ?>

                                total += parseFloat(item_price);

<?php if (TAX2) { ?>
                                    if (tax_type2 == 2) {
                                        total_tax2 = tax_rate2;
                                    }
                                    if (tax_type2 == 1) {
                                        total_tax2 = (total * tax_rate2) / 100;
                                    }
<?php } ?>
<?php if (DISCOUNT_METHOD == 1 && DISCOUNT_OPTION == 1) { ?>
                                    if (discount_type == 2) {
                                        total_discount = discount;
                                    }
                                    if (discount_type == 1) {
                                        total_discount = (total * discount) / 100;
                                    }
<?php } elseif (DISCOUNT_METHOD == 2 && DISCOUNT_OPTION == 1) { ?>
                                    if (discount_type == 2) {
                                        total_discount = discount;
                                    }
                                    if (discount_type == 1) {
                                        total_discount = ((total + total_tax1 + total_tax2) * discount) / 100;
                                    }
<?php } ?>

<?php if (DISCOUNT_OPTION == 2) { ?>

    <?php if (DISCOUNT_METHOD == 1) { ?>
                                        if (discount_type2 == 2) {
                                            pr_discount = discount2;
                                        }
                                        if (discount_type2 == 1) {
                                            pr_discount = (item_price * discount2) / 100;
                                        }
    <?php } elseif (DISCOUNT_METHOD == 2) { ?>
                                        if (discount_type2 == 2) {
                                            pr_discount = discount2;
                                        }
                                        if (discount_type2 == 1) {
                                            pr_discount = ((parseFloat(item_price) + pr_tax_rate) * discount2) / 100;
                                        }
    <?php } ?>
                                    total_discount += pr_discount;
<?php } ?>

                                gtotal = ((total + total_tax1 + total_tax2) - total_discount) + shipping;
                                $('#total').val(total.toFixed(2));
<?php if (DISCOUNT_OPTION == 1 || DISCOUNT_OPTION == 2) { ?>$('#tds').val(total_discount.toFixed(2));<?php } ?>
<?php if (TAX1) { ?>$('#ttax1').val(total_tax1.toFixed(2));<?php } ?>
<?php if (TAX2) { ?>$('#ttax2').val(total_tax2.toFixed(2));<?php } ?>
                                $('#gtotal').val(gtotal.toFixed(2));


                            },
                            close: function() {
                                $('#name').val('');
                            }
                        });

                        $("#codes").autocomplete({
                            source: function(request, response) {
                                $.ajax({url: "<?php echo site_url('module=quotes&view=codeSuggestions'); ?>",
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
                                    bootbox.alert("You have reached the max item limit.");
                                    return false;
                                }
                                if (count >= 200) {
                                    bootbox.alert("You have reached the max item limit.");
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
                                        item_name = data.name;
                                        pr_tax = data.tax_rate;

                                    },
                                    error: function() {
                                        bootbox.alert('<?php echo $this->lang->line('code_error'); ?>');
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
                                newTr.html('<td><input name="product' + count + '" type="hidden" value="' + item_code + '"><input class="span5 tran" style="text-align:left;" name="item' + count + '" type="text" value="' + item_name + ' (' + item_code + ')"></td><?php
if (DISCOUNT_OPTION == 2) {
    echo '<td><select class="span2 select tran" data-placeholder="Select..." name="discount\' + count + \'" id="discount-\' + count + \'">';
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
    ?><td><select class="input-block-level" data-placeholder="Select..." name="tax_rate' + count + '" id="tax_rate-' + count + '">' + taxes + '</select></td><?php }
?><td><input class="input-block-level text-center" name="quantity' + count + '" type="text" value="1" id="quantity-' + count + '" onClick="this.select();"></td><td><input class="span2 tran" style="text-align:right;" name="unit_price' + count + '" type="text" id="price-' + count + '" value="' + item_price + '"></td><td><i class="icon-trash tip del" id="' + count + '" title="Remove this Item" style="cursor:pointer;" data-placement="right"></i></td>');
                                newTr.prependTo("#dyTable");

                                count++;
                                an++;
<?php if (TAX1) { ?>

                                    if (pr_tax) {
                                        if (pr_tax.type == 2) {
                                            pr_tax_rate = parseFloat(pr_tax.rate);
                                        }
                                        if (pr_tax.type == 1) {
                                            pr_tax_rate = (item_price * parseFloat(pr_tax.rate)) / 100;
                                        }
                                        total_tax1 += pr_tax_rate;
                                    } else {
                                        if (tax_type == 2) {
                                            pr_tax_rate = tax_rate;
                                        }
                                        if (tax_type == 1) {
                                            pr_tax_rate = (item_price * tax_rate) / 100;
                                        }
                                        total_tax1 += pr_tax_rate;
                                    }


<?php } else { ?>
                                    pr_tax_rate = 0;
<?php } ?>

                                total += parseFloat(item_price);

<?php if (TAX2) { ?>
                                    if (tax_type2 == 2) {
                                        total_tax2 = tax_rate2;
                                    }
                                    if (tax_type2 == 1) {
                                        total_tax2 = (total * tax_rate2) / 100;
                                    }
<?php } ?>
<?php if (DISCOUNT_METHOD == 1 && DISCOUNT_OPTION == 1) { ?>
                                    if (discount_type == 2) {
                                        total_discount = discount;
                                    }
                                    if (discount_type == 1) {
                                        total_discount = (total * discount) / 100;
                                    }
<?php } elseif (DISCOUNT_METHOD == 2 && DISCOUNT_OPTION == 1) { ?>
                                    if (discount_type == 2) {
                                        total_discount = discount;
                                    }
                                    if (discount_type == 1) {
                                        total_discount = ((total + total_tax1 + total_tax2) * discount) / 100;
                                    }
<?php } ?>

<?php if (DISCOUNT_OPTION == 2) { ?>

    <?php if (DISCOUNT_METHOD == 1) { ?>
                                        if (discount_type2 == 2) {
                                            pr_discount = discount2;
                                        }
                                        if (discount_type2 == 1) {
                                            pr_discount = (item_price * discount2) / 100;
                                        }
    <?php } elseif (DISCOUNT_METHOD == 2) { ?>
                                        if (discount_type2 == 2) {
                                            pr_discount = discount2;
                                        }
                                        if (discount_type2 == 1) {
                                            pr_discount = ((parseFloat(item_price) + pr_tax_rate) * discount2) / 100;
                                        }
    <?php } ?>
                                    total_discount += pr_discount;
<?php } ?>

                                gtotal = ((total + total_tax1 + total_tax2) - total_discount) + shipping;
                                $('#total').val(total.toFixed(2));
<?php if (DISCOUNT_OPTION == 1 || DISCOUNT_OPTION == 2) { ?>$('#tds').val(total_discount.toFixed(2));<?php } ?>
<?php if (TAX1) { ?>$('#ttax1').val(total_tax1.toFixed(2));<?php } ?>
<?php if (TAX2) { ?>$('#ttax2').val(total_tax2.toFixed(2));<?php } ?>
                                $('#gtotal').val(gtotal.toFixed(2));

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
                                bootbox.alert("<?php echo $this->lang->line('no_invoice_item'); ?>");
                                return false;
                            }
                        });

<?php if (TAX2) { ?>
                            var old_val = $("#tax2_s").val();
                            $("#tax2_s").change(function() {
                                var new_val = $("#tax2_s").val();
                                $.each(tax_rates, function() {
                                    if (this.id == new_val) {
                                        new_tax_rate = parseFloat(this.rate);
                                        new_tax_type = parseFloat(this.type);
                                    }
                                    if (this.id == old_val) {
                                        old_tax_rate = parseFloat(this.rate);
                                        old_tax_type = parseFloat(this.type);
                                    }
                                });

                                if (new_tax_type == 2) {
                                    new_tax_rate = new_tax_rate;
                                }
                                if (new_tax_type == 1) {
                                    new_tax_rate = (total * new_tax_rate) / 100;
                                }
                                if (old_tax_type == 2) {
                                    old_tax_rate = old_tax_rate;
                                }
                                if (old_tax_type == 1) {
                                    old_tax_rate = (total * old_tax_rate) / 100;
                                }
                                total_tax2 -= old_tax_rate;
                                total_tax2 += new_tax_rate;

    <?php if (DISCOUNT_OPTION == 1 && DISCOUNT_METHOD == 2) { ?> total_discount = ((total + total_tax1 + total_tax2) * discount) / 100;
                                    $('#tds').val(total_discount.toFixed(2));<?php } ?>

                                gtotal = ((total + total_tax1 + total_tax2) - total_discount) + shipping;
                                $('#ttax2').val(total_tax2.toFixed(2));
                                $('#gtotal').val(gtotal.toFixed(2));
                                old_val = new_val;
                            });
<?php } ?>

<?php if (DISCOUNT_OPTION == 1) { ?>
                            var ods_val = $("#discount_s").val();
                            $("#discount_s").change(function() {
                                var nds_val = $("#discount_s").val();
                                $.each(discounts, function() {
                                    if (this.id == nds_val) {
                                        new_discount_rate = parseFloat(this.discount);
                                        new_discount_type = parseFloat(this.type);
                                    }
                                    if (this.id == ods_val) {
                                        old_discount_rate = parseFloat(this.discount);
                                        old_discount_type = parseFloat(this.type);
                                    }
                                });

    <?php if (DISCOUNT_METHOD == 1) { ?>
                                    if (new_discount_type == 2) {
                                        new_discount = new_discount_rate;
                                    }
                                    if (new_discount_type == 1) {
                                        new_discount = (total * new_discount_rate) / 100;
                                    }
                                    if (old_discount_type == 2) {
                                        old_discount = old_discount_rate;
                                    }
                                    if (old_discount_type == 1) {
                                        old_discount = (total * old_discount_rate) / 100;
                                    }
    <?php } elseif (DISCOUNT_METHOD == 2) { ?>
                                    if (new_discount_type == 2) {
                                        new_discount = new_discount_rate;
                                    }
                                    if (new_discount_type == 1) {
                                        new_discount = ((total + total_tax1 + total_tax2) * new_discount_rate) / 100;
                                    }
                                    if (old_discount_type == 2) {
                                        old_discount = old_discount_rate;
                                    }
                                    if (old_discount_type == 1) {
                                        old_discount = ((total + total_tax1 + total_tax2) * old_discount_rate) / 100;
                                    }
    <?php } ?>

                                total_discount -= old_discount;
                                total_discount += new_discount;

                                gtotal = ((total + total_tax1 + total_tax2) - total_discount) + shipping;
                                $('#tds').val(total_discount.toFixed(2));
                                $('#gtotal').val(gtotal.toFixed(2));
                                ods_val = nds_val;
                            });
<?php } ?>

<?php if (TAX1) { ?>

                            $("#dyTable").on("focus", 'select[id^="tax_rate-"]', function() {
                                otval = $(this).val();
                            });

                            $("#dyTable").on("change", 'select[id^="tax_rate-"]', function() {
                                var selID = $(this).attr('id');
                                var sl_id = selID.split("-");
                                var rw_no = sl_id[1];
                                var ntval = $(this).val();
                                var p1 = $('#price-' + rw_no);
                                var q1 = $('#quantity-' + rw_no);

                                var price = parseFloat(p1.val());
                                var quantity = parseInt(q1.val());
                                var row_price = price * quantity;
                                $.each(tax_rates, function() {
                                    if (this.id == ntval) {
                                        new_tax_rate = parseFloat(this.rate);
                                        new_tax_type = parseFloat(this.type);
                                    }
                                    if (this.id == otval) {
                                        old_tax_rate = parseFloat(this.rate);
                                        old_tax_type = parseFloat(this.type);
                                    }
                                });

                                if (new_tax_type == 2) {
                                    new_pr_tax_rate = new_tax_rate;
                                }
                                if (new_tax_type == 1) {
                                    new_pr_tax_rate = (row_price * new_tax_rate) / 100;
                                }
                                if (old_tax_type == 2) {
                                    old_pr_tax_rate = old_tax_rate;
                                }
                                if (old_tax_type == 1) {
                                    old_pr_tax_rate = (row_price * old_tax_rate) / 100;
                                }
                                total_tax1 -= old_pr_tax_rate;
                                total_tax1 += new_pr_tax_rate;


    <?php if (DISCOUNT_OPTION == 1 && DISCOUNT_METHOD == 2) { ?>
                                    var d1 = $('#discount_s').val();
                                    $.each(discounts, function() {
                                        if (this.id == d1) {
                                            new_discount_rate = parseFloat(this.discount);
                                            new_discount_type = parseFloat(this.type);
                                        }
                                    });

                                    total_discount = ((total + total_tax1 + total_tax2) * new_discount_rate) / 100;
                                    $('#tds').val(total_discount.toFixed(2));<?php } ?>
    <?php if (DISCOUNT_OPTION == 2 && DISCOUNT_METHOD == 2) { ?>
                                    var d1 = $('#discount-' + rw_no).val();
                                    $.each(discounts, function() {
                                        if (this.id == d1) {
                                            new_discount_rate = parseFloat(this.discount);
                                            new_discount_type = parseFloat(this.type);
                                        }
                                    });

                                    o_discount = ((row_price + old_pr_tax_rate) * new_discount_rate) / 100;
                                    n_discount = ((row_price + new_pr_tax_rate) * new_discount_rate) / 100;

                                    total_discount -= o_discount;
                                    total_discount += n_discount;
                                    $('#tds').val(total_discount.toFixed(2));

    <?php } ?>

                                gtotal = ((total + total_tax1 + total_tax2) - total_discount) + shipping;
                                $('#ttax1').val(Math.abs(total_tax1).toFixed(2));
                                $('#gtotal').val(gtotal.toFixed(2));
                                otval = ntval;

                            });
<?php } ?>

                        $("#dyTable").on("focus", 'input[id^="quantity-"]', function() {
                            oqty = $(this).val();
                        });
                        $("#dyTable").on("blur", 'input[id^="quantity-"]', function() {
                            var rID = $(this).attr('id');
                            var r_id = rID.split("-");
                            var rw_no = r_id[1];
                            var nqty = $(this).val();
                            var rprice = $('#price-' + rw_no).val();

                            var oldrowtotal = oqty * rprice;
                            var newrowtotal = nqty * rprice;

                            total -= oldrowtotal;
                            total += newrowtotal;

<?php if (TAX1) { ?>
                                var rtax = $('#tax_rate-' + rw_no).val();
                                $.each(tax_rates, function() {
                                    if (this.id == rtax) {
                                        new_tax_rate = parseFloat(this.rate);
                                        new_tax_type = parseFloat(this.type);
                                    }
                                });

                                if (new_tax_type == 2) {
                                    opr_tax_rate = new_tax_rate;
                                }
                                if (new_tax_type == 1) {
                                    opr_tax_rate = (oldrowtotal * new_tax_rate) / 100;
                                }
                                if (new_tax_type == 2) {
                                    npr_tax_rate = new_tax_rate;
                                }
                                if (new_tax_type == 1) {
                                    npr_tax_rate = (newrowtotal * new_tax_rate) / 100;
                                }

                                total_tax1 -= opr_tax_rate;
                                total_tax1 += npr_tax_rate;
<?php } ?>


<?php if (TAX2) { ?>

                                var inds = $("#tax2_s").val();
                                $.each(tax_rates, function() {
                                    if (this.id == inds) {
                                        new_tax_rate = parseFloat(this.rate);
                                        new_tax_type = parseFloat(this.type);
                                    }
                                });

                                if (new_tax_type == 2) {
                                    new_tax_rate = new_tax_rate;
                                }
                                if (new_tax_type == 1) {
                                    new_tax_rate = (total * new_tax_rate) / 100;
                                }
                                total_tax2 = new_tax_rate;

<?php } ?>

<?php if (DISCOUNT_OPTION == 2) { ?>
                                var rtax = $('#discount-' + rw_no).val();
                                $.each(discounts, function() {
                                    if (this.id == rtax) {
                                        new_discount_rate = parseFloat(this.discount);
                                        new_discount_type = parseFloat(this.type);
                                    }
                                });

                                if (new_discount_type == 2) {
                                    opr_discount_rate = new_discount_rate * oqty;
                                }
    <?php if (DISCOUNT_METHOD == 1) { ?>
                                    if (new_discount_type == 1) {
                                        opr_discount_rate = (oldrowtotal * new_discount_rate) / 100;
                                    }
    <?php } ?>
    <?php if (DISCOUNT_METHOD == 2) { ?>
                                    if (new_discount_type == 1) {
                                        opr_discount_rate = ((oldrowtotal + opr_tax_rate) * new_discount_rate) / 100;
                                    }
    <?php } ?>

                                if (new_discount_type == 2) {
                                    npr_discount_rate = new_discount_rate * nqty;
                                }
    <?php if (DISCOUNT_METHOD == 1) { ?>
                                    if (new_discount_type == 1) {
                                        npr_discount_rate = (newrowtotal * new_discount_rate) / 100;
                                    }
    <?php } ?>
    <?php if (DISCOUNT_METHOD == 2) { ?>
                                    if (new_discount_type == 1) {
                                        npr_discount_rate = ((newrowtotal + npr_tax_rate) * new_discount_rate) / 100;
                                    }
    <?php } ?>

                                total_discount -= opr_discount_rate;
                                total_discount += npr_discount_rate;

<?php } ?>

<?php if (DISCOUNT_OPTION == 1) { ?>

                                var ids = $("#discount_s").val();
                                $.each(discounts, function() {
                                    if (this.id == ids) {
                                        new_discount_rate = parseFloat(this.discount);
                                        new_discount_type = parseFloat(this.type);
                                    }
                                });

                                if (new_discount_type == 2) {
                                    new_discount_rate = new_discount_rate;
                                }
    <?php if (DISCOUNT_METHOD == 1) { ?>
                                    if (new_discount_type == 1) {
                                        new_discount_rate = (total * new_discount_rate) / 100;
                                    }
    <?php } ?>
    <?php if (DISCOUNT_METHOD == 2) { ?>
                                    if (new_discount_type == 1) {
                                        new_discount_rate = ((total + total_tax1 + total_tax2) * new_discount_rate) / 100;
                                    }
    <?php } ?>
                                total_discount = new_discount_rate;

<?php } ?>


                            gtotal = ((total + total_tax1 + total_tax2) - total_discount) + shipping;
                            $('#total').val(total.toFixed(2));
                            $('#tds').val(total_discount.toFixed(2));
                            $('#ttax1').val(total_tax1.toFixed(2));
                            $('#ttax2').val(total_tax2.toFixed(2));
                            $('#gtotal').val(gtotal.toFixed(2));

                        });

<?php if (DISCOUNT_OPTION == 2) { ?>

                            $("#dyTable").on("focus", 'select[id^="discount-"]', function() {
                                odsval = $(this).val();
                            });

                            $("#dyTable").on("change", 'select[id^="discount-"]', function() {
                                var selID = $(this).attr('id');
                                var sl_id = selID.split("-");
                                var rw_no = sl_id[1];
                                var ntval = $(this).val();
                                var p1 = $('#price-' + rw_no);
                                var q1 = $('#quantity-' + rw_no);

                                var price = parseFloat(p1.val());
                                var quantity = parseInt(q1.val());
                                var row_price = price * quantity;

                                var ndsval = $(this).val();
                                $.each(discounts, function() {
                                    if (this.id == ndsval) {
                                        new_discount_rate = parseFloat(this.discount);
                                        new_discount_type = parseFloat(this.type);
                                    }
                                    if (this.id == odsval) {
                                        old_discount_rate = parseFloat(this.discount);
                                        old_discount_type = parseFloat(this.type);
                                    }
                                });

    <?php if (DISCOUNT_METHOD == 1) { ?>
                                    if (old_discount_type == 2) {
                                        opr_discount = old_discount_rate * quantity;
                                    }
                                    if (old_discount_type == 1) {
                                        opr_discount = (row_price * old_discount_rate) / 100;
                                    }
                                    if (new_discount_type == 2) {
                                        npr_discount = new_discount_rate * quantity;
                                    }
                                    if (new_discount_type == 1) {
                                        npr_discount = (row_price * new_discount_rate) / 100;
                                    }

    <?php } ?>

    <?php if (DISCOUNT_METHOD == 2) { ?>
                                    var nt = $('#tax_rate-' + rw_no).val();
                                    $.each(tax_rates, function() {
                                        if (this.id == nt) {
                                            new_tax_rate = parseFloat(this.rate);
                                            new_tax_type = parseFloat(this.type);
                                        }
                                    });

                                    if (new_tax_type == 2) {
                                        pr_tax = new_tax_rate;
                                    }
                                    if (new_tax_type == 1) {
                                        pr_tax = (row_price * new_tax_rate) / 100;
                                    }

                                    if (old_discount_type == 2) {
                                        opr_discount = old_discount_rate * quantity;
                                    }
                                    if (old_discount_type == 1) {
                                        opr_discount = ((row_price + pr_tax) * old_discount_rate) / 100;
                                    }
                                    if (new_discount_type == 2) {
                                        npr_discount = new_discount_rate * quantity;
                                    }
                                    if (new_discount_type == 1) {
                                        npr_discount = ((row_price + pr_tax) * new_discount_rate) / 100;
                                    }

    <?php } ?>

                                total_discount -= opr_discount;
                                total_discount += npr_discount;

                                gtotal = ((total + total_tax1 + total_tax2) - total_discount) + shipping;
                                $('#tds').val(total_discount.toFixed(2));
                                $('#gtotal').val(gtotal.toFixed(2));
                                odsval = ndsval;

                            });
<?php } ?>
                        $('#shipping').change(function() {
                            shipping = parseFloat($(this).val());
                            gtotal = ((total + total_tax1 + total_tax2) - total_discount) + shipping;
                            $(this).val(shipping.toFixed(2));
                            $('#gtotal').val(gtotal.toFixed(2));
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
                        $('#code, #name').tooltip({placement: "top", trigger: "focus"});
                        $("#add_options").draggable({refreshPositions: true});

                    });
</script>

<?php if ($message) {
    echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>";
} ?>

<h3 class="title"><?php echo $page_title; ?></h3>
<p><?php echo $this->lang->line("enter_info"); ?></p>

<?php $attrib = array('class' => 'form-horizontal', 'id' => 'addSale_form');
echo form_open("module=quotes&view=add", $attrib); ?>
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
    <label class="control-label" id="biller_l"><?php echo $this->lang->line("biller"); ?></label>
    <div class="controls">  <?php
$bl[""] = "";
foreach ($billers as $biller) {
    $bl[$biller->id] = $biller->name;
}
echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : ""), 'id="biller_s" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("biller") . '" required="required" data-error="' . $this->lang->line("biller") . ' ' . $this->lang->line("is_required") . '"');
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
echo form_dropdown('customer', $cu, (isset($_POST['customer']) ? $_POST['customer'] : ""), 'id="customer_s" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("customer") . '" required="required" data-error="' . $this->lang->line("customer") . ' ' . $this->lang->line("is_required") . '"');
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
    echo form_dropdown('tax2', $tr, (isset($_POST['tax2']) ? $_POST['tax2'] : DEFAULT_TAX2), 'id="tax2_s" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("tax2") . '" required="required" data-error="' . $this->lang->line("tax2") . ' ' . $this->lang->line("is_required") . '"');
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
    echo form_dropdown('inv_discount', $ds, (isset($_POST['inv_discount']) ? $_POST['inv_discount'] : DEFAULT_DISCOUNT), 'id="discount_s" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("discount") . '" required="required" data-error="' . $this->lang->line("discount") . ' ' . $this->lang->line("is_required") . '"');
    ?> </div>
    </div>
<?php } ?>

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
            <tbody></tbody>
        </table>
    </div>
</div>  
<div class="row-fluid"> 
    <div class="span7">

        <div class="control-group">
            <label class="control-label"><?php echo $this->lang->line("note"); ?></label>
            <div class="controls fancy-tab-container">

                <ul class="nav nav-tabs two-tabs fancy" id="noteTab">
                    <li class="active"><a href="#internal"><?php echo $this->lang->line('internal_note'); ?></a></li>
                    <li><a href="#onquote"><?php echo $this->lang->line('on_invoice_note'); ?></a></li>
                </ul>

                <div class="tab-content">

                    <div class="tab-pane active" id="internal">
<?php echo form_textarea('internal_note', (isset($_POST['internal_note']) ? $_POST['internal_note'] : ""), 'class="input-block-level" id="internal_note" style="margin-top: 10px; height: 100px;"'); ?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="tab-pane" id="onquote">
        <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'class="input-block-level" id="note" style="margin-top: 10px; height: 100px;"'); ?> 
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

    </div>
    <div class="span5">

        <div class="control-group inverse" style="margin-bottom:5px; cursor: default;">
            <label class="control-label" style="cursor: default;"><?php echo $this->lang->line("total"); ?></label>
            <div class="controls"> <?php echo form_input('dummy_sales', '', 'class="input-block-level text-right" id="total" disabled'); ?>
            </div>
        </div> 
<?php if (DISCOUNT_OPTION == 1 || DISCOUNT_OPTION == 2) { ?>
            <div class="control-group inverse" style="margin-bottom:5px;">
                <label class="control-label" style="cursor: default;"><?php echo $this->lang->line("discount"); ?></label>
                <div class="controls"> <?php echo form_input('dummy_ds', '', 'class="input-block-level text-right" id="tds" disabled'); ?>
                </div>
            </div> 
<?php } if (TAX1) { ?>
            <div class="control-group inverse" style="margin-bottom:5px;">
                <label class="control-label" style="cursor: default;"><?php echo $this->lang->line("product_tax"); ?></label>
                <div class="controls"> <?php echo form_input('dummy_tax1', '', 'class="input-block-level text-right" id="ttax1" disabled'); ?>
                </div>
            </div> 
<?php } if (TAX2) { ?>
            <div class="control-group inverse" style="margin-bottom:5px;">
                <label class="control-label" style="cursor: default;"><?php echo $this->lang->line("invoice_tax"); ?></label>
                <div class="controls"> <?php echo form_input('dummy_tax2', '', 'class="input-block-level text-right" id="ttax2" disabled'); ?>
                </div>
            </div> 
<?php } ?>
        <div class="control-group" style="margin-bottom:5px;">
            <label class="control-label" for="shipping"><?php echo $this->lang->line("shipping"); ?></label>
            <div class="controls"> <?php echo form_input('shipping', '', 'class="input-block-level text-right" id="shipping"'); ?>
            </div>
        </div> 
        <div class="control-group inverse" style="margin-bottom:5px;">
            <label class="control-label" style="cursor: default;"><?php echo $this->lang->line("total_payable"); ?></label>
            <div class="controls"> <?php echo form_input('dummy_total', '', 'class="input-block-level text-right" style="font-weight: bold;" id="gtotal" disabled'); ?>
            </div>
        </div> 


    </div>
</div>

<div class="control-group"><div class="controls"><?php echo form_submit('submit', $this->lang->line("submit"), 'class="btn btn-primary" style="padding: 6px 15px;"'); ?></div></div>
<?php echo form_close(); ?> 
