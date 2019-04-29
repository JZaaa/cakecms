$(function() {
  // footer吸附在底部
  var $footer = $('#footer')
  if ($footer.length) {
    $('#zad-wrap').css('margin-bottom', $footer.outerHeight())
  }
  // 导航菜单active选择，赋值[data-active]标识当前活动菜单的位置，默认为0
  var $header = $('#header')
  if ($header.length) {
    $header.find('.menu li').eq($header.data('active') || 0).addClass('active')
  }
})
