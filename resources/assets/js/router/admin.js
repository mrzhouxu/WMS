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
        {
            name: '店员编辑',
            path: '/employee/edit/:id?',
            component: resolve =>void(require(['../components/admin/employee/Edit.vue'], resolve))
        },
        {
            name: '经销商列表',
            path: '/dealer/list',
            component: resolve =>void(require(['../components/admin/dealer/List.vue'], resolve))
        },
        {
            name: '经销商编辑',
            path: '/dealer/edit/:id?',
            component: resolve =>void(require(['../components/admin/dealer/Edit.vue'], resolve))
        },
        {
            name: '我要进货',
            path: '/goods/purchase',
            component: resolve =>void(require(['../components/admin/goods/Purchase.vue'], resolve))
        },
        {
            name: '分类管理',
            path: '/goods/type',
            component: resolve =>void(require(['../components/admin/goods/Type.vue'], resolve))
        },
        {
            name: '缺货商品',
            path: '/goods/lack',
            component: resolve =>void(require(['../components/admin/goods/Lack.vue'], resolve))
        },
        {
            name: '商品列表',
            path: '/goods/goods',
            component: resolve =>void(require(['../components/admin/goods/Goods.vue'], resolve))
        },
        {
            name: '订单列表',
            path: '/order/list',
            component: resolve =>void(require(['../components/admin/order/List.vue'], resolve))
        },
    ]
})

