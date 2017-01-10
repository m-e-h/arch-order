var vm = new Vue({

  el: '#demo',

  data: {
    posts: '',
	slug: null
  },

  created: function () {
    this.fetchData()
  },

  watch: {
	  '$route': function () {
		  var self = this
		  self.isLoading = true
		  self.fetchData().then(function () {
			  self.isLoading = false
		  })
	  }
  },

  methods: {
	  fetchData: function () {
		  var self = this
		  return axios.get('/wp-json/wp/v2/posts?per_page=20')
		  .then(function (response) {
			  self.posts = response
		  })
		  .catch(function (error) {
			  self.fetchError = error
		  })
	  }
  }
})
