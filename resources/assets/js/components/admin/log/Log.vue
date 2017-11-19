<template>
    <div  v-loading="loading" element-loading-text="拼命加载中~~~">
        <div class="gm-breadcrumb">
            <span class="el-breadcrumb__item__inner"><i class="ion-ios-home gm-home"></i>当前位置：</span>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>日志查看</el-breadcrumb-item>
                <el-breadcrumb-item>日志列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <el-table
                :data="tableData"
                border
                stripe
                style="width: 100%">
            <el-table-column
                    type="index"
                    width="150">
            </el-table-column>
            <!--<el-table-column-->
                    <!--label="日期"-->
                    <!--width="180">-->
                <!--<template  slot-scope="scope">{{ scope.row.create_time | date }}</template>-->
            <!--</el-table-column>-->
            <el-table-column
                    prop="content"
                    label="内容">
            </el-table-column>
        </el-table>
        <!--<el-pagination-->
                <!--@size-change="handleSizeChange"-->
                <!--@current-change="handleCurrentChange"-->
                <!--:current-page="currentPage4"-->
                <!--:page-sizes="[100, 200, 300, 400]"-->
                <!--:page-size="100"-->
                <!--layout="total, sizes, prev, pager, next, jumper"-->
                <!--:total="400">-->
        <!--</el-pagination>-->
    </div>
</template>

<script>
    export default{
        components : {

        },
        data(){
            return {
                tableData: [],
                currentPage4: 1,
                loading:true
            }
        },
        methods : {
            handleSizeChange(val) {
                console.log(`每页 ${val} 条`);
            },
            handleCurrentChange(val) {
                console.log(`当前页: ${val}`);
            },
            getData(){
                let param = {
                    id:1,
                    name:2
                };
                axios.post('/admin/log/get_list',param)
                    .then(res=>{
//                        console.log(res.data)
                        this.tableData = res.data
                        this.loading = false
                    })
                    .catch(err=>{
                        this.loading = false
                    })
            }

        },
        mounted(){
            this.getData();
        }
    }
</script>
