<template>
        <Button @click="modal4 = true">修改/刪除</Button>
        <Modal
            v-model="modal4"
            title="Custom width"
            width="500" hight="fit-content">
            <p>Customize width, unit px, default 520px.</p>
            <p>The width of the dialog box is responsive, and the width becomes <code>auto</code> when the screen size is less than 768px.</p>
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