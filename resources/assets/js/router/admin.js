import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

export default new VueRouter({
    saveScrollPosition: true,
    routes: [
        {
            name: "首页",
            path: '/',
            component: resolve =>void(require(['../components/admin/layout/index.vue'], resolve))
        },
        {
            name: "自动回复",
            path: '/wx/reply',
            component: resolve =>void(require(['../components/admin/wx/reply.vue'], resolve))
        },
        {
            name: '基础配置',
            path: '/wx/config',
            component: resolve =>void(require(['../components/admin/wx/config.vue'], resolve))
        },
        {
            name: '模板配置',
            path: '/wx/template',
            component: resolve =>void(require(['../components/admin/wx/temp.vue'], resolve))
        },
        {
            name: '菜单配置',
            path: '/wx/menu',
            component: resolve =>void(require(['../components/admin/wx/menu.vue'], resolve))
        },
        {
            name: '修改密码',
            path: '/super/password',
            component: resolve =>void(require(['../components/admin/super/password.vue'], resolve))
        },
        {
            name: '日志列表',
            path: '/log',
            component: resolve =>void(require(['../components/admin/log/Log.vue'], resolve))
        },
        {
            name: '店员列表',
            path: '/employee/list',
            component: resolve =>void(require(['../components/admin/employee/List.vue'], resolve))
        },
    ]
})

