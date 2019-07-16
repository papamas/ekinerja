<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


require_once APPPATH . "third_party/PHPExcel/PHPExcel/Cell/AdvancedValueBinder.php";

class Excel2 extends PHPExcel_Cell_AdvancedValueBinder {

    public function __construct() {
        parent::__construct();
    }

}

?>