<?php

namespace App\Admin\Actions\Row;

use App\Mail\DatabaseBackup;
use App\Models\User;
use Encore\Admin\Actions\RowAction;
use Illuminate\Support\Facades\Mail;

class SendBackup extends RowAction
{
    public function handle(User $user)
    {
        $server = $user->server;

        // 登录SSH
        $connection = ssh2_connect($server->ip, $server->port ?? 22);
        ssh2_auth_password($connection, $server->username ?? "root", $server->password);

        // 登录SFTP
        $sftp = ssh2_sftp($connection);

        // 创建备份文件夹,把创建的文件扔到里面去
        $backupFileName = $user->database_name . '_' . date('ymdhis', time());
        // 存储目录
        $storagePath = "/tmp/database-backup/{$backupFileName}.sql";

        $cmd = <<<CMD
        mkdir /tmp/database-backup;
        mysqldump -uroot -p{$server->db_password} {$user->database_name} >> {$storagePath};
CMD;
        // 执行命令
        $ret = ssh2_exec($connection, $cmd);
        stream_set_blocking($ret, true);
        // 如果有返回值,说明出现了错误
        $result = stream_get_contents($ret);


        if ($result) {
            $this->response()->error($result);
        }

        $resource = "ssh2.sftp://{$sftp}" . $storagePath;

        $localBackupPath = public_path('database-backup');

        // 本地没有存放备份的文件夹的话首先创建文件夹
        if (!is_dir($localBackupPath)) {
            mkdir($localBackupPath);
        }

        $dest = $localBackupPath . '/' . $backupFileName;

        $copyResult = copy($resource, $dest);


        if (!$copyResult) {
            return $this->response()->error("发生错误咯!");
        }
        $mailSendResult = Mail::to(['email' => $user->email])
            ->send(new DatabaseBackup($dest));


        if ($mailSendResult) {
            return $this->response()->error("操作失败")->refresh();
        }

        return $this->response()->success("操作成功")->refresh();
    }

    public function display($value)
    {
        return "<button>发送附件给客户</button>";
    }

    public function dialog()
    {
        $this->confirm("你确定要发送给客户备份吗?", '可能需要较长时间,请耐心等待', [
            'focusCancel' => true,
        ]);
    }


}