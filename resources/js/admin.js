import 'trumbowyg'
import svgPath from 'trumbowyg/dist/ui/icons.svg'

$('.trumbowyg-form').trumbowyg({
  svgPath: svgPath
})

// Toggle the side navigation
$('#sidenavToggler').click(function (e) {
  e.preventDefault()
  $('body').toggleClass('sidenav-toggled')
})

// Configure tooltips for collapsed side navigation
$('.navbar-sidenav [data-toggle="tooltip"]').tooltip({
  template: '<div class="tooltip navbar-sidenav-tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
})
