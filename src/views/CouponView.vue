<template>
  <!-- 標題 -->
  <the-heading heading="折扣券管理系統"></the-heading>
  <!-- 新增彈窗按鈕 -->
  <Button @click="modal1 = true" class="add">新增 +</Button>
  <!-- 新增彈窗 -->
  <Modal
    v-model="modal1"
    title="新增折扣卷"
    width="700px"
    class="addnews-popup"
    :styles="{ top: '30px' }"
    ok-text="確認新增"
    cancel-text="取消新增"
    @on-ok="newData"
    @on-Cancel="cancelData"
  >
    <Form :model="addItem" :label-width="80" :rules="ruleInline" inline>
      <!-- <FormItem label="折扣卷ID">
        <Input v-model="addItem.coupon_id" placeholder="ID" disabled></Input>
      </FormItem> -->
      <FormItem label="折扣金額">
        <InputNumber
          style="width: 200px"
          controls-outside
          :formatter="
            (value) => `$ ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')
          "
          :min="1"
          model-value
          v-model="addItem.coupon_discount_number"
          placeholder="請輸入折扣金額"
        ></InputNumber>
      </FormItem>
      <FormItem label="發行數量">
        <InputNumber
          editable
          style="width: 200px"
          :min="1"
          controls-outside
          v-model="addItem.coupon_quantity"
          placeholder="請輸入發行數量"
        ></InputNumber>
      </FormItem>
      <FormItem label="消費門檻">
        <InputNumber
          style="width: 200px"
          controls-outside
          :formatter="
            (value) => `$ ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')
          "
          :min="addItem.coupon_discount_number"
          v-model="addItem.coupon_pricing_condition"
          placeholder="請輸入門檻金額"
          :class="{
            error:
              !addItem.coupon_discount_number >
              addItem.coupon_pricing_condition,
          }"
        ></InputNumber>
      </FormItem>
    </Form>
    <Form :model="addItem">
      <FormItem label="發送日期">
        <DatePicker
          :min="1"
          type="date"
          v-model="addItem.coupon_issue_date"
          placeholder="請輸入發送日期"
        ></DatePicker>
      </FormItem>
      <FormItem label="生效日期">
        <DatePicker
          type="date"
          v-model="addItem.coupon_valid_date"
          placeholder="請輸入生效日期"
        ></DatePicker>
      </FormItem>
      <FormItem label="到期日期">
        <DatePicker
          type="date"
          v-model="addItem.coupon_exp_date"
          placeholder="請輸入到期日期"
        ></DatePicker>
      </FormItem>
    </Form>
  </Modal>

  <!-- 表格 -->
  <Table
    class="table"
    stripe="true"
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
        v-model="row.coupon_status"
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

    <template #news_type="{ row }">
      <text>{{ row.news_type }}</text>
    </template>

    <!-- 加入編輯、刪除彈窗 -->
    <template #edit_del="{ index, row }">
      <!-- 編輯按鈕 -->
      <!-- <Button @click="clickEditBtn(index)" class="edit">編輯</Button> -->
      <!-- 編輯彈窗 -->
      <Modal
        v-model="modal3"
        title="編輯折扣卷"
        ok-text="確認修改"
        cancel-text="取消"
        width="700px"
        class="editnews-popup"
        :styles="{ top: '30px' }"
      >
        <Form :model="editItem" :label-width="80" :rules="ruleInline" inline>
          <FormItem label="折扣卷ID">
            <Input
              v-model="editItem.coupon_id"
              placeholder="請輸入折扣ID"
            ></Input>
          </FormItem>
          <FormItem label="折扣金額">
            <Input
              v-model="editItem.coupon_discount_number"
              placeholder="請輸入折扣金額"
            ></Input>
          </FormItem>
          <FormItem label="發行數量">
            <Input
              v-model="editItem.coupon_quantity"
              placeholder="請輸入發行數量"
            ></Input>
          </FormItem>
          <FormItem label="消費門檻">
            <Input
              v-model="editItem.coupon_pricing_condition"
              placeholder="請輸入門檻金額"
            ></Input>
          </FormItem>
        </Form>
        <Form :model="editItem">
          <FormItem label="發送日期">
            <DatePicker
              type="date"
              v-model="editItem.coupon_issue_date"
              placeholder="請輸入發送日期"
            ></DatePicker>
          </FormItem>
          <FormItem label="生效日期">
            <DatePicker
              type="date"
              v-model="editItem.coupon_valid_date"
              placeholder="請輸入生效日期"
            ></DatePicker>
          </FormItem>
          <FormItem label="到期日期">
            <DatePicker
              type="date"
              v-model="editItem.coupon_exp_date"
              placeholder="請輸入到期日期"
            ></DatePicker>
          </FormItem>
        </Form>
      </Modal>

      <!-- 刪除按鈕 -->
      <Button
        v-if="dataList[index].coupon_given_numbers != 0"
        class="notDelete delete"
        @click="remove(index, row)"
        >已發送中</Button
      >
      <Button v-else class="delete" @click="remove(index, row)"
        >完全刪除</Button
      >
    </template>
  </Table>
