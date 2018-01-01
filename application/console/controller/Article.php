<?php
// +----------------------------------------------------------------------+
// | CYCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2018 http://www.benweng.com All rights reserved.       |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 *
 * @filename  Article.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-11-29 10:33:12
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\console\controller;

use app\console\controller\Base;

class Article extends Base {
	public function initialize() {
		parent::initialize();

		$category = $this->app->model('category')->select();
		$this->assign('category', $category);

	}
}
