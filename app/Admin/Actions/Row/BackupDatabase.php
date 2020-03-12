<?php

namespace App\Admin\Actions\Row;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class BackupDatabase extends RowAction
{
    public $name = '备份数据库并发送到客户邮箱';

    public function handle(Model $model)
    {

        return $this->response()->success('发送成功')->refresh();
    }

}