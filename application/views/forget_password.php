<?php $this->load->view('admin/components/header'); ?>
<link href="<?php echo base_url(); ?>asset/css/animation.css" rel="stylesheet">

<body class="login-page">


<div class="login-box retrive-password">
    <div class="login-logo animated fadeInDown" data-animation="fadeInDown">
        <a href="<?php echo base_url() ?>"><b>Easy</b>Inventory </a>
    </div><!-- /.login-logo -->

    <div class="login-box-body  animated fadeInUp" data-animation="fadeInUp">



        <div class="panel panel-default">
            <div class="panel-heading">Forget Password</div>
            <div class="panel-body">

                <form method="post" action="<?php echo base_url() ?>forget_password/retrieve_password">
                    <?php echo $this->session->flashdata('error'); ?>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter email" required>
                    </div>

                    <button type="submit" class="btn bg-navy btn-block">Retrieve Password</button>
                </form>
                <br/>
                <a href="<?php echo base_url() ?>">Back to Login Page</a>

            </div>
        </div>



    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->

</body>
</html>