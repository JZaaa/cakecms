<div class="zad-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <span class="title">服务器信息</span>
                </div>
                <div class="panel-body no-padding">
                    <table class="table table-hover table-bordered no-margin">
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

</div>
