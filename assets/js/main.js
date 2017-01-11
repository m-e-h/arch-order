var vm = new Vue({

	el: '#app',

	data: {
		posts: []
	},

	mounted: function() {
		this.fetchPosts()
	},

	watch: {
		'$route': function() {
			var self = this
			self.isLoading = true
			self.fetchPosts().then(function() {
				self.isLoading = false
			})
		}
	},

	methods: {
		fetchPosts: function() {
			var self = this
			axios.get('/wp-json/wp/v2/posts')
				.then(function(response) {
					vm.posts = response.data
				})
				.catch(function(error) {
					self.fetchError = error
				})
		}
	}
});
