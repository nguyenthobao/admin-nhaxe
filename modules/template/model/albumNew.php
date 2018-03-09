<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/slideNew.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/17/2014, 10:14 AM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

/**
 * add slide model
 */
class slideNew extends GlobalTemplate {
    /*
     * slide param
     */
    public $title;
    public $contents_description;
    public $avatar;
    public $avatar_id;
    public $status;
    public $create_time;
    public $meta_title;
    public $meta_keywords;
    public $meta_description;
    public $order_by;
    public $id;
    public $not_in;
    
    /*
     * luu slide
     */
    public function addSlide()
    {
        $return['status'] = false;
        $return['error'] = 'empty';
        if(!empty($this->title)){
        $data = array(
        'idw'                  => $this->idw,
        'title'                => $this->title,
        'contents_description' => $this->contents_description,
        'avatar'               => $this->avatar,
        'avatar_id'            => $this->avatar_id,
        'status'               => $this->status,
        'create_uid'           => $this->B['uid'],
        'create_time'          => $this->create_time,
        'meta_title'           => $this->meta_title,
        'meta_keywords'        => $this->meta_keywords,
        'meta_description'     => $this->meta_description,
        'order_by'             => $this->order_by,
        ); 
        $this->objTable = new Model($this->getLangAndID['lang'].'_slide');
        $return['last_id'] = $result = $this->objTable->insert($data);//insert data
        
        if ($return['last_id']){
        $this->idSlideOfPic($return['last_id'], $this->tmp_id);
        $this->setAvatar($this->avatar_id);
        $return['status'] = true;
        }else{
        $return['status'] = false;
        $return['error'] = $this->objTable->getLastError();
        }
        }
        return $return;
    }
    
    /*
     * cap nhat id slide cho anh
     */
    public function idSlideOfPic($slide_id, $tmp_id)
    {
      $this->objTable = new Model($this->lang.'_slide_image');
      $data = array(
        'slide_id' => $slide_id
      );
      $this->objTable->where('idw',$this->idw);
      $this->objTable->where('tmp_id',$tmp_id);
      $this->objTable->update($data);
    }
    /*
     * cap nhat id slide cho anh
     */
    public function setAvatar($avatar_id)
    {
      $this->objTable = new Model($this->lang.'_slide_image');
      $data = array(
        'avatar' => 1
      );
      $this->objTable->where('idw',$this->idw);
      $this->objTable->where('id',$avatar_id);
      $this->objTable->update($data);
    }
    
}