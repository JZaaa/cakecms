<?php $this->start('css')?>
    <link href="<?php echo $this->Url->webroot('assets/zui/lib/uploader/zui.uploader.min.css')?>" rel="stylesheet">
<?php $this->end()?>
    <div class="zad-content">
        <form action="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Options', 'action' => 'index'])?>" method="post" data-toggle="ajaxform" autocomplete="off">
            <ul class="nav nav-tabs">
                <li class="active"><a href="javascript:;" data-target="#baseContent" data-toggle="tab">基本内容</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="baseContent">
                    <div class="with-padding">
                        <div class="form-group">
                            <label for="title">网站标题</label>
                            <input type="hidden" name="title[name]" value="网站标题">
                            <input id="title" name="title[value_field]" value="<?php if (isset($data['title']['value_field'])) echo $data['title']['value_field']?>" type="text" class="form-control">
                        </div>
                        <div class="uploader form-group" style="width: 200px" data-toggle="upload" data-url="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Upload', 'action' => 'image'])?>" data-file="<?php if ((isset($data['logo']['value_field'])) && !empty($data['logo']['value_field'])) echo $this->Url->webroot($data['logo']['value_field'])?>"  data-response-handler="responseHandler" data-delete-action-on-done="deleteActionOnDone">
                            <label>网站logo</label>
                            <input type="hidden" name="logo[name]" value="网站logo">
                            <input type="hidden" name="logo[value_field]" value="<?php if (isset($data['logo']['value_field'])) echo $data['logo']['value_field']?>">
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
                            <input type="hidden" name="seo_keywords[name]" value="SEO关键字">
                            <input id="seo_keywords" name="seo_keywords[value_field]" value="<?php if (isset($data['seo_keywords']['value_field'])) echo $data['seo_keywords']['value_field']?>" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="seo_description">SEO描述</label>
                            <input type="hidden" name="seo_description[name]" value="SEO描述">
                            <textarea id="seo_description" name="seo_description[value_field]" class="form-control"><?php if (isset($data['seo_description']['value_field'])) echo $data['seo_description']['value_field']?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="footer_left">底部左侧文字 <span class="label label-info">换行分割</span></label>
                            <input type="hidden" name="footer_left[name]" value="底部左侧文字">
                            <textarea id="footer_left" name="footer_left[value_field]" class="form-control"><?php if (isset($data['footer_left']['value_field'])) echo $data['footer_left']['value_field']?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="footer_right">底部右侧文字 <span class="label label-info">换行分割</span></label>
                            <input type="hidden" name="footer_right[name]" value="底部右侧文字">
                            <textarea id="footer_right" name="footer_right[value_field]" class="form-control"><?php if (isset($data['footer_right']['value_field'])) echo $data['footer_right']['value_field']?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="icp">备案号</label>
                            <input type="hidden" name="icp[name]" value="备案号">
                            <input id="icp" name="icp[value_field]" value="<?php if (isset($data['icp']['value_field'])) echo $data['icp']['value_field']?>" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="copyright">尾部信息</label>
                            <input type="hidden" name="copyright[name]" value="尾部信息">
                            <input id="copyright" name="copyright[value_field]" value="<?php if (isset($data['copyright']['value_field'])) echo $data['copyright']['value_field']?>" type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group text-right with-padding">
                <button type="submit" class="btn btn-info">提交</button>
            </div>
        </form>
    </div>
<?php $this->start('js_before')?>
    <script src="<?php echo $this->Url->webroot('assets/zui/lib/uploader/zui.uploader.min.js')?>"></script>
    <script>
      function responseHandler(responseObject, file) {
        var response = (typeof responseObject.response === 'string') ? JSON.parse(responseObject.response) : responseObject.response
        if (response.code !== 200) {
          return response.message
        } else {
          $('input[name="logo"]').val(response.data.filePath)
        }
      }
      function deleteActionOnDone(file, doRemoveFile) {
        $('input[name="logo"]').val('')
        return true
      }
    </script>
<?php $this->end()?>