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
        <Input
          v-model="addItem.coupon_discount_number"
          placeholder="請輸入折扣金額"
        ></Input>
      </FormItem>
      <FormItem label="發行數量">
        <Input
          v-model="addItem.coupon_quantity"
          placeholder="請輸入發行數量"
        ></Input>
      </FormItem>
      <FormItem label="消費門檻">
        <Input
          v-model="addItem.coupon_pricing_condition"
          placeholder="請輸入門檻金額"
        ></Input>
      </FormItem>
    </Form>
    <Form :model="addItem">
      <FormItem label="發送日期">
        <DatePicker
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
      <Button class="delete" @click="remove(index, row)">刪除</Button>
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
          title: "編輯/刪除",
          key: "edit",
          align: "center",
          slot: "edit_del", //加入編輯刪除欄位需加slot
        },
      ],
      dataList: [],
      addItem: {
        //新增彈窗內容資料
        coupon_id: "",
        coupon_discount_number: "1",
        coupon_quantity: "100",
        coupon_pricing_condition: "3",
        coupon_issue_date: "2022-12-01",
        coupon_valid_date: "2022-12-29",
        coupon_exp_date: "2023-01-31",
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
        this.$Message.info("上架狀態： 上架");
      } else {
        this.$Message.info("上架狀態： 下架");
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

          //資料處理
          //新增couponStatus屬性代替coupon_status計算布林值
          for (let i = 0; i < selt.dataList.length; i++) {
            if (selt.dataList[i].coupon_status == 1) {
              selt.dataList[i]["couponStatus"] = true;
            } else if (selt.dataList[i].coupon_status == 0) {
              selt.dataList[i]["couponStatus"] = false;
            }
          }

          selt.addItem.coupon_id = selt.dataList.length + 1;
          console.log(selt);
        });
      console.log(selt.dataList);
    },
    couponStatus() {
      console.log("EEE");
      console.log(dataList.coupon_status);
      if ((dataList.coupon_status = 1)) {
        return true;
      } else {
        return false;
      }
    },
    newData() {
      let selt = this;
      let AddItem = selt.addItem;

      // 整理資料
      //新增couponStatus的布林值，轉為coupon_status 0 or 1
      AddItem.coupon_id = AddItem.coupon_id;
      if (AddItem.couponStatus == true) {
        AddItem.coupon_status == 1;
      } else if (AddItem.couponStatus == false) {
        AddItem.coupon_status == 0;
      }

      // 檢查資料是否為數字
      function isNumber(inputs) {
        return parseFloat(inputs).toString() != "NaN";
      }
      // 折價金額
      if (isNumber(AddItem.coupon_discount_number)) {
        //發行數量
        if (isNumber(AddItem.coupon_quantity)) {
          //消費門檻
          if (isNumber(AddItem.coupon_pricing_condition)) {
            // 新增資料
            NewData();
          } else {
            selt.$Message.info("消費門檻錯誤");
          }
        } else {
          selt.$Message.info("發行數量錯誤");
        }
      } else {
        selt.$Message.info("折價金額錯誤");
      }
      return;

      // 新增資料
      function NewData() {
        // fetch(`${BASE_URL}/insert_new_coupon_data.php`)
        fetch(`${BASE_URL}/insert_new_coupon_data.php`, {
          method: "POST",
          body: JSON.stringify({
            action: "newData",
            coupon_id: AddItem.coupon_id,
            coupon_discount_number: AddItem.coupon_discount_number,
            coupon_quantity: AddItem.coupon_quantity,
            coupon_pricing_condition: AddItem.coupon_pricing_condition,
            coupon_issue_date: AddItem.coupon_issue_date,
            coupon_valid_date: AddItem.coupon_valid_date,
            coupon_exp_date: AddItem.coupon_exp_date,
            coupon_status: AddItem.coupon_status,
          }),
        });
        selt.$Message.info("已新增一筆資料");
        // 重新撈資料
        this.getData();
      }
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
  mounted() {},
  created() {
    this.getData();
  },
  computed: {},
};
</script>
<style lang="scss" scoped>
@import "@/assets/css/app.scss";
</style>
