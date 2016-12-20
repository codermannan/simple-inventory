<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* Script: pos_lang.php
* 	Thai translation file
*
* Last edited:
*	Thai: August 15th, 2013 based on English 21st March 2013
*
* License:
*	GPL v3 or above
*/

/* I will thankful if you could help me translating this file to your language and email me at saleem@tecdiary.com */

#Header

$lang['pos_module'] 				= "โมดูลระบบบริการ ณ จุดขาย";
$lang['cat_limit'] 					= "แสดงหมวดหมู่";
$lang['pro_limit'] 					= "แสดงสินค้า";
$lang['default_category']			= "หมวดหมู่เริ่มต้น";
$lang['default_customer'] 			= "ลูกค้าเริ่มต้น";
$lang['default_biller'] 			= "ผู้ออกใบเสร็จเริ่มต้น";
$lang['pos_settings'] 				= "ตั้งค่าระบบ";
$lang['barcode_scanner'] 			= "เครื่องอ่านบาร์โคด";
$lang['x'] 							= "X";
$lang['qty'] 						= "จำนวน";
$lang['total_items'] 				= "รวมรายการทั้งสิ้น";
$lang['total_payable'] 				= "จำนวนที่จ่าย";
$lang['total_sales'] 				= "รวมยอดขาย";
$lang['tax1'] 						= "ภาษี 1";
$lang['total_x_tax'] 				= "รวม";
$lang['cancel'] 					= "ยกเลิก";
$lang['payment'] 					= "การชำระ";
$lang['pos'] 						= "ระบบบริการ ณ จุดขาย";
$lang['p_o_s'] 						= "ระบบบริการ ณ จุดขาย";
$lang['today_sale'] 				= "รายการขายวันนี้";
$lang['daily_sales'] 				= "รายการขายรายวัน";
$lang['monthly_sales'] 				= "รายการขายรายเดือน";
$lang['pos_settings'] 				= "ตั้งค่าระบบบริการ ณ จุดขาย";
$lang['loading'] 					= "กำลังโหลด...";
$lang['display_time'] 				= "แสดงเวลา";
$lang['pos_setting_updated'] 		= "การตั้งค่าระบบบริการ ณ จุดขายบันทึกเรียบร้อยแล้ว โปรดรีเฟรชหน้าเพื่อโหลดค่าใหม่";
$lang['tax_request_failed'] 		= "คำร้องขอล้มเหลว พบปัญหาบางอย่างเรื่องอัตราภาษี";
$lang['pos_error'] 					= "พบปัญหาในการคำนวณ โปรดลองเพิ่มรายการสินค้าอีกครั้ง";
$lang['qty_limit'] 					= "จำนวนเกิน 999 ที่กำหนด";
$lang['max_pro_reached'] 			= " จำนวนเกินที่กำหนด โปรดเพิ่มการชำระและเปิดใบเสร็จใหม่สำหรับสินค้ารายการถัดไป";
$lang['code_error'] 				= "คำร้องขอล้มเหลว ลองตรวจสอบรหัสอีกครั้ง";
$lang['x_total'] 					= " โปรดเพิ่มสินค้าก่อนชำระสินค้า";
$lang['paid_l_t_payable'] 			= "จำนวนชำระน้อยกว่าจำนวนที่ต้องจ่าย";
$lang['suspended_sales'] 			= "ยกเลิกรายการขาย";
$lang['sale_suspended'] 			= "รายการขายถูกยกเลิกแล้ว";
$lang['sale_suspend_failed'] 		= "ล้มเหลวในการยกเลิกรายการขาย โปรดลองใหม่อีกครั้ง";
$lang['add_to_pos'] 				= "เพิ่มรายการขายนี้ในหน้าระบบบริการ ณ จุดขาย";
$lang['delete_suspended_sale'] 		= "ลบรายการยกเลิกการขาย";
$lang['save'] 						= "บันทึก";
$lang['discount_request_failed']	= "คำร้องขอล้มเหลว พบปัญหาเรื่องส่วนลด";
$lang['saving'] 					= "กำลังบันทึก...";
$lang['paid_by'] 					= "ชำระโดย";
$lang['paid'] 						= "ชำระแล้ว";
$lang['ajax_error'] 				= "คำร้องขอล้มเหลว โปรดลองอีกครั้ง";
$lang['close'] 						= "ปิด";
$lang['finalize_sale'] 				= "ทำรายการขายสมบูรณ์";
$lang['cash_sale'] 					= "ชำระด้วยเงินสด";
$lang['cc_sale'] 					= "ชำระด้วยบัตรเครดิต";
$lang['ch_sale'] 					= "ชำระด้วยเช็ค";
$lang['sure_to_suspend_sale'] 		= "ต้องการลบรายการขาย?";
$lang['leave_alert']				= "ข้อมูลการขายจะหายไป กดตกลงเพื่อออกหรือกดยกเลิกเพื่ออยู่หน้านี้ต่อไป";
$lang['sure_to_cancel_sale'] 		= "ต้องการยกเลิกรายการขาย?";
$lang['sure_to_submit_sale'] 		= "ต้องการทำรายการขาย?";
$lang['alert_x_sale'] 				= " ต้องการลบรายการขายที่ถูกยกเลิก?";
$lang['suspended_sale_deleted'] 	= "รายการขายที่ถูกยกเลิกถูกลบแล้ว";
$lang['item_count_error'] 			= "พบปัญหาขระนับจำนวนรายการสินค้า โปรดลองใหม่อีกครั้ง";
$lang['x_suspend'] 					= "โปรดเพิ่มสินค้าก่อนยกเลิกรายการขาย";
$lang['x_cancel'] 					= "ไม่มีสินค้า";
$lang['yes'] 						= "ใช่";
$lang['no1'] 						= "ไม่";
$lang['suspend'] 					= "ยกเลิก";
$lang['order_list'] 				= "รายการสั่งซื้อ";
$lang['print'] 						= "พิมพ์";
$lang['cf_display_on_bill'] 		= "หัวเรื่องกำหนดเองที่จะแสดงในในเสร็จรับเงินของระบบบริการ ณ จุดขาย";
$lang['cf_title1'] 						= "หัวเรื่องกำหนดเอง 1 ชื่อเรื่อง";
$lang['cf_value1'] 						= "หัวเรื่องกำหนดเอง 1 ค่า";
$lang['cf_title2'] 						= "หัวเรื่องกำหนดเอง 2 ชื่อเรื่อง";
$lang['cf_value2'] 						= "หัวเรื่องกำหนดเอง 2 ค่า";