<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Batch\BackupDatabase;
use App\Admin\Actions\Row\SendBackup;
use App\Models\Server;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'))->editable();
        $grid->column('email', __('Email'))->label('warning')->copyable();
        $grid->column('database_name', __('Database name'))->label('danger');
        $grid->column('server_id', '所在服务器')
            ->using(Server::options())
            ->label();
        $grid->column('created_at', __('Created at'))->hide();
        $grid->column('updated_at', __('Updated at'))->hide();
        $grid->column('备份操作')->action(new SendBackup());
        $grid->actions(function ($action) {
            $action->add(new \App\Admin\Actions\Row\BackupDatabase());
        });

        $grid->batchActions(function ($batch) {
            $batch->add(new BackupDatabase());
        });
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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('database_name', __('Database name'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('name', __('Name'));
        $form->email('email', __('Email'))->placeholder('请输入接受备份的邮箱');
        $form->select('server_id', __('所在服务器'))->options(Server::options());
        $form->text('database_name', __('Database name'))
            ->placeholder('严格匹配数据库字段,不允许空格以及特殊字符出现');

        return $form;
    }
}
