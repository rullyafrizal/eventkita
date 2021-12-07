<template>
  <div class="container mb-24">
    <h1 class="mb-8 text-3xl font-bold">
      <inertia-link
        class="text-indigo-400 hover:text-indigo-600"
        :href="route('event-pictures.index')"
      >
        Back
      </inertia-link>
      <span class="font-medium text-indigo-400">/</span>
      Create Event Pictures
    </h1>

    <div class="max-w-4xl overflow-hidden bg-white rounded shadow">
      <FormulateForm
        v-model="formCreate"
        :errors="errors"
        @submit="submit"
      >
        <div class="flex flex-wrap p-5">
          <FormulateInput
            name="events"
            type="select"
            label="Choose Event"
            validation="required"
            class="w-1/2 p-2"
            :options="events"
            placeholder="Event Type"
          />

          <FormulateInput
            type="hidden"
            class="w-1/2 p-2"
          />

          <FileInput
            v-for="event_picture in formCreate.event_pictures"
            :key="event_picture.id"
            ref="fileUpload"
            v-model="event_picture.file"
            :label="event_picture.label"
            :errors="errors.event_pictures"
            hide-size
            size="show"
            class="w-1/2 p-2"
          />
        </div>

        <div class="flex items-center justify-end w-full px-8 py-4 mt-8 bg-gray-100 border-t border-gray-200">
          <FormulateInput
            type="submit"
            name="Create Event Picture"
            :disabled="loading"
          >Create Event Picture<div v-if="loading" style="border-top-color:transparent" class="ml-3 w-5 h-5 border-4 border-blue-400 border-solid rounded-full animate-spin"></div>
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
import throttle from 'lodash/throttle'
import pickBy from 'lodash/pickBy'

export default {
  metaInfo: {
    title: 'Create Event Pictures',
  },
  components: {
    FileInput,
  },

  mixins: [
    Upload,
  ],

  layout: Layout,

  props: {
    errors: [Object, Array],
    events: [Object, Array],
  },

  remember: 'formCreateEvent',

  data() {
    return {
      formCreate: {
        events: null,
        event_pictures: [
          {
            id: 1,
            file: null,
            label: 'Picture 1 ',
          },
        ],
      },
      loading: false,
      limit: 5,
    }
  },

  watch: {
    formCreate: {
      handler: throttle(function() {
        let query = pickBy(this.formCreate)
        const length = query.event_pictures.length
        const lastItem = query.event_pictures[length - 1]

        if (length < this.limit && lastItem.file) {
          query.event_pictures.push({
            id: lastItem.id + 1,
            file: null,
            label: `Picture ${lastItem.id + 1} `,
          })
        }

        if (length >= 2) {
          const secondLastItem = query.event_pictures[length - 2]
          if (!secondLastItem.file) {
            query.event_pictures.pop()
          }
        }

      }, 100),
      deep: true,
    },
    'formCreate.events': {
      handler: throttle(function() {
        if (this.formCreate.events) {
          this.getLimit(this.formCreate.events)
            .then((limit) => {
              this.limit = limit
            })
        }
      }, 100),
      deep: true,
    },
  },

  mounted() {
    this.setStorePath('event_pictures')
    this.setRouteUploadName('event-pictures.upload')
  },

  methods: {
    async submit(data) {
      this.loading = true
      let form = data

      if (this.formCreate.event_pictures.length) {
        const event_pictures = this.formCreate.event_pictures.filter((item) => item.file)

        if(event_pictures.length) {
          for(let i = 0; i < event_pictures.length; i++) {
            const result = await this.uploader(event_pictures[i].file, 'event_pictures')
            if (!result) return false

            event_pictures[i].file = [result]
          }

          form.event_pictures = event_pictures
        }
      }

      this.$inertia.post(this.route('event-pictures.store'), form, {
        onSuccess: () => {
          this.loading = false
        },
        onFailure: () => {
          this.loading = false
        },
      })
    },

    async getLimit(event_id) {
      const response = await this.fetchLimit(event_id)

      return response.data.limit
    },

    async fetchLimit(event_id) {
      const response = await fetch(this.route('events.check-limit-event-pictures', event_id), {
        headers: {
          'Content-Type': 'application/json',
          // 'Content-Type': 'application/x-www-form-urlencoded',
        },
        method: 'GET',
      })

      return response.json()
    },
  },
}
</script>
