import '../css/main.css'

import { createPinia } from 'pinia'
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from 'ziggy-js'
import axios from 'axios'



const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'

const pinia = createPinia()

// Configure Axios to include CSRF token and X-Requested-With header
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
const csrfToken = document.querySelector('meta[name="csrf-token"]')
if (csrfToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.getAttribute('content')
}


createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(pinia)
      .use(ZiggyVue, Ziggy)
      .mount(el)
  },
  progress: {
    color: '#4B5563'
  }
})
