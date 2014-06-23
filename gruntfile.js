module.exports = function (grunt) {
	
	// Initialize configuration object
	grunt.initConfig({

		// Read in project settings
		pkg: grunt.file.readJSON('package.json'),

		// User editable project settings & variables
		options: {
			// Base path to your assets folder
			base: 'assets',

			// Published assets path
			publish: 'public',

			// Files to be clean on rebuild
			clean: {
				all: ['<%= options.css.concat %>', '<%= options.css.min %>', '<%= options.js.min %>', '<%= options.js.concat %>'],
				concat: ['<%= options.css.concat %>', '<%= options.js.concat %>']
			},

			// CSS settings
			css: {
				base: 'assets/css',			 				// Base path to your CSS folder
				files: ['assets/css/*.css', 'assets/css/components/*.css', 'assets/css/vendor/*.css'], // CSS files in order you'd like them concatenated and minified
				concat: '<%= options.publish %>/concat.css',	// Name of the concatenated CSS file
				min: '<%= options.publish %>/style.min.css'		// Name of the minified CSS file
			},

			// JavaScript settings
			js: {
				base: 'assets/js', // Base path to you JS folder
				files: [
					// Vendor
					'assets/js/vendor/jquery.js', 
					'assets/js/vendor/leaflet-0.7.js', 
					'assets/js/vendor/leaflet.markercluster.js',
					'assets/js/vendor/leaflet.label.js',
					'assets/js/vendor/tile.stamen.js',
					'assets/js/vendor/chosen.jquery.js',

					// Map js
					'assets/js/custom/map.js',
					// Various form submit
					'assets/js/custom/form.js',
					// Compass navigation
					'assets/js/custom/compass.js',
					// Sidebar navigation
					'assets/js/custom/sidebar.js',
					// Master cluster
					'assets/js/custom/mastercluster.js',

				], // JavaScript files in order you'd like them concatenated and minified
				concat: '<%= options.publish %>/concat.js',		// Name of the concatenated JavaScript file
				min: '<%= options.publish %>/script.min.js'		// Name of the minified JavaScript file
			},

			// Files and folders to watch for live reload and rebuild purposes
			watch: {
				files: ['<%= options.js.files %>', '<%= options.css.files %>', '!<%= option.js.min %>']
			}
		},

		// Clean files and folders before replacement
		clean: {
			all: {
				src: '<%= options.clean.all %>'
			},
			concat: {
				src: '<%= options.clean.concat %>'
			}
		},

		// Concatenate multiple sets of files
		concat: {
			css: {
				files: {
					'<%= options.css.concat %>' : ['<%= options.css.files %>']
				}
			},

			js: {
				options: {
					block: false,
					line: false,
					stripBanners: false
				},
				files: {
					'<%= options.js.concat %>' : '<%= options.js.files %>',
				}
			}
		},

		// Minify and concatenate CSS files
		cssmin: {
			minify: {
     		src: '<%= options.css.concat %>',
      	dest: '<%= options.css.min %>'
			}
		},

		// Javascript linting - JS Hint
		jshint: {
			files: ['<%= options.js.files %>'],
			options: {
				// Options to override JSHint defaults
				curly: true,
				indent: 4,
				trailing: true,
				devel: true,
				globals: {
					jQuery: true
				}
			}
		},

		// Javascript minification - uglify
		uglify: {
			options: {
				preserveComments: false
			},
			files: {
				src: '<%= options.js.concat %>',
				dest: '<%= options.js.min %>'
			}
		},

		// Watch for files and folder changes
		watch: {
			// options: {
			// 	livereload: false
			// },
			files: ['assets/css/*.css', 'assets/css/components/*.css', 'assets/css/vendor/*.css', 'assets/js/vendor/*.js', 'assets/js/custom/*.js', 'assets/js/custom/modal/*.js', 'assets/js/custom/map/*.js',  'assets/js/custom/comment/*.js'],
			tasks: ['clean:all',  'concat:css', 'concat:js', 'cssmin', 'uglify']
		}

	});

	// Load npm tasks
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-compress');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');

	// Register tasks
	grunt.registerTask('default', ['clean:all',  'concat:css', 'concat:js', 'cssmin', 'uglify', 'clean:concat']); // Default task
};