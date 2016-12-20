<?php
$info = $this->session->userdata('business_info');
if(!empty($info->currency))
{
    $money_sign = $info->currency ;
}else
{
    $money_sign = '$';
}
?>

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
    height: auto;
    width: auto;
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
    display: inline-block;
    width: 29%;
    float: left;

}

#shipping {
    padding-left: 6px;
    display: inline-block;
    width: 29%;
    float: left;
}

#client .to {
    color: #777777;
}

#shipping .to {
    color: #777777;
}


h2.name {
    font-size: 1.4em;
    font-weight: normal;
    margin: 0;
}

#invoice {
    display: inline-block;
    text-align: right;
    width: 37%;
    float: right;
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
    padding: 5px;
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
    font-size: 10px;
}

table .unit {
    background: #DDDDDD;
}

table .qty {
}

table .total {
    background: #DDD;
    color: #000;
    text-align: right;
}

table td.unit,
table td.qty,
table td.total {
    font-size: 1.0em;
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


</head>
<body>


<header class="clearfix">
    <div id="logo">
        <img src="<?php  echo base_url(). $logo?>">
    </div>
    <div id="company">
        <h2 class="name"><?php echo $company_name?></h2>
        <div><?php echo $company_phone?></div>
        <div><?php echo $company_email?></div>
    </div>

</header>



<main>
    <div id="details" class="clearfix">

        <div id="client">
            <div class="to">CUSTOMER BILLING INFO:</div>
            <h2 class="name"><?php echo $order_info->customer_name ?></h2>
            <div class="address"><?php echo $order_info->customer_address ?></div>
            <div class="address"><?php echo $order_info->customer_phone ?></div>
            <div class="email"><?php echo $order_info->customer_email ?></div>
        </div>

            <div id="shipping">
                <?php if(!empty($order_info->shipping_address)):?>
                <div class="to">CUSTOMER SHIPPING INFO:</div>

                <div class="address"><?php
                    echo  $order_info->shipping_address;
                    ?></div>
                <?php endif ?>
            </div>


        <div id="invoice">
            <h1>INVOICE <?php echo $invoice_info->invoice_no ?></h1>
            <div class="date">Date of Invoice: <?php echo date('Y-m-d', strtotime($invoice_info->invoice_date )) ?></div>
            <div class="date">Sales Person: <?php echo $order_info->sales_person ?></div>

        </div>
    </div>
    <table border="0" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th class="desc text-right">#</th>
            <th class="desc">DESCRIPTION</th>
            <th class="unit text-right">UNIT PRICE</th>
            <th class="qty text-right">QUANTITY</th>
            <th class="total text-right ">TOTAL</th>
        </tr>
        </thead>
        <tbody>
        <?php $counter = 1?>
        <?php foreach($order_details as $v_order): ?>
            <tr>
                <td class="desc" ><?php echo $counter ?></td>
                <td class="desc" ><h3><?php echo $v_order->product_name ?></h3></td>
                <td class="unit" ><?php echo number_format($v_order->selling_price, 2); ?></td>
                <td class="qty" ><?php echo $v_order->product_quantity ?></td>
                <td class="total" ><?php echo number_format($v_order->sub_total,2) ?></td>
            </tr>
            <?php $counter ++?>
        <?php endforeach; ?>
        </tbody>

        <tfoot>
        <tr>
            <td colspan="2"></td>
            <td  colspan="2" >SUBTOTAL</td>
            <td><?php echo number_format($order_info->sub_total,2) ?></td>
        </tr>


        <tr>
            <td colspan="2"></td>
            <td colspan="2">Tax</td>
            <td><?php echo number_format($order_info->total_tax,2) ?></td>
        </tr>

        <?php if($order_info->discount):?>
            <tr>
                <td colspan="2" ></td>
                <td colspan="2" >Discount Amount</td>
                <td><?php echo number_format($order_info->discount_amount,2) ?></td>
            </tr>
        <?php endif; ?>

        <tr>
            <td colspan="2"></td>
            <td colspan="2">GRAND TOTAL</td>
            <td><?php echo $money_sign ?> <?php echo number_format($order_info->grand_total ,2) ?></td>
        </tr>

        </tfoot>

    </table>

</main>

</br>
<footer class="text-center">
    <strong><?php echo $company_name?></strong>&nbsp;&nbsp;&nbsp;<?php echo $address ?>
</footer>


</body>
</html>