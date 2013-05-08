<?php

/**
 * CLinkPager class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CLinkPager displays a list of hyperlinks that lead to different pages of target.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id$
 * @package system.web.widgets.pagers
 * @since 1.0
 */
class InfinitePager extends CBasePager {

    /**
     * Initializes the pager by setting some default property values.
     */
    public function init() {
    }

    public function run() {
        
        $currentPage = $this->getCurrentPage(false);
        if (($page = $currentPage + 1) <= $this->getPageCount() - 1)
            echo Html::tag("a", array(
                "href" => $this->createPageUrl($currentPage + 1),
                "class" => "btn btn-small"
                    ), "More Results");
    }
}
