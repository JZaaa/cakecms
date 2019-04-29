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
    function tagChange(obj) {
      var $newTag = $.CurrentDialog().find('#newtag')
      $newTag.val('')
      if ($(obj).val().length <= 0) {
        $newTag.parent().show()
      } else {
        $newTag.parent().hide()
      }
    }
</script>
<form action="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Sliders', 'action' => 'add'])?>" method="post" data-toggle="ajaxform" autocomplete="off">
    <div class="uploader form-group" data-toggle="upload" data-url="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Upload', 'action' => 'image'])?>" data-response-handler="responseHandler" data-delete-action-on-done="deleteActionOnDone">
        <label>图片</label>
        <input type="hidden" name="pic" data-rule="图片:required">
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
        <label for="title">标题</label>
        <input id="title" name="title" type="text" class="form-control">
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="tag">tag</label>
                <select id="tag" name="tag" class="chosen-select form-control" data-toggle="selectpicker" onchange="tagChange(this)">
                    <option value="home">home</option>
                    <?php foreach ($tags as $item):?>
                        <option value="<?php echo $item?>"><?php echo $item?></option>
                    <?php endforeach;?>
                    <option value="">新增</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group" style="display: none">
                <label for="newtag">新增tag</label>
                <input id="newtag" name="newtag" type="text" class="form-control">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="url">链接</label>
        <input id="url" name="url" type="text" class="form-control" placeholder="http://">
    </div>
    <div class="form-group">
        <label for="sub">描述</label>
        <input id="sub" name="sub" type="text" class="form-control">
    </div>

    <div class="form-group">
        <label for="sort" class="required">排序</label>
        <input id="sort" name="sort" value="0" type="text" class="form-control" data-rule="required;integer(+0)">
    </div>

    <div class="form-group text-right">
        <button type="submit" class="btn btn-info">提交</button>
    </div>
</form>
