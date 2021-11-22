<template>
  <div>
    <trashed-message
      v-if="article.data.deleted_at && can('restore-article')"
      class="mb-6"
      @restore="restore"
    >
      This event type has been deleted.
    </trashed-message>
    <div class="bg-white rounded shadow overflow-x-auto p-8">
      <div class="flex justify-between mb-4">
        <div class="flex">
          <div class="mr-4">
            <img class="h-48 w-48" :src="article.data.thumbnail" alt="profile image" />
          </div>
          <div>
            <div class="text-3xl font-bold mb-2">{{ article.data.title }}</div>
          </div>
        </div>
        <div>
          <inertia-link
            v-if="can('edit-article') && !article.data.deleted_at"
            class="btn-indigo"
            :href="route('articles.edit', article.data.id)"
          >
            <span>Edit Article</span>
          </inertia-link>
        </div>
      </div>
      <div class="grid grid-flow-row grid-cols-1">
        <div class="text-md font-normal" v-html="article.data.body" />
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
    return {
      titleBar: this.article.data.title,
    }
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
