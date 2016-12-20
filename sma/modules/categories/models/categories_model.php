<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
| -----------------------------------------------------
| PRODUCT NAME: 	Trip Manager
| -----------------------------------------------------
| AUTHER:			MIAN SALEEM 
| -----------------------------------------------------
| EMAIL:			saleem@tecdiary.com 
| -----------------------------------------------------
| COPYRIGHTS:		RESERVED BY TECDIARY IT SOLUTIONS
| -----------------------------------------------------
| WEBSITE:			http://tecdiary.net
| -----------------------------------------------------
|
| MODULE: 			Categories
| -----------------------------------------------------
| This is categories module's model file.
| -----------------------------------------------------
*/


class Categories_model extends CI_Model
{
	
	
	public function __construct()
	{
		parent::__construct();

	}
	
	public function getAllCategories() 
	{
		$q = $this->db->get("categories");
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getAllSubCategories() 
	{
		$q = $this->db->get("subcategories");
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getSubCategoriesByCategoryID($category_id) 
	{
		$q = $this->db->get_where("subcategories", array('category_id' => $category_id));
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
		
		return FALSE;
	}
	
		
	public function getCategoryByID($id) 
	{

		$q = $this->db->get_where("categories", array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function getSubCategoryByID($id) 
	{

		$q = $this->db->get_where("subcategories", array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function addCategory($name, $code)
	{

		if($this->db->insert("categories", array('code' => $code, 'name' => $name))) {
			return true;
		} else {
			return false;
		}
	}
	
	public function addSubCategory($category, $name, $code)
	{

		if($this->db->insert("subcategories", array('category_id' => $category,'code' => $code, 'name' => $name))) {
			return true;
		} else {
			return false;
		}
	}
	
	public function updateCategory($id, $data = array())
	{
		
		
		// Category data
		$categoryData = array(
		    'code'	     		=> $data['code'],
		    'name'   			=> $data['name'],

		);
		$this->db->where('id', $id);
		if($this->db->update("categories", $categoryData)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function updateSubCategory($id, $data = array())
	{
		
		// Category data
		$categoryData = array(
		    'category_id'	   	=> $data['category'],
			'code'	     		=> $data['code'],
		    'name'   			=> $data['name'],

		);
		$this->db->where('id', $id);
		if($this->db->update("subcategories", $categoryData)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function deleteCategory($id) 
	{
		if($this->db->delete("categories", array('id' => $id))) {
			return true;
		}
	return FALSE;
	}
	
	public function deleteSubCategory($id) 
	{
		if($this->db->delete("subcategories", array('id' => $id))) {
			return true;
		}
	return FALSE;
	}

}

/* End of file calegories_model.php */ 
/* Location: ./sma/modules/categories/models/categories_model.php */
