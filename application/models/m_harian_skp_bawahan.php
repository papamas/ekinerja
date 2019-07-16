<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_harian_skp_bawahan extends CI_Model {

    var $table = 'opmt_realisasi_harian_skp a';
    var $column_order = array(null, 'year(a.tanggal)', 'month(a.tanggal)'); //set column field database for datatable orderable
    var $column_search = array('year(a.tanggal)', 'month(a.tanggal)'); //set column field database for datatable searchable 
    var $order = array('id_opmt_realisasi_harian_skp' => 'asc'); // default order 

    public function __construct() {
        parent::__construct();
        $this->db->_protect_identifiers = false;
        $this->load->database();
    }

    private function _get_datatables_query($bulan, $tahun, $nama) {
        $id_user = $this->session->userdata('id_user');
        if (!empty($nama)) {
            $this->db->like("c.nama", $nama);
        }
        if ($bulan !== "all") {
            $this->db->where("month(a.tanggal)", $bulan);
        }
        if ($tahun !== "all") {
            $this->db->where("year(a.tanggal)", $tahun);
        }
        $this->db->from($this->table);
        $this->db->join('opmt_target_bulanan_skp b', 'a.id_opmt_target_bulanan_skp=b.id_opmt_target_bulanan_skp', 'LEFT');
        $this->db->join('dd_user c', "a.id_dd_user=c.id_dd_user AND (c.atasan_langsung={$id_user} OR c.atasan_2={$id_user} OR c.atasan_3={$id_user})", 'INNER');
        $this->db->join('opmt_turunan_skp d', 'd.id_opmt_turunan_skp=a.id_opmt_target_bulanan_skp', 'LEFT');
        $this->db->join('dd_kuantitas e', 'e.id_dd_kuantitas=a.satuan_kuantitas', 'LEFT');
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

    function get_datatables($bulan, $tahun, $nama) {
        $this->_get_datatables_query($bulan, $tahun, $nama);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($bulan, $tahun, $nama) {
        $this->_get_datatables_query($bulan, $tahun, $nama);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($bulan, $tahun, $nama) {
        $id_user = $this->session->userdata('id_user');
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        if (!empty($nama)) {
            $this->db->like("c.nama", $nama);
        }
        if ($bulan !== "all") {
            $this->db->where("month(a.tanggal)", $bulan);
        }
        if ($tahun !== "all") {
            $this->db->where("month(a.tanggal)", $tahun);
        }
        $this->db->from($this->table);
        $this->db->join('opmt_target_bulanan_skp b', 'a.id_opmt_target_bulanan_skp=b.id_opmt_target_bulanan_skp', 'LEFT');
        $this->db->join('dd_user c', "a.id_dd_user=c.id_dd_user AND (c.atasan_langsung={$id_user} OR c.atasan_2={$id_user} OR c.atasan_3={$id_user})", 'INNER');
        $this->db->join('opmt_turunan_skp d', 'd.id_opmt_turunan_skp=a.id_opmt_target_bulanan_skp', 'LEFT');
        $this->db->join('dd_kuantitas e', 'e.id_dd_kuantitas=a.satuan_kuantitas', 'LEFT');
        return $this->db->count_all_results();
    }

}
