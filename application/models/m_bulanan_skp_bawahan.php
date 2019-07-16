<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_bulanan_skp_bawahan extends CI_Model {

    var $table = 'opmt_bulanan_skp a';
    var $column_order = array(null, 'tahun', 'bulan'); //set column field database for datatable orderable
    var $column_search = array('tahun', 'bulan'); //set column field database for datatable searchable 
    var $order = array('id_opmt_bulanan_skp' => 'asc'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($nama, $tahun, $bulan) {
        $this->db->from($this->table);
        $id_user = $this->session->userdata('id_user');
        $this->db->join('dd_user b', "b.id_dd_user=a.id_dd_user AND (b.atasan_langsung={$id_user} OR b.atasan_2={$id_user} OR b.atasan_3={$id_user})", 'INNER');
        if (!empty($tahun)) {
            $this->db->where('tahun', $tahun);
        }
        if ($bulan !== 'all') {
            $this->db->where('bulan', $bulan);
        } if (!empty($nama)) {
            $this->db->like('nama', $nama);
        }
        $i = 0;

        foreach ($this->column_search as $item) { // loop column 
               if (!empty($_POST['search']['value'])) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($nama, $tahun, $bulan) {
        $this->_get_datatables_query($nama, $tahun, $bulan);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($nama, $tahun, $bulan) {
        $this->_get_datatables_query($nama, $tahun, $bulan);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($nama, $tahun, $bulan) {
        if (!empty($tahun)) {
            $this->db->where('tahun', $tahun);
        }
        if ($bulan !== 'all') {
            $this->db->where('bulan', $bulan);
        } if (!empty($nama)) {
            $this->db->like('nama', $nama);
        }
        $id_user = $this->session->userdata('id_user');
        $this->db->from($this->table);
        $this->db->join('dd_user b', "b.id_dd_user=a.id_dd_user AND (b.atasan_langsung={$id_user} OR b.atasan_2={$id_user} OR b.atasan_3={$id_user})", 'INNER');
        return $this->db->count_all_results();
    }

}
