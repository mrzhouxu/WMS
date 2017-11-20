<template>
    <div v-loading="loading" element-loading-text="拼命加载中~~~">
        <div class="gm-breadcrumb">
            <span class="el-breadcrumb__item__inner"><i class="ion-ios-home gm-home"></i>当前位置：</span>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>店员管理</el-breadcrumb-item>
                <el-breadcrumb-item>店员列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <div style="padding-bottom: 10px;">
            <!--<span style="font-size: 14px;margin-right: 6px;">选择日期 : </span>-->
            <el-input placeholder="请输入内容" v-model="val" style="width: inherit;" >
                <el-select v-model="key" slot="prepend" placeholder="请选择" style="width: 120px;">
                    <el-option
                            v-for="item in options_key"
                            :key="item.id"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
            </el-input>
            <el-button type="primary" icon="search" style="background: rgb(69, 91, 140);border-color: rgb(69, 91, 140);" @click="submit">查询</el-button>
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
                <template  slot-scope="scope">
                    <el-popover
                            ref="popover1"
                            placement="right"
                            width="400"
                            trigger="hover">
                        <img :src="scope.row.img" alt="" width="100%" >
                    </el-popover>
                    <img :src="scope.row.img" alt="" width="50" height="50" v-popover:popover1 >
                </template>
            </el-table-column>
            <el-table-column
                    label="姓名">
                <template  slot-scope="scope">{{ scope.row.name }}</template>
            </el-table-column>
            <el-table-column
                    label="性别">
                <template  slot-scope="scope">{{ scope.row.sex | sex }}</template>
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
            <el-table-column
                    label="操作"
                    width="220">
                <template slot-scope="scope">
                    <el-button-group>
                        <el-button
                                size="small"
                                type="primary"
                                @click="edit(scope.row.id)">编辑</el-button>
                        <el-button
                                size="small"
                                type="danger"
                                @click="del(scope.row.id)">删除</el-button>
                        <el-button
                                size="small"
                                @click="reset(scope.row.id)">重置密码</el-button>
                    </el-button-group>
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
                tableData: [],
                key:'0',
                val:'',
                options_key: [{
                    label: '全部',
                    value:'0'
                },{
                    label: '姓名',
                    value:'name'
                },{
                    label: '性别',
                    value:'sex'
                },{
                    label: '身份证号',
                    value:'card'
                },{
                    label: '联系方式',
                    value:'phone'
                },{
                    label: '家庭住址',
                    value:'address'
                },{
                    label: '登陆账号',
                    value:'user'
                },
                ],
            }
        },
        methods : {
            getData(){
                let param = {
                    key:this.key,
                    val:this.val
                }
                axios.post('/admin/employee/list',param)
                    .then((res)=>{
                        this.tableData = res.data.result
                    })
                    .catch((err)=>{

                    })
            },
            submit(){
                this.getData()
            },
            edit(id){
                console.log(id)
            },
            del(id){

            },
            reset(id){

            }
        },
        mounted(){
            this.getData()
        }
    }
</script>
