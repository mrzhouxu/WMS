<template>
    <div v-loading="loading" element-loading-text="拼命加载中~~~">
        <div class="gm-breadcrumb">
            <span class="el-breadcrumb__item__inner"><i class="ion-ios-home gm-home"></i>当前位置：</span>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>订单管理</el-breadcrumb-item>
                <el-breadcrumb-item>订单列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div style="padding-bottom: 10px;">
            <!--<span style="font-size: 14px;margin-right: 6px;">选择日期 : </span>-->
            <!--<router-link to="/dealer/edit">
                <el-button type="primary"><i class="ion-plus"></i> 添加经销商</el-button>
            </router-link>-->
            <el-input placeholder="请输入内容" v-model="val" style="width: 380px;">
                <el-select v-model="key" slot="prepend" placeholder="请选择" style="width: 120px;">
                    <el-option
                            v-for="item in options_key"
                            :key="item.id"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
            </el-input>
            <span style="font-size: 14px;margin: 0 6px;">选择日期 : </span>
            <el-date-picker
                    v-model="time"
                    type="daterange"
                    align="right"
                    placeholder="请选择要查询的日期"
                    @change="change"
                    :picker-options="pickerOptions2">
            </el-date-picker>
            <el-button type="primary" icon="search" @click="submit">查询</el-button>
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
                    width="220"
                    label="订单号">
                <template  slot-scope="scope">{{ scope.row.order_card }}</template>
            </el-table-column>
            <el-table-column
                    label="订单金额">
                <template  slot-scope="scope">{{ scope.row.price }} 元</template>
            </el-table-column>
            <el-table-column
                    label="盈利">
                <template  slot-scope="scope">{{ scope.row.profit }} 元</template>
            </el-table-column>
            <el-table-column
                    label="创建时间">
                <template  slot-scope="scope">{{ scope.row.create_time | date }}</template>
            </el-table-column>
            <el-table-column
                    label="操作"
                    width="100">
                <template slot-scope="scope">
                    <!--<el-button-group>-->
                        <!--<el-button-->
                                <!--size="small"-->
                                <!--type="primary"-->
                                <!--@click="edit(scope.row.id)">编辑</el-button>-->
                        <el-button
                                size="small"
                                type="danger"
                                @click="del(scope.row.id)">删除</el-button>
                    <!--</el-button-group>-->
                </template>
            </el-table-column>

            <el-table-column type="expand">
                <template slot-scope="scope">
                    <el-form label-position="left" inline class="demo-table-expand">
                        <el-table
                                :data="scope.row.products"
                                border
                                style="width: 100%">
                            <el-table-column
                                    type="index"
                                    width="100">
                            </el-table-column>
                            <el-table-column
                                    label="商品名称"
                                    width="220">
                                <template  slot-scope="scope">{{ scope.row.name }}</template>
                            </el-table-column>
                            <el-table-column
                                    label="价格">
                                <template  slot-scope="scope">{{ scope.row.out_price }} 元</template>
                            </el-table-column>
                            <el-table-column
                                    label="数量">
                                <template  slot-scope="scope">{{ scope.row.num  }}  {{ scope.row.unit }}</template>
                            </el-table-column>

                        </el-table>
                        <!--<div style="position: relative;width: 160px;height: 200px;display: inline-block;margin-right: 20px;" v-for="item,index in scope.row.products" :key="index">

                        </div>-->
                    </el-form>
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
                time:'',
                loading:false,
                tableData: [],
                key:'order_card',
                val:'',
                options_key: [{
                    label: '订单号',
                    value:'order_card'
                }
                ],
            }
        },
        methods : {
            getData(){
                this.loading = true
                let param = {
                    key:this.key,
                    val:this.val,
                    start_time:Date.parse(this.time[0])/1000,
                    end_time:Date.parse(this.time[1])/1000
                }
                axios.post('/admin/order/get_data',param)
                    .then(res=>{
                        this.loading = false
                        this.tableData = res.data.result
                    })
                    .catch(err=>{
                        this.loading = false
                    })
            },
            submit(){
                this.getData()
            },
            edit(id){
                this.$router.push({path:"/dealer/edit/"+id });
            },
            del(id){
                this.$confirm('此操作将永久删除该供销商, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.loading = true
                    axios.post('/admin/order/del',{id:id})
                        .then(res=>{
                            this.loading = false
                            if(res.data.status == 0){
                                this.$message({
                                    type: 'success',
                                    message: '删除成功!'
                                });
                                this.loading = true
                                this.getData()
                            }
                        })
                        .catch()
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
                });
            },
            change(val){
//                console.log(val)
//                console.log(this.time)
            },
        },
        mounted(){
            this.getData()
        }
    }
</script>
