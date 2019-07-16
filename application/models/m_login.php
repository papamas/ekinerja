<?php

class M_login extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function validasi($user, $pass) {
        $this->db->from('dd_user');
        $this->db->where('username', $user);
        $this->db->where('password', base64_encode($pass));
        $validasi = $this->db->count_all_results();
        return $validasi;
    }

    public function get_data($user, $pass) {
        $this->db->from('dd_user a');
        $this->db->where('username', $user);
        $this->db->where('password', base64_encode($pass));
        $this->db->join('tbljabatan b', 'b.kodejab=a.jabatan', 'LEFT');
        $this->db->join('tblstruktural c', 'a.unit_kerja=c.kodeUnit', 'LEFT');
        return $this->db->get()->row_array();
    }

    public function update_log($user, $pass) {
        $login_terakhir = date('Y-m-d H:i:s');
        $data = array(
            'login_terakhir' => $login_terakhir,
            'ip_address' => $this->input->ip_address()
        );
        $this->db->where('username', $user);
        $this->db->where('password', base64_encode($pass));
        $update = $this->db->update('dd_user', $data);
        return $update;
    }

}
