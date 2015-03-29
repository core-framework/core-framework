module.exports = function(grunt) {

    grunt.initConfig({
        uglify: {
            build: {
                options: {
                    sourceMap: true
                },
                files: grunt.file.expandMapping(['web/scripts/*.js', '!web/scripts/*.min.js'], 'web/scripts', {
                    rename: function(destBase, destPath) {
                        return destPath.replace('.js', '.min.js');
                    }
                })
            }
        },
        watch: {
            scripts: {
                files: 'web/scripts/*.js',
                tasks: ['uglify:build']
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.registerTask('default', ['watch']);
    grunt.registerTask('buildjs', ['uglify:build'])

};
