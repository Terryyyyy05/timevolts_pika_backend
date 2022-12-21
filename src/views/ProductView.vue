<template>
  <!-- 標題 -->
  <the-heading heading="商品管理系統"></the-heading>
  <!-- 新增彈窗按鈕 -->
  <Button @click="modal1 = true" class="add">新增 +</Button>
  <!-- 新增彈窗 -->
  <Modal
    v-model="modal1"
    title="新增商品"
    width="700px"
    class="addnews-popup"
    :styles="{ top: '30px' }"
    ok-text="確認新增"
    cancel-text="取消新增"
    @on-ok="clickOk"
  >
    <Form :model="addItem" :label-width="80" inline>
      <FormItem label="商品編號">
        <Input v-model="addItem.pro_id" placeholder="請輸入消息編號"></Input>
      </FormItem>
      <FormItem label="商品分類">
        <Select v-model="addItem.pro_class_name" placeholder="請選擇">
          <Option value="旅行必備">旅行必備</Option>
          <Option value="醫療用品">醫療用品</Option>
          <Option value="應急糧食">應急糧食</Option>
          <Option value="求生用品">求生用品</Option>
        </Select>
      </FormItem>
    </Form>
    <Form :model="addItem" :label-width="80">
      <FormItem label="商品名稱">
        <Input v-model="addItem.pro_name" placeholder="請輸入商品名稱"></Input>
      </FormItem>
      <FormItem label="上架日期">
        <DatePicker
          type="date"
          placeholder="請選擇日期"
          v-model="addItem.pro_onshelf_date"
        ></DatePicker>
      </FormItem>
      <FormItem label="商品單價">
        <input
          type="number"
          placeholder="請輸入商品單價"
          v-model="addItem.pro_price"
        />
      </FormItem>
      <FormItem label="商品數量">
        <input
          type="number"
          placeholder="請輸入商品上架數量"
          v-model="addItem.pro_onshelf_amount"
        />
      </FormItem>
      <FormItem label="商品圖片">
        <input type="file" multiple />
      </FormItem>
      <FormItem label="商品資訊">
        <Input
          v-model="addItem.pro_info"
          type="textarea"
          :autosize="{ minRows: 10, maxRows: 50 }"
        ></Input>
      </FormItem>
    </Form>
  </Modal>

  <!-- 表格 -->
  <Table
    class="table"
    stripe
    border
    :columns="columns"
    :data="dataList"
    width="1200"
  >
    <!-- 加入開關按鈕 -->
    <template #on_off="{ row }">
      <Switch
        size="large"
        true-color="#fab042"
        false-color="#e6e6e6"
        v-model="row.pro_status"
        true-value="1"
        false-value="0"
        @on-change="onChange(row)"
      >
        <template #open>
          <span>上架</span>
        </template>
        <template #close>
          <span>下架</span>
        </template>
      </Switch>
    </template>

    <template #pro_class_name="{ row }">
      <text>{{ row.pro_class_name }}</text>
    </template>

    <!-- 加入編輯、刪除彈窗 -->
    <template #edit_del="{ index }">
      <!-- 編輯按鈕 -->
      <Button @click="clickEditBtn(index)" class="edit">編輯</Button>
      <!-- 編輯彈窗 -->
      <Modal
        v-model="modal3[index]"
        title="編輯商品資訊"
        ok-text="確認修改"
        cancel-text="取消"
        width="700px"
        class="editnews-popup"
        :styles="{ top: '30px' }"
        @on-ok="replaceItem"
        @on-cancel="cancelEdit"
      >
        <Form :model="addItem" :label-width="80" inline>
          <FormItem label="消息編號">
            <text>{{ addItem.pro_id }}</text>
          </FormItem>
          <FormItem label="消息分類">
            <Select v-model="addItem.pro_class_name" placeholder="請選擇">
              <Option value="旅行必備">旅行必備</Option>
              <Option value="醫療用品">醫療用品</Option>
              <Option value="應急糧食">應急糧食</Option>
              <Option value="求生用品">求生用品</Option>
            </Select>
          </FormItem>
        </Form>
        <Form :model="addItem" :label-width="80">
          <FormItem label="商品名稱">
            <Input
              v-model="addItem.pro_name"
              placeholder="請輸入商品名稱"
            ></Input>
          </FormItem>
          <FormItem label="上架日期">
            <DatePicker
              type="date"
              placeholder="請選擇日期"
              v-model="addItem.pro_onshelf_date"
            ></DatePicker>
          </FormItem>
          <FormItem label="商品單價">
            <input
              type="number"
              placeholder="請輸入商品單價"
              v-model="addItem.pro_price"
            />
          </FormItem>
          <FormItem label="商品數量">
            <input
              type="number"
              placeholder="請更新商品上架數量"
              v-model="addItem.pro_onshelf_amount"
            />
          </FormItem>
          <FormItem label="商品圖片">
            <input type="file" multiple />
          </FormItem>
          <FormItem label="商品資訊">
            <Input
              v-model="addItem.pro_info"
              type="textarea"
              :autosize="{ minRows: 10, maxRows: 50 }"
            ></Input>
          </FormItem>
        </Form>
      </Modal>

      <!-- 刪除按鈕 -->
      <Button class="delete" @click="remove(index)">刪除</Button>
    </template>
  </Table>
