<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 *	@author : CodesLab
 *  @support: support@codeslab.net
 *	date	: 05 June, 2015
 *	Easy Inventory
 *	http://www.codeslab.net
 *  version: 1.0
 */

class Menu
{
    public function dynamicMenu()
    {
        $CI = &get_instance();

        $employee_login_id = $CI->session->userdata('employee_login_id');

        $user_type = $CI->session->userdata('user_type');

        if ($user_type != 1) {
            // query for employee employee role
            $user_menu = mysql_query("SELECT tbl_user_role.menu_id, tbl_user_role.employee_login_id, tbl_menu.*
                                        FROM tbl_user_role
                                        INNER JOIN tbl_menu
                                        ON tbl_user_role.menu_id=tbl_menu.menu_id
                                        WHERE tbl_user_role.employee_login_id=$employee_login_id
                                        ORDER BY sort;");
        } else { // get all menu for admin
           $user_menu =  mysql_query('SELECT menu_id, label, link, icon, parent FROM tbl_menu ORDER BY sort');
        }

        // Create a multidimensional array to conatin a list of items and parents
        $menu = array(
            'items' => array(),
            'parents' => array(),
        );

        // Builds the array lists with data from the menu table
        while ($items = mysql_fetch_assoc($user_menu)) {

            // Creates entry into items array with current menu item id ie. $menu['items'][1]
            $menu['items'][$items['menu_id']] = $items;

            // Creates entry into parents array. Parents array contains a list of all items with children
            $menu['parents'][$items['parent']][] = $items['menu_id'];
        }

        return $output = $this->buildMenu(0, $menu);
    }

    public function buildMenu($parent, $menu, $flag=null)
    {
        $html = '';
        
        if (isset($menu['parents'][$parent])) {
            
            if($flag !=null){
                $html .= "<ul class='treeview-menu'>\n"; 
            }else{
               $html .= "<ul class='sidebar-menu'>\n";
            }
            
            foreach ($menu['parents'][$parent] as $itemId) {
                $result = $this->active_menu_id($menu['items'][$itemId]['menu_id']);
                if ($result) {
                    $active = 'active';
                    $opened = 'opened';
                } else {
                    $active = '';
                    $opened = '';
                }

                if (!isset($menu['parents'][$itemId])) { //if condition is false
                    $html .= "<li class='".$active ."' >\n  <a href='".base_url().$menu['items'][$itemId]['link']."'> <i class='".$menu['items'][$itemId]['icon']."'></i><span>".$menu['items'][$itemId]['label']."</span></a>\n</li> \n";
                }

                if (isset($menu['parents'][$itemId])) { //if condition is true
                    $html .= "<li class='".$active . ' treeview' ."'>\n  <a href='".base_url().$menu['items'][$itemId]['link']."'> <i class='".$menu['items'][$itemId]['icon']."'></i><span>".$menu['items'][$itemId]['label']."</span> <i class='fa fa-angle-left pull-right'></i> </a>\n";
                    $html .= self::buildMenu($itemId, $menu, $flag=1);
                    $html .= "</li> \n";
                }
            }

            $html .= "</ul> \n";
        }
        
        return $html;
    }

    public function active_menu_id($id)
    {
        $CI = &get_instance();
        $activeId = $CI->session->userdata('menu_active_id');

        if (!empty($activeId)) {
            foreach ($activeId as $v_activeId) {
                if ($id == $v_activeId) {
                    return true;
                }
            }
        }

        return false;
    }
}
