<template>
  <the-heading heading="後台帳號管理系統"></the-heading>
  <!-- 新增彈窗按鈕 -->
  <Button @click="modal1 = true" class="add">新增 +</Button>
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
        <FormItem label="管理員姓名"
        prop="admin_name">
          <Input v-model="addItem.admin_name" placeholder="請輸入姓名"></Input>
        </FormItem>
        <FormItem label="管理員帳號"
        prop="admin_account">
          <Input v-model="addItem.admin_account" placeholder="請輸入帳號"></Input>
        </FormItem>
        <FormItem label="管理員密碼"
        prop="admin_psw">
          <Input v-model="addItem.admin_psw" placeholder="請輸入密碼"></Input>
        </FormItem>
        <!-- <FormItem label="再次輸入"
        prop="admin_pswConfirm">
          <Input v-model="addItem.admin_pswConfirm" placeholder="再輸入密碼"></Input>
        </FormItem> -->
        <FormItem label="管理員權限"
        prop="admin_authority">
          <Select v-model="addItem.admin_authority" placeholder="請選擇" style="width:100px">
            <Option value="1">超級權限</Option>
            <Option value="2">一般</Option>
            <Option value="3">停權</Option>
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
      <text>{{authorityText[row.admin_authority]}}</text>
    </template>

    <!-- 加入編輯、刪除彈窗 -->
    <template #edit_admin="{index, row}">
      <!-- 編輯按鈕 -->
      <Button @click="clickEditBtn(index)" class="edit">編輯</Button>
      <!-- 編輯彈窗 -->
      <Modal 
      v-model="modal3[index]" 
      :id="row.admin_name"
      title="編輯會員資料" 
      ok-text="確認修改"
      cancel-text="取消" 
      width="500px" 
      class="editadmin-popup"
      :styles="{top: '30px'}"
      @on-ok="replaceItem(row.admin_name)"
      @on-cancel="cancelEdit"
      >
      
        <Form 
        :model="addItem" 
        :label-width="100"
        :rules="ruleValidate"
        ref="updateForm"
        >
        <FormItem label="員工編號">
         <text>{{ addItem.admin_id }}</text>
        </FormItem>
        <FormItem label="管理員姓名"
        prop="admin_name">
          <Input v-model="addItem.admin_name" placeholder="請輸入姓名"></Input>
        </FormItem>
        <FormItem label="管理員帳號"
        prop="admin_account">
        <Input v-model="addItem.admin_account" placeholder="請輸入帳號"></Input>
        </FormItem>
        <FormItem label="管理員密碼"
        prop="admin_psw">
          <Input type="password" v-model="addItem.admin_psw" placeholder="請輸入密碼"></Input>
        </FormItem>
        <!-- <FormItem label="再次確認密碼"
        prop="admin_pswConfirm">
          <Input type="password" v-model="addItem.admin_pswConfirm" placeholder="請輸入密碼"></Input>
        </FormItem> -->
        <FormItem label="管理員權限"
        prop="admin_authority">
          <Select v-model="addItem.admin_authority" placeholder="請選擇" style="width:100px">
            <Option value="1">超級權限</Option>
            <Option value="2">一般</Option>
            <Option value="3">停權</Option>
          </Select>
        </FormItem>
        <FormItem label="在職狀態">
          <text>{{ addItem.admin_status === 0 ? "離職" : "在職" }}</text>
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
      authorityText: {
        1: "超級權限",
        2: "一般",
        3: "停權"
      },
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
              value: "超級權限"
            },
            {
              label: "一般",
              value: "一般"
            },
            {
              label: "停權",
              value: "停權"
            },
          ],
          filterMultiple: false,
          filterMethod(value, row) {
            if (value === "超級權限") {
              return row.admin_authority === 1;
            } else if (value === "一般") {
              return row.admin_authority === 2;
            }else {
              return row.admin_authority === 3
            }
          }
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
        // admin_pswConfirm:[
        //   {
        //     required: true,
        //     type: "string",
        //     message: "密碼先預設",
        //     trigger: "blur",
        //   },
        // ],
        admin_authority: [
          {
          required: true,
          type: "string",
          message: "請選擇權限",
          trigger: "blur",
          }
        ],
      }
    }
  },
  
  methods:{
    onChange(row) {
      if (row.admin_status) {
        this.$Message.info("管理員狀態： 在職");
      } else {
        this.$Message.info("管理員狀態： 離職");
      }
      this.updateStatus(row.admin_id, row.admin_status);
    },
    clickOk() {
      this.$refs["addForm"].validate((valid) => {
        if (valid) {

          this.insertData(this.addItem);
          } else {
          alert("新增失敗，請確認表格是否輸入正確");
          }
      });
  },
    clickEditBtn(index) {
      this.modal3[index] = true;
      this.addItem = { ...this.dataList[index] };
    },
    replaceItem() {
      this.$refs["updateForm"].validate((valid) => {
        if (valid) {
          this.updateData(index);
        } else {
          alert("修改失敗，請確認表格是否輸入正確");
        }
      });
    },
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
    insertData() {
      const formData = new FormData();
      const formDataKey = Object.keys(this.addItem);
      formDataKey.forEach((key) => {
          formData.append(`${key}`, this.addItem[key]);
      });
      fetch(`${BASE_URL}/insert_admin_staff.php`, {
          method: "POST",
          body: formData,
      })
      .then((res) => res.json())
      .then((res) => {
          const result = res;

          if (result === "wrong") {
              alert("新增失敗，資料庫已有此筆資料");
          } else {
              this.addItem.admin_id = result.admin[0].admin_id;
              this.dataList.push({ ...this.addItem });
          }

          this.addItem = { ...this.resetItem };
      });
    },
    updateData(name) {
      const formData = new FormData();
      const formDataKey = Object.keys(this.addItem);
      formDataKey.forEach((key) => {
          formData.append(`${key}`, this.addItem[key]);
      });

      fetch(`${BASE_URL}/updateAdmin.php`, {
          method: "POST",
          body: formData,
      })
        .then((res) => res.json())
        .then((res) => {
          const result = res;

          if (result === "wrong") {
              alert("新增失敗，資料庫已有此筆資料");
          } else {
              const index = this.dataList.findIndex(
                  (item) => item.admin_id === this.addItem.admin_id
              );

              this.dataList[index] = this.addItem;
          }

          this.addItem = { ...this.resetItem };
        });
      },




      
    updateStatus(admin_id, admin_status) {
      const formData = new FormData();
      formData.append("admin_status", admin_status);
      formData.append("admin_id", admin_id);

      fetch(`${BASE_URL}/update_admin_status.php`, {
          method: "POST",
          body: formData,
      })
          .then((res) => res.json())
          .then((res) => {
              const result = res;
              console.log(result);
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