<template>
  <div>
    <div class="flex justify-start max-w-3xl mb-8">
      <h1 class="text-3xl font-bold">
        <inertia-link
          class="text-indigo-400 hover:text-indigo-600"
          :href="route('event-types.index')"
        >
          Back
        </inertia-link>
        <span class="font-medium text-indigo-400">/</span>
        Edit Event Type
      </h1>
    </div>

    <trashed-message
      v-if="eventType.data.deleted_at && can('restore-event-type')"
      class="mb-6"
      @restore="restore"
    >
      This event type has been deleted.
    </trashed-message>

    <div class="max-w-3xl overflow-hidden bg-white rounded shadow">
      <FormulateForm
        v-model="formEdit"
        @submit="submit"
      >
        <div class="flex flex-wrap p-5">
          <FormulateInput
            name="name"
            type="text"
            label="Name"
            placeholder="Event Type..."
            validation="required"
            class="w-1/2 p-2"
          />
        </div>

        <div class="flex items-center justify-between w-full px-8 py-4 mt-8 bg-gray-100 border-t border-gray-200">
          <button
            v-if="!eventType.data.deleted_at && can('delete-event-type')"
            class="text-red-600 hover:underline"
            tabindex="-1"
            type="button"
            @click="destroy"
          >
            Delete Department
          </button>
          <FormulateInput
            type="submit"
            name="Update Department"
          />
        </div>
      </FormulateForm>
    </div>
  </div>
</template>

<script>
import Layout from '../../Shared/Layout'
import TrashedMessage from '../../Shared/TrashedMessage'

export default {
  name: 'Edit',

  components: {
    TrashedMessage,
  },

  layout: Layout,

  props: {
    errors: [Object, Array],
    eventType: [Object, Array],
  },

  metaInfo: {
    title: 'Edit Event Type',
  },

  remember: 'formEditEventType',

  data() {
    return {
      formEdit: {
        name: this.eventType.data.name,
      },
    }
  },

  methods: {
    async submit(data) {
      await this.$inertia.put(this.route('event-types.update', this.eventType.data.id), data)
    },

    destroy() {
      if (confirm('Are you sure you want to delete this eventType?')) {
        this.$inertia.delete(this.route('event-types.destroy', this.eventType.data.id))
      }
    },

    restore() {
      if (confirm('Are you sure you want to restore this eventType?')) {
        this.$inertia.put(this.route('event-types.restore', this.eventType.data.id))
      }
    },
  },
}
</script>
