<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/slideUpdate.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/17/2014, 10:14 AM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

/**
 * update slide model
 */
class slideUpdate extends GlobalTemplate {
    /*
     * slide param
     */
    public $id;
    public $title;
    public $contents_description;
    public $avatar;
    public $avatar_id;
    public $status;
    public $update_time;
    public $meta_title;
    public $meta_keywords;
    public $meta_description;
    public $order_by;
    public $id_lang;
    public $get_lang;
    public $not_in;
    
    /*
     * luu allbum
     */
    public function updateSlide()
    {
        $return['status'] = false;
        $return['error'] = 'empty';
        if($this->getLangAndID['lang']!=$this->lang){
        $id_lang = $this->id;
        }else{
        $id_lang = '';
        }
        if(!empty($this->title)){
        $data = array(
        'idw'                  => $this->idw,
        'title'                => $this->title,
        'contents_description' => $this->contents_description,
        'avatar'               => $this->avatar,
        'avatar_id'            => $this->avatar_id,
        'status'               => $this->status,
        'update_uid'           => $this->B['uid'],
        'update_time'          => $this->update_time,
        'id_lang'              => $id_lang,
        'meta_title'           => $this->meta_title,
        'meta_keywords'        => $this->meta_keywords,
        'meta_description'     => $this->meta_description,
        'order_by'             => $this->order_by,
        ); 
        $this->objTable = new Model($this->getLangAndID['lang'].'_slide');
        /*
        if(!empty($this->id)){
        $this->objTable->where($this->getLangAndID['field_id'],$this->id);
        $this->objTable->where('idw',$this->idw);
        $result = $this->objTable->update($data);
        }
        */
        //Kiểm tra xem bản ghi đã tồn tại bên ngôn ngữ này chưa. 
        //True : update
        //false: insert
        $checkExist = $this->ifExist($this->id, $this->getLangAndID['lang'],'_slide');
        if($checkExist==true){
        $this->objTable->where($this->getLangAndID['field_id'], $this->id);
        $this->objTable->where('idw',$this->idw);
        $result = $this->objTable->update($data);
        //$return['last_id'] = $this->id;
        $data = array(
        'category_id'          => $this->category_id
        );
        $this->applyAllLang($data,$this->id,'update');//
        }else{
        $result = $this->objTable->insert($data);
        }
        
        $return['last_id'] = $this->id;
        
        if($result){
        $this->updateAvatar($this->avatar_id, $this->id);
        $return['status'] = true;
        }else{
        $return['status'] = false;
        $return['error'] = $this->objTable->getLastError();
        }
        }
        return $return;
    }

    /*
     * get images slide
     */
     public function getImages()
     {
        $res=array();
        $this->objTable = new Model($this->getLangAndID['lang'].'_slide_image');
        $select = array('id','title','description','slide_id','src_link','order_by','avatar');
        $this->objTable->where('slide_id',$this->id);
        $this->objTable->where('idw',$this->idw);
        $data = $this->objTable->get(null,null,$select);
          
          return $data; 
     }
    //
     public function getImagesLang($id)
     {
        $this->objTable = new Model($this->getLangAndID['lang'].'_slide_image');
        $select = array('title','description');
        $this->objTable->where('id_lang',$id);
        $this->objTable->where('idw',$this->idw);
        $result = $this->objTable->getOne(null,$select);
        if ($result) {
            return $result;
        }
     }

    /*
     * get one slide
     */
     public function getSlideItem()
     {
        if(!$this->safeUpdate())
            return 'errorUpdate';
        $this->objTable = new Model($this->getLangAndID['lang'].'_slide');
        $this->objTable->where($this->getLangAndID['field_id'],$this->id);
        $this->objTable->where('idw',$this->idw);
        $result = $this->objTable->getOne();
        //if($this->checkPostTime($result['post_time']))
        //$result['post_time']='';
        if ($result) {
            return $result;
        }
     }
    
    
    /*
     * safe update
     */
    protected function safeUpdate(){
    $id = $this->id;
    if($this->get_lang){
    $this->objTable = new Model($this->lang.'_slide');
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