<template>
  <div class="container mb-24">
    <h1 class="mb-8 text-3xl font-bold">
      <inertia-link
        class="text-indigo-400 hover:text-indigo-600"
        :href="route('events.index')"
      >
        Back
      </inertia-link>
      <span class="font-medium text-indigo-400">/</span>
      Create Event
    </h1>

    <div class="max-w-4xl overflow-hidden bg-white rounded shadow">
      <FormulateForm
        v-model="formCreate"
        :errors="errors"
        @submit="submit"
      >
        <div class="flex flex-wrap p-5">
          <FormulateInput
            name="name"
            type="text"
            label="Name"
            placeholder="Vaksinasi bersama TNI-AL"
            validation-name="Name"
            validation="required"
            class="w-1/2 p-2"
          />

          <FormulateInput
            name="location"
            type="text"
            label="Location"
            placeholder="Bandara Juanda"
            validation-name="Location"
            validation="required"
            class="w-1/2 p-2"
          />

          <FormulateInput
            name="start_date"
            type="vue-datetime"
            datetype="datetime"
            label="Start Date"
            title="Start Date"
            validation="date"
            validation-name="Start Date"
            placeholder="2021-12-31"
            class="w-1/2 p-2"
            format="y-MM-dd"
            zone="Asia/Jakarta"
            value-zone="Asia/Jakarta"
            :flow="['date', 'time']"
            :max-datetime="setMaximalDatetime(formCreate.start_date)"
          />

          <FormulateInput
            name="end_date"
            type="vue-datetime"
            datetype="datetime"
            label="End Date"
            title="End Date"
            validation="date"
            validation-name="End Date"
            placeholder="2021-12-31"
            class="w-1/2 p-2"
            format="y-MM-dd"
            zone="Asia/Jakarta"
            value-zone="Asia/Jakarta"
            :flow="['date', 'time']"
            :min-datetime="setMinimalDatetime(formCreate.start_date)"
          />

          <FormulateInput
            name="quota"
            type="number"
            label="Quota"
            placeholder="1500"
            validation-name="Quota"
            validation="required"
            class="w-1/2 p-2"
          />

          <FormulateInput
            name="event_type"
            type="select"
            label="Choose Event Type"
            validation="required"
            class="w-1/2 p-2"
            :options="eventTypes"
            placeholder="Event Type"
          />

          <FormulateInput
            name="event_informations"
            type="textarea"
            label="Event Informations"
            validation="required"
            class="w-1/2 p-2"
            help="Pisahkan dengan koma, apabila lebih dari 1"
            placeholder="Gratis tidak dipungut biaya, Quota lebih dari 1000 orang"
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
          <div>
            <vue-editor id="content" v-model="formCreate.description" class="mx-2 mt-6" placeholder="Event description goes here..." />
          </div>
        </div>
        <div class="flex items-center justify-end w-full px-8 py-4 mt-8 bg-gray-100 border-t border-gray-200">
          <div v-if="loading" class="mr-4 animate-spin rounded-full h-4 w-4 border-t-2 border-b-2 border-black" />
          <FormulateInput
            type="submit"
            name="Create Event"
            :disabled="loading"
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
import throttle from 'lodash/throttle'
import pickBy from 'lodash/pickBy'
import Date from '../../Mixins/Date'

export default {
  metaInfo: {
    title: 'Create Event',
  },
  components: {
    VueEditor,
    FileInput,
  },

  mixins: [
    Upload,
    Date,
  ],

  layout: Layout,

  props: {
    errors: [Object, Array],
    eventTypes: [Object, Array],
  },

  remember: 'formCreateEvent',

  data() {
    return {
      formCreate: {
        name: null,
        location: null,
        description: null,
        quota: null,
        start_date: null,
        end_date: null,
        event_type: null,
        event_informations: null,
        event_pictures: [
          {
            id: 1,
            file: null,
            label: 'Picture 1 ',
          },
        ],
      },
      loading: false,
    }
  },

  watch: {
    formCreate: {
      handler: throttle(function() {
        let query = pickBy(this.formCreate)
        const length = query.event_pictures.length
        const lastItem = query.event_pictures[length - 1]

        if (length < 5 && lastItem.file) {
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

      this.$inertia.post(this.route('events.store'), form, {
        onSuccess: () => {
          this.loading = false
        },
        onFailure: () => {
          this.loading = false
        },
      })
    },
  },
}
</script>
