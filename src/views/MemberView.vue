<template>
  <the-heading heading="會員管理系統"></the-heading>
  <!-- 表格 -->
  <Table 
  class="table" 
  stripe border 
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
          <span>一般</span>
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
    <template #edit_member="{index}">
      <!-- 編輯按鈕 -->
      <Button @click="clickEditBtn(index)" class="edit">編輯</Button>
      <!-- 編輯彈窗 -->
      <Modal 
      v-model="modal[index]" 
      title="編輯會員資料" 
      ok-text="確認修改" 
      cancel-text="取消" 
      width="700px" 
      class="editmember-popup"
      :styles="{top: '30px'}"
      @on-ok="replaceItem"
      @on-cancel="cancelEdit"
      >
      
        <Form :model="addItem" :label-width="80" inline>
          <FormItem label="姓名" :model="addItem">
            <text>{{addItem.mem_name}}</text>
          </FormItem>
          <FormItem label="會員頭貼" style="margin-left:200px">
            <Avatar style="background-color: #87d068" icon="ios-person" />
          </FormItem>

        </Form>
        <Form :model="addItem" :label-width="80">
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
            <Select v-model="addItem.mem_status" placeholder="狀態" style="width:100px">
              <Option value="1">一般</Option>
              <Option value="0">停權</Option>
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
      modal: [],  //編輯彈窗預設關閉
      columns: [  ///表單表頭
        {
          title: '會員編號',
          width: '200px',  //寬度
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
              label: "普通",
              value: 1
            },
            {
              label: "白金",
              value: 2
            },
            {
              label: "鑽石",
              value: 3
            }
          ],
          filterMultiple: false,
          filterMethod(value, row) {
            if (value === 1) {
              return row.mem_level === "普通";
            } else if (value === 2) {
              return row.mem_level ==="白金";
            } else {
              return row.mem_level === "鑽石";
            }
          }
        },
        {
          title: '會員狀態',
          width: '200px',
          key: 'status',
          align: 'center',
          slot: 'mem_status',  //加入開關鈕欄位需加slot
          // filters: [   //篩選分類
          //   {
          //     label: '1',
          //     value: 1
          //   },
          //   {
          //     label: '2',
          //     value: 2
          //   }
          // ],
          // filterMultiple: false,
          // filterMethod(value, row) {
          //   if (value === 1) {
          //     return row.show === 1;
          //   } else if (value === 2) {
          //     return row.show === 2;
          //   }
          // }
        },
        {
          title: '編輯',
          width: '195px',
          key: 'edit',
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
        mem_status: 0,
        mem_img: "",
      },
      restItem: {
        mem_id: "",
        mem_name: "",
        mem_email: "",
        mem_psw: "",
        mem_phone: "",
        mem_address: "",
        mem_signup_date: "",
        mem_level: "",
        mem_status: 0,
        mem_img: "",
      },
      // data: [     ///表格內容資料
      //   {
      //     id: '1000001',
      //     name: '張西西',
      //     account: '123123',
      //     email: '123123@gmail.com',
      //     birthday:'1999/11/11',
      //     tel:'0900000000',
      //     address:'桃園復興',
      //     date: '2022/01/05',
      //     mem_level: '白金'
      //   },
      //   {
      //     id: '1000002',
      //     name: '張嚕嚕',
      //     account: '123123',
      //     email: '123123@gmail.com',
      //     birthday:'1999/11/12',
      //     tel:'0900009800',
      //     address:'桃園復興路',
      //     date: '2022/01/06',
      //     mem_level: '白金'
      //   },
      //   {
      //     id: '1000003',
      //     name: '張哈哈',
      //     account: '3424fdsf',
      //     email: '123123@gmail.com',
      //     birthday:'1999/11/13',
      //     tel:'0900076000',
      //     address:'桃園市中壢區復興',
      //     date: '2022/01/04',
      //     mem_level: '白金'
      //   },
      //   {
      //     id: '1000004',
      //     name: '張滴滴',
      //     account: 'dsgdsxcv',
      //     email: '123123@gmail.com',
      //     birthday:'1999/11/14',
      //     tel:'0900054000',
      //     address:'桃園市復興',
      //     date: '2022/01/03',
      //     mem_level: '普通'
      //   },
      //   {
      //     id: '1000005',
      //     name: '張咚咚',
      //     account: '123123',
      //     email: '123123@gmail.com',
      //     birthday:'1999/11/15',
      //     tel:'0900230000',
      //     address:'桃園復興46號',
      //     date: '2022/01/01',
      //     mem_level: '白金'
      //   },
      //   {
      //     id: '1000006',
      //     name: '張喃喃',
      //     account: 'safafdaaaa',
      //     email: '123123@gmail.com',
      //     birthday:'1999/11/16',
      //     tel:'0900000000',
      //     address:'桃園復興',
      //     date: '2022/01/02',
      //     mem_level: '鑽石'
      //   },
      // ],
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
        this.$Message.info("上架狀態： 在職");
      } else {
        this.$Message.info("上架狀態： 離職");
      }
      console.log(row);
    },
    clickEditBtn(index) {
      this.modal[index] = true;
      this.addItem = { ...this.dataList[index] };
    },
    replaceItem() {
      const index = this.dataList.findIndex(
        (item) => item.mem_id === this.addItem.mem_id
      );
      this.dataList[index] = this.addItem;
      this.addItem = { ...this.resetItem };
    },
    cancelEdit() {
      this.addItem = { ...this.resetItem };
    },
  },
  created(){
    this.getData();
  }
}

</script>
<style lang="scss" scoped>
@import '@/assets/css/app.scss';

</style>