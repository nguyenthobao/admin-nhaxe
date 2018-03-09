<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
/*
 * Uploads model
 */

 class uploads extends Album {
     /*
      * post param
      */
      public $title;
      public $description;
      public $album_id;
      public $tmp_id;
      public $status;
      public $create_time;
      public $Lfile;
      public $optionsUpload;
     
     public function upload(){
         /*
          * upload
          */
          if (isset($this->Lfile)) {
          include(DIR_HELPER_UPLOAD);
          $upload = new BncUpload($this->optionsUpload);
          
            $ret = array();
        
            $error = $this->Lfile["error"]; {
        
                if (!is_array($this->Lfile['name']))//single file
                {
                    $dir = $upload->upload($this->idw, 'album', 'Lfile');
                    if($dir){
                    $data = array(
                    'idw'                  => $this->idw,
                    //'title'                => $this->title,
                    //'description'          => $this->description,
                    'album_id'             => $this->album_id,
                    'create_time'          => $this->create_time,
                    //'status'               => $this->status,
                    'create_uid'           => $this->B['uid'],
                    'src_link'             => $dir
                    //'avatar'               => $this->avatar,
                    //'update_uid'           => 0,
                    //'update_time'          => 0,
                    //'id_lang'              => 0,
                    //'meta_title'           => $this->meta_title,
                    //'meta_keywords'        => $this->meta_keywords,
                    //'meta_description'     => $this->meta_description,
                    //'views'                => 0,
                    //'order_by'             => $this->order_by
                    ); 
                    if($this->tmp_id) $data['tmp_id'] = $this->tmp_id;
                    
                    $this->objTable = new Model($this->getLangAndID['lang'].'_album_images');
                    $ret['id'] = $this->objTable->insert($data);//insert data
                    $ret['linkFile'] = $this->B['upload_path'].$dir;
                    $ret['path'] = $dir;
                    }
                } else {
                    $fileCount = count($this->Lfile['name']);
                    for ($i = 0; $i < $fileCount; $i++) {
                        $fileName = $this->Lfile["name"][$i];
                        $dir = $upload->upload($this->idw, 'album', 'Lfile');
                        if($dir){
                        $data = array(
                        'idw'                  => $this->idw,
                        //'title'                => $this->title,
                        //'description'          => $this->description,
                        'album_id'             => $this->album_id,
                        'create_time'          => $this->create_time,
                        //'status'               => $this->status,
                        'create_uid'           => $this->B['uid'],
                        'src_link'             => $dir
                        //'avatar'               => $this->avatar,
                        //'update_uid'           => 0,
                        //'update_time'          => 0,
                        //'id_lang'              => 0,
                        //'meta_title'           => $this->meta_title,
                        //'meta_keywords'        => $this->meta_keywords,
                        //'meta_description'     => $this->meta_description,
                        //'views'                => 0,
                        //'order_by'             => $this->order_by
                        ); 
                        if($this->tmp_id) $data['tmp_id'] = $this->tmp_id;
                        
                        $this->objTable = new Model($this->getLangAndID['lang'].'_album_images');
                        $ret['id'] = $this->objTable->insert($data);//insert data
                        $ret['linkFile'] = $this->B['upload_path'].$dir;
                        $ret['path'] = $dir;
                        }
                    }
        
                }
            }
            return $ret;
        
        } 
     }
 }
 
