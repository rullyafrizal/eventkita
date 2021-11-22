<template>
  <div class="mb-24">
    <h1 class="mb-8 text-3xl font-bold">Roles</h1>

    <div class="flex flex-col md:flex-row items-center justify-between mb-6">
      <search-filter
        v-model="formFilter.search"
        class="w-full max-w-md mr-4 mb-2 md:mb-0"
        @reset="reset"
      />
      <inertia-link
        v-if="can('create-role')"
        class="btn-indigo self-end md:self-center"
        :href="route('roles.create')"
      >
        <span>Add Role</span>
      </inertia-link>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
      <table class="w-full whitespace-no-wrap">
        <tr class="font-bold text-left">
          <th class="px-6 pt-6 pb-4">Name</th>
          <th class="px-6 pt-6 pb-4">Guard</th>
          <th class="px-6 pt-6 pb-4" colspan="2">Permissions</th>
        </tr>

        <tr
          v-for="role in roles.data"
          :key="role.id"
          class="hover:bg-gray-100 focus-within:bg-gray-100"
        >
          <td class="border-t">
            <span class="flex items-center px-6 py-4">
              {{ role.name }}
            </span>
          </td>
          <td class="border-t">
            <span class="flex items-center px-6 py-4">
              {{ role.guard_name }}
            </span>
          </td>
          <td class="border-t">
            <span
              v-if="role.permissions_by_name.length > 0"
              class="items-center px-6 py-4 flex flex-wrap"
            >
              <span
                v-for="permission_name in role.permissions_by_name"
                :key="permission_name.id"
                class="bg-green-400 text-white py-1 px-2 ml-1 mb-1 rounded-full text-xs font-bold justify-center"
              >
                {{ permission_name }}
              </span>
            </span>
          </td>
          <td class="w-px border-t">
            <inertia-link
              v-if="can('edit-role')"
              class="flex items-center px-4"
              :href="route('roles.edit', role.id)"
              tabindex="-1"
            >
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="roles.length === 0">
          <td class="px-6 py-4 border-t" colspan="3">No data found.</td>
        </tr>
      </table>
    </div>

    <pagination
      v-if="roles.data.length > 0"
      class="mt-6"
      :links="roles.meta.links"
    />
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import SearchFilter from '@/Shared/SearchFilter'
import Icon from '@/Shared/Icon'
import mapValues from 'lodash/mapValues'
import pickBy from 'lodash/pickBy'
import throttle from 'lodash/throttle'
import Pagination from '@/Shared/Pagination'

export default {
  metaInfo: {
    title: 'Roles',
  },

  components: {
    SearchFilter,
    Icon,
    Pagination,
  },

  layout: Layout,

  props: {
    roles: [Object, Array],
    filters: [Object, Array],
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
        this.$inertia.replace(this.route('roles.index', Object.keys(query).length ? query : { remember: 'forget' }))
      }, 150),
      deep: true,
    },
  },

  methods: {
    reset() {
      this.formFilter = mapValues(this.formFilter, () => null)
    },
  },
}
</script>
