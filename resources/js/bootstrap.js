/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
import 'bootstrap'
import Clipboard from 'clipboard'
import jquery from 'jquery'
import '@hotwired/turbo'

window.$ = window.jQuery = jquery

new Clipboard('[data-clipboard-target]')
