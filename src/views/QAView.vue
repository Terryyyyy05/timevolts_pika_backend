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
    ok-text="確認新增"
    cancel-text="取消新增"
    @on-ok="clickOk"
  >
    <Form
      :model="addqaItem"
      :label-width="80"
      method="post"
      enctype="multipart/form-data"
      ref="addForm"
      :rules="ruleValidate"
    >
      <!-- <FormItem label="問題編號">
        <Input v-model="addqaItem.qa_id" placeholder="請輸入問題編號"></Input>
      </FormItem> -->
      <FormItem label="問題分類" prop="qa_type">
        <Select v-model="addqaItem.qa_type" placeholder="請選擇">
          <Option value="常見問題">常見問題</Option>
          <Option value="行程預訂">行程預訂</Option>
          <Option value="商品訂購">商品訂購</Option>
        </Select>
      </FormItem>
      <FormItem label="問題標題" prop="qa_title">
        <Input
          v-model="addqaItem.qa_title"
          placeholder="請輸入問題標題"
        ></Input>
      </FormItem>
      <FormItem label="問題答案" prop="qa_answer">
        <Input
          v-model="addqaItem.qa_answer"
          placeholder="請輸入問題答案"
        ></Input>
      </FormItem>
      <!-- <FormItem label="狀態" prop="qa_status">
        <Select
          v-model="addqaItem.qa_status"
          placeholder="請選擇"
          style="width: 100px"
        >
          <Option value="1">上架</Option>
          <Option value="0">下架</Option>
        </Select>
      </FormItem> -->
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
    <!-- <template #qa_id="{ row }">
      <Input type="text">{{ row.qa_id }}</Input>
    </template> -->
    <!-- 加入開關按鈕 -->
    <template #on_off="{ row }">
      <Switch
        size="large"
        true-color="#fab042"
        false-color="#e6e6e6"
        v-model="row.qa_status"
        :true-value="parseInt(1)"
        :false-value="parseInt(0)"
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

    <template #qa_type="{ row }">
      <text>{{ row.qa_type }}</text>
    </template>

    <!-- 加入編輯、刪除彈窗 -->
    <template #edit_del="{ index, row }">
      <!-- 編輯按鈕 -->
      <Button @click="clickEditBtn(index)" class="edit">編輯</Button>
      <!-- 編輯彈窗 -->
      <Modal
        v-model="modal3[index]"
        title="編輯最新消息"
        ok-text="確認修改"
        cancel-text="取消"
        width="700px"
        class="editnews-popup"
        :styles="{ top: '30px' }"
        @on-ok="replaceItem(row.qa_title)"
        @on-cancel="cancelEdit"
      >
        <Form
          :model="addqaItem"
          :label-width="80"
          :rules="ruleValidate"
          ref="updateForm"
        >
          <FormItem label="問題編號">
            <text>{{ addqaItem.qa_id }}</text>
          </FormItem>
          <FormItem label="問題分類" prop="qa_type">
            <Select v-model="addqaItem.qa_type" placeholder="請選擇">
              <Option value="常見問題">常見問題</Option>
              <Option value="行程預訂">行程預訂</Option>
              <Option value="商品訂購">商品訂購</Option>
            </Select>
          </FormItem>
          <FormItem label="問題標題" prop="qa_title">
            <Input
              v-model="addqaItem.qa_title"
              placeholder="請輸入問題標題"
            ></Input>
          </FormItem>
          <FormItem label="問題答案" prop="qa_answer">
            <Input
              v-model="addqaItem.qa_answer"
              placeholder="請輸入問題答案"
            ></Input>
          </FormItem>
          <!-- <FormItem label="狀態">
            <Select
              v-model="addqaItem.qa_status"
              placeholder="請選擇"
              style="width: 100px"
            >
              <Option value="1">上架</Option>
              <Option value="0">下架</Option>
            </Select>
          </FormItem> -->
        </Form>
      </Modal>
      <!-- 刪除按鈕 -->
      <Button class="delete" @click="remove(index, row)">刪除</Button>
    </template>
  </Table>
</template>

<script>
import { BASE_URL } from "@/assets/js/commom";

