<template>
    <portal to="modals">
        <Transition>
            <div class="modalForm" v-show="isModalOpen" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalFormLabel">{{ title }}</h5>
                            <button type="button" class="close" @click="closeModal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="submit">
                            <div class="modal-body">
                                <slot name="body"></slot>
                            </div>
                            <div class="modal-footer">
                                <slot name="footer"> </slot>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </Transition>         
    </portal>    
</template>

<script>
    export default {
        name: "ModalForm",
        props: {
            id: {
                type: Number,
                required: false
            },
            title: {
                type: String,
                required: true
            },
            submit: {
                type: Function,
                required: false
            },
            isModalOpen: {
                type: Boolean,
                required: true
            },
            closeModal: {
                type: Function,
                required: true
            }
        },
        methods: {
            closeModal() {
                this.$emit("closeModal");
            },
            submit() {
                this.$emit("submit", this.id);
            },
        },
        mounted() {
            console.log("Component mounted.")
        }
    };


</script>
<style scoped>
    .modalForm {
        position: fixed;
        z-index: 90;
        inset: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgba(0,0,0,.5); 
        transform: none; 
        border: 1px solid rgba(0,0,0,.2);
        .modal-dialog {
            min-width: 500px;
            background-color: #fff;
            padding: 16px;
            border-radius: 10px
        }
    }

    .v-enter-active,
    .v-leave-active {
        transition: opacity 0.3s ease;
    }

    .v-enter-from,
    .v-leave-to {
        opacity: 0;
    }

</style>


