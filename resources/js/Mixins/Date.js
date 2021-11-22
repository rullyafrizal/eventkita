export default {
  methods: {

    /**
         * Set minimal datetime in input type date
         *
         * @param {string} startDate
         * @returns {string}
         */
    setMinimalDatetime(startDate) {
      if (startDate) {
        return new Date(startDate).toISOString()
      }
    },

    /**
         * Set maximal datetime in input type date
         *
         * @param {string} endDate
         * @returns {string}
         */
    setMaximalDatetime(endDate) {
      if(endDate) {
        return new Date(endDate).toISOString()
      }
    },
  },
}
