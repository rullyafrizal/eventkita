<template>
  <div>
    <div v-if="can('view-admin-dashboard')" class="mb-4">
        <inertia-link class="flex items-center group py-3" :href="route('dashboard')">
        <icon name="dashboard" class="w-4 h-4 mr-2" :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Dashboard</div>
        </inertia-link>
    </div>
    <div v-if="can('view-roles')" class="mb-4">
        <inertia-link class="flex items-center group py-3" :href="route('roles.index')">
        <icon name="roles" class="w-4 h-4 mr-2" :class="isUrl('roles') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('roles') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Roles</div>
        </inertia-link>
    </div>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'

export default {
  components: {
    Icon,
  },
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
