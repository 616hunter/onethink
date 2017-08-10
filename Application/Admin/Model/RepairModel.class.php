<?php
/**
 * Created by PhpStorm.
 * User: tw
 * Date: 2017/8/10
 * Time: 14:40
 */

namespace Admin\Model;


use Think\Model;

class RepairModel extends Model
{
    protected $_validate = array(
        array('username', 'require', '字段名必须'),
//        array('tel', '/^[a-zA-Z][\w_]{1,29}$/', '字段名不合法'),
        array('tel', 'require', '电话不能为空'),
        array('address', 'require', '地址不能为空'),
        array('status', 'require', '状态不能为空'),

    );
}