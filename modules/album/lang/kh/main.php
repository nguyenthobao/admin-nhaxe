<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

/*----Lang Menu ----*/
$_L['title_header']='អាល់ប៊ុម - វេបសាយគ្រប់គ្រង';
$_L['title_module']='អាល់ប៊ុម';
$_L['title_module_m']='អាល់ប៊ុម';
$_L['title_manager_mod']='អាល់ប៊ុម';
$_L['breadcrumb_mod']='អាល់ប៊ុម';
$_L['chon_anh_dai_dien']='ការផ្លាស់ប្តូររូបភាព';
$_L['co_chac_muon_lam_moi_ko']='ព្រមាន: អ្នកប្រាកដជាធ្វើឱ្យអាល់ប៊ុមនេះឬ?';
$_L['go_new']='ធ្វើឱ្យស្រស់';
$_L['album_new']='ភ្នំពេញប៉ុស្តិ៍អាល់ប៊ុមថ្មី';
$_L['album_new_sort']='អាល់ប៊ុមថ្មី';
$_L['album_hot']='អាល់ប៊ុមក្តៅ';
$_L['album_random']='អាល់ប៊ុមចៃដន្យ';
$_L['sap_xep_tin']='ដំណឹងរៀប';
$_L['so_luong_hien_thi']='បង្ហាញលេខ';
$_L['hien_album_cung_danh_muc']='បង្ហាញអាល់ប៊ុមនៅក្នុងប្រភេទដូចគ្នានេះ';
$_L['load_more']='មើល';
$_L['related_list']='បញ្ជីអាល់ប៊ុមការបោះឆ្នោតដែលទាក់ទិននឹង';
$_L['related']='ជ្រើសអាល់ប៊ុមដែលពាក់ព័ន្ធ';
$_L['related_noti']='';
$_L['album_related']='អាល់ប៊ុមទាក់ទងនឹង';
$_L['tim_theo_danh_muc']='ស្វែងរកតាមប្រភេទ';
$_L['ban_muon_dang_ngay']='ព្រមាន: អ្នកនឹងចុះហត្ថលេខាលើអាល់ប៊ុមនេះឥឡូវនេះ';
$_L['hen_dang']='មនោសញ្ចេតនាបង្ហោះ';
$_L['post_time']='ឧបករណ៍កំណត់ពេលវេលាដែលបានបង្ហោះ';
$_L['album_images']='Avatar';
$_L['album_name']=;
$_L['images_noti']='អ្នកអាចជ្រើសឯកសារជាច្រើនដើម្បីផ្ទុកឡើង';
$_L['success_album_add']='កំណត់ហេតុអាល់ប៊ុមទទួលបានជោគជ័យ។ ';
$_L['ok']='យល់ព្រម';
$_L['cancel']='បោះបង់';
$_L['do_you_really_want_to_delete']='ព្រមាន: អ្នកពិតជាចង់លុបអាល់ប៊ុមនេះឬ?';
$_L['noti_information']='វាលនេះត្រូវបានសម្គាល់ * មានជាចាំបាច់';
$_L['basic_information']='មូលដ្ឋានព';
$_L['meta_information']='ព័តមេតា';
$_L['breadcrumb_album_new']='ភ្នំពេញប៉ុស្តិ៍អាល់ប៊ុមថ្មី';
$_L['breadcrumb_album_edit']='កែសម្រួលអាល់ប៊ុម';
$_L['title_manager_album']='គ្រប់គ្រងអាល់ប៊ុម';
$_L['images']='រូបភាព';
$_L['category']='បញ្ជី';
$_L['check_all']='ជ្រើសទាំងអស់';
$_L['search_title']='ស្វែងរកដោយឈ្មោះ';
$_L['search']='ស្វែងរក';
$_L['category_name']='បញ្ជីឈ្មោះ';
$_L['sort']='តម្រៀប';
$_L['status']='ស្ថានភាព';
$_L['action']='សកម្មភាព';
$_L['alert']='ព្រមាន!';
$_L['no_data']='គ្មានកំណត់ត្រាត្រូវបានរកឃើញ! ';
$_L['main_category']='បញ្ជីជា root';
$_L['error_just_not_idea']='កំហុសមួយបានកើតឡើងសូមព្យាយាមម្តងទៀត!';
$_L['click_to_change_status']='ចុចដើម្បីផ្លាស់ប្តូររដ្ឋបាន';
$_L['hiding']='លាក់';
$_L['showing']='បង្ហាញ';
$_L['click_to_edit']='ចុចដើម្បីកែសម្រួល';
$_L['click_to_edit_order']='តម្រៀប';
$_L['edit']='កែសម្រួល';
$_L['delete']='លុប';
$_L['view_details']='មើលលម្អិត';
$_L['sort_tooltips']='នៅក្នុងគោលបំណងនៃការតូចទៅធំ';
$_L['success_category_add']='កំណត់ហេតុប្រភេទទទួលបានជោគជ័យ។ ';
$_L['breadcrumb_category_new']='ភ្នំពេញប៉ុស្តិ៍ប្រភេទថ្មី';
$_L['meta_title']='មាតិកាអត្ថបទ';
$_L['meta_keywords']='ស្លាក';
$_L['meta_description']='បរិយាយ';
$_L['icon_img']='រូបតំណាង';
$_L['bg_img']='រូបភាព';
$_L['image_group']='រូបភាព';
$_L['remove_image']='យក';
$_L['publuc']='បង្ហាញ';
$_L['private']='លាក់';
$_L['breadcrumb_category']='បញ្ជី';
$_L['title_manager_category']='គ្រប់គ្រងប្រភេទអាល់ប៊ុម';
$_L['breadcrumb_category_edit']='កែបញ្ជី';
$_L['parent_not_translate']='សូមឪពុកផលប័ត្រសេវាកម្មជាលើកដំបូង!';
$_L['error_update']='មិនអាចរកឃើញប្រភេទ!';
$_L['error_update_album']='មិនអាចរកឃើញល់ប៊ុមនេះ!';


