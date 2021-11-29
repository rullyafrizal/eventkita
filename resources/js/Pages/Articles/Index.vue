<template>
  <div class="mb-24">
    <h1 class="mb-8 text-3xl font-bold">Articles</h1>

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
            <option value="published">Published</option>
            <option value="not published">Not Published</option>
          </select>
        </label>

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
        v-if="can('create-article')"
        class="btn-indigo"
        :href="route('articles.create')"
      >
        <span>Create</span>
        <span class="hidden md:inline">Article</span>
      </inertia-link>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
      <table class="w-full whitespace-no-wrap">
        <tr class="font-bold text-left">
          <th class="px-6 pt-6 pb-4">Title</th>
          <th class="px-6 pt-6 pb-4">Status</th>
          <th class="px-6 pt-6 pb-4">Last Update</th>
          <th class="px-6 pt-6 pb-4">Action</th>
        </tr>

        <tr
          v-for="article in articles.data"
          :key="article.id"
          class="hover:bg-gray-100 focus-within:bg-gray-100"
        >
          <td class="border-t">
            <span class="flex items-center px-6 py-4">
              {{ article.title }}
            </span>
          </td>

          <td class="border-t">
            <span v-if="article.is_published"
                  class="justify-center px-2 py-1 mb-1 ml-1 text-xs font-bold text-white rounded-full bg-green-600 cursor-pointer"
            >
              PUBLISHED
            </span>
            <span v-else
                  class="justify-center px-2 py-1 mb-1 ml-1 text-xs font-bold text-white rounded-full bg-red-600 cursor-pointer"
            >
              NOT PUBLISHED
            </span>
          </td>

          <td class="border-t">
            <span class="flex items-center px-6 py-4">
              {{ article.updated_at }}
            </span>
          </td>

          <td class="border-t">
            <button
              v-if="article.is_published"
              :disabled="loadingAction"
              class="btn-red-small flex items-center mr-2 ml-3"
              @click="publish(article)"
            >
              <span
                v-if="loadingAction"
                class="mr-2 btn-spinner"
              />

              <span class="block">
                UNPUBLISH
              </span>
            </button>
            <button
              v-else
              :disabled="loadingAction"
              class="btn-indigo-small flex items-center mr-2 ml-3"
              type="button" @click="publish(article)"
            >
              <span
                v-if="loadingAction"
                class="mr-2 btn-spinner"
              />

              <span class="block">
                PUBLISH
              </span>
            </button>
          </td>

          <td class="w-px border-t">
            <inertia-link
              v-if="can('edit-article')"
              class="flex items-center px-4"
              :href="route('articles.show', article.id)"
              tabindex="-1"
            >
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="articles.data.length === 0">
          <td class="px-6 py-4 border-t" colspan="5">No data found.</td>
        </tr>
      </table>
    </div>

    <pagination
      v-if="articles.data.length > 0"
      class="mt-6"
      :links="articles.meta.links"
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
    articles: [Object, Array],
    filters: [Object, Array],
  },
  metaInfo: {
    title: 'Articles',
  },

  data() {
    return {
      formFilter: {
        search: this.filters.search,
        trashed: this.filters.trashed,
        status: this.filters.status,
      },
      loadingAction: false,
    }
  },

  watch: {
    formFilter: {
      handler: throttle(function() {
        let query = pickBy(this.formFilter)
        this.$inertia.replace(this.route('articles.index', Object.keys(query).length ? query : { remember: 'forget' }))
      }, 150),
      deep: true,
    },
  },

  methods: {
    reset () {
      this.formFilter = mapValues(this.formFilter, () => null)
    },
    publish(article) {
      if(confirm('Are you sure?')) {
        this.loadingAction = true
        this.$inertia.put(this.route('articles.publish', article.id), {}, {
          onSuccess: () => {
            this.loadingAction = false
          },
        })
      }
    },
  },
}
</script>
