<template>
  <div class="mb-24">
    <h1 class="mb-8 text-3xl font-bold">Event Types</h1>

    <div class="flex items-center justify-between mb-6">
      <search-filter
        v-model="formFilter.search"
        class="w-full max-w-md mr-4"
        @reset="reset"
      >
        <label class="block mt-4 text-gray-700">Trashed:</label>
        <label>
          <select
            v-model="formFilter.trashed"
            class="w-full mt-1 form-select"
          >
            <option :value="null" />
            <option value="with">With Trashed</option>
            <option value="only">Only Trashed</option>
          </select>
        </label>
      </search-filter>
      <inertia-link
        v-if="can('create-event-type')"
        class="btn-indigo"
        :href="route('event-types.create')"
      >
        <span>Create</span>
        <span class="hidden md:inline">Event Type</span>
      </inertia-link>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
      <table class="w-full whitespace-no-wrap">
        <tr class="font-bold text-left">
          <th class="px-6 pt-6 pb-4">Name</th>
        </tr>

        <tr
          v-for="eventType in eventTypes.data"
          :key="eventType.id"
          class="hover:bg-gray-100 focus-within:bg-gray-100"
        >
          <td class="border-t">
            <span class="flex items-center px-6 py-4">
              {{ eventType.name }}
            </span>
          </td>

          <td class="w-px border-t">
            <inertia-link
              v-if="can('edit-event-type')"
              class="flex items-center px-4"
              :href="route('event-types.edit', eventType.id)"
              tabindex="-1"
            >
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="eventTypes.data.length === 0">
          <td class="px-6 py-4 border-t" colspan="3">No data found.</td>
        </tr>
      </table>
    </div>

    <pagination
      v-if="eventTypes.data.length > 0"
      class="mt-6"
      :links="eventTypes.meta.links"
    />
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import Icon from '@/Shared/Icon'
import SearchFilter from '@/Shared/SearchFilter'
import Pagination from '@/Shared/Pagination'
import throttle from 'lodash/throttle'
import pickBy from 'lodash/pickBy'
import mapValues from 'lodash/mapValues'

export default {
  name: 'Index',
  components: {
    Icon,
    SearchFilter,
    Pagination,
  },

  layout: Layout,
  props: {
    eventTypes: [Object, Array],
    filters: [Object, Array],
  },
  metaInfo: {
    title: 'Event Types',
  },

  data() {
    return {
      formFilter: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
    }
  },

  watch: {
    formFilter: {
      handler: throttle(function() {
        let query = pickBy(this.formFilter)
        this.$inertia.replace(this.route('event-types.index', Object.keys(query).length ? query : { remember: 'forget' }))
      }, 150),
      deep: true,
    },
  },

  methods: {
    reset () {
      this.formFilter = mapValues(this.formFilter, () => null)
    },
  },
}
</script>
