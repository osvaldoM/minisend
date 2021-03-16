<template>

    <modal :isModalVisible="isModalVisible" @close="$emit('close')">
        <section slot="body" class="">
            <h1>Send email</h1>

            <form v-on:submit="sendEmail" class="">
                <validation-errors :errors="privateState.validationErrors" v-if="privateState.validationErrors">

                </validation-errors>
                <input required type="email" name="from" placeholder="From address" class="w-full rounded-lg bg-gray-200 px-4 py-2 mb-2" />
                <input required type="email" name="to" placeholder="To address" class="w-full rounded-lg bg-gray-200 px-4 py-2 mb-2" />
                <input required type="text" name="subject" placeholder="Subject" class="w-full rounded-lg bg-gray-200 px-4 py-2 mb-2" />
                <textarea required name="html_content"
                          placeholder="Html message" class="w-full rounded-lg bg-gray-200 px-4 py-2 mb-2" cols="5" rows="6">
                </textarea>
                <textarea required name="text_content"
                          placeholder="Text message" class="w-full rounded-lg bg-gray-200 px-4 py-2 mb-2" cols="5" rows="6">
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
                    <save-button :loading="isSavingEmail" class="rounded-lg bg-blue-700 text-white font-bold py-4 px-8">
                        <span slot="main-content" class="flex items-center">
                            Send
                            <svg-icon class="mr-2" icon="chevron-right"></svg-icon>
                        </span>
                    </save-button>
                </div>
            </form>
        </section>
    </modal>
</template>

<script>
import axios from 'axios';
import Modal from './base_components/Modal';
import ValidationErrors from './base_components/ValidationErrors';
import SaveButton from './base_components/SaveButton';
import SvgIcon from "./base_components/SvgIcon";
export default {
  components: {
    SaveButton,
    Modal,
    ValidationErrors,
      SvgIcon
  },
  props: {
    isModalVisible: {
      type: Boolean,
      default: false,
      required: true,
    },
  },
  data() {
    return {
      privateState: {
        validationErrors: null,
        savingEmail: false,
      },
    };
  },
  methods: {
    sendEmail(event) {
      event.preventDefault();

      const $form = event.target;
      const formData = new FormData($form);

      this.isSavingEmail = true;
      axios.post(window.route('email.store'), formData).then((res) => {
        this.$toasted.global.save_success({ entity: 'Email' });
        this.$router.push({ name: 'emailDetails', params: { id: res.data.id } });
      }).catch((error) => {
        if (error.response.status === 422) {
          this.privateState.validationErrors = error.response.data.errors;
        }
        this.$toasted.global.save_error({
          message: (error.response ? error.response.data.message : error.message),
        });
      }).finally(() => {
        this.isSavingEmail = false;
      });
    },
  },
  computed: {
    isSavingEmail: {
      get() {
        return this.privateState.savingEmail;
      },
      set(val) {
        this.privateState.savingEmail = val;
      },
    },
  },
};
</script>

<style scoped>

</style>
