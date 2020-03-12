<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Server
 *
 * @property int $id
 * @property string|null $name 服务器名称
 * @property string|null $ip 服务器IP
 * @property string|null $username 服务器账号
 * @property string|null $password 服务器密码
 * @property int|null $type 服务器类型（是FTP还是SFTP还是其他）
 * @property string|null $remark 备注
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereUsername($value)
 * @mixin \Eloquent
 * @property int|null $port SSH端口号
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server wherePort($value)
 */
class Server extends Model
{
    protected static $options = [];

    /**
     * 指定默认表名称
     *
     * @var string
     */
    protected $table = 'server';

    /**
     * 默认不维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    const TYPE = [
        1 => 'SFTP',
        2 => 'FTP'
    ];

    /**
     * 获取服务器列表
     *
     * @return array
     * @author Vencenty <yanchengtian0536@163.com>
     */
    public static function options()
    {
        if (!static::$options) {
            $servers = self::all();
            $options = [];
            foreach ($servers as $key => $server) {
                $options[$server->id] = "[$server->ip]# $server->desc";
            }
            static::$options = $options;
        }

        return static::$options;
    }
}
