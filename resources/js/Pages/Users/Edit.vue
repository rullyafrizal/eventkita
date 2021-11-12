<template>
  <div>
    <div class="mb-8 flex justify-start max-w-3xl">
      <h1 class="font-bold text-3xl">
        <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('users.index')">Users</inertia-link>
        <span class="text-indigo-400 font-medium">/</span>
        {{ form.name }}
      </h1>
      <img v-if="user.photo" class="block w-8 h-8 rounded-full ml-4" :src="user.photo" alt="avatar" />
    </div>
    <trashed-message v-if="user.data.deleted_at" class="mb-6" @restore="restore">
      This user has been deleted.
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
          <text-input v-model="form.email" :error="form.errors.email" class="pr-6 pb-8 w-full lg:w-1/2" label="Email" />
          <text-input v-model="form.phone" :error="form.errors.phone" class="pr-6 pb-8 w-full lg:w-1/2" label="Phone" />
          <select-input v-if="can('full-access')" v-model="form.role" :error="form.errors.role" class="pr-6 pb-8 w-full lg:w-1/2" label="Role">
            <option v-for="role in roles" :key="role" :value="role" :selected="selectedRoles(role)">{{ role }}</option>
          </select-input>
          <text-input v-model="form.password" :error="form.errors.password" class="pr-6 pb-8 w-full lg:w-1/2" type="password" autocomplete="new-password" label="Password" />
          <text-input v-if="form.password" v-model="form.password_confirmation" :error="form.errors.password_confirmation" class="pr-6 pb-8 w-full lg:w-1/2" type="password" autocomplete="new-password" label="Password Confirmation" />
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!user.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete User</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update User</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  metaInfo() {
    return {
      title: `${this.user.data.name}`,
    }
  },
  components: {
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    user: [Object, Array],
    roles: [Object, Array],
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        _method: 'put',
        name: this.user.data.name,
        email: this.user.data.email,
        password: null,
        password_confirmation: null,
        phone: this.user.data.phone,
        role: this.user.data.roles_by_name[0],
      }),
    }
  },

  methods: {
    update() {
      this.form.post(this.route('users.update', this.user.data.id), {
        onSuccess: () => this.form.reset('password', 'photo'),
      })
    },
    destroy() {
      if (confirm('Are you sure you want to delete this user?')) {
        this.$inertia.delete(this.route('users.destroy', this.user.data.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this user?')) {
        this.$inertia.put(this.route('users.restore', this.user.data.id))
      }
    },

    selectedRoles(role) {
      return this.form.role.includes(role)
    },
  },
}
</script>
