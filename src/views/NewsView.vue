<template>
<the-heading heading="最新消息管理系統"></the-heading>
<Tableform :columns="columns" :data="data"/>
<switchbtn/>
<lightbox/>
</template>

<script>
import Tableform from '@/components/Tableform.vue'
import switchbtn from '@/components/switchbtn.vue'
import lightbox from '@/components/lightbox.vue'
export default {
  components: {
    Tableform,
    switchbtn,
    lightbox
  },
  data() {
    return {
      columns: [
        {
          title: '最新消息編號',
          key: 'number',
          sortable: true
        },
        {
          title: '發布日期',
          key: 'date',
          sortable: true
        },
        {
          title: '消息分類',
          key: 'type',
          sortable: true
        },
        {
          title: '標題',
          key: 'title'
        },
        {
          title: '狀態',
          key: 'status'
        },
        {
          title: '編輯/修改',
          key: 'edit'
        },
      ],
      data: [
        {
          number: '1',
          date: '',
          type: '',
          title: '',
          status: "",
          edit: '',
        },
        {
          number: '2',
          date: '',
          type: '',
          title: '',
          status: '',
          edit: '',
        },
        {
          number: '3',
          date: '',
          type: '',
          title: '',
          status: '',
          edit: '',
        },
        {
          number: '4',
          date: '',
          type: '',
          title: '',
          status: '',
          edit: '',
        },
        {
          number: '5',
          date: '',
          type: '',
          title: '',
          status: '',
          edit: '',
        },
        {
          number: '6',
          date: '',
          type: '',
          title: '',
          status: '',
          edit: '',
        },
      ]
    }
  }
}
</script>
<style lang="scss" scoped>
@import '@/assets/css/app.scss';
</style>