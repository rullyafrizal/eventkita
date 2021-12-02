<template>
  <div class="container mb-24">
    <h1 class="mb-8 text-3xl font-bold">
      <inertia-link
        class="text-indigo-400 hover:text-indigo-600"
        :href="route('articles.show', article.data.id)"
      >
        Back
      </inertia-link>
      <span class="font-medium text-indigo-400">/</span>
      Edit Article {{ article.data.id }}
    </h1>

    <div class="max-w-4xl overflow-hidden bg-white rounded shadow">
      <FormulateForm
        v-model="formEdit"
        :errors="errors"
        @submit="submit"
      >
        <div class="flex flex-wrap p-5">
          <FormulateInput
            name="title"
            type="text"
            label="Title"
            placeholder="Title"
            validation-name="Title"
            validation="required"
            class="w-1/2 p-2"
          />

          <FileInput
            ref="fileUpload"
            v-model="formEdit.thumbnail"
            label="Foto Thumbnail"
            :errors="errors.thumbnail"
            hide-size
            class="w-1/2 p-2"
          />
          <div>
            <vue-editor id="content" v-model="formEdit.body" class="mx-2" placeholder="Article body goes here..." />
          </div>
        </div>
        <div class="flex items-center justify-between w-full px-8 py-4 mt-8 bg-gray-100 border-t border-gray-200">
          <button
            v-if="!article.data.deleted_at && can('delete-article')"
            class="text-red-600 hover:underline"
            tabindex="-1"
            type="button"
            @click="destroy"
          >
            Delete Article
          </button>
          <FormulateInput
            type="submit"
            name="Update Article"
          />
        </div>
      </FormulateForm>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import { VueEditor } from 'vue2-editor'
import FileInput from '@/Shared/FileInput'
import Upload from '@/Mixins/Upload'

export default {
  metaInfo: {
    title: 'Edit Article',
  },
  components: {
    VueEditor,
    FileInput,
  },

  mixins: [Upload],

  layout: Layout,

  props: {
    errors: [Object, Array],
    article: [Object, Array],
  },

  remember: 'formEditArticle',

  data() {
    return {
      formEdit: {
        title: this.article.data.title,
        body: this.article.data.body,
        thumbnail: null,
      },
    }
  },

  mounted() {
    this.setStorePath('articles')
    this.setRouteUploadName('articles.upload')
  },

  methods: {
    async submit(data) {
      let form = data

      if (this.formEdit.thumbnail) {
        const result = await this.uploader(this.formEdit.thumbnail, 'thumbnail')
        if (!result) return false

        form.thumbnail = [result]
      } else {
        delete form.thumbnail
      }

      this.$inertia.put(this.route('articles.update', this.article.data.id), form)
    },

    async destroy() {
      if (confirm('Are you sure you want to delete this Article?')) {
        this.$inertia.delete(this.route('articles.destroy', this.article.data.id))
      }
    },
  },
}
</script>
