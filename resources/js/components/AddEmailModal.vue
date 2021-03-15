<template>

    <modal :isModalVisible="isModalVisible" @close="$emit('close')" v-bind:on-mounted="addEventListeners">
        <section slot="body" class="">
            <h1>Send email</h1>

            <form v-on:submit="sendEmail" class="">
                <input required type="email" name="from" placeholder="From address" class="w-full rounded-lg bg-gray-200 px-4 py-2 mb-2" />
                <input required type="email" name="to" placeholder="To address" class="w-full rounded-lg bg-gray-200 px-4 py-2 mb-2" />
                <input required type="text" name="subject" placeholder="Subject" class="w-full rounded-lg bg-gray-200 px-4 py-2 mb-2" />
                <textarea required name="html_content" placeholder="Html message" class="w-full rounded-lg bg-gray-200 px-4 py-2 mb-2" cols="5" rows="6">
                </textarea>
                <textarea required name="text_content" placeholder="Text message" class="w-full rounded-lg bg-gray-200 px-4 py-2 mb-2" cols="5" rows="6">
                </textarea>
                <label class="block mb-2">
                    Attachments
                    <input name="attachments[]" type="file" placeholder="attachments" multiple/>
                </label>
                <label class="block" title="email failing will fail if checked">
                    Should fail
                    <input name="should_fail" type="checkbox">
                </label>
                <div class="flex justify-end">
                    <button class="rounded-lg bg-blue-700 flex items-center text-white font-bold py-4 px-8" type="submit">
                        Send
                        <svg-icon class="mr-2" icon="chevron-right"></svg-icon>
                    </button>
                </div>
            </form>
        </section>
    </modal>
</template>

<script>
import Modal from "./base_components/Modal";
import SvgIcon from "./base_components/SvgIcon";
import axios from "axios";

export default {
    components: {
        Modal,
        SvgIcon
    },
    props: {
        isModalVisible: {
            type: Boolean,
            default: false,
            required: true
        }
    },
    data() {
        return {
            privateState: {

            }
        }
    },
    methods: {
        sendEmail(event) {
            event.preventDefault();

            const $form = event.target
            const formData = new FormData($form);

            axios.post(window.route('email.store'), formData).then( res => {
                console.log(res.id);
                this.$router.push({name: 'emailDetails', params: {id: res.data.id}});
            }).catch( err => {

            })
        },
        addEventListeners() {

        },
    },
    computed: {
    },
}
</script>

<style scoped>

</style>
