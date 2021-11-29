<template>
  <div>
    <div v-if="can('view-dashboard')" class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('dashboard')">
        <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">
          <strong>DASHBOARD</strong>
        </div>
      </inertia-link>
    </div>
    <div v-if="can('view-roles')" class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('roles.index')">
        <div :class="isUrl('roles') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">
          <strong>ROLES</strong>
        </div>
      </inertia-link>
    </div>
    <div v-if="can('view-event-types')" class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('event-types.index')">
        <div :class="isUrl('event-types') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">
          <strong>EVENT TYPES</strong>
        </div>
      </inertia-link>
    </div>
    <div v-if="can('view-articles')" class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('articles.index')">
        <div :class="isUrl('articles') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">
          <strong>ARTICLES</strong>
        </div>
      </inertia-link>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    isUrl(...urls) {
      let currentUrl = this.$page.url.substr(1)
      if (urls[0] === '') {
        return currentUrl === ''
      }
      return urls.filter(url => currentUrl.startsWith(url)).length
    },
  },
}
</script>