</template>

<script>
// import { objectToString } from "@vue/shared";

export default {
  data() {
    return {
      test: true,
      modal1: false, //新增彈窗預設關閉
      modal3: [], //編輯彈窗預設關閉
      columns: [
        ///表單表頭
        {
          title: "商品編號",
          width: "110px", //寬度
          key: "pro_id",
          align: "center", //置中
          sortable: true, //是否排序
        },
        {
          title: "上架日期",
          width: "110px",
          key: "pro_onshelf_date",
          align: "center",
          sortable: true,
        },
        {
          title: "商品分類",
          width: "120px",
          slot: "pro_class_name",
          align: "center",
          filters: [
            //篩選分類
            {
              label: "旅行必備",
              value: 1,
            },
            {
              label: "醫療用品",
              value: 2,
            },
            {
              label: "應急糧食",
              value: 3,
            },
            {
              label: "求生用品",
              value: 4,
            },
          ],
          filterMultiple: false,
          filterMethod(value, row) {
            if (value === 1) {
              return row.pro_class_name === "旅行必備";
            } else if (value === 2) {
              return row.pro_class_name === "醫療用品";
            } else if (value === 3) {
              return row.pro_class_name === "應急糧食";
            } else {
              return row.pro_class_name === "求生用品";
            }
          },
        },
        {
          title: "商品名稱",
          key: "pro_name",
          align: "center",
        },
        {
          title: "單價",
          width: "80px",
          key: "pro_price",
          align: "center",
          sortable: true,
        },
        {
          title: "上架數量",
          width: "110px",
          key: "pro_onshelf_amount",
          align: "center",
          sortable: true,
        },
        {
          title: "剩餘數量",
          width: "110px",
          key: "pro_rest_amount",
          align: "center",
          sortable: true,
        },
        {
          title: "狀態",
          key: "pro_status",
          align: "center",
          width: "100px",
          slot: "on_off", //加入開關鈕欄位需加slot
        },
        {
          title: "編輯/刪除",
          width: "200px",
          key: "edit",
          align: "center",
          slot: "edit_del", //加入編輯刪除欄位需加slot
        },
      ],
      data: [
        ///表格內容資料
        {
          pro_id: "1001",
          pro_onshelf_date: "2022-12-10",
          pro_class_name: "旅行必備",
          pro_name: "穿梭於史前時代",
          pro_price: "7777",
          pro_onshelf_amount: "100",
          pro_rest_amount: "50",
          pro_status: true,
          pro_info:
            "你好我好你好我好大家好安安你蒿哭哭饅頭團專家由你好我好大家好安安你蒿哭哭饅頭團專家由你好我好大家好安安你蒿哭哭饅頭團專家由你好我好大家好安安你蒿哭哭饅頭團專家由大家好安安你蒿哭哭饅頭團專家由",
        },
        {
          pro_id: "1002",
          pro_onshelf_date: "2022-11-10",
          pro_class_name: "醫療用品",
          pro_name: "埃及五千年的黃金時代",
          pro_price: "777",
          pro_onshelf_amount: "100",
          pro_rest_amount: "50",
          pro_status: true,
          pro_info:
            "你好我好你好我好大家好安安你蒿哭哭饅頭團專家由你好我好大家好安安你蒿哭哭饅頭團專家由你好我好大家好安安你蒿哭哭饅頭團專家由你好我好大家好安安你蒿哭哭饅頭團專家由大家好安安你蒿哭哭饅頭團專家由",
        },
        {
          pro_id: "2001",
          pro_onshelf_date: "2022-12-15",
          pro_class_name: "旅行必備",
          pro_name: "鐵達尼號沈船",
          pro_price: "1020",
          pro_onshelf_amount: "100",
          pro_rest_amount: "50",
          pro_status: true,
          pro_info:
            "你好我好你好我好大家好安安你蒿哭哭饅頭團專家由你好我好大家好安安你蒿哭哭饅頭團專家由你好我好大家好安安你蒿哭哭饅頭團專家由你好我好大家好安安你蒿哭哭饅頭團專家由大家好安安你蒿哭哭饅頭團專家由",
        },
        {
          pro_id: "2002",
          pro_onshelf_date: "2022-12-01",
          pro_class_name: "旅行必備",
          pro_name: "鄭和下西洋",
          pro_price: "1500",
          pro_onshelf_amount: "100",
          pro_rest_amount: "50",
          pro_status: true,
          pro_info:
            "你好我好你好我好大家好安安你蒿哭哭饅頭團專家由你好我好大家好安安你蒿哭哭饅頭團專家由你好我好大家好安安你蒿哭哭饅頭團專家由你好我好大家好安安你蒿哭哭饅頭團專家由大家好安安你蒿哭哭饅頭團專家由",
        },
        {
          pro_id: "3001",
          pro_onshelf_date: "2022-11-11",
          pro_class_name: "應急糧食",
          pro_name: "購物須知",
          pro_price: "7970",
          pro_onshelf_amount: "100",
          pro_rest_amount: "50",
          pro_status: true,
          pro_info:
            "你好我好你好我好大家好安安你蒿哭哭饅頭團專家由你好我好大家好安安你蒿哭哭饅頭團專家由你好我好大家好安安你蒿哭哭饅頭團專家由你好我好大家好安安你蒿哭哭饅頭團專家由大家好安安你蒿哭哭饅頭團專家由",
        },
        {
          pro_id: "4001",
          pro_onshelf_date: "2022-11-09",
          pro_class_name: "求生用品",
          pro_name: "官網維護公告",
          pro_price: "977",
          pro_onshelf_amount: "100",
          pro_rest_amount: "50",
          pro_status: true,
          pro_info:
            "你好我好你好我好大家好安安你蒿哭哭饅頭團專家由你好我好大家好安安你蒿哭哭饅頭團專家由你好我好大家好安安你蒿哭哭饅頭團專家由你好我好大家好安安你蒿哭哭饅頭團專家由大家好安安你蒿哭哭饅頭團專家由",
        },
      ],
      dataList: [],
      addItem: {
        //新增彈窗內容資料
        pro_id: "",
        pro_name: "",
        pro_class_name: "",
        pro_onshelf_date: "",
        pro_info: "",
        pro_price: "",
        pro_onshelf_amount: "",
        pro_rest_amount: "",
        pro_status: false,
      },
      editItem: {
        id: "addItem.pro_id()",
        title: "",
        select: "",
        date: "",
        textarea: "",
      },
      resetItem: {
        pro_id: "",
        pro_name: "",
        pro_class_name: "",
        pro_onshelf_date: "",
        pro_info: "",
        pro_price: "",
        pro_onshelf_amount: "",
        pro_rest_amount: "",
        pro_status: false,
      },
    };
  },
  methods: {
    remove(index) {
      // console.log(index);
      this.$Modal.confirm({
        content: "<p>確認刪除嗎?</p>",
        okText: "刪刪刪",
        cancelText: "還是不要好了",
        onOk: () => {
          this.$Message.info("確認刪除");

          this.data.splice(index, 1);
        },
        onCancel: () => {
          this.$Message.info("取消");
        },
      });
    },
    onChange(row) {
      if (row.pro_status) {
        this.$Message.info("上架狀態： 上架");
      } else {
        this.$Message.info("上架狀態： 下架");
      }
      console.log(row);
    },
    clickOk() {
      this.addItem.pro_rest_amount = this.addItem.pro_onshelf_amount;
      this.addItem.pro_onshelf_date = this.addItem.pro_onshelf_date
        .toLocaleDateString()
        .replace(/\//g, "-");

      // console.log(this.resetItem);

      this.data.push({ ...this.addItem });

      // console.log(this.addItem);
      // console.log(this.addItem.pro_onshelf_date);
      // Object.assign(this.addItem, this.resetItem)
      this.addItem = { ...this.resetItem };
      // console.log(this.addItem);
      // console.log(this.resetItem);
    },
    testtt(index) {
      console.log(index);
    },
    clickEditBtn(index) {
      this.modal3[index] = true;
      this.addItem = { ...this.dataList[index] };
    },
    replaceItem() {
      console.log(this.data[0]);
      const index = this.data.findIndex(
        (item) => item.pro_id === this.addItem.pro_id
      );

      this.addItem.pro_onshelf_date = this.addItem.pro_onshelf_date
        .toLocaleDateString()
        .replace(/\//g, "-");

      this.data[index] = this.addItem;
      this.addItem = { ...this.resetItem };
      console.log(this.data[0]);
      // console.log(index);
      // console.log(this.addItem);
      // console.log(this.data[0]);
    },
    cancelEdit() {
      this.addItem = { ...this.resetItem };
    },
    getData() {
      fetch(
        "http://localhost/timevolts_pika_backend/public/phpfiles/get_pro_data.php"
      )
        .then((res) => res.json())
        .then((result) => {
          this.dataList = result;
        });
    },
    insertData(newData) {
      fetch(
        "http://localhost/timevolts_pika_backend/public/phpfiles/insert_pro_data.php",
        {
          method: "POST",
          body: JSON.stringify({ test: 123 }),
        }
      )
        .then((res) => res.json())
        .then((result) => {
          console.log(result);
        });
    },
  },
  mounted() {
    this.getData();
    // this.insertData();
  },
};
</script>
<style lang="scss" scoped>
@import "@/assets/css/app.scss";
</style>
