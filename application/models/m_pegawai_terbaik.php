<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_pegawai_terbaik extends CI_Model {

    var $table = 'opmt_bulanan_skp a';
    var $column_order = array('id','nama','nip','nilai_skp'); //set column field database for datatable orderable
    var $column_search = array('tahun', 'bulan'); //set column field database for datatable searchable 
    var $order = array('a.nilai_skp' => 'desc'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->db->_protect_identifiers = false;
    }

    private function _get_datatables_query($bulan, $tahun) {
        $this->db->from($this->table);
        $this->db->select("a.id_opmt_bulanan_skp,a.pegawai_terbaik,b.nama,b.nip,a.nilai_skp,c.ttl,coalesce(d.ttl,0) ttl_tambahan,coalesce(e.ttl,0) ttl_prod ,coalesce(f.ttl,0) ttl_disposisi");
        $this->db->join('dd_user b', 'a.id_dd_user=b.id_dd_user', 'LEFT');
        $this->db->join("(SELECT id_dd_user, count(*)ttl from opmt_tugas_tambahan WHERE year(tanggal)={$tahun} AND month(tanggal)={$bulan}) d", 'a.id_dd_user=d.id_dd_user', 'LEFT');
        $this->db->join("(SELECT id_dd_user, count(*)ttl from opmt_produktivitas_skp WHERE year(tanggal)={$tahun} AND month(tanggal)={$bulan}) e", 'a.id_dd_user=e.id_dd_user', 'LEFT');
        $this->db->join("(SELECT id_dd_user, count(*)ttl from opmt_disposisi where status_disposisi_atasan=1 AND year(tanggal_disposisi)={$tahun} AND month(tanggal_disposisi)={$bulan}) f", "a.id_dd_user=f.id_dd_user", 'LEFT');
        $this->db->join('(SELECT a.id_dd_user, COUNT(*) ttl
FROM opmt_realisasi_harian_skp a
LEFT JOIN (
SELECT a.id_opmt_target_bulanan_skp AS id,b.kegiatan_tahunan AS kegiatan_bulanan,0 AS ket
FROM opmt_target_bulanan_skp a
INNER JOIN opmt_target_skp b ON a.id_opmt_target_skp=b.id_opmt_target_skp UNION ALL
SELECT id_opmt_turunan_skp AS id,kegiatan_turunan,1 AS ket
FROM opmt_turunan_skp d
INNER JOIN opmt_target_bulanan_skp e ON d.id_opmt_target_bulanan_skp=e.id_opmt_target_bulanan_skp
INNER JOIN opmt_target_skp f ON e.id_opmt_target_skp=f.id_opmt_target_skp
INNER JOIN opmt_tahunan_skp g ON g.id_opmt_tahunan_skp=f.id_opmt_tahunan_skp
) b ON a.turunan=b.ket AND b.id=a.id_opmt_target_bulanan_skp
GROUP BY a.id_dd_user) c', 'c.id_dd_user=a.id_dd_user', 'LEFT');
        $this->db->where("a.bulan", $bulan);
        $this->db->where("a.tahun", $tahun);
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
		    //var_dump($_POST['order']);
		
			
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($bulan, $tahun) {
        $this->_get_datatables_query($bulan, $tahun);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($bulan, $tahun) {
        $this->_get_datatables_query($bulan, $tahun);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($bulan, $tahun) {
        $id_user = $this->session->userdata('id_user');
        $this->db->from($this->table);
        $this->db->join('dd_user b', 'a.id_dd_user=b.id_dd_user', 'LEFT');
        $this->db->join("(SELECT id_dd_user, count(*)ttl from opmt_tugas_tambahan WHERE year(tanggal)={$tahun} AND month(tanggal)={$bulan}) d", 'a.id_dd_user=d.id_dd_user', 'LEFT');
        $this->db->join("(SELECT id_dd_user, count(*)ttl from opmt_produktivitas_skp WHERE year(tanggal)={$tahun} AND month(tanggal)={$bulan}) e", 'a.id_dd_user=e.id_dd_user', 'LEFT');
        $this->db->join("(SELECT id_dd_user, count(*)ttl from opmt_disposisi where status_disposisi_atasan=1 AND year(tanggal_disposisi)={$tahun} AND month(tanggal_disposisi)={$bulan}) f", "a.id_dd_user=f.id_dd_user", 'LEFT');
        $this->db->join('(SELECT a.id_dd_user, COUNT(*) ttl
FROM opmt_realisasi_harian_skp a
LEFT JOIN (
SELECT a.id_opmt_target_bulanan_skp AS id,b.kegiatan_tahunan AS kegiatan_bulanan,0 AS ket
FROM opmt_target_bulanan_skp a
INNER JOIN opmt_target_skp b ON a.id_opmt_target_skp=b.id_opmt_target_skp UNION ALL
SELECT id_opmt_turunan_skp AS id,kegiatan_turunan,1 AS ket
FROM opmt_turunan_skp d
INNER JOIN opmt_target_bulanan_skp e ON d.id_opmt_target_bulanan_skp=e.id_opmt_target_bulanan_skp
INNER JOIN opmt_target_skp f ON e.id_opmt_target_skp=f.id_opmt_target_skp
INNER JOIN opmt_tahunan_skp g ON g.id_opmt_tahunan_skp=f.id_opmt_tahunan_skp
) b ON a.turunan=b.ket AND b.id=a.id_opmt_target_bulanan_skp
GROUP BY a.id_dd_user) c', 'c.id_dd_user=a.id_dd_user', 'LEFT');
        $this->db->where("a.bulan", $bulan);
        $this->db->where("a.tahun", $tahun);
        return $this->db->count_all_results();
    }

}
