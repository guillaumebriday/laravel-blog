import 'trumbowyg'
import svgPath from 'trumbowyg/dist/ui/icons.svg'
import { Tooltip } from 'bootstrap'

// Turbo Drive swaps the <body> on navigation without re-running this module,
// so widgets are initialized on every turbo:load and torn down before Turbo
// caches the page (otherwise restoring a snapshot would initialize them twice).
document.addEventListener('turbo:load', () => {
  $('.trumbowyg-form').trumbowyg({
    svgPath
  })

  // Configure tooltips for collapsed side navigation
  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(tooltipTriggerEl => {
    new Tooltip(tooltipTriggerEl, {
      template: '<div class="tooltip navbar-sidenav-tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
    })
  })
})

document.addEventListener('turbo:before-cache', () => {
  // Trumbowyg only runs methods on a single element, so destroy each editor
  $('.trumbowyg-form').each(function () {
    $(this).trumbowyg('destroy')
  })

  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(tooltipTriggerEl => {
    Tooltip.getInstance(tooltipTriggerEl)?.dispose()
  })
})

// Toggle the side navigation (delegated, since Turbo replaces the element)
$(document).on('click', '#sidenavToggler', function (e) {
  e.preventDefault()
  $('body').toggleClass('sidenav-toggled')
})
