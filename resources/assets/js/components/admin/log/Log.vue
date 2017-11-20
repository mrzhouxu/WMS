<template>
    <div  v-loading="loading" element-loading-text="拼命加载中~~~">
        <div class="gm-breadcrumb">
            <span class="el-breadcrumb__item__inner"><i class="ion-ios-home gm-home"></i>当前位置：</span>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>日志查看</el-breadcrumb-item>
                <el-breadcrumb-item>日志列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <div style="padding-bottom: 10px;">
            <span style="font-size: 14px;margin-right: 6px;">选择日期 : </span>
            <el-date-picker
                    v-model="time"
                    type="daterange"
                    align="right"
                    placeholder="请选择要查询的日期"
                    @change="change"
                    :picker-options="pickerOptions2">
            </el-date-picker>
            <el-button type="primary" icon="search" style="background: rgb(69, 91, 140);border-color: rgb(69, 91, 140);" @click="submit">查询</el-button>
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
                pickerOptions2: {
                    shortcuts: [{
                        text: '最近一周',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: '最近一个月',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: '最近三个月',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
                            picker.$emit('pick', [start, end]);
                        }
                    }]
                },
                tableData: [],
                currentPage4: 1,
                loading:true,
                time:'',
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
                    start_time:Date.parse(this.time[0])/1000,
                    end_time:Date.parse(this.time[1])/1000
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
            },
            change(val){
//                console.log(val)
//                console.log(this.time)
            },
            submit(){
                this.loading = true
                this.getData()
            }

        },
        mounted(){
            this.getData();
        }
    }
</script>
