<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/kendo.default.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/kendo.common.min.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/kendo.all.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/ajax.js"></script>


<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header box-header-background with-border">
                    <div class="col-md-offset-1">
                    <h3 class="box-title">Create User</h3>
                        </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="userform" enctype="multipart/form-data" onsubmit="return employeeImage(this)"
                      action="<?php echo base_url(); ?>admin/employee/save_employee" method="post">

                    <div class="row">
                        <div class="col-md-5 col-md-offset-1 border-right">
                            <div class="box-body">



                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name <span class="required">*</span></label>
                                    <input type="text" placeholder="First" name="name" class="form-control"
                                        value="<?php if(!empty($employee_login_details->name)){
                                            echo $employee_login_details->name;
                                        } ?>"
                                        >
                                </div>
                                <div class="form-group">
                                    <label>Username <span class="required">*</span></label>
                                    <input type="text" placeholder="Username" onchange="check_user_name(this.value)" name="user_name" class="form-control"
                                           value="<?php if(!empty($employee_login_details->user_name)){
                                               echo $employee_login_details->user_name;
                                           } ?>"
                                        >
                                    <div class="required" id="username_result"></div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Email <span class="required">*</span></label>
                                    <input type="email" placeholder="Email" name="email" class="form-control"
                                           value="<?php if(!empty($employee_login_details->email)){
                                               echo $employee_login_details->email;
                                           } ?>"
                                        >
                                </div>
                                <div id="password_div" style="
                                <?php if(!empty($employee_login_details->user_id)){
                                    echo 'display: none';
                                } ?>">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password <span class="required">*</span></label>
                                    <input type="password" placeholder="Password" id="password" name="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Confirm Password</label>
                                    <input type="password" placeholder="Password" id="confirm_password" name="confirm_password"
                                           class="form-control">
                                </div>
                                </div>
                                <input type="hidden" id="password_flag" name="password_flag" value="">

                                <?php if(!empty($employee_login_details->user_id)) : ?>
                                <div class="form-group">
                                    <input type=button id="change_password" class="btn bg-purple" value='Change Password' onclick="setVisibility();";>

                                </div>
                                <?php endif; ?>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">User Type</label>
                                    <select id="user_type" name="flag" class="form-control"
                                            <?php
                                            if(!empty($employee_login_details->flag)) {
                                                if($employee_login_details->flag !=1 ){
                                                    echo 'required';
                                                }else{
                                                    echo 'disabled';
                                                }
                                            }else{
                                                echo 'required';
                                            }
                                            ?>
                                            required>
                                        <option
                                            value="" <?php echo $employee_login_details->flag == 3 ? 'selected' : '' ?>>
                                            Select User Type
                                        </option>
                                        <option <?php echo $employee_login_details->flag == 1 ? 'selected' : '' ?>
                                            value="1">Admin
                                        </option>
                                        <option <?php echo $employee_login_details->flag == 0 ? 'selected' : '' ?>
                                            value="0">User
                                        </option>
                                    </select>
                                </div>


                                <!-- /.employee Image -->
                                <div class="form-group">
                                    <label>Employee Image</label>
                                </div>
                                <div class="form-group">
                                    <!-- hidden  old_path when update  -->
                                    <input type="hidden" name="old_path"  value="<?php
                                    if (!empty($product_image->image_path)) {
                                        echo $product_image->image_path;
                                    }
                                    ?>">
                                    <div class="fileinput fileinput-new"  data-provides="fileinput">
                                        <div class="fileinput-new thumbnail g-logo-img" >
                                            <?php if (!empty($employee_login_details->filename)): // if product image is exist then show  ?>
                                                <img src="<?php echo base_url() . $employee_login_details->filename; ?>" >
                                            <?php else: // if product image is not exist then defualt a image ?>
                                                <img src="<?php echo base_url() ?>img/user.jpg" alt="Product Image">
                                            <?php endif; ?>
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail g-logo-img"  ></div>
                                        <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new"><input type="file" name="employee_image" /></span>
                                                        <span class="fileinput-exists">Change</span>
                                                    </span>
                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                        <div id="valid_msg" class="required"></div>
                                    </div>
                                </div>
                                <!-- / Product Image -->


                            </div>
                            <!-- /.box-body -->
                        </div>

                        <div class="col-md-5 col-md-offset-1">
                            <div id="roll">
                                <div class="box-body">
                                    <h4>User Access Roll:</h4>
                                    <div class="k-header">
                                        <div class="box-col">
                                            <div id="treeview"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.row end -->

                    <input type="hidden" name="employee_id" id="employee_id" value="<?php echo $employee_id?>">

                    <div class="box-footer ">
                        <button type="submit" id="sbtn" class="btn btn-primary btn-navy col-md-offset-1 bg-navy">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
