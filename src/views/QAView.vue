<template>
  <!-- 標題 -->
  <the-heading heading="時空管理局管理系統"></the-heading>
  <!-- 新增彈窗按鈕 -->
  <Button @click="modal1 = true" class="add">新增 +</Button>
  <!-- 新增彈窗 -->
  <Modal
    v-model="modal1"
    title="新增問題"
    width="700px"
    class="addqa-popup"
    :styles="{ top: '30px' }"
  >
    <Form :model="addqaItem" :label-width="80">
      <FormItem label="問題編號">
        <Input v-model="addqaItem.qa_id" placeholder="請輸入問題編號"></Input>
      </FormItem>
      <FormItem label="問題分類">
        <Select v-model="addqaItem.qa_type" placeholder="請選擇">
          <Option value="常見問題">常見問題</Option>
          <Option value="行程預訂">行程預訂</Option>
          <Option value="商品訂購">商品訂購</Option>
        </Select>
      </FormItem>
      <FormItem label="問題標題">
        <Input
          v-model="addqaItem.qa_title"
          placeholder="請輸入問題標題"
        ></Input>
      </FormItem>
      <FormItem label="問題答案">
        <Input
          v-model="addqaItem.qa_answer"
          placeholder="請輸入問題答案"
        ></Input>
      </FormItem>
      <FormItem label="狀態">
        <Select
          v-model="addqaItem.qa_status"
          placeholder="請選擇"
          style="width: 100px"
        >
          <Option value="true">上架</Option>
          <Option value="false">下架</Option>
        </Select>
      </FormItem>
    </Form>
  </Modal>

  <!-- 表格 -->
  <Table
    class="table"
    stripe
    border
    :columns="columns"
    :data="getQuestion"
    width="1200"
  >
    <!-- 加入開關按鈕 -->
    <template #on_off>
      <Switch size="large" true-color="#fab042" false-color="#e6e6e6">
        <template #open>
          <span>上架</span>
        </template>
        <template #close>
          <span>下架</span>
        </template>
      </Switch>
    </template>

    <template #qa_type="{ row }">
      <text>{{ row.qa_type }}</text>
    </template>

    <!-- 加入編輯彈窗 -->
    <template #edit>
      <!-- 編輯按鈕 -->
      <Button @click="modal3 = true" class="edit">編輯</Button>
      <!-- 編輯彈窗 -->
      <Modal
        v-model="modal3"
        title="編輯最新消息"
        ok-text="確認修改"
        cancel-text="取消"
        width="700px"
        class="editnews-popup"
        :styles="{ top: '30px' }"
      >
        <Form :model="addqaItem" :label-width="80">
          <FormItem label="問題編號">
            <Input
              v-model="addqaItem.qa_id"
              placeholder="請輸入問題編號"
            ></Input>
          </FormItem>
          <FormItem label="問題分類">
            <Select v-model="addqaItem.qa_type" placeholder="請選擇">
              <Option value="常見問題">常見問題</Option>
              <Option value="行程預訂">行程預訂</Option>
              <Option value="商品訂購">商品訂購</Option>
            </Select>
          </FormItem>
          <FormItem label="問題標題">
            <Input
              v-model="addqaItem.qa_title"
              placeholder="請輸入問題標題"
            ></Input>
          </FormItem>
          <FormItem label="問題答案">
            <Input
              v-model="addqaItem.qa_answer"
              placeholder="請輸入問題答案"
            ></Input>
          </FormItem>
          <FormItem label="狀態">
            <Select
              v-model="addqaItem.qa_status"
              placeholder="請選擇"
              style="width: 100px"
            >
              <Option value="true">上架</Option>
              <Option value="false">下架</Option>
            </Select>
          </FormItem>
        </Form>
      </Modal>
    </template>
  </Table>
</template>

<script>
import { BASE_URL } from "@/assets/js/commom";
import { is } from "@babel/types";

export default {
  data() {
    return {
      modal1: false, //新增彈窗預設關閉
      modal3: false, //編輯彈窗預設關閉
      columns: [
        ///表單表頭
        {
          title: "問題編號",
          width: "200px", //寬度
          key: "qa_id",
          align: "center", //置中
          sortable: true, //是否排序
        },
        {
          title: "問題分類",
          width: "200px",
          key: "qa_type",
          align: "center",
        },
        {
          title: "問題標題",
          key: "qa_title",
          align: "center",
        },
        {
          title: "問題答案",
          key: "qa_answer",
          align: "center",
        },
        {
          title: "問題狀態",
          key: "qa_status",
          align: "center",
          width: "100px",
          slot: "on_off", //加入開關鈕欄位需加slot
        },
        {
          title: "編輯",
          width: "100px",
          key: "edit",
          align: "center",
          slot: "edit", //加入編輯刪除欄位需加slot
        },
      ],
      // data: [
      //   ///表格內容資料
      //   {
      //     id: "1001",
      //     qa_type: "常見問題",
      //     title: "時間管理局是一個什麼樣的組織？",
      //     answer:
      //       "時間管理局是一個為了維持時間線正常運行的組織，其主要成員都是研究時空穿越的頂尖科學家。",
      //   },
      //   {
      //     id: "1002",
      //     qa_type: "行程預訂",
      //     title: "經典行程與期間限定行程有何不同？",
      //     answer: "若有不可抗力之因素需取消訂單，請洽詢客服。",
      //   },
      //   {
      //     id: "1003",
      //     qa_type: "商品訂購",
      //     title: "商品配送時間多久？",
      //     answer: "我們合作的時光宅急便，配送時間為工作天一到三天。",
      //   },
      // ],
      getQuestion: [],
      addqaItem: {
        //新增彈窗內容資料
        qa_id: "",
        qa_type: "",
        qa_title: "",
        qa_answer: "",
        qa_status: "",
      },
      editqaItem: {
        qa_id: "",
        qa_type: "",
        qa_title: "",
        qa_answer: "",
        qa_status: "",
      },
    };
  },
  methods: {
    getData() {
      fetch(`${BASE_URL}/getQuestion.php`)
        .then((res) => res.json())
        .then((json) => {
          this.getQuestion = json;
        });
    },
  },
  created() {
    this.getData();
    console.log(this);
  },
};
</script>
<style lang="scss" scoped>
@import "@/assets/css/app.scss";
</style>
