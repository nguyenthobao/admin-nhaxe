<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
/*
 * Ajax module
 */
 class ajax extends Album {
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
      public $album_id;
      public $not_in;
      public $not_id;
      
      /*
       * update avatar
       */
       public function updateAvatarAjax()
       {
          $this->updateAvatar($this->avatar_id, $this->album_id);
          $this->objTable = new Model($this->getLangAndID['lang'].'_album_images');
          $select = array('id', 'src_link');
          $this->objTable->where('idw',$this->idw);
          $this->objTable->where('id',$this->avatar_id);
          $this->objTable->where('avatar',1);
          $result = $this->objTable->getOne(null,$select);
          $this->objTable = new Model($this->getLangAndID['lang'].'_album');
          $data = array(
            'avatar'               => $result['src_link'],
            'avatar_id'            => $result['id'],
            //'create_uid'           => $this->B['uid'],
            'update_uid'           => $this->B['uid'],
            //'create_time'          => $this->create_time,
            'update_time'          => $this->update_time
           ); 
          $this->objTable->where('idw',$this->idw);
          $this->objTable->where($this->getLangAndID['field_id'], $this->album_id);
          
          $this->objTable->update($data);
          return $result;
       }
      
      /*
       * xoa anh
       */
       public function photoDelete()
       {
           $this->objTable = new Model($this->getLangAndID['lang'].'_album_images');
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
          $this->objTable = new Model($this->getLangAndID['lang'].'_album');
          $select = array('title');
          $this->objTable->where('idw',$this->idw);
          $this->objTable->where($this->getLangAndID['field_id'],$this->id);
          
          $result['album'] = $this->objTable->getOne(null,$select);
          //
          $this->objTable = new Model($this->getLangAndID['lang'].'_album_images');
          $select = array('id','title','description','album_id','src_link','order_by','avatar');
          $this->objTable->where('idw',$this->idw);
          $this->objTable->where('album_id',$this->id);
          $this->objTable->orderBy('order_by','ASC');
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
          $this->objTable = new Model($this->getLangAndID['lang'].'_album_images');
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
          $this->objTable = new Model($this->getLangAndID['lang'].'_album_images');
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
          $checkExist = $this->ifExist($this->id, $this->getLangAndID['lang'],'_album_images');
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
       * xoa nhanh mot album
       */
      public function quickDeleteAlbum()
      {
          $return['ids'] = $return['success'] = false;
          $return['error'] = true;
          $this->objTable = new Model($this->getLangAndID['lang'].'_album');
          if(!empty($this->id) && is_numeric($this->id)){
          //$this->deleteImagesAlbum($this->id);
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
       * sua nhanh trang thai album
       */
      public function quickEditAlbumStatus()
      {
          $return['ids'] = $return['success'] = false;
          $return['error'] = true;
          $this->objTable = new Model($this->getLangAndID['lang'].'_album');
          $data = array(
          'status' => $this->status,
          'update_uid' => $this->B['uid'],
          'update_time' => $this->update_time
          );
          
          if(!empty($this->id) && is_numeric($this->status)){
          if($this->status==2){
          $data = array(
          'status' => 1,
          'post_time' => 0
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
       * sua nhanh thu tu album
       */
      public function quickEditAlbumOrder()
      {
          $return['success'] = false;
          $return['error'] = true;
          $this->objTable = new Model($this->getLangAndID['lang'].'_album');
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
       * sua nhanh tieu de album
       */
      public function quickEditAlbumTitle()
      {
          $return['success'] = false;
          $return['error'] = true;
          $this->objTable = new Model($this->getLangAndID['lang'].'_album');
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
      
      /*
       * sua nhanh tieu de danh muc
       */
      public function quickEditCateTitle()
      {
          $return['success'] = false;
          $return['error'] = true;
          $this->objTable = new Model($this->getLangAndID['lang'].'_album_category');
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
      
      /*
       * sua nhanh thu tu danh muc
       */
      public function quickEditCateOrder()
      {
          $return['success'] = false;
          $return['error'] = true;
          $this->objTable = new Model($this->getLangAndID['lang'].'_album_category');
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
       * sua nhanh trang thai danh muc
       */
      public function quickEditCateStatus()
      {
          $return['ids'] = $return['success'] = false;
          $return['error'] = true;
          $this->objTable = new Model($this->getLangAndID['lang'].'_album_category');
          $data = array(
          'status' => $this->status,
          'update_uid' => $this->B['uid'],
          'update_time' => $this->update_time
          );
          if($this->status==1){
          if(!$this->checkParentStatus($this->id)){
              $return['error'] = 'parentIsHide';
              return $return; 
          }
          }
          if(!empty($this->id) && is_numeric($this->status)){
          $this->objTable->where($this->getLangAndID['field_id'],$this->id);
          $this->objTable->where('idw',$this->idw);
          $result = $this->objTable->update($data);
          //an tat ca ngon ngu khac
          if($this->status == 0 && $this->getLangAndID['lang'] == $this->lang)
          $this->applyAllLang($data,$this->id,'update','_album_category');
          
          if($result){
          /*
           * ap dung cho tat ca danh muc con
           */
           //an album
          $this->hideByCate($this->id, $this->status);
          if($this->status!=1){
          $this->getChildCate($this->id);
          if(!empty($this->arr)){
           foreach($this->arr as $v){
           $this->objTable = new Model($this->getLangAndID['lang'].'_album_category');
           $data = array(
           'status' => $this->status,
           'update_uid' => $this->B['uid'],
           'update_time' => $this->update_time
           );
           $this->objTable->where('id', $v);
           $this->objTable->where('idw',$this->idw);
           $this->objTable->update($data);
           //an album
           $this->hideByCate($v, $this->status);
           //an tat ca ngon ngu khac
           if($this->status == 0 && $this->getLangAndID['lang'] == $this->lang)
           $this->applyAllLang($data,$this->id,'update','_album_category');
           }
          $return['ids'] = implode(",", $this->arr);
          }
          }
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
       * kiem tra trang thai danh muc cha
       */
       public function checkParentStatus($id)
       {
          $this->objTable = new Model($this->getLangAndID['lang'].'_album_category');
          $select = array('parent_id');
          $this->objTable->where('idw',$this->idw);
          $this->objTable->where('id',$id);
          $result = $this->objTable->getOne(null,$select);
          if($result['parent_id']=='') return true;
          $this->objTable = new Model($this->getLangAndID['lang'].'_album_category');
          $select = array('id');
          $this->objTable->where('idw',$this->idw);
          $this->objTable->where('id',$result['parent_id']);
          $this->objTable->where('status',1);
          $result = $this->objTable->getOne(null,$select);
          return $result['id'];
       }
       
       //order images
       public function imgOrder(){
         $updateRecordsArray = $this->orderby;   
         $listingCounter = 1;
         if(!empty($updateRecordsArray)){
         foreach ($updateRecordsArray as $recordIDValue) {
         $this->objTable = new Model($this->getLangAndID['lang'].'_album_images');
         $data = array (
         'order_by'=> $listingCounter
         );
         $this->objTable->where('id',$recordIDValue);
         $this->objTable->where('idw',$this->idw);
         $result = $this->objTable->update($data);
         $listingCounter = $listingCounter + 1;
         }
         }
       }
     
 }
