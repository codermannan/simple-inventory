<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />


   <style>

       table {
           width: 100%;
       }
       td{
           width: 100px;
           margin: 15px;
       }

   </style>

</head>
<body>


<table>

    <?php
    if(!empty($_SESSION["barcode"])){
        ?>
        <?php foreach($_SESSION["barcode"] as $barcode){ ?>

            <div class="col-sm-3 text-center" style="margin: 20px 0px 20px 5px">
                <?php

                $product_name = $barcode['product_name'];
                $name_product = wordwrap($product_name, 10, "\n", true);
                ?>
                <small><?php echo $name_product?></small></br>
                <img src="<?php echo base_url() . $barcode['barcode']?>" style="max-width:150%; height:auto">
            </div>
        <?php }?>
    <?php }else {?>
        <div class="col-md-12">
            <?php echo "There is No Product Barcode for Print" ?>
        </div>
    <?php } ?>

</table>

<!-- end .container_16 -->
</body>
</html>