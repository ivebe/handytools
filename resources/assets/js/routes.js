module.exports = {
    routes: [
        { path: '/', component: require('./components/List.vue') },
        { path: '/md5', component: require('./tools/md5.vue') },
        { path: '/bcrypt', component: require('./tools/bcrypt.vue') },
        { path: '/base64', component: require('./tools/base64.vue') },
        { path: '/passwd', component: require('./tools/passwd.vue')},
        { path: '/urlencdec', component: require('./tools/urlencdec.vue')},
    ]
};