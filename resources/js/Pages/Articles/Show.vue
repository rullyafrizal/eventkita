<template>
  <div>
    <div class="flex justify-between max-w-5xl mb-8">
      <div>
        <h1 class="text-3xl font-bold">
          <inertia-link
            class="text-indigo-400 hover:text-indigo-600"
            :href="route('articles.index')"
          >
            Back
          </inertia-link>
          <span class="font-medium text-indigo-400">/</span>
          Show Article {{ article.data.id }}
        </h1>
      </div>

      <div class="mt-3">
        <inertia-link
          v-if="can('edit-article') && !article.data.deleted_at"
          class="btn-indigo"
          :href="route('articles.edit', article.data.id)"
        >
          <span>Edit Article</span>
        </inertia-link>
      </div>
    </div>

    <trashed-message
      v-if="article.data.deleted_at && can('restore-article')"
      class="mb-6"
      @restore="restore"
    >
      This article has been deleted.
    </trashed-message>
    <div class="bg-white rounded shadow overflow-x-auto p-8">
      <div class="flex justify-center mb-4">
        <div class="flex">
          <div class="mr-4">
            <img class="h-full w-full rounded-md" :src="article.data.thumbnail" alt="profile image" />
          </div>
        </div>
      </div>
      <div class="grid grid-flow-row grid-cols-1">
        <h1 class="text-3xl font-bold mb-3">
          {{ article.data.title }}
        </h1>
        <div class="font-normal mb-8">
          <div class="text-gray-400">
            {{ article.data.last_update }}&nbsp;&nbsp;
            <span v-if="article.data.is_published"
                  class="justify-center px-2 py-1 mb-2 text-xs font-bold text-white rounded-full bg-green-600 cursor-pointer"
            >
              PUBLISHED
            </span>
            <span v-else
                  class="justify-center px-2 py-1 mb-2 text-xs font-bold text-white rounded-full bg-red-600 cursor-pointer"
            >
              NOT PUBLISHED
            </span>
          </div>
        </div>
        <div class="prose lg:prose-m" v-html="article.data.body" />
      </div>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  name: 'Edit',

  components: {
    TrashedMessage,
  },

  layout: Layout,

  props: {
    article: [Object, Array],
  },

  metaInfo: {
    title: 'Show Article',
  },

  data() {
    return {}
  },

  methods: {
    restore() {
      if (confirm('Are you sure you want to restore this article?')) {
        this.$inertia.put(this.route('articles.restore', this.article.data.id))
      }
    },
  },
}
</script>
