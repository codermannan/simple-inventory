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

class Breadcrumbs
{
    public function build_breadcrumbs()
    {
        $CI = &get_instance();
        $menu_id = $CI->session->userdata('menu_active_id');

        $breadcrumbs = '';
        foreach ($menu_id as $v_id) {
            $menu = mysql_query("SELECT tbl_menu.*
                                        FROM tbl_menu
                                        WHERE tbl_menu.menu_id=$v_id ;");

            while ($items = mysql_fetch_assoc($menu)) {
                $breadcrumbs .= "<li>\n  <a href='".base_url().$items['link']."'>".$items['label']."</a>\n</li> \n";
            }
        }

        return $breadcrumbs;
    }
}
