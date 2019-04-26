<?php $this->start('css')?>
<link href="<?php echo $this->Url->webroot('assets/zui/lib/uploader/zui.uploader.min.css')?>" rel="stylesheet">
<?php $this->end()?>
<div class="zad-header">
    <?php echo $this->Util->getBtn(
        [
            'name' => '新增',
            'class' => 'btn-primary',
            'url' => ['plugin' => 'Admin', 'controller' => 'SiteMenus', 'action' => 'add'],
            'toggle' => 'dialog'
        ]
    )?>
</div>
<div class="zad-content">
    <table class="table table-hover table-bordered table-condensed text-center">
        <thead>
        <tr>
            <th>名称</th>
            <th>类型</th>
            <th>状态</th>
            <th>排序</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $item):?>
            <tr>
                <td class="text-left"><?php echo $item->name?></td>
                <td><?php echo $types[$item->type]?></td>
                <td><?php echo $status[$item->status]?></td>
                <td><?php echo $item->sort?></td>
                <td>
                    <?php echo $this->Util->getBtn(
                        [
                            'name' => '编辑',
                            'class' => 'btn-info btn-sm',
                            'url' => ['plugin' => 'Admin', 'controller' => 'SiteMenus', 'action' => 'edit', $item->id],
                            'toggle' => 'dialog'
                        ],
                        [
                            'name' => '删除',
                            'class' => 'btn-danger btn-sm',
                            'url' => ['plugin' => 'Admin', 'controller' => 'SiteMenus', 'action' => 'delete', $item->id],
                            'toggle' => 'doajax'
                        ]
                    )?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>
<?php $this->start('js_before')?>
    <script src="<?php echo $this->Url->webroot('assets/zui/lib/uploader/zui.uploader.min.js')?>"></script>
<?php $this->end()?>