//ajax page
$_L['delete_item_dialog']='ព្រមាន: ការលុបប្រភេទនេះសំពៀតឥណទានទាំងមូល។ និងអាល់ប៊ុមដោយប្រើប្រភេទទាំងនេះនឹងត្រូវបានលុបផងដែរ! អ្នកធ្វើឱ្យប្រាកដថាដើម្បីលុប? ';
$_L['delete_all_dialog']='ព្រមាន: ការយកប្រភេទទាំងអស់ដែលអ្នកបានជ្រើសនោះផលប័ត្រទាំងមូល។ និងអាល់ប៊ុមដោយប្រើប្រភេទទាំងនេះនឹងត្រូវបានលុបផងដែរ! អ្នកធ្វើឱ្យប្រាកដថាដើម្បីលុប? ';
$_L['delete_item_album']='ព្រមាន: អ្នកពិតជាចង់លុប?';
$_L['delete_all_album']='ព្រមាន: អ្នកចង់លុបអាល់ប៊ុមទាំងអស់ដែលបានជ្រើស ';?
$_L['parent_category_is_hide']='ប្រភេទឪពុកគឺក្រៅបណ្ដាញ!';
$_L['error_empty_title']='ទិន្នន័យមិនគួរត្រូវបានទទេ!';
$_L['error_number_only']='ការទទួលយកតែទិន្នន័យគឺជាចំនួន!';
$_L['dragDropStr']='អូស & ឯកសារដែលបានទម្លាក់នៅទីនេះ';
$_L['abortStr']='បានបញ្ឈប់ការទាញយក';
$_L['loadingStr']='កំពុងផ្ទុក';
$_L['placeholderTextStr']='ចំណងជើងរូបភាព ... ';
$_L['placeholderTextAreaStr']='ការរៀបរាប់នៃរូបថត ... ';
$_L['chooseStr']='ជ្រើសថាជារូបតំនាង';
$_L['none_avatar']='សូមជ្រើសរូបតំនាងមួយ!';
$_L['add_image']='បន្ថែមរូបភាព';
$_L['chon_avatar_tieu_de']='គ្រប់គ្រងអាល់ប៊ុមរូបថត';
$_L['do_you_really_want_to_delete_pic']='ព្រមាន: អ្នកពិតជាចង់លុបរូបភាពនេះឬ?';
$_L['save']='រក្សាទុក';
$_L['reset']='ធ្វើឱ្យស្រស់';
$_L['hien_album_tu_chon']='បង្ហាញអាល់ប៊ុមជ្រើសតាំងទាក់ទងនឹង';
$_L['option_post']='ជម្រើសចូល';
$_L['alert_hide_by_cate']='អាល់ប៊ុមនេះមិនអាចត្រូវបានគេឃើញនៅក្នុងកម្មវិធីមើល។ ដោយសារតែបញ្ជីអាល់ប៊ុម offline! ';
$_L['breadcrumb_setting']='ការដំឡើងល់ប៊ុមនេះ';
$_L['setting_information']='ទំព័រការកំណត់អាល់ប៊ុម';
$_L['setting_define']='ប្រព័ន្ធនឹងត្រូវបានអនុវត្តលំនាំដើមនៅក្នុងផ្នែកនេះគឺទំនេរ ... !';
$_L['kieu_sap_xep']='ប្រភេទការរៀបចំ';
$_L['so_luong_hien_thi']='បង្ហាញលេខ';
$_L['kieu_hien_thi']='បង្ហាញ';
$_L['new']='ថ្មី';
$_L['hot']='មើលច្រើនទៀត';
$_L['az']='A ដល់ Z';
$_L['dang_luoi']='ក្រឡាចត្រង្គ';
$_L['danh_sach']='បញ្ជី';
$_L['per_page']='អាល់ប៊ុមនៅលើទំព័រ';
$_L['reset_default']='ត្រឡប់ទៅលំនាំដើម';
$_L['tags']='ស្លាក';
$_L['do_you_really_want_to_reset']='អ្នកនឹងត្រឡប់ទៅការកំណត់លំនាំដើម?';
$_L['album_vip']='លក្ខណៈពិសេសនៃអាល់ប៊ុម';
$_L['noti_change']='តើអ្នកយល់ព្រមការផ្លាស់ប្តូរតំណភ្ជាប់ SEO ដែល url';



