<?php

		/**
		 * 取角色列表
		 * @param int $page 页号
		 * @param int $pageSize 每页数量
		 * @return array 二维数组, 角色列表
		 */
		public function get_role_list($page = 0, $pageSize = 10) {
		    if ($pageSize > 0) {
		        $limit = ' LIMIT ' . ($pageSize * $page) . ', ' . $pageSize;
		    } else {
		        $limit = '';
		    }
		    
		    $strQuery = 'SELECT * FROM ' . $this->sysDB('admin_role') . ' WHERE `sys_is_del` = 0 ORDER BY `role_id` ASC' . $limit;
		    return $this->db->query(Database::SELECT,$strQuery,FALSE)->as_array();
		}


?>