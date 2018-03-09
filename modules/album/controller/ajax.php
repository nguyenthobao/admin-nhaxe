<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
/*
 * Ajax controller
 */
 $ajax = new ajax();
 $ajax->update_time = date("Y-m-d H:i");
 $data=array();//data json

 //safe request
 switch ($_B['r']->get_string('name','POST')) {
     case 'imgOrder':
         $ajax->orderby = $_B['r']->get_array('order','POST');
         $ajax->imgOrder();
         $data['success'] = 1;
         echo json_encode($data); 
         break;
     case 'avatar-update':
         $ajax->album_id = $_B['r']->get_int('album_id','POST');
         $ajax->avatar_id = $_B['r']->get_int('id','POST');
         $result = $ajax->updateAvatarAjax();
         if($result){
         $data['success'] = 1;
         $data['id'] = $result['id'];
         $data['path'] = $_B['upload_path'].$result['src_link'];
         $data['path_none_domain'] = $result['src_link'];
         echo json_encode($data);   
         }
         break;
     case 'pic-delete':
         $ajax->id = $_B['r']->get_int('id','POST');
         $ajax->photoDelete();
         $data['success'] = 1;
         echo json_encode($data);
         break;
     case 'albumAvatarManager':
         $ajax->id = $_B['r']->get_int('key','POST');
         $result = $ajax->chooseAvatarDialogBox();
         $data['success'] = 1;
         $data['title'] = lang('chon_avatar_tieu_de'); 
         $data['titleAlbum'] = $result['album']['title']; 
         $data['html']='<div class="photo-list" id="sortB_">';
         
         foreach ($result['images'] as $key => $value) {
         $data['html'].='<div data-item="order_'.$value['id'].'" class="ajax-file-upload-statusbar" '.($value['avatar'] ==1 ? 'style="border-color: #0DA3E2"' : '').'>
         <div class="ajax-file-upload-file"><img src="'.$_B['upload_path'].$value['src_link'].'" /></div>
         <div data-id="'.$value['id'].'" data-type="delete" class="ajax-file-upload-del ajax-link" style="display: none;'.($value['avatar'] ==1 ? 'top: -100px' : '').'">'.lang('delete').'</div>
         <div album-id="'.$value['album_id'].'" data-id="'.$value['id'].'" data-type="choose-avatar" class="ajax-file-upload-choose ajax-link" style="display: none;">'.lang('chooseStr').'</div>
         <div class="ajax-file-upload-input">
         <input class="ajax-update-title" data-id="'.$value['id'].'" type="text" maxlength="170" placeholder="'.lang('placeholderTextStr').'" value="'.$value['title'].'">
         </div>
         <div class="ajax-file-upload-textarea">
         <textarea class="ajax-update-description" data-id="'.$value['id'].'" maxlength="500" placeholder="'.lang('placeholderTextAreaStr').'">'.$value['description'].'</textarea>
         </div>
         </div>';
         }
         $data['html'].='<div id="albumImagesUpload">Thêm ảnh</div></div>';
         echo json_encode($data);
         break;
     case 'searchRelated':
         $search = $_B['r']->get_string('search','POST');
         $ajax->id = $_B['r']->get_int('id','POST');
         $ajax->not_in = $_B['r']->get_array('not_in','POST');
         $result['data'] = $ajax->getRelatedSearchItem($search);
         if($result['data']){
         foreach ($result['data'] as $k => $v) {
                $v['avatar'] = $_B['upload_path'].$v['avatar'];
                $result['data'][$k] = $v;
            }
         }
         $result['empty']=lang('no_data'); 
         echo json_encode($result);
         break;
     case 'loadMoreRelated':
         $ajax->id = $_B['r']->get_int('id','POST');
         $ajax->not_id = $_B['r']->get_int('not_id','POST');
         $ajax->not_in = $_B['r']->get_array('not_in','POST');
         $result['data'] = $ajax->getRelatedAjax();
         $result['num'] = count($result['data']);
         foreach ($result['data'] as $k => $v) {
                $v['avatar'] = $_B['upload_path'].$v['avatar'];
                $result['data'][$k] = $v;
            }
         echo json_encode($result);
         break;
     case 'deleteAlbumItem'://xoa album
         $ajax->id = $_B['r']->get_int('key','POST');
         $result = $ajax->quickDeleteAlbum();
         if($result['success']){
         $data['success'] = 1;
         if($result['ids']){
         $data['ids'] = $result['ids'];
         }
         }
         echo json_encode($data);
         break;
     case 'editAlbumStatus'://sua trang thai album
         $ajax->id = $_B['r']->get_int('key','POST');
         $ajax->status = $_B['r']->get_int('status','POST');
         $result = $ajax->quickEditAlbumStatus();
         
         if($result['error']){
         $data['msg']=lang('parent_category_is_hide');
         }
         if($result['success']){
         $data['success']=1;
         $data['status']=$ajax->status;
         if($result['ids']){
         $data['ids'] = $result['ids'];
         }
         }
         echo json_encode($data);
         break;
     case 'editAlbumOrder'://sap xep thu tu album
         $ajax->id = $_B['r']->get_int('pk','POST');
         $ajax->safe = $_B['r']->get_string('value','POST');
         $ajax->orderby = $_B['r']->get_int('value','POST');
         $result = $ajax->quickEditAlbumOrder();
         
         if($result['error']){
         $data['msg']=lang('error_number_only');
         }
         echo json_encode($data);
         break;
     case 'editAlbumName'://sua ten album
         $ajax->id = $_B['r']->get_int('pk','POST');
         $ajax->title = $ajax->txt_string($_B['r']->get_string('value','POST'));
         $result = $ajax->quickEditAlbumTitle();
         
         if($result['error']){
         $data['msg']=lang('error_empty_title');
         }
         echo json_encode($data);
         break;
     case 'editCateName'://sua ten danh muc
         $ajax->id = $_B['r']->get_int('pk','POST');
         $ajax->title = $ajax->txt_string($_B['r']->get_string('value','POST'));
         $result = $ajax->quickEditCateTitle();
         
         if($result['error']){
         $data['msg']=lang('error_empty_title');
         }
         echo json_encode($data);
         break;
     case 'editCateOrder'://sap xep thu tu danh muc
         $ajax->id = $_B['r']->get_int('pk','POST');
         $ajax->safe = $_B['r']->get_string('value','POST');
         $ajax->orderby = $_B['r']->get_int('value','POST');
         $result = $ajax->quickEditCateOrder();
         
         if($result['error']){
         $data['msg']=lang('error_number_only');
         }
         echo json_encode($data);
         break;
     case 'editCateStatus'://sua trang thai danh muc
         $ajax->id = $_B['r']->get_int('key','POST');
         $ajax->status = $_B['r']->get_int('status','POST');
         $result = $ajax->quickEditCateStatus();
         
         if($result['error']){
         $data['msg']=lang('parent_category_is_hide');
         }
         if($result['success']){
         $data['success']=1;
         $data['status']=$ajax->status;
         if($result['ids']){
         $data['ids'] = $result['ids'];
         }
         }
         echo json_encode($data);
         break;
     case 'deleteCateItem'://xoa danh muc
         $ajax->id = $_B['r']->get_int('key','POST');
         $result = $ajax->quickDeleteCate();
         if($result['success']){
         $data['success'] = 1;
         if($result['ids']){
         $data['ids'] = $result['ids'];
         }
         }
         echo json_encode($data);
         break;
      case 'choose-avatar':
         $ajax->id = $_B['r']->get_int('id','POST');
         $result = $ajax->chooseAvatar();
         if($result){
         $data['success'] = 1;
         $data['id'] = $result['id'];
         $data['path'] = $result['src_link'];
         }
         echo json_encode($data);
         break;
      case 'pic-update':
         $ajax->id = $_B['r']->get_int('id','POST');
         $ajax->title = $ajax->txt_string($_B['r']->get_string('title','POST'));
         $ajax->description = $_B['r']->get_string('description','POST');
         $result = $ajax->picUpdate();
         if($result){
         $data['success'] = 1;
         }
         echo json_encode($data);
         break;
     
     default:
         
         break;
 }
