
<html>
<body>
	<h1>Stock Manager Advance</h1>
	<p>Activate account for <?php echo $identity;?></p>
    <p>&nbsp;</p>
    <p>Please click this link to <?php echo anchor('auth/activate/'. $id .'/'. $activation, 'Activate Your Account');?>.</p>
    <p>&nbsp;</p>
    <p>Thank you!</p>
    <p>&nbsp;</p>
    <p>This is system generated email and replying this email will go nowhere. If you have any questions, Please contact the administrtor.</p>
    
</body>
</html>
