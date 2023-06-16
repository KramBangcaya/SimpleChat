import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);
const routes = [
    {
        path: '*',
        name: 'not-found',
        component: require('./components/NotFound.vue').default
    },
    {
        path: '/Chat',
        name: 'Chat',
        component: require('./components/Chat.vue').default,
    },
    {
        path: '/Server',
        name: 'Server',
        component: require('./components/Server.vue').default
    },
    {
        path: '/groupchat',
        name: 'Group Chat',
        component: require('./components/GroupChat.vue').default
    },
    //---------------------------------------------------------USER
    {
        path: '/users',
        name: 'users',
        component: require('./components/Users/IndexUser.vue').default,
        props: true,
    },
    //---------------------------------------------------------END USER
    //---------------------------------------------------------ROLE
    {
        path: '/role',
        name: 'role',
        component: require('./components/Role/IndexRole.vue').default,
        props: true,
    },
    // {
    //     path: '/role-add/:page',
    //     name: 'role_add',
    //     component: require('./components/Role/AddRole.vue').default,
    //     props: true,
    // },
    //---------------------------------------------------------END ROLE
    //---------------------------------------------------------PERMISSION
    {
        path: '/permission',
        name: 'permission',
        component: require('./components/Permission/IndexPermission.vue').default
    },
    // {
    //     path: '/permission-add',
    //     name: 'permission-add',
    //     component: require('./components/Permission/AddPermission.vue').default
    // },
    //---------------------------------------------------------END PERMISSION
    //---------------------------------------------------------REGISTRAR
    {
        path: '/registrar',
        name: 'registrar',
        component: require('./components/Registrar/IndexRegistrar.vue').default
    },
    //---------------------------------------------------------END REGISTRAR
    //---------------------------------------------------------PROGRAM
    {
        path: '/program',
        name: 'program',
        component: require('./components/Program/IndexProgram.vue').default
    },
    //---------------------------------------------------------END PROGRAM
]
// Vue.component(
//     'enrollment-status',
//     require('./components/EnrollmentStatus.vue').default
// );
const router = new Router({
    mode: 'history',
    routes: routes
});

export default router
