<?php
/**
 *
 */
class global_block_nxt {

	public function routerPosition($key = null) {
		global $_B;
		$config = $_B['web']['configTheme']['blocks'];
		if (!isset($config) || count($config) == 0) {
			echo '<center><h1><font color="red">Không tồn tại file config.xml</font></h1></center>';
			die();
		}
		foreach ($config as $k => $v) {
			$result[$v['key']] = $v['name'];
		}
		if (!is_null($key)) {
			$result = $result[$key];
		}
		return $result;
	}
}

?>














