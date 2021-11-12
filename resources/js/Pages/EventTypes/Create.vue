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
        Create Event Type
      </h1>
    </div>

    <div class="max-w-3xl overflow-hidden bg-white rounded shadow">
      <FormulateForm
        v-model="formCreate"
        @submit="submit"
      >
        <div class="flex flex-wrap p-5">
          <FormulateInput
            name="name"
            type="text"
            label="Name"
            placeholder="Event Type name..."
            validation="required"
            class="w-1/2 p-2"
          />
        </div>

        <div class="flex items-center justify-end w-full px-8 py-4 mt-8 bg-gray-100 border-t border-gray-200">
          <FormulateInput
            type="submit"
            name="Create Event Type"
          />
        </div>
      </FormulateForm>
    </div>
  </div>
</template>

<script>
import Layout from '../../Shared/Layout'

export default {
  name: 'Create',

  metaInfo: {
    title: 'Create Department',
  },

  layout: Layout,

  props: {
    errors: [Object, Array],
  },

  remember: 'formCreateDepartment',

  data() {
    return {
      formCreate: {
        name: null,
      },
    }
  },

  methods: {
    async submit(data) {
      await this.$inertia.post(this.route('event-types.store'), data)
    },
  },
}
</script>
