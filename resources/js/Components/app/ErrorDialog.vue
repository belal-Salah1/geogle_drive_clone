<script setup>
// imports
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '../PrimaryButton.vue';
import { onMounted, ref } from 'vue';
import { emitter, SHOW_ERROR_DIALOG } from '@/event-bus';

// users

// refs
const show = ref(false);
const message = ref('');

// props & emits
const emit = defineEmits(['close']);

// computed

// methods

function close() {
  show.value = false;
}

// hooks
onMounted(() => {
  emitter.on(SHOW_ERROR_DIALOG, ({ message: msg }) => {
    show.value = true;
    message.value = msg;
  });
});
</script>

<template>
  <Modal :show="show">
    <div class="p-6">
      <h2 class="text-2xl mb-2 text-red-600 font-semibold">{{ message }}</h2>
      <div class="mt-6 flex justify-end">
        <PrimaryButton @click="close">OK</PrimaryButton>
      </div>
    </div>
  </Modal>
</template>
