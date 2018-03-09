<?php

if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
/*
* Ajax module
*/
class ajax extends Slide {
    /*
    * input param
    */
    public $id;
    public $title;
    public $position;
    public $content;
    public $description;
    public $status;
    public $sort;
    public $safe;
    public $getLang;
    public $update_time;
    public $avatar_id;
    public $slide_id;
    public $not_in;
    public $not_id;

    public function updateAvatarAjax() {
        $this->updateAvatar($this->avatar_id, $this->slide_id);
        $this->objTable = new Model($this->getLangAndID['lang'].'_slide_images');
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
    public function photoDelete() {
        $this->objTable = new Model($this->getLangAndID['lang'].'_slide_images');
        $this->objTable->where('idw',$this->idw);
        $this->objTable->where('id',$this->id);
        $this->objTable->delete();
    }
    public function chooseAvatarDialogBox() {
        $result=array();
        $this->objTable = new Model($this->getLangAndID['lang'].'_slide');
        $select = array('title');
        $this->objTable->where('idw',$this->idw);
        $this->objTable->where($this->getLangAndID['field_id'],$this->id);

        $result['slide'] = $this->objTable->getOne(null,$select);

        $this->objTable = new Model($this->getLangAndID['lang'].'_slide_images');
        $select = array('id','title','description','slide_id','src_link','sort','avatar');
        $this->objTable->where('idw',$this->idw);
        $this->objTable->where('slide_id',$this->id);
        $result['images'] = $this->objTable->get(null,null,$select);
        if ($result) {
            return $result;
        }
    }
    public function chooseAvatar() {
        $this->objTable = new Model($this->getLangAndID['lang'].'_slide_images');
        $select = array('id', 'src_link');
        $this->objTable->where('id',$this->id);
        $this->objTable->where('idw',$this->idw);
        $result = $this->objTable->getOne(null,$select);
        if ($result) {
            return $result;
        }
    }
    public function picUpdate() {
        $return['success'] = false;
        $return['error'] = true;
        if($this->getLangAndID['lang']!=$this->lang){
            $id_lang = $this->id;
        }else{
            $id_lang = '';
        }
        $this->objTable = new Model($this->getLangAndID['lang'].'_slide_images');
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
        if($this->width){
            $data = array(
                'idw' => $this->idw,
                'width' => $this->width,
                'id_lang' => $id_lang,
                'update_uid' => $this->B['uid'],
                'update_time' => $this->update_time
            );
        }
        if($this->height){
            $data = array(
                'idw' => $this->idw,
                'height' => $this->height,
                'id_lang' => $id_lang,
                'update_uid' => $this->B['uid'],
                'update_time' => $this->update_time
            );
        }
        if($this->link){
            $data = array(
                'idw' => $this->idw,
                'link' => $this->link,
                'id_lang' => $id_lang,
                'update_uid' => $this->B['uid'],
                'update_time' => $this->update_time
            );
        }
            //Kiểm tra xem bản ghi đã tồn tại bên ngôn ngữ này chưa. 
            //True : update
            //false: insert
        $checkExist = $this->ifExist($this->id, $this->getLangAndID['lang'],'_slide_images');
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
    public function quickDeleteSlide() {
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
    public function quickEditSlideStatus() {
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
    public function quickEditSlideOrder() {
        $return['success'] = false;
        $return['error'] = true;
        $this->objTable = new Model($this->getLangAndID['lang'].'_slide');
        $data = array(
            'sort' => $this->sort,
            'update_uid' => $this->B['uid'],
            'update_time' => $this->update_time
        );
        if(!empty($this->id) && is_numeric($this->sort) && is_numeric($this->safe)){
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
    public function quickEditSlideTitle() {
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
    public function editPositionSlide() {
        $return['success'] = false;
        $return['error'] = true;
        $this->objTable = new Model($this->getLangAndID['lang'].'_slide');
        $data = array(
            'position' => $this->position,
            'update_uid' => $this->B['uid'],
            'update_time' => $this->update_time
        );
        if(!empty($this->id) && !empty($this->position)){
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