
<div class="row">
    <div class="col-sm-12">
        <div class="wrap-fpanel">
            <div class="panel panel-default" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        <strong>Add Navigation</strong>
                    </div>                
                </div>
                <div class="panel-body">

                    <form role="form" id="form" action="<?php echo base_url(); ?>admin/navigation/save_navigation/<?php if(!empty($menu_info->menu_id)){ echo $menu_info->menu_id;} ?>" method="post" class="form-horizontal form-groups-bordered">

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label">Label<span class="required"> *</span></label>
                            <div class="col-sm-5">                         
                                <input type="text" name="label" value="<?php echo $menu_info->label ?>" class="form-control" placeholder="Menu Label"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label">Slug<span class="required"> *</span></label>
                            <div class="col-sm-5">                         
                                <input type="text" name="link" value="<?php echo $menu_info->link ?>" class="form-control" placeholder="Menu Link"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label">Icon<span class="required"> *</span></label>
                            <div class="col-sm-5">                         
                                <input type="text" name="icon" value="<?php echo $menu_info->icon ?>" class="form-control" placeholder="Menu Icon"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label">Parent</label>
                            <div class="col-sm-5">                         
                                <select name="parent" class="form-control">
                                    <option value="">Select Parent...</option>
                                    
                                   <?php if (count($nav)): foreach ($nav as $v_nav) : ?>
                                    <option value="<?php echo $v_nav->menu_id ?>"
                                            <?php echo $menu_info->parent == $v_nav->menu_id ? 'selected':'' ?>>
                                            <?php echo $v_nav->label ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label">Sort<span class="required"> *</span></label>
                            <div class="col-sm-5">                         
                                <input type="text" name="sort" value="<?php echo $menu_info->sort ?>" class="form-control" placeholder="Menu Sorting"/>
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5 pull-right">
                                <button type="submit" id="sbtn" class="btn btn-primary">Save</button>                            
                            </div>
                        </div>   
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
