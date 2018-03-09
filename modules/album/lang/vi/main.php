<?php
/**
 * @Project BNC v2 -> Admin -> Album
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

/*----Lang Menu ----*/
$_L['title_header']                 = 'Album - Quản trị website';
$_L['title_module']                 = 'Album';
$_L['title_module_m']               = 'Album';
$_L['title_manager_mod']            = 'Album';
$_L['breadcrumb_mod']               = 'Album';

//new album page
//$_L['xx'] = 'xx';
$_L['chon_anh_dai_dien']            = 'Thay ảnh';
$_L['co_chac_muon_lam_moi_ko']      = 'Cảnh báo: Bạn chắc chắn làm mới album này?';
$_L['go_new']                       = 'Làm mới';
$_L['album_new']                    = 'Đăng album mới';
$_L['album_new_sort']               = 'Album mới';
$_L['album_hot']                    = 'Album hot';
$_L['album_random']                 = 'Album ngẫu nhiêu';
$_L['sap_xep_tin']                  = 'Sắp xếp tin tức';
$_L['so_luong_hien_thi']            = 'Số lượng hiển thị';
$_L['hien_album_cung_danh_muc']     = 'Hiện album cùng danh mục';
$_L['load_more']                    = 'Xem thêm';
$_L['related_list']                 = 'Danh sách album liên quan tự chọn';
$_L['related']                      = 'Chọn album liên quan';
$_L['related_noti']                 = '';
$_L['album_related']                = 'Album liên quan';
$_L['tim_theo_danh_muc']            = 'Tìm theo danh mục';
$_L['ban_muon_dang_ngay']           = 'Cảnh báo: Bạn sẽ đăng album này ngay bây giờ?';
$_L['hen_dang']                     = 'Hẹn đăng';
$_L['post_time']                    = 'Hẹn giờ đăng';
$_L['album_images']                 = 'Ảnh đại diện';
$_L['album_name']                   = 'Tên album';
$_L['images_noti']                  = 'Có thể chọn cùng lúc nhiều file để tải lên';
$_L['success_album_add']            = 'Đăng album thành công.';
$_L['ok']                           = 'Đồng ý';
$_L['cancel']                       = 'Hủy';
$_L['do_you_really_want_to_delete'] = 'Cảnh báo: Bạn thật sự muốn xóa album này?';
$_L['noti_information']             = 'Những trường có dấu * là bắt buộc';
$_L['basic_information']            = 'Thông tin cơ bản';
$_L['meta_information']             = 'Thông Tin Meta';
$_L['breadcrumb_album_new']         = 'Đăng album mới';
$_L['breadcrumb_album_edit']        = 'Sửa album';
$_L['title_manager_album']          = 'Quản lý album';
$_L['images']                       = 'Hình ảnh';
$_L['category']                     = 'Danh mục';
$_L['check_all']                    = 'Chọn tất cả';

//new category page
$_L['search_title']                 = 'Tìm kiếm theo tên';
$_L['search']                       = 'Tìm kiếm';
$_L['category_name']                = 'Tên danh mục';
$_L['sort']                         = 'Sắp xếp';
$_L['status']                       = 'Trạng thái';
$_L['action']                       = 'Hành động';
$_L['alert']                        = 'Cảnh báo!';
$_L['no_data']                      = 'Không có bản ghi nào được tìm thấy! ';
$_L['main_category']                = 'Danh mục gốc';
$_L['error_just_not_idea']          = 'Có lỗi xảy ra xin thử lại!';
$_L['click_to_change_status']       = 'Click để đổi trạng thái';
$_L['hiding']                       = 'Đang ẩn';
$_L['showing']                      = 'Đang hiện';
$_L['click_to_edit']                = 'Click để sửa';
$_L['click_to_edit_order']                = 'Sắp xếp';
$_L['edit']                         = 'Sửa';
$_L['delete']                       = 'Xóa';
$_L['view_details']                 = 'Xem chi tiết';
$_L['sort_tooltips']                = 'Theo thứ tự nhỏ đến lớn';
$_L['success_category_add']         = 'Đăng danh mục thành công.';
$_L['breadcrumb_category_new']      = 'Đăng danh mục mới';
$_L['meta_title']                   = 'Tiêu đề nội dung';
$_L['meta_keywords']                = 'Từ khóa';
$_L['meta_description']             = 'Mô tả';
$_L['icon_img']                     = 'Biểu tượng';
$_L['bg_img']                       = 'Hình nền';
$_L['image_group']                  = 'Hình ảnh';
$_L['remove_image']                 = 'Loại bỏ';
$_L['status']                       = 'Trạng thái';
$_L['publuc']                       = 'Hiện';
$_L['private']                      = 'Ẩn';

$_L['breadcrumb_category']          = 'Danh mục';
$_L['title_manager_category']       = 'Quản lý danh mục album';
$_L['delete']                       = 'Xóa';

