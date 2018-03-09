<?php

if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class slideUpdate extends Slide {
    /*
     * slide param
     */
    public $id;
    public $title;
    public $description;
    public $status;
    public $sort;
    public $position;
    public $update_time;
    public $meta_title;
    public $meta_keywords;
    public $meta_description;    
    public $id_lang;
    public $get_lang;
    public $not_in;
    
    public function updateSlide() {
        $return['status'] = false;
        $return['error'] = 'empty';
        if($this->getLangAndID['lang']!=$this->lang){
            $id_lang = $this->id;
        }else{
            $id_lang = '';
        }
        if(!empty($this->title)){
            $data = array(
                'idw'                   => $this->idw,
                'title'                 => $this->title,
                'description'           => $this->description,
                'status'                => $this->status,
                'sort'                  => $this->sort,
                'position'              => $this->position,
                'update_uid'            => $this->B['uid'],
                'update_time'           => $this->update_time,
                'id_lang'               => $id_lang,
                'meta_title'            => $this->meta_title,
                'meta_keywords'         => $this->meta_keywords,
                'meta_description'      => $this->meta_description,            
                ); 
            $this->objTable = new Model($this->getLangAndID['lang'].'_slide');

            //Kiểm tra xem bản ghi đã tồn tại bên ngôn ngữ này chưa. 
            //True : update
            //false: insert
            $checkExist = $this->ifExist($this->id, $this->getLangAndID['lang'],'_slide');
            if($checkExist==true){
                $this->objTable->where($this->getLangAndID['field_id'], $this->id);
                $this->objTable->where('idw',$this->idw);
                $result = $this->objTable->update($data);
            //$return['last_id'] = $this->id;

            $this->applyAllLang($data,$this->id,'update');//
        }else{
            $result = $this->objTable->insert($data);
        }

        $return['last_id'] = $this->id;

        if($result){
            $return['status'] = true;
        }else{
            $return['status'] = false;
            $return['error'] = $this->objTable->getLastError();
        }
    }
    return $return;
}
public function getImages()
{
    $res=array();
    $this->objTable = new Model($this->getLangAndID['lang'].'_slide_images');
    $select = array('id','title','description','slide_id','src_link','sort','width','height','link');
    $this->objTable->where('slide_id',$this->id);
    $this->objTable->where('idw',$this->idw);
    $data = $this->objTable->get(null,null,$select);          
    return $data; 
}
public function getImagesLang($id)
{
    $this->objTable = new Model($this->getLangAndID['lang'].'_slide_images');
    $select = array('title','description');
    $this->objTable->where('id_lang',$id);
    $this->objTable->where('idw',$this->idw);
    $result = $this->objTable->getOne(null,$select);
    if ($result) {
        return $result;
    }
}
public function getSlideItem()
{
    if(!$this->safeUpdate())
        return 'errorUpdate';
    $this->objTable = new Model($this->getLangAndID['lang'].'_slide');
    $this->objTable->where($this->getLangAndID['field_id'],$this->id);
    $this->objTable->where('idw',$this->idw);
    $result = $this->objTable->getOne();
    // echo "<pre>";
    // print_r($result);
    // echo "</pre>";
    // die();
    return $result;
}
protected function safeUpdate(){
    $id = $this->id;
    if($this->get_lang){
        $this->objTable = new Model($this->getLangAndID['lang'].'_slide');
        $select = array('id');
        $this->objTable->where('id',$id);
        $this->objTable->where('idw',$this->idw);
        $result = $this->objTable->getOne(null,$select);
        if ($result){
            return $result['id'];
        }
    }
}

}