</template>

<script>
import { BASE_URL } from "@/assets/js/commom";
export default {
  data() {
    return {
      loading: true,
      modal1: false, //新增彈窗預設關閉
      modal3: false, //編輯彈窗預設關閉
      columns: [
        ///表單表頭
        {
          title: "ID",
          width: "80px", //寬度
          key: "coupon_id",
          align: "center", //置中
          sortable: true, //是否排序
        },
        {
          title: "發送日期",
          width: "120px",
          key: "coupon_issue_date",
          align: "center",
          sortable: true,
        },
        {
          title: "生效日期",
          width: "120px",
          key: "coupon_valid_date",
          align: "center",
          sortable: true,
        },
        {
          title: "到期日期",
          width: "120px",
          key: "coupon_exp_date",
          align: "center",
          sortable: true,
        },
        {
          title: "發行數量",
          width: "108px",
          key: "coupon_quantity",
          align: "center",
          sortable: true,
        },
        {
          title: "已發數量",
          width: "108px",
          key: "coupon_given_numbers",
          align: "center",
          sortable: true,
        },
        {
          title: "折扣金額",
          width: "108px",
          key: "coupon_discount_number",
          align: "center",
          sortable: true,
        },
        {
          title: "消費門檻",
          width: "108px",
          key: "coupon_pricing_condition",
          align: "center",
          sortable: true,
        },
        {
          title: "上下架狀態",
          key: "coupon_status",
          align: "center",
          width: "120px",
          slot: "on_off", //加入開關鈕欄位需加slot
        },
        {
          title: "刪除",
          key: "edit",
          align: "center",
          slot: "edit_del", //加入編輯刪除欄位需加slot
        },
      ],
      dataList: [],
      addItem: {
        //新增彈窗內容資料
        coupon_id: "",
        coupon_discount_number: "",
        coupon_quantity: "",
        coupon_pricing_condition: "",
        coupon_issue_date: "",
        coupon_valid_date: "",
        coupon_exp_date: "",
        coupon_status: 0,
        couponStatus: false,
      },
      editItem: {
        coupon_id: "",
        coupon_discount_number: "",
        coupon_quantity: "",
        coupon_pricing_condition: "",
        coupon_issue_date: "",
        coupon_valid_date: "",
        coupon_exp_date: "",
        coupon_status: 0,
        couponStatus: false,
      },
    };
  },
  methods: {
    remove(index, row) {
      // 刪除
      let selt = this;
      console.log(row);
      console.log(index);

      if (row.coupon_given_numbers != 0) {
        selt.$Message.info(
          "優惠卷已被領取，不能刪除，但可以先下架避免發放更多優惠卷"
        );
      } else {
        this.$Modal.confirm({
          content: "<p>您確認刪除這筆資料嗎?</p><p>刪除後就找不回來唷!</p>",
          okText: "確定刪除",
          cancelText: "取消刪除",
          onOk: () => {
            selt.$Message.info("優惠卷已刪除");
            selt.deleData(row);
            console.log(selt.dataList.splice(index, 1));
            selt.dataList.splice(index, 1);
          },
          onCancel: () => {
            this.$Message.info("取消");
          },
        });
      }
    },
    deleData(row) {
      console.log(row.pro_id);
      const formData = new FormData();
      formData.append("coupon_id", row.coupon_id);

      fetch(`${BASE_URL}/dele_coupon_data.php`, {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((result) => {
          console.log(result);
        });
    },

    onChange(row) {
      console.log(row.coupon_status);
      if (row.coupon_status) {
        this.$Message.success("上架狀態： 上架");
      } else {
        this.$Message.success("上架狀態： 下架");
      }
      console.log(row);

      this.updateStatus(row.coupon_id, row.coupon_status);
    },
    updateStatus(coupon_id, coupon_status) {
      const formData = new FormData();
      formData.append("coupon_status", coupon_status);
      formData.append("coupon_id", coupon_id);

      fetch(`${BASE_URL}/update_coupon_status.php`, {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((res) => {
          const result = res;
          console.log(result);
        });
    },

    clickEditBtn(index) {
      this.modal3[index] = true;
      this.addItem = { ...this.dataList[index] };
    },
    async getData() {
      let selt = this;
      await fetch(`${BASE_URL}/get_coupon_data.php`)
        .then((res) => res.json())
        .then((result) => {
          selt.dataList = result;
          // selt.addItem.coupon_id = selt.dataList.length + 1;
          console.log(selt);
        });
    },
    async couponStatus() {
      if ((dataList.coupon_status = 1)) {
        return true;
      } else {
        return false;
      }
    },
    newData() {
      let selt = this;
      let AddItem = selt.addItem;

      // 檢查是否為空值、錯誤
      if (AddItem.coupon_discount_number == "") {
        selt.$Message.warning("「折扣金額」不得為空");
      } else if (AddItem.coupon_quantity == "") {
        selt.$Message.warning("「發送數量」不得為空");
      } else if (AddItem.coupon_pricing_condition == "") {
        selt.$Message.warning("「消費門檻」不得為空");
      } else if (
        AddItem.coupon_pricing_condition < AddItem.coupon_discount_number
      ) {
        selt.$Message.warning("「消費門檻」不得低於「折扣金額」");
      } else if (AddItem.coupon_issue_date == "") {
        selt.$Message.warning("「發送日期」不得為空");
      } else if (AddItem.coupon_valid_date == "") {
        selt.$Message.warning("「生效日期」不得為空");
      } else {
        // 檢查資料是否為數字
        function isNumber(inputs) {
          return parseFloat(inputs).toString() != "NaN";
        }
        if (!isNumber(AddItem.coupon_discount_number)) {
          selt.$Message.info("折價金額錯誤");
        } else if (!isNumber(AddItem.coupon_quantity)) {
          selt.$Message.info("消費門檻錯誤");
        } else if (!isNumber(AddItem.coupon_pricing_condition)) {
          selt.$Message.info("發行數量錯誤");
        } else {
          // 通過驗證
          this.newDataTidy();
        }
      }
    },
    newDataTidy() {
      let selt = this;
      let AddItem = selt.addItem;

      // 整理日期格式、判定有無期限
      typeof str == "string";
      selt.addItem.coupon_issue_date = selt.addItem.coupon_issue_date
        .toLocaleDateString()
        .replace(/\//g, "-")
        .substr(0, 10);
      selt.addItem.coupon_valid_date = selt.addItem.coupon_valid_date
        .toLocaleDateString()
        .replace(/\//g, "-")
        .substr(0, 10);
      if (selt.addItem.coupon_exp_date != "") {
        selt.addItem.coupon_exp_date = selt.addItem.coupon_exp_date
          .toLocaleDateString()
          .replace(/\//g, "-")
          .substr(0, 10);
        // 送出一般的資料
        this.insertNewData(AddItem);
      } else {
        selt.addItem.coupon_exp_date == "null";
        // 送出無期限的資料
        this.insertNullExpData(AddItem);
      }

      // 新增資料
      // if (AddItem.coupon_exp_date != "null") {
      //   console.log(AddItem.coupon_exp_date);
      // } else {
      //   console.log(AddItem.coupon_exp_date);
      // }
    },

    // 新增資料
    insertNewData(AddItem) {
      let formData = new FormData();
      formData.append("action", "newData");
      formData.append("coupon_discount_number", AddItem.coupon_discount_number);
      formData.append("coupon_quantity", AddItem.coupon_quantity);
      formData.append(
        "coupon_pricing_condition",
        AddItem.coupon_pricing_condition
      );
      formData.append("coupon_issue_date", AddItem.coupon_issue_date);
      formData.append("coupon_valid_date", AddItem.coupon_valid_date);
      formData.append("coupon_exp_date", AddItem.coupon_exp_date);
      formData.append("coupon_status", AddItem.coupon_status);

      fetch(`${BASE_URL}/insert_new_coupon_data.php`, {
        method: "POST",
        body: formData,
      });
      selt.$Message.info("已新增一筆資料");
      // 重新撈資料
      this.getData();
    },

    // 新增無期限資料
    insertNullExpData(AddItem) {
      let nullExpFormData = new FormData();
      nullExpFormData.append("action", "nullExpData");
      nullExpFormData.append(
        "coupon_discount_number",
        AddItem.coupon_discount_number
      );
      nullExpFormData.append("coupon_quantity", AddItem.coupon_quantity);
      nullExpFormData.append(
        "coupon_pricing_condition",
        AddItem.coupon_pricing_condition
      );
      nullExpFormData.append("coupon_issue_date", AddItem.coupon_issue_date);
      nullExpFormData.append("coupon_valid_date", AddItem.coupon_valid_date);
      nullExpFormData.append("coupon_status", AddItem.coupon_status);

      fetch(`${BASE_URL}/insert_null_exp_coupon_data.php`, {
        method: "POST",
        body: nullExpFormData,
      });
      selt.$Message.info("已新增一筆資料");
      // 重新撈資料
      this.getData();
    },

    cancelData() {
      this.$Message.info("已取消新增");
    },

    confirm() {
      // 新增通知
      let selt = this;
      selt.modal1 = true;
      this.$Modal.confirm({
        onOk: () => {
          // 已新增一筆資料
          newData;
          this.$Message.info("已新增一筆資料");
        },
        onCancel: () => {
          this.$Message.info("已取消新增");

          console.log(selt);
        },
      });
    },
  },
  mounted() {
    this.getData();
  },
  created() {
    // this.getData();
    // function OnlyNumber(obj) {
    //   if (obj.value != obj.value.replace(/[^0-9\.]/g, "")) {
    //     obj.value = obj.value.replace(/[^0-9\.-]/g, "");
    //   }
    // }
    // this.$set(this.dataList, "add", 0);
  },
  computed: {},
};
</script>
<style lang="scss" scoped>
@import "@/assets/css/app.scss";
.notDelete {
  background: #ccc;
  border: 1px solid #ccc;
}
.error input::-webkit-input-placeholder {
  color: red;
}
</style>