export default {
  data() {
    return {
      modal1: false, //新增彈窗預設關閉
      modal3: [], //編輯彈窗預設關閉
      columns: [
        ///表單表頭
        {
          title: "問題編號",
          width: "150px", //寬度
          key: "qa_id",
          align: "center", //置中
          sortable: true, //是否排序
        },
        {
          title: "問題分類",
          width: "150px",
          key: "qa_type",
          align: "center",
          sortable: true,
        },
        {
          title: "問題標題",
          width: "250px",
          key: "qa_title",
          align: "center",
        },
        {
          title: "問題答案",
          width: "345px",
          key: "qa_answer",
          align: "center",
        },
        {
          title: "狀態",
          key: "qa_status",
          align: "center",
          width: "100px",
          slot: "on_off", //加入開關鈕欄位需加slot
        },
        {
          title: "編輯/刪除",
          width: "203px",
          key: "edit",
          align: "center",
          slot: "edit_del", //加入編輯刪除欄位需加slot
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
        // qa_id: "",
        qa_type: "",
        qa_title: "",
        qa_answer: "",
        qa_status: "0",
      },
      resetqaItem: {
        // qa_id: "",
        qa_type: "",
        qa_title: "",
        qa_answer: "",
        qa_status: "0",
      },
      // validate
      ruleValidate: {
        qa_type: [
          {
            required: true,
            type: "string",
            message: "請記得打問題種類",
            trigger: "blur",
          },
        ],
        qa_title: [
          {
            required: true,
            type: "string",
            message: "別忘了問題標題",
            trigger: "blur",
          },
        ],
        qa_answer: [
          {
            required: true,
            type: "string",
            message: "別忘了問題答案",
            trigger: "blur",
          },
        ],
        qa_status: 0,
      },
    };
  },
  methods: {
    remove(index, row) {
      console.log(row);
      this.$Modal.confirm({
        content: "<p>請再次確認是否需要刪除?</p>",
        okText: "確認刪除",
        cancelText: "取消刪除",
        onOk: () => {
          this.$Message.info("確認刪除");
          this.deleData(row);

          this.getQuestion.splice(index, 1);
        },
        onCancel: () => {
          this.$Message.info("取消");
        },
      });
    },
    onChange(row) {
      // console.log(row.qa_status);
      if (row.qa_status) {
        this.$Message.info("上架狀態： 上架");
      } else {
        this.$Message.info("上架狀態： 下架");
      }
      // console.log(row);

      this.updateStatus(row.qa_id, row.qa_status);
    },
    clickOk() {
      this.$refs["addForm"].validate((valid) => {
        if (valid) {
          this.insertData(this.addqaItem);
        } else {
          alert("新增失敗，請確認表格是否輸入正確");
          // this.$Message.error("Fail!");
          // this.addItem = { ...this.resetItem };
          // document.getElementById("pro_img_id").outerHTML =
          //   document.getElementById("pro_img_id").outerHTML;
        }
      });
    },
    clickEditBtn(index) {
      this.modal3[index] = true;
      this.addqaItem = { ...this.getQuestion[index] };
      // console.log(this.getNews[0]);
    },
    replaceItem(index) {
      this.$refs["updateForm"].validate((valid) => {
        if (valid) {
          // this.addItem.pro_rest_amount = this.addItem.pro_onshelf_amount;
          // this.addItem.pro_onshelf_date = this.addItem.pro_onshelf_date
          //   .toLocaleDateString()
          //   .replace(/\//g, "-");

          // this.insertData(this.addItem);
          this.updateData(index);

          // 帶移動
          // const index = this.dataList.findIndex(
          //   (item) => item.pro_id === this.addItem.pro_id
          // );

          // this.dataList[index] = this.addItem;
          // this.addItem = { ...this.resetItem };
        } else {
          alert("修改失敗，請確認表格是否輸入正確");
        }
      });
    },
    cancelEdit() {
      this.addqaItem = { ...this.resetqaItem };
    },
    getData() {
      fetch(`${BASE_URL}/getQuestion.php`)
        .then((res) => res.json())
        .then((json) => {
          this.getQuestion = json;
        });
    },
    insertData() {
      const formData = new FormData();
      const formDataKey = Object.keys(this.addqaItem);
      formDataKey.forEach((key) => {
        formData.append(`${key}`, this.addqaItem[key]);
      });
      fetch(`${BASE_URL}/addQuestion.php`, {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((res) => {
          const result = res;

          if (result === "wrong") {
            alert("新增失敗，資料庫已有此筆資料");
          } else {
            this.addqaItem.qa_id = result.qa_id[0].qa_id;
            this.getQuestion.push({ ...this.addqaItem });
          }

          this.addqaItem = { ...this.resetqaItem };
        });
    },
    deleData(row) {
      // console.log(row.qa_id);
      const formData = new FormData();
      formData.append("qa_id", row.qa_id);

      fetch(`${BASE_URL}/deleteQuestion.php`, {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((result) => {
          console.log(result);
        });
    },
    updateData() {
      console.log(this.addqaItem);
      const formData = new FormData();
      const formDataKey = Object.keys(this.addqaItem);
      formDataKey.forEach((key) => {
        formData.append(`${key}`, this.addqaItem[key]);
      });
      fetch(`${BASE_URL}/editQuestion.php`, {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((res) => {
          const result = res;

          if (result === "wrong") {
            alert("新增失敗，資料庫已有此筆資料");
          } else {
            const index = this.getQuestion.findIndex(
              (item) => item.qa_id === this.addqaItem.qa_id
            );

            this.getQuestion[index] = this.addqaItem;
          }

          this.addqaItem = { ...this.resetqaItem };
        });
    },
    updateStatus(qa_id, qa_status) {
      const formData = new FormData();
      formData.append("qa_status", qa_status);
      formData.append("qa_id", qa_id);

      fetch(`${BASE_URL}/updateQuestionStatus.php`, {
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
  mounted() {
    this.getData();
  },
};
</script>
<style lang="scss" scoped>
@import "@/assets/css/app.scss";
</style>
