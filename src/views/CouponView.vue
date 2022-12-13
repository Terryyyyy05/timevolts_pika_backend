<template>
  <the-heading heading="折扣券管理系統"></the-heading>
    <Table class="table" stripe border :columns="columns" :data="data">
      
      <template #on_off="{row }">
        <switchbtn/>
      </template>

      <template #edit_del="{row}">
        <lightbox />
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
          title: '編輯/修改',
          width: '150px',
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
  }
}
</script>
<style lang="scss" scoped>
@import '@/assets/css/app.scss';
.table{
  width: 1200px;
  margin: 30px auto;
}

</style>