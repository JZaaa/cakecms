<?php $this->start('css')?>
<link href="<?php echo $this->Url->webroot('assets/zui/lib/uploader/zui.uploader.min.css')?>" rel="stylesheet">
<?php $this->end()?>
<div class="zad-header">
    <?php echo $this->Util->getBtn(
        [
            'name' => '新增',
            'class' => 'btn-primary',
            'url' => ['plugin' => 'Admin', 'controller' => 'Sliders', 'action' => 'add'],
            'toggle' => 'dialog'
        ]
    )?>
</div>
<div class="zad-content">
    <table class="table table-hover table-bordered text-center">
        <thead>
        <tr>
            <td>tag</td>
            <td>图片</td>
            <td>链接</td>
            <td>标题</td>
            <td>描述</td>
            <td>排序</td>
            <td>操作</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $item):?>
            <tr>
                <td><?php echo $item->tag?></td>
                <td><img src="<?php echo $this->Url->webroot($item->pic)?>" style="height: 30px"></td>
                <td><?php echo $item->url?></td>
                <td><?php echo $item->title?></td>
                <td><?php echo $item->sub?></td>
                <td><?php echo $item->sort?></td>
                <td>
                    <?php
                        echo $this->Util->getBtn(
                            [
                                'name' => '编辑',
                                'class' => 'btn-primary btn-sm',
                                'url' => ['plugin' => 'Admin', 'controller' => 'Sliders', 'action' => 'edit', $item->id],
                                'toggle' => 'dialog'
                            ],
                            [
                                'name' => '删除',
                                'class' => 'btn-danger btn-sm',
                                'url' => ['plugin' => 'Admin', 'controller' => 'Sliders', 'action' => 'delete', $item->id],
                                'toggle' => 'doajax'
                            ]
                        );
                    ?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <?php echo $this->MyPage->show()?>
</div>
<?php $this->start('js_before')?>
    <script src="<?php echo $this->Url->webroot('assets/zui/lib/uploader/zui.uploader.min.js')?>"></script>
<?php $this->end()?>