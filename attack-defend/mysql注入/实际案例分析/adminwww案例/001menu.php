<?php
/**
 * 后台菜单采用"左右值"构建菜单树
 * 每个根菜单左值相隔1000, 这意味着每支最多有500个菜单
 * 这样做的好处是, 当因插入或删除时需要更新"左右值"时只需要更新本支, 减少需更新记录数量
 * 
 * 左右值参考资料: http://blog.csdn.net/i_bruce/article/details/41558063
 */

defined ( 'SYSPATH' ) or die ( 'No direct script access.' );
class action_configure_menu extends Controller_configure {
    
    /**
     * 
     * @var model_sysadmin
     */
    private $_adminModel = null;
    
    public function Page_Load() {
        parent::Page_Load ();
        $this->index ();
    }
    
    public function index() {
        $action = isset ( $_REQUEST ['ac'] ) ? trim ( $_REQUEST ['ac'] ) : 'getList';
        $this->_adminModel = new model_sysadmin();
        switch ($action) {
            case 'getList' :
                $this->getList ();
                break;
            case 'edit':
                $this->edit();
            case 'save' :
                $this->save ();
                break;
            case 'delete':
                $this->delete();
                break;
            default :
                $this->getList ();
                break;
        }
    }
    
    /**
     * 获取菜单列表
     */
    private function getList() {

        $menuList = $this->_adminModel->get_admin_menu_list();
        Difeye::$view->assign('menuList', $menuList);
        
        Difeye::$view->display ( 'configure/menuList.html' );
    }
    
    /**
     * 编辑/新增
     * id为0则新增
     */
    private function edit() {
        $id = (int) ($_REQUEST['id'] ?? 0);
        if ($id > 0) {
            $menu = $this->_adminModel->get_menu_by_id($id);
            if (!empty($menu)) {
                $pMenuList = $this->_adminModel->get_parent_menu($menu['menu_left'], $menu['menu_right'], 1);
                if (empty($pMenuList)) {
                    $pid = 0;
                } else {
                    $pMenu = reset($pMenuList);
                    $pid = $pMenu['menu_id'];
                }
            }
        } else {
            $menu = [];
        }
        
        $menuList = $this->_adminModel->get_admin_menu_list();
        
        Difeye::$view->assign('pid', $pid);
        Difeye::$view->assign('menu', $menu);
        Difeye::$view->assign('menuList', $menuList);
        
        Difeye::$view->display ( 'configure/menuEdit.html' );
    }
    
    /**
     * 保存
     */
    private function save() {
        $id = (int) ($_REQUEST['id'] ?? 0);
        $pid = (int) ($_REQUEST['pid'] ?? 0);
        $oldPid = (int) ($_REQUEST['oldPid'] ?? 0); // 原PID
        
        $newData = [];
        if (isset($_REQUEST['menu_title'])) {
            $newData['menu_title'] = trim($_REQUEST['menu_title']);
        }
        
        if (isset($_REQUEST['menu_tag'])) {
            $newData['menu_tag'] = trim($_REQUEST['menu_tag']);
        }
        
        if (isset($_REQUEST['menu_controller'])) {
            $newData['menu_controller'] = trim($_REQUEST['menu_controller']);
        }
        
        if (isset($_REQUEST['menu_action'])) {
            $newData['menu_action'] = trim($_REQUEST['menu_action']);
        }
        
        if (isset($_REQUEST['menu_params'])) {
            $newData['menu_params'] = trim($_REQUEST['menu_params']);
        }
        
        
        if (empty($newData)) {
            dwz_fail();
            return;
        }
        
        if ($id > 0) {
            $this->_adminModel->update_menu($id, $newData, $pid == $oldPid ? -1 : $pid);
            dwz_success('admin_menu','closeCurrent','');
            return;
        }
        
        $result = $this->_adminModel->add_menu($pid, $newData);
        
        if ($result) {
            dwz_success('admin_menu','closeCurrent','');
        } else {
            dwz_fail();
        }
    }
    
    /**
     * 删除
     */
    private function delete() {
        if (!$_REQUEST['id']) {
            dwz_fail();
            return;
        }
        
        $id = (int) $_REQUEST['id'];
        if ($id < 1) {
            dwz_fail();
            return;
        }
        
        $result = $this->_adminModel->delete_menu($id);
        
        if ($result) {
            dwz_success('admin_menu','forword','/configure/menu');
        } else {
            dwz_fail();
        }
    }
    
}


