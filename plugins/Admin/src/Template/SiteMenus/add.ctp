<script>
  function responseHandler(responseObject, file) {
    var response = (typeof responseObject.response === 'string') ? JSON.parse(responseObject.response) : responseObject.response
    if (response.code !== 200) {
      return response.message
    } else {
      $.CurrentDialog().find('input[name="pic"]').val(response.data.filePath)
    }
  }
  function deleteActionOnDone(file, doRemoveFile) {
    $.CurrentDialog().find('input[name="pic"]').val('')
    return true
  }
  $.CurrentDialog().find('[data-toggle="popover"]').popover();
</script>
<form action="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'SiteMenus', 'action' => 'add'])?>" method="post" data-toggle="ajaxform" autocomplete="off">
    <div class="form-group">
        <label for="name">名称</label>
        <input id="name" name="name" value="" type="text" class="form-control" data-rule="required">
    </div>
    <div class="form-group">
        <label for="parent_id">父级</label>
        <select id="parent_id" name="parent_id" class="chosen-select form-control" data-toggle="selectpicker">
            <option value="">顶级</option>
            <?php foreach ($parents as $key => $item):?>
                <option value="<?php echo $key?>"><?php echo $item?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="form-group">
        <label for="subname">别名</label>
        <input id="subname" name="subname" value="" type="text" class="form-control">
    </div>
    <div class="form-group">
        <label for="type">类型</label>
        <select id="type" name="type" class="chosen-select form-control" data-toggle="selectpicker">
            <?php foreach ($types as $key => $item):?>
                <option value="<?php echo $key?>"><?php echo $item?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <label for="list_tpl">列表模板</label>
                <select id="list_tpl" name="list_tpl" class="chosen-select form-control" data-toggle="selectpicker">
                    <option value="">请选择</option>
                    <?php foreach ($listTpls as $key => $item):?>
                        <option value="<?php echo $key?>"><?php echo $item?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label for="content_tpl">内容模板</label>
                <select id="content_tpl" name="content_tpl" class="chosen-select form-control" data-toggle="selectpicker">
                    <?php foreach ($contentTpls as $key => $item):?>
                        <option value="<?php echo $key?>"><?php echo $item?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="status">状态</label>
        <select id="status" name="status" class="chosen-select form-control" data-toggle="selectpicker">
            <?php foreach ($status as $key => $item):?>
                <option value="<?php echo $key?>"><?php echo $item?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="uploader form-group" data-toggle="upload" data-url="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Upload', 'action' => 'image'])?>" data-response-handler="responseHandler" data-delete-action-on-done="deleteActionOnDone">
        <label>图片</label>
        <input type="hidden" name="pic">
        <div class="uploader-message text-center">
            <div class="content"></div>
            <button type="button" class="close">×</button>
        </div>
        <div class="uploader-files file-list file-list-grid"></div>
        <div>
            <hr class="divider">
            <div class="uploader-status pull-right text-muted"></div>
            <button type="button" class="btn btn-link uploader-btn-browse"><i class="icon icon-plus"></i> 选择文件</button>
        </div>
    </div>
    <div class="form-group">
        <label for="custom_url">固定链接 </label> <i class="icon icon-info-sign text-blue" data-toggle="popover" data-placement="top" data-content="请勿使用纯数字或特殊字符作为链接地址,保留地址:/home,/admin,/page"></i>
        <input id="custom_url" name="custom_url" value="" placeholder="示例：/about 或 /my-page/index" type="text" class="form-control">
    </div>
    <div class="form-group">
        <label for="link">外链</label>
        <input id="link" name="link" value="" placeholder="http://" type="text" class="form-control">
    </div>
    <div class="form-group">
        <label for="sort">排序</label>
        <input id="sort" name="sort" value="0" type="text" class="form-control" data-rule="required;integer(+0)">
    </div>
    <div class="form-group text-right">
        <button type="submit" class="btn btn-info">提交</button>
    </div>
</form>
