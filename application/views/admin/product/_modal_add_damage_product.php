


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $title ?></h4>
</div>
<div class="modal-body" >







    <div class="form-group">
        <label for="exampleInputEmail1">Customer Name <span class="required">*</span></label>
        <input name="customer_name" placeholder="Customer Name" value="" class="form-control" type="text">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Customer Name <span class="required">*</span></label>
        <input name="customer_name" placeholder="Customer Name" value="" class="form-control" type="text">
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Address <span class="required">*</span></label>
        <textarea name="address" class="form-control autogrow" id="field-ta" placeholder="Address"></textarea>
    </div>


    <div class="modal-footer" >
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <a href="<?php echo base_url(); ?>admin/product/add_product/" type="button" class="btn bg-navy">save Damage Product </a>
    </div>

</div>




