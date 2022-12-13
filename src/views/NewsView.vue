<template>
  <the-heading heading="最新消息管理系統"></the-heading>
  <Button @click="modal1 = true">新增</Button>
        <Modal
            v-model="modal1"
            title="Custom width"
            width="300"
            >
            <p>Customize width, unit px, default 520px.</p>
            <p>The width of the dialog box is responsive, and the width becomes <code>auto</code> when the screen size is less than 768px.</p>
        </Modal>
    <Table class="table" stripe border :columns="columns" :data="data">
      
      <template #on_off="{row }">
        <switchbtn />
      </template>

      <template #edit_del="{row}">
        <Button @click="modal2 = true" class="edit">編輯</Button>
        <Modal
            title="Title"
            v-model="modal2"
            :mask-closable="false">
            <p>Content of dialog</p>
            <p>Content of dialog</p>
            <p>Content of dialog</p>
        </Modal>

        <Button class="delete" @click="confirm">刪除</Button>
      </template>
    </Table>
</template>

<script>
import switchbtn from '@/components/switchbtn.vue'
import lightbox from '@/components/lightbox.vue'
export default {
  components: {
    switchbtn,
    lightbox
  },
  data() {
    return {
      modal1: false, 
      modal2: false,
      columns: [
        {
          title: '編號',
          width: '100px',
          key: 'number',
          align: 'center',
          sortable: true
        },
        {
          title: '發布日期',
          width: '150px',
          key: 'date',
          align: 'center',
          sortable: true
        },
        {
          title: '消息分類',
          width: '150px',
          key: 'type',
          align: 'center',
          sortable: true,
        },
        {
          title: '標題',
          key: 'title',
          align: 'center',
          input: 'textarea',
        },
        {
          title: '上下架',
          key: 'status',
          align: 'center',
          width: '100px',
          slot: 'on_off',
        },
        {
          title: '編輯/刪除',
          width: '200px',
          key: 'edit',
          align: 'center',
          slot:'edit_del'
        },
      ],
      data: [
        {
          number: '1',
          date: '',
          type: '',
          title: '',
        },
        {
          number: '2',
          date: '',
          type: '',
          title: '',
        },
        {
          number: '3',
          date: '',
          type: '',
          title: '',
        },
        {
          number: '4',
          date: '',
          type: '',
          title: '',
        },
        {
          number: '5',
          date: '',
          type: '',
          title: '',
        },
        {
          number: '6',
          date: '',
          type: '',
          title: '',
        },
      ]
    }
  },
  methods: {
    confirm () {
                this.$Modal.confirm({
                    content: '<p>確認刪除嗎?</p>',
                    onOk: () => {
                        this.$Message.info('確認刪除');
                    },
                    onCancel: () => {
                        this.$Message.info('取消');
                    }
                });
        }
      }
    }

</script>
<style lang="scss" scoped>
@import '@/assets/css/app.scss';
.table{
  width: 1200px;
  margin: 30px auto;
}
.delete{
 margin: 0 10px;
 background-color: $color;
 color: #ffffff;
 border:1px solid $color;
}
.edit{
 color: $color;
 border:1px solid $color;
}
</style>