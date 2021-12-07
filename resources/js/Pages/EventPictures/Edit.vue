<template>
  <div>
    <div class="flex justify-start mb-8">
      <h1 class="text-3xl font-bold">
        <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('event-pictures.index')">Back</inertia-link>
        <span class="font-medium text-indigo-400">/</span> Edit Event Picture
      </h1>
    </div>

    <div class="overflow-hidden bg-white rounded shadow lg:max-w-3xl">
      <FormulateForm
        v-model="formEdit"
        name="formEdit"
        @submit="submit"
      >
        <div class="flex flex-wrap p-5">
          <FileInput
            ref="fileUpload"
            v-model="formEdit.event_picture_file"
            :errors="errors.event_picture_file"
            hide-size
            class="w-full p-2"
          />
        </div>

        <div class="flex items-center justify-between w-full px-8 py-4 bg-gray-100 border-t border-gray-200">
          <button
            v-if="!eventPicture.data.deleted_at && can('delete-event-picture')"
            class="text-red-600 hover:underline"
            tabindex="-1"
            type="button"
            @click="destroy"
          >
            Delete Event Picture
          </button>

          <FormulateInput
            type="submit"
            name="Update Event Picture"
            :disabled="loading"
          >Update Event Picture<div v-if="loading" style="border-top-color:transparent" class="ml-3 w-5 h-5 border-4 border-blue-400 border-solid rounded-full animate-spin"></div>
          </FormulateInput>
        </div>
      </FormulateForm>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import FileInput from '@/Shared/FileInput'
import Upload from '@/Mixins/Upload'

export default {
  metaInfo: {
    title: 'Edit Event Picture',
  },

  components: {
    FileInput,
  },

  mixins: [Upload],

  layout: Layout,

  props: {
    errors: Object,
    eventPicture: [Object, Array],
  },

  remember: 'formEditEventPicture',

  data() {
    return {
      formEdit: {
        event_picture_file: this.eventPicture.data.file.length > 0 ? {
          name: this.eventPicture.data.file[0]['path'].split('/').pop(),
          path: this.eventPicture.data.file[0]['path'],
          url: this.eventPicture.data.file[0]['url'],
        } : null,
        type: 'update',
        loading: false,
      },
    }
  },

  watch: {
    'formEdit.document_file'() {
      if (this.errors.event_picture_file) {
        this.$set(this.errors, 'event_picture_file')
      }
    },
  },

  mounted() {
    this.setStorePath('event_pictures')
    this.setRouteUploadName('event-pictures.upload')
  },
  methods: {
    async submit(data) {
      this.loading = true
      let form = {
        ...data,
      }

      if (this.formEdit.event_picture_file) {
        const result = (!this.formEdit.event_picture_file || !this.formEdit.event_picture_file.path)
          ? await this.uploader(this.formEdit.event_picture_file, 'event_picture_file')
          : this.formEdit.event_picture_file
        if (!result) return false

        form.event_picture_file = [result]
      } else {
        delete form.event_picture_file
      }

      this.$inertia.put(this.route('event-pictures.update', this.eventPicture.data.id), form)
        .then(() => {
          this.loading = false
          if (!this.errors) {
            this.$formulate.reset('formEdit')
            this.$refs.fileUpload.remove()
          }
        })
    },
    destroy() {
      if(confirm('Are you sure you want to delete this event picture')) {
        this.$inertia.delete(this.route('event-pictures.destroy', this.eventPicture.data.id))
      }
    },
  },
}
</script>
