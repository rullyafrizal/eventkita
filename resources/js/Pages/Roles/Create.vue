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
        Create Role
      </h1>
    </div>

    <div class="max-w-3xl overflow-hidden bg-white rounded shadow">
      <form @submit.prevent="submit">
        <div class="flex flex-col flex-wrap p-5">
          <label for="name" class="font-bold mb-2">Name</label>
          <input
            id="name"
            v-model.lazy="formCreate.name"
            type="text"
            placeholder="Name"
            name="name"
            class="w-1/2 p-2 border border-gray-500 rounded"
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
                  v-model.lazy="formCreate.permissions"
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
                  v-model.lazy="formCreate.permissions"
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
                  v-model.lazy="formCreate.permissions"
                  type="checkbox"
                  :value="permission.name"
                  @change="updateCheckAll"
                />
                {{ permission.name }}
              </label>
            </div>
          </div>
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-100 border-t border-gray-200 w-full justify-end">
          <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded">Create</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'

export default {
  metaInfo: {
    title: 'Create Role',
  },

  layout: Layout,

  props: {
    errors: [Object, Array],
    allPermissions: [Array, Object],
    fullAccessPermission: [Array, Object],
    dashboardPermissions: [Array, Object],
    rolePermissions: [Array, Object],
    userPermissions: [Array, Object],
  },

  remember: 'formCreateRole',

  data() {
    return {
      isCheckAll: false,
      formCreate: {
        name: null,
        permissions: [],
      },
    }
  },

  created() {
    console.log(this.rolePermissions)
  },

  methods: {
    async submit () {
      if (this.isCheckAll) {
        this.formCreate.permissions.splice(0, this.formCreate.permissions.length)
        this.formCreate.permissions.push('full-access')
      }
      await this.$inertia.post(this.route('roles.store'), this.formCreate)
    },

    checkAll: function() {
      this.isCheckAll = !this.isCheckAll
      if (this.isCheckAll) {
        this.formCreate.permissions.splice(0, this.formCreate.permissions.length)
        this.allPermissions.forEach(permission => {
          this.formCreate.permissions.push(permission.name)
        })
      } else {
        this.formCreate.permissions.splice(0, this.formCreate.permissions.length)
      }
    },

    updateCheckAll: function () {
      if (this.formCreate.permissions.length !== this.allPermissions.length) {
        this.isCheckAll = false
      }
    },
  },
}
</script>
