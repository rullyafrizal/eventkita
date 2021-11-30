<template>
  <div>
    <div v-if="can('view-dashboard')" class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('dashboard')">
        <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">
          <strong>Dashboard</strong>
        </div>
      </inertia-link>
    </div>

    <div v-if="can('view-users')" class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('users.index')">
        <div :class="isUrl('users') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">
          <strong>Users</strong>
        </div>
      </inertia-link>
    </div>

    <div v-if="can('view-roles')" class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('roles.index')">
        <div :class="isUrl('roles') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">
          <strong>Roles</strong>
        </div>
      </inertia-link>
    </div>

    <div v-if="can('view-event-types')" class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('event-types.index')">
        <div :class="isUrl('event-types') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">
          <strong>Event Types</strong>
        </div>
      </inertia-link>
    </div>

    <div v-if="can('view-articles')" class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('articles.index')">
        <div :class="isUrl('articles') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">
          <strong>Articles</strong>
        </div>
      </inertia-link>
    </div>

    <div v-if="can('view-events')" class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('events.index')">
        <div :class="isUrl('events') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">
          <strong>Events</strong>
        </div>
      </inertia-link>
    </div>

    <div v-if="can('view-event-pictures')" class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('event-pictures.index')">
        <div :class="isUrl('event-pictures') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">
          <strong>Event Pictures</strong>
        </div>
      </inertia-link>
    </div>

    <div v-if="can('view-participations')" class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('participations.index')">
        <div :class="isUrl('participations') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">
          <strong>Participations</strong>
        </div>
      </inertia-link>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    isUrl(...urls) {
      let currentUrl = this.$page.url.substr(1).replace('cms/', '')

      if (this.$page.url.substr(1) === 'cms') {
        currentUrl = this.$page.url.substr(1).replace('cms', '')
      }

      if (urls[0] === '') {
        return currentUrl === ''
      }

      return urls.filter(url => currentUrl.startsWith(url)).length
    },
  },
}
</script>
