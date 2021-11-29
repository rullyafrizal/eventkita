<template>
  <div class="mb-24">
    <div class="mb-8 flex justify-start">
      <h1 class="font-bold text-3xl">
        <inertia-link
          class="text-indigo-400 hover:text-indigo-600"
          :href="route('roles.index')"
        >
          Back
        </inertia-link>
        <span class="text-indigo-400 font-medium">/</span>
        Edit Role
      </h1>
    </div>

    <div class="max-w-3xl overflow-hidden bg-white rounded shadow">
      <form @submit.prevent="submit">
        <div class="flex flex-col flex-wrap p-5">
          <label for="name" class="font-bold mb-2">Name</label>
          <input
            id="name"
            v-model.lazy="formEdit.name"
            type="text"
            placeholder="Name"
            name="name"
            class="w-1/2 p-2 border border-gray-500 rounded mb-2"
            required
          />
          <small v-if="errors.name" class="text-red-500">{{ errors.name }}</small>

          <div class="font-bold mt-5">Full Access Permissions</div>
          <div class="grid grid-cols-3 gap-7 my-3">
            <div v-for="permission in fullAccessPermission" :key="permission.name" class="col-span-1">
              <label :for="permission.name">
                <input
                  :id="permission.name"
                  v-model="isCheckAll"
                  type="checkbox"
                  :value="permission.name"
                  @click="checkAll"
                />
                {{ permission.name }}
              </label>
            </div>
          </div>

          <div class="font-bold mt-2">Dashboard Permissions</div>
          <div class="grid grid-cols-3 gap-6 my-3">
            <div v-for="permission in dashboardPermissions" :key="permission.name" class="col-span-1">
              <label :for="permission.name">
                <input
                  :id="permission.name"
                  v-model.lazy="formEdit.permissions"
                  type="checkbox"
                  :value="permission.name"
                  @change="updateCheckAll"
                />
                {{ permission.name }}
              </label>
            </div>
          </div>

          <div class="font-bold mt-2">Role Permissions</div>
          <div class="grid grid-cols-3 gap-6 my-3">
            <div v-for="permission in rolePermissions" :key="permission.name" class="col-span-1">
              <label :for="permission.name">
                <input
                  :id="permission.name"
                  v-model.lazy="formEdit.permissions"
                  type="checkbox"
                  :value="permission.name"
                  @change="updateCheckAll"
                />
                {{ permission.name }}
              </label>
            </div>
          </div>

          <div class="font-bold mt-2">User Permissions</div>
          <div class="grid grid-cols-3 gap-6 my-3">
            <div v-for="permission in userPermissions" :key="permission.name" class="col-span-1">
              <label :for="permission.name">
                <input
                  :id="permission.name"
                  v-model.lazy="formEdit.permissions"
                  type="checkbox"
                  :value="permission.name"
                  @change="updateCheckAll"
                />
                {{ permission.name }}
              </label>
            </div>
          </div>

          <div class="font-bold mt-2">Event Type Permissions</div>
          <div class="grid grid-cols-3 gap-6 my-3">
            <div v-for="permission in eventTypePermissions" :key="permission.name" class="col-span-1">
              <label :for="permission.name">
                <input
                  :id="permission.name"
                  v-model.lazy="formEdit.permissions"
                  type="checkbox"
                  :value="permission.name"
                  @change="updateCheckAll"
                />
                {{ permission.name }}
              </label>
            </div>
          </div>

          <div class="font-bold mt-2">Article Permissions</div>
          <div class="grid grid-cols-3 gap-6 my-3">
            <div v-for="permission in articlePermissions" :key="permission.name" class="col-span-1">
              <label :for="permission.name">
                <input
                  :id="permission.name"
                  v-model.lazy="formEdit.permissions"
                  type="checkbox"
                  :value="permission.name"
                  @change="updateCheckAll"
                />
                {{ permission.name }}
              </label>
            </div>
          </div>

          <div class="font-bold mt-2">Event Permissions</div>
          <div class="grid grid-cols-3 gap-6 my-3">
            <div v-for="permission in eventPermissions" :key="permission.name" class="col-span-1">
              <label :for="permission.name">
                <input
                  :id="permission.name"
                  v-model.lazy="formEdit.permissions"
                  type="checkbox"
                  :value="permission.name"
                  @change="updateCheckAll"
                />
                {{ permission.name }}
              </label>
            </div>
          </div>

          <div class="font-bold mt-2">Event Picture Permissions</div>
          <div class="grid grid-cols-3 gap-6 my-3">
            <div v-for="permission in eventPicturePermissions" :key="permission.name" class="col-span-1">
              <label :for="permission.name">
                <input
                  :id="permission.name"
                  v-model.lazy="formEdit.permissions"
                  type="checkbox"
                  :value="permission.name"
                  @change="updateCheckAll"
                />
                {{ permission.name }}
              </label>
            </div>
          </div>
        </div>
        <div class="flex justify-between items-center px-8 py-4 bg-gray-100 border-t border-gray-200 w-full justify-end">
          <inertia-link
            href=""
            class="text-red-500"
            @click.prevent="destroy"
          >
            Delete
          </inertia-link>
          <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded">Submit</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'

export default {
  metaInfo: {
    title: 'Edit Role',
  },

  layout: Layout,

  props: {
    errors: [Object, Array],
    allPermissions: [Array, Object],
    fullAccessPermission: [Array, Object],
    dashboardPermissions: [Array, Object],
    rolePermissions: [Array, Object],
    userPermissions: [Array, Object],
    eventTypePermissions: [Array, Object],
    articlePermissions: [Array, Object],
    eventPermissions: [Array, Object],
    eventPicturePermissions: [Array, Object],
    role: [Object, Array],
  },

  remember: 'formEditRole',

  data() {
    return {
      isCheckAll: false,
      formEdit: {
        name: this.role.data.name,
        guard_name: this.role.data.guard_name,
        permissions: this.role.data.permissions_by_name,
      },
    }
  },

  mounted() {
    if (this.formEdit.permissions.includes('full-access')) {
      this.checkAll()
    }
  },

  methods: {
    async submit() {
      if (this.isCheckAll) {
        this.formEdit.permissions.splice(0, this.allPermissions.length)
        this.formEdit.permissions.push('full-access')
      }
      await this.$inertia.put(this.route('roles.update', this.role.data.id), this.formEdit)
    },

    destroy() {
      if (confirm(`Are you sure you want to delete this ${this.role.data.name} Role?`)) {
        this.$inertia.delete(this.route('roles.destroy', this.role.data.id))
      }
    },

    checkAll: function() {
      this.isCheckAll = !this.isCheckAll
      if (this.isCheckAll) {
        this.formEdit.permissions.splice(0, this.allPermissions.length)
        this.allPermissions.forEach(permission => {
          this.formEdit.permissions.push(permission.name)
        })
      } else {
        this.formEdit.permissions.splice(0, this.formEdit.permissions.length)
      }
    },

    updateCheckAll: function () {
      if (this.formEdit.permissions.length !== this.allPermissions.length) {
        this.isCheckAll = false
      }
    },
  },
}
</script>
