<template>
        <Button @click="modal4 = true">修改</Button>
        <Modal
            v-model="modal4"
            title="Custom width"
            width="500" hight="fit-content">
            <div class="popup">
                <div class="title">
                    <p>標題</p>
                    <Input v-model="value" placeholder="Enter something..." style="width: 300px" />
                </div>

            </div>
        </Modal>
</template>
<script>
    export default {
        data () {
            return {
                modal4: false,
            }
        },
        methods: {
        }
    }
</script>