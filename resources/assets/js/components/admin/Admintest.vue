<template>
    <div v-loading="loading" element-loading-text="拼命加载中~~~">
        <div class="gm-breadcrumb">
            <span class="el-breadcrumb__item__inner"><i class="ion-ios-home gm-home"></i>当前位置：</span>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>管理系统</el-breadcrumb-item>
                <el-breadcrumb-item>首页</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <h1>admin</h1>
    </div>
</template>

<script>
    export default{
        components : {

        },
        data(){
            return {
                loading:false;
        }
        },
        methods : {

        },
        mounted(){

        }
    }
</script>
