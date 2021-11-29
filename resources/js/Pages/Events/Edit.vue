<template>
  <div class="container mb-24">
    <h1 class="mb-8 text-3xl font-bold">
      <inertia-link
        class="text-indigo-400 hover:text-indigo-600"
        :href="route('events.show', event.data.id)"
      >
        Back
      </inertia-link>
      <span class="font-medium text-indigo-400">/</span>
      Edit Event
    </h1>

    <div class="max-w-4xl overflow-hidden bg-white rounded shadow">
      <FormulateForm
        v-model="formEdit"
        :errors="errors"
        @submit="submit"
      >
        <div class="flex flex-wrap p-5">
          <FormulateInput
            name="name"
            type="text"
            label="Name"
            placeholder="Event Name"
            validation-name="Name"
            validation="required"
            class="w-1/2 p-2"
          />

          <FormulateInput
            name="location"
            type="text"
            label="Location"
            placeholder="Event Location"
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
            :max-datetime="setMaximalDatetime(formEdit.start_date)"
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
            :min-datetime="setMinimalDatetime(formEdit.start_date)"
          />

          <FormulateInput
            name="quota"
            type="number"
            label="Quota"
            placeholder="Participant Quota"
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

          <div>
            <vue-editor id="content" v-model="formEdit.description" class="mx-2 mt-6" placeholder="Event description goes here..." />
          </div>
        </div>
        <div class="flex items-center justify-end w-full px-8 py-4 mt-8 bg-gray-100 border-t border-gray-200">
          <div v-if="loading" class="mr-4 animate-spin rounded-full h-4 w-4 border-t-2 border-b-2 border-black" />
          <FormulateInput
            type="submit"
            name="Update Event"
            :disabled="loading"
          />
        </div>
      </FormulateForm>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import {VueEditor} from 'vue2-editor'
import Date from '../../Mixins/Date'

export default {
  metaInfo: {
    title: 'Edit Event',
  },
  components: {
    VueEditor,
  },

  mixins: [
    Date,
  ],

  layout: Layout,

  props: {
    errors: [Object, Array],
    eventTypes: [Object, Array],
    event: [Object, Array],
    eventInformations: String,
  },

  remember: 'formEditEvent',

  data() {
    return {
      formEdit: {
        name: this.event.data.name,
        location: this.event.data.location,
        description: this.event.data.description,
        quota: this.event.data.quota,
        start_date: this.event.data.real_start_date,
        end_date: this.event.data.real_end_date,
        event_type: this.event.data.event_type.id,
        event_informations: this.eventInformations,
      },
      loading: false,
    }
  },

  methods: {
    submit(data) {
      this.loading = true

      this.$inertia.put(this.route('events.update', this.event.data.id), data, {
        onSuccess: () => {
          this.loading = false
        },
        onError: () => {
          this.loading = false
        },
      })
    },
  },
}
</script>
