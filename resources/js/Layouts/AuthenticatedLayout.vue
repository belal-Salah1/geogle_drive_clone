
<script setup>
import Navigation from '@/Components/app/Navigation.vue';
import SearchForm from '@/Components/app/SearchForm.vue';
import UserSettingDropDown from '@/Components/app/UserSettingsDropDown.vue';
import { emitter, FILE_UPLOAD_STARTED } from '@/event-bus';
import { onMounted, ref } from 'vue';

const dragOver = ref(false);

function handleDrop(event) {
  const files = event.dataTransfer.files;
  uploadFiles(files);
}
function onDragover(event) {
}
function onDragleave(event) {

}

function uploadFiles(files) {
  console.log('file upload started listener in layout', files);
}

onMounted(() => {
  emitter.on(FILE_UPLOAD_STARTED, uploadFiles);
});
</script>

<template>
  <div class="h-screen bg-gray-50 flex w-full gap-4">
    <Navigation />
    <main
      class="flex flex-col flex-1 px-4 overflow-hidden"
      @drop.prevent="handleDrop"
      @dragover.prevent="onDragover"
      @dragleave.prevent="onDragleave"
    >
      <div class="flex items-center justify-between w-full">
        <SearchForm />
        <UserSettingDropDown />
      </div>

      <div class="flex-1 flex flex-col overflow-hidden">
        <slot />
      </div>
    </main>
  </div>
</template>
