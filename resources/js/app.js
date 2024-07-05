import './bootstrap';

import { createApp, h } from 'vue'
import { createStore } from 'vuex';
import { createInertiaApp } from '@inertiajs/vue3'
import beercss from "beercss";
import materialDynamicColors from "material-dynamic-colors";
import DefaultLayout from './Layouts/DefaultLayout.vue'

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    let page = pages[`./Pages/${name}.vue`]
    page.default.layout = DefaultLayout
    return page

    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({
      render: () => h(App, props)
    })
    .use(plugin)
    .mount(el);
  },
})
