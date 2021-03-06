<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
* 
*/
class provedores extends CI_Model 
{


	function get_master($id=''){//sacar tu id de provedor

		$this->db->select('*');
		$this->db->from('provedores');
		$this->db->like('Correo',$id);

		$query=$this->db->get();

		if ($query->num_rows()) {
			
			return $query->result_array();
		}

		else{
            return false;
		}



	}



	function get_users($id=''){//sacar tu id de provedor

		$this->db->select('*');
		$this->db->from('users');
		$this->db->like('Correo',$id);

		$query=$this->db->get();

		if ($query->num_rows()) {
			
			return $query->result_array();
		}

		else{
            return false;
		}



	}



	function get_clientes($id=''){//sacar tu id de provedor

		$this->db->select('*');
		$this->db->from('client');
		$this->db->like('Correo',$id);

		$query=$this->db->get();

		if ($query->num_rows()) {
			
			return $query->result_array();
		}

		else{
            return false;
		}



	}



	
	function get_user_id($id=''){//sacar tu id de provedor

		$this->db->select('id');
		$this->db->from('provedores');
		$this->db->like('Correo',$id);

		$query=$this->db->get();

		if ($query->num_rows()) {
			
			return $query->row_array();
		}

		else{
            return false;
		}



	}


	function get_emalil($id=''){

		$this->db->select('Correo');
		$this->db->from('client');
		$this->db->where('id',$id);

		$query=$this->db->get();

		if ($query->num_rows()) {
			
			return $query->row_array();
		}

		else{
            return false;
		}

	}




	function get_factura($id=''){

		$this->db->select('*');
		$this->db->from('movimientos_facturas');
		$this->db->join('movimientos', 'movimientos.id = movimientos_facturas.id_movimiento');
		$this->db->join('client', 'client.id = movimientos_facturas.id_client');
		$this->db->where('id_movimiento',$id);

		$query=$this->db->get();

		if ($query->num_rows()) {
			
			return $query->result_array();
		}

		else{
            return false;
		}

	}



	



	function get_client_id($id){

		$this->db->select('*');
		$this->db->from('client');
		$this->db->join('provedores', 'provedores.id = client.users_id');

		$this->db->where('client.users_id',$id);
		
		



		$query=$this->db->get();

		if ($query->num_rows()) {
			
			return $query->result_array();
		}

		else{
            return false;
		}
	}




	function get_movimientos_id($id){

		$this->db->select('*');
		$this->db->from('movimientos');
		$this->db->join('client', 'client.id =movimientos.id_clients');

		$this->db->where('movimientos.id_clients',$id);
		
		



		$query=$this->db->get();

		if ($query->num_rows()) {
			
			return $query->result_array();
		}

		else{
            return false;
		}
	
	}




}

