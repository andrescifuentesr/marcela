module.exports = {
  options: {
    livereload: true,
  },
  scripts: {
    files: ['js/*.js'],
    tasks: ['jshint', 'concat', 'uglify'],
    options: {
      spawn: false,
    }
  },
  css: {
    //files: ['css/scss/**/*.scss', 'css/scss/style.scss'],
    files: ['css/scss/**/*.scss'],
    tasks: ['sass', 'autoprefixer', 'cssmin'],
    options: {
      spawn: false,
    }
  },
  images: {
    files: ['img/**/*.{png,jpg,gif}', 'img/*.{png,jpg,gif}'],
    tasks: ['imagemin'],
    options: {
      spawn: false,
    }
  },
  html:{
    files: ['./**/*.html'],
    tasks: [],
    options: {
      spawn: false
    }
  },
  php:{
    files: ['./**/*.php'],
    tasks: [],
    options: {
      spawn: false
    }
  }  
}