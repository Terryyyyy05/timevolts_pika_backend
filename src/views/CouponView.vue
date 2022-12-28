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
  >
    <Form :model="addItem" :label-width="80" :rules="ruleInline" inline>
      <FormItem label="折扣卷ID">
        <Input v-model="addItem.coupon_id" placeholder="請輸入折扣ID"></Input>
      </FormItem>
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
    <Switch size="large" true-color="#fab042" false-color="#e6e6e6">
      <template #open>
        <span>上架</span>
      </template>
      <template #close>
        <span>下架</span>
      </template>
    </Switch>
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

    <template #news_type="{ row }">
      <text>{{ row.news_type }}</text>
    </template>

    <!-- 加入編輯、刪除彈窗 -->
    <template #edit_del>
      <!-- 編輯按鈕 -->
      <Button @click="modal3 = true">編輯</Button>
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
              v-model="addItem.coupon_id"
              placeholder="請輸入折扣ID"
            ></Input>
          </FormItem>
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
        <Switch size="large" true-color="#fab042" false-color="#e6e6e6">
          <template #open>
            <span>上架</span>
          </template>
          <template #close>
            <span>下架</span>
          </template>
        </Switch>
      </Modal>

      <!-- 刪除按鈕 -->
      <Button class="delete" @click="remove(data.id)">刪除</Button>
    </template>
  </Table>
</template>

<script>
export default {
  data() {
    return {
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
      dataList: [
        ///表格內容資料
        {
          coupon_id: 1, //編號
          coupon_discount_number: 0, //折扣金額
          coupon_issue_date: "", //發送日期
          coupon_valid_date: "", //生效日期
          coupon_exp_date: "", //到期日期
          coupon_quantity: 0, //發行數量
          coupon_given_numbers: 0, //已發數量
          coupon_pricing_condition: 0, //消費門檻
          coupon_status: 0, // 1=上架,0=下架
        },
        {
          coupon_id: 2, //編號
          coupon_discount_number: 0, //折扣金額
          coupon_issue_date: "", //發送日期
          coupon_valid_date: "", //生效日期
          coupon_exp_date: "", //到期日期
          coupon_quantity: 0, //發行數量
          coupon_given_numbers: 0, //已發數量
          coupon_pricing_condition: 0, //消費門檻
          coupon_status: 0, // 1=上架,0=下架
        },
        {
          coupon_id: 3, //編號
          coupon_discount_number: 0, //折扣金額
          coupon_issue_date: "", //發送日期
          coupon_valid_date: "", //生效日期
          coupon_exp_date: "", //到期日期
          coupon_quantity: 0, //發行數量
          coupon_given_numbers: 0, //已發數量
          coupon_pricing_condition: 0, //消費門檻
          coupon_status: 0, // 1=上架,0=下架
        },
        {
          coupon_id: 4, //編號
          coupon_discount_number: 0, //折扣金額
          coupon_issue_date: "", //發送日期
          coupon_valid_date: "", //生效日期
          coupon_exp_date: "", //到期日期
          coupon_quantity: 0, //發行數量
          coupon_given_numbers: 0, //已發數量
          coupon_pricing_condition: 0, //消費門檻
          coupon_status: 0, // 1=上架,0=下架
        },
        {
          coupon_id: 5, //編號
          coupon_discount_number: 0, //折扣金額
          coupon_issue_date: "", //發送日期
          coupon_valid_date: "", //生效日期
          coupon_exp_date: "", //到期日期
          coupon_quantity: 0, //發行數量
          coupon_given_numbers: 0, //已發數量
          coupon_pricing_condition: 0, //消費門檻
          coupon_status: 0, // 1=上架,0=下架
        },
        {
          coupon_id: 6, //編號
          coupon_discount_number: 0, //折扣金額
          coupon_issue_date: "", //發送日期
          coupon_valid_date: "", //生效日期
          coupon_exp_date: "", //到期日期
          coupon_quantity: 0, //發行數量
          coupon_given_numbers: 0, //已發數量
          coupon_pricing_condition: 0, //消費門檻
          coupon_status: 0, // 1=上架,0=下架
        },
        {
          coupon_id: 7, //編號
          coupon_discount_number: 0, //折扣金額
          coupon_issue_date: "", //發送日期
          coupon_valid_date: "", //生效日期
          coupon_exp_date: "", //到期日期
          coupon_quantity: 0, //發行數量
          coupon_given_numbers: 0, //已發數量
          coupon_pricing_condition: 0, //消費門檻
          coupon_status: 0, // 1=上架,0=下架
        },
        {
          coupon_id: 8, //編號
          coupon_discount_number: 0, //折扣金額
          coupon_issue_date: "", //發送日期
          coupon_valid_date: "", //生效日期
          coupon_exp_date: "", //到期日期
          coupon_quantity: 0, //發行數量
          coupon_given_numbers: 0, //已發數量
          coupon_pricing_condition: 0, //消費門檻
          coupon_status: 0, // 1=上架,0=下架
        },
        {
          coupon_id: 9, //編號
          coupon_discount_number: 0, //折扣金額
          coupon_issue_date: "", //發送日期
          coupon_valid_date: "", //生效日期
          coupon_exp_date: "", //到期日期
          coupon_quantity: 0, //發行數量
          coupon_given_numbers: 0, //已發數量
          coupon_pricing_condition: 0, //消費門檻
          coupon_status: 0, // 1=上架,0=下架
        },
        {
          coupon_id: 10, //編號
          coupon_discount_number: 0, //折扣金額
          coupon_issue_date: "", //發送日期
          coupon_valid_date: "", //生效日期
          coupon_exp_date: "", //到期日期
          coupon_quantity: 0, //發行數量
          coupon_given_numbers: 0, //已發數量
          coupon_pricing_condition: 0, //消費門檻
          coupon_status: 0, // 1=上架,0=下架
        },
      ],
      addItem: {
        //新增彈窗內容資料
        coupon_id: "",
        title: "",
        select: "",
        date: "",
        textarea: "",
      },
      editItem: {
        id: "addItem.id()",
        title: "",
        select: "",
        date: "",
        textarea: "",
      },
    };
  },
  methods: {
    async getData() {
      // fetch(`${BASE_URL}/get_coupon_data.php`)
      let selt = this;
      await fetch(
        `http://localhost/timevolts_pika_backend/public/phpfiles/get_coupon_data.php`
      )
        .then((res) => res.json())
        .then((result) => {
          selt.dataList = result;

          //資料處理
          //
          selt.addItem.coupon_id = selt.dataList.length + 1;
          console.log(selt);
        });
    },
    remove() {
      this.$Modal.confirm({
        content: "<p>確認刪除嗎?</p>",
        onOk: () => {
          this.$Message.info("確認刪除");
          this.data.splice("id", 1);
        },
        onCancel: () => {
          this.$Message.info("取消");
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
