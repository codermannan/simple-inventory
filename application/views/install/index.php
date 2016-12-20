
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<title>Installation | Easy Inventory</title>
        <link href="<?php echo base_url(); ?>asset/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>asset/css/admin.css" rel="stylesheet" type="text/css" />
	</head>
	<body style="background:#222D32">
    


<div class="container" style="margin-top:50px ">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">


            <div class="box">
                <div class="box-header box-header-background with-border">
                    <h3 class="box-title">Easy Inventory Installation</h3>

                </div><!-- /.box-header -->
                <div class="box-body">

                    <?php echo message_box('success'); ?>
                    <?php echo message_box('error'); ?>

                        <h4>Database Seetings</h4>
                        <hr/>
                        <form class="form-horizontal" id="install_form" method="post" action="<?php echo base_url() ?>install/do_install">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Hostname</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" id="hostname" value="localhost" class="input_text" name="db_host_name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-4 control-label">Database Username</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" id="username" class="input_text" name="db_user_name" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-4 control-label">Database Password</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" id="password" class="input_text" name="db_password" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-4 control-label">Database Name</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" id="database" class="input_text" name="db_name" required>
                                </div>
                            </div>



                            <div class="form-group last">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" class="btn bg-navy btn-flat" id="submit">Install</button>
                                    <button type="reset" class="btn btn-flat bg-olive">Reset</button>
                                </div>
                            </div>
                        </form>


                </div><!-- /.box-body -->
                <div class="box-footer">
                    &copy <?php echo date("Y") ?> www.codeslab.net
                </div><!-- box-footer -->
            </div><!-- /.box -->

        </div>
    </div>
</div>




    

	</body>
</html>
