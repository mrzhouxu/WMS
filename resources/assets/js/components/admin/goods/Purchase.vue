<template>
    <div v-loading="loading" element-loading-text="拼命加载中~~~">
        <div class="gm-breadcrumb">
            <span class="el-breadcrumb__item__inner"><i class="ion-ios-home gm-home"></i>当前位置：</span>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>商品管理</el-breadcrumb-item>
                <el-breadcrumb-item>我要进货</el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <el-card :body-style="{ padding: '0px' }" style="display: inline-block;padding: 8px;margin: 0 6px;">
            <img src="/img/1-96.jpg" class="image" style="width: 200px;height: 200px;">
            <div style="padding: 14px;">
                <span>好吃的汉堡</span>
                <div class="bottom clearfix">
                    <el-button type="text" class="button">操作按钮</el-button>
                </div>
            </div>
        </el-card>

    </div>
</template>

<script>
    export default{
        components : {

        },
        data(){
            return {
                loading:false
            }
        },
        methods : {

        },
        mounted(){

        }
    }
</script>
<style>
    .time {
        font-size: 13px;
        color: #999;
    }

    .bottom {
        margin-top: 13px;
        line-height: 12px;
    }

    .button {
        padding: 0;
        float: right;
    }

    .image {
        width: 100%;
        display: block;
    }

    .clearfix:before,
    .clearfix:after {
        display: table;
        content: "";
    }

    .clearfix:after {
        clear: both
    }
</style>