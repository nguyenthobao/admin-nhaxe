<?php
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
class Modellanguage extends \Bncv2\Core\ModelBase
{
	
	function __construct() {
		parent::__construct();
	}

	/**
	 * [emptyBlock description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-10-26
	 * @param  [type]                     $lang [description]
	 * @return [type]                           [description]
	 */
	public function emptyBlock($lang)
	{
		$tmp_model=new Model($lang.'_block');
		$tmp_model->where('idw',$this->idw);
		return $tmp_model->delete();
	}

	/**
	 * [getBlocks description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-10-26
	 * @param  [type]                     $lang [description]
	 * @return [type]                           [description]
	 */
	public function getBlocks($lang)
	{
		$tmp_model=new Model($lang.'_block');
		$tmp_model->where('idw',$this->idw);
		return $tmp_model->get();
	}


	/**
	 * [copyBlocks description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-10-26
	 * @param  [type]                     $lang [description]
	 * @param  [type]                     $data [description]
	 * @return [type]                           [description]
	 */
	public function copyBlocks($lang,$data)
	{
		$tmp_model=new Model($lang.'_block');
		return $tmp_model->insert($data);
	}


//---------------------------------------------------


	/**
	 * [emptyHome description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-10-26
	 * @param  [type]                     $lang [description]
	 * @return [type]                           [description]
	 */
	public function emptyHome($lang)
	{
		$tmp_model=new Model($lang.'_home');
		$tmp_model->where('idw',$this->idw);
		return $tmp_model->delete();
	}

	/**
	 * [getHomes description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-10-26
	 * @param  [type]                     $lang [description]
	 * @return [type]                           [description]
	 */
	public function getHomes($lang)
	{
		$tmp_model=new Model($lang.'_home');
		$tmp_model->where('idw',$this->idw);
		return $tmp_model->get();
	}
	
	/**
	 * [copyHomes description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-10-26
	 * @param  [type]                     $lang [description]
	 * @param  [type]                     $data [description]
	 * @return [type]                           [description]
	 */
	public function copyHomes($lang,$data)
	{
		$tmp_model=new Model($lang.'_home');
		return $tmp_model->insert($data);
	}
}