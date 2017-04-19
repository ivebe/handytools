<p align="left"><img src="https://laravel.com/assets/img/components/logo-laravel.svg" style="height:40px"> <img src="https://vuejs.org/images/logo.png" style="width:40px; height: 40px;"></p>


## About

This is a collection of few handy tools that are needed on day to day basis. This project main goal is to be learning ground for Vue 2, hence it's new-user-contribution-friendly :) 

## Contributing HOW-TO

Creating new "tool" is quite easy.
 
- If you haven't already done so, make a [fork](https://help.github.com/articles/fork-a-repo/) of this repository.
- Go to the terminal and type `php artisan make:tool NAME-OF-YOUR-AWESOME-TOOL`
- This will create two files for you. One is new PHP class placed at `App\Tools\Yourawesometool` and second one is vue component placed at `resources\assets\js\tools\yourawesometool.vue`
- PHP class have 2 methods `get` and `post`. `get` is intended to be used on the initial call of the tool (if needed). `post` is action that you submit from your vue component and expect results of your awesome new tool.
- One more step is needed to be done manually. You need to add vue route to the `routes.js` file. Just copy last row and change your route and component accordingly. 
- Also don't forget to run `npm run watch` to compile your vue changes. List of tools is cached. So in case that you manually create new tools, don't forget to run `php artisan cache:clear` 

## Contributing by more experienced users

If you wish to contribute to the general setup of this app, please do not hesitate to do so, original idea is to make easy project for newbies to contribute to, but every good advice is more than welcome.

## License

[MIT license](http://opensource.org/licenses/MIT).
