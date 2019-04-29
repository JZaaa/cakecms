<div class="zad-header">
    <form autocomplete="off" method="get" class="form-inline">
        <div class="form-group input-control">
            <select id="site_menu" name="site_menu" class="chosen-select form-control" data-toggle="selectpicker">
                <option value=""> 全部栏目 </option>
                <?php foreach ($siteMenus as $key => $item):?>
                    <option value="<?php echo $key?>" <?php if ($siteMenu == $key) echo 'selected'?>><?php echo $item?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="form-group input-control has-label-left">
            <input type="text" class="form-control" name="title" value="<?php echo $title?>">
            <label class="input-control-label-left">标题:</label>
        </div>
        <button type="submit" class="btn btn-info">查询</button>
        <?php
        if (!in_array($type, [1])) {
            // 单页不可新增
            echo $this->Util->getBtn(
                [
                    'name' => '新增',
                    'class' => 'btn-primary',
                    'url' => ['plugin' => 'Admin', 'controller' => 'Articles', 'action' => 'add', '?' => ['type' => $type]],
                    'toggle' => 'redirect'
                ]
            );
        }
        ?>
    </form>
</div>
<div class="zad-content">
    <table class="table table-hover table-bordered text-center">
        <thead>
        <tr>
            <th>标题</th>
            <th>所属栏目</th>
            <th>状态</th>
            <th>发布日期</th>
            <th>修改日期</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $item):?>
            <tr>
                <td><?php echo $item->title;
                    if ($item['istop'] == 1):?>
                        <span class="label label-danger label-outline">置顶</span>
                    <?php endif;?>
                </td>
                <td><?php echo $item->site_menu->name?></td>
                <td><?php echo ($item->status == 1) ? '发布' : '草稿'?></td>
                <td><?php echo $item->date?></td>
                <td><?php echo $item->modified?></td>
                <td>
                    <a class="btn btn-sm" target="_blank" href="<?php echo $this->Url->build(['plugin' => 'Website', 'controller' => 'Page', 'action' => 'view', $item->id, '?' => ['tmp' => 1]])?>">预览</a>
                    <?php if (in_array($item->site_menu->type, [1])) {
                        // 单页不可删除
                        echo $this->Util->getBtn(
                            [
                                'name' => '编辑',
                                'class' => ' btn-info btn-sm',
                                'url' => ['plugin' => 'Admin', 'controller' => 'Articles', 'action' => 'edit', $item->id, '?' => ['type' => $type]],
                                'toggle' => 'redirect'
                            ]
                        );
                    } else {
                        echo $this->Util->getBtn(
                            [
                                'name' => '编辑',
                                'class' => ' btn-info btn-sm',
                                'url' => ['plugin' => 'Admin', 'controller' => 'Articles', 'action' => 'edit', $item->id, '?' => ['type' => $type]],
                                'toggle' => 'redirect'
                            ],
                            [
                                'name' => '删除',
                                'class' => 'btn-danger btn-sm',
                                'url' => ['plugin' => 'Admin', 'controller' => 'Articles', 'action' => 'delete', $item->id],
                                'toggle' => 'doajax'
                            ]
                        );
                    }
                    ?>

                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <?php echo $this->MyPage->show()?>
</div>