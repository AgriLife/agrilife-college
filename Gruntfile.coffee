module.exports = (grunt) ->
	@initConfig
		pkg   : @file.readJSON('package.json')
		watch :
			files: ['**/**.coffee', '**/*.scss']
			tasks: ['develop']
		coffee:
			compile:
				expand : true
				flatten: true
				cwd    : 'js/src/'
				src    : ['*.coffee']
				dest   : 'js/'
				ext    : '.js'
		compass:
			dist:
				options:
					config : 'config.rb'
					specify: ['css/src/*.scss']
		jshint :
			files  : ['js/*.js']
			options:
				globals:
					jQuery  : true
					console : true
					module  : true
					document: true
				force  : true
		csslint:
			options:
				'star-property-hack'       : false
				'duplicate-properties'     : false
				'unique-headings'          : false
			# 'ids': false
				'display-property-grouping': false
				'floats'                   : false
				'outline-none'             : false
				'box-model'                : false
				'adjoining-classes'        : false
				'box-sizing'               : false
				'universal-selector'       : false
				'font-sizes'               : false
				'overqualified-elements'   : false
				force                      : true
			src    : ['css/*.css']
		concat :
			adminjs :
				src : ['js/src/admin-*.js']
				dest: 'js/admin.min.js'
			publicjs:
				src : ['js/src/public-*.js']
				dest: 'js/public.min.js'
		compress:
			main:
				options:
					archive: '<%= pkg.name %>.zip'
				files: [
					{src: ['fields/**']},
					{src: ['js/*.js']},
					{src: ['src/**']},
					{src: ['vendor/**', '!vendor/composer/autoload_static.php']},
					{src: ['view/**']},
					{src: ['agrilife-college.php']},
					{src: ['README.md']}
				]
		gh_release:
			options:
				token: process.env.RELEASE_KEY
				owner: 'agrilife'
				repo: '<%= pkg.name %>'
			release:
				tag_name: '<%= pkg.version %>'
				target_commitish: 'master'
				name: 'Release'
				body: 'First release'
				draft: false
				prerelease: false
				asset:
					name: '<%= pkg.name %>.zip'
					file: '<%= pkg.name %>.zip'
					'Content-Type': 'application/zip'

	@loadNpmTasks 'grunt-contrib-coffee'
	@loadNpmTasks 'grunt-contrib-compass'
	@loadNpmTasks 'grunt-contrib-jshint'
	@loadNpmTasks 'grunt-contrib-csslint'
	@loadNpmTasks 'grunt-contrib-concat'
	@loadNpmTasks 'grunt-contrib-watch'
	@loadNpmTasks 'grunt-contrib-compress'
	@loadNpmTasks 'grunt-gh-release'
	@loadNpmTasks 'grunt-gitinfo'

	@registerTask 'default', ['coffee']
	@registerTask 'develop', ['coffee', 'jshint']
	@registerTask 'package', ['default', 'csslint']
	@registerTask 'release', ['compress', 'setreleasemsg', 'gh_release']
	@registerTask 'setreleasemsg', 'Set release message as range of commits', ->
    done = @async()
    grunt.util.spawn {
      cmd: 'git'
      args: [ 'tag' ]
    }, (err, result, code) ->
      if(result.stdout!='')
        matches = result.stdout.match(/([^\n]+)$/)
        releaserange = matches[1] + '..HEAD'
        grunt.config.set 'releaserange', releaserange
        grunt.task.run('shortlog');
      done(err)
      return
    return
  @registerTask 'shortlog', 'Set gh_release body with commit messages since last release', ->
    done = @async()
    grunt.util.spawn {
      cmd: 'git'
      args: ['shortlog', grunt.config.get('releaserange'), '--no-merges']
    }, (err, result, code) ->
      if(result.stdout != '')
        grunt.config 'gh_release.release.body', result.stdout.replace(/(\n)\s\s+/g, '$1- ')
      else
        grunt.config 'gh_release.release.body', 'release'
      done(err)
      return
    return

	@event.on 'watch', (action, filepath) =>
		@log.writeln('#{filepath} has #{action}')