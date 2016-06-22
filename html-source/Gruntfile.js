module.exports = function (grunt) {
	// load all deps
	require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

	// configuration
	grunt.initConfig({
		pgk: grunt.file.readJSON('package.json'),
		
		// https://npmjs.org/package/grunt-contrib-compass
		compass: {
			all: {
				options: {
					sassDir:        'lib',
					cssDir:         'css',
					imagesDir:      'images',
					outputStyle:    'expanded',
					relativeAssets: true,
					noLineComments: true,
					watch:          true
				}
			}
		},

		// https://npmjs.org/package/grunt-contrib-watch
		watch: {
			options: {
				livereload: true
			},
			files: ['{,*/}/*.{css,js}', '{,*/}*.{php,html}']
		},
		
		// https://npmjs.org/package/grunt-concurrent
		concurrent: {
			server: [
				'compass:all',
				'watch'
			]
		}
	});

	// when developing
	grunt.registerTask('server', [
		'concurrent:server'
	]);

	// defaults to the server
	grunt.registerTask('default', [
		'server'
	]);
};