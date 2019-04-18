<form action="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Roles', 'action' => 'menu', $id])?>" method="post" data-toggle="ajaxform" autocomplete="off">
    <input type="hidden" value="<?php echo $data->id?>" name="id">
    <input type="hidden" name="role_menu" id="role_menu" value="<?php echo $data->role_menu?>">
    <ul id="tree" class="ztree"></ul>
    <div class="form-group text-right">
        <button type="submit" class="btn btn-info">提交</button>
    </div>
</form>
<script>
    var zTreeObj = $.fn.zTree.init($("#tree"), {
      data: {
        simpleData: {
          enable: true,
          rootPId: 0,
          pIdKey: "parent_id",
        }
      },
      check: {
        enable: true
      },
      callback: {
        onCheck: function(event, treeId, treeNode) {
          var checked = $.fn.zTree.getZTreeObj(treeId).getCheckedNodes(true)
          var checkedId = []
          $.each(checked, function(index, value) {
            checkedId.push(value.id)
          })
          $.CurrentDialog().find('#role_menu').val(checkedId.join(','))
        }
      }
    }, JSON.parse('<?php echo json_encode($menus)?>')).expandAll(true)

</script>
