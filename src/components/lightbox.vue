<template>
        <Button @click="modal4 = true">修改/刪除</Button>
        <Modal
            v-model="modal4"
            title="Custom width"
            width="500" hight="fit-content">
            <div class="popup">

            </div>
        </Modal>
</template>
<script>
    export default {
        data () {
            return {
                modal4: false
            }
        },
        methods: {
        }
    }
</script>