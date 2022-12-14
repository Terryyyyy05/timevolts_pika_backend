<template>
  <the-heading heading="會員管理系統"></the-heading>
  <!-- 表格 -->
  <Table class="table" stripe border :columns="columns" :data="data" width="1200">
    <!-- 加入開關按鈕 -->
    <template #on_off="{ row }">   
      <switchbtn />
    </template>
    <!-- 加入編輯、刪除彈窗 -->
    <template #edit_member="{ row }">
      <!-- 編輯按鈕 -->
      <Button @click="modal3 = true">編輯</Button>
      <!-- 編輯彈窗 -->
      <Modal v-model="modal3" title="編輯會員資料" ok-text="確認修改" cancel-text="取消" width="700px" class="editmember-popup"
        :styles="{top: '30px'}">
      
        <Form :model="memberItem" :label-width="80" :rules="ruleInline" inline>
          <FormItem label="會員姓名">
            <text>{{memberItem.name}}</text>
          </FormItem>

        </Form>
        <Form :model="memberItem" :label-width="80">
          <FormItem label="信箱">
          </FormItem>
          <FormItem label="生日">
          </FormItem>
          <FormItem label="電話">
          </FormItem>
          <FormItem label="地址">
          </FormItem>
          <FormItem label="會員狀態">
            <Select v-model="memberItem.status" placeholder="狀態">
              <Option value="一般">一般</Option>
              <Option value="停權">停權</Option>
            </Select>
          </FormItem>
        </Form>
      </Modal>

    </template>
  </Table>
</template>

<script>
import switchbtn from '@/components/switchbtn.vue'
export default {
  components: {
    switchbtn,
  },
  data() {
    return {
      modal3: false,  //編輯彈窗預設關閉
      columns: [  ///表單表頭
        {
          title: '會員編號',
          width: '200px',  //寬度
          key: 'id',
          align: 'center',  //置中
          sortable: true,   //是否排序
        },
        {
          title: '會員帳號',
          width: '200px',
          key: 'account',
          align: 'center',
          sortable: true
        },
        {
          title: '會員信箱',
          key: 'email',
          align: 'center',
          sortable: true
        },
        {
          title: '註冊日期',
          width: '150px',
          key: 'date',
          align: 'center',
          sortable: true
        },
        {
          title: '會員等級',
          width: '110px',
          key: 'value',
          align: 'center',
          filters: [   //篩選分類
            {
              level: "普通",
              value: 1
            },
            {
              level: "白金",
              value: 2
            },
            {
              level: "鑽石",
              value: 3
            }
          ],
          filterMultiple: false,
          filterMethod(value, row) {
            if (value === 1) {
              return row.show === "普通";
            } else if (value === 2) {
              return row.show ==="白金";
            } else {
              return row.show === "鑽石";
            }
          }
        },
        {
          title: '會員狀態',
          width: '110px',
          key: 'status',
          align: 'center',
          slot: 'on_off',  //加入開關鈕欄位需加slot
          filters: [   //篩選分類
            {
              label: '1',
              value: 1
            },
            {
              label: '2',
              value: 2
            }
          ],
          filterMultiple: false,
          filterMethod(value, row) {
            if (value === 1) {
              return row.show === 1;
            } else if (value === 2) {
              return row.show === 2;
            }
          }
        },
        {
          title: '編輯',
          width: '100px',
          key: 'edit',
          align: 'center',
          slot: 'edit_member'  //加入編輯欄位
        },
      ],
      data: [     ///表格內容資料
        {
          id: '1000001',
          account: '123123',
          email: '123123@gmail.com',
          date: '2022/01/05',
          value: '白金'
        },
        {
          id: '1000002',
          account: '123123',
          email: '123123@gmail.com',
          date: '2022/01/06',
          value: '白金'
        },
        {
          id: '1000003',
          account: '3424fdsf',
          email: '123123@gmail.com',
          date: '2022/01/04',
          value: '白金'
        },
        {
          id: '1000004',
          account: 'dsgdsxcv',
          email: '123123@gmail.com',
          date: '2022/01/03',
          value: '白金'
        },
        {
          id: '1000005',
          account: '123123',
          email: '123123@gmail.com',
          date: '2022/01/01',
          value: '白金'
        },
        {
          id: '1000006',
          account: 'safafdaaaa',
          email: '123123@gmail.com',
          date: '2022/01/02',
          value: '鑽石'
        },
      ],
      memberItem: {
        name:'',
        status:'',
      }
    }
  },
  // methods: {
    
  // }
}

</script>
<style lang="scss" scoped>
@import '@/assets/css/app.scss';

.table {
  margin: 30px auto;
}
.edit {
  color: $color;
  border: 1px solid $color;
  margin: auto;
}
</style>