module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		sass: {
			dist: {
				options: {
					style: 'compressed'
				},
				files: {
					'style.css' : 'sass/style.scss'
				}
			}
		},
		watch: {
			css: {
				files: 'sass/partials/*.scss',
				tasks: ['sass']
			}
		},
		uglify: {
			options: {
				banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'
			},
			dist: {
				files: {
					'js/minified/about.min.js' : ['js/custom/about.js'],
					'js/minified/blog.min.js'  : ['js/custom/blog.js'],
					'js/minified/home.min.js'  : ['js/custom/home.js'],
					'js/minified/nav.min.js'   : ['js/custom/nav.js'],
					'js/minified/photos.min.js': ['js/custom/photos.js'],
					'js/minified/single.min.js': ['js/custom/single.js'],
					'js/minified/jquery.lazyload.min.js' : ['js/contrib/jquery.lazyload.js']
				}
			}
		}
	});
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.registerTask('default', ['watch']);
	grunt.registerTask('css', ['sass']);
	grunt.registerTask('js', ['uglify']);
}
