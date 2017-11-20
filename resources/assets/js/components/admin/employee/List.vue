<template>
    <div v-loading="loading" element-loading-text="拼命加载中~~~">
        <div class="gm-breadcrumb">
            <span class="el-breadcrumb__item__inner"><i class="ion-ios-home gm-home"></i>当前位置：</span>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>店员管理</el-breadcrumb-item>
                <el-breadcrumb-item>店员列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <el-table
                :data="tableData"
                border
                stripe
                style="width: 100%">
            <el-table-column
                    type="index"
                    width="100">
            </el-table-column>
            <!--<el-table-column-->
            <!--label="日期"-->
            <!--width="180">-->
            <!--<template  slot-scope="scope">{{ scope.row.create_time | date }}</template>-->
            <!--</el-table-column>-->
            <el-table-column
                    label="照片">
                <template  slot-scope="scope">{{ scope.row.img }}</template>
            </el-table-column>
            <el-table-column
                    label="姓名">
                <template  slot-scope="scope">{{ scope.row.name }}</template>
            </el-table-column>
            <el-table-column
                    label="性别">
                <template  slot-scope="scope">{{ scope.row.sex }}</template>
            </el-table-column>
            <el-table-column
                    label="身份证号">
                <template  slot-scope="scope">{{ scope.row.card }}</template>
            </el-table-column>
            <el-table-column
                    label="联系方式">
                <template  slot-scope="scope">{{ scope.row.phone }}</template>
            </el-table-column>
            <el-table-column
                    label="家庭住址">
                <template  slot-scope="scope">{{ scope.row.address }}</template>
            </el-table-column>
            <el-table-column
                    label="登陆账号">
                <template  slot-scope="scope">{{ scope.row.user }}</template>
            </el-table-column>
            <el-table-column label="操作">
                <template slot-scope="scope">
                    <el-button
                            size="small"
                            @click="">编辑</el-button>
                    <el-button
                            size="small"
                            type="danger"
                            @click="">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
    export default{
        components : {

        },
        data(){
            return {
                loading:false,
                tableData: []
            }
        },
        methods : {
            getData(){
                let param = {
                    key:1,
                    val:2
                }
                axios.post('/admin/employee/list',param)
                    .then((res)=>{
                        this.tableData = res.data.result
                    })
                    .catch((err)=>{

                    })
            }
        },
        mounted(){
            this.getData()
        }
    }
</script>
