<form action="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Users', 'action' => 'edit', $data->id])?>" method="post" data-toggle="ajaxform" autocomplete="off">
    <input type="hidden" value="<?php echo $data->id?>" name="id">
    <div class="form-group">
        <label for="username" class="required">用户名</label>
        <input id="username" name="username" value="<?php echo $data->username?>" type="text" class="form-control" data-rule="required">
    </div>
    <div class="form-group">
        <label for="password">密码</label>
        <input id="password" name="password" value="" type="password" class="form-control" data-rule="密码:" placeholder="为空则不修改原密码">
    </div>
    <div class="form-group">
        <label for="repassword">确认密码</label>
        <input id="repassword" name="confirmPwd" value="" type="password" class="form-control" data-rule="确认密码:match(password)">
    </div>
    <div class="form-group">
        <label for="nickname" class="required">昵称</label>
        <input type="text" id="nickname" name="nickname" value="<?php echo $data->nickname?>" class="form-control" data-rule="required">
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="role_id">用户角色</label>
                <select id="role_id" name="role_id" class="chosen-select form-control" data-toggle="selectpicker" data-rule="required">
                    <?php foreach ($roles as $key => $item):?>
                        <option value="<?php echo $key?>" <?php if ($key == $data->role_id) echo 'selected'?>><?php echo $item?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="status">状态</label>
                <select id="status" name="status" class="chosen-select form-control" data-toggle="selectpicker">
                    <?php foreach ($status as $key => $item):?>
                        <option value="<?php echo $key?>" <?php if ($key == $data->status) echo 'selected'?>><?php echo $item?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group text-right">
        <button type="submit" class="btn btn-info">提交</button>
    </div>
</form>
