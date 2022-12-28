<template>
  <the-heading heading="後台帳號管理系統"></the-heading>
  <!-- 新增彈窗按鈕 -->
  <Button @click="modal1 = true" class="admin">新增 +</Button>
  <!-- 新增彈窗 -->
  <Modal 
  v-model="modal1" 
  title="新增管理員" 
  width="500px" 
  class="addadmin-popup" 
  :styles="{top: '30px'}"
  ok-text="確認新增"
  cancel-text="取消新增"
  @on-ok="clickOk"
  >
      <Form 
      :model="addItem" 
      :label-width="100"
      method="post"
      enctype="multipart/form-data"
      ref="addForm"
      :rules="ruleValidate"
      >
        <FormItem label="員工編號">
          <Input v-model="addItem.admin_id" placeholder="請輸入編號"></Input>
        </FormItem>
        <FormItem label="管理員姓名">
          <Input v-model="addItem.admin_name" placeholder="請輸入姓名"></Input>
        </FormItem>
        <FormItem label="管理員帳號">
          <Input v-model="addItem.admin_account" placeholder="請輸入帳號"></Input>
        </FormItem>
        <FormItem label="管理員密碼">
          <Input v-model="addItem.admin_psw" placeholder="請輸入密碼"></Input>
        </FormItem>
        <FormItem label="管理員權限">
          <Select v-model="addItem.admin_authority" placeholder="請選擇" style="width:100px">
            <Option value="1">超級權限</Option>
            <Option value="2">一般</Option>
            <Option value="3">停權</Option>
          </Select>
        </FormItem>
        <FormItem label="在職狀態">
          <Select v-model="addItem.admin_status" placeholder="請選擇" style="width:100px">
            <Option value="在職">在職</Option>
            <Option value="離職">離職</Option>
          </Select>
        </FormItem>
      </Form>
  </Modal>

  <!-- 表格 -->
  <Table 
  class="table" 
  stripe border 
  :columns="columns" 
  :data="dataList" 
  width="1200">
    <!-- 加入開關按鈕 -->
    <template #admin_status="{row}">   
      <Switch 
      size="large" 
      true-color="#fab042" 
      false-color="#e6e6e6"
      v-model="row.admin_status"
      :true-value="parseInt(1)"
      :false-value="parseInt(0)"
      @on-change="onChange(row)"
      >
        <template #open>
          <span>在職</span>
        </template>
        <template #close>
          <span>離職</span>
        </template>
      </Switch>
    </template>

    <template #admin_authority="{ row }">   
      <text>{{ row.admin_authority }}</text>
    </template>

    <!-- 加入編輯、刪除彈窗 -->
    <template #edit_admin="{index}">
      <!-- 編輯按鈕 -->
      <Button @click="clickEditBtn(index)" class="edit">編輯</Button>
      <!-- 編輯彈窗 -->
      <Modal 
      v-model="modal3[index]" 
      title="編輯會員資料" 
      ok-text="確認修改"
      cancel-text="取消" 
      width="500px" 
      class="editadmin-popup"
      :styles="{top: '30px'}"
      @on-ok="replaceItem"
      @on-cancel="cancelEdit"
      >
      
        <Form 
        :model="addItem" 
        :label-width="100"
        :rules="ruleValidate"
        ref="updateForm"
        >
        <FormItem label="員工編號">
          <Input v-model="addItem.admin_id" placeholder="請輸入編號"></Input>
        </FormItem>
        <FormItem label="管理員姓名">
          <Input v-model="addItem.admin_name" placeholder="請輸入姓名"></Input>
        </FormItem>
        <FormItem label="管理員帳號">
          <Input v-model="addItem.admin_account" placeholder="請輸入帳號"></Input>
        </FormItem>
        <FormItem label="管理員密碼">
          <Input type="password" v-model="addItem.admin_psw" placeholder="請輸入密碼"></Input>
        </FormItem>
        <FormItem label="管理員權限">
          <Select v-model="addItem.admin_authority" placeholder="請選擇" style="width:100px">
            <Option value="1">超級權限</Option>
            <Option value="2">一般</Option>
            <Option value="3">停權</Option>
          </Select>
        </FormItem>
        <FormItem label="在職狀態">
          <Select v-model="addItem.admin_status" placeholder="請選擇" style="width:100px">
            <Option value="1">在職</Option>
            <Option value="0">離職</Option>
          </Select>
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
      modal1: false,  //新增彈窗預設關閉
      modal3: [],  //編輯彈窗預設關閉
      columns: [  ///表單表頭
        {
          title: '管理員編號',
          width: '150px',
          key: 'admin_id',
          align: 'center',  //置中
          sortable: true,   //是否排序
        },
        {
          title: '管理員帳號',
          width: '250px',
          key: 'admin_account',
          align: 'center',
          sortable: true,
        },
        {
          title: '管理員姓名',
          width: '200px',
          key: 'admin_name',
          align: 'center',
        },
        {
          title: '管理員權限',
          width: '200px',
          key: 'admin_authority',
          align: 'center',
          slot:'admin_authority',
          filters: [
          {
              label: "超級權限",
              value: 1
            },
            {
              label: "一般",
              value: 2
            },
            {
              label: "停權",
              value: 3
            },
          ]
        },
        {
          title: '在職狀態',
          width: '200px',
          key: 'admin_status',
          align: 'center',
          slot:'admin_status'
        },
        {
          title: '編輯',
          width: '195px',
          key: 'edit',
          align: 'center',
          slot:'edit_admin'
        },
      ],
      // data: [     ///表格內容資料
      //   {
      //     id: '1000001',
      //     name: '張咚咚',
      //     account: '123123',
      //     password:'sdfsdfsdfsdf',
      //     permission:'',
      //     admin_status:'在職',
      //   },
      //   {
      //     id: '1000002',
      //     name: '張西西',
      //     account: '123123',
      //     password:'sdfsdfsdfsdf',
      //     permission:'',
      //     admin_status:'在職',
      //   },
      //   {
      //     id: '1000003',
      //     name: '張喃喃',
      //     account: '123123',
      //     password:'sdfsdfsdfsdf',
      //     permission:'',
      //     admin_status:'在職',
      //   },
      //   {
      //     id: '1000004',
      //     name: '張北北',
      //     account: '123123',
      //     password:'sdfsdfsdfsdf',
      //     permission:'',
      //     admin_status:'在職',
      //   },
       
      // ],
      dataList:[],
      addItem: {   //新增彈窗內容資料
        // admin_id: '',
        admin_name: '',
        admin_account: '',
        admin_psw: '',
        admin_authority: '',
        admin_status: '',
      },
      resetItem: { 
        // admin_id: '',
        admin_name: '',
        admin_account: '',
        admin_psw: '',
        admin_authority: '',
        admin_status: '',
      },
      ruleValidate: {
        admin_name: [
          {
            required: true,
            type: "string",
            message: "名字記得打拜託",
            trigger: "blur",
          },
        ],
        admin_account: [
          {
            required: true,
            type: "string",
            message: "帳號記得打拜託",
            trigger: "blur",
          },
        ],
        admin_psw: [
          {
            required: true,
            type: "string",
            message: "密碼先預設",
            trigger: "blur",
          },
        ],
        admin_authority: 2,
        admin_status: 1
      }
    }
  },
  methods:{
    remove(index, row) {
      // console.log(index);
      this.$Modal.confirm({
        content: "<p>確認刪除嗎?</p>",
        okText: "刪刪刪拉",
        cancelText: "先不要好ㄌ",
        onOk: () => {
          this.$Message.info("確認刪除");
          this.deleData(row);

          this.dataList.splice(index, 1);
        },
        onCancel: () => {
          this.$Message.info("取消");
        },
      });
    },
    onChange(row) {
      if (row.admin_status) {
        this.$Message.info("上架狀態： 在職");
      } else {
        this.$Message.info("上架狀態： 離職");
      }
    },
    //這裡不懂
  //   clickOk() {
  //     this.$refs["addForm"].validate((valid) => {
  //       if (valid) {
  //         this.addItem.pro_rest_amount = this.addItem.pro_onshelf_amount;
  //         this.addItem.pro_onshelf_date = this.addItem.pro_onshelf_date
  //           .toLocaleDateString()
  //           .replace(/\//g, "-");

  //         this.insertData(this.addItem);
  //         } else {
  //         alert("新增失敗，請確認表格是否輸入正確");
  //         }
  //     });
  // },
    clickEditBtn(index) {
      this.modal3[index] = true;
      this.addItem = { ...this.dataList[index] };
    },
    // replaceItem() {
    //   this.$refs["updateForm"].validate((valid) => {
    //     if (valid) {
    //       this.addItem.pro_onshelf_date = this.addItem.pro_onshelf_date
    //         .toLocaleDateString()
    //         .replace(/\//g, "-");

    //       this.updateData();
    //     } else {
    //       alert("修改失敗，請確認表格是否輸入正確");
    //     }
    //   });
    // },
    cancelEdit() {
      this.addItem = { ...this.resetItem };
    },
    getData() {
      fetch(`${BASE_URL}/getAdminStaff.php`)
        .then((res) => res.json())
        .then((result) => {
          this.dataList = result;
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


.admin {
  margin: 20px 0 0 0;
  width: 80px;
  background-color: $color;
  color: #ffffff;
  border: 1px solid $color;
}


</style>