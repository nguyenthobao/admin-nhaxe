<?php
/**
 * NXT
 */
class nxt_global {
	public function pageBasic() {
		global $_B;
		$page = array(
			'basic' => array(
				'name'    => 'Trang cơ bản',
				'mod'     => '',
				'page'    => 'basic',
				'sub'     => '',
				'content' => array(
					array(
						'id'        => '',
						'id_lang'   => '',
						'parent_id' => 0,
						'title'     => 'Trang chủ',
						'line'      => '',
						'str_id'    => '',
						'content'   => '/',
					),
					array(
						'id'        => '',
						'id_lang'   => '',
						'parent_id' => 0,
						'title'     => 'Trang Bản đồ',
						'line'      => '',
						'str_id'    => '',
						'content'   => '/maps' . $_B['cf']['dotExtension'],
					),
					array(
						'id'        => '',
						'id_lang'   => '',
						'parent_id' => 0,
						'title'     => 'Trang liên hệ',
						'line'      => '',
						'str_id'    => '',
						'content'   => '/contact' . $_B['cf']['dotExtension'],
					),
					array(
						'id'        => '',
						'id_lang'   => '',
						'parent_id' => 0,
						'title'     => 'Trang giới thiệu',
						'line'      => '',
						'str_id'    => '',
						'content'   => '/info-info' . $_B['cf']['dotExtension'],
					),
				),
			),
		);
		return $page;
	}
}