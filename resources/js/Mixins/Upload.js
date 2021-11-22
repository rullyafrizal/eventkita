export default {
  data() {
    return {
      storePath: null,
      routeUploadName: null,
      resultFile: null,
    }
  },

  methods: {
    setStorePath(value) {
      this.storePath = value
    },

    setRouteUploadName(value) {
      this.routeUploadName = value
    },

    async uploader(file, errorName) {
      try {
        const formData = new FormData()
        formData.append('file', file)
        if (this.storePath) formData.append('store_path', this.storePath)
        formData.append('_token', this.$page.props.csrf_token)

        const result = await fetch(this.route(this.routeUploadName), {
          method: 'POST',
          headers: {
            Accept: 'application/json',
            // 'Content-Type': 'application/form-data',
          },
          body: formData,
        })

        this.resultFile = await result.json()

        if (this.resultFile.errors || !(this.resultFile.path && this.resultFile.url)) {
          console.log(this.resultFile)
          this.$set(this.errors, errorName, ['Unable to upload file'])
          return false
        }

        return this.resultFile
      } catch (err) {
        console.error('err ', err.response)
        // const error = err.response.data
        this.$set(this.errors, errorName, ['Unable to upload file'])
        return false
      }
    },
  },
}
