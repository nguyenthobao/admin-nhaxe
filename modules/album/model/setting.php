<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

/**
 * setting album model
 */
class setting extends Album {
    /*
    public $title;
    public $description;
    public $meta_title;
    public $meta_keywords;
    public $meta_description;
    public $display_sort;
    public $display_number;
    public $display_type;
    */
    public $value_string;
    
    public function homeSetting()
    {
     $data = array(
     'idw'          => $this->idw,
     'key'          => 'home_config',
     'value_string' => $this->value_string
     ); 
     $this->objTable = new Model($this->getLangAndID['lang'].'_config');  
     $this->objTable->where('idw', $this->idw);
     $this->objTable->where('`key`', 'home_config');
     $exist = $this->objTable->num_rows(); 
     if (!empty($exist)) {
        $this->objTable->where('idw', $this->idw);
        $this->objTable->where('`key`', $data['key']);
        $result = $this->objTable->update($data);
     }else{
        $result = $this->objTable->insert($data);
     }
     if ($result) {
        $return['status'] = true;
     }else{
        $return['status'] = false;
        $return['error'] = $this->objTable->getLastError();
     }
     return $return;
     }
    
     public function getSetting()
     {
        $this->objTable = new Model($this->getLangAndID['lang'].'_config');
        $this->objTable->where('idw', $this->idw);
        $this->objTable->where('`key`', 'home_config');
        $result = $this->objTable->getOne();
        if ($result) {
            return $result;
        }
     }
     
     public function defaultSetting()
     {
         $this->objTable = new Model($this->getLangAndID['lang'].'_config');
         $this->objTable->where('idw', $this->idw);
         $this->objTable->where('`key`', 'home_config');
         $result = $this->objTable->delete();
     }
    
}
 
