<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CakeCMS - 登录</title>
    <link href="<?php echo $this->Url->webroot('assets/zui/css/zui.min.css')?>" rel="stylesheet">
    <link href="<?php echo $this->Url->webroot('css/admin.css')?>" rel="stylesheet">
</head>
<body>
<div class="container zad_container_main">
    <div class="zad_login_wrapper">
        <div class="zad_login">
            <div class="login_content">
                <div class="login_header">登录</div>
                <form class="login_form" action="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Users', 'action' => 'login'])?>" method="post" autocomplete="off">
                    <div class="form-group">
                        <label for="username">用户名</label>
                        <input type="text" value="<?php if (isset($username)) echo $username?>" name="username" class="form-control" id="username" placeholder="用户名" data-rule="required">
                    </div>
                    <div class="form-group">
                        <label for="password">密码</label>
                        <input type="password" value="<?php if (isset($password)) echo $password?>" name="password" class="form-control" id="password" placeholder="密码" data-rule="required">
                    </div>
                    <div class="form-group">
                        <label for="password">
                            <?php
                            $flash = $this->Flash->render('tip');
                            if (!empty($flash)) {
                                ?><div style="color: red"><?php echo $flash;?></div><?php
                            } else {
                                echo '&nbsp;';
                            }
                            ?>
                        </label>
                        <button type="submit" class="btn btn-primary btn-block btn-lg">登录</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $this->Url->webroot('js/jquery.min.js')?>"></script>
<script src="<?php echo $this->Url->webroot('assets/zui/js/zui.min.js')?>"></script>
<script src="<?php echo $this->Url->webroot('assets/validator/jquery.validator.min.js?local=zh-CN')?>"></script>
<script src="<?php echo $this->Url->webroot('js/admin.js')?>"></script>
</body>
</html>
