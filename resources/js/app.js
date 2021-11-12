import Vue from 'vue'
import VueMeta from 'vue-meta'
import PortalVue from 'portal-vue'
import { InertiaProgress } from '@inertiajs/progress'
import { createInertiaApp } from '@inertiajs/inertia-vue'
import VueFormulate from '@braid/vue-formulate'
import Auth from './Mixins/Auth'

/** Vue Formulate Plugins */
import FormulateVueDatetimePlugin from '@cone2875/vue-formulate-datetime'
import 'vue-datetime/dist/vue-datetime.css'

Vue.config.productionTip = false
Vue.mixin(Auth)
Vue.mixin({ methods: { route: window.route } })
Vue.use(PortalVue)
Vue.use(VueMeta)
Vue.use(VueFormulate, {
  plugins: [
    /** https://www.npmjs.com/package/vue-datetime#usage */
    FormulateVueDatetimePlugin,
  ],
})

InertiaProgress.init()

createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  setup({ el, app, props }) {
    new Vue({
      metaInfo: {
        titleTemplate: title => (title ? `${title} - Eventkita` : 'Eventkita'),
      },
      render: h => h(app, props),
    }).$mount(el)
  },
})
