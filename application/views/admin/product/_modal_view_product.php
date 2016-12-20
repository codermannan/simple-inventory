
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $product->product_name ?></h4>
</div>
<div class="modal-body wrap-modal wrap" style="max-height: 900px;">

    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-thumbnail">
                        <?php if(!empty($product->filename)){?>
                            <img src="<?php echo base_url() . $product->filename; ?>" class="img-circle" alt="Product Image"/>
                        <?php }else{?>
                            <img src="<?php echo base_url(); ?>img/product.png" class="img-circle" alt="Product Image"/>
                        <?php } ?>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="product-barcode">
                        <img src="<?php echo base_url() . $product->barcode ?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-8">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="active" colspan="2"><?php echo $product->product_name ?></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="col-sm-3">Product Code</td>
                    <td><?php echo $product->product_code ?></td>
                </tr>
                <tr>
                    <td class="col-sm-3 ">Product Name</td>
                    <td class=""><?php echo $product->product_name ?></td>
                </tr>
                <tr>
                    <td class="col-sm-3">Product Note</td>
                    <td><?php echo $product->product_note ?></td>
                </tr>
                <tr>
                    <td class="col-sm-3 ">Product Category</td>
                    <td class=""><?php echo $product->category_name ?></td>
                </tr>
                <tr>
                    <th class="active" colspan="2" >Product General Price</th>
                </tr>
                <tr>
                    <td class="col-sm-3">Buying Price</td>
                    <td class=""><?php echo $product->buying_price ?></td>
                </tr>
                <tr>
                    <td class="col-sm-3">Selling Price</td>
                    <td><?php echo $product->selling_price ?></td>
                </tr>

                <tr>
                    <th class="active" colspan="2">Special Offer</th>
                </tr>
                <tr>
                    <td class="col-sm-3">Offer Start Date</td>
                    <td><?php echo $product->start_date ?></td>
                </tr>
                <tr>
                    <td class="col-sm-3">Offer End Date</td>
                    <td><?php echo $product->end_date ?></td>
                </tr>
                <tr>
                    <td class="col-sm-3">Offer Price</td>
                    <td><?php echo $product->offer_price ?></td>
                </tr>

                <tr>
                    <th class="active" colspan="2">Tier Price</th>
                </tr>

                <tr>
                    <td class="no-border" colspan="2">

                        <table class="table table-bordered nowrap">
                            <thead>
                            <tr>
                                <th>
                                    Quantity Above
                                </th>
                                <th>
                                    Price
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($tier_price as $v_tier_price){ ?>
                            <tr>
                                <td><?php echo $v_tier_price->quantity_above?></td>
                                <td><?php echo $v_tier_price->tier_price?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr>
                    <th class="active" colspan="2">Attribute</th>
                </tr>

                <tr>
                    <td class="no-border" colspan="2">

                        <table class="table table-bordered nowrap">
                            <thead>
                            <tr>
                                <th>
                                    Attribute Label
                                </th>
                                <th>
                                    Value
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($attribute as $v_attribute){ ?>
                                <tr>
                                    <td><?php echo $v_attribute->attribute_name?></td>
                                    <td><?php echo $v_attribute->attribute_value?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr>
                    <th class="active" colspan="2">Product Tag</th>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php foreach($product_tags as $v_tag){
                            echo '<span class="label label-default">'.$v_tag->tag .'</span> &nbsp;&nbsp;';
                        }?>


                    </td>
                </tr>


                </tbody>
            </table>

        </div>
    </div>


    <div class="modal-footer" >

            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <a href="<?php echo base_url(); ?>admin/product/add_product/<?php echo $product_id ?>" type="button" class="btn btn-primary">Edit Product</a>

        </div>

</div>


