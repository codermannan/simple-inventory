<?php $info = $this->session->userdata('business_info');?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Untitled Document</title>
</head>

<body>
<table width="60%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td height="100" style="background-color:#eeeeee; border-top:solid 10px #333333">
            <img width="196" height="60" src="<?php  echo base_url(). $info->logo?>" alt="logo" style="padding-top: 5px; padding-bottom: 5px; padding-left:10px">
        </td>
    </tr>
    <tr>
        <td height="31" valign="top" style="padding:20px">
            <h2>Your New Password</h2>
            <p>Hi, Alex<br />
                Your System <b>Generate</b> New password is bellow:<br><br></p>

            <p><strong> Username:</strong> <?php echo $username ?>
                <br/>
                <strong> Password:</strong> <?php echo $password ?></p>
            <p>&nbsp;</p>
            <p>Thanks</p></td>
    </tr>
    <tr>
        <td height="50" style="background-color:#eeeeee; border-bottom:solid 5px #333333; text-align:center; font-size:12px; color:#666">
            <strong><?php echo $info->company_name?></strong>&nbsp;&nbsp;&nbsp;<?php echo $info->address ?>
        </td>
    </tr>
</table>
</body>
</html>
