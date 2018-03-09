<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

/*----Lang Menu ----*/
$_L['title_header']                 = 'Album - Manager';
$_L['title_module']                 = 'Album';
$_L['title_module_m']               = 'Album';
$_L['title_manager_mod']            = 'Album';
$_L['breadcrumb_mod']               = 'Album';

//new album page
//$_L['xx'] = 'xx';
$_L['chon_anh_dai_dien']            = 'Rather photos';
$_L['co_chac_muon_lam_moi_ko']      = 'Warning: You surely refresh this album?';
$_L['go_new']                       = 'refresh';
$_L['album_new']                    = 'Create new album';
$_L['album_new_sort']               = 'Album new';
$_L['album_hot']                    = 'Album hot';
$_L['album_random']                 = 'Album random';
$_L['sap_xep_tin']                  = 'New sort';
$_L['so_luong_hien_thi']            = 'Number of display';
$_L['hien_album_cung_danh_muc']     = 'Show album category';
$_L['load_more']                    = 'View more';
$_L['related_list']                 = 'List of relevant elective album';
$_L['related']                      = 'Select the relevant album';
$_L['related_noti']                 = '';
$_L['album_related']                = 'Album related';
$_L['tim_theo_danh_muc']            = 'Search by category';
$_L['ban_muon_dang_ngay']           = 'Warning: You will sign this album right now?';
$_L['hen_dang']                     = 'Published Romance';
$_L['post_time']                    = 'Schedule Posted';
$_L['album_images']                 = 'Avatar';
$_L['album_name']                   = 'Album Name';
$_L['images_noti']                  = 'Can select multiple files to upload';
$_L['success_album_add']            = 'Sign successful album.';
$_L['ok']                           = 'Agree';
$_L['cancel']                       = 'Cancel';
$_L['do_you_really_want_to_delete'] = 'Warning: You really want to delete this album?';
$_L['noti_information']             = 'Fields marked * are mandatory';
$_L['basic_information']            = 'Basic Information';
$_L['meta_information']             = 'Meta information';
$_L['breadcrumb_album_new']         = 'Create new album';
$_L['breadcrumb_album_edit']        = 'Edit album';
$_L['title_manager_album']          = 'Manager album';
$_L['images']                       = 'Image';
$_L['category']                     = 'Category';
$_L['check_all']                    = 'Select add';

//new category page
$_L['search_title']                 = 'Search by name';
$_L['search']                       = 'Search';
$_L['category_name']                = 'Name lists';
$_L['sort']                         = 'Sort';
$_L['status']                       = 'Status';
$_L['action']                       = 'Action';
$_L['alert']                        = 'Warning!';
$_L['no_data']                      = 'No records were found! ';
$_L['main_category']                = 'Original list';
$_L['error_just_not_idea']          = 'An error occurred please try again!';
$_L['click_to_change_status']       = 'Click to change the status';
$_L['hiding']                       = 'Hiding';
$_L['showing']                      = 'Showding';
$_L['click_to_edit']                = 'Click to edit';
$_L['click_to_edit_order']          = 'Sort';
$_L['edit']                         = 'Edit';
$_L['delete']                       = 'Delete';
$_L['view_details']                 = 'View details';
$_L['sort_tooltips']                = 'In order of small to large';
$_L['success_category_add']         = 'Create lists of successful.';
$_L['breadcrumb_category_new']      = 'Create new list';
$_L['meta_title']                   = 'Title content';
$_L['meta_keywords']                = 'Meta keywords';
$_L['meta_description']             = 'Meta description';
$_L['icon_img']                     = 'Icon';
$_L['bg_img']                       = 'Background';
$_L['image_group']                  = 'Image';
$_L['remove_image']                 = 'Remove';
$_L['publuc']                       = 'Show';
$_L['private']                      = 'Hide';

$_L['breadcrumb_category']          = 'Category';
$_L['title_manager_category']       = 'Album manager list';

$_L['breadcrumb_category_edit']     = 'Edit category';
$_L['parent_not_translate']         = 'Take care portfolio father ago!';
$_L['error_update']                 = 'Did not find the list!';
$_L['error_update_album']           = 'No albums found!';

//ajax page
$_L['delete_item_dialog']           = 'Warning: Removing this category the entire list, use the list of albums will be deleted at! Are you sure to delete ?';
$_L['delete_all_dialog']            = 'Warning: Remove all the categories you are selected, the entire list, use the list of albums will be deleted at! Are you sure to delete';
$_L['delete_item_album']            = 'Warning: You really want to delete?';
$_L['delete_all_album']             = 'Warning: You want to delete all the selected album?';

$_L['parent_category_is_hide']      = 'Categories father is offline!';
$_L['error_empty_title']            = 'Data must not be empty!';
$_L['error_number_only']            = 'Just accept that some data!';

//upload
$_L['dragDropStr']                  = 'Drag & Drop Files Here';
$_L['abortStr']                     = 'Stop loading';
$_L['loadingStr']                   = 'Loading';
$_L['placeholderTextStr']           = 'Title image...';
$_L['placeholderTextAreaStr']       = 'Description image...';
$_L['chooseStr']                    = 'Make this avatar';
$_L['none_avatar']                  = 'Please select an avatar!';
$_L['add_image']                    = 'Add photos';

$_L['chon_avatar_tieu_de']          = 'Manage photo album';
$_L['do_you_really_want_to_delete_pic']          = 'Warning: You really want to delete this image?';
$_L['save']                         = 'Save';
$_L['reset'] = 'Làm mới';
$_L['hien_album_tu_chon']           = 'Related album elective';
$_L['option_post'] = 'Tùy chọn đăng';
$_L['alert_hide_by_cate']           = 'This album can not be out before the viewer. Because the list of albums is offline!';

$_L['breadcrumb_setting']           = 'Setting album';
$_L['setting_information']          = 'Install the album page';
$_L['setting_define']               = 'The system will apply the default in the section has been left blank!...';

$_L['kieu_sap_xep']                 = 'Arrangements';
$_L['so_luong_hien_thi']            = 'Number of display';
$_L['kieu_hien_thi']                = 'Display Mode';
$_L['new']                          = 'New';
$_L['hot']                          = 'View more';
$_L['az']                           = 'A - Z';
$_L['dang_luoi']                    = 'grid';
$_L['danh_sach']                    = 'list';
$_L['per_page']                     = 'Album page';
$_L['reset_default']                = 'Back to default';
$_L['tags']                         = 'Tags';
$_L['album_vip']                  	= 'Prominent album';
$_L['do_you_really_want_to_reset']  = 'You will return the settings to their default?';
$_L['noti_change']                  = 'You agree to change the link SEO URL';

$_L['copy_cate']                     = 'Copy album category';
$_L['copy_cate_note']                     = '- You can copy entire album catalog to predefined language. Vietnamese
                        - All data from the original language will be preserved when moving through the new language.';
$_L['select_lang']                     = 'Select Language copied to';
$_L['delete_all_cate']                     = 'Do you want to delete all the album category?';
$_L['empty_for_copy']                     = 'empty before copying';
$_L['close']                     = 'Close';
$_L['show_home']                     = 'Show home';
$_L['copy_lang']                     = 'Copying language';
$_L['copy_album']                     = 'Copy album';
$_L['note_copy_album']                     = '- You can copy the entire album to the predefined language. Vietnamese
                        - All data from the original language will be preserved when moving through the new language.';
$_L['show_album']                     = 'Show Album relate';