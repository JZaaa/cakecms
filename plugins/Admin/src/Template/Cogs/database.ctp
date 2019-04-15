<div class="zad-content">
    <table class="table table-bordered table-hover text-center">
        <thead>
        <tr>
            <th>
                <div class="checkbox-primary inline-block"><input type="checkbox" data-toggle="checkgroup" data-group="name"><label></label></div>
            </th>
            <th>表名</th>
            <th>引擎</th>
            <th>编码</th>
            <th>版本</th>
            <th>行数</th>
            <th>创建时间</th>
            <th>最后修改时间</th>
            <th>大小</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $totalSize = 0;
        $num = 0;
        foreach ($data as $item):?>
            <tr>
                <td>
                    <div class="checkbox-primary inline-block">
                        <input type="checkbox" name="name" value="<?php echo $item['Name']?>">
                        <label></label>
                    </div>
                </td>
                <td><?php echo $item['Name']?></td>
                <td><?php echo $item['Engine']?></td>
                <td><?php echo $item['Collation']?></td>
                <td><?php echo $item['Version']?></td>
                <td><?php echo $item['Rows']?></td>
                <td><?php echo $item['Create_time']?></td>
                <td><?php echo $item['Update_time']?></td>
                <td><?php echo $size = round(($item['Data_length'] + $item['Index_length'])/1024,2) , 'KB'?></td>
            </tr>
            <?php
            $totalSize += $size;
            $num++;
        endforeach;?>
        <tr>
            <td colspan="9">共 <?php echo $num?> 张表，总大小：<?php echo $totalSize , 'KB'?></td>
        </tr>

        </tbody>
    </table>
    <button class="btn btn-danger" type="button" onclick="database('yh')">优化表</button>
    <button class="btn btn-danger" type="button" onclick="database('xf')">修复表</button>
    <button class="btn btn-danger" type="button" onclick="database('bf')">备份表</button>
    <button class="btn btn-danger" type="button" onclick="database('bfdb')">备份数据库</button>
</div>
<?php $this->start('js')?>
<script>
   function database(type) {
     var checkbox = $('[data-toggle="checkgroup"]').data('zad.checkgroup')
     var checked = checkbox.getCheckedValue()
     if (type !== 'bfdb' && checked.length <= 0) {
       $.alertmsg('danger', '请至少选中一项')
     } else {
       $(this).doAjax({
         url: '<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Cogs', 'action' => 'database'])?>',
         method: 'POST',
         data: {
           type: type,
           tables: checked
         }
       })
     }

   }
</script>
<?php $this->end()?>
