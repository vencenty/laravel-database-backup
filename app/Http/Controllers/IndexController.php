<?php

namespace App\Http\Controllers;

use App\Mail\DatabaseBackup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    public function index()
    {





        // step1. 执行登陆
        // step2. 执行打包命令
        // step3. 发送打包文件
//        $user = "root";
//        $pass = "al6GRdtgb2glsk2g";
//        $connection = ssh2_connect('103.120.225.186', 22);
//        ssh2_auth_password($connection, $user, $pass);
//
//        $sftp = ssh2_sftp($connection);
//        $resource = "ssh2.sftp://{$sftp}/tmp/database-backup/ems.sql";
////        $r = file_put_contents('ccccc.sql', $resource);
//        $r = copy($resource, './eeeee.sql');
//
//
//        // 创建备份文件夹,把创建的文件扔到里面去
//        $cmd = <<<CMD
//        mkdir /tmp/database-backup;
//        mysqldump -uroot -p24ed13536a46599e ems >> /tmp/database-backup/ems.sql;
//CMD;
//
//        $ret = ssh2_exec($connection, $cmd);
//        stream_set_blocking($ret, true);
//        echo(stream_get_contents($ret));

    }
}
