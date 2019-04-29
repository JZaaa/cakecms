<?php $this->start('css')?>
    <link href="<?php echo $this->Url->webroot('assets/zui/lib/colorpicker/zui.colorpicker.min.css')?>" rel="stylesheet">
    <link href="<?php echo $this->Url->webroot('assets/zui/lib/uploader/zui.uploader.min.css')?>" rel="stylesheet">
<?php $this->end()?>
    <div class="zad-content">
        <form action="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Articles', 'action' => 'add', '?' => ['type' => $type]])?>" method="post" data-toggle="ajaxform" autocomplete="off">
            <ul class="nav nav-tabs">
                <li class="active"><a href="javascript:;" data-target="#baseContent" data-toggle="tab">基本内容</a></li>
                <li><a href="javascript:;" data-target="#otherContent" data-toggle="tab">拓展内容</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="baseContent">
                    <div class="with-padding">
                        <div class="form-group">
                            <label for="site_menu_id" class="required">栏目</label>
                            <select id="site_menu_id" name="site_menu_id" class="chosen-select form-control" data-toggle="selectpicker">
                                <?php foreach ($siteMenus as $key => $item):?>
                                    <option value="<?php echo $key?>"><?php echo $item?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title" class="required">标题</label>
                            <input id="title" name="title" value="" type="text" class="form-control" data-rule="required">
                        </div>
                        <div class="form-group">
                            <label for="subtitle">副标题</label>
                            <input id="subtitle" name="subtitle" value="" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="abstract">摘要</label>
                            <textarea id="abstract" name="abstract" class="form-control"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label for="color">标题颜色</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="color" name="color" data-provide="colorpicker" data-wrapper="input-group-btn" data-pull-menu-right="true" value="" placeholder="请输入16进制颜色值，例如 #FF00DD">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label for="date">发布日期</label>
                                    <input id="date" name="date" value="<?php echo date('Y-m-d H:i:s')?>" type="text" class="form-control" data-toggle="datepicker" data-type="datetime">
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label for="source">来源</label>
                                    <input id="source" name="source" value="" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label for="author">作者</label>
                                    <input id="author" name="author" value="" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label for="istop">置顶</label>
                                    <select id="istop" name="istop" class="chosen-select form-control" data-toggle="selectpicker">
                                        <option value="2">否</option>
                                        <option value="1">是</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label for="status">状态</label>
                                    <select id="status" name="status" class="chosen-select form-control" data-toggle="selectpicker">
                                        <option value="1">发布</option>
                                        <option value="2">草稿</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label for="visit">访问数</label>
                                    <input id="visit" name="visit" value="0" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content">内容</label>
                            <textarea id="content" data-toggle="kindeditor" name="content" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="otherContent">
                    <div class="with-padding">
                        <div class="uploader form-group" data-toggle="upload" data-url="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Upload', 'action' => 'image'])?>" data-response-handler="responseHandler" data-delete-action-on-done="deleteActionOnDone">
                            <label>缩略图</label>
                            <input type="hidden" name="thumb">
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
                            <label for="seo_keywords">SEO关键字</label>
                            <input id="seo_keywords" name="seo_keywords" value="" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="seo_description">SEO描述</label>
                            <textarea id="seo_description" name="seo_description" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group text-right with-padding">
                <button class="btn" type="button" onclick="window.history.back()">取消</button>
                <button type="submit" class="btn btn-info">提交</button>
            </div>
        </form>
    </div>
<?php $this->start('js_before')?>
    <script src="<?php echo $this->Url->webroot('assets/zui/lib/colorpicker/zui.colorpicker.min.js')?>"></script>
    <script src="<?php echo $this->Url->webroot('assets/zui/lib/kindeditor/kindeditor.min.js')?>"></script>
    <script src="<?php echo $this->Url->webroot('assets/zui/lib/uploader/zui.uploader.min.js')?>"></script>
    <script src="<?php echo $this->Url->webroot('assets/laydate/laydate.js')?>"></script>
    <script>
      function responseHandler(responseObject, file) {
        var response = (typeof responseObject.response === 'string') ? JSON.parse(responseObject.response) : responseObject.response
        if (response.code !== 200) {
          return response.message
        } else {
          $('input[name="thumb"]').val(response.data.filePath)
        }
      }
      function deleteActionOnDone(file, doRemoveFile) {
        $('input[name="thumb"]').val('')
        return true
      }
    </script>
<?php $this->end()?>