</section>

    <script>
                $("#treeview").kendoTreeView({
        checkboxes: {
        checkChildren: true,
                template: "<input type='checkbox' #= item.check# name='menu[]' value='#= item.value #'  />"

        },
                check: onCheck,
                dataSource: [
<?php foreach ($result as $parent => $v_parent): ?>
    <?php if (is_array($v_parent)): ?>
        <?php foreach ($v_parent as $parent_id => $v_child): ?>
                            {
                            id: "", text: "<?php echo $parent; ?>", value: "<?php
            if (!empty($parent_id)) {
                echo $parent_id;
            }
            ?>", expanded: false, items: [
            <?php foreach ($v_child as $child => $v_sub_child) : ?>
                <?php if (is_array($v_sub_child)): ?>
                    <?php foreach ($v_sub_child as $sub_chld => $v_sub_chld): ?>
                                        {
                                        id: "", text: "<?php echo $child; ?>", value: "<?php
                        if (!empty($sub_chld)) {
                            echo $sub_chld;
                        }
                        ?>", expanded: false, items: [
                        <?php foreach ($v_sub_chld as $sub_chld_name => $sub_chld_id): ?>
                                            {
                                            id: "", text: "<?php echo $sub_chld_name; ?>",<?php
                            if (!empty($roll[$sub_chld_id])) {
                                echo $roll[$sub_chld_id] ? 'check: "checked",' : '';
                            }
                            ?> value: "<?php
                            if (!empty($sub_chld_id)) {
                                echo $sub_chld_id;
                            }
                            ?>",
                                            },
                        <?php endforeach; ?>
                                        ]
                                        },
                    <?php endforeach; ?>
                <?php else: ?>
                                    {
                                    id: "", text: "<?php echo $child; ?>", <?php
                    if (!is_array($v_sub_child)) {
                        if (!empty($roll[$v_sub_child])) {
                            echo $roll[$v_sub_child] ? 'check: "checked",' : '';
                        }
                    }
                    ?> value: "<?php
                    if (!empty($v_sub_child)) {
                        echo $v_sub_child;
                    }
                    ?>",
                                    },
                <?php endif; ?>
            <?php endforeach; ?>
                            ]
                            },
        <?php endforeach; ?>
    <?php else: ?>
                        { <?php if ($parent == 'Dashboard') {
            ?>
                            id: "", text: "<?php echo $parent ?>", <?php echo 'check: "checked",';
            ?>  value: "<?php
            if (!is_array($v_parent)) {
                echo $v_parent;
            }
            ?>"
            <?php
        } else {
            ?>
                            id: "", text: "<?php echo $parent ?>", <?php
            if (!is_array($v_parent)) {
                if (!empty($roll[$v_parent])) {
                    echo $roll[$v_parent] ? 'check: "checked",' : '';
                }
            }
            ?> value: "<?php
            if (!is_array($v_parent)) {
                echo $v_parent;
            }
            ?>"
        <?php }
        ?>
                        },
    <?php endif; ?>
<?php endforeach; ?>
                ]
        });
                // show checked node IDs on datasource change
                        function onCheck() {
                        var checkedNodes = [],
                                treeView = $("#treeview").data("kendoTreeView"),
                                message;
                                checkedNodeIds(treeView.dataSource.view(), checkedNodes);
                                $("#result").html(message);
                        }
    </script>


    <script type="text/javascript">

                $(function () {
                $("#treeview .k-checkbox input").eq(0).hide();
                        $('form').submit(function () {
                $('#treeview :checkbox').each(function () {
                if (this.indeterminate) {
                this.checked = true;
                }
                });
                })
                })
    </script>

    <script>
                        $(document).ready(function(){

                var user_flag = document.getElementById("user_type").value;
                        if (user_flag == '' || user_flag == '0')
                {
                $("#roll").show();
                }
                else
                {
                $("#roll").hide();
                }

                // on change user type select action
                $('#user_type').on('change', function() {
                if (this.value == '0' || this.value == '')
                        //.....................^.......
                        {
                        $("#roll").show();
                        }
                else
                {
                $("#roll").hide();
                }
                });
                });

    </script>

    <script>

        $().ready(function() {

            // validate signup form on keyup and submit
            $("#userform").validate({
                rules: {
                    user_name: "required",
                    name: "required",

                    user_name: {
                        required: true,
                        minlength: 4
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },

                    confirm_password: {
                        equalTo: "#password"
                    },

                    email: {
                        required: true,
                        email: true
                    }

                },
                highlight: function(element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element).closest('.form-group').removeClass('has-error');
                },
                errorElement: 'span',
                errorClass: 'help-block',
                errorPlacement: function(error, element) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                },
                messages: {
                    user_name: {
                        required: "Please enter a username",
                        minlength: "Your username must consist of at least 4 characters"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 6 characters long"
                    },

                    email: {
                        required: "Please enter a valid email address"
                    },

                    name: {
                        required: "Please enter your Name"
                    }


                }

            });

        });
    </script>
