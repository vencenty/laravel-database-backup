<?php

namespace App\Admin\Actions\Batch;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;

class BackupDatabase extends BatchAction
{
    public $name = '备份数据库';

    public function handle(Collection $collection)
    {
        return $this->response()->success('Success message...')->refresh();
    }

}