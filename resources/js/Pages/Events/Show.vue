<template>
  <div class="container mb-24">
    <div class="flex justify-between max-w-5xl mb-8">
      <div>
        <h1 class="text-3xl font-bold">
          <inertia-link
            class="text-indigo-400 hover:text-indigo-600"
            :href="route('events.index')"
          >
            Back
          </inertia-link>
          <span class="font-medium text-indigo-400">/</span>
          Event {{ event.data.name }}
        </h1>
      </div>
      <div class="mt-3">
        <inertia-link
          v-if="can('edit-event') && !event.data.deleted_at"
          class="btn-indigo"
          :href="route('events.edit', event.data.id)"
        >
          <span>Edit Event</span>
        </inertia-link>
      </div>
    </div>

    <trashed-message
      v-if="event.data.deleted_at && can('restore-event')"
      class="mb-6"
      @restore="restore"
    >
      This event has been deleted.
    </trashed-message>
    <div class="bg-white rounded shadow overflow-x-auto p-8">
      <div class="flex justify-between mb-4">
        <div class="flex">
          <div class="mr-4 ml-2">
            <h1 class="text-3xl font-bold text-gray-700">
              {{ event.data.name }}
            </h1>
          </div>
        </div>
      </div>
      <div v-if="event.data.pictures.data.length" class="flex justify-center overflow-x-auto bg-white rounded shadow mx-4 mb-5">
        <div class="flex">
          <div class="m-5">
            <img
              class="object-cover w-full rounded-md"
              :src="activeImage.path"
              alt="profile image"
            />
          </div>
        </div>
      </div>
      <div v-else class="overflow-x-auto bg-white rounded shadow mx-4 mb-5">
        <div class="flex justify-center">
          <div class="m-5">
            <h1 class="text-3xl font-bold">
              No Pictures Found
            </h1>
            <h3 class="text-md mt-2 font-light">
              <inertia-link
                class="text-indigo-400 hover:text-indigo-600"
                :href="route('event-pictures.create')"
              >
                + Add Pictures
              </inertia-link>
            </h3>
          </div>
        </div>
      </div>
      <div v-if="event.data.pictures.data.length" class="flex flex-row flex-wrap -mx-2 mb-8 px-4">
        <div v-for="picture in event.data.pictures.data"
             :key="picture.id"
             class="w-full cursor-pointer sm:w-1/5 h-32 md:h-48 mb-4 sm:mb-0 px-2"
             @click="activateImage(picture)"
        >
          <a
            class="block w-full h-full bg-grey-dark bg-no-repeat bg-center bg-cover rounded-md"
            :class="{'outline-none ring-4 ring-indigo-700 border-transparent': picture.id === activeImage.id}"
            :style="{ backgroundImage: `url(${picture.path})` }"
          />
        </div>
      </div>
      <hr class="mt-8 mb-6 mx-2" />
      <h4 class="text-xl font-medium mx-1 mb-5 text-gray-600">
        <span
          class="justify-center px-2 py-1 mb-1 ml-4 text-lg font-bold text-white rounded-full bg-indigo-600 hover:bg-orange-600 cursor-text"
        >&nbsp;Event Informations :&nbsp;</span>
      </h4>

      <div class="overflow-x-auto bg-white rounded shadow mx-4 mb-5">
        <table class="w-full whitespace-no-wrap">
          <tr class="font-bold text-left bg-gray-100">
            <th class="px-6 pt-6 pb-4">Organizer</th>
            <th class="px-6 pt-6 pb-4">Location</th>
            <th class="px-6 pt-6 pb-4">Status</th>
            <th class="px-6 pt-6 pb-4">Quota</th>
            <th class="px-6 pt-6 pb-4">Start Date</th>
            <th class="px-6 pt-6 pb-4">End Date</th>
          </tr>

          <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
              <span class="flex items-center px-6 py-4">
                {{ event.data.user.name }}
              </span>
            </td>
            <td class="border-t">
              <span class="flex items-center px-6 py-4">
                {{ event.data.location }}
              </span>
            </td>

            <td class="border-t">
              <span v-if="event.data.status === 'OPEN'"
                    class="justify-center px-2 py-1 mb-1 ml-4 text-xs font-bold text-white rounded-full bg-green-600 cursor-pointer"
              >
                OPENED
              </span>
              <span v-else
                    class="justify-center px-2 py-1 mb-1 ml-4 text-xs font-bold text-white rounded-full bg-red-600 cursor-pointer"
              >
                CLOSED
              </span>
            </td>

            <td class="border-t">
              <span class="flex items-center px-6 py-4">
                {{ event.data.quota }}
              </span>
            </td>

            <td class="border-t">
              <span class="flex items-center px-6 py-4">
                {{ event.data.start_date }}
              </span>
            </td>

            <td class="border-t">
              <span class="flex items-center px-6 py-4">
                {{ event.data.end_date }}
              </span>
            </td>
          </tr>
        </table>
      </div>

      <div class="overflow-x-auto bg-white hover:bg-gray-50 rounded shadow mx-4 mb-5">
        <div v-if="event.data.informations.data.length" class="grid grid-cols-2 gap-4 mx-5 my-5">
          <div v-for="information in event.data.informations.data" :key="information.id" class="font-medium">
            &bull; &nbsp;{{ information.information }}
          </div>
        </div>
      </div>
      <hr class="mt-8 mb-6 mx-2" />
      <h4 class="text-xl font-medium mx-1 mb-5 text-gray-600">
        <span
          class="justify-center px-2 py-1 mb-1 ml-4 text-lg font-bold text-white rounded-full bg-indigo-600 hover:bg-orange-600 cursor-text"
        >&nbsp;Event Description :&nbsp;</span>
      </h4>
      <div class="overflow-x-auto bg-white hover:bg-gray-50 rounded shadow mx-4">
        <div class="prose lg:prose-m my-7 mx-10" v-html="event.data.description" />
      </div>
    </div>
    <div class="flex items-center justify-end w-full px-8 py-4 mt-8 bg-gray-100 border-t border-gray-200">
      <button
        v-if="can('delete-event')"
        class="text-red-600 hover:underline"
        tabindex="-1"
        type="button"
        @click="destroy"
      >
        Delete Event
      </button>
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
    event: [Object, Array],
  },

  metaInfo: {
    title: 'Show Event',
  },

  data() {
    return {
      activeImage: this.event.data.pictures.data[0],
    }
  },

  methods: {
    restore() {
      if (confirm('Are you sure you want to restore this event?')) {
        this.$inertia.put(this.route('articles.restore', this.article.data.id))
      }
    },
    activateImage(param) {
      this.activeImage = param
    },
    destroy() {
      if(confirm('Are you sure you want to destroy this event?')) {
        this.$inertia.delete(this.route('events.destroy', this.event.data.id))
      }
    },
  },
}
</script>
