-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jun 10, 2015 at 03:33 PM
-- Server version: 5.5.38
-- PHP Version: 5.4.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `easy_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `installer`
--

CREATE TABLE `installer` (
  `id` int(1) NOT NULL,
  `installer_flag` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `installer`
--

INSERT INTO `installer` (`id`, `installer_flag`) VALUES
  (1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attribute`
--

CREATE TABLE `tbl_attribute` (
  `attribute_id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `attribute_name` varchar(100) NOT NULL,
  `attribute_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attribute_set`
--

CREATE TABLE `tbl_attribute_set` (
  `attribute_set_id` int(11) NOT NULL,
  `attribute_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_business_profile`
--

CREATE TABLE `tbl_business_profile` (
  `business_profile_id` int(2) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `logo` varchar(150) DEFAULT NULL,
  `full_path` varchar(150) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(100) NOT NULL,
  `currency` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_campaign`
--

CREATE TABLE `tbl_campaign` (
  `campaign_id` int(11) NOT NULL,
  `campaign_name` varchar(128) NOT NULL,
  `subject` varchar(128) NOT NULL,
  `email_body` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_campaign_result`
--

CREATE TABLE `tbl_campaign_result` (
  `campaign_result_id` int(11) NOT NULL,
  `campaign_id` int(10) NOT NULL,
  `campaign_name` varchar(128) NOT NULL,
  `subject` varchar(128) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `send_by` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` int(5) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `created_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `customer_id` int(11) NOT NULL,
  `customer_code` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `discount` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_damage_product`
--

CREATE TABLE `tbl_damage_product` (
  `damage_product_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` int(11) NOT NULL,
  `product_name` varchar(127) NOT NULL,
  `category` varchar(128) NOT NULL,
  `qty` int(5) NOT NULL,
  `note` text NOT NULL,
  `decrease` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0= no; 1= yes',
  `date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inventory`
--

CREATE TABLE `tbl_inventory` (
  `inventory_id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `product_quantity` int(5) NOT NULL,
  `notify_quantity` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice`
--

CREATE TABLE `tbl_invoice` (
  `invoice_id` int(5) NOT NULL,
  `invoice_no` int(11) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `invoice_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `menu_id` int(11) NOT NULL,
  `label` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `parent` int(5) NOT NULL,
  `sort` int(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_menu`
--

INSERT INTO `tbl_menu` (`menu_id`, `label`, `link`, `icon`, `parent`, `sort`) VALUES
  (1, 'Dashboard', 'admin/dashboard', 'fa fa-dashboard', 0, 1),
  (2, 'Settings', '#', 'fa fa-cogs', 0, 15),
  (3, 'Business Profile', 'admin/settings/business_profile', 'glyphicon glyphicon-briefcase', 2, 1),
  (4, 'Employee Management', '#', 'entypo-users', 0, 20),
  (5, 'Employee List', 'admin/employee/employee_list', 'fa fa-users', 4, 1),
  (6, 'Add Employee', 'admin/employee/add_employee', 'entypo-user-add', 4, 2),
  (7, 'Product', '#', 'glyphicon glyphicon-th-large', 0, 5),
  (8, 'Category', '#', 'glyphicon glyphicon-indent-left', 7, 4),
  (9, 'Product Category', 'admin/product/category', 'glyphicon glyphicon-tag', 8, 1),
  (10, 'Sub Category', 'admin/product/subcategory', 'glyphicon glyphicon-tags', 8, 2),
  (13, 'Add Product', 'admin/product/add_product', 'glyphicon glyphicon-plus', 7, 1),
  (14, 'Manage Product', 'admin/product/manage_product', 'glyphicon glyphicon-th-list', 7, 2),
  (17, 'Manage Tax Rules', 'admin/settings/tax', 'glyphicon glyphicon-credit-card', 2, 2),
  (18, 'Manage Purchase', '#', 'fa fa-truck', 0, 3),
  (19, 'Supplier', '#', 'glyphicon glyphicon-gift', 18, 1),
  (20, 'Add Supplier', 'admin/purchase/add_supplier', 'glyphicon glyphicon-plus', 19, 1),
  (21, 'Manage Supplier', 'admin/purchase/manage_supplier', 'glyphicon glyphicon-briefcase', 19, 2),
  (22, 'Purchase', '#', 'glyphicon glyphicon-credit-card', 18, 2),
  (23, 'New Purchase', 'admin/purchase/new_purchase', 'glyphicon glyphicon-shopping-cart', 22, 1),
  (24, 'Purchase History', 'admin/purchase/purchase_list', 'glyphicon glyphicon-th-list', 22, 2),
  (25, 'Customer', '', 'glyphicon glyphicon-user', 0, 7),
  (26, 'Add Customer', 'admin/customer/add_customer', 'glyphicon glyphicon-plus', 25, 1),
  (27, 'Manage Customer', 'admin/customer/manage_customer', 'glyphicon glyphicon-th-list', 25, 2),
  (28, 'Damage Product', 'admin/product/damage_product', 'glyphicon glyphicon-trash', 7, 3),
  (29, 'Barcode Print', 'admin/product/print_barcode', 'glyphicon glyphicon-barcode', 7, 3),
  (30, 'Order Process', '#', 'glyphicon glyphicon-shopping-cart', 0, 6),
  (31, 'New Order', 'admin/order/new_order', 'fa fa-cart-plus', 30, 1),
  (32, 'Manage Order', 'admin/order/manage_order', 'glyphicon glyphicon-th-list', 30, 2),
  (33, 'Manage Invoice', 'admin/order/manage_invoice', 'glyphicon glyphicon-list-alt', 30, 3),
  (34, 'Report', 'admin/report', 'glyphicon glyphicon-signal', 0, 8),
  (35, 'Sales Report', 'admin/report/sales_report', 'fa fa-bar-chart', 34, 1),
  (36, 'Purchase Report', 'admin/report/purchase_report', 'fa fa-line-chart', 34, 2),
  (37, 'Email Campaign', '#', 'glyphicon glyphicon-send', 0, 8),
  (38, 'New campaign', 'admin/campaign/new_campaign', 'glyphicon glyphicon-envelope', 37, 1),
  (39, 'Manage Campaign', 'admin/campaign/manage_campaign', 'glyphicon glyphicon-th-list', 37, 2),
  (40, 'Camaign Result', 'admin/campaign/campaign_result', 'glyphicon glyphicon-bullhorn', 37, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `order_id` int(11) NOT NULL,
  `order_no` int(10) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(10) NOT NULL,
  `customer_name` varchar(128) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_phone` varchar(100) NOT NULL,
  `customer_address` text NOT NULL,
  `shipping_address` text NOT NULL,
  `sub_total` double NOT NULL,
  `discount` double NOT NULL,
  `discount_amount` double NOT NULL,
  `total_tax` double NOT NULL,
  `grand_total` double NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `payment_ref` varchar(120) NOT NULL,
  `order_status` int(2) NOT NULL DEFAULT '0' COMMENT '0= pending; 1= cancel; 2=confirm',
  `note` text NOT NULL,
  `sales_person` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_details`
--

CREATE TABLE `tbl_order_details` (
  `order_details_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `product_code` int(10) NOT NULL,
  `product_name` varchar(128) NOT NULL,
  `product_quantity` int(5) NOT NULL,
  `buying_price` double NOT NULL,
  `selling_price` double NOT NULL,
  `product_tax` double NOT NULL,
  `sub_total` double NOT NULL,
  `price_option` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `product_id` int(11) NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_note` text NOT NULL,
  `status` tinyint(2) DEFAULT '1' COMMENT '0=Inactive,1=Active',
  `subcategory_id` int(5) NOT NULL,
  `barcode_path` varchar(300) NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `tax_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_image`
--

CREATE TABLE `tbl_product_image` (
  `product_image_id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `image_path` varchar(300) NOT NULL,
  `filename` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_price`
--

CREATE TABLE `tbl_product_price` (
  `product_price_id` int(11) NOT NULL,
  `product_id` int(5) NOT NULL,
  `buying_price` double NOT NULL,
  `selling_price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_tag`
--

CREATE TABLE `tbl_product_tag` (
  `product_tag_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `tag` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase`
--

CREATE TABLE `tbl_purchase` (
  `purchase_id` int(11) NOT NULL,
  `purchase_order_number` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(128) NOT NULL,
  `grand_total` int(5) NOT NULL,
  `purchase_ref` varchar(128) NOT NULL,
  `payment_method` varchar(128) NOT NULL,
  `payment_ref` varchar(128) NOT NULL,
  `purchase_by` varchar(100) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_product`
--

CREATE TABLE `tbl_purchase_product` (
  `purchase_product_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `product_name` varchar(128) NOT NULL,
  `qty` int(5) NOT NULL,
  `unit_price` int(5) NOT NULL,
  `sub_total` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_special_offer`
--

CREATE TABLE `tbl_special_offer` (
  `special_offer_id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `offer_price` double DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subcategory`
--

CREATE TABLE `tbl_subcategory` (
  `subcategory_id` int(5) NOT NULL,
  `category_id` int(5) NOT NULL,
  `subcategory_name` varchar(100) NOT NULL,
  `created_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `supplier_id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tag`
--

CREATE TABLE `tbl_tag` (
  `tag_id` int(11) NOT NULL,
  `tag` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tax`
--

CREATE TABLE `tbl_tax` (
  `tax_id` int(11) NOT NULL,
  `tax_title` varchar(100) NOT NULL,
  `tax_rate` double NOT NULL,
  `tax_type` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tier_price`
--

CREATE TABLE `tbl_tier_price` (
  `tier_price_id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `tier_price` double NOT NULL,
  `quantity_above` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(5) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `filename` varchar(128) NOT NULL,
  `image_path` varchar(128) NOT NULL,
  `flag` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_role`
--

CREATE TABLE `tbl_user_role` (
  `user_role_id` int(11) NOT NULL,
  `employee_login_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
ADD PRIMARY KEY (`session_id`), ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `tbl_attribute`
--
ALTER TABLE `tbl_attribute`
ADD PRIMARY KEY (`attribute_id`);

--
-- Indexes for table `tbl_attribute_set`
--
ALTER TABLE `tbl_attribute_set`
ADD PRIMARY KEY (`attribute_set_id`);

--
-- Indexes for table `tbl_business_profile`
--
ALTER TABLE `tbl_business_profile`
ADD PRIMARY KEY (`business_profile_id`);

--
-- Indexes for table `tbl_campaign`
--
ALTER TABLE `tbl_campaign`
ADD PRIMARY KEY (`campaign_id`);

--
-- Indexes for table `tbl_campaign_result`
--
ALTER TABLE `tbl_campaign_result`
ADD PRIMARY KEY (`campaign_result_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `tbl_damage_product`
--
ALTER TABLE `tbl_damage_product`
ADD PRIMARY KEY (`damage_product_id`);

--
-- Indexes for table `tbl_inventory`
--
ALTER TABLE `tbl_inventory`
ADD PRIMARY KEY (`inventory_id`);

--
-- Indexes for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `tbl_menu`
--
ALTER TABLE `tbl_menu`
ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
ADD PRIMARY KEY (`order_details_id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `tbl_product_image`
--
ALTER TABLE `tbl_product_image`
ADD PRIMARY KEY (`product_image_id`);

--
-- Indexes for table `tbl_product_price`
--
ALTER TABLE `tbl_product_price`
ADD PRIMARY KEY (`product_price_id`);

--
-- Indexes for table `tbl_product_tag`
--
ALTER TABLE `tbl_product_tag`
ADD PRIMARY KEY (`product_tag_id`);

--
-- Indexes for table `tbl_purchase`
--
ALTER TABLE `tbl_purchase`
ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `tbl_purchase_product`
--
ALTER TABLE `tbl_purchase_product`
ADD PRIMARY KEY (`purchase_product_id`);

--
-- Indexes for table `tbl_special_offer`
--
ALTER TABLE `tbl_special_offer`
ADD PRIMARY KEY (`special_offer_id`);

--
-- Indexes for table `tbl_subcategory`
--
ALTER TABLE `tbl_subcategory`
ADD PRIMARY KEY (`subcategory_id`);

--
-- Indexes for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `tbl_tag`
--
ALTER TABLE `tbl_tag`
ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `tbl_tax`
--
ALTER TABLE `tbl_tax`
ADD PRIMARY KEY (`tax_id`);

--
-- Indexes for table `tbl_tier_price`
--
ALTER TABLE `tbl_tier_price`
ADD PRIMARY KEY (`tier_price_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_user_role`
--
ALTER TABLE `tbl_user_role`
ADD PRIMARY KEY (`user_role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_attribute`
--
ALTER TABLE `tbl_attribute`
MODIFY `attribute_id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_attribute_set`
--
ALTER TABLE `tbl_attribute_set`
MODIFY `attribute_set_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_business_profile`
--
ALTER TABLE `tbl_business_profile`
MODIFY `business_profile_id` int(2) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_campaign`
--
ALTER TABLE `tbl_campaign`
MODIFY `campaign_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_campaign_result`
--
ALTER TABLE `tbl_campaign_result`
MODIFY `campaign_result_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
MODIFY `category_id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_damage_product`
--
ALTER TABLE `tbl_damage_product`
MODIFY `damage_product_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_inventory`
--
ALTER TABLE `tbl_inventory`
MODIFY `inventory_id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
MODIFY `invoice_id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_menu`
--
ALTER TABLE `tbl_menu`
MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
MODIFY `order_details_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_product_image`
--
ALTER TABLE `tbl_product_image`
MODIFY `product_image_id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_product_price`
--
ALTER TABLE `tbl_product_price`
MODIFY `product_price_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_product_tag`
--
ALTER TABLE `tbl_product_tag`
MODIFY `product_tag_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_purchase`
--
ALTER TABLE `tbl_purchase`
MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_purchase_product`
--
ALTER TABLE `tbl_purchase_product`
MODIFY `purchase_product_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_special_offer`
--
ALTER TABLE `tbl_special_offer`
MODIFY `special_offer_id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_subcategory`
--
ALTER TABLE `tbl_subcategory`
MODIFY `subcategory_id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_tag`
--
ALTER TABLE `tbl_tag`
MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_tax`
--
ALTER TABLE `tbl_tax`
MODIFY `tax_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_tier_price`
--
ALTER TABLE `tbl_tier_price`
MODIFY `tier_price_id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_user_role`
--
ALTER TABLE `tbl_user_role`
MODIFY `user_role_id` int(11) NOT NULL AUTO_INCREMENT;