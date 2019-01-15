# mktg-rsthecon

## Hosted on wpengine

 - Stage: http://rstheconstage.wpengine.com/
 - Prod: http://rstheconprod.wpengine.com/
 - Prod Alias: http://rsthecon.rewardstyle.com/

## Requirements

NodeJS - [Download](https://nodejs.org/en/)  
`gulp: $npm install gulp-cli -g`

## Getting Started

Open your OS Command Line Tool

`$cd /path/to/theme`  
`$npm install`  
`$gulp`

## Finding Things

All development files e.g sass, js etc can be found in /assets folder.  
The gulp task once run will compile these files to the /dist folder. All JS is built into script.min.js with vendor js files being ordered first.

### Template Parts

*Global Parts*
/views

*Page Sections*
/views/sections

Section ID's can also easily be edited in the front-page.php without having to jump to each template part.

### Template SCSS

*Global Parts*

/assets/sass/parts

*Page Sections*

/assets/sass/sections

*Understand BEM Mixin I have used:*

```
@include e('element') {
  /* CSS declarations for `.block__element` */
  @include m('modifier') {
    /* CSS declarations for `.block--modifier` */
  }
}
```

### JS files

/assets/js
