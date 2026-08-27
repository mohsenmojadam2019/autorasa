//import '@tabler/core/dist/js/autosize'
//import '@tabler/core/dist/js/dropdown'
//import '@tabler/core/dist/js/tooltip'
//import '@tabler/core/dist/js/popover'
//import '@tabler/core/dist/js/switch-icon'
//import '@tabler/core/dist/js/tab'
import * as bootstrap from 'bootstrap'
//import * as tabler from '@tabler/core/dist/js/tabler'
import '@tabler/core'  // کل پکیج رو وارد کن

globalThis.bootstrap = bootstrap
globalThis.tabler = tabler

import setupProgress from './base/progress'

setupProgress({
    showSpinner: true,
})
