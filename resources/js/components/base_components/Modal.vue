<template>
    <transition name="modal">
        <div class="modal-mask" v-if="isModalVisible">
            <div class="modal-wrapper">
                <div class="modal-container rounded-xl shadow-2xl">

                    <div class="modal-header">
                        <slot name="header">
                            <button class="modal-default-button" @click="$emit('close')">
                                x
                            </button>
                        </slot>
                    </div>

                    <div class="modal-body">
                        <slot name="body">
                            default body
                        </slot>
                    </div>

                    <div class="modal-footer">
                        <slot name="footer">

                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<style>
.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgb(0 163 177 / 90%);
    display: table;
    transition: opacity 0.3s ease;
}
.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
}
.modal-container {
    max-width: 1200px;
    margin: 0px auto;
    padding: 20px 30px;
    background-color: #fff;
    transition: all 0.3s ease;
    font-family: Helvetica, Arial, sans-serif;
}
.modal-header h3 {
    margin-top: 0;
    color: #42b983;
}
.modal-body {
    margin: 20px 0;
}
.modal-default-button {
    float: right;
}
.modal-enter {
    opacity: 0;
}
.modal-leave-active {
    opacity: 0;
}
.modal-enter .modal-container,
.modal-leave-active .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
}
</style>

<script>
export default {
    data() {
        return {
            // isModalVisible: false
        }
    },
    props: {
        onMounted: {
            type: Function,
            default: null,
            required: false
        },
        isModalVisible: {
            type: Boolean,
            default: false,
            required: true
        }
    },
    mounted(){
        this.onMounted && this.onMounted();
    }
}
</script>
