<template>
  <div class="container mb-24">
    <h1 class="mb-8 text-3xl font-bold">
      <inertia-link
        class="text-indigo-400 hover:text-indigo-600"
        :href="route('articles.index')"
      >
        Back
      </inertia-link>
      <span class="font-medium text-indigo-400">/</span>
      Create Article
    </h1>

    <div class="max-w-4xl overflow-hidden bg-white rounded shadow">
      <FormulateForm
        v-model="formCreate"
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
            v-model="formCreate.thumbnail"
            label="Foto Thumbnail"
            :errors="errors.thumbnail"
            size="show"
            class="w-1/2 p-2"
          />
          <div>
            <vue-editor id="content" v-model="formCreate.body" class="mx-2" placeholder="Article body goes here..." />
          </div>
        </div>
        <div class="flex items-center justify-end w-full px-8 py-4 mt-8 bg-gray-100 border-t border-gray-200">
          <FormulateInput
            type="submit"
            name="Create Article"
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
    title: 'Create Article',
  },
  components: {
    VueEditor,
    FileInput,
  },

  mixins: [Upload],

  layout: Layout,

  props: {
    errors: [Object, Array],
  },

  remember: 'formCreateArticle',

  data() {
    return {
      formCreate: {
        title: null,
        body: null,
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

      if (this.formCreate.thumbnail) {
        const result = await this.uploader(this.formCreate.thumbnail, 'thumbnail')
        if (!result) return false

        form.thumbnail = [result]
      } else {
        delete form.thumbnail
      }

      this.$inertia.post(this.route('articles.store'), form)
    },
  },
}
</script>
