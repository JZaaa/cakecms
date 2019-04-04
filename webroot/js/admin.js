var $C_RIGHT = $('.zad_container_right')
var CURRENT_URL = window.location.href.split('#')[0].split('?')[0]
var $MENU_TREE = $('#zad_menu_tree')

$(document).ready(function() {
  // 右侧栏目设置高度
  var setContentHeight = function() {
    $C_RIGHT.css('height', $(window).height())
  }

  // 开启默认菜单
  var setActiveMenu = function() {
    var $active = $MENU_TREE.find('a[href="' + CURRENT_URL + '"]').parent('li').addClass('active')
    if ($active.length) {
      $MENU_TREE.tree('expand', $active.parents('li'))
    }
  }

  setContentHeight()
  setActiveMenu()
})

