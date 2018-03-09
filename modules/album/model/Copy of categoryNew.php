<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

/**
 * add category model
 */
class categoryNew extends Album {
    /*
     * them danh muc
     */
    public function addCategory()
    {
        $this->objTable = new Model($this->getLangAndID['lang'].'_album_category');
        
        //upload
        include(DIR_HELPER_UPLOAD);
        $options = array('max_size' => 1600);
        $upload = new BncUpload($options);
        
        $avatarUpload = $upload->upload($this->idw,'album','avatar');
        if (!empty($avatarUpload)){
        $avatar = $avatarUpload;
        }else{
        $avatar = null;
        }
        
        $iconUpload = $upload->upload($this->idw,'album','icon');
        if (!empty($iconUpload)){
        $icon = $iconUpload;
        }else{
        $icon = null;
        }
        
        $bg_imageUpload = $upload->upload($this->idw,'album','bg_image');
        if (!empty($bg_imageUpload)){
        $bg_image = $bg_imageUpload;
        }else{
        $bg_image = null;
        }
        //upload end
        
        $data = array(
        'idw'                  => $this->idw,
        'title'                => $this->r->get_string('title','POST'),
        'contents_description' => $this->r->get_string('contents_description','POST'),
        'avatar'               => $avatar,
        'icon'                 => $icon,
        'bg_image'             => $bg_image,
        'status'               => $this->r->get_int('status','POST'),
        'create_uid'           => $this->B['uid'],
        //'update_uid'           => 0,
        'create_time'          => time(),
        //'update_time'          => 0,
        //'id_lang'              => 0,
        'meta_title'           => $this->r->get_string('meta_title','POST'),
        'meta_keywords'        => $this->r->get_string('meta_keywords','POST'),
        'meta_description'     => $this->r->get_string('meta_description','POST'),
        //'views'                => 0,
        'order_by'             => $this->r->get_int('order_by','POST'),
        'parent_id'            => $this->r->get_int('parent_id','POST')
        );
            
        if($getLangAndID['lang']!='vi'){
        $id_lang = $this->r->get_int('id');
        $parent_id = $this->getParentID();
        }else{
        $parent_id = $this->r->get_int('cat_id','POST');
        }
            
        //Kiểm tra xem nếu tồn tại id thì update, nếu không thì insert
        $id = $this->r->get_int('id');
        if(!empty($id)){
        $this->objTable->where($this->getLangAndID['field_id'],$id);
        $this->objTable->where('idw',$this->idw);
        $result = $this->objTable->update($data);
        if($getLangAndID['lang']=='vi'){
        //Update lại parent_id nếu sửa bản ghi tiếng việt
        $data = array(
            'parent_id' => $parent_id
        );
        //function fixParentCat($data,$id,$action)
        //@param1 : mảng truyền vào xử lý
        //@param2: id
        //@param3: action truyền vào để xử lý theo yêu cầu. VD: delete,update
        $this->fixParentCat($data,$id,'update');
        }else{
        //Kiểm tra xem bản ghi đã tồn tại bên ngôn ngữ này chưa. 
        //True : update
        //false: insert
        $checkExist = $this->checkExist($id,$this->getLangAndID['lang']);
        if ($checkExist==true){
        $this->objTable->where($this->getLangAndID['field_id'],$id);
        $this->objTable->where('idw',$this->idw);
        $result = $this->objTable->update($data);      
        }else{
        $result = $this->objTable->insert($data);
        }
        }
        }else{
        $result = $this->objTable->insert($data);
        }
        
        if ($getLangAndID['lang']!='vi'){
        $return['last_id'] = $this->r->get_int('id');
        }else{
        $return['last_id'] = $this->objTable->getLastId();
        }
        
        if ($result){
        $return['status'] = true;
        }else{
        $return['status'] = false;
        $return['error'] = $this->objTable->getLastError();
        }
        
        return $return;
        
    }

    
    public function getParentID(){
        
    }
    
}
