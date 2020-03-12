<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Batch\BatchBackupDatabase;
use App\Models\Server;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ServerController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\Server';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Server());

        $grid->column('id', __('Id'));
        $grid->column('ip', __('Ip'));
        $grid->column('port', __('Port'));
        $grid->column('username', __('Username'));
        $grid->column('remark', __('Remark'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Server::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('ip', __('Ip'));
        $show->field('username', __('Username'));
        $show->field('remark', __('Remark'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Server());

        $form->ip('ip', __('Ip'));
        $form->text('port', __('Port'))
            ->default('默认端口号');
        $form->textarea('remark', __('Remark'));
//        $form->text('username', __('Username'));
        $form->password('password', '服务器ROOT密码');
//        $form->text('db_username', '数据库用户名')->placeholder("只支持ROOT");
        $form->password('db_password', '数据库ROOT密码');

        return $form;
    }
}
