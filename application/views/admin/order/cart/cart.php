


<table class="table table-bordered table-hover">
    <thead ><!-- Table head -->
    <tr>
        <th class="active">Sl</th>
        <th class="active col-sm-6">Product</th>
        <th class="active ">Qty</th>
        <th class="active ">Unit Price</th>
        <th class="active">Total</th>
        <th class="active">Action</th>

    </tr>
    </thead><!-- / Table head -->
    <tbody><!-- / Table body -->
    <?php $cart = $this->cart->contents() ;
//    echo '<pre>';
//    print_r($cart);
    ?>
    <?php $counter =1 ; ?>
    <?php if (!empty($cart)): foreach ($cart as $item) : ?>

        <tr class="custom-tr">
            <td class="vertical-td">
                <?php echo  $counter ?>
            </td>
            <td class="vertical-td"><?php echo $item['name'] ?></td>
            <td class="vertical-td">

                <input  type="text" name="qty" style="width: 50px" value="<?php echo $item['qty'] ?>" onblur ="order(this);" id="<?php echo 'qty'.$item['rowid'] ?>" class="form-control">

            </td>
            <td>

<!--                <input  type="text" name="price" value="--><?php //echo $item['price'] ?><!--"  onblur ="order(this);" id="--><?php //echo 'pri'.$item['rowid'] ?><!--" class="form-control">-->
                <div class="input-group">
                        <span class="input-group-addon">
                          <input type="checkbox" id="<?php echo 'opt'.$item['rowid'] ?>" onclick="return price_checkbox(this)" name="custom_price"
                                 <?php echo $item['price_option'] == 'custom_price' ? 'checked':'' ?>
                                 data-placement="top" data-toggle="tooltip" data-original-title="Custom Price">
                        </span>
                    <input  type="text" name="price" value="<?php echo $item['price'] ?>"  onblur ="order(this);" id="<?php echo 'pri'.$item['rowid'] ?>" class="form-control"
                            <?php echo $item['price_option'] == 'custom_price' ? '':'disabled' ?> >
                </div>


                <input type="hidden" name="product_code" value="<?php echo $item['id']  ?>" id="<?php echo 'code'.$item['rowid'] ?>">
            </td>
            <td class="vertical-td"><?php echo number_format($item['subtotal'], 2, '.', ',')  ?></td>

            <td class="vertical-td">
                <?php echo btn_delete('admin/order/delete_cart_item/' . $item['rowid']); ?>
            </td>

        </tr>


        <?php
        $counter++;
    endforeach;
        ?><!--get all sub category if not this empty-->





    <?php else : ?> <!--get error message if this empty-->
        <td colspan="6">
            <strong>There is no record for display</strong>
        </td><!--/ get error message if this empty-->
    <?php endif; ?>
    </tbody><!-- / Table body -->
</table> <!-- / Table -->
<script src="<?php echo base_url(); ?>asset/js/ajax.js"></script>

<script>



</script>