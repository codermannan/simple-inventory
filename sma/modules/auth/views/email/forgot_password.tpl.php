<html>
<body>
	<h1>Stock Manager Advance</h1>
	<p>We have recevived a request to reset the password for <?php echo $identity;?></p>
    <p>&nbsp;</p>
	<p>Please click this link to <?php echo anchor('module=auth&view=reset_password&code='. $forgotten_password_code, 'Reset Your Password');?>.</p>
    <p>&nbsp;</p>
    <p>Thank you!</p>
    <p>&nbsp;</p>
    <p>This is system generated email and replying this email will go nowhere. If you have any questions, Please contact the administrtor.</p>
</body>
</html>