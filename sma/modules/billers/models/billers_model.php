<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
| -----------------------------------------------------
| PRODUCT NAME: 	STOCK MANAGER ADVANCE 
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
| MODULE: 			Billers
| -----------------------------------------------------
| This is homepage module model file.
| -----------------------------------------------------
*/


class Billers_model extends CI_Model
{
	
	
	public function __construct()
	{
		parent::__construct();

	}
	
	public function getAllBillers() 
	{
		$q = $this->db->get('billers');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function billers_count() {
        return $this->db->count_all("billers");
    }

    public function fetch_billers($limit, $start) {
        $this->db->limit($limit, $start);
		$this->db->order_by("id", "desc"); 
        $query = $this->db->get("billers");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
	
	public function getBillerByID($id) 
	{

		$q = $this->db->get_where('billers', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function addBiller($name, $email, $company, $data = array())
	{
		
		
		// Biiler data
		$billerData = array(
		    'name'	     		=> $data['name'],
		    'email'   			=> $data['email'],
		    'company'      		=> $data['company'],
		    'cf1'      			=> $data['cf1'],
			'cf2'      			=> $data['cf2'],
			'cf3'      			=> $data['cf3'],
			'cf4'      			=> $data['cf4'],
			'cf5'      			=> $data['cf5'],
			'cf6'      			=> $data['cf6'],
		    'address' 			=> $data['address'],
			'city'	     		=> $data['city'],
		    'state'   			=> $data['state'],
		    'postal_code'   	=> $data['postal_code'],
		    'country' 			=> $data['country'],
			'phone'	     		=> $data['phone'],
		    'logo'   			=> $data['logo'],
		    'invoice_footer' 	=> $data['invoice_footer']
		);

		if($this->db->insert('billers', $billerData)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function updateBiller($id, $data = array())
	{
		
		
		// Biiler data
		$billerData = array(
		    'name'	     		=> $data['name'],
		    'email'   			=> $data['email'],
		    'company'      		=> $data['company'],
		    'cf1'      			=> $data['cf1'],
			'cf2'      			=> $data['cf2'],
			'cf3'      			=> $data['cf3'],
			'cf4'      			=> $data['cf4'],
			'cf5'      			=> $data['cf5'],
			'cf6'      			=> $data['cf6'],
		    'address' 			=> $data['address'],
			'city'	     		=> $data['city'],
		    'state'   			=> $data['state'],
		    'postal_code'   	=> $data['postal_code'],
		    'country' 			=> $data['country'],
			'phone'	     		=> $data['phone'],
		    'logo'   			=> $data['logo'],
		    'invoice_footer' 	=> $data['invoice_footer']
		);
		$this->db->where('id', $id);
		if($this->db->update('billers', $billerData)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function deleteBiller($id) 
	{
		if($this->db->delete('billers', array('id' => $id))) {
			return true;
		}
	return FALSE;
	}
	
	public function getLogoList() {

		$this->load->helper('directory');

		$dirname= "assets/uploads/logos";
		$ext = array("jpg", "png", "jpeg", "gif");
		$files = array();
		if($handle = opendir($dirname)) {
			while(false !== ($file = readdir($handle)))
			for($i=0;$i<sizeof($ext);$i++)
			if(stristr($file, ".".$ext[$i])) //NOT case sensitive: OK with JpeG, JPG, ecc.
			$files[] = $file;
			closedir($handle);
		}
		sort($files);
		return $files;
	}

}

/* End of file biller_model.php */ 
/* Location: ./sma/modules/billers/models/billers_model.php */