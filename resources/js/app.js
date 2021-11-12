import Vue from 'vue'
import VueMeta from 'vue-meta'
import PortalVue from 'portal-vue'
import { InertiaProgress } from '@inertiajs/progress'
import { createInertiaApp } from '@inertiajs/inertia-vue'
import VueFormulate from '@braid/vue-formulate'
import Auth from './Mixins/Auth'

Vue.config.productionTip = false
Vue.mixin(Auth)
Vue.mixin({ methods: { route: window.route } })
Vue.use(PortalVue)
Vue.use(VueMeta)
Vue.use(VueFormulate)

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
