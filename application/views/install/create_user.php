
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
                    <h3 class="box-title">Easy Inventory | Create User Login</h3>

                </div><!-- /.box-header -->
                <div class="box-body">

                    <?php echo message_box('success'); ?>
                    <?php echo message_box('error'); ?>

                    <div class="callout callout-success">
                        <h3>Sparking!</h3>
                        <h4>Easy Inventory Successfully Installed.</h4>
                    </div>

                    <h4>Create Login Details</h4>
                    <hr/>
                    <form class="form-horizontal" id="install_form" method="post" action="<?php echo base_url() ?>install/create_user/save_user">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Name</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" id="hostname" class="input_text" name="name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">Username</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" id="username" class="input_text" name="user_name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">Password</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" id="password" class="input_text" name="password" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" id="password" class="input_text" name="email" required>
                            </div>
                        </div>



                        <div class="form-group last">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn bg-navy btn-flat" id="submit">Create User</button>
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