$_L['breadcrumb_category_edit']     = 'Sửa danh mục';
$_L['parent_not_translate']         = 'Hãy dịch danh mục cha trước!';
$_L['error_update']                 = 'Không tìm thấy danh mục!';
$_L['error_update_album']           = 'Không tìm thấy album!';

//ajax page
$_L['delete_item_dialog']           = 'Cảnh báo: Xoá danh mục này toàn bộ danh mục con. Và album sử dụng những danh mục này sẽ được xoá theo! Bạn chắc chắn xoá ?';
$_L['delete_all_dialog']            = 'Cảnh báo: Xoá tất cả danh mục bạn đã chọn, toàn bộ danh mục con. Và album sử dụng những danh mục này sẽ được xoá theo! Bạn chắc chắn xoá ?';
$_L['delete_item_album']            = 'Cảnh báo: Bạn thật sự muốn xóa?';
$_L['delete_all_album']             = 'Cảnh báo: Bạn muốn xóa tất cả album đã chọn?';

$_L['parent_category_is_hide']      = 'Danh mục cha đang ẩn!';
$_L['error_empty_title']            = 'Dữ liệu không được để trống!';
$_L['error_number_only']            = 'Chỉ chấp nhận dữ liệu là số!';

//upload
$_L['dragDropStr']                  = 'Kéo & Thả Files Ở Đây';
$_L['abortStr']                     = 'Ngưng tải';
$_L['loadingStr']                   = 'Đang tải';
$_L['placeholderTextStr']           = 'Tiêu đề ảnh...';
$_L['placeholderTextAreaStr']       = 'Mô tả ảnh...';
$_L['chooseStr']                    = 'Chọn làm ảnh đại diện';
$_L['none_avatar']                  = 'Vui lòng chọn ảnh đại diện!';
$_L['add_image']                    = 'Thêm ảnh';

$_L['chon_avatar_tieu_de']          = 'Quản lý ảnh album';
$_L['do_you_really_want_to_delete_pic']          = 'Cảnh báo: Bạn thật sự muốn xóa ảnh này?';
$_L['save']                         = 'Lưu';
$_L['reset'] = 'Làm mới';
$_L['hien_album_tu_chon']           = 'Hiện album liên quan tự chọn';
$_L['option_post'] = 'Tùy chọn đăng';
$_L['alert_hide_by_cate']           = 'Album này có thể không được hiện trước người xem. Vì danh mục của album đang ẩn!';

$_L['breadcrumb_setting']           = 'Cài đặt album';
$_L['setting_information']          = 'Cài đặt trang album';
$_L['setting_define']               = 'Hệ thống sẽ áp dụng mặc định ở những phần đã được bỏ trống!...';

$_L['kieu_sap_xep']                 = 'Kiểu sắp xếp';
$_L['so_luong_hien_thi']            = 'Số lượng hiển thị';
$_L['kieu_hien_thi']                = 'Kiểu hiển thị';
$_L['new']                          = 'Mới nhất';
$_L['hot']                          = 'Xem nhiều';
$_L['az']                           = 'A đến Z';
$_L['dang_luoi']                    = 'Dạng lưới';
$_L['danh_sach']                    = 'Danh sách';
$_L['per_page']                     = 'Album trên trang';
$_L['reset_default']                     = 'Trở về mặc định';
$_L['tags']                     = 'Tags';

$_L['do_you_really_want_to_reset']  = 'Bạn sẽ trả cài đặt trở về mặc định?';
$_L['album_vip']                  = 'Album nổi bật';
$_L['noti_change']                = 'Bạn có đồng ý thay đổi link SEO URL';
$_L['copy_cate']                     = 'Sao chép danh mục album';
$_L['copy_cate_note']                     = '- Bạn có thể sao chép được toàn bộ danh mục album sang ngôn ngữ được định sẵn.<br>
                        - Tất cả dữ liệu từ bên ngôn ngữ gốc sẽ được bảo toàn khi chuyển qua ngôn ngữ mới.';
$_L['select_lang']                     = 'Chọn ngôn ngữ sao chép sang';
$_L['delete_all_cate']                     = 'Bạn có muốn xóa tất cả danh mục album ?';
$_L['empty_for_copy']                     = 'Làm rỗng trước khi sao chép';
$_L['close']                     = 'Đóng';
$_L['show_home']                     = 'Hiện trang chủ';
$_L['copy_lang']                     = 'Sao chép ngôn ngữ';
$_L['copy_album']                     = 'Sao chép album';
$_L['note_copy_album']                     = '- Bạn có thể sao chép được toàn bộ album sang ngôn ngữ được định sẵn.<br>
                        - Tất cả dữ liệu từ bên ngôn ngữ gốc sẽ được bảo toàn khi chuyển qua ngôn ngữ mới.';
$_L['show_album']                     = 'Hiện album liên quan';
