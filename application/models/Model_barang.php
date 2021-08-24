<?php

class Model_barang extends CI_Model {
	public function tampil_data()
	{
		return $this->db->get('tbl_barang')->result_array();
	}

	public function tambah_barang($data,$table)
	{
		$this->db->insert($table,$data);
	}

	public function edit_barang($where,$table){
		return $this->db->get_where($table,$where);
	}
	
	public function update_data($where,$data,$table)
	{
		$this->db->where($where);
		$this->db->update($table,$data);
	}

	public function detail_barang($id_brg)
	{
		return $this->db->get_where('tbl_barang',['id_barang' => $id_brg])->row_array();
	}

	public function getBarang($limit,$start, $keyword=null) {
		if ($keyword) {
			$this->db->like('name',$keyword);
			$this->db->or_like('desc',$keyword);
		}
		return $this->db->get('tbl_barang', $limit,$start)->result_array();
	}

	public function getPermohonan()
	{
		$query = "SELECT `user` .*, `tbl_pinjam` .*, `tbl_barang`.`name`, `tbl_barang`.`stock`
				FROM `user` JOIN `tbl_pinjam`
				ON `user`.`id` = `tbl_pinjam`.`id_user` 
				JOIN `tbl_barang`
				ON `tbl_barang`.`id_barang` = `tbl_pinjam`.`id_brg`
				WHERE `tbl_pinjam`.`status` = 0
		";
		return $this->db->query($query)->result_array();
	}

	//History User
	public function tampil_history()
	{
		$user= $this->session->userdata('email');

		$query = "SELECT `user` .*, `tbl_pinjam` .*, `tbl_barang`.`name`
				FROM `user` JOIN `tbl_pinjam`
				ON `user`.`id` = `tbl_pinjam`.`id_user` 
				JOIN `tbl_barang`
				ON `tbl_barang`.`id_barang` = `tbl_pinjam`.`id_brg`
				WHERE `user`.`email` = '$user'
		";

		return $this->db->query($query)->result_array();	
	}

	public function barang_kembali($id)
	{
		$query = "SELECT `user` .*, `tbl_pinjam` .*, `tbl_barang`.*
				FROM `user` JOIN `tbl_pinjam`
				ON `user`.`id` = `tbl_pinjam`.`id_user` 
				JOIN `tbl_barang`
				ON `tbl_barang`.`id_barang` = `tbl_pinjam`.`id_brg`
				WHERE `tbl_pinjam`.`id_pinjam` = '$id'
		";
		
		return $this->db->query($query)->row_array();	
		
	}

	public function getPengembalian()
	{
		$query = "SELECT `user` .*, `tbl_pinjam` .*, `tbl_barang`.`name`, `tbl_barang`.`stock`
				FROM `user` JOIN `tbl_pinjam`
				ON `user`.`id` = `tbl_pinjam`.`id_user` 
				JOIN `tbl_barang`
				ON `tbl_barang`.`id_barang` = `tbl_pinjam`.`id_brg`
				WHERE `tbl_pinjam`.`status` = 3
		";
		return $this->db->query($query)->result_array();
	}

	//History Admin
	public function getHistory()
	{
		$query = "SELECT `user` .*, `tbl_pinjam` .*, `tbl_barang`.*
				FROM `user` JOIN `tbl_pinjam`
				ON `user`.`id` = `tbl_pinjam`.`id_user` 
				JOIN `tbl_barang`
				ON `tbl_barang`.`id_barang` = `tbl_pinjam`.`id_brg`
				WHERE `tbl_pinjam`.`status` = 1 OR `tbl_pinjam`.`status` = 4

		";

		return $this->db->query($query)->result_array();	
	}

	public function getJumlahBarang()
	{
		return $this->db->get('tbl_barang')->num_rows();

	}

	public function getJumlahPermohonan()
	{
		$query = "SELECT `user` .*, `tbl_pinjam` .*, `tbl_barang`.`name`, `tbl_barang`.`stock`
				FROM `user` JOIN `tbl_pinjam`
				ON `user`.`id` = `tbl_pinjam`.`id_user` 
				JOIN `tbl_barang`
				ON `tbl_barang`.`id_barang` = `tbl_pinjam`.`id_brg`
				WHERE `tbl_pinjam`.`status` = 0
		";
		return $this->db->query($query)->num_rows();
	}

	public function getJumlahPengembalian()
	{
		$query = "SELECT `user` .*, `tbl_pinjam` .*, `tbl_barang`.`name`, `tbl_barang`.`stock`
				FROM `user` JOIN `tbl_pinjam`
				ON `user`.`id` = `tbl_pinjam`.`id_user` 
				JOIN `tbl_barang`
				ON `tbl_barang`.`id_barang` = `tbl_pinjam`.`id_brg`
				WHERE `tbl_pinjam`.`status` = 3
		";
		return $this->db->query($query)->num_rows();

	}

	public function getJumlahUser()
	{
		$query = "SELECT * FROM `user` WHERE `role_id` = 2
		";
		return $this->db->query($query)->num_rows();
	}
}
?>