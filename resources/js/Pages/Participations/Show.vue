<template>
  <div class="mb-24">
    <h1 class="mb-8 text-3xl font-bold">{{ event.name }} Participations</h1>

    <div class="flex items-center justify-between mb-6">
      <search-filter
        v-model="formFilter.search"
        class="w-full max-w-md mr-4"
        @reset="reset"
      >
        <label class="block mt-4 text-gray-700">Status</label>
        <label>
          <select
            v-model="formFilter.status"
            class="w-full mt-1 form-select"
          >
            <option :value="null" />
            <option value="ABSENT">Absent</option>
            <option value="PRESENT">Present</option>
          </select>
        </label>
      </search-filter>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
      <table class="w-full whitespace-no-wrap">
        <tr class="font-bold text-left">
          <th class="px-6 pt-6 pb-4">Event Name</th>
          <th class="px-6 pt-6 pb-4">Participant Name</th>
          <th class="px-6 pt-6 pb-4">Status</th>
        </tr>

        <tr
          v-for="participation in participations.data"
          :key="participation.id"
          class="hover:bg-gray-100 focus-within:bg-gray-100"
        >
          <td class="border-t">
            <span class="flex items-center px-6 py-4">
              {{ participation.event.name }}
            </span>
          </td>

          <td class="border-t">
            <span class="flex items-center px-6 py-4">
              {{ participation.user.name }}
            </span>
          </td>

          <td class="border-t">
            <span v-if="participation.status === 'PRESENT'"
                  class="justify-center px-2 py-1 mb-1 ml-4 text-xs font-bold text-white rounded-full bg-green-600 cursor-pointer"
            >
              PRESENT
            </span>
            <span v-else-if="participation.status === 'ABSENT'"
                  class="justify-center px-2 py-1 mb-1 ml-4 text-xs font-bold text-white rounded-full bg-red-600 cursor-pointer"
            >
              ABSENT
            </span>
            <span v-else class="flex items-center px-6 py-4">
              -
            </span>
          </td>
        </tr>
        <tr v-if="participations.data.length === 0">
          <td class="px-6 py-4 border-t" colspan="7">No data found.</td>
        </tr>
      </table>
    </div>

    <pagination
      v-if="participations.data.length > 0"
      class="mt-6"
      :links="participations.meta.links"
    />
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import SearchFilter from '@/Shared/SearchFilter'
import Pagination from '@/Shared/Pagination'
import throttle from 'lodash/throttle'
import pickBy from 'lodash/pickBy'
import mapValues from 'lodash/mapValues'

export default {
  name: 'Show',
  components: {
    SearchFilter,
    Pagination,
  },

  layout: Layout,
  props: {
    event: [Object, Array],
    filters: [Object, Array],
    participations: [Object, Array],
  },
  metaInfo: {
    title: 'Event Participations',
  },

  data() {
    return {
      formFilter: {
        search: this.filters.search,
      },
    }
  },

  watch: {
    formFilter: {
      handler: throttle(function() {
        let query = pickBy(this.formFilter)
        this.$inertia.replace(this.route('participations.show', {
          event: this.event.id,
          ...Object.keys(query).length ? query : { remember: 'forget' },
        }))
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
