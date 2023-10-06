import 'trumbowyg'
import svgPath from 'trumbowyg/dist/ui/icons.svg'
import { Tooltip } from 'bootstrap'

$('.trumbowyg-form').trumbowyg({
  svgPath: svgPath
})

// Toggle the side navigation
$('#sidenavToggler').on('click', function (e) {
  e.preventDefault()
  $('body').toggleClass('sidenav-toggled')
})

// Configure tooltips for collapsed side navigation
document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(tooltipTriggerEl => {
  new Tooltip(tooltipTriggerEl, {
    template: '<div class="tooltip navbar-sidenav-tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
  })
})
