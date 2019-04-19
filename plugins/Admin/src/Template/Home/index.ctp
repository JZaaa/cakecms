<div class="zad-content">
    <div class="alert">
        <div class="content">
            当前登录用户：<code><?php echo $user['username'] , ' ', $user['nickname']?></code>，登录时间：<code><?php echo $user['modified']?></code>，登录IP：<code><?php echo $user['login_ip']?></code>，累计登录<code><?php echo $user['login_count']?></code>次
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <span class="title">服务器信息</span>
                </div>
                <table class="table table-hover table-bordered table-list">
                    <?php foreach ($env as $item):?>
                        <tr>
                            <td><?php echo $item['label']?></td>
                            <td><?php echo $item['value']?></td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
        </div>
    </div>

</div>
