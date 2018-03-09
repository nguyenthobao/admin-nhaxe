<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/ajaxslide.php 
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 08/17/2014, 10:14 AM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
/*
 * Ajax module
 */
 class ajaxslide extends GlobalTemplate {
     /*
      * input param
      */
      public $id;
      public $title;
      public $content;
      public $description;
      public $status;
      public $orderby;
      public $safe;
      public $getLang;
      public $update_time;
      public $avatar_id;
      public $slide_id;
      public $not_in;
      public $not_id;
      
      /*
       * update avatar
       */
       public function updateAvatarAjax()
       {
          $this->updateAvatar($this->avatar_id, $this->slide_id);
          $this->objTable = new Model($this->getLangAndID['lang'].'_slide_image');
          $select = array('id', 'src_link');
          $this->objTable->where('idw',$this->idw);
          $this->objTable->where('id',$this->avatar_id);
          $this->objTable->where('avatar',1);
          $result = $this->objTable->getOne(null,$select);
          $this->objTable = new Model($this->getLangAndID['lang'].'_slide');
          $data = array(
            'avatar'               => $result['src_link'],
            'avatar_id'            => $result['id'],
            //'create_uid'           => $this->B['uid'],
            'update_uid'           => $this->B['uid'],
            //'create_time'          => $this->create_time,
            'update_time'          => $this->update_time
           ); 
          $this->objTable->where('idw',$this->idw);
          $this->objTable->where($this->getLangAndID['field_id'], $this->slide_id);
          
          $this->objTable->update($data);
          return $result;
       }
      
      /*
       * xoa anh
       */
       public function photoDelete()
       {
           $this->objTable = new Model($this->getLangAndID['lang'].'_slide_image');
           $this->objTable->where('idw',$this->idw);
           $this->objTable->where('id',$this->id);
           $this->objTable->delete();
       }
      
      /*
       * chon anh dai dien dialogBox
       */
      public function chooseAvatarDialogBox()
      {
          $result=array();
          $this->objTable = new Model($this->getLangAndID['lang'].'_slide');
          $select = array('title');
          $this->objTable->where('idw',$this->idw);
          $this->objTable->where($this->getLangAndID['field_id'],$this->id);
          
          $result['slide'] = $this->objTable->getOne(null,$select);
          //
          $this->objTable = new Model($this->getLangAndID['lang'].'_slide_image');
          $select = array('id','title','description','slide_id','src_link','order_by','avatar');
          $this->objTable->where('idw',$this->idw);
          $this->objTable->where('slide_id',$this->id);
          //$this->objTable->orderBy('create_time','DESC');
          $result['images'] = $this->objTable->get(null,null,$select);
          //
          if ($result) {
              return $result;
          }
          
      }
      
      /*
       * chon anh dai dien
       */
      public function chooseAvatar()
      {
          $this->objTable = new Model($this->getLangAndID['lang'].'_slide_image');
          $select = array('id', 'src_link');
          $this->objTable->where('id',$this->id);
          $this->objTable->where('idw',$this->idw);
          $result = $this->objTable->getOne(null,$select);
          if ($result) {
              return $result;
          }
          
      }
      
      /*
       * cap nhat tieu de anh
       */
      public function picUpdate()
      {
          $return['success'] = false;
          $return['error'] = true;
          if($this->getLangAndID['lang']!=$this->lang){
          $id_lang = $this->id;
          }else{
          $id_lang = '';
          }
          $this->objTable = new Model($this->getLangAndID['lang'].'_slide_image');
          if($this->title){
           $data = array(
          'idw' => $this->idw,
          'title' => $this->title,
          'id_lang' => $id_lang,
          'update_uid' => $this->B['uid'],
          'update_time' => $this->update_time
          );  
          }
          if($this->description){
           $data = array(
          'idw' => $this->idw,
          'description' => $this->description,
          'id_lang' => $id_lang,
          'update_uid' => $this->B['uid'],
          'update_time' => $this->update_time
          );   
          }
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
          $checkExist = $this->ifExist($this->id, $this->getLangAndID['lang'],'_slide_image');
          if($checkExist==true){
          $this->objTable->where($this->getLangAndID['field_id'], $this->id);
          $this->objTable->where('idw',$this->idw);
          $result = $this->objTable->update($data);      
          }else{
          $result = $this->objTable->insert($data);
          }
            
          if($this->getLangAndID['lang']!=$this->lang){
          $return['last_id'] = $this->id;
          }else{
          $return['last_id'] = $result;
          }
          
          if($result){
          $return['success'] = true;
          $return['error'] = false;
          }else{
          $return['success'] = false;
          $return['error'] = $this->objTable->getLastError();
          } 
          
          return $return;
      }

      /*
       * xoa nhanh mot slide
       */
      public function quickDeleteSlide()
      {
          $return['ids'] = $return['success'] = false;
          $return['error'] = true;
          $this->objTable = new Model($this->getLangAndID['lang'].'_slide');
          if(!empty($this->id) && is_numeric($this->id)){
          $this->objTable->where($this->getLangAndID['field_id'],$this->id);
          $this->objTable->where('idw',$this->idw);
          $result = $this->objTable->delete();
          
          //ap dung cho tat ca ngon ngu
          $this->applyAllLang(null,$this->id,'delete');
          
          if($result){

          $return['success'] = true;
          $return['error'] = false;
          }else{
          $return['success'] = false;
          $return['error'] = $this->objTable->getLastError();
          } 
          }
          return $return; 
          
      }

      /*
       * sua nhanh trang thai slide
       */
      public function quickEditSlideStatus()
      {
          $return['ids'] = $return['success'] = false;
          $return['error'] = true;
          $this->objTable = new Model($this->getLangAndID['lang'].'_slide');
          $data = array(
          'status' => $this->status,
          'update_uid' => $this->B['uid'],
          'update_time' => $this->update_time
          );
          
          if(!empty($this->id) && is_numeric($this->status)){
          if($this->status==2){
          $data = array(
          'status' => 1,
          'post_time' => ''
          );
          $this->objTable->where($this->getLangAndID['field_id'],$this->id);
          $this->objTable->where('idw',$this->idw);
          $result = $this->objTable->update($data);
          }else{
          $this->objTable->where($this->getLangAndID['field_id'],$this->id);
          $this->objTable->where('idw',$this->idw);
          $result = $this->objTable->update($data);
          }
          //an tat ca ngon ngu khac
          if($this->status == 0 && $this->getLangAndID['lang'] == $this->lang)
          $this->applyAllLang($data,$this->id,'update');
          
          if($result){
          
          $return['success'] = true;
          $return['error'] = false;
          }else{
          $return['success'] = false;
          $return['error'] = $this->objTable->getLastError();
          } 
          }
          return $return; 
      }

      /*
       * sua nhanh thu tu slide
       */
      public function quickEditSlideOrder()
      {
          $return['success'] = false;
          $return['error'] = true;
          $this->objTable = new Model($this->getLangAndID['lang'].'_slide');
          $data = array(
          'order_by' => $this->orderby,
          'update_uid' => $this->B['uid'],
          'update_time' => $this->update_time
          );
          
          if(!empty($this->id) && is_numeric($this->orderby) && is_numeric($this->safe)){
          $this->objTable->where($this->getLangAndID['field_id'],$this->id);
          $this->objTable->where('idw',$this->idw);
          $result = $this->objTable->update($data);
          
          if($result){
          $return['success'] = true;
          $return['error'] = false;
          }else{
          $return['success'] = false;
          $return['error'] = $this->objTable->getLastError();
          } 
          }
          return $return;
          
      }

      /*
       * sua nhanh tieu de slide
       */
      public function quickEditSlideTitle()
      {
          $return['success'] = false;
          $return['error'] = true;
          $this->objTable = new Model($this->getLangAndID['lang'].'_slide');
          $data = array(
          'title' => $this->title,
          'update_uid' => $this->B['uid'],
          'update_time' => $this->update_time
          );
          if(!empty($this->id) && !empty($this->title)){
          $this->objTable->where($this->getLangAndID['field_id'],$this->id);
          $this->objTable->where('idw',$this->idw);
          $result = $this->objTable->update($data);
          
          if($result){
          $return['success'] = true;
          $return['error'] = false;
          }else{
          $return['success'] = false;
          $return['error'] = $this->objTable->getLastError();
          } 
          }
          return $return;
      }
      
     
     
 }
