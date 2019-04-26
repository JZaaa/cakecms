var $C_RIGHT = $('.zad_container_right')
var $CONTAINER = $('#zad_container_main')
var $MENU_TREE = $('#zad_menu_tree')
var CURRENT_URL = $MENU_TREE.data('activeUrl') ? $MENU_TREE.data('activeUrl') : window.location.href.split('#')[0].split('?')[0]
var C_DIALOG = undefined // 当前的dialog插件

$(document).ready(function() {
  // 右侧栏目设置高度
  var setContentHeight = function() {
    $C_RIGHT.css('height', $(window).height())
  }

  // 开启默认菜单
  var setActiveMenu = function() {
    var $active = $MENU_TREE.find('a[href="' + CURRENT_URL + '"]').parent('li').addClass('active')
    if ($active.length) {
      var $parents = $active.first().parents('li')
      $MENU_TREE.tree('expand', $parents)

    }
  }

  setContentHeight()
  setActiveMenu()
})

;(function($) {
  'use strict'

  window.ZAD = {
    eventType: {
      initUI: 'zad.initUI'
    }
  }

}(jQuery))


/**
 * 工具函数
 */
;(function($) {
  'use strict'

  $.extend(Function.prototype, {
    toFunc: function() {
      return this
    }
  })

  $.fn.extend({
    isTag: function(tn) {
      if (!tn) return false
      if (!$(this).prop('tagName')) return false
      return $(this)[0].tagName.toLowerCase() === tn
    }
  })

  $.extend(String.prototype, {
    /**
     * String to Function
     * 参数(方法字符串或方法名)： 'function(){...}' 或 'getName' 或 'USER.getName' 均可
     */
    toFunc: function() {
      if (!this || this.length === 0) return undefined
      if (this.startsWith('function')) {
        return (new Function('return ' + this))()
      }

      var m_arr = this.split('.')
      var fn = window

      for (var i = 0; i < m_arr.length; i++) {
        fn = fn[m_arr[i]]
      }

      if (typeof fn === 'function') {
        return fn
      }

      return undefined
    },
    setUrlParam: function(key, value) {
      var url = this
      var r = url
      if (r != null && r !== 'undefined' && r !== '') {
        value = encodeURIComponent(value)
        var reg = new RegExp('(^|)' + key + '=([^&]*)(|$)')
        var tmp = key + '=' + value
        if (url.match(reg) != null) {
          r = url.replace(reg, tmp)
        } else {
          if (url.match('[\?]')) {
            r = url + '&' + tmp
          } else {
            r = url + '?' + tmp
          }
        }
      }
      return r
    },
    /**
     * 获取url参数
     * @param name 参数名称，为空则返回所有参数Object集合
     * @param url 目标url，默认为当前url
     * @returns {*}
     */
    getQuery: function(name, url) {
      var $location
      var $params = {}
      if (url) {
        $location = document.createElement('a')
        $location.href = url
      } else {
        $location = window.location
      }
      var $seg = $location.search.replace(/^\?/, '').split('&')
      var len = $seg.length
      var $p
      for (var i = 0; i < len; i++) {
        if ($seg[i]) {
          $p = $seg[i].split('=')
          $params[$p[0]] = decodeURIComponent($p[1])
        }
      }
      return (name ? $params[name] : $params)
    }
  })


   /**
   * ajax 统一封装
   * @param opt {Object} 与$.ajax基本相同，新增callback属性，存在则覆盖success属性
   */
  $.request = function(opt) {

    if (opt.callback) {
      opt.success = opt.callback
    }

    $.ajax({
      type: opt.type || 'GET',
      url: opt.url,
      data: opt.data || {},
      cache: false,
      dataType: 'json',
      timeout: opt.timeout || 20000,
      success: function(response) {
        if (opt.success) {
          opt.success(response)
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        if (opt.error) {
          opt.error(xhr, ajaxOptions, thrownError)
        }
      },
      beforeSend: function() {
        if (opt.beforeSend) {
          opt.beforeSend()
        }
      },
      complete: function() {
        if (opt.complete) {
          opt.complete()
        }
      },
      statusCode: {
        403: function() {
          $.alertmsg('default', '无权限访问！')
        },
        500: function() {
          $.alertmsg('default', '接口请求失败！')
        }
      }
    })
  }

  /**
   * 弹出信息
   * @param type {string} success|danger|warning|default(默认)
   * @param message {string} 提示信息
   * @param actions
   */
  $.alertmsg = function(type, message, actions) {
    type = type || 'default'
    var icon = undefined
    switch (type) {
      case 'success':
        icon = 'ok-sign'
        break
      case 'danger':
        icon = 'exclamation-sign'
        break
      case 'warning':
        icon = 'warning-sign'
        break
    }
    new $.zui.Messager(
      message,
      {
        icon: icon,
        type: type,
        time: 4000,
        actions: actions
      }
    ).show()
  }


  /**
   * 确认框
   * @param message {string} 信息
   * @param callback {function} 回调函数
   */
  $.confirm = function(message, callback) {
    callback = callback || function(){}
    bootbox.confirm({
      title: "确认请求",
      message: message || '是否确定操作？',
      buttons: {
        confirm: {
          label: '确定',
          className: 'btn-success btn'
        },
        cancel: {
          label: '取消',
          className: 'btn-danger btn'
        }
      },
      callback: function (result) {
        callback(result)
      }
    });
  }

  /**
   * 全屏loading加载提示
   * @type {{close: jQuery.loading.close, open: jQuery.loading.open}}
   */
  $.loading = {
    open: function() {
      $CONTAINER.addClass('loading')
    },
    close: function() {
      $CONTAINER.removeClass('loading')
    }
  }

  /**
   * @return {undefined}
   */
  $.CurrentDialog = function() {
    return C_DIALOG ? C_DIALOG.$dialog : undefined
  }


}(jQuery))


/**
 * 弹窗，[data-toggle="dialog"]
 * 对zui.modalTrigger 二次封装，实现添加监听与弹窗内插件实例化
 * 属性与zad.modalTrigger一致
 */
;(function($) {
  'use strict'

  var DataKey = 'zad.dialog'

  var Default = {
    moveable: true,
    ajaxOptions: {
      error: function() {
        if (C_DIALOG) {
          C_DIALOG.close()
        }
        $.alertmsg('default', '请求接口失败！')
      }
    }
  }

  var Selector = {
    data: '[data-toggle="dialog"]'
  }

  var Dialog = function(element, options) {
    this.element = $(element)
    this.options = options

    this.dialog = new $.zui.ModalTrigger(options)

    this._setUpListener()
  }

  Dialog.prototype._setUpListener = function() {
    this.element.on('click', function(e) {
      e.preventDefault()
      this.show()
    }.bind(this))

  }

  Dialog.prototype.show = function() {
    var a = this.dialog.show({
      onShow: function(e) {
        C_DIALOG = this.dialog
      }.bind(this),
      loaded: function(e) {
        $(e.target).trigger(ZAD.eventType.initUI)
      }
    })
  }

  Dialog.prototype.hide = function() {
    this.dialog.close()
  }


  // Plugin Definition
  // =================
  function Plugin(option) {
    return this.each(function () {
      var $this = $(this)
      var data  = $this.data(DataKey)

      if (!data) {
        var options = $.extend({}, Default, $this.data(), typeof option == 'object' && option);
        $this.data(DataKey, (data = new Dialog($this, options)))
      }

      if (typeof data == 'string') {
        if (typeof data[option] == 'undefined') {
          throw new Error('No method named ' + option)
        }
        data[option]()
      }
    })
  }

  var old = $.fn.dialog

  $.fn.dialog = Plugin
  $.fn.dialog.Constructor = Dialog

  // No Conflict Mode
  // ================
  $.fn.dialog.noConflict = function () {
    $.fn.dialog = old
    return this
  }

  // Dialog Data API
  // ==================
  $(window).on('load', function () {
    $(Selector.data).each(function() {
      Plugin.call($(this))
    })
  })
}(jQuery))


/**
 * AjaxForm()
 *
 * ajax提交表单,
 * 默认回调函数：
 * code: 200正确, 非200错误
 * message: 提示消息
 * refresh {bool}：code = 200且redirect为false时,刷新页面
 * redirect: {false|string} 跳转链接
 * timeout: 跳转/刷新页面触发时间
 */
;(function($) {
  'use strict'

  var DataKey = 'zad.ajaxform'

  var Default = {
    type: 'POST',
    url: undefined,
    callback: function(response) {
      var message = response.message || '请求失败'
      if (response.code !== 200) {
        $.alertmsg('danger', message)
      } else {
        if (response.closeDialog && C_DIALOG) {
          C_DIALOG.close()
        }
        if (response.redirect) {
          $.alertmsg('success', message, [{
            name: 'timeout',
            text: (response.timeout / 1000) + '秒后跳转页面',
            action: function() {
            }
          }])
          setTimeout(function () {
            window.location.href = response.redirect
          }, response.timeout)
        } else if (response.refresh) {
          $.alertmsg('success', message, [{
            name: 'timeout',
            text: (response.timeout / 1000) + '秒后刷新页面',
            action: function() {
            }
          }])
          setTimeout(function () {
            window.location.reload()
          }, response.timeout)
        }else {
          $.alertmsg('success', message)
        }
      }
    },
    beforeSend: function() {
      this.submitSelector.attr('disabled', true)
    },
    complete: function() {
      this.submitSelector.removeAttr('disabled')
    }
  }

  var Selector = {
    data: 'form[data-toggle="ajaxform"]'
  }

  var AjaxForm = function(element, options) {
    this.element = $(element)
    this.options = options
    this.options.submitSelector = this.element.find(':submit')
    this._setUpListener()
  }

  // 监听事件
  AjaxForm.prototype._setUpListener = function() {
    this.element.on('submit', function(e) {
      e.preventDefault()
      this.submit()
    }.bind(this))
  }

  // 提交表单
  AjaxForm.prototype.submit = function() {
    if (this.isValid()) {
      this.options.data = this.element.serialize()
      $.request(this.options)
    }
  }

  // 表单验证是否通过，基于jquery.validator
  AjaxForm.prototype.isValid = function() {
    return this.element.isValid ? this.element.isValid() : true
  }



  function Plugin(option) {
    return this.each(function () {
      var $this = $(this)
      var data  = $this.data(DataKey)

      if (!data) {
        var options = $.extend({}, Default, {
          url: $this.attr('action'),
          type: $this.attr('method')
        }, typeof option == 'object' && option)
        if (!options.url) {
          throw new Error('url is undefined')
        } else {
          $this.data(DataKey, (data = new AjaxForm(this, options)))
        }
      }

      if (typeof data == 'string') {
        if (typeof data[option] == 'undefined') {
          throw new Error('No method named ' + option)
        }
        data[option]()
      }

    })
  }

  var old = $.fn.ajaxForm

  $.fn.ajaxForm = Plugin
  $.fn.ajaxForm.Constructor = AjaxForm

  // No Conflict Mode
  // ================
  $.fn.ajaxForm.noConflict = function() {
    $.fn.ajaxForm = old
    return this
  }

  // ajaxForm Data API
  // =================
  $(window).on('load', function(e) {
    $(Selector.data).each(function() {
      var $this = $(this)
      Plugin.call($this, $this.data())
    })
  })

  $(document).on(ZAD.eventType.initUI, function(e) {
    $(e.target).find(Selector.data).each(function() {
      var $this = $(this)
      Plugin.call($this, $this.data())
    })
  })


}(jQuery))

/**
 * doajax ajax请求
 * options:
 * confirm {bool} 是否有确认弹窗
 * message {string} 确认弹窗文字
 *
 */
;(function($) {
  'use strict'

  var DataKey = 'zad.doajax'

  var Default = {
    message: undefined,
    confirm: true,
    type: 'POST',
    url: undefined,
    data: {},
    callback: function(response) {
      var message = response.message || '请求失败'
      if (response.code !== 200) {
        $.alertmsg('danger', message)
      } else {
        if (response.redirect) {
          $.alertmsg('success', message, [{
            name: 'timeout',
            text: (response.timeout / 1000) + '秒后跳转页面',
            action: function() {
            }
          }])
          setTimeout(function () {
            window.location.href = response.redirect
          }, response.timeout)
        } else if (response.refresh) {
          $.alertmsg('success', message, [{
            name: 'timeout',
            text: (response.timeout / 1000) + '秒后刷新页面',
            action: function() {
            }
          }])
          setTimeout(function () {
            window.location.reload()
          }, response.timeout)
        } else {
          $.alertmsg('success', message)
        }
      }
    },
    beforeSend: function() {
      $.loading.open()
      this.element.attr('disabled', true)
    },
    complete: function() {
      $.loading.close()
      this.element.removeAttr('disabled')
    }

  }

  var Selector = {
    data: '[data-toggle="doajax"]'
  }

  var DoAjax = function(element, options) {
    this.element = $(element)
    this.options = options
    this.options.element = this.element
  }

  DoAjax.prototype.do = function() {
    var options = this.options
    if (options.confirm) {
      $.confirm(options.message, function(res) {
        if (res) {
          $.request(options)
        }
      }.bind(this))
    } else {
      $.request(options)
    }
  }


  function Plugin(option) {
    return this.each(function () {
      var options = $.extend({}, Default, {
        url: $(this).attr('href')
      }, typeof option == 'object' && option)
      new DoAjax(this, options).do()
    })
  }

  var old = $.fn.doAjax

  $.fn.doAjax = Plugin
  $.fn.doAjax.Constructor = DoAjax

  // No Conflict Mode
  // ================
  $.fn.doAjax.noConflict = function() {
    $.fn.doAjax = old
    return this
  }

  $(document).on('click.' + DataKey + '.data-api', Selector.data, function(e) {
    var $this = $(this)
    e.preventDefault()
    Plugin.call($this, $this.data())
  })

}(jQuery))

/**
 * checkbox 组， data-toggle="checkgroup" 可实例化
 * var checkbox = new CheckGroup('#checkbox'); 或 var checkbox = $('#checkbox').data('zad.checkgroup');
 * 获取选中项：checkbox.getCheckedValue()
 */
;(function($) {
  'use strict'

  var DataKey = 'zad.checkgroup'

  var Default = {
    group: 'id'
  }

  var Selector = {
    data: '[data-toggle="checkgroup"]'
  }

  var CheckGroup = function(element, options) {
    this.element = $(element)
    this.options = options
    this.children = this.getChildren()
    this._setUpListener()
  }

  CheckGroup.prototype._setUpListener = function() {
    this.element.on('change', function(e) {
      if ($(e.target).is(':checked')) {
        this.doCheck()
      } else {
        this.cancelCheck()
      }
    }.bind(this))
  }

  CheckGroup.prototype.getChildren = function() {
    return $('[type="checkbox"][name="'+ this.options.group +'"]')
  }


  CheckGroup.prototype.doCheck = function() {
    this.children.prop('checked', true)
  }

  CheckGroup.prototype.cancelCheck = function() {
    this.children.prop('checked', false)
  }

  CheckGroup.prototype.getCheckedValue = function() {
    var children = this.getChildren()
    var value = []
    children.each(function() {
      var $this = $(this)
      if ($this.is(':checked')) {
        value.push($this.val())
      }
    })
    return value.join(',')
  }

  function Plugin(option) {

    return this.each(function () {
      var $this = $(this)
      var data  = $this.data(DataKey)

      if (!data) {
        var options = $.extend({}, Default, typeof option == 'object' && option)
        $this.data(DataKey, (data = new CheckGroup(this, options)))
      }

      if (typeof data == 'string') {
        if (typeof data[option] == 'undefined') {
          throw new Error('No method named ' + option)
        }
        data[option]()
      }

    })
  }

  var old = $.fn.checkGroup

  $.fn.checkGroup = Plugin
  $.fn.checkGroup.Constructor = CheckGroup

  // No Conflict Mode
  // ================
  $.fn.checkGroup.noConflict = function() {
    $.fn.checkGroup = old
    return this
  }

  $(window).on('load', function(e) {
    $(Selector.data).each(function() {
      var $this = $(this)
      Plugin.call($this, $this.data())
    })
  })

  $(document).on(ZAD.eventType.initUI, function(e) {
    $(e.target).find(Selector.data).each(function() {
      var $this = $(this)
      Plugin.call($this, $this.data())
    })
  })

}(jQuery))

/**
 * chosen|chosenIcons 组件二次封装
 * chosenIcons => true 使用图标选择插件独立组件
 */
;(function($) {
  'use strict'

  var DataKey = 'zad.selectpicker'

  var Default = {
    lang: 'zh_cn',
    no_results_text: '没有找到',
    disable_search_threshold: 10,
    search_contains: true,
    compact_search: true,
    width: '100%',
    chosenIcons: false
  }

  var Selector = {
    data: '[data-toggle="selectpicker"]'
  }

  var SelectPicker = function(element, options) {
    this.element = $(element)
    this.options = options
    if (options.chosenIcons) {
      this.element.chosenIcons(this.options)
    } else {
      this.element.chosen(this.options)
    }
  }

  // Plugin Definition
  // =================
  function Plugin(option) {
    return this.each(function () {
      var $this = $(this)
      var options = $.extend({}, Default, $this.data(), typeof option == 'object' && option);

      if (options.chosenIcons) {
        new SelectPicker($this, options)
      } else {
        var data  = $this.data(DataKey)

        if (!data) {
          $this.data(DataKey, (data = new SelectPicker($this, options)))
        }

        if (typeof data == 'string') {
          if (typeof data[option] == 'undefined') {
            throw new Error('No method named ' + option)
          }
          data[option]()
        }
      }

    })
  }

  var old = $.fn.selectpicker

  $.fn.selectpicker = Plugin
  $.fn.selectpicker.Constructor = SelectPicker

  // No Conflict Mode
  // ================
  $.fn.selectpicker.noConflict = function () {
    $.fn.selectpicker = old
    return this
  }

  // Data API
  // ==================
  $(window).on('load', function () {
    $(Selector.data).each(function() {
      Plugin.call($(this))
    })
  })

  $(document).on(ZAD.eventType.initUI, function(e) {
    $(e.target).find(Selector.data).each(function() {
      Plugin.call($(this))
    })
  })

}(jQuery))

/**
 * [data-toggle="upload"]
 * zui.uploader单图片上传封装，文档请参考zui.uploader
 * 上传回调函数 data-response-handler="responseHandler"
 * 删除回调函数 data-delete-action-on-done="deleteActionOnDone"
 *
 */
;(function($) {
  'use strict'

  var Default = {
    autoUpload: true,
    multi_selection: false,
    fileList: 'grid',
    max_retries: 0,
    chunk_size: 0, // 关闭分片上传
    limitFilesCount: 1,
    filters: {
      mime_types: [
        {title: '图片', extensions: 'jpg,png'},
      ],
      prevent_duplicates: true,
      max_file_size: '5mb'
    },
    deleteActionOnDone: function(file, doRemoveFile) {
      return true
    },
    responseHandler: function(responseObject, file) {
      var response = (typeof responseObject.response === 'string') ? JSON.parse(responseObject.response) : responseObject.response
      if (response.code !== 200) {
        return response.message
      }
    }
  }

  var Selector = {
    data: '[data-toggle="upload"]'
  }

  var Upload = function(element, options) {
    if (options.responseHandler) {
      options.responseHandler = options.responseHandler.toFunc()
    }
    if (options.deleteActionOnDone) {
      options.deleteActionOnDone = options.deleteActionOnDone.toFunc()
    }
    if (options.file) {
      options.staticFiles = [
        { url: options.file, isImage: true, previewImage: options.file }
      ]
    }
    return $(element).uploader($.extend({}, Default, options))
  }

  $(window).on('load', function () {
    $(Selector.data).each(function() {
      Upload(this, $(this).data())
    })
  })

  $(document).on(ZAD.eventType.initUI, function(e) {
    $(e.target).find(Selector.data).each(function() {
      Upload(this, $(this).data())
    })
  })



}(jQuery))

/**
 * 外部插件等初始化配置
 */
;(function($) {
  'use strict'

  if ($.validator) {
    // nice-validator全局配置，适配zui表单
    $.validator.config({
      validClass: 'has-success', // 正确类，如不需要可删除
      invalidClass: 'has-error',
      bindClassTo: '.form-group',
      msgClass: 'help-block',
      msgWrapper: 'div',
      msgMaker: function(opt){
        return opt.msg
      },
      invalid: function(form, errors) {
        $.alertmsg(null, '表单存在 [ ' + errors.length + ' ] 处错误，请验证后提交！')
      }
    })
  }

  $(document).on(ZAD.eventType.initUI, function(e) {
    initPlugin()
  })

  /**
   * 跳转
   */
  $(document).on('click', '[data-toggle="redirect"]', function(e) {
    e.preventDefault()
    window.location.href = $(this).data('url')
  })
  /**
   * 修改样式
   * 添加size支持
   */
  var zadFixedUi = function() {
    $(':text, :password, textarea, :button, a.btn').each(function() {
      var $element = $(this)
      if (($element.is(':text') || $element.is(':password') || $element.isTag('textarea')) && !$element.hasClass('form-control')) {
        $element.addClass('form-control')
      }

      var size = $element.attr('size') || $element.attr('cols')
      if (!size) return
      var width = 0
      if (size.charAt(size.length - 1) !== '%') {
        width = size * 10
      } else {
        width = size
      }
      if (width) $element.css('width', width)
    })

  }

  /**
   * kindeditor 初始化
   *
   */
  var KindeditorInit = function() {
    if (window.KindEditor) {
      $('textarea[data-toggle="kindeditor"]').each(function() {
        var $editor = $(this)
        var options = $editor.data()
        if (options.items && typeof options.items === 'string') {
          options.items = options.items.replaceAll('\'', '').replaceAll(' ', '').split(',')
        }
        KindEditor.create($editor, {
          allowFileManager : true,
          bodyClass : 'article-content',
          minHeight: options.minHeight || 260,
          items: options.items || KindEditor.options.items,
          uploadJson: options.uploadJson || ZADGLOAB.kindeditor.uploadJson,
          fileManagerJson: options.fileManagerJson || ZADGLOAB.kindeditor.fileManagerJson
        })
      })
    }
  }

  /**
   * laydate初始化
   * @constructor
   */
  var LaydateInit = function() {
    if (window.laydate) {
      $('[data-toggle="datepicker"]').each(function() {
        var options = $(this).data()
        if (!options.calendar) {
          options.calendar = true
        }
        options.elem = this
        laydate.render(options)
      })
    }
  }

  /**
   * 插件初始化
   */
  function initPlugin() {
    zadFixedUi()
    KindeditorInit()
    LaydateInit()
  }

  initPlugin()





}(jQuery))

