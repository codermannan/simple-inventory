<?php
$info = $this->session->userdata('business_info');
if(!empty($info->currency))
{
    $currency = $info->currency ;
}else
{
    $currency = '$';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">

<style>

.clearfix:after {
    content: "";
    display: table;
    clear: both;
}

a {
    color: #0087C3;
    text-decoration: none;
}

body {
    position: relative;
    width: 19cm;
    height: 29.7cm;
    margin: 0 auto;
    color: #555555;
    background: #FFFFFF;
    font-family: Arial, sans-serif;
    font-size: 14px;
    font-family: SourceSansPro;
}

header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #AAAAAA;
}

#logo {
    float: left;
    margin-top: 8px;
    display: inline-block;
    width: 40%;
}

#logo img {
    height: 70px;
    width: 150px;
}

#company {
    float: right;
    text-align: right;
    display: inline-block;
    width: 60%;
}


#details {
    margin-bottom: 50px;
}

#client {
    padding-left: 6px;
    border-left: 6px solid #0087C3;
    float: left;
    display: inline-block;
    width: 50%;
}

#client .to {
    color: #777777;
}

h2.name {
    font-size: 1.4em;
    font-weight: normal;
    margin: 0;
}

#invoice {
    float: right;
    text-align: right;
    display: inline-block;
    width: 40%;
}

#invoice h1 {
    color: #0087C3;
    font-size: 1.4em;
    line-height: 1em;
    font-weight: normal;
    margin: 0  0 10px 0;
}

#invoice .date {
    font-size: 1.1em;
    color: #777777;
}

table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px;
}

table th,
table td {
    padding: 10px;
    background: #EEEEEE;
    text-align: center;
    border-bottom: 1px solid #FFFFFF;
}

table th {
    white-space: nowrap;
    font-weight: normal;
}

table td {
    text-align: right;
}

table td h3{
    color: #57B223;
    font-size: 1.2em;
    font-weight: normal;
    margin: 0 0 0.2em 0;
}

table .no {
    color: #000;
    font-size: 1.6em;
    background: #C4CBC2;
}

table .desc {
    text-align: left;
}

table .unit {
    background: #DDDDDD;
}

table .qty {
}

table .total {
    background: #DDD;
    color: #000;
}

table td.unit,
table td.qty,
table td.total {
    font-size: 1.2em;
}

table tbody tr:last-child td {
    border: none;
}

table tfoot td {
    padding: 10px 20px;
    background: #FFFFFF;
    border-bottom: none;
    font-size: 1.2em;
    white-space: nowrap;
    border-top: 1px solid #AAAAAA;
}

table tfoot tr:first-child td {
    border-top: none;
}

table tfoot tr:last-child td {
    color: #57B223;
    font-size: 1.4em;
    border-top: 1px solid #57B223;

}

table tfoot tr td:first-child {
    border: none;
}

#thanks{
    font-size: 2em;
    margin-bottom: 50px;
}

#notices{
    padding-left: 6px;
    border-left: 6px solid #0087C3;
}

#notices .notice {
    font-size: 1.2em;
}

footer {
    color: #777777;
    width: 100%;
    height: 30px;
    position: absolute;
    bottom: 0;
    border-top: 1px solid #AAAAAA;
    padding: 8px 0;
    text-align: center;
}



</style>

<?php
    //company logo
    if(!empty($info->logo)){
        $logo = $info->logo;
    }else{
        $logo = 'img/logo.png';
    }

    //company details
    if(!empty($info->company_name)){
        $company_name = $info->company_name;
    }else{
        $company_name = 'Your Company Name';
    }
    //company phone
    if(!empty($info->phone)){
        $company_phone = $info->phone;
    }else{
        $company_phone = 'Company Phone';
    }
    //company email
    if(!empty($info->email)){
        $company_email = $info->email;
    }else{
        $company_email = 'Company Email';
    }
    //company address
    if(!empty($info->address)){
        $address = $info->address;
    }else{
        $address = 'Company Address';
    }



?>

</head>
<body>
<header class="clearfix">
    <div id="logo">
        <img src="<?php  echo base_url(). $logo?>">
    </div>
    <div id="company">
        <h2 class="name"><?php echo $company_name ?></h2>
        <div><?php echo $company_phone ?></div>
        <div><?php echo $company_email ?></div>
    </div>
    </div>
</header>
<main>
    <div id="details" class="clearfix">
        <div id="client">
            <div class="to">SUPPLIER:</div>
            <h2 class="name"><?php echo $purchase->company_name ?></h2>
            <div class="name"><?php echo $purchase->address ?></div>
            <div class="address"><?php echo $purchase->phone ?></div>
            <div class="email"><?php echo $purchase->email ?></div>
        </div>
        <div id="invoice">
            <h1>INVOICE <?php echo $purchase->purchase_order_number ?></h1>
            <div class="date">Date of Invoice: <?php echo date('Y-m-d', strtotime($purchase->datetime )) ?></div>
            <div class="date">Purchase by: <?php echo $purchase->purchase_by ?></div>

        </div>
    </div>
    <table border="0" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th class="no">#</th>
            <th class="desc">DESCRIPTION</th>
            <th class="unit" style="text-align: right">UNIT PRICE</th>
            <th class="qty" style="text-align: right">QUANTITY</th>
            <th class="total" style="text-align: right">TOTAL</th>
        </tr>
        </thead>
        <tbody>
        <?php $counter = 1?>
        <?php foreach($product as $v_product): ?>
            <tr>
                <td class="no"><?php echo $counter ?></td>
                <td class="desc"><h3><?php echo $v_product->product_name ?></h3></td>
                <td class="unit"><?php echo number_format($v_product->unit_price, 2); ?></td>
                <td class="qty"><?php echo $v_product->qty ?></td>
                <td class="total"><?php echo number_format($v_product->sub_total,2) ?></td>
            </tr>
            <?php $counter ++?>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2"></td>
            <td colspan="2">SUBTOTAL</td>
            <td><?php echo $currency.' '.number_format($purchase->grand_total,2) ?></td>
        </tr>

        <tr>
            <td colspan="2"></td>
            <td colspan="2">GRAND TOTAL</td>
            <td><?php echo $currency.' '.number_format($purchase->grand_total,2) ?></td>
        </tr>
        </tfoot>
    </table>

</main>
<footer>
    <strong><?php echo $company_name?></strong>&nbsp;&nbsp;&nbsp;<?php echo $address ?>
</footer>
</body>
</html>