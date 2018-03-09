<?php
/**
 *  @author Truong Nguyen
 * @email  truongnx28111994@gmail.com
 * @date   2015-06-12
 *
 */

class Permissions {

    function __construct() {
        global $_B;
        $this->request = $_B['r'];

    }
    /**
     * [isAjax description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-06-12
     * @return boolean                    [description]
     */
    public function isAjax() {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * [accessPermission description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-06-12
     * @param  [type]                     $action [description]
     * @return [type]                             [description]
     */
    public function accessPermission($action = null) {
        $mod  = $this->request->get_string('mod', 'GET');
        $page = $this->request->get_string('page', 'GET');
        $sub  = $this->request->get_string('sub', 'GET');
        $id   = $this->request->get_string('id', 'GET');
        //Kiem tra session
        if (isset($_SESSION['active_perm'])) {
            $active_perm = $_SESSION['active_perm'];
            //Kiem tra 2 POST lien quan toi public
            $NXTname   = strtolower($this->request->get_string('name', 'POST'));
            $NXTaction = strtolower($this->request->get_string('action', 'POST'));
            $NXTstatus = strtolower($this->request->get_string('status', 'POST'));

            if (
                (strpos($NXTname, 'active') !== false || strpos($NXTname, 'sort') !== false || strpos($NXTname, 'active') !== false)
                || (strpos($NXTaction, 'active') !== false || strpos($NXTaction, 'sort') !== false || strpos($NXTaction, 'active') !== false)
                || (isset($_POST['status']) && ($_POST['status'] == 0 || $_POST['status'] == 1))
            ) {
                $action = 'public';
            }
            switch ($action) {
            case 'insert':
                $result = $active_perm[$mod]['perm_add'];

                break;
            case 'update':
                $result = $active_perm[$mod]['perm_edit'];

                break;
            case 'delete':
                $result = $active_perm[$mod]['perm_del'];

                break;
            case 'get':
                $result = @$active_perm[$mod]['perm_view'];
                break;
            case 'getOne':
                $result = @$active_perm[$mod]['perm_view'];
                break;
            case 'public':
                $result = $active_perm[$mod]['perm_public'];
                break;
            }

            if (
                ($mod !== 'webuserlogout')
                && ($active_perm[$mod]['perm_public'] !== 'full')
                && $mod != 'home'
                && !empty($mod)
            ) {
                if (!isset($result) || $result == false) {
                    if ($this->isAjax()) {
                        http_response_code(403);
                        exit();
                    } else {
                        echo 'Không có quyền truy cập nhá Baby';
                        exit();
                    }
                }
            }
        }
    }
}

?>