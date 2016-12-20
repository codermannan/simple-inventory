<script src="<?php echo $this->config->base_url(); ?>assets/js/validation.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('form').form();
    });
</script>
<style type="text/css">
    .span11, .chzn-container { width: 91.453% !important; }
</style>    
<?php if ($message) {
    echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>";
} ?>
<?php if ($success_message) {
    echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>";
} ?>

<h3 class="title"><?php echo $page_title; ?></h3>
<p><?php echo $this->lang->line('update_info'); ?></p>
<?php $attrib = array('class' => 'form-horizontal');
echo form_open("module=settings&view=system_setting", $attrib); ?>
<div class="row-fluid">
<div class="span5">
<div class="control-group">
    <label class="control-label" for="site_name"><?php echo $this->lang->line("site_name"); ?></label>
    <div class="controls"> <?php echo form_input('site_name', $settings->site_name, 'class="span11 tip" id="site_name" title="' . $this->lang->line("site_name_tip") . '" required="required" data-error="' . $this->lang->line("site_name") . ' ' . $this->lang->line("is_required") . '"'); ?> </div>
</div>
<div class="control-group">
    <label class="control-label" for="language"><?php echo $this->lang->line("language"); ?></label>
    <div class="controls">
        <?php
        /*
          'chinese' => '普通话',
         */
        $lang = array(
            'arabic' => 'العربية',
            'english' => 'English',
            'french' => 'Le Français',
            'indonesian ' => 'Indonesian',
            'bportuguese' => 'Português Do Brasil',
            'eportuguese' => 'Português Europeu',
            'romanian' => 'Română',
            'spanish' => 'Español'
        );
        echo form_dropdown('language', $lang, $settings->language, 'class="span11 tip chzn-select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("language") . '" title="' . $this->lang->line("language_tip") . '" required="required" data-error="' . $this->lang->line("language") . ' ' . $this->lang->line("is_required") . '"');
        ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="warehouse"><?php echo $this->lang->line("warehouse"); ?></label>
    <div class="controls">
<?php
foreach ($warehouses as $warehouse) {
    $wh[$warehouse->id] = $warehouse->name;
}
echo form_dropdown('warehouse', $wh, $settings->default_warehouse, 'class="span11 tip chzn-select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("warehouse") . '" title="' . $this->lang->line("default_warehouse_tip") . '" required="required" data-error="' . $this->lang->line("warehouse") . ' ' . $this->lang->line("is_required") . '"');
?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="currency_code"><?php echo $this->lang->line("currency_code"); ?></label>
    <div class="controls"> <?php echo form_input('currency_prefix', $settings->currency_prefix, 'class="span11 tip" id="currency_code" title="' . $this->lang->line("currency_code_tip") . '" required="required" data-error="' . $this->lang->line("currency_code") . ' ' . $this->lang->line("is_required") . '"'); ?> </div>
</div>
<div class="control-group">
    <label class="control-label" for="tax_rate"><?php echo $this->lang->line("product_tax"); ?></label>
    <div class="controls">
<?php
$tr['0'] = $this->lang->line("disable");
foreach ($tax_rates as $rate) {
    $tr[$rate->id] = $rate->name;
}
echo form_dropdown('tax_rate', $tr, $settings->default_tax_rate, 'class="span11 tip chzn-select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("tax_rate") . '" title="' . $this->lang->line("default_tax_rate_tip") . '" required="required" data-error="' . $this->lang->line("tax_rate") . ' ' . $this->lang->line("is_required") . '"');
?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="tax_rate2"><?php echo $this->lang->line("invoice_tax"); ?></label>
    <div class="controls">
        <?php echo form_dropdown('tax_rate2', $tr, $settings->default_tax_rate2, 'class="span11 tip chzn-select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("tax_rate2") . '" title="' . $this->lang->line("default_tax_rate2_tip") . '" required="required" data-error="' . $this->lang->line("tax_rate2") . ' ' . $this->lang->line("is_required") . '"'); ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="date_format"><?php echo $this->lang->line("date_format"); ?></label>
    <div class="controls">
<?php
foreach ($date_formats as $date_format) {
    $dt[$date_format->id] = $date_format->js;
}
echo form_dropdown('date_format', $dt, $settings->dateformat, 'class="span11 tip chzn-select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("date_format") . '" required="required" data-error="' . $this->lang->line("date_format") . ' ' . $this->lang->line("is_required") . '"');
?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="barcode_symbology"><?php echo $this->lang->line("barcode_symbology"); ?></label>
    <div class="controls">
        <?php
        $bs = array(
            'code25' => 'Code25',
            'code39' => 'Code39',
            'code128' => 'Code128',
            'ean8' => 'EAN8',
            'ean13' => 'EAN13',
            'upca ' => 'UPC-A',
            'upce' => 'UPC-E');
        echo form_dropdown('barcode_symbology', $bs, $settings->barcode_symbology, 'class="span11 tip chzn-select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("barcode_symbology") . '" required="required" data-error="' . $this->lang->line("barcode_symbology") . ' ' . $this->lang->line("is_required") . '"');
        ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="theme"><?php echo $this->lang->line("theme"); ?></label>
    <div class="controls">
<?php
$th = array(
    'blue' => 'Theme 1',
    'cosmo' => 'Theme 2',
    'red' => 'Theme 3',
    'rtl' => 'RTL Languages');
echo form_dropdown('theme', $th, $settings->theme, 'class="span11 tip chzn-select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("theme") . '" required="required" data-error="' . $this->lang->line("theme") . ' ' . $this->lang->line("is_required") . '"');
?>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="product_serial"><?php echo $this->lang->line("product_serial"); ?></label>
    <div class="controls">
        <?php
        $ps = array('0' => $this->lang->line("disable"), '1' => $this->lang->line("enable"));
        echo form_dropdown('product_serial', $ps, $settings->product_serial, 'class="span11 tip chzn-select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("product_serial") . '" required="required" data-error="' . $this->lang->line("product_serial") . ' ' . $this->lang->line("is_required") . '"');
        ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="discount_option"><?php echo $this->lang->line("discount_option"); ?></label>
    <div class="controls">
        <?php
        $do = array('0' => $this->lang->line("disable") . " " . $this->lang->line("discount"), '1' => $this->lang->line("apply_on_invoice_total"), '2' => $this->lang->line("apply_per_product"));
        echo form_dropdown('discount_option', $do, $settings->discount_option, 'class="span11 tip chzn-select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("discount_option") . '" required="required" data-error="' . $this->lang->line("discount_option") . ' ' . $this->lang->line("is_required") . '"');
        ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="discount_method"><?php echo $this->lang->line("discount_method"); ?></label>
    <div class="controls">
        <?php
        $dm = array('1' => $this->lang->line("apply_before_tax"), '2' => $this->lang->line("apply_after_tax"));
        echo form_dropdown('discount_method', $dm, $settings->discount_method, 'class="span11 tip chzn-select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("discount_method") . '" required="required" data-error="' . $this->lang->line("discount_method") . ' ' . $this->lang->line("is_required") . '"');
        ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="default_discount"><?php echo $this->lang->line("default_discount"); ?></label>
    <div class="controls">
        <?php
        foreach ($discounts as $discount) {
            $ds[$discount->id] = $discount->name;
        }
        echo form_dropdown('default_discount', $ds, $settings->default_discount, 'class="span11 tip chzn-select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("default_discount") . '" required="required" data-error="' . $this->lang->line("default_discount") . ' ' . $this->lang->line("is_required") . '"');
        ?>
    </div>
</div>
</div>
    <div class="span5 offset1">
<div class="control-group">
    <label class="control-label" for="tax_rate2"><?php echo $this->lang->line("rows_per_page"); ?></label>
    <div class="controls">
<?php
$options = array(
    '10' => '10',
    '25' => '25',
    '50' => '50',
    '100' => '100',
    '-1' => 'All (not recommended)');
echo form_dropdown('rows_per_page', $options, $settings->rows_per_page, 'class="span11 tip chzn-select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("rows_per_page") . '" title="' . $this->lang->line("rows_per_page_tip") . '" required="required" data-error="' . $this->lang->line("rows_per_page") . ' ' . $this->lang->line("is_required") . '"');
?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="total_rows"><?php echo $this->lang->line("total_rows"); ?></label>
    <div class="controls"><!--<input type="number" name="total_rows" value="<?php echo $settings->total_rows; ?>" min="10" max="99" id="inputComputer" class="span11 tip" id="total_rows" title="<?php echo $this->lang->line("total_rows_tip"); ?>" data-error="<?php echo $this->lang->line("total_rows") . ' ' . $this->lang->line("is_required"); ?>">-->
<?php echo form_input('total_rows', $settings->total_rows, 'class="span11 tip" id="total_rows" title="' . $this->lang->line("total_rows_tip") . '" required="required" data-error="' . $this->lang->line("total_rows") . ' ' . $this->lang->line("is_required") . '"'); ?> </div>
</div>
<div class="control-group">
    <label class="control-label" for="sales_prefix"><?php echo $this->lang->line("sales_prefix"); ?></label>
    <div class="controls"> <?php echo form_input('sales_prefix', $settings->sales_prefix, 'class="span11 tip" id="sales_prefix" title="' . $this->lang->line("sales_prefix_tip") . '" required="required" data-error="' . $this->lang->line("sales_prefix") . ' ' . $this->lang->line("is_required") . '"'); ?> </div>
</div>
<div class="control-group">
    <label class="control-label" for="quote_prefix"><?php echo $this->lang->line("quote_prefix"); ?></label>
    <div class="controls"> <?php echo form_input('quote_prefix', $settings->quote_prefix, 'class="span11 tip" id="quote_prefix" title="' . $this->lang->line("quote_prefix_tip") . '" required="required" data-error="' . $this->lang->line("quote_prefix") . ' ' . $this->lang->line("is_required") . '"'); ?> </div>
</div>
<div class="control-group">
    <label class="control-label" for="purchase_prefix"><?php echo $this->lang->line("purchase_prefix"); ?></label>
    <div class="controls"> <?php echo form_input('purchase_prefix', $settings->purchase_prefix, 'class="span11 tip" id="purchase_prefix" title="' . $this->lang->line("purchase_prefix_tip") . '" required="required" data-error="' . $this->lang->line("purchase_prefix") . ' ' . $this->lang->line("is_required") . '"'); ?> </div>
</div>
<div class="control-group">
    <label class="control-label" for="transfer_prefix"><?php echo $this->lang->line("transfer_prefix"); ?></label>
    <div class="controls"> <?php echo form_input('transfer_prefix', $settings->transfer_prefix, 'class="span11 tip" id="transfer_prefix" title="' . $this->lang->line("transfer_prefix_tip") . '" required="required" data-error="' . $this->lang->line("transfer_prefix") . ' ' . $this->lang->line("is_required") . '"'); ?> </div>
</div>
<div class="control-group">
    <label class="control-label" for="restrict_sale"><?php echo $this->lang->line("restrict_sale"); ?></label>
    <div class="controls">
<?php
$opt = array(1 => $this->lang->line('yes'), 0 => $this->lang->line('no1'));
echo form_dropdown('restrict_sale', $opt, $settings->restrict_sale, 'class="span11 tip chzn-select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("restrict_sale") . '" title="' . $this->lang->line("restrict_sale_tip") . '" required="required" data-error="' . $this->lang->line("restrict_sale") . ' ' . $this->lang->line("is_required") . '"');
?>
    </div>
</div>  

<div class="control-group">
    <label class="control-label" for="restrict_calendar"><?php echo $this->lang->line("calendar"); ?></label>
    <div class="controls">
<?php
$opt_cal = array(1 => $this->lang->line('private'), 0 => $this->lang->line('shared'));
echo form_dropdown('restrict_calendar', $opt_cal, $settings->restrict_calendar, 'class="span11 tip chzn-select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("restrict_calendar") . '" title="' . $this->lang->line("restrict_calendar_tip") . '" required="required" data-error="' . $this->lang->line("restrict_calendar") . ' ' . $this->lang->line("is_required") . '"');
?>
    </div>
</div>      
        
    </div>
</div>    
        
<div class="control-group">
    <div class="controls"> <?php echo form_submit('submit', $this->lang->line("update_settings"), 'class="btn btn-primary"'); ?> </div>
</div>
<?php echo form_close(); ?> 