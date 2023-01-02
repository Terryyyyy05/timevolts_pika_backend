<template>
  <the-heading heading="會員管理系統"></the-heading>
  <!-- 表格 -->
  <Table 
  class="table" 
  stripe 
  border 
  :columns="columns" 
  :data="dataList" 
  width="1200">

    <!-- 加入開關按鈕 -->
    <template #mem_status="{row}">   
      <Switch 
      size="large" 
      true-color="#fab042" 
      false-color="#e6e6e6"
      v-model="row.mem_status"
      :true-value="parseInt(1)"
      :false-value="parseInt(0)"
      @on-change="onChange(row)">
        <template #open>
          <span>正常</span>
        </template>
        <template #close>
          <span>停權</span>
        </template>
      </Switch>
    </template>

    <template #mem_level="{ row }">   
      <text>{{ row.mem_level }}</text>
    </template>

    <!-- 加入編輯、刪除彈窗 -->
    <template #edit_member="{index, row}">
      <!-- 編輯按鈕 -->
      <Button @click="clickEditBtn(index)" class="edit">編輯與查看</Button>
      <!-- 編輯彈窗 -->
      <Modal 
      v-model="modal[index]" 
      :id="row.mem_name"
      title="編輯會員資料" 
      ok-text="確認" 
      cancel-text="取消" 
      width="700px" 
      class="editmember-popup"
      :styles="{top: '30px'}"
      >
      
        <Form 
        :model="addItem" 
        :label-width="80"
        method="post"
        enctype="multipart/form-data"
        ref="updateForm"
        inline>
          <FormItem label="姓名">
            <text>{{addItem.mem_name}}</text>
          </FormItem>
          <FormItem label="會員頭貼" style="margin-left:200px">
            <Avatar style="background-color: #87d068" icon="ios-person" />
          </FormItem>

        </Form>
        <Form 
        :model="addItem" 
        :label-width="80"
        ref="updateForm">
          <FormItem label="信箱">
            <text>{{addItem.mem_email}}</text>
          </FormItem>
          <FormItem label="電話">
            <text>{{addItem.mem_phone}}</text>
          </FormItem>
          <FormItem label="地址">
            <text>{{addItem.mem_address}}</text>
          </FormItem>
          <FormItem label="會員狀態">
            <text>{{ addItem.mem_status === 0 ? "停權" : "正常" }}</text>
          </FormItem>
        </Form>
      </Modal>
    </template>
  </Table>
</template>

<script>
import { BASE_URL } from "@/assets/js/commom";
export default {
  data() {
    return {
      modal: [],  //編輯彈窗預設關閉
      columns: [  ///表單表頭
        {
          title: '會員編號',
          width: '110px',  //寬度
          key: 'mem_id',
          align: 'center',  //置中
          sortable: true,   //是否排序
        },
        {
          title: '會員帳號',
          width: '200px',
          key: 'mem_email',
          align: 'center',
          sortable: true
        },
        {
          title: '會員姓名',
          width: '150px',  //寬度
          key: 'mem_name',
          align: 'center',  //置中
          sortable: true,   //是否排序
        },
        {
          title: '註冊日期',
          width: '200px',
          key: 'mem_signup_date',
          align: 'center',
          sortable: true
        },
        {
          title: '會員等級',
          width: '200px',
          slot: 'mem_level',
          align: 'center',
          filters: [   //篩選分類
            {
              label: "普通會員",
              value: 1
            },
            {
              label: "白金會員",
              value: 2
            },
            {
              label: "鑽石會員",
              value: 3
            }
          ],
          filterMultiple: false,
          filterMethod(value, row) {
            if (value === 1) {
              return row.mem_level === "普通會員";
            } else if (value === 2) {
              return row.mem_level ==="白金會員";
            } else {
              return row.mem_level === "鑽石會員";
            }
          }
        },
        {
          title: '會員狀態',
          width: '150px',
          key: 'mem_status',
          align: 'center',
          slot: 'mem_status',  //加入開關鈕欄位需加slot
        },
        {
          title: '編輯與查看',
          width: '185px',
          key: 'edit_member',
          align: 'center',
          slot: 'edit_member'  //加入編輯欄位
        },
      ],
      dataList:[],
      addItem: {
        mem_id: "",
        mem_name: "",
        mem_email: "",
        mem_psw: "",
        mem_phone: "",
        mem_address: "",
        mem_signup_date: "",
        mem_level: "",
        mem_status: "",
        mem_photo: "",
      },
      // memberItem: {
      //   name:'',
      //   status:'',
      // }
    }
  },
  methods:{
    getData(){
      fetch(`${BASE_URL}/getMember.php`)
      .then((res) => res.json())
      .then((result) => {
        this.dataList = result;
      });
    },
    onChange(row) {
      if (row.mem_status) {
        this.$Message.info("會員狀態： 正常");
      } else {
        this.$Message.info("會員狀態： 停權");
      }
      this.updateStatus(row.mem_id, row.mem_status);
    },
    clickEditBtn(index) {
      this.modal[index] = true;
      this.addItem = { ...this.dataList[index] };
    },
    updateStatus(mem_id, mem_status) {
      const formData = new FormData();
      formData.append("mem_status", mem_status);
      formData.append("mem_id", mem_id);

      fetch(`${BASE_URL}/update_member.php`, {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((res) => {
          const result = res;
        });
    },
  },
  mounted(){
    this.getData();
  }
}

</script>
<style lang="scss" scoped>
@import '@/assets/css/app.scss';

</style>