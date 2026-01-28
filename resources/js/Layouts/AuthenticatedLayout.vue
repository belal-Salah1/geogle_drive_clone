<script setup>
import Navigation from '@/Components/app/Navigation.vue';
import SearchForm from '@/Components/app/SearchForm.vue';
import UserSettingDropDown from '@/Components/app/UserSettingsDropDown.vue';
import { emitter, FILE_UPLOAD_STARTED } from '@/event-bus';
import { useForm, usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const fileUploadForm = useForm({
  files: [],
  relative_path: [],
  parent_id: null,
});

const page = usePage();
const dragOver = ref(false);

function onDragover() {
  dragOver.value = true;
}
function onDragleave() {
  dragOver.value = false;
}
function handleDrop(event) {
  dragOver.value = false;
  const files = event.dataTransfer.files;
  if (files.length === 0) return;
  uploadFiles(files);
}

function uploadFiles(files) {
  fileUploadForm.parent_id = page.props.folder.id;
  fileUploadForm.files = files;
  fileUploadForm.relative_path = [...files].map(
    (file) => file.webkitRelativePath
  );

  fileUploadForm.post(route('file.store'), {
    preserveScroll: true,
    onSuccess: () => {
      fileUploadForm.reset();
    },
  });
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
      :class="dragOver ? 'dropzone' : ''"
      @drop.prevent="handleDrop"
      @dragover.prevent="onDragover"
      @dragleave.prevent="onDragleave"
    >
      <template v-if="dragOver">
        <div class="text-gray text-center py-8">Drop files here to upload</div>
      </template>
      <template v-else>
        <div class="flex items-center justify-between w-full">
          <SearchForm />
          <UserSettingDropDown />
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
          <slot />
        </div>
      </template>
    </main>
  </div>
</template>

<style scoped>
.dropzone {
  width: 100%;
  height: 100%;
  color: #8d8d8d;
  border: 2px dashed #3b82f6;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #e0f2fe;
}
</style>
