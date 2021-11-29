<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Dashboard</h1>
    <div class="grid lg:grid-cols-3 sm:grid-cols-1 gap-4 mt-3">
      <div class="grid gap-y-4 lg:col-span-1 col-span-2">
        <div v-if="can('view-events-count')" class="flex flex-col p-3 rounded-lg h-full w-full bg-white h-1/2 shadow-lg p-4">
          <div class="flex flex-wrap items-center">
            <icon name="megaphone" class="mr-2 w-10 h-10 fill-indigo-600" />
            <h4 class="mt-2 text-xl font-semibold">Total Events : {{ eventsCount }}</h4>
          </div>
        </div>
        <div v-if="can('view-users-count')" class="p-3 rounded-lg bg-white h-full shadow-lg w-full p-4">
          <div class="flex flex-wrap items-center">
            <icon name="users" class="mr-2 w-10 h-10 fill-indigo-600" />
            <h4 class="mt-2 text-xl font-semibold">Total Users : {{ usersCount }}</h4>
          </div>
        </div>
      </div>
      <div class="grid gap-y-4 lg:col-span-1 col-span-2">
        <div v-if="can('view-my-events-count')" class="flex flex-col p-3 rounded-lg h-full w-full bg-white h-1/2 shadow-lg p-4">
          <div class="flex flex-wrap items-center">
            <icon name="megaphone" class="mr-2 w-10 h-10 fill-indigo-600" />
            <h4 class="mt-2 text-xl font-semibold">My Events : {{ userEventsCount }}</h4>
          </div>
        </div>
        <div v-if="can('view-articles-count')" class="p-3 rounded-lg bg-white h-full shadow-lg w-full p-4">
          <div class="flex flex-wrap items-center">
            <icon name="news" class="mr-2 w-10 h-10 fill-indigo-600" />
            <h4 class="mt-2 text-xl font-semibold">Total Articles : {{ articlesCount }}</h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import Icon from '@/Shared/Icon'

export default {
  metaInfo: { title: 'Dashboard' },

  components: {
    Icon,
  },

  layout: Layout,

  props: {
    usersCount: [Number],
    eventsCount: [Number],
    articlesCount: [Number],
    userEventsCount: [Number],
  },
}
</script>
