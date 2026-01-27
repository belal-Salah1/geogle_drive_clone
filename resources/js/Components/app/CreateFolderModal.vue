<script setup>
import Modal from '@/Components/Modal.vue';
import { defineProps, defineEmits, ref, onActivated, nextTick } from 'vue';
import InputLabel from '../InputLabel.vue';
import TextInput from '../TextInput.vue';
import { useForm, router, usePage } from '@inertiajs/vue3';
import inputError from '../InputError.vue';
import SecondaryButton from '../SecondaryButton.vue';
import PrimaryButton from '../PrimaryButton.vue';
const form = useForm({
  name: '',
  parent_id: null,
});
const page = usePage();

defineProps({
  modelValue: {
    type: Boolean,
  },
});

const folderNameInput = ref(null);

const emit = defineEmits(['update:modelValue']);

function createFolder() {
  form.parent_id = page.props.folder ? page.props.folder.id : null;
  console.log(form.parent_id);
  router.post(route('folder.create'), form.data(), {
    preserveScroll: true,
    onSuccess: () => {
      closeModel();
      form.reset();
      //show succcess notification
    },
    onProcessing: () => {
      console.log('processing');
    },
    onError: (errors) => {
      console.log('Validation errors:', errors); // Add this
      return folderNameInput.value.focus();
    },
  });
}

function onShow() {
  nextTick(() => {
    folderNameInput.value.focus();
  });
}

function closeModel() {
  emit('update:modelValue', false);
  form.clearErrors();
  form.reset();
}
</script>
<template>
  <Modal :show="modelValue" max-width="sm" @show="onShow">
    <div class="p-6">
      <h2 class="text-lg font-medium text-gray-900">Create New Folder</h2>
      <div class="mt-6">
        <InputLabel for="folderName" value="Folder Name" class="sr-only" />
        <TextInput
          ref="folderNameInput"
          type="text"
          id="folderName"
          v-model="form.name"
          class="mt-1 block w-full"
          :class="
            form.errors.name
              ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
              : ''
          "
          placeholder="Folder Name"
          @keyup.enter="createFolder"
        />
        <inputError :message="form.errors.name" class="mt-2" />
      </div>
      <div class="mt-6 flex justify-end">
        <SecondaryButton @click="closeModel"> Cancel </SecondaryButton>
        <PrimaryButton
          class="ml-3"
          :class="{ 'opacity-25': form.processing }"
          @click="createFolder"
          :disable="form.processing"
          >Submit</PrimaryButton
        >
      </div>
    </div>
  </Modal>
</template>
