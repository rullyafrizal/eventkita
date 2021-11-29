export default {
  methods: {
    /**
         * Authorization permissions
         *
         * @param {array|string} permissions
         * @returns {boolean|*}
         */
    can(permissions) {
      if(this.$page.props.auth.user.can['full-access']) {
        return true
      }

      if (Array.isArray(permissions)) {
        for (let i in permissions) {
          if (this.$page.props.auth.user.can[permissions[i]]) {
            return true
          }
        }
      }

      return !!this.$page.props.auth.user.can[permissions]
    },
  },